<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Hanya return view, tidak ada logic
|--------------------------------------------------------------------------
*/

// ===== PUBLIK (tanpa login) =====
Route::get('/', function () {
    return view('landing');
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

// ===== AUTH =====
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

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