<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class SuperAdmin
{
    public function handle($request, Closure $next)
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        }); 

        return redirect()->route('admin.dashboard')->with('unsuccess', "You don't have access to that section");
    }
}
