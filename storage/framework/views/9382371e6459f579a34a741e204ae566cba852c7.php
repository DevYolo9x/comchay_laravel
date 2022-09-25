<?php if($menu_header->count() > 0): ?>
<nav class="bg-global my-5 hidden md:block">
    <div class="container mx-auto bg-a1080e px-4 md:px-0">
        <ul class="flex ul-nav-custom">
            <li class="h-10 leading-10 text-white relative">
                <a href="<?php echo e(url('')); ?>" class="uppercase px-2 lg:px-7 float-left font-semibold mt-[7px] hover:text-ff0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </a>
            </li>
            <?php $__currentLoopData = $menu_header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="h-10 leading-10 text-white relative group"><a href="<?php echo e(url($item->slug)); ?>" class="uppercase px-2 lg:px-7 float-left font-semibold hover:text-ff0" <?php echo !empty($item->target === '_blank') ? 'target="_blank"' : '' ?>> <?php echo e($item->title); ?></a>
                <?php if($item->children->count() > 0): ?>
                <ul class="hidden group-hover:block absolute left-0 top-10 w-[225px] z-50">
                    <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(url($item2->slug)); ?>" class="text-black hover:bg-global w-full px-5 float-left" <?php echo !empty($item2->target === '_blank') ? 'target="_blank"' : '' ?>><?php echo e($item2->title); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</nav>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/homepage/common/menuHeader.blade.php ENDPATH**/ ?>