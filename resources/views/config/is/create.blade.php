@extends('dashboard.layout.dashboard')
@section('title')
<title>Thêm mới </title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách ",
        "src" => route('configIs.index'),
    ],
    [
        "title" => "Thêm mới",
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
            Thêm mới
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('configIs.store')}}" method="post" enctype="multipart/form-data">
        <div class="col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề </label>
                    <?php echo Form::text('title', '', ['class' => 'form-control w-full']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Module</label>
                    <?php echo Form::select('module', $table, null, ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => ""]); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Type</label>
                    <?php echo Form::select('type', $type, null, ['class' => 'tom-select tom-select-custom w-full', 'data-placeholder' => ""]); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Hiển thị</label>
                    <div class="flex items-center">
                        <input type="checkbox" checked name="active" value="1" class="checkbox-item mr-1">
                        Cho phép hiển thị
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </div>
            </div>

            <!-- END: Form Layout -->
        </div>

    </form>
</div>
@endsection