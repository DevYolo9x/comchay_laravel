<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\article\frontend\CategoryController as CategoryControllerArticle;
use App\Http\Controllers\article\frontend\ArticleController;
use App\Http\Controllers\briefing\frontend\BriefingCategoryController;
use App\Http\Controllers\product\frontend\CategoryController as CategoryControllerProduct;
use App\Http\Controllers\product\frontend\ProductController;

use App\Http\Controllers\tour\frontend\TourCategoryController;
use App\Http\Controllers\tour\frontend\TourController;

use App\Http\Controllers\media\frontend\CategoryController as CategoryControllerMedia;
use  App\Http\Controllers\media\frontend\MediaController;

use App\Http\Controllers\components\ComponentsController;
use Session;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function (Request $request) {

            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web-backend.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web-ajax.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web-frontend.php'));

            $segment = explode('/', $request->getRequestUri());
            if (!empty($segment)) {
                if (count($segment) == 3 || count($segment) == 2) {
                    if ($segment[1] == 'en' || $segment[1] == 'vi') {
                        $_url = explode('?', $segment[2]);
                        $checkURL = DB::table('router')->select('module')->where('slug', $_url[0])->where('alanguage', $segment[1])->first();
                    } else {
                        $_url = explode('?', $segment[1]);
                        $checkURL = DB::table('router')->select('module')->where('slug', $_url[0])->first();
                    }
                    if (!empty($checkURL)) {
                        /*
                        if ($checkURL->module == 'category_products') {
                            Route::get('/{slug}', [CategoryControllerProduct::class, 'index'])->middleware(['web', 'locale', 'auth:customer'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'products') {
                            Route::get('/{slug}', [ProductController::class, 'index'])->middleware(['web', 'locale', 'auth:customer'])->where(['slug' => '.+'])->name('routerURL');
                        } */
                        if ($checkURL->module == 'briefing_categories') {
                            Route::get('/{slug}', [BriefingCategoryController::class, 'index'])->middleware(['web', 'locale', 'auth:customer'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'category_articles') {
                            Route::get('/{slug}', [CategoryControllerArticle::class, 'index'])->middleware(['web', 'locale', 'auth:customer'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'articles') {
                            Route::get('/{slug}', [ArticleController::class, 'index'])->middleware(['web', 'locale', 'auth:customer'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        /*
                         if ($checkURL->module == 'category_media') {
                            Route::get('/{slug}', [CategoryControllerMedia::class, 'index'])->middleware(['web','locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'media') {
                            Route::get('/{slug}', [MediaController::class, 'index'])->middleware(['web','locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'tour_categories') {
                            Route::get('/{slug}', [TourCategoryController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'tours') {
                            Route::get('/{slug}', [TourController::class, 'index'])->middleware('web')->where(['slug' => '.+'])->name('routerURL');
                        }*/
                    }
                }
            }
        });
    }
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
