@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới thành viên</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách thành viên",
            "src" => route('users.index'),
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
            Thêm mới
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('users.store')}}" method="post"
        enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên thành viên</label>
                    <?php echo Form::text('name', '', ['class' => 'form-control w-full ']); ?>
                </div>

                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Email</label>
                    <div class="mt-2">
                        <?php echo Form::text('email', '', ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Số điện thoại</label>
                    <div class="mt-2">
                        <?php echo Form::text('phone', '', ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Địa chỉ</label>
                    <div class="mt-2">
                        <?php echo Form::text('address', '', ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mật khẩu</label>
                    <div class="mt-2">
                        <input type="password" name="password" class="form-control" placeholder="" value="">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Nhập lại mật khẩu</label>
                    <div class="mt-2">
                        <input type="password" name="confirm_password" class="form-control" placeholder="" value="">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Chọn nhóm thành viên</label>
                    <div class="mt-2">

                        <select class="tom-select tom-select-custom w-full tomselected" data-placeholder="Search..."
                            name="role_id[]" tabindex="-1">
                            <option value=""></option>
                            @foreach($roles as $k=>$v)
                            <option value="{{$v->id}}"
                                {{ (collect(old('role_id'))->contains($v->id)) ? 'selected':'' }}>
                                {{$v->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    @include('user.backend.user.image',['action' => 'create'])
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>

        </div>
    </form>
</div>



@endsection
