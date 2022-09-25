@extends('dashboard.layout.dashboard')
@section('title')
<title>Cập nhập </title>
@endsection
<!--START: breadcrumb -->
@section('breadcrumb')
<?php
        $array = array(
            [
                "title" => "Danh sách",
                "src" => route('tour_types.index'),
            ],
            [
                "title" => "Cập nhập",
                "src" => 'javascript:void(0)',
            ]
        );
        echo breadcrumb_backend($array);
    ?>
@endsection
<!--END: breadcrumb -->
@section('content')
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('tour_types.update',['id' => $detail->id])}}"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8 ">
            <!-- BEGIN: Form Layout -->
            <div class="mt-3 box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên danh mục</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full title']); ?>
                </div>
                <div class="mt-3 hidden">
                    <label class="form-label text-base font-semibold">Đường dẫn</label>
                    <div class="input-group">
                        <div class="input-group-text"><span class="vertical-1"><?php echo url(''); ?></span></div>
                        <?php echo Form::text('slug', $detail->slug, ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>
            <div class=" box p-5 mt-3 hidden">
                <!-- start: SEO -->
                @include('components.seo')
                <!-- end: SEO -->
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">

            @include('components.publish')
        </div>
    </form>
</div>
@endsection