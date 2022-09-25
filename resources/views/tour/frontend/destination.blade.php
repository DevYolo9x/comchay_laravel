@extends('homepage.layout.home')
@section('content')

<link href="{{asset('frontend/css/header/header2.css')}}" rel="stylesheet">

<style>
.img-responsive-destination {
    height: 380px;
    object-fit: cover;
}

@media (min-width:768px) and (max-width:1023px) {
    .img-responsive-destination {
        height: 486px;
        object-fit: cover;
    }
}

@media (max-width:767px) {
    .block-title {
        padding-top: 0px
    }

    .img-responsive-destination {
        height: 511px;
        object-fit: cover;
    }

}
</style>
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
<div class="destination-list">
    <!-- START: Destination -->

    <section class="destination-chose">
        <div class="container">
            <div class="row">
                @if(count($TourCategory) > 0)
                @foreach($TourCategory as $item)
                <div class="item col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="transition product-layout">
                        <div class="product-item-container ">
                            <div class="item-block so-quickview">
                                <div class="image">
                                    <a href="{{route('routerURL',['slug'=> $item->slug])}}" target="_self">

                                        <img src="{{asset($item->image)}}" alt="{{$item->title}}"
                                            class="img-responsive img-responsive-destination">
                                    </a>
                                </div>
                                <div class="item-content">
                                    <div class="item-title clearfix">
                                        <h3 class="pull-left">
                                            <a href="{{route('routerURL',['slug'=> $item->slug])}}">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{$item->title}}
                                            </a>
                                        </h3>
                                        <span class="pull-right">{{count($item->tourCount)}} tours</span>
                                    </div>
                                    <div class="view-all">
                                        <a href="{{route('routerURL',['slug'=> $item->slug])}}">
                                            View all tour <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                {{$TourCategory->links()}}
            </div>
        </div>
    </section>
    <!-- END: Destination -->


    <!-- START: popular Tour -->
    @include('homepage.common.tour.popularSlide')
    <!-- END: popular Tour -->

    <!-- START: JOIN THE NEWSLETTER -->
    @include('homepage.common.tour.NEWSLETTER')
    <!-- END: JOIN THE NEWSLETTER -->
</div>

<!-- //Main Container -->
@endsection