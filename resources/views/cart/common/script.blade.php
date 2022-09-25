<script>
$(function() {




    //change input số lượng


    //add coupon


    //selected payment
    $(document).on('click', '.payment-item input[name="payment"]', function() {
        $('.small').hide();
        $(this).parent().parent().find('.small').show();
    });
    var payment = '<?php echo old('payment') ?>';
    var payment_type_zalopay = '<?php echo old('payment_type_zalopay') ?>';
    var payment_type_momo = '<?php echo old('payment_type_momo') ?>';
    if (payment != '') {
        $('#' + payment).prop('checked', true);
        $('#' + payment + ":checked").parent().parent().find('.small').show();
    }
    if (payment_type_zalopay != '') {
        $('#' + payment_type_zalopay).prop('checked', true);
    }
    if (payment_type_momo != '') {
        $('#' + payment_type_momo).prop('checked', true);
    }

});
</script>
<!--tỉnh thanh quận huyện -->
@include('components.script.getLocation')