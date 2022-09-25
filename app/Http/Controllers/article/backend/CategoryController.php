<?php

namespace App\Http\Controllers\article\backend;

use App\Http\Controllers\Controller;
use App\Components\Nestedsetbie;
use App\Models\CategoryArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Image;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $nestedsetbie;
    protected $table = 'category_articles';
    public function __construct()
    {
        $this->nestedsetbie = new Nestedsetbie(array('table' => $this->table));
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  CategoryArticle::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('article.backend.category.index', compact('data', 'module', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $htmlCatalogue = $this->nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('article.backend.category.create', compact('module', 'htmlCatalogue', 'field'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . config('app.locale') . ',alanguage',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image,banner,...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'danh-muc-bai-viet');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'danh-muc-bai-viet/banner');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end

        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('category_articles.index')->with('success', "Thêm mới danh mục thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = CategoryArticle::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('category_articles.index')->with('error', "Danh mục không tồn tại");
        }
        $htmlCatalogue = $this->nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('article.backend.category.edit', compact('detail', 'htmlCatalogue', 'module', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid,alanguage,' . config('app.locale') . '',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image,banner...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'danh-muc-bai-viet');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'danh-muc-bai-viet/banner');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('category_articles.index')->with('success', "Cập nhập danh mục thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $arrayImg = [])
    {
        if ($action == 'create') {
            $time = 'created_at';
            $user = 'userid_created';
        } else {
            $time = 'updated_at';
            $user = 'userid_updated';
        }
        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'description' => $request['description'],
            'image_json' =>  !empty($request['album']) ? json_encode($request['album']) : '',
            'parentid' => !empty($request['parentid']) ? $request['parentid'] : 0,
            'image' =>  $arrayImg['image_url'],
            'banner' => $arrayImg['banner_url'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = CategoryArticle::insertGetId($_data);
        } else {
            CategoryArticle::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa bảng router
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
                'alanguage' => config('app.locale'),
            ]);
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END
            $this->nestedsetbie->Get();
            $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
            $this->nestedsetbie->Action();
        }
    }
}
