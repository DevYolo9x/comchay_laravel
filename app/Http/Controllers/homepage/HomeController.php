<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Components\Comment;
use App\Components\System;
use Cache;

class HomeController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new Comment();
        $this->system = new System();
    }
    public function index()
    {

        /*$slideHome = CategorySlide::select('title', 'id')->where(['alanguage' => config('app.locale'), 'keyword' => 'slide-home'])->with('slides')->first(); */

        $blogs = \App\Models\CategoryArticle::select('id', 'title', 'slug')->where(['alanguage' => config('app.locale'), 'ishome' => 1, 'publish' => 0])->limit(2)->get();

        $slideHome = \App\Models\CategorySlide::select('id', 'title')->where(['alanguage' => config('app.locale'), 'keyword' => 'main-slide'])->limit(1)->with('slides')->get();

        //dd($slideHome);


        /*
        $ishomeCategoryProduct = CategoryProduct::select('id', 'title', 'slug')
            ->where(['alanguage' => config('app.locale'), 'ishome' => 1, 'publish' => 0])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        $ishomeProduct = Product::select('id', 'title', 'slug', 'description', 'price', 'price_sale', 'price_contact', 'image')
            ->where(['alanguage' => config('app.locale'), 'ishome' => 1, 'publish' => 0])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();*/

        $fcSystem = $this->system->fcSystem();
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'index', 'publish' => 0])
        ->select('pages.meta_title', 'pages.meta_description', 'pages.image', 'pages.title', 'pages.content_item')
        ->with('postmeta')
        ->first();

        //dd($page);

        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        return view('homepage.home.index', compact('seo', 'fcSystem', 'blogs', 'slideHome', 'page'));
    }


    public function sitemap()
    {
        $Tags = \App\Models\Tag::select('id', 'slug', 'created_at')->where('alanguage', config('app.locale'))->where('publish', 0)->get();
        $Brands = \App\Models\Brand::select('id', 'slug', 'created_at')->where('alanguage', config('app.locale'))->where('publish', 0)->get();
        $router = DB::table('router')->select('slug', 'created_at')->get();
        return response()->view('homepage.home.sitemap', compact('router', 'Tags', 'Brands'))->header('Content-Type', 'text/xml');
    }
}
