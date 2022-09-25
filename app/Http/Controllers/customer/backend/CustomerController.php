<?php

namespace App\Http\Controllers\customer\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Components\Nestedsetbie;
use App\Models\CustomerCategory;

class CustomerController extends Controller
{
    protected $Nestedsetbie;
    protected $table = 'customers';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'customer_categories'));
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data = Customer::orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->Where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%');
        }
        if (is($request->catalogueid)) {
            $data =  $data->Where('catalogue_id', $request->catalogueid);
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        if (is($request->catalogueid)) {
            $data->appends(['catalogueid' => $request->catalogueid]);
        }
        $dataCategory = CustomerCategory::select('id', 'title')->orderBy('id', 'desc')->get();
        $category = $this->Nestedsetbie->DropdownCatalogue($dataCategory, 'Chọn nhóm thành viên');

        return view('customer.backend.customer.index', compact('module', 'data', 'category'));
    }
    public function create()
    {

        $module = $this->table;
        $dataCategory = CustomerCategory::select('id', 'title')->orderBy('id', 'desc')->get();
        $category = $this->Nestedsetbie->DropdownCatalogue($dataCategory, 'Chọn nhóm thành viên');
        return view('customer.backend.customer.create', compact('module', 'category'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'catalogue_id' => 'required|gt:0',
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|unique:customers',
            'password' => 'required|min:6',
        ], [
            'catalogue_id.required' => 'Nhóm thành viên là trường bắt buộc.',
            'catalogue_id.gt' => 'Nhóm thành viên là trường bắt buộc.',
            'name.required' => 'Họ và tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu tối thiểu là 6 kí tự.',
        ]);
        //upload image
        $image_url = '';
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        }
        //end
        $_data = [
            'catalogue_id' => $request->catalogue_id,
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $image_url,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
            'active' => 1
        ];
        Customer::create($_data);

        return redirect()->route('customers.index')->with('success', "Thêm mới thành viên thành công");
    }
    public function edit($id)
    {
        $detail  = Customer::find($id);
        if (!isset($detail)) {
            return redirect()->route('customers.index')->with('error', "Thành viên không tồn tại");
        }
        $module = $this->table;
        $dataCategory = CustomerCategory::select('id', 'title')->orderBy('id', 'desc')->get();
        $category = $this->Nestedsetbie->DropdownCatalogue($dataCategory, 'Chọn nhóm thành viên');
        return view('customer.backend.customer.edit', compact('module', 'detail', 'category'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Họ và tên là trường bắt buộc.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
            if (file_exists(base_path() . '/' . $request->image_old)) {
                unlink(base_path() . '/' . $request->image_old);
            }
        } else {
            $image_url = $request->image_old;
        }
        //end
        $_data = [
            'catalogue_id' => $request->catalogue_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'image' => $image_url,
            'updated_at' => Carbon::now(),
        ];
        Customer::find($id)->update($_data);
        return redirect()->route('customers.index')->with('success', "Cập nhập thành viên thành công");
    }
}
