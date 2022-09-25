<?php
$weekday = date("l");
$weekday = strtolower($weekday);
switch ($weekday) {
    case 'monday':
        $weekday = 'Thứ 2';
        break;
    case 'tuesday':
        $weekday = 'Thứ 3';
        break;
    case 'wednesday':
        $weekday = 'Thứ 4';
        break;
    case 'thursday':
        $weekday = 'Thứ 5';
        break;
    case 'friday':
        $weekday = 'Thứ 6';
        break;
    case 'saturday':
        $weekday = 'Thứ 7';
        break;
    default:
        $weekday = 'Chủ nhật';
        break;
}
?>
<?php
$menu_header_id = \App\Models\Menu::where('slug', 'menu-header')->pluck('id');
$menu_header = \App\Models\MenuItem::where('menu_id', $menu_header_id)->where('parentid', 0)->orderBy('order')->where('alanguage', config('app.locale'))->with('children')->get();
?>

<header class="hidden md:block text-gray524 border-b border-gray-300">
    <div class="bg-green py-[8px] text-f13">
        <div class="container mx-auto px-3">
            <div class="grid">
                <div class="navbar-collapse collapse grow items-center">
                    <ul class="navbar-nav mr-auto flex space-x-5 justify-end">
                        <li class="nav-item">
                            <form action="">
                                <input type="text" placeholder="Tìm kiếm" class="w-72 h-[40px] bg-transparent border border-gray-300 rounded">
                            </form>
                        </li>
                        <li class="nav-item">
                            <a href="tel:{{$fcSystem['contact_hotline']}}" class="inline-block text-f20 font-bold mt-[8px] text-brown">
                                <span class="inline-block mr-2"><i class="fa-solid fa-phone-volume"></i></span>
                                Hotline: {{$fcSystem['contact_hotline']}}
                            </a>
                        </li>
                        <li class="cart mt-[7px]">
                            <a class="cursor-pointer relative">
                                <img src="{{ asset('frontend/images/cart.webp') }}" alt="" class="w-[25px]">
                                <span class="absolute bg-red-600">10</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="main-menu-pr">
        <div class="container py-[14px] mx-auto px-3 relative">
            <div class="inline-block w-full">
                <div class="main-logo absolute z-10 top-0">
                    <a href="{{url('')}}"><img src="{{ asset($fcSystem['homepage_logo']) }}" alt="{{ $fcSystem['homepage_company'] }}" style="width: 138px;" /></a>
                </div>
                <div class="main-menu pl-5 float-right">
                    <ul class="flex lg:flex-grow md:space-x-0 lg:space-x-4 mt-0 lg:mt-[8px] justify-end">
                        @if($menu_header->count() > 0)
                        @foreach( $menu_header as $key => $child )
                        <li class="group relative">
                            <a href="{{url($child->slug)}}" class="text-white inline-block px-[5px] lg:px-[8px] py-[10px] font-bold text-f14 lg:text-f16  transition-all">
                                <span class="lg:mt-0 hover:text-blue003">
                                    {{$child->title}}
                                    @if( $child->children->count() > 0 )
                                    <span class="text-f11 ml-[5px]"><i class="fa-solid fa-chevron-down"></i></span>
                                    @endif
                                </span>
                            </a>
                            @if( $child->children->count() > 0 )
                            <ul class="group-hover:block hidden absolute dropdown left-0 top-full z-30 bg-white p-[10px] submenu">
                                @foreach( $child->children as $keyC => $childC)
                                <li>
                                    <a href="{{url($childC->slug)}}" class="hover:text-blue003 text-f15 inline-block mb-2 hover:text-Orangefc5">{{$childC->title}}</a>
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>


</header>
<!-- Modal toggle -->

