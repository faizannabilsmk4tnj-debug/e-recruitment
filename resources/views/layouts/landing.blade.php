<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
    @yield('css')
</head>
<body class="min-h-screen flex flex-col bg-white">

    <!-- Navbar -->
    <nav class="bg-green-900 px-16 py-3 flex items-center justify-between relative z-50">
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
            </a>
        </div>

        <!-- Nav Links -->
        <div class="flex items-center gap-8">
            <a href="#lowongan" class="text-white text-sm hover:text-green-200 transition-colors">Lowongan</a>
            <a href="#tentang" class="text-white text-sm hover:text-green-200 transition-colors">Tentang Kami</a>
            <a href="/login" class="bg-white text-green-900 text-sm font-semibold px-5 py-2 rounded-lg hover:bg-green-50 transition-colors">
                Masuk
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-950 text-white">
        <div class="px-16 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                        <div>
                            <h3 class="font-bold text-base leading-tight">PT Ecogreen<br>Oleochemicals</h3>
                        </div>
                    </div>
                    <p class="text-green-300 text-sm leading-relaxed mb-6">
                        Platform rekrutmen terdepan yang menghubungkan talenta terbaik dengan peluang karir di industri ramah lingkungan untuk masa depan yang berkelanjutan.
                    </p>
                    <!-- Social Icons -->
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-green-900 rounded-lg flex items-center justify-center hover:bg-green-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-green-900 rounded-lg flex items-center justify-center hover:bg-green-800 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Pencari Kerja -->
                <div>
                    <h4 class="font-bold text-base mb-4">Pencari Kerja</h4>
                    <ul class="space-y-3 text-sm text-green-300">
                        <li><a href="#" class="hover:text-white transition-colors">Telusuri Pekerjaan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tips Karir</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Buat Akun</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Dashboard Pelamar</a></li>
                    </ul>
                </div>

                <!-- Perusahaan -->
                <div>
                    <h4 class="font-bold text-base mb-4">Perusahaan</h4>
                    <ul class="space-y-3 text-sm text-green-300">
                        <li><a href="#" class="hover:text-white transition-colors">Pasang Lowongan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Hubungi Kami -->
                <div>
                    <h4 class="font-bold text-base mb-4">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-green-300">
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span>Jl. Hijau Rindang No. 12, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="402321322525320025232f273225252e6e232f6e2924">[email&#160;protected]</a></span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span>+62 21 555 1234</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-green-900 px-16 py-4 flex flex-col md:flex-row items-center justify-between gap-2">
            <p class="text-green-400 text-xs">© 2023 PT Ecogreen Oleochemicals. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex items-center gap-4 text-green-400 text-xs">
                <span>Bahasa Indonesia</span>
                <span>•</span>
                <span>v1.0.4</span>
            </di