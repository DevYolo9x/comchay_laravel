<?php $__env->startSection('content'); ?>
<main>
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                <?php echo $__env->make('homepage.common.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-span-12 lg:col-span-9 space-y-6 mt-5 md:mt-0 order-0 lg:order-1">
                <?php if(!$blogs->isEmpty()): ?>
                <div class="grid lg:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="md:col-span-1">
                        <div class="flex justify-between items-center border-b border-global">
                            <h2 class="h2-category h2-main text-global font-bold text-lg uppercase relative pb-1">
                                <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>" class="hover:text-red-600"><?php echo e($item->title); ?></a>
                            </h2>
                            <?php if(count($item->children) > 0): ?>
                            <ul class="space-x-1 hidden md:flex">
                                <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('routerURL',['slug' => $value->slug])); ?>" class="hover:text-red-600"><?php echo e($value->title); ?> </a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>

                        </div>
                        <div class="mt-3">
                            <?php if(count($item->listArticleHome) > 0): ?>
                            <?php $__currentLoopData = $item->listArticleHome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($k==0): ?>
                            <div class="md:flex a-custom">
                                <div class="w-full md:w-1/2 mb-2 md:mb-0 overflow-hidden  mr-[15px]">
                                    <a href="<?php echo e(route('routerURL',['slug' => $value->slug])); ?>" class="overflow-hidden">
                                        <img src="<?php echo e(asset($value->image)); ?>" class="h-[180px] img-custom object-cover w-full" alt="<?php echo e($value->title); ?>">
                                    </a>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col justify-between h-full">
                                        <div class="mb-2 md:mb-0">
                                            <h3 class="line-clamp line-clamp-2"><a href="<?php echo e(route('routerURL',['slug' =>  $value->slug])); ?>" class="text-base text-global font-bold"><?php echo e($value->title); ?></a></h3>
                                            <div class="mt-2 line-clamp line-clamp-3">
                                                <?php echo strip_tags($value->description) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="<?php echo e(route('routerURL',['slug' => $value->slug])); ?>" class="bg-global px-[23px] text-white h-[33px] leading-[33px] float-left hover:bg-red-500">Đọc
                                                tiếp</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="grid grid-cols-3 gap-[10px] mt-3">
                                <?php $__currentLoopData = $item->listArticleHome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($k>0): ?>
                                <div class="col-span-3 md:col-span-1 a-custom mb-[10px] md:mb-0">
                                    <div class="overflow-hidden mb-1 md:mb-3">
                                        <a href="<?php echo e(route('routerURL',['slug' => $value->slug])); ?>"><img src="<?php echo e(asset($value->image)); ?>" class="img-custom h-[250px] md:h-[157px] lg:h-[110px] object-cover w-full" alt="<?php echo e($value->title); ?>"></a>
                                    </div>
                                    <h3 class="line-clamp line-clamp-2"><a href="<?php echo e(route('routerURL',['slug' => $value->slug])); ?>" class="text-global line-custom-2 font-semibold"><?php echo e($value->title); ?></a></h3>
                                    <div class="mt-1 line-clamp line-clamp-3">
                                        <?php echo strip_tags($value->description) ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>


                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('javascript'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/homepage/home/index.blade.php ENDPATH**/ ?>