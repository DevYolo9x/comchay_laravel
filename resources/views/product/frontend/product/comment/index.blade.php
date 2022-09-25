<?php
$list_images_cmt = [];
foreach ($comment_view['listComment'] as $v) {
    if (!empty($v->images)) {
        $tmp_images_cmt = json_decode($v->images, TRUE);
        if (!empty($tmp_images_cmt)) {
            foreach ($tmp_images_cmt as $v) {
                $list_images_cmt[] = $v;
            }
        }
    }
}
?>
<?php

$arrayRate5 = $arrayRate4 = $arrayRate3 = $arrayRate2 = $arrayRate1 = 0;
$arrayRate5PT = $arrayRate4PT = $arrayRate3PT = $arrayRate2PT = $arrayRate1PT = 0;
if (isset($comment_view) && is_array($comment_view) && count($comment_view)) {
    $averagePoint = round($comment_view['averagePoint']);
    $totalComment = $comment_view['totalComment'];
    $arrayRate5 = $comment_view['arrayRate'][5];
    if ($arrayRate5 > 0) {
        $arrayRate5PT = ($arrayRate5 / $totalComment) * 100;
    }
    $arrayRate4 = $comment_view['arrayRate'][4];
    if ($arrayRate4 > 0) {
        $arrayRate4PT = ($arrayRate4 / $totalComment) * 100;
    }
    $arrayRate3 = $comment_view['arrayRate'][3];
    if ($arrayRate3 > 0) {
        $arrayRate3PT = ($arrayRate3 / $totalComment) * 100;
    }
    $arrayRate2 = $comment_view['arrayRate'][2];
    if ($arrayRate2 > 0) {
        $arrayRate2PT = ($arrayRate2 / $totalComment) * 100;
    }
    $arrayRate1 = $comment_view['arrayRate'][1];
    if ($arrayRate1 > 0) {
        $arrayRate1PT = ($arrayRate1 / $totalComment) * 100;
    }
}
?>

