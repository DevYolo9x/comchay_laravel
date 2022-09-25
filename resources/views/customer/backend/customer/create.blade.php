@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới thành viên</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách thành viên",
        "src" => route('customers.index'),
    ],
    [
        "title" => "Thêm mới",
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
            Thêm mới thành viên
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('customers.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Nhóm thành viên</label>
                    <?php echo Form::select('catalogue_id', $category, old('catalogue_id'), ['class' => 'form-control w-full', 'placeholder' => '']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Email</label>
                    <?php echo Form::text('email', '', ['class' => 'form-control w-full', 'placeholder' => 'Email']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mật khẩu</label>
                    <?php echo Form::text('password', '', ['class' => 'form-control w-full', 'placeholder' => 'Mật khẩu']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Họ và tên</label>
                    <?php echo Form::text('name', '', ['class' => 'form-control w-full', 'placeholder' => 'Họ và tên']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Số điện thoại</label>
                    <?php echo Form::text('phone', '', ['class' => 'form-control w-full', 'placeholder' => 'Số điện thoại']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Địa chỉ</label>
                    <?php echo Form::text('address', '', ['class' => 'form-control w-full', 'placeholder' => 'Số 80 - Ngõ 20 - Mỹ Đình']); ?>
                </div>
                <div class="mt-3">
                    @include('user.backend.user.image',['action' => 'create'])
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection