<?php

declare(strict_types=1);

namespace app\Http\Middleware;

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
        if ($request->routeIs('admin.*')) {
            return route('admin.login');
        } elseif ($request->routeIs('vendor.*')) {
            return route('vendor.dashboard');
        } else {
            return route('login');
        }
    }
}
