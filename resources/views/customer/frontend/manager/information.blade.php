@extends('homepage.layout.home')
@section('content')
<main class="bg-gray-50">
    <div class="container pt-4 mx-auto">
        <nav class="bg-grey-light rounded font-sans w-full">
            <ol class="list-reset flex text-blue-500">
                <li><a href="<?php echo url('') ?>" class="text-blue font-bold">Trang chủ</a></li>
                <li><span class="mx-2">/</span></li>
                <li><?php echo $detailPage['title'] ?></li>
            </ol>
        </nav>
        <div class="mt-4 flex items-start space-x-4">
            @include('customer/frontend/auth/common/sidebar')
            <div class="flex-1 overflow-x-hidden">
                <div class="flex-1 ml-4 p-6 bg-white shadow rounded-xl">
                    <h1 class="text-black text-[26px]"><?php echo $detailPage['title'] ?></h1>
                    <div class="relative py-3">
                        <ul class="ul-tab flex items-center gap-5">
                            <li class="py-2 tab-profile active"><a href="javascript:void(0)" onclick="tab('profile')">Thông tin tài khoản</a></li>
                            <li class="py-2 tab-change-password"><a href="javascript:void(0)" onclick="tab('change-password')">Mật khẩu</a></li>
                        </ul>
                    </div>
                    <div id="tab-profile" class="tab-box active">
                        <form>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <span class="font-bold text-xs mb-1 block">Tên hiển thị</span>
                                    <input autocomplete="off" disabled="" inputmode="text" type="text" value="Quyền" class="w-full border border-gray-300 rounded-md cursor-not-allowed px-4 h-12 bg-gray-200">
                                </div>
                                <div>
                                    <span class="font-bold text-xs mb-1 block">Số điện thoại</span>
                                    <input autocomplete="off" type="text" name="phone" value="" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                </div>
                                <div>
                                    <span class="font-bold text-xs mb-1 block">Email</span>
                                    <input autocomplete="off" type="text" name="email" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                </div>

                                <div>
                                    <span class="font-bold text-xs mb-1 block">Ngày sinh</span>
                                    <input autocomplete="off" type="date" value="" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                </div>

                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <button class="font-bold h-12 w-full text-white bg-rose-500 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center text-[16px]">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="tab-change-password" class="tab-box hidden">
                        <form>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <span class="font-bold text-xs mb-1 block">Mật khẩu hiện tại</span>
                                    <input autocomplete="off" type="password" name="" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                </div>
                                <div>
                                    <span class="font-bold text-xs mb-1 block">Mật khẩu mới</span>
                                    <input autocomplete="off" type="password" value="" class="w-full border border-gray-300 rounded-md  px-4 h-12 ">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-6">
                                <button class="font-bold h-12 w-full text-white bg-rose-500 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center text-[16px]">
                                    Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@push('custom-scripts')
<script>
    function tab(e) {
        $('.ul-tab li').removeClass('active');
        $('.ul-tab li.tab-' + e).removeClass('hidden').addClass('active');
        $('.tab-box').removeClass('active').addClass('hidden');
        $('#tab-' + e).addClass('active').removeClass('hidden');
    }
</script>
<style type="text/css">
    .ul-tab .active {
        color: rgba(0, 101, 238, 1);
        border-bottom: 2px solid rgba(0, 101, 238, 1);
        font-weight: 700
    }
</style>
@endpush
@endsection