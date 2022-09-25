<?php

namespace App\Http\Controllers\page\backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    protected $table = 'pages';
    public function index(Request $request)
    {
        $data =  Page::where('alanguage', config('app.locale'))->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $module = $this->table;
        return view('page.backend.index', compact('module', 'data', 'module'));
    }
    public function create()
    {
        $module = $this->table;
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('page.backend.create', compact('module', 'field'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:pages',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        //upload image
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImage($request->file('banner'), $this->table);
        } else {
            $banner_url = $request->banner_old;
        }
        //end
        $this->submitPage($request, 'create', 0, $image_url, $banner_url);
        return redirect()->route('pages.index')->with('success', "Thêm mới page thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = Page::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('pages.index')->with('error', "Trang không tồn tại");
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('page.backend.edit', compact('module', 'detail', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:pages,title,' . $id . ',id',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        //upload image
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImage($request->file('banner'), $this->table);
        } else {
            $banner_url = $request->banner_old;
        }
        //end

        $this->submitPage($request, 'update', $id, $image_url, $banner_url);
        return redirect()->route('pages.index')->with('success', "Cập nhập page thành công");
    }
    public function submitPage($request = [], $action = '', $id = 0, $image_url = '', $banner_url = '')
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
            'page' => $request['page'],
            'slug' => $request['page'],
            'image' => $image_url,
            'description' => $request['description'],
            //page: giới thiệu
            // 'content' => !empty($request['content']) ? $request['content'] : '',
            // 'content_item' => !empty($request['content_item']) ? json_encode($request['content_item']) : '',
            // 'video' => !empty($request['video']) ? $request['video'] : '',
            // 'banner' => !empty($banner_url) ? $banner_url : '',
            //end
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = Page::insertGetId($_data);
        } else {
            Page::find($id)->update($_data);
        }
        if ($action == 'update') {
            //xóa custom fields
            DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
        }
        //START: custom fields
        fieldsInsert($this->table, $id, $request);
        //END
    }
}
