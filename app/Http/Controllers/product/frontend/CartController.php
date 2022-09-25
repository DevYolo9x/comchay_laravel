<?php

namespace App\Http\Controllers\product\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Products_version;
use Illuminate\Support\Facades\DB;
use Session;
use App\Components\Coupon as CouponHelper;
use App\Components\System;

class CartController extends Controller
{
    protected $coupon;
    public function __construct()
    {
        $this->coupon = new CouponHelper();
        $this->system = new System();
    }
    //trang giỏ hàng
    public function index()
    {
        $cartController = Session::get('cart');
        $coupon = Session::get('coupon');
        //page: giỏ hàng
        $page = Page::where('page', 'cart_index')->select('meta_title', 'meta_description', 'image', 'title')->first();
        $seo['canonical'] = route('cart.index');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();

        return view('cart.index', compact('page', 'seo', 'fcSystem', 'cartController', 'coupon'));
    }
    //trang checkout
    public function checkout()
    {
        $cartController = Session::get('cart');
        if (!isset($cartController)) {
            return redirect()->route('homepage.index')->with('error', "Có lỗi xảy ra");
        }
        $coupon = Session::get('coupon');
        $getCity = DB::table('vn_province')->orderBy('name', 'asc')->get();
        $listCity['0'] = 'Tỉnh/Thành Phố';
        if (isset($getCity)) {
            foreach ($getCity as $key => $val) {
                $listCity[$val->provinceid] = $val->name;
            }
        }
        // Session::forget('coupon');
        // Session::save();
        $detail = Page::find(4);
        //page: giỏ hàng
        $page = Page::where('page', 'cart_checkout')->select('meta_title', 'meta_description', 'image', 'title')->first();
        $seo['canonical'] = route('cart.checkout');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('cart.checkout', compact('page', 'seo', 'fcSystem', 'cartController', 'coupon', 'listCity'));
    }
    //trang thanh toán thành công
    public function success($id)
    {
        if (empty($id)) {
            return redirect()->route('homepage.index')->with('error', "Có lỗi xảy ra");
        }
        $detail = Order::find($id);
        if (!isset($detail)) {
            return redirect()->route('homepage.index')->with('error', "Có lỗi xảy ra");
        }
        //xóa giỏ hàng
        Session::forget('cart');
        Session::forget('coupon');
        //xóa coupon
        Session::save();
        //page: đặt hàng thành công
        $page = Page::where('page', 'cart_success')->select('meta_title', 'meta_description', 'image', 'title')->first();
        $seo['canonical'] = route('cart.checkout');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('cart.success', compact('page', 'fcSystem', 'seo', 'detail'));
    }
    public function getLocation(Request $request)
    {
        $param = $request->param;
        $getData = DB::table($param['table'])->where('provinceid', $param['parentid'])->orderBy('name', 'asc')->get();
        $temp = '';
        $temp = $temp . '<option value="0">' . $param['text'] . '</option>';
        if (isset($getData)) {
            foreach ($getData as  $val) {
                $temp = $temp . '<option value="' . $val->districtid . '">' . $val->name . '</option>';
            }
        }
        echo json_encode(array(
            'html' => $temp,
        ));
        die();
    }
    //add to cart ajax
    public function addtocart(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => 'Sản phẩm được thêm vào giỏ hàng thành công!',
            'total' => 0,
            'total_coupon' => 0,
            'total_items' => 0,
            'coupon_price' => 0
        );
        $id = $request->id;
        $price = $request->price;
        $title_version = $request->title_version;
        // $id_version = $request->id_version;
        $product = Product::select('id', 'title', 'slug', 'price', 'price_sale', 'price_contact', 'inventory', 'inventoryPolicy', 'inventoryQuantity', 'catalogue_id', 'image')->find($id);
        if (!$product) {
            $alert['error'] = 'Sản phẩm không tồn tại';
        }
        //Lấy giá nếu tồn tại product version
        /*
        $getVersionproduct = Products_version::select('title_version', 'price_version', 'id_sort')->where('productid', $id)->where('id_sort', $id_version)->first();
        if (!empty($getVersionproduct)) {
            $price = $getVersionproduct->price_version;
        } else {
            $price = getPrice(array('price' => $product->price, 'price_sale' => $product->price_sale, 'price_contact' => $product->price_contact));
            $price = $price['price_final_none_format'];
        }
        $title_version = !empty($getVersionproduct->title_version) ? $getVersionproduct->title_version : '';
        */
        // Session::forget('cart');die;
        //START: check tồn kho => products_versions
        if ($request->type == 'variable') {
            $getVersionproduct = Products_version::select('id', '_stock_status', '_stock', '_outstock_status')->where('productid', $id)->where('title_version', $request->title_version)->first();
            if (!$getVersionproduct) {
                $alert['error'] = 'Phiên bản sản phẩm không tồn tại';
            }
            if ($getVersionproduct['_stock_status'] == 1) {
                if ($getVersionproduct['_outstock_status']  == 0) {
                    if ($request->quantity > $getVersionproduct['_stock']) {
                        $alert['error'] = 'Hết hàng';
                        echo json_encode($alert);
                        die();
                    }
                }
            }
        } else if ($request->type == 'simple') {
            if ($product->inventory == 1) {
                if ($product->inventoryPolicy  == 0) {
                    if ($request->quantity > $product->inventoryQuantity) {
                        $alert['error'] = 'Hết hàng';
                        echo json_encode($alert);
                        die();
                    }
                }
            }
        }

        //END: check tồn kho
        $cart = Session::get('cart');
        //tạo rowid
        $rowid = md5($product->id . $title_version);
        if (isset($cart[$rowid])) {
            $quantity = $cart[$rowid]['quantity'] + $request->quantity;
            if ($request->type == 'variable') {
                $getVersionproduct = Products_version::select('id', '_stock_status', '_stock', '_outstock_status')->where('productid', $id)->where('title_version', $request->title_version)->first();
                if (!$getVersionproduct) {
                    $alert['error'] = 'Phiên bản sản phẩm không tồn tại';
                }
                if ($getVersionproduct['_stock_status'] == 1) {
                    if ($getVersionproduct['_outstock_status']  == 0) {
                        if ($quantity > $getVersionproduct['_stock']) {
                            $alert['error'] = 'Hết hàng';
                            echo json_encode($alert);
                            die();
                        }
                    }
                }
            } else if ($request->type == 'simple') {
                if ($product->inventory == 1) {
                    if ($product->inventoryPolicy  == 0) {
                        if ($quantity > $product->inventoryQuantity) {
                            $alert['error'] = 'Hết hàng';
                            echo json_encode($alert);
                            die();
                        }
                    }
                }
            }
            $cart[$rowid]['quantity'] =  $quantity;
        } else {
            $cart[$rowid] = [
                "id" => $product->id,
                "title" => $product->title,
                "slug" => $product->slug,
                "image" => !empty($request->image) ? $request->image : $product->image,
                "quantity" => $request->quantity,
                "price" => $price,
                "options" => $title_version,
            ];
        }
        Session::put('cart', $cart);
        Session::save();
        // dd(Session::all());die;
        $getUpdateCart = $this->getUpdateCart($cart, $alert);
        $alert['total'] = !empty($getUpdateCart['total']) ? $getUpdateCart['total'] : 0;
        $alert['total_items'] = !empty($getUpdateCart['total_items']) ? $getUpdateCart['total_items'] : 0;
        $alert['total_coupon'] = !empty($getUpdateCart['total_coupon']) ? $getUpdateCart['total_coupon'] : 0;
        $alert['html_header'] = !empty($getUpdateCart['html_header']) ? $getUpdateCart['html_header'] : '';
        echo json_encode($alert);
        die();
    }
    //update: tăng giảm số lương, xóa giỏ hàng
    public function updatecart(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => '',
            'html' => '',
            'total' => 0,
            'total_coupon' => 0,
            'total_items' => 0,
            'coupon_price' => 0
        );
        $cart = Session::get('cart');
        if ($request->type == 'update') {
            if ($request->rowid and $request->quantity) {
                //check tồn kho
                if (!empty($cart[$request->rowid]["options"])) {
                    $getVersionproduct = Products_version::select('id', '_stock_status', '_stock', '_outstock_status')->where('productid', $cart[$request->rowid]["id"])->where('title_version',  $cart[$request->rowid]["options"])->first();
                    if (!$getVersionproduct) {
                        $alert['error'] = 'Phiên bản sản phẩm không tồn tại';
                    }
                    if ($getVersionproduct['_stock_status'] == 1) {
                        if ($getVersionproduct['_outstock_status']  == 0) {
                            if ($request->quantity > $getVersionproduct['_stock']) {
                                $alert['error'] = 'Hết hàng';
                                echo json_encode($alert);
                                die();
                            }
                        }
                    }
                } else {
                    $product = Product::select('inventory', 'inventoryPolicy', 'inventoryQuantity')->find($cart[$request->rowid]['id']);
                    if ($product['inventory'] == 1) {
                        if ($product['inventoryPolicy']  == 0) {
                            if ($request->quantity > $product['inventoryQuantity']) {
                                $alert['error'] = 'Hết hàng';
                                echo json_encode($alert);
                                die();
                            }
                        }
                    }
                }
                //end
                $cart[$request->rowid]["quantity"] = $request->quantity;
                //return
                $alert = $this->getUpdateCart($cart, $alert);
            } else {
                $alert['error'] = "Cập nhập giỏ hàng không thành công";
            }
        } else if ($request->type == 'delete') {
            if ($request->rowid) {
                if (isset($cart[$request->rowid])) {
                    unset($cart[$request->rowid]);
                    //return
                    $alert = $this->getUpdateCart($cart, $alert);
                } else {
                    $alert['error'] = "Xóa giỏ hàng không thành công";
                }
            } else {
                $alert['error'] = "Xóa giỏ hàng không thành công";
            }
        } else {
            $alert['error'] = "Có lỗi xảy ra";
        }
        echo json_encode($alert);
        die();
    }
    //ajax thêm mã giảm giá
    public function addcounpon(Request $request)
    {

        $name = $request->name;
        $priceShipping = $request->priceShipping;
        if (!empty($name)) {
            $alert = $this->coupon->getCoupon($name, TRUE);
        } else {
            $alert['error'] = "Mã khuyến mại không được để trống";
        }
        echo json_encode($alert);
        die();
    }
    //ajax xóa mã giảm giá
    public function deletecoupon(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => '',
            'price' => 0,
            'total' =>  0
        );
        $id  = $request->id;
        $priceShipping  = $request->priceShipping;
        $cart = Session::get('cart');
        $total = 0;
        if ($cart) {
            foreach ($cart as $v) {
                $total += $v['price'] * $v['quantity'];
            }
        }
        $coupon = Session::get('coupon');
        if (!in_array($id, array_keys($coupon))) {
            $alert['error'] = "Mã giảm giá không tồn tại";
        } else {
            unset($coupon[$id]);
            Session::put('coupon', $coupon);
            Session::save();
            //return
            $price_counpon = 0;
            $html = '';
            if (isset($coupon)) {
                foreach ($coupon as $v) {
                    $price_counpon += $v['price'];
                    $html .= '<tr>
                        <th>Mã giảm giá : <span class="cart-coupon-name">' . $v['name'] . '</span></th>
                        <td>-<span class="amount cart-coupon-price">' . number_format($v['price']) . ' VNĐ</span> <a href="" data-id="' . $v['id'] . '" class="remove-coupon">[Xóa]</a></td>
                    </tr>';
                }
            }
            $alert['price'] = $price_counpon;
            $alert['html'] = $html;
            $alert['total'] = number_format($total + $priceShipping - $price_counpon) . ' VNĐ';
            $alert['message'] = "Xóa mã giảm giá thành công";
        }
        echo json_encode($alert);
    }
    //cập nhập lại toàn bộ giỏ hàng nếu add coupon
    public function getUpdateCart($cart = [], $alert = [])
    {
        $coupon = Session::get('coupon');
        $html = $html_header =  '';
        Session::put('cart', $cart);
        Session::save();
        $total = 0;
        $total_items = 0;
        if ($cart) {
            foreach ($cart as $k => $v) {
                $total += $v['price'] * $v['quantity'];
                $total_items += $v['quantity'];
                $html .= htmlItemCart($k, $v);
                $html_header .= htmlItemCartHeader($k, $v);
            }
            //nếu tồn tại mã giảm giá thì tính toán lại
            $coupon_price = 0;
            $coupon_html = '';
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $this->coupon->getCoupon($v['name'], FALSE);
                }
            }
            $coupon = Session::get('coupon');
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $coupon_price += $v['price'];
                    $coupon_html .= '<tr>
                        <th>Mã giảm giá : <span class="cart-coupon-name">' . $v['name'] . '</span></th>
                        <td>-<span class="amount cart-coupon-price">' . number_format($v['price']) . ' VNĐ</span> <a href="" data-id="' . $v['id'] . '" class="remove-coupon">[Xóa]</a></td>
                    </tr>';
                }
            }
            //end
            $alert['html'] = $html;
            $alert['html_header'] = $html_header;
            $alert['message'] = 'Cập nhập sản phẩm!';
            $alert['total'] = $total;
            $alert['total_coupon'] = $total - $coupon_price;
            $alert['total_items'] = $total_items;
            $alert['coupon_price'] = $coupon_price;
            $alert['coupon_html'] = $coupon_html;
        }
        return $alert;
    }
}
