@extends('dashboard.layout.dashboard')

@section('title')
<title>Cập nhập {{$detail->title}}</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách",
            "src" => route('tour_services.index'),
        ],
        [
            "title" => "Cập nhập",
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
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form"
        action="{{route('tour_services.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class="mt-3 box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tiêu đề</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full','required']); ?>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            @include('components.publish')
        </div>
    </form>
    <div class=" flex items-center  mt-5">
        <h1 class="text-lg font-medium mr-auto hTitleItem">
            Thêm mới item
        </h1>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <div class=" col-span-12 lg:col-span-4">
            <!-- START: form thêm mới -->
            <form class="mt-3 box p-5" role="form" id="formSubmit" action="" method="post"
                enctype="multipart/form-data">
                <div class="alert alert-danger p-2 mb-3" style="display: none;"></div>
                <div class="">
                    <div>
                        <label class="form-label text-base font-semibold">Tiêu đề</label>
                        <input type="text" id="titleItem" class="form-control" placeholder="" require>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="pull-right btn btn-primary">Thêm mới</button>
                </div>
            </form>
            <!-- END: form thêm mới -->
            <!-- START: form cập nhậo -->

            <form class="mt-3 box p-5 hidden" role="form" id="formSubmitUpdate" action="" method="post"
                enctype="multipart/form-data">
                <div class="alert alert-danger p-2 mb-3" style="display: none;"></div>
                <div class="">
                    <div>
                        <label class="form-label text-base font-semibold">Tiêu đề</label>
                        <input type="text" id="titleItemUpdate" class="form-control" placeholder="" require>
                        <input type="hidden" id="idItemUpdate" value="">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="pull-right btn btn-primary">Cập nhập</button>
                </div>
            </form>
            <!-- END: form cập nhập -->

        </div>
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class="mt-3 box p-5">
                @if(count($detail->items) > 0)
                <div class="mb-2">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th style="">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="checkbox-all">
                                        <select class="form-control ajax-delete-all mr10 col-span-2 ml-2"
                                            data-title="Lưu ý: Khi bạn xóa , toàn bộ nội dung này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!"
                                            data-module="tour_service_items">
                                            <option>Hành động</option>
                                            <option value="">Xóa</option>
                                        </select>

                                    </div>
                                </th>
                                <th class="whitespace-nowrap" style="padding-left:0px">TIÊU ĐỀ</th>
                                <th class="whitespace-nowrap">Vị trí</th>
                                <th class="whitespace-nowrap">HIỂN THỊ</th>
                                <th class="whitespace-nowrap text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail->items as $v)
                            <tr class="odd " id="post-<?php echo $v->id; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>"
                                        class="checkbox-item">
                                </td>
                                <td>
                                    <?php echo $v->title; ?>
                                </td>
                                @include('components.order',['module' => 'tour_service_items'])

                                <td class="w-40">
                                    @include('components.publishTable',['module' => 'tour_service_items','title' =>
                                    'publish','id' =>
                                    $v->id])
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3 editForm" href="javascript:void(0)"
                                            data-info="{{$v}}">
                                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                            Edit
                                        </a>
                                        <a class="flex items-center text-danger ajax-delete" href="javascript:void(0)"
                                            data-id="{{$v->id}}" data-module="tour_service_items" data-child="0"
                                            data-title="Lưu ý: Khi bạn xóa, sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script>
$("#formSubmit").submit(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        url: '<?php echo route('tourServiceItem.store')?>',
        type: "POST",
        dataType: "JSON",
        data: {
            id: <?php echo $detail->id?>,
            title: $('#titleItem').val(),
        },
        success: function(data) {
            $(".alert-danger").html('').hide();
            swal({
                title: "Thêm mới thành công!",
                text: "",
                type: "success"
            }, function() {
                location.reload();
            });
        },
        error: function(jqXhr, json, errorThrown) {
            var errors = jqXhr.responseJSON;
            var errorsHtml = "";
            $.each(errors["errors"], function(index, value) {
                errorsHtml += value + "/ ";
            });
            $(".alert-danger").html(errorsHtml).show();
        },
    });
})
$(document).on('click', '.editForm', function(event) {
    $('.hTitleItem').text('Cập nhập item');
    let info = JSON.parse($(this).attr('data-info'));
    $('#formSubmit').addClass('hidden');
    $('#formSubmitUpdate').removeClass('hidden');
    $('#titleItemUpdate').val(info.title);
    $('#idItemUpdate').val(info.id);
    $('tr').removeClass('active');
    $(this).parent().parent().parent().addClass('active');
})
$("#formSubmitUpdate").submit(function(e) {
    e.preventDefault();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        url: '<?php echo route('tourServiceItem.update')?>',
        type: "POST",
        dataType: "JSON",
        data: {
            id: $('#idItemUpdate').val(),
            title: $('#titleItemUpdate').val(),
        },
        success: function(data) {
            $(".alert-danger").html('').hide();
            swal({
                title: "Cập nhập thành công!",
                text: "",
                type: "success"
            }, function() {
                location.reload();
            });
        },
        error: function(jqXhr, json, errorThrown) {
            var errors = jqXhr.responseJSON;
            var errorsHtml = "";
            $.each(errors["errors"], function(index, value) {
                errorsHtml += value + "/ ";
            });
            $(".alert-danger").html(errorsHtml).show();
        },
    });
})
</script>
<style>
tr.active td {
    background-color: #ffc !important;
}
</style>

@endpush