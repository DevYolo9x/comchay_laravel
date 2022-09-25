@extends('homepage.layout.home')
@section('content')

<?php if(!empty($detail->banner)){?>
<div class="image-top"><img src="{{asset($detail->banner)}}" alt="{{$detail->tour}}" class="img-responsive"
        style="width:100%">
</div>
<?php }else{?>
<div class="image-top"><img src="{{asset('frontend/image/catalog/demo/product/travel/tour-detail2.jpg')}}"
        alt="{{$detail->tour}}" style="width:100%" class="img-responsive">
</div>
<?php }?>
<?php
$listAlbums = json_decode($detail->image_json, true);

?>
<!-- Main Container  -->
<div class="destination-detail">
    <div class="container product-detail page-builder-ltr">
        <div class="row row-style row_a1">
            <div id="content" class="destination-content col-md-9 col-sm-12 col-xs-12">
                <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md">
                    <i class="fa fa-bars"></i>Sidebar
                </a>
                <div class="view-top">
                    @if(!empty($listAlbums))
                    @foreach($listAlbums as $key=>$item)
                    <a href="{{asset($item)}}" data-fancybox="images" data-type="image"
                        <?php if($key > 0){?>style="display: none" <?php }?>><i class="fa fa-camera-retro"
                            aria-hidden="true"></i>View photo</a>
                    @endforeach
                    @endif
                    @if(!empty($detail->video))
                    <!-- START: video -->
                    <a href="{{$detail->video}}" data-fancybox="gallery"><i class="fa fa-play"
                            aria-hidden="true"></i>View preview</a>
                    <!-- END: video -->
                    @endif
                </div>
                <h1>Welcome to {{$detail->title}}</h1>
                <div class="destination-top">
                    <!-- START: description -->
                    <div class="destination-description-tp">
                        <?php echo $detail->description?>
                    </div>
                    <!-- END: description-->

                    <a href="{{route('destinationURL',['slug' => $detail->slug])}}" class="view-all">View all
                        {{count($detail->tourCount)}} {{$detail->title}} tour <i class="fa fa-angle-double-right"
                            aria-hidden="true"></i></a>
                    <!-- START: content-->
                    <div class="destination-content-tp">
                        <?php echo $detail->content?>
                    </div>
                    <!-- END: content-->

                </div>
            </div>

            <aside class="col-md-3 col-sm-4 col-xs-12 content-aside right_column sidebar-offcanvas">
                <span id="close-sidebar" class="fa fa-times"></span>
                <!-- START: banner -->
                @if(!empty($fcSystem['banner_7']))
                <div class="image-top"><img src="{{asset($fcSystem['banner_7'])}}" alt="tour" class="img-responsive">
                </div>
                @endif
                <!-- END: banner -->
                <!-- START: Get A Questions -->
                @include('homepage.common.tour.Questions')
                <!-- END: Get A Questions -->
            </aside>
        </div>
    </div>
    <!-- START: popular Tour -->
    @include('homepage.common.tour.popularSlide')
    <!-- END: popular Tour -->

</div>

<!-- //Main Container -->

@endsection
@push('javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.css" />
<script>
$('[data-fancybox="images"]').fancybox({
    thumbs: {
        autoStart: true,
        axis: 'y'
    }
})
</script>
@endpush