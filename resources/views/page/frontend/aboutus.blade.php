@extends('homepage.layout.home')
@section('content')
<div id="main">
    <section>
        <div class="container mx-auto px-3">
            <div class="breadcrumb mb-3  py-[10px]">

                <ul class="flex flex-wrap">
                    <li class="pr-[5px]"><a href="{{url('')}}">{{$fcSystem['title_7']}}</a> /</li>
                    <li>{{$page->title}}</li>
                </ul>
            </div>
            <div class="about-us-content">
                <?php echo $page->description; ?>
            </div>
        </div>
    </section>
</div>
@endsection