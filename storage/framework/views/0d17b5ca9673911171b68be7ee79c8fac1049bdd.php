<?php $__env->startSection('content'); ?>


<?php if($slideHome->count() > 0): ?>
<div class="banner">
    <div id="slider-home" class="owl-carousel">
        <?php $__currentLoopData = $slideHome[0]->slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item relative">
            <a href="<?php echo e(url($val->link)); ?>"><img src="<?php echo e(asset($val->src)); ?>" alt="<?php echo e($val->title); ?>" class="inline-block"></a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>



<div id="main" class="sitemap">
    <!-- start: box 1 -->
    <section class="category-home pt-5 md:pt-20 wow fadeInUp hidden lg:block">
        <div class="container mx-auto px-3 ">
            <div class="section-title">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium"> <?php echo e(showField($page->postmeta, 'config_colums_input_title_group1')); ?></h2>
            </div>
            <div class="relative m-auto mt-28 content-category" style="width: 960px;">
                <div class="item-primary text-center">
                    <div class="img">
                        <a href=""><img src="<?php echo e(asset('frontend/images/sp4.jpg')); ?>" alt="" style="width: 390px; height: 390px;" class="border-2 border-white rounded-full object-cover inline-block"></a>
                    </div>
                </div>
                <div class="absolute -top-28 -right-5 -mt-12">
                    <div class="text rounded-full  border border-brown border-dashed flex items-center -ml-20 relative" style="width: 160px; height: 160px; top:87px; left: -47px;">
                        <span class="w-[30px] h-[30px] inline-block rounded-full text-white bg-red-700 absolute text-center top-[-17px] left-1/2 -translate-x-1/2 leading-[30px]">1</span>
                        <h3 class="text-f20 font-bold italic px-4 text-brown leading-[22px] text-center"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="img"><a href=""><img src="<?php echo e(asset('frontend/images/sp5.jpg')); ?>" alt="" class="rounded-full object-cover inline-block border-2 border-white" style="width: 177px; height: 177px;"></a></div>
                </div>
                <div class="absolute  " style="bottom:-157px; right:10px">
                    <div class="text rounded-full  border border-brown border-dashed flex items-center -ml-20 relative" style="width: 160px; height: 160px; float: right;">
                        <span class="w-[30px] h-[30px] inline-block rounded-full text-white bg-red-700 absolute text-center top-[-17px] left-1/2 -translate-x-1/2 leading-[30px]">2</span>
                        <h3 class="text-f20 font-bold italic px-4 text-brown leading-[22px] text-center"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="img relative" style="right:69px ; top:-34px"><a href=""><img src="<?php echo e(asset('frontend/images/sp6.jpg')); ?>" alt="" class="rounded-full object-cover inline-block border-2 border-white" style="width: 177px; height: 177px;"></a></div>
                </div>
                <div class="absolute  " style="bottom:-222px; left: 60%; transform: translateX(-50%);">
                    <div class="flex flex-wrap justify-center">
                        <div class="text rounded-full  border border-brown border-dashed flex items-center -ml-20 relative" style="width: 160px; height: 160px; float: right;">
                            <span class="w-[30px] h-[30px] inline-block rounded-full text-white bg-red-700 absolute text-center top-[-17px] left-1/2 -translate-x-1/2 leading-[30px]">3</span>
                            <h3 class="text-f20 font-bold italic px-4 text-brown leading-[22px] text-center"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                        </div>
                        <div class="img relative" style="    top: -19px;
          left: -14px;"><a href=""><img src="<?php echo e(asset('frontend/images/sp7.jpg')); ?>" alt="" class="rounded-full object-cover inline-block border-2 border-white" style="width: 150px; height: 150px;"></a></div>
                    </div>
                </div>
                <div class="absolute  " style="bottom:-157px; left:10px">
                    <div class="text rounded-full  border border-brown border-dashed flex items-center -ml-20 relative" style="width: 160px; height: 160px; float: right;">
                        <span class="w-[30px] h-[30px] inline-block rounded-full text-white bg-red-700 absolute text-center top-[-17px] left-1/2 -translate-x-1/2 leading-[30px]">4</span>
                        <h3 class="text-f20 font-bold italic px-4 text-brown leading-[22px] text-center"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="img relative" style="left:69px ; top:-34px"><a href=""><img src="<?php echo e(asset('frontend/images/sp5.jpg')); ?>" alt="" class="rounded-full object-cover inline-block border-2 border-white" style="width: 177px; height: 177px;"></a></div>
                </div>
                <div class="absolute -top-28 -left-5 -mt-12">
                    <div class="text rounded-full  border border-brown border-dashed flex items-center -ml-20 relative float-right" style="width: 160px; height: 160px; top:87px; right: -128px;">
                        <span class="w-[30px] h-[30px] inline-block rounded-full text-white bg-red-700 absolute text-center top-[-17px] right-1/2 -translate-x-1/2 leading-[30px]">5</span>
                        <h3 class="text-f20 font-bold italic px-4 text-brown leading-[22px] text-center"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="img"><a href=""><img src="<?php echo e(asset('frontend/images/sp8.jpg')); ?>" alt="" class="rounded-full object-cover inline-block border-2 border-white" style="width: 177px; height: 177px;"></a></div>
                </div>

            </div>

        </div>
    </section>
    <section class="block lg:hidden">
        <div class="container mx-auto px-3  pt-[20px]  ">
            <div class="section-title">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">Yoosun Rau M?? d??ng trong nh???ng tr?????ng h???p n??o ?</h2>
            </div>
            <div>
                <div class="flex flex-wrap justify-between -mx-[5px]">
                    <div class="w-1/2 px-[5px] mb-[15px]">
                        <div class="img">
                            <img src="<?php echo e(asset('frontend/images/sp8.jpg')); ?>" alt="" class="object-cover inline-block w-full border-white" style=" height: 177px;">
                        </div>
                        <h3 class="text-f16 font-bold  text-brown leading-[20px]  h-[40px] overflow-hidden text-center mt-[10px]"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="w-1/2 px-[5px] mb-[15px]">
                        <div class="img">
                            <img src="<?php echo e(asset('frontend/images/sp8.jpg')); ?>" alt="" class="object-cover inline-block w-full border-white" style=" height: 177px;">
                        </div>
                        <h3 class="text-f16 font-bold  text-brown leading-[20px]  h-[40px] overflow-hidden text-center mt-[10px]"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="w-1/2 px-[5px] mb-[15px]">
                        <div class="img">
                            <img src="<?php echo e(asset('frontend/images/sp8.jpg')); ?>" alt="" class="object-cover inline-block w-full border-white" style=" height: 177px;">
                        </div>
                        <h3 class="text-f16 font-bold  text-brown leading-[20px]  h-[40px] overflow-hidden text-center mt-[10px]"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                    <div class="w-1/2 px-[5px] mb-[15px]">
                        <div class="img">
                            <img src="<?php echo e(asset('frontend/images/sp8.jpg')); ?>" alt="" class="object-cover inline-block w-full border-white" style=" height: 177px;">
                        </div>
                        <h3 class="text-f16 font-bold  text-brown leading-[20px]  h-[40px] overflow-hidden text-center mt-[10px]"><a href="">C??m ch??y Mini si??u ru???c chu???n v??? S??i G??n</a></h3>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- end: box 1 -->
    <!-- start: box 2 -->
    <section class="mt-0 md:mt-10">
        <div class="container mx-auto px-3">
            <div class="section-title wow fadeInUp">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">S???n ph???m n???i b???t</h2>
            </div>
            <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3 mt-5 md:mt-7 wow fadeInUp">
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ?? <del class="text-f15 text-gray-400 font-medium ml-[5px]">600.000??</del></p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ?? <del class="text-f15 text-gray-400 font-medium ml-[5px]">600.000??</del></p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ?? <del class="text-f15 text-gray-400 font-medium ml-[5px]">600.000??</del></p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ?? <del class="text-f15 text-gray-400 font-medium ml-[5px]">600.000??</del></p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ??</p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ??</p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ??</p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item-product text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/sp2.jpg')); ?>" alt="" class="w-full">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 2;
          height: 40px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> C??m ch??y ch?? b??ng s??i g??n C??m ch??y ch?? b??ng s??i g??n</a></h3>
                        <p class="price text-red-600 text-f16 font-bold mt-[5px]">500.000 ??</p>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end: box 2 -->


    <!-- start: box 3 -->
    <section class="mt-5 md:mt-10">
        <div class="container mx-auto px-3">
            <div class="section-title wow fadeInUp">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">C???m nh???n ng?????i d??ng</h2>
            </div>
            <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3 mt-5 md:mt-7 wow fadeInUp">
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- end: box 3 -->

    <!-- start: box 4 -->
    <section class="mt-5 md:mt-10 why-section">
        <div class="container mx-auto px-3">
            <div class="section-title wow fadeInUp">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">V?? sao n??n ch???n Yoosun Rau M???</h2>
            </div>
            <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3 mt-5 md:mt-7 wow fadeInUp">
                <div class="w-1/2 md:w-1/5 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh2.png')); ?>" alt="" class="w-full object-cover inline-block">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] text-brown"><a href="" class="hover:text-brown transition-all">AN TO??N L??NH T??NH</a></h3>
                        <p class="text-f15 mt-2">V???i d???ch chi???t rau m??
                            Kh??ng Corticoid, kh??ng Parabens</p>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/5 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh2.png')); ?>" alt="" class="w-full object-cover inline-block">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] text-brown"><a href="" class="hover:text-brown transition-all">AN TO??N L??NH T??NH</a></h3>
                        <p class="text-f15 mt-2">V???i d???ch chi???t rau m??
                            Kh??ng Corticoid, kh??ng Parabens</p>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/5 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh2.png')); ?>" alt="" class="w-full object-cover inline-block">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] text-brown"><a href="" class="hover:text-brown transition-all">AN TO??N L??NH T??NH</a></h3>
                        <p class="text-f15 mt-2">V???i d???ch chi???t rau m??
                            Kh??ng Corticoid, kh??ng Parabens</p>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/5 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh2.png')); ?>" alt="" class="w-full object-cover inline-block">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] text-brown"><a href="" class="hover:text-brown transition-all">NH?? M??Y ?????T CHU???N GMP</a></h3>
                        <p class="text-f15 mt-2">?????m b???o an to??n, ch???t l?????ng</p>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/5 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh2.png')); ?>" alt="" class="w-full object-cover inline-block">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] text-brown"><a href="" class="hover:text-brown transition-all">AN TO??N L??NH T??NH</a></h3>
                        <p class="text-f15 mt-2">V???i d???ch chi???t rau m??
                            Kh??ng Corticoid, kh??ng Parabens</p>
                    </div>
                </div>



            </div>
        </div>
    </section>
    <!-- end: box 4 -->

    <!-- start: box 5 -->
    <section class="mt-5 md:mt-10">
        <div class="container mx-auto px-3">
            <div class="section-title wow fadeInUp">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">Tin t???c</h2>
            </div>
            <div class="flex flex-wrap justify-center -mx-[5px] md:-mx-3 mt-5 md:mt-7 wow fadeInUp">
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>
                <div class="w-1/2 md:w-1/4 px-[5px] md:px-3 ">
                    <div class="item text-center mb-4 md:mb-6">
                        <div class="img hover-zoom">
                            <a href="">
                                <img src="<?php echo e(asset('frontend/images/anh1.webp')); ?>" alt="" class="w-full object-cover" style="height: 190px;">
                            </a>
                        </div>
                        <h3 class="text-f15 font-bold mt-[15px] overflow-hidden" style=" text-overflow: ellipsis;
          line-height: 20px;
          -webkit-line-clamp: 3;
          height: 60px;
          display: -webkit-box;
          -webkit-box-orient: vertical;"><a href="" class="hover:text-brown transition-all"> Ca s?? V?? H??? Tr??m m??ch n?????c d??ng Yoosun Rau m?? ????nh bay r??m s???y, m???n ng???a cho con</a></h3>
                        <a href="" class="btn-active-view inline-block mt-[10px] hover:underline">Xem chi ti???t</a>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- end: box5 -->

    <!-- start: box 6 -->
    <section class="video-home">
        <div class="container mx-auto px-3">
            <div class="section-title wow fadeInUp">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">Video Yoosun rau m??</h2>
            </div>
            <div class="flex flex-wrap justify-center mt-5 wow fadeInUp">
                <div class="w-full md:w-2/3">
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/i0DCgO-shsw" title="C??ch l??m C??m Ch??y Ch?? B??ng t???i nh?? th??m ngon gi??n r???m" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- end: box 6 -->

    <!-- start: box 6 -->
    <section class="oder-home pt-5 md:pt-10">
        <div class="container mx-auto px-3">
            <div class="section-title wow fadeInUp">
                <h2 class="text-f22 md:text-f30 text-center text-brown font-medium">B???n c?? th??? mua Yoosun Rau M?? ??? ????u?</h2>
            </div>
            <div class="flex flex-wrap justify-between -mx-[5px] md:-mx-3 mt-0 md:mt-5">
                <div class="w-full md:w-1/3 px-[5px] md:px-3">
                    <p class="text-f15 text-brown">Yoosun rau m?? ???????c b??n ph??? bi???n t???i c??c nh?? thu???c tr??n to??n qu???c, xem ?????a ch??? nh?? thu???c g???n b???n <a href="" class="font-bold">T???I ????Y!</a></p>
                    <p class="text-f15 py-[15px]">?????t mua tr???c tuy???n t???i:</p>
                    <ul class="flex flex-wrap justify-start">
                        <li class="mr-[15px]">
                            <a href=""><img src="<?php echo e(asset('frontend/images/Shopee.png.webp')); ?>" alt=""></a>
                        </li>
                        <li class="mr-[15px]">
                            <a href=""><img src="<?php echo e(asset('frontend/images/Tiki.png.webp')); ?>"></a>
                        </li>
                        <li class="mr-[15px]">
                            <a href=""><img src="<?php echo e(asset('frontend/images/Lazada.png.webp')); ?>" alt=""></a>
                        </li>
                    </ul>
                </div>
                <div class="w-full md:w-2/3 px-[5px] md:px-3 mt-4 md:mt-0">
                    <div class="flex flex-wrap justify-between bg-white">
                        <div class="w-full md:w-1/2">
                            <h3 class="bg-brown text-white py-[8px] px-[10px]">HO???C MUA NGAY T???I ????Y:</h3>
                            <div class="p-[15px]">
                                <div class="mb-[15px]">
                                    <label for="" class="inline-block w-full mb-2">H??? v?? t??n</label>
                                    <input type="text" class="w-full h-[38px] border border-gray-400">
                                </div>
                                <div class="mb-[15px]">
                                    <label for="" class="inline-block w-full mb-2">S??? ??i???n tho???i:</label>
                                    <input type="text" class="w-full h-[38px] border border-gray-400">
                                </div>
                                <div class="mb-[15px]">
                                    <label for="" class="inline-block w-full mb-2">?????a ch???:</label>
                                    <input type="text" class="w-full h-[38px] border border-gray-400">
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 text-center pb-[15px] md:pb-0">
                            <input type="submit" value="?????t h??ng ngay" class="bg-yellow text-black py-[8px] px-[10px] w-full uppercase font-bold hidden md:block">
                            <div class="flex flex-wrap justify-center  items-start md:items-center h-full md:h-5/6 ">
                                <div>


                                    <select name="" id="">
                                        <option value="">S???n ph???m</option>
                                    </select>


                                    <p class="text-f16 ">????n gi??: <span class="text-red-600 font-bold"> 43.000VN??</span></p>


                                    <p class="mt-4">S??? l?????ng: <input type="number" min="1" class="w-[100px] h-[35px] border border-gray-300 rounded-sm ml-3"></p>
                                    <input type="submit" value="?????t h??ng ngay" class="bg-yellow text-black py-[8px] px-[10px]  uppercase font-bold block md:hidden w-full mt-4 md:mt-0">
                                    <p class="text-red-600 font-bold text-f20 mt-4">T???NG: 258.000VN??</p>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end: box 7 -->

