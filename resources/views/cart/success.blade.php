@extends('homepage.layout.home')
@section('content')
<nav class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-gray-500 hover:text-gray-600">Trang chủ</a></li>
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="javascript:void(0)" class="text-gray-500 hover:text-gray-600">{{$page->title}}</a></li>
            </ol>
        </nav>
    </div>
</nav>
<main class="py-8 bg-gray-50 px-4 md:px-0">
    <div class=" container mx-auto">
        <h1 class="uppercase w-full text-center font-bold text-2xl md:text-4xl py-4">{{$page->title}}</h1>
        <div class="text-center py-4">
            <p>
                Trên thị trường có quá nhiều sự lựa chọn, cảm ơn bạn đã lựa chọn mua sắm tại <a href="<?php echo url('') ?>" target="_blank"><b class="uppercase">{{$fcSystem['homepage_brandname']}}</b></a></p>
            <p>
                Đơn hàng của bạn CHẮC CHẮN đã được chuyển tới hệ thống xử lý đơn hàng của
                <b class="uppercase">{{$fcSystem['homepage_brandname']}}</b>.
                <br>
                Trong quá trình xử lý <b class="uppercase">{{$fcSystem['homepage_brandname']}}</b> sẽ liên hệ lại nếu
                như cần thêm thông tin từ
                bạn.
                <br>
                Ngoài ra <b class="uppercase">{{$fcSystem['homepage_brandname']}}</b> cũng sẽ có gửi xác nhận đơn
                hàng bằng Email và tin nhắn
            </p>


        </div>
        <div class=" text-center flex justify-center py-4">
            <a href="<?php echo url('') ?>" class=" bg-red-600 text-white rounded-full px-6 py-2 w-auto">Khám phá thêm
                các sản phẩm khác tại đây</a>
        </div>
        <?php $cart = json_decode($detail->cart, TRUE); ?>
        <?php $coupon = json_decode($detail->coupon, TRUE); ?>
        <div class="py-4">
            <h2 class="text-3xl font-medium w-full text-center mb-6">Thông tin đơn hàng</h2>
            <div class="rounded-xl border border-red-300 p-4 md:w-[736px] mx-auto">
                <div class="grid grid-cols-7 gap-4 items-center">
                    <div class="col-start-3 col-span-3">
                        <div class="rounded-xl border border-red-300 p-2 text-center font-semibold">
                            ĐƠN HÀNG #{{$detail->code}}
                        </div>
                    </div>
                    <div class="col-start-6 col-end-8 text-right">
                        {{$detail->created_at}}
                    </div>
                    <div class="col-start-1 col-end-8 overflow-x-auto">
                        <table class="table table-aut">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá niêm yết</th>
                                    <th>Biến thể</th>
                                    <th class="text--right">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($cart)
                                @foreach( $cart as $k=>$v)
                                <?php
                                $slug = !empty($v['slug']) ? route('routerURL', ['slug' => $v['slug']]) : 'javascript:void(0)';
                                $options = !empty($v['options']) ? $v['options'] : '';
                                ?>
                                <tr>
                                    <td class="text--left">
                                        <a href="{{$slug}}" target="_blank">{{$v['title']}}</a>
                                    </td>
                                    <td>{{$v['quantity']}}</td>
                                    <td>{{number_format( $v['price'],0,'.',',')}} VNĐ</td>
                                    <td>
                                        {{$options}}
                                    </td>
                                    <td>{{number_format($v['quantity'] * $v['price'],0,'.',',')}}
                                        VNĐ</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="total_payment">
                                    <td colspan="3">
                                        Tạm tính
                                    </td>
                                    <td colspan="2" class="text-right">
                                        {{ number_format($detail->total_price) }}
                                        VNĐ
                                    </td>
                                </tr>
                                <tr class="total_payment">
                                    <td colspan="3">
                                        Phí vận chuyển
                                    </td>
                                    <td colspan="2" class="text-right">
                                        {{ number_format($detail->total_price_ship) }}
                                        VNĐ
                                    </td>
                                </tr>
                                @if (isset($coupon))
                                @foreach ($coupon as $v)
                                <tr>
                                    <td colspan="3">Giảm giá</span>
                                    </td>
                                    <td colspan="2" class="text-right">-<span class="amount cart-coupon-price">{{number_format($v['price'])}}
                                            VNĐ</span></td>
                                </tr>
                                @endforeach
                                @endif

                                <tr class="total_payment">
                                    <td colspan="3">
                                        Tổng thanh toán
                                    </td>
                                    <td colspan="2" class="text-right">
                                        {{ number_format($detail->total_price-$detail->total_price_coupon+$detail->total_price_ship) }}
                                        VNĐ
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
        <div class="py-4">
            <h2 class="text-3xl font-medium w-full text-center mb-6">Thông tin nhận hàng</h2>

            <div class="rounded-xl border border-red-300 p-4 md:w-[736px] mx-auto">
                <p>
                    Tên người nhận: <strong>{{$detail->fullname}}</strong>
                </p>
                <p>
                    Email: <strong>{{$detail->email}}</strong>
                </p>
                <p>
                    Số điện thoại: <strong>{{$detail->phone}}</strong>
                </p>
                <p>
                    Hình thức thanh toán: <strong>{{config('cart')['payment'][$detail->payment]}}</strong>
                </p>
                <p>
                    Địa chỉ nhận hàng: <strong>{{$detail->address}}</strong>
                </p>
                <p>
                    Quận/Huyện: <strong>{{!empty($detail->district_name)?$detail->district_name->name:''}}</strong>
                </p>
                <p>
                    Tỉnh/Thành Phố: <strong>{{!empty($detail->city_name)?$detail->city_name->name:''}}</strong>
                </p>
            </div>

        </div>
    </div>
</main>
<style>
    .table {
        width: 100%;
        border-spacing: 0;
        background: #d9d9d9;
        border-radius: 16px;
    }

    .thank-box .table {
        margin: 1rem 0;
    }

    .table td,
    .table th {
        padding: 10px 20px !important;
    }

    .table thead>tr th {
        color: #fff;
        background-color: #2f5acf;
        font-weight: 500;
        text-align: center;
    }

    .table thead>tr th:last-child {
        border-radius: 0 16px 16px 0;
    }

    .table thead>tr th:first-child {
        border-radius: 16px 0 0 16px;
    }

    .text--left {
        text-align: left;
    }

    .table tbody tr:nth-child(2n) td {
        background-color: #eee;
    }

    .table th,
    .table tr:last-child td {
        border: 0px !important;
    }

    .table tfoot td {
        background-color: #fff !important;
    }
</style>



@endsection