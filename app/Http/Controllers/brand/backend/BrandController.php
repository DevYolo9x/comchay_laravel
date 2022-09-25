<?php

namespace App\Http\Controllers\brand\backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class BrandController extends Controller
{
    protected $table = 'brands';
    public function index(Request $request)
    {
        $data =  Brand::where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
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
        $module = $this->table;
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('brand.backend.brand.index', compact('module', 'data', 'module', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('brand.backend.brand.create', compact('module', 'field'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:brands',
            'slug' => 'required|unique:brands',
        ], [
            'title.required' => 'Tên thương hiệu là trường bắt buộc.',
            'title.unique' => 'Tên thương hiệu đã tồn tại.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',

        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }

        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('brands.index')->with('success', "Thêm mới thương hiệu thành công");
    }
    public function edit($id)
    {
        $detail  = Brand::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('brands.index')->with('error', "Thương hiệu không tồn tại");
        }
        $module = $this->table;
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('brand.backend.brand.edit', compact('module', 'detail', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:brands,slug,' . $id . ',id',
            'slug' => 'required|unique:brands,slug,' . $id . ',id',
        ], [
            'title.required' => 'Tên thương hiệu là trường bắt buộc.',
            'title.unique' => 'Tên thương hiệu đã tồn tại.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',

        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('brands.index')->with('success', "Cập nhập thương hiệu thành công");
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
            'image' => $image_url,
            'description' => $request['description'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = Brand::insertGetId($_data);
        } else {
            Brand::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END
        }
    }
}
