<?php $__env->startSection('title'); ?>
<title>Danh sách thành viên</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
    $array = array(
        [
            "title" => "Danh sách thành viên",
            "src" => route('users.index'),
        ],
        [
            "title" => "Danh sách",
            "src" => 'javascript:void(0)',
        ]
    );
    echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content">
    <h1 class=" text-lg font-medium mt-10">
        Danh sách thành viên
    </h1>
    <?php echo $__env->make('components.alert-success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class=" col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-between">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_create')): ?>
            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary shadow-md mr-2">Thêm mới</a>
            <?php endif; ?>
        </div>
        <!-- BEGIN: Data List -->
        <div class=" col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">STT</th>
                        <th class="whitespace-nowrap">Ảnh đại diện</th>
                        <th class="whitespace-nowrap">Tên thành viên</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="whitespace-nowrap">Nhóm thành viên</th>
                        <th class="whitespace-nowrap">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="odd " id="post-<?php echo $v->id; ?>">
                        <td>
                            <?php echo e($data->firstItem()+$loop->index); ?>

                        </td>
                        <td>
                            <div class="w-10 h-10 image-fit zoom-in -ml-5">
                                <img alt="<?php echo e($v->name); ?>" class=" rounded-full"
                                    src="<?php echo !empty($v->image)?asset($v->image):asset('images/404.png')?>">
                            </div>
                        </td>
                        <td>
                            <?php echo e($v->name); ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_edit')): ?>
                            <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">
                                <a data-url="<?php echo e(route('users.reset-password',['id'=>$v->id])); ?>"
                                    href="javascript:void(0)" class="p-reset text-warning"
                                    data-userid="<?php echo e($v->id); ?>">RESET mật khẩu</a>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo e($v->email); ?>

                        </td>
                        <td>
                            <?php $__currentLoopData = $v->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('roles.edit',['id'=>$v1->id])); ?>"
                                class="btn btn-warning btn-sm"><?php echo e($v1->title); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_edit')): ?>
                                <a class="flex items-center mr-3" href="<?php echo e(route('users.edit',['id'=>$v->id])); ?>">
                                    <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                    Edit
                                </a>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_destroy')): ?>
                                <a class="flex items-center text-danger p-destroy" href="javascript:;"
                                    data-url="<?php echo e(route('users.destroy',['id'=>$v->id])); ?>" data-id="<?php echo e($v->id); ?>">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class=" col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
            <?php echo e($data->links()); ?>

        </div>
        <!-- END: Pagination -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script src="<?php echo e(asset('backend/library/users.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/user/backend/user/index.blade.php ENDPATH**/ ?>