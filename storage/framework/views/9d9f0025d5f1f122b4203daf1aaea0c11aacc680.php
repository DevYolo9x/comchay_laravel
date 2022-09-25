<div id="rowthongbao">
    <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700-700 px-4 py-3 rounded relative my-3" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">
            <?php echo e(session('success')); ?>

        </span>
    </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
        <strong class="font-bold">ERROR!</strong>
        <span class="block sm:inline">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($error); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </span>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-3" role="alert">
        <strong class="font-bold">ERROR!</strong>
        <span class="block sm:inline">
            <?php echo e(session('error')); ?>

        </span>
    </div>
    <?php endif; ?>
</div><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/briefing/frontend/alert.blade.php ENDPATH**/ ?>