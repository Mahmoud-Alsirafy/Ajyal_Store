<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__ . '/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        // apiPrefix: 'api/v1',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.type' => \App\Http\Middleware\CheckUserType::class,
            'update_active' => \App\Http\Middleware\UpdateUserLastActive::class,
            'mark_read' => \App\Http\Middleware\MarkNotificationAsRead::class, // this one
            'money' => App\Helpers\Currency::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // '/webhook/callback',
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\MarkNotificationAsRead::class,
        ]);
        $middleware->api(append: [
            \App\Http\Middleware\CheckApiToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();