<div class=" col-span-12 lg:col-span-8 mt-3">
    @include('components.alert-error')
    @csrf
    <div class=" box p-5">
        <div>
            <label class="form-label text-base font-semibold">Tiêu đề</label>
            <?php echo Form::text('title', !empty($detail) ? $detail->title : '', ['class' => 'form-control w-full title','required']); ?>
        </div>
        <div class="mt-3">
            <label class="form-label text-base font-semibold">Đường dẫn</label>
            <div class="input-group">
                <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
                </div>
                <?php echo Form::text('slug', !empty($detail) ? $detail->slug : '', ['class' => 'form-control canonical', 'data-flag' => 0,'required']); ?>
            </div>
        </div>
        <div class="mt-3 hidden">
            <label class="form-label text-base font-semibold">Mô tả</label>
            <div class="mt-2">
                <?php echo Form::textarea('description', !empty($detail) ? $detail->description : '', ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
            </div>
        </div>
    </div>
    <div class=" box mt-5">
        <div id="link-tab" class="p-5">
            <div class="preview">
                <ul class="nav nav-link-tabs" role="tablist">
                    <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill"
                            data-tw-target="#example-tab-1" type="button" role="tab" aria-controls="example-tab-1"
                            aria-selected="true"> Chung </button>
                    </li>
                    <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-2"
                            type="button" role="tab" aria-controls="example-tab-2" aria-selected="false"> Hạn chế sử
                            dụng </button>
                    </li>
                    <li id="example-3-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#example-tab-3"
                            type="button" role="tab" aria-controls="example-tab-3" aria-selected="false">Các giới hạn sử
                            dụng </button>
                    </li>
                </ul>
                <div class="tab-content mt-5">
                    <div id="example-tab-1" class="tab-pane leading-relaxed active  space-y-3" role="tabpanel"
                        aria-labelledby="example-5-tab">
                        <div>
                            <label class="form-label text-base font-semibold">Mã
                                ưu đãi</label>
                            <div class="input-group">
                                <?php echo Form::text('name', !empty($detail) ? $detail->name : '', ['class' => 'form-control', 'autocomplete' => 'off' ,'required']); ?>
                                <div class="input-group-text render_code cursor-pointer w-52">Tạo mã tự
                                    động
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold">Loại ưu đãi</label>
                            <?php echo Form::select('typecoupon', config('cart.coupon'), !empty($detail) ? $detail->type : '', ['class' => 'form-control ']); ?>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Mức ưu đãi <a href=""
                                    class="text-primary tooltip" title="Giá trị của mã ưu đãi.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php echo Form::number('value', !empty($detail) ? $detail->value : '', ['class' => 'form-control', 'autocomplete' => 'off','required']); ?>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold">Sử dụng kết hợp cùng các mã ưu đãi
                                khác</label>
                            <?php echo Form::select('individual_use', config('cart.individual_use'), !empty($detail) ? $detail->individual_use : '', ['class' => 'form-control ']); ?>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Ngày bắt đầu <a href=""
                                    class="text-primary tooltip" title="Phiếu giảm giá sẽ bắt đầu vào lúc 00:00:00">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php echo Form::text('date_start', !empty($detail) ? $detail->date_start : '', ['class' => 'form-control datepicker',  'autocomplete' => 'off']);?>
                        </div>

                        <?php
                        if ($errors->any()) {
                            $expiry_date = old('expiry_date');
                        } else if($action == 'update'){
                            $expiry_date = $detail->expiry_date;
                        }
                        ?>
                        <div class="flex mt-3 items-center">
                            <div class="mr-1">
                                <?php if (isset($expiry_date) && $expiry_date == 1) { ?>
                                <input type="checkbox" checked name="expiry_date" value="1" class="checkbox-item">
                                <?php } else { ?>
                                <input type="checkbox" name="expiry_date" value="1" class="checkbox-item">
                                <?php } ?>
                            </div>
                            <div>
                                Ngày kết thúc
                            </div>
                        </div>
                        <div class="show_date_end"
                            <?php if (isset($expiry_date) && $expiry_date == 1) { ?>style="display: block"
                            <?php }else{?> style="display: none" <?php }?>>
                            <label class="form-label text-base font-semibold  flex items-center">Ngày kết thúc <a
                                    href="" class="text-primary tooltip"
                                    title="Phiếu giảm giá sẽ kết thúc vào lúc 00:00:00">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php echo Form::text('date_end', !empty($detail) ? $detail->date_end : '', ['class' => 'form-control datepicker',  'autocomplete' => 'off']);?>
                        </div>

                    </div>
                    <div id="example-tab-2" class="tab-pane leading-relaxed  space-y-3" role="tabpanel"
                        aria-labelledby="example-2-tab">
                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Chi tiêu tối
                                thiểu<a href="" class="text-primary tooltip"
                                    title="Trường này cho phép bạn thiết lập giá trị đơn hàng tối thiểu để sử dụng các mã ưu đãi.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php  echo Form::text('min_price', !empty($detail) ? $detail->min_price : '', ['class' => 'form-control ', 'autocomplete' => 'off']); ?>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Chi tiêu tối
                                đa<a href="" class="text-primary tooltip"
                                    title="Trường này cho phép bạn thiết lập giá trị đơn hàng tối đa để sử dụng các mã ưu đãi.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php  echo Form::text('max_price', !empty($detail) ? $detail->max_price : '', ['class' => 'form-control ', 'autocomplete' => 'off']); ?>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Số lượng đơn
                                hàng tối thiểu<a href="" class="text-primary tooltip"
                                    title="Trường này cho phép bạn thiết lập số lượng đơn hàng tối thiểu để sử dụng các mã ưu đãi.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php  echo Form::text('min_count', !empty($detail) ? $detail->min_count : '', ['class' => 'form-control ', 'autocomplete' => 'off']); ?>
                        </div>
                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Số lượng đơn
                                hàng tối đa<a href="" class="text-primary tooltip"
                                    title="Trường này cho phép bạn thiết lập số lượng đơn hàng tối đa để sử dụng các mã ưu đãi.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php  echo Form::text('max_count', !empty($detail) ? $detail->max_count : '', ['class' => 'form-control ', 'autocomplete' => 'off']); ?>
                        </div>

                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Sản phẩm <a href=""
                                    class="text-primary tooltip"
                                    title="Các sản phẩm được sử dụng mã ưu đãi, hoặc cần trong giỏ hàng để có thể áp dụng.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <select id="product_ids" class="form-control tom-select-product tom-select tomselected"
                                multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="products"
                                name="product_ids[]" tabindex="-1" hidden="hidden">
                                <?php if(!empty($product_ids) && count($product_ids) > 0){?>
                                <?php foreach($product_ids as  $v){?>
                                <option selected value="<?php echo $v->id ?>"> <?php echo $v->title ?></option>
                                <?php }?>
                                <?php }?>
                            </select>
                        </div>
                        <div>
                            <label class=" form-label text-base font-semibold flex items-center">Danh mục sản
                                phẩm <a href="" class="text-primary tooltip"
                                    title="Các danh mục sản phẩm được sử dụng mã ưu đãi, hoặc cần trong giỏ hàng để có thể áp dụng.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <select id="product_categories"
                                class="form-control tom-select-product-category tom-select tomselected"
                                multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="products"
                                name="product_categories[]" tabindex="-1" hidden="hidden">

                                <?php if(!empty($product_categories) && count($product_categories) > 0){?>
                                <?php foreach($product_categories as  $v){?>
                                <option selected value="<?php echo $v->id ?>"> <?php echo $v->title ?></option>
                                <?php }?>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div id="example-tab-3" class="tab-pane leading-relaxed space-y-3" role="tabpanel"
                        aria-labelledby="example-3-tab">


                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Giới hạn sử
                                dụng cho mỗi mã giảm giá<a href="" class="text-primary tooltip"
                                    title="Mỗi mã ưu đãi được sử dụng bao nhiêu lần trước khi hết hạn.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php  echo Form::text('limit', !empty($detail) ? $detail->limit : '', ['class' => 'form-control ', 'autocomplete' => 'off']); ?>

                        </div>

                        <div>
                            <label class="form-label text-base font-semibold  flex items-center">Giới hạn sử
                                dụng trên mỗi người dùng<a href="" class="text-primary tooltip"
                                    title="Bao nhiêu lần mỗi mã ưu đãi có thể sử dụng bởi một khách hàng. Sử dụng địa chỉ email thanh toán cho khách không đăng nhập, và mã khách hàng nếu đã đăng nhập.">
                                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i></a></label>
                            <?php  echo Form::text('limit_user', !empty($detail) ? $detail->limit_user : '', ['class' => 'form-control ', 'autocomplete' => 'off']); ?>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Album Ảnh -->
    <div class=" box p-5 mt-3">
        <!-- start: SEO -->
        @include('components.seo')
        <!-- end: SEO -->
        <div class="text-right mt-5">
            @if ($action == 'update')
            <button type="submit" class="btn btn-primary">Cập nhập</button>
            @else
            <button type="submit" class="btn btn-primary">Lưu</button>
            @endif
        </div>
    </div>
    <!-- END: Form Layout -->
</div>
<div class=" col-span-12 lg:col-span-4">
    @include('components.image',['action' => $action,'name' => 'image','title'=> 'Ảnh đại diện'])
  
    @include('components.publish')
</div>
@push('javascript')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(function() {
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<script>
$(document).on('click', '.checkbox-item', function() {
    var value = $(this).val();
    if (value == 1) {
        $('.show_date_end').show();
    }
})
</script>
<style>
#ui-datepicker-div {
    z-index: 9999999 !important;
}
</style>
@endpush