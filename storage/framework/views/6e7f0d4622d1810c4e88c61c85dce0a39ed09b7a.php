<?php $dropdown = getFunctions(); ?>
<nav class="side-nav">
    <div class="pt-4 mb-4">
        <div class="side-nav__header flex items-center">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class=" flex items-center">
                <img alt="Rocketman Tailwind HTML Admin Template" class="side-nav__header__logo" src="<?php echo e(asset('backend/images/logo.svg')); ?>">
                <span class="side-nav__header__text text-white pt-0.5 text-lg ml-2.5"> <?php echo e(env('BE_TITLE_SEO')); ?> </span>
            </a>
            <a href="javascript:;" class="side-nav__header__toggler hidden xl:block ml-auto text-white text-opacity-70 hover:text-opacity-100 transition-all duration-300 ease-in-out pr-5">
                <i data-lucide="arrow-left-circle" class="w-5 h-5"></i> </a>
            <a href="javascript:;" class="mobile-menu-toggler xl:hidden ml-auto text-white text-opacity-70 hover:text-opacity-100 transition-all duration-300 ease-in-out pr-5">
                <i data-lucide="x-circle" class="w-5 h-5"></i> </a>
        </div>
    </div>
    <div class="scrollable">
        <ul class="scrollable__content">
            <li class="side-nav__devider mb-4">START MENU</li>
            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="side-menu <?php echo e(activeMenu('dashboard')); ?>">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title">
                        Dashboard
                    </div>
                </a>
            </li>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('articles_index')): ?>
            <?php if (in_array('articles', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php echo e(request()->routeIs('articles.index') ? 'side-menu--active' : ''); ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? B??i vi???t
                            <div class="side-menu__sub-icon <?php if ($module === 'category_articles' || $module === 'articles') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'category_articles' || $module === 'articles') { ?>side-menu__sub-open<?php } ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_articles_index')): ?>
                        <li>
                            <a href="<?php echo e(route('category_articles.index')); ?>" class="side-menu <?php echo e(activeMenu('category-articles')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh m???c b??i vi???t</div>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('articles.index')); ?>" class="side-menu <?php echo e(activeMenu('articles')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> B??i vi???t </div>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? b??i vi???t -->
            <!-- Start: Qu???n l?? product -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_index')): ?>
            <?php if (in_array('products', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'category_products' || $module === 'products' || $module === 'orders' || $module === 'coupons' || $module === 'brands') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? S???n ph???m
                            <div class="side-menu__sub-icon <?php if ($module === 'category_products' || $module === 'products' || $module === 'orders' || $module === 'coupons' || $module === 'brands') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'category_products' || $module === 'products' || $module === 'orders' || $module === 'coupons' || $module === 'brands') { ?>side-menu__sub-open<?php } ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_products_index')): ?>
                        <li>
                            <a href="<?php echo e(route('category_products.index')); ?>" class="side-menu <?php echo e(activeMenu('category-products')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh m???c s???n ph???m</div>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('products.index')); ?>" class="side-menu <?php echo e(activeMenu('products')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh s??ch s???n ph???m</div>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('brands_index')): ?>
                        <?php if (in_array('brands', $dropdown)) { ?>
                            <li>
                                <a href="<?php echo e(route('brands.index')); ?>" class="side-menu <?php echo e(activeMenu('brands')); ?>">
                                    <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                    <div class="side-menu__title"> Qu???n l?? Th????ng hi???u</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders_index')): ?>
                        <?php if (in_array('orders', $dropdown)) { ?>
                            <li>
                                <a href="<?php echo e(route('orders.index')); ?>" class="side-menu <?php echo e(activeMenu('orders')); ?>">
                                    <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                    <div class="side-menu__title"> Qu???n l?? ????n h??ng</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupons_index')): ?>
                        <?php if (in_array('coupons', $dropdown)) { ?>
                            <li>
                                <a href="<?php echo e(route('coupons.index')); ?>" class="side-menu <?php echo e(activeMenu('coupons')); ?>">
                                    <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                    <div class="side-menu__title"> Qu???n l?? M?? gi???m gi??</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? product -->
            <!-- Start: Qu???n l?? thu???c t??nh -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('attributes_index')): ?>
            <?php if (in_array('attributes', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'category_attributes' || $module === 'attributes') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? Thu???c t??nh
                            <div class="side-menu__sub-icon <?php if ($module === 'category_attributes' || $module === 'attributes') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'category_attributes' || $module === 'attributes') { ?>side-menu__sub-open<?php } ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_attributes_index')): ?>
                        <li>
                            <a href="<?php echo e(route('category_attributes.index')); ?>" class="side-menu <?php echo e(activeMenu('category-attributes')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Nh??m thu???c t??nh</div>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('attributes.index')); ?>" class="side-menu <?php echo e(activeMenu('attributes')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh s??ch </div>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? thu???c t??nh -->
            <!-- Start: Qu???n l?? media -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('media_index')): ?>
            <?php if (in_array('media', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'category_media' || $module === 'media') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? Media
                            <div class="side-menu__sub-icon <?php if ($module === 'category_media' || $module === 'media') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'category_media' || $module === 'media') { ?>side-menu__sub-open<?php } ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_media_index')): ?>
                        <li>
                            <a href="<?php echo e(route('category_media.index')); ?>" class="side-menu <?php echo e(activeMenu('category-media')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh m???c media</div>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('media.index')); ?>" class="side-menu <?php echo e(activeMenu('media')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh s??ch </div>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? media -->
            <!-- Start: Qu???n l?? tour -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tours_index')): ?>
            <?php if (in_array('tours', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'tour_categories' || $module === 'tours' || $module === 'tour_types' || $module === 'tour_services' || $module === 'tour_books' || $module === 'faqs') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? tour
                            <div class="side-menu__sub-icon <?php if ($module === 'tour_categories' || $module === 'tour_types' || $module === 'tours' || $module === 'tour_services' || $module === 'tour_books' || $module === 'faqs') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'tour_categories' || $module === 'tour_types' || $module === 'tours' || $module === 'tour_services' || $module === 'tour_books' || $module === 'faqs') { ?>side-menu__sub-open<?php } ?>">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tour_categories_index')): ?>
                        <li>
                            <a href="<?php echo e(route('tour_categories.index')); ?>" class="side-menu <?php echo e(activeMenu('tour-categories')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> ??i???m ?????n</div>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo e(route('tours.index')); ?>" class="side-menu <?php echo e(activeMenu('tours')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh s??ch </div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('tour_types.index')); ?>" class="side-menu <?php echo e(activeMenu('tour-types')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title">Travel type</div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('tour_services.index')); ?>" class="side-menu <?php echo e(activeMenu('tour-services')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title">D???ch v??? tour</div>
                            </a>
                        </li>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tour_books_index')): ?>
                        <?php if (in_array('tour_books', $dropdown)) { ?>
                            <li>
                                <a href="<?php echo e(route('tour_books.index')); ?>" class="side-menu <?php echo e(activeMenu('tour-books')); ?>">
                                    <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                    <div class="side-menu__title">Danh s??ch ?????t tour</div>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('tour_books.inquiry')); ?>" class="side-menu <?php echo e(activeMenu('tour-inquiry')); ?>">
                                    <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                    <div class="side-menu__title">Danh s??ch inquiry</div>
                                </a>
                            </li>
                        <?php } ?>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? tour -->
            <!-- Start: Qu???n l?? kh??ch h??ng -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('customers_index')): ?>
            <?php if (in_array('customers', $dropdown) && !empty($module)) { ?>

                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'customers' || $module === 'customer_categories') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? user
                            <div class="side-menu__sub-icon <?php if ($module === 'customers' || $module === 'customer_categories') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'customers' || $module === 'customer_categories') { ?>side-menu__sub-open<?php } ?>">
                        <li>
                            <a href="<?php echo e(route('customer_categories.index')); ?>" class="side-menu <?php echo e(activeMenu('customer-categories')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Nh??m user</div>
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo e(route('customers.index')); ?>" class="side-menu <?php echo e(activeMenu('customers')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Danh s??ch user </div>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? kh??ch h??ng -->
            <!-- Start: H??? th???ng c???a h??ng -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('addresses_index')): ?>
            <?php if (in_array('addresses', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('addresses.index')); ?>" class="side-menu <?php echo e(activeMenu('addresses')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> H??? th???ng c???a h??ng </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: H??? th???ng c???a h??ng -->
            <!-- Start: Qu???n l?? Trang -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pages_index')): ?>
            <?php if (in_array('pages', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('pages.index')); ?>" class="side-menu <?php echo e(activeMenu('pages')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> Qu???n l?? Trang </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>

            <!-- END: Qu???n l?? Trang -->
            <!-- Start: Qu???n l?? Li??n h??? -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contacts_index')): ?>
            <?php if (in_array('contacts', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'contacts') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? Li??n h???
                            <div class="side-menu__sub-icon <?php if ($module === 'contacts') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'contacts') { ?>side-menu__sub-open<?php } ?>">
                        <li>
                            <a href="<?php echo e(route('contacts.index')); ?>" class="side-menu <?php echo e(activeMenu('contacts')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Qu???n l?? Li??n h???</div>
                            </a>
                        </li>
                        <li class="hidden">
                            <a href="<?php echo e(route('subscribers.index')); ?>" class="side-menu <?php echo e(activeMenu('subscribers')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> ????ng k?? g???i email </div>
                            </a>
                        </li>
                        <li class="hidden">
                            <a href="<?php echo e(route('books.index')); ?>" class="side-menu <?php echo e(activeMenu('books')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> ?????t l???ch h???n </div>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? Li??n h??? -->
            <!-- Start: Qu???n l?? Tag -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tags_index')): ?>
            <?php if (in_array('tags', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('tags.index')); ?>" class="side-menu <?php echo e(activeMenu('tags')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> Qu???n l?? Tag </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? Tag -->


            <!-- Start: Qu???n l?? Comment -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('comments_index')): ?>
            <?php if (in_array('comments', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('comments.index')); ?>" class="side-menu <?php echo e(activeMenu('comments')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> Qu???n l?? Comment </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? Comment -->

            <!-- Start: Qu???n l?? slide -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('slides_index')): ?>
            <?php if (in_array('slides', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('slides.index')); ?>" class="side-menu <?php echo e(activeMenu('slides')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> Qu???n l?? Banner & Slide </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? slide -->

            <!-- Start: Qu???n l?? Menu -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('menus_index')): ?>
            <?php if (in_array('menus', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('menus.index')); ?>" class="side-menu <?php echo e(activeMenu('menus')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> Qu???n l?? Menu </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: Qu???n l?? Menu -->

            <!-- Start: C???u h??nh h??? th???ng -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('generals_index')): ?>
            <?php if (in_array('generals', $dropdown)) { ?>
                <li>
                    <a href="<?php echo e(route('generals.general')); ?>" class="side-menu <?php echo e(activeMenu('generals')); ?>">
                        <div class="side-menu__icon">
                            <i data-lucide="box"></i>
                        </div>
                        <div class="side-menu__title"> C???u h??nh h??? th???ng </div>
                    </a>
                </li>
            <?php } ?>
            <?php endif; ?>
            <!-- END: C???u h??nh h??? th???ng -->
            <!-- Start: Qu???n l?? th??nh vi??n -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_index')): ?>
            <?php if (in_array('users', $dropdown) && !empty($module)) { ?>
                <li>
                    <a href="javascript:void(0)" class="side-menu <?php if ($module === 'users' || $module === 'roles') { ?>side-menu--active<?php } ?>">
                        <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                        <div class="side-menu__title">
                            Qu???n l?? th??nh vi??n
                            <div class="side-menu__sub-icon <?php if ($module === 'users' || $module === 'roles') { ?>transform rotate-180<?php } ?>">
                                <i data-lucide="chevron-down"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="<?php if ($module === 'users' || $module === 'roles') { ?>side-menu__sub-open<?php } ?>">
                        <li>
                            <a href="<?php echo e(route('roles.index')); ?>" class="side-menu <?php echo e(activeMenu('roles')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Nh??m th??nh vi??n</div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('users.index')); ?>" class="side-menu <?php echo e(activeMenu('users')); ?>">
                                <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                                <div class="side-menu__title"> Th??nh vi??n </div>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>
            <?php endif; ?>

            <!-- END: Qu???n l?? th??nh vi??n -->
            <?php if(env('APP_ENV') == "local" && !empty($module)): ?>
            <li>
                <a href="javascript:void(0)" class="side-menu <?php if ($module === 'permissions' || $module === 'configis' || $module === 'config_colums') { ?>side-menu--active<?php } ?>">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        Development
                        <div class="side-menu__sub-icon <?php if ($module === 'permissions' || $module === 'configis' || $module === 'config_colums') { ?>transform rotate-180<?php } ?>">
                            <i data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="<?php if ($module === 'permissions' || $module === 'configis' || $module === 'config_colums') { ?>side-menu__sub-open<?php } ?>">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_index')): ?>
                    <li>
                        <a href="<?php echo e(route('permissions.index')); ?>" class="side-menu <?php echo e(activeMenu('permissions')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Qu???n l?? ph??n quy???n</div>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li>
                        <a href="<?php echo e(route('configIs.index')); ?>" class="side-menu <?php echo e(activeMenu('config-is')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">C???u h??nh hi???n th???</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('config_colums.index')); ?>" class="side-menu <?php echo e(activeMenu('config-colums')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Custom field</div>
                        </a>
                    </li>
                </ul>
            </li>

            <?php endif; ?>
            <li class="">
                <a href="<?php echo e(route('sitemap')); ?>" class="side-menu" target="_blank">
                    <div class="side-menu__icon">
                        <i data-lucide="box"></i>
                    </div>
                    <div class="side-menu__title">C???p nh???p sitemap</div>
                </a>
            </li>

        </ul>
    </div>
</nav><?php /**PATH D:\xampp\htdocs\laravel.local\resources\views/dashboard/common/sidebar.blade.php ENDPATH**/ ?>