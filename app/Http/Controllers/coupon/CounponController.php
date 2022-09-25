<?php

namespace App\Http\Controllers\coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CategoryProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounponController extends Controller
{
    protected $table = 'coupons';
    public function index(Request $request)
    {
        $module = $this->table;
        $data = Coupon::where('deleted_at','0000-00-00 00:00:00')->orderBy('id','DESC');
        if(is($request->keyword)){
            $data =  $data->where('name', 'like', '%' .$request->keyword .'%')->orWhere('title', 'like', '%' .$request->keyword . '%');
        }
        $data = $data->paginate(env('APP_paginate'));
        if(is($request->keyword)){
            $data->appends(['keyword' => $request->keyword]);
        }
        return view('coupon.index',compact('module','data'));
    }
    public function create()
    {
        $module = $this->table;
        return view('coupon.create',compact('module'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:coupons',
            'name' => 'required|unique:coupons',
            'value' => 'required'
        ],[
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'name.required' => 'Mã ưu đãi là trường bắt buộc',
            'name.unique' => 'Mã ưu đãi đã tồn tại.',
            'value.required'=> 'Mức ưu đãi là trường bắt buộc',
        ]);
        if(!empty($request->file('image'))){
            $image_url = uploadImageNone($request->file('image'),$this->table);
        }else{
            $image_url = $request->image_old;
        }
        $this->submit($request,'create',0, $image_url);
        return redirect()->route('coupons.index')->with('success',"Thêm mới mã giảm giá thành công");
    }
    public function edit($id)
    {
        $detail  = Coupon::find($id);
        if (!isset($detail)) {
            return redirect()->route('coupons.index')->with('error', "Mã giảm giá không tồn tại");
        }
        $module = $this->table;
        $items_product = json_decode($detail['product_ids'],true);
        $items_product_categories = json_decode($detail['product_categories'],true);
        if(!empty($items_product)){
            $product_ids = Product::select('id', 'title','code')->whereIn('id', $items_product)->get();
        }else{
            $product_ids = [];
        }
        if(!empty($items_product_categories)){
            $product_categories = CategoryProduct::select('id', 'title')->whereIn('id', $items_product_categories)->get();
        }else{
            $product_categories = [];
        }
        return view('coupon.edit', compact('module','detail','product_ids','product_categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:coupons,slug,' . $id . ',id',
            'name' => 'required|unique:coupons,name,' . $id . ',id',
            'value' => 'required',

        ],[
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'name.required' => 'Mã ưu đãi là trường bắt buộc',
            'name.unique' => 'Mã ưu đãi đã tồn tại.',
            'value.required'=> 'Mức ưu đãi là trường bắt buộc',

        ]);
        //upload image
        if(!empty($request->file('image'))){
            $image_url = uploadImage($request->file('image'),$this->table);
        }else{
            $image_url = $request->image_old;
        }
        //end_price
        $this->submit($request,'update',$id,$image_url);
        return redirect()->route('coupons.index')->with('success',"Cập nhập mã giảm giá thành công");

    }

    public function submit($request = [],$action = '',$id = 0,$image_url = ''){
        if($action == 'create'){
            $time = 'created_at';
            $user = 'userid_created';
        }else{
            $time = 'updated_at';
            $user = 'userid_updated';
        }

        $product_ids = $exclude_product_ids = $product_categories = $exclude_product_categories = null;
        if($request['typecoupon'] == 'fixed_percent' || $request['typecoupon'] == 'fixed_money'){
            $product_ids .= json_encode($request['product_ids']);
            // $exclude_product_ids .= json_encode($request['exclude_product_ids']);
            $product_categories .= json_encode($request['product_categories']);
            // $exclude_product_categories .= json_encode($request['exclude_product_categories']);
        }
        $_data= [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'description' => !empty($request['description'])?$request['description']:'',
            'image' => $image_url,
            'meta_title' => !empty($request['meta_title'])?$request['meta_title']:"",
            'meta_description' => !empty($request['meta_description'])?$request['meta_description']:'',
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'name' => $request['name'],
            'type' => $request['typecoupon'],
            'value' => $request['value'],

            'expiry_date' => $request['expiry_date'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],

            'individual_use' => $request['individual_use'],

            'min_price' => str_replace('.', '',$request['min_price']),
            'max_price' => str_replace('.', '',$request['max_price']),
            'min_count' => $request['min_count'],
            'max_count' => $request['max_count'],
            'product_ids' => $product_ids,
            'exclude_product_ids' => $exclude_product_ids,
            'product_categories' => $product_categories,
            'exclude_product_categories' => $exclude_product_categories,

            'limit' => $request['limit'],
            'limit_user' => $request['limit_user'],

            'deleted_at' => '0000-00-00 00:00:00'
        ];
        if($action == 'create'){
            $id = Coupon::insertGetId($_data);
        }else{
            Coupon::where('id','=',$id)->update($_data);

        }

    }
}
