<?php

namespace App\Http\Controllers\product\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products =  Product::select('id','title','code')->where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $result['code'] = 200;
        $result['list'] = $products;
        $result['msg'] = "Success";
        return response()->json(['request' => $request->url(),'result'=>$result]);
    }
    public function index_product_category(Request $request)
    {
        $products =  CategoryProduct::select('id','title')->where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC')->get();
        $result['code'] = 200;
        $result['list'] = $products;
        $result['msg'] = "Success";
        return response()->json(['request' => $request->url(),'result'=>$result]);
    }
}