</div>










<?php /*
<main style="display: none;">
    <div class="container px-1 md:px-0 mx-auto">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 lg:col-span-3 mt-8 md:mt-0 order-1 lg:order-0">
                @include('homepage.common.aside')
            </div>
            <div class="col-span-12 lg:col-span-9 space-y-6 mt-5 md:mt-0 order-0 lg:order-1">
                @if(!$blogs->isEmpty())
                <div class="grid lg:grid-cols-2 gap-4">
                    @foreach($blogs as $key=>$item)
                    <div class="md:col-span-1">
                        <div class="flex justify-between items-center border-b border-global">
                            <h2 class="h2-category h2-main text-global font-bold text-lg uppercase relative pb-1">
                                <a href="{{route('routerURL',['slug' => $item->slug])}}" class="hover:text-red-600">{{$item->title}}</a>
                            </h2>
                            @if(count($item->children) > 0)
                            <ul class="space-x-1 hidden md:flex">
                                @foreach($item->children as $value)
                                <li><a href="{{route('routerURL',['slug' => $value->slug])}}" class="hover:text-red-600">{{$value->title}} </a></li>
                                @endforeach
                            </ul>
                            @endif

                        </div>
                        <div class="mt-3">
                            @if(count($item->listArticleHome) > 0)
                            @foreach($item->listArticleHome as $k=>$value)
                            @if($k==0)
                            <div class="md:flex a-custom">
                                <div class="w-full md:w-1/2 mb-2 md:mb-0 overflow-hidden  mr-[15px]">
                                    <a href="{{route('routerURL',['slug' => $value->slug])}}" class="overflow-hidden">
                                        <img src="{{ asset('frontend/imagessset($value->image' )}}" class="h-[180px] img-custom object-cover w-full" alt="{{$value->title}}">
                                    </a>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col justify-between h-full">
                                        <div class="mb-2 md:mb-0">
                                            <h3 class="line-clamp line-clamp-2"><a href="{{route('routerURL',['slug' =>  $value->slug])}}" class="text-base text-global font-bold">{{$value->title}}</a></h3>
                                            <div class="mt-2 line-clamp line-clamp-3">
                                                <?php echo strip_tags($value->description) ?>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{route('routerURL',['slug' => $value->slug])}}" class="bg-global px-[23px] text-white h-[33px] leading-[33px] float-left hover:bg-red-500">?????c
                                                ti???p</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="grid grid-cols-3 gap-[10px] mt-3">
                                @foreach($item->listArticleHome as $k=>$value)
                                @if($k>0)
                                <div class="col-span-3 md:col-span-1 a-custom mb-[10px] md:mb-0">
                                    <div class="overflow-hidden mb-1 md:mb-3">
                                        <a href="{{route('routerURL',['slug' => $value->slug])}}"><img src="{{ asset('frontend/imagessset($value->image)}}" class="img-custom h-[250px] md:h-[157px] lg:h-[110px] object-cover w-full') }}" alt="{{$value->title}}"></a>
                                    </div>
                                    <h3 class="line-clamp line-clamp-2"><a href="{{route('routerURL',['slug' => $value->slug])}}" class="text-global line-custom-2 font-semibold">{{$value->title}}</a></h3>
                                    <div class="mt-1 line-clamp line-clamp-3">
                                        <?php echo strip_tags($value->description) ?>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endif


                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
<div class="flex grid">

</div>
 */  ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('javascript'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/homepage/home/index.blade.php ENDPATH**/ ?>