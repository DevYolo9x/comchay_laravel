<?php

namespace App\Http\Controllers\media\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\Nestedsetbie;
use App\Models\CategoryMedia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $Nestedsetbie;
    protected $table = 'category_media';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => $this->table));
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  CategoryMedia::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC');
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
        return view('media.backend.category.index', compact('data', 'module', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('media.backend.category.create', compact('module', 'htmlCatalogue', 'field'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'layoutid' => 'required',
            // 'slug' => 'required|unique:router',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'layoutid.required' => 'Loại thư viện là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);

        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'danh-muc-media');
        } else {
            $image_url = $request->image_old;
        }
        $this->submitCategoryMedia($request, 'create', 0, $image_url);
        return redirect()->route('category_media.index')->with('success', "Thêm mới danh mục thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = CategoryMedia::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('category_media.index')->with('error', "Danh mục không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('media.backend.category.edit', compact('detail', 'htmlCatalogue', 'module', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'layoutid' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'layoutid.required' => 'Loại thư viện là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'danh-muc-media');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submitCategoryMedia($request, 'update', $id, $image_url);
        return redirect()->route('category_media.index')->with('success', "Cập nhập danh mục thành công");
    }
    public function submitCategoryMedia($request = [], $action = '', $id = 0, $image_url = '')
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
            'parentid' => !empty($request['parentid']) ? $request['parentid'] : 0,
            'image' => $image_url,
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'layoutid' => $request['layoutid'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = CategoryMedia::insertGetId($_data);
        } else {
            CategoryMedia::find($id)->update($_data);
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
            $this->Nestedsetbie->Get();
            $this->Nestedsetbie->Recursive(0, $this->Nestedsetbie->Set());
            $this->Nestedsetbie->Action();
        }
    }
}
