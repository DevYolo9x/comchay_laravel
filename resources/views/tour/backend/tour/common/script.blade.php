@push('javascript')
<div id="medium-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-10">
                <form class="mt-3" role="form" id="formSubmit" action="" method="post" enctype="multipart/form-data">
                    <div class="alert alert-danger p-2 mb-3" style="display: none;"></div>
                    <div class="">
                        <label class="form-label text-base font-semibold">Tiêu đề</label>
                        <input type="text" id="titleItem" class="form-control" placeholder="" require>
                        <input type="hidden" id="idItem" class="form-control" placeholder="">
                    </div>
                    <div class="mt-3 flex">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-primary w-24 btnCloseAddItemService">Đóng</button>
                        <button type="submit" class="pull-right btn btn-primary ml-2">Thêm mới</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div> <!-- END: Medium Modal Content -->
<script>
/*START: thêm mới item services*/
$(document).on('click', '.modalAddService', function(e) {
    $('#idItem').val($(this).attr('data-id'));
    $('#medium-modal').show();
})
$(document).on('click', '.btnCloseAddItemService', function(e) {
    $('#titleItem').val('');
    $('#idItem').val('');
})
$("#formSubmit").submit(function(e) {
    e.preventDefault();
    var id = $('#idItem').val();
    var title = $('#titleItem').val();
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        url: '<?php echo route('tour_service_items.store')?>',
        type: "POST",
        dataType: "JSON",
        data: {
            id: id,
            title: title,
        },
        success: function(data) {
            $(".alert-danger").html('').hide();

            let html = '';
            html = html + '<div>';
            html = html + '<label class="form-label text-base">';
            html = html + '<input type="checkbox" name="serviceTour[]" value="' + data.id + '"> ' +
                title + '</label></div>';
            console.log(html);
            $('#box-services-' + id).prepend(html);
            $('#titleItem').val('');
            $('#medium-modal').hide();
            swal({
                title: "Thêm mới thành công!",
                text: "",
                type: "success"
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
/*END: thêm mới item services*/

/*START: thêm lịch trình */
$(document).on('click', '.add-schedule', function() {
    let _this = $(this);
    render_schedule();
})

function render_schedule() {
    let html = '';
    var microtime = (Date.now() % 1000) / 1000;
    var editorId = 'editor_' + microtime;
    html = html + '<div class="mt-5 desc-more">'
    html = html + '<div class="relative">'
    html = html + '<div class="w-full">'
    html = html +
        '<input type="text" name="schedule[title][]" class="form-control" placeholder="Tiêu đề" style="padding-right: 38px;">'
    html = html + '</div>'
    html = html +
        '<button class=" text-danger delete-attr absolute right-0 top-1/2" type="button" style="top: 50%;transform: translateY(-50%);width: 50px;height: 38px;display: flex;justify-content: center;align-items: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>'
    html = html + '</div>'
    html = html + '<div class="col-lg-12 mt-3" >'
    html = html + '<textarea name="schedule[description][]" class="form-control ck-editor" id="' + editorId +
        '" placeholder="Mô tả"></textarea>'
    html = html + '</div>'
    html = html + '</div>';
    $('#schedule').append(html);
    CKEDITOR.replace(editorId, {
        height: 277
    });
}
$(document).on('click', '.delete-attr', function() {
    let _this = $(this);
    _this.parents('.desc-more').remove();
});

/*END: thêm lịch trình */
/*START: tạo mảng serviceTour */
$(document).on('click', 'input[name="serviceTour[]"]', function(e) {
    var id = $(this).val();
    loadChecked();
})


function loadChecked() {
    let attribute = new Array();
    $('.itemService').each(function(key, value) {
        let id = $(this).attr('data-id');
        attribute[id] = new Array();
        if ($(this).find('input[name="serviceTour[]"]').length) {
            if ($(this).find('input[name="serviceTour[]"]:checked').length) {
                $(this).find('input[name="serviceTour[]"]:checked').each(function() {
                    attribute[id].push($(this).val());
                });
            }
        }
    });
    let json = JSON.stringify({
        ...attribute
    });
    $('input[name="groupService"]').val(json);
}
loadChecked();
/*END */
</script>
<style>
#example-tab-2 .wrapper::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
}

#example-tab-2 .wrapper::-webkit-scrollbar {
    width: 6px;
    background-color: #F5F5F5;
}

#example-tab-2 .wrapper::-webkit-scrollbar-thumb {
    background-color: #000000;
}
</style>


@endpush
