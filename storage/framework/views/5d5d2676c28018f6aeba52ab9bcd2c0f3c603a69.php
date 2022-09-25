<div class="form-check form-switch">
    <input id="checkbox-switch-<?php echo e($title); ?>-<?php echo $v->id; ?>" <?php echo ($v->$title == 1) ? 'checked=""' : ''; ?>
        class="form-check-input publish-ajax" type="checkbox" data-module="<?php echo e($module); ?>" data-id="<?php echo $v->id; ?>"
        data-title="<?php echo e($title); ?>">
</div>
<?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/components/isModule.blade.php ENDPATH**/ ?>