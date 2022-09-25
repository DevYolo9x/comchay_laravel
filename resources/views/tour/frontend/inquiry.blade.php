@extends('homepage.layout.home')
@section('content')

<!-- Main Container  -->
<div class="breadcrumbs"
    <?php if(!empty($page->image)){?>style="background: url({{asset($page->image)}}) no-repeat center top;" <?php }?>>
    <div class="container">
        <h1 style="margin-top:0px" class="title-breadcrumb">
            {{$page->title}}
        </h1>
        <ul class="breadcrumb-cate">
            <li><a href="{{url('')}}">Home</a></li>
            <li><a href="javascript:void(0)"> {{$page->title}}</a></li>
        </ul>
    </div>
</div>
<div class="main-container container main-require">
    <div class="row">
        <div id="content" class="col-md-9">
            <form action="#" method="post" enctype="multipart/form-data" class="form-infomation clearfix">
                @csrf
                <div class="print-error-msg "></div>
                <fieldset class="your-infomation clearfix">
                    <h3>Your infomation</h3>
                    <div class="form-item item1 required">
                        <label class="control-label" for="input-firstname">First Name</label>
                        <input type="text" name="firstname" value="" placeholder="" id="input-firstname">
                    </div>
                    <div class="form-item item2 required">
                        <label class="control-label" for="input-lastname">Last Name</label>
                        <input type="text" name="lastname" value="" placeholder="" id="input-lastname">
                    </div>
                    <div class="form-item item1 required">
                        <label class="control-label" for="input-email">Email Address</label>
                        <input type="email" name="email" value="" placeholder="" id="input-email">
                    </div>
                    <div class="form-item item2 required">
                        <label class="control-label" for="input-telephone">Phone number</label>
                        <input type="tel" name="phone" value="" placeholder="" id="input-telephone">
                    </div>
                    <div class="form-item item1">
                        <label class="control-label" for="input-adddress">Address</label>
                        <input type="text" name="address" value="" placeholder="" id="input-adddress">
                    </div>

                    <div class="form-item item-select required">
                        <label class="control-label" for="input-number">Number</label>
                        <?php
                        $Adult = \App\Models\Faq::where('id',3)->where('publish',0)->first();
                        ?>
                        @if($Adult)
                        <?php $itemAdult = json_decode($Adult->jsonInfo,TRUE);?>
                        <div class="number1">
                            <select name="adult">
                                <option value="">Adult</option>
                                @if(!empty($itemAdult) && !empty($itemAdult['title']))
                                @foreach($itemAdult['title'] as $item)
                                @if(!empty($item))
                                <option value="{{$item}}">{{$item}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @endif
                        <?php
                        $Children = \App\Models\Faq::where('id',2)->where('publish',0)->first();
                        ?>
                        @if($Children)
                        <?php $itemChildren = json_decode($Children->jsonInfo,TRUE);?>
                        <div class="number2">
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
                    </div>
                </fieldset>
                <fieldset class="tour-infomation clearfix">
                    <h3>tour require</h3>
                    <div class="form-item item1 required">
                        <label class="control-label" for="input-destination">Destination</label>
                        <input type="text" name="destination" value="" placeholder="" id="input-destination">
                    </div>
                    <?php
                        $tourType = \App\Models\TourType::select('title')->where(['alanguage'=> config('app.locale'), 'publish' => 0])->get();
                    ?>
                    @if(count($tourType) > 0)
                    <div class="form-item item2 accomodation required">
                        <label class="control-label" for="input-tourstyle">Tour Styles</label>
                        <select name="tourstyle">
                            @foreach($tourType as $item)
                            <option value="{{$item->title}}">{{$item->title}}</option>
                            @endforeach

                        </select>
                    </div>
                    @endif
                    <div class="form-item item1">
                        <label class="control-label" for="input-departure">Departure City</label>
                        <input type="email" name="departure" value="" placeholder="" id="input-departure">
                    </div>
                    <div class="form-item date item-date required">
                        <label class="control-label" for="input-number">Arrival Date</label>
                        <input type="text" class="tour-search-input datepicker hasDatepicker" name="arrivalDate"
                            id="date_from" placeholder="DD/MM/YY">
                    </div>
                    <div class="form-item date item-date2 required">
                        <label class="control-label" for="input-number">Length of Stay</label>
                        <input type="text" class="tour-search-input datepicker hasDatepicker" name="LengthofStay"
                            id="date_to" placeholder="DD/MM/YY">
                    </div>
                    <div class="form-item item1 budget required">
                        <label class="control-label" for="input-budget">Max Budget</label>
                        <input type="number" name="budget" value="" placeholder="" id="input-budget">
                    </div>
                    <?php
                        $Accomodation = \App\Models\Faq::where('keyword','accomodation')->first();
                    ?>
                    @if($Accomodation)
                    <?php $itemAccomodation = json_decode($Accomodation->jsonInfo,TRUE);?>
                    <div class="form-item item2 accomodation">
                        <label class="control-label" for="input-accomodation">Accomodation</label>
                        <select name="accomodation">
                            @if(!empty($itemAccomodation) && !empty($itemAccomodation['title']))
                            @foreach($itemAccomodation['title'] as $item)
                            @if(!empty($item))
                            <option value="{{$item}}">{{$item}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    @endif
                    <div class="form-item item3">
                        <label class="control-label">Note</label>
                        <textarea name="message" rows="6" id="input-message"></textarea>
                    </div>
                </fieldset>
                <div class="buttons clearfix">
                    <input type="submit" value="Make a inquiry" class="btn btn-primary btn-submit-inquiry">
                </div>
            </form>
        </div>
        <aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">
            <span id="close-sidebar" class="fa fa-times"></span>
            <div class="content-search">
                <form action="{{route('search.tour')}}" method="GET">
                    <input class="autosearch-input" type="text" value="" size="50" autocomplete="off"
                        placeholder="Search..." name="keyword">
                    <span class="input-group-btn">
                        <button type="submit" class="fa fa-search button-search-pro form-button"></button>
                    </span>
                </form>
            </div>
            @include('homepage.common.article.LastestNews')
            @include('homepage.common.subscribers')
        </aside>
    </div>
</div>
<!-- //Main Container -->
@endsection
@push('javascript')
<link href="{{ asset('library/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('library/sweetalert/sweetalert.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".btn-submit-inquiry").click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo route('inquiry.store')?>",
            type: 'POST',
            data: {
                _token: $(".form-infomation input[name='_token']").val(),
                firstname: $(".form-infomation input[name='firstname']").val(),
                lastname: $(".form-infomation input[name='lastname']").val(),
                email: $(".form-infomation input[name='email']").val(),
                phone: $(".form-infomation input[name='phone']").val(),
                address: $(".form-infomation input[name='address']").val(),
                adult: $(".form-infomation select[name='adult']").val(),
                children: $(".form-infomation select[name='children']").val(),
                destination: $(".form-infomation input[name='destination']").val(),
                tourstyle: $(".form-infomation select[name='tourstyle']").val(),
                departure: $(".form-infomation input[name='departure']").val(),
                arrivalDate: $(".form-infomation input[name='arrivalDate']").val(),
                LengthofStay: $(".form-infomation input[name='LengthofStay']").val(),
                budget: $(".form-infomation input[name='budget']").val(),
                accomodation: $(".form-infomation select[name='accomodation']").val(),
                message: $("#input-message").val(),
            },
            success: function(responsive) {
                console.log(responsive.status);
                if (responsive.status == 200) {
                    $(".form-infomation .print-error-msg").html('').removeClass(
                        'alert-danger');
                    $(".form-infomation .print-error-msg").css('display', 'none');
                    swal({
                        title: "Successful!",
                        text: "You have been successfully",
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    $(".form-infomation .print-error-msg").html('').addClass(
                        'alert-danger alert');
                    $(".form-infomation .print-error-msg").css('display', 'block');
                    $(".form-infomation .print-error-msg").html(data.error);
                }
            },
            error: function(jqXhr, json, errorThrown) {
                // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                $(".form-infomation .print-error-msg").html('').addClass(
                    'alert-danger alert');
                $(".form-infomation .print-error-msg").css('display', 'block');
                var errorsHtml = "";
                $.each(errors.errors, function(index, value) {
                    errorsHtml += value + "/ ";
                });
                if (errorsHtml.length > 0) {
                    $(".form-infomation .print-error-msg").html(errorsHtml);
                } else {
                    $(".form-infomation .print-error-msg").html(errors.message);
                }
                $('html, body').animate({
                    scrollTop: $(".breadcrumbs").offset().top
                }, 200);
            },
        });
    });
});
</script>
@endpush
