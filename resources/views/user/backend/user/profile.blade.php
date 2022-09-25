@extends('dashboard.layout.dashboard')

@section('title')
<title>Hồ sơ cá nhân</title>
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Hồ sơ cá nhân",
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
            Cập nhập thông tin cá nhân
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <a href="{{route('admin.profile-password')}}" class="btn btn-primary shadow-md mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    icon-name="pencil" class="lucide lucide-pencil w-4 h-4 mr-2" data-lucide="pencil">
                    <line x1="18" y1="2" x2="22" y2="6"></line>
                    <path d="M7.5 20.5L19 9l-4-4L3.5 16.5 2 22z"></path>
                </svg> Thay đổi mật khẩu
            </a>
        </div>
    </div>
    <form role="form" action="{{route('admin.profile-store' , ['id' => Auth::user()->id])}}" method="post"
        enctype="multipart/form-data">
        <div class="grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Profile Side Menu -->
            <div class="col-span-12 xl:col-span-4">
                <div class="box  p-5">
                    <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                        <div class="font-medium truncate text-base">Thông tin tài khoản
                        </div>
                    </div>
                    <div>
                        <div
                            class="flex border-b border-slate-200 border-dashed pb-5 mb-5 last:border-b-0 last:pb-0 last:mb-0">
                            <img class=" rounded-full bg-slate-200 dark:bg-darkmode-400 flex items-center justify-center text-base font-medium"
                                src="{{!empty(Auth::user()->image)?url(Auth::user()->image):asset('images/404.png')}}"
                                alt="user image" style="width: 100px;height: 100px;object-fit: cover;">
                            <div>
                                <div class="ml-5">
                                    <div class="font-medium text-base">Họ và tên</div>
                                    <div class=" text-slate-500">{{Auth::user()->name}}</div>
                                </div>
                                <div class="ml-5 mt-1">
                                    <div class="font-medium text-base">Email</div>
                                    <div class=" text-slate-500">{{Auth::user()->email}}</div>
                                </div>
                                <div class="ml-5 mt-1">
                                    <div class="font-medium text-base">Địa chỉ</div>
                                    <div class=" text-slate-500">{{Auth::user()->address}}</div>
                                </div>
                                <div class="ml-5 mt-1">
                                    <div class="font-medium text-base">Số điện thoại</div>
                                    <div class=" text-slate-500">{{Auth::user()->phone}}</div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!-- END: Profile Side Menu -->
            <!-- BEGIN: Profile Content -->
            <div class="col-span-12 xl:col-span-8">
                <div class=" box p-5">
                    @include('components.alert-error')
                    @include('components.alert-success')
                    @csrf
                    <div>
                        <label class="form-label text-base font-semibold">Email</label>
                        <?php echo Form::text('email', Auth::user()->email, ['class' => 'form-control w-full','disabled']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Tên thành viên</label>
                        <?php echo Form::text('name', Auth::user()->name, ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Số điện thoại</label>
                        <?php echo Form::text('phone', Auth::user()->phone, ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label text-base font-semibold">Địa chỉ</label>
                        <?php echo Form::text('address', Auth::user()->address, ['class' => 'form-control w-full']); ?>
                    </div>
                    <div class="mt-3">
                        @include('user.backend.user.image',['action' => 'profile'])
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