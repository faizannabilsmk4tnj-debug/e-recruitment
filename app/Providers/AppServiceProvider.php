<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('local')) {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            } catch (\Exception $e) {
                // Silently catch exceptions to prevent crash if database is temporarily unavailable
            }
        }

        View::composer(['layouts.pelamar', 'pelamar.profil'], function ($view) {
            $persentase = 0;
            if (Auth::check()) {
                $persentase = Auth::user()->getProfileCompletionPercentage();
            }

            $view->with('persentase', $persentase);
        });
    }
}
