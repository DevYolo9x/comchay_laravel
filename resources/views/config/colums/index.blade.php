@extends('dashboard.layout.dashboard')
@section('title')
<title>Cấu hình hiển thị</title>
@endsection
@section('breadcrumb')
<?php
$array = array(
    [
        "title" => "Cấu hình hiển thị",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
@endsection
@section('content')

<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Cấu hình hiển thị
    </h1>
    @include('components.alert-success')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <div class="flex space-x-2">

                <select class="form-control ajax-delete-all-config-colums mr10" style="width: 200px" data-title="Lưu ý: Khi bạn xóa danh mục nội dung tĩnh, toàn bộ nội dung tĩnh trong nhóm này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!" data-module="{{$module}}">
                    <option>Hành động</option>
                    <option value="">Xóa</option>
                </select>
                <form action="" class="flex space-x-2" id="search" style="margin-bottom: 0px;">
                    @if(!empty($table))
                    <select class="form-control mr10" name="module" style="width: 200px">
                        <option value="">Chọn module</option>
                        @foreach($table as $key=>$value)
                        <option value="{{$key}}" <?php if (request()->get('module') == $key) { ?>selected<?php } ?>>{{$value}}</option>
                        @endforeach
                    </select>
                    @endif
                    <input type="search" name="keyword" class="keyword form-control filter" placeholder="Nhập từ khóa tìm kiếm ..." autocomplete="off" value="<?php echo request()->get('keyword') ?>" style="width: 200px;">
                    <button class="btn btn-primary">
                        <i data-lucide="search"></i>
                    </button>
                </form>
            </div>
            <a href="{{route('config_colums.create')}}" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th style="width:40px;">
                            <input type="checkbox" id="checkbox-all">
                        </th>
                        <th class="whitespace-nowrap">ID</th>
                        <th class="whitespace-nowrap">TIÊU ĐỀ</th>
                        <th class="whitespace-nowrap">Module</th>
                        <th class="whitespace-nowrap">Type</th>
                        <th class="whitespace-nowrap">Hiển thị</th>
                        <th class="whitespace-nowrap">NGÀY TẠO</th>
                        <th class="whitespace-nowrap">#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key=>$v)
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                        </td>
                        <td>
                            {{$v->id}}
                        </td>
                        <td>
                            <?php echo $v->title; ?> (<?php echo count($v->postmetas) ?>)
                        </td>
                        <td>
                            <?php echo $table[$v->module]; ?>
                        </td>
                        <td>
                            <?php echo $v->type; ?>
                        </td>
                        <td class="w-40">
                            @include('components.publishTable',['module' => $module,'title' => 'publish','id' =>
                            $v->id])
                        </td>
                        <td>
                            @if($v->created_at)
                            {{Carbon\Carbon::parse($v->created_at)->diffForHumans()}}
                            @endif
                        </td>

                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('config_colums.edit',['id'=>$v->id]) }}">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                @if(count($v->postmetas) <= 0) <a class="flex items-center text-danger ajax-delete-config-colums" href="javascript:void(0)" data-id="<?php echo $v->id ?>" data-module="<?php echo $module ?>" data-child="0" data-title="Lưu ý: Khi bạn xóa danh mục, danh mục sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                    @endif
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
@push('javascript')
<script type="text/javascript">
    $(document).on("click", ".ajax-delete-config-colums", function(e) {
        e.preventDefault();

        let _this = $(this);
        let param = {
            title: _this.attr("data-title"),
            id: _this.attr("data-id"),
        };
        let parent = _this.attr("data-parent"); /*Đây là khối mà sẽ ẩn sau khi xóa */
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: param.title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    let formURL = "<?php echo route('config_colums.destroy') ?>";
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: formURL,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            module: param.module,
                            id: param.id,
                            router: param.router,
                            child: param.child,
                        },
                        success: function(data) {
                            if (data.code === 200) {
                                if (typeof parent != "undefined") {
                                    _this
                                        .parents("." + parent + "")
                                        .hide()
                                        .remove();
                                } else {
                                    _this.parent().parent().parent().hide().remove();
                                }
                                if (param.child == 1) {
                                    $("#listData" + param.id).remove();
                                }
                                swal({
                                    title: "Xóa thành công!",
                                    text: "Hạng mục đã được xóa khỏi danh sách.",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(jqXhr, json, errorThrown) {
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = "";
                            $.each(errors["errors"], function(index, value) {
                                errorsHtml += value + "/ ";
                            });
                            $("#myModal .alert").html(errorsHtml).show();
                        },
                    });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    }, function() {
                        location.reload();
                    });
                }
            }
        );
    });
    /*START: XÓA tất cả bản ghi */
    $(document).on('change', '.ajax-delete-all-config-colums', function() {
        let _this = $(this);
        let id_checked = []; /*Lấy id bản ghi */
        $('.checkbox-item:checked').each(function() {
            id_checked.push($(this).val());
        });
        if (id_checked.length <= 0) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này",
                type: "error"
            }, function() {
                location.reload();
            });
            return false;
        }
        let param = {
            'list': id_checked,
        }
        let parent = _this.attr('data-parent'); /*Đây là khối mà sẽ ẩn sau khi xóa */
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: param.title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo route('config_colums.delete_all') ?>',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            param: param
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                                for (let i = 0; i < id_checked.length; i++) {
                                    $('#post-' + id_checked[i]).hide().remove()
                                }
                                swal({
                                    title: "Xóa thành công!",
                                    text: "Các bản ghi đã được xóa khỏi danh sách.",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    swal({
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error"
                    }, function() {
                        location.reload();
                    });


                }
            });
    });
    /*END: XÓA tất cả bản ghi */
</script>
@endpush