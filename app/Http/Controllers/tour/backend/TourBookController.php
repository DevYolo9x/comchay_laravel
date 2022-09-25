<?php

namespace App\Http\Controllers\tour\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TourBook;
class TourBookController extends Controller
{

    public function index(Request $request)
    {
        $module = 'tour_books';
        $data = TourBook::orderBy('id','desc')->where('type','tours');
        if(is($request->keyword)){
            $data =  $data->where('code', 'like', '%' .$request->keyword .'%')
                          ->orWhere('fullname', 'like', '%' .$request->keyword . '%')
                          ->orWhere('email', 'like', '%' .$request->keyword . '%');
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
        if(is($request->date)){
            $data->appends(['date' => $request->date]);
        }
        return view('tour.backend.book.index',compact('module','data'));
    }
    public function inquiry(Request $request)
    {
        $module = 'tour_books';
        $data = TourBook::orderBy('id','desc')->where('type','inquiry');
        if(is($request->keyword)){
            $data =  $data->where('code', 'like', '%' .$request->keyword .'%')
                          ->orWhere('fullname', 'like', '%' .$request->keyword . '%')
                          ->orWhere('email', 'like', '%' .$request->keyword . '%');
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
        if(is($request->date)){
            $data->appends(['date' => $request->date]);
        }
        return view('tour.backend.book.inquiry',compact('module','data'));
    }

    public function edit($id)
    {
        $module = 'tour_books';
        $detail = TourBook::find($id);
        if (!isset($detail)) {
            return redirect()->route('tour_books.index')->with('error', "ERROR! Không tồn tại");
        }
        return view('tour.backend.book.edit',compact('module','detail'));


    }
}
