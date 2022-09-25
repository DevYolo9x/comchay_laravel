<?php

namespace App\Http\Controllers\media\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\System;
use App\Models\Media;
use App\Models\CategoryMedia;
use Illuminate\Support\Facades\DB;
class MediaController extends Controller
{
    public function __construct()
    {
        $this->system = new System();

    }

    public function index($slug = "")
    {
        $segments = request()->segments();
        $slug = end($segments);
        $detail = Media::where('slug', $slug)->where('alanguage', config('app.locale'))->with('getCategoryMedia')->where('publish',0)->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $detailCatalog = $detail->getCategoryMedia;
        // breadcrumb
        $breadcrumb = CategoryMedia::select('title','slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detailCatalog->lft)->where('rgt', '>=', $detailCatalog->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        //bài viết liên quan
        $sameMedia =  Media::select('id', 'title', 'slug', 'image', 'description',  'media.created_at')->where('alanguage', config('app.locale'))->where('catalogues_relationships.catalogueid', $detail->getCategoryMedia->id)->where('catalogues_relationships.moduleid', '!=', $detail['id'])->where('media.publish', 0)->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $sameMedia = $sameMedia->join('catalogues_relationships', 'media.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', 'media');
        $sameMedia =  $sameMedia->groupBy('catalogues_relationships.moduleid');
        $sameMedia =  $sameMedia->limit(6)->get();
        //cập nhập lượt xem
        DB::table('media')->where('id', '=', $detail['id'])->update([
            'viewed' => $detail['viewed'] + 1,
        ]);
        //lấy fcSystem và menu
        $fcSystem = $this->system->fcSystem();
        $seo['canonical'] = route('routerURL', ['slug' => $slug]);
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();

        return view('media.frontend.media.index', compact('fcSystem','detail', 'seo','breadcrumb','sameMedia','detailCatalog'));
    }
}
