@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập cửa hàng</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách cửa hàng",
            "src" => route('addresses.index'),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập cửa hàng
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('addresses.update',['id' => $detail->id])}}"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên cửa hàng</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Email</label>
                    <div class="mt-2">
                        <?php echo Form::text('email', $detail->email, ['class' => 'form-control']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Số điện thoại</label>
                    <div class="mt-2">
                        <?php echo Form::text('hotline', $detail->hotline, ['class' => 'form-control']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Địa chỉ</label>
                    <div class="mt-2">
                        <?php echo Form::text('address', $detail->address, ['class' => 'form-control','placeholder'=>'Số 33 ngõ 629 Kim Mã']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Tỉnh/Thành phố</label>
                    <div class="mt-2">
                        <?php echo Form::select('cityid', $listCity, $detail->cityid, ['class' => 'form-control tom-select tom-select-custom', 'id' => 'city']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Quận/Huyện</label>
                    <div class="mt-2">

                        <?php echo Form::select('districtid', [], '', ['class' => 'form-control', 'id' => 'district','placeholder'=>'']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Thời gian làm việc</label>
                    <div class="mt-2">
                        <?php echo Form::text('time', $detail->time, ['class' => 'form-control']);?>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])

            @include('components.publish')
        </div>
    </form>
</div>

@include('address.backend.script')
@endsection