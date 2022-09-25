@extends('dashboard.layout.dashboard')

@section('title')
<title>Thêm mới phân quyền</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách nhóm phân quyền",
            "src" => route('permissions.index'),
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
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('permissions.store')}}" method="post"
        enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên module</label>
                    <select class="tom-select tom-select-custom w-full tomselected" data-placeholder="Search..."
                        name="title" tabindex="-1">
                        <option value=""></option>
                        @foreach(config('permissions.modules') as $k=>$v)
                        <option value="{{$k}}" {{ (collect(old('title'))->contains($k)) ? 'selected':'' }}> {{$v}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <div class="mt-2">
                        <?php echo Form::textarea('description', '', ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>
                <div class="mt-3 ">
                    <label class="form-label text-base font-semibold">Quyền module </label>
                    <div class="grid grid-cols-12 gap-6">
                        @foreach(config('permissions.actions') as $k=>$v)
                        <div class="col-span-3">
                            <label for="check{{$k}}">
                                <input name="permission_id[]" type="checkbox" class="inputChild" value="{{$k}}"
                                    id="check{{$k}}" />
                                {{$v}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection