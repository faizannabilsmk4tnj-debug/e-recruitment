@extends('layouts.pelamar')

@section('title', 'Pengalaman Organisasi')
@section('nav-organisasi', 'active')

@section('content')

<!-- Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengalaman Organisasi</h1>
        <p class="text-gray-500 mt-1">Kelola riwayat keterlibatan organisasi dan kepanitiaan Anda.</p>
    </div>
    <a href="/pelamar/organisasi/tambah" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Tambah Pengalaman
    </a>
</div>

<!-- Cards -->
<div class="space-y-4" id="org-list">

    <!-- Card 1 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-sm transition-all" data-id="1">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Ketua Himpunan Mahasiswa Informatika</h3>
                        <p class="text-sm font-medium text-green-700 mt-0.5">Universitas Indonesia</p>
                    </div>
                    <span class="text-xs font-medium text-gray-500 border border-gray-200 px-3 py-1 rounded-full shrink-0 ml-4">Jan 2022 - Des 2022</span>
                </div>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">Bertanggung jawab memimpin jalannya organisasi secara keseluruhan, mengawasi 8 departemen, dan melakukan koordinasi strategis dengan pihak dekanat serta organisasi kemahasiswaan lainnya.</p>
                <div class="flex gap-3 mt-4">
                    <button class="btn-edit flex items-center gap-1.5 text-sm text-gray-500 hover:text-green-700 transition-colors" data-id="1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        Edit
                    </button>
                    <button class="btn-hapus flex items-center gap-1.5 text-sm text-red-400 hover:text-red-600 transition-colors" data-id="1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-sm transition-all" data-id="2">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Staf Departemen Minat dan Bakat</h3>
                        <p class="text-sm font-medium text-green-700 mt-0.5">BEM Fakultas Ilmu Komputer</p>
                    </div>
                    <span class="text-xs font-medium text-gray-500 border border-gray-200 px-3 py-1 rounded-full shrink-0 ml-4">Jan 2021 - Des 2021</span>
                </div>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">Mengelola program kerja "Fasilkom Cup" yang melibatkan lebih dari 500 peserta. Berhasil meningkatkan partisipasi mahasiswa dalam kegiatan non-akademik sebesar 25%.</p>
                <div class="flex gap-3 mt-4">
                    <button class="btn-edit flex items-center gap-1.5 text-sm text-gray-500 hover:text-green-700 transition-colors" data-id="2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        Edit
                    </button>
                    <button class="btn-hapus flex items-center gap-1.5 text-sm text-red-400 hover:text-red-600 transition-colors" data-id="2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-sm transition-all" data-id="3">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Koordinator Acara - Seminar Nasional</h3>
                        <p class="text-sm font-medium text-green-700 mt-0.5">Panitia Dies Natalis UI</p>
                    </div>
                    <span class="text-xs font-medium text-gray-500 border border-gray-200 px-3 py-1 rounded-full shrink-0 ml-4">Okt 2020 - Jan 2021</span>
                </div>
                <p class="text-sm text-gray-600 mt-3 leading-relaxed">Menyusun rangkaian acara seminar daring berskala nasional dengan 1000+ peserta. Mengoordinasikan 5 pembicara utama dari industri teknologi.</p>
                <div class="flex gap-3 mt-4">
                    <button class="btn-edit flex items-center gap-1.5 text-sm text-gray-500 hover:text-green-700 transition-colors" data-id="3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        Edit
                    </button>
                    <button class="btn-hapus flex items-center gap-1.5 text-sm text-red-400 hover:text-red-600 transition-colors" data-id="3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
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