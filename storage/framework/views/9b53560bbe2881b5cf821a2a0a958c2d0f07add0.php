<?php
$jsonInfo =  [];
$title = $keyword = $description = '';
if ($errors->any()) {
    $jsonInfo =  old('jsonInfo');
    $title =  old('title');
    $keyword =  old('keyword');
} else if ($action == 'update') {
    $title =  $detail->title;
    $keyword =  $detail->keyword;
    $description =  $detail->description;
    $jsonInfo =  json_decode($detail->jsonInfo, TRUE);
}
?>
<div>
    <label class="form-label text-base font-semibold">Tiêu đề</label>
    <?php echo Form::text('title', $title, ['class' => 'form-control w-full title']); ?>
</div>
<div class="mt-3 hidden">
    <label class="form-label text-base font-semibold">Mô tả</label>
    <div class="mt-2">
        <?php echo Form::textarea('description', $description, ['id' => 'ckDescription', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>
    </div>
</div>
<div class="mt-3 hidden">
    <label class="form-label text-base font-semibold">Keyword</label>
    <?php echo Form::text('keyword', $keyword, ['class' => 'form-control canonical', 'data-flag' => 0]); ?>

</div>
<div class="box p-5 mt-3 ">
    <div id="jsonInfo">
        <?php if(isset($jsonInfo['title']) && is_array($jsonInfo['title']) && count($jsonInfo['title'])): ?>
        <?php $__currentLoopData = $jsonInfo['title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mt-5 desc-more">
            <div class="relative">
                <div class="w-full">
                    <input type="text" name="jsonInfo[title][]" value="<?php echo $val ?>" class="form-control" placeholder="Tiêu đề">
                </div>
                <button class=" text-danger delete-attr absolute right-0 top-1/2" type="button" style="top: 50%;transform: translateY(-50%);width: 50px;height: 38px;display: flex;justify-content: center;align-items: center;"><i data-lucide="trash-2" class="w-4 h-4 mr-1"></i></button>
            </div>
            <?php echo Form::textarea('jsonInfo[description][]', $jsonInfo['description'][$key], ['id' => 'ckJsonInfo' . $key . '', 'class' => 'ck-editor', 'style' => 'height:60px;font-size:14px;line-height:18px;border:1px solid #ddd;padding:10px']); ?>


        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
    <div class="flex justify-between items-center mt-5">
        <a href="javascript:void(0)" class="add-jsonInfo btn btn-success text-white" onclick="return false;">Thêm mới
            +</a>
    </div>

</div>
<?php $__env->startPush('javascript'); ?>
<script>
    /*START: thêm lịch trình */
    $(document).on('click', '.add-jsonInfo', function() {
        let _this = $(this);
        render_jsonInfo();
    })

    function render_jsonInfo() {
        let html = '';
        var microtime = (Date.now() % 1000) / 1000;
        var editorId = 'editor_' + microtime;
        html = html + '<div class="mt-5 desc-more">'
        html = html + '<div class="relative">'
        html = html + '<div class="w-full">'
        html = html +
            '<input type="text" name="jsonInfo[title][]" class="form-control" placeholder="Tiêu đề" style="padding-right: 38px;">'
        html = html + '</div>'
        html = html +
            '<button class=" text-danger delete-attr absolute right-0 top-1/2" type="button" style="top: 50%;transform: translateY(-50%);width: 50px;height: 38px;display: flex;justify-content: center;align-items: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>'
        html = html + '</div>'
        html = html + '<div class="" >'
        html = html + '<textarea name="jsonInfo[description][]" class="form-control ck-editor" id="' + editorId +
            '" placeholder="Mô tả"></textarea>'
        html = html + '</div>'
        html = html + '</div>';
        $('#jsonInfo').append(html);
        CKEDITOR.replace(editorId, {
            height: 277
        });
    }
    $(document).on('click', '.delete-attr', function() {
        let _this = $(this);
        _this.parents('.desc-more').remove();
    });

    /*END: thêm lịch trình */
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/faq/backend/_faq.blade.php ENDPATH**/ ?>