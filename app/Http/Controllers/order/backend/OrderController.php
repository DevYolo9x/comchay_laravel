<?php

namespace App\Http\Controllers\order\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){

        $module = 'orders';
        $data = Order::where('deleted_at','0000-00-00 00:00:00')->orderBy('id','desc');

        if(is($request->keyword)){
            $data =  $data->where('code', 'like', '%' .$request->keyword .'%')
                          ->orWhere('fullname', 'like', '%' .$request->keyword . '%')
                          ->orWhere('phone', 'like', '%' .$request->keyword . '%')
                          ->orWhere('email', 'like', '%' .$request->keyword . '%');
        }
        if(is($request->status)){
            $data =  $data->where('status',$request->status);
        }
        if(is($request->payment)){
            $data =  $data->where('payment',$request->payment);
        }

        if(is($request->date)){
            $date =  explode(' to ',$request->date);
            $date_start = trim($date[0].' 00:00:00');
            $date_end = trim($date[1].' 23:59:59');
            if($date[0] != $date[1]){
                $data =  $data->where('created_at','>=',$date_start)->where('created_at','<=',$date_end);
            }
        }
        $data = $data->paginate(env('APP_paginate'));
        if(is($request->keyword)){
            $data->appends(['keyword' => $request->keyword]);
        }
        if(is($request->status)){
            $data->appends(['status' => $request->status]);
        }
        if(is($request->payment)){
            $data->appends(['payment' => $request->payment]);
        }
        if(is($request->date)){
            $data->appends(['date' => $request->date]);
        }
        return view('order.backend.index',compact('module','data'));
    }
    public function edit($id){

        $module = 'orders';
        $detail = Order::find($id);
        if (!isset($detail)) {
            return redirect()->route('orders.index')->with('error', "Đơn hàng không tồn tại");
        }
        return view('order.backend.edit',compact('module','detail'));
    }
    public function ajaxUploadStatus(Request $request){

        Order::find($request->id)->update(['status' => $request->status]);

    }
}