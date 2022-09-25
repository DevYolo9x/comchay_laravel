@extends('homepage.layout.home')
@section('content')
<div id="main" class="main-new-detail">
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                @include('homepage.common.aside')
            </div>
            <div class="col-span-12 lg:col-span-9 mt-5 md:mt-0 order-0 lg:order-1">
                <div class="breadcrumb  py-[10px]">
                    <ul class="flex flex-wrap">
                        <li><a href="{{url('')}}">{{$fcSystem['title_7']}}</a></li>
                        @foreach($breadcrumb as $k=>$v)
                        <li><span class="text-gray-500 mx-2">/</span></li>
                        <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-Orangefc5">{{ $v->title}}</a></li>
                        @endforeach
                    </ul>

                </div>
                <div class="content-new-page mt-3">
                    <h1 class="text-f20 font-bold">{{$detail->title}}</h1>
                    <p class="text-f15 text-gray-400 my-[10px]">{{$fcSystem['title_12']}}: {{$detail->created_at}}</p>
                    <div class="article-detail-content">
                        <?php echo $detail->content ?>
                        <style>
                            .article-detail-content p {
                                margin-bottom: 10px;
                            }

                            .article-detail-content img {
                                max-width: 100% !important;
                                height: auto !important
                            }
                        </style>
                    </div>
                </div>
                @if(!$sameArticle->isEmpty())
                <!--  start: box 2 -->
                <section class="mb-5 md:mb-14 new-home mt-8 md:mt-14 wow fadeInUp">

                    <h2 class="h2-category text-global font-bold text-lg uppercase -tracking-tighter relative pb-1">Bài viết liên quan</h2>
                    <div class="grid grid-cols-3 gap-6 mt-3">
                        @foreach($sameArticle as $key=>$item)
                        <div class="item item-custom group">
                            <div class="img flex-shrink-0">
                                <a href="{{route('routerURL',['slug' => $item->slug])}}">
                                    <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full object-cover h-[200px]" />
                                </a>
                            </div>
                            <div class="nav-item mt-[15px] flex flex-1 flex-col">
                                <div class="flex flex-1 flex-col">
                                    <div class="mb-1">
                                        <h3 class="text-f15 font-semibold mt-[10px] title-4 line-clamp line-clamp-2">
                                            <a href="{{route('routerURL',['slug' => $item->slug])}}" class="hover:text-Orangefc5 transition-all">{{$item->title}}</a>
                                        </h3>
                                        <p class="date text-gray-500  uppercase my-[7px] text-f14">
                                            {{$fcSystem['title_12']}}: {{$item->created_at}}
                                        </p>
                                    </div>
                                    <div class="flex flex-col flex-shrink-0 mt-auto">
                                        <div class="line-clamp line-clamp-3">
                                            <?php echo strip_tags($item->description) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{route('routerURL',['slug' => $item->slug])}}" class="text-Orangefc5 mt-2 text-f15 transition-all group-hover:pl-[8px] flex items-center">
                                        <span>XEM THÊM</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                <!-- end:box 2 -->
                @endif
            </div>
        </div>



    </div>
</div>

@endsection
@push('css')
<style>
    .article-detail-content img {
        max-width: 100% !important;
        margin: 0px auto;
    }

    @media (max-width:767px) {
        .article-detail-content img {
            height: auto !important
        }
    }
</style>

@endpush
@push('javascript')
<script>
    $('.owl-blog-slide').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        margin: 35,
        navText: [
            '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-7 w-7\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" stroke-width=\"2\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M15 19l-7-7 7-7\" /></svg>',
            '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-7 w-7\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\" stroke-width=\"2\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M9 5l7 7-7 7\" /></svg>'
        ],
        responsive: {
            0: {
                items: 1,

            },
            767: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });
</script>
@endpush