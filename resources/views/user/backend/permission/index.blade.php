@extends('dashboard.layout.dashboard')

@section('title')
<title>Danh sách nhóm phân quyền</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách nhóm phân quyền",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách nhóm phân quyền
    </h1>
    @include('components.alert-success')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <a href="{{route('permissions.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">ID</th>
                        <th class="whitespace-nowrap">Tên module</th>
                        <th class="whitespace-nowrap">Trạng thái</th>
                    </tr>
                </thead>
                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            {{$v->id}}
                        </td>
                        <td>{{config('permissions.modules')[$v->title]}}</td>
                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
</div>
@endsection