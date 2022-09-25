<?php

namespace App\Http\Controllers\attribute\backend;

use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function App\Components\myQuery;

class AttributeController extends Controller
{
    protected $Nestedsetbie;
    protected $table = 'attributes';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'category_attributes'));
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  Attribute::where('alanguage', config('app.locale'))->orderBy('catalogueid', 'ASC')->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $catalogueid = $request->catalogueid;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($catalogueid)) {
            $data =  $data->where('catalogueid', $catalogueid);
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($catalogueid)) {
            $data->appends(['catalogueid' => $catalogueid]);
        }
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        $htmlOption = $this->Nestedsetbie->dropdown();
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('attribute.backend.attribute.index', compact('data', 'module', 'htmlOption', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $htmlOption = $this->Nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('attribute.backend.attribute.create', compact('module', 'htmlOption', 'field'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:attributes,alanguage,' . config('app.locale') . '',
            'catalogueid' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'catalogueid.gt' => 'Nhóm thuộc tính là trường bắt buộc.',

        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }

        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('attributes.index')->with('success', "Thêm mới thuộc tính thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $detail  = Attribute::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('attributes.index')->with('error', "Thuộc tính không tồn tại");
        }
        $htmlOption = $this->Nestedsetbie->dropdown();
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('attribute.backend.attribute.edit', compact('detail', 'htmlOption', 'module', 'field'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:attributes,slug,' . $id . ',id,alanguage,' . config('app.locale') . '',
            'catalogueid' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
            'catalogueid.gt' => 'Danh mục là trường bắt buộc.',

        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('attributes.index')->with('success', "Cập nhập thuộc tính thành công");
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
            'catalogueid' => $request['catalogueid'],
            'image' => $image_url,
            'description' => $request['description'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'color' => $request['color'],
            'price_start' => str_replace('.', '', $request['price_start']),
            'price_end' => str_replace('.', '', $request['price_end']),
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = Attribute::insertGetId($_data);
        } else {
            Attribute::find($id)->update($_data);
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
