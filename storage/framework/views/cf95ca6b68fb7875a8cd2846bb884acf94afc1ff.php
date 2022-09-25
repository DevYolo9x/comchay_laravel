<?php
$menu_footer = Cache::remember('menu_footer', 60, function () {
    $menu_footer_id = \App\Models\Menu::where('slug', 'menu-footer')->pluck('id');
    $menu_footer = \App\Models\MenuItem::where('menu_id', $menu_footer_id)->where('parentid', 0)->orderBy('order')->where('alanguage', config('app.locale'))->with('children')->get();
    return $menu_footer;
});
?>
<?php if($menu_footer->count() > 0): ?>
<div class="container px-1 md:px-0 mx-auto mb-2 mt-10">
    <div>
        <ul class="flex flex-wrap space-x-6 gap-2">
            <?php $__currentLoopData = $menu_footer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="<?php echo e(url($item->slug)); ?>" <?php echo !empty($item->target === '_blank') ? 'target="_blank"' : '' ?> class="uppercase font-bold hover:text-c8252c"><?php echo e($item->title); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>
<?php endif; ?><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/homepage/common/menuFooter.blade.php ENDPATH**/ ?>