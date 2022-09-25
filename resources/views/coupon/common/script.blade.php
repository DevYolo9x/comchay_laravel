<!-- <script type="text/javascript" src="{{asset('library/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('library/daterangepicker/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('library/daterangepicker/daterangepicker.css')}}" />
<script type="text/javascript">
$(function() {
    $('input[name="expiry_date"]').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            separator: " to "
        }
    });
});
</script> -->
<script type="text/javascript">
/*START: tạo mã tự động*/
$(document).on('click', '.render_code', function() {
    let _this = $(this);
    $('input[name="name"]').val(readerCode());
});

function readerCode(length = 8) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}
/*END*/
/*check % đơn hàng*/
$(document).on('keyup', 'input[name="value"]', function() {
    let type = $('select[name="typecoupon"] :selected').val();
    console.log(type);
    let value = $(this).val();
    if (type == 'fixed_cart_percent' || type == 'fixed_percent') {
        if (value > 100) {
            $(this).val(100);
        }
        return false;
    }
});
/*END*/
$(document).on('change', 'select[name="typecoupon"]', function() {
    let type = $(this).val();
    let data = $('input[name="value"]').val();
    if (type == 'fixed_cart_percent' || type == 'fixed_percent') {
        if (data > 100) {
            $('input[name="value"]').val(100);
        }
        return false;
    }
});
</script>
