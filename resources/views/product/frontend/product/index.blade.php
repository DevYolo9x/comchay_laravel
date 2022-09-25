@extends('homepage.layout.home')
@section('content')
<?php
$listAlbums = json_decode($detail->image_json, true);
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
if ($detail->inventory == 1 && $detail->inventoryPolicy  == 0 && $detail->inventoryQuantity == 0) {
    $stock = $fcSystem['title_21'];
} else {
    $stock = $fcSystem['title_20'];
}
?>
<div id="main" class="main-product-detail py-5">
    <div class="container mx-auto px-3">
        <div class="breadcrumb mb-3">
            <ul class="flex flex-wrap">
                <li><a href="{{url('')}}">{{$fcSystem['title_7']}}</a></li>
                @foreach($breadcrumb as $k=>$v)
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-Orangefc5">{{ $v->title}}</a></li>
                @endforeach
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li>{{$detail->title}}</li>
            </ul>
        </div>
        <div class="content-product-detail">
            <div class="bg-white p-[10px] md:p-[25px]">
                <div class="row flex flex-wrap justify-between -mx-3">
                    <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full px-3">
                        <div class="overflow-hidden ">
                            @if(!empty($listAlbums))
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 flex-1 ml-4 overflow-hidden">
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
                                        <img src="{{$item}}" alt="{{$detail->title}}" style="object-fit: cover;height: 100%;" />
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full px-3 lg:mt-0 md:mt-0 sm:mt-4 mt-4">
                        <h1 class="text-f25 font-bold mb-[15px]">
                            {{$detail->title}}
                        </h1>
                        <p class="text-f14 mb-[3px]">
                            {{$fcSystem['title_17']}}: <span class="text-blue_primary"> {{$detail->code}}</span>
                        </p>
                        <p class="text-f14">
                            @if($brand)
                            {{$fcSystem['title_18']}}:
                            <a href="{{route('brandURL',['slug' => $brand->slug])}}" class="text-blue_primary">{{$brand->title}}</a> |
                            @endif
                            {{$fcSystem['title_19']}}: <span class="text-blue_primary">{{$stock}}</span>
                        </p>
                        <p class="price mt-[10px] border-b-[1px] pb-[10px]">
                            <span class="text-f25 font-bold text-red-600">{{$price['price_final']}}</span>
                            @if(!empty($price['price_old']))
                            <del class="text-f16 text-gray-400 pl-[10px]">{{$price['price_old']}}</del>
                            @endif
                        </p>
                        <div class="desc text-f14 mt-[15px]">
                            <?php echo $detail->description ?>
                        </div>
                        <div class="w-full py-4">
                            <div class="font-black mb-2">Số lượng</div>
                            <div class="custom-number-input h-10 w-32 flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                                <button class="card-dec bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none leading-[50px]">
                                    <span class="m-auto text-2xl font-thin">−</span>
                                </button>
                                <input type="number" class="card-quantity outline-none focus:outline-none text-center w-full bg-gray-100 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none" name="custom-input-number" value="1" />
                                <button class="card-inc bg-gray-200 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer leading-[50px]">
                                    <span class="m-auto text-2xl font-thin">+</span>
                                </button>
                            </div>
                            <div class="mt-5 flex items-center w-full space-x-2">
                                <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="0" class="addtocart uppercase font-black h-12 w-1/2 text-white bg-red-600 flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                    Thêm vào giỏ
                                </button>
                                <button data-quantity="1" data-id="{{$detail->id}}" data-title="{{$detail->title}}" data-price="<?php echo !empty($price['price_final_none_format']) ? $price['price_final_none_format'] : 0 ?>" data-cart="1" class="addtocart uppercase font-black h-12 w-1/2 text-white bg-black flex-1 cursor-pointer items-center inline-flex rounded-md px-6 justify-center">
                                    mua ngay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start: box 5 -->
            <section class="mt-6 md:mt-10 description-section wow fadeInUp">
                <div class="tab-detail">
                    <nav class="tabs flex justify-start">
                        <button data-target="panel-1" class="px-[15px] text-f15 md:text-f18 font-bold uppercase mr-[5px] md:mr-[15px] tab active block hover:text-Orangefc5 focus:outline-none">
                            {{$fcSystem['title_22']}}
                        </button>
                        <button data-target="panel-2" class="p-[15px] text-f15 md:text-f18 font-bold uppercase mx-[5px] md:mx-[15px] tab block hover:text-Orangefc5 focus:outline-none">
                            {{$fcSystem['title_24']}} ({{$comment_view['totalComment']}})
                        </button>
                    </nav>
                </div>
                <div id="panels" class="p-[10px] md:p-[20px] bg-white">
                    <div class="panel-1 tab-content active">
                        <div class="content-content">
                            <?php echo $detail->content ?>
                        </div>
                    </div>
                    <div class="panel-2 tab-content tab-content bg-white">
                        @include('product.frontend.product.comment.index')
                    </div>

                </div>
            </section>
            <!-- end: box5 -->
        </div>
        @if(!$productSame->isEmpty())
        <div class="raleted-product mt-5 md:mt-10">
            <h2 class="text-center text-f25 font-bold uppercase">{{$fcSystem['title_26']}}</h2>
            <div class="bg-white mt-5 p-[10px] md:p-[20px]">
                <div class="slider-raleted-product owl-carousel">
                    @foreach($productSame as $key=>$value)
                    <?php
                    $price = getPrice(array('price' => $value->price, 'price_sale' => $value->price_sale, 'price_contact' =>
                    $value->price_contact));
                    //get comment()
                    $rate = getRateOfComment($value->id, 'products');
                    ?>
                    <div class="item group">
                        <div class="img border border-gray-100 overflow-hidden">
                            <a href="{{route('routerURL',['slug' => $value->slug])}}" class=" a-custom "><img src="{{asset($value->image)}}" alt="{{$value->title}}" class="h-[210px] md:h-[92px] w-full object-contain lg:object-cover  img-custom" /></a>
                        </div>
                        <div class="nav-img mt-[10px]">
                            <h3 class="title-1 text-f15 font-semibold hover:text-Orangefc5 line-clamp line-clamp-2">
                                <a href="{{route('routerURL',['slug' => $value->slug])}}" class="group-hover:text-Orangefc5">{{$value->title}}</a>
                            </h3>
                            <p class="start py-[5px]">
                                <input type="hidden" class="rating-disabled" value="{{(float)$rate->rate}}" disabled="disabled" />
                            </p>
                            <div>
                                <span class="text-f15 font-bold text-red-600">{{$price['price_final']}}</span>
                                @if (!empty($price['price_old']))
                                <del class="pl-[5px] text-gray-400 text-f13">{{$price['price_old']}}</del>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
@push('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<style>
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .section-product .item .nav-img .title-1 {
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 20px;
        -webkit-line-clamp: 2;
        height: 40px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }

    .section-product .item:hover .img img {
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
    }

    .section-product .item .img img {
        height: 275px;
        object-fit: cover;
    }

    .section-product .item .img {
        overflow: hidden;
    }

    .section-product .tabs button.active {
        border-bottom: 2px solid #fc5a34;
        color: #fc5a34;
    }

    @media only screen and (max-width: 736px) {
        .section-product .item .img img {
            height: 200px;
        }
    }

    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    body {
        background-color: #f5f4f2;
    }

    .mySwiper .swiper-slide {
        opacity: 0.4;
        border: 1px solid #dddddd;
    }

    .mySwiper .swiper-slide-thumb-active {
        opacity: 1;
    }
</style>
@endpush
@push('javascript')
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: false,
        spaceBetween: 15,
        slidesPerView: 5,
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
@endpush