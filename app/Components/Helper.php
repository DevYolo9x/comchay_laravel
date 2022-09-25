<?php

namespace App\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{
    //thêm vào bảng catalogue_relationship
    function catalogue_relation_ship($productid = 0, $catalogueid = 0, $tmp_catalogue = [], $module = '')
    {
        /*$_catalogue_relation_ship[] = array(
            'module' => $module,
            'moduleid' => $productid,
            'catalogueid' => $catalogueid,
            'created_at' => Carbon::now(),
        ); */
        $_catalogue_relation_ship = [];
        if (isset($tmp_catalogue)) {
            foreach ($tmp_catalogue as $v) {
                $_catalogue_relation_ship[] = array(
                    'module' => $module,
                    'moduleid' => $productid,
                    'catalogueid' => $v,
                    'created_at' => Carbon::now(),
                );
            }
        }
        DB::table('catalogues_relationships')->insert($_catalogue_relation_ship);
    }
    //thêm vào bảng attribute_relationship
    function attribute_relation_ship($productid = 0, $attribute = [])
    {
        $_insert_attribute = [];
        if (isset($attribute) && is_array($attribute) && count($attribute) && $attribute != array('0' => 0)) {
            foreach ($attribute as $key => $val) {
                if (isset($val) && is_array($val) && count($val) && $val != array('0' => 0)) {
                    foreach ($val as $sub => $subs) {
                        $_insert_attribute[] = array(
                            'moduleid' => $productid,
                            'attrid' => $subs,
                            'created_at' => Carbon::now(),
                        );
                    }
                } else {
                    $_insert_attribute[] = array(
                        'moduleid' => $productid,
                        'attrid' => $val,
                        'created_at' => Carbon::now(),
                    );
                }
            }
            if (check_array($_insert_attribute)) {
                DB::table('attributes_relationships')->insert($_insert_attribute);
            }
        }
    }
    // thêm nhóm thuộc tính vào nhóm sản phẩm
    function update_attribute_catalogue_in_product_catalogue($param = [])
    {
        $_catalogue_relation_ship[] = $param['catalogueid'];
        if (isset($param['tmp_catalogue'])) {
            foreach ($param['tmp_catalogue'] as $v) {
                $_catalogue_relation_ship[] = $v;
            }
        }

        if (!empty($param['attribute_catalogue']) && $param['attribute_catalogue'] != array(0 => 0)) {
            //foreach từng mảng danh mục sản phẩm
            if (isset($_catalogue_relation_ship)) {
                foreach ($_catalogue_relation_ship as $v) {
                    $product_catalogue = DB::table('category_products')->select('attrid')->where('id', '=', $v)->first();
                    $attrid_old = is(json_decode($product_catalogue->attrid, true));
                    foreach ($param['attribute_catalogue'] as $key => $cata) {
                        if (!empty($param['attribute'])) {
                            foreach ($param['attribute'] as $sub => $attr) {
                                if ($key == $sub) {
                                    $attrid_new[$cata] = $attr;
                                }
                            }
                        }
                    }
                    if (!empty($attrid_old)) {
                        foreach ($attrid_old as $cata_old => $attr_old) {
                            if (!empty($attr_old)) {
                                if (!empty($attrid_new) && check_array($attrid_new)) {
                                    foreach ($attrid_new as $cata_new => $attr_new) {
                                        if ($cata_old == $cata_new) {
                                            $attrid[$cata_old] = array_unique(array_merge($attr_new, $attr_old));
                                        }
                                        if ($cata_old != $cata_new) {
                                            $attrid[$cata_new] = (isset($attrid[$cata_new])) ? array_unique(array_merge($attr_new, $attrid[$cata_new])) : $attr_new;
                                            $attrid[$cata_old] = (isset($attrid[$cata_old])) ? array_unique(array_merge($attr_old, $attrid[$cata_old])) : $attr_old;
                                        }
                                    }
                                }
                            } else {
                                foreach ($param['attribute_catalogue'] as $key => $val) {
                                    foreach ($param['attribute'] as $sub => $subs) {
                                        if ($sub == $key) {
                                            $attrid[$val] = $subs;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ($param['attribute_catalogue'] as $key => $val) {
                            foreach ($param['attribute'] as $sub => $subs) {
                                if ($sub == $key) {
                                    $attrid[$val] = $subs;
                                }
                            }
                        }
                    }
                    if (isset($attrid) && check_array($attrid)) {
                        $_update_attrid = array(
                            'attrid' => json_encode($attrid),
                        );
                        DB::table('category_products')->where('id', '=', $v)->update($_update_attrid);
                    }
                }
            }
        }
    }
    // thêm phiên bản sản phẩm: products_version
    function create_product_version($param = [])
    {
        $_insert_version = [];
        //lấy dữ liệu post lên
        if (isset($param['title_version']) && is_array($param['title_version']) && count($param['title_version'])) {
            foreach ($param['title_version'] as $key => $val) {
                //thêm id sort để chọn các thuộc tính mua hàng theo thứ tự
                $ex = explode(":", $param['id_version'][$key]);
                $id_sort = array();
                foreach ($ex as $k => $row) {
                    $id_sort[$k] = $row;
                }
                array_multisort($id_sort, SORT_DESC, $ex);
                $_insert_version[] = array(
                    'title_version_1' => $param['title_version_1'][$key],
                    'title_version_2' => !empty($param['title_version_2'][$key]) ? $param['title_version_2'][$key] : '',

                    'productid' => $param['productid'],
                    'title_version' => $val,

                    'id_version' => $param['id_version'][$key],

                    'code_version' => $param['code_version'][$key],
                    'image_version' => !empty($param['image_version'][$key]) ? $param['image_version'][$key] : '',

                    'price_version' => (int)str_replace('.', '', $param['price_version'][$key]),
                    'price_sale_version' => (int)str_replace('.', '', $param['price_sale_version'][$key]),

                    '_stock_status' => $param['_stock_status'][$key],
                    '_stock' => $param['_stock'][$key],
                    '_outstock_status' => $param['_outstock_status'][$key],

                    'id_sort' => json_encode($id_sort),

                    'created_at' => Carbon::now(),
                    'userid_created' => Auth::user()->id,
                );
            }
        }
        //thuc hien groupBy id_version
        $tmpArr = [];
        if (!empty($_insert_version)) {
            foreach ($_insert_version as $key => $item) {
                $tmpArr[$item['title_version_1']]['title'] = $item['title_version_1'];
                $tmpArr[$item['title_version_1']]['children'][$key] = $item;
            }
            ksort($tmpArr, SORT_NUMERIC);
            array_values($tmpArr);
        }
        //done groupBy id_version => getname
        $productVersionArr = [];
        if (isset($tmpArr) && is_array($tmpArr) && count($tmpArr)) {
            foreach ($tmpArr as $key => $value) {
                $tmp_status[$key] = [];
                $totalStock = 0;
                $addOneID = \App\Models\products_color::insertGetId([
                    'title' => $value['title'],
                    'product_id' => $param['productid'],
                    'stock' => 0,
                    'userid_created' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                if (isset($value['children']) && is_array($value['children']) && count($value['children'])) {
                    // echo "<pre>";var_dump(array_values($value['children']));
                    //  array_values($value['children']);
                    foreach ($value['children'] as $keyC => $val) {
                        $totalStock += $val['_stock'];
                        $productVersionArr[] = array(
                            'title_version' => $val['title_version'],
                            'code_version' => $val['code_version'],
                            'image_version' => $val['image_version'],
                            'price_version' => $val['price_version'],
                            'price_sale_version' => $val['price_sale_version'],
                            '_stock_status' => $val['_stock_status'],
                            '_stock' =>  $val['_stock'],
                            '_outstock_status' => $val['_outstock_status'],
                            'id_sort' => $val['id_sort'],
                            'productid' => $val['productid'],
                            'product_color_id' => $addOneID,
                            'userid_created' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                        );
                        //check không quản lý tồn kho và đồng ý đặt hàng khi hết hàng

                        if ($val['_stock_status'] == 0 || $val['_outstock_status'] == 1) {
                            $tmp_status[$key][] = $value['title'] . '/' . $val['title_version'];
                        }
                        //tổng số lượng sản phẩm tồn kho lớn hơn 0
                        if ($totalStock > 0) {
                            $tmp_status[$key][] = $value['title'] . '/' . $val['title_version'];
                        }
                    }
                }

                if (!empty($tmp_status[$key])) {
                    DB::table('products_colors')->where('id', '=', $addOneID)->update([
                        'stock' => 1,
                    ]);
                }
            }
        }
        //thực hiện thêm vào bảng products_versions
        if (!empty($productVersionArr)) {
            DB::table('products_versions')->insert($productVersionArr);
        }
    }
    //thêm vào bảng table_relationship: brand, tag,...
    function _table_relation_ship($productid = 0, $moduleid = [], $table = '', $rowname = '', $module = '')
    {
        $_insert = [];
        if (isset($moduleid) && is_array($moduleid) && count($moduleid) && $moduleid != array('0' => 0)) {
            foreach ($moduleid as $val) {
                if (isset($val) && is_array($val) && count($val) && $val != array('0' => 0)) {
                    foreach ($val as $subs) {
                        $_insert[] = array(
                            'moduleid' => $productid,
                            $rowname => $subs,
                            'module' => $module,
                            'created_at' => Carbon::now(),
                            'userid_created' => Auth::user()->id,
                        );
                    }
                } else {
                    $_insert[] = array(
                        'moduleid' => $productid,
                        $rowname   => $val,
                        'module' => $module,
                        'created_at' => Carbon::now(),
                        'userid_created' => Auth::user()->id,
                    );
                }
            }
            if (check_array($_insert)) {
                DB::table($table . '_relationships')->insert($_insert);
            }
        }
    }
    //thêm giá của sản phẩm vào khoảng giá của bộ lọc
    function price_attributes($price = 0, $productid = 0)
    {
        $attributes = DB::table('attributes')->where('catalogueid', 1)->where('price_start', '<=', $price)->where('price_end', '>=', $price)->first();
        if (empty($attributes)) {
            $attributes = DB::table('attributes')->where('catalogueid', 1)->where('price_end', 0)->first();
        }
        if (!empty($attributes)) {
            DB::table('attributes_relationships')->insert(array(
                'moduleid' => $productid,
                'attrid' => $attributes->id,
                'created_at' => Carbon::now(),
            ));
        }
    }
}
