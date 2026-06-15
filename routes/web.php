<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelamarController;

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
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// ===== AUTH PELAMAR =====
// Hanya bisa diakses kalau belum login
Route::middleware('guest')->group(function () {
    Route::get('/login',            fn() => view('auth.login'))->name('login');
    Route::post('/login',           [AuthController::class, 'login']);
    Route::get('/register',         fn() => view('auth.register'))->name('register');
    Route::post('/register',        [AuthController::class, 'register']);
    Route::get('/forgot-password',  fn() => view('auth.forgot-password'))->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',  [AuthController::class, 'resetPassword'])->name('password.update');
});

// ===== AUTH HR =====
// /hr/login bisa diakses siapapun (tidak pakai middleware guest)
Route::get('/hr/login',  fn() => view('hr.login'))->name('hr.login');
Route::post('/hr/login', [AuthController::class, 'hrLogin']);

// Logout (untuk kedua role)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===== PELAMAR — harus login dan role=applicant =====
Route::middleware('role:applicant')->group(function () {

   Route::get('/pelamar/dashboard', [PelamarController::class, 'dashboard']);
    Route::get('/pelamar/profil',              fn() => view('pelamar.profil'));
    Route::get('/pelamar/pengalaman-kerja',    fn() => view('pelamar.pengalaman-kerja'));
    Route::get('/pelamar/pengalaman-kerja/tambah', fn() => view('pelamar.tambah-pengalaman'));
    Route::get('/pelamar/pendidikan',          fn() => view('pelamar.pendidikan'));
    Route::get('/pelamar/pendidikan/tambah',   fn() => view('pelamar.tambah-pendidikan'));
    Route::get('/pelamar/organisasi',          fn() => view('pelamar.organisasi'));
    Route::get('/pelamar/organisasi/tambah',   fn() => view('pelamar.tambah-organisasi'));
    Route::get('/pelamar/lampiran',            fn() => view('pelamar.lampiran'));
    Route::get('/pelamar/cv',                  fn() => view('pelamar.cv'));
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
    Route::get('/hr/template-cv',               fn() => view('hr.template-cv'));
    Route::get('/hr/template-cv/editor',        fn() => view('hr.template-cv-editor'));
    Route::get('/hr/template-cv/editor/{id}',   fn($id) => view('hr.template-cv-editor'));

});
