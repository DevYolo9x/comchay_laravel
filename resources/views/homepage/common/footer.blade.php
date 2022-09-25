@include('homepage.common.menuFooter')


<footer class="relative mt-5 pt-7 lg:pt-16 pb-5 md:pb-10 ">
    <div class="container mx-auto pl-4 pr-4 relative z-20 pt-10">
        <div class="flex flex-wrap justify-between text-center">
            <div class="w-full md:w-1/2">
                <a href="" class="logo-footer">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="" class="inline-block">
                </a>
            </div>
            <div class="w-full md:w-1/2">
                <a href="">
                    <img src="{{ asset('frontend/images/fanpage.jpg.webp') }}" alt="" class="inline-block">
                </a>
            </div>
        </div>
        <div class="flex flex-wrap justify-between -mx-3 mt-7">
            <div class="w-full md:w-4/5 px-3">
                <div class="item">
                    <div class="flex flex-wrap justify-between ">
                        <div class="w-full md:w-1/4">
                            <img src="{{ asset('frontend/images/bct.png') }}" alt="">
                        </div>
                        <div class="w-full md:w-3/4 pl-0 md:pl-[15px] py-[15px] md:py-0">

                            <p class="text-f15 text-white opacity-70 mb-2">
                                Sản phẩm này không phải là thuốc. Kết quả có thể khác nhau tùy theo cơ địa của mỗi người)
                            </p>
                            <p class="text-f15 text-white opacity-70 mb-2">Số giấy chứng nhận ĐKKD: 0102000559 do phòng ĐKKD</p>
                            <p class="text-f15 text-white opacity-70 mb-2">Sở Kế hoạch và Đầu tư Thành phố Hà Nội cấp ngày 23/05/2000.</p>
                            <p class="text-white opacity-70 mb-2 text-f15 mt-4">
                                <i class="fa-solid fa-location-dot mr-2"></i>Địa chỉ: Box 565,
                                Charlestown, Nevis, West Indies
                            </p>
                            <p class="text-white opacity-70 mb-2 text-f15">
                                <i class="fa-solid fa-phone mr-2"></i>Phone: +(48) 880 456 789
                            </p>
                            <p class="text-white opacity-70 mb-2 text-f15">
                                <i class="fa-solid fa-envelope mr-2"></i>Email:
                                help.apar@gmail.com
                            </p>
                        </div>

                    </div>

                </div>
            </div>
            <div class="w-full md:w-1/5 px-3">
                <div class="item">
                    <h3 class="footer_title pb-3 text-white opacity-80 text-f16 font-semibold uppercase">
                        Liên kết
                    </h3>
                    <ul class="md:block">
                        <li class="mb-[5px]">
                            <a href="" class="text-f15 pb-2 inline-block text-white opacity-70">Wishlist</a>
                        </li>
                        <li class="mb-[5px]">
                            <a href="" class="text-f15 pb-2 inline-block text-white opacity-70">My account</a>
                        </li>
                        <li class="mb-[5px]">
                            <a href="" class="text-f15 pb-2 inline-block text-white opacity-70">Store Locator</a>
                        </li>
                        <li class="mb-[5px]">
                            <a href="" class="text-f15 pb-2 inline-block text-white opacity-70">FAQ</a>
                        </li>
                        <li class="mb-[5px]">
                            <a href="" class="text-f15 pb-2 inline-block text-white opacity-70">Store Locator</a>
                        </li>

                    </ul>
                </div>
            </div>


        </div>
    </div>
</footer>
<div class="support-online">
    <div class="support-content" style="display: none;">
        <a href="tel:0989949123" class="call-now" rel="nofollow">
            <i class="fa-solid fa-mobile-retro"></i>
            <div class="animated infinite zoomIn kenit-alo-circle"></div>
            <div class="animated infinite pulse kenit-alo-circle-fill"></div>
            <span>Gọi ngay: 0989949123</span>
        </a>
        <a class="mes" href="">
            <i class="fa-brands fa-facebook-f"></i>
            <span>Nhắn tin facebook</span>
        </a>
        <a class="zalo" href="">
            <i class="fa-brands fa-rocketchat"></i>
            <span>Zalo: 0989949123</span>
        </a>
        <a class="sms" href="sms:0989949123">
            <i class="fa-solid fa-comment-sms"></i>
            <span>SMS: 0989949123</span>
        </a>
    </div>
    <a class="btn-support">
        <i class="fa-solid fa-user"></i>
        <div class="animated infinite zoomIn kenit-alo-circle"></div>
        <div class="animated infinite pulse kenit-alo-circle-fill"></div>
    </a>
</div>
<div id="scrollUp"><i class="fa fa-angle-up"></i></div>



<?php /*
<footer class=" bg-gray-100 py-10" style="display: none;">
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-[30px]">
            <div class="col-span-12 md:col-span-2 lg:col-span-2">
                <a href="{{url('')}}">
                    <img class="mx-auto" src="{{asset($fcSystem['homepage_logo_footer'])}}" alt="{{$fcSystem['homepage_company']}}" />
                </a>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <?php echo $fcSystem['homepage_footer'] ?>
            </div>
            <div class="col-span-12 md:col-span-4 lg:col-span-3">
                <?php echo $fcSystem['homepage_ads'] ?>
            </div>
            <div class="col-span-12 md:col-span-12 lg:col-span-3 text-center lg:text-right">
                <p>{{$fcSystem['title_0']}}</p>
                <ul class="flex space-x-2 mt-5 justify-center lg:justify-end">
                    <li>
                        <a target="_blank" href="{{$fcSystem['social_facebook']}}">
                            <img alt="facebook" class="w-[27px]" src="{{asset('frontend/images/facebook-black.svg')}}">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="{{$fcSystem['social_youtube']}}">
                            <img alt="youtube" class="w-[27px]" src="{{asset('frontend/images/youtube-black.svg')}}">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="{{$fcSystem['social_tiktok']}}">
                            <img alt="tiktok" class="w-[27px]" src="{{asset('frontend/images/tiktok-black.svg')}}">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="{{$fcSystem['social_twitter']}}">
                            <img alt="twitter" class="w-[27px]" src="{{asset('frontend/images/twitter-black.svg')}}">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="http://zalo.me/{{$fcSystem['social_zalo']}}">
                            <img alt="zalo" class="w-[27px]" src="{{asset('frontend/images/zalo-black.svg')}}">
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</footer>

<div id="scrollUp" class="hover:bg-[#333] hover:text-white " style="display:none;">
    <img src="{{asset('frontend/images/top.png')}}" alt="top">
</div>

*/ ?>