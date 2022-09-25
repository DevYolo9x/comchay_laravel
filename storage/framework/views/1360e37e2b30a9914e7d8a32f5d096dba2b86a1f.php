<nav id="primary-nav" class="dropdown cf" style="display: none">

    <ul class="dropdown menu">
        <?php if($menu_header->count() > 0): ?>
        <?php $__currentLoopData = $menu_header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(url($item->slug)); ?>" <?php echo !empty($item->target === '_blank') ? 'target="_blank"' : '' ?>><?php echo e($item->title); ?></a>
            <?php if($item->children->count() > 0): ?>
            <ul class="sub-menu">
                <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(url($item2->slug)); ?>" <?php echo !empty($item2->target === '_blank') ? 'target="_blank"' : '' ?>><?php echo e($item2->title); ?></a>
                    <?php if($item2->children->count() > 0): ?>
                    <ul class="sub-menu">
                        <?php $__currentLoopData = $item2->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(url($item3->slug)); ?>" <?php echo !empty($item3->target === '_blank') ? 'target="_blank"' : '' ?>><?php echo e($item3->title); ?></a>
                            <?php if($item3->children->count() > 0): ?>
                            <ul class="sub-menu">
                                <?php $__currentLoopData = $item3->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item4): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li> <a href="<?php echo e(url($item4->slug)); ?>" <?php echo !empty($item4->target === '_blank') ? 'target="_blank"' : '' ?>><?php echo e($item4->title); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if($menu_top->count() > 0): ?>
        <?php $__currentLoopData = $menu_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(url($item->slug)); ?>"><?php echo e($item->title); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <li><a href="<?php echo e(route('customer.changepassword')); ?>">Đổi mật khẩu</a></li>
        <li><a href="<?php echo e(route('customer.dashboard')); ?>"><?php echo e(Auth::user()->name); ?></a></li>
        <li><a href="<?php echo e(route('customer.logout')); ?>">Đăng xuất</a></li>
    </ul>

</nav><!-- / #primary-nav --><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/homepage/common/menuMobile.blade.php ENDPATH**/ ?>