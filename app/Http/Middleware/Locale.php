<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Arr;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $segments = request()->segments();
        $last  = end($segments);
        $first = reset($segments);
        if ($first) {
            if ($first == 'vi' || $first == 'en') {
                Session::put('language', $first);
                Session::save();
                config(['app.locale' => $first]);
            } else {
                $language = Session::get('language', config('app.locale'));
                config(['app.locale' => $language]);
            }
        } else {
            // Lấy dữ liệu lưu trong Session, không có thì trả về default lấy trong config
            $language = Session::get('language', config('app.locale'));
            config(['app.locale' => $language]);
        }
        return $next($request);
    }
}
