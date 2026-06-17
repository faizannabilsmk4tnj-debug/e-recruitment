<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Application;
use App\Models\SavedJob;
use App\Models\Notification;

class PelamarController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $persentase = $this->hitungPersentaseProfil($user->id);

        $totalLamaran = Application::where('user_id', $user->id)->count();
        $aktif        = Application::where('user_id', $user->id)->where('status', 'active')->count();
        $ditolak      = Application::where('user_id', $user->id)->where('status', 'rejected')->count();
        $wawancara    = Application::where('user_id', $user->id)->where('status', 'interview')->count();

        $lamaran      = Application::with('jobPosting')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->take(5)
                            ->get();

        $savedJobs    = SavedJob::with('jobPosting')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->take(3)
                            ->get();

        $notifications = Notification::where('user_id', $user->id)
                            ->latest()
                            ->take(3)
                            ->get();
        $lamaranBulanIni = Application::where('user_id', $user->id)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        return view('pelamar.dashboard', compact(
    'user', 'totalLamaran', 'aktif', 'ditolak', 'wawancara',
    'lamaran', 'savedJobs', 'notifications', 'persentase', 'lamaranBulanIni'
));
    }

    private function hitungPersentaseProfil($userId)
    {
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
            ->where('id_user', $userId)
            ->exists();
        if ($portfolio) $poin += 15;

        $workExp = DB::table('work_experiences')
            ->where('user_id', $userId)
            ->exists();
        if ($workExp) $poin += 15;

        $sertifikat = DB::table('applicant_skills')
            ->where('id_user', $userId)
            ->whereNotNull('cert_url')
            ->exists();
        if ($sertifikat) $poin += 5;

        return min($poin, 100);
    }
}
