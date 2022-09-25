<?php

use App\Http\Controllers\product\frontend\AjaxController;
use App\Http\Controllers\tour\frontend\AjaxController as TourAjaxController;
use App\Http\Controllers\tour\frontend\TourCategoryController;
use App\Http\Controllers\address\frontend\AddressController;
use App\Http\Controllers\contact\frontend\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\product\frontend\CartController;

Route::group(['middleware' => 'locale'], function () {
    Route::group(['prefix' => 'ajax/product'], function () {
        //product quick view
        Route::post('/quick-view', [AjaxController::class, 'quick_view']);
        Route::post('/get-version-product', [AjaxController::class, 'getversion']);
        Route::post('/get-version-product', [AjaxController::class, 'getversion']);
        Route::post('/product-filter', [AjaxController::class, 'product_filter']);
        Route::post('/product-sizes', [AjaxController::class, 'product_sizes']);
    });
    Route::group(['prefix' => 'ajax/cart'], function () {
        //product quick view
        Route::post('/addtocart', [CartController::class, 'addtocart']);
        Route::post('/updatecart', [CartController::class, 'updatecart'])->name('cart.updatecart');
        Route::post('/removecart', [CartController::class, 'removecart'])->name('cart.removecart');
        Route::post('/addcounpon', [CartController::class, 'addcounpon']);
        Route::post('/deletecoupon', [CartController::class, 'deletecoupon']);
    });
    Route::group(['prefix' => 'tour'], function () {
        //product quick view
        Route::post('/book-tour', [TourAjaxController::class, 'bookTour'])->name('bookTour.frontend');
        Route::post('/tour-filter', [TourCategoryController::class, 'filter'])->name('filterTour.frontend');
        Route::post('/tour-inquiry-store', [TourAjaxController::class, 'inquiryTour'])->name('inquiry.store');
    });
    Route::group(['prefix' => 'ajax/address'], function () {
        //product quick view
        Route::post('/', [AddressController::class, 'getAddressFrontend'])->name('getAddressFrontend');
    });
    Route::group(['prefix' => 'ajax/contact'], function () {
        //product quick view
        Route::post('/subcribers', [ContactController::class, 'subcribers'])->name('subcribersContact');
        Route::post('/books', [ContactController::class, 'books'])->name('booksContact');
    });
});
