@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới media</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách menu",
            "src" => route('menus.index'),
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
            Thêm mới menu
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('menus.store')}}" method="post"
        enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên menu</label>
                    <?php echo Form::text('title', '', ['class' => 'form-control w-full title','required']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Từ khóa</label>
                    <div class="input-group">

                        <?php echo Form::text('slug', '', ['class' => 'form-control canonical', 'data-flag' => 0,'required']); ?>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <di v class=" col-span-12 lg:col-span-4">
            @include('components.publish')
        </di>
    </form>
</div>

@endsection