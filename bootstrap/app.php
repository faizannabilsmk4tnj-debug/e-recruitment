<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        \App\Console\Commands\CheckVacancyDeadlines::class,
        \App\Console\Commands\TestMail::class,
        \App\Console\Commands\FixPasswords::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\DetectDeletedUser::class,
        ]);
        $middleware->redirectGuestsTo(function ($request) {
            if (str_starts_with($request->path(), 'hr/')) {
                return '/hr/login';
            }
            return route('login');
        });
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Database\QueryException $e) {
            // Catch MySQL privilege errors (e.g. 1142 SELECT/INSERT/UPDATE command denied to user)
            if ($e->getCode() === '42000' || str_contains($e->getMessage(), '1142') || str_contains($e->getMessage(), 'command denied')) {
                return response()->view('errors.db_privilege_denied', [
                    'exception' => $e
                ], 403);
            }
        });
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule): void {
        $schedule->command('app:check-vacancy-deadlines')->daily();
    })->create();
