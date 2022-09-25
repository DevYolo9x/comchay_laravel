@extends('dashboard.layout.dashboard')
@section('title')
<title>Cập nhập</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách",
            "src" => route('tours.index'),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('tours.update',['id' => $detail->id ])}}"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            @include('components.alert-error')
            @csrf
            <ul class="nav nav-link-tabs flex-wrap" role="tablist">
                <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1"
                        type="button" role="tab" aria-controls="example-tab-1" aria-selected="true">Thông tin
                        chung</button>
                </li>
                <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-2"
                        type="button" role="tab" aria-controls="example-tab-2" aria-selected="true">Thông tin tour
                    </button>
                </li>
                <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-3"
                        type="button" role="tab" aria-controls="example-tab-3" aria-selected="true">Lịch trình
                    </button>
                </li>
            </ul>
            <div class="tab-content ">
                <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel"
                    aria-labelledby="example-1-tab">
                    @include('tour.backend.tour.common._detail',['action' => 'update'])
                    <div class="box p-5 mt-3">
                        <!-- start: SEO -->
                        @include('components.seo')
                        <!-- end: SEO -->
                    </div>
                </div>
                <div id="example-tab-2" class="tab-pane leading-relaxed " role="tabpanel"
                    aria-labelledby="example-2-tab">
                    @include('tour.backend.tour.common._attribute',['action' => 'update'])
                    @include('tour.backend.tour.common._tour',['action' => 'update'])
                </div>
                <div id="example-tab-3" class="tab-pane leading-relaxed " role="tabpanel"
                    aria-labelledby="example-3-tab">
                    @include('tour.backend.tour.common._schedule',['action' => 'update'])
                </div>
            </div>
            <div class="col-span-12 mt-5">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class="col-span-12 lg:col-span-4">
            <div class=" box p-5 pt-3">
                <div>
                    <label class="form-label text-base font-semibold">Chọn điểm đến</label>
                    <?php echo Form::select('catalogue_id', $category, $detail->catalogue_id, ['class' => 'tom-select tom-select-custom w-full','data-placeholder'=>"Tìm kiếm danh mục...",'required']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Chọn điểm đến phụ</label>
                    <select name="catalogue[]" class="form-control tom-select tom-select-custom w-full" multiple>
                        <option value=""></option>
                        @foreach($category as $k=>$v)
                        <option value="{{$k}}" {{ (collect($getCatalogue)->contains($k)) ? 'selected':'';}}>
                            {{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Travel type</label>
                    <select name="types[]" class="form-control tom-select tom-select-custom w-full" multiple
                        data-placeholder="Tìm kiếm...">
                        <option value=""></option>
                        @foreach($types as $k=>$v)
                        <option value="{{$k}}" {{ (collect($getTypes)->contains($k)) ? 'selected':'';}}>
                            {{$v}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.image',['action' => 'update','name' => 'banner','title'=> 'Banner'])
            @include('components.publish')
            @include('components.tag',['module' => $module])

        </div>
    </form>
</div>
<style>
.dz-preview {
    border-radius: 10px;
    -webkit-box-shadow: -8px -4px 57px -34px rgb(66 68 90);
    -moz-box-shadow: -8px -4px 57px -34px rgba(66, 68, 90, 1);
    box-shadow: -8px -4px 57px -34px rgb(66 68 90);
}
</style>
@endsection
@include('tour.backend.tour.common.script')