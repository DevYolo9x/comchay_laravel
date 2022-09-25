<?php $__env->startSection('title'); ?>
<title>Cập nhập</title>
<?php $__env->stopSection(); ?>
<!--START: breadcrumb -->
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách",
        "src" => route('faqs.index'),
    ],
    [
        "title" => "Thêm mới",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<!--END: breadcrumb -->

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class=" flex items-center mt-8">
        <h1 class="text-lg font-medium mr-auto">
            Cập nhập
        </h1>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" role="form" action="<?php echo e(route('faqs.update',['id' => $detail->id])); ?>" method="post" enctype="multipart/form-data">
        <div class=" col-span-12 lg:col-span-8">
            <!-- BEGIN: Form Layout -->
            <div class=" box p-5">
                <?php echo $__env->make('components.alert-error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo csrf_field(); ?>
                <?php echo $__env->make('faq.backend._faq',['action' => 'update'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="mt-3 hidden">
                    <?php echo $__env->make('components.dropzone',['action' => 'update'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="btn btn-primary w-24">Cập nhập</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
        <div class=" col-span-12 lg:col-span-4">
            <div class=" box p-5">
                <label class="form-label text-base font-semibold">Trang</label>
                <div class="mt-2">
                    <?php echo Form::select('page', config('page'), $detail->page, ['class' => 'form-control tom-select tom-select-custom']); ?>
                </div>
            </div>
            <?php echo $__env->make('components.image',['action' => 'update','name' => 'image','title'=> 'Ảnh đại diện'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="hidden">
                <?php echo $__env->make('components.image',['action' => 'update','name' => 'banner','title'=> 'Ảnh mẫu'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <input type="hidden" value="<?php echo e($detail->banner); ?>" name="banner_old">
                <div class="box p-5 mt-3">
                    <label class="form-label text-base font-semibold">File CATALOGUE</label>
                    <div class="mt-2">
                        <?php echo Form::text('file', $detail->file, ['class' => 'form-control', 'onclick' => "openKCFinder(this, 'files')"]); ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/faq/backend/edit.blade.php ENDPATH**/ ?>