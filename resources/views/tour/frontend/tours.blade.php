@extends('homepage.layout.home')
@section('content')

<script>
var min_price =
    '<?php if(!empty(request()->get('min-price'))){ ?><?php echo request()->get('minPrice')?><?php }else{?>0<?php }?>';
var max_price =
    '<?php if(!empty(request()->get('max-price'))){ ?><?php echo request()->get('maxPrice')?><?php }else{?>10000<?php }?>';
</script>

<!-- Main Container  -->
<div class="breadcrumbs"
    <?php if(!empty($page->image)){?>style="background: url({{asset($page->image)}}) no-repeat center top;" <?php }?>>
    <div class="container">
        <h1 style="margin-top:0px" class="title-breadcrumb">
            {{$page->title}}
        </h1>
        <ul class="breadcrumb-cate">
            <li><a href="{{url('')}}">Home</a></li>
            <li><a href="javascript:void(0)">{{$page->title}}</a></li>
        </ul>
    </div>
</div>
<div class="container product-detail product-detail-tp-custom">
    <div class="row">
        <!-- START: filter left -->
        <aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas">
            <span id="close-sidebar" class="fa fa-times"></span>
            <div class="module-search clearfix">
                <h3 class="modtitle">Tour searching</h3>
                <form method="get" class="search-pr">
                    <div class="alert alert-danger" style="display: none"></div>
                    <div class="search-item city">
                        <select name="destinaion" class="tour-search-input _check">
                            <option value="">City, region or anywhere</option>
                            @if(count($TourCategory) > 0)
                            @foreach($TourCategory as $item)
                            <option value="{{$item->id}}"
                                <?php if(request()->get('destinaion') == $item->id){ ?>selected<?php }?>>
                                {{$item->title}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <?php
                        if(!empty(request()->get('checkin'))){
                            $checkin = request()->get('checkin');
                        }else{
                            $checkin = '';
                        }
                        if(!empty(request()->get('checkout'))){
                            $checkout = request()->get('checkout');
                        }else{
                            $checkout = '';
                        }
                    ?>
                    <div class="search-item date">
                        <input type="text" class="tour-search-input datepicker hasDatepicker _check" id="date_from"
                            name="checkin" placeholder="Day start" value="{{$checkin}}" autocomplete="off">
                    </div>
                    <div class="search-item date">
                        <input type="text" class="tour-search-input datepicker hasDatepicker _check" id="date_to"
                            name="checkout" placeholder="Day end" value="{{$checkout}}" autocomplete="off">
                    </div>
                    <?php if(count($category_attributes) > 0) {?>
                    <?php foreach($category_attributes as $value){?>
                    <?php if(count($value->listAttr) > 0){?>
                    <div class="search-item item-select">
                        <select name="attr[]" class="attr _check" data-keyword="{{$value->slug}}">
                            <option value="0">{{$value->title}}</option>
                            @foreach($value->listAttr as $key=>$val)
                            <option value="{{$val->id}}"
                                <?php if( request()->get('attribute') == $value->slug.';'.$val->id){?> selected
                                <?php }?>>
                                {{$val->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <?php }?>
                    <?php }?>
                    <?php }?>
                    <div class="search-item item-budget">
                        <input type="number" class="hotel-budget-input _check" name="maxPrice" id="budget"
                            value="{{request()->get('maxPrice')}}" placeholder="Max budget">
                    </div>
                    <div class="button-submit">
                        <button type="button" class="button button-submit-ajax">Search Tour <i class="fa fa-angle-right"
                                aria-hidden="true"></i></button>
                    </div>
                </form>
            </div>
            @if(count($TourType) > 0)
            <div class="module-travel clearfix">
                <h3>travel style</h3>
                <ul class="listTourType">
                    @foreach($TourType as $item)
                    <li>
                        <a href="javascript:void(0)" data-id="{{$item->id}}"
                            class="filterTourType"><span>{{$item->title}}</span><label>{{$item->count}}</label></a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="module-rate clearfix">
                <h3>star rating</h3>
                <ul class="listRate">
                    <li>
                        <a href="javascript:void(0)" data-rate="5" class="filterRate">
                            <div class="star"><span style="width: 75px"></span></div><label>{{$rate5}}</label>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-rate="4" class="filterRate">
                            <div class="star"><span style="width: 60px"></span></div><label>{{$rate4}}</label>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-rate="3" class="filterRate">
                            <div class="star"><span style="width: 45px"></span></div><label>{{$rate3}}</label>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-rate="2" class="filterRate">
                            <div class="star"><span style="width: 30px"></span></div><label>{{$rate2}}</label>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-rate="1" class="filterRate">
                            <div class="star"><span style="width: 15px"></span></div><label>{{$rate1}}</label>
                        </a>
                    </li>
                </ul>
            </div>
            <input type="text" id="choose_attr" class="hidden">
            <input type="text" name="filter_tour_type" class="filter hidden">
            <input type="text" name="filter_rate" class="filter hidden">

            @include('homepage.common.tour.popular')

        </aside>
        <!-- END: filter left -->

        <div id="content" class="col-md-9 col-sm-12 col-xs-12">
            <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Sidebar</a>
            <div class="products-category">
                <div class="product-filter filters-panel">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 view-mode hidden-xs">
                            <div class="list-view">
                                <button class="btn btn-default grid active" data-view="grid" data-toggle="tooltip"
                                    data-original-title="Grid"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-default list" data-view="list" data-toggle="tooltip"
                                    data-original-title="List"><i class="fa fa-th-list"></i></button>
                            </div>
                        </div>
                        <div class="short-by-show form-inline col-md-10 col-sm-10">
                            <div class="form-group">
                                <?php
                                $page    = request()->get('page') ? request()->get('page') : 1;
                                $total   = $data->total();
                                $perPage = 24;
                                $showingTotal  = $page * $perPage;
                                $currentShowing = $showingTotal>$total ? $total : $showingTotal;
                                $showingStarted = $showingTotal - $perPage;
                                if(!empty($showingStarted)){
                                    $showingStarted =  $showingStarted;
                                }else{
                                    $showingStarted = 1;
                                }
                                $tableInfo = "Show $showingStarted to $currentShowing of $total";
                                ?>
                                <label class="control-label" for="input-limit"><?php echo $tableInfo?></label>
                            </div>
                            <div class="form-group short-by">
                                <select id="input-sort" class="form-control filter">
                                    <option value="" selected="selected">Sort By</option>
                                    <option value="title|asc">Name (A - Z)</option>
                                    <option value="title|desc">Name (Z - A)</option>
                                    <option value="price|asc">Price (Low &gt; High)</option>
                                    <option value="price|desc">Price (High &gt; Low)</option>
                                    <option value="rate|desc">Rating (Highest)</option>
                                    <option value="rate|asc">Rating (Lowest)</option>
                                    <option value="code|asc">Model (A - Z)</option>
                                    <option value="code|desc">Model (Z - A)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @if($data)
                <div class="section-style4 products-list grid row number-col-3 so-filter-gird" id="dataTour">
                    @foreach($data as $key=>$item)
                    <?php echo htmlItemTourCategory($key,$item);?>
                    @endforeach
                </div>
                <div class="product-filter product-filter-bottom filters-panel">
                    <?php echo $data->links();?>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- //Main Container -->

@endsection
@push('javascript')
<script>
/*Click rate */
$(document).on('click', '.filterRate', function() {
    $(this).parent().toggleClass('active');
    let attr = '';
    $('.listRate li.active a').each(function(key, index) {
        let rate = $(this).attr('data-rate');
        attr = attr + rate + ';';
    });
    $('input[name="filter_rate"]').val(attr).change();
})
/*click tour type*/
$(document).on('click', '.filterTourType', function() {
    $(this).parent().toggleClass('active');
    let attr = '';
    $('.listTourType li.active a').each(function(key, index) {
        let id = $(this).attr('data-id');
        attr = attr + id + ';';

    });
    $('input[name="filter_tour_type"]').val(attr).change();
})
$(document).on('click', '.button-submit-ajax', function(e) {
    let attr = $('#choose_attr').val();
    var destinaion = $('select[name="destinaion"] option:selected').val();
    var maxPrice = $('input[name="maxPrice"]').val();
    var checkin = $('input[name="checkin"]').val();
    var checkout = $('input[name="checkout"]').val();
    if (attr == '' && destinaion == '' && maxPrice == '' && checkin == '' && checkout == '') {
        $('.alert-danger').show().html('Please select!');
        return false;
    }
    $('.alert-danger').hide().html('');
    let page = $('.pagination .active span').text();
    time = setTimeout(function() {
        get_list_object(page);
    }, 500);
    return false;
})
$(document).on('change keyup', '._check', function(e) {
    $('.alert-danger').hide().html('');
    return false;
})
</script>
<!-- tour filter -->
<script>
$(document).on('change', '.attr', function() {
    let attr = '';
    $('select[name="attr[]"]').each(function(key, index) {
        let id = $(this).find('option:selected').val();
        if (id > 0) {
            let attr_id = $(this).attr('data-keyword');
            attr = attr + attr_id + ';' + id + ';';
        }

    });
    $('#choose_attr').val(attr);
})
var time;
$(document).on('keyup change', '.filter', function() {
    let page = $('.pagination .active span').text();
    time = setTimeout(function() {
        get_list_object(page);
    }, 500);
    return false;
});
$(document).on('click', '.pagination_custom a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    get_list_object(page);
});

function get_list_object(page = 1) {
    let sort = $('#input-sort option:selected').val();
    let type = $('input[name="filter_tour_type"]').val();
    let rate = $('input[name="filter_rate"]').val();
    let attr = $('#choose_attr').val();
    let ajaxUrl = BASE_URL_AJAX + 'tour/tour-filter';
    /*get data request GET */
    var destinaion = $('select[name="destinaion"] option:selected').val();
    var maxPrice = $('input[name="maxPrice"]').val();
    var checkin = $('input[name="checkin"]').val();
    var checkout = $('input[name="checkout"]').val();
    $.ajax({
        type: 'POST',
        url: ajaxUrl,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            page: page,
            sort: sort,
            type: type,
            attr: attr,
            rate: rate,
            destinaion: destinaion,
            maxPrice: maxPrice,
            checkin: checkin,
            checkout: checkout
        },
        success: function(data) {
            let json = JSON.parse(data);
            $('#dataTour').html(json.html);
            $('.total-ajax').text(json.total);
            $('html, body').animate({
                scrollTop: $(".grid-left-sidebar__filter").offset().top
            }, 300);
        }
    });
}
</script>
@endpush
