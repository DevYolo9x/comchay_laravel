@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập thuộc tính</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách thuộc tính",
            "src" => route('attributes.index'),
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
            Cập nhập thuộc tính
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('attributes.update',['id' => $detail->id])}}"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full title']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Đường dẫn</label>
                    <div class="input-group">
                        <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
                        </div>
                        <?php echo Form::text('slug', $detail->slug, ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('description', $detail->description, ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
                    </div>
                </div>
            </div>
            <div class=" box p-5 mt-3">
                <!-- start: SEO -->
                @include('components.seo')
                <!-- end: SEO -->
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            <div class=" box p-5 pt-3">
                <label class="form-label text-base font-semibold">Chọn nhóm thuộc tính</label>
                <?php echo Form::select('catalogueid', $htmlOption, $detail->catalogueid, ['class' => 'tom-select tom-select-custom w-full','data-placeholder'=>"Select your favorite actors"]); ?>
            </div>
            <div class=" box p-5 pt-3 mt-3 hidden">
                <label class="form-label text-base font-semibold">Màu sắc</label>
                <?php echo Form::text('color', $detail->color, ['placeholder'=> '','class' => 'form-control ','autocomplete'=>'off']); ?>

            </div>
            <div class=" box p-5 pt-3 mt-3 hidden">
                <label class="form-label text-base font-semibold">Khoảng giá</label>
                <div class="flex justify-between items-center">
                    <?php echo Form::text('price_start', $detail->price_start, ['placeholder'=> 'Từ','class' => 'form-control int','autocomplete'=>'off','style'=>'width: calc(100% - 30px);']);?>
                    <span style="margin: 0px 5px;">-</span>
                    <?php echo Form::text('price_end',  $detail->price_end, ['placeholder'=> 'đến','class' => 'form-control int','autocomplete'=>'off','style'=>'width: calc(100% - 30px);']);?>
                </div>
            </div>
            @include('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.publish')
        </div>
    </form>
</div>
@endsection