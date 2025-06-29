<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
    basePath: dirname(__DIR__)
)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
    // CSRF-исключения
    $middleware->validateCsrfTokens(except: [
        'cookie-consent',
    ]);

    // Middleware для группы 'web'
    $middleware->web(append: [
        \Spatie\CookieConsent\CookieConsentMiddleware::class,
    ]);

    // Алиасы
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);

    // Глобальные middleware
    $middleware->append([
        \Illuminate\Http\Middleware\HandleCors::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        // Обработка исключений (можно настроить)
    })
    ->create();
