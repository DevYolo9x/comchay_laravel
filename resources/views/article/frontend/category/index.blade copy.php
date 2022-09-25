@extends('homepage.layout.home')
@section('content')
<nav class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-gray-500 hover:text-gray-600">Trang chủ</a></li>
                @foreach($breadcrumb as $k=>$v)
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
                @endforeach
            </ol>
        </nav>
    </div>
</nav>
<main class="pb-11 px-4 md:px-0">

    <div class="container mx-auto mt-11">
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="col-span-1 md:col-span-1 lg:col-span-3 space-y-11 order-1">
                @include('article.frontend.aside')
            </div>
            <div class="col-span-1 md:col-span-1 lg:col-span-9 md:order-0 lg:order-2">
                @if($data)
                <div class="section-catalogue">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php foreach ($data as $k => $item) { ?>
                            <div class="article-item space-y-2">
                                <div class="article-img overflow-hidden">
                                    <a href="{{route('routerURL',['slug' => $item->slug])}}">
                                        <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="w-full h-[200px] object-cover">
                                    </a>
                                </div>
                                <div class="article-title">
                                    <h3 class="font-medium">
                                        <a href="{{route('routerURL',['slug' => $item->slug])}}" class="hover:text-d61c1f">{{$item->title}}
                                        </a>
                                    </h3>
                                </div>
                                <div class="article-description">
                                    <?php echo $item->description ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>
                <div class="mt-10">
                    <?php echo $data->links() ?>
                </div>

                @endif


            </div>
        </div>


    </div>
</main>






@endsection