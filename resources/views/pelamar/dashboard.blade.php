@extends('layouts.pelamar')

@section('title', 'Dashboard')
@section('nav-dashboard', 'active')

@section('css')
<style>
    .stat-card { position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; border-radius: 4px 0 0 4px; }
    .stat-card.green::before { background: #15803d; }
    .stat-card.emerald::before { background: #059669; }
    .stat-card.red::before { background: #dc2626; }
    .stat-card.blue::before { background: #2563eb; }
    .saved-job:hover .saved-job-title { color: #15803d; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    .animate-card { animation: fadeInUp 0.4s ease-out forwards; opacity: 0; }
    .animate-card:nth-child(1) { animation-delay: 0.05s; }
    .animate-card:nth-child(2) { animation-delay: 0.1s; }
    .animate-card:nth-child(3) { animation-delay: 0.15s; }
    .animate-card:nth-child(4) { animation-delay: 0.2s; }
</style>
@endsection

@section('content')

<!-- Greeting -->
<a href="/pelamar/profil" class="block relative rounded-xl mb-6 overflow-hidden cursor-pointer group border border-gray-200 shadow-sm hover:shadow-md transition-shadow" id="greeting-card">
    <!-- Background: white base -->
    <div class="absolute inset-0 bg-white"></div>
    <!-- Green fill based on percentage -->
    <div class="absolute inset-0 bg-gradient-to-r from-green-800 to-green-900 transition-all duration-1000 ease-out" id="progress-fill" style="width: 0%"></div>
    <!-- Content -->
    <div class="relative z-10 p-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold" id="greeting-text">Halo, <span id="user-name">Ahmad</span>!</h1>
            <p class="mt-1 text-sm" id="greeting-sub">Selamat datang kembali. Berikut adalah ringkasan aktivitas lamaran Anda.</p>
        </div>
        <div class="text-right flex items-center gap-4">
            <div>
                <p class="text-xs uppercase tracking-wider font-medium" id="progress-label">Profil Lengkap</p>
                <p class="text-3xl font-bold mt-0.5" id="progress-number">85%</p>
            </div>
            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" id="progress-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </div>
        </div>
    </div>
</a>

<!-- Stat Cards -->
<div class="grid grid-cols-4 gap-5 mb-8">
    <!-- Total Lamaran -->
    <div class="stat-card green animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-green-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Lamaran</p>
                <p class="text-3xl font-bold text-gray-900" id="stat-total">12</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-1.5 mt-3 bg-green-50 rounded-md px-2 py-1 w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            <span class="text-xs font-semibold text-green-700">+2 bulan ini</span>
        </div>
    </div>

    <!-- Aktif -->
    <div class="stat-card emerald animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-green-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Aktif</p>
                <p class="text-3xl font-bold text-emerald-700" id="stat-aktif">4</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">Dalam proses review</p>
    </div>

    <!-- Ditolak -->
    <div class="stat-card red animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-red-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Ditolak</p>
                <p class="text-3xl font-bold text-red-600" id="stat-ditolak">2</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-red-50 to-red-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">Tetap semangat!</p>
    </div>

    <!-- Wawancara -->
    <div class="stat-card blue animate-card bg-white rounded-xl border border-gray-200 p-5 cursor-pointer hover:shadow-lg hover:border-blue-200 transition-all">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Wawancara</p>
                <p class="text-3xl font-bold text-blue-600" id="stat-wawancara">3</p>
            </div>
            <div class="w-11 h-11 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-3">Persiapkan diri Anda</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-3 gap-6">

    <!-- LEFT: Daftar Lamaran Terbaru -->
    <div class="col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-green-700 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900">Daftar Lamaran Terbaru</h2>
                </div>
                <a href="/pelamar/status-lamaran" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 transition-colors">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Posisi</th>
                        <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Tanggal</th>
                        <th class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody id="lamaran-table">
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Process Engineer</p>
                            <p class="text-xs text-gray-400">Plant Division - Batam</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">12 Okt 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-200">Shortlisted</span></td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Quality Assurance Specialist</p>
                            <p class="text-xs text-gray-400">Laboratory - Medan</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">08 Okt 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">Interview</span></td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Finance & Accounting Staff</p>
                            <p class="text-xs text-gray-400">Head Office - Jakarta</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">05 Okt 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-50 text-gray-500 border border-gray-200">Applied</span></td>
                    </tr>
                    <tr class="border-b border-gray-50 hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">HR Generalist</p>
                            <p class="text-xs text-gray-400">Head Office - Jakarta</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">30 Sep 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-200">Rejected</span></td>
                    </tr>
                    <tr class="hover:bg-green-50/40 transition-colors cursor-pointer group">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Supply Chain Manager</p>
                            <p class="text-xs text-gray-400">Logistics - Batam</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">25 Sep 2023</td>
                        <td class="px-6 py-4"><span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-50 text-gray-500 border border-gray-200">Applied</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- RIGHT: Lowongan Tersimpan + Notifikasi -->
    <div class="col-span-1 space-y-6">

        <!-- Lowongan Tersimpan -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-blue-500 rounded-full"></div>
                    <h3 class="font-bold text-gray-900 text-sm">Lowongan Tersimpan</h3>
                </div>
                <a href="/#lowongan" class="text-xs font-semibold text-green-700 hover:text-green-600 transition-colors">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-50" id="saved-jobs">
                <div class="saved-job flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="saved-job-title font-semibold text-sm text-gray-900 truncate transition-colors">Maintenance Supervisor</p>
                        <p class="text-xs text-gray-400">Batam • 5 hari lalu</p>
                    </div>
                    <button class="text-gray-300 hover:text-yellow-500 transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    </button>
                </div>
                <div class="saved-job flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="saved-job-title font-semibold text-sm text-gray-900 truncate transition-colors">Chemical Lab Tech</p>
                        <p class="text-xs text-gray-400">Medan • 2 hari lalu</p>
                    </div>
                    <button class="text-gray-300 hover:text-yellow-500 transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    </button>
                </div>
                <div class="saved-job flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="saved-job-title font-semibold text-sm text-gray-900 truncate transition-colors">Talent Acquisition Lead</p>
                        <p class="text-xs text-gray-400">Jakarta • Baru</p>
                    </div>
                    <button class="text-gray-300 hover:text-yellow-500 transition-colors shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-5 py-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-5 bg-amber-500 rounded-full"></div>
                    <h3 class="font-bold text-gray-900 text-sm">Notifikasi</h3>
                </div>
                <span class="text-xs font-bold text-white bg-green-600 px-2.5 py-0.5 rounded-full animate-pulse">3 Baru</span>
            </div>
            <div class="divide-y divide-gray-50" id="notifications">
                <div class="flex items-start gap-3 px-5 py-4 hover:bg-blue-50/30 transition-colors cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0 ring-2 ring-blue-200"></div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Jadwal Wawancara Dikonfirmasi</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Undangan wawancara teknis untuk Process Engineer telah dikirim ke email Anda.</p>
                        <p class="text-xs text-gray-400 mt-1.5 font-medium">1 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 px-5 py-4 hover:bg-blue-50/30 transition-colors cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0 ring-2 ring-blue-200"></div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Update Status Lamaran</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Lamaran Anda untuk posisi QA Specialist telah diperbarui ke 'Shortlisted'.</p>
                        <p class="text-xs text-gray-400 mt-1.5 font-medium">Kemarin, 14:20</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 px-5 py-4 hover:bg-blue-50/30 transition-colors cursor-pointer">
                    <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mt-1.5 shrink-0 ring-2 ring-blue-200"></div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">Lengkapi Profil Anda</p>
                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">Sertifikat TOEFL Anda akan segera kadaluarsa. Harap perbarui dokumen pendukung.</p>
                        <p class="text-xs text-gray-400 mt-1.5 font-medium">2 hari yang lalu</p>
                    </div>
                </div>
            </div>
            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50/50">
                <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 transition-colors flex items-center justify-center gap-1">
                    Lihat Semua Notifikasi
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/pelamar/dashboard.js') }}"></script>
@endsection