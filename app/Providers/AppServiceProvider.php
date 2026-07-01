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
                $user = Auth::user();
                $persentase = $user->getProfileCompletionPercentage();

                // DBA change-detection on web page load
                $sessionKey = 'last_known_privilege_' . $user->id;
                $lastKnown = request()->session()->get($sessionKey);
                $currentPriv = (bool) $user->has_privilege;

                if (is_null($lastKnown)) {
                    request()->session()->put($sessionKey, $currentPriv);
                } elseif ($lastKnown !== $currentPriv) {
                    $notificationService = new \App\Services\NotificationService();
                    $notificationService->notifyPrivilegeChange($user, $currentPriv);
                    request()->session()->put($sessionKey, $currentPriv);
                }
            }

            $view->with('persentase', $persentase);
        });
    }
}
