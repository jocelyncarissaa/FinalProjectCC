<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Routing;

return Application::configure(basePath: dirname(__DIR__))

    // ->withRouting(
    //     web: __DIR__.'/../routes/web.php',
    //     commands: __DIR__.'/../routes/console.php',
    //     health: '/up',
    // )

// Routing
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        // api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
// Middleware
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([ //mendaftarkan alias 'admin'
            // 'auth'    => \App\Http\Middleware\Authenticate::class,
            // 'guest'   => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'admin'   => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })


    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
