<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script>
    var BASE_URL = '<?php echo url(''); ?>/';
    var BASE_URL_AJAX = '<?php echo url(''); ?>/<?php echo env('APP_ADMIN')?>/';
    </script>
    <?php echo $__env->yieldContent('title'); ?>
    <!-- head-->
    <?php echo $__env->make('dashboard.common.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="main">

    <div class="flex">
        <!-- sidebar -->
        <?php echo $__env->make('dashboard.common.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--right-side -->
        <aside class="wrapper">
            <!-- header-->
            <?php echo $__env->make('dashboard.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- Main content -->
            <?php echo $__env->yieldContent('content'); ?>
            <!-- /.content -->
        </aside>
    </div>
    <!-- footer -->
    <?php echo $__env->make('dashboard.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('javascript'); ?>
    <style>
    .no-print {
        top: 50% !important;
    }
    </style>
</body>

</html><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/dashboard/layout/dashboard.blade.php ENDPATH**/ ?>