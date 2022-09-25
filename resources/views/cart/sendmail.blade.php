<?php
$id = $data['id'];
$detail = \App\Models\Order::find($id);
use App\Components\System;
$system = new System();
$fcSystem = $system->fcSystem();
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" dir="ltr" align="center"
    style="background-color:#fff;font-size:16px">
    <tb>
        <tr>
            <td align="left" valign="top" style="margin:0;padding:0">
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td>
                                <div
                                    style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        THÔNG TIN ĐƠN HÀNG
                                        <a href="javascript:void(0)">
                                            #{{$detail->code}}
                                        </a>
                                        <span style="font-weight:normal">({{$detail->created_at}})</span>
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b>Thông tin tài khoản</b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Tên khách hàng: {{$detail->fullname}}
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Email: <a href="mailto:{{$detail->email}}"
                                                            target="_blank">{{$detail->email}}</a>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Số điện thoại: {{$detail->phone}}
                                                    </p>
                                                </td>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b>Địa chỉ giao hàng</b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Tên khách hàng: {{$detail->fullname}}
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Email: <a href="mailto:{{$detail->email}}"
                                                            target="_blank">{{$detail->email}}</a>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Số điện thoại: {{$detail->phone}}
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        Địa chỉ: {{$detail->address}}
                                                    </p>
                                                    <p>
                                                        Quận/Huyện:
                                                        {{!empty($detail->district_name)?$detail->district_name->name:''}}
                                                    </p>
                                                    <p>
                                                        Tỉnh/Thành Phố:
                                                        {{!empty($detail->city_name)?$detail->city_name->name:''}}
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p style="margin:10px 0">
                                                        <b>Phương thức thanh toán:</b>
                                                        {{config('cart')['payment'][$detail->payment]}}
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php $cart = json_decode($detail->cart, TRUE); ?>
                        <?php $coupon = json_decode($detail->coupon, TRUE); ?>
                        <tr>
                            <td>
                                <div
                                    style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        CHI TIẾT ĐƠN HÀNG
                                    </p>
                                    <table class="m_-8304563403915632023table" cellpadding="0" cellspacing="0"
                                        border="0" width="100%" style="font-size:14px">
                                        <thead>
                                            <tr>
                                                <th width="150px" style="text-align:left">Tên sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th width="150px">Giá bán</th>
                                                <th style="text-align:right">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($cart)
                                            @foreach( $cart as $k=>$v)
                                            <?php
                                                $slug = !empty($v['slug']) ? route('routerURL',['slug' => $v['slug']]) : 'javascript:void(0)';
                                                $options = !empty($v['options']) ? $v['options'] : '';
                                                ?>
                                            <tr>
                                                <td style="text-align:left">
                                                    <p style="margin:5px 0 0">
                                                        <a href="{{$slug}}" target="_blank">{{$v['title']}}</a>
                                                    </p>
                                                    @if(!empty($options))
                                                    <p style="margin-top:3px">
                                                        <span style="font-size:12px;display:block">
                                                            {{$options}}
                                                        </span>
                                                    </p>
                                                    @endif
                                                </td>
                                                <td style="text-align:center">
                                                    {{$v['quantity']}}
                                                </td>
                                                <td style="text-align:center">
                                                    <b>
                                                        {{number_format( $v['price'],0,'.',',')}} VNĐ
                                                    </b>

                                                </td>
                                                <td style="text-align:right">
                                                    {{number_format($v['quantity'] * $v['price'],0,'.',',')}}
                                                    VNĐ
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>

                                            <tr>
                                                <td colspan="3">
                                                    Tổng giá trị sản phẩm
                                                </td>
                                                <td style="text-align:right">
                                                    {{ number_format($detail->total_price) }}
                                                    VNĐ
                                                </td>
                                            </tr>
                                            @if (isset($coupon))
                                            @foreach ($coupon as $v)
                                            <tr>
                                                <td colspan="3">
                                                    Giảm giá
                                                </td>
                                                <td style="text-align:right">
                                                    - {{number_format($v['price'])}}
                                                    VNĐ
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="3">Phí vận chuyển</td>
                                                <td style="text-align:right">
                                                    {{ number_format($detail->total_price_ship) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <b>Tổng thanh toán</b>
                                                </td>
                                                <td style="text-align:right">
                                                    <b>
                                                        {{ number_format($detail->total_price-$detail->total_price_coupon+$detail->total_price_ship) }}
                                                        VNĐ
                                                    </b>
                                                </td>
                                            </tr>

                                        </tfoot>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%"
                                        style="margin-top:20px;font-size:14px;line-height:24px">
                                        <tbody>
                                            <tr>

                                                <td>
                                                    <p style="font-weight:bold;">
                                                        Quý khách cần được hỗ trợ ngay?
                                                    </p>
                                                    Chỉ cần phản hồi đến <a href="mailto:{{$fcSystem['contact_email']}}"
                                                        style="text-decoration:none;color:black" target="_blank">
                                                        <b>
                                                            {{$fcSystem['contact_email']}}
                                                        </b>
                                                    </a>
                                                    , hoặc gọi số điện thoại <a
                                                        href="tel:{{$fcSystem['contact_hotline']}}"
                                                        style="text-decoration:none;color:black" target="_blank">
                                                        <b>{{$fcSystem['contact_hotline']}}</b>
                                                    </a> hoặc inbox trực tiếp cho
                                                    {{$fcSystem['homepage_company']}} <a
                                                        href="{{$fcSystem['social_facebook']}}"
                                                        style="text-decoration:none;color:black" target="_blank">
                                                        <b>
                                                            tại đây
                                                        </b>
                                                    </a> (8-21h cả T7,CN).
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td style="font-size:14px;text-align:center;padding:16px 0;line-height:20px">
                                Hotline: <a href="tel:{{$fcSystem['contact_hotline']}}"
                                    style="color:black;text-decoration:none"
                                    target="_blank">{{$fcSystem['contact_hotline']}}</a> |
                                CSKH: <a href="mailto:{{$fcSystem['contact_email']}}"
                                    style="color:black;text-decoration:none"
                                    target="_blank">{{$fcSystem['contact_email']}}</a>


                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tb ody>
</table>