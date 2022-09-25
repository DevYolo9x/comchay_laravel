@push('javascript')
<script>
var cityid = '<?php echo !empty(old('cityid'))?old('cityid'):(!empty($detail->cityid)?$detail->cityid:"") ?>';
var districtid =
    '<?php echo !empty(old('districtid'))?old('districtid'):(!empty($detail->districtid)?$detail->districtid:"") ?>';
var wardid = '<?php echo old('wardid') ?>';

$(document).on('change', '#city', function(e, data) {
    let _this = $(this);
    let param = {
        'parentid': _this.val(),
        'select': 'districtid',
        'table': 'vn_district',
        'trigger_district': (typeof(data) != 'undefined') ? true : false,
        'text': 'Chọn Quận/Huyện',
        'parentField': 'provinceid',
    }
    getLocation(param, '#district');
});
if (typeof(cityid) != 'undefined' && cityid != '') {
    $('#city').val(cityid).trigger('change', [{
        'trigger': true
    }]);
}

function getLocation(param, object) {
    if (districtid == '' || param.trigger_district == false) districtid = 0;
    if (wardid == '' || param.trigger_ward == false) wardid = 0;
    let formURL = '<?php echo route('addresses.getLocation') ?>';
    $.post(formURL, {
            param: param,
            "_token": $('meta[name="csrf-token"]').attr("content")
        },
        function(data) {
            let json = JSON.parse(data);
            if (param.select == 'districtid') {
                if (param.trigger_district == true) {
                    $(object).html(json.html).val(districtid).trigger('change', [{
                        'trigger': true
                    }]);
                } else {
                    $(object).html(json.html).val(districtid).trigger('change');
                }
            } else if (param.select == 'wardid') {
                $(object).html(json.html).val(wardid);
            }
        });
}
</script>
@endpush
