@extends('dashboard.layout.dashboard')

@section('title')
<title>Thay đổi mật khẩu</title>
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Thay đổi mật khẩu",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex flex-col sm:flex-row items-center mt-8">
        <h1 class="flex items-center text-lg font-medium mr-auto">
            Thay đổi mật khẩu
        </h1>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{route('admin.profile')}}" class="btn btn-primary shadow-md mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    icon-name="pencil" class="lucide lucide-pencil w-4 h-4 mr-2" data-lucide="pencil">
                    <line x1="18" y1="2" x2="22" y2="6"></line>
                    <path d="M7.5 20.5L19 9l-4-4L3.5 16.5 2 22z"></path>
                </svg> Cập nhập thông tin cá nhân
            </a>
        </div>
    </div>
    <form role="form" action="{{route('admin.profile-password-store' , ['id' => Auth::user()->id])}}" method="post"
        enctype="multipart/form-data">
        <div class="grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Profile Side Menu -->
            @include('user.backend.user.profile_sidebar')
            <!-- END: Profile Side Menu -->
            <!-- BEGIN: Profile Content -->
            <div class="col-span-12 xl:col-span-8">
                <div class=" box p-5">
                    @include('components.alert-error')
                    @include('components.alert-success')
                    @csrf
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="" value="" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="" value=""
                            required>
                    </div>
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary">Cập nhập</button>
                    </div>
                </div>
            </div>
            <!-- END: Profile Content -->
        </div>
    </form>
</div>
@endsection
