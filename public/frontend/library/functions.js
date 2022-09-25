$(function() {
    $('.tp-cart').click(function() {
        $('.offcanvas-overlay').toggleClass('hidden');
        $('#offcanvas-cart').toggleClass('hidden');
    });

    $(".offcanvas-close, .offcanvas-overlay").on("click", function(e) {
        e.preventDefault();
        $('.offcanvas-overlay').addClass('hidden');
        $('#offcanvas-cart').addClass('hidden ');
    });
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    /*show hide loading customers */
    $(function () {
        $('#submit-auth-loading').hide();
        $("#form-auth").submit(function (event) {
            $('#submit-auth').hide();
            $('#submit-auth-loading').show();
        });
    })

    /*START: tăng giảm số lượng */
    $(document).on('click', '.card-inc', function() {
        var quantity = parseInt($(this).parent().find('.card-quantity').val());
        var max_quantity = parseInt($(this).parent().find('.card-quantity').attr('max'));
        if (quantity >= max_quantity) {
            quantity = max_quantity;
        } else {
            quantity += 1;
        }
        $(this).parent().find('.card-quantity').val(quantity);
        $(this).parent().parent().parent().find('.addtocart').attr('data-quantity', quantity);
    });
    $(document).on('click', '.card-dec', function() {
        var quantity = parseInt($(this).parent().find('.card-quantity').val());
        if (quantity <= 1) {
            quantity = 1;
        } else {
            quantity -= 1;
        }
        $(this).parent().find('.card-quantity').val(quantity);
        $(this).parent().parent().parent().find('.addtocart').attr('data-quantity', quantity);
    });
    /* change input số lượng => view giỏ hàng*/
    $(document).on('keyup', '.product-details .card-quantity', function() {
        var quantity = parseInt($(this).val());
        var max_quantity = parseInt($(this).attr('max'));
        if (quantity >= max_quantity) {
            $(this).val(max_quantity)
            $(this).parent().parent().parent().find('.addtocart').attr('data-quantity', max_quantity);

        } else {
            $(this).val(quantity)
            $(this).parent().parent().parent().find('.addtocart').attr('data-quantity', quantity);
        }
    });
    /*END: tăng giảm số lượng */
    /*START: chọn thuộc tính version*/
    $(document).on('click', '.swatch-option', function() {
        let _this = $(this).parent();
        let __this = $(this).parent().parent().parent();
        //xóa selected có trong thẻ li của ul chứa li click
        _this.find('.swatch-option').removeClass('selected')
        //tìm đến li click thêm class selected
        _this.find(this).addClass('selected');
        //remove class selected ở ul cha
        _this.parent().find('ul').removeClass('selected');
        _this.addClass('done');
        let count_version = __this.find('.addtocart').attr('data-count-version');
        let check = __this.find('.swatch-option.selected').length;
        let attr = '';
        __this.find('.swatch-option.selected').each(function(key, index) {
            let id = $(this).attr('data-id');
            attr = attr + ';' + id;
        });
        if (count_version == check) {
            let URL = BASE_URL_AJAX + "ajax/product/get-version-product";
            $.post(URL, {
                    attr: attr,
                    id: __this.find('.addtocart').attr('data-id'),
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                function(data) {
                    //kiểm tra hết hàng
                    if(data.getVersionproduct.status_version == 1){
                        __this.find('.addtocart').addClass('disabled');
                    }else{
                        __this.find('.card-price').html(numberWithCommas(data.getVersionproduct.price_version) + ' VNĐ');
                        //thực hiện add attr giỏ hàng
                        __this.find('.addtocart').attr('data-price', data.getVersionproduct.price_version);
                        __this.find('.addtocart').attr('data-title-version', data.getVersionproduct.title_version);
                        __this.find('.addtocart').attr('data-id-version', data.getVersionproduct.id_sort);
                    }
                });
            return false;
        }
    });
    /*END: chọn thuộc tính version */
    /*START: submit thêm vào giỏ hàng*/
    /*
    $(document).on('click', '.addtocart', function() {
        let _this = $(this).parent().parent().parent();
        let id = $(this).attr('data-id');
        let count_version = $(this).attr('data-count-version');
        let count_version_check = _this.find('ul li.selected').length;
        _this.find('.list-version').removeClass('selected');
        if (count_version_check == count_version) {
            let URL = BASE_URL_AJAX + "ajax/cart/addtocart";
            $.ajax({
                type: 'POST',
                url: URL,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    id_version: $(this).attr('data-id-version'),
                    quantity: $(this).attr('data-quantity'),
                },
                success: function(data) {
                    let json = JSON.parse(data);
                    if (json.error == '') {
                        loadDataCart(json);
                        _this.find('ul').removeClass('done');
                        _this.find('ul li.selected').removeClass('selected');
                        toastr.success(json.message, 'Thông báo!')
                    } else {
                        toastr.error(json.error, 'Error!')
                    }

                }
            });
        } else {
            _this.find('.list-version').not('.done').addClass('selected');
        }
    });
    */
    $(document).on('click', '.addtocart', function() {
        let id = $(this).attr('data-id');
        let URL = BASE_URL_AJAX + "ajax/cart/addtocart";
        let cart = $(this).attr('data-cart');
        let image = $(this).attr('data-src');
        $.ajax({
            type: 'POST',
            url: URL,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                image: image,
                title_version: $(this).attr('data-title-version'),
                quantity: $(this).attr('data-quantity'),
                price: $(this).attr('data-price'),
                type: $(this).attr('data-type'),
            },
            success: function(data) {
                let json = JSON.parse(data);
                if (json.error == '') {
                    if(cart == 1){
                        window.location.href = BASE_URL_AJAX + "gio-hang/thanh-toan";
                    }else{
                        if(json.total_items > 0){
                            $('#cart-none-header').hide();
                            $('#cart-show-header').show();
                        }
                        loadDataCart(json);
                        toastr.success(json.message, 'Thông báo!')
                    }
                } else {
                    toastr.error(json.error, 'Error!')
                }
            },
            error: function(jqXhr, json, errorThrown) {
                toastr.error("Thêm sản phẩm vào giỏ hàng không thành công", 'Error!')
            },
        });
    });
    /*END: submit thêm vào giỏ hàng*/
    /*xóa giỏ hàng*/
     $(document).on('click', '.cart-remove', function(e) {
        e.preventDefault();
        let rowid = $(this).parent().parent().attr('data-rowid');
        ajax_cart_update(rowid, 0, 'delete');
        $(this).parent().parent().remove();
    });
    /*tăng giỏ hàng item => view giỏ hàng*/
    $(document).on('click', '.cart-plus', function() {
        let _this = $(this).parent().find('.card-quantity');
        var quantity = parseInt(_this.val());
        var max_quantity = parseInt(_this.attr('max'));
        if (quantity >= max_quantity) {
            toastr.error('Hết hàng', 'Error!');
            quantity = max_quantity;
            return false;
        } else {
            quantity += 1;
        }
        _this.val(quantity);
        // $(this).parent().parent().find('.addtocart').attr('data-quantity', quantity);
        let rowid = $(this).parent().parent().parent().attr('data-rowid');
        ajax_cart_update(rowid, quantity, 'update');
    });
    /*giảm giỏ hàng item => view giỏ hàng*/
    $(document).on('click', '.cart-minus', function() {
        let _this = $(this).parent().find('.card-quantity');
        var quantity = parseInt(_this.val());
        if (quantity <= 1) {
            quantity = 1;
        } else {
            quantity -= 1;
        }
        _this.val(quantity);
        // $(this).parent().parent().find('.addtocart').attr('data-quantity', quantity);
        let rowid = $(this).parent().parent().parent().attr('data-rowid');
        ajax_cart_update(rowid, quantity, 'update');

    });
    /* change input số lượng => view giỏ hàng*/
    $(document).on('change', '.cart_item .card-quantity', function() {
        var quantity = parseInt($(this).parent().find('.card-quantity').val());
        var max_quantity = parseInt($(this).parent().find('.card-quantity').attr('max'));
        if (quantity >= max_quantity) {
            $(this).parent().find('.card-quantity').val(max_quantity)
        } else {
            $(this).parent().find('.card-quantity').val()
        }
        let rowid = $(this).parent().parent().parent().attr('data-rowid');
        setTimeout(ajax_cart_update(rowid, quantity, 'update'), 800);
    });

    /*update cart*/
    function ajax_cart_update(rowid, quantity, type) {
        $.ajax({
            type: 'POST',
            url: BASE_URL_AJAX + "ajax/cart/updatecart",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                rowid: rowid,
                quantity: quantity,
                type: type
            },
            success: function(data) {
                let json = JSON.parse(data);
                if (json.error == '') {
                    toastr.success(json.message, 'Thông báo!')
                    $('#main-cart').html(json.html);
                    loadDataCart(json);
                    if (json.total > 0 && json.total_items > 0) {
                        //thực hiện add coupon nếu có
                        $('.cart-discount').html(json.coupon_html);
                    }
                    if(json.total_items > 0){
                        $('#cart-html-header').css('display', 'block');
                        $('#cart-none-header').hide();
                    }else{
                        $('#cart-show-header').css('display', 'none');
                        $('#cart-none-header').show();
                    }
                } else {
                    toastr.error(json.error, 'Error!')
                }
            }
        });
    }

    function loadDataCart(json){
      
        $('.cart-html-header').html(json.html_header);
        $('.cart-html-cart').html(json.html);
        $('.cart-quantity').html(json.total_items);
        $('.cart-coupon-price').html( numberWithCommas(json.coupon_price) + ' VNĐ');
        $('.cart-total').html(numberWithCommas(json.total) + ' VNĐ');
        $('.cart-total-final').html(numberWithCommas(json.total_coupon) + ' VNĐ');
    }
    /*START:mã giảm giá */
    $(document).on('click', '#apply_coupon', function(e) {
        e.preventDefault();
        let name = $('#coupon_code').val();
        $.ajax({
            type: 'POST',
            url: BASE_URL_AJAX + 'ajax/cart/addcounpon',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                priceShipping: $('input[name="total_price_ship"]').val()
            },
            success: function(data) {
                let json = JSON.parse(data);
                $('.message-container').show();
                if (json.error == '') {
                    $('.message-danger').hide();
                    //coupon show html
                    $('.cart-coupon-html').html(json.html);
                    //cập nhập lại tổng tiền
                    $('.cart-total-final').html(json.total);
                    toastr.success(json.message, 'Thông báo!')
                } else {
                    $('.message-success').hide();
                    $('.message-danger').show();
                    $('.danger-title').html('').html(json.error);
                }
            }
        });
    });
    /*END:mã giảm giá */
    /** START: xóa mã giảm giá */
    $(document).on('click', '.remove-coupon', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: BASE_URL_AJAX + 'ajax/cart/deletecoupon',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: $(this).attr('data-id'),
                priceShipping: $('input[name="total_price_ship"]').val()
            },
            success: function(data) {
                let json = JSON.parse(data);
                if (json.error == '') {
                    //coupon show html
                    $('.cart-coupon-html').html(json.html);
                    //cập nhập lại tổng tiền
                    $('.cart-total-final').html(json.total);
                    toastr.success(json.message, 'Thông báo!')
                } else {
                    toastr.error(json.error, 'Error!')
                }
            }
        });
    });
    /** END: xóa mã giảm giá */
});
