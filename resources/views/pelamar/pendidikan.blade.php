@extends('layouts.pelamar')

@section('title', 'Pendidikan')
@section('nav-pendidikan', 'active')

@section('content')

<!-- Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pendidikan</h1>
        <p class="text-gray-500 mt-1">Kelola riwayat pendidikan formal Anda untuk melengkapi profil profesional.<br>Pastikan data yang dimasukkan sesuai dengan ijazah asli.</p>
    </div>
    <a href="/pelamar/pendidikan/tambah" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Tambah Pendidikan
    </a>
</div>

<!-- Education Cards -->
<div class="grid grid-cols-2 gap-5" id="education-list">
    <!-- Card 1 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6" data-id="1">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                </svg>
            </div>
            <div class="flex gap-1.5">
                <button class="btn-edit w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-green-700 hover:bg-green-50 transition-colors" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                </button>
                <button class="btn-hapus w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
        <span class="text-xs font-bold text-green-700 uppercase tracking-wider">S1 Teknik Kimia</span>
        <h3 class="text-lg font-bold text-gray-900 mt-1">Universitas Indonesia</h3>
        <p class="text-sm text-gray-500 mt-1">Agustus 2018 - Juli 2022</p>
        <div class="flex items-center gap-1.5 mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            <span class="text-xs text-green-600 font-medium">Ijazah Terverifikasi</span>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6" data-id="2">
        <div class="flex items-center justify-between mb-4">
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
            <div class="flex gap-1.5">
                <button class="btn-edit w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-green-700 hover:bg-green-50 transition-colors" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                </button>
                <button class="btn-hapus w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
        <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">SMA - IPA</span>
        <h3 class="text-lg font-bold text-gray-900 mt-1">SMA Negeri 1 Jakarta</h3>
        <p class="text-sm text-gray-500 mt-1">Juli 2015 - Mei 2018</p>
        <div class="flex items-center gap-1.5 mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
            <span class="text-xs text-green-600 font-medium">Ijazah Terverifikasi</span>
        </div>
    </div>
</div>

<!-- Empty State -->
<div class="hidden bg-white rounded-xl border border-gray-200 p-16 text-center" id="empty-state">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
    <p class="text-gray-500 font-medium">Belum ada riwayat pendidikan.</p>
    <p class="text-gray-400 text-sm mt-1">Klik "Tambah Pendidikan" untuk menambahkan.</p>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('education-list');
    const emptyState = document.getElementById('empty-state');

    list.addEventListener('click', function (e) {
        const hapusBtn = e.target.closest('.btn-hapus');
        if (hapusBtn && confirm('Yakin ingin menghapus riwayat pendidikan ini?')) {
            const card = hapusBtn.closest('[data-id]');
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity = '0';
            card.style.transform = 'translateX(-20px)';
            setTimeout(() => { card.remove(); if (list.children.length === 0) emptyState.classList.remove('hidden'); }, 300);
        }

        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) window.location.href = '/pelamar/pendidikan/tambah?edit=' + editBtn.dataset.id;
    });
});
</script>
@endsection