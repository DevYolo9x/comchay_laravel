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
                url: BASE_URL_AJAX + 'ajax/select2',
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
        /*
        if (value != '') {
            $.ajax({
                type: 'POST',
                url: BASE_URL_AJAX + 'ajax/select2',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    value: value,
                    module: module,
                    select: select,
                    key: key
                },
                success: function(data) {
                    let json = JSON.parse(data);
                    console.log('d');

                    if (json.items != 'undefined' && json.items.length) {
                        for (let i = 0; i < json.items.length; i++) {
                            var option = new Option(json.items[i].text, json.items[i].id, true, true);
                            console.log(option);
                            _this.append(option).trigger('change');
                        }
                    }
                }
            });

        } */
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

        //foreach thêm get_vesion
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
        /*get_vesion();*/
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
        get_vesion();
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
        get_vesion()
    });
    //Hết hàng
    $(document).on('click', 'input[name="checkbox_version[]"]', function() {
        let val = $(this).parents('td').find('input[name="status_version[]"]').val();
        console.log(val);
        if (val == 1) {
            $(this).parents('td').find('input[name="status_version[]"]').val(0);
        } else {
            $(this).parents('td').find('input[name="status_version[]"]').val(1);
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
        html = html + '<td class="" data-index="' + index + '" style="width: 10%">';
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

    function get_vesion() {
        let code_main = $('input[name="code"]').val();
        let attribute = new Array();
        let attributeid = new Array();
        $('.block-attribute table tbody tr').each(function(key, value) {
            /*filter danh mục thuộc tính */
            if ($(this).find('select[name="attribute_catalogue[]"]').length) {
                /*chọn checked: danh mục thuộc tính */
                if ($(this).find('input[name="checkbox[]"]:checked').length) {
                    /*lấy STT dựa theo tr đầu tiên */
                    let index = $(this).find('td:first').attr('data-index');
                    /*tạo các key vào mảng*/
                    if ($(this).find('select[name="attribute[' + index + '][]"] option:selected').length) {
                        attribute[key] = new Array();
                        attributeid[key] = new Array();
                    }
                    /*thuộc tính theo danh mục: "data-index = 0"  =>  select[name="attribute[0][]*/
                    $(this).find('select[name="attribute[' + index + '][]"] option:selected').each(function() {
                        attribute[key].push($(this).text());
                        attributeid[key].push($(this).val());
                    });
                }
            }
        });
        let attribute1 = [];
        let attributeid1 = [];
        attribute.forEach(function(item, index, array) {
            if (typeof item != "undefined") {
                attribute1.push(item);
                attributeid1.push(attributeid[index]);
            }
        });
        // console.log('đây là mảng danh mục thuộc tính', attribute);
        // console.log(attributeid1);
        $('#table_version ').html('');
        $('.block-attribute').siblings('table').hide();
        let index = 1;
        for (var i in attribute1[0]) {
            if (typeof attribute1[1] != "undefined") {
                for (var j in attribute1[1]) {
                    let id_attr = attributeid1[0][i] + ':' + attributeid1[1][j];
                    let title = attribute1[0][i] + '/' + attribute1[1][j];
                    code = code_main + '-' + index;
                    index = index + 1;
                    $('#table_version').append(render_version(title, code, id_attr));
                    $('#table_version').show();
                }
            } else {
                let id_attr = attributeid1[0][i];
                let title = attribute1[0][i];
                code = code_main + '-' + index;
                index = index + 1;
                $('#table_version').append(render_version(title, code, id_attr));
                $('#table_version').show();
            }
        }
    }
    /*START: tạo các sản phẩm biến thể từ thuộc tính */
    function render_version(title = '', code = '', id_attr = '') {
        const array_title_convert = title.split('/');
        // console.log(array_title_convert);
        let price_old = $('input[name="price"]').val();
        let price_sale = $('input[name="price_sale"]').val();
        var item = '';
        item = item + '<div class="mb-2 dd3-content ">';
        /**hidden*/
        item = item + '<div class="hidden">';

        item = item + '<input type="text" name="title_version_1[]" value="' + array_title_convert[0] + '">';
        item = item + '<input type="text" name="title_version_2[]" value="' + array_title_convert[1] + '">';
        item = item + '<input type="text" name="id_version[]" value="' + id_attr + '">';
        item = item + '<input type="text" name="title_version[]" readonly value="' + title +
            '" class="form-control"  autocomplete="off" >';

        item = item + '</div>';
        item = item + '<div class="relative">';
        item = item +
            '<a href="javascript:void(0)" class="form-label mb-0 accordion w-full">';
        array_title_convert.forEach(function(v, i) {
            if (i == 0) {
                item = item +
                    '<span class="text-xs whitespace-nowrap text-pending bg-pending/20 pending  pending-primary/20 rounded-full px-2 py-1 ' +
                    slug(v) + '">' +
                    v + '</span >';
            } else {
                item = item +
                    '<span class="text-xs whitespace-nowrap text-success bg-success/20 pending  pending-success/20 rounded-full px-2 py-1 ' +
                    slug(v) + '">' +
                    v + '</span >';
            }
        })
        item = item + '</a>';
        item = item + '<a href="javascript:void(0)" class="text-danger version_remove" data-number="1">Xóa</a>';
        item = item + '</div>';
        item = item + '<div class="version_item_size hidden">';
        item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
        item = item + '<div class="">';
        item = item + '<label class="form-label">Hình ảnh</label>';
        item = item + '<div class="flex items-center space-x-3">';
        item = item + '<div class="avatar" style="cursor: pointer;flex:none">';
        item = item +
            '<img src="<?php echo url('images/404.png') ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">';
        item = item + '</div>';
        item = item +
            '<input type="text" name="image_version[]" style="cursor: not-allowed;opacity: 0.56;" value="" class="form-control" placeholder="Đường dẫn của ảnh" autocomplete="off">';
        item = item + '</div>';
        item = item + '</div>';
        item = item + '<div>';
        item = item + '<label class="form-label">Mã sản phẩm</label>';
        item = item + '<input type="text" name="code_version[]" value="' + code +
            '" class="form-control" placeholder="" >';
        item = item + '</div>';
        item = item + '</div>';
        item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
        item = item + '<div>';
        item = item + '<label class="form-label">Giá</label>';
        item = item + '<input type="text" value="' + price_old +
            '" name="price_version[]" class="form-control int price" placeholder="">';
        item = item + '</div>';
        item = item + '<div class="">';
        item = item + '<label class="form-label">Giá ưu đãi</label>';
        item = item +
            '<input type="text" value="' + price_sale +
            '" name="price_sale_version[]" class="form-control int price" placeholder="">';
        item = item + '</div>';
        item = item + '</div>';
        item = item + '<div class="mt-3">';
        item = item + '<h2 class="font-medium text-base mr-auto">Quản lý tồn kho</h2>';
        item = item + '<div class="mt-3">';
        item = item + '<div class="form-switch">';
        item = item + '<select class="form-select selectStock" name="_stock_status[]">';
        item = item + '<option value="0" selected>Không quản lý</option>';
        item = item + '<option value="1" >Có quản lý tồn kho</option>';
        item = item + '</select>';
        item = item + '</div>';
        item = item + '</div>';

        item = item + '<div class="showStock hidden">';
        item = item + '<div class="mt-3">';
        item = item + '<label class="form-label">Số lượng trong kho</label>';
        item = item +
            '<input type="number" name="_stock[]" min="0" class="form-control" placeholder="">';
        item = item + '</div>';

        item = item + '<div class="mt-3">';
        item = item + '<div class="form-switch">';
        item = item + '<label class="form-label">Đặt hàng khi đã hết hàng</label>';
        item = item + '<select class="form-select" name="_outstock_status[]">';
        item = item + '<option value="0" selected>Không cho đặt hàng khi hết hàng</option>';
        item = item + '<option value="1" >Đồng ý cho đặt hàng khi đã hết hàng</option>';
        item = item + '</select>';
        item = item + '</div>';
        item = item + '</div>';
        item = item + '</div>';

        item = item + '</div>';
        item = item + '</div>';
        item = item + '</div>';
        //lưu vào localstore

        return item;
    }
    /*end */
    /*click show chi tiết kích thước trong màu sắc */
    $(document).on('click', '.accordion', function() {
        $(this).parent().parent().find('.version_item_size').toggleClass('hidden');
    })
    $(document).on('change', '.selectStock', function() {
        $value = $(this).val();
        if ($value == 1) {
            $(this).parent().parent().parent().find('.showStock').removeClass('hidden');
        } else {
            $(this).parent().parent().parent().find('.showStock').addClass('hidden');
        }
    })
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
<?php
/*function combinations($arrays, $i = 0) {
    if (!isset($arrays[$i])) {
        return array();
    }
    if ($i == count($arrays) - 1) {
        return $arrays[$i];
    }

    // get combinations from subsequent arrays
    $tmp = combinations($arrays, $i + 1);

    $result = array();

    // concat each array from tmp with each element from $arrays[$i]
    foreach ($arrays[$i] as $v) {
        foreach ($tmp as $t) {
            $result[] = is_array($t) ?
                array_merge(array($v), $t) :
                array($v, $t);
        }
    }

    return $result;
}
echo "<pre>";
var_dump(combinations(
    array(
        array('A1','A2','A3'),
        array('B1','B2','B3'),
        array('C1','C2'),
        array('D1','D2'),
    )
)); */
?>







@endpush