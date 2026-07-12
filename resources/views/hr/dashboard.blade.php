@extends('layouts.hr')

@section('title', 'HR Dashboard')
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
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">Active</span>
            </div>
            <div class="flex items-center gap-1.5 mb-1 text-gray-500">
                <span class="text-sm">Active Vacancies</span>
                <div class="relative inline-block leading-none z-20">
                    <button type="button" class="info-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    </button>
                    <div class="info-tooltip hidden absolute z-30 w-48 bg-gray-900 text-white text-[10px] font-semibold rounded-lg p-2.5 shadow-lg -left-20 top-6 pointer-events-none">
                        <p class="text-green-400 mb-1">+ : vacancy opened</p>
                        <p class="text-red-400">- : vacancy closed</p>
                    </div>
                </div>
            </div>
            <div class="flex items-baseline gap-3">
                <p class="text-3xl font-extrabold text-gray-900 leading-none">{{ $activeVacanciesCount }}</p>
                <div class="flex flex-col text-[11px] font-bold leading-normal shrink-0">
                    @if($vacanciesAdded > 0)
                        <span class="text-green-600">+{{ $vacanciesAdded }}</span>
                    @endif
                    @if($vacanciesRemoved > 0)
                        <span class="text-red-500">-{{ $vacanciesRemoved }}</span>
                    @endif
                </div>
            </div>
        </a>

        <!-- Total Pelamar Hari Ini / Overall -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden hover:shadow-lg hover:border-green-200 transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <!-- Toggle Switch -->
                <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5 text-[10px] font-bold relative z-10">
                    <button type="button" id="btn-applicants-today" class="px-2.5 py-1 rounded-md bg-white text-gray-800 shadow-sm transition-all">Today</button>
                    <button type="button" id="btn-applicants-overall" class="px-2.5 py-1 rounded-md text-gray-500 hover:text-gray-700 transition-all">Overall</button>
                </div>
            </div>
            <a href="/hr/pelamar" class="block">
                <div class="flex items-center gap-1.5 mb-1 text-gray-500">
                    <span id="label-applicants" class="text-sm">Total Applicants Today</span>
                    <div class="relative inline-block leading-none z-20">
                        <button type="button" id="info-applicants-btn" class="info-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        </button>
                        <div id="info-applicants-tooltip" class="info-tooltip hidden absolute z-30 w-48 bg-gray-900 text-white text-[10px] font-semibold rounded-lg p-2.5 shadow-lg -left-20 top-6 pointer-events-none">
                            <!-- Filled dynamically by JS -->
                        </div>
                    </div>
                </div>
                <div class="flex items-baseline gap-3">
                    <p id="value-applicants" class="text-3xl font-extrabold text-gray-900 leading-none" data-today="{{ $applicantsToday }}" data-overall="{{ $applicantsOverall }}">{{ $applicantsToday }}</p>
                    <div id="change-applicants" class="flex flex-col text-[11px] font-bold leading-normal shrink-0"
                         data-today-added="{{ $applicantsTodayAdded }}"
                         data-today-removed="{{ $applicantsTodayRemoved }}"
                         data-overall-added="{{ $applicantsOverallAdded }}"
                         data-overall-removed="{{ $applicantsOverallRemoved }}">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </a>
        </div>

        <!-- Wawancara Minggu Ini / Scheduled -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5 relative overflow-hidden hover:shadow-lg hover:border-green-200 transition-all">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <!-- Toggle Switch -->
                <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5 text-[10px] font-bold relative z-10">
                    <button type="button" id="btn-interviews-week" class="px-2.5 py-1 rounded-md bg-white text-gray-800 shadow-sm transition-all">This Week</button>
                    <button type="button" id="btn-interviews-overall" class="px-2.5 py-1 rounded-md text-gray-500 hover:text-gray-700 transition-all">Scheduled</button>
                </div>
            </div>
            <a href="/hr/wawancara/daftar" class="block">
                <div class="flex items-center gap-1.5 mb-1 text-gray-500">
                    <span id="label-interviews" class="text-sm">Interviews This Week</span>
                    <div class="relative inline-block leading-none z-20">
                        <button type="button" id="info-interviews-btn" class="info-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        </button>
                        <div id="info-interviews-tooltip" class="info-tooltip hidden absolute z-30 w-48 bg-gray-900 text-white text-[10px] font-semibold rounded-lg p-2.5 shadow-lg -left-20 top-6 pointer-events-none">
                            <!-- Filled dynamically by JS -->
                        </div>
                    </div>
                </div>
                <div class="flex items-baseline gap-3">
                    <p id="value-interviews" class="text-3xl font-extrabold text-gray-900 leading-none" data-week="{{ $interviewsThisWeek }}" data-overall="{{ $interviewsOverall }}">{{ $interviewsThisWeek }}</p>
                    <div id="change-interviews" class="flex flex-col text-[11px] font-bold leading-normal shrink-0"
                         data-week-added="{{ $interviewsWeekAdded }}"
                         data-week-removed="{{ $interviewsWeekRemoved }}"
                         data-overall-added="{{ $interviewsOverallAdded }}"
                         data-overall-removed="{{ $interviewsOverallRemoved }}">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </a>
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
                        <div class="flex items-center gap-2">
                            <h2 class="font-bold text-gray-900 text-lg">Recruitment Trends</h2>
                            <span id="chart-total-badge" class="px-2 py-0.5 text-[10px] font-bold text-green-800 bg-green-50 rounded-full border border-green-100">Total: 0 Applicants</span>
                        </div>
                        <p id="chart-sub-desc" class="text-xs text-gray-400 mt-0.5">Applicant activity in the last 6 months</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Navigation Arrows (only visible when in monthly mode) -->
                        <div id="chart-nav" class="flex gap-1">
                            <button id="btn-chart-prev" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg flex items-center justify-center transition-colors disabled:opacity-40 disabled:cursor-not-allowed" title="Previous 6 Months">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button id="btn-chart-next" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg flex items-center justify-center transition-colors disabled:opacity-40 disabled:cursor-not-allowed" title="Next 6 Months">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                        <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5">
                            <button id="btn-monthly" class="px-3 py-1.5 text-xs font-semibold rounded-md bg-white text-gray-800 shadow-sm transition-all">Monthly</button>
                            <button id="btn-weekly" class="px-3 py-1.5 text-xs font-semibold rounded-md text-gray-500 hover:text-gray-700 transition-all">Weekly</button>
                        </div>
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
                    <div id="chart-bars-container" class="ml-8 flex items-end gap-3" style="height: 160px;">
                        <!-- Generated dynamically by JavaScript -->
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
                            <th class="pb-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($activeVacancies as $job)
                            @php
                                $progress = $job->quota > 0 ? min(100, round(($job->applications_count / $job->quota) * 100)) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="if(!event.target.closest('a') && !event.target.closest('button')) window.location.href='/hr/lowongan/{{ $job->id }}'">
                                <td class="py-4 pr-4">
                                    <div class="flex items-center gap-2">
                                        <p class="font-semibold text-sm text-gray-900 hover:text-green-800 transition-colors">{{ $job->title }}</p>
                                        <span class="text-[9px] font-bold text-green-700 bg-green-50 border border-green-200 px-1.5 py-0.5 rounded uppercase shrink-0">{{ str_replace('-', ' ', $job->employment_type) }}</span>
                                    </div>
                                </td>
                                <td class="py-4 pr-4 text-sm text-gray-500">{{ $job->category->name ?? 'Category' }}</td>
                                <td class="py-4 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-green-700 rounded-full" style="width:{{ $progress }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-600 w-8">{{ $progress }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="/hr/lowongan?edit={{ $job->id }}" class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 hover:text-green-800 px-3 py-1.5 rounded-lg text-xs font-bold transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-gray-400 italic">No active vacancies available.</td>
                            </tr>
                        @endforelse
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
                        @php
                            $firstDate = array_key_first($wawancaraData);
                            $firstDateCount = $firstDate ? count($wawancaraData[$firstDate]) : 0;
                        @endphp
                        <span id="wawancara-count" class="text-xs font-bold {{ $firstDateCount > 0 ? 'text-green-700 bg-green-50' : 'text-gray-500 bg-gray-100' }} px-2 py-1 rounded-full">{{ $firstDateCount }} {{ $firstDateCount === 1 ? 'Session' : 'Sessions' }}</span>
                    </div>
                    <select id="wawancara-date" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-green-700 text-gray-700 w-full font-medium cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        @if(count($wawancaraData) > 0)
                            @foreach(array_keys($wawancaraData) as $dateStr)
                                <option value="{{ $dateStr }}">{{ \Carbon\Carbon::parse($dateStr)->format('l, d M Y') }}</option>
                            @endforeach
                        @else
                            <option value="2026-04-30">Thursday, 30 Apr 2026</option>
                            <option value="2026-05-01">Friday, 1 May 2026</option>
                            <option value="2026-05-05">Tuesday, 5 May 2026</option>
                            <option value="2026-05-12">Tuesday, 12 May 2026</option>
                        @endif
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
<script>
    window.dbChartData = {
        monthly: {
            labels: {!! json_encode(array_keys($monthlyTrends)) !!},
            values: {!! json_encode(array_values($monthlyTrends)) !!},
            activeIndex: {{ array_search(strtoupper(now()->format('M')), array_keys($monthlyTrends)) !== false ? array_search(strtoupper(now()->format('M')), array_keys($monthlyTrends)) : 5 }}
        },
        weekly: {
            labels: {!! json_encode(array_keys($weeklyTrends)) !!},
            values: {!! json_encode(array_values($weeklyTrends)) !!},
            dates: {!! json_encode($weeklyDates) !!},
            activeIndex: {{ array_search(strtoupper(now()->format('D')), array_keys($weeklyTrends)) !== false ? array_search(strtoupper(now()->format('D')), array_keys($weeklyTrends)) : 5 }}
        },
        wawancara: {!! json_encode($wawancaraData) !!}
    };
</script>
<script src="{{ asset('js/hr/dashboard.js') }}"></script>
@endsection