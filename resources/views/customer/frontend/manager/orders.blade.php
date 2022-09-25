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

                <div class="flex-1 overflow-x-hidden">
                    <div class="flex-1 ml-4 p-6 bg-white shadow rounded-xl">
                        <h1 class="text-black text-[26px] mb-4">Quản lý đơn hàng</h1>
                        <!-- Slider main container -->
                        <div class="relative swiperOrder_box">
                            <div class="swiper swiperOrder" style="margin-right: 100px;">
                                <div class="swiper-wrapper">
                                    <?php foreach (config('cart.status') as $k => $v) { ?>
                                        <div class="swiper-slide swiper-slide-<?php echo $k ?> flex justify-center py-2 <?php echo !empty($k == 'wait') ? 'active' : '' ?>">
                                            <a href="javascript:void(0)" class="flex items-center gap-1" onclick="tabStatus('<?php echo $k ?>')"><?php echo $v ?> <span class="text-bold text-gray-400">0</span></a>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="swiper-button-prev rounded-full bg-gray-200" style="width:40px;height:40px"></div>
                            <div class="swiper-button-next rounded-full bg-gray-200" style="width:40px;height:40px"></div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center ml-4 p-6 bg-white shadow rounded-xl mt-4">
                        <div class="bg-gray-50 p-3 border border-gray-50 rounded-full mb-2 w-[50px] h-[50px]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <strong class="font-bold mb-2">Chưa có đơn hàng</strong>
                        <p class="mb-4">Mời bạn quẹo lựa hàng chuẩn giá tốt</p>
                    </div>
                </div>


            </div>
        </div>

    </div>
</main>
@push('custom-scripts')
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper(".swiperOrder", {
        direction: "horizontal",
        slidesPerView: 4,
        loop: false,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        scrollbar: {
            el: ".swiper-scrollbar"
        }
    });

    function tabStatus(e) {
        $('.swiperOrder_box .swiper-slide').removeClass('active');
        $('.swiperOrder_box .swiper-slide-' + e).addClass('active');
    }
</script>
<style>
    .swiperOrder_box .swiper-button-next:after,
    .swiperOrder_box .swiper-button-prev:after {
        font-size: 18px;
        color: gray;
    }

    .swiperOrder_box .swiper-button-prev {
        left: auto;
        right: 60px
    }

    .swiperOrder_box .swiper-slide.active {
        color: rgba(0, 101, 238, 1);
        border-bottom: 2px solid rgba(0, 101, 238, 1);
        font-weight: 700
    }
</style>
@endpush

@endsection