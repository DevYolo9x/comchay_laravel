<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        //kiem tra neu dang nhap roi thi quay tro lai trang dashboard
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                //return redirect(RouteServiceProvider::HOME);
                if ($guard === 'customer') {
                    return redirect()->route('homepage.index');
                }
                return redirect()->route('admin.dashboard');
            }
        }
        return $next($request);
    }
}
