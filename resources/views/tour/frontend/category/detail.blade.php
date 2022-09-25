@extends('homepage.layout.home')
@section('content')

<div class="breadcrumbs"
    <?php if(!empty($detail->banner)){?>style="background: url({{asset($detail->banner)}}) no-repeat center top;"
    <?php }?>>
    <div class="container">
        <h1 style="margin-top:0px" class="title-breadcrumb">
            {{$detail->title}}
        </h1>
        <ul class="breadcrumb-cate">
            <li><a href="{{url('')}}">Home</a></li>
            @if(count($breadcrumb) > 0)
            @foreach($breadcrumb as $key => $value)
            <li><a href="{{route('destinationURL',['slug' => $value->slug])}}">{{$value->title}}</a></li>
            @endforeach
            @endif
        </ul>
    </div>
</div>
<div class="container product-detail product-detail-tp-custom">
    <div class="row">
        <div id="content" class="col-md-9 col-sm-12 col-xs-12">
            <a href="javascript:void(0)" class="open-sidebar hidden-lg hidden-md"><i class="fa fa-bars"></i>Sidebar</a>
            <div class="products-category">
                @if(count($data) > 0)
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
        <!-- START: filter left -->
        @include('tour.frontend.aside')
        <!-- END: filter left -->
    </div>
</div>

@endsection