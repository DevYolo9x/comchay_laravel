<?php

namespace App\Http\Controllers\product\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Products_version;
use App\Models\products_size;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Session;
use App\Components\Comment as CommentHelper;
class AjaxController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new CommentHelper();
    }
    public function getversion(Request $request)
    {
        $attr = $request->attr;
        $id = $request->id;
        $attr = substr($attr, 1, strlen($attr));
        $ex = explode(";", $attr);
        $id_sort = array();
        foreach ($ex as $key => $row) {
            $id_sort[$key] = $row;
        }
        array_multisort($id_sort, SORT_DESC, $ex);
        try{
            $product = Product::where('alanguage', config('app.locale'))->findOrFail($id);
            $getVersionproduct = Products_version::select('title_version', 'price_version', 'id_sort','status_version','stock_version')->where('productid', $id)->where('id_sort', json_encode($id_sort))->first();
        }catch(ModelNotFoundException $e){
            return response()->json(["message"=>"Sản phẩm không tồn tại"], 404);
        }
        return response()->json(["getVersionproduct"=>$getVersionproduct], 200);
    }

    public function quick_view(Request $request){

        try{
            $detail = Product::where(['alanguage' => config('app.locale'),'id'=> $request->id,'publish' => 0])->with([
                'products_color' => function($q) {
                    $q
                    ->join('products_versions', 'products_colors.id', '=', 'products_versions.product_color_id')
                    ->groupBy('products_versions.product_color_id')->get();
                }
            ])->first();
            $listAlbums = json_decode($detail->image_json, true);
            $brand = \App\Models\Brand::select('id','title','slug')->whereIn('id',$detail->brands->pluck('brandid'))->first();

            $comment_view =  $this->comment->comment(array('id' => $detail->id, 'sort' => 'id'));

            $version = getBlockAttr($detail['version_json']);
            if(count($detail->products_color) > 0){
                $type= 'variable';
            }else{
                $type= 'simple';
            }
            $price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));

            $html = '';
            $html.='<button class="text-black text-lg absolute top-7 right-7 modal-close" style="    position: absolute;
            z-index: 999;
            top: 10px;
            right: 10px;
            color: red;"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg></button>
            <div class="box_product_detail grid grid-cols-12 space-x-0 md:space-x-10">
            <div class="col-span-12 md:col-span-6">';
            if(!empty($listAlbums)){
            $html.='<div class="overflow-hidden ">
                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                        class="swiper mySwiper2 flex-1 ml-4 overflow-hidden">
                        <div class="swiper-wrapper">';
                        foreach($listAlbums as $key=>$item){
                        $html.='<div class="swiper-slide ">
                                <img src="'.$item.'" alt="'.$detail->title.'"
                                    class="w-full object-cover h-full" />
                            </div>';
                        }
            $html.='</div>
                    </div>
                    <div thumbsSlider="" class="swiper mySwiper mt-2">
                        <div class="swiper-wrapper">';
                        foreach($listAlbums as $key=>$item){
                        $html.='<div class="swiper-slide ">
                                <img src="'.$item.'" alt="'.$detail->title.'" />
                            </div>';
                        }
            $html.='</div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>';
        }
        $html.='</div>
            </div>
            <div class="col-span-12 md:col-span-6 mt-5 md:mt-0">
                <div class="flex-1 overflow-auto p-4">
                    <div class="flex flex-col space-y-4">
                        <div class="flex flex-col space-y-3">
                            <div class="flex flex-col">
                                <h1 class="font-semibold text-2xl">'.$detail->title.'</h1>
                                <div class="section-subtitle flex text-gray-20 mt-1 flex-wrap divide">
                                    <span class="mr-3 text-ui">
                                        CODE: <span class="product_code text-d61c1f">'.$detail->code.'</span>
                                    </span>';
                                    if($brand){
                                    $html.='<span class="mr-3 text-ui">
                                        Thương hiệu: <a href="'.route('brandURL',['slug' => $brand->slug]).'"
                                            class=" text-d61c1f">'.$brand->title.'</a>
                                    </span>';
                                    }

                                    $html.='<div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                            <a href="javascript:void(0)" class="text-blue-400 cursor-pointer scrollCmt">
                                                '.$comment_view['totalComment'].' đánh giá
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="text-red-600 text-2xl font-extrabold product_price_final">'.$price['price_final'].'</span>
                                    <div class="ml-2">
                                        <span class="line-through text-lg product_price_old">'.$price['price_old'].'</span>
                                        <span class="text-2xl text-red-600 ml-1 product_percent">';
                                        if(!empty($price['percent'])){
                                            $html.='-'.$price['percent'];
                                        }
                                        $html.='</span>

                                    </div>
                                </div>
                            </div>';
                            if(!empty($detail->description)){
                                $html.='<div class="bg-red-50 rounded-lg px-4 py-3">
                                '.$detail->description.'
                            </div>';
                            }


                        $html.='</div>';
                        // chọn màu sắc

                        if( $type == 'variable'){
                        if(isset($version['version'])){
                        if(count($version['version']) > 1){
                        foreach($version['version'] as $key=>$value){
                        if(count($detail->products_color) > 0){
                        if($key == 1){
                            $html.='<div class="section-color-picker">
                            <div class="font-black mb-2">
                                '. $value['title'].'
                            </div>
                            <div class="inline-block">';
                                foreach($detail->products_color as $key=>$item){

                                if($item->image_version){
                                    $image_version = $item->image_version;
                                }else{
                                    $image_version = $detail->image;
                                }
                                if($item->stock == 0){
                                    $class = "disabled";
                                }else{
                                    $class = "colors hover:border-d61c1f hover:text-d61c1f cursor-pointer";

                                }
                                $html.='<div class="'.$class.' item px-3 py-2 mb-2 inline-block mr-2 border"
                                    data-id="'.$item->product_color_id.'" data-image="'.$image_version.'">
                                    '.$item->title.'
                                </div>';
                                }
                                $html.='</div></div>';
                         }else{
                            $html.='<div class="section-color-picker hidden">
                        <div class="font-black mb-2">
                                '.$value['title'].'
                            </div>
                            <div class="inline-block" id="loadSize">';
                                foreach($detail->products_color as $key=>$item){
                                if($key==0){
                                foreach($item->products_versions as $k=>$val){
                                $html.= htmlSize($val, $detail->image);
                                }
                                }
                                }
                                $html.='</div>
                        </div>';
                        }
                        }
                        }
                        }else{
                        if(isset($version['version'])){
                        foreach($version['version'] as $key=>$value){
                            $html.='<div class="section-color-picker">
                            <div class="font-black mb-2">';
                            $html.=$value['title'];
                            $html.='</div>
                            <div class="inline-block" id="loadSize">';
                                foreach($detail->products_versions as $key=>$item){
                                    $html.=htmlSize($item, $detail->image);
                                }
                                $html.='</div>
                        </div>';
                        }
                        }
                        }
                        }
                        }
                        //end
                        $quantityStock = '';
                        if($type == 'simple'){
                            $hiddenAddToCart = 0;
                            $product_stock_title = '';

                            if($detail->inventory == 1){
                                if($detail->inventoryPolicy == 0){
                                    if($detail->inventoryQuantity == 0){
                                        $hiddenAddToCart = 1;
                                        $product_stock_title =  '<span class="product_stock">Hết hàng</span>';
                                    }else{
                                        $quantityStock = $detail->inventoryQuantity;
                                        $product_stock_title = '<span class="product_stock">'.$detail->inventoryQuantity.'</span> sản phẩm có sẵn';
                                    }

                                }else{
                                    $product_stock_title = '<span class="product_stock"></span> sản phẩm có sẵn';
                                }
                            }else{
                                $product_stock_title = '<span class="product_stock"></span> sản phẩm có sẵn';
                            }
                        }



            $html.='</div>
                    <div class="product-details w-full py-4 ">
                        <div class="font-black mb-2">Số lượng</div>
                        <div class="flex items-center">
                            <div
                                class="custom-number-input h-10 w-32 flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                <button
                                    class="card-dec bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none"
                                    style="line-height:40px">
                                    <span class="m-auto text-2xl font-thin">−</span>
                                </button>
                                <input type="number" max="'.$quantityStock.'"
                                    class="card-quantity outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                    name="custom-input-number" value="1"></input>
                                <button
                                    class="card-inc bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer"
                                    style="line-height:40px">
                                    <span class="m-auto text-2xl font-thin">+</span>
                                </button>

                            </div>
                            <div class="ml-2 text-red-600 font-bold">';
                            if($type == 'simple'){
                                $html.=$product_stock_title;
                            }else{
                                $html.='<span class="product_stock"></span> sản phẩm có sẵn';

                            }
                            if(!empty($price['price_final_none_format'])){
                                $price_final_none_format = $price['price_final_none_format'];
                            }else{
                                $price_final_none_format = 0;
                            }
                            $classBtnCart = '';
                            if($type == 'simple'){
                                if($hiddenAddToCart == 1){
                                    $classBtnCart = 'hidden';
                                }
                            }
                            $html.='</div>
                            </div>
                            <div class="mt-5 flex items-center w-full space-x-2">
                                <button data-quantity="1" data-id="'.$detail->id.'" data-title="'.$detail->title.'"
                                    data-price="'.$price_final_none_format.'"
                                    data-cart="0" data-src="" data-type="'.$type.'"
                                    class="'.$classBtnCart.' addtocart uppercase font-black h-12 w-1/2 text-white bg-red-600 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                    Thêm vào giỏ
                                </button>
                                <button data-quantity="1" data-id="'.$detail->id.'" data-title="'.$detail->title.'"
                                    data-price="'.$price_final_none_format.'"
                                    data-cart="1" data-src="" data-type="'.$type.'"
                                    class="'.$classBtnCart.' addtocart uppercase font-black h-12 w-1/2 text-white bg-black flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                    mua ngay
                                </button>
                            </div>
                    </div>

                </div>

            </div>
        </div>';



        }catch(ModelNotFoundException $e){
            return response()->json(["error"=>"Sản phẩm không tồn tại"], 404);
        }
        return response()->json(["html"=>$html], 200);
    }
    public function product_filter(Request $request)
    {
        $data =  Product::where('alanguage', config('app.locale'));
        $keyword = $request->keyword;
        $brand = $request->brand;
        $request_attr = $request->attr;
        $sort = $request->sort;

        if (!empty($keyword)) {
            $data =  $data->where('products.title', 'like', '%' . $keyword . '%');
        }
        //xử lý danh mục
        $data = $data->join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', 'products');
        if (!empty($request->catalogueid)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $request->catalogueid);
        }

        //xử lý brand
        if (!empty($brand)) {
            $data = $data->join('brands_relationships', 'products.id', '=', 'brands_relationships.moduleid')->where('brands_relationships.module', '=', 'products');
            $data =  $data->whereIn('brands_relationships.brandid',$brand);
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
                    $data = $data->join('attributes_relationships as tb' . $index . '', 'products.id', '=', 'tb' . $index . '.moduleid');
                }
                $data =  $data->whereIn('tb' . $index . '.attrid', $val);
            }
            $data =  $data->groupBy('tb102.moduleid');
        }
        $data =  $data->groupBy('catalogues_relationships.moduleid');
        //sort
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (count($sort) == 2) {
                $data =  $data->orderBy('products.'.$sort[0], $sort[1]);
            }
        } else {
            $data =  $data->orderBy('products.id', 'desc');
        }
        $data = $data->with([
            'products_versions' => function($q) {
                $q
                ->groupBy('products_versions.product_color_id');
            }
        ]);
        $data =  $data->paginate(24);
        //render HTML
        $html = '';
        $html .= '<div class="grid grid-cols-2 md:grid-cols-4 gap-2">';
                    foreach ($data as $k => $item) {
                        $html .= htmlItemProduct($k,$item);
                    }
                    $html .= '</div>
                <div class="mt-10">
                    <div class="pagination_custom flex justify-center">';
                    $html .= $data->links();
                        $html .= '</div>
                </div>';
        echo json_encode(['html' => $html,'total' => $data->total()]);die;
    }
    //lấ
    //lấy size của sản phẩm theo màu sắc
    public function product_sizes(Request $request){
        $html = '';
        $sizes = Products_version::where(['product_color_id' => $request->id])->get();
        if($sizes->count() > 0){
            foreach ($sizes as $k=>$val){
                $html.=htmlSize($val,$request->image);
            }

        }
        echo json_encode(['html' => $html]);die;

    }
}