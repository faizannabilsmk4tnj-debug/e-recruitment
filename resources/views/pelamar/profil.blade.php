@extends('layouts.pelamar')

@section('title', 'Profil')
@section('nav-profil', 'active')

@section('content')

<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
    <p class="text-gray-500 mt-1">Complete your personal data according to official documents for verification purposes.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-8">

    <!-- ===== FOTO PROFIL ===== -->
    <div class="flex items-center gap-5 mb-10">
        <div class="relative">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden" id="avatar-preview">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <label for="foto-input" class="absolute bottom-0 right-0 w-7 h-7 bg-green-700 rounded-full flex items-center justify-center cursor-pointer hover:bg-green-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/>
                </svg>
            </label>
            <input type="file" id="foto-input" accept="image/jpeg,image/png" class="hidden">
        </div>
        <div>
            <p class="font-semibold text-gray-900">Profile Photo</p>
            <p class="text-xs text-gray-400">JPG, PNG format (Max 2MB).</p>
            <p class="text-xs text-gray-400">Use your best formal photo.</p>
        </div>
    </div>

    <!-- ===== DATA PRIBADI ===== -->
    <div class="grid grid-cols-2 gap-x-8 gap-y-5 mb-10">
        <!-- NIK -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK (National ID Number)</label>
            <input type="text" id="nik" placeholder="Enter 16-digit NIK" maxlength="16" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
        </div>
        <!-- Nama Lengkap -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
            <input type="text" id="nama" placeholder="Full name as per ID card" value="Budi Santoso" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
        </div>
        <!-- Jenis Kelamin -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Gender</label>
            <select id="jenis-kelamin" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none">
                <option value="">Select</option>
                <option value="L" selected>Male</option>
                <option value="P">Female</option>
            </select>
        </div>
        <!-- Nomor Telepon -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
            <input type="tel" id="telepon" placeholder="+62 812 3456 7890" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
        </div>
        <!-- Email Address -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
            <input type="email" id="email" placeholder="email@example.com" value="budi.santoso@email.com" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
        </div>
        <!-- Tempat/Tanggal Lahir -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Place / Date of Birth</label>
            <div class="grid grid-cols-2 gap-3">
                <input type="text" id="tempat-lahir" placeholder="City" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                <input type="date" id="tanggal-lahir" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
        </div>
        <!-- Umur -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Age</label>
            <input type="number" id="umur" placeholder="Example: 25" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
        </div>
        <!-- Status Pernikahan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Marital Status</label>
            <select id="status-nikah" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none">
                <option value="">Select</option>
                <option value="belum" selected>Single</option>
                <option value="menikah">Married</option>
                <option value="cerai">Divorced</option>
            </select>
        </div>
    </div>

    <!-- ===== PENDIDIKAN TERAKHIR ===== -->
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
            </svg>
            <h2 class="text-base font-bold text-gray-900">Latest Education</h2>
        </div>
        <div class="grid grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Latest Education</label>
                <select id="pendidikan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all appearance-none">
                    <option value="">Select</option>
                    <option value="sma" selected>SMA/SMK</option>
                    <option value="d3">D3</option>
                    <option value="s1">S1</option>
                    <option value="s2">S2</option>
                    <option value="s3">S3</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">School / University</label>
                <input type="text" id="sekolah" placeholder="Institution Name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Education Completion</label>
                <input type="month" id="selesai-pendidikan" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">GPA / Average Score</label>
                <input type="text" id="ipk" placeholder="Example: 3.75 / 4.00" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
        </div>
    </div>

    <!-- ===== ALAMAT SESUAI KTP ===== -->
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <h2 class="text-base font-bold text-gray-900">ID Card Address</h2>
        </div>
        <div class="grid grid-cols-2 gap-x-8 gap-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Province</label>
                <input type="text" id="ktp-provinsi" placeholder="Province" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">City / Regency</label>
                <input type="text" id="ktp-kota" placeholder="City / Regency" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">District</label>
                <input type="text" id="ktp-kecamatan" placeholder="District" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sub-district</label>
                <input type="text" id="ktp-kelurahan" placeholder="Sub-district" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Address</label>
                <input type="text" id="ktp-alamat" placeholder="Street Name, House No., RT/RW" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
        </div>
    </div>

    <!-- ===== ALAMAT DOMISILI ===== -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                </svg>
                <h2 class="text-base font-bold text-gray-900">Current Residence Address</h2>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" id="sama-ktp" class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-600 accent-green-800 cursor-pointer">
                <span class="text-sm text-gray-500">Same as ID Card</span>
            </label>
        </div>
        <div class="grid grid-cols-2 gap-x-8 gap-y-5" id="domisili-fields">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Province</label>
                <input type="text" id="dom-provinsi" placeholder="Province" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">City / Regency</label>
                <input type="text" id="dom-kota" placeholder="City / Regency" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">District</label>
                <input type="text" id="dom-kecamatan" placeholder="District" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sub-district</label>
                <input type="text" id="dom-kelurahan" placeholder="Sub-district" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Address</label>
                <input type="text" id="dom-alamat" placeholder="Street Name, House No., RT/RW" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
            </div>
        </div>
    </div>

    <!-- ===== SIMPAN BUTTON ===== -->
    <div class="pt-4">
        <button type="button" id="btn-simpan" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
            </svg>
            Save Changes
        </button>
    </div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('js/pelamar/profil.js') }}"></script>
@endsection