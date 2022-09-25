@extends('dashboard.layout.dashboard')
@section('title')
<title>Danh sách menu</title>
@endsection
@section('breadcrumb')
<?php
    $array = array(
        [
            "title" => "Danh sách menu",
            "src" => route('menus.index'),
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
    <h1 class="text-lg font-medium mt-10 uppercase">
        Danh sách {{$detail->title}}
    </h1>
    @include('components.alert-success')
    @if(env('APP_ENV') == "local")
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="{{route('menus.update',['id' => $detail->id])}}"
        method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8 mt-3">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                @include('components.alert-error')
                @csrf
                <div>
                    <label class="form-label text-base font-semibold">Tên menu</label>
                    <?php echo Form::text('title', $detail->title, ['class' => 'form-control w-full title','required']); ?>
                </div>
                <div class="mt-3">
                    <label class="form-label text-base font-semibold">Từ khóa</label>
                    <div class="input-group">

                        <?php echo Form::text('slug', $detail->slug, ['class' => 'form-control canonical', 'data-flag' => 0,'required']); ?>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <di v class="col-span-12 lg:col-span-4">
            @include('components.publish')
        </di>
    </form>
    @endif
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 md:col-span-4">
            @include('menu.backend.module')
        </div>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 md:col-span-8 overflow-auto lg:overflow-visible">
            <?php if(!empty($menuitems)){?>
            <div id="menu-content">
                <div class="accordion accordion-boxed" id="faq-accordion-3">
                    <p>Kéo các mục tới vị trí bạn mong muốn. Nhấp chuột vào mũi tên bên phải để thiết lập tuỳ chỉnh cho
                        mỗi mục. Sau đó ấn <span class="text-danger">"LƯU MENU"</span></p>
                    <div class="mt-3 mb-3">
                        <label>
                            <input type="checkbox" id="checkbox-all-menu">
                            <span>Chọn tất cả</span>
                        </label>
                    </div>
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @if (count($menuitems) > 0)
                            @foreach ($menuitems as $item)
                            @include('menu.backend.renderMenuItem', $item)
                            @endforeach
                            @endif
                        </ol>
                    </div>
                </div>
                <div style="clear:both"></div>
                @if(count($menuitems) > 0)
                <div class="text-left" style="position: sticky;bottom: 0;z-index: 10;float: left; width: 100%;">
                    @can('menus_destroy')
                    <button class="btn btn-danger ajax-delete-all-menu mb-1 mb:0" data-module="menu_items"
                        data-title="Lưu ý: Khi bạn xóa toàn bộ menu, toàn bộ menu này sẽ bị xóa. Hãy chắc chắn rằng bạn muốn thực hiện chức năng này!">Xóa
                        những mục được chọn</button>
                    @endcan
                    @can('menus_edit')
                    <input type="hidden" class="form-control w-full mb-1" id="nestable-output" name="menu">
                    <button type="button" class="btn btn-primary w-32" id="saveMenu">LƯU MENU</button>
                    @endcan
                </div>
                @endif
            </div>
            <?php }?>
        </div>
        <!-- END: Data List -->
    </div>
</div>
@endsection

@push('javascript')
<script>
$('#saveMenu').click(function() {
    var menuid = <?php echo $detail->id ?>;
    var value = $("#nestable-output").val();
    $.ajax({
        type: "get",
        data: {
            menuid: menuid,
            value: value
        },
        url: "{{route('update-menu')}}",
        success: function(res) {
            swal({
                title: "Lưu menu thành công!",
                text: "Các bản ghi đã được sắp xếp.",
                type: "success"
            }, function() {
                location.reload();
            });
        },
        error: function(data) {
            var errors = data.responseJSON;
            swal({
                title: "ERROR",
                text: errors.message,
                type: "error"
            }, function() {
                location.reload();
            });

        }
    })
})
$('.accordionQ').click(function(event) {
    var id = $(this).attr('data-id');
    $('.collapseQ-' + id).toggleClass('d-none');
});
$('input[name="clickAllMenu"]').click(function(event) {
    if (this.checked) {
        $(this).parent().parent().parent().find('.item-list-body :checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $(this).parent().parent().parent().find('.item-list-body :checkbox').each(function() {
            this.checked = false;
        });
    }
});
/*START: click thêm vào menu */
$('.add-menu-item').click(function() {
    var module = $(this).attr('data-module');
    var menuid = <?php echo $detail->id ?>;
    var n = $('.' + module + ':checked').length;
    var array = $('.' + module + ':checked');
    var ids = [];
    for (i = 0; i < n; i++) {
        ids[i] = array.eq(i).val();
    }
    if (ids.length == 0) {
        return false;
    }
    $.ajax({
        type: "get",
        data: {
            menuid: menuid,
            ids: ids,
            module: module
        },
        url: "{{route('addMenuItem')}}",
        success: function(data) {
            swal({
                    title: "Thêm mới thành công!",
                    text: "Menu đã được thêm vào <?php echo $detail->title?>.",
                    type: "success"
                },
                function() {
                    location.reload();
                });
        },
        error: function(jqXhr, json, errorThrown) {
            swal({
                title: "Có vấn đề xảy ra",
                text: "Vui lòng thử lại",
                type: "error"
            }, function() {
                location.reload();
            });
        },
    })
})
/*END: click thêm vào
   menu */
/*START: add custome link */
$("#add-custom-link").click(function() {
    var menuid = <?= $detail->id ?>;
    var
        slug = $('#url').val();
    var title = $('#linktext').val();
    $.ajax({
        type: "get",
        data: {
            menuid: menuid,
            slug: slug,
            title: title
        },
        url: "{{route('addCustomLink')}}",
        success: function(res) {
            $("#faq-accordion-collapse-5.alert ").hide();
            swal({
                    title: "Thêm mới thành công!",
                    text: "Menu đã được thêm vào <?php echo $detail->title?> ",
                    type: "success"
                },
                function() {
                    location.reload();
                });
        },
        error: function(jqXhr, json, errorThrown) {
            var errors = jqXhr.responseJSON;
            var errorsHtml = "";
            $.each(errors["errors"], function(index, value) {
                errorsHtml += value + "/ ";
            });
            $("#faq-accordion-collapse-5 .alert").html(errorsHtml).show();
        },
    })
}) /*END: add custome link */
/*START: xóa nhiều menu item */
$(document).on('click', '#checkbox-all-menu', function() {
    let _this = $(this);
    check_all_menu(_this);
});

function check_all_menu(_this) {
    let table = $('#menu-content');
    if ($('#checkbox-all-menu').length) {
        if (table.find('#checkbox-all-menu').prop('checked')) {
            table.find('.checkbox-item').prop('checked', true);
        } else {
            table.find('.checkbox-item').prop('checked', false);
        }
    }
}
$(document).on('click', '.checkbox-item', function() {
    let _this = $(this);
    check_item_all(_this);
});

function check_item_all(_this) {
    let table = $('#menu-content');
    if (table.find('.checkbox-item').length) {
        if (table.find('.checkbox-item:checked').length == table.find('.checkbox-item').length) {
            table.find('#checkbox-all-menu').prop('checked', true);
        } else {
            table.find('#checkbox-all-menu').prop('checked',
                false);
        }
    }
}
/*END: xóa nhiều menu item */
/*AJAX xóa nhiều menu item */
$(document).on('click', '.ajax-delete-all-menu', function() {
    let _this = $(this);
    let id_checked = [];
    /*Lấy id bản
       ghi */
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
        'title': _this.attr('data-title'),
        'module': _this.attr('data-module'),
        'router': _this.attr('data-router'),
        'child': _this.attr('data-child'),
        'list': id_checked,
    }
    let parent = _this.attr('data-parent');
    /*Đây là khối mà sẽ ẩn sau
       khi xóa */
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
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'POST',
                url: BASE_URL_AJAX + "ajax/ajax-delete-all",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token" ]').attr('content')
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
</script>
<link rel="stylesheet" href="{{url('library/sortable/jquery.nestable.css')}}">
<script src="{{url('library/sortable/jquery.nestable.js')}}"></script>
<script>
$(document).ready(function() {
    var updateOutput = function() {
        $('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
    };
    $('#nestable').nestable().on('change', updateOutput);
});
</script>
<style>
.caret {
    display: inline-block;
    width: 0;
    height: 0;
    margin-left: 2px;
    vertical-align: middle;
    border-top: 4px solid;
    border-right: 4px solid transparent;
    border-left: 4px solid transparent;
    transform: translate(-50%, -50%);
    position: absolute;
    right: 15px;
    top: 50%;
}

.accordion-button.active .caret {
    transform: translate(-50%, -50%) rotate(180deg);
}

.disabled {
    cursor: not-allowed;
}
</style>

@endpush
