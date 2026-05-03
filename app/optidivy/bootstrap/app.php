<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'klient'       => \App\Http\Middleware\EnsureKlient::class,
            'optometrista' => \App\Http\Middleware\EnsureOptometrista::class,
            'manager'      => \App\Http\Middleware\EnsureManager::class,
            'technik'      => \App\Http\Middleware\EnsureTechnician::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
