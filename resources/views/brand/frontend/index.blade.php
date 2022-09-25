@extends('homepage.layout.home')
@section('content')
<nav class="px-4 relative w-full flex flex-wrap items-center justify-between py-3 bg-gray-100 text-gray-500 hover:text-gray-700 focus:text-gray-700 shadow-lg navbar navbar-expand-lg navbar-light">
    <div class="container mx-auto w-full flex flex-wrap items-center justify-between">
        <nav class="bg-grey-light w-full" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="<?php echo url('') ?>" class="text-gray-500 hover:text-gray-600">Trang chủ</a></li>
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li><a href="javascript:void(0)" class="text-gray-500 hover:text-gray-600">{{ $detail->title}}</a></li>
            </ol>
        </nav>
    </div>
</nav>
<main class="py-8">
    <div class=" container mx-auto px-4 md:px-0">
        <div class="rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 float-left w-full">
                <h1 class="text-3xl font-bold">Thương hiệu {{$detail->title}}</h1>
                <div class="mt-4">
                    <div class="px-2 py-3 float-left w-auto border-b-2 border-red-600 font-medium">
                        <span class="text-4 text-red-600">Tất cả {{$detail->title}}</span>
                        <span class="text-gray-600">{{$data->total()}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 space-x-0 md:space-x-4 relative pt-6 md:px-0" id="scrollTop">
            <div class="col-span-12 lg:col-span-3 side-left inset-0 overflow-auto ovn_scroll_bar_filter order-1 lg:order-0">
            </div>
            <div class="col-span-12 lg:col-span-12 pb-6 order-0 lg:order-1">
                <div class="grid grid-cols-1 justify-between items-center space-x-2">
                    <div class="text-right">
                        <select name="sortBy" class="SortBy w-full md:w-auto focus:outline-none hover:outline-none">
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
                    @if(!$data->isEmpty())
                    <div class="content-product mt-5">
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 -mx-[5px] md:-mx-3">
                            @foreach ($data as $k => $value)
                            <?php
                            $price = getPrice(array('price' => $value->price, 'price_sale' => $value->price_sale, 'price_contact' =>
                            $value->price_contact));
                            //get comment()
                            $rate = getRateOfComment($value->id, 'products');
                            ?>
                            <div class=" px-[5px] md:px-3 mb-[15px] md:mb-7">
                                <div class="item group">
                                    <div class="img border border-gray-100 overflow-hidden">
                                        <a href="{{route('routerURL',['slug' => $value->slug])}}" class=" a-custom ">
                                            <img src="{{asset($value->image)}}" alt="{{$value->title}}" class="h-[210px] md:h-[261px] w-full object-contain md:object-cover  img-custom" />
                                        </a>
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
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-5 flex justify-center">
                            {{$data->links()}}
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        $(function() {
            $(document).on('change', '.SortBy', function() {
                var sort_by = $(this).val();
                window.location.href =
                    "<?php echo $seo['canonical'] ?>?sort=" +
                    sort_by;
            });
        });
    });
</script>
@endsection