
<?php $__env->startSection('content'); ?>
<main>
    <div class="container px-1 md:px-0 mx-auto">
        <h1 class="hidden"><?php echo e($detail->title); ?></h1>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                <?php echo $__env->make('homepage.common.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-span-12 lg:col-span-9 mt-5 md:mt-0 order-0 lg:order-1">
                <div class="breadcrumb py-[10px]">
                    <ul class="flex flex-wrap">
                        <li><a href="<?php echo e(url('')); ?>"><?php echo e($fcSystem['title_7']); ?></a></li>
                        <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><span class="text-gray-500 mx-2">/</span></li>
                        <li><a href="<?php echo route('routerURL', ['slug' => $v->slug]) ?>" class="text-gray-500 hover:text-Orangefc5"><?php echo e($v->title); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php echo $__env->make('briefing.frontend.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="mt-3">
                    <?php if(!$data->isEmpty()): ?>
                    <div class="grid grid-cols-12 space-x-2 md:space-x-0 md:gap-4 bg-global-2 item-center text-xs md:text-sm">
                        <div class="col-span-6 text-white pl-[25px] py-2 ">
                            Tiêu đề
                        </div>
                        <div class="col-span-3 text-white px-1 py-2">
                            Ngày đăng
                        </div>
                        <div class="col-span-3 text-white px-1 py-2">
                            Thảo luận cuối
                        </div>
                    </div>
                    <div class="box-comment-home">
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $comment = commentCategory($item->id);
                        ?>
                        <div class="grid grid-cols-12 space-x-2 md:space-x-0 md:gap-4 items-center  text-xs md:text-sm group">
                            <div class="col-span-6">
                                <div class="flex items-center">
                                    <img src="<?php echo asset('frontend/images/topic_open.gif') ?>" alt="<?php echo e($item->title); ?>">
                                    <a href="<?php echo e(route('chude.index',['slug' => slug($item->title),'id' => $item->id])); ?>" class=" text-black px-1 py-2 md:p-2 font-medium flex items-center  text-xs md:text-sm group-hover:text-red-600">
                                        <?php echo e($item->title); ?>

                                        <span class="flex bg-gray-100 px-2 py-1 justify-center items-center ml-1 md:ml-5">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                            </svg>
                                            <span><?php echo e(!empty($comment['count'])?$comment['count']:'0'); ?></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-span-3 text-black px-1 py-2 group-hover:text-red-600">
                                <span><?php echo e($item->created_at); ?></span><br>
                                <?php if($item->type == 'admin'): ?>
                                <strong>Bởi: <?php echo e($item->user->name); ?></strong>
                                <?php else: ?>
                                <strong>Bởi: <?php echo e($item->customer->name); ?></strong>
                                <?php endif; ?>
                            </div>
                            <div class="col-span-3 text-black px-1 py-2 group-hover:text-red-600">
                                <?php if(!empty($comment['cmtLast'])): ?>
                                <span><?php echo e($comment['cmtLast']['created_at']); ?></span><br>
                                <strong>Bởi: <?php echo e($comment['cmtLast']['fullname']); ?></strong>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>

                    <div class="flex justify-end mt-3">
                        <a href="<?php echo e(route('chude.create',['id' => $detail->id])); ?>" class="bg-global text-white flex items-center  px-7 py-3  font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span>Chủ đề mới</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/briefing/frontend/category/index.blade.php ENDPATH**/ ?>