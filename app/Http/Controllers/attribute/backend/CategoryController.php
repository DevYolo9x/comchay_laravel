<?php

namespace App\Http\Controllers\attribute\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $table = 'category_attributes';
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  CategoryAttribute::where('alanguage', config('app.locale'))->orderBy('id', 'ASC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
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
        return view('attribute.backend.category.index', compact('data', 'module', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('attribute.backend.category.create', compact('module', 'field'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:router',
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        $validator->validate();
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('category_attributes.index')->with('success', "Thêm mới nhóm thuộc tính thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = CategoryAttribute::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('category_attributes.index')->with('error', "Nhóm thuộc tính không tồn tại");
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('attribute.backend.category.edit', compact('detail', 'module', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:category_attributes,slug,' . $id . ',id',
            'slug' => 'required|unique:router,slug,' . $id . ',moduleid',
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'danh-muc-bai-viet');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('category_attributes.index')->with('success', "Cập nhập nhóm thuộc tính thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
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
            'image' => $image_url,
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = CategoryAttribute::insertGetId($_data);
        } else {
            CategoryAttribute::find($id)->update($_data);
        }
        if (!empty($id)) {
            /*xóa router khi cập nhập*/
            if ($action == 'update') {
                //xóa bảng router
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END
            /*thêm router*/
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
