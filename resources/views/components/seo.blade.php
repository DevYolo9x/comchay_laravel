<div class="mt-3">
    <div class="ibox-title">
        <div class="flex justify-between items-center">
            <h5 class="form-label text-base font-semibold mb-0">Tối ưu SEO <small class=" text-danger">Thiết lập các thẻ
                    mô
                    tả
                    giúp khách hàng dễ dàng tìm thấy
                    bạn.</small></h5>

            <div class="edit">
                <a href="#" class="edit-seo">Chỉnh sửa SEO</a>
            </div>
        </div>
    </div>
    <div class="ibox-content mt-3">
        <div class="">
            <?php if (isset($detail)) { ?>
            <div class="google">
                <div class="g-title">
                    <?php echo (old('meta_title')) ? old('meta_title') : ((old('title')) ? old('title') : (($detail->meta_title != '') ? $detail->meta_title : $detail->title)); ?>
                </div>
                @if($module != 'pages')
                <div class="g-link"><?php echo (old('slug')) ? url(old('slug')) : url($detail->slug); ?></div>
                @endif
                <div class="g-description" id="metaDescription">
                    <?php echo (old('meta_description')) ? old('meta_description') : ((old('description')) ? strip_tags(old('description')) : ((!empty($detail->meta_description)) ? strip_tags($detail->meta_description) : ((!empty($detail->description)) ? cutnchar(strip_tags($detail->description)) : 'List of all combinations of words containing CKEDT. Words that contain ckedt letters in them. Anagrams made from C K E D T letters.List of all combinations of words containing CKEDT. Words that contain ckedt letters in them. Anagrams made from C K E D T letters.'))); ?>
                </div>
            </div>
            <?php } else { ?>
            <div class="google">
                <div class="g-title">
                    <?php echo (old('meta_title')) ? old('meta_title') : ((old('title')) ? old('title') : env('BE_TITLE_SEO').' - Đơn vị thiết kế website hàng đầu Việt Nam'); ?>
                </div>
                @if($module != 'pages')
                <div class="g-link">
                    <?php echo (old('slug')) ? url(old('slug')) : 'https://ADMIN.COM/kho-giao-dien-website.html'; ?>
                </div>
                @endif

                <div class="g-description" id="metaDescription">
                    <?php echo (old('meta_description')) ? old('meta_description') : ((old('description')) ? strip_tags(old('description')) : 'List of all combinations of words containing CKEDT. Words that contain ckedt letters in them. Anagrams made from C K E D T letters.List of all combinations of words containing CKEDT. Words that contain ckedt letters in them. Anagrams made from C K E D T letters.'); ?>

                </div>
            </div>

            <?php } ?>
        </div>

        <div class="seo-group hidden mt-3">
            <hr class="py-2">
            <div class="">
                <div class="form-row">
                    <div class="flex justify-between items-center">
                        <label class="form-label text-base font-semibold">
                            Tiêu đề SEO
                        </label>
                        <span style="color:#9fafba;"><span
                                id="titleCount"><?php echo !empty($detail->meta_title) ? strlen($detail->meta_title) : 0 ?></span>
                            trên 70 ký tự</span>
                    </div>
                    <?php
                        echo Form::text('meta_title', !empty($detail->meta_title) ? $detail->meta_title : '', ['class' => 'form-control meta-title']);
                        ?>
                </div>
            </div>
            <div class="mt-3">
                <div class="form-row">
                    <div class="flex justify-between items-center">
                        <label class="form-label text-base font-semibold ">
                            Mô tả SEO
                        </label>
                        <span style="color:#9fafba;"><span
                                id="descriptionCount"><?php echo !empty($detail->meta_description) ? strlen($detail->meta_description) : 0 ?></span>
                            trên 320 ký tự</span>
                    </div>

                    <?php
                        echo Form::textarea('meta_description',  !empty($detail->meta_description) ? $detail->meta_description : '', ['class' => 'form-control meta-description', 'id' => 'seoDescription']);
                        ?>
                </div>
            </div>

        </div>

    </div>

</div>
@push('javascript')
<script>
$(document).on("click", ".edit-seo", function() {
    $(".seo-group").toggleClass("hidden");
    return false;
});
$(document).on("keyup", ".canonical", function() {
    let _this = $(this);
    _this.attr("data-flag", "1");
    let slugTitle = slug(_this.val());
    $(".g-link").text(BASE_URL + slugTitle + ".html");
});

$(document).on("keyup change", ".meta-title", function() {
    let _this = $(this);
    let totalCharacter = _this.val().length;
    $("#titleCount").text(totalCharacter);
    if (totalCharacter > 70) {
        _this.addClass("input-error");
    } else {
        _this.removeClass("input-error");
    }
    $(".g-title").text(_this.val());
});

$(document).on("keyup change", ".meta-description", function() {
    let _this = $(this);
    let totalCharacter = _this.val().length;
    $("#descriptionCount").text(totalCharacter);
    if (totalCharacter > 320) {
        _this.addClass("input-error");
    } else {
        _this.removeClass("input-error");
    }
    $(".g-description").text(_this.val());
});
</script>
<style>
.g-title {
    font-size: 18px;
    color: #1a0dab
}

.g-link {
    font-size: 14px;
    color: #006621
}
</style>

@endpush