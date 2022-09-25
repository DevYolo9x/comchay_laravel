<?php

namespace App\Http\Controllers\customer\backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerCategoryController extends Controller
{
    protected $table = 'customer_categories';
    public function index(Request $request)
    {
        $module = $this->table;
        $data = CustomerCategory::orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->Where('title', 'like', '%' . $request->keyword . '%');
        }

        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        return view('customer.backend.category.index', compact('module', 'data'));
    }
    public function create()
    {
        $module = $this->table;
        return view('customer.backend.category.create', compact('module'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:customer_categories',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        $_data = [
            'title' => $request->title,
            'created_at' => Carbon::now(),
        ];
        CustomerCategory::create($_data);
        return redirect()->route('customer_categories.index')->with('success', "Thêm mới nhóm thành viên thành công");
    }


    public function edit($id)
    {
        $detail  = CustomerCategory::find($id);
        if (!isset($detail)) {
            return redirect()->route('customer_categories.index')->with('error', "Nhóm thành viên không tồn tại");
        }
        $module = $this->table;
        return view('customer.backend.category.edit', compact('module', 'detail'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', Rule::unique('customer_categories')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })],
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        $_data = [
            'title' => $request->title,
            'updated_at' => Carbon::now(),
        ];
        CustomerCategory::find($id)->update($_data);
        return redirect()->route('customer_categories.index')->with('success', "Cập nhập nhóm thành viên thành công");
    }
}
