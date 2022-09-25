
<?php $__env->startSection('content'); ?>
<main>
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                <?php echo $__env->make('homepage.common.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-span-12 lg:col-span-9 space-y-6 mt-5 md:mt-0 order-0 lg:order-1">
                <div>
                    <div class="flex justify-between items-center border-b border-global">
                        <h2 class="h2-category h2-main text-global font-bold text-lg  tracking-tighter relative pb-1"><span class="uppercase"> GỬI CHỦ ĐỀ THẢO LUẬN MỚI</span></h2>
                    </div>
                    <form class="mt-3 space-y-3" method="post" action="">
                        <?php echo csrf_field(); ?>
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



                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Email</label>
                            <input type="text" name="" class="flex-1 form-control block w-full py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding rounded transition ease-in-out m-0 focus:outline-none" value="<?php echo e(Auth::guard('customer')->user()->email); ?>" disabled />
                        </div>
                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Mật khẩu cũ</label>
                            <input type="password" name="current_password" class="flex-1 form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="<?php echo e(old('title')); ?>" placeholder="" />
                        </div>
                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Mật khẩu mới</label>
                            <input type="password" name="old_password" class="flex-1 form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="<?php echo e(old('title')); ?>" placeholder="" />
                        </div>
                        <div class="flex items-center flex-col md:flex-row">
                            <label class="w-full md:w-[160px] font-bold">Nhập lại mật khẩu mới</label>
                            <input type="password" name="new_password" class="flex-1 form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="<?php echo e(old('title')); ?>" placeholder="" />
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="submit" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                <span>Đổi mật khẩu</span>
                            </button>
                            <button type="reset" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                <span>Nhập lại</span>
                            </button>
                        </div>
                    </form>
                    <div class="mt-3">
                        <?php echo $fcSystem['title_sale'] ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>
</main>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('javascript'); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/customer/frontend/manager/changepassword.blade.php ENDPATH**/ ?>