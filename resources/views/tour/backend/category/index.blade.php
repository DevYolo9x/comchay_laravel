@extends('dashboard.layout.dashboard')
@section('title')
<title>Điểm đến</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Điểm đến",
            "src" => route('tour_categories.index'),
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
        Điểm đến
    </h1>
    @include('components.alert-success')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            @include('components.search',['module'=>$module,'catalogue' => TRUE])
            @can('tour_categories_create')
            <a href="{{route('tour_categories.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            @endcan
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                        <th class="whitespace-nowrap">VỊ TRÍ</th>
                        <th class="whitespace-nowrap">NGƯỜI TẠO</th>
                        <th class="whitespace-nowrap">NGÀY TẠO</th>
                        <th class="whitespace-nowrap">HIỂN THỊ</th>
                        <th class="whitespace-nowrap">TRANG CHỦ</th>
                        <!-- <th class="whitespace-nowrap">Nổi bật</th>
                        <th class="whitespace-nowrap">ASIDE</th> -->
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
                            <a href="{{route('tour.index',['catalogueid'=>$v->id])}}">
                                <?php echo str_repeat('|----', (($v->level > 0) ? ($v->level - 1) : 0)) . $v->title; ?>
                                ({{count($v->tourCount)}})</a>
                        </td>
                        @include('components.order',['module' => $module])
                        <td>
                            {{$v->user->name}}
                        </td>
                        <td>
                            @if($v->created_at)
                            {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                            @endif
                        </td>
                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])

                        </td>
                        <td class="w-40">
                            @include('components.isModule',['module' => $module,'title' => 'ishome','id' =>
                            $v->id])
                        </td>
                        <td class="w-40 hidden">
                            @include('components.isModule',['module' => $module,'title' => 'highlight','id' =>
                            $v->id])
                        </td>
                        <td class="w-40 hidden">
                            @include('components.isModule',['module' => $module,'title' => 'isaside','id' =>
                            $v->id])
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                @can('tour_categories_edit')
                                <a class="flex items-center mr-3"
                                    href="{{ route('tour_categories.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                                @endcan
                                @can('tour_categories_destroy')
                                <a class="flex items-center text-danger <?php echo !empty($v->tourCount->count() == 0) ? 'ajax-delete' : '' ?> <?php echo ($v->rgt - $v->lft > 1) ? 'disabled' : ''; ?>
                                    <?php echo !empty($v->tourCount->count() == 0) ? '' : 'disabled' ?>"
                                    href="javascript:void(0);" data-id="<?php echo $v->id ?>"
                                    data-module="<?php echo $module ?>" data-child="0"
                                    data-title="Lưu ý: Khi bạn xóa Điểm đến, Điểm đến sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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