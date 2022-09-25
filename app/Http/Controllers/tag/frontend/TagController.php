<?php

namespace App\Http\Controllers\tag\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Tags_relationship;
use App\Components\System;

class TagController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request,$slug = ""){
        $detail = Tag::select('id','title','slug','module','image')->where(['alanguage' => config('app.locale'),'slug'=> $slug,'publish' => 0])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $module = $detail->module;
        $data = Tags_relationship::where(['module' => $module,'tagid'=> $detail->id])->select('moduleid');
        if($module == 'articles'){
            $data = $data->paginate(12);
            $view = 'tag.frontend.article';
        }else if('tours'){
            $data = $data->paginate(10);
            $view = 'tag.frontend.tour';
        }else if('products'){
            $data = $data->paginate(10);
            $view = 'tag.frontend.product';
        }

        $seo['canonical'] =  $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view($view, compact('fcSystem','detail', 'seo','data'));
    }
}