<div id="section-rating-comment" class="flex flex-col space-y-4 mt-6 pt-6 border-t">
    <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
        </svg>
        <h3 class="ml-2 text-[19px] font-bold"><a href="javascript:void(0)">Đánh giá &amp; nhận xét</a></h3>
    </div>

    <div class="grid grid-cols-12">
        <div class="col-span-12 md:col-span-5">
            <div class="flex items-center space-x-2">
                <div class="text-5xl font-bold whitespace-nowrap">{{$comment_view['averagePoint']}}</div>
                <div class="text-sm">
                    <div class="relative flex averagePoint">
                        <input type="hidden" class="rating-disabled" value="{{$comment_view['averagePoint']}}" disabled="disabled" />
                    </div>
                    <div>
                        {{$comment_view['totalComment']}} nhận xét
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="5" disabled="disabled" />
                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">
                        <div class="bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate5PT ?>%;">
                        </div>
                    </div>
                    <div class="text-sm"><?php echo $arrayRate5 ?></div>
                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="4" disabled="disabled" />
                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">
                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate4PT ?>%;">
                        </div>
                    </div>
                    <div class="text-sm"><?php echo $arrayRate4 ?></div>

                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="3" disabled="disabled" />
                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">

                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate3PT ?>%;">
                        </div>

                    </div>
                    <div class="text-sm"><?php echo $arrayRate3 ?></div>

                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">
                        <input type="hidden" class="rating-disabled" value="2" disabled="disabled" />

                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">

                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate2PT ?>%;">
                        </div>

                    </div>
                    <div class="text-sm"><?php echo $arrayRate2 ?></div>

                </div>
                <div class="flex items-center mx-1">
                    <div class="flex">

                        <input type="hidden" class="rating-disabled" value="1" disabled="disabled" />

                    </div>
                    <div class="w-[138px] h-[6px] relative mx-2 rounded-2xl bg-slate-200">

                        <div class=" bg-slate-500 absolute top-0 left-0 rounded-2xl h-[6px]" style="width: <?php echo $arrayRate1PT ?>%;">
                        </div>

                    </div>
                    <div class="text-sm"><?php echo $arrayRate1 ?></div>

                </div>
            </div>
        </div>
        <div class="col-span-12 md:col-span-7 mt-5 md:mt-0">

            @if(empty($comment_view['totalComment']))
            <div class="flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-11 w-11 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                <span class="block text-[19px] font-bold">Chưa có đánh giá &amp; nhận xét</span>
                <span class="block text-[14px]">
                    Nên mua hay không? Hãy giúp anh em bạn nhé
                </span>
            </div>
            @endif
            @if(!empty($list_images_cmt))
            <div class="">
                <h2 class="text-lg font-medium mb-2">Tất cả hình
                    ảnh(<?php echo !empty($list_images_cmt) ? count($list_images_cmt) : 0 ?>)</h2>
                <div class="flex flex-wrap md:flex-nowrap">
                    @foreach($list_images_cmt as $kimage=>$image)
                    @if($kimage <= 3) <div class="w-[120px] h-[120px] object-cover mr-4 cursor-pointer border border-slate-100 mb-2 review_images_item">
                        <div class="w-full h-full rounded bg-cover" style="background-image: url(<?php echo $image ?>);">
                        </div>
                </div>
                @endif
                @if($kimage == 4)
                <div class="w-[120px] h-[120px] object-cover cursor-pointer bg-cover relative rounded review_images_item" style="background-image: url(<?php echo $image ?>);">
                    @if(count($list_images_cmt) > 5)
                    <span class="absolute rounded top-1/2 left-1/2 w-full text-center text-white h-full font-bold" style="transform: translate(-50%,-50%);background-color: rgba(36, 36, 36, 0.7);    line-height: 120px;">+<?php echo count($list_images_cmt) - 5 ?>
                    </span>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            @endif
            <button onclick="modalHandler(true)" class="mt-4 flex items-center justify-center bg-red-600 h-12 rounded-md px-6 text-white font-semibold w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                Đánh giá
            </button>
        </div>


    </div>

    @if(!empty($list_images_cmt))
    <!-- START: filter comment -->
    <div class="col-span-12 mt-5">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4 font-normal ">Lọc xem theo</div>
            <div class="flex flex-wrap flex-grow space-x-4">
                <div class="filter_item mb-2 md:mb-0">
                    <div data-sort="id" class="filter_text flex items-center">
                        <span class="filter_check "><img src="{{url('images/check.png')}}"></span>
                        <span>Mới nhất</span>
                    </div>
                </div>
                <div class="filter_item mb-2 md:mb-0">
                    <div data-sort="gallery" class="filter_text flex items-center">
                        <span class="filter_check "><img src="{{url('images/check.png')}}"></span>
                        <span>Có hình ảnh</span>
                    </div>
                </div>
                <?php /*<div class="filter_item mb-2 md:mb-0">
                    <span class="filter_check "><img src="{{url('images/check.png')}}"></span>
                    <span data-sort="payment" class="filter_text">Đã mua hàng</span>
                </div>*/ ?>
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <div class="filter_item mb-2 md:mb-0">
                        <div data-sort="{{$i}}" class="filter_text flex items-center">
                            <span class="filter_check "><img src="{{asset('images/check.png')}}"></span>
                            <span>{{$i}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="ml-1">
                                <path d="M10 2.5L12.1832 7.34711L17.5 7.91118L13.5325 11.4709L14.6353 16.6667L10 14.0196L5.36474 16.6667L6.4675 11.4709L2.5 7.91118L7.81679 7.34711L10 2.5Z" stroke="#FFD52E" fill="#FFD52E"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99996 1.66675L12.4257 7.09013L18.3333 7.72127L13.925 11.7042L15.1502 17.5177L9.99996 14.5559L4.84968 17.5177L6.07496 11.7042L1.66663 7.72127L7.57418 7.09013L9.99996 1.66675ZM9.99996 3.57863L8.10348 7.81865L3.48494 8.31207L6.93138 11.426L5.97345 15.9709L9.99996 13.6554L14.0265 15.9709L13.0685 11.426L16.515 8.31207L11.8964 7.81865L9.99996 3.57863Z" fill="#FFD52E"></path>
                            </svg>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
    <!-- END: filter comment -->
    @endif
    <!-- START: comment item -->
    <div class="col-span-12 mt-7">
        <div id="getListComment">
            @include('product.frontend.product.comment.data')
        </div>

    </div>
    <!-- END: comment item -->
</div>
@push('javascript')
<!-- Code block starts -->
<div class="py-12 transition duration-150 ease-in-out z-10 fixed top-0 right-0 bottom-0 left-0 " id="modal" style="background:#0000007a;display: none">
    <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
        <div class="relative py-8 px-5  bg-white shadow-md rounded border border-gray-400">

            <h2 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">{{$detail->title}}</h2>
            <div class="modal-body">
                <form id="form-comment">
                    <div class="write-review__heading">Vui lòng đánh giá</div>
                    <div class="write-review__stars">
                        <input type="hidden" class="rating-disabled" value="5" name="rating" />
                        <input type="hidden" value="" name="images">
                    </div>
                    <div class="write-review__info">
                        <input value="" type="text" name="fullname" placeholder="Họ và tên" class="form-control" required>
                        <input value="" type="text" name="phone" placeholder="Số điện thoại" class="form-control">
                    </div>
                    <textarea rows="8" placeholder="Chia sẻ thêm thông tin sản phẩm" class="write-review__input" name="message" required></textarea>
                    <div class="error_comment">
                        <div class="alert-success bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-5" style="display: none" role="alert">
                            <div class="flex">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                    </svg></div>
                                <div>
                                    <p class="font-bold js_text_success"></p>
                                </div>
                            </div>
                        </div>
                        <div class="alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert" style="display: none">
                            <strong class="font-bold">Lỗi!</strong>
                            <span class="block sm:inline js_text_danger"></span>
                        </div>
                    </div>
                    <div class="write-review__images" style="display: none;">
                    </div>
                    <div class="write-review__buttons">
                        <input class="write-review__file" type="file" multiple="">
                        <button type="button" class="write-review__button write-review__button--image">
                            <img src="{{asset('images/d8ff2d5d709c730e12e11ba0b70a1285.jpg')}}"><span>Thêm
                                ảnh</span>
                        </button>
                        <button type="submit" class="write-review__button write-review__button--submit"><span>Gửi đánh
                                giá</span>
                        </button>
                    </div>
                </form>
            </div>
            <button class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600" onclick="modalHandler()" aria-label="close modal" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    </div>
</div>
@if(svl_ismobile() == 'is desktop')
<div class="UNFVx" style="opacity:0;z-index: -1;">
    <a class="btn-close"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z">
            </path>
        </svg><span>Đóng</span></a>

    <div class="main-slide-wrapper">
        <div class="main-slide-container">
            <?php $list_gallery = json_decode($detail->image_json, TRUE); ?>
            @if(!empty($list_images_cmt))
            <div class="cSlider cSlider--single">
                @foreach($list_images_cmt as $v)
                <div class="cSlider__item"><img src="{{$v}}" class="img-fluid fLNLeB" alt="{{$detail->title}}"></div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="slide-nav-wrapper">
        <div class="container">
            <div class="tab"><span class="tab-item actived">Hình ảnh thực tế từ khách
                    hàng(<?php echo count($list_images_cmt) ?>).</span></div>
            <div class="cSlider cSlider--nav">
                @foreach($list_images_cmt as $v)
                <div class="cSlider__item cSlider__item_child">
                    <div class="cSlider__item_child_2">
                        <img src="{{$v}}" alt="{{$detail->title}}" class="kipMhU">
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
<script src="{{asset('product/product-gallery-slider/slick.min.js')}}"></script>
<link rel='stylesheet' href="{{asset('product/product-gallery-slider/slick.css')}}">
<style>
    /**album anh cmt */
    .slick-active.is-active .cSlider__item_child_2 {
        border: 2px solid red;
    }

    .UNFVx .main-slide-wrapper .main-slide-container {
        width: 550px;
        margin: auto;
        position: relative;
    }

    .cSlider--single .slick-slide img {
        margin: 0px auto;
        display: block;
    }

    .cSlider--nav {
        margin-top: 10px;
    }

    .fLNLeB {
        object-fit: contain;
        width: 550px !important;
        height: 700px !important;
        background-color: #fff;
    }

    .cSlider__item_child {
        background: #fff;
        margin: 0px 2px;
    }

    .kipMhU {
        display: inline-block;
        height: 75px;
        width: 100%;
        object-fit: contain;
        position: relative;
    }

    .UNFVx .main-slide-wrapper {
        flex: 1 1 0%;
        position: relative;
    }


    .UNFVx .slide-nav-wrapper {
        flex: 0 0 130px;
    }

    .UNFVx .slide-nav-wrapper .container {
        width: 948px;
        margin: auto;
    }

    .UNFVx .slide-nav-wrapper .tab .tab-item {
        color: rgb(255, 255, 255);
        font-size: 18px;
        font-weight: 300;
        cursor: pointer;
        display: inline-block;
        padding: 0px 0px 3px;
        text-decoration: none;
        margin-right: 10px;
    }

    .UNFVx .slide-nav-wrapper .tab .tab-item.actived {
        text-decoration: none;
        border-bottom: 2px solid rgb(0, 127, 240);
    }

    .UNFVx {
        position: fixed;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        background-color: rgba(0, 0, 0, 0.95);
        z-index: 999;
    }

    .UNFVx .btn-close {
        cursor: pointer;
        position: absolute;
        top: 24px;
        right: 40px;
        z-index: 1;
        display: flex;
        flex-direction: column;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        color: rgb(204, 204, 204) !important;
        font-size: 40px;
    }

    .UNFVx .btn-close span {
        font-size: 14px;
    }

    .slick-prev-1 {
        display: block;
        position: absolute;
        z-index: 9999;
        width: 40px;
        height: 40px;
        top: 50%;
        transform: translateY(-50%);
        border: solid black;
        border-width: 0 3px 3px 0;
        padding: 3px;
        transform: translateY(-50%) rotate(135deg);
        -webkit-transform: translateY(-50%) rotate(135deg);
        left: 15px;
        cursor: pointer;
    }

    .slick-next-1 {
        cursor: pointer;
        display: block;
        position: absolute;
        z-index: 9999;
        width: 40px;
        height: 40px;
        top: 50%;
        right: 15px;
        border: solid black;
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
        transform: translateY(-50%) rotate(-45deg);
        -webkit-transform: translateY(-50%) rotate(-45deg);
    }
</style>
<script>
    $(document).ready(function() {
        $(document).on('click', '.review_images_item', function(e) {
            $(".UNFVx").css('opacity', 1);
            $(".UNFVx").css('z-index', 99999999);
        });
        $(document).on('click', '.btn-close', function(e) {
            $(".UNFVx").css('opacity', 0);
            $(".UNFVx").css('z-index', -1);

        });
        $('.cSlider--single').slick({
            slide: '.cSlider__item',
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            adaptiveHeight: true,
            infinite: false,
            useTransform: true,
            speed: 400,
            cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
            prevArrow: '<div class="slick-prev"><i class="fa fa-right></i></div>',
            nextArrow: '<div class="slick-next"><i class="ion-ios-arrow-right"></i><span class="sr-only sr-only-focusable">></span></div>'
        });

        $('.cSlider--nav').on('init', function(event, slick) {
                $(this).find('.slick-slide.slick-current').addClass('is-active');
            })
            .slick({
                slide: '.cSlider__item',
                slidesToShow: 12,
                slidesToScroll: 12,
                dots: false,
                focusOnSelect: false,
                infinite: false,
                arrows: true,
                prevArrow: '<div class="slick-prev-1"><i class="fa fa-angle-right></i></div>',
                nextArrow: '<div class="slick-next-1"><i class="fa fa-angle-left></i></div>',
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                    }
                }, {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    }
                }, {
                    breakpoint: 420,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                }]
            });

        $('.cSlider--single').on('afterChange', function(event, slick, currentSlide) {
            $('.cSlider--nav').slick('slickGoTo', currentSlide);
            $('.cSlider--nav').find('.slick-slide.is-active').removeClass('is-active');
            $('.cSlider--nav').find('.slick-slide[data-slick-index="' + currentSlide + '"]').addClass(
                'is-active');
        });

        $('.cSlider--nav').on('click', '.slick-slide', function(event) {
            event.preventDefault();
            var goToSingleSlide = $(this).data('slick-index');

            $('.cSlider--single').slick('slickGoTo', goToSingleSlide);
        });
    });
