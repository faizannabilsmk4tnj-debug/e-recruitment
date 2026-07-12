@extends('layouts.hr')

@section('title', 'Vacancy Details')
@section('page-title', 'Vacancy Details')
@section('nav-lowongan', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="px-8 py-6">

    <!-- Back button -->
    <div class="flex items-center gap-3 mb-6">
        <a href="/hr/lowongan" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Back to Vacancies
        </a>
    </div>

    <!-- Top Row: Info Card + Hiring Urgency -->
    <div class="grid grid-cols-3 gap-5 mb-6">

        <!-- Info Card (col-span-2) -->
        <div class="col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden relative">
            @if($vacancy->banner_image)
            <div class="w-full h-48 relative">
                <img src="{{ asset($vacancy->banner_image) }}" alt="Cover Banner" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="p-6 {{ $vacancy->banner_image ? 'relative -mt-6 rounded-t-3xl bg-white z-10' : '' }}">
                <!-- Category Badge -->
                <div class="mb-3">
                    <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-md uppercase tracking-wider">
                        {{ $vacancy->category->name ?? 'General' }}
                    </span>
                </div>

                <!-- Text content safely on white background -->
                <div>
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-2xl font-extrabold text-gray-900 flex items-center gap-3">
                                {{ $vacancy->title }}
                                <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full uppercase shrink-0">{{ str_replace('-', ' ', $vacancy->employment_type) }}</span>
                            </h1>
                            <p class="flex items-center gap-1 text-sm text-gray-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $vacancy->location ?: 'Batam Plant' }}
                            </p>
                        </div>
                        @php
                            $statusClasses = [
                                'open' => 'bg-green-50 border-green-200 text-green-700',
                                'draft' => 'bg-amber-50 border-amber-200 text-amber-700',
                                'closed' => 'bg-red-50 border-red-200 text-red-700',
                                'expired' => 'bg-gray-50 border-gray-200 text-gray-700',
                                'filled' => 'bg-blue-50 border-blue-200 text-blue-700',
                            ];
                            $statusClass = $statusClasses[$vacancy->status] ?? 'bg-gray-50 border-gray-200 text-gray-700';

                            $dotClasses = [
                                'open' => 'bg-green-500 animate-pulse',
                                'draft' => 'bg-amber-500',
                                'closed' => 'bg-red-500',
                                'expired' => 'bg-gray-500',
                                'filled' => 'bg-blue-500',
                            ];
                            $dotClass = $dotClasses[$vacancy->status] ?? 'bg-gray-500';
                            
                            $statusLabel = $vacancy->status === 'open' ? 'ACTIVE RECRUITMENT' : $vacancy->status;
                        @endphp
                        <span class="flex items-center gap-1.5 border {{ $statusClass }} text-xs font-bold px-3 py-1.5 rounded-full shrink-0">
                            <span class="w-1.5 h-1.5 {{ $dotClass }} rounded-full"></span>
                            {{ strtoupper($statusLabel) }}
                        </span>
                    </div>
                </div>

                <div class="flex-center gap-8 mt-5">
                    <div class="flex items-center gap-8">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Salary Range</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">
                                @if($vacancy->show_salary && $vacancy->salary_min && $vacancy->salary_max)
                                    Rp {{ number_format($vacancy->salary_min / 1000000, 1, ',', '.') }}M - {{ number_format($vacancy->salary_max / 1000000, 1, ',', '.') }}M
                                @else
                                    Hidden
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Quota</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">{{ $vacancy->quota }} Personnel</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Age Limit</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">
                                @if($vacancy->age_min || $vacancy->age_max)
                                    {{ $vacancy->age_min ?? 'Any' }} - {{ $vacancy->age_max ?? 'Any' }} Yrs
                                @else
                                    No Limit
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Passing Grade</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">{{ $vacancy->passing_grade ?? 70 }} Point</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Posted Date</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">{{ $vacancy->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        @if($vacancy->status !== 'draft')
                            <a href="/hr/pelamar?lowongan={{ $vacancy->id }}" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                View Applicants
                            </a>
                        @endif

                        @if($vacancy->status === 'draft')
                            <button id="btn-publish-detail" data-id="{{ $vacancy->id }}" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Publish Vacancy
                            </button>
                            <button id="btn-edit-detail" data-id="{{ $vacancy->id }}" class="flex items-center gap-2 border border-gray-300 text-gray-700 font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                Edit Vacancy
                            </button>
                        @else
                            <button id="btn-edit-detail" data-id="{{ $vacancy->id }}" class="flex items-center gap-2 border border-gray-300 text-gray-700 font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                Edit Vacancy
                            </button>
                        @endif
                        <a href="/hr/lowongan" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg text-sm hover:bg-gray-50 transition-colors">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vacancy Progress -->
        @php
            $startDate = $vacancy->created_at;
            $endDate = $vacancy->deadline ? \Carbon\Carbon::parse($vacancy->deadline)->endOfDay() : $startDate->copy()->addDays(30);
            
            $totalDays = max(1, $startDate->diffInDays($endDate));
            $daysRemaining = max(0, now()->diffInDays($endDate, false));
            if (now() > $endDate || in_array($vacancy->status, ['closed', 'expired', 'filled'])) {
                $daysRemaining = 0;
            }
            // Round days remaining to a clean integer
            $daysRemainingClean = round($daysRemaining);
            
            $percentRemaining = $totalDays > 0 ? min(100, max(0, round(($daysRemaining / $totalDays) * 100))) : 0;
            if (in_array($vacancy->status, ['closed', 'expired', 'filled'])) {
                $percentRemaining = 0;
            }

            // Quota calculations
            $quota = $vacancy->quota ?? 1;
            $currentApplicants = $stats['total'] ?? 0;
            $percentQuota = min(100, round(($currentApplicants / $quota) * 100));

            $cardBg = in_array($vacancy->status, ['closed', 'expired', 'filled']) ? 'bg-gray-900' : 'bg-green-900';
            $barBg = in_array($vacancy->status, ['closed', 'expired', 'filled']) ? 'bg-gray-800' : 'bg-green-800';
            $fillBg = in_array($vacancy->status, ['closed', 'expired', 'filled']) ? 'bg-gray-500' : 'bg-green-400';
            $textMuted = in_array($vacancy->status, ['closed', 'expired', 'filled']) ? 'text-gray-400' : 'text-green-300';
            
            $autoCloseMethod = $vacancy->auto_close_method ?? 'both';
        @endphp
        <div class="{{ $cardBg }} rounded-2xl p-6 relative overflow-hidden self-start">
            <!-- Decorative -->
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-3 right-4 w-8 h-8 text-white opacity-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 9 9l-7 1 5 5-1 7 6-3 6 3-1-7 5-5-7-1-3-7z"/></svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-3 right-8 w-5 h-5 text-white opacity-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 9 9l-7 1 5 5-1 7 6-3 6 3-1-7 5-5-7-1-3-7z"/></svg>

            <p class="text-white font-bold text-lg">Vacancy Progress</p>
            
            @if(in_array($vacancy->status, ['closed', 'expired', 'filled']))
                <p class="text-gray-400 text-xs mt-1 mb-6">This recruitment process has been concluded.</p>
            @elseif($autoCloseMethod === 'deadline')
                <p class="text-green-300 text-xs mt-1 mb-6">Auto-close is active based on time deadline on {{ $vacancy->deadline ? \Carbon\Carbon::parse($vacancy->deadline)->format('M d, Y') : '-' }}.</p>
            @elseif($autoCloseMethod === 'quota')
                <p class="text-green-300 text-xs mt-1 mb-6">Auto-close is active based on recruitment quota of {{ $quota }} applicants.</p>
            @elseif($autoCloseMethod === 'both')
                <p class="text-green-300 text-xs mt-1 mb-6">Auto-close is active when either deadline ({{ $vacancy->deadline ? \Carbon\Carbon::parse($vacancy->deadline)->format('M d, Y') : '-' }}) or quota ({{ $quota }} applicants) is reached.</p>
            @else
                <p class="text-green-300 text-xs mt-1 mb-6">Recruitment is managed manually by HR.</p>
            @endif

            @if(in_array($vacancy->status, ['closed', 'expired', 'filled']))
                <div class="flex items-center justify-between mt-4">
                    <span class="text-xs text-gray-400">Status</span>
                    <span class="text-red-400 text-sm font-bold uppercase tracking-wider">Concluded</span>
                </div>
            @else
                <div class="space-y-5 mt-4">
                    <!-- 1. TIME COUNTDOWN METRIC -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs {{ $textMuted }}">Days Remaining</span>
                                @if(in_array($autoCloseMethod, ['deadline', 'both']))
                                    <!-- Auto Close active marker -->
                                    <span class="tooltip-container cursor-pointer inline-flex items-center" data-tooltip="Auto-close is active based on time deadline. System will automatically close the posting once the deadline ends.">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-yellow-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-1.5">
                                <!-- Warning indicator: Hidden by default, shown by JS when time's up -->
                                <span id="time-warning-icon" class="hidden text-red-500 animate-pulse tooltip-container cursor-pointer inline-flex items-center" data-tooltip="Recruitment deadline has expired.">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                </span>
                                <!-- Live Countdown Container -->
                                <div id="countdown-container" 
                                     data-deadline="{{ $vacancy->deadline ? \Carbon\Carbon::parse($vacancy->deadline)->endOfDay()->toIso8601String() : '' }}"
                                     data-created="{{ $vacancy->created_at->toIso8601String() }}">
                                    <span id="countdown-timer" class="text-white text-base font-extrabold tracking-tight">Calculating...</span>
                                </div>
                            </div>
                        </div>
                        <div class="h-1.5 {{ $barBg }} rounded-full overflow-hidden">
                            <div id="time-progress-bar" class="h-full {{ $fillBg }} rounded-full transition-all duration-1000" style="width: {{ $percentRemaining }}%"></div>
                        </div>
                    </div>

                    <!-- 2. QUOTA METRIC -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs {{ $textMuted }}">Quota Filled</span>
                                @if(in_array($autoCloseMethod, ['quota', 'both']))
                                    <!-- Auto Close active marker -->
                                    <span class="tooltip-container cursor-pointer inline-flex items-center" data-tooltip="Auto-close is active based on recruitment quota. System will automatically stop accepting new applications once the quota is reached.">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-yellow-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center gap-1.5">
                                @if($currentApplicants >= $quota)
                                    <!-- Quota is Full indicator: green checkmark -->
                                    <span id="quota-warning-icon" class="text-green-400 tooltip-container cursor-pointer inline-flex items-center" data-tooltip="Recruitment quota is full.">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                @endif
                                <span class="text-white text-base font-extrabold tracking-tight">
                                    {{ $currentApplicants }} <span class="text-xs text-gray-300 font-semibold font-normal">/ {{ $quota }} Applicants</span>
                                </span>
                            </div>
                        </div>
                        <div class="h-1.5 {{ $barBg }} rounded-full overflow-hidden">
                            <div class="h-full {{ $fillBg }} rounded-full" style="width: {{ $percentQuota }}%"></div>
                        </div>
                    </div>
                </div>
            @endif
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
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Shortlisted</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $stats['shortlisted'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Interview</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $stats['interview'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Rejected</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $stats['rejected'] }}</p>
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
                    <p class="text-xs text-gray-400 mt-0.5" id="chart-subtitle">Daily applicants in the last 7 days</p>
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

            <div class="space-y-4" id="recent-applicants-list">
                @forelse($applicants->take(3) as $app)
                @php
                    $initials = '';
                    $parts = explode(' ', $app->applicant_name);
                    foreach($parts as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                    }
                    $initials = substr($initials, 0, 2);
                    
                    // Simple randomized gradient/color for visual aesthetic
                    $colors = ['from-blue-400 to-blue-600', 'from-purple-400 to-purple-600', 'from-amber-400 to-amber-600', 'from-green-400 to-green-600', 'from-rose-400 to-rose-600'];
                    $colorGrad = $colors[$app->user_id % count($colors)];
                @endphp
                <a href="/hr/pelamar/{{ $app->id }}" class="recent-applicant-item flex items-center gap-3 -mx-2 px-2 py-1 rounded-lg hover:bg-gray-50 transition-colors group" data-name="{{ strtolower($app->applicant_name) }}" data-education="{{ strtolower($app->education_level ?: 'applicant') }}">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $colorGrad }} flex items-center justify-center text-white font-bold text-sm shrink-0">{{ $initials }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate group-hover:text-green-800 transition-colors">{{ $app->applicant_name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $app->education_level ?: 'Applicant' }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-green-700 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                @empty
                <p class="text-xs text-gray-400 py-2">No applicants yet.</p>
                @endforelse
                <div id="no-recent-matches" class="hidden text-xs text-gray-400 py-2">No matching applicants.</div>
            </div>

            <div class="border-t border-gray-100 mt-5 pt-4">
                <a href="/hr/pelamar" class="flex items-center justify-between text-sm font-semibold text-green-800 hover:text-green-700 transition-colors">
                    View All {{ $stats['total'] }} Applicants
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal: Publish Vacancy confirm -->
    <div id="modal-publish-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative shadow-2xl">
            <button id="btn-close-publish-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Publish Vacancy?</h3>
            <p class="text-sm text-gray-500 mb-5">Are you sure you want to publish this vacancy? It will immediately go active and be open to the public for applications.</p>
            <div class="space-y-2.5">
                <button id="btn-confirm-publish-vacancy" class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors focus:outline-none">Yes, Publish</button>
                <button id="btn-cancel-publish-vacancy" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors focus:outline-none">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Modal: Vacancy Incomplete Alert -->
    <div id="modal-incomplete-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative shadow-2xl">
            <button id="btn-close-incomplete-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Incomplete Data</h3>
            <p class="text-sm text-gray-500 mb-5">The details for this vacancy are incomplete. Please complete all required information before publishing.</p>
            <div class="space-y-2.5">
                <button id="btn-incomplete-lengkapi" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 rounded-lg text-sm text-center transition-colors focus:outline-none">Complete Data</button>
                <button id="btn-confirm-incomplete-ok" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors focus:outline-none">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Modal: Create/Edit Vacancy -->
    <div id="modal-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl">
            <div class="bg-green-900 px-6 py-5 flex items-center justify-between">
                <h2 class="text-white font-bold">Edit Vacancy</h2>
                <button id="btn-close-vacancy-modal" class="text-green-300 hover:text-white transition-colors focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4 max-h-[70vh] overflow-y-auto">
                <!-- Published Lock Banner -->
                <div id="v-published-lock-banner" class="col-span-2 hidden bg-amber-50 border border-amber-200 text-amber-800 text-xs px-4 py-3 rounded-lg flex items-start gap-2.5 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <div>
                        <p class="font-bold">Core fields are locked</p>
                        <p class="text-amber-700/90 mt-0.5">This vacancy is already published. Core details (title, category, type, location, salary, benefits, description, requirements) cannot be edited to protect active applicants.</p>
                    </div>
                </div>

                <!-- Cover Image Banner -->
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Cover Image Banner</label>
                    <div id="v-cover-drop-area" class="bg-gray-50 border border-dashed border-gray-200 rounded-xl h-28 flex flex-col items-center justify-center relative overflow-hidden group">
                        <input type="file" id="v-cover-upload" class="hidden" accept="image/*">
                        <div id="v-upload-placeholder" class="flex flex-col items-center gap-1 cursor-pointer">
                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow text-gray-400 group-hover:scale-105 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            </div>
                            <span class="text-[10px] font-semibold text-gray-500">Upload Cover Image</span>
                        </div>
                        <img id="v-img-preview" src="" alt="Cover Preview" class="hidden absolute inset-0 w-full h-full object-cover">
                        <button type="button" id="btn-v-remove-img" class="hidden absolute top-2 right-2 bg-black/60 hover:bg-black/80 text-white rounded-full p-1.5 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Position Title <span class="text-red-500 ml-0.5">*</span></label>
                    <input type="text" id="v-title" placeholder="e.g. Chemical Process Engineer" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Category <span class="text-red-500 ml-0.5">*</span></label>
                    <select id="v-category" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="">Select category...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                        <option value="ADD_NEW_CATEGORY" class="font-bold text-green-700 bg-green-50">+ Add New Category</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Employment Type <span class="text-red-500 ml-0.5">*</span></label>
                    <select id="v-employment-type" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="full-time">Full-time</option>
                        <option value="part-time">Part-time</option>
                        <option value="contract">Contract</option>
                        <option value="internship">Internship</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Work Location <span class="text-red-500 ml-0.5">*</span></label>
                    <select id="v-location" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="">Select location...</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->name }}">{{ $loc->name }}</option>
                        @endforeach
                        <option value="ADD_NEW_LOCATION" class="font-bold text-green-700 bg-green-50">+ Add New Location</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Maximum Applicants <span class="text-red-500 ml-0.5">*</span></label>
                    <input type="number" id="v-quota" placeholder="e.g. 3" min="1" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Deadline <span class="text-red-500 ml-0.5">*</span></label>
                    <input type="date" id="v-deadline" min="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Age Limits (Min / Max)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" id="v-age-min" placeholder="Min" min="0" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <input type="number" id="v-age-max" placeholder="Max" min="0" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Interview Passing Grade</label>
                    <input type="number" id="v-passing-grade" placeholder="e.g. 70" min="0" max="100" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Status</label>
                    <select id="v-status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="DRAFT">Draft</option>
                        <option value="ACTIVE">Active</option>
                        <option value="CLOSED">Closed</option>
                        <option value="FILLED">Filled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Auto Close Method</label>
                    <select id="v-auto-close" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="both">Deadline or Quota Met</option>
                        <option value="deadline">Only Deadline Reached</option>
                        <option value="quota">Only Quota Met</option>
                        <option value="manual">Manual Close Only</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Show Salary Range</label>
                    <div class="flex items-center h-10 mt-1">
                        <input type="checkbox" id="v-show-salary" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span class="ml-2 text-xs text-gray-600">Show to applicants</span>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Salary Range (Min / Max)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" id="v-salary-min" placeholder="Min" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500">
                        <input type="text" id="v-salary-max" placeholder="Max" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Description <span class="text-red-500 ml-0.5">*</span></label>
                    <div class="ck-editor-wrapper">
                        <textarea id="v-desc" placeholder="Brief job description..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Requirements <span class="text-red-500 ml-0.5">*</span></label>
                    <div class="ck-editor-wrapper">
                        <textarea id="v-requirements" placeholder="Minimum education, skills, experience..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                    </div>
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Benefits</label>
                    <input type="text" id="v-benefits" placeholder="e.g. Health Insurance, Meal Allowance, Transport (comma-separated)" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button id="btn-cancel-vacancy" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
                <button id="btn-save-vacancy" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Modal: Add Category -->
    <div id="modal-add-category" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl animate-fade-in">
            <div class="bg-green-900 px-6 py-4 flex items-center justify-between">
                <h2 class="text-white font-bold">Manage Job Categories</h2>
                <button id="btn-close-category-modal" class="text-green-300 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            
            <!-- Form Tambah Baru -->
            <div class="p-6 pb-4">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 font-sans">Add New Category</label>
                <div class="flex gap-2">
                    <input type="text" id="cat-name-input" placeholder="e.g. Engineering, Marketing..." class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <button id="btn-save-category" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors">Add</button>
                </div>
            </div>

            <!-- Daftar Kategori Saat Ini -->
            <div id="manage-category-list-section" class="px-6 py-4 border-t border-gray-100 mt-2 bg-gray-50/50">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2.5 font-sans">Current Categories</label>
                <div class="max-h-48 overflow-y-auto space-y-2 pr-1" id="category-list-container">
                    @foreach($categories as $cat)
                        <div class="flex items-center justify-between bg-white px-3.5 py-2.5 rounded-lg border border-gray-200 shadow-sm" data-id="{{ $cat->id }}" data-name="{{ $cat->name }}">
                            <span class="text-sm font-semibold text-gray-700">{{ $cat->name }}</span>
                            <button class="btn-delete-category text-gray-400 hover:text-red-600 transition-colors p-1" data-id="{{ $cat->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                <button id="btn-cancel-category" class="border border-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal: Add Location -->
    <div id="modal-add-location" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl animate-fade-in">
            <div class="bg-green-900 px-6 py-4 flex items-center justify-between">
                <h2 class="text-white font-bold">Manage Work Locations</h2>
                <button id="btn-close-location-modal" class="text-green-300 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            
            <!-- Form Tambah Baru -->
            <div class="p-6 pb-4">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5 font-sans">Add New Location</label>
                <div class="flex gap-2">
                    <input type="text" id="loc-name-input" placeholder="e.g. Surabaya Office..." class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <button id="btn-save-location" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors">Add</button>
                </div>
            </div>

            <!-- Daftar Lokasi Saat Ini -->
            <div id="manage-location-list-section" class="px-6 py-4 border-t border-gray-100 mt-2 bg-gray-50/50">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2.5 font-sans">Current Locations</label>
                <div class="max-h-48 overflow-y-auto space-y-2 pr-1" id="location-list-container">
                    @foreach($locations as $loc)
                        <div class="flex items-center justify-between bg-white px-3.5 py-2.5 rounded-lg border border-gray-200 shadow-sm" data-id="{{ $loc->id }}" data-name="{{ $loc->name }}">
                            <span class="text-sm font-semibold text-gray-700">{{ $loc->name }}</span>
                            <button class="btn-delete-location text-gray-400 hover:text-red-600 transition-colors p-1" data-id="{{ $loc->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                <button id="btn-cancel-location" class="border border-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal: Custom Confirm Deletion -->
    <div id="modal-custom-confirm" class="fixed inset-0 bg-black/50 z-[70] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative shadow-2xl animate-fade-in">
            <button id="btn-close-confirm-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <div id="confirm-modal-icon-container" class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <!-- Dynamic Icon -->
            </div>
            <h3 id="confirm-modal-title" class="text-lg font-bold text-gray-900 mb-2">Confirm Delete</h3>
            <p id="confirm-modal-desc" class="text-sm text-gray-500 mb-6">Are you sure you want to delete this item?</p>
            <div class="flex gap-3">
                <button id="btn-confirm-cancel" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors focus:outline-none">Cancel</button>
                <button id="btn-confirm-ok" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors focus:outline-none">Delete</button>
            </div>
        </div>
    </div>

    <!-- Modal: Custom Alert/Notification -->
    <div id="modal-custom-alert" class="fixed inset-0 bg-black/50 z-[70] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative shadow-2xl animate-fade-in">
            <button id="btn-close-alert-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <div id="alert-modal-icon-container" class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <!-- Dynamic Icon -->
            </div>
            <h3 id="alert-modal-title" class="text-lg font-bold text-gray-900 mb-2">Notification</h3>
            <p id="alert-modal-desc" class="text-sm text-gray-500 mb-6">Something happened.</p>
            <button id="btn-alert-ok" class="w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-2.5 rounded-lg text-sm transition-colors focus:outline-none">OK</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
<script>
    window.postedDate = "{{ $vacancy->created_at->format('Y-m-d') }}";
    window.weeklyDailyData = @json($weeklyDailyData);
    window.vacancyData = @json($vacancy);
</script>
<script src="{{ asset('js/hr/lowongan-detail.js') }}"></script>
@endsection