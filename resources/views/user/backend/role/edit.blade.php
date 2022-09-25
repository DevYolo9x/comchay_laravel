@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập nhóm thành viên</title>
@endsection

@section('content')
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách nhóm thành viên",
            "src" => route('roles.index'),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('roles.update',['id' => $detailRole->id])}}"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên nhóm thành viên</label>
                    <?php echo Form::text('title', $detailRole->title, ['class' => 'form-control w-full ']); ?>
                </div>

                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Mô tả</label>
                    <div class="mt-2">
                        <?php echo Form::text('description', $detailRole->description, ['class' => 'form-control w-full ']); ?>
                    </div>
                </div>

            </div>
            <!-- END: Album Ảnh -->
            <div class=" box p-5 mt-3 space-y-5">
                @foreach($permissions as $k=>$v)
                <div class="grid grid-cols-12 ">
                    <div class="col-span-12 md:col-span-4">
                        <label
                            class="form-label text-base font-semibold">{{config('permissions.modules')[$v->title]}}</label>
                    </div>
                    @foreach($v->permissionsChildren as $val)
                    @if($val->title != 'Copy hình ảnh' && $val->title != 'Di chuyển hình ảnh')

                    <div class="col-span-12 xl:col-span-2">
                        <label for="check{{$val->id}}">
                            <input {{$permissionChecked->contains('id',$val->id) ? 'checked' : ''}}
                                name="permission_id[]" type="checkbox" class="inputChild" value="{{$val->id}}"
                                id="check{{$val->id}}" />
                            {{!empty(config('permissions.actions')[$val->title])?config('permissions.actions')[$val->title]:$val->title}}
                        </label>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endforeach
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Lưu</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </form>

</div>
@endsection
