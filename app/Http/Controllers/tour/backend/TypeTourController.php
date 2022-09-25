<?php

namespace App\Http\Controllers\tour\backend;

use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;

class TypeTourController extends Controller
{
    protected $table = 'tour_types';
    public function index(Request $request)
    {
        $module = $this->table;
        $data =  TourType::select('id','alanguage','title','slug','publish','order','created_at','userid_created')->where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('tour.backend.type.index', compact('data', 'module'));
    }
    public function create(Request $request)
    {
        $module = $this->table;
        return view('tour.backend.type.create', compact( 'module'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',

        ]);
        $this->submit($request, 'create', 0);
        return redirect()->route('tour_types.index')->with('success', "Thêm mới thành công");
    }
    public function edit($id)
    {
        $module =  $this->table;
        $detail  = TourType::find($id);
        if (!isset($detail)) {
            return redirect()->route('tour_types.index')->with('error', "Travel type không tồn tại");
        }
        return view('tour.backend.type.edit', compact('detail', 'module'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',

        ]);

        $this->submit($request, 'update', $id);
        return redirect()->route('tour_types.index')->with('success', "Cập nhập thành công");
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
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = TourType::insertGetId($_data);
        } else {
            TourType::find($id)->update($_data);
        }
    }
}