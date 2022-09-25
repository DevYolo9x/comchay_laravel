@extends('homepage.layout.home')
@section('content')
<div id="main" class="main-product ">
    <div class="container mx-auto px-3">
        <div class="breadcrumb mb-3  py-[10px]">
            <ul class="flex flex-wrap">
                <li><a href="{{url('')}}">{{$fcSystem['title_7']}}</a></li>
                <li><span class="text-gray-500 mx-2">/</span></li>
                <li>Tìm kiếm: {{request()->get('keyword')}}</li>
            </ul>
        </div>
        <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3 mt-4">
            <div class="w-full md:w-3/4 px-[5px] md:px-3 mb-[15px] md:mb-6 wow fadeInUp">
                <div class="sort-product flex justify-between items-center">
                    <div class="w-full md:w-1/2">
                        <h2 class="text-f20 font-bold uppercase">Tìm kiếm: {{request()->get('keyword')}}</h2>
                    </div>
                    <div class="w-full md:w-1/2">
                        <select name="sort" id="" class="float-right SortBy">
                            <option value="">Sắp xếp</option>
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
                @if(!$data->isEmpty())
                <div class="content-product mt-5">
                    <div class="flex flex-wrap -mx-[5px] md:-mx-3">
                        @foreach ($data as $k => $value)
                        <?php
                        $price = getPrice(array('price' => $value->price, 'price_sale' => $value->price_sale, 'price_contact' =>
                        $value->price_contact));
                        //get comment()
                        $rate = getRateOfComment($value->id, 'products');
                        ?>
                        <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 mb-[15px] md:mb-7">
                            <div class="item group">
                                <div class="img border border-gray-100 overflow-hidden">
                                    <a href="{{route('routerURL',['slug' => $value->slug])}}" class=" a-custom "><img src="{{asset($value->image)}}" alt="{{$value->title}}" class="h-[210px] md:h-[92px] w-full object-contain lg:object-cover  img-custom" /></a>
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
            <div class="w-full md:w-1/4 px-[5px] md:px-3 mb-[15px] md:mb-6 wow fadeInUp">
                @include('homepage.common.aside')
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(function() {
            $(document).on('change', '.SortBy', function() {
                var sort_by = $(this).val();
                window.location.href =
                    "<?php echo $seo['canonical'] ?>?keyword=<?php echo request()->get('keyword') ?>&sort=" +
                    sort_by;
            });
        });
    });
</script>

@endsection