</script>
@endif

<script>
    /*modal form comment*/
    let modal = document.getElementById("modal");

    function modalHandler(val) {
        if (val) {
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }

    function fadeOut(el) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.1) < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }

    function fadeIn(el, display) {
        el.style.opacity = 0;
        el.style.display = display || "flex";
        (function fade() {
            let val = parseFloat(el.style.opacity);
            if (!((val += 0.2) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }
    /*END: modal form comment*/

    $(document).ready(function() {

        /*upload image comment*/
        $(document).on('click', '.write-review__button--image', function(e) {
            $(".write-review__file").click();
        });
        var inputFile = $('input.write-review__file');
        var uploadURI = '<?php echo route('components.uploadImagesComment') ?>';
        var processBar = $('#progress-bar');
        $('input.write-review__file').change(function(event) {
            var filesToUpload = inputFile[0].files;
            if (filesToUpload.length > 0) {
                var formData = new FormData();
                for (var i = 0; i < filesToUpload.length; i++) {
                    var file = filesToUpload[i];
                    formData.append('file[]', file, file.name);
                }
                // console.log(formData);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    url: uploadURI,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('.error_comment').removeClass('alert alert-danger');
                        $('.write-review__images').show();
                        var json = JSON.parse(data);
                        $('.write-review__images').append(json.html);
                        load_src_img();
                    },
                    error: function(jqXhr, json, errorThrown) {
                        // this are default for ajax errors
                        var errors = jqXhr.responseJSON;
                        $('.error_comment').removeClass('alert alert-success').addClass(
                            'alert alert-danger');
                        $('.error_comment').html('').html(errors.message);
                    },
                });
            }
        });

        function load_src_img() {
            var outputText = '';
            $('.write-review__images img').each(function() {
                var divHtml = $(this).attr('src');
                outputText += divHtml + '-+-';
            });
            $('#form-comment input[name="images"]').attr('value', outputText.slice(0, -3));
        }

        $(document).on('click', '.js_delete_image_cmt', function() {
            var me = $(this);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: uploadURI,
                type: 'post',
                data: {
                    file: me.attr('data-file'),
                    delete: 'delete'
                },
                success: function() {
                    $('.error_comment').removeClass('alert alert-danger').removeClass(
                        'alert alert-danger');
                    me.parent().remove();
                    load_src_img();
                },
                error: function(jqXhr, json, errorThrown) {
                    // this are default for ajax errors
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = "";
                    $.each(errors["errors"], function(index, value) {
                        errorsHtml += value + "/ ";
                    });
                    $('.error_comment').removeClass('alert alert-success').addClass(
                        'alert alert-danger');
                    $(".error_comment").html(errorsHtml).show();
                },
            });
        });
        /*end: upload images*/
        /*START: submit comment*/
        $('#form-comment').submit(function(event) {
            event.preventDefault();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "<?php echo route('commentFrontend.post') ?>",
                type: 'POST',
                dataType: "JSON",
                data: {
                    rating: $('#form-comment input[name="rating"]').val(),
                    images: $('#form-comment input[name="images"]').val(),
                    fullname: $('#form-comment input[name="fullname"]').val(),
                    phone: $('#form-comment input[name="phone"]').val(),
                    message: $('#form-comment textarea[name="message"]').val(),
                    module_id: "{{$detail->id}}"
                },
                success: function(data) {
                    if (data == 200) {
                        $('.error_comment .alert-danger').hide();
                        $('.error_comment .alert-success').show();
                        $('.error_comment .js_text_success').html("Gửi bình luận thành công!");
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        $('.error_comment .alert-danger').show();
                        $('.error_comment .alert-success').hide();
                        $('.error_comment .js_text_danger').html("Có lỗi xảy ra");
                    }
                },
                error: function(jqXhr, json, errorThrown) {
                    // this are default for ajax errors
                    var errors = jqXhr.responseJSON;
                    $('.error_comment .alert-danger').show();
                    $('.error_comment .alert-success').hide();
                    if (errors.message == "Unauthenticated.") {
                        $('.error_comment .js_text_danger').html(
                            "Bạn phải đăng nhập để sử dụng tính năng này");
                    } else {
                        $('.error_comment .js_text_danger').html(errors.message);
                    }
                },
            });
        });
        /*END: submit comment*/

        /*START: reply comment*/
        $(document).on('click', '.js_btn_reply', function(e) {
            e.preventDefault();
            let _this = $(this);
            let text = _this.text();
            if (text == "Bỏ bình luận") {
                _this.parent().find('.reply-comment').html('');
                _this.html('Bình luận');
            } else {
                let param = {
                    'parentid': _this.attr('data-id'),
                    'name': _this.attr('data-name'),
                };
                let reply = get_comment_html(param);
                $('.reply-comment').html('');
                $('.js_btn_reply').html('Bình luận');
                _this.parent().find('.reply-comment').html(reply);
                _this.attr('data-comment', 0);
                _this.html('Bỏ bình luận');
            }

        });

        function get_comment_html(param = '') {
            let comment = '';
            comment += '<div class="flex">';
            comment += '<div class="reply_comment_avatar mt-5 mr-2">';
            comment +=
                '<img src="{{asset("images/90e54b0a7a59948dd910ba50954c702e.png")}}" alt="avatar">';
            comment += '</div>';
            comment += '<div class="reply_comment_wrapper mt-5">';
            comment += '<span class="font-semibold mb-1">@' + param.name + '</span>';

            comment +=
                '<input value="" type="text" name="" placeholder="Họ và tên" class="js_input_reply_cmt mt-2" required=""><span class="reply_fullname"></span>';
            comment += '<div class="relative">';
            comment +=
                '<textarea placeholder="Viết câu trả lời" class="js_textarea_reply_cmt" required></textarea><span class="reply_message"></span>';
            comment += '<button type="button" class="js_reply_comment_submit" data-parent-id="' + param.parentid +
                '">';
            comment +=
                '<img src="{{asset("images/92f01c5a743f7c8c1c7433a0a7090191.png")}}" alt="icon submit">';
            comment += '</button>';
            comment += '</div>';
            comment += '</div>';
            comment += '</div>';
            comment += '<div class="reply_comment_error">';

            comment +=
                '<div class="alert-success bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-5" style="display: none" role="alert">';
            comment += '<div class="flex items-center">';
            comment += '<div class="py-1">';
            comment +=
                '<svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">';
            comment +=
                '<path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"></path>';
            comment += '</svg>';
            comment += '</div>';
            comment += '<div>';
            comment += '<p class="font-bold js_text_success"></p>';
            comment += '</div>';
            comment += '</div>';
            comment += '</div>';
            comment +=
                '<div class="alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert" style="display: none">';
            comment += '<strong class="font-bold">Lỗi!</strong>';
            comment += '<span class="block sm:inline js_text_danger"></span>';
            comment += '</div>';
            comment += '</div>';
            return comment;
        }
        $(document).on('click', '.js_reply_comment_submit', function() {
            var parent_id = $(this).attr('data-parent-id');
            let fullname = $('.js_input_reply_cmt').val();
            let message = $('.js_textarea_reply_cmt').val();
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: "<?php echo route('replyComment.post') ?>",
                type: 'POST',
                dataType: "JSON",
                data: {
                    parent_id: parent_id,
                    message: message,
                    fullname: fullname,
                },
                success: function(data) {
                    $('.reply_comment_error .alert-danger').hide();
                    $('.reply_comment_error .alert-success').show();
                    $('.reply_comment_error .js_text_success').html("Phản hồi bình luận thành công!");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(jqXhr, json, errorThrown) {
                    // this are default for ajax errors
                    var errors = jqXhr.responseJSON;
                    $('.reply_comment_error .alert-danger').show();
                    $('.reply_comment_error .alert-success').hide();
                    if (errors.message == "Unauthenticated.") {
                        $('.reply_comment_error').html('').html(
                            "Bạn phải đăng nhập để sử dụng tính năng này");
                    } else {
                        if (fullname == '') {
                            $('.js_input_reply_cmt').css('border-color', 'red')
                        }
                        if (fullname == '') {
                            $('.js_textarea_reply_cmt').css('border-color', 'red')
                        }
                        $('.reply_comment_error .js_text_danger').html(errors.message);
                    }

                },
            });
            return false;
        });
        /*END: reply comment */
        $(document).on('click', '.paginate_cmt a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var sort = $('.filter_item.active .filter_text').attr('data-sort');
            get_list_object(page, sort, true);
        });
        $(document).on('click', '.filter_text', function(event) {
            event.preventDefault();
            var sort = $(this).attr('data-sort');
            $('.filter_item').removeClass('active');
            $(this).parent().addClass('active');
            get_list_object(1, sort, false);
        });


        function get_list_object(page = 1, sort = 'id', animate = true) {
            setTimeout(function() {
                $.post('<?php echo route('getListComment.frontend') ?>', {
                        page: page,
                        module_id: '{{$detail->id}}',
                        sort: sort,
                        "_token": $('meta[name="csrf-token"]').attr("content")
                    },
                    function(data) {
                        $('#getListComment').html(data);
                        console.log(animate);
                        if (animate === true) {
                            $('html, body').animate({
                                scrollTop: $("#getListComment").offset().top
                            }, 200);
                        }

                    }
                );
            }, 210);
        }
        $(document).on('click', '.scrollCmt', function(event) {
            $('html, body').animate({
                scrollTop: $("#getListComment").offset().top
            }, 500);
        });
    });
