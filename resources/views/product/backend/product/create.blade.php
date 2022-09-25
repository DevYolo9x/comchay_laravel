@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới sản phẩm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách sản phẩm",
        "src" => route('products.index'),
    ],
    [
        "title" => "Thêm mới sản phẩm",
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
            Thêm mới sản phẩm
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <ul class="nav nav-link-tabs flex-wrap" role="tablist">
                <li id="example-homepage-tab" class="nav-item" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-homepage" type="button" role="tab" aria-controls="example-tab-homepage" aria-selected="true">Thông tin chung</button>
                </li>
                @if(!$field->isEmpty())
                <li id="example-contact-tab" class="nav-item " role="presentation">
                    <button class="nav-link w-full py-2 " data-tw-toggle="pill" data-tw-target="#example-tab-contact" type="button" role="tab" aria-controls="example-tab-contact" aria-selected="true">Custom field</button>
                </li>
                @endif
            </ul>
            @include('components.alert-error')
            @csrf
            <div class="tab-content">
                <div id="example-tab-homepage" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-homepage-tab">
                    @include('product.backend.product.common._detail',['action' => 'create'])
                    <div class="<?php if (!in_array('attributes', $dropdown)) { ?>hidden<?php } ?>">
                        @include('product.backend.product.common.attribute',['action' => 'create'])
                    </div>
                </div>
                <div id="example-tab-contact" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="example-contact-tab">
                    @include('components.field.index', ['module' => $module])
                </div>
            </div>

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
                    <label class="form-label text-base font-semibold">Chọn danh mục chính</label>
                    <?php echo Form::select('catalogue_id', $htmlCatalogue, old('catalogue_id'), ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm danh mục...", 'required']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Chọn danh mục phụ</label>
                    <?php echo Form::select('catalogue[]', $htmlCatalogue, null, ['multiple', 'class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => "Tìm kiếm danh mục..."]); ?>
                </div>
                <div class="mt-3 <?php if (!in_array('brands', $dropdown)) { ?>hidden<?php } ?>">
                    <label class="form-label text-base font-semibold">Thương hiệu</label>
                    <select class="tom-select w-full tom-select-custom" data-placeholder="Tìm kiếm thương hiệu..." data-header="Thương hiệu" name="brands[]" tabindex="-1" hidden="hidden">
                        <option>Chọn thương hiệu </option>
                        @if(isset($brands))
                        @foreach($brands as $k=>$brand)
                        <option value="{{$brand->id}}" {{ (collect($getBrands)->contains($brand->id)) ? 'selected':'' }}>
                            {{$brand->title}}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            @include('components.image',['action' => 'create','name' => 'image','title'=> 'Ảnh đại diện'])
            @include('components.tag',['module' => $module])
            @include('components.publish')
        </div>
    </form>
</div>
@include('product.backend.product.common.script')
<style>
    .dz-preview {
        border-radius: 10px;
        -webkit-box-shadow: -8px -4px 57px -34px rgb(66 68 90);
        -moz-box-shadow: -8px -4px 57px -34px rgba(66, 68, 90, 1);
        box-shadow: -8px -4px 57px -34px rgb(66 68 90);
    }
</style>
@endsection