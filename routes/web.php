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
use App\Http\Middleware\SetUserLocale;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== PUBLIK (tanpa login) =====
Route::get('/', function () { return view('landing'); });
Route::get('/tentang-kami', function () { return view('tentang-kami'); });
Route::get('/lowongan',                       [VacancyController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{id}',                  [VacancyController::class, 'show'])->name('lowongan.show')->where('id', '[0-9]+');

// Route bantu development: akses /logout-now di browser untuk clear sesi
Route::get('/logout-now', function () {
    auth()->guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// ===== AUTH PELAMAR =====
// Hanya bisa diakses kalau belum login
// Auth routes — GET bisa diakses siapapun, POST diproses controller
Route::get('/login',            fn() => view('auth.login'))->name('login');
Route::post('/login',           [AuthController::class, 'login']);
Route::get('/register',         fn() => view('auth.register'))->name('register');
Route::post('/register',        [AuthController::class, 'register']);
Route::get('/forgot-password',  fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password',  [AuthController::class, 'resetPassword'])->name('password.update');


// ===== AUTH HR =====
// /hr/login bisa diakses siapapun (tidak pakai middleware guest)
Route::get('/hr/login',  fn() => view('hr.login'))->name('hr.login');
Route::post('/hr/login', [AuthController::class, 'hrLogin']);

// Logout (untuk kedua role)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===== PELAMAR — harus login dan role=applicant =====
Route::middleware('role:applicant')->group(function () {

    Route::get('/pelamar/dashboard',           fn() => view('pelamar.dashboard'));
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
    Route::get('/pelamar/status-lamaran',      fn() => view('pelamar.status-lamaran'));
    Route::get('/pelamar/lowongan',            [VacancyController::class, 'index'])->name('pelamar.lowongan.index');
    Route::get('/pelamar/lowongan/{id}',       [VacancyController::class, 'show'])->name('pelamar.lowongan.show')->where('id', '[0-9]+');
    Route::get('/pelamar/review-lamaran/{id}',    [VacancyController::class, 'showReview'])->name('pelamar.review-lamaran');
    Route::post('/pelamar/review-lamaran/{id}',   [VacancyController::class, 'submitApplication'])->name('pelamar.review-lamaran.submit');
    Route::get('/pelamar/lamaran-terkirim',    fn() => view('pelamar.lamaran-terkirim'));

});

// ===== HR — harus login dan role=hr =====
Route::middleware(['role:hr', SetUserLocale::class])->group(function () {

    Route::get('/hr/dashboard',                  [DashboardController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr/setting',                    [SettingController::class, 'index'])->name('hr.setting');
    Route::post('/hr/setting/profile',           [SettingController::class, 'updateProfile'])->name('hr.setting.profile');
    Route::post('/hr/setting/avatar/remove',     [SettingController::class, 'removeAvatar'])->name('hr.setting.avatar.remove');
    Route::post('/hr/setting/password',          [SettingController::class, 'updatePassword'])->name('hr.setting.password');
    Route::post('/hr/setting/notifications',     [SettingController::class, 'updateNotifications'])->name('hr.setting.notifications');
    Route::post('/hr/setting/language',          [SettingController::class, 'updateLanguage'])->name('hr.setting.language');
    Route::delete('/hr/setting/session/{id}',    [SettingController::class, 'logoutDevice'])->name('hr.setting.session.destroy');
    Route::delete('/hr/setting/sessions',        [SettingController::class, 'logoutAllDevices'])->name('hr.setting.sessions.destroy');
    Route::get('/hr/tim',                        fn() => view('hr.tim'));
    Route::get('/hr/lowongan',                   [JobPostingController::class, 'index'])->name('hr.lowongan.index');
    Route::get('/hr/lowongan/buat',              [JobPostingController::class, 'create'])->name('hr.lowongan.create');
    Route::post('/hr/lowongan',                  [JobPostingController::class, 'store'])->name('hr.lowongan.store');
    Route::get('/hr/lowongan/{id}',              [JobPostingController::class, 'show'])->name('hr.lowongan.show')->where('id', '[0-9]+');
    Route::put('/hr/lowongan/{id}',              [JobPostingController::class, 'update'])->name('hr.lowongan.update')->where('id', '[0-9]+');
    Route::post('/hr/lowongan/{id}/status',      [JobPostingController::class, 'updateStatus'])->name('hr.lowongan.status')->where('id', '[0-9]+');
    Route::get('/hr/pelamar',                    fn() => view('hr.pelamar'));
    Route::get('/hr/pelamar/{id}',               fn($id) => view('hr.pelamar-detail'))->where('id', '[0-9]+');
    Route::get('/hr/wawancara',                  fn() => view('hr.wawancara'));
    Route::get('/hr/wawancara/daftar',           fn() => view('hr.wawancara-daftar'));
    Route::get('/hr/laporan',                    fn() => view('hr.laporan'));
    // HR CV Template Management (CRUD via HrCvTemplateController)
    Route::get('/hr/template-cv',                           [HrCvTemplateController::class, 'index'])->name('hr.template-cv.index');
    Route::post('/hr/template-cv',                          [HrCvTemplateController::class, 'store'])->name('hr.template-cv.store');
    Route::get('/hr/template-cv/create',                    [HrCvTemplateController::class, 'create'])->name('hr.template-cv.create');
    Route::get('/hr/template-cv/{template}/edit',           [HrCvTemplateController::class, 'edit'])->name('hr.template-cv.editor');
    Route::get('/hr/template-cv/{template}/preview',        [HrCvTemplateController::class, 'preview'])->name('hr.template-cv.preview');
    Route::put('/hr/template-cv/{template}',                [HrCvTemplateController::class, 'update'])->name('hr.template-cv.update');
    Route::patch('/hr/template-cv/{template}/publish',      [HrCvTemplateController::class, 'publish'])->name('hr.template-cv.publish');
    Route::patch('/hr/template-cv/{template}/default',      [HrCvTemplateController::class, 'setDefault'])->name('hr.template-cv.setDefault');
    Route::delete('/hr/template-cv/{template}',             [HrCvTemplateController::class, 'destroy'])->name('hr.template-cv.destroy');

});
