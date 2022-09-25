<div class="offcanvas-overlay fixed inset-0 bg-black opacity-50 z-50 hidden"></div>
<div id="offcanvas-cart" class="offcanvas left-auto right-0 transform fixed font-normal text-sm top-0 z-50 h-screen w-80 lg:w-96 transition-all ease-in-out duration-300 bg-white overflow-y-auto hidden animated fadeInRight">
    <div class="p-8">
        <div class="flex flex-wrap justify-between items-center pb-6 mb-6 border-b border-solid border-gray-600">
            <h4 class="font-normal text-xl">Giỏ hàng</h4>
            <button class="offcanvas-close text-d61c1f">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>

        <div id="cart-show-header" <?php if (empty($cart['cart'])) { ?> style="display: none" <?php } ?>>
            <ul class="h-96 overflow-y-auto cart-html-header">
                @if(isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart']) > 0)
                @foreach($cart['cart'] as $k=>$item)
                <?php
                $html = '';
                $slug = !empty($item['slug']) ? $item['slug'] : '';
                $options = !empty($item['options']) ? '-' . $item['options'] : '';
                echo $html .= '<li class="flex flex-wrap group mb-8" data-rowid="' . $k . '">
                             <div class="mr-5 relative">
                                 <a href="' . $slug . '"><img src="' . url($item['image']) . '" alt="' . $item['title'] . '"
                                         loading="lazy" width="90" height="100" /></a>
                                 <button class="absolute top-3 left-3 opacity-0 invisible group-hover:visible group-hover:opacity-100 transition-all hover:text-orange cart-remove">
                                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                     </svg>
                                 </button>
                             </div>
                             <div class="flex-1">
                                 <h4>
                                     <a class="font-light text-sm md:text-base text-dark hover:text-orange transition-all tracking-wide"
                                         href="' . $slug . '">' . $item['title'] . '' . $options . '</a>
                                 </h4>
                                 <span class="font-light text-sm text-dark transition-all tracking-wide">' . $item['quantity'] . ' x
                                     <span>' . number_format($item['price'], 0, ',', '.') . ' VNĐ' . '</span></span>
                             </div>
                         </li>';
                ?>
                @endforeach

                @endif
            </ul>
            <div>
                <div class="flex flex-wrap justify-between items-center py-4 my-6 border-t border-b border-solid border-gray-600 font-normal text-base text-dark capitalize">
                    Tổng tiền:<span class="cart-total"><?php echo number_format($cart['total'], 0, ',', '.') . ' VNĐĐ' ?></span>
                </div>
                <div class="text-center">
                    <a class="py-5 px-10 block bg-white border border-solid border-gray-600 uppercase font-semibold text-base hover:bg-red-600 hover:border-red-600 hover:text-white transition-all leading-none" href="{{route('cart.index')}}">Giỏ hàng</a>

                    <a class="py-5 px-10 block bg-white border border-solid border-gray-600 uppercase font-semibold text-base hover:bg-red-600 hover:border-red-600  hover:text-white transition-all leading-none  mt-3" href="{{route('cart.checkout')}}">Thanh toán</a>
                </div>
            </div>
        </div>
        <div id="cart-none-header" <?php if (!empty($cart['cart'])) { ?> style="display: none" <?php } ?>>
            <div class="flex flex-col items-center justify-center space-y-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                <span class="block text-xl font-bold text-gray-400">Chưa có sản phẩm trong giỏ hàng</span>

            </div>

        </div>

    </div>
</div>
@push('css')
<style>
    @-webkit-keyframes fadeInRight {
        0% {
            opacity: 0;
            -webkit-transform: translateX(20px);
        }

        100% {
            opacity: 1;
            -webkit-transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        0% {
            opacity: 0;
            transform: translateX(20px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .fadeInRight {
        -webkit-animation-name: fadeInRight;
        animation-name: fadeInRight;
    }

    .animated {
        -webkit-animation-duration: 0.5s;
        animation-duration: 0.5s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
</style>
@endpush
@push('javascript')
<!-- functions tp -->
<script src="{{asset('library/toastr/toastr.min.js')}}"></script>
<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">
<script src="{{ asset('frontend/library/functions.js') }}"></script>
<!-- end -->
@endpush