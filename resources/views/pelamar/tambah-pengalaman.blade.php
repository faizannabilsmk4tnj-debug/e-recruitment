@extends('layouts.pelamar')

@section('title', 'Tambah Pengalaman Kerja')
@section('nav-pengalaman', 'active')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="/pelamar/pengalaman-kerja" class="hover:text-green-700 transition-colors">Pengalaman Kerja</a>
    <span>›</span>
    <span class="text-gray-700 font-medium">Tambah Baru</span>
</div>

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Pengalaman Kerja</h1>
    <p class="text-gray-500 mt-1">Lengkapi detail pengalaman profesional Anda untuk profil yang lebih baik.</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl border border-gray-200 p-8">
    <div class="space-y-6">

        <!-- Position & Company -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Position / Job Title <span class="text-red-500">*</span></label>
                <input type="text" id="posisi" placeholder="Contoh: Chemical Engineer" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Company Name <span class="text-red-500">*</span></label>
                <input type="text" id="perusahaan" placeholder="Contoh: PT Ecogreen Oleochemicals" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <!-- Industry & Employment Type -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Industry</label>
                <select id="industri" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none">
                    <option value="">Pilih Industri</option>
                    <option value="teknologi">Teknologi</option>
                    <option value="manufaktur">Manufaktur</option>
                    <option value="kimia">Kimia & Oleochemical</option>
                    <option value="keuangan">Keuangan & Perbankan</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="pendidikan">Pendidikan</option>
                    <option value="energi">Energi & Pertambangan</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Employment Type</label>
                <select id="tipe" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none">
                    <option value="">Pilih Tipe Pekerjaan</option>
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Contract">Contract</option>
                    <option value="Internship">Internship</option>
                    <option value="Freelance">Freelance</option>
                </select>
            </div>
        </div>

        <!-- Location -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Location</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <input type="text" id="lokasi" placeholder="Contoh: Batam, Kepulauan Riau" class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <!-- Start & End Date -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Date</label>
                <input type="date" id="mulai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">End Date</label>
                <input type="date" id="selesai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <!-- Currently Working -->
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="masih-bekerja" class="h-4 w-4 rounded border-gray-300 accent-green-800 cursor-pointer">
            <span class="text-sm text-gray-600">I am currently working in this role</span>
        </label>

        <!-- Photo Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Perusahaan / Tempat Kerja</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors cursor-pointer" id="drop-zone">
                <div id="upload-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                    </svg>
                    <p class="text-sm text-gray-500">Klik atau drag foto ke sini</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG (Maks 5MB)</p>
                </div>
                <div id="upload-preview" class="hidden">
                    <img id="preview-img" src="" alt="Preview" class="max-h-40 mx-auto rounded-lg">
                    <button type="button" id="remove-foto" class="mt-3 text-xs text-red-500 hover:text-red-700 font-medium">Hapus Foto</button>
                </div>
                <input type="file" id="foto-kerja" accept="image/jpeg,image/png" class="hidden">
            </div>
        </div>

        <!-- Job Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Job Description</label>
            <textarea id="deskripsi" rows="5" placeholder="Jelaskan tanggung jawab dan pencapaian Anda selama bekerja di posisi ini..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
            <p class="text-xs text-gray-400 mt-1.5 italic">Tips: Gunakan bullet points untuk menjelaskan pencapaian utama Anda.</p>
        </div>

        <!-- Buttons -->
        <div class="grid grid-cols-2 gap-4 pt-4">
            <button type="button" id="btn-simpan" class="bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Pengalaman
            </button>
            <a href="/pelamar/pengalaman-kerja" class="border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors flex items-center justify-center">
                Batal
            </a>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Checkbox "masih bekerja" disable end date
    const cb = document.getElementById('masih-bekerja');
    const endDate = document.getElementById('selesai');
    cb.addEventListener('change', function () {
        endDate.disabled = this.checked;
        if (this.checked) endDate.value = '';
    });

    // Photo upload
    const dropZone = document.getElementById('drop-zone');
    const fotoInput = document.getElementById('foto-kerja');
    const placeholder = document.getElementById('upload-placeholder');
    const preview = document.getElementById('upload-preview');
    const previewImg = document.getElementById('preview-img');
    const removeBtn = document.getElementById('remove-foto');

    dropZone.addEventListener('click', () => fotoInput.click());
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-green-500', 'bg-green-50'); });
    dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-green-500', 'bg-green-50'); });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        if (e.dataTransfer.files.length) { fotoInput.files = e.dataTransfer.files; handleFile(e.dataTransfer.files[0]); }
    });

    fotoInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

    function handleFile(file) {
        if (file.size > 5 * 1024 * 1024) { alert('Ukuran file melebihi 5MB.'); return; }
        if (!['image/jpeg', 'image/png'].includes(file.type)) { alert('Format harus JPG atau PNG.'); return; }
        const reader = new FileReader();
        reader.onload = (e) => { previewImg.src = e.target.result; placeholder.classList.add('hidden'); preview.classList.remove('hidden'); };
        reader.readAsDataURL(file);
    }

    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        fotoInput.value = '';
        previewImg.src = '';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    });

    // Simpan
    document.getElementById('btn-simpan').addEventListener('click', function () {
        const posisi = document.getElementById('posisi').value.trim();
        const perusahaan = document.getElementById('perusahaan').value.trim();
        if (!posisi || !perusahaan) {
            alert('Position dan Company Name wajib diisi.');
            return;
        }
        alert('Pengalaman berhasil disimpan! (demo)');
        window.location.href = '/pelamar/pengalaman-kerja';
    });
});
</script>
@endsection