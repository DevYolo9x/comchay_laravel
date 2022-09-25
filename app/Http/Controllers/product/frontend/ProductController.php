<?php

namespace App\Http\Controllers\product\frontend;

use App\Components\Comment as CommentHelper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Components\System;

class ProductController extends Controller
{
    protected $comment;
    public function __construct()
    {
        $this->comment = new CommentHelper();
        $this->system = new System();
    }
    public function index(Request $request, $slug = "", $id = 0)
    {
        $segments = request()->segments();
        $slug = end($segments);
        $detail = Product::where(['alanguage' => config('app.locale'), 'slug' => $slug, 'publish' => 0])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        //comment
        $comment_view =  $this->comment->comment(array('id' => $detail->id, 'sort' => 'id'), 'products');


        //end
        //lấy danh mục cha
        $detailCatalogue = $detail->detailCategoryProduct;
        // breadcrumb
        $breadcrumb = [];
        if (!empty($detailCatalogue)) {
            $breadcrumb = CategoryProduct::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detailCatalogue->lft)->where('rgt', '>=', $detailCatalogue->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        }
        //lấy brands
        $brand = Brand::select('id', 'title', 'slug')->whereIn('id', $detail->brands->pluck('brandid'))->first();
        //sản phẩm liên quan
        $productSame =  Product::join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', 'products');
        $productSame =  $productSame->where('catalogues_relationships.catalogueid', $detailCatalogue->id)->where('products.id', '!=', $detail->id);
        $productSame =  $productSame->orderBy('order', 'asc')->orderBy('id', 'desc');
        $productSame =  $productSame->select('id', 'title', 'image', 'slug', 'price', 'price_sale', 'price_contact');
        $productSame =  $productSame->limit(10);
        $productSame =  $productSame->get();
        $seo['canonical'] =  $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('product.frontend.product.index', compact('fcSystem', 'detail', 'seo', 'breadcrumb', 'productSame', 'detailCatalogue', 'brand', 'comment_view'));
    }
}
