<?php

namespace App\Http\Controllers\product\backend;

use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CategoryProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Components\Helper;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $Nestedsetbie;
    protected $Lang;
    protected $table = 'products';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'category_products'));
        $this->Helper = new Helper();
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $htmlOption = $this->Nestedsetbie->dropdown();
        $catalogueid = $request->catalogueid;
        $data =  Product::where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $data = $data->join('catalogues_relationships', $this->table . '.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', $this->table);
        if (!empty($catalogueid)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $catalogueid);
        }
        $data =  $data->groupBy('catalogues_relationships.moduleid');
        $data =  $data->paginate(env('APP_paginate'));
        if (is($catalogueid)) {
            $data->appends(['catalogueid' => $catalogueid]);
        }
        $dropdown = getFunctions();
        $tags = \App\Models\Tag::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $brands = \App\Models\Brand::select('id', 'title')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('product.backend.product.index', compact('data', 'module', 'htmlOption', 'tags', 'brands', 'dropdown', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $dropdown = getFunctions();
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $category_attribute = DB::table('category_attributes')
            ->select('id', 'title')
            ->where('id', '!=', 1)
            ->where('alanguage', config('app.locale'))
            ->get();
        //tag
        $getTags = [];
        if (old('tags')) {
            $getTags = old('tags');
        }
        $tags = \App\Models\Tag::select('id', 'title')->where('module', 'products')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        //end
        //brands
        $getBrands = [];
        if (old('brands')) {
            $getBrands = old('brands');
        }
        $brands = \App\Models\Brand::select('id', 'title')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        //end
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
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute);
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('product.backend.product.create', compact('field', 'module', 'htmlCatalogue', 'htmlAttribute', 'tags', 'getTags', 'brands', 'getBrands', 'attribute_json', 'dropdown'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . config('app.locale') . ',alanguage',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
            'code' => 'unique:products',
            'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'code.unique' => 'Mã sản phẩm đã tồn tại.',
            'catalogue_id.gt' => 'Danh mục chính là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'san-pham');
        } else {
            $image_url = $request->image_old;
        }
        //end

        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('products.index')->with('success', "Thêm mới sản phẩm thành công");
    }
    public function edit($id)
    {
        $module = $this->table;
        $dropdown = getFunctions();
        $detail  = Product::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('products.index')->with('error', "Sản phẩm không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $category_attribute = DB::table('category_attributes')
            ->select('id', 'title')
            ->where('alanguage', config('app.locale'))
            ->where('id', '!=', 1)
            ->get();
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute);
        //tags
        $getTags = [];
        if (old('tags')) {
            $getTags = old('tags');
        } else {
            foreach ($detail->tags as $k => $v) {
                $getTags[] = $v['tagid'];
            }
        }
        $tags = \App\Models\Tag::select('id', 'title')->where('module', 'products')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        //end tag
        //brands
        $getBrands = [];
        if (old('brands')) {
            $getBrands = old('brands');
        } else {
            foreach ($detail->brands as $k => $v) {
                $getBrands[] = $v['brandid'];
            }
        }
        $brands = \App\Models\Brand::select('id', 'title')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        //end brand
        //attr
        if (old('attribute')) {
            $attribute = old('attribute');
        } else {
            $version_json = json_decode(base64_decode($detail->version_json), true);
            $attribute = $version_json[2];
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
        $getCatalogue = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('product.backend.product.edit', compact('field', 'module', 'getCatalogue', 'detail', 'htmlCatalogue', 'htmlAttribute', 'tags', 'getTags', 'getBrands', 'brands', 'attribute_json', 'dropdown'));
    }
    public function copy($id)
    {
        $module = $this->table;
        $dropdown = getFunctions();
        $detail  = Product::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('products.index')->with('error', "Sản phẩm không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown();
        $category_attribute = DB::table('category_attributes')
            ->select('id', 'title')
            ->where('alanguage', config('app.locale'))
            ->where('id', '!=', 1)
            ->get();
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute);
        //tags
        $getTags = [];
        if (old('tags')) {
            $getTags = old('tags');
        } else {
            foreach ($detail->tags as $k => $v) {
                $getTags[] = $v['tagid'];
            }
        }
        $tags = \App\Models\Tag::select('id', 'title')->where('module', 'products')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        //end tag
        //brands
        $getBrands = [];
        if (old('brands')) {
            $getBrands = old('brands');
        } else {
            foreach ($detail->brands as $k => $v) {
                $getBrands[] = $v['brandid'];
            }
        }
        $brands = \App\Models\Brand::select('id', 'title')->where('alanguage', config('app.locale'))->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        //end brand
        //attr
        if (old('attribute')) {
            $attribute = old('attribute');
        } else {
            $version_json = json_decode(base64_decode($detail->version_json), true);
            $attribute = $version_json[2];
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
        $getCatalogue = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('product.backend.product.copy', compact('field', 'module', 'getCatalogue', 'detail', 'htmlCatalogue', 'htmlAttribute', 'tags', 'getTags', 'getBrands', 'brands', 'attribute_json', 'dropdown'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            //'slug' => 'required|unique:router,slug,' . $id . ',moduleid,alanguage,' . config('app.locale') . '',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            })],
            'code' => 'unique:products,code,' . $id . ',id',
            'catalogue_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'code.unique' => 'Mã sản phẩm đã tồn tại.',
            'catalogue_id.gt' => 'Danh mục chính là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'san-pham');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('products.index')->with('success', "Cập nhập sản phẩm thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
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
        $detail = CategoryProduct::select('id', 'title', 'slug', 'lft')->where('id', $request['catalogue_id'])->first();
        $breadcrumb = CategoryProduct::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        if ($breadcrumb->count() > 0) {
            foreach ($breadcrumb as $v) {
                $tmp_catalogue[] = $v->id;
            }
        }
        $tmp_catalogue = array_unique($tmp_catalogue);
        //end
        //version
        $checkbox = isset($request['checkbox_val']) ? $request['checkbox_val'] : [];
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
            //inventory
            'inventory' => isset($request['inventory']) ? $request['inventory'] : 0,
            'inventoryPolicy' => isset($request['inventoryPolicy']) ? $request['inventoryPolicy'] : 0,
            'inventoryQuantity' => $request['inventoryQuantity'],
            'image_json' =>  !empty($request['album']) ? json_encode($request['album']) : '',
            'catalogue_id' => $request['catalogue_id'],
            'catalogue' => json_encode($tmp_catalogue),
            'image' => $image_url,
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'version_json' => base64_encode(json_encode(array($checkbox, $attribute_catalogue, $attribute))),
            'alanguage' => config('app.locale'),
        ];


        if ($action == 'create') {
            $id = Product::insertGetId($_data_product);
        } else {
            DB::table('products')->where('id', '=', $id)->update($_data_product);
        }
        if (!empty($id)) {
            /*xóa khi cập nhập*/
            if ($action == 'update') {
                /*xóa catalogue_relationship*/
                DB::table('catalogues_relationships')->where('moduleid', $id)->where('module', $this->table)->delete();
                /*xóa tags_relationship*/
                DB::table('tags_relationships')->where('moduleid', $id)->where('module', $this->table)->delete();
                /*xóa brands_relationship*/
                DB::table('brands_relationships')->where('moduleid', $id)->where('module', $this->table)->delete();
                /*xóa attribute_relationship*/
                DB::table('attributes_relationships')->where('moduleid', $id)->delete();
                /*Xóa  products_versions*/
                DB::table('products_versions')->where('productid', $id)->delete();
                /*Xóa products_colors and products_sizes */
                DB::table('products_sizes')->where('product_id', $id)->delete();
                DB::table('products_colors')->where('product_id', $id)->delete();

                /*xóa router*/
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
                'alanguage' => config('app.locale'),

            ]);
            //thêm vào bảng catalogue_relationship
            $this->Helper->catalogue_relation_ship($id, $request['catalogue_id'], $tmp_catalogue, $this->table);
            //thêm product_version
            $this->Helper->create_product_version(array(
                'title_version_1' => $request['title_version_1'],
                'title_version_2' => $request['title_version_2'],
                'id_version' => $request['id_version'],
                'title_version' => $request['title_version'],
                'code_version' => $request['code_version'],
                'image_version' => $request['image_version'],
                'price_version' => $request['price_version'],
                'price_sale_version' => $request['price_sale_version'],
                '_stock_status' => $request['_stock_status'],
                '_stock' => $request['_stock'],
                '_outstock_status' => $request['_outstock_status'],
                'productid' => $id,
            ));
            //thêm vào bảng brand_relationship
            $this->Helper->_table_relation_ship($id, $request['brands'], 'brands', 'brandid', $this->table);


            //thêm vào bảng tag_relationship
            $this->Helper->_table_relation_ship($id, $request['tags'], 'tags', 'tagid', $this->table);


            //thêm nhóm thuộc tính vào nhóm sản phẩm
            $this->Helper->update_attribute_catalogue_in_product_catalogue(array(
                'catalogueid' => $request['catalogue_id'],
                'tmp_catalogue' => $tmp_catalogue,
                'attribute_catalogue' => $attribute_catalogue,
                'attribute' => $attribute,
            ));


            //thêm vào bảng attribute_relationship
            $this->Helper->attribute_relation_ship($id, $attribute);


            //thêm sản phẩm vào khoảng giá
            $this->Helper->price_attributes((float)str_replace('.', '', $request['price']), $id);


            //new: thêm version table product_color and product_size
            $colors =  $request['colors'];
            $sizes =  $request['sizes'];
            $color_page = $this->convert_color($colors, $sizes);
            $color_size_insert = [];
            if (isset($color_page) && is_array($color_page) && count($color_page)) {
                foreach ($color_page as $keyc => $vals) {
                    $tmp_status[$keyc] = [];
                    $totalSizeOfColor = 0;
                    $color_id = \App\Models\products_color::insertGetId([
                        'title' => $vals['title'],
                        'image' => $vals['image'],
                        'product_id' => $id,
                        'stock' => 0,
                        $user => Auth::user()->id,
                        $time => Carbon::now(),
                    ]);
                    if (isset($vals['page']) && is_array($vals['page']) && count($vals['page'])) {
                        foreach ($vals['page'] as $key => $val) {
                            $totalSizeOfColor += $val['_stock'];
                            $color_size_insert[] = array(
                                'title' => $val['title'],
                                'title_color' => $vals['title'] . '/' . $val['title'],
                                'code' => $val['code'],
                                'price' => isset($val['price']) ? str_replace('.', '', $val['price']) : 0,
                                'price_sale' => isset($val['price_sale']) ? str_replace('.', '', $val['price_sale']) : 0,
                                '_stock_status' => $val['_stock_status'],
                                '_stock' =>  $val['_stock'],
                                '_outstock_status' => $val['_outstock_status'],
                                'color_id' => $color_id,
                                'product_id' => $id,
                                $user => Auth::user()->id,
                                $time => Carbon::now(),
                            );

                            if ($val['_stock_status'] == 0 || $val['_outstock_status'] == 1) {
                                $tmp_status[$keyc][] = $vals['title'] . '/' . $val['title'];
                            }
                            if ($totalSizeOfColor > 0) {
                                $tmp_status[$keyc][] = $vals['title'] . '/' . $val['title'];
                            }
                        }
                    }
                    // echo "<pre>";var_dump($tmp_status[$keyc]);
                    // echo "<pre>";var_dump($totalSizeOfColor);
                    if (!empty($tmp_status[$keyc])) {
                        DB::table('products_colors')->where('id', '=', $color_id)->update([
                            'stock' => 1,
                        ]);
                    }
                }
                DB::table('products_sizes')->insert($color_size_insert);
            }
            //end
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END

        }
    }
    public function convert_color($color = '', $size = '')
    {
        //vòng lặp của color
        $tempColor = [];
        if (isset($color['title']) && is_array($color['title'])  && count($color['title'])) {
            foreach ($color['title'] as $key => $val) {
                $tempColor[] = array('title' => $val);
            }
        }
        if (isset($tempColor) && is_array($tempColor) && count($tempColor)) {
            foreach ($tempColor as $key => $val) {
                $tempColor[$key]['title'] = $color['title'][$key];
                $tempColor[$key]['image'] = $color['image'][$key];
                $tempColor[$key]['count'] = $color['count'][$key];
            }
        }
        //vòng lặp của size
        $tempSize = [];
        if (isset($size['title']) && is_array($size['title'])  && count($size['title'])) {
            foreach ($size['title'] as $key => $val) {
                $tempSize[] = array('title' => $val);
            }
        }
        if (isset($tempSize) && is_array($tempSize) && count($tempSize)) {
            foreach ($tempSize as $key => $val) {
                $tempSize[$key]['title'] = $size['title'][$key];
                $tempSize[$key]['code'] = $size['code'][$key];
                $tempSize[$key]['price'] = $size['price'][$key];
                $tempSize[$key]['price_sale'] = $size['price_sale'][$key];
                $tempSize[$key]['_stock_status'] = $size['_stock_status'][$key];
                $tempSize[$key]['_stock'] = $size['_stock'][$key];
                $tempSize[$key]['_outstock_status'] = $size['_outstock_status'][$key];
            }
        }
        $array = [];
        if (isset($tempColor) && is_array($tempColor) && count($tempColor)) {
            $j = $i = 0;
            foreach ($tempColor as $key => $val) {
                $array[$key]['title'] = $val['title'];
                $array[$key]['image'] = $val['image'];
                $j = $j + $val['count'];
                $page = [];
                if (isset($tempSize) && is_array($tempSize) && count($tempSize)) {
                    foreach ($tempSize as $keyS => $valS) {
                        if ($keyS < $j && $keyS >= $i) {
                            $page[$keyS] = $valS;
                            $i++;
                        }
                    }
                    $page = array_values($page);
                }
                $array[$key]['page'] = $page;
            }
        }
        return $array;
    }
    public function get_attrid(Request $request)
    {
        $catalogue_id = $request->catalogue_id;
        $detailCatalogue = DB::table('category_products')->select('id', 'attrid')->where('id', '=', $catalogue_id)->first();
        $attribute_catalogue = getListAttr($detailCatalogue->attrid);
        $html = '';
        if (check_array($attribute_catalogue)) {
            foreach ($attribute_catalogue as $key => $val) {
                if (count($val) > 1) {
                    $html = $html . '<li class="catalogue mb-3" data-keyword = ' . $val['keyword_cata'] . '>';
                    $html = $html . '<label class="form-label text-base font-semibold">' . $key . '</label>';
                    $html = $html . '<div class="grid grid-cols-12 gap-6" >';
                    foreach ($val as $sub => $subs) {
                        if ($sub != 'keyword_cata') {
                            $html = $html . '<div class="col-span-3">';
                            $html = $html . '<div class="attr cursor-pointer">';
                            $html = $html . '<input disabled="disabled"  class="checkbox-item filter mr-2" type="checkbox" name="attr[]" value="' . $sub . '"><span style="margin-left: -24px;padding-left: 24px;">';
                            $html = $html . $subs;
                            $html = $html . '</span></div>';
                            $html = $html . '</div>';
                        }
                    }
                    $html = $html . '</div>';
                    $html = $html . '</li>';
                }
            }
        }
        echo json_encode(array(
            'attribute_catalogue' => $html,
        ));
        die();
    }
    public function listproduct(Request $request)
    {
        $data =  Product::where('alanguage', config('app.locale'))->orderBy('order', 'ASC')->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $brand = $request->brand;
        $tag = $request->tag;
        $request_attr = $request->attr;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('products.title', 'like', '%' . $keyword . '%');
            $data =  $data->orWhere('products.code', 'like', '%' . $keyword . '%');
        }
        if (!empty($type)) {
            $data =  $data->where('products.' . $type, 1);
        }
        //xử lý danh mục
        $data = $data->join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', $this->table);
        if (!empty($request->catalogue_id)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $request->catalogue_id);
        }
        //xử lý khoảng giá
        $request->start_price = (int)str_replace('.', '', $request->start_price);
        $request->end_price = (int)str_replace('.', '', $request->end_price);
        if (isset($request->start_price) && !empty($request->end_price)) {
            $data =  $data->where('products.price', '>=', $request->start_price);
            $data =  $data->where('products.price', '<=', $request->end_price);
        }
        //xử lý tags
        if (!empty($brand)) {
            $data = $data->join('brands_relationships', 'products.id', '=', 'brands_relationships.moduleid')->where('brands_relationships.module', '=', $this->table);
            $data =  $data->whereIn('brands_relationships.brandid', $brand);
        }
        //xử lý tags
        if (!empty($tag)) {
            $data = $data->join('tags_relationships', 'products.id', '=', 'tags_relationships.moduleid')->where('tags_relationships.module', '=', $this->table);
            $data =  $data->whereIn('tags_relationships.tagid', $tag);
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
        $data =  $data->paginate(env('APP_paginate'));
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();

        return view('product.backend.product.index.data', compact('data', 'configIs'))->render();
    }
}
