@extends('layouts.hr')

@section('title', 'Detail Lowongan')
@section('page-title', 'Detail Lowongan')
@section('nav-lowongan', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="px-8 py-6">

    <!-- Back button + Search + New Recruitment -->
    <div class="flex items-center gap-3 mb-6">
        <a href="/hr/lowongan" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Lowongan
        </a>
        <div class="ml-auto flex items-center gap-3">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Search applicants or files..." class="w-72 pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
            </div>
            <a href="/hr/lowongan/buat" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                New Recruitment
            </a>
        </div>
    </div>

    <!-- Top Row: Info Card + Hiring Urgency -->
    <div class="grid grid-cols-3 gap-5 mb-6">

        <!-- Info Card (col-span-2) -->
        <div class="col-span-2 bg-white rounded-2xl border border-gray-100 p-6 relative overflow-hidden">
            <div class="flex items-start gap-5">
                <!-- Icon -->
                <div class="w-20 h-20 bg-green-50 rounded-2xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="m17.5 9.5 2 2"/><path d="M19 7h0a2 2 0 1 1 2 2"/></svg>
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-2xl font-extrabold text-gray-900">Senior Chemical Engineer</h1>
                            <p class="flex items-center gap-1 text-sm text-gray-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            Batam, Kepulauan Riau — Plant Operations
                            </p>
                        </div>
                        <span class="flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-700 text-xs font-bold px-3 py-1.5 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            ACTIVE RECRUITMENT
                        </span>
                    </div>

                    <div class="flex items-center gap-8 mt-5">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Salary Range</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">Rp 25.0M - 35.0M</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Experience</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">8 - 12 Years</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Posted Date</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">Oct 12, 2023</p>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <a href="/hr/pelamar?lowongan=1" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            View Applicants
                        </a>
                        <a href="/hr/lowongan/buat" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-50 transition-colors">Edit Vacancy</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hiring Urgency -->
        <div class="bg-green-900 rounded-2xl p-6 relative overflow-hidden">
            <!-- Decorative -->
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-3 right-4 w-8 h-8 text-green-600 opacity-30" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 9 9l-7 1 5 5-1 7 6-3 6 3-1-7 5-5-7-1-3-7z"/></svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-3 right-8 w-5 h-5 text-green-600 opacity-20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 9 9l-7 1 5 5-1 7 6-3 6 3-1-7 5-5-7-1-3-7z"/></svg>

            <p class="text-white font-bold text-lg">Hiring Urgency</p>
            <p class="text-green-300 text-xs mt-1 mb-6">Targeting onboard date within 30 days.</p>

            <div class="flex items-end justify-between mb-2">
                <span class="text-xs text-green-300">Days Remaining</span>
                <span class="text-white text-2xl font-extrabold">14 <span class="text-sm font-bold">Days</span></span>
            </div>
            <div class="h-1.5 bg-green-800 rounded-full overflow-hidden">
                <div class="h-full bg-green-400 rounded-full" style="width: 47%"></div>
            </div>
        </div>
    </div>

    <!-- Stat Cards: 4 metrics -->
    <div class="grid grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Applicants</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">124</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Shortlisted</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">42</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Interview</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">18</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Rejected</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">64</p>
            </div>
        </div>
    </div>

    <!-- Weekly Trends + Recent Applicants -->
    <div class="grid grid-cols-3 gap-5">

        <!-- Weekly Trends (col-span-2) -->
        <div class="col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="font-bold text-gray-900 text-lg">Application Trends</h2>
                    <p class="text-xs text-gray-400 mt-0.5" id="chart-subtitle">Jumlah applicants daysan dalam 7 days terakhir</p>
                </div>
                <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5">
                    <button id="btn-daily" class="px-3 py-1.5 text-xs font-semibold rounded-md bg-white text-gray-800 shadow-sm transition-all">Daily</button>
                    <button id="btn-weekly" class="px-3 py-1.5 text-xs font-semibold rounded-md text-gray-500 hover:text-gray-700 transition-all">Weekly</button>
                </div>
            </div>

            <!-- Big chart -->
            <div class="relative">
                <!-- Y-axis labels -->
                <div class="absolute left-0 top-0 bottom-10 flex flex-col justify-between text-[10px] text-gray-300 font-semibold">
                    <span id="y-max">30</span>
                    <span id="y-mid-top"></span>
                    <span id="y-mid"></span>
                    <span id="y-mid-bot"></span>
                    <span>0</span>
                </div>

                <!-- Chart -->
                <div class="ml-8">
                    <svg id="trend-chart" viewBox="0 0 600 280" class="w-full overflow-visible" style="height: 280px;">
                        <defs>
                            <linearGradient id="area-gradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#166534" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#166534" stop-opacity="0"/>
                            </linearGradient>
                        </defs>

                        <!-- Grid lines -->
                        <line x1="0" y1="60"  x2="600" y2="60"  stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="0" y1="120" x2="600" y2="120" stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="0" y1="180" x2="600" y2="180" stroke="#f3f4f6" stroke-width="1"/>
                        <line x1="0" y1="240" x2="600" y2="240" stroke="#f3f4f6" stroke-width="1"/>

                        <!-- Area fill -->
                        <path id="chart-area" fill="url(#area-gradient)"/>
                        <!-- Line -->
                        <path id="chart-line" stroke="#166534" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>

                        <!-- Data points group (populated via JS) -->
                        <g id="chart-points"></g>
                    </svg>

                    <!-- X-axis labels (populated by JS) -->
                    <div id="x-labels" class="flex justify-between mt-3 px-2"></div>
                </div>
            </div>
        </div>

        <!-- Recent Applicants -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="font-bold text-gray-900 mb-5">Recent Applicants</h2>

            <div class="space-y-4">
                <!-- Applicant 1 -->
                <a href="/hr/pelamar/1" class="flex items-center gap-3 -mx-2 px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0">AW</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-green-800 transition-colors">Adrian Wijaya</p>
                        <p class="text-xs text-gray-400 truncate">Master of Chemical Eng.</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-green-700 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>

                <!-- Applicant 2 -->
                <a href="/hr/pelamar/2" class="flex items-center gap-3 -mx-2 px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold text-sm shrink-0">SR</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-green-800 transition-colors">Siti Rahayu</p>
                        <p class="text-xs text-gray-400 truncate">Lead Process Engineer</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-green-700 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>

                <!-- Applicant 3 -->
                <a href="/hr/pelamar/3" class="flex items-center gap-3 -mx-2 px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-bold text-sm shrink-0">BH</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-green-800 transition-colors">Bambang Hartono</p>
                        <p class="text-xs text-gray-400 truncate">Chemical Operations Spec.</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-green-700 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>

            <div class="border-t border-gray-100 mt-5 pt-4">
                <a href="/hr/pelamar?lowongan=1" class="flex items-center justify-between text-sm font-semibold text-green-800 hover:text-green-700 transition-colors">
                    View All 124 Applicants
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Live Security Pulse badge -->
    <div class="flex justify-end mt-6">
        <div class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-bold text-gray-700 uppercase tracking-widest">Live Security Pulse Active</span>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/hr/lowongan-detail.js') }}"></script>
@endsection