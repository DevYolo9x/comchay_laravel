@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách </title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách",
            "src" => route('tour_services.index'),
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
        Danh sách
    </h1>
    @include('components.alert-success')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <a href="{{route('tour_services.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">ID</th>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                        <th class="whitespace-nowrap">VỊ TRÍ</th>
                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>
                        <th class="whitespace-nowrap">NGÀY TẠO</th>
                        <th class="whitespace-nowrap">HIỂN THỊ</th>
                        <th class="whitespace-nowrap">Không bao gồm</th>
                        <th class="whitespace-nowrap">Amenities</th>
                        <th class="whitespace-nowrap">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            {{$v->id}}
                        </td>
                        <td>
                            <?php echo $v->title; ?>
                        </td>
                        @include('components.order',['module' => $module])
                        <td>
                            {{$v->user->name}}
                        </td>
                        <td>
                            @if($v->created_at)
                            {{Carbon\Carbon::parse()->diffForHumans()}}
                            @endif
                        </td>
                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])
                        </td>
                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'type','id' =>
                            $v->id])
                        </td>
                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'ishome','id' =>
                            $v->id])
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3"
                                    href="{{ route('tour_services.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;"
                                    data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0"
                                    data-title="Lưu ý: Khi bạn xóa bài viết, bài viết sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                            </div>
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