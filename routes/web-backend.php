<?php

use App\Http\Controllers\address\backend\AddressController;
//article module
use App\Http\Controllers\article\backend\ArticleController;
use App\Http\Controllers\article\backend\CategoryController as BackendCategoryController;
//product module
use App\Http\Controllers\product\backend\CategoryController;
use App\Http\Controllers\product\backend\ProductController;
//attribute module
use App\Http\Controllers\attribute\backend\CategoryController as AttributeCategoryController;
use App\Http\Controllers\attribute\backend\AttributeController as AttributeController;
//brand module
use App\Http\Controllers\brand\backend\BrandController;
use App\Http\Controllers\briefing\backend\BriefingCategoryController;
use App\Http\Controllers\briefing\backend\BriefingController;
//mã giảm giá module
use App\Http\Controllers\coupon\CounponController;
//Order, đặt hàng module
use App\Http\Controllers\order\backend\OrderController;

//comment module
use App\Http\Controllers\comment\backend\CommentController;
//media module
use App\Http\Controllers\media\backend\CategoryController as MediaBackendCategoryController;
use App\Http\Controllers\media\backend\MediaController;
//menu module
use App\Http\Controllers\menu\backend\MenuController;
use App\Http\Controllers\module\ModuleController;
//slide module
use App\Http\Controllers\slide\backend\SlideController;
///tag module
use App\Http\Controllers\tag\backend\TagController;
//khách hàng module
use App\Http\Controllers\customer\backend\CustomerController;
//user ADMIN
use App\Http\Controllers\user\backend\AuthController;
use App\Http\Controllers\user\backend\PermissionController;
use App\Http\Controllers\user\backend\ResetPasswordController;
use App\Http\Controllers\user\backend\RolesController;
use App\Http\Controllers\user\backend\UsersController;
//tour
use App\Http\Controllers\tour\backend\TourController;
use App\Http\Controllers\tour\backend\CategoryTourController;
use App\Http\Controllers\tour\backend\TypeTourController;
use App\Http\Controllers\tour\backend\ServiceTourController;
use App\Http\Controllers\tour\backend\ServiceItemTourController;
use App\Http\Controllers\tour\backend\TourBookController;
//faq
use App\Http\Controllers\faq\backend\FaqController;

//contact module
use App\Http\Controllers\contact\backend\ContactController;
//page module
use App\Http\Controllers\page\backend\PageController;

//global admin => module
use App\Http\Controllers\components\ComponentsController;
use App\Http\Controllers\config\ConfigColumController;
use App\Http\Controllers\config\ConfigIsController;
use App\Http\Controllers\customer\backend\CustomerCategoryController;
use App\Http\Controllers\dashboard\AjaxController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\GeneralController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => env('APP_ADMIN'), 'middleware' => ['guest:web']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'store'])->name('admin.login-store');
    Route::get('/reset-password', [ResetPasswordController::class, 'index'])->name('admin.reset-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('admin.reset-password-store');
    Route::get('/reset-password-new', [ResetPasswordController::class, 'reset_password_new'])->name('admin.reset-password-new');
});

