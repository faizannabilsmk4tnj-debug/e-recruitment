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

<!-- Education Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden" id="education-list">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50">
                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Institusi</th>
                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Tingkat / Jurusan</th>
                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Periode</th>
                <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-t border-gray-100 hover:bg-green-50/30 transition-colors" data-id="1">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-green-50 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
                        </div>
                        <p class="font-semibold text-sm text-gray-900">Universitas Indonesia</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded uppercase">S1 Teknik Kimia</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">2018 - 2022</td>
                <td class="px-6 py-4">
                    <span class="text-xs text-green-600 font-medium flex items-center gap-1 w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Terverifikasi
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-1 justify-end">
                        <button class="btn-edit w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-green-700 hover:bg-green-50 transition-colors" data-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        </button>
                        <button class="btn-hapus w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" data-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            <tr class="border-t border-gray-100 hover:bg-green-50/30 transition-colors" data-id="2">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="14" x="3" y="7" rx="2"/><path d="M12 3v4"/></svg>
                        </div>
                        <p class="font-semibold text-sm text-gray-900">SMA Negeri 1 Jakarta</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded uppercase">SMA - IPA</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">2015 - 2018</td>
                <td class="px-6 py-4">
                    <span class="text-xs text-green-600 font-medium flex items-center gap-1 w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Terverifikasi
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-1 justify-end">
                        <button class="btn-edit w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-green-700 hover:bg-green-50 transition-colors" data-id="2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        </button>
                        <button class="btn-hapus w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" data-id="2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
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