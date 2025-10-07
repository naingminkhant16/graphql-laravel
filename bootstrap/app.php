<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Nuwave\Lighthouse\LighthouseServiceProvider;
use Nuwave\Lighthouse\Pagination\PaginationServiceProvider;
use Nuwave\Lighthouse\Validation\ValidationServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->registered(function (Application $app): void {
        $app->register(LighthouseServiceProvider::class);
        $app->register(ValidationServiceProvider::class);
//        $app->register(PaginationServiceProvider::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
