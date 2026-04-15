@extends('layouts.pelamar')

@section('title', 'Tambah Pengalaman Organisasi')
@section('nav-organisasi', 'active')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="/pelamar/organisasi" class="hover:text-green-700 transition-colors">Pengalaman Organisasi</a>
    <span>›</span>
    <span class="text-gray-700 font-medium">Tambah Baru</span>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Pengalaman Organisasi</h1>
    <p class="text-gray-500 mt-1">Lengkapi detail keterlibatan organisasi atau kepanitiaan Anda.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-8">
    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan / Posisi <span class="text-red-500">*</span></label>
                <input type="text" id="jabatan" placeholder="Contoh: Ketua Himpunan" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Organisasi <span class="text-red-500">*</span></label>
                <input type="text" id="organisasi" placeholder="Contoh: BEM Fakultas" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Mulai</label>
                <input type="month" id="mulai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Selesai</label>
                <input type="month" id="selesai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Kegiatan</label>
            <textarea id="deskripsi" rows="5" placeholder="Jelaskan tanggung jawab, pencapaian, dan kontribusi Anda dalam organisasi ini..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
            <p class="text-xs text-gray-400 mt-1.5 italic">Tips: Sertakan angka atau hasil konkret untuk memperkuat deskripsi.</p>
        </div>

        <div class="flex gap-4 pt-4 justify-end">
            <a href="/pelamar/organisasi" class="border border-gray-300 text-gray-700 font-semibold px-8 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</a>
            <button type="button" id="btn-simpan" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition-colors">Simpan Pengalaman</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn-simpan').addEventListener('click', function () {
        const jabatan = document.getElementById('jabatan').value.trim();
        const organisasi = document.getElementById('organisasi').value.trim();
        if (!jabatan || !organisasi) { alert('Jabatan dan Nama Organisasi wajib diisi.'); return; }
        alert('Pengalaman organisasi berhasil disimpan! (demo)');
        window.location.href = '/pelamar/organisasi';
    });
});
</script>
@endsection