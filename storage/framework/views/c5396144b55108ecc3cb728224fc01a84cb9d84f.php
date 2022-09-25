<?php
/*$field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get(); */
?>
<?php if(!$field->isEmpty()): ?>
<?php $__currentLoopData = $field; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->make('components.field.'.$item->type,['dataField' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/components/field/index.blade.php ENDPATH**/ ?>