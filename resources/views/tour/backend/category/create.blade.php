@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới điểm đến</title>
@endsection
<!--START: breadcrumb -->
@section('breadcrumb')
<?php
        $array = array(
            [
                "title" => "Điểm đến",
                "src" => route('tour_categories.index'),
            ],
            [
                "title" => "Thêm mới",
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
            Thêm mới
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('tour_categories.store')}}" method="post"
        enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên Điểm đến</label>
                    <?php echo Form::text('title', '', ['class' => 'form-control w-full title','required']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Đường dẫn</label>
                    <div class="input-group">
                        <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
                        </div>
                        <?php echo Form::text('slug', '', ['class' => 'form-control canonical', 'data-flag' => 0,'required']); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('description', '', ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Thông tin chi tiết</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('content', '', ['id' => 'ckContent', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Video</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('video', '', ['class' => 'form-control']);?>
                    </div>
                </div>
            </div>
            <!-- start: Album Ảnh -->
            <div class=" box p-5 mt-3">
                <div class="mt-3">
                    @include('components.dropzone',['action' => 'create'])
                </div>
            </div>
            <!-- END: Album Ảnh -->
            <div class=" box p-5 mt-3">
                <!-- start: SEO -->
                @include('components.seo')
                <!-- end: SEO -->
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            <div class=" box p-5 pt-3">
                <div>
                    <label class="form-label text-base font-semibold">Chọn Điểm đến cha</label>
                    <?php echo Form::select('parentid', $catalogue, null, ['class' => 'tom-select tom-select-custom w-full','data-placeholder'=>"Select your favorite actors"]); ?>
                </div>
            </div>
            @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.image',['action' => 'create','name' => 'banner','title'=> 'Banner'])
            @include('components.publish')

        </div>
    </form>
</div>
@endsection