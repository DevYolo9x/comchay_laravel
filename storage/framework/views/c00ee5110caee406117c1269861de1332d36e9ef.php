<?php echo $__env->make('homepage.common.menuFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<footer class=" bg-gray-100 py-10">
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-[30px]">
            <div class="col-span-12 md:col-span-2 lg:col-span-2">
                <a href="<?php echo e(url('')); ?>">
                    <img class="mx-auto" src="<?php echo e(asset($fcSystem['homepage_logo_footer'])); ?>" alt="<?php echo e($fcSystem['homepage_company']); ?>" />
                </a>
            </div>
            <div class="col-span-12 md:col-span-6 lg:col-span-4">
                <?php echo $fcSystem['homepage_footer'] ?>
            </div>
            <div class="col-span-12 md:col-span-4 lg:col-span-3">
                <?php echo $fcSystem['homepage_ads'] ?>
            </div>
            <div class="col-span-12 md:col-span-12 lg:col-span-3 text-center lg:text-right">
                <p><?php echo e($fcSystem['title_0']); ?></p>
                <ul class="flex space-x-2 mt-5 justify-center lg:justify-end">
                    <li>
                        <a target="_blank" href="<?php echo e($fcSystem['social_facebook']); ?>">
                            <img alt="facebook" class="w-[27px]" src="<?php echo e(asset('frontend/images/facebook-black.svg')); ?>">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="<?php echo e($fcSystem['social_youtube']); ?>">
                            <img alt="youtube" class="w-[27px]" src="<?php echo e(asset('frontend/images/youtube-black.svg')); ?>">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="<?php echo e($fcSystem['social_tiktok']); ?>">
                            <img alt="tiktok" class="w-[27px]" src="<?php echo e(asset('frontend/images/tiktok-black.svg')); ?>">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="<?php echo e($fcSystem['social_twitter']); ?>">
                            <img alt="twitter" class="w-[27px]" src="<?php echo e(asset('frontend/images/twitter-black.svg')); ?>">
                        </a>
                    </li>
                    <li>
                        <a target="_blank" href="http://zalo.me/<?php echo e($fcSystem['social_zalo']); ?>">
                            <img alt="zalo" class="w-[27px]" src="<?php echo e(asset('frontend/images/zalo-black.svg')); ?>">
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</footer>
<div id="scrollUp" class="hover:bg-[#333] hover:text-white ">
    <img src="<?php echo e(asset('frontend/images/top.png')); ?>" alt="top">
</div><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/homepage/common/footer.blade.php ENDPATH**/ ?>