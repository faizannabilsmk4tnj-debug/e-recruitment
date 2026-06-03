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
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);

        // Ketika user sudah login tapi mencoba akses halaman guest (login/register),
        // redirect ke dashboard yang sesuai dengan role-nya
        \Illuminate\Auth\Middleware\RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (auth()->check()) {
                return auth()->user()->role === 'hr'
                    ? '/hr/dashboard'
                    : '/pelamar/dashboard';
            }
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
