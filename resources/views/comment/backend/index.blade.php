@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách comment</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Danh sách comment",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách comment
    </h1>
    @include('components.alert-success')
    <form action="" class="grid grid-cols-12 gap-1 space-x-2  mt-5" id="search" style="margin-bottom: 0px;">
        <div class="col-span-2">
            <select class="form-control ajax-delete-all  " data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
                <option>Hành động</option>
                <option value="">Xóa</option>
            </select>
        </div>
        <?php $array_star = ['' => 'Đánh giá', '1' => '1 sao', '2' => '2 sao', '3' => '3 sao', '4' => '4 sao', '5' => '5 sao',]; ?>
        <?php $array_module = ['' => 'Chọn module', 'articles' => 'Bài viết', 'products' => 'Sản phẩm', 'tours' => 'Tours']; ?>
        <div class="col-span-2">
            <?php echo Form::select('rating', $array_star, request()->get('rating'), ['class' => 'form-control']); ?>
        </div>
        <?php /*<div class="col-span-2">
            <?php echo Form::select('module_id', $getProduct, request()->get('module_id'), ['class' => 'form-control tom-select tom-select-custom w-full','data-placeholders'=>'Chon san phẩm']); ?>
</div>*/ ?>
        <div class="col-span-2 hidden">
            <?php echo Form::select('module', $array_module, request()->get('module'), ['class' => 'form-control']); ?>
        </div>

        <div class="col-span-3">
            <?php echo Form::text('date', request()->get('date'), ['class' => 'form-control',  'autocomplete' => 'off']); ?>
        </div>
        <div class="col-span-3 flex">
            <input type="search" name="keyword" class="keyword form-control filter w-full mr-1" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>">
            <button class="btn btn-primary btn-sm">
                <i data-lucide="search"></i>
            </button>
        </div>
    </form>
    <div class="grid grid-cols-12 gap-6 mt-3">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th style="width:40px;">STT</th>
                        <th>Tên khách hàng</th>
                        <th class="hidden" style="width:200px;">Nội dung</th>
                        <th>Module</th>
                        <th style="width:200px;">Chủ đề</th>
                        <th class="hidden">Đánh giá</th>
                        <th>Hiển thị</th>
                        <th class="text-center">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        <td class="sorting_1">{{$data->firstItem()+$loop->index}}</td>
                        <td>
                            <?php echo  $v->fullname; ?>
                            <br> {{$v->phone}}
                            <br> {{$v->created_at}}
                        </td>
                        <td class="hidden">
                            {{$v->message}}
                        </td>
                        <td>
                            {{$v->module}}
                        </td>
                        <td>
                            @if($v->module == 'tours')
                            @if(!empty($v->tour))
                            <a href="{{route('routerURL',['slug' => $v->tour->slug])}}" class="text-primary" target="_blank">{{$v->tour->title}}</a>
                            @endif
                            @elseif($v->module == 'products')
                            @if(!empty($v->product))
                            <a href="{{route('routerURL',['slug' => $v->product->slug])}}" class="text-primary" target="_blank">{{$v->product->title}}</a>
                            @endif
                            @elseif($v->module == 'articles')
                            @if(!empty($v->article))
                            <a href="{{route('routerURL',['slug' => $v->article->slug])}}" class="text-primary" target="_blank">{{$v->article->title}}</a>
                            @endif

                            @endif
                        </td>
                        <td class="hidden">
                            <div class="flex">
                                <?php for ($i = 1; $i <= $v->rating; $i++) { ?>
                                    <i data-lucide="star" class="w-4 h-4" style="color:#ea9d02;fill:#ea9d02;"></i>
                                <?php } ?>
                                <?php for ($i = 1; $i <= 5 - $v->rating; $i++) { ?>
                                    <i data-lucide="star" class="w-4 h-4" style="color:#ea9d02"></i>
                                <?php } ?>
                            </div>
                        </td>

                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                @can('comments_edit')
                                <a class="flex items-center mr-3" href="{{ route('comments.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                @endcan
                                @can('comments_destroy')
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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
<script type="text/javascript" src="{{asset('library/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('library/daterangepicker/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('library/daterangepicker/daterangepicker.css')}}" />
<script type="text/javascript">
    $(function() {
        $('input[name="date"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: " to "
            }
        });
    });
</script>
<style>
    table {
        table-layout: fixed;
    }

    table td {
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

@endpush