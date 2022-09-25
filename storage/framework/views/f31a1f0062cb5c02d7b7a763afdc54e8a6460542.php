<div class="form-check form-switch">
    <input <?php echo ($v->$title == 0) ? 'checked=""' : ''; ?> class="form-check-input publish-ajax" type="checkbox"
        data-module="<?php echo e($module); ?>" data-id="<?php echo $v->id; ?>" data-title="<?php echo e($title); ?>"
        id="<?php echo e($title); ?>-<?php echo $v->id; ?>">
</div><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/components/publishTable.blade.php ENDPATH**/ ?>