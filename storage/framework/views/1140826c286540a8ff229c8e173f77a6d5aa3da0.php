
<?php $__env->startSection('content'); ?>
<section class="h-screen">
    <div class="px-6 h-full text-gray-800">
        <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
            <div class="grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0">
                <img src="<?php echo e(asset('frontend/images/draw2.webp')); ?>" class="w-full" alt="Sample image" />
            </div>
            <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
                <form action="<?php echo e(route('customer.login-store')); ?>" method="POST" id="form-auth">
                    <?php echo csrf_field(); ?>
                    <div class="flex flex-row items-center justify-center lg:justify-start">
                        <p class="text-lg mb-0 mr-4 font-bold">Đăng nhập hệ thống</p>
                    </div>
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
                    <!-- Email input -->
                    <div class="my-3">
                        <input type="text" name="email" class="form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="<?php echo e(old('email')); ?>" placeholder="Email" />
                    </div>
                    <!-- Password input -->
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control block w-full px-4 py-2 text-sm font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" value="<?php echo e(old('password')); ?>" placeholder="Mật khẩu" />
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <div class="form-group form-check">
                            <input type="checkbox" name="remember" value="1" class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" id="exampleCheck2">
                            <label class="form-check-label inline-block text-gray-800" for="exampleCheck2">Ghi nhớ đăng nhập</label>
                        </div>
                        <a href="<?php echo e(route('customer.reset-password')); ?>" class="text-gray-800">Quên mật khẩu?</a>
                    </div>
                    <div class="text-center lg:text-left">
                        <button type="submit" class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Đăng nhập
                        </button>
                        <?php /*<p class="text-sm font-semibold mt-2 pt-1 mb-0">
                            Bạn chưa có tài khoản?
                            <a href="{{route('customer.register')}}" class="text-red-600 hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out">Đăng ký</a>
                        </p>*/ ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<style>
    .form-check-input:checked[type=checkbox] {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M6 10l3 3l6-6'/%3e%3c/svg%3e");
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/customer/frontend/auth/login.blade.php ENDPATH**/ ?>