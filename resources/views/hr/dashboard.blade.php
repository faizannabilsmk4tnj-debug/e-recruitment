@extends('layouts.hr')

@section('title', 'Dashboard HR')
@section('page-title', 'Dashboard')
@section('nav-dashboard', 'text-green-800 border-green-700 font-semibold')

@section('css')
<style>
    .bar { transition: height 0.6s ease; }
</style>
@endsection

@section('content')
<div class="px-8 py-8">

    <!-- ===== STAT CARDS ===== -->
    <div class="grid grid-cols-4 gap-5 mb-8">

        <!-- Lowongan Aktif -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Lowongan Aktif</p>
            <p class="text-3xl font-extrabold text-gray-900">24</p>
        </div>

        <!-- Total Pelamar Hari Ini -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">+45</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Pelamar Hari Ini</p>
            <p class="text-3xl font-extrabold text-gray-900">158</p>
        </div>

        <!-- Wawancara Minggu Ini -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">Intensif</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Wawancara Minggu Ini</p>
            <p class="text-3xl font-extrabold text-gray-900">42</p>
        </div>

        <!-- Posisi Hampir Tutup -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                </div>
                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Urgent</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Posisi Hampir Tutup</p>
            <p class="text-3xl font-extrabold text-gray-900">5</p>
        </div>
    </div>

    <!-- ===== MAIN GRID ===== -->
    <div class="grid grid-cols-3 gap-6">

        <!-- LEFT (col-span-2) -->
        <div class="col-span-2 space-y-6">

            <!-- Tren Rekrutmen -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-1">
                    <div>
                        <h2 class="font-bold text-gray-900 text-lg">Tren Rekrutmen</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Aktivitas pelamar 6 bulan terakhir</p>
                    </div>
                    <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5">
                        <button id="btn-monthly" class="px-3 py-1.5 text-xs font-semibold rounded-md bg-white text-gray-800 shadow-sm transition-all">Monthly</button>
                        <button id="btn-weekly" class="px-3 py-1.5 text-xs font-semibold rounded-md text-gray-500 hover:text-gray-700 transition-all">Weekly</button>
                    </div>
                </div>

                <!-- Bar Chart -->
                <div class="mt-6 relative">
                    <!-- Y-axis labels -->
                    <div class="absolute left-0 top-0 bottom-6 flex flex-col justify-between">
                        <span class="text-[10px] text-gray-300">100</span>
                        <span class="text-[10px] text-gray-300">75</span>
                        <span class="text-[10px] text-gray-300">50</span>
                        <span class="text-[10px] text-gray-300">25</span>
                        <span class="text-[10px] text-gray-300">0</span>
                    </div>
                    <!-- Bars -->
                    <div class="ml-8 flex items-end gap-3" style="height: 160px;">
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg bg-green-200 chart-bar transition-all duration-500" style="height:55px;" data-monthly="55" data-weekly="40"></div>
                            <span class="text-[10px] font-semibold text-gray-400 chart-label">JAN</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg bg-green-200 chart-bar transition-all duration-500" style="height:72px;" data-monthly="72" data-weekly="60"></div>
                            <span class="text-[10px] font-semibold text-gray-400 chart-label">FEB</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg bg-green-200 chart-bar transition-all duration-500" style="height:65px;" data-monthly="65" data-weekly="85"></div>
                            <span class="text-[10px] font-semibold text-gray-400 chart-label">MAR</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg bg-green-200 chart-bar transition-all duration-500" style="height:88px;" data-monthly="88" data-weekly="55"></div>
                            <span class="text-[10px] font-semibold text-gray-400 chart-label">APR</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg bg-green-200 chart-bar transition-all duration-500" style="height:78px;" data-monthly="78" data-weekly="70"></div>
                            <span class="text-[10px] font-semibold text-gray-400 chart-label">MAY</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                            <div class="w-full rounded-t-lg bg-green-800 chart-bar transition-all duration-500" style="height:140px;" data-monthly="100" data-weekly="45"></div>
                            <span class="text-[10px] font-semibold text-green-800 chart-label">JUN</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Lowongan Aktif -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-5">Status Lowongan Aktif</h2>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Jabatan</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Departemen</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Progres Rekrutmen</th>
                            <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-sm text-gray-900">Senior Chemical Engineer</p>
                            </td>
                            <td class="py-4 pr-4 text-sm text-gray-500">Produksi</td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-700 rounded-full" style="width:75%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 w-8">75%</span>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <button class="text-gray-400 hover:text-gray-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-sm text-gray-900">Sustainability Officer</p>
                            </td>
                            <td class="py-4 pr-4 text-sm text-gray-500">Kepatuhan</td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-700 rounded-full" style="width:40%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 w-8">40%</span>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <button class="text-gray-400 hover:text-gray-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-sm text-gray-900">Plant Manager</p>
                            </td>
                            <td class="py-4 pr-4 text-sm text-gray-500">Operasional</td>
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-700 rounded-full" style="width:15%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 w-8">15%</span>
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <button class="text-gray-400 hover:text-gray-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT (col-span-1) -->
        <div class="space-y-5">

            <!-- Jadwal Wawancara Hari Ini -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-bold text-gray-900">Jadwal Wawancara Hari Ini</h2>
                    <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-1 rounded-full">3 Sesi</span>
                </div>

                <div class="space-y-4">
                    <!-- Sesi 1 -->
                    <div class="flex gap-4 items-start">
                        <div class="text-center shrink-0 w-12">
                            <p class="text-sm font-bold text-gray-900 leading-none">09:00</p>
                            <p class="text-[10px] text-gray-400 font-medium">AM</p>
                        </div>
                        <div class="flex-1 bg-gray-50 rounded-xl p-3 border-l-4 border-green-700">
                            <p class="font-bold text-sm text-gray-900">Budi Santoso</p>
                            <p class="text-xs text-gray-500 mt-0.5">Technical Lead - R&D</p>
                            <div class="flex items-center gap-1 mt-2 text-xs text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="14" x="3" y="5" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                Google Meet
                            </div>
                        </div>
                    </div>

                    <!-- Sesi 2 -->
                    <div class="flex gap-4 items-start">
                        <div class="text-center shrink-0 w-12">
                            <p class="text-sm font-bold text-gray-900 leading-none">11:30</p>
                            <p class="text-[10px] text-gray-400 font-medium">AM</p>
                        </div>
                        <div class="flex-1 bg-gray-50 rounded-xl p-3 border-l-4 border-gray-300">
                            <p class="font-bold text-sm text-gray-900">Siska Wijaya</p>
                            <p class="text-xs text-gray-500 mt-0.5">Finance Supervisor</p>
                            <div class="flex items-center gap-1 mt-2 text-xs text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                Ruang Meeting A2
                            </div>
                        </div>
                    </div>

                    <!-- Sesi 3 -->
                    <div class="flex gap-4 items-start">
                        <div class="text-center shrink-0 w-12">
                            <p class="text-sm font-bold text-gray-900 leading-none">02:00</p>
                            <p class="text-[10px] text-gray-400 font-medium">PM</p>
                        </div>
                        <div class="flex-1 bg-gray-50 rounded-xl p-3 border-l-4 border-gray-300">
                            <p class="font-bold text-sm text-gray-900">Ahmad Fauzi</p>
                            <p class="text-xs text-gray-500 mt-0.5">Maintenance Staff</p>
                            <div class="flex items-center gap-1 mt-2 text-xs text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                Workshop Utama
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action -->
            <div class="bg-green-900 rounded-2xl p-6 text-center">
                <p class="text-xs font-bold text-green-400 uppercase tracking-widest mb-2">Quick Action</p>
                <p class="text-white font-bold text-base mb-4">Butuh Rekrutmen Baru?</p>
                <a href="/hr/lowongan" class="flex items-center justify-center gap-2 w-full bg-green-700 hover:bg-green-600 text-white font-semibold py-3 rounded-xl text-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                    Buat Lowongan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/hr/dashboard.js') }}"></script>
@endsection