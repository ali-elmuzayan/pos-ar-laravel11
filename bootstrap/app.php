<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        function(Router $router) {
            $router->middleware(['web'])
                ->group(base_path('routes/web.php'));

            $router->middleware(['web', 'auth', 'admin'])
                ->group(base_path('routes/admin.php'));
        },
//        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
