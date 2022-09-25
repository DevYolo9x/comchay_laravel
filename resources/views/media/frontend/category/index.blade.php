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
                <h1 class="hidden">{{$detail->title}}</h1>
                @if($data)
                <div class="section-catalogue">
                    <div class="grid grid-cols-1 space-y-5">
                        <?php foreach($data as $k=>$item){ ?>
                        <?php echo htmlArticle($item,$fcSystem['title_4'])?>

                        <?php }?>

                    </div>

                </div>
                <div class="my-10 flex justify-center">
                    <?php echo $data->links()?>
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