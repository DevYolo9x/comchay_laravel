<?php

namespace App\Http\Controllers\product\frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Components\System;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request, $slug = "", $id = 0)
    {
        $segments = request()->segments();
        $slug = end($segments);
        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $detail = CategoryProduct::where(['alanguage' => config('app.locale'), 'slug' => $slug, 'publish' => 0])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        // $childCategory =  CategoryProduct::where('parentid', $detail->id)->get();
        //bộ lọc
        // $attribute_catalogue = getListAttr($detail->attrid);
        //data product
        $data =  Product::join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', 'products');
        if (!empty($detail->id)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $detail->id);
        }
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                return redirect()->route('routerURL', ['slug' => $detail->slug]);
            }
        } else {
            $data =  $data->orderBy('order', 'asc')->orderBy('id', 'desc');
        }
        /*$data = $data->with([
            'products_versions' => function ($q) {
                $q->groupBy('products_versions.product_color_id');
            }
        ]); */
        $data =  $data->paginate(24);
        if (is($sort)) {
            $data->appends(['sort' => $request->sort]);
        }
        //end
        // breadcrumb
        $breadcrumb = CategoryProduct::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('product.frontend.category.index', compact('fcSystem', 'detail', 'seo', 'data', 'breadcrumb'));
    }
    public function search(Request $request)
    {

        $keyword = $request->keyword;
        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $data =  Product::where(['alanguage' => config('app.locale'), 'publish' => 0])->with([
            'products_versions' => function ($q) {
                $q
                    ->groupBy('products_versions.product_color_id');
            }
        ]);
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (!empty($sort) && count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                return redirect()->route('search', ['keyword' => $keyword]);
            }
        } else {
            $data =  $data->orderBy('order', 'asc')->orderBy('id', 'desc');
        }
        $data =  $data->paginate(32);
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($sort)) {
            $data->appends(['sort' => $request->sort]);
        }
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  "Tìm kiếm sản phẩm " . $keyword;
        $seo['meta_description'] = '';
        $seo['meta_image'] = '';
        $fcSystem = $this->system->fcSystem();


        return view('product.frontend.search.index', compact('fcSystem', 'seo', 'data'));
    }
}
