@extends('layouts.landing')

@section('title', 'Karir - PT Ecogreen Oleochemicals')

@section('css')
<style>
    .hero-curve {
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: #15803d;
        border-bottom-left-radius: 50% 70%;
        z-index: 0;
    }
    .hero-illustration {
        position: relative;
        z-index: 1;
    }
    .category-banner {
        background: linear-gradient(135deg, #14532d 0%, #166534 50%, #15803d 100%);
    }
</style>
@endsection

@section('content')

<!-- ========== HERO SECTION ========== -->
<section class="relative overflow-hidden bg-white">
    <div class="hero-curve"></div>
    <div class="relative z-10 px-16 py-20 flex items-center justify-between">
        <!-- Left: Text -->
        <div class="max-w-xl">
            <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                <span class="italic">Tumbuh Bersama</span><br>
                <span class="italic text-green-700">Membangun Masa Depan</span>
                <span> yang Lebih Hijau</span>
            </h1>
            <p class="text-gray-600 text-base leading-relaxed mb-8">
                Temukan peluang karir terbaik di PT Ecogreen Oleochemicals. Kami mengundang talenta berbakat untuk berinovasi dan memberikan dampak positif bagi lingkungan dan industri.
            </p>
            <div class="flex gap-4">
                <a href="#lowongan" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors text-sm">
                    Lihat Lowongan
                </a>
                <a href="/register" class="border-2 border-green-800 text-green-800 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg transition-colors text-sm">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Right: Illustration -->
        <div class="hero-illustration flex items-end justify-center mr-8">
            <img src="{{ asset('images/foto1.png') }}" alt="Ilustrasi Karir" class="w-80 h-auto drop-shadow-xl">
        </div>
    </div>
</section>

<!-- ========== KATEGORI BANNER ========== -->
<section class="category-banner py-12 px-16">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-16">
            <div class="text-center">
                <p class="text-3xl font-bold text-white" id="stat-lowongan">50+</p>
                <p class="text-green-300 text-sm mt-1">Lowongan Aktif</p>
            </div>
            <div class="w-px h-12 bg-green-700"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white" id="stat-pelamar">1,200+</p>
                <p class="text-green-300 text-sm mt-1">Pelamar Terdaftar</p>
            </div>
            <div class="w-px h-12 bg-green-700"></div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white" id="stat-diterima">300+</p>
                <p class="text-green-300 text-sm mt-1">Berhasil Diterima</p>
            </div>
        </div>
        <div>
            <p class="text-white font-semibold text-lg">Kategori Pekerjaan</p>
        </div>
    </div>
</section>

<!-- ========== KATEGORI POPULER ========== -->
<section class="py-16 px-16 bg-gray-50">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-3">Kategori Populer</h2>
        <p class="text-gray-500">Telusuri berbagai bidang karir yang sesuai dengan minat dan keahlian Anda.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="category-cards">
        <!-- Information Tech -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg hover:border-green-200 transition-all cursor-pointer group">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 18 22 12 16 6"/>
                    <polyline points="8 6 2 12 8 18"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Information Tech</h3>
            <span class="text-xs font-medium text-green-700 bg-green-50 px-3 py-1 rounded-full">12 Lowongan</span>
        </div>

        <!-- Finance -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg hover:border-green-200 transition-all cursor-pointer group">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                    <path d="M12 18V6"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Finance</h3>
            <span class="text-xs font-medium text-green-700 bg-green-50 px-3 py-1 rounded-full">8 Lowongan</span>
        </div>

        <!-- Engineering -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg hover:border-green-200 transition-all cursor-pointer group">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Engineering</h3>
            <span class="text-xs font-medium text-green-700 bg-green-50 px-3 py-1 rounded-full">10 Lowongan</span>
        </div>

        <!-- Marketing -->
        <div class="bg-white rounded-xl border border-gray-100 p-6 hover:shadow-lg hover:border-green-200 transition-all cursor-pointer group">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Marketing</h3>
            <span class="text-xs font-medium text-green-700 bg-green-50 px-3 py-1 rounded-full">6 Lowongan</span>
        </div>
    </div>
</section>

<!-- ========== LOWONGAN TERBARU ========== -->
<section class="py-16 px-16 bg-white" id="lowongan">
    <div class="flex items-end justify-between mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Lowongan Terbaru</h2>
            <p class="text-gray-500">Bergabunglah dengan tim kami di berbagai departemen.</p>
        </div>
        <a href="#" class="flex items-center gap-2 text-green-800 font-semibold text-sm hover:text-green-600 transition-colors">
            Lihat Semua Lowongan
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"/>
                <path d="m12 5 7 7-7 7"/>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="job-cards">
        <!-- Job Card 1 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-green-200 transition-all">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-10 h-10 bg-green-800 rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-bold leading-none">E<br>G</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Senior Web Developer</h3>
                    <p class="text-sm text-gray-500">PT Ecogreen Oleochemicals</p>
                </div>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full font-medium">Full-time</span>
                <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">On-site</span>
            </div>
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400">Diposting 2 hari lalu</span>
                <a href="#" class="text-green-700 text-sm font-semibold hover:text-green-600 transition-colors">Detail →</a>
            </div>
        </div>

        <!-- Job Card 2 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-green-200 transition-all">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-10 h-10 bg-green-800 rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-bold leading-none">E<br>G</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Financial Analyst</h3>
                    <p class="text-sm text-gray-500">PT Ecogreen Oleochemicals</p>
                </div>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="text-xs bg-green-50 text-green-700 px-3 py-1 rounded-full font-medium">Full-time</span>
                <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">On-site</span>
            </div>
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400">Diposting 3 hari lalu</span>
                <a href="#" class="text-green-700 text-sm font-semibold hover:text-green-600 transition-colors">Detail →</a>
            </div>
        </div>

        <!-- Job Card 3 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-green-200 transition-all">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-10 h-10 bg-green-800 rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white text-xs font-bold leading-none">E<br>G</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Marketing Specialist</h3>
                    <p class="text-sm text-gray-500">PT Ecogreen Oleochemicals</p>
                </div>
            </div>
            <div class="flex gap-2 mb-4">
                <span class="text-xs bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-medium">Hybrid</span>
                <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">Contract</span>
            </div>
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400">Diposting 5 hari lalu</span>
                <a href="#" class="text-green-700 text-sm font-semibold hover:text-green-600 transition-colors">Detail →</a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/landing.js') }}"></script>
@endsection