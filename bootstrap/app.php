<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\{
    Locale,
    SuperAdmin,
};

use Spatie\Permission\Middleware\{
    PermissionMiddleware,
    RoleMiddleware,
    RoleOrPermissionMiddleware
};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api/v1',
        health: '/up',
        then: function () {
            Route::prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Locale middleware
        $middleware->use([
            Locale::class,
        ]);

        $middleware->alias([
            'role'               => RoleMiddleware::class,
            'permission'         => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'super'              => SuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
    })->create();