Route::group(['middleware' => 'locale'], function () {
    Route::group(['prefix' => env('APP_ADMIN'), 'middleware' => ['auth:web']], function () {

        Route::group(['prefix' => '/dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::post('/search/bookTour', [DashboardController::class, 'searchBookTour'])->name('admin.searchBookTour');
        });
        //configure
        Route::group(['prefix' => '/config-is'], function () {
            Route::get('/index', [ConfigIsController::class, 'index'])->name('configIs.index');
            Route::get('/create', [ConfigIsController::class, 'create'])->name('configIs.create');
            Route::post('/store', [ConfigIsController::class, 'store'])->name('configIs.store');
            Route::get('/edit/{id}', [ConfigIsController::class, 'edit'])->name('configIs.edit');
            Route::post('/update/{id}', [ConfigIsController::class, 'update'])->name('configIs.update');
            Route::get('/destroy/{id}', [ConfigIsController::class, 'destroy'])->name('configIs.destroy');
        });
        Route::group(['prefix' => '/config-colums'], function () {
            Route::get('/index', [ConfigColumController::class, 'index'])->name('config_colums.index');
            Route::get('/create', [ConfigColumController::class, 'create'])->name('config_colums.create');
            Route::post('/store', [ConfigColumController::class, 'store'])->name('config_colums.store');
            Route::get('/edit/{id}', [ConfigColumController::class, 'edit'])->name('config_colums.edit');
            Route::post('/update/{id}', [ConfigColumController::class, 'update'])->name('config_colums.update');
            Route::post('/destroy', [ConfigColumController::class, 'destroy'])->name('config_colums.destroy');
            Route::post('/ajax/delete-all', [ConfigColumController::class, 'deleteAll'])->name('config_colums.delete_all');
        });
        //ajax
        Route::group(['prefix' => '/ajax'], function () {
            Route::post('/select2', [AjaxController::class, 'select2']);
            Route::post('/ajax-create', [AjaxController::class, 'ajax_create'])->name('ajax-create');
            Route::post('/ajax-delete', [AjaxController::class, 'ajax_delete']);
            Route::post('/ajax-delete-all', [AjaxController::class, 'ajax_delete_all']);
            Route::post('/ajax-order', [AjaxController::class, 'ajax_order']);
            Route::post('/publish-ajax', [AjaxController::class, 'ajax_publish']);
            Route::post('/get-select2', [AjaxController::class, 'get_select2']);
            Route::post('/pre-select2', [AjaxController::class, 'pre_select2']);
        });

        //cấu hình hệ thống
        Route::group(['prefix' => '/generals'], function () {
            Route::get('/index', [GeneralController::class, 'general'])->name('generals.general')->middleware('can:generals_index');
            Route::post('/store', [GeneralController::class, 'store'])->name('generals.store');
        });

        //permission
        Route::group(['prefix' => '/permissions'], function () {
            Route::get('/index', [PermissionController::class, 'index'])->name('permissions.index');
            Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
            Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
        });
        //nhóm thành viên
        Route::group(['prefix' => '/roles'], function () {
            Route::get('/index', [RolesController::class, 'index'])->name('roles.index')->middleware('can:roles_index');
            Route::get('/create', [RolesController::class, 'create'])->name('roles.create')->middleware('can:roles_create');
            Route::post('/store', [RolesController::class, 'store'])->name('roles.store')->middleware('can:roles_create');
            Route::get('/edit/{id}', [RolesController::class, 'edit'])->name('roles.edit')->middleware('can:roles_edit');
            Route::post('/update/{id}', [RolesController::class, 'update'])->name('roles.update')->middleware('can:roles_edit');
            Route::get('/destroy/{id}', [RolesController::class, 'destroy'])->name('roles.destroy')->middleware('can:roles_destroy');
        });
        //Thành viên quản trị
        Route::group(['prefix' => '/users'], function () {
            Route::get('/index', [UsersController::class, 'index'])->name('users.index')->middleware('can:users_index');
            Route::get('/create', [UsersController::class, 'create'])->name('users.create')->middleware('can:users_create');
            Route::post('/store', [UsersController::class, 'store'])->name('users.store')->middleware('can:users_create');
            Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('users.edit')->middleware('can:users_edit');
            Route::post('/update/{id}', [UsersController::class, 'update'])->name('users.update')->middleware('can:users_edit');
            Route::get('/destroy/{id}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware('can:roles_destroy');
            Route::get('/reset-password', [UsersController::class, 'reset_password'])->name('users.reset-password')->middleware('can:users_edit');
            //auth
            Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
            Route::get('/my-profile', [AuthController::class, 'profile'])->name('admin.profile');
            Route::post('/my-profile/{id}', [AuthController::class, 'profile_store'])->name('admin.profile-store');
            Route::get('/my-password', [AuthController::class, 'profile_password'])->name('admin.profile-password');
            Route::post('/my-password/{id}', [AuthController::class, 'profile_password_store'])->name('admin.profile-password-store');
        });
        //slide
        Route::group(['prefix' => '/slides'], function () {
            Route::get('/index', [SlideController::class, 'index'])->name('slides.index')->middleware('can:slides_index');
            Route::post('/store', [SlideController::class, 'store'])->name('slides.store')->middleware('can:slides_index');
            Route::post('/category_store', [SlideController::class, 'category_store'])->name('slides.category_store')->middleware('can:slides_index');
            Route::post('/category_update', [SlideController::class, 'category_update'])->name('slides.category_update')->middleware('can:slides_index');
            Route::post('/update', [SlideController::class, 'update'])->name('slides.update')->middleware('can:slides_index');
        });
        //danh mục attribute
        Route::group(['prefix' => '/category-attributes'], function () {
            Route::get('/index', [AttributeCategoryController::class, 'index'])->name('category_attributes.index')->middleware('can:category_attributes_index');
            Route::get('/create', [AttributeCategoryController::class, 'create'])->name('category_attributes.create')->middleware('can:category_attributes_create');
            Route::post('/store', [AttributeCategoryController::class, 'store'])->name('category_attributes.store')->middleware('can:category_attributes_create');
            Route::get('/edit/{id}', [AttributeCategoryController::class, 'edit'])->name('category_attributes.edit')->middleware('can:category_attributes_edit');
            Route::post('/update/{id}', [AttributeCategoryController::class, 'update'])->name('category_attributes.update')->middleware('can:category_attributes_edit');
            Route::get('/destroy/{id}', [AttributeCategoryController::class, 'destroy'])->name('category_attributes.destroy')->middleware('can:category_attributes_destroy');
        });
        //danh sách attribute
        Route::group(['prefix' => '/attributes'], function () {
            Route::get('/index', [AttributeController::class, 'index'])->name('attributes.index')->middleware('can:attributes_index');
            Route::get('/create', [AttributeController::class, 'create'])->name('attributes.create')->middleware('can:attributes_create');
            Route::post('/store', [AttributeController::class, 'store'])->name('attributes.store')->middleware('can:attributes_create');
            Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('attributes.edit')->middleware('can:attributes_edit');
            Route::post('/update/{id}', [AttributeController::class, 'update'])->name('attributes.update')->middleware('can:attributes_edit');
            Route::get('/destroy/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy')->middleware('can:attributes_destroy');
            Route::post('/select2', [AttributeController::class, 'select2']);
        });
        //danh mục sản phẩm
        Route::group(['prefix' => '/category-products'], function () {
            Route::get('/index', [CategoryController::class, 'index'])->name('category_products.index')->middleware('can:category_products_index');
            Route::get('/create', [CategoryController::class, 'create'])->name('category_products.create')->middleware('can:category_products_create');
            Route::post('/store', [CategoryController::class, 'store'])->name('category_products.store')->middleware('can:category_products_create');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category_products.edit')->middleware('can:category_products_edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category_products.update')->middleware('can:category_products_edit');
            Route::get('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category_products.destroy')->middleware('can:category_products_destroy');
        });
        //sản phẩm
        Route::group(['prefix' => '/products'], function () {
            Route::get('/index', [ProductController::class, 'index'])->name('products.index')->middleware('can:products_index');

            Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware('can:products_create');
            Route::post('/store', [ProductController::class, 'store'])->name('products.store')->middleware('can:products_create');
            Route::get('/copy/{id}', [ProductController::class, 'copy'])->name('products.copy')->middleware('can:products_create');

            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit')->middleware('can:products_edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('can:products_edit');
            Route::get('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('can:products_destroy');
            Route::post('/ajax/get-attrid', [ProductController::class, 'get_attrid']);
            Route::get('/ajax/list-product', [ProductController::class, 'listproduct']);
            Route::get('/ajax/index/pagination', [ProductController::class, 'pagination'])->middleware('can:products_index');
        });
        //tag
        Route::group(['prefix' => '/tags'], function () {
            Route::get('/index', [TagController::class, 'index'])->name('tags.index')->middleware('can:tags_index');
            Route::get('/create', [TagController::class, 'create'])->name('tags.create')->middleware('can:tags_create');
            Route::post('/store', [TagController::class, 'store'])->name('tags.store');
            Route::get('/edit/{id}', [TagController::class, 'edit'])->name('tags.edit')->middleware('can:tags_edit');
            Route::post('/update/{id}', [TagController::class, 'update'])->name('tags.update')->middleware('can:tags_edit');
            Route::get('/destroy/{id}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('can:tags_destroy');
        });
        Route::group(['prefix' => '/brands'], function () {
            Route::get('/index', [BrandController::class, 'index'])->name('brands.index')->middleware('can:brands_index');
            Route::get('/create', [BrandController::class, 'create'])->name('brands.create')->middleware('can:brands_create');
            Route::post('/store', [BrandController::class, 'store'])->name('brands.store')->middleware('can:brands_create');
            Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit')->middleware('can:brands_edit');
            Route::post('/update/{id}', [BrandController::class, 'update'])->name('brands.update')->middleware('can:brands_edit');
            Route::get('/destroy/{id}', [BrandController::class, 'destroy'])->name('brands.destroy')->middleware('can:brands_destroy');
        });
        Route::group(['prefix' => '/coupons'], function () {
            Route::get('/index', [CounponController::class, 'index'])->name('coupons.index')->middleware('can:coupons_index');
            Route::get('/create', [CounponController::class, 'create'])->name('coupons.create')->middleware('can:coupons_create');
            Route::post('/store', [CounponController::class, 'store'])->name('coupons.store')->middleware('can:coupons_create');
            Route::get('/edit/{id}', [CounponController::class, 'edit'])->name('coupons.edit')->middleware('can:coupons_edit');
            Route::post('/update/{id}', [CounponController::class, 'update'])->name('coupons.update')->middleware('can:coupons_edit');
            Route::get('/destroy/{id}', [CounponController::class, 'destroy'])->name('coupons.destroy')->middleware('can:coupons_destroy');
        });
        //danh mục article
        Route::group(['prefix' => '/category-articles'], function () {
            Route::get('/index', [BackendCategoryController::class, 'index'])->name('category_articles.index')->middleware('can:category_articles_index');
            Route::get('/create', [BackendCategoryController::class, 'create'])->name('category_articles.create')->middleware('can:category_articles_create');
            Route::post('/store', [BackendCategoryController::class, 'store'])->name('category_articles.store')->middleware('can:category_articles_create');
            Route::get('/edit/{id}', [BackendCategoryController::class, 'edit'])->name('category_articles.edit')->middleware('can:category_articles_edit');
            Route::post('/update/{id}', [BackendCategoryController::class, 'update'])->name('category_articles.update')->middleware('can:category_articles_edit');
            Route::get('/destroy/{id}', [BackendCategoryController::class, 'destroy'])->name('category_articles.destroy')->middleware('can:category_articles_destroy');
        });
        //danh sách article
        Route::group(['prefix' => '/articles'], function () {
            Route::get('/index', [ArticleController::class, 'index'])->name('articles.index')->middleware('can:articles_index');
            Route::get('/create', [ArticleController::class, 'create'])->name('articles.create')->middleware('can:articles_create');
            Route::post('/store', [ArticleController::class, 'store'])->name('articles.store');
            Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name('articles.edit')->middleware('can:articles_edit');
            Route::post('/update/{id}', [ArticleController::class, 'update'])->name('articles.update')->middleware('can:articles_edit');
            Route::get('/destroy/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy')->middleware('can:articles_destroy');
            Route::post('/select2', [ArticleController::class, 'select2']);
        });
        //danh mục media
        Route::group(['prefix' => '/category-media'], function () {
            Route::get('/index', [MediaBackendCategoryController::class, 'index'])->name('category_media.index')->middleware('can:category_media_index');
            Route::get('/create', [MediaBackendCategoryController::class, 'create'])->name('category_media.create')->middleware('can:category_media_create');
            Route::post('/store', [MediaBackendCategoryController::class, 'store'])->name('category_media.store');
            Route::get('/edit/{id}', [MediaBackendCategoryController::class, 'edit'])->name('category_media.edit')->middleware('can:category_media_edit');
            Route::post('/update/{id}', [MediaBackendCategoryController::class, 'update'])->name('category_media.update')->middleware('can:category_media_edit');
            Route::get('/destroy/{id}', [MediaBackendCategoryController::class, 'destroy'])->name('category_media.destroy')->middleware('can:category_media_destroy');
        });

        //danh sách media
        Route::group(['prefix' => '/media'], function () {
            Route::get('/index', [MediaController::class, 'index'])->name('media.index')->middleware('can:media_index');
            Route::get('/create', [MediaController::class, 'create'])->name('media.create')->middleware('can:media_create');
            Route::post('/store', [MediaController::class, 'store'])->name('media.store');
            Route::get('/edit/{id}', [MediaController::class, 'edit'])->name('media.edit')->middleware('can:media_edit');
            Route::post('/update/{id}', [MediaController::class, 'update'])->name('media.update')->middleware('can:media_edit');
            Route::get('/destroy/{id}', [MediaController::class, 'destroy'])->name('media.destroy')->middleware('can:media_destroy');
            Route::post('/get-select-type', [MediaController::class, 'get_select_type']);
        });
        //liên hệ
        Route::group(['prefix' => '/contacts'], function () {
            Route::get('/index', [ContactController::class, 'index'])->name('contacts.index')->middleware('can:contacts_index');
            Route::post('/index', [ContactController::class, 'store'])->name('contacts.index_store')->middleware('can:contacts_index');
        });
        Route::group(['prefix' => '/subscribers'], function () {
            Route::get('/index', [ContactController::class, 'subscribers'])->name('subscribers.index');
        });
        Route::group(['prefix' => '/books'], function () {
            Route::get('/index', [ContactController::class, 'books'])->name('books.index');
        });
        //menu
        Route::group(['prefix' => '/menus'], function () {
            Route::get('/index', [MenuController::class, 'index'])->name('menus.index')->middleware('can:menus_index');
            Route::get('/create', [MenuController::class, 'create'])->name('menus.create')->middleware('can:menus_create');
            Route::post('/store', [MenuController::class, 'store'])->name('menus.store');
            Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menus.edit')->middleware('can:menus_edit');
            Route::post('/update/{id}', [MenuController::class, 'update'])->name('menus.update');
            //nút "thêm vào menu"
            Route::get('/add-menu-item', [MenuController::class, 'addMenuItem'])->name('addMenuItem')->middleware('can:menus_create');
            //nút Liên kết tự tạo => "thêm vào menu"
            Route::get('/add-custom-link', [MenuController::class, 'addCustomLink'])->name('addCustomLink')->middleware('can:menus_create');
            //nút Lưu menu item
            Route::post('/update-menu-item/{id}', [MenuController::class, 'updateMenuItem'])->name('update-menu-item')->middleware('can:menus_edit');
            //nút Xóa menu item
            Route::get('/delete-menu-item/{id}/{menus_id}', [MenuController::class, 'deleteMenuItem'])->name('delete-menu-item')->middleware('can:menus_edit');
            //nút LƯU MENU khi kéo thả
            Route::get('/update-menu', [MenuController::class, 'updateMenu'])->name('update-menu')->middleware('can:menus_edit');
            //nút XÓA MENU
            Route::get('/delete-menu/{id}', [MenuController::class, 'destroy'])->name('delete-menu')->middleware('can:menus_destroy');
        });
        //address
        Route::group(['prefix' => '/addresses'], function () {
            Route::get('/index', [AddressController::class, 'index'])->name('addresses.index')->middleware('can:addresses_index');
            Route::get('/create', [AddressController::class, 'create'])->name('addresses.create')->middleware('can:addresses_create');
            Route::post('/create', [AddressController::class, 'store'])->name('addresses.store')->middleware('can:addresses_create');
            Route::get('/edit/{id}', [AddressController::class, 'edit'])->name('addresses.edit')->middleware('can:addresses_edit');
            Route::post('/update/{id}', [AddressController::class, 'update'])->name('addresses.update')->middleware('can:addresses_edit');
            Route::get('/destroy', [AddressController::class, 'destroy'])->name('addresses.destroy')->middleware('can:addresses_destroy');
            Route::post('/getLocation', [AddressController::class, 'getLocation'])->name('addresses.getLocation');
        });
        Route::group(['prefix' => '/pages'], function () {
            Route::get('index', [PageController::class, 'index'])->name('pages.index')->middleware('can:pages_index');
            Route::get('create', [PageController::class, 'create'])->name('pages.create')->middleware('can:pages_create');
            Route::post('create', [PageController::class, 'store'])->name('pages.store')->middleware('can:pages_create');
            Route::get('edit/{id}', [PageController::class, 'edit'])->name('pages.edit')->middleware('can:pages_edit');
            Route::post('update/{id}', [PageController::class, 'update'])->name('pages.update')->middleware('can:pages_edit');
            Route::get('destroy', [PageController::class, 'destroy'])->name('pages.destroy')->middleware('can:pages_destroy');
        });
        //order
        Route::group(['prefix' => '/orders'], function () {
            Route::get('index', [OrderController::class, 'index'])->name('orders.index')->middleware('can:orders_index');
            Route::get('edit/{id}', [OrderController::class, 'edit'])->name('orders.edit')->middleware('can:orders_edit');
            Route::post('update/{id}', [OrderController::class, 'update'])->name('orders.update')->middleware('can:orders_edit');
            Route::get('destroy', [OrderController::class, 'destroy'])->name('orders.destroy')->middleware('can:orders_destroy');
            Route::post('ajax/ajax-upload-status', [OrderController::class, 'ajaxUploadStatus'])->name('orders.ajaxUploadStatus');
        });
        //comments
        Route::group(['prefix' => '/comments'], function () {
            Route::get('index', [CommentController::class, 'index'])->name('comments.index')->middleware('can:comments_index');
            Route::get('edit/{id}', [CommentController::class, 'edit'])->name('comments.edit')->middleware('can:comments_edit');
            Route::post('update/{id}', [CommentController::class, 'update'])->name('comments.update')->middleware('can:comments_edit');
            Route::get('destroy', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('can:comments_destroy');
        });
        //customer category
        Route::group(['prefix' => '/customer-categories'], function () {
            Route::get('index', [CustomerCategoryController::class, 'index'])->name('customer_categories.index')->middleware('can:customers_index');
            Route::get('create', [CustomerCategoryController::class, 'create'])->name('customer_categories.create')->middleware('can:customers_create');
            Route::post('store', [CustomerCategoryController::class, 'store'])->name('customer_categories.store')->middleware('can:customers_create');
            Route::get('edit/{id}', [CustomerCategoryController::class, 'edit'])->name('customer_categories.edit')->middleware('can:customers_edit');
            Route::post('update/{id}', [CustomerCategoryController::class, 'update'])->name('customer_categories.update')->middleware('can:customers_edit');
            Route::get('destroy', [CustomerCategoryController::class, 'destroy'])->name('customer_categories.destroy')->middleware('can:customers_destroy');
        });
        //customer
        Route::group(['prefix' => '/customers'], function () {
            Route::get('index', [CustomerController::class, 'index'])->name('customers.index')->middleware('can:customers_index');
            Route::get('create', [CustomerController::class, 'create'])->name('customers.create')->middleware('can:customers_create');
            Route::post('store', [CustomerController::class, 'store'])->name('customers.store')->middleware('can:customers_create');
            Route::get('edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit')->middleware('can:customers_edit');
            Route::post('update/{id}', [CustomerController::class, 'update'])->name('customers.update')->middleware('can:customers_edit');
            Route::get('destroy', [CustomerController::class, 'destroy'])->name('customers.destroy')->middleware('can:customers_destroy');
        });
        //tour
        Route::group(['prefix' => '/tour-categories'], function () {
            Route::get('index', [CategoryTourController::class, 'index'])->name('tour_categories.index')->middleware('can:tour_categories_index');
            Route::get('create', [CategoryTourController::class, 'create'])->name('tour_categories.create')->middleware('can:tour_categories_create');
            Route::post('create', [CategoryTourController::class, 'store'])->name('tour_categories.store')->middleware('can:tour_categories_create');
            Route::get('edit/{id}', [CategoryTourController::class, 'edit'])->name('tour_categories.edit')->middleware('can:tour_categories_edit');
            Route::post('update/{id}', [CategoryTourController::class, 'update'])->name('tour_categories.update')->middleware('can:tour_categories_edit');
            Route::get('destroy', [CategoryTourController::class, 'destroy'])->name('tour_categories.destroy')->middleware('can:tour_categories_destroy');
        });

        Route::group(['prefix' => '/tours'], function () {
            Route::get('index', [TourController::class, 'index'])->name('tours.index')->middleware('can:tours_index');
            Route::get('create', [TourController::class, 'create'])->name('tours.create')->middleware('can:tours_create');
            Route::post('create', [TourController::class, 'store'])->name('tours.store')->middleware('can:tours_create');
            Route::get('edit/{id}', [TourController::class, 'edit'])->name('tours.edit')->middleware('can:tours_edit');
            Route::post('update/{id}', [TourController::class, 'update'])->name('tours.update')->middleware('can:tours_edit');
            Route::get('destroy', [TourController::class, 'destroy'])->name('tours.destroy')->middleware('can:tours_destroy');
        });
        Route::group(['prefix' => '/tour-types'], function () {
            Route::get('index', [TypeTourController::class, 'index'])->name('tour_types.index')->middleware('can:tours_index');
            Route::get('create', [TypeTourController::class, 'create'])->name('tour_types.create')->middleware('can:tours_create');
            Route::post('create', [TypeTourController::class, 'store'])->name('tour_types.store')->middleware('can:tours_create');
            Route::get('edit/{id}', [TypeTourController::class, 'edit'])->name('tour_types.edit')->middleware('can:tours_edit');
            Route::post('update/{id}', [TypeTourController::class, 'update'])->name('tour_types.update')->middleware('can:tours_edit');
            Route::get('destroy', [TypeTourController::class, 'destroy'])->name('tour_types.destroy')->middleware('can:tours_destroy');
        });
        //dịch vụ tour
        Route::group(['prefix' => '/tour-services'], function () {
            Route::get('index', [ServiceTourController::class, 'index'])->name('tour_services.index')->middleware('can:tours_index');
            Route::get('create', [ServiceTourController::class, 'create'])->name('tour_services.create')->middleware('can:tours_create');
            Route::post('create', [ServiceTourController::class, 'store'])->name('tour_services.store')->middleware('can:tours_create');
            Route::get('edit/{id}', [ServiceTourController::class, 'edit'])->name('tour_services.edit')->middleware('can:tours_edit');
            Route::post('update/{id}', [ServiceTourController::class, 'update'])->name('tour_services.update')->middleware('can:tours_edit');
            Route::get('destroy', [ServiceTourController::class, 'destroy'])->name('tour_services.destroy')->middleware('can:tours_destroy');
            Route::post('create-item', [ServiceItemTourController::class, 'store'])->name('tour_service_items.store')->middleware('can:tours_create');
            Route::post('update-item', [ServiceItemTourController::class, 'update'])->name('tour_service_items.update')->middleware('can:tours_edit');
        });
        //đặt tour
        Route::group(['prefix' => '/tour-books'], function () {
            Route::get('index', [TourBookController::class, 'index'])->name('tour_books.index')->middleware('can:tour_books_index');
            Route::get('edit/{id}', [TourBookController::class, 'edit'])->name('tour_books.edit')->middleware('can:tour_books_index');
        });
        Route::group(['prefix' => '/tour-inquiry'], function () {
            Route::get('index', [TourBookController::class, 'inquiry'])->name('tour_books.inquiry')->middleware('can:tour_books_index');
        });
        //dropzone
        Route::group(['prefix' => '/dropzone'], function () {
            Route::post('/dropzone-upload', [ComponentsController::class, 'dropzone_upload'])->name('dropzone_upload');
            Route::post('/dropzone-delete', [ComponentsController::class, 'dropzone_delete'])->name('dropzone_delete');
            Route::post('/dropzone-image', [ComponentsController::class, 'dropzone_image'])->name('dropzone_image');
        });
    });
    Route::get('/language/{language}', [ComponentsController::class, 'language'])->name('components.language');
});
