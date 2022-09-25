@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách",
            "src" => route('tours.index'),
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
        Danh sách
    </h1>
    @include('components.alert-success')
    <form action="" class=" grid grid-cols-12 gap-6 justify-between  mt-5">
        <select class="form-control ajax-delete-all mr10 col-span-2"
            data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!"
            data-module="{{$module}}">
            <option>Hành động</option>
            <option value="">Xóa</option>
        </select>
        @if(isset($category))
        <div class="col-span-3">
            <?php echo Form::select('category_id', $category, request()->get('category_id'), ['class' => 'form-control tom-select tom-select-custom  ','data-placeholder'=>"Select your favorite actors"]);?>
        </div>
        @endif
        <input type="search" name="keyword" class="keyword form-control  col-span-4" placeholder="Tên tour...."
            autocomplete="off" value="<?php echo request()->get('keyword') ?>">
        <button class="btn btn-primary" type="submit">
            <i data-lucide="search"></i>
        </button>

        @can('tours_create')
        <a href="{{route('tours.create')}}" class="btn btn-primary shadow-md mr-2 col-span-2">Thêm mới</a>
        @endcan
    </form>

    <div class="grid grid-cols-12 gap-6 ">
        <div class="col-span-12 overflow-auto lg:overflow-visible">
            <!-- BEGIN: Data List -->
            <div class="">
                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th style="">
                                <input type="checkbox" id="checkbox-all">
                            </th>
                            <th style="">STT</th>
                            <th>Tiêu đề</th>
                            <th>Điểm đến</th>
                            <th>Giá</th>
                            <th>Vị trí</th>
                            <th>Ngày tạo</th>
                            <th>Người tạo</th>
                            <th>Hiển thị</th>
                            <th>FLASH DEAL</th>
                            <th>POPULAR TOUR</th>
                            <th>Hot tour</th>
                            <th class="whitespace-nowrap">#</th>
                        </tr>
                    </thead>
                    <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($data as $v)
                        <?php $getPrice = getPrice(array('price' =>$v->price,'price_sale' => $v->price_sale,'price_contact' =>$v->price_contact)); ?>
                        <tr class="odd " id="post-<?php echo $v->id; ?>">
                            <td>
                                <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>"
                                    class="checkbox-item">
                            </td>
                            <td>
                                {{$data->firstItem()+$loop->index}}
                            </td>

                            <td>
                                <a href="{{route('routerURL',['slug' => $v->slug])}}" target="_blank"
                                    class="tooltip text-primary font-medium"
                                    title="<?php echo $v->title; ?>"><?php echo $v->title; ?></a>
                            </td>
                            <td>
                                <div class="list-catalogue">
                                    @foreach($v->catalogues_relationships as $kc=>$c)
                                    <a class="text-danger" href="{{route('routerURL',['slug' => $c->slug])}}"
                                        target="_blank"><?php echo !empty($kc == 0) ? '' : ',' ?>{{$c->title}}</a>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <?php if($getPrice['price_old']){?>
                                <old style="text-decoration: line-through;"><?php echo $getPrice['price_old']?><br>
                                </old>
                                <?php }?>
                                <?php echo $getPrice['price_final']?>
                            </td>
                            @include('components.order',['module' => $module])
                            <td>
                                @if($v->created_at)
                                {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                                @endif
                            </td>
                            <td>
                                {{$v->user->name}}
                            </td>
                            <td class="w-40">
                                @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                                $v->id])
                            </td>
                            <td class="w-40">
                                @include('components.isModule',['module' => $module,'title' => 'ishome','id' =>
                                $v->id])
                            </td>
                            <td class="w-40">
                                @include('components.isModule',['module' => $module,'title' => 'highlight','id' =>
                                $v->id])
                            </td>
                            <td class="w-40">
                                @include('components.isModule',['module' => $module,'title' => 'isfooter','id' =>
                                $v->id])
                            </td>
                            <td class="table-report__action w-56 ">
                                <div class="flex justify-center items-center">
                                    @can('tours_edit')
                                    <a class="flex items-center mr-3" href="{{ route('tours.edit',['id'=>$v->id]) }}">
                                        <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                                    </a>
                                    @endcan
                                    @can('tours_destroy')
                                    <a class="flex items-center text-danger ajax-delete" href="javascript:;"
                                        data-id="<?php echo $v->id ?>" data-module="{{$module}}" data-child="0"
                                        data-title="Lưu ý: Khi bạn xóa tour, tour sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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
</div>
@endsection
@push('javascript')

@endpush
