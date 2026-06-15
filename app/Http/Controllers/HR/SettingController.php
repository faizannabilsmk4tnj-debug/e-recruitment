<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\UpdateLanguageRequest;
use App\Http\Requests\HR\UpdateNotificationPreferenceRequest;
use App\Http\Requests\HR\UpdatePasswordRequest;
use App\Http\Requests\HR\UpdateProfileRequest;
use App\Models\NotificationPreference;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman setting HR.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil atau buat profile jika belum ada
        $profile = UserProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => '',
                'address' => '',
                'city' => '',
                'province' => '',
            ]
        );

        // Ambil atau buat preferensi notifikasi jika belum ada
        $notifPrefs = NotificationPreference::firstOrCreate(
            ['user_id' => $user->id],
            [
                'notif_new_applicant' => true,
                'notif_interview_schedule' => true,
                'notif_vacancy_capacity' => true,
                'notif_vacancy_deadline' => true,
            ]
        );

        // Ambil sesi aktif dari DB (SESSION_DRIVER=database)
        $rawSessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->get();

        $currentSessionId = $request->session()->getId();

        $sessions = $rawSessions->map(function ($session) use ($currentSessionId) {
            return [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'device' => $this->parseUserAgent($session->user_agent),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'is_current' => $session->id === $currentSessionId,
            ];
        })->sortByDesc('is_current')->values();

        return view('hr.setting', compact('user', 'profile', 'notifPrefs', 'sessions'));
    }

    /**
     * Update data profil & avatar.
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?: UserProfile::firstOrCreate(['user_id' => $user->id]);

        $validated = $request->validated();

        // Update User
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'job_title' => $validated['job_title'] ?? null,
        ]);

        // Update Avatar jika diunggah
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($profile->avatar_url) {
                $oldPath = str_replace('/storage/', '', $profile->avatar_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar_url = Storage::url($path);
        }

        // Simpan updated_at pada profile
        $profile->updated_at = now();
        $profile->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'avatar_url' => $profile->avatar_url,
            'name' => $user->name,
            'job_title' => $user->job_title,
        ]);
    }

    /**
     * Hapus avatar.
     */
    public function removeAvatar()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile && $profile->avatar_url) {
            $oldPath = str_replace('/storage/', '', $profile->avatar_url);
            Storage::disk('public')->delete($oldPath);
            $profile->avatar_url = null;
            $profile->updated_at = now();
            $profile->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully!',
        ]);
    }

    /**
     * Ganti password.
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $user->update([
            'password' => $validated['password'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!',
        ]);
    }

    /**
     * Update preferensi notifikasi.
     */
    public function updateNotifications(UpdateNotificationPreferenceRequest $request)
    {
        $user = Auth::user();
        $notifPrefs = $user->notificationPreference ?: NotificationPreference::firstOrCreate(['user_id' => $user->id]);

        $notifPrefs->update([
            'notif_new_applicant' => $request->boolean('notif_new_applicant'),
            'notif_interview_schedule' => $request->boolean('notif_interview_schedule'),
            'notif_vacancy_capacity' => $request->boolean('notif_vacancy_capacity'),
            'notif_vacancy_deadline' => $request->boolean('notif_vacancy_deadline'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated successfully!',
        ]);
    }

    /**
     * Update bahasa interface.
     */
    public function updateLanguage(UpdateLanguageRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        $user->update([
            'language' => $validated['language'],
        ]);

        App::setLocale($validated['language']);
        $request->session()->put('locale', $validated['language']);

        return response()->json([
            'success' => true,
            'message' => 'Language preference updated successfully!',
        ]);
    }

    /**
     * Logout dari sesi / device tertentu.
     */
    public function logoutDevice(Request $request, $sessionId)
    {
        $user = Auth::user();

        // Jangan izinkan logout dari sesi saat ini lewat endpoint ini
        if ($sessionId === $request->session()->getId()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot log out of the current session here. Use standard logout instead.',
            ], 400);
        }

        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out of device successfully!',
        ]);
    }

    /**
     * Logout dari seluruh sesi/device lain.
     */
    public function logoutAllDevices(Request $request)
    {
        $user = Auth::user();
        $currentSessionId = $request->session()->getId();

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out of all other devices successfully!',
        ]);
    }

    /**
     * Helper parser User Agent sederhana.
     */
    private function parseUserAgent($userAgent)
    {
        $os = 'Unknown OS';
        $browser = 'Unknown Browser';

        if (empty($userAgent)) {
            return "$os — $browser";
        }

        // OS Detection
        if (preg_match('/windows|win32/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/iphone|ipad/i', $userAgent)) {
            $os = 'iOS Device';
        } elseif (preg_match('/android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $os = 'Linux';
        }

        // Browser Detection
        if (preg_match('/chrome/i', $userAgent) && !preg_match('/edge|edg/i', $userAgent) && !preg_match('/opr/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/safari/i', $userAgent) && !preg_match('/chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/edge|edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/opr/i', $userAgent)) {
            $browser = 'Opera';
        }

        return "$os — $browser";
    }
}
