@push('javascript')
<script>
/*START: upload hình ảnh vào nhóm slide */
function slide_render(src = '') {
    let html = '<div class="col-span-4">';
    html = html + '<div class="ibox">';
    html = html + '<div class="ibox-content product-box">';
    html = html + '<div class="product-imitation">';
    html = html + '<span class="image img-scaledown"><img src="' + src + '" alt="" /></span>';
    html = html + '<input type="text" name="slide[image][]" value="' + src +
        '" class="image-src" style="display:none;" />';
    html = html + '</div>';
    html = html + '<div class="product-desc">';
    html = html +
        '<input type="text" name="slide[title][]" value="" class="form-control image-title mb-1" placeholder="Chú thích ảnh" autocomplete="off">';
    html = html +
        '<input type="text" name="slide[link][]" value="" class="form-control image-link mb-1" placeholder="Đường dẫn" autocomplete="off">';
    html = html +
        '<textarea name="description" class="form-control image_description mb-1" placeholder="Ghi chú"></textarea>';
    html = html + '<div class="flex justify-between items-center">';
    html = html + '<span class="small-text" style="width:100px;">Vị trí</span>';
    html = html +
        '<input type="text" name="slide[order][]" value="0" class="form-control image-order mb-1" placeholder="" autocomplete="off">';
    html = html + '</div>';
    html = html + '<div class="m-t text-righ">';
    html = html +
        '<a href="#" class="btn btn-xs btn-outline btn-danger delete-slide w-full">Xóa </a>';
    html = html + '</div>';
    html = html + '</div>';
    html = html + '</div>'
    html = html + '</div>';
    html = html + '</div>';
    return html;
}

$(document).on('click', '.delete-slide', function() {
    $(this).parent().parent().parent().parent().remove();
});
$(document).on('click', '.add-slide', function() {
    let img_title = [];
    let img_src = [];
    let img_link = [];
    let img_description = [];
    let img_order = [];
    let slideModal = $('#basic-modal-upload-image');
    $('.image-title').each(function() {
        img_title.push($(this).val());
    });
    $('.image-src').each(function() {
        img_src.push($(this).val());
    });
    $('.image-link').each(function() {
        img_link.push($(this).val());
    });
    $('.image_description').each(function() {
        img_description.push($(this).val());
    });
    $('.image-order').each(function() {
        img_order.push($(this).val());
    });
    let object = {
        'title': img_title,
        'src': img_src,
        'link': img_link,
        'description': img_description,
        'order': img_order
    };

    let catalogueid = $('.catalogueid').val();
    //console.log(object);
    if (catalogueid == 0) {
        slideModal.find('.alert').show();
        slideModal.find('.title_error').html('Bắt buộc phải lựa chọn Tên nhóm Slide.');
    } else {
        slideModal.find('.alert').hide();
        let formURL = "{{route('slides.store')}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: formURL,
            type: 'POST',
            dataType: 'JSON',
            data: {
                object: object,
                catalogueid: catalogueid
            },
            success: function(response) {
                slideModal.hide();
                slideModal.find('.alert').hide();
                swal({
                        title: "Thêm mới slide thành công", // this will output "Error 422: Unprocessable Entity"
                        html: 'Thêm mới thành công',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Đóng",
                        cancelButtonText: "Hủy bỏ!",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showCancelButton: false,
                        type: 'success'
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    });
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    errorsHtml += value + '/ ';
                });
                $('#basic-modal-upload-image .title_error').html(errorsHtml);
                $('#basic-modal-upload-image .alert').show();

            }
        });


    }
    return false;
});
/*END*/
/*START: thêm mới nhóm slide */
$(document).ready(function() {
    $('.alert').hide();
    $('.bg-loader').hide();
    $('.upload-list').hide();
    let addGroupSlide = $('#basic-modal-add-group');
    $(document).on('click', '.add-group', function() {
        let slideTitle = $('#title').val();
        let slideKeyword = $('#keyword').val();
        let formURL = "{{route('slides.category_store')}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: formURL,
            type: 'POST',
            dataType: 'JSON',
            data: {
                title: slideTitle,
                keyword: slideKeyword
            },
            success: function(response) {
                addGroupSlide.hide();
                $('#basic-modal-add-group .alert').hide();
                $("#folder-list").prepend(response.html);
                swal({
                        title: "Thêm mới thành công", // this will output "Error 422: Unprocessable Entity"
                        html: 'Thêm mới thành công',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Đóng",
                        cancelButtonText: "Hủy bỏ!",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showCancelButton: false,
                        type: 'success'
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    });
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    errorsHtml += value + '/ ';
                });
                $('#basic-modal-add-group .title_error').html(errorsHtml);
                $('#basic-modal-add-group .alert').show();

            }
        });
    });


});
/*END*/
/*START: update nhóm slide */
$(document).on('click', '.slide-group-edit', function(event) {
    var title = $(this).attr('data-title');
    var id = $(this).attr('data-id');
    $('#basic-modal-edit-group .title').val(title);
    $('#basic-modal-edit-group .id').val(id);

});
$(document).ready(function() {
    let editGroupSlide = $('#basic-modal-edit-group');
    $(document).on('click', '.edit-group', function() {
        let slideTitle = $('#basic-modal-edit-group .title').val();
        let slideID = $('#basic-modal-edit-group .id').val();
        let formURL = "{{route('slides.category_update')}}";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: formURL,
            type: 'POST',
            dataType: 'JSON',
            data: {
                title: slideTitle,
                id: slideID,
            },
            success: function(response) {
                editGroupSlide.hide();
                $('#basic-modal-edit-group .alert').hide();
                swal({
                        title: "Cập nhập thành công", // this will output "Error 422: Unprocessable Entity"
                        html: 'Cập nhập thành công',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Đóng",
                        cancelButtonText: "Hủy bỏ!",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        showCancelButton: false,
                        type: 'success'
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        }
                    });
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    errorsHtml += value + '/ ';
                });
                $('#basic-modal-edit-group .title_error').html(errorsHtml);
                $('#basic-modal-edit-group .alert').show();

            }
        });
    });


});
/*END*/

$(document).on('click', '.edit-slide', function() {
    let _this = $(this);
    let data = _this.attr('data-json');
    let id = _this.attr('data-id')
    data = window.atob(data);
    let json = JSON.parse(data);
    let html = slide_update(json, id);
    $('.update-group').html(html);
    return false;
});

function slide_update(object, id) {
    let html = '';
    html = html + '<div class="grid grid-cols-12 gap-6 mt-5">';
    html = html + '<div class="col-span-6">';
    html = html + '<div class="form-row">';
    html = html + '<small class="text-danger mb5">Click vào ảnh để thay đổi.</small>';
    html = html + '<div class="avatar slide-image image-scaledown" style="cursor: pointer;"><img src="' + object.src +
        '" class="img-thumbnail" alt=""></div>';
    html = html + '<input type="hidden" name="src" value="' + object.src + '">';
    html = html + '<input type="hidden" name="id" value="' + id + '">';
    html = html + '</div>';
    html = html + '</div>';
    html = html + '<div class="col-span-6">';
    html = html + '<div class="form-row space-y-3">';
    html = html + '<div class="">';
    html = html + '<label>Chú thích</label> ';
    html = html + '<input type="text" placeholder="" name="title" class="form-control" value="' + object.title + '">';
    html = html + '</div>';
    html = html + '<div class="">';
    html = html + '<label>Đường dẫn</label>';
    html = html + '<input type="text" placeholder="" name="link" class="form-control" value="' + object.link + '">';
    html = html + '</div>';
    html = html + '<div class="">';
    html = html + '<label>Ghi chú</label>';
    html = html + '<textarea placeholder="" name="description" class="form-control" >' + object
        .description +
        '</textarea>';
    html = html + '</div>';
    html = html + '<div class="">';
    html = html + '<label>Vị trí</label> ';
    html = html + '<input type="text" placeholder="" name="order" class="form-control" value="' + object.order + '">';
    html = html + '</div>';
    html = html + '</div>';
    html = html + '</div>';
    html = html + '</div>';


    return html;
}

$(document).on('click', '.update-slide', function() {
    let _this = $(this);
    let _form = $('.update-group').serializeArray();
    let formURL = "{{route('slides.update')}}";
    swal({
            title: "Bạn muốn cập nhật hạng mục này?",
            text: 'Dữ liệu sẽ thay đổi khi bạn thực hiện thao tác này. Bấm Thực hiện để tiếp tục',
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
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: formURL,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        data: _form
                    },
                    success: function(data) {
                        if (data.code === 200) {
                            $('#slide-' + _form[1].value).find('.img-responsive').attr('src',
                                data.src);
                            $('#slide-' + _form[1].value).find('.name').html(
                                '<span style="font-weight:bold;">Chú thích</span>: ' + data
                                .title);
                            $('#slide-' + _form[1].value).find('.link').html(
                                '<span style="font-weight:bold;">Link</span> <i style="color:blue;">' +
                                data.link + '</i>: ');
                            $('#slide-' + _form[1].value).find('.description').html(
                                '<span style="font-weight:bold;">Ghi chú</span> ' +
                                data.description + '');

                            $('#basic-modal-edit-slide').hide();
                            swal({
                                title: "Cập nhật thành công!",
                                text: "Dữ liệu đã được cập nhật thành công, hãy thực hiện tiếp các thao tác khác.",
                                type: "success"
                            }, function() {
                                location.reload();
                            });

                        } else {
                            $('#basic-modal-edit-slide').hide();
                            swal({
                                title: "ERROR",
                                text: "Có lỗi xảy ra.",
                                type: "error"
                            }, function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(jqXhr, json,
                        errorThrown) { // this are default for ajax errors
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';

                        $.each(errors['errors'], function(index, value) {
                            errorsHtml += value + '/ ';
                        });
                        $('#basic-modal-edit-slide .title_error').html(errorsHtml);
                        $('#basic-modal-edit-slide .alert').show();
                    }
                });
            } else {
                swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
            }
        });
    return false;

});
</script>
@endpush
