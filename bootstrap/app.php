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
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'trainer' => \App\Http\Middleware\TrainerMiddleware::class,
    ]);
    
    // CRITICAL: Disable CSRF for PayU callbacks
    $middleware->validateCsrfTokens(except: [
        '/payment/success',
        '/payment/failure',
           // Gym Membership PayU Callback Routes
    '/member/membership-payment-success',
    '/member/membership-payment-failure',

    // Optional (recommended)
    'member/membership-payment-success',
    'member/membership-payment-failure',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();