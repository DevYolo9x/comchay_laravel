<?php $category_attributes = \App\Models\CategoryAttribute::select('id', 'title', 'ishome', 'highlight')->where('alanguage', config('app.locale'))->where('ishome', 1)->orWhere('highlight', 1)->limit(2)->get(); ?>
@if($category_attributes->count() > 1)
<?php
foreach ($category_attributes as $k => $item) {
    if ($item->ishome == 1) {
        $colors = $item;
    } else if ($item->highlight == 1) {
        $sizes = $item;
    }
}
function convert_color($color = '', $size = '')
{
    //vòng lặp của color
    $tempColor = [];
    if (isset($color['title']) && is_array($color['title'])  && count($color['title'])) {
        foreach ($color['title'] as $key => $val) {
            $tempColor[] = array('title' => $val);
        }
    }
    if (isset($tempColor) && is_array($tempColor) && count($tempColor)) {
        foreach ($tempColor as $key => $val) {
            $tempColor[$key]['title'] = $color['title'][$key];
            $tempColor[$key]['image'] = $color['image'][$key];
            $tempColor[$key]['count'] = $color['count'][$key];
        }
    }
    //vòng lặp của size
    $tempSize = [];
    if (isset($size['title']) && is_array($size['title'])  && count($size['title'])) {
        foreach ($size['title'] as $key => $val) {
            $tempSize[] = array('title' => $val);
        }
    }
    if (isset($tempSize) && is_array($tempSize) && count($tempSize)) {
        foreach ($tempSize as $key => $val) {
            $tempSize[$key]['title'] = $size['title'][$key];
            $tempSize[$key]['code'] = $size['code'][$key];
            $tempSize[$key]['price'] = $size['price'][$key];
            $tempSize[$key]['price_sale'] = $size['price_sale'][$key];
            $tempSize[$key]['_stock_status'] = $size['_stock_status'][$key];
            $tempSize[$key]['_stock'] = $size['_stock'][$key];
            $tempSize[$key]['_outstock_status'] = $size['_outstock_status'][$key];
        }
    }
    $array = [];
    if (isset($tempColor) && is_array($tempColor) && count($tempColor)) {
        $j = $i = 0;
        foreach ($tempColor as $key => $val) {
            $array[$key]['title'] = $val['title'];
            $array[$key]['image'] = $val['image'];
            $j = $j + $val['count'];
            $page = [];
            if (isset($tempSize) && is_array($tempSize) && count($tempSize)) {
                foreach ($tempSize as $keyS => $valS) {
                    if ($keyS < $j && $keyS >= $i) {
                        $page[$keyS] = $valS;
                        $i++;
                    }
                }
                $page = array_values($page);
            }
            $array[$key]['page'] = $page;
        }
    }
    return $array;
}
$colors_old = old('colors');
$sizes_old = old('sizes');
$color_page = convert_color($colors_old, $sizes_old);
if (isset($color_page) && is_array($color_page) && count($color_page)) {
    $color_page = $color_page;
} elseif (!empty($detail->id)) {
    $color_page = [];
    $products_color = \App\Models\products_color::select('id', 'title', 'image')->where('product_id', $detail->id)->get();
    if ($products_color->count() > 0) {
        foreach ($products_color as $k => $item) {
            $color_page[] = [
                'title' => $item->title,
                'image' => $item->image,
                'page' => $item->products_size
            ];
        }
    }
}
?>
<div class=" box p-5 mt-3 space-y-3">
    <div>
        <label class="form-label text-base font-semibold">Phiên bản sản phẩm</label>
    </div>
    <div class="ibox mb-5 block-version">
        <div id="from-itinerary">
            @if (isset($color_page) && is_array($color_page) && count($color_page))
            @foreach ($color_page as $keyc => $vals)
            <div class="p-5 box mb-5 color_box">
                <div class="preview py-2">
                    <div>
                        <div class="flex items-center justify-between">
                            <label class="form-label uppercase version_title">Tên Màu sắc
                                <span><?php echo ($keyc + 1) ?></span></label>
                            <a href="javascript:void(0)" class="form-label uppercase text-danger btnDeleteColor" data-number="1">Xóa Màu sắc này</a>
                        </div>
                        <input type="text" value="<?php echo $vals['title'] ?>" class="form-control colors_title" name="colors[title][]" placeholder="" required="">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Hình ảnh</label>
                        <div class="flex items-center space-x-3">
                            <div class="avatar" style="cursor: pointer;flex:none">
                                <img src="<?php echo (isset($vals['image']) && !empty($vals['image'])) ? url($vals['image']) : url('images/404.png'); ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">
                            </div>
                            <input type="text" name="colors[image][]" value="<?php echo $vals['image']; ?>" class="form-control" placeholder="Đường dẫn của ảnh" style="cursor: not-allowed;opacity: 0.56;" autocomplete="off">
                            <input type="hidden" name="colors[count][]" class="count" value="<?php echo count($vals['page']) ?>">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="sortable">
                    <?php if (count($vals['page']) > 0) : ?>
                        <?php foreach ($vals['page'] as $key => $val) : ?>
                            <div class="mb-2 dd3-content ">
                                <div class="relative">
                                    <a href="javascript:void(0)" class="form-label mb-0 accordion w-full">
                                        <span class="version_title_color"><?php echo $vals['title'] ?>/</span>
                                        <span class="version_title_size"><?php echo $val['title'] ?></span>
                                    </a>
                                    <a href="javascript:void(0)" class="text-danger version_remove" data-number="1" data-page="1">Xóa</a>
                                </div>
                                <div class="version_item_size hidden">
                                    <div class="grid grid-cols-2 gap-6 mt-3">
                                        <div>
                                            <label class="form-label uppercase">TÊn Size</label>
                                            <input type="text" name="sizes[title][]" value="<?php echo $val['title'] ?>" class="form-control size_title" placeholder="" required="">
                                        </div>
                                        <div><label class="form-label">Mã sản phẩm</label>
                                            <input type="text" name="sizes[code][]" value="<?php echo $val['code'] ?>" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6 mt-3">
                                        <div>
                                            <label class="form-label">Giá</label>
                                            <input type="text" name="sizes[price][]" value="<?php echo $val['price'] ?>" class="form-control int price" placeholder="">
                                        </div>
                                        <div>
                                            <label class="form-label">Giá ưu đãi</label><input type="text" name="sizes[price_sale][]" value="<?php echo $val['price_sale'] ?>" class="form-control int price" placeholder="">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h2 class="font-medium text-base mr-auto">Quản lý tồn kho</h2>
                                        <div class="mt-3">
                                            <div class="form-switch">

                                                <select class="form-select selectStock" name="sizes[_stock_status][]">
                                                    <option value="1" @if($val['_stock_status']==1) selected @endif>Có quản lý
                                                        tồn
                                                        kho</option>
                                                    <option value="0" @if($val['_stock_status']==0) selected @endif>Không quản
                                                        lý
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="showStock @if($val['_stock_status']==0) hidden @endif">
                                            <div class="mt-3">
                                                <label class="form-label">Số lượng trong kho</label>
                                                <input type="number" name="sizes[_stock][]" min="0" class="form-control" value="<?php echo $val['_stock'] ?>" placeholder="">
                                            </div>
                                            <div class="mt-3">
                                                <div class=" form-switch">
                                                    <label class="form-label">Đồng ý cho đặt hàng khi đã hết hàng</label>
                                                    <select class="form-select" name="sizes[_outstock_status][]">
                                                        <option value="0" @if($val['_outstock_status']==0) selected @endif>Không
                                                            cho đặt hàng khi hết hàng</option>
                                                        <option value="1" @if($val['_outstock_status']==1) selected @endif>Đồng
                                                            ý
                                                            cho đặt hàng khi đã hết hàng
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>

                </div>
                <button type="button" class="btn btnAddSize btn-danger text-white capitalize" data-page="1">Thêm
                    Size mới cho màu này</button>
            </div>
            @endforeach
            @endif
            <a href="javascript:void(0)" class="btn btn-primary mt-5 w-full uppercase btnAddColor" data-number="0" data-page="0">Thêm mới {{$colors->title}}</a>

        </div>
    </div>

