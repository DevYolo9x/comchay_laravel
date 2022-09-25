<?php

namespace App\Http\Controllers\tour\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Page;
use App\Models\TourCategory;
use App\Models\TourType;
use App\Components\System;
use Illuminate\Support\Facades\DB;

class TourCategoryController extends Controller
{
    protected $paginate = 12;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request,$slug = ""){
        $detail = TourCategory::where(['alanguage' => config('app.locale'),'slug'=> $slug,'publish' => 0])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        // breadcrumb
        // $breadcrumb = TourCategory::select('title','slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();

        // //data tour
        // $data =  Tour::join('tour_category_relationships', 'tours.id', '=', 'tour_category_relationships.tour_id');
        // if (!empty($detail->id)) {
        //     $data =  $data->where('tour_category_relationships.tour_category_id', $detail->id);
        // }
        // $data =  $data->orderBy('tours.id', 'desc')->paginate(24);
        // //end

        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('tour.frontend.category.index', compact('fcSystem','detail', 'seo'));
    }
    public function detail(Request $request,$slug = ""){
        $detail = TourCategory::where(['alanguage' => config('app.locale'),'slug'=> $slug,'publish' => 0])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        // breadcrumb
        $breadcrumb = TourCategory::select('title','slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        //data tour
        $data =  Tour::join('tour_category_relationships', 'tours.id', '=', 'tour_category_relationships.tour_id');
        if (!empty($detail->id)) {
            $data =  $data->where('tour_category_relationships.tour_category_id', $detail->id);
        }
        $data =  $data->orderBy('tours.id', 'desc')->paginate($this->paginate);
        //end
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('tour.frontend.category.detail', compact('fcSystem','detail', 'seo','data', 'breadcrumb'));
    }
    //danh sach tour
    public function tours(Request $request){
        $page = Page::where(['alanguage'=> config('app.locale'),'page'=> 'tour', 'publish' => 0])->select('meta_title','meta_description','image','title')->first();
        $TourCategory = TourCategory::select('id','title')->where(['alanguage'=> config('app.locale'),'publish' => 0])->with('tours')->orderBy('order','asc')->orderBy('id','desc')->get();
        //START: thực hiện search
        $destinaion = $request->destinaion;
        $checkin = $request->checkin;
        $checkout = $request->checkout;
        $request_attr = $request->attribute;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $type = $request->type;

        $data =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0]);
        //xử lý danh mục
        $data = $data->join('tour_category_relationships', 'tours.id', '=', 'tour_category_relationships.tour_id');
        if (!empty($destinaion)) {
            $data =  $data->where('tour_category_relationships.tour_category_id',$destinaion);
        }
        //checkout và checkin
        if($checkin < $checkout){
            if(!empty($checkin) && !empty($checkout)){
                $checkinConvert = explode('/',$checkin);
                if(!empty($checkinConvert)){
                    $data = $data->where('tours.checkin','>=', trim($checkinConvert[2]).'-'.(int)str_pad(trim($checkinConvert[0]), 2, "0", STR_PAD_LEFT).'-'.trim($checkinConvert[1]));
                }
                $checkoutConvert = explode('/',$checkout);
                if(!empty($checkoutConvert)){
                    $data = $data->where('tours.checkin','<=', trim($checkoutConvert[2]).'-'.(int)str_pad(trim($checkoutConvert[0]), 2, "0", STR_PAD_LEFT).'-'.trim($checkoutConvert[1]));
                }
            }

        }else if($checkin == $checkout){
            if(!empty($checkin)){
                $checkinConvert = explode('/',$checkin);
                if(!empty($checkinConvert)){
                    $data = $data->where('tours.checkin','>=', trim($checkinConvert[2]).'-'.trim($checkinConvert[0]).'-'.trim($checkinConvert[1]));
                }
            }
        }else if($checkin > $checkout){
            if(!empty($checkin)){
                $checkinConvert = explode('/',$checkin);
                if(!empty($checkinConvert)){
                    $data = $data->where('tours.checkin','>=', trim($checkinConvert[2]).'-'.trim($checkinConvert[0]).'-'.trim($checkinConvert[1]));
                }
            }
        }
        //kiểu tour
        if(!empty($type)){
            $data = $data->join('tour_type_relationships', 'tours.id', '=', 'tour_type_relationships.tour_id');
            $data =  $data->where('tour_type_relationships.tour_type_id', $type);
        }
        //khoảng giá
        /*
        if (isset($minPrice) && !empty($maxPrice)) {
            $data =  $data->where('tours.price', '>=', $minPrice);
            $data =  $data->where('tours.price', '<=', $maxPrice);
        } */
        if (!empty($maxPrice)) {
            $data =  $data->where('tours.price', '<=', $maxPrice);
        }
        //xử lý thuộc tính
        if (!empty($request_attr)) {
            $attr = explode(';', $request_attr);
            foreach ($attr as $key => $val) {
                if ($key % 2 == 0) {
                    if ($val != '') {
                        $attribute[$val][] = $attr[$key + 1];
                    }
                } else {
                    continue;
                }
            }
            $total = 0;
            $index = 100;
            foreach ($attribute as $key => $val) {
                $total++;
                $index++;
                foreach ($val as $subs) {
                    $index = $index + $total;
                    $data = $data->join('tour_attribute_relationships as tb' . $index . '', 'tours.id', '=', 'tb' . $index . '.tour_id');
                }
                $data =  $data->whereIn('tb' . $index . '.attribute_id', $val);
            }
            $data =  $data->groupBy('tb102.tour_id');
        }
        //end
        //sort
        $sort = '';
        if (!empty($request->sort)) {
            $sort = $request->sort;
        }
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (!empty($sort) && count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                return redirect()->route('tours');
            }
        } else {
            $data =  $data->orderBy('tours.order', 'ASC')->orderBy('tours.id', 'DESC');
        }
        //lấy tour type
        $wherInTourType = $data->pluck('tours.id');
        $TourType = \App\Models\TourType::leftJoin('tour_type_relationships', 'tour_types.id', '=', 'tour_type_relationships.tour_type_id')
        ->whereIn('tour_type_relationships.tour_id',$wherInTourType)->select('tour_types.id','tour_types.title',DB::raw("count('tour_id') as count"))
        ->groupby('tour_type_id')->get();
        //end
        //count start 1-5
        $rate5 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<=",5)->where('rate',">=",4.5)->count();
        $rate4 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",4.5)->where('rate',">=",3.5)->count(); //lớn hơn 3.5 và nhỏ hơn 4.5
        $rate3 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",3.5)->where('rate',">=",2.5)->count(); // lớn hơn 2.5 và nhỏ hơn 3.5
        $rate2 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",2.5)->where('rate',">=",1.5)->count(); //lớn hơn 1.5 và nhỏ hơn  2.5
        $rate1 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",1.5)->where('rate',">",0)->count();
        //end
        //phân trang
        $data =  $data->groupBy('tour_category_relationships.tour_id');
        $data = $data->paginate($this->paginate);
        //end get data tour
        //phân trang GET
        if (is($destinaion)) {
            $data->appends(['destinaion' => $destinaion]);
        }
        if (is($checkin)) {
            $data->appends(['checkin' => $checkin]);
        }
        if (is($checkout)) {
            $data->appends(['checkout' => $checkout]);
        }
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        if (is($request_attr)) {
            $data->appends(['attribute' => $request_attr]);
        }
        if (is($minPrice)) {
            $data->appends(['minPrice' => $minPrice]);
        }
        if (is($maxPrice)) {
            $data->appends(['maxPrice' => $maxPrice]);
        }
        if (is($sort)) {
            $data->appends(['sort' => $sort]);
        }
        //END: thực hiện search

        //lấy danh sách lọc
        $category_attributes = \App\Models\CategoryAttribute::select('id','title','slug')->where(['alanguage'=> config('app.locale'),'publish' => 0])->with('listAttr')->orderBy('order','asc')->orderBy('id','desc')->get();
        //end


        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('tour.frontend.tours', compact('fcSystem','seo','page','TourCategory','TourType','data','category_attributes','rate1','rate2','rate3','rate4','rate5'));
    }
    //filter ajax tour
    public function filter(Request $request)  {
        //START: thực hiện search
        $destinaion = $request->destinaion;
        $checkin = $request->checkin;
        $checkout = $request->checkout;
        $request_attr = $request->attr;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $type = $request->type;
        $data =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0]);
        //xử lý danh mục
        $data = $data->join('tour_category_relationships', 'tours.id', '=', 'tour_category_relationships.tour_id');
        if (!empty($destinaion)) {
            $data =  $data->where('tour_category_relationships.tour_category_id',$destinaion);
        }
        //checkout và checkin
        if($checkin < $checkout){
            if(!empty($checkin) && !empty($checkout)){
                $checkinConvert = explode('/',$checkin);
                if(!empty($checkinConvert)){
                    $data = $data->where('tours.checkin','>=', trim($checkinConvert[2]).'-'.(int)str_pad(trim($checkinConvert[0]), 2, "0", STR_PAD_LEFT).'-'.trim($checkinConvert[1]));
                }
                $checkoutConvert = explode('/',$checkout);
                if(!empty($checkoutConvert)){
                    $data = $data->where('tours.checkin','<=', trim($checkoutConvert[2]).'-'.(int)str_pad(trim($checkoutConvert[0]), 2, "0", STR_PAD_LEFT).'-'.trim($checkoutConvert[1]));
                }
            }

        }else if($checkin == $checkout){
            if(!empty($checkin)){
                $checkinConvert = explode('/',$checkin);
                if(!empty($checkinConvert)){
                    $data = $data->where('tours.checkin','>=', trim($checkinConvert[2]).'-'.trim($checkinConvert[0]).'-'.trim($checkinConvert[1]));
                }
            }
        }else if($checkin > $checkout){
            if(!empty($checkin)){
                $checkinConvert = explode('/',$checkin);
                if(!empty($checkinConvert)){
                    $data = $data->where('tours.checkin','>=', trim($checkinConvert[2]).'-'.trim($checkinConvert[0]).'-'.trim($checkinConvert[1]));
                }
            }
        }
        //kiểu tour
        $type_explode = [];
        if(!empty($type)){
            $type_explode = explode(';',$type);
            if(!empty($type_explode)){
                $data = $data->join('tour_type_relationships', 'tours.id', '=', 'tour_type_relationships.tour_id');
                $data =  $data->whereIn('tour_type_relationships.tour_type_id', $type_explode);
            }
        }
        //khoảng giá
        if (!empty($maxPrice)) {
            $data =  $data->where('tours.price', '<=', $maxPrice);
        }
        //xử lý thuộc tính
        if (!empty($request_attr)) {
            $attr = explode(';', $request_attr);
            foreach ($attr as $key => $val) {
                if ($key % 2 == 0) {
                    if ($val != '') {
                        $attribute[$val][] = $attr[$key + 1];
                    }
                } else {
                    continue;
                }
            }
            $total = 0;
            $index = 100;
            foreach ($attribute as $key => $val) {
                $total++;
                $index++;
                foreach ($val as $subs) {
                    $index = $index + $total;
                    $data = $data->join('tour_attribute_relationships as tb' . $index . '', 'tours.id', '=', 'tb' . $index . '.tour_id');
                }
                $data =  $data->whereIn('tb' . $index . '.attribute_id', $val);
            }
            $data =  $data->groupBy('tb102.tour_id');
        }
        //end
        //rate
        $rate_explode = [];
        if(!empty($request->rate)){
            $rate_explode = explode(';',$request->rate);
            if(!empty($rate_explode)){
                //get data
                $data =  $data->whereIn('tours.rate', $rate_explode);
                //end
            }
        }
        //end
        //sort
        $sort = '';
        if (!empty($request->sort)) {
            $sort = $request->sort;
        }
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (!empty($sort) && count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                $data =  $data->orderBy('tours.order', 'ASC')->orderBy('tours.id', 'DESC');
            }
        } else {
            $data =  $data->orderBy('tours.order', 'ASC')->orderBy('tours.id', 'DESC');
        }
        //lấy tour type
        $wherInTourType = $data->pluck('tours.id');
        $TourType = \App\Models\TourType::leftJoin('tour_type_relationships', 'tour_types.id', '=', 'tour_type_relationships.tour_type_id')
        ->whereIn('tour_type_relationships.tour_id',$wherInTourType)->select('tour_types.id','tour_types.title',DB::raw("count('tour_id') as count"))
        ->groupby('tour_type_id')->get();
        //end
        //count start 1-5
        // $rate5 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<=",5)->where('rate',">=",4.5)->count();
        // $rate4 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",4.5)->where('rate',">=",3.5)->count(); //lớn hơn 3.5 và nhỏ hơn 4.5
        // $rate3 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",3.5)->where('rate',">=",2.5)->count(); // lớn hơn 2.5 và nhỏ hơn 3.5
        // $rate2 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",2.5)->where('rate',">=",1.5)->count(); //lớn hơn 1.5 và nhỏ hơn  2.5
        // $rate1 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",1.5)->where('rate',">",0)->count();

        //end
        //phân trang
        $data =  $data->groupBy('tour_category_relationships.tour_id');
        $data = $data->paginate($this->paginate);
        //end get data tour
        //render HTML
        $html = '';
        // $htmlTourType = '';
        // $htmlRate = '';
        // if(count($TourType) > 0){
        //     foreach($TourType as $item){
        //         if (in_array($item->id, $type_explode)) {
        //             $class = 'active';
        //         }else{
        //             $class = '';
        //         }
        //         $htmlTourType .= '<li class="'.$class.'">
        //             <a href="javascript:void(0)" data-id="'.$item->id.'"
        //             class="filterTourType"><span>'.$item->title.'</span><label>'.$item->count.'</label></a>
        //         </li>';
        //     }
        // }

        // if (in_array(5, $rate_explode)) {
        //     $class_5 = 'active';
        // }else{
        //     $class_5 = '';
        // }
        // if (in_array(4, $rate_explode)) {
        //     $class_4 = 'active';
        // }else{
        //     $class_4 = '';
        // }
        // if (in_array(3, $rate_explode)) {
        //     $class_3 = 'active';
        // }else{
        //     $class_3 = '';
        // }
        // if (in_array(2, $rate_explode)) {
        //     $class_2 = 'active';
        // }else{
        //     $class_2 = '';
        // }
        // if (in_array(1, $rate_explode)) {
        //     $class_1 = 'active';
        // }else{
        //     $class_1 = '';
        // }
        // $htmlRate .= '<li class="'.$class_5.'">
        //                 <a href="javascript:void(0)" data-rate="5" class="filterRate">
        //                     <div class="star"><span style="width: 75px"></span></div><label>'.$rate5.'</label>
        //                 </a>
        //             </li>
        //             <li class="'.$class_4.'">
        //                 <a href="javascript:void(0)" data-rate="4" class="filterRate">
        //                     <div class="star"><span style="width: 60px"></span></div><label>'.$rate4.'</label>
        //                 </a>
        //             </li>
        //             <li class="'.$class_3.'">
        //                 <a href="javascript:void(0)" data-rate="3" class="filterRate">
        //                     <div class="star"><span style="width: 45px"></span></div><label>'.$rate3.'</label>
        //                 </a>
        //             </li>
        //             <li class="'.$class_2.'">
        //                 <a href="javascript:void(0)" data-rate="2" class="filterRate">
        //                     <div class="star"><span style="width: 30px"></span></div><label>'.$rate2.'</label>
        //                 </a>
        //             </li>
        //             <li class="'.$class_1.'">
        //                 <a href="javascript:void(0)" data-rate="1" class="filterRate">
        //                     <div class="star"><span style="width: 15px"></span></div><label>'.$rate1.'</label>
        //                 </a>
        //             </li>';



        foreach ($data as $k => $item) {
            $html .= htmlItemTourCategory($k,$item);
        }
        $html .= '<div class="pagination_custom flex justify-center">';
        $html .= $data->links();
        $html .= '</div>';
        echo json_encode(['html' => $html,'total' => $data->total()]);die;
    }
    //destination
    public function destination(){
        $page = Page::where(['alanguage'=> config('app.locale'),'page'=> 'destination', 'publish' => 0])->select('meta_title','meta_description','image','title')->first();
        $TourCategory = TourCategory::select('id','title','slug','image')->where(['alanguage'=> config('app.locale'),'publish' => 0])->with('tourCount')->orderBy('order','asc')->orderBy('id','desc')->paginate(8);
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('tour.frontend.destination', compact('fcSystem','seo','page','TourCategory'));
    }
    //inquiry
    public function inquiry(){
        $page = Page::where(['alanguage'=> config('app.locale'),'page'=> 'requiry', 'publish' => 0])->select('meta_title','meta_description','image','title')->first();
        $TourCategory = TourCategory::select('id','title','slug','image')->where(['alanguage'=> config('app.locale'),'publish' => 0])->with('tourCount')->orderBy('order','asc')->orderBy('id','desc')->paginate(12);
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('tour.frontend.inquiry', compact('fcSystem','seo','page','TourCategory'));
    }
    //search tour
    public function search(Request $request){
        $keyword = $request->keyword;
        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $data =  Tour::where(['alanguage'=> config('app.locale'),'publish' => 0]);
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->orderBy('order', 'asc')->orderBy('id', 'desc');
        //lấy tour type
        $wherInTourType = $data->pluck('tours.id');
        $TourType = \App\Models\TourType::leftJoin('tour_type_relationships', 'tour_types.id', '=', 'tour_type_relationships.tour_type_id')
        ->whereIn('tour_type_relationships.tour_id',$wherInTourType)->select('tour_types.id','tour_types.title',DB::raw("count('tour_id') as count"))
        ->groupby('tour_type_id')->get();
        //end
        //count start 1-5
        $rate5 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<=",5)->where('rate',">=",4.5)->count();
        $rate4 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",4.5)->where('rate',">=",3.5)->count(); //lớn hơn 3.5 và nhỏ hơn 4.5
        $rate3 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",3.5)->where('rate',">=",2.5)->count(); // lớn hơn 2.5 và nhỏ hơn 3.5
        $rate2 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",2.5)->where('rate',">=",1.5)->count(); //lớn hơn 1.5 và nhỏ hơn  2.5
        $rate1 =  Tour::where(['tours.alanguage' => config('app.locale'),'publish' => 0])->whereIn('id',$wherInTourType)->where('rate',"<",1.5)->where('rate',">",0)->count();
        //end
        $data =  $data->paginate($this->paginate);
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  "Search tour ". $keyword;
        $seo['meta_description'] = '';
        $seo['meta_image'] = '';
        $fcSystem = $this->system->fcSystem();
        $TourCategory = TourCategory::select('id','title')->where(['alanguage'=> config('app.locale'),'publish' => 0])->with('tours')->orderBy('order','asc')->orderBy('id','desc')->get();
        $category_attributes = \App\Models\CategoryAttribute::select('id','title','slug')->where(['alanguage'=> config('app.locale'),'publish' => 0])->with('listAttr')->orderBy('order','asc')->orderBy('id','desc')->get();

        return view('tour.frontend.search.index', compact('fcSystem','seo','data','TourCategory','category_attributes','TourType','rate5','rate4','rate3','rate2','rate1'));

    }
}
