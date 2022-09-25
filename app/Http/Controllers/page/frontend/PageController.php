<?php

namespace App\Http\Controllers\page\frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Components\System;

class PageController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function aboutUs()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'aboutus', 'publish' => 0])->select('meta_title', 'meta_description', 'image', 'title', 'description')->first();

        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();

        return view('page.frontend.aboutus', compact('seo', 'page', 'fcSystem'));
    }
}