</script>
<!-- Code block ends -->
<style>
    .fa.fa-star-o,
    .fa.fa-star {
        color: #FFD52E !important;
    }

    .write-review__stars .fa-star,
    .write-review__stars .fa-star-o {
        font-size: 35px;
        margin: 0px 5px;
    }

    /* comment form */
    .write-review__info {
        flex: 1 1 0%;
        align-items: flex-end;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
        margin: 12px 0px 0px;
    }

    .write-review__info input {
        width: 49%;
        height: 36px;
        background: 0px center;
        line-height: 36px;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        outline: 0px;
        border: 1px solid rgb(238, 238, 238);
        padding: 6px 12px;
        font-size: 14px;
    }

    .write-review__input {
        border: 1px solid rgb(238, 238, 238);
        padding: 12px;
        border-radius: 4px;
        resize: none;
        width: 100%;
        outline: 0px;
        margin: 12px 0px 12px;
    }

    .modal-body {
        position: relative;
        border-top: 1px solid #e5e5e5;
        padding-top: 15px
    }

    .write-review__heading {
        font-size: 18px;
        line-height: 24px;
        font-weight: 500;
        text-align: center;
        margin: 0px 0px 12px;
    }

    .write-review__stars {
        text-align: center;
    }

    .write-review__buttons {
        flex: 1 1 0%;
        align-items: flex-end;
        display: flex;
        -webkit-box-pack: justify;
        justify-content: space-between;
        padding: 0px 0px 16px;
        margin: 0px;
    }

    .write-review__file {
        position: absolute;
        height: 0px;
        width: 0px;
        visibility: hidden;
        opacity: 0;
        clip: rect(0px, 0px, 0px, 0px);
    }

    input[type=file] {
        display: block;
    }


    .write-review__button {
        width: 49%;
        height: 36px;
        border: 0px;
        background: 0px center;
        padding: 0px;
        line-height: 36px;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
        outline: 0px;
    }

    .write-review__button--image {
        color: rgb(11, 116, 229);
        border: 1px solid rgb(11, 116, 229);
    }

    .write-review__button--submit {
        background-color: rgb(11, 116, 229);
        color: rgb(255, 255, 255);
    }

    .write-review__button--image img {
        width: 15px;
        margin: 0px 4px 0px 0px;
    }

    .write-review__images {
        text-align: left;
        margin: 0px 0px 12px;
    }

    .write-review__image {
        display: inline-block;
        width: 48px;
        height: 48px;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        margin: 0px 12px 0px 0px;
        border: 1px solid rgb(224, 224, 224);
        border-radius: 4px;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .js_delete_image_cmt {
        width: 21px;
        height: 21px;
        background-color: rgb(255, 255, 255);
        border-radius: 50%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        line-height: 21px;
        font-size: 18px;
        display: none;
        text-align: center;
    }

    .write-review__image:hover::after {
        content: "";
        position: absolute;
        inset: 0px;
        background-color: rgba(36, 36, 36, 0.7);
    }

    .write-review__image:hover .js_delete_image_cmt {
        display: block;
    }

    /* end */
    /* review-sub-comment */
    .review-sub-comment {
        margin: 8px 0px 0px;
        display: flex;
    }

    .review-sub-comment:first-child {
        margin: 20px 0px 0px;
    }

    .review-sub-comment-avatar {
        width: 32px;
        height: 32px;
        background-size: cover;
        margin: 0px 8px 0px 0px;
        border-radius: 100%;
        min-width: 32px;
    }

    .review-sub-comment-inner {
        padding: 10px 12px;
        border: 1px solid rgb(242, 242, 242);
        background-color: rgb(250, 250, 250);
        border-radius: 12px;
        -webkit-box-flex: 1;
        flex-grow: 1;
    }

    .review-sub-comment-date {
        color: rgb(128, 128, 137);
        margin: 0px 0px 0px 6px;
        padding: 0px 0px 0px 8px;
        position: relative;
        z-index: 1;
        font-size: 13px;
        line-height: 20px;
        font-weight: 400;
    }

    .review-sub-comment-date::before {
        content: "";
        height: 2px;
        width: 2px;
        background-color: rgb(128, 128, 137);
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 0px;
        margin: -1px 0px 0px;
    }

    /* end*/
    /* reply comment */
    .review-comment__image {
        width: 80px;
        height: 80px;
        border-radius: 4px;
        background-size: cover;
        background-position: center center;

        cursor: pointer;
        margin-right: 5px
    }

    .reply_comment_avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-size: cover;
        background-position: center center;
        flex-shrink: 0;
    }

    .reply_comment_avatar img {
        display: block;
        border-radius: 50%;
        background-color: rgb(242, 242, 242);
    }

    .reply_comment_wrapper {
        z-index: 1;
        -webkit-box-flex: 1;
        flex-grow: 1;
    }

    .js_reply_comment_submit {
        position: absolute;
        z-index: 1;
        width: 17px;
        right: 12px;
        cursor: pointer;
        top: 13px;
    }

    .reply_comment_wrapper textarea,
    .reply_comment_wrapper input {
        border: 1px solid rgb(238, 238, 238);
        padding: 10px 40px 10px 12px;
        border-radius: 12px;
        width: 100%;
        outline: 0px;
        font-size: 13px;
        line-height: 20px;
        resize: none;
        overflow: hidden;
        margin-bottom: 10px;

    }

    /* end */


    .review-seller {
        display: flex;
        -webkit-box-align: center;
        align-items: center;
        font-size: 13px;
        font-weight: 400;
        line-height: 20px;
        color: rgb(0, 171, 86);
    }

    .review-check-icon {
        display: block;
        width: 14px;
        height: 14px;
        background-color: rgb(0, 171, 86);
        border-radius: 50%;
        position: relative;
        z-index: 1;
        margin: 0px 6px 0px 0px;
    }

    .review-check-icon::before {
        content: "";
        width: 6px;
        height: 3px;
        border-left: 1px solid rgb(255, 255, 255);
        border-bottom: 1px solid rgb(255, 255, 255);
        position: absolute;
        display: block;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -70%) rotate(-45deg);
    }


    .review_avatar {
        margin: 0px 12px 0px 0px;
        width: 48px;
        height: 48px;
        background-size: cover;
        border-radius: 50%;
        position: relative;
        z-index: 1;
    }

    .filter_check {
        width: 18px;
        height: 18px;
        margin-right: 5px;
        display: none;
    }

    .filter_item.active .filter_check {
        display: inline-block;
    }

    .filter_item {
        height: 32px;
        font-weight: 500;
        font-size: 14px;
        line-height: 20px;
        padding: 6px 12px;
        border-radius: 100px;
        color: rgb(56, 56, 61);
        background: rgb(245, 245, 250);
        cursor: pointer;
        display: flex;
        -webkit-box-align: center;
        align-items: center;
    }

    .averagePoint .fa-star,
    .averagePoint .fa-star-o {
        font-size: 25px;
    }
</style>
@endpush