@extends('layouts.pelamar')

@section('title', 'Tambah Pendidikan')
@section('nav-pendidikan', 'active')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="/pelamar/pendidikan" class="hover:text-green-700 transition-colors">Pendidikan</a>
    <span>›</span>
    <span class="text-gray-700 font-medium">Tambah Baru</span>
</div>

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Riwayat Pendidikan</h1>
    <p class="text-gray-500 mt-1">Lengkapi formulir di bawah ini dengan informasi pendidikan Anda.</p>
</div>

<!-- Form -->
<div class="bg-white rounded-xl border border-gray-200 p-8">
    <div class="space-y-6">

        <!-- Nama Sekolah & Tingkat -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Sekolah / Universitas <span class="text-red-500">*</span></label>
                <input type="text" id="sekolah" placeholder="Contoh: Institut Teknologi Bandung" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tingkat Pendidikan <span class="text-red-500">*</span></label>
                <select id="tingkat" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none">
                    <option value="">Pilih Tingkat</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA/SMK">SMA/SMK</option>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>
        </div>

        <!-- Jurusan & Nomor Ijazah -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jurusan</label>
                <input type="text" id="jurusan" placeholder="Contoh: Teknik Mesin" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Ijazah</label>
                <input type="text" id="no-ijazah" placeholder="Contoh: 12345/UN6.1/2022" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <!-- IPK / Nilai -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">IPK / Nilai Rata-Rata</label>
                <input type="text" id="ipk" placeholder="Contoh: 3.75 / 4.00" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div></div>
        </div>

        <!-- Tanggal Mulai & Selesai -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                <input type="date" id="mulai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                <input type="date" id="selesai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <!-- Upload Ijazah & SKHU -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Foto Ijazah</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-green-400 transition-colors cursor-pointer" id="drop-ijazah">
                    <div id="placeholder-ijazah">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <p class="text-xs text-gray-500">Tarik file atau klik untuk unggah</p>
                        <p class="text-xs text-gray-400">PDF, JPG, PNG (Maks. 2MB)</p>
                    </div>
                    <div id="preview-ijazah" class="hidden">
                        <p class="text-sm text-green-700 font-medium" id="name-ijazah"></p>
                        <button type="button" class="remove-file text-xs text-red-500 mt-1" data-target="ijazah">Hapus</button>
                    </div>
                    <input type="file" id="file-ijazah" accept="image/jpeg,image/png,application/pdf" class="hidden">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Foto SKHU <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-green-400 transition-colors cursor-pointer" id="drop-skhu">
                    <div id="placeholder-skhu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-300 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        <p class="text-xs text-gray-500">Tarik file atau klik untuk unggah</p>
                        <p class="text-xs text-gray-400">PDF, JPG, PNG (Maks. 2MB)</p>
                    </div>
                    <div id="preview-skhu" class="hidden">
                        <p class="text-sm text-green-700 font-medium" id="name-skhu"></p>
                        <button type="button" class="remove-file text-xs text-red-500 mt-1" data-target="skhu">Hapus</button>
                    </div>
                    <input type="file" id="file-skhu" accept="image/jpeg,image/png,application/pdf" class="hidden">
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 pt-4 justify-end">
            <a href="/pelamar/pendidikan" class="border border-gray-300 text-gray-700 font-semibold px-8 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</a>
            <button type="button" id="btn-simpan" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition-colors">Simpan Perubahan</button>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // File upload handlers for both zones
    ['ijazah', 'skhu'].forEach(type => {
        const drop = document.getElementById('drop-' + type);
        const input = document.getElementById('file-' + type);
        const placeholder = document.getElementById('placeholder-' + type);
        const preview = document.getElementById('preview-' + type);
        const nameEl = document.getElementById('name-' + type);

        drop.addEventListener('click', () => input.click());
        drop.addEventListener('dragover', (e) => { e.preventDefault(); drop.classList.add('border-green-500', 'bg-green-50'); });
        drop.addEventListener('dragleave', () => drop.classList.remove('border-green-500', 'bg-green-50'));
        drop.addEventListener('drop', (e) => {
            e.preventDefault(); drop.classList.remove('border-green-500', 'bg-green-50');
            if (e.dataTransfer.files.length) { input.files = e.dataTransfer.files; showFile(e.dataTransfer.files[0]); }
        });
        input.addEventListener('change', (e) => { if (e.target.files[0]) showFile(e.target.files[0]); });

        function showFile(file) {
            if (file.size > 2 * 1024 * 1024) { alert('File melebihi 2MB.'); return; }
            nameEl.textContent = file.name;
            placeholder.classList.add('hidden');
            preview.classList.remove('hidden');
        }
    });

    // Remove file buttons
    document.querySelectorAll('.remove-file').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const type = btn.dataset.target;
            document.getElementById('file-' + type).value = '';
            document.getElementById('preview-' + type).classList.add('hidden');
            document.getElementById('placeholder-' + type).classList.remove('hidden');
        });
    });

    // Simpan
    document.getElementById('btn-simpan').addEventListener('click', function () {
        const sekolah = document.getElementById('sekolah').value.trim();
        const tingkat = document.getElementById('tingkat').value;
        if (!sekolah || !tingkat) { alert('Nama Sekolah dan Tingkat Pendidikan wajib diisi.'); return; }
        alert('Pendidikan berhasil disimpan! (demo)');
        window.location.href = '/pelamar/pendidikan';
    });
});
</script>
@endsection