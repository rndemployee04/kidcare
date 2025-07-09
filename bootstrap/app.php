<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register custom middleware
        $middleware->alias([
            'parent.registration.complete' => \App\Http\Middleware\EnsureParentRegistrationComplete::class,
            'parent.verified' => \App\Http\Middleware\EnsureParentVerified::class,
            'carebuddy.registration.complete' => \App\Http\Middleware\EnsureCarebuddyRegistrationComplete::class,
            'carebuddy.verified' => \App\Http\Middleware\EnsureCarebuddyVerified::class,
            'carebuddy.role' => \App\Http\Middleware\EnsureCarebuddyRole::class,
            'admin.verified' => \App\Http\Middleware\EnsureAdminVerified::class,
            'role.redirect' => \App\Http\Middleware\CheckRoleAndRedirect::class,
            'playpal.registration.complete' => \App\Http\Middleware\EnsurePlayPalRegistrationComplete::class,
            'playpal.verified' => \App\Http\Middleware\EnsurePlayPalVerified::class,
            'playpal.role' => \App\Http\Middleware\EnsurePlayPalRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
