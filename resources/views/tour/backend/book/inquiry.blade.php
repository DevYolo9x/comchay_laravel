@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách đặt tour</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách đặt tour",
            "src" => route('tour_books.inquiry'),
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
    <form action="" class="grid grid-cols-12 gap-1 space-x-2  mt-5" id="search" style="margin-bottom: 0px;">
        <div class="col-span-2">
            <select class="form-control ajax-delete-all  "
                data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!"
                data-module="{{$module}}">
                <option>Hành động</option>
                <option value="">Xóa</option>
            </select>
        </div>


        <div class="col-span-3">
            <?php echo Form::text('date', request()->get('date') , ['class' => 'form-control',  'autocomplete' => 'off']);?>
        </div>
        <div class="col-span-3 flex">
            <input type="search" name="keyword" class="keyword form-control filter w-full mr-1"
                placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off"
                value="<?php echo request()->get('keyword') ?>">
            <button class="btn btn-primary btn-sm">
                <i data-lucide="search"></i>
            </button>
        </div>
    </form>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Thông tin</th>
                        <th class="whitespace-nowrap">Tour Require</th>
                        <th class="whitespace-nowrap">Ngày tạo</th>
                        <th class="whitespace-nowrap text-center">#</th>
                    </tr>
                </thead>

                <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
                    @foreach($data as $v)

                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>"
                                class="checkbox-item">
                        </td>
                        <td>
                            {{$data->firstItem()+$loop->index}}
                        </td>
                        <td>
                            <p><b>CODE:</b> <a href="javascript:void(0)">#<?php echo $v->code; ?></a></p>
                            <p><?php echo $v->fullname; ?></p>
                            <p><?php echo $v->phone; ?></p>
                            <p><?php echo $v->address; ?></p>
                            <p><?php echo $v->email; ?></p>
                        </td>
                        <td>
                            <?php echo $v->inquiryTour; ?>
                        </td>
                        <td>
                            {{$v->created_at}}
                        </td>
                        <td class="">

                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-danger ajax-delete" href="javascript:;"
                                    data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0"
                                    data-title="Lưu ý: Khi bạn xóa đơn hàng, đơn hàng sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
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

@endpush
