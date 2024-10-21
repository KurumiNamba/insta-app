<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Option 1
        $middleware->appendToGroup('admin', [AdminMiddleware::class]);

        // Option 2 (If we adopt this option, line no.6 is not needed.)
        // $middleware->appendToGroup('admin', 'App\Http\Middleware\AdminMiddleware');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
