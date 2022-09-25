<?php

namespace App\Http\Controllers\tag\backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class TagController extends Controller
{
    protected $table = 'tags';
    public function index(Request $request)
    {
        $data =  Tag::where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $module = $this->table;
        $dropdown = getFunctions();
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('tag.backend.tag.index', compact('data', 'module', 'dropdown', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('tag.backend.tag.create', compact('module', 'field'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tags',
            'slug' => 'required|unique:tags',
            'module' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề tag đã tồn tại.',
            'slug.required' => 'Đường dẫn tag là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn tag đã tồn tại.',
            'module.required' => 'Chọn module là trường bắt buộc.',

        ]);
        $validator->validate();
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('tags.index')->with('success', "Thêm mới tag thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = Tag::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('tags.index')->with('error', "Tag không tồn tại");
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();

        return view('tag.backend.tag.edit', compact('module', 'detail', 'field'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tags,slug,' . $id . ',id',
            'slug' => 'required|unique:tags,slug,' . $id . ',id',
            'module' => 'required',

        ], [
            'title.required' => 'Tên tag là trường bắt buộc.',
            'title.unique' => 'Tên tag đã tồn tại.',
            'slug.required' => 'Đường dẫn tag là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn tag đã tồn tại.',
            'module.required' => 'Chọn module là trường bắt buộc.',


        ]);
        $validator->validate();
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('tags.index')->with('success', "Cập nhập tag thành công");
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
            'module' => $request['module'],
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
            $id = Tag::insertGetId($_data);
        } else {
            Tag::find($id)->update($_data);
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