<header class="block md:hidden header-mobile">

    <div class="relative flex justify-center px-2 py-[10px] header-22">
        <style>
            /* Micro Clearfix */
            .cf:before,
            .cf:after {
                content: "";
                display: table;
                visibility: hidden;
            }

            .cf:after {
                clear: both;
            }

            .cf {
                *zoom: 1;
            }

            .wrap {
                text-align: center;
            }

            .menu li {
                float: left;
                margin-right: 10px;
                position: relative;
            }

            .menu li:last-child {
                margin-right: 0;
            }

            .menu .sub-menu li {
                width: 100%;
            }

            .menu li a {
                display: block;
                text-decoration: none;
            }

            #top-nav li a {
                color: rgba(51, 51, 51, 0.9);
                padding: 5px 0;
            }

            #top-nav .sub-menu {
                background: #fff;
            }

            #top-nav .sub-menu li a {
                padding: 5px;
            }

            #top-nav .sub-menu li>a:hover,
            #top-nav .sub-menu li.selected>a {
                background: #000f1d;
                color: #fff;
            }

            #primary-nav li a {
                color: #fff;
                padding: 10px;
            }

            #primary-nav li.active>a,
            #primary-nav li>a:hover,
            #primary-nav li.selected>a {
                background: #249045;
                color: #fff;
            }

            .downarrow {
                background: none;
                display: inline-block;
                padding: 0;
                text-align: center;
                min-width: 3px;
            }

            .sub-menu .downarrow {
                position: absolute;
                right: 0;
                padding-right: 10px;
            }

            .downarrow:before {
                content: "\25be";
                color: inherit;
                display: block;
                font-family: sans-serif;
                font-size: 1em;
                line-height: 1.1;
                width: 1em;
                height: 1em;
            }

            .menu .sub-menu {
                display: none;
                position: absolute;
                left: 0;
                max-height: 1000px;
            }

            .menu .sub-menu.hide {
                display: none;
            }

            #primary-nav .sub-menu {
                background: #249045;
                min-width: 150px;
                z-index: 200;
            }

            #primary-nav.mobile ul {
                width: 100%;
            }

            #primary-nav .sub-menu li {
                border-bottom: 1px solid rgba(51, 51, 51, 0.9);
            }

            #primary-nav .sub-menu li:last-child {
                border-bottom: 0;
            }

            #primary-nav .sub-menu .downarrow:before {
                content: "\25b8";
            }

            #primary-nav.mobile {
                display: none;
                position: absolute;
                top: 100%;
                background: #249045;
                width: 100%;
                z-index: 999;
            }

            #primary-nav.mobile li {
                width: 100%;
                margin: 0;
                border-bottom: 1px solid rgb(61 161 91);
            }

            #primary-nav.mobile li.selected>a {
                border-bottom: 1px solid rgb(61 161 91);
            }

            #primary-nav.mobile li:last-child {
                border: none;
            }

            #primary-nav.mobile li a {
                padding: 5%;
            }

            #primary-nav.mobile .sub-menu li a {
                padding-left: 7%;
            }

            #primary-nav.mobile .sub-menu .submenu li a {
                padding-left: 9%;
            }

            #primary-nav.mobile .sub-menu .sub-menu .sub-menu li a {
                padding-left: 11%;
            }

            #primary-nav.mobile .sub-menu {
                float: left;
                position: relative;
                width: 100%;
            }

            .mobile .downarrow,
            .mobile .sub-menu .downarrow {
                position: absolute;
                right: 0;
                padding-right: 5%;
            }

            #primary-nav.mobile .sub-menu .downarrow:before {
                content: "\25be";
            }

            #primary-nav-button.mobile {
                display: inline-block;
            }
        </style>

        <div class="w-full text-center">
            <button id="primary-nav-button" type="button" class="mobile float-right mt-[13px]">
                <span><i class="fa-solid fa-bars"></i></span>
            </button>
            <a href="" class="logo"><img src="{{ asset('frontend/images/logo.png') }}" alt="" class="inline-block" /></a>
        </div>
        <div class="absolute top-0 right-[10px]">
            <div class="right-header">
                <ul class="flex lg:flex-grow space-x-4 float-right">
                    <li class="relative">
                        <a class="cursor-pointer click-search">
                            <img src="{{ asset('frontend/images/search.webp') }}" alt="" class="w-[25px]">
                        </a>
                        <div class="nav-search absolute top-[33px] right-0" style="display: none;">
                            <form action="" class="relative">
                                <input type="text" placeholder="Tìm kiếm">

                            </form>
                        </div>
                    </li>
                    <li class="cart">
                        <a class="cursor-pointer relative">
                            <img src="{{ asset('frontend/images/cart.webp') }}" alt="" class="w-[25px]">
                            <span class="absolute bg-red-600">10</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <nav id="primary-nav" class="dropdown cf mobile" style="display: none">
            <ul class="dropdown menu">
                <li>
                    <a href="">Trang chủ<span class="downarrow"></span></a>
                    <ul class="sub-menu">
                        <li><a href="">Thời trang bé gái</a></li>
                        <li><a href="">BST Econice</a></li>
                        <li><a href="">Thời trang bé trai</a></li>
                        <li><a href="">BST Unifriend</a></li>
                    </ul>
                </li>
                <li><a href="">Thời trang bé trai</a></li>
                <li><a href="">Thời trang bé gái</a></li>
                <li><a href="">Giới thiệu Unifriend</a></li>
                <li><a href="">BST Unifriend</a></li>
                <li><a href="">BST Econice</a></li>

            </ul>

        </nav>
        <!-- / #primary-nav -->
    </div>
