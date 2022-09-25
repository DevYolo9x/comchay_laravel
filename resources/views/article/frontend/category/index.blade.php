@extends('homepage.layout.home')
@section('content')
<main>
    <div class="container px-1 md:px-0 mx-auto">

        <h1 class="hidden">{{$detail->title}}</h1>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                @include('homepage.common.aside')
            </div>
            <div class="col-span-12 lg:col-span-9 mt-5 md:mt-0 order-0 lg:order-1">
                <div class="breadcrumb py-[10px]">
                    <ul class="flex flex-wrap">
                        <li><a href="{{url('')}}">{{$fcSystem['title_7']}}</a></li>
                        @foreach($breadcrumb as $k=>$v)
                        <li><span class="text-gray-500 mx-2">/</span></li>
                        <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-Orangefc5">{{ $v->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3">
                    @if($data)
                    @foreach($data as $k=>$item)
                    <div class="w-full md:w-1/3 px-[5px] md:px-3 mb-[15px] md:mb-6 wow fadeInUp flex flex-col">
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
                    @endif

                </div>
                <div class="mt-5 flex justify-center">
                    <?php echo $data->links() ?>
                </div>
            </div>
        </div>



    </div>
</main>
@endsection