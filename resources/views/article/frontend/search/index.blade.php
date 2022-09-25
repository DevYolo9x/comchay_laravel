@extends('homepage.layout.home')
@section('content')
<main>

    <div class="container mx-auto">
        <div class="grid grid-cols-12 md:gap-[15px]">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                @include('homepage.common.aside')
            </div>
            <div class="col-span-12 lg:col-span-9 mt-5 md:mt-0 order-0 lg:order-1" data-aos="fade-up" data-aos-duration="1000">
                <nav class="mb-3 py-3 relative w-full flex flex-wrap items-center justify-between  focus:text-gray-700 navbar-light">
                    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
                        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
                            <ol class="list-reset flex">
                                <li><a href="{{url('')}}" class="text-gray-500 hover:text-gray-600">{{$fcSystem['title_6']}}</a>
                                </li>
                                <li><span class="text-gray-500 mx-2">/</span></li>
                                <li><a href="javascript:void(0)" class="text-gray-500 hover:text-gray-600">Tìm kiếm:
                                        {{request()->get('keyword')}}</a></li>
                            </ol>
                        </nav>
                    </div>
                </nav>
                <h1 class="hidden">Tìm kiếm:
                    {{request()->get('keyword')}}
                </h1>
                @if($data)
                <div class="section-catalogue">
                    <div class="grid grid-cols-1 space-y-5">
                        <?php foreach ($data as $k => $item) { ?>
                            <?php echo htmlArticle($item, $fcSystem['title_4']) ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="my-10 flex justify-center">
                    <?php echo $data->links() ?>
                </div>
                @endif
            </div>

        </div>
    </div>
</main>


@endsection