@extends('layouts.pelamar')

@section('title', 'Pengalaman Kerja')
@section('nav-pengalaman', 'active')

@section('content')

<!-- Header -->
<div class="bg-white rounded-xl border border-gray-200 p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengalaman Kerja</h1>
            <p class="text-gray-500 mt-1">Daftar riwayat pekerjaan profesional Anda</p>
        </div>
        <a href="/pelamar/pengalaman-kerja/tambah" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Pengalaman
        </a>
    </div>
</div>

<!-- Experience List -->
<div class="space-y-4" id="experience-list">
    <!-- Card 1 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start justify-between" data-id="1">
        <div class="flex-1">
            <span class="exp-tipe text-xs font-bold text-green-700 uppercase tracking-wider">Full-Time</span>
            <h3 class="exp-posisi text-lg font-bold text-gray-900 mt-1">Senior Software Engineer</h3>
            <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="exp-perusahaan">PT Teknologi Maju</span>
            </div>
            <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <span class="exp-periode">Jan 2020 - Sekarang</span>
            </div>
            <div class="flex gap-2 mt-4">
                <button class="btn-edit flex items-center gap-1.5 px-4 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                    Edit
                </button>
                <button class="btn-hapus flex items-center gap-1.5 px-4 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-300 transition-colors" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Hapus
                </button>
            </div>
        </div>
        <div class="w-40 h-28 bg-gray-100 rounded-lg overflow-hidden ml-6 shrink-0">
            <img src="{{ asset('images/company-1.jpg') }}" alt="" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-green-800 to-green-950 flex items-center justify-center text-white/30 text-xs\'>Foto</div>'">
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start justify-between" data-id="2">
        <div class="flex-1">
            <span class="exp-tipe text-xs font-bold text-green-700 uppercase tracking-wider">Full-Time</span>
            <h3 class="exp-posisi text-lg font-bold text-gray-900 mt-1">Junior Developer</h3>
            <div class="flex items-center gap-2 mt-2 text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="exp-perusahaan">Startup Inovasi</span>
            </div>
            <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <span class="exp-periode">Jun 2017 - Des 2019</span>
            </div>
            <div class="flex gap-2 mt-4">
                <button class="btn-edit flex items-center gap-1.5 px-4 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                    Edit
                </button>
                <button class="btn-hapus flex items-center gap-1.5 px-4 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 hover:border-red-300 transition-colors" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    Hapus
                </button>
            </div>
        </div>
        <div class="w-40 h-28 bg-gray-100 rounded-lg overflow-hidden ml-6 shrink-0">
            <img src="{{ asset('images/company-2.jpg') }}" alt="" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-green-700 to-teal-900 flex items-center justify-center text-white/30 text-xs\'>Foto</div>'">
        </div>
    </div>
</div>

<!-- Empty State (hidden by default) -->
<div class="hidden bg-white rounded-xl border border-gray-200 p-16 text-center" id="empty-state">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
    <p class="text-gray-500 font-medium">Belum ada pengalaman kerja.</p>
    <p class="text-gray-400 text-sm mt-1">Klik "Tambah Pengalaman" untuk menambahkan.</p>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/pelamar/pengalaman-kerja.js') }}"></script>
@endsection