<?php

namespace App\Http\Controllers\contact\frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Components\System;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function index()
    {
        //page: Contact

        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'contact'])->select('meta_title', 'meta_description', 'image', 'title')->first();
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();


        return view('contact.frontend.index', compact('fcSystem', 'seo', 'page'));
    }
    public function store(Request $request)
    {
        if (config('app.locale') == 'vi') {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                // 'message' => 'required',
            ], [
                'fullname.required' => 'Trường Họ và tên là trường bắt buộc.',
                'phone.required' => 'Trường Số điện thoại là trường bắt buộc.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                // 'message' => 'required',
            ]);
        }
        if ($validator->passes()) {
            $id = Contact::insertGetId([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'type' => 'contact',
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['status' => '200']);
            } else {
                return response()->json(['status' => '500']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function subcribers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->passes()) {
            $id = Contact::insertGetId([
                'email' => $request->email,
                'type' => 'email',
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 500]);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function books(Request $request)
    {
        $fcSystem = $this->system->fcSystem();
        $validator = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);
        if ($validator->passes()) {
            $id = Contact::insertGetId([
                'fullname' => $request->lastname . ' ' . $request->firstname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'message' => $request->date . ' ' . $request->hours,
                'type' => 'book',
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 500]);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
