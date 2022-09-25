<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Passport\Passport;
use View;
use App\Models\Menu;
use App\Models\MenuItem;
use Cache;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Passport::routes();
        View::composer('homepage.*', function ($view) {
            $menu_id = \App\Models\Menu::where('slug', 'menu-header')->pluck('id');
            $menu_header =  \App\Models\MenuItem::where('menu_id', $menu_id)->where('parentid', 0)->orderBy('order')->where('alanguage', config('app.locale'))->with('children')->get();
            $view->with('menu_header', $menu_header);
        });
        View::composer(['homepage.*', 'cart.*'], function ($view) {
            $cart = [];
            $cart['cart'] = Session::get('cart');
            $total = $quantity = 0;
            if (isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart']) > 0) {
                foreach ($cart['cart'] as $k => $item) {
                    $total += $item['quantity'] * $item['price'];
                    $quantity += $item['quantity'];
                }
            }
            $cart['total'] = $total;
            $cart['quantity'] = $quantity;
            $view->with('cart', $cart);
        });
        // cấu hình thời gian sống cho refresh tokens và access tokens
        // Passport::tokensExpireIn(Carbon::now()->addDays(15));
        // Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        // loại bỏ các tokens
        //Passport::pruneRevokedTokens();
    }
}
