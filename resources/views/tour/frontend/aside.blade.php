<aside class="col-md-3 col-sm-4 col-xs-12 content-aside left_column sidebar-offcanvas">
    <span id="close-sidebar" class="fa fa-times"></span>
    <div class="page-blog">
        <div class="content-search">
            <form action="{{route('search.tour')}}">
                <input class="autosearch-input" type="text" value="<?php echo request()->get('keyword')?>" size="50"
                    autocomplete="off" placeholder="Search..." name="keyword">
                <span class="input-group-btn">
                    <button type="submit" class="fa fa-search button-search-pro form-button"></button>
                </span>
            </form>
        </div>
    </div>
    <?php
            $asideCategoryTour =  \App\Models\TourCategory::select('id','title','slug')->where('alanguage', config('app.locale'))->where(array('publish'=> 0))->with('tourCount')->orderBy('order','asc')->orderBy('id','desc')->limit(10)->get();
            ?>
    @if($asideCategoryTour->count() > 0)
    <div class="module-travel clearfix">
        <h3>{{$fcSystem['title_17']}}</h3>
        <ul>
            @foreach($asideCategoryTour as $k=>$item)
            <li <?php if(!empty($detail) && $detail->title === $item->title){?>class="active" <?php }?>><a
                    href="{{route('routerURL',['slug' => $item->slug])}}"><span>{{$item->title}}</span><label>{{count($item->tourCount)}}</label></a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    <?php
            $asideTagsTour = Cache::remember('asideTagsTour', 60, function () {
                return \App\Models\Tag::select('title','slug')->where('alanguage', config('app.locale'))->where(array('publish'=> 0,'isaside'=>1,'module' => 'tours'))->orderBy('order','asc')->orderBy('id','desc')->limit(20)->get();
            });
            ?>
    @if($asideTagsTour->count() > 0)
    <div class="module-tag">
        <h3>{{$fcSystem['title_19']}}</h3>
        <ul>
            @foreach($asideTagsTour as $k=>$item)
            <li <?php if(!empty($detail) && $detail->title === $item->title){?>class="active" <?php }?>><a
                    href="{{route('tagURL',['slug' => $item->slug])}}">{{$item->title}}</a></li>
            @endforeach
        </ul>
    </div>
    @endif

    @include('homepage.common.tour.popular')

</aside>