</div>
@endif
@push('javascript')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        $("#sortable").sortable();
    });
</script>
<script>
    $(function() {

        /*click show chi tiết kích thước trong màu sắc */
        $(document).on('click', '.accordion', function() {
            $(this).parent().parent().find('.version_item_size').toggleClass('hidden');
        })
        /*Điền tên màu sắc thêm vào kích thước con*/
        $(document).on('keyup', '.colors_title', function() {
            var value = $(this).val();
            $(this).parent().parent().parent().find('.version_title_color').html(value + '/');
        })
        /*nhập kích thước có trong màu sắc */
        $(document).on('keyup', '.size_title', function() {
            var value = $(this).val();
            $(this).parent().parent().parent().parent().find('.version_title_size').html(value);
        })

        function load_color(stt = 1, page = 1, product_code = '') {
            let price_old = $('input[name="price"]').val();
            let price_sale = $('input[name="price_sale"]').val();
            item = '<div class="p-5 box mb-5 color_box">';
            item = item + '<div class="preview py-2">';
            item = item + '<div>';
            item = item + '<div class="flex items-center justify-between">';
            item = item +
                '<label class="form-label uppercase version_title">Tên <?php echo $colors->title ?> <span>' + (stt +
                    1) + '</span></label>';
            item = item +
                '<a href="javascript:void(0)" class="form-label uppercase text-danger btnDeleteColor" data-number="' +
                (stt + 1) + '">Xóa <?php echo $colors->title ?> này</a>';
            item = item + '</div>';
            item = item +
                '<input type="text" class="form-control colors_title" name="colors[title][]" placeholder="" required>';
            item = item + '</div>';
            item = item + '<div class="mt-3">';
            item = item + '<label class="form-label">Hình ảnh</label>';
            item = item + '<div class="flex items-center space-x-3">';
            item = item + '<div class="avatar" style="cursor: pointer;flex:none">';
            item = item +
                '<img src="<?php echo url('images/404.png') ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">';
            item = item + '</div>';
            item = item +
                '<input type="text" name="colors[image][]" style="cursor: not-allowed;opacity: 0.56;" value="" class="form-control" placeholder="Đường dẫn của ảnh" autocomplete="off"><input type="hidden" name="colors[count][]" class="count" value="<?php echo $sizes->count() ?>">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<hr>';
            item = item + '<div class = "sortable">';
            <?php if ($sizes->listAttr->count() > 0) { ?>
                <?php foreach ($sizes->listAttr as $k => $item) { ?>
                    item = item + '<div class="mb-2 dd3-content ">';
                    item = item + '<div class="relative">';
                    item = item +
                        '<a href="javascript:void(0)" class="form-label mb-0 accordion w-full"><span class="version_title_color"></span><span class="version_title_size"><?php echo $item->title ?></span></a>';
                    item = item +
                        '<a href="javascript:void(0)" class="text-danger version_remove"  data-number="1">Xóa</a>';
                    item = item + '</div>';
                    item = item + '<div class="version_item_size hidden">';
                    item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
                    item = item + '<div>';
                    item = item + '<label class="form-label uppercase">TÊn {{$sizes->title}}</label>';
                    item = item +
                        '<input type="text" name="sizes[title][]" value="<?php echo $item->title ?>" class="form-control size_title" placeholder="" required>';
                    item = item + '</div>';
                    item = item + '<div>';
                    item = item + '<label class="form-label">Mã sản phẩm</label>';
                    item = item + '<input type="text" name="sizes[code][]" value="' + product_code + '-' + (stt +
                        1) + '-<?php echo $k ?>" class="form-control" placeholder="">';
                    item = item + '</div>';
                    item = item + '</div>';
                    item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
                    item = item + '<div>';
                    item = item + '<label class="form-label">Giá</label>';
                    item = item + '<input type="text" name="sizes[price][]" value="' + price_old +
                        '" class="form-control int price" placeholder="">';
                    item = item + '</div>';
                    item = item + '<div class="">';
                    item = item + '<label class="form-label">Giá ưu đãi</label>';
                    item = item +
                        '<input type="text" name="sizes[price_sale][]" value="' + price_sale +
                        '" class="form-control int price" placeholder="">';
                    item = item + '</div>';
                    item = item + '</div>';
                    item = item + '<div class="mt-3">';
                    item = item + '<h2 class="font-medium text-base mr-auto">Quản lý tồn kho</h2>';
                    item = item + '<div class="mt-3">';
                    item = item + '<div class="form-switch">';
                    item = item + '<select class="form-select selectStock" name="sizes[_stock_status][]">';
                    item = item + '<option value="1" selected>Có quản lý tồn kho</option>';
                    item = item + '<option value="0">Không quản lý</option>';
                    item = item + '</select>';
                    item = item + '</div>';
                    item = item + '</div>';


                    item = item + '<div class="showStock">';
                    item = item + '<div class="mt-3">';
                    item = item + '<label class="form-label">Số lượng trong kho</label>';
                    item = item +
                        '<input type="number" name="sizes[_stock][]" min="0" class="form-control" placeholder="">';
                    item = item + '</div>';
                    item = item + '<div class="mt-3">';
                    item = item + '<div class="form-switch">';
                    item = item + '<label class="form-label">Đặt hàng khi đã hết hàng</label>';
                    item = item + '<select class="form-select" name="sizes[_outstock_status][]">';
                    item = item + '<option value="0" selected>Không cho đặt hàng khi hết hàng</option>';
                    item = item + '<option value="1" >Đồng ý cho đặt hàng khi đã hết hàng</option>';
                    item = item + '</select>';
                    item = item + '</div>';
                    item = item + '</div>';
                    item = item + '</div>';
                    item = item + '</div>';
                    item = item + '</div>';
                    item = item + '</div>';
                <?php } ?>
            <?php } ?>
            item = item + '</div>';
            item = item +
                '<button type="button" class="btn btnAddSize btn-danger text-white capitalize" data-page="' + (
                    page +
                    1) +
                '">Thêm {{$sizes->title}} mới cho màu này</button>';
            item = item + '</div>';
            item = item +
                '<a href="javascript:void(0)" class="btn btn-primary mt-5 w-full uppercase btnAddColor" data-number="' +
                (stt + 1) + '" data-page="' + (page + 1) + '">Thêm mới phiên bản</a>';
            return item;
        }

        function load_color_page() {
            var i = 1;
            var j = 1;
            $('#from-itinerary .color_box').each(function() {
                var chapt = i++;
                // Đánh số lại các color
                $(this).find('.version_title span').html(chapt);
                $(this).find('.btnDeleteColor').attr('data-number', chapt);
                $('#from-itinerary').find('.btnAddColor').attr('data-number', chapt);
                // Đánh số lại các size
                // var jj = j + 1;
                $(this).find('.dd3-content').each(function() {
                    var page = j++;
                    $(this).find('.version_remove').attr('data-page', page);
                    $('#from-itinerary').find('.btnAddColor').attr('data-number', chapt);
                    $(this).parent().find('.btnAddSize').attr('data-page', page);
                    $('#from-itinerary').find('.btnAddColor').attr('data-page', page);
                });
            });
        }
        //thêm mới màu sắc
        $(document).on('click', '.btnAddColor', function() {
            var chap = parseInt($(this).attr('data-number'));
            var page = parseInt($(this).attr('data-page'));
            var product_code = $('input[name="code"]').val();
            var item = load_color(chap, page, product_code);
            $(this).remove();
            $('#from-itinerary').append(item);
            load_color_page();
        });
        /* Xóa màu sắc  */
        $(document).on('click', '.btnDeleteColor', function() {
            $(this).parent().parent().parent().parent().remove();
            load_color_page();
        });

        function load_size(page = 1, title_color = '', product_code = '') {
            let price_old = $('input[name="price"]').val();
            let price_sale = $('input[name="price_sale"]').val();
            var item = '';
            item = item + '<div class="mb-2 dd3-content ">';
            item = item + '<div class="relative">';
            item = item +
                '<a href="javascript:void(0)" class="form-label mb-0 accordion w-full"><span class="version_title_color">' +
                title_color + '/</span><span class="version_title_size"></span></a>';
            item = item + '<a href="javascript:void(0)" class="text-danger version_remove" data-number="1">Xóa</a>';
            item = item + '</div>';
            item = item + '<div class="version_item_size ">';
            item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
            item = item + '<div>';
            item = item + '<label class="form-label uppercase">TÊn {{$sizes->title}}</label>';
            item = item +
                '<input type="text" name="sizes[title][]" value="" class="form-control size_title" placeholder="" required>';
            item = item + '</div>';
            item = item + '<div>';
            item = item + '<label class="form-label">Mã sản phẩm</label>';
            item = item + '<input type="text" name="sizes[code][]" value="' + product_code +
                '" class="form-control" placeholder="">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="grid grid-cols-2 gap-6 mt-3">';
            item = item + '<div>';
            item = item + '<label class="form-label">Giá</label>';
            item = item + '<input type="text" value="' + price_old +
                '" name="sizes[price][]" class="form-control int price" placeholder="">';
            item = item + '</div>';
            item = item + '<div class="">';
            item = item + '<label class="form-label">Giá ưu đãi</label>';
            item = item +
                '<input type="text" value="' + price_sale +
                '" name="sizes[price_sale][]" class="form-control int price" placeholder="">';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '<div class="mt-3">';
            item = item + '<h2 class="font-medium text-base mr-auto">Quản lý tồn kho</h2>';
            item = item + '<div class="mt-3">';
            item = item + '<div class="form-switch">';
            item = item + '<select class="form-select selectStock" name="sizes[_stock_status][]">';
            item = item + '<option value="1" selected>Có quản lý tồn kho</option>';
            item = item + '<option value="0">Không quản lý</option>';
            item = item + '</select>';
            item = item + '</div>';
            item = item + '</div>';

            item = item + '<div class="showStock">';
            item = item + '<div class="mt-3">';
            item = item + '<label class="form-label">Số lượng trong kho</label>';
            item = item +
                '<input type="number" name="sizes[_stock][]" min="0" class="form-control" placeholder="">';
            item = item + '</div>';

            item = item + '<div class="mt-3">';
            item = item + '<div class="form-switch">';
            item = item + '<label class="form-label">Đặt hàng khi đã hết hàng</label>';
            item = item + '<select class="form-select" name="sizes[_outstock_status][]">';
            item = item + '<option value="0" selected>Không cho đặt hàng khi hết hàng</option>';
            item = item + '<option value="1" >Đồng ý cho đặt hàng khi đã hết hàng</option>';
            item = item + '</select>';
            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';

            item = item + '</div>';
            item = item + '</div>';
            item = item + '</div>';
            return item;
        }
        /* Thêm kích thước vào màu sắc */
        $(document).on('click', '.btnAddSize', function() {
            var title_color = $(this).parent().find('.colors_title').val();
            var page = parseInt($(this).attr('data-page'));
            var count = parseInt($(this).parent().find('.count').val());
            $(this).parent().find('.count').attr('value', (count + 1));
            //lấy code
            var code_length = parseInt($(this).parent().find('.dd3-content').length) + 1;
            var code_stt = $(this).parent().find('.version_title span').text();
            var code_product = $('input[name="code"]').val();

            var product_code = code_product + '-' + code_stt + '-' + code_length;

            var item = load_size(page, title_color, product_code);

            $(this).attr('data-page', (page + 1));

            $('.btnAddColor').attr('data-page', (page + 1));

            $(this).parent().find('.sortable').append(item);

            load_color_page();
        });
        /*xóa kích thước trong màu sắc */
        $(document).on('click', '.version_remove', function() {
            $(this).parent().parent().remove();
            load_color_page();

        })
        $(document).on('change', '.selectStock', function() {
            $value = $(this).val();
            if ($value == 1) {
                $(this).parent().parent().parent().find('.showStock').removeClass('hidden');
            } else {
                $(this).parent().parent().parent().find('.showStock').addClass('hidden');
            }
        })

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

























@endpush