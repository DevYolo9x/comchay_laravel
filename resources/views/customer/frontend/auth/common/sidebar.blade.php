<div class="w-[376px]">
    <div>
        <section class="flex items-center mb-1">
            <div class="border rounded-full h-[60px] w-[60px] overflow-hidden">
                <img alt="Thêm alt sau" src="{{asset('frontend/images/fallback-image.4d0336f.png')}}" class="blur-up h-full w-full t-img">
            </div>
            <div class="flex flex-col ml-3">
                <span class="font-extrabold text-[19px]">
                    Quyền
                </span>
                <a href="" class="font-bold text-xs text-blue-500	">
                    Thêm số điện thoại
                </a>
            </div>
        </section>
        <div class="h-px my-3"></div>
        <div class="flex flex-col gap-3">
            <a href="{{route('customer.dashboard')}}" class="flex justify-between items-center p-3 rounded-xl<?php if (route('customer.dashboard') == $seo['canonical']) { ?> border border-blue-500<?php } else { ?> hover:bg-gray-100<?php } ?>">
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Thông tin tài khoản</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?php echo !empty((route('customer.dashboard') == $seo['canonical'])) ? 'text-gray-600' : 'text-gray-300' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="{{route('customer.address')}}" class="flex justify-between items-center p-3 rounded-xl <?php if (route('customer.address') == $seo['canonical']) { ?> border-blue-500 border<?php } else { ?> hover:bg-gray-100 <?php } ?>">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-cyan-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Thông tin liên hệ &amp; Sổ địa chỉ</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?php echo !empty((route('customer.address') == $seo['canonical'])) ? 'text-gray-600' : 'text-gray-300' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="{{route('customer.orders')}}" class="flex justify-between items-center p-3 rounded-xl<?php if (route('customer.orders') == $seo['canonical']) { ?> border border-blue-500<?php } else { ?> hover:bg-gray-100 <?php } ?>">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Lịch sử mua hàng</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 <?php echo !empty((route('customer.orders') == $seo['canonical'])) ? 'text-gray-600' : 'text-gray-300' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
        <div class="flex space-x-2 my-5">
            <a href="" class="px-1 w-1/4 rounded-xl hover:bg-gray-40 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex flex-col items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <div class="mt-1 text-sm text-center">
                        <span class="block">Chờ</span>
                        <span class="font-bold mt-[2px] block">Thanh toán</span>
                    </div>
                </div>
            </a>
            <a href="" class="px-1 w-1/4 rounded-xl hover:bg-gray-40 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex flex-col items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z"></path>
                    </svg>
                    <div class="mt-1 text-sm text-center">
                        <span class="block">Có tại</span>
                        <span class="font-bold mt-[2px] block">Cửa hàng</span>
                    </div>
                </div>
            </a>
            <a href="" class="px-1 w-1/4 rounded-xl hover:bg-gray-40 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex flex-col items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <div class="mt-1 text-sm text-center">
                        <span class="block">Đang</span>
                        <span class="font-bold mt-[2px] block">Vận chuyển</span>
                    </div>
                </div>
            </a>
            <a href="" class="px-1 w-1/4 rounded-xl hover:bg-gray-40 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex flex-col items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <div class="mt-1 text-sm text-center">
                        <span class="block">Chờ</span>
                        <span class="font-bold mt-[2px] block">Đánh giá</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="h-px my-3"></div>
        <div class="">
            <a href="{{route('addressFrontend.index')}}" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                    </svg>
                    <span>Hệ thống cửa hàng</span>
                </div>
                <!---->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{route('homepage.policy')}}" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Bảo hành, đổi trả</span>
                </div>
                <!---->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <span>Vận chuyển, thanh toán</span>
                </div>
                <!---->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                    </svg>
                    <span>Bảng giá dịch vụ</span>
                </div>
                <!---->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span>Gọi hotline 1900.63.3579</span>
                </div>
                <!---->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>


        <div class="h-px my-3"></div>
        <a href="" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
            <div class="flex space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Đăng xuất</span>
            </div>

        </a>
    </div>

</div>