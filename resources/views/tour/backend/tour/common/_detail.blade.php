<?php
$code = CodeRender('tours');
$price = $price_sale = 0;
$title = $slug = $description = $content = $map = $video = '';
if ($errors->any()) {
    $title =  old('title');
    $slug = old('slug');
    $code = old('code');
    $price = old('price');
    $price_sale = old('price_sale');
    $price_contact = old('price_contact');
    $description = old('description');
    $content = old('content');
    $map = old('map');
    $video = old('video');

} else if($action == 'update'){
    $title =  $detail->title;
    $slug = $detail->slug;
    $code = $detail->code;
    $price =  number_format($detail->price, '0', ',', '.');
    $price_sale =  number_format($detail->price_sale, '0', ',', '.');
    $price_contact = $detail->price_contact;
    $description = $detail->description;
    $content = $detail->content;
    $map = $detail->map;
    $video = $detail->video;
}
?>
<!-- BEGIN: Form Layout -->
<div class="mt-3 box p-5">
    <div>
        <label class="form-label text-base font-semibold">Tiêu đề</label>
        <?php echo Form::text('title', $title, ['class' => 'form-control w-full title']); ?>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Đường dẫn</label>
        <div class="input-group">
            <div class="input-group-text vertical-1"><span class="vertical-1"><?php echo url(''); ?></span>
            </div>
            <?php echo Form::text('slug', $slug, ['class' => 'form-control canonical', 'data-flag' => 0]); ?>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Mô tả</label>
        <div class="mt-2">
            <?php echo Form::textarea('description', $description, ['id' => 'ckDescription', 'class' => 'ck-editor-description', 'style' => 'font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label text-base font-semibold">Thông tin sản phẩm</label>
        <div class="mt-2">
            <?php echo Form::textarea('content', $content, ['id' => 'ckContent', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']);?>
        </div>
    </div>
</div>
<div class="box p-5 mt-3 space-y-3">
    <div class="grid grid-cols-2 gap-6">
        <div class="col-span-2">
            <label class="form-label text-base font-semibold">Mã sản phẩm</label>
            <?php echo Form::text('code', $code, ['class' => 'form-control w-full ']); ?>
        </div>
        <div>
            <label class="form-label text-base font-semibold">Giá</label>
            <?php echo Form::text('price', $price, ['class' => 'form-control int price','autocomplete' => 'off']);; ?>

            <div class="flex mt-3 items-center">
                <div class="mr-1">
                    <?php if (isset($price_contact) && $price_contact == 1) { ?>
                    <input type="checkbox" checked name="price_contact" value="1" class="checkbox-item">
                    <?php } else { ?>
                    <input type="checkbox" name="price_contact" value="1" class="checkbox-item">
                    <?php } ?>
                </div>
                <div>
                    Liên hệ để biết giá
                </div>
            </div>
        </div>
        <div class="">
            <label class="form-label text-base font-semibold">Giá khuyến mại</label>
            <?php echo Form::text('price_sale', $price_sale, ['class' => 'form-control int ','autocomplete' => 'off']);; ?>
        </div>
    </div>
</div>
<!-- start: Album Ảnh -->
<div class="box p-5 mt-3 space-y-3">
    <div>
        @include('components.dropzone',['action' => $action])
    </div>
</div>
<!-- END: Album Ảnh -->
<!-- start: Video -->
<div class="box p-5 mt-3 space-y-3">
    <div class="col-span-2">
        <div class="flex justify-between items-center">
            <label class="form-label text-base font-semibold">Video</label>
            <span class="uppercase">Mã iframe</span>
        </div>
        <?php echo Form::textarea('video', $video, ['class' => 'form-control','rows' => 4]);?>
    </div>
</div>
<!-- END: Video -->
<!-- start: Video -->
<div class="box p-5 mt-3 space-y-3">
    <div class="col-span-2">
        <div class="flex justify-between items-center">
            <label class="form-label text-base font-semibold">Map</label>
            <span class="uppercase">Mã iframe</span>
        </div>
        <?php echo Form::textarea('map', $map, ['class' => 'form-control','rows' => 4]);?>
    </div>
</div>
<!-- END: Video -->
@push('javascript')
@endpush