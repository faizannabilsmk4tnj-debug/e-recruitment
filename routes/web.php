<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - Hanya return view, tidak ada logic
|--------------------------------------------------------------------------
*/

// ===== PUBLIK (tanpa login) =====
Route::get('/', function () {
    return view('landing');
});

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
});

Route::get('/lowongan', function () {
    return view('lowongan');
});

Route::get('/lowongan/{id}', function ($id) {
    return view('detail-lowongan');
});

// ===== AUTH =====
Route::get('/login', fn() => view('auth.login'))->name('login');

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/hr/login', fn() => view('hr.login'));

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===== PELAMAR (perlu login + role pelamar) =====
Route::middleware(['auth'])->group(function () {
    Route::get('/pelamar/dashboard', fn() => view('pelamar.dashboard'));
    Route::get('/pelamar/profil', fn() => view('pelamar.profil'));
    Route::get('/pelamar/lowongan', fn() => view('lowongan', ['layout' => 'layouts.pelamar-public']));
    Route::get('/pelamar/lowongan/{id}', fn($id) => view('detail-lowongan', ['layout' => 'layouts.pelamar-public']));
    Route::get('/pelamar/review-lamaran/{id}', fn($id) => view('pelamar.review-lamaran'));
    Route::get('/pelamar/lamaran-terkirim', fn() => view('pelamar.lamaran-terkirim'));
    Route::get('/pelamar/pengalaman-kerja', fn() => view('pelamar.pengalaman-kerja'));
    Route::get('/pelamar/pengalaman-kerja/tambah', fn() => view('pelamar.tambah-pengalaman'));
    Route::get('/pelamar/pendidikan', fn() => view('pelamar.pendidikan'));
    Route::get('/pelamar/pendidikan/tambah', fn() => view('pelamar.tambah-pendidikan'));
    Route::get('/pelamar/organisasi', fn() => view('pelamar.organisasi'));
    Route::get('/pelamar/organisasi/tambah', fn() => view('pelamar.tambah-organisasi'));
    Route::get('/pelamar/lampiran', fn() => view('pelamar.lampiran'));
    Route::get('/pelamar/cv', fn() => view('pelamar.cv'));
    Route::get('/pelamar/status-lamaran', fn() => view('pelamar.status-lamaran'));
});

// ===== HR ROUTES =====
Route::middleware(['auth'])->group(function () {
    Route::get('/hr/dashboard', fn() => view('hr.dashboard'));
    Route::get('/hr/setting', fn() => view('hr.setting'));
    Route::get('/hr/tim', fn() => view('hr.tim'));
    Route::get('/hr/lowongan', fn() => view('hr.lowongan'));
    Route::get('/hr/lowongan/buat', fn() => view('hr.lowongan-buat'));
    Route::get('/hr/lowongan/{id}', fn($id) => view('hr.lowongan-detail'))->where('id', '[0-9]+');
    Route::get('/hr/pelamar', fn() => view('hr.pelamar'));
    Route::get('/hr/pelamar/{id}', fn($id) => view('hr.pelamar-detail'))->where('id', '[0-9]+');
    Route::get('/hr/wawancara', fn() => view('hr.wawancara'));
    Route::get('/hr/wawancara/daftar', fn() => view('hr.wawancara-daftar'));
    Route::get('/hr/laporan', fn() => view('hr.laporan'));
    Route::get('/hr/template-cv', fn() => view('hr.template-cv'));
    Route::get('/hr/template-cv/editor', fn() => view('hr.template-cv-editor'));
    Route::get('/hr/template-cv/editor/{id}', fn($id) => view('hr.template-cv-editor'));
});
