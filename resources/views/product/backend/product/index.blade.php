@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách sản phẩm</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách sản phẩm",
        "src" => route('products.index'),
    ],
    [
        "title" => "Danh sách",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);

?>
@endsection
@section('content')
<div class="content">
    <h1 class="text-lg font-medium mt-10">
        Danh sách sản phẩm
    </h1>
    @include('components.alert-success')
    <div class=" grid grid-cols-12 gap-6 justify-between  mt-5 mb-5">
        @if(empty($catalogue))
        <select class="form-control ajax-delete-all mr10 col-span-2 " data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
            <option>Hành động</option>
            <option value="">Xóa</option>
        </select>
        @endif
        @if(isset($configIs))
        <div class="col-span-2">
            <select class="form-control mr10 filter h-10" name="type">
                <option value="" selected>Chọn hiển thị</option>
                @foreach($configIs as $key=>$value)
                <option value="{{$value->type}}" <?php if (!empty(request()->get('type')) && request()->get('type') == $value->module) { ?>selected<?php } ?>>{{$value->title}}
                </option>
                @endforeach
            </select>
        </div>
        @endif
        @if(isset($htmlOption))
        <div class="col-span-2">

            <?php echo Form::select('catalogue_id', $htmlOption, request()->get('catalogue_id'), ['class' => 'form-control tom-select tom-select-custom filter catalogue_id ', 'data-placeholder' => "Select your favorite actors"]); ?>
        </div>
        @endif
        <input type="search" name="keyword" class="keyword form-control filter col-span-3" placeholder="Tên sản phẩm, mã sản phẩm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">

        <a class="full-search btn btn-danger col-span-2 hidden" href="javascript:void(0);">Tìm kiếm nâng cao</a>
        @can('products_create')
        <a href="{{route('products.create')}}" class="btn btn-primary shadow-md mr-2 col-span-2">Thêm mới</a>
        @endcan
    </div>
    <!-- START: tìm kiếm -->
    <div class="mb10 row filter-more grid grid-cols-12 gap-6 justify-between mt-5 hidden">
        <div class="col-span-4">
            <label class="form-label text-base font-semibold">Nhập khoảng giá</label>

            <div class="sm:grid grid-cols-2 gap-2">
                <div class="input-group">
                    <div class="input-group-text">Từ</div>
                    <input type="text" class="form-control int filter h-10" name="start_price" value="">
                </div>
                <div class="input-group">
                    <div class="input-group-text">Đến</div>
                    <input type="text" class="form-control int filter h-10" name="end_price" value="">
                </div>
            </div>
        </div>
        <div class="col-span-4  <?php if (!in_array('tags', $dropdown)) { ?>hidden<?php } ?>">
            <label class="form-label text-base font-semibold">Tags</label>
            <select class="tom-select-custom tom-select w-full filter" data-placeholder="Tìm kiếm tag..." data-header="Tags" multiple="multiple" name="tags[]" tabindex="-1" hidden="hidden">
                @if(isset($tags))
                @foreach($tags as $k=>$tag)
                <option value="{{$tag->id}}">
                    {{$tag->title}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-span-4 <?php if (!in_array('brands', $dropdown)) { ?>hidden<?php } ?>">
            <label class="form-label text-base font-semibold">Thương hiệu</label>
            <select class="tom-select-custom tom-select w-full filter" data-placeholder="Tìm kiếm thương hiệu..." data-header="Thương hiệu" multiple="multiple" name="brands[]" tabindex="-1" hidden="hidden">
                @if(isset($brands))
                @foreach($brands as $k=>$brand)
                <option value="{{$brand->id}}">
                    {{$brand->title}}
                </option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-span-12" id="selected_attr"></div>

        <div class="col-span-12">
            <div id="choose_attr">
                <label class="form-label text-base font-semibold">Thuộc tính</label>
                <input type="text" class="hidden filter" name="attr" value="">
                <ul class="list_attr_catalogue bg-white p-3" style="display: none">
                </ul>
            </div>
        </div>
    </div>
    <!-- END: tìm kiếm -->
    <div class="grid grid-cols-12 gap-6 ">
        <div id="data_product" class="col-span-12 overflow-auto lg:overflow-visible">
            @include('product.backend.product.index.data')
        </div>
    </div>
</div>
@endsection
@push('javascript')
@include('product.backend.product.index.script')
@endpush