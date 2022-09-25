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
<main class="py-8">
    <div class=" container mx-auto">
        <div class="rounded-xl overflow-hidden">
            <?php if (!empty($detail->banner)) { ?>
                <div class="w-full h-[200px] relative">
                    <img alt="{{$detail->title}}" src="{{asset($detail->banner)}}" class="blur-up object-cover w-full h-full">
                    <h2 class="text-4xl font-black absolute left-6 top-1/2 text-white uppercase hidden" style="transform: translateY(-50%)">{{$detail->title}}</h2>
                </div>
            <?php } ?>

            <div class="px-6 py-4 bg-gray-50 float-left w-full">
                <h1 class="text-3xl font-bold">{{$detail->title}}</h1>
                <div class="mt-4">
                    <div class="px-2 py-3 float-left w-auto border-b-2 border-red-600 font-medium">
                        <span class="text-4 text-red-600">Tất cả {{$detail->title}}</span>
                        <span class="text-gray-600">{{$detail->countProduct->count()}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 space-x-0 md:space-x-4 relative pt-6 px-4 md:px-0" id="scrollTop">
            <div class="col-span-12 lg:col-span-3 side-left inset-0 overflow-auto ovn_scroll_bar_filter order-1 lg:order-0">
                @include('product.frontend.category.filter')
            </div>
            <div class="col-span-12 lg:col-span-9 pb-6 order-0 lg:order-1">
                <div class="grid grid-cols-2 justify-between items-center space-x-2">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute top-1/2 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input placeholder="Tìm kiếm trong" type="text" value="" class="filter keyword rounded-full border w-full lg:w-[421px] h-11 px-8 focus:outline-none focus:ring focus:ring-red-300 focus:rounded-full hover:outline-none hover:ring hover:ring-red-300 hover:rounded-full" name="keyword">
                    </div>
                    <div class="text-right">
                        <select name="sortBy" class="SortBy w-full md:w-auto focus:outline-none focus:ring focus:ring-red-300 focus:rounded-full hover:outline-none hover:ring hover:ring-red-300 hover:rounded-full">
                            <option value="">SẮP XẾP THEO</option>
                            <option value="title|asc" <?php echo !empty(request()->get('sort') == 'title|asc') ? 'selected' : '' ?>>Theo bảng
                                chữ cái từ A-Z</option>
                            <option value="title|desc" <?php echo !empty(request()->get('sort') == 'title|desc') ? 'selected' : '' ?>>Theo bảng
                                chữ cái từ Z-A</option>
                            <option value="price|asc" <?php echo !empty(request()->get('sort') == 'price|asc') ? 'selected' : '' ?>>Giá từ thấp
                                tới cao</option>
                            <option value="price|desc" <?php echo !empty(request()->get('sort') == 'price|desc') ? 'selected' : '' ?>>Giá từ cao
                                tới thấp</option>
                            <option value="id|desc" <?php echo !empty(request()->get('sort') == 'id|desc') ? 'selected' : '' ?>>Mới nhất
                            </option>
                            <option value="id|asc" <?php echo !empty(request()->get('sort') == 'id|asc') ? 'selected' : '' ?>>Cũ nhất
                            </option>
                        </select>
                    </div>
                </div>

                <section class="p-5 bg-red-50 rounded-2xl mt-6 hidden" id="selected_attr">
                    <h3 class="font-normal text-base">
                        Có
                        <strong class="total-ajax">{{$data->total()}}</strong>
                        sản phẩm phù hợp với tiêu chí của bạn
                    </h3>
                    <div class="mt-2 t-flex-gap">
                        <div class="flex flex-wrap gap-4 listFilter">
                        </div>
                    </div>
                </section>
                <div class="mt-4" id="data_product">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 -mx-3">
                        <?php foreach ($data as $k => $item) { ?>
                            <?php echo htmlItemProduct($k, $item); ?>
                        <?php } ?>
                    </div>
                    <div class="mt-5">
                        <div class="flex justify-center">
                            {{$data->links()}}

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>

@endsection