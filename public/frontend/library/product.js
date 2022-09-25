

function loadSize() {
    $('.sizes').each(function(index, elem) {
        if ($(elem).is(':not(.disabled)')) {
            $('.sizes:eq("' + index + '")').addClass('checked');
            var title_version = $(this).attr('data-title-version');
            var code = $(this).attr('data-code');
            var price_old = $(this).attr('data-price-old');
            var price_final = $(this).attr('data-price-final');
            var percent = $(this).attr('data-percent');
            var data_price_cart = $(this).attr('data-price-cart');
            var stock = parseInt($(this).attr('data-stock'));
            var image = $(this).attr('data-image');
            $('.swiper-slide:first-child img').attr('src', BASE_URL_AJAX + image);
            $('.addtocart ').attr('data-title-version', title_version).attr('data-price', data_price_cart).attr('data-code', code);
            $('.product_code').text(code);
            $('.product_price_old').html(price_old);
            $('.product_price_final').html(price_final);
            if(percent){
                $('.product_percent').html('-'+percent);
            }else{
                $('.product_percent').html('');
            }
            //lấy số lượng hiện có trong quantity
            var quantity = parseInt($('.card-quantity').val());
            if(quantity > stock){
                 $('.card-quantity').val(stock);
            }else{
                $('.card-quantity').val(quantity);
            }
            if(isNaN(stock)){
                $('.product_stock').text("");
                $('.card-quantity').attr('max',"");
            }else{
                $('.product_stock').text(stock);
                $('.card-quantity').attr('max',stock);
            }
            return false;
        }
    });
}
loadSize();
//click size
$(document).on('click', '.sizes', function() {
    $('.sizes').removeClass('checked');
    $(this).addClass('checked');
    var title_version = $(this).attr('data-title-version');
    var code = $(this).attr('data-code');
    var price_old = $(this).attr('data-price-old');
    var price_final = $(this).attr('data-price-final');
    var percent = $(this).attr('data-percent');
    var data_price_cart = $(this).attr('data-price-cart');
    var stock = parseInt($(this).attr('data-stock'));
    var image = $(this).attr('data-image');
    $('.swiper-slide:first-child img').attr('src', BASE_URL_AJAX + image);
    $('.addtocart ').attr('data-title-version', title_version).attr('data-price', data_price_cart).attr('data-code', code);
    $('.product_code').text(code);
    $('.product_price_old').html(price_old);
    $('.product_price_final').html(price_final);
    if(percent){
        $('.product_percent').html('-'+percent);
    }else{
        $('.product_percent').html('');
    }
    //check stock
    //lấy số lượng hiện có trong quantity
    var quantity = parseInt($('.card-quantity').val());
    if(quantity > stock){
         $('.card-quantity').val(stock);
    }else{
        $('.card-quantity').val(quantity);
    }
    if(isNaN(stock)){
        $('.product_stock').text("");
        $('.card-quantity').attr('max',"");
    }else{
        $('.product_stock').text(stock);
        $('.card-quantity').attr('max',stock);
    }
    return false;
});
//chọn color
function loadColors() {
    $('.colors').each(function(index, elem) {
        if ($(elem).is(':not(.disabled)')) {
            var id = $(this).attr('data-id');
            var image = $(this).attr('data-image');
            $('.colors').removeClass('checked');
            $(this).addClass('checked');
            $('.swiper-slide:first-child img').attr('src', BASE_URL_AJAX + image);
            let ajaxUrl = BASE_URL_AJAX + 'ajax/product/product-sizes';
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    image: image,
                },
                success: function(data) {
                    $('.section-color-picker').removeClass('hidden')
                    let json = JSON.parse(data);
                    $('.addtocart').attr('data-src', image);
                    $('#loadSize').html(json.html);
                    loadSize();
                }
            });
            return false;
        }
    });
}
loadColors();
$(document).on('click', '.colors:not(.disabled)', function() {
    var id = $(this).attr('data-id');
    var image = $(this).attr('data-image');
    $('.colors').removeClass('checked');
    $(this).addClass('checked');
    $('.swiper-slide:first-child img').attr('src', BASE_URL_AJAX + image);
    let ajaxUrl = BASE_URL_AJAX + 'ajax/product/product-sizes';
    $.ajax({
        type: 'POST',
        url: ajaxUrl,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            image: image,
        },
        success: function(data) {
            $('.section-color-picker').removeClass('hidden')
            let json = JSON.parse(data);
            $('.addtocart').attr('data-src', image);
            $('#loadSize').html(json.html);
            loadSize();
        }
    });
})

//kiểm tra tồn kho


