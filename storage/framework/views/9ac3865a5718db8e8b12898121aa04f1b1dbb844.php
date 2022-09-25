<?php
$weekday = date("l");
$weekday = strtolower($weekday);
switch ($weekday) {
    case 'monday':
        $weekday = 'Thứ 2';
        break;
    case 'tuesday':
        $weekday = 'Thứ 3';
        break;
    case 'wednesday':
        $weekday = 'Thứ 4';
        break;
    case 'thursday':
        $weekday = 'Thứ 5';
        break;
    case 'friday':
        $weekday = 'Thứ 6';
        break;
    case 'saturday':
        $weekday = 'Thứ 7';
        break;
    default:
        $weekday = 'Chủ nhật';
        break;
}
?>
<?php
$menu_top = Cache::remember('menu_top', 60, function () {
    $menu_top_id = \App\Models\Menu::where('slug', 'menu-top')->pluck('id');
    $menu_top = \App\Models\MenuItem::where('menu_id', $menu_top_id)->where('parentid', 0)->orderBy('order')->where('alanguage', config('app.locale'))->with('children')->get();
    return $menu_top;
});
?>
<header>
    <div class="hidden md:block bg-gray-50">
        <div class="container mx-auto px-4 md:px-0">
            <ul class="flex items-center justify-end space-x-4 py-1">
                <?php if($menu_top->count() > 0): ?>
                <?php $__currentLoopData = $menu_top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(url($item->slug)); ?>" class="text-global font-bold hover:text-red-600"><?php echo e($item->title); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <li><a href="<?php echo e(route('customer.changepassword')); ?>" class="text-global font-bold hover:text-red-600">Đổi mật khẩu</a></li>
                <li><a href="<?php echo e(route('customer.logout')); ?>" class="text-global font-bold hover:text-red-600">Đăng xuất</a></li>
            </ul>
        </div>
    </div>
    <div class="container mx-auto px-4 md:px-0 hidden md:block">
        <div class="grid grid-cols-12 gap-4 items-center my-2">
            <div class="col-span-12 md:col-span-4">
                <a href="<?php echo e(url('')); ?>"><img class="mx-auto" src="<?php echo e(asset($fcSystem['homepage_logo'])); ?>" alt="<?php echo e($fcSystem['homepage_company']); ?>"></a>
            </div>
            <div class="col-span-12 md:col-span-4 ">
                <form action="<?php echo e(url('tim-kiem')); ?>" method="GET">
                    <div class="relative">
                        <input placeholder="Tìm kiếm" type="text" value="<?php echo e(request()->get('keyword')); ?>" class="bg-gray-200 rounded-full border w-full h-11 px-3 focus:outline-none  hover:outline-none" name="keyword">
                        <button class="absolute right-1 rounded-full bg-d61c1f h-9 w-10 text-global top-1/2 ovn_submit_search" style="transform: translateY(-50%);" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1/2 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-span-12 md:col-span-4 text-right">
                <div class="flex items-end justify-end">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9  text-global">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>" class="text-2xl font-bold text-global"><?php echo e($fcSystem['contact_hotline']); ?></a>
                </div>
                <div class="mt-1">
                    <?php echo e($weekday); ?>, ngày <?php echo e(date('d')); ?> tháng <?php echo e(date('m')); ?> năm <?php echo e(date('Y')); ?>

                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('homepage.common.menuHeader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="grid grid-cols-12 md:hidden py-2 items-center relative  px-1">
        <div class="col-span-2">
            <button id="primary-nav-button" type="button" class="mobile">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                    </svg>
                </span>
            </button>
        </div>
        <div class="col-span-8">
            <a href="<?php echo e(url('')); ?>"><img class="mx-auto" src="<?php echo e(asset($fcSystem['homepage_logo'])); ?>" alt="<?php echo e($fcSystem['homepage_company']); ?>"></a>
        </div>
        <div class="col-span-2 flex justify-end">
            <button type="button" class="handleSearchMobile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </div>
        <div class="searchMobile absolute w-full top-full z-50" style="display: none;">
            <form action="<?php echo e(url('tim-kiem')); ?>" method="GET">
                <div class="relative">
                    <input placeholder="Tìm kiếm " type="text" value="<?php echo e(request()->get('keyword')); ?>" class="bg-gray-200 rounded-full border w-full h-11 px-3 focus:outline-none  hover:outline-none" name="keyword">
                    <button class="absolute right-1 rounded-full bg-d61c1f h-9 w-10 text-global top-1/2 ovn_submit_search" style="transform: translateY(-50%);" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute top-1/2 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="transform: translateY(-50%);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </form>

        </div>
        <?php echo $__env->make('homepage.common.menuMobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</header><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/homepage/common/header.blade.php ENDPATH**/ ?>