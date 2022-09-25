<?php

use App\Http\Controllers\address\frontend\AddressController;
use App\Http\Controllers\comment\frontend\CommentController;
use App\Http\Controllers\contact\frontend\ContactController;
use App\Http\Controllers\customer\frontend\CustomerController;
use App\Http\Controllers\homepage\HomeController;
use App\Http\Controllers\order\frontend\OrderController;
use App\Http\Controllers\product\frontend\CartController;
use App\Http\Controllers\product\frontend\CategoryController;
use App\Http\Controllers\article\frontend\CategoryController as CategoryArticleController;
use App\Http\Controllers\brand\frontend\BrandController;
use App\Http\Controllers\briefing\frontend\BriefingController;
use App\Http\Controllers\customer\frontend\VerificationController;
use App\Http\Controllers\homepage\ImageController;
use App\Http\Controllers\page\frontend\PageController;
use App\Http\Controllers\tag\frontend\TagController;
use App\Http\Controllers\tour\frontend\TourCategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'locale'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('homepage.index');
    Route::get('/about-us', [PageController::class, 'aboutUs'])->name('homepage.aboutus');

    Route::get('/lien-he', [ContactController::class, 'index'])->name('contactFrontend.index');
    Route::post('/lien-he', [ContactController::class, 'store'])->name('contactFrontend.store');

    Route::get('/tim-kiem', [CategoryArticleController::class, 'search'])->name('homepage.search');
    //login customer
    Route::group(['prefix' => 'thanh-vien', 'middleware' => ['guest:customer']], function () {
        Route::get('/login', [CustomerController::class, 'login'])->name('customer.login');
        Route::post('/login', [CustomerController::class, 'store'])->name('customer.login-store');
        /* Route::get('/register', [CustomerController::class, 'register'])->name('customer.register');
        Route::post('/register', [CustomerController::class, 'register_store'])->name('customer.register-store'); */
        //login social
        Route::get('/login/redirect/{provider}', [CustomerController::class, 'redirect'])->name('customer.redirect');
        Route::get('/login/callback/{provider}', [CustomerController::class, 'callback'])->name('customer.callback');
        Route::get('/reset-password', [CustomerController::class, 'reset_password'])->name('customer.reset-password');
        Route::post('/reset-password', [CustomerController::class, 'reset_password_store'])->name('customer.reset-password-store');
        Route::get('/reset-password-new', [CustomerController::class, 'reset_password_new'])->name('customer.reset-password-new');
        //email register
        /*
        Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
        Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend'); */
    });
    Route::group(['prefix' => 'thanh-vien'], function () {
        Route::get('/thong-tin-tai-khoan', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/doi-mat-khau', [CustomerController::class, 'changepassword'])->name('customer.changepassword');
        Route::post('/doi-mat-khau', [CustomerController::class, 'storeChangePassword'])->name('customer.storeChangePassword');
        Route::get('/thong-tin-lien-he', [CustomerController::class, 'address'])->name('customer.address');
        Route::get('/quan-ly-don-hang', [CustomerController::class, 'orders'])->name('customer.orders');
        Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    });

    //upload image frontend
    Route::post('/image/store', [ImageController::class, 'store'])->name('image.store');

    //comment
    Route::group(['prefix' => 'comment'], function () {
        Route::post('/post-comment', [CommentController::class, 'postCmt'])->name('commentFrontend.post');
        Route::post('/post-comment-tour', [CommentController::class, 'postCmtTour'])->name('commentFrontend.postTour');
        Route::post('/post-comment-article', [CommentController::class, 'postArticle'])->name('commentFrontend.postArticle');
        Route::post('/reply-comment', [CommentController::class, 'reply_comment'])->name('replyComment.post');
        Route::post('/get-list-comment', [CommentController::class, 'getListComment'])->name('getListComment.frontend');
        Route::post('/get-list-comment-tour', [CommentController::class, 'getListCommentTour'])->name('getListComment.frontendTour');
        Route::post('/get-list-comment-article', [CommentController::class, 'getListCommentArticle'])->name('getListComment.frontendArticle');
        Route::post('upload-images-comment', [CommentController::class, 'uploadImagesComment'])->name('components.uploadImagesComment');
    });
    //giỏ hàng - ajax
    Route::group(['prefix' => 'gio-hang'], function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::get('/thanh-toan', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('/thanh-toan-thanh-cong/{id}', [CartController::class, 'success'])->name('cart.success');
        Route::post('/get-location', [CartController::class, 'getLocation'])->name('checkout.getLocation');
    });
    //order
    Route::group(['prefix' => 'order'], function () {
        Route::post('/', [OrderController::class, 'order'])->name('cart.order');
        Route::get('momo-result', [OrderController::class, 'momo_result'])->name('momo.result');
        Route::get('momo-ipn', [OrderController::class, 'momo_ipn'])->name('momo.ipn');
        Route::get('vnpay-result', [OrderController::class, 'vnpay_result'])->name('vnpay.result');
    });
    //tags
    Route::group(['prefix' => 'tag'], function () {
        Route::get('/{slug}', [TagController::class, 'index'])->where(['slug' => '.+'])->name('tagURL');
    });
    //thuong hiệu
    Route::group(['prefix' => 'thuong-hieu'], function () {
        Route::get('/{slug}', [BrandController::class, 'index'])->where(['slug' => '.+'])->name('brandURL');
    });
    //thuong hiệu
    Route::group(['prefix' => 'destination'], function () {
        Route::get('/{slug}', [TourCategoryController::class, 'detail'])->where(['slug' => '.+'])->name('destinationURL');
    });

    /*custom link: language vú dụ: domain.com/en/...*/
    /*Route::group(['prefix' => '{language}'], function () {
        Route::get('/about-us', [PageController::class, 'aboutUs']);
        Route::get('/lien-he', [ContactController::class, 'get']);
        Route::post('/lien-he', [ContactController::class, 'store']);
        Route::get('/tim-kiem', [CategoryController::class, 'search'])->name('search');
    }); */
    //hệ thống cửa hàng
    /*Route::group(['prefix' => '/he-thong-cua-hang'], function () {
        Route::get('/', [AddressController::class, 'index'])->name('addressFrontend.index');
        Route::post('getLocationstore', [AddressController::class, 'getLocationFrontend'])->name('addressFrontend.getLocation');
    }); */
});
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
// Route::post('/danh-muc-san-pham/filter', [CategoryController::class, 'filter'])->name('productCategoryFrontend.filter');
Route::get('/{slug}')->where(['slug' => '.+'])->name('routerURL');
