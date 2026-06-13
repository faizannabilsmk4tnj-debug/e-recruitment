<?php


use App\Http\Controllers\ApplicantCvController;
use App\Http\Controllers\ApplicantEducationController;
use App\Http\Controllers\ApplicantLampiranController;
use App\Http\Controllers\ApplicantOrganizationExperienceController;
use App\Http\Controllers\ApplicantProfileController;
use App\Http\Controllers\ApplicantWorkExperienceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HrCvTemplateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== PUBLIK (tanpa login) =====
Route::get('/', function () { return view('landing'); });
Route::get('/tentang-kami', function () { return view('tentang-kami'); });
Route::get('/lowongan', function () { return view('lowongan'); });
Route::get('/lowongan/{id}', function () { return view('detail-lowongan'); });

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
    Route::get('/pelamar/lowongan',            fn() => view('lowongan', ['layout' => 'layouts.pelamar-public']));
    Route::get('/pelamar/lowongan/{id}',       fn($id) => view('detail-lowongan', ['layout' => 'layouts.pelamar-public']));
    Route::get('/pelamar/review-lamaran/{id}', fn($id) => view('pelamar.review-lamaran'));
    Route::get('/pelamar/lamaran-terkirim',    fn() => view('pelamar.lamaran-terkirim'));

});

// ===== HR — harus login dan role=hr =====
Route::middleware('role:hr')->group(function () {

    Route::get('/hr/dashboard',                  fn() => view('hr.dashboard'));
    Route::get('/hr/setting',                    fn() => view('hr.setting'));
    Route::get('/hr/tim',                        fn() => view('hr.tim'));
    Route::get('/hr/lowongan',                   fn() => view('hr.lowongan'));
    Route::get('/hr/lowongan/buat',              fn() => view('hr.lowongan-buat'));
    Route::get('/hr/lowongan/{id}',              fn($id) => view('hr.lowongan-detail'))->where('id', '[0-9]+');
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
