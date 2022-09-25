<?php
$listType = json_decode($dataField->data, true);
$keyword = $dataField->keyword;
$keyword_convert = str_replace('-', '_', $keyword);
$content =  [];
if ($errors->any()) {
    $content = old('config_colums_json_' . $keyword_convert);
} else {
    if (!empty($detail)) {
        $ConfigPostmeta = \App\Models\ConfigPostmeta::select('meta_value')->where(['module_id' => $detail->id, 'module' => $module, 'config_colums_id' => $dataField->id])->first();
        if ($ConfigPostmeta) {
            $content = json_decode($ConfigPostmeta->meta_value, TRUE);
        }
       
    }
}
?>
<div class="mt-3 box p-5">
    <label class="form-label text-base font-semibold"><?php echo e($dataField->title); ?></label>
    <div id="schedule-<?php echo $keyword_convert ?>">
        <?php if(isset($content['title']) && is_array($content['title']) &&
        count($content['title'])): ?>
        <?php $__currentLoopData = $content['title']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="relative mt-5 desc-more-<?php echo $keyword_convert ?>">
            <div class="">
                <?php if (!empty($listType)) { ?>
                    <?php if (!empty($listType['type'])) { ?>
                        <?php foreach ($listType['type'] as $key => $item) { ?>
                            <?php if ($item == 'image') { ?>
                                <div class="mt-3">
                                    <label class="form-label text-base font-semibold w-full"><?php echo $listType['title'][$key] ?></label>
                                    <div class="flex items-center space-x-3">
                                        <div class="avatar" style="cursor: pointer;flex:none">
                                            <img src="<?php echo !empty($content[$listType['keyword'][$key]][$k]) ? asset($content[$listType['keyword'][$key]][$k]) : asset('images/404.png') ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">
                                        </div>
                                        <input type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" value="<?php echo !empty($content[$listType['keyword'][$key]][$k])?$content[$listType['keyword'][$key]][$k]:'' ?>" class="form-control " placeholder="Đường dẫn của <?php echo $listType['title'][$key] ?>" onclick="openKCFinderAddItem($(this))" autocomplete="off">
                                    </div>
                                </div>
                            <?php } else if ($item == 'input') { ?>
                                <input type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" value="<?php echo !empty($content[$listType['keyword'][$key]][$k])?$content[$listType['keyword'][$key]][$k]:'' ?>" class="form-control mt-3" placeholder="<?php echo $listType['keyword'][$key] ?>">
                            <?php } else if ($item == 'textarea') { ?>
                                <textarea type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" class="form-control mt-3" placeholder="<?php echo $listType['keyword'][$key] ?>"><?php echo !empty($content[$listType['keyword'][$key]][$k])?$content[$listType['keyword'][$key]][$k]:'' ?></textarea>
                            <?php } else if ($item == 'editor') { ?>
                                <div class="mt-3">
                                    <textarea type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" id="editorId<?php echo $k ?>" class="ck-editor form-control mt-3"><<?php echo !empty($content[$listType['keyword'][$key]][$k])?$content[$listType['keyword'][$key]][$k]:'' ?></textarea>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <button class="btn btn-danger text-white delete-attr-<?php echo $keyword_convert ?> absolute right-0 top-1/2" type="button" style="top: 50%;transform: translateY(-50%);width: 50px;height: 38px;display: flex;justify-content: center;align-items: center;"><i data-lucide="trash-2" class="w-4 h-4 "></i></button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
    <div class="flex justify-between items-center mt-5">
        <a href="javascript:void(0)" class="add-schedule-<?php echo $keyword_convert ?> btn btn-success text-white" onclick="return false;">Thêm mới +</a>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<script>
    $(document).on('click', '.add-schedule-<?php echo $keyword_convert ?>', function() {
        let _this = $(this);
        render_schedule_<?php echo $keyword_convert ?>();
    })

    function render_schedule_<?php echo $keyword_convert ?>() {
        let html = '';
        var microtime = (Date.now() % 1000) / 1000;
        var editorId = 'editor_' + microtime;
        html = html + '<div class="relative mt-5 desc-more-<?php echo $keyword_convert ?>">'
        html = html + '<div class="">'
        <?php if (!empty($listType)) { ?>
            <?php if (!empty($listType['type'])) { ?>
                <?php foreach ($listType['type'] as $key => $item) { ?>
                    <?php if ($item == 'image') { ?>
                        html = html + '<div class="mt-3">'
                        html = html + '<label class="form-label text-base font-semibold w-full"><?php echo $listType['title'][$key] ?></label>'
                        html = html + '<div class="flex items-center space-x-3">'
                        html = html + '<div class="avatar" style="cursor: pointer;flex:none">'
                        html = html + '<img src="<?php echo asset('images/404.png') ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">'
                        html = html + '</div>'
                        html = html + ' <input type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" value="" class="form-control " placeholder="Đường dẫn của <?php echo $listType['title'][$key] ?>" onclick="openKCFinderAddItem($(this))" autocomplete="off">'
                        html = html + '</div>'
                        html = html + '</div>'
                    <?php } else if ($item == 'input') { ?>
                        html = html + '<input type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" class="form-control mt-3" placeholder="<?php echo $listType['title'][$key] ?>">'
                    <?php } else if ($item == 'textarea') { ?>
                        html = html + '<textarea type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" class="form-control mt-3" placeholder="<?php echo $listType['title'][$key] ?>"></textarea>'
                    <?php } else if ($item == 'editor') { ?>
                        html = html + '<div class="mt-3">'
                        html = html + '<textarea type="text" name="config_colums_json_<?php echo $keyword_convert ?>[<?php echo $listType['keyword'][$key] ?>][]" id="' + editorId + '" class="ck-editor form-control mt-3"></textarea>'
                        html = html + '</div>'

                    <?php } ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        html = html + '</div>'
        html = html + '<button class="btn btn-danger text-white delete-attr-<?php echo $keyword_convert ?> absolute right-0 top-1/2" type="button" style="top: 50%;transform: translateY(-50%);width: 50px;height: 38px;display: flex;justify-content: center;align-items: center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 "><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>'
        html = html + '</div>'
        $('#schedule-<?php echo $keyword_convert ?>').append(html);
        CKEDITOR.replace(editorId, {
            height: 277
        });
    }
    $(document).on('click', '.delete-attr-<?php echo $keyword_convert ?>', function() {
        let _this = $(this);
        _this.parents('.desc-more-<?php echo $keyword_convert ?>').remove();
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/components/field/json.blade.php ENDPATH**/ ?>