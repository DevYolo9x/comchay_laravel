<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            if (
                $request->routeIs('customer.*') ||
                $request->routeIs('homepage.*') ||
                $request->routeIs('search.*') ||
                $request->routeIs('contactFrontend.*') ||
                $request->routeIs('commentFrontend.*') ||
                $request->routeIs('replyComment.*') ||
                $request->routeIs('getListComment.*') ||
                $request->routeIs('components.*') ||
                $request->routeIs('image.*') ||
                $request->routeIs('chude.*') ||
                $request->routeIs('routerURL')
            ) {
                return route('customer.login');
            }
            return route('admin.login');
        }
    }
}