</header>




<?php /*
<header>
    <div class="hidden md:block bg-gray-50">
        <div class="container mx-auto px-4 md:px-0">
            <ul class="flex items-center justify-end space-x-4 py-1">
                @if($menu_top->count() > 0)
                @foreach($menu_top as $key => $item)
                <li><a href="{{url($item->slug)}}" class="text-global font-bold hover:text-red-600">{{$item->title}}</a></li>
                @endforeach
                @endif

                <li><a href="{{route('customer.changepassword')}}" class="text-global font-bold hover:text-red-600">Đổi mật khẩu</a></li>
                <li><a href="{{route('customer.logout')}}" class="text-global font-bold hover:text-red-600">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
    <div class="container mx-auto px-4 md:px-0 hidden md:block">
        <div class="grid grid-cols-12 gap-4 items-center my-2">
            <div class="col-span-12 md:col-span-4">
                <a href="{{url('')}}"><img class="mx-auto" src="{{ asset('{{asset($fcSystem['homepage_logo'])}}') }}" alt="{{$fcSystem['homepage_company']}}"></a>
            </div>
            <div class="col-span-12 md:col-span-4 ">
                <form action="{{url('tim-kiem')}}" method="GET">
                    <div class="relative">
                        <input placeholder="Tìm kiếm" type="text" value="{{request()->get('keyword')}}" class="bg-gray-200 rounded-full border w-full h-11 px-3 focus:outline-none  hover:outline-none" name="keyword">
                        <button class="absolute right-1 rounded-full bg-d61c1f h-9 w-10 text-global top-1/2 ovn_submit_search" style="transform: translateY(-50%);" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1/2 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-span-12 md:col-span-4 text-right">
                <div class="flex items-end justify-end">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9  text-global">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <a href="tel:{{$fcSystem['contact_hotline']}}" class="text-2xl font-bold text-global">{{$fcSystem['contact_hotline']}}</a>
                </div>
                <div class="mt-1">
                    {{$weekday}}, ngày {{date('d')}} tháng {{date('m')}} năm {{date('Y')}}
                </div>
            </div>
        </div>
    </div>
    @include('homepage.common.menuHeader')
    <div class="grid grid-cols-12 md:hidden py-2 items-center relative  px-1">
        <div class="col-span-2">
            <button id="primary-nav-button" type="button" class="mobile">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </span>
            </button>
        </div>
        <div class="col-span-8">
            <a href="{{url('')}}"><img class="mx-auto" src="{{ asset('{{asset($fcSystem['homepage_logo'])}}') }}" alt="{{$fcSystem['homepage_company']}}"></a>
        </div>
        <div class="col-span-2 flex justify-end">
            <button type="button" class="handleSearchMobile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </div>
        <div class="searchMobile absolute w-full top-full z-50" style="display: none;">
            <form action="{{url('tim-kiem')}}" method="GET">
                <div class="relative">
                    <input placeholder="Tìm kiếm " type="text" value="{{request()->get('keyword')}}" class="bg-gray-200 rounded-full border w-full h-11 px-3 focus:outline-none  hover:outline-none" name="keyword">
                    <button class="absolute right-1 rounded-full bg-d61c1f h-9 w-10 text-global top-1/2 ovn_submit_search" style="transform: translateY(-50%);" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1/2 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>

*/ ?>