<?php

if ($errors->any()) {
    $catalogue  = old('attribute_catalogue');
    $attribute = old('attribute');
} else if($action == 'update'){
    $version_json = json_decode(base64_decode($detail->version_json), true);
    if(!empty($version_json)){
        $catalogue  = $version_json[0];
        $attribute = $version_json[1];
    }
}
?>
<div class=" box p-5 mt-3 space-y-3">
    <div>
        <label class="form-label text-base font-semibold">Bộ lọc tour</label>
    </div>
    <div class="ibox mb-5 block-version <?php if (!in_array('attribute', $dropdown)) { ?>hidden<?php } ?>"
        data-countattribute_catalogue="<?php echo count($htmlAttribute) - 1 ?>">
        <div class="ibox-title">
            <div class="grid grid-cols-3 justify-between text-base  items-center">
                <div class="col-span-2">
                    <h5>Chọn bộ lọc thuộc tính cho tour</h5>
                </div>
                <div class="text-right">
                    <a class="show-version btn btn-danger" href=""
                        <?php echo (!empty($catalogue)) ? 'style="display:none"' : '' ?>>Thêm mới</a>
                    <a class="hide-version  btn btn-danger" href=""
                        <?php echo (!empty($catalogue)) ? '' : 'style="display:none"' ?>>
                        Đóng
                    </a>
                </div>
            </div>
        </div>
        <div class="ibox-content mt-5"
            style="background: #f5f6f7; <?php echo (!empty($catalogue)) ? '' : 'display:none"' ?>">
            <div class="block-attribute">
                <div class="mb-3 overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <td style="width: 30%;">Tên thuộc tính</td>
                                <td style="width: 50%;">Giá trị thuộc tính (Các giá trị cách nhau bởi dấu phẩy)</td>
                                <td style="width: 10%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($catalogue)) { ?>
                            <?php foreach ($catalogue as $key => $value) {
                                if (isset($attribute_json[$key])) { ?>
                            <tr data-id="<?php echo $value ?>"
                                <?php echo (isset($checkbox[$key]) && $checkbox[$key] == 1) ? 'class="bg-choose"' : '' ?>>
                                <td>
                                    <select class="form-control select3" name="attribute_catalogue[]" tabindex="-1"
                                        aria-hidden="true">
                                        @foreach($htmlAttribute as $k=>$v)
                                        <option value="{{$k}}" {{ $value == $k ? 'selected' : ''  }}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <?php if ($value == 0) { ?>
                                    <input type="text" class="form-control" disabled="disabled">
                                    <?php } else { ?>
                                    <select name="attribute[<?php echo $key ?>][]" data-stt="{{$key}}"
                                        data-json="<?php echo (isset($attribute_json[$key])) ? base64_encode(json_encode($attribute_json[$key])) : '' ?>"
                                        data-condition="<?php echo $value ?>" class="form-control selectMultipe"
                                        multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.."
                                        data-module="attributes" style="width: 100%;">
                                    </select>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a type="button" class="text-danger delete-attribute" data-id="">Xóa</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between" style="padding: 0px 20px 10px 20px;">
                    <a href="javascript:void(0)"
                        data-attribute="<?php echo base64_encode(json_encode($htmlAttribute)) ?>"
                        class="btn btn-danger add-attribute" data-id=""><i class="fa fa-plus"></i> Thêm thuộc
                        tính cho sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('javascript')
<script src="{{asset('library/toastr/toastr.min.js')}}"></script>
<link href="{{asset('library/toastr/toastr.min.css')}}" rel="stylesheet">
<script>
$('.select2').select2();
$('.select3').select2();

function selectMultipe(object, select = "title") {
    let condition = object.attr('data-condition');
    let title = object.attr('data-title');
    let module = object.attr('data-module');
    let key = object.attr('data-key');
    object.select2({
        minimumInputLength: 0,
        placeholder: title,
        ajax: {
            url: BASE_URL_AJAX + 'select2',
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            deley: 250,
            data: function(params) {
                return {
                    locationVal: params.term,
                    module: module,
                    key: key,
                    select: select,
                    condition: condition,
                };
            },
            processResults: function(data) {
                // console.log(data);
                return {
                    results: $.map(data, function(obj, i) {
                        return obj
                    })
                }

            },
            cache: true,
        }
    });
}
$('.selectMultipe').each(function(key1, index) {
    let _this = $(this);
    let select = _this.attr('data-select');
    select = (typeof select == 'undefined') ? 'title' : select;
    let key = _this.attr('data-key');
    key = (typeof key == 'undefined') ? 'id' : key;
    let module = _this.attr('data-module');
    let json = _this.attr('data-json');
    value = (typeof json != "undefined") ? window.atob(json) : '';
    console.log(value);
    let parse = JSON.parse(value);
    if (parse != 'undefined' && parse.length) {
        for (let i = 0; i < parse.length; i++) {
            var option = new Option(parse[i].text, parse[i].id, true, true);
            _this.append(option).trigger('change');
        }
    }
    selectMultipe($(this), select);
});
</script>
<script type="text/javascript">
/*======================xử lí khối thêm phiên bản======================*/
$(document).on('click', '.block-version .show-version', function(e) {
    e.preventDefault();
    let _this = $(this);
    _this.parent('div').find('.hide-version').show();
    _this.hide();
    _this.parents('.block-version').find('.ibox-content').show();
});
$(document).on('click', '.block-version .hide-version', function(e) {
    e.preventDefault();
    let _this = $(this);
    _this.parents('.block-version').find('.show-version').show();
    _this.parents('.block-version').find('.hide-version').hide();
    _this.parents('.block-version').find('.ibox-content').hide();
});
var attribute_catalogue = [];
$(document).on('click', '.add-attribute', function() {
    let _this = $(this);
    let attr = _this.attr('data-attribute');
    $('.block-attribute').find('table tbody').append(render_attribute(attr, attribute_catalogue));
    check_attribute();
    $('.select3').each(function(key, index) {
        $(this).select2();
    });
    $countAttr = $('.block-attribute table tbody').find('tr').length;
    $countattribute_catalogue = $('.block-version').attr('data-countattribute_catalogue');
    if (parseFloat($countAttr) >= parseFloat($countattribute_catalogue)) {
        $('.add-attribute').hide()
    } else {
        $('.add-attribute').show()
    }
});
/*click thêm thuộc tính */
$(document).on('select2:select', '.selectMultipe', function(e) {
    // console.log(e.params.data.text);
    var id = e.params.data.id;
    var title = e.params.data.text;
    // $(this).find('select[name="attribute[' + index + '][]"] option:selected').length
    $('.block-attribute .selectMultipe').removeClass('active');
    $(this).addClass('active');
    //lấy ID,Title của mảng tiếp theo
    let attributeID = new Array();
    let attributeTitle = new Array();
    $('.block-attribute .selectMultipe:not(.active) option:selected').each(function() {
        attributeID.push($(this).val());
        attributeTitle.push($(this).text());
    });
    var stt = $('.block-attribute .selectMultipe:not(.active)').attr('data-stt');

    // let code_product = $('input[name="code"]').val();
    $.each(attributeID, function(index, value) {
        let id_attr = '';
        let title_attr = '';
        if (stt == 1) {
            id_attr = value + ':' + id;
            title_attr = title + '/' + attributeTitle[index];
        } else {
            id_attr = id + ':' + value;
            title_attr = attributeTitle[index] + '/' + title;
        }
        // var code_length = parseInt($('#table_version .dd3-content').length) + 1;
        $('#table_version').append(render_version(title_attr, '', id_attr));
    });
    // console.log(attributeID);
    // console.log(attributeTitle);
});
/*click bỏ thuộc tính */
$(document).on('select2:unselect', '.selectMultipe', function(e) {
    console.log(e.params.data.text);
    var classRemove = slug(e.params.data.text);
    console.log(classRemove);
    $('.' + classRemove).parent().parent().parent().remove();
    // $('input[value="' + e.params.data.text + '"]').parent().parent().remove();
});
/*xóa phiên bản sản phẩm */
$(document).on('click', '.version_remove', function() {
    $(this).parent().parent().remove();
})
$(document).on('click', '.block-attribute .delete-attribute', function() {
    let _this = $(this);
    _this.parents('tr').remove();
    let val = _this.parents('tr').find('select[name="attribute_catalogue[]"] option:checked').val();
    $('.block-attribute select[name="attribute_catalogue[]"]').find("option[value=" + val + "]").prop(
        'disabled', false);
    $('.block-attribute select[name="attribute_catalogue[]"]').select2("destroy").select2();
    check_attribute();
    let pos = attribute_catalogue.indexOf(val);
    attribute_catalogue.splice(pos, 1);
    $countAttr = $('.block-attribute table tbody').find('tr').length;
    $countattribute_catalogue = $('.block-version').attr('data-countattribute_catalogue');
    if (parseFloat($countAttr) >= parseFloat($countattribute_catalogue)) {
        $('.add-attribute').hide()
    } else {
        $('.add-attribute').show()
    }

});
$(document).on('select2:select', '.block-attribute tbody tr select ', function() {
    let _this = $(this);
    let catalogue_id = _this.parents('tr').find('select[name="attribute_catalogue[]"]').val();
    if (catalogue_id == 2) {
        let text = _this.text();
        attribute = [];
        attributeid = [];
        let index = _this.parents('tr').find('td:first').attr('data-index');

        _this.parents('tr').find('select[name="attribute[' + index + '][]"] option:selected').each(function() {
            attribute.push($(this).text());
            attributeid.push($(this).val());
        });
        // $('.block-color').show();
        // $('.block-color .row').html('').html(html_block_color(attributeid, attribute));
    }
});
$(document).on('change', 'select[name="attribute_catalogue[]"]', function() {
    let _this = $(this);
    check_attribute(_this);
    let catalogue_id = _this.val();

    if (catalogue_id != 0) {
        let index = _this.parents('tr').find('td:first').attr('data-index');
        _this.parents('tr').find('td:eq(2)').html(render_select2(catalogue_id, index));
    } else {
        _this.parents('tr').find('td:eq(2)').html(
            '<input type="text" class="form-control" disabled="disabled">');
    }
    $('.selectMultipe').each(function(key, index) {
        selectMultipe($(this));
    });
});
//click "Sản phảm biến thể"
$(document).on('click', 'input[name="checkbox[]"]', function() {
    let val = $(this).parents('td').find('input[name="checkbox_val[]"]').val();
    if (val == 1) {
        $(this).parents('td').find('input[name="checkbox_val[]"]').val(0);
    } else {
        $(this).parents('td').find('input[name="checkbox_val[]"]').val(1);
    }
});
$(document).on('change', '.block-attribute input[name="checkbox[]"]', function() {
    let check = $('input[name="checkbox[]"]:checked').length;
    if (check > 2) {
        toastr.warning('Chọn nhiều nhất 2 thuộc tính để tạo phiên bản', '');
        $(this).prop('checked', false);
        $(this).parent().parent().removeClass('bg-active');
        $(this).parents('td').html(
            '<input type="checkbox" name="checkbox[]" value="" class="checkbox-item"><div for="" class="label-checkboxitem"></div>'
        );
    }
});


function render_select2(condition = '', index = '') {
    html = '<select name="attribute[' + index + '][]" data-condition="' + condition +
        '" data-json="" data-stt="' + index +
        '" class="form-control selectMultipe" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="attributes"  style="width: 100%;">';
    html = html + '</select>';
    return html;
}

function check_attribute(_this = '') {
    attribute_catalogue = new Array();
    $('.block-attribute select[name="attribute_catalogue[]"]').each(function() {
        let val = $(this).find('option:selected').val();
        if (val != 0) {
            attribute_catalogue.push(val);
        }
    });
    // xóa hết disable đi
    $('.block-attribute select[name="attribute_catalogue[]"]').find("option").removeAttr("disabled");
    for (let i = 0; i < attribute_catalogue.length; i++) {
        // thêm disable ở những cái nào trong mảng
        $('.block-attribute select[name="attribute_catalogue[]"]').find("option[value=" + attribute_catalogue[i] + "]")
            .prop('disabled', !$('#one').prop('disabled'));
        $('.block-attribute select[name="attribute_catalogue[]"]').select2();
    }
    // // nếu cái option nào được chọn thì xóa disable cua nó đi
    $('.block-attribute select[name="attribute_catalogue[]"]').find("option:selected").removeAttr("disabled");

}

function render_attribute(attr, attribute_catalogue) {
    let index = $('.block-attribute tbody tr').length;
    attr = JSON.parse(window.atob(attr));
    let key = Object.keys(attr);
    let value = Object.values(attr);
    let html = '<tr>';
    html = html + '<td class="hidden" data-index="' + index + '" style="width: 10%">';
    html = html + '<input type="checkbox" name="checkbox[]" value="1" class="checkbox-item">';
    html = html + '<input type="text" name="checkbox_val[]" value="0" class="hidden">';
    html = html + '<div for="" class="label-checkboxitem"></div>';
    html = html + '</td>';
    html = html + '<td style="width: 30%">';
    html = html + '<select name="attribute_catalogue[]" class="form-control select3"> style="width:100%" >';
    let pos = '';
    for (let i = 0; i < key.length; i++) {
        pos = attribute_catalogue.indexOf(key[i]);
        if (pos == -1) {
            html = html + '<option value="' + key[i] + '">' + value[i] + '</option>';
        } else {
            html = html + '<option disabled="disabled" value="' + key[i] + '">' + value[i] + '</option>';
        }
    }
    html = html + '</select>';
    html = html + '</td>';
    html = html + '<td style="width: 50%">';
    html = html + '<input type="text" class="form-control" disabled="disabled">';
    html = html + '</td>';
    html = html + '<td style="width: 10%">';
    html = html +
        '<a href="javascript:void(0)" class=" delete-attribute flex items-center text-danger" data-id="" >Xóa</a>';
    html = html + '</td>';
    html = html + '</tr>';
    $('.select3').each(function(key, index) {
        $(this).select2();
    });
    return html;
}
</script>
<style>
.dd3-content {
    display: block;
    color: #333;
    text-decoration: none;
    font-weight: bold;
    line-height: 32px;
    border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 0;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    position: relative;
}

.dd3-content .relative {
    padding-left: 10px;
    height: 45px;
    line-height: 45px;
}

.version_remove {
    position: absolute;
    right: 15px;
    top: 50%;
    text-align: center;
    text-indent: 0px;
    transform: translateY(-50%);
}

.version_item_size {
    padding: 20px;
    background: #fff;
}
</style>


<style>
#table_version td {
    padding: 5px
}
</style>


@endpush
