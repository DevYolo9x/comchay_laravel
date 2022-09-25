@extends('dashboard.layout.dashboard')

@section('title')
<title>Danh sách thành viên</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách thành viên",
            "src" => route('users.index'),
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
    <h1 class=" text-lg font-medium mt-10">
        Danh sách thành viên
    </h1>
    @include('components.alert-success')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @can('users_create')
            <a href="{{route('users.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Ảnh đại diện</th>
                        <th class="whitespace-nowrap">Tên thành viên</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="whitespace-nowrap">Nhóm thành viên</th>
                        <th class="whitespace-nowrap">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <div class="w-10 h-10 image-fit zoom-in -ml-5">
                                <img alt="{{$v->name}}" class=" rounded-full"
                                    src="<?php echo !empty($v->image)?asset($v->image):asset('images/404.png')?>">
                            </div>
                        </td>
                        <td>
                            {{$v->name}}
                            @can('users_edit')
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                <a data-url="{{ route('users.reset-password',['id'=>$v->id])}}"
                                    href="javascript:void(0)" class="p-reset text-warning"
                                    data-userid="{{$v->id}}">RESET mật khẩu</a>
                            </div>
                            @endcan
                        </td>
                        <td>
                            {{$v->email}}
                        </td>
                        <td>
                            @foreach($v->roles as $v1)
                            <a href="{{ route('roles.edit',['id'=>$v1->id]) }}"
                                class="btn btn-warning btn-sm">{{$v1->title}}</a>
                            @endforeach
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                @can('users_edit')
                                <a class="flex items-center mr-3" href="{{ route('users.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                @endcan
                                @can('users_destroy')
                                <a class="flex items-center text-danger p-destroy" href="javascript:;"
                                    data-url="{{ route('users.destroy',['id'=>$v->id]) }}" data-id="{{ $v->id }}">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            {{$data->links()}}
        </div>
        <!-- END: Pagination -->
    </div>
</div>
@endsection
@push('javascript')
<script src="{{ asset('backend/library/users.js') }}"></script>
@endpush
