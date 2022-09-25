<?php
namespace App\Components;

use App\Models\Catalogues_relationships;
use App\Models\Coupon as ModelsCoupon;
use Session;
class Coupon{
	public function getCoupon($name = '',$check = TRUE,$priceShipping = 0){
        $cart = Session::get('cart');
        $coupon = Session::get('coupon');
        $total = 0;
        $total_items = 0;
        if ($cart) {
            foreach ($cart as $v) {
                $total += $v['price'] * $v['quantity'];
                $total_items += $v['quantity'];
            }
        }
        $detail = ModelsCoupon::where('name', '=', $name)->where('publish','=', 0)->where('deleted_at','0000-00-00 00:00:00')->first();
        /*lấy session coupon đã được lưu*/
        $alert = array(
            'error' => '',
            'html' => '',
            'message' => '',
            'price' => 0,
            'total' =>  $total
        );
        if($check == TRUE){
            if (!empty($detail)) {
                if (!empty($coupon)) {
                    if ($detail->individual_use == 1) {
                        $alert['error'] = 'Mã ưu đãi không được sử dụng cùng với những mã ưu đãi khác !';
                    } else if ($detail->individual_use == 0) {
                        foreach ($coupon as $v) {
                            if ($v['id'] == $detail->id) {
                                $alert['error'] = 'Mã ưu đãi đang được sử dụng';
                            }
                            if ($v['individual_use'] == 1) {
                                $alert['error'] = 'Mã ưu đãi không được sử dụng cùng với những mã ưu đãi khác';
                            }
                        }
                    }
                }
            }else{
                $alert['error'] = "Mã giảm giá $name không tồn tại!";
            }
        }
        if (!empty($detail)) {
            /*check ngày hết hạn*/
            if (!empty($detail['expiry_date'])) {
                $date = gmdate('Y-m-d H:i:s', time() + 7 * 3600 + 180);
                $date_start = $detail['date_start'];
                $date_end = $detail['date_end'];
                if ($date > $date_end || $date < $date_start) {
                    $alert['error'] = 'Mã ưu đãi áp dụng trong khoảng thời gian từ ' . $date_start . ' đến ' . $date_end . '';
                }
            }
            /*check giá trị đơn hàng tối thiểu*/
            if (!empty($detail['min_price'])) {
                if ($total < $detail['min_price']) {
                    $alert['error'] = 'Mã ưu đãi áp dụng cho đơn hàng có giá trị tối thiểu là ' . str_replace(',', '.', number_format($detail['min_price'])) . ' VNĐ.';
                }
            }
            /*check giá trị đơn hàng tối đa*/
            if (!empty($detail['max_price'])) {
                if ($total > $detail['max_price']) {
                    $alert['error'] = 'Mã ưu đãi áp dụng cho đơn hàng có giá trị tối đa là ' . str_replace(',', '.', number_format($detail['max_price'])) . ' VNĐ.';
                }
            }
            /*check số lượng giỏ hàng tối thiểu*/
            if (!empty($detail['min_count'])) {
                if ($total_items < $detail['min_count']) {
                    $alert['error'] = 'Mã ưu đãi áp dụng cho đơn hàng có số lượng tối thiểu là ' . $detail['min_count'] . ' sản phẩm';
                }
            }
            /*check số lượng giỏ hàng tối đa*/
            if (!empty($detail['max_count'])) {
                if ($total_items > $detail->max_count) {
                    $alert['error'] = 'Mã ưu đãi áp dụng cho đơn hàng có số lượng tối đa là ' . $detail->max_count . ' sản phẩm';
                }
            }
            /*Nếu có giới hạn số lần sử dụng mã*/
            if (!empty($detail['limit'])) {
                $limit = $detail->coupon_relationship()->count();
                if ($limit >= $detail->limit) {
                    $alert['error'] = 'Số lần sử dụng mã ưu đãi đã hết';
                }
            }
            /* Kiểm tra mã code áp dụng cho trường hợp nào*/
            if ($detail['type'] == 'fixed_percent' || $detail['type'] == 'fixed_money') {
                /*Giảm giá phần trăm sản phẩm có trong giỏ hàng*/
                $price = 0;
                $tmp_productid = $tmp_diff = [];
                /*array diff*/
                if (!empty($detail['exclude_product_categories']) && $detail['exclude_product_categories'] != 'null') {
                    $exclude_product_categories = json_decode($detail['exclude_product_categories']);
                    $Catalogues_relationships_diff = Catalogues_relationships::where('module', 'product')->whereIn('catalogueid', $exclude_product_categories)->groupBy('moduleid')->get();

                    if (isset($Catalogues_relationships_diff)) {
                        foreach ($Catalogues_relationships_diff as $v) {
                            $tmp_diff[] = (string)$v->moduleid;
                        }
                    }
                }
                if (!empty($detail['exclude_product_ids']) && $detail['exclude_product_ids'] != 'null') {
                    $arr_exclude_product_ids  = json_decode($detail['exclude_product_ids']);
                    /*gộp mảng*/
                    $tmp_diff = array_merge($tmp_diff, $arr_exclude_product_ids);
                    /*loại bỏ phần tử có trong mảng*/
                    $tmp_diff = array_unique($tmp_diff);
                }
                if (!empty($detail['product_categories']) && $detail['product_categories'] != 'null') {
                    $product_categories = json_decode($detail['product_categories']);
                    $Catalogues_relationships = Catalogues_relationships::where('module', 'product')->whereIn('catalogueid', $product_categories)->groupBy('moduleid')->get();

                    if (isset($Catalogues_relationships)) {
                        foreach ($Catalogues_relationships as $v) {
                            $tmp_productid[] = (string)$v->moduleid;
                        }
                    }
                }
                if (!empty($detail['product_ids']) && $detail['product_ids'] != 'null') {
                    $arr_product_ids  = json_decode($detail['product_ids']);
                    /*gộp mảng*/
                    $tmp_productid = array_merge($tmp_productid, $arr_product_ids);
                    /*loại bỏ phần tử có trong mảng*/
                    $tmp_productid = array_unique($tmp_productid);
                }
                if (isset($tmp_diff)) {
                    $tmp_productid = array_diff($tmp_productid, $tmp_diff);
                }
                if ($cart) {
                    if (!empty($tmp_productid)) {
                        foreach ($cart as $v) {
                            /*nếu id sản phẩm trong giỏ hàng có trong mảng khuyến mại*/
                            if (in_array($v['id'], $tmp_productid)) {
                                if ($detail['type'] == 'fixed_percent') {
                                    $price += ($v['price'] * $v['quantity']) / 100 * $detail['value'];
                                } else if ($detail['type'] == 'fixed_money') {
                                    $price += $v['quantity'] * $detail['value'];
                                }
                            }
                        }
                    } else {
                        if (!empty($tmp_diff)) {
                            foreach ($cart as $v) {
                                if (!in_array($v['id'], $tmp_diff)) {
                                    if ($detail['type'] == 'fixed_percent') {
                                        $price += ($v['price'] * $v['quantity']) / 100 * $detail['value'];
                                    } else if ($detail['type'] == 'fixed_money') {
                                        $price += $v['quantity'] * $detail['value'];
                                    }
                                }
                            }
                        } else {
                            foreach ($cart as $v) {
                                if ($detail['type'] == 'fixed_percent') {
                                    $price += ($v['price'] * $v['quantity']) / 100 * $detail['value'];
                                } else if ($detail['type'] == 'fixed_money') {
                                    $price += $v['quantity'] * $detail['value'];
                                }
                            }
                        }
                    }
                }
                if ($price == 0) {
                    $alert['error'] = 'Xin lỗi, mã ưu đãi này không áp dụng cho các sản phẩm đã chọn.';
                } else {
                    $alert['price'] = $price;
                    $alert['message'] = 'Mã ưu đãi đã được áp dụng thành công.';
                }
            } else if ($detail['type'] == 'fixed_cart_percent' || $detail['type'] == 'fixed_cart_money') {
                /*Giảm giá phần trăm giỏ hàng cố định hoặc phần trăm giỏ hàng cố định*/
                if ($total > 0) {
                    if ($detail['type'] == 'fixed_cart_percent') {
                        $price = $total / 100 * $detail['value'];
                    } else if ($detail['type'] == 'fixed_cart_money') {
                        $price = $detail['value'];
                    }
                    $alert['price'] = $price;
                    $alert['message'] = 'Mã ưu đãi đã được áp dụng thành công.';
                } else {
                    $alert['error'] = "Mã giảm giá $name không tồn tại!";
                }
            } else {
                $alert['error'] = "Mã giảm giá $name không tồn tại!";
            }
        } else {
            $alert['error'] = "Mã giảm giá $name không tồn tại!";
        }
        /*kết thúc add mã giảm giá tồn tại price coupon > 0*/
        if ($alert['error'] == '' && $price > 0) {
            /*update*/
            $coupon[$detail['id']] = [
                "id" => $detail['id'],
                "name" => $detail['name'],
                "individual_use" => $detail['individual_use'],
                'price' => $price
            ];
            // Session::forget('coupon');
            Session::put('coupon', $coupon);
            Session::save();
        }else if($alert['error'] != '' && $alert['error'] != "Mã ưu đãi đang được sử dụng" && $alert['error'] != "Mã ưu đãi không được sử dụng cùng với những mã ưu đãi khác !"){
            /*update giỏ hàng nếu có sự thay đổi mã giảm giá: sản phẩm,danh mục,....*/
            if(!empty($coupon)){
                unset($coupon[$detail['id']]);
                Session::put('coupon', $coupon);
                Session::save();
            }
        }
        //return
        $price_counpon = 0;
        $html = '';
        if (!empty($coupon)) {
            foreach ($coupon as $v) {
                $price_counpon += $v['price'];
                $html .= '<table><tr>
                    <th>Mã giảm giá : <span class="cart-coupon-name">' . $v['name'] . '</span></th>
                    <td>-<span class="amount cart-coupon-price">' . number_format($v['price']) . ' VNĐ</span> <a href="javascript:void(0)" data-id="' . $v['id'] . '" class="remove-coupon text-red-600 font-bold">[Xóa]</a></td>
                </tr> </table>';
            }
        }

        $alert['price'] = $price_counpon;
        $alert['html'] = $html;
        $alert['total'] = number_format($total + $priceShipping - $price_counpon) . ' VNĐ';

        return $alert;
	}
}
