<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
        $guards = $guards === [] ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if ($guard == "admin") {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }

                if ($guard == "client") {
                    return redirect(RouteServiceProvider::CLIENT_HOME);
                }
                // dd($guard);

                return $next($request);
            }
        }
    }
}
