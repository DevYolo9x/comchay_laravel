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
<div class="py-9 bg-gray-light px-4">
    <form class="checkout" action="{{route('cart.order')}}" method="POST">
        <div class="container mx-auto">
            <div class="grid grid-cols-12 gap-5">
                <div class="col-span-12 lg:col-span-7">
                    <div>
                        <h3 class="text-lg font-semibold mb-5">Thông tin thanh toán</h3>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-5">



                            @if ($errors->any())
                            <div class="col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}
                                    @endforeach
                                </span>
                            </div>
                            @endif
                            @if(session('error'))
                            <div class="col-span-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg">
                                <strong class="font-bold">ERROR!</strong>
                                <span class="block sm:inline">
                                    {{session('error')}}
                                </span>
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg" style="display: none">
                                <div class="flex items-center mb-">
                                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-bold">{{session('success')}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif


                            @csrf
                            <div class="lg:col-span-2">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Họ và tên</label>

                                    <?php echo Form::text('fullname', !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->name : '', ['class' => 'border border-solid border-gray-300 w-full py-1 px-5 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                </div>
                            </div>
                            <div class="lg:col-span-2">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Email</label>

                                    <?php echo Form::text('email', !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->email : '', ['class' => 'border border-solid border-gray-300 w-full py-1 px-5 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                </div>
                            </div>
                            <div class="lg:col-span-2">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Số điện thoại</label>

                                    <?php echo Form::text('phone', !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->phone : '', ['class' => 'border border-solid border-gray-300 w-full py-1 px-5 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                                </div>
                            </div>
                            <div class="lg:col-span-2">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Địa chỉ</label>
                                    <?php
                                    echo Form::textarea('address', !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->address : '', ['class' => 'border border-solid border-gray-300 w-full py-1 px-5 placeholder-current text-dark h-36 focus:outline-none text-base', 'autocomplete' => 'off']);
                                    ?>
                                </div>
                            </div>
                            <div class="">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Tỉnh/Thành phố</label>

                                    <?php
                                    echo Form::select('cityid', $listCity, old('cityid'), ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-5 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'city']);
                                    ?>

                                </div>
                            </div>
                            <div class="">
                                <div>
                                    <label class="mb-3 inline-block font-bold">Quận/Huyện</label>
                                    <?php
                                    echo Form::select('districtid', [], old('cityid'), ['class' => 'bg-transparent border border-solid border-gray-300 w-full py-1 px-5 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base', 'id' => 'district', 'placeholder' => 'Quận/Huyện']);
                                    ?>
                                </div>
                            </div>
                            <div class="lg:col-span-2">
                                <label class="mb-3 inline-block font-bold">Thanh toán</label>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex">
                                            <input name="payment" type="radio" class="mr-1" value="COD" checked>
                                            <label>
                                                <span>Thanh toán khi giao hàng (COD)</span>
                                            </label>
                                        </div>
                                        <div class="shadow p-4 mt-2">
                                            <?php echo $fcSystem['cart_1'] ?>

                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex">
                                            <input name="payment" type="radio" class="mr-1" value="BANKING">
                                            <label>
                                                <span>Chuyển khoản ngân hàng </span>
                                            </label>
                                        </div>
                                        <div class="shadow p-4  mt-2">
                                            <?php echo $fcSystem['cart_2'] ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="additional-info-wrap mt-3">
                            <h4 class="text-base font-bold mb-3">Ghi chú đơn hàng</h4>
                            <div class="additional-info">
                                <?php echo Form::textarea('note', '', ['class' => 'border border-solid border-gray-300 w-full py-1 px-5 placeholder-current text-dark h-36 focus:outline-none text-base', 'autocomplete' => 'off']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-5 mt-4 mt-lg-0">
                    <div>
                        <h3 class="text-lg font-semibold mb-5">Thông tin đơn hàng</h3>
                        <div class="bg-slate-100 p-10">
                            <div class="your-order-product-info">
                                <ul class="flex flex-wrap items-center justify-between">
                                    <li class="text-base font-semibold">Sản phẩm</li>
                                    <li class="text-base font-semibold text-orange">Thành tiền</li>
                                </ul>
                                <ul class="border-t border-b  py-5 my-5">
                                    <?php $total = $price_coupon = 0; ?>
                                    @if($cartController)
                                    @foreach( $cartController as $k=>$v)
                                    <?php
                                    $total += $v['price'] * $v['quantity'];
                                    $slug = !empty($v['slug']) ? $v['slug'] : '';
                                    $options = !empty($v['options']) ? ' - ' . $v['options'] : '';
                                    ?>
                                    <li class="flex flex-wrap items-center justify-between">
                                        <span class="w-1-2">{{$v['title']}} {{ $options}} X <b class="text-orange">{{$v['quantity']}}</b></span>
                                        <span class="w-1-2 text-right text-orange font-semibold">{{number_format($v['quantity'] * $v['price'],0,'.',',')}}
                                            VNĐ</span>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                                <ul class="flex flex-wrap items-center justify-between ">
                                    <li class="text-base font-semibold">Tạm tính</li>
                                    <li class="text-base font-semibold text-orange">
                                        {{ number_format($total,0,'.',',') }} VNĐ
                                    </li>
                                </ul>
                                <input type="hidden" name="total_price_ship" value="{{$fcSystem['cart_shipping']}}">
                                <ul class="flex flex-wrap items-center justify-between ">
                                    <li class="text-base font-semibold">Phí vận chuyển</li>
                                    <li class="text-base font-semibold text-orange">
                                        {{ number_format($fcSystem['cart_shipping'],0,'.',',') }} VNĐ
                                    </li>
                                </ul>
                                <?php /*<div class="cart-coupon-html">
                                    @if (isset($coupon))
                                    @foreach ($coupon as $v)
                                    <?php $price_coupon += !empty($v['price']) ? $v['price'] : 0; ?>
                                    <ul class="flex flex-wrap items-center justify-between">
                                        <li class="text-base font-semibold">Mã giảm giá {{$v['name']}}</li>
                                        <li class="text-base font-semibold text-orange ">
                                            <span class="cart-coupon-price">
                                                - {{number_format($v['price'],0,'.',',')}} VNĐ <a href="javascript:void(0)" data-id="{{$v['id']}}" class="remove-coupon text-red-600 font-bold">[Xóa]</a>
                                            </span>

                                        </li>
                                    </ul>
                                    @endforeach
                                    @endif
                                </div>*/ ?>

                                <!-- START: mã giảm giá -->
                                <?php /*<div class="mt-5">

                                    <h3 class="text-md font-semibold capitalize mb-2">Nhập mã giảm giá</h3>

                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative message-danger mb-2 hidden">
                                        <strong class="font-bold">ERROR!</strong>
                                        <span class="block sm:inline danger-title"></span>
                                    </div>
                                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md message-success mb-2 hidden">
                                        <div class="flex">
                                            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold success-title"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <input id="coupon_code" class="border border-solid border-gray-300 w-full px-5 mb-5 placeholder-current text-dark h-12 focus:outline-none text-base" placeholder="" type="text">
                                        <button type="button" id="apply_coupon" class="absolute top-0 right-0 h-12 inline-block bg-black leading-none py-4 px-2 text-sm text-white transition-all hover:bg-orange uppercase font-semibold hover:text-white">Áp
                                            dụng</button>
                                    </div>
                                </div>*/ ?>
                                <!-- END: mã giảm giá -->

                                <ul class="flex flex-wrap items-center justify-between border-t border-b  py-5 my-5">
                                    <li class="text-base font-semibold">Tổng tiền</li>
                                    <li class="text-base font-semibold text-orange cart-total-final">
                                        {{ number_format($total+$fcSystem['cart_shipping']-$price_coupon,0,'.',',') }}
                                        VNĐ
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-6">
                            @if(session('errorStock'))
                            <div class="alert alert-danger alert-dismissable lg:col-span-2">
                                <b>Error!</b>
                                @foreach(session('errorStock') as $err)
                                {{$err}}
                                @endforeach
                            </div>
                            @endif
                            <button type="submit" class="block w-full text-center leading-none uppercase bg-red-600 text-white text-sm bg-dark px-5 py-5 transition-all hover:bg-orange font-semibold">ĐẶT
                                HÀNG</but>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('javascript')


<script>
    $("form.checkout").submit(function(event) {
        $('.lds-show').removeClass('hidden');
        $('.offcanvas-overlay').removeClass('hidden');
    });
    var cityid = '<?php echo !empty(old('cityid')) ? old('cityid') : "" ?>';
    var districtid = '<?php echo !empty(old('districtid')) ? old('districtid') : "" ?>';
    var wardid = '<?php echo old('wardid') ?>';
    $(document).on('change', '#city', function(e, data) {
        let _this = $(this);
        let param = {
            'parentid': _this.val(),
            'select': 'districtid',
            'table': 'vn_district',
            'trigger_district': (typeof(data) != 'undefined') ? true : false,
            'text': 'Chọn Quận/Huyện',
            'parentField': 'provinceid',
        }
        getLocation(param, '#district');
    });
    if (typeof(cityid) != 'undefined' && cityid != '') {
        $('#city').val(cityid).trigger('change', [{
            'trigger': true
        }]);
    }

    function getLocation(param, object) {
        if (districtid == '' || param.trigger_district == false) districtid = 0;
        if (wardid == '' || param.trigger_ward == false) wardid = 0;
        let formURL = '<?php echo route('checkout.getLocation') ?>';
        $.post(formURL, {
                param: param,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                let json = JSON.parse(data);
                console.log(json.html);
                if (param.select == 'districtid') {
                    if (param.trigger_district == true) {
                        $(object).html(json.html).val(districtid).trigger('change', [{
                            'trigger': true
                        }]);
                    } else {
                        $(object).html(json.html).val(districtid).trigger('change');
                    }
                } else if (param.select == 'wardid') {
                    $(object).html(json.html).val(wardid);
                }
            });
    }
</script>
@endpush