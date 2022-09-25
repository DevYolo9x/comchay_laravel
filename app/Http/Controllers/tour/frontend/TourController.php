<?php

namespace App\Http\Controllers\tour\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Components\Comment;
use App\Components\System;

class TourController extends Controller

{
    protected $comment;
    public function __construct()
    {
        $this->comment = new Comment();
        $this->system = new System();
    }
    public function index(Request $request,$slug = ""){
        $detail = Tour::where(['alanguage' => config('app.locale'),'slug'=> $slug,'publish' => 0])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $id = $detail->id;
        //điểm đến
        $detailCatalogue = TourCategory::select('id','title','slug','lft')->where(['alanguage' => config('app.locale'),'id'=> $detail->catalogue_id,'publish' => 0])->first();
        // breadcrumb
        $breadcrumb = [];
        if(!empty($detailCatalogue)){
            $breadcrumb = TourCategory::select('title','slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detailCatalogue->lft)->where('rgt', '>=', $detailCatalogue->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        }
        //tour liên quan
        $tourSame =  Tour::select('id','slug','title','infoTour','price','price_sale','price_contact','image','rate','catalogue_id','infoTour')->where(['alanguage' => config('app.locale'),'catalogue_id'=> $detail->catalogue_id,'publish' => 0])->where('id','!=',$detail->id)->orderBy('order', 'asc')->orderBy('id', 'desc')->paginate(10);

        //comment
        $comment_view =  $this->comment->comment(array('id' => $id, 'sort' => 'id'),'tours');

        //get services
        $services =  $detail->services;
        if(count($services) > 0){
            foreach($services as $service){
                $service['serviceItems'] = \App\Models\TourServiceRelationship::where(['tour_service_id' => $service->tour_service_id,'tour_id' => $id])
                ->join('tour_service_items', 'tour_service_items.id', '=', 'tour_service_relationships.tour_service_item_id')
                ->select('tour_service_items.title')
                ->get();
            }
        }
        //get TourType
        $getTourType = \App\Models\TourTypeRelationship::select('tour_type_id')->where('tour_id',$detail->id)->with('getTourType')->get();
        //faqs
        $seo['canonical'] =  $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('tour.frontend.tour.index', compact('fcSystem','detail', 'seo', 'comment_view','tourSame','comment_view','detailCatalogue','getTourType','breadcrumb'));
    }
}