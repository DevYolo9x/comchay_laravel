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
                    <div>
                        <section class="pt-8 flex flex-col items-center">
                            <div class="max-w-screen-mobile">
                                <div class="flex flex-col items-center space-y-3">
                                    <button class="bg-gray-50 rounded-full flex items-center justify-center w-[50px] h-[50px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                        </svg>
                                    </button>
                                    <span class="block text-body font-bold">Chưa thêm địa chỉ</span>
                                    <span class="text-sm">
                                        Hãy thêm địa chỉ để dễ dàng nhận hàng bạn nhé!
                                    </span>
                                </div>
                                <button class="font-bold h-12 w-full text-white bg-rose-500 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center text-[16px] mt-5" onclick="showModalAddress()">
                                    Thêm địa chỉ mới
                                </button>

                            </div>
                            <div class="mt-3 flex justify-end overlay w-full pr-[60px]">
                                <img alt="ThinkPro" src="{{asset('frontend/images/thinkpro-employee.7b76650.png')}}">
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Main modal -->
<div id="authentication-modal" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full  flex justify-center items-center " style="background: #808080cc">
    <div class="relative p-4 h-full md:h-auto w-[790px]">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-end p-2">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" onclick="showModalAddress()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <form class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8 " action="#">
                <h3 class="text-3xl font-medium text-gray-900 dark:text-white">Thông tin địa chỉ</h3>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tên người nhận</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Số điện thoại</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tỉnh / Thành phố</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Quận / Huyện
                        </label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Phường / Xã</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Địa chỉ nhận hàng
                        </label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                    </div>
                </div>
                <div class="flex items-center w-full mb-12">

                    <label for="toogleA" class="flex items-center cursor-pointer">
                        <!-- toggle -->
                        <div class="relative">
                            <!-- input -->
                            <input id="toogleA" type="checkbox" class="sr-only" />
                            <!-- line -->
                            <div class="w-10 h-[24px] bg-gray-400 rounded-full shadow-inner"></div>
                            <!-- dot -->
                            <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 top-0 transition"></div>
                        </div>
                        <!-- label -->
                        <div class="ml-3 text-gray-700 text-sm">
                            Đặt làm địa chỉ mặc định
                        </div>
                    </label>

                </div>

                <button type="submit" class=" text-white bg-rose-500 hover:bg-rose-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-rose-500 dark:hover:bg-rose-600 dark:focus:ring-blue-800">
                    Thêm địa chỉ mới</button>

            </form>
        </div>
    </div>
</div>
<style>
    input:checked~.dot {
        transform: translateX(100%);
        background-color: rgb(29 78 216 / 1);
    }
</style>
@push('custom-scripts')
<script>
    function showModalAddress() {
        $('#authentication-modal').toggleClass('hidden')
    }
</script>
@endpush
@endsection