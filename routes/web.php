<?php

use App\Http\Controllers\ApplicantCvController;
use App\Http\Controllers\ApplicantEducationController;
use App\Http\Controllers\ApplicantLampiranController;
use App\Http\Controllers\ApplicantOrganizationExperienceController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\ApplicantWorkExperienceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HrCvTemplateController;
use App\Http\Controllers\HR\SettingController;
use App\Http\Controllers\HR\JobPostingController;
use App\Http\Controllers\HR\DashboardController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes - Hanya return view, tidak ada logic
|--------------------------------------------------------------------------
*/

// ===== PUBLIK (tanpa login) =====
Route::get('/', function () {
    $categories = \App\Models\JobCategory::where('is_active', true)
        ->withCount('jobPostings')
        ->take(8)
        ->get();

    $latestJobs = \App\Models\JobPosting::where('status', 'open')
        ->with('category')
        ->latest()
        ->take(5)
        ->get();

    return view('landing', compact('categories', 'latestJobs'));
});
Route::get('/tentang-kami', function () { return view('tentang-kami'); });
Route::get('/lowongan',                       [VacancyController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{id}',                  [VacancyController::class, 'show'])->name('lowongan.show')->where('id', '[0-9]+');

// Route bantu development: akses /logout-now di browser untuk clear sesi
if (app()->environment('local')) {
    Route::get('/logout-now', function () {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    });
}

// ===== AUTH =====
Route::get('/login',            fn() => view('auth.login'))->name('login');
Route::post('/login',           [AuthController::class, 'loginApplicant']);
Route::get('/register',         fn() => view('auth.register'))->name('register');
Route::post('/register',        [AuthController::class, 'register']);
Route::get('/forgot-password',  fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',  [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/hr/login', fn() => view('hr.login'));
Route::post('/hr/login', [AuthController::class, 'loginHr']);
Route::get('/hr/deactivated', function () {
    if (!Auth::check() || Auth::user()->is_active) {
        return redirect('/hr/login');
    }
    return view('hr.deactivated');
})->name('hr.deactivated');
Route::get('/hr/logout-deactivated', function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return redirect('/hr/login')->with('auth_warning', 'Akun Anda telah dinonaktifkan oleh HR Master.');
})->name('hr.logout-deactivated');
Route::get('/hr/logout-deleted', function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return redirect('/hr/login')->with('auth_warning', 'Akun HR Anda telah dihapus oleh HR Master.');
})->name('hr.logout-deleted');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===== NOTIFICATION API (shared, auth-gated) =====
Route::middleware('auth')->group(function () {
    Route::get('/api/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/api/notifications/read-all',    [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::post('/api/notifications/{id}/read',   [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// ===== PELAMAR — harus login dan role=applicant =====
Route::middleware(['auth', 'role:applicant'])->group(function () {

    Route::get('/pelamar/dashboard',           [PelamarController::class, 'dashboard'])->name('pelamar.dashboard');
    Route::get('/pelamar/profil',              [ApplicantProfileController::class, 'edit'])->name('pelamar.profil.edit');
    Route::put('/pelamar/profil',              [ApplicantProfileController::class, 'update'])->name('pelamar.profil.update');
    Route::delete('/pelamar/profil',           [ApplicantProfileController::class, 'destroy'])->name('pelamar.profil.destroy');
    Route::delete('/pelamar/profil/avatar',    [ApplicantProfileController::class, 'destroyAvatar'])->name('pelamar.profil.avatar.destroy');
    Route::get('/pelamar/pengalaman-kerja', [ApplicantWorkExperienceController::class, 'index'])->name('pelamar.pengalaman-kerja.index');
    Route::get('/pelamar/pengalaman-kerja/tambah', [ApplicantWorkExperienceController::class, 'create'])->name('pelamar.pengalaman-kerja.create');
    Route::post('/pelamar/pengalaman-kerja', [ApplicantWorkExperienceController::class, 'store'])->name('pelamar.pengalaman-kerja.store');
    Route::get('/pelamar/pengalaman-kerja/{workExperience}/edit', [ApplicantWorkExperienceController::class, 'edit'])->name('pelamar.pengalaman-kerja.edit');
    Route::put('/pelamar/pengalaman-kerja/{workExperience}', [ApplicantWorkExperienceController::class, 'update'])->name('pelamar.pengalaman-kerja.update');
    Route::delete('/pelamar/pengalaman-kerja/{workExperience}', [ApplicantWorkExperienceController::class, 'destroy'])->name('pelamar.pengalaman-kerja.destroy');
    Route::get('/pelamar/pendidikan',          [ApplicantEducationController::class, 'index'])->name('pelamar.pendidikan.index');
    Route::get('/pelamar/pendidikan/tambah',   [ApplicantEducationController::class, 'create'])->name('pelamar.pendidikan.create');
    Route::post('/pelamar/pendidikan',         [ApplicantEducationController::class, 'store'])->name('pelamar.pendidikan.store');
    Route::get('/pelamar/pendidikan/{education}/edit', [ApplicantEducationController::class, 'edit'])->name('pelamar.pendidikan.edit');
    Route::put('/pelamar/pendidikan/{education}', [ApplicantEducationController::class, 'update'])->name('pelamar.pendidikan.update');
    Route::delete('/pelamar/pendidikan/{education}', [ApplicantEducationController::class, 'destroy'])->name('pelamar.pendidikan.destroy');
    Route::get('/pelamar/organisasi', [ApplicantOrganizationExperienceController::class, 'index'])->name('pelamar.organisasi.index');
    Route::get('/pelamar/organisasi/tambah', [ApplicantOrganizationExperienceController::class, 'create'])->name('pelamar.organisasi.create');
    Route::post('/pelamar/organisasi', [ApplicantOrganizationExperienceController::class, 'store'])->name('pelamar.organisasi.store');
    Route::get('/pelamar/organisasi/{organizationExperience}/edit', [ApplicantOrganizationExperienceController::class, 'edit'])->name('pelamar.organisasi.edit');
    Route::put('/pelamar/organisasi/{organizationExperience}', [ApplicantOrganizationExperienceController::class, 'update'])->name('pelamar.organisasi.update');
    Route::delete('/pelamar/organisasi/{organizationExperience}', [ApplicantOrganizationExperienceController::class, 'destroy'])->name('pelamar.organisasi.destroy');
    // Lampiran (Skills & Portfolio)
    Route::get('/pelamar/lampiran',                          [ApplicantLampiranController::class, 'index'])->name('pelamar.lampiran');
    // Skills (applicant_skills)
    Route::post('/pelamar/lampiran/skill',                   [ApplicantLampiranController::class, 'skillStore'])->name('pelamar.skill.store');
    Route::patch('/pelamar/lampiran/skill/{skill}',          [ApplicantLampiranController::class, 'skillUpdate'])->name('pelamar.skill.update');
    Route::delete('/pelamar/lampiran/skill/{skill}',         [ApplicantLampiranController::class, 'skillDestroy'])->name('pelamar.skill.destroy');
    // Portofolio
    Route::post('/pelamar/lampiran/portofolio',              [ApplicantLampiranController::class, 'portofolioStore'])->name('pelamar.portofolio.store');
    Route::patch('/pelamar/lampiran/portofolio/{portofolio}',[ApplicantLampiranController::class, 'portofolioUpdate'])->name('pelamar.portofolio.update');
    Route::delete('/pelamar/lampiran/portofolio/{portofolio}',[ApplicantLampiranController::class, 'portofolioDestroy'])->name('pelamar.portofolio.destroy');
    Route::get('/pelamar/cv',                        [ApplicantCvController::class, 'index'])->name('pelamar.cv');
    Route::get('/pelamar/cv/{template}/generate',    [ApplicantCvController::class, 'generate'])->name('pelamar.cv.generate');
    Route::get('/pelamar/status-lamaran',               [PelamarController::class, 'statusLamaran'])->name('pelamar.status-lamaran');
    Route::post('/pelamar/status-lamaran/{id}/withdraw', [PelamarController::class, 'withdrawApplication'])->name('pelamar.status-lamaran.withdraw');
    Route::post('/pelamar/status-lamaran/interview/{id}/confirm', [PelamarController::class, 'confirmInterviewAttendance'])->name('pelamar.status-lamaran.confirm-attendance');
    Route::get('/pelamar/status-lamaran/interview/booked-slots', [PelamarController::class, 'getBookedSlots'])->name('pelamar.status-lamaran.booked-slots');
    Route::post('/pelamar/status-lamaran/interview/{id}/reschedule', [PelamarController::class, 'rescheduleInterviewRequest'])->name('pelamar.status-lamaran.reschedule-interview');
    Route::post('/pelamar/status-lamaran/interview/{id}/decline', [PelamarController::class, 'declineInterview'])->name('pelamar.status-lamaran.decline-interview');
    Route::get('/pelamar/lowongan',            [VacancyController::class, 'index'])->name('pelamar.lowongan.index');
    Route::get('/pelamar/lowongan/{id}',       [VacancyController::class, 'show'])->name('pelamar.lowongan.show')->where('id', '[0-9]+');
    Route::get('/pelamar/review-lamaran/{id}',    [VacancyController::class, 'showReview'])->name('pelamar.review-lamaran');
    Route::post('/pelamar/review-lamaran/{id}',   [VacancyController::class, 'submitApplication'])->name('pelamar.review-lamaran.submit');
    Route::get('/pelamar/lowongan-tersimpan', [PelamarController::class, 'savedJobs'])->name('pelamar.lowongan-tersimpan');
    Route::post('/pelamar/lowongan/{id}/toggle-save', [PelamarController::class, 'toggleSaveJob'])->name('pelamar.lowongan.toggle-save');
    Route::get('/pelamar/application-submitted', fn() => view('pelamar.application-submitted'))->name('pelamar.application-submitted');
    Route::get('/pelamar/lamaran-terkirim', fn() => redirect('/pelamar/application-submitted'));


});

// ===== HR — harus login dan role=hr =====
Route::middleware(['role:hr', 'auth'])->group(function () {

    Route::get('/hr/dashboard',                  [DashboardController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr/setting',                    [SettingController::class, 'index'])->name('hr.setting');
    Route::post('/hr/setting/profile',           [SettingController::class, 'updateProfile'])->name('hr.setting.profile');
    Route::post('/hr/setting/avatar/remove',     [SettingController::class, 'removeAvatar'])->name('hr.setting.avatar.remove');
    Route::post('/hr/setting/password',          [SettingController::class, 'updatePassword'])->name('hr.setting.password');
    Route::post('/hr/setting/notifications',     [SettingController::class, 'updateNotifications'])->name('hr.setting.notifications');
    Route::delete('/hr/setting/session/{id}',    [SettingController::class, 'logoutDevice'])->name('hr.setting.session.destroy');
    Route::delete('/hr/setting/sessions',        [SettingController::class, 'logoutAllDevices'])->name('hr.setting.sessions.destroy');
    // HR Team Management (Only accessible by HR Master)
    Route::middleware('role:hr_master')->group(function () {
        Route::get('/hr/tim',                        [App\Http\Controllers\HR\TeamController::class, 'index'])->name('hr.tim.index');
        Route::post('/hr/tim',                       [App\Http\Controllers\HR\TeamController::class, 'store'])->name('hr.tim.store');
        Route::put('/hr/tim/{id}',                   [App\Http\Controllers\HR\TeamController::class, 'update'])->name('hr.tim.update');
        Route::delete('/hr/tim/{id}',                [App\Http\Controllers\HR\TeamController::class, 'destroy'])->name('hr.tim.destroy');
        Route::post('/hr/tim/{id}/toggle-status',    [App\Http\Controllers\HR\TeamController::class, 'toggleStatus'])->name('hr.tim.toggle-status');
    });
    Route::get('/hr/lowongan',                   [JobPostingController::class, 'index'])->name('hr.lowongan.index');
    Route::get('/hr/lowongan/buat',              [JobPostingController::class, 'create'])->name('hr.lowongan.create');
    Route::post('/hr/lowongan',                  [JobPostingController::class, 'store'])->name('hr.lowongan.store');
    Route::post('/hr/lowongan/kategori',         [JobPostingController::class, 'storeCategory'])->name('hr.lowongan.store-category');
    Route::delete('/hr/lowongan/kategori/{id}',  [JobPostingController::class, 'destroyCategory'])->name('hr.lowongan.destroy-category')->where('id', '[0-9]+');
    Route::post('/hr/lowongan/lokasi',           [JobPostingController::class, 'storeLocation'])->name('hr.lowongan.store-location');
    Route::delete('/hr/lowongan/lokasi/{id}',    [JobPostingController::class, 'destroyLocation'])->name('hr.lowongan.destroy-location')->where('id', '[0-9]+');
    Route::get('/hr/lowongan/{id}',              [JobPostingController::class, 'show'])->name('hr.lowongan.show')->where('id', '[0-9]+');
    Route::put('/hr/lowongan/{id}',              [JobPostingController::class, 'update'])->name('hr.lowongan.update')->where('id', '[0-9]+');
    Route::post('/hr/lowongan/{id}/status',      [JobPostingController::class, 'updateStatus'])->name('hr.lowongan.status')->where('id', '[0-9]+');
    Route::get('/hr/pelamar',                    [\App\Http\Controllers\HR\PelamarController::class, 'index'])->name('hr.pelamar.index');
    Route::get('/hr/pelamar/{id}',               [\App\Http\Controllers\HR\PelamarController::class, 'show'])->name('hr.pelamar.show')->where('id', '[0-9]+');
    Route::get('/hr/pelamar/{id}/cv-preview',    [\App\Http\Controllers\HR\PelamarController::class, 'cvPreview'])->name('hr.pelamar.cv-preview')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/{id}/status',       [\App\Http\Controllers\HR\PelamarController::class, 'updateStatus'])->name('hr.pelamar.status')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/lowongan/{id}/mark-seen', [\App\Http\Controllers\HR\PelamarController::class, 'markSeen'])->name('hr.pelamar.mark-seen')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/lowongan/{id}/archive',   [\App\Http\Controllers\HR\PelamarController::class, 'archive'])->name('hr.pelamar.archive')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/{id}/toggle-privilege', [\App\Http\Controllers\HR\PelamarController::class, 'togglePrivilege'])->name('hr.pelamar.toggle-privilege')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/{id}/note',         [\App\Http\Controllers\HR\PelamarController::class, 'addNote'])->name('hr.pelamar.note')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/{id}/interview',    [\App\Http\Controllers\HR\PelamarController::class, 'scheduleInterview'])->name('hr.pelamar.interview')->where('id', '[0-9]+');
    Route::post('/hr/pelamar/{id}/interview/{interviewId}/evaluate', [\App\Http\Controllers\HR\PelamarController::class, 'evaluateInterview'])->name('hr.pelamar.interview.evaluate')->where(['id' => '[0-9]+', 'interviewId' => '[0-9]+']);
    Route::get('/hr/wawancara/booked-slots',          [\App\Http\Controllers\HR\InterviewController::class, 'getBookedSlots'])->name('hr.wawancara.booked-slots');
    Route::get('/hr/wawancara',                        [\App\Http\Controllers\HR\InterviewController::class, 'calendar'])->name('hr.wawancara.calendar');
    Route::get('/hr/wawancara/daftar',                [\App\Http\Controllers\HR\InterviewController::class, 'index'])->name('hr.wawancara.index');
    Route::post('/hr/wawancara/buat',                  [\App\Http\Controllers\HR\InterviewController::class, 'store'])->name('hr.wawancara.store');
    Route::put('/hr/wawancara/{id}',                   [\App\Http\Controllers\HR\InterviewController::class, 'update'])->name('hr.wawancara.update');
    Route::post('/hr/wawancara/{id}/status',           [\App\Http\Controllers\HR\InterviewController::class, 'updateStatus'])->name('hr.wawancara.update-status');
    Route::post('/hr/wawancara/{id}/reschedule-decision', [\App\Http\Controllers\HR\InterviewController::class, 'rescheduleDecision'])->name('hr.wawancara.reschedule-decision');
    Route::delete('/hr/wawancara/{id}',                [\App\Http\Controllers\HR\InterviewController::class, 'destroy'])->name('hr.wawancara.destroy');
    Route::get('/hr/laporan',                    [\App\Http\Controllers\HR\LaporanController::class, 'index'])->name('hr.laporan');
    // HR CV Template Management (CRUD via HrCvTemplateController)
    Route::get('/hr/template-cv',                           [HrCvTemplateController::class, 'index'])->name('hr.template-cv.index');
    Route::post('/hr/template-cv',                          [HrCvTemplateController::class, 'store'])->name('hr.template-cv.store');
    Route::get('/hr/template-cv/create',                    [HrCvTemplateController::class, 'create'])->name('hr.template-cv.create');
    Route::get('/hr/template-cv/{template}/edit',           [HrCvTemplateController::class, 'edit'])->name('hr.template-cv.editor');
    Route::get('/hr/template-cv/{template}/preview',        [HrCvTemplateController::class, 'preview'])->name('hr.template-cv.preview');
    Route::put('/hr/template-cv/{template}',                [HrCvTemplateController::class, 'update'])->name('hr.template-cv.update');
    Route::patch('/hr/template-cv/{template}/publish',      [HrCvTemplateController::class, 'publish'])->name('hr.template-cv.publish');
    Route::patch('/hr/template-cv/{template}/draft',        [HrCvTemplateController::class, 'setDraft'])->name('hr.template-cv.setDraft');
    Route::patch('/hr/template-cv/{template}/default',      [HrCvTemplateController::class, 'setDefault'])->name('hr.template-cv.setDefault');
    Route::delete('/hr/template-cv/{template}',             [HrCvTemplateController::class, 'destroy'])->name('hr.template-cv.destroy');
});

Route::get('/preview-error/{code}', function ($code) {
    if (!in_array($code, ['403', '404', '419', '500'])) {
        abort(404);
    }
    if ($code == '403') {
        abort(403, 'Anda tidak memiliki hak untuk melihat berkas internal HR.');
    }
    abort((int)$code);
});

// Helper route untuk test cron job / command secara instan dari browser
if (app()->environment('local')) {
    Route::get('/run-deadline-check', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('app:check-vacancy-deadlines');
            return response('<h3>Output Command:</h3><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>');
        } catch (\Exception $e) {
            return response('Error executing command: ' . $e->getMessage(), 500);
        }
    });

    Route::get('/run-migration', function () {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            return response('<h3>Migration Output:</h3><pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>');
        } catch (\Exception $e) {
            return response('Error executing migration: ' . $e->getMessage(), 500);
        }
    });

    Route::get('/run-mail-test', function () {
        try {
            $email = request('email', 'ecogreenjobvacancy@gmail.com');
            
            $output = "Current Mail Default Driver: " . config('mail.default') . "\n";
            $output .= "Host: " . config('mail.mailers.smtp.host') . "\n";
            $output .= "Port: " . config('mail.mailers.smtp.port') . "\n";
            $output .= "Username: " . config('mail.mailers.smtp.username') . "\n";
            $output .= "Scheme: " . config('mail.mailers.smtp.scheme') . "\n\n";
            
            $output .= "Sending test mail to {$email}...\n";
            
            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\PasswordResetMail('http://localhost/reset-password/test-token-123456', 'User Test SMTP'));
            
            $output .= "Success: Mail sent successfully!\n";
            return response('<h3>Mail Test:</h3><pre>' . $output . '</pre>');
        } catch (\Exception $e) {
            return response('<h3>Mail Test Failed:</h3><pre>Error: ' . $e->getMessage() . "\n\n" . $e->getTraceAsString() . '</pre>', 500);
        }
    });

    Route::get('/test-register-and-reset', function () {
        $email = 'nouzenshin@gmail.com';
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => 'Nouzenshin',
                'email' => $email,
                'password_hash' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'applicant',
                'is_active' => true,
            ]);
            $status = "User {$email} created successfully!";
        } else {
            $status = "User {$email} already exists.";
        }

        // Simulate forgot password request
        \Illuminate\Support\Facades\Mail::alwaysTo('ecogreenjobvacancy@gmail.com');
        $request = \Illuminate\Http\Request::create('/forgot-password', 'POST', ['email' => $email]);
        $response = app(AuthController::class)->forgotPassword($request);

        return "<h3>Status:</h3><p>{$status}</p><h3>Forgot Password Response:</h3><pre>" . $response->getContent() . "</pre><p><strong>Email has been redirected and sent to ecogreenjobvacancy@gmail.com</strong></p>";
    });

    Route::get('/trigger-test-notif', function() {
        $hrUsers = \App\Models\User::whereIn('role', ['hr', 'hr_master'])->where('is_active', true)->get();
        if ($hrUsers->isEmpty()) return "No HR found";
        
        foreach ($hrUsers as $hr) {
            // Clear notifications first
            \App\Models\Notification::where('user_id', $hr->id)->where('type', 'vacancy_closed_auto')->delete();
            
            // Trigger Quota
            \App\Services\NotificationService::create(
                $hr->id,
                'vacancy_closed_auto',
                'Lowongan Ditutup (Kuota Penuh)',
                'Lowongan "Accounting Supervisor" telah ditutup otomatis karena kuota pendaftar terpenuhi (5/5).',
                [
                    'job_id' => 1,
                    'job_title' => 'Accounting Supervisor',
                    'reason' => 'quota'
                ]
            );

            // Trigger Deadline
            \App\Services\NotificationService::create(
                $hr->id,
                'vacancy_closed_auto',
                'Lowongan Ditutup (Deadline Lewat)',
                'Lowongan "HR Officer" telah ditutup otomatis karena telah melewati batas tenggat waktu pendaftaran.',
                [
                    'job_id' => 2,
                    'job_title' => 'HR Officer',
                    'reason' => 'deadline'
                ]
            );
        }

        return "<h3>Success!</h3><p>Notifications triggered successfully for all " . $hrUsers->count() . " HR users.</p>";
    });

    Route::get('/test-all-notifications', function() {
        $applicant = \App\Models\User::where('role', 'applicant')->where('email', 'nouzenshin@gmail.com')->first();
        $hr = \App\Models\User::where('role', 'hr_master')->where('email', 'ecogreenhrmaster@gmail.com')->first();
        
        if (!$applicant || !$hr) {
            return "Error: Test users not found. Make sure seeds are run.";
        }

        $results = [];

        // 1. Status change (applicant)
        try {
            \App\Services\NotificationService::create(
                $applicant->id,
                'status_change',
                'Status Lamaran Berubah',
                'Lamaran Anda untuk posisi Backend Developer Laravel telah diperbarui ke status: Shortlisted.',
                ['job_id' => 1]
            );
            $results[] = "SUCCESS: Status change notification created & emailed to {$applicant->email}.";
        } catch (\Exception $e) {
            $results[] = "ERROR (Status Change): " . $e->getMessage();
        }

        // 2. Interview scheduled (applicant)
        try {
            \App\Services\NotificationService::create(
                $applicant->id,
                'interview_scheduled',
                'Jadwal Interview',
                'Interview Online untuk posisi Backend Developer Laravel dijadwalkan pada 15 Jul 2026, 10:00.',
                ['job_id' => 1]
            );
            $results[] = "SUCCESS: Interview scheduled notification created & emailed to {$applicant->email}.";
        } catch (\Exception $e) {
            $results[] = "ERROR (Interview Scheduled): " . $e->getMessage();
        }

        // 3. Interview rescheduled (applicant)
        try {
            \App\Services\NotificationService::create(
                $applicant->id,
                'interview_rescheduled',
                'Jadwal Interview Diperbarui',
                'Jadwal interview Online untuk posisi Backend Developer Laravel diubah menjadi 16 Jul 2026, 11:00.',
                ['job_id' => 1]
            );
            $results[] = "SUCCESS: Interview rescheduled notification created & emailed to {$applicant->email}.";
        } catch (\Exception $e) {
            $results[] = "ERROR (Interview Rescheduled): " . $e->getMessage();
        }

        // 4. Interview cancelled (applicant)
        try {
            \App\Services\NotificationService::create(
                $applicant->id,
                'interview_cancelled',
                'Interview Dibatalkan',
                'Interview Online untuk posisi Backend Developer Laravel pada 16 Jul 2026 telah dibatalkan.',
                ['job_id' => 1]
            );
            $results[] = "SUCCESS: Interview cancelled notification created & emailed to {$applicant->email}.";
        } catch (\Exception $e) {
            $results[] = "ERROR (Interview Cancelled): " . $e->getMessage();
        }

        // 5. Vacancy approaching deadline (HR)
        try {
            \App\Services\NotificationService::create(
                $hr->id,
                'vacancy_deadline',
                'Lowongan Segera Berakhir',
                'Lowongan "DevOps Engineer" akan berakhir dalam 3 hari.',
                ['job_id' => 2]
            );
            $results[] = "SUCCESS: Vacancy deadline notification created & emailed to {$hr->email}.";
        } catch (\Exception $e) {
            $results[] = "ERROR (Vacancy Deadline): " . $e->getMessage();
        }

        // 6. Vacancy closed auto (HR)
        try {
            \App\Services\NotificationService::create(
                $hr->id,
                'vacancy_closed_auto',
                'Lowongan Ditutup (Kuota Penuh)',
                'Lowongan "Social Media Specialist" telah ditutup otomatis karena kuota pendaftar terpenuhi (1/1).',
                ['job_id' => 3]
            );
            $results[] = "SUCCESS: Vacancy closed auto notification created & emailed to {$hr->email}.";
        } catch (\Exception $e) {
            $results[] = "ERROR (Vacancy Closed): " . $e->getMessage();
        }

        // 7. New applicant (HR) -> should NOT email!
        try {
            \App\Services\NotificationService::create(
                $hr->id,
                'new_applicant',
                'Pelamar Baru',
                'Shin melamar posisi Backend Developer Laravel.',
                ['job_id' => 1]
            );
            $results[] = "SUCCESS: New applicant notification created in app for {$hr->email} (No email dispatched, as requested).";
        } catch (\Exception $e) {
            $results[] = "ERROR (New Applicant): " . $e->getMessage();
        }

        return "<h2>Notification and Email Dispatch Test Results</h2><ul><li>" . implode("</li><li>", $results) . "</li></ul>";
    });
}


