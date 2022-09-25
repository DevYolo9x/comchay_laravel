<?php
if(!empty($url) && count($url) == 3){
    if($url[1] == 'language'){
        if($url[2] == 'vi' || $url[2] == 'en'){
            config(['app.locale' => $url[1]]);
        }
    }else{
        if($url[1] == 'vi' || $url[1] == 'en'){
            //chuyển ngôn ngữ
            config(['app.locale' => $url[1]]);
            $_url = explode('?', $url[2]);
            $checkURL = DB::table('router')->select('module','alanguage')->where('alanguage', config('app.locale'))->where('slug', $_url[0])->first();
            if (!empty($checkURL)) {
                if ($checkURL->module == 'category_products') {
                    Route::get('/{slug}', [CategoryControllerProduct::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
                }
                if ($checkURL->module == 'products') {
                    Route::get('/{slug}', [ProductController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
                }
                if ($checkURL->module == 'category_articles') {
                    Route::get('/{slug}', [CategoryControllerArticle::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');

                }
                if ($checkURL->module == 'articles') {
                    Route::get('/{slug}', [ArticleController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
                }
            }else{
                if($_url[0] != '' && $_url[0] != 'story' && $_url[0] != 'contact' && $_url[0] != 'lien-he' && $_url[0] != 'sitemap.xml' && $_url[0] != 'tailoring' && $_url[0] != 'promotion'){
                    abort(404);
                }
            }
        }else{
            abort(404);
        }
    }

}else if (!empty($url) && count($url) == 2) {
    $_url = explode('?', $url[1]);
    $checkURL = DB::table('router')->select('module','alanguage')->where('alanguage', config('app.locale'))->where('slug', $_url[0])->first();
    if (!empty($checkURL)) {

        if ($checkURL->module == 'category_products') {
            Route::get('/{slug}', [CategoryControllerProduct::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
        }
        if ($checkURL->module == 'products') {
            Route::get('/{slug}', [ProductController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
        }

        if ($checkURL->module == 'category_articles') {
            Route::get('/{slug}', [CategoryControllerArticle::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');

        }
        if ($checkURL->module == 'articles') {
            Route::get('/{slug}', [ArticleController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
        }

        /*
        if ($checkURL->module == 'tour_categories') {
            Route::get('/{slug}', [TourCategoryController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
        }
        if ($checkURL->module == 'tours') {
            Route::get('/{slug}', [TourController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
        }*/
    }else{
        if($_url[0] != '' && $_url[0] != 'story' && $_url[0] != 'contact' && $_url[0] != 'lien-he' && $_url[0] != 'sitemap.xml' && $_url[0] != 'tailoring' && $_url[0] != 'promotion'){
            abort(404);
        }
    }
}
?>


//check bảng router
if(!empty($segment_1)){
if($segment_1 == 'en' || $segment_1 == 'vi'){
config(['app.locale' => $segment_1]);
$_url = explode('?', $request->segment(2));
}else if($segment_1 == 'language') {
config(['app.locale' => $request->segment(2)]);
$_url = explode('?', $segment_1);
}else{
$_url = explode('?', $segment_1);
}
$checkURL = DB::table('router')->select('module','alanguage')->where('slug', $_url[0])->first();
if (!empty($checkURL)) {
if ($checkURL->module == 'category_products') {
Route::get('/{slug}', [CategoryControllerProduct::class, 'index'])->middleware('web')->where(['slug' =>
'.+'])->name('routerURL');
}
if ($checkURL->module == 'products') {
Route::get('/{slug}', [ProductController::class, 'index'])->middleware('web')->where(['slug' =>
'.+'])->name('routerURL');
}

if ($checkURL->module == 'category_articles') {
Route::get('/{slug}', [CategoryControllerArticle::class, 'index'])->middleware('web')->where(['slug' =>
'.+'])->name('routerURL');

}
if ($checkURL->module == 'articles') {
Route::get('/{slug}', [ArticleController::class, 'index'])->middleware('web')->where(['slug' =>
'.+'])->name('routerURL');
}
}else{
if($_url[0] != '' &&
$_url[0] != 'sitemap.xml' &&
$_url[0] != 'ajax' &&
$_url[0] != 'contact' &&
$_url[0] != 'lien-he' &&
$_url[0] != 'tim-kiem' &&
$_url[0] != 'search' &&
$_url[0] != 'search-tours' &&
$_url[0] != 'thanh-vien' &&
$_url[0] != 'gio-hang' &&
$_url[0] != 'order' &&
$_url[0] != 'comment' &&
$_url[0] != 'tag' &&
$_url[0] != 'thuong-hieu' &&
$_url[0] != 'destination' &&
$_url[0] != 'danh-muc-san-pham' &&
$_url[0] != 'tour' &&
$_url[0] != 'tp-admin' &&
$_url[0] != 'language' &&
$_url[0] != 'tours' &&
$_url[0] != 'destination' &&
$_url[0] != 'story' &&
$_url[0] != 'tailoring' &&
$_url[0] != '
promotion'){
abort(404);
}
}
}