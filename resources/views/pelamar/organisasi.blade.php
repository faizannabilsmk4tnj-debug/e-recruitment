@extends('layouts.pelamar')

@section('title', 'Pengalaman Organisasi')
@section('nav-organisasi', 'active')

@section('content')

<!-- Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Organization Experience</h1>
        <p class="text-gray-500 mt-1">Kelola riwayat keterlibatan organisasi dan kepanitiaan Anda.</p>
    </div>
    <a href="/pelamar/organisasi/tambah" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Tambah Pengalaman
    </a>
</div>

<!-- Cards - 2 column grid -->
<div class="grid grid-cols-2 gap-4" id="org-list">

    <!-- Card 1 -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-green-200 transition-all group relative" data-id="1">
        <div class="flex items-center gap-3 mb-2.5">
            <div class="w-2 h-10 bg-green-700 rounded-full shrink-0"></div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-sm text-gray-900 truncate">Ketua Himpunan Mahasiswa Informatika</h3>
                <p class="text-xs text-green-700 font-medium">Universitas Indonesia</p>
            </div>
            <span class="text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded-md shrink-0 font-medium">2022</span>
        </div>
        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 ml-5">Memimpin organisasi, mengawasi 8 departemen, dan koordinasi strategis dengan pihak dekanat.</p>
        <div class="flex gap-3 mt-3 ml-5">
            <button class="btn-edit text-[11px] text-gray-400 hover:text-green-700 transition-colors flex items-center gap-1" data-id="1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg> Edit
            </button>
            <button class="btn-hapus text-[11px] text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1" data-id="1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg> Hapus
            </button>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-green-200 transition-all group relative" data-id="2">
        <div class="flex items-center gap-3 mb-2.5">
            <div class="w-2 h-10 bg-blue-500 rounded-full shrink-0"></div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-sm text-gray-900 truncate">Staf Departemen Minat dan Bakat</h3>
                <p class="text-xs text-green-700 font-medium">BEM Fakultas Ilmu Komputer</p>
            </div>
            <span class="text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded-md shrink-0 font-medium">2021</span>
        </div>
        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 ml-5">Mengelola program "Fasilkom Cup" dengan 500+ peserta. Meningkatkan partisipasi non-akademik 25%.</p>
        <div class="flex gap-3 mt-3 ml-5">
            <button class="btn-edit text-[11px] text-gray-400 hover:text-green-700 transition-colors flex items-center gap-1" data-id="2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg> Edit
            </button>
            <button class="btn-hapus text-[11px] text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1" data-id="2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg> Hapus
            </button>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-green-200 transition-all group relative" data-id="3">
        <div class="flex items-center gap-3 mb-2.5">
            <div class="w-2 h-10 bg-amber-500 rounded-full shrink-0"></div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-sm text-gray-900 truncate">Koordinator Acara - Seminar Nasional</h3>
                <p class="text-xs text-green-700 font-medium">Panitia Dies Natalis UI</p>
            </div>
            <span class="text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded-md shrink-0 font-medium">2020</span>
        </div>
        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 ml-5">Menyusun rangkaian acara seminar nasional dengan 1000+ peserta. Mengoordinasikan 5 pembicara utama.</p>
        <div class="flex gap-3 mt-3 ml-5">
            <button class="btn-edit text-[11px] text-gray-400 hover:text-green-700 transition-colors flex items-center gap-1" data-id="3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg> Edit
            </button>
            <button class="btn-hapus text-[11px] text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1" data-id="3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg> Hapus
            </button>
        </div>
    </div>

</div>

<!-- Empty State -->
<div class="hidden bg-white rounded-xl border border-gray-200 p-16 text-center" id="empty-state">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    <p class="text-gray-500 font-medium">Belum ada pengalaman organisasi.</p>
    <p class="text-gray-400 text-sm mt-1">Klik "Tambah Pengalaman" untuk menambahkan.</p>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('org-list');
    const emptyState = document.getElementById('empty-state');

    list.addEventListener('click', function (e) {
        const hapusBtn = e.target.closest('.btn-hapus');
        if (hapusBtn && confirm('Yakin ingin menghapus pengalaman organisasi ini?')) {
            const card = hapusBtn.closest('[data-id]');
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity = '0';
            card.style.transform = 'translateX(-20px)';
            setTimeout(() => { card.remove(); if (list.children.length === 0) emptyState.classList.remove('hidden'); }, 300);
        }

        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) window.location.href = '/pelamar/organisasi/tambah?edit=' + editBtn.dataset.id;
    });
});
</script>
@endsection