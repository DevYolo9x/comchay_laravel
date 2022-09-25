<?php

namespace App\Http\Controllers\tour\backend;

use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use Illuminate\Validation\Rule;

class CategoryTourController extends Controller
{
    protected $Nestedsetbie;
    protected $table = 'tour_categories';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => $this->table));

    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  TourCategory::select('id','slug','title','ishome','highlight','isaside','isfooter','order','publish','lft','rgt','level','created_at','userid_created','parentid')->where('alanguage', config('app.locale'))->orderBy('lft', 'ASC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('tour.backend.category.index', compact('data', 'module'));
    }
    public function create(Request $request)
    {
        $module = $this->table;
        $catalogue = $this->Nestedsetbie->dropdown();
        return view('tour.backend.category.create', compact( 'module','catalogue'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image,banner
        if(!empty($request->file('image'))){
            $image_url = uploadImageNone($request->file('image'),'danh-muc-tour');
        }else{
            $image_url = $request->image_old;
        }
       
        if(!empty($request->file('banner'))){
            $banner_url = uploadImageNone($request->file('banner'),'danh-muc-tour/banner');
        }else{
            $banner_url = $request->image_banner;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'create', 0 ,$arrayImg);
        return redirect()->route('tour_categories.index')->with('success', "Thêm mới danh mục tour thành công");
    }
    public function edit($id)
    {
        $module =  $this->table;
        $detail  = TourCategory::find($id);
        if (!isset($detail)) {
            return redirect()->route('tour_categories.index')->with('error', "Danh mục tour không tồn tại");
        }
        $catalogue = $this->Nestedsetbie->dropdown();
        return view('tour.backend.category.edit', compact('detail', 'catalogue', 'module'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid','!=', $id)->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image,banner
         if(!empty($request->file('image'))){
            $image_url = uploadImageNone($request->file('image'),'danh-muc-tour');
        }else{
            $image_url = $request->image_old;
        }
       
        if(!empty($request->file('banner'))){
            $banner_url = uploadImageNone($request->file('banner'),'danh-muc-tour/banner');
        }else{
            $banner_url = $request->image_banner;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('tour_categories.index')->with('success', "Cập nhập danh mục thành công");
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
            'content' => $request['content'],
            'parentid' => !empty($request['parentid']) ? $request['parentid'] : 0,
            'image' =>  $arrayImg['image_url'],
            'banner' => $arrayImg['banner_url'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'video' => $request['video'],
            'image_json' =>  !empty($request['album']) ? json_encode($request['album']) : '',
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = TourCategory::insertGetId($_data);
        } else {
            TourCategory::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa bảng router
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
            }
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
            ]);
            $this->Nestedsetbie->Get();
            $this->Nestedsetbie->Recursive(0, $this->Nestedsetbie->Set());
            $this->Nestedsetbie->Action();
        }
    }
}