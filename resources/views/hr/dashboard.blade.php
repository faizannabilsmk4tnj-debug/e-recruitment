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
    <div class="grid grid-cols-3 gap-5 mb-8">

        <!-- Lowongan Aktif -->
        <a href="/hr/lowongan" class="block bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden hover:shadow-lg hover:border-green-200 transition-all cursor-pointer">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Active Vacancies</p>
            <p class="text-3xl font-extrabold text-gray-900">24</p>
        </a>

        <!-- Total Pelamar Hari Ini -->
        <a href="/hr/pelamar" class="block bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden hover:shadow-lg hover:border-green-200 transition-all cursor-pointer">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">+45</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Applicants Today</p>
            <p class="text-3xl font-extrabold text-gray-900">158</p>
        </a>

        <!-- Wawancara Minggu Ini -->
        <a href="/hr/wawancara/daftar" class="block bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden hover:shadow-lg hover:border-green-200 transition-all cursor-pointer">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">Intensive</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Interviews This Week</p>
            <p class="text-3xl font-extrabold text-gray-900">42</p>
        </a>


    </div>

    <!-- ===== MAIN GRID ===== -->
    <div class="grid grid-cols-3 gap-6">

        <!-- LEFT (col-span-2) -->
        <div class="col-span-2 space-y-6">

            <!-- Tren Rekrutmen -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-1">
                    <div>
                        <h2 class="font-bold text-gray-900 text-lg">Recruitment Trends</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Applicant activity in the last 6 months</p>
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
                <h2 class="font-bold text-gray-900 mb-5">Active Vacancy Status</h2>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Position</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Department</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Recruitment Progress</th>
                            <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-sm text-gray-900">Senior Chemical Engineer</p>
                            </td>
                            <td class="py-4 pr-4 text-sm text-gray-500">Production</td>
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
                            <td class="py-4 pr-4 text-sm text-gray-500">Compliance</td>
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
                            <td class="py-4 pr-4 text-sm text-gray-500">Operations</td>
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

            <!-- Jadwal Wawancara -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex flex-col mb-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="font-bold text-gray-900">Interview Schedule</h2>
                        <span id="wawancara-count" class="text-xs font-bold text-green-700 bg-green-50 px-2 py-1 rounded-full">3 Sessions</span>
                    </div>
                    <select id="wawancara-date" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-green-700 text-gray-700 w-full font-medium cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <option value="2026-04-30">Thursday, 30 Apr 2026</option>
                        <option value="2026-05-01">Friday, 1 May 2026</option>
                        <option value="2026-05-05">Tuesday, 5 May 2026</option>
                        <option value="2026-05-12">Tuesday, 12 May 2026</option>
                    </select>
                </div>

                <div id="wawancara-list" class="space-y-4">
                    <!-- Diisi oleh JavaScript -->
                </div>
                
                <div id="wawancara-empty" class="hidden text-center py-6">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-medium text-gray-600">No schedules</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">No interviews scheduled for today.</p>
                </div>
            </div>

        </div>
    </div>
</div>

    <!-- Modal Detail Chart -->
    <div id="chart-modal" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-md mx-4 p-7 relative">
            <button id="btn-close-chart-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Applicant Detail - <span id="chart-modal-title"></span></h3>
            <p id="chart-modal-desc" class="text-sm text-gray-500 mb-6">Here are the daily applicant details for this period.</p>
            
            <div class="bg-gray-50 rounded-xl p-4 mb-6" id="chart-modal-content">
                <!-- Injected via JS -->
            </div>

            <a href="/hr/pelamar" class="w-full flex items-center justify-center bg-green-700 hover:bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                Manage Applicant Data
            </a>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/hr/dashboard.js') }}"></script>
@endsection