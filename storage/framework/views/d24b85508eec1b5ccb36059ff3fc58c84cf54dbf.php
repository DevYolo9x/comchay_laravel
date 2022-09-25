 <?php
    $danh_muc_chinh_id = \App\Models\Menu::where('slug', 'danh-muc-chinh')->pluck('id');
    $danh_muc_chinh = \App\Models\MenuItem::where('menu_id', $danh_muc_chinh_id)->where('parentid', 0)->orderBy('order')->where('alanguage', config('app.locale'))->with('children')->get();
    $asideBanner = \App\Models\CategorySlide::select('title', 'id')->where(['alanguage' => config('app.locale'), 'keyword' => 'aside-banner'])->with('slides')->first();
    $tinkinhte = \App\Models\CategoryArticle::select('id', 'title', 'slug')->where(['alanguage' => config('app.locale'), 'isaside' => 1, 'publish' => 0])->with([
        'listArticle' => function ($q) {
            $q
                ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
                ->where(['articles.publish' => 0])
                ->limit(5)
                ->orderBy('articles.order', 'asc')
                ->orderBy('articles.id', 'desc')->get();
        }
    ])->first();
    ?>
 <?php if($danh_muc_chinh->count() > 0): ?>
 <aside class="float-left w-full">
     <h2 class="h2-category text-global font-bold text-lg uppercase -tracking-tighter relative pb-1">Danh mục chính</h2>
     <ul class="mt-3 w-full float-left">
         <?php $__currentLoopData = $danh_muc_chinh; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <li class="relative w-full float-left mb-2">
             <a <?php echo !empty($item->target === '_blank') ? 'target="_blank"' : '' ?> href="<?php echo e(url($item->slug)); ?>" class="w-full float-left border border-gray-100 rounded-sm p-2  hover:text-red-700 font-medium"><?php echo e($item->title); ?></a>
             <?php if($item->children->count() > 0): ?>
             <span class="handleSubmenu absolute right-0 top-0 flex items-center h-[41px] w-10 justify-center">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 cursor-pointer">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                 </svg>
             </span>
             <ul class="sub-menu w-full float-left pl-5 mt-3" style="display: none">
                 <?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <li class="relative w-full float-left mb-2"><a <?php echo !empty($item2->target === '_blank') ? 'target="_blank"' : '' ?> href="<?php echo e(url($item2->slug)); ?>" class="w-full float-left border border-gray-100 rounded-sm p-2 hover:text-red-700 font-medium"><?php echo e($item2->title); ?></a></li>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </ul>
             <?php endif; ?>
         </li>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </ul>
 </aside>
 <?php endif; ?>
 <div class="clear-both"></div>
 <?php if($tinkinhte): ?>
 <aside class="mt-6">
     <div class="border border-global p-4">
         <h2 class="text-lg font-medium text-center w-full mb-2 text-global"><?php echo e($tinkinhte->title); ?></h2>
         <ul>
             <?php $__currentLoopData = $tinkinhte->listArticle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <li class="border-t py-2 border-global">
                 <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>" class="text-global"><?php echo e($item->title); ?></a>
             </li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </ul>
     </div>
 </aside>
 <?php endif; ?>
 <?php if($asideBanner): ?>
 <?php if(count($asideBanner->slides) > 0): ?>
 <?php $__currentLoopData = $asideBanner->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <aside class="mt-6">
     <a href="<?php echo e(url($item->link)); ?>" target="_blank"><img class="w-full" src="<?php echo e(asset($item->src)); ?>" alt="banner"></a>
 </aside>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?>
 <?php endif; ?><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/homepage/common/aside.blade.php ENDPATH**/ ?>