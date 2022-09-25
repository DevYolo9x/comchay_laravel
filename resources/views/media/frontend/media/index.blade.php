@extends('homepage.layout.home')
@section('content')
<main>
    <nav
        class="mt-2 mb-3 px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
        <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
            <nav class="bg-grey-light w-full" aria-label="breadcrumb">
                <ol class="list-reset flex">
                    <li><a href="{{url('')}}" class="text-gray-500 hover:text-gray-600">{{$fcSystem['title_6']}}</a>
                    </li>
                    @foreach($breadcrumb as $k=>$v)
                    <li><span class="text-gray-500 mx-2">/</span></li>
                    <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>"
                            class="text-gray-500 hover:text-gray-600">{{ $v->title}}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </nav>
    <div class="container mx-auto">
        <div class="grid grid-cols-12 md:gap-[15px]">
            <div class="col-span-12 lg:col-span-8" data-aos="fade-up" data-aos-duration="1000">

                <h1 class="font-bold text-c8252c text-xl">{{$detail->title}}</h1>
                <div class="flex items-center space-x-5 my-1">
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                        <span>
                            {{$detail->created_at}}
                        </span>

                    </div>
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>
                            {{$detail->viewed}} {{$fcSystem['title_4']}}
                        </span>

                    </div>

                </div>
                <div class="article-detail-content">
                    <?php echo $detail->description?>
                </div>
                @if(!$sameMedia->isEmpty())
                <div class="mt-10" data-aos="fade-up" data-aos-duration="1000">
                    <div class="flex items-center border-b border-c8252c">
                        <h2 class="text-c8252c font-bold text-lg uppercase mr-4 border-b-4 border-c8252c"><a
                                href="javascript:void(0)">{{$fcSystem['title_5']}}</a>
                        </h2>
                    </div>
                    <div class="grid md:grid-cols-3 md:gap-[30px] mt-5">
                        @foreach($sameMedia as $k=>$v)
                        <div class="item group mb-7 md:mb-0">
                            <a href="{{route('routerURL',['slug' => $v->slug])}}" class="a-custom">
                                <div class="overflow-hidden mb-3">
                                    <img src="{{asset($v->image)}}" class="img-custom h-[180px] object-cover w-full"
                                        alt="{{$v->title}}">
                                </div>
                            </a>
                            <h3>
                                <a href="{{route('routerURL',['slug' => $v->slug])}}"
                                    class="line-custom-3 font-medium group-hover:text-c8252c">{{$v->title}}</a>
                            </h3>
                        </div>
                        @endforeach

                    </div>
                </div>
                @endif
            </div>
            <div class="col-span-12 lg:col-span-4 space-y-6 mt-8 md:mt-0">
                @include('homepage.common.aside')
            </div>
        </div>
    </div>
</main>

@endsection
@push('css')
<style>
.article-detail-content p {
    margin-bottom: 10px
}

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