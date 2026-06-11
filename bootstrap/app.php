<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Clear config cache if it exists (prevents stale config on cloud deploys)
if (file_exists(__DIR__ . '/../bootstrap/cache/config.php')) {
    @unlink(__DIR__ . '/../bootstrap/cache/config.php');
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->validateCsrfTokens(except: [
            '/ongkir/calculate',
            '/ongkir/search',
            '/midtrans/callback', // ← Tambahan: webhook dari server Midtrans tidak punya CSRF token
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();