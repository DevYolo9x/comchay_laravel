<?php

namespace App\Http\Controllers\order\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Components\Coupon as CouponHelper;
use App\Components\System;
use App\Models\Coupon;
use App\Models\Coupon_relationship;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $coupon;
    public function __construct()
    {
        $this->coupon = new CouponHelper();
        $this->system = new System();
    }
    public function order(Request $request)
    {
        $cart = Session::get('cart');
        //thuc hien check ton kho
        $arrStock = [];
        if (isset($cart)) {
            foreach ($cart as $key => $value) {
                if (!empty($value['options'])) {
                    $getVersionproduct = \App\Models\Products_version::select('id', '_stock_status', '_stock', '_outstock_status')->where('productid', $value["id"])->where('title_version',  $value["options"])->first();
                    //quản lý kho hàng - không cho đặt hàng khi hết hàng - số lượng bằng 0
                    if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0 && $getVersionproduct['_stock'] == 0) {
                        array_push($arrStock, 'Sản phẩm ' . $value['title'] . '-' . $value['options'] . ' đã hết hàng');
                    }
                } else {
                    $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->find($value["id"]);
                    if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0 && $product['inventoryQuantity'] == 0) {
                        array_push($arrStock, 'Sản phẩm ' . $value['title'] . ' đã hết hàng');
                    }
                }
            }
        }
        if (!empty($arrStock)) {
            return Redirect::route('cart.checkout')->with('errorStock', $arrStock);
        }
        //endif
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'cityid' => 'required',
            'districtid' => 'required',
        ], [
            'fullname.required' => 'Họ và tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'cityid.required' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'districtid.required' => 'Quận/Huyện là trường bắt buộc.',
        ]);
        $payment = $request->payment;
        $total_price_ship = $request->total_price_ship;
        $total = $total_item = $total_price_coupon = 0;
        $coupon = Session::get('coupon');
        //check giảm giá theo user
        if (!empty($coupon)) {
            //lấy những mã giảm giá giới hạn số lượng
            $checkuser = Coupon::whereIn('id', array_keys($coupon))->where('limit_user', '!=', NULL)->select('id', 'name', 'limit_user')->get();
            if ($checkuser->count() > 0) {
                foreach ($checkuser as $v) {
                    // $tmp_checkuser[] = $v->coupon_relationship_one->orderid;
                    $getEmail = DB::table('coupons_relationships')->where('couponid', $v->id)->where('email', $request->email)->count();
                    if ($getEmail >= $v['limit_user']) {
                        return Redirect::route('cart.checkout')->with('error', "Mã giảm giá $v->name đã được sử dụng cho lần mua hàng trước");
                    }
                }
            }
        }
        //end
        if ($cart) {
            foreach ($cart as $v) {
                $total += $v['price'] * $v['quantity'];
                $total_item +=  $v['quantity'];
            }
            //nếu tồn tại mã giảm giá thì tính toán lại
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $this->coupon->getCoupon($v['name'], FALSE);
                }
            }
            $coupon = Session::get('coupon');
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $total_price_coupon += $v['price'];
                }
            }
            //end
        }
        //lưu thông tin khách hàng vào session
        $_data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'cityid' => $request->cityid,
            'districtid' => $request->districtid,
            'note' => $request->note,
            'payment' => $request->payment,
            'cart' => !empty($cart) ? json_encode($cart) : '',
            'coupon' => !empty($coupon) ? json_encode($coupon) : '',
            'total_price' => $total,
            'total_item' => $total_item,
            'total_price_coupon' => $total_price_coupon,
            'total_price_ship' => $total_price_ship,
            'status' => 'pending',
            'customerid' => !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : 0,
            'created_at' => Carbon::now(),
        ];
        Session::put('orderinfo', $_data);
        Session::save();
        $amount = (int)$total + (int)$total_price_ship - $total_price_coupon;
        $orderid = $this->saveOrder();
        return redirect()->route('cart.success', $orderid)->with('error', "Đặt hàng thành công");

        /*if ($payment == 'COD' || $payment == 'BANKING') {
            //thực hiện lưu vào bảng order
            $orderid = $this->saveOrder();
            return redirect()->route('cart.success',$orderid)->with('error', "Đặt hàng thành công");

        } else if ($payment == 'MOMO') {
            if ($request->payment_type_momo) {
                $jsonResult = $this->momo_create($amount, $request->payment_type_momo);
            } else {
                return Redirect::route('cart.checkout')->with('error', "Có lỗi xảy ra");
            }
            if (!empty($jsonResult)) {
                if ($jsonResult['errorCode'] == 0) {
                    return Redirect::to($jsonResult['payUrl']);
                } else {
                    return Redirect::route('cart.checkout')->with('error', $jsonResult['localMessage']);
                }
            } else {
                return Redirect::route('cart.checkout')->with('error', "Có lỗi xảy ra");
            }
        } else if ($payment == 'VNPAY') {
            $jsonResult = $this->vnpay_create($amount);
            return Redirect::to($jsonResult['data']);
        } */
    }
    //vnpay
    public function vnpay_create($amount = 0)
    {

        $info_session =  Session::get('orderinfo');
        $vnp_TmnCode = "IC90F17B"; //Website ID in VNPAY System
        $vnp_HashSecret = "LGFCHRKZAKXJDAHXROOSVFCRIZMPIABG"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.result');

        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        //data gửi đi
        $vnp_TxnRef =  'VNPAY' . time() . ""; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán qua vnpay';
        $vnp_OrderType = 'other';
        $vnp_Amount = $amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $expire;
        //Billing
        $vnp_Bill_Mobile = $info_session['phone'];
        $vnp_Bill_Email = $info_session['email'];
        $fullName = trim($info_session['fullname']);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_City =  $info_session['cityid'];
        $vnp_Bill_Country = "VN";

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_City" => $vnp_Bill_City,
            "vnp_Bill_Country" => $vnp_Bill_Country,

        );
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        return $returnData;
    }
    public function vnpay_result(Request $request)
    {
        $vnp_HashSecret = "LGFCHRKZAKXJDAHXROOSVFCRIZMPIABG"; //Secret key
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                //lưu thông tin trả về vào bảng orders_payment
                $order_id = $this->saveOrder();
                //luu thong tin vao bang orders_momo
                DB::table('orders_payment')->insert([
                    'order_id' => $order_id,
                    'transId' => $request->vnp_TransactionNo,
                    'json' => json_encode($request->query()),
                    'status' => 0,
                    'type' => 'VNPAY',
                    "created_at" => Carbon::now(),
                ]);
                return redirect()->route('cart.success', $order_id)->with('error', "Đặt hàng thành công");
            } else {
                return Redirect::route('cart.checkout')->with('error', "Giao dịch không thành công");
            }
        } else {
            return Redirect::route('cart.checkout')->with('error', "Chữ ký không hợp lệ");
        }
    }
    public function vnpay_ipn(Request $request)
    {

        $vnp_HashSecret = "LGFCHRKZAKXJDAHXROOSVFCRIZMPIABG"; //Secret key

        $inputData = array();
        $returnData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi
        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);
                $order = DB::table('orders_payment')->where('transId', $vnpTranId)->first();
                if ($order != NULL) {
                    $jsonOrder = json_decode($order->json, TRUE);
                    $order_Amount = $jsonOrder['vnp_Amount'] / 100;

                    if ($order_Amount == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        if ($order->status != NULL && $order->status == 0) {
                            if ($request->vnp_ResponseCode == '00' || $request->vnp_TransactionStatus == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            DB::table('orders_payment')->where('transId',  $order->transId)->update([
                                'status' => $Status,
                                "updated_at" => Carbon::now(),
                            ]);
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        echo json_encode($returnData);
    }
    //momo
    public function momo_create($amount = 0, $type = "")
    {
        $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $serectKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';


        $orderInfo = "Thanh toán qua MoMo";
        $amount = "$amount";
        $orderId = 'MOMO' . time() . "";
        $extraData = "";
        $returnUrl = route('momo.result');
        $notifyurl =  route('momo.ipn');
        $requestId = time() . "";
        $bankCode = "SML";
        if ($type == "MOMOATM") {
            $requestType = "payWithMoMoATM";
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&bankCode=" . $bankCode . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData . "&requestType=" . $requestType;
        } else if ($type = "MOMOQRCode") {
            $requestType = "captureMoMoWallet";
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
        }

        $signature = hash_hmac("sha256", $rawHash, $serectKey);

        $data =  array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'bankCode' => $bankCode,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        return $jsonResult;
    }
    public function momo_result(Request $request)
    {
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $serectKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        if ($request->errorCode == 0) {
            $requestId = $request->requestId;
            $amount = $request->amount;
            $orderId = $request->orderId;
            $orderInfo = $request->orderInfo;
            $extraData = "";
            $orderType = $request->orderType;
            $transId =  $request->transId;
            $message = $request->message;
            $localMessage = $request->localMessage;
            $responseTime = $request->responseTime;
            $errorCode = $request->errorCode;
            $payType = $request->payType;
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
                "&payType=" . $payType . "&extraData=" . $extraData;
            $signature = hash_hmac("sha256", $rawHash, $serectKey);
            if ($signature == $request->signature) {
                if ($errorCode == '0') {
                    //lưu thông tin trả về vào bảng orders_payment
                    $order_id = $this->saveOrder();
                    //luu thong tin vao bang orders_momo
                    DB::table('orders_payment')->insert([
                        'order_id' => $order_id,
                        'transId' => $request->transId,
                        'json' => json_encode($request->query()),
                        'status' => 0,
                        'type' => 'MOMO',
                        "created_at" => Carbon::now(),
                    ]);
                    return redirect()->route('cart.success', $order_id)->with('error', "Đặt hàng thành công");
                } else {
                    return Redirect::route('cart.checkout')->with('error',  $message . '/' . $localMessage);
                }
            } else {
                return Redirect::route('cart.checkout')->with('error', "This transaction could be hacked, please check your signature and returned signature");
            }
        } else {
            return redirect()->route('cart.checkout')->with('error', "Giao dịch bị hủy bỏ");
        }
    }
    public function momo_ipn(Request $request)
    {

        $partnerCode = $request->partnerCode;
        $accessKey = $request->accessKey;
        $serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderId = $request->orderId;
        $localMessage = $request->localMessage;
        $message = $request->message;
        $transId = $request->transId;
        $orderInfo = $request->orderInfo;
        $amount = $request->amount;
        $errorCode = $request->errorCode;
        $responseTime = $request->responseTime;
        $requestId = $request->requestId;
        $extraData = $request->extraData;
        $payType = $request->payType;
        $orderType = $request->orderType;
        $extraData = $request->extraData;
        $m2signature = $request->signature; //MoMo signature
        //Checksum
        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
            "&payType=" . $payType . "&extraData=" . $extraData;
        $partnerSignature = hash_hmac("sha256", $rawHash, $serectkey);
        $debugger = array();
        $debugger['rawData'] = $rawHash;
        $debugger['momoSignature'] = $m2signature;
        $debugger['partnerSignature'] = $partnerSignature;
        if ($m2signature == $partnerSignature) {
            if ($errorCode == '0') {
                //cap nhap du lieu dua vao transId(Mã giao dịch của MoMo)  orders_momo
                $response['message'] = "Capture Payment Success";
                DB::table('orders_payment')->where('transId', $request->transId)->update([
                    'status' => 1,
                    "updated_at" => Carbon::now(),
                ]);
            } else {
                $response['message'] =  $message;
            }
            $response['message'] = "Received payment result success";
        } else {
            $response['message'] = "ERROR! Fail checksum";
        }
        $response['debugger'] = $debugger;
        echo json_encode($response);
    }
    //lưu thông tin vào database
    public function saveOrder()
    {
        $fcSystem = $this->system->fcSystem();
        $info_session =  Session::get('orderinfo');
        $cart = json_decode($info_session['cart']);
        $id = Order::insertGetId($info_session);
        if ($id > 0) {
            //update mã đơn hàng
            Order::where('id', $id)->update(['code' => 'DH.' . date('m.y') . '.' . $id, 'deleted_at' => '0000-00-00 00:00:00']);
            //lưu bảng order item
            $tmp_orderItem = [];
            $tmp_coupon = [];
            if ($cart) {
                foreach ($cart as $v) {
                    $tmp_orderItem[] = array(
                        "order_id" => $id,
                        "product_id" => $v->id,
                        "product_title" => $v->title,
                        "product_image" => $v->image,
                        "product_quantity" => $v->quantity,
                        "product_price" => $v->price,
                        "product_option" => !empty($v->options) ? $v->options : '',
                        "created_at" => Carbon::now(),
                    );
                }
                DB::table('orders_item')->insert($tmp_orderItem);
            }
            //end
            //lưu vào bảng coupons_relationships
            $coupon = Session::get('coupon');
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $tmp_coupon[] = array(
                        "orderid" => $id,
                        "couponid" => $v['id'],
                        "email" => $info_session['email'],
                        "created_at" => Carbon::now(),
                    );
                }
                DB::table('coupons_relationships')->insert($tmp_coupon);
            }
            //end
            //trừ stock bảng products_version
            if (!empty($tmp_orderItem)) {
                foreach ($tmp_orderItem as $key => $value) {
                    if (!empty($value['product_option'])) {
                        $getVersionproduct = \App\Models\Products_version::select('id', '_stock_status', '_stock', '_outstock_status')->where('productid', $value["product_id"])->where('title_version',  $value["product_option"])->first();
                        if ($getVersionproduct['_stock_status'] == 1) {
                            if ($getVersionproduct['_outstock_status']  == 0) {
                                if ($getVersionproduct['_stock'] > 0) {
                                    DB::table('products_versions')->where('id', $getVersionproduct->id)->update(array(
                                        '_stock' => $getVersionproduct['_stock'] - $value['product_quantity']
                                    ));
                                }
                            }
                        }
                    } else {
                        $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->find($value["product_id"]);
                        if ($product['inventory'] == 1) {
                            if ($product['inventoryPolicy']  == 0) {
                                if ($product['inventoryQuantity'] > 0) {
                                    DB::table('products')->where('id', $product->id)->update(array(
                                        'inventoryQuantity' => $product['inventoryQuantity'] - $value['product_quantity']
                                    ));
                                }
                            }
                        }
                    }
                }
            }
            //end
            //gui email
            $sendMail = array(
                'subject' => 'Thông báo! Đặt hàng thành công',
                'id' => $id,
            );
            Mail::to($fcSystem['contact_email'])->cc($info_session['email'])->send(new \App\Mail\SendMailCart($sendMail));
            //end
        }
        return $id;
    }
}
