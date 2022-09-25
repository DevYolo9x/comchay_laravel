@extends('homepage.layout.home')
@section('content')
<nav
    class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('')?>" class="text-gray-500 hover:text-gray-600">Trang chủ</a></li>
                @foreach($breadcrumb as $k=>$v)
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"
                        class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
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
                <div class="space-y-2">
                    <h1 class="font-bold text-2xl">{{$detail->title}}</h1>
                    <ul class="flex space-x-4">
                        <li class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{$detail->created_at}}</span>
                        </li>
                        <li class="flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{$detail->viewed}} lượt xem</span>
                        </li>
                    </ul>
                    <div class="box_content">
                        <?php echo $detail->content?>
                    </div>
                    <div class="box_comment">
                        <div class="fb-comments" data-href="{{$seo['canonical']}}" data-width="952" data-numposts="12">
                        </div>
                    </div>
                    @if(!$sameArticle->isEmpty())
                    <div class="box_comment">
                        <h2 class="font-bold text-2xl mb-2">Bài viết liên quan</h2>
                        <ul class="list-disc pl-5">
                            @foreach($sameArticle as $k=>$v)
                            <li><a class="hover:text-d61c1f"
                                    href="{{route('routerURL',['slug' => $v->slug])}}">{{$v->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
<style>
.box_content img {
    margin: 10px auto;
    max-width: 100%;
    height: auto !important;
}
</style>









@endsection