<?php

namespace App\Http\Controllers\tour\backend;


use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Components\Helper;
use Illuminate\Validation\Rule;
class TourController extends Controller
{
    protected $Nestedsetbie;
    protected $table = 'tours';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'tour_categories'));
        $this->Helper = new Helper();
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $category = $this->Nestedsetbie->dropdown();
        //data tour
        $data =  Tour::where('tours.alanguage', config('app.locale'));
        //search keyword
        $keyword = $request->keyword;
        $category_id = $request->category_id;
        //xử lý danh mục
        $data =  $data->join('tour_category_relationships', 'tours.id', '=', 'tour_category_relationships.tour_id');
        if (!empty($category_id)) {
            $data =  $data->where('tour_category_relationships.tour_category_id', $category_id);
        }
        $data =  $data->groupBy('tour_category_relationships.tour_id')->select('tours.id','title','slug','image','catalogue_id','code','price','price_contact','price_sale','publish','ishome','highlight','isaside','isfooter','order','userid_created','created_at');
        if (!empty($keyword)) {
            $data =  $data->where('tours.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->orderBy('order', 'ASC')->orderBy('id', 'DESC')->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($category_id)) {
            $data->appends(['category_id' => $category_id]);
        }
        return view('tour.backend.tour.index', compact('data', 'module', 'category'));
    }
    public function create()
    {
        $module = $this->table;
        $dropdown = getFunctions();
        $category = $this->Nestedsetbie->dropdown();
        //travel type
        $getType = \App\Models\TourType::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $types = $this->Nestedsetbie->DropdownCatalogue($getType);
        //end
        //get services tour
        $services = \App\Models\TourService::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->with('items')->get();
        //end
        //get danh sách thuộc tính
        $category_attribute = DB::table('category_attributes')
        ->select('id', 'title')
        ->where('alanguage', config('app.locale'))
        ->get();
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute);
        //end
        //attribute
        if (old('attribute')) {
            $attribute = old('attribute');
        }
        $attribute_json = [];
        if (!empty($attribute)) {
            foreach ($attribute as $key => $value) {
                if ($value == '') {
                    $attribute_json[$key] = '';
                } else {
                    // $attribute_json[$key]['json'] = base64_encode(json_encode($value));
                    $attributes =  DB::table('attributes')->orderBy('order', 'asc')->orderBy('id', 'desc')->whereIn('id', $value)->get();
                    $temp = [];
                    if (!empty($attributes)) {
                        foreach ($attributes as $val) {
                            $temp[] = array(
                                'id' => $val->id,
                                'text' => $val->title,
                            );
                        }
                    }
                    $attribute_json[$key] = $temp;
                }
            }
        }
        //end attr
        //tags
        $getTags = [];
        if (old('tags')) {
            $getTags = old('tags');
        }
        // $tags = relationships('\App\Models\Tag', $getTags);
        //end tag
        $tags = Tag::select('id', 'title')->where('module', 'tours')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('tour.backend.tour.create', compact('module','category','types','services','htmlAttribute','dropdown','attribute_json','tags','getTags'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
            'code' => 'unique:tours',
            'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'code.unique' => 'Mã tour đã tồn tại.',
            'catalogue_id.gt' => 'Điểm đến là trường bắt buộc.',
        ]);
        //upload image,banner
        if(!empty($request->file('image'))){
            $image_url = uploadImageNone($request->file('image'),'tour');
        }else{
            $image_url = $request->image_old;
        }
       
        if(!empty($request->file('banner'))){
            $banner_url = uploadImageNone($request->file('banner'),'tour/banner');
        }else{
            $banner_url = $request->image_banner;
        }
   
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];     
        //end
        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('tours.index')->with('success', "Thêm mới tour thành công");
    }

    public function edit($id)
    {
        $module = $this->table;
        $dropdown = getFunctions();
        $detail  = Tour::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('tours.index')->with('error', "Tour không tồn tại");
        }
        $category = $this->Nestedsetbie->dropdown();
        //travel type
        $getType = \App\Models\TourType::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $types = $this->Nestedsetbie->DropdownCatalogue($getType);
        //end
        //get services tour
        $services = \App\Models\TourService::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->with('items')->get();
        //end
        //get danh sách thuộc tính
        $category_attribute = DB::table('category_attributes')
            ->select('id', 'title')
            ->where('alanguage', config('app.locale'))
            ->get();
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute);
         //end
        //attr
        if (old('attribute')) {
            $attribute = old('attribute');
        } else {
            $version_json = json_decode(base64_decode($detail->version_json), true);
            if(!empty($version_json)){
                $attribute = $version_json[1];
            }
        }
        $attribute_json = [];
        if (!empty($attribute)) {
            foreach ($attribute as $key => $value) {
                if ($value == '') {
                    $attribute_json[$key] = '';
                } else {
                    // $attribute_json[$key]['json'] = base64_encode(json_encode($value));
                    $attributes =  DB::table('attributes')->orderBy('order', 'asc')->orderBy('id', 'desc')->whereIn('id', $value)->get();
                    $temp = [];
                    if (!empty($attributes)) {
                        foreach ($attributes as $val) {
                            $temp[] = array(
                                'id' => $val->id,
                                'text' => $val->title,
                            );
                        }
                    }
                    $attribute_json[$key] = $temp;
                }
            }
        }
        //end attr
        //tags
         $getTags = [];
         if (old('tags')) {
             $getTags = old('tags');
         } else {
             foreach ($detail->tags as $k => $v) {
                 $getTags[] = $v['tagid'];
             }
         }
         $tags = Tag::select('id', 'title')->where('module', 'tours')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
         //end tag
         $getCatalogue = [];
         if (old('catalogue')) {
             $getCatalogue = old('catalogue');
         } else {

            $getCatalogue = $detail->catalogue->pluck('tour_category_id');
         }
        $getTypes = \App\Models\TourTypeRelationship::where('tour_id',  $detail->id)->pluck('tour_type_id');
        return view('tour.backend.tour.edit', compact('module','detail','category','types','getTypes','services','htmlAttribute','dropdown','attribute_json','tags','getTags','getCatalogue'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid','!=', $id)->where('alanguage', config('app.locale'));
            })],
            'code' => 'unique:tours,code,' . $id . ',id',
            'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'code.unique' => 'Mã tour đã tồn tại.',
            'catalogue_id.gt' => 'Điểm đến là trường bắt buộc.',
        ]);
        //upload image,banner
        if(!empty($request->file('image'))){
            $image_url = uploadImageNone($request->file('image'),'tour');
        }else{
            $image_url = $request->image_old;
        }
       
        if(!empty($request->file('banner'))){
            $banner_url = uploadImageNone($request->file('banner'),'tour/banner');
        }else{
            $banner_url = $request->image_banner;
        }
   
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];     
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('tours.index')->with('success', "Cập nhập thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $arrayImg = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
            $user = 'userid_created';
        } else {
            $time = 'updated_at';
            $user = 'userid_updated';
        }
        //lấy danh mục phụ
        $catalogue = $request['catalogue'];
        $tmp_catalogue = [];
        if (isset($catalogue)) {
            foreach ($catalogue as $v) {
                if ($v != 0 && $v != $request['catalogue_id']) { //check id != 0 và id != danh mục chính
                    $tmp_catalogue[] = $v;
                }
            }
        }
        //lấy danh mục cha (nếu có)
        $detail = TourCategory::select('id', 'title', 'slug', 'lft')->where('id', $request['catalogue_id'])->first();
        $breadcrumb = TourCategory::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        if ($breadcrumb->count() > 0) {
            foreach ($breadcrumb as $v) {
                $tmp_catalogue[] = $v->id;
            }
        }
        $tmp_catalogue = array_unique($tmp_catalogue);
        //end

        //version
        $attribute_catalogue = isset($request['attribute_catalogue']) ? $request['attribute_catalogue'] : [];
        $attribute = isset($request['attribute']) ? $request['attribute'] : [];
        //data create - update
        $_data_product = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'description' => $request['description'],
            'content' => $request['content'],
            'code' => is($request['code']),
            'price' => isset($request['price']) ? str_replace('.', '', $request['price']) : 0,
            'price_sale' => str_replace('.', '', $request['price_sale']),
            'price_contact' => isset($request['price_contact']) ? $request['price_contact'] : 0,
            'image_json' =>  !empty($request['album']) ? json_encode($request['album']) : '',
            'catalogue_id' => $request['catalogue_id'],
            'image' => $arrayImg['image_url'],
            'banner' => $arrayImg['banner_url'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'checkin' => $request['checkin'],
            'checkout' => $request['checkout'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            //tour
            'map' => $request['map'],
            'video' => $request['video'],
            'discount' => $request['discount'],
            'available' => $request['available'],
            'schedule' => json_encode($request['schedule']),
            'infoTour' => json_encode($request['infoTour']),
            'alanguage' => config('app.locale'),
            'version_json' => base64_encode(json_encode(array($attribute_catalogue, $attribute))),
        ];

        if ($action == 'create') {
            $id = Tour::insertGetId($_data_product);
        } else {
            Tour::find($id)->update($_data_product);
        }
        if (!empty($id)) {
            /*xóa khi cập nhập*/
            if ($action == 'update') {
                /*xóa tour_category_relationships*/
                DB::table('tour_category_relationships')->where('tour_id', $id)->delete();
                /*xóa tour_type_relationships*/
                DB::table('tour_type_relationships')->where('tour_id', $id)->delete();
                /*xóa tour_attribute_relationships*/
                DB::table('tour_attribute_relationships')->where('tour_id', $id)->delete();
                 /*xóa tour_service_relationships*/
                 DB::table('tour_service_relationships')->where('tour_id', $id)->delete();
                /*xóa router*/
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa tags_relationship
                DB::table('tags_relationships')->where('moduleid', $id)->where('module', $this->table)->delete();
            }
            //thêm tour_category_relationships
            $tmp_catalogue_insert = [];
            if (!empty($tmp_catalogue)) {
                foreach ($tmp_catalogue as $v) {
                    if(!empty($v)){
                        $tmp_catalogue_insert[] = array(
                            'tour_id' => $id,
                            'tour_category_id' => $v,
                        );
                    }
                }
                if(!empty($tmp_catalogue_insert)){
                    DB::table('tour_category_relationships')->insert($tmp_catalogue_insert);
                }
            }
            //thêm tag
            $this->Helper->_table_relation_ship($id, $request['tags'], 'tags', 'tagid', $this->table);
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
            ]);
            //thêm vào bảng tour_type_relationships
            $types = [];
            if (isset($request['types'])) {
                foreach ($request['types'] as $v) {
                    if(!empty($v)){
                        $types[] = array(
                            'tour_id' => $id,
                            'tour_type_id' => $v,
                            'created_at' => Carbon::now(),
                        );
                    }
                }
                if(!empty($types)){
                    DB::table('tour_type_relationships')->insert($types);
                }
            }
            //thêm vào bảng tour_attribute_relationships
            $attribute_relationships = [];
            if(isset($attribute_catalogue) && is_array($attribute_catalogue) && count($attribute_catalogue)){
                foreach($attribute_catalogue as $key=>$value){
                    if(isset($attribute[$key]) && is_array($attribute[$key]) && count($attribute[$key])){

                        foreach($attribute[$key] as $k=>$v){
                            if(!empty($v)){
                                $attribute_relationships[] = array(
                                    'tour_id' => $id,
                                    'tour_category_id' => $request['catalogue_id'],
                                    'attribute_category_id' => $value,
                                    'attribute_id' => $v,
                                    'created_at' => Carbon::now(),
                                );
                            }
                        }
                    }
                }
                if(!empty($attribute_relationships)){
                    DB::table('tour_attribute_relationships')->insert($attribute_relationships);
                }
            }
            //thêm vào bảng tour_service_relationships
            $service_relationships = [];
            $groupService = json_decode($request['groupService'],TRUE);
            if(isset($groupService) && is_array($groupService) && count($groupService)){
                foreach($groupService as $key=>$value){
                    if(isset($value) && is_array($value) && count($value)){

                        foreach($value as $k=>$v){
                            if(!empty($v)){
                                $service_relationships[] = array(
                                    'tour_id' => $id,
                                    'tour_service_id' => $key,
                                    'tour_service_item_id' => $v,
                                    'created_at' => Carbon::now(),
                                );
                            }
                        }
                    }
                }
                if(!empty($service_relationships)){
                    DB::table('tour_service_relationships')->insert($service_relationships);
                }
            }
            //end
        }
    }
}