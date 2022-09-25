@extends('homepage.layout.home')
@section('content')
<style>
::-webkit-input-placeholder {
    /* Edge */
    color: #909090;
}

:-ms-input-placeholder {
    /* Internet Explorer 10-11 */
    color: #909090;
}

::placeholder {
    color: #909090;
}
</style>

<?php

$listAlbums = json_decode($detail->image_json, true);
$infoTour = json_decode($detail->infoTour,TRUE);
$schedule =  json_decode($detail->schedule,TRUE);
$price = getPrice(array('price' => $detail->price, 'price_sale' => $detail->price_sale, 'price_contact' => $detail->price_contact));
$price_discount = '$0.00';
$price_tax = '$0.00';
if(!empty($price['price_final_none_format'])){
    if(!empty($detail->discount)){
        $price_discount = '$'.($price['price_final_none_format']/100)*$detail->discount;
    }
    if(!empty($fcSystem['tax_tax'])){
        $price_tax = '$'.($price['price_final_none_format']/100)*$fcSystem['tax_tax'];

    }
}

?>

<div class="image-top">
    @if(!empty($detail->banner))
    <img src="{{asset($detail->banner)}}" alt="{{$detail->title}}" class="img-responsive">
    @else

    <img src="{{asset('frontend/image/catalog/demo/product/travel/tour-detail.jpg')}}" alt="{{$detail->title}}"
        class="img-responsive">
    @endif


</div>
<!-- Main Container  -->
<div class="container product-detail tour-single">
    <div class="row">
        <div id="content" class="col-md-9 col-sm-12 col-xs-12">
            <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Sidebar</a>
            <div class="detail-content">
                <div class="view-top">
                    <!-- START: View photo -->
                    @if(!empty($listAlbums))
                    @foreach($listAlbums as $key=>$item)
                    <a href="{{asset($item)}}" data-fancybox="images" data-type="image"
                        <?php if($key > 0){?>style="display: none" <?php }?>><i class="fa fa-camera-retro"
                            aria-hidden="true"></i>View photo</a>
                    @endforeach
                    @endif
                    <!-- END: View photo -->

                    @if(!empty($detail->video))
                    <!-- START: video -->
                    <a href="{{$detail->video}}" data-fancybox="gallery"><i class="fa fa-play"
                            aria-hidden="true"></i>View preview</a>
                    <!-- END: video -->
                    @endif

                </div>
                <div class="sticky-content">
                    <h1>{{$detail->title}}</h1>
                    <ul class="box-meta">
                        <li>
                            <div class="star"><span
                                    style="width: <?php echo $comment_view['averagePoint']*20?>%"></span>
                            </div>
                            <label>{{$comment_view['totalComment']}} comment</label>
                        </li>
                        @if(!empty($infoTour) && !empty($infoTour[0]))
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i>{{$infoTour[0]}}</li>
                        @endif
                        @if(count($getTourType) > 0)
                        <li>
                            <i class="fa fa-male" aria-hidden="true"></i>
                            @foreach($getTourType as $key=>$item)
                            <?php if($key > 0){?>,<?php }?>{{$item->getTourType->title}}
                            @endforeach
                        </li>
                        @endif

                        @if(!empty($infoTour) && !empty($infoTour[2]))
                        <li><i class="fa fa-users" aria-hidden="true"></i>{{$infoTour[1]}}</li>
                        @endif
                    </ul>
                    <div class="top-tab" id="nav">
                        <ul class="nav nav-tabs">
                            <li><a href="#home">Overview</a></li>
                            @if(!empty($schedule['title']))
                            <li><a href="#menu1">Tour Plans</a></li>
                            @endif
                            @if($detail->map)
                            <li><a href="#menu2">Map</a></li>
                            @endif
                            <li><a href="#menu3">Amenities</a></li>
                            <li><a href="#menu4">Review</a></li>
                        </ul>
                    </div>
                </div>
                <div class="content-tabs">
                    <div class="tab-content">
                        <div id="home">
                            <?php echo $detail->content?>
                            <style>
                            #home img {
                                height: auto !important;
                                max-width: 100%;
                            }
                            </style>
                        </div>
                        <ul class="location-wee clearfix">
                            @if(count($detail->catalogues_relationships) > 0)
                            <li>
                                <label>Location</label>

                                <div class="item">
                                    @foreach($detail->catalogues_relationships as $key=>$val)
                                    <a
                                        href="{{route('routerURL',['slug' => $val->slug])}}"><?php if($key > 0){?>,<?php }?>{{$val->title}}</a>
                                    @endforeach
                                </div>
                            </li>
                            @endif
                            <!-- Dịch vụ tour -->
                            @if(count($detail->services) > 0)
                            @foreach($detail->services as $item)
                            @if($item->ishome == 0)
                            <li>
                                <label>{{ $item->title}}</label>
                                <div class="item">
                                    <!-- check Price Excludes -->
                                    @if($item->type == 1)
                                    @foreach($item->serviceItems as $val)
                                    <div class="info2"><i class="fa fa-times" aria-hidden="true"></i>{{$val->title}}
                                    </div>
                                    @endforeach
                                    @else
                                    <!-- check Price Includes -->
                                    @if(count($item->serviceItems) > 1)
                                    @foreach($item->serviceItems as $val)
                                    <div class="info"><i class="fa fa-check" aria-hidden="true"></i>{{$val->title}}
                                    </div>
                                    @endforeach
                                    @else
                                    @foreach($item->serviceItems as $val)
                                    {{$val->title}}
                                    @endforeach
                                    @endif
                                    @endif
                                </div>
                            </li>
                            @endif
                            @endforeach
                            @endif
                            <!-- end: dịch vụ tour -->
                        </ul>

                        <!-- START: lịch trình tour -->
                        @if(isset($schedule['title']) && is_array($schedule['title']) && count($schedule['title']))
                        <div id="menu1" class="tour-plan clearfix">
                            <h3>tour plans</h3>
                            <div class="item-content">
                                @foreach ($schedule['title'] as $key => $val)
                                @if(!empty($val))
                                <div class="title"><span><?php echo ($key+1)?></span><?php echo $val ?></div>
                                <div>
                                    <?php echo $schedule['description'][$key]?>
                                </div>
                                @endif
                                @endforeach
                                <style>
                                .item-content img {
                                    height: auto !important;
                                    max-width: 100%;
                                }
                                </style>
                            </div>
                        </div>

                        @endif
                        <!-- END: lịch trình tour -->

                        <!-- START: map-->
                        @if($detail->map)
                        <div id="menu2" class="tour-map">
                            <h3>Map Located</h3>
                            <style>
                            #menu2 iframe {
                                width: 100% !important;
                            }
                            </style>
                            <?php echo $detail->map?>
                        </div>
                        @endif
                        <!-- END: map-->

                        <!-- START: Amenities-->
                        @if(count($detail->services) > 0)
                        @foreach($detail->services as $item)
                        @if($item->ishome == 1)
                        <div id="menu3" class="tour-amen clearfix">
                            <h3>{{ $item->title}}</h3>
                            <ul>
                                @foreach($item->serviceItems as $val)
                                <li><i class="fa fa-check-circle" aria-hidden="true"></i>{{ $val->title}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endforeach
                        @endif
                        <!-- END: Amenities-->

                        <!-- START: comment-->
                        @include('tour.frontend.tour.comment._comment')
                        <!-- END: comment-->



                    </div>
                </div>
            </div>
        </div>
        <aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">
            <span id="close-sidebar" class="fa fa-times"></span>
            <!-- START: book tour-->
            <div class="module-search2 clearfix">
                <h3 class="modtitle">
                    <label><?php echo $price['price_final']?></label><span>person</span>
                </h3>
                <form method="get" class="search-pr" action="" id="book-tour">
                    <div class="error_tour">
                        <div class="alert alert-danger" style="display: none;">
                            <span class="js_text_danger"></span>
                        </div>
                    </div>
                    <div class="search-item date">
                        <input type="text" class="tour-search-input datepicker hasDatepicker" id="date_from" name="date"
                            placeholder="Travel Date *">
                    </div>
                    @if(!empty($detail->available))
                    <div class="item-avai">Ticket Available: <span>{{$detail->available}}</span></div>
                    @endif
                    <div class="search-item ">
                        <input type="text" class="tour-search-input" name="fullname" placeholder="Full Name *">
                    </div>
                    <div class="search-item ">
                        <input type="text" class="tour-search-input" name="email" placeholder="Email Address *">
                    </div>
                    <div class="search-item ">
                        <input type="text" class="tour-search-input" name="phone" placeholder="Phone *">
                    </div>
                    <?php
                        $Adult = \App\Models\Faq::where('id',3)->first();
                    ?>
                    @if($Adult)
                    <?php $itemAdult = json_decode($Adult->jsonInfo,TRUE);?>
                    <div class="search-item item-select">
                        <select name="adult">
                            <option value="1">Adult</option>
                            <@if(!empty($itemAdult) && !empty($itemAdult['title'])) @foreach($itemAdult['title'] as
                                $item) @if(!empty($item)) <option value="{{$item}}">{{$item}}</option>
                                @endif
                                @endforeach
                                @endif
                        </select>
                    </div>
                    @endif
                    <?php
                        $Children = \App\Models\Faq::where('id',2)->first();
                    ?>
                    @if($Children)
                    <?php $itemChildren = json_decode($Children->jsonInfo,TRUE);?>
                    <div class="search-item item-select">
                        <select name="children">
                            <option value="">Children</option>
                            @if(!empty($itemChildren) && !empty($itemChildren['title']))
                            @foreach($itemChildren['title'] as $item)
                            @if(!empty($item))
                            <option value="{{$item}}">{{$item}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    @endif
                    <div class="search-item ">
                        <textarea class="tour-search-input" name="message" placeholder="Your Enquiry"
                            style="width:100%"></textarea>
                    </div>
                    <ul>
                        @if(!empty($fcSystem['tax_tax']))
                        <li><span>Tax (+{{$fcSystem['tax_tax']}}%):</span><label>{{$price_tax}}</label></li>
                        @endif
                        @if(!empty($detail->discount))
                        <li><span>Discount(<?php echo !empty($detail->discount)?$detail->discount:0?>%):</span><label>{{$price_discount}}</label>
                        </li>
                        @endif
                    </ul>
                    <div class="button-submit">
                        <button type="submit" class="button">book now</button>
                    </div>
                </form>
            </div>
            <!-- END: book tour-->
            <!-- START: Why should travel with us?-->
            <?php
                $should = \App\Models\Faq::where('id',5)->where('publish',0)->first();
            ?>
            @if($should)
            <?php $itemChildren = json_decode($should->jsonInfo,TRUE);?>
            @if(!empty($itemChildren))
            <div class="module-why clearfix">
                <h3>{{$should->title}}</h3>
                <ul>
                    @foreach($itemChildren['title'] as $key=>$item)
                    @if(!empty($item))
                    <li><i class="{{$item}}"
                            aria-hidden="true"></i><?php echo strip_tags($itemChildren['description'][$key])?></li>
                    @endif
                    @endforeach
                </ul>
            </div>
            @endif
            @endif
            <!-- END: Why should travel with us?-->

            <!-- START: tour popular -->
            @include('homepage.common.tour.popular')
            <!-- END: tour popular -->

        </aside>
    </div>
</div>
<!-- //Main Container -->



@endsection
@push('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.css" />
<link href="{{ asset('library/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('library/sweetalert/sweetalert.min.js') }}"></script>
<script>
$('[data-fancybox="images"]').fancybox({
    thumbs: {
        autoStart: true,
        axis: 'y'
    }
})
</script>
<script>
$('#book-tour').submit(function(event) {
    event.preventDefault();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        url: "<?php echo route('bookTour.frontend') ?>",
        type: 'POST',
        dataType: "JSON",
        data: {
            fullname: $('#book-tour input[name="fullname"]').val(),
            email: $('#book-tour input[name="email"]').val(),
            phone: $('#book-tour input[name="phone"]').val(),
            date: $('#book-tour input[name="date"]').val(),
            adult: $('#book-tour select[name="adult"]').val(),
            children: $('#book-tour select[name="children"]').val(),
            message: $('#book-tour textarea[name="message"]').val(),
            tour_id: "{{$detail->id}}"
        },
        success: function(data) {
            if (data.success == 200) {
                $('.error_tour .alert-danger').hide();
                swal({
                    title: "Successful!",
                    text: "Successful tour booking.",
                    type: "success"
                }, function() {
                    location.reload();
                });
            } else {
                $('.error_tour .alert-danger').show();
                $('.error_tour .js_text_danger').html("ERROR");
            }
        },
        error: function(jqXhr, json, errorThrown) {
            // this are default for ajax errors
            var errors = jqXhr.responseJSON;
            $('.error_tour .alert-danger').show();
            var errorsHtml = "";
            $.each(errors.errors, function(index, value) {
                errorsHtml += value + "/ ";
            });
            if (errorsHtml.length > 0) {
                $('.error_tour .js_text_danger').html(errorsHtml);
            } else {
                $('.error_tour .js_text_danger').html(errors.message);
            }

        },
    });
});
</script>
<script type="text/javascript" src="{{asset('frontend/js/themejs/application.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/themejs/homepage.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/themejs/custom_h1.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/themejs/addtostick.js')}}"></script>
@endpush