<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/pelamar/lowongan', function () {
    return view('lowongan', ['layout' => 'layouts.pelamar-public']);
});

Route::get('/lowongan/{id}', function ($id) {
    return view('detail-lowongan');
});

Route::get('/pelamar/lowongan/{id}', function ($id) {
    return view('detail-lowongan', ['layout' => 'layouts.pelamar-public']);
});

Route::get('/pelamar/review-lamaran/{id}', function ($id) {
    return view('pelamar.review-lamaran');
});

Route::get('/pelamar/lamaran-terkirim', function () {
    return view('pelamar.lamaran-terkirim');
});

// ===== AUTH =====
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/hr/login');
})->name('logout');

// ===== HR (perlu login + role hr) =====
Route::get('/hr/dashboard', function () {
    return view('hr.dashboard');
});

// ===== PELAMAR (perlu login + role pelamar) =====
Route::get('/pelamar/dashboard', function () {
    return view('pelamar.dashboard');
});

Route::get('/pelamar/profil', function () {
    return view('pelamar.profil');
});

Route::get('/pelamar/pengalaman-kerja', function () {
    return view('pelamar.pengalaman-kerja');
});

Route::get('/pelamar/pengalaman-kerja/tambah', function () {
    return view('pelamar.tambah-pengalaman');
});

Route::get('/pelamar/pendidikan', function () {
    return view('pelamar.pendidikan');
});

Route::get('/pelamar/pendidikan/tambah', function () {
    return view('pelamar.tambah-pendidikan');
});

Route::get('/pelamar/organisasi', function () {
    return view('pelamar.organisasi');
});

Route::get('/pelamar/organisasi/tambah', function () {
    return view('pelamar.tambah-organisasi');
});

Route::get('/pelamar/lampiran', function () {
    return view('pelamar.lampiran');
});

Route::get('/pelamar/cv', function () {
    return view('pelamar.cv');
});

Route::get('/pelamar/status-lamaran', function () {
    return view('pelamar.status-lamaran');
});

// ===== HR ROUTES =====
Route::get('/hr/login', function () { return view('hr.login'); });
Route::get('/hr/setting', function () { return view('hr.setting'); });
Route::get('/hr/tim', function () { return view('hr.tim'); });
Route::get('/hr/lowongan', function () { return view('hr.lowongan'); });
Route::get('/hr/lowongan/buat', function () { return view('hr.lowongan-buat'); });
Route::get('/hr/lowongan/{id}', function ($id) { return view('hr.lowongan-detail'); })->where('id', '[0-9]+');
Route::get('/hr/pelamar', function () { return view('hr.pelamar'); });
Route::get('/hr/pelamar/{id}', function ($id) { return view('hr.pelamar-detail'); })->where('id', '[0-9]+');
Route::get('/hr/wawancara', function () { return view('hr.wawancara'); });
Route::get('/hr/wawancara/daftar', function () { return view('hr.wawancara-daftar'); });
Route::get('/hr/laporan', function () { return view('hr.laporan'); });
Route::get('/hr/template-cv', function () { return view('hr.template-cv'); });
Route::get('/hr/template-cv/editor', function () { return view('hr.template-cv-editor'); });
Route::get('/hr/template-cv/editor/{id}', function ($id) { return view('hr.template-cv-editor'); });