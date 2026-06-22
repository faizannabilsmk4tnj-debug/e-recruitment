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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.pelamar', 'pelamar.profil'], function ($view) {
            $persentase = 0;
            if (Auth::check()) {
                $userId = Auth::id();
                $poin = 0;

                $profile = DB::table('user_profiles')->where('user_id', $userId)->first();
                $user    = DB::table('users')->where('id', $userId)->first();

                if ($profile) {
                    if (!empty($profile->avatar_url))   $poin += 5;
                    if (!empty($user->name))            $poin += 3;
                    if (!empty($profile->gender))       $poin += 2;
                    if (!empty($user->phone))           $poin += 3;
                    if (!empty($user->email))           $poin += 2;
                    if (!empty($profile->birth_date))   $poin += 3;
                    if (!empty($profile->address))      $poin += 4;
                    if (!empty($profile->city))         $poin += 2;
                    if (!empty($profile->province))     $poin += 2;
                    if (!empty($profile->bio))          $poin += 3;
                    if (!empty($profile->linkedin_url)) $poin += 3;

                    $latestEdu = DB::table('educations')->where('user_id', $userId)->exists();
                    if ($latestEdu) $poin += 3;
                }

                $education = DB::table('educations')
                    ->where('user_id', $userId)
                    ->whereNotNull('institution')
                    ->whereNotNull('degree')
                    ->exists();
                if ($education) $poin += 20;

                $portfolio = DB::table('portofolio')
                    ->where('user_id', $userId)
                    ->exists();
                if ($portfolio) $poin += 15;

                $workExp = DB::table('work_experiences')
                    ->where('user_id', $userId)
                    ->exists();
                if ($workExp) $poin += 15;

                $sertifikat = DB::table('applicant_skills')
                    ->where('user_id', $userId)
                    ->whereNotNull('cert_file_path')
                    ->exists();
                if ($sertifikat) $poin += 5;

                $persentase = min($poin, 100);
            }

            $view->with('persentase', $persentase);
        });
    }
}
