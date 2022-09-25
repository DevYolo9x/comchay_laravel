@extends('dashboard.layout.dashboard')
@section('title')
<title>Chi tiết đơn hàng</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách đơn hàng",
        "src" => route('orders.index'),
    ],
    [
        "title" => "Cập nhập đơn hàng",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')

<div class="content">
    <div class=" flex flex-col sm:flex-row items-center mt-8">
        <h2 class="flex items-center text-lg font-medium mr-auto">
            Đơn hàng <i class="w-4 h-4 mx-2 !stroke-2" data-lucide="arrow-right"></i> #{{$detail->code}}
        </h2>

    </div>
    <div class="grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Order Detail Side Menu -->
        <div class="col-span-12 md:col-span-4">
            <div class="box  p-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Chi tiết giao dịch</div>
                </div>
                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Mã đơn hàng: <button class="underline decoration-dotted ml-1">{{$detail->code}}</button>
                </div>
                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Ngày đặt: {{$detail->created_at}} </div>
                <div class="flex items-center mt-3"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Trạng thái đơn hàng:
                    <?php

                    if ($detail->status == 'wait') {
                        $class = 'text-xs whitespace-nowrap text-secondary bg-secondary/20 secondary  border-secondary/20 rounded-full px-2 py-1';
                    } else if ($detail->status == 'pending') {
                        $class = 'text-xs whitespace-nowrap text-pending bg-pending/20 pending  pending-primary/20 rounded-full px-2 py-1';
                    } else if ($detail->status == 'transported') {
                        $class = 'text-xs whitespace-nowrap text-primary bg-primary/20 border border-primary/20 rounded-full px-2 py-1';
                    } else if ($detail->status == 'completed') {
                        $class = 'text-xs text-success bg-success/30 border border-success/20 rounded-md px-1.5 py-0.5 ml-1';
                    } else if ($detail->status == 'canceled') {
                        $class = 'text-xs whitespace-nowrap text-warning bg-warning/20 border border-warning/20 rounded-full px-2 py-1';
                    }

                    ?>
                    <span class="{{$class}}">
                        <?php echo config('cart')['status'][$detail->status]; ?>
                    </span>
                </div>
                <div class="flex items-center mt-3"> <i data-lucide="edit" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Cập nhập trạng thái đơn hàng:
                </div>
                <select class="form-control tom-select tom-select-custom mt-3" data-id="{{$detail->id}}">
                    @foreach(config('cart')['status'] as $l=>$val)
                    <option value="{{$l}}" <?php if ($detail->status == $l) { ?>selected<?php } ?>>
                        {{$val}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Thông tin người mua</div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <b>Họ và tên:</b> <span class=" decoration-dotted ml-1">{{$detail->fullname}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Số điện thoại:</b> <span class=" decoration-dotted ml-1">{{$detail->phone}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Email:</b> <span class="decoration-dotted ml-1">{{$detail->email}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Địa chỉ:</b> <span class=" decoration-dotted ml-1">{{$detail->address}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Quận/Huyện:</b> <span class=" decoration-dotted ml-1">{{$detail->district_name->name}}</span>
                    </div>
                    <div class="flex items-center">
                        <b>Tỉnh/Thành phố:</b> <span class=" decoration-dotted ml-1">{{$detail->city_name->name}}</span>
                    </div>
                    <div class="">
                        <div>
                            <b>Ghi chú:</b>
                        </div>
                        <div>
                            {{$detail->note}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Chi tiết thanh toán</div>
                </div>
                <div class="flex items-center">
                    <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Thanh toán:
                    <div class="ml-auto"><?php echo config('cart')['payment'][$detail->payment]; ?></div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Tạm tính:
                    <div class="ml-auto">{{number_format($detail->total_price,0,',','.')}} VNĐ</div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Phí vận chuyện:
                    <div class="ml-auto">{{number_format($detail['total_price_ship'],0,',','.')}} VNĐ</div>
                </div>
                <?php $coupon = json_decode($detail->coupon, TRUE); ?>
                @if(isset($coupon))
                @foreach($coupon as $v)
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Mã giảm giá - {{$v['name']}}
                    <div class="ml-auto">- {{number_format($v['price'],0,',','.')}} VNĐ</div>
                </div>
                @endforeach
                @endif
                <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Tổng tiền thanh toán:
                    <div class="ml-auto">
                        {{number_format($detail->total_price-$detail->total_price_coupon+$detail->total_price_ship,0,',','.')}}
                        VNĐ
                    </div>
                </div>
            </div>

        </div>
        <!-- END: Order Detail Side Menu -->
        <!-- BEGIN: Order Detail Content -->
        <?php $cart = json_decode($detail->cart, TRUE); ?>
        <div class="col-span-12 md:col-span-8">
            <div class="box  p-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Sản phẩm</div>
                </div>
                <div>
                    <?php $total = 0 ?>
                    @if($cart)
                    @foreach( $cart as $k=>$v)
                    <?php
                    $total += $v['price'] * $v['quantity'];
                    $slug = !empty($v['slug']) ? $v['slug'] : '';
                    $options = !empty($v['options']) ? $v['options'] : '';
                    ?>
                    <div class="flex flex-col md:flex-row items-center py-4 first:pt-0 last:border-0 last:pb-0 border-b border-dashed border-slate-200 dark:border-darkmode-400">
                        <div class="flex items-center md:mr-auto flex-1">
                            <div class="image-fit w-16 h-16">
                                <img src="{{url($v['image'])}}" class="rounded-lg border-2 border-white shadow-md" alt="{{$v['title']}}">
                            </div>
                            <div class="ml-5">
                                <div class="font-medium">{{$v['title']}}</div>
                                <div>
                                    {{$options}}
                                </div>
                                <div class="text-slate-500 mt-1">{{$v['quantity']}} items x
                                    {{number_format($v['price'],0,',','.')}}
                                </div>

                            </div>
                        </div>

                        <div class="py-4 md:pl-12 md:pr-10 md:border-l text-center md:text-left border-dashed border-slate-200 dark:border-darkmode-400" style="width:200px">
                            <div class="text-slate-500">Thành tiền</div>
                            <div class="font-medium mt-1">{{number_format($v['price']*$v['quantity'],0,',','.')}} VNĐ
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- END: Order Detail Content -->
    </div>
</div>
@endsection
@push('javascript')
<script src="{{asset('library/toastr/toastr.min.js')}}"></script>
<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">
<script>
    $(document).on('change', '.tom-select-custom', function() {
        var id = $(this).attr('data-id');
        var status = $(this).val();
        $.ajax({
            type: 'POST',
            url: "{{route('orders.ajaxUploadStatus')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                status: status
            },
            success: function(data) {

                swal({
                    title: "Cập nhập trạng thái đơn hàng thành công!",
                    type: "success"
                }, function() {
                    location.reload();
                });
            },
            error: function(jqXhr, json, errorThrown) {
                toastr.error('Cập nhập đơn hàng không thành công', 'Error!')
            },
        });

    });
</script>
@endpush