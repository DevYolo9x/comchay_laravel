@extends('dashboard.layout.dashboard')
@section('title')
<title>Cập nhập mã giảm giá</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách coupon",
            "src" => route('coupons.index'),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0);',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập coupon
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('coupons.update',['id'=>$detail->id])}}"
        method="post" enctype="multipart/form-data">
        @include('coupon.common.coupon',['action' => 'update'])
    </form>
</div>
@push('javascript')
<script>
var product_ids = '<?php echo $detail->product_ids; ?>';
var exclude_product_ids = '<?php echo $detail->exclude_product_ids; ?>';
var product_categories = '<?php echo $detail->product_categories; ?>';
var exclude_product_categories = '<?php echo $detail->exclude_product_categories; ?>';
</script>
@include('coupon.common.script')
@endpush
@endsection