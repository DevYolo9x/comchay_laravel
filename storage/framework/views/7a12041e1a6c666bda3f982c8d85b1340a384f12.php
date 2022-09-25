<div class="box p-5 mt-3 pt-3">
    <label class="form-label text-base font-semibold"><?php echo e($title); ?></label>
    <img src="<?php echo !empty($detail->$name) ? url($detail->$name) :  asset('images/404.png'); ?>"  id="mainThmb-<?php echo e($name); ?>" class="'w-full">
    <input type="text" value="<?php echo !empty($detail->$name) ? $detail->$name : ''; ?>" name="<?php echo e($name); ?>_old" class="w-full " id="<?php echo e($name); ?>_old">
    <div class="flex gap-2 mt-3">
        <div class="input-file-container w-1/2">
            <input class="hidden input-file" id="my-<?php echo e($name); ?>" onchange="mainThamUrl(this,'<?php echo e($name); ?>')" name="<?php echo e($name); ?>"
                type="file">
            <label class="btn btn-dark w-full mr-2 mb-2 input-file-trigger" for="my-<?php echo e($name); ?>">
               Upload file...
            </label>
        </div>
        <p class="file-return"></p>
        <div class="uploadCkfinder w-1/2">
            <label class="btn btn-dark w-full mr-2 mb-2 input-file-trigger" onclick="selectFileUpload('<?php echo e($name); ?>');return false;">
               Select file
            </label>
        </div>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<script>
/*lấy hình ảnh khi upload */
function mainThamUrl(input, image) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#mainThmb-' + image).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
/*lấy tên file khi upload ảnh xong*/
$('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $(this).parent().parent().find('.file-return').html('Select file image: ' + fileName);;
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/components/image.blade.php ENDPATH**/ ?>