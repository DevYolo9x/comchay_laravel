@extends('homepage.layout.home')
@section('content')
<nav
    class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('')?>" class="text-blue font-bold">Trang chủ</a></li>
                @foreach($breadcrumb as $k=>$v)
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"
                        class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
                @endforeach
            </ol>
        </nav>
    </div>
</nav>
<?php
$listAlbums = json_decode($detail->image_json, true);
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
$slideShipping = Cache::remember('slideShipping', 60, function () {
    return \App\Models\CategorySlide::where('keyword', 'shipping')->select('id','title')->first();
});
if(count($detail->products_color) > 0){
    $type= 'variable';
}else{
    $type= 'simple';
}
//lay categories attribute

$version = getBlockAttr($detail['version_json']);

?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<!-- comment product -->
<script type="text/javascript" src="{{asset('product/rating/bootstrap-rating.min.js')}}"></script>
<link href="{{asset('product/rating/bootstrap-rating.css')}}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<main class="py-0 md:py-8">
    <div class=" container mx-auto">
        <section
            class="<?php if(svl_ismobile() == 'is desktop'){?>flex gap-10<?php }else{?>grid grid-cols-1<?php }?>  mt-4 ">
            <div
                class="<?php if(svl_ismobile() == 'is desktop'){?>flex-1 w-[670px] gap-6 flex flex-col<?php }?> order-1 lg:order-0">
                <!-- START: slide images product PC-->
                <?php if(svl_ismobile() == 'is desktop'){?>
                <div class="hidden md:block desktopSlide">
                    <div class="overflow-hidden p-6 flex bg-white shadow rounded-2xl ">
                        @if(!empty($listAlbums))
                        <div thumbsSlider="" class="swiper mySwiper"
                            style="width:80px; margin-right: 16px;height: 538px;">
                            <div class="swiper-wrapper">
                                @foreach($listAlbums as $key=>$item)
                                <div class="swiper-slide ">
                                    <img src="{{$item}}" alt="{{$detail->title}}" />
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="swiper mySwiper2 flex-1 ml-4 overflow-hidden">
                            <div class="swiper-wrapper">
                                @foreach($listAlbums as $key=>$item)
                                <div class="swiper-slide ">
                                    <img src="{{$item}}" alt="{{$detail->title}}" class="w-full object-cover h-full" />
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                </div>
                <script>
                var swiper = new Swiper(".mySwiper", {
                    loop: false,
                    spaceBetween: 15,
                    slidesPerView: 7,
                    freeMode: true,
                    watchSlidesProgress: true,
                    direction: "vertical",
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
                var swiper2 = new Swiper(".mySwiper2", {
                    loop: false,
                    spaceBetween: 5,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    thumbs: {
                        swiper: swiper,
                    },
                });
                </script>

                <style>
                .desktopSlide .mySwiper .swiper-slide {
                    height: 78px !important;
                    opacity: 0.4;
                    border-radius: 8px;
                    cursor: pointer;
                    overflow: hidden;
                    position: relative;
                    border-width: 1px;
                }

                .desktopSlide .mySwiper .swiper-slide-thumb-active {
                    opacity: 1;
                }

                .desktopSlide .swiper-button-next,
                .desktopSlide .swiper-button-prev {
                    height: 40px;
                    width: 40px;
                    background: rgba(248, 250, 252, 1);
                    border-radius: 100%;

                }

                .desktopSlide .swiper-button-next {
                    top: auto;
                    bottom: 0px;
                    left: 50%;
                    transform: translateX(-50%) rotate(90deg);
                }

                .desktopSlide .swiper-button-prev {
                    top: 23px;
                    left: 50%;
                    transform: translateX(-50%) rotate(90deg);
                }

                .desktopSlide .swiper-button-next:after,
                .desktopSlide .swiper-rtl .swiper-button-prev:after,
                .desktopSlide .swiper-button-prev:after,
                .desktopSlide .swiper-rtl .swiper-button-next:after {
                    font-size: 16px;
                    color: rgb(128, 128, 137);
                }
                </style>
                <?php }?>
                <!-- Swiper JS -->

                <!-- END: slide product image PC-->
                <div class="px-4 pb-6 bg-white md:shadow md:rounded-2xl">
                    <section class="section-description mt-6">
                        <div class="flex flex-wrap items-center space-x-2">
                            <h3 class="ml-2 uppercase font-medium cursor-pointer changeAtiveTab tab-1 active  hover:border-d61c1f hover:text-d61c1f cursor-pointer  item px-3 py-2 mb-2 inline-block mr-2 border"
                                onclick="changeAtiveTab(event,'tab-1')">Thông tin sản phẩm</h3>
                            <h3 class="ml-2 uppercase font-medium cursor-pointer changeAtiveTab tab-2 hover:border-d61c1f hover:text-d61c1f cursor-pointer  item px-3 py-2 mb-2 inline-block mr-2 border"
                                onclick="changeAtiveTab(event,'tab-2')">Bảng size</h3>
                            <h3 class="ml-2 uppercase font-medium cursor-pointer changeAtiveTab tab-3 hover:border-d61c1f hover:text-d61c1f cursor-pointer  item px-3 py-2 mb-2 inline-block mr-2 border"
                                onclick="changeAtiveTab(event,'tab-3')">Giới thiệu về
                                {{$fcSystem['homepage_brandname']}}</h3>
                        </div>
                        <div class="content-detail-product mt-4 relative overflow-hidden tab-content">
                            <div class="ProseMirror space-y-2 tab" id="tab-1">
                                <?php echo $detail->content?>
                            </div>
                            <div class="ProseMirror space-y-2 tab hidden" id="tab-2">
                                <?php echo $fcSystem['homepage_size']?>
                            </div>
                            <div class="ProseMirror space-y-2 tab hidden" id="tab-3">
                                <?php echo $fcSystem['homepage_aboutus']?>
                            </div>
                        </div>
                        <script type="text/javascript">
                        function changeAtiveTab(event, tabID) {
                            $('.tab-content .tab').addClass('hidden');
                            $('#' + tabID).removeClass('hidden');
                            $('.changeAtiveTab').removeClass('active');
                            $('.' + tabID).addClass('active');
                        }
                        </script>

                    </section>
                    <!-- START: đánh giá sản phẩm -->
                    @include('product.frontend.product.comment.index')
                    <!-- END: đánh giá sản phẩm -->

                </div>
            </div>
            <div
                class="order-0 lg:order-1 box_product_detail bg-white  <?php if(svl_ismobile() == 'is desktop'){?>shadow rounded-2xl sticky overflow-hidden right-0 bottom-0 left-0 h-full top-[20px]<?php }?>">
                <!-- START: slide product image mobile and table -->

                <?php if(svl_ismobile() == 'is mobile' || svl_ismobile() == 'is tablet'){?>
                <div class="block lg:hidden">
                    <div class="overflow-hidden ">
                        @if(!empty($listAlbums))
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="swiper mySwiper2 flex-1 ml-4 overflow-hidden">
                            <div class="swiper-wrapper">
                                @foreach($listAlbums as $key=>$item)
                                <div class="swiper-slide ">
                                    <img src="{{$item}}" alt="{{$detail->title}}" class="w-full object-cover h-full" />
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper mt-2">
                            <div class="swiper-wrapper">
                                @foreach($listAlbums as $key=>$item)
                                <div class="swiper-slide ">
                                    <img src="{{$item}}" alt="{{$detail->title}}" />
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        @endif
                    </div>
                </div>
                <script>
                var swiper = new Swiper(".mySwiper", {
                    loop: false,
                    spaceBetween: 15,
                    slidesPerView: 4,
                    freeMode: true,
                    watchSlidesProgress: true,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
                var swiper2 = new Swiper(".mySwiper2", {
                    loop: false,
                    spaceBetween: 5,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    thumbs: {
                        swiper: swiper,
                    },
                });
                </script>
                <?php }?>
                <!-- END-->
                <div class="flex-1 overflow-auto p-4">
                    <div class="flex flex-col space-y-4">
                        <div class="flex flex-col space-y-3">
                            <div class="flex flex-col">
                                <h1 class="font-semibold text-2xl">{{$detail->title}}</h1>
                                <div class="section-subtitle flex text-gray-20 mt-1 flex-wrap divide">
                                    <span class="mr-3 text-ui">
                                        CODE: <span class="product_code text-d61c1f">{{$detail->code}}</span>
                                    </span>
                                    @if($brand)
                                    <span class="mr-3 text-ui">
                                        Thương hiệu: <a href="{{route('brandURL',['slug' => $brand->slug])}}"
                                            class=" text-d61c1f">{{$brand->title}}</a>
                                    </span>
                                    @endif
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <a href="javascript:void(0)" class="text-blue-400 cursor-pointer scrollCmt">
                                                {{$comment_view['totalComment']}} đánh giá
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-1 flex items-center">
                                    <span class="text-red-600 text-2xl font-extrabold product_price_final">
                                        {{$price['price_final']}}
                                    </span>
                                    <div class="ml-2">
                                        <span class="line-through text-lg product_price_old">
                                            {{$price['price_old']}}
                                        </span>

                                        <span class="text-2xl text-red-600 ml-1 product_percent">
                                            @if(!empty($price['percent']))
                                            -{{$price['percent']}}
                                            @endif
                                        </span>

                                    </div>
                                </div>
                            </div>
                            @if($detail->description)
                            <div class="bg-red-50 rounded-lg px-4 py-3">
                                <?php echo $detail->description?>
                            </div>
                            @endif
                        </div>
                        @if($type == 'variable')
                        @if(isset($version['version']))
                        <?php if(count($version['version']) > 1){?>
                        @foreach($version['version'] as $key=>$value)
                        @if(count($detail->products_color) > 0)
                        <?php if($key == 1){?>
                        <div class="section-color-picker">
                            <div class="font-black mb-2">
                                <?php echo $value['title']?>
                            </div>
                            <div class="inline-block">
                                @foreach($detail->products_color as $key=>$item)
                                <?php
                                if($item->image_version){
                                    $image_version = $item->image_version;
                                }else{
                                    $image_version = $detail->image;
                                }
                                ?>
                                <div class=" <?php if($item->stock == 0){?>disabled<?php }else{?>colors hover:border-d61c1f hover:text-d61c1f cursor-pointer<?php }?>  item px-3 py-2 mb-2 inline-block mr-2 border"
                                    data-id="{{$item->product_color_id}}" data-image="{{$image_version}}">
                                    {{$item->title}}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <?php }else{?>
                        <div class="section-color-picker hidden">
                            <div class="font-black mb-2">
                                <?php echo $value['title']?>
                            </div>
                            <div class="inline-block" id="loadSize">
                                @foreach($detail->products_color as $key=>$item)
                                @if($key==0)
                                @foreach($item->products_versions as $k=>$val)
                                <?php echo htmlSize($val, $detail->image);?>
                                @endforeach
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <?php }?>
                        @endif
                        @endforeach
                        <?php }else{ ?>
                        @if(isset($version['version']))
                        @foreach($version['version'] as $key=>$value)
                        <div class="section-color-picker ">
                            <div class="font-black mb-2">
                                <?php echo $value['title']?>
                            </div>
                            <div class="inline-block" id="loadSize">
                                @foreach($detail->products_versions as $key=>$item)
                                <?php echo htmlSize($item, $detail->image);?>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <?php }?>
                        @endif
                        @endif



                    </div>
                    @if($type == 'simple')
                    <?php
                        $hiddenAddToCart = 0;
                        $product_stock_title = '';
                        $quantityStock = '';
                        if($detail->inventory == 1){
                            if($detail->inventoryPolicy == 0){
                                if($detail->inventoryQuantity == 0){
                                    $hiddenAddToCart = 1;
                                    $product_stock_title =  '<span class="product_stock">Hết hàng</span>';
                                }else{
                                    $quantityStock = $detail->inventoryQuantity;
                                    $product_stock_title = '<span class="product_stock">'.$detail->inventoryQuantity.'</span> sản phẩm có sẵn';
                                }

                            }else{
                                $product_stock_title = '<span class="product_stock"></span> sản phẩm có sẵn';
                            }
                        }else{
                            $product_stock_title = '<span class="product_stock"></span> sản phẩm có sẵn';
                        }
                    ?>
                    @endif
                    <div class="product-details w-full py-4 ">
                        <div class="font-black mb-2">Số lượng</div>
                        <div class="flex items-center">
                            <div
                                class="custom-number-input h-10 w-32 flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                <button
                                    class="card-dec bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none"
                                    style="line-height:40px">
                                    <span class="m-auto text-2xl font-thin">−</span>
                                </button>
                                <input type="number" max="{{!empty($quantityStock)?$quantityStock:''}}"
                                    class="card-quantity outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                                    name="custom-input-number" value="1"></input>
                                <button
                                    class="card-inc bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer"
                                    style="line-height:40px">
                                    <span class="m-auto text-2xl font-thin">+</span>
                                </button>

                            </div>
                            <div class="ml-2 text-red-600 font-bold">
                                @if($type == 'simple')
                                <?php
                                   echo $product_stock_title;
                                ?>
                                @else
                                <span class="product_stock"></span> sản phẩm có sẵn
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 flex items-center w-full space-x-2">
                            <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}"
                                data-price="<?php echo !empty($price['price_final_none_format'])?$price['price_final_none_format']:0?>"
                                data-cart="0" data-src="" data-type="{{$type}}"
                                class="addtocart uppercase font-black h-12 w-1/2 text-white bg-red-600 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                Thêm vào giỏ
                            </button>
                            <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}"
                                data-price="<?php echo !empty($price['price_final_none_format'])?$price['price_final_none_format']:0?>"
                                data-cart="1" data-src="" data-type="{{$type}}"
                                class="addtocart uppercase font-black h-12 w-1/2 text-white bg-black flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                mua ngay
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="product-hotline">
                            <span class="uppercase">Hotline</span>
                            <a href="tel:0968 034 918" class="text-2xl font-bold">{{$fcSystem['contact_hotline']}}</a>
                            <span class="small">
                                {{$fcSystem['contact_time']}}
                            </span>
                        </div>
                        @if($slideShipping->slides->count() > 0)
                        <div class="product-hotline product-policy">
                            <span>{{$slideShipping->title}}</span>
                            <ul class="no-bullets">
                                @foreach($slideShipping->slides as $Slide)
                                <li>
                                    <div class="icon">
                                        <img src="{{asset($Slide->src)}}" alt="{{$Slide->title}}">
                                    </div>
                                    <span>{{$Slide->title}}</span>
                                    <span class="small">{{$Slide->description}}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <style>
                        .product-hotline>span {
                            color: #26BB4E;
                            display: block;
                            font-weight: normal;
                        }

                        .product-hotline>a {
                            position: relative;
                            display: inline-block;
                            line-height: 30px;
                            color: #d61c1f;
                        }

                        .product-hotline span.small {
                            color: #666666 !important;
                            margin-left: 5px;
                            font-weight: normal !important;
                            text-transform: none !important;
                            margin-bottom: 0 !important;
                            display: inline-block !important;
                            margin-left: 5px;
                            font-size: 14px
                        }

                        .product-policy ul {
                            margin: 0;
                        }

                        .product-policy ul li {
                            display: flex;
                            align-items: center;
                        }

                        .product-policy ul li .icon {
                            display: inline-block;
                            margin-right: 5px;
                        }
                        </style>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-10 px-4">
            <h2 class="font-bold text-2xl mb-5">Sản phẩm liên quan</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 -mx-3">
                @foreach($productSame as $key=>$item)
                <?php  echo htmlItemProduct($k,$item);?>
                @endforeach
            </div>
        </section>
    </div>
</main>


@endsection
@push('javascript')
@if($type == 'simple')
<?php if($hiddenAddToCart == 1){?>
<script>
$('.addtocart').remove();
</script>
<?php }?>
@endif
@include('product.frontend.product.common.style')
<script src="{{ asset('frontend/library/product.js') }}"></script>
@endpush