<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function index(){

        $module = 'module';
        $data = DB::table('permissions')->where('parent_id',0)->orderBy('order','asc')->get();
        return view('module.index',compact('module','data'));
    }
}
