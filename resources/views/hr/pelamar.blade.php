@extends('layouts.hr')

@section('title', 'Applicants')
@section('page-title', 'Applicants')
@section('nav-pelamar', 'text-green-800 border-green-700 font-semibold')

@section('css')
<style>
    @keyframes highlight-pulse-animation {
        0% {
            box-shadow: 0 0 0 0 rgba(21, 128, 61, 0.6);
            background-color: rgba(240, 253, 244, 1);
            border-color: #16a34a !important;
        }
        50% {
            box-shadow: 0 0 0 15px rgba(21, 128, 61, 0);
            background-color: rgba(240, 253, 244, 0.3);
            border-color: #16a34a !important;
        }
        100% {
            box-shadow: 0 0 0 0 rgba(21, 128, 61, 0);
            background-color: transparent;
        }
    }
    .highlight-pulse {
        animation: highlight-pulse-animation 0.8s ease-in-out 1;
        border: 2px solid #16a34a !important;
    }
    .lowongan-card.new-badges-dismissed .new-vacancy-badge,
    .lowongan-card.new-badges-dismissed .new-applicants-badge {
        display: none !important;
    }
</style>
@endsection

@section('content')
<div class="px-8 py-6">

    <!-- Header -->
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-green-900">Applicant List</h1>
            <p class="text-sm text-gray-500 mt-1">Manage and review all incoming applications for active positions at PT Ecogreen Oleochemicals.</p>
        </div>
        <button id="btn-export" class="flex items-center gap-2 border border-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Export Excel
        </button>
    </div>

    <!-- 6 Summary Stat Cards (2x3 Grid) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Card: left-accent border black/dark-gray -->
        <div class="bg-white rounded-xl border-l-4 border-gray-800 border-y border-r border-r-gray-100 border-y-gray-100 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Total Applicants</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $totalApplicants }}</p>
        </div>
        <!-- Submitted Card: left-accent border gray-300 -->
        <div class="bg-white rounded-xl border-l-4 border-gray-300 border-y border-r border-r-gray-100 border-y-gray-100 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Submitted</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $submittedCount }}</p>
        </div>
        <!-- Shortlisted Card: left-accent border amber-400 -->
        <div class="bg-white rounded-xl border-l-4 border-amber-400 border-y border-r border-r-gray-100 border-y-gray-100 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Shortlisted</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $shortlistedCount }}</p>
        </div>
        <!-- Interview Card: left-accent border blue-500 -->
        <div class="bg-white rounded-xl border-l-4 border-blue-500 border-y border-r border-r-gray-100 border-y-gray-100 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Interview</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $interviewCount }}</p>
        </div>
        <!-- Accepted Card: left-accent border green-600 -->
        <div class="bg-white rounded-xl border-l-4 border-green-600 border-y border-r border-r-gray-100 border-y-gray-100 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest">Accepted</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $acceptedCount }}</p>
        </div>
        <!-- Rejected Card: left-accent border red-600 -->
        <div class="bg-white rounded-xl border-l-4 border-red-600 border-y border-r border-r-gray-100 border-y-gray-100 p-4 shadow-sm">
            <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest">Rejected</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $rejectedCount }}</p>
        </div>
    </div>

    <!-- Quick Filter Pills (Global Status Filter) -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-4">
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-2">Job Focus:</span>
            <button class="quick-filter active-quick bg-green-800 text-white font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="all">All</button>
            <button class="quick-filter bg-gray-50 border border-gray-200 text-gray-600 hover:border-amber-300 hover:text-amber-700 font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="review">
                <span class="inline-block w-1.5 h-1.5 bg-amber-400 rounded-full mr-1"></span>
                Needs Review <span class="text-gray-400 ml-0.5">({{ $submittedCount + $shortlistedCount }})</span>
            </button>
            <button class="quick-filter bg-gray-50 border border-gray-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="interview">
                <span class="inline-block w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></span>
                In Interview <span class="text-gray-400 ml-0.5">({{ $interviewCount }})</span>
            </button>
            <button class="quick-filter bg-gray-50 border border-gray-200 text-gray-600 hover:border-purple-300 hover:text-purple-700 font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="decision">
                <span class="inline-block w-1.5 h-1.5 bg-purple-500 rounded-full mr-1"></span>
                Needs Decision <span class="text-gray-400 ml-0.5">({{ $decisionCount }})</span>
            </button>
        </div>
    </div>

    <!-- Search + Filters Bar -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-5">
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Smart search -->
            <div class="relative flex-1 min-w-[280px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="global-search" placeholder="Search applicant name, email, or position..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <span id="search-hint" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400"></span>
            </div>

            <!-- Category Filter -->
            <select id="filter-category" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 min-w-[160px]">
                <option value="">Category: All</option>
                @foreach($deptList as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>

            <!-- Sort lowongan -->
            <select id="sort-lowongan" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 min-w-[180px]">
                <option value="pelamar-desc">Sort: Most Applicants</option>
                <option value="urgency">Sort: Most Urgent</option>
                <option value="newest">Sort: Newest</option>
                <option value="alpha">Sort: A-Z</option>
            </select>

            <!-- Show Archived Toggle Button -->
            <button id="btn-toggle-archived" class="flex items-center gap-1.5 border border-gray-200 text-gray-600 hover:border-green-300 hover:text-green-700 font-semibold px-3.5 py-2 rounded-lg text-xs transition-all bg-white" data-active="false" type="button">
                <span id="archived-dot" class="w-1.5 h-1.5 rounded-full bg-gray-300 transition-colors"></span>
                Show Archived
            </button>

            <!-- Expand/Collapse all -->
            <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5">
                <button id="btn-expand-all" class="px-3 py-1.5 text-xs font-semibold rounded-md text-gray-600 hover:text-gray-800 transition-colors">Expand All</button>
                <button id="btn-collapse-all" class="px-3 py-1.5 text-xs font-semibold rounded-md text-gray-600 hover:text-gray-800 transition-colors">Collapse All</button>
            </div>
        </div>

        <!-- Active filter indicator -->
        <div id="active-filter-bar" class="hidden mt-3 pt-3 border-t border-gray-100 flex items-center gap-2 flex-wrap">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Filters:</span>
            <div id="active-filter-pills" class="flex items-center gap-2 flex-wrap"></div>
            <button id="btn-clear-filters" class="ml-auto text-xs font-semibold text-red-600 hover:text-red-700 transition-colors">Clear All Filters</button>
        </div>
    </div>

    <!-- Result summary -->
    <div class="mb-3 flex items-center justify-between text-xs text-gray-500">
        <p>Showing <span id="visible-lowongan-count" class="font-bold text-gray-700">3</span> vacancies with <span id="visible-applicant-count" class="font-bold text-gray-700">10</span> applicants</p>
        <p>Total: <span class="font-bold text-gray-700">{{ $totalApplicants }} applicants</span> in {{ count($lowonganList) }} active vacancies</p>
    </div>

    <!-- Lowongan Cards -->
    <div class="space-y-4" id="lowongan-container">

        @foreach($lowonganList as $low)
        @php
            $unreviewed = $low['counts']['submitted'] + $low['counts']['shortlisted'];
            $statusLabel = $low['status'] === 'filled' ? 'FILLED' : ($low['status'] === 'closed' ? 'CLOSE' : strtoupper($low['status']));
        @endphp
        <div class="rounded-2xl border overflow-hidden lowongan-card {{ $low['expanded'] ? 'is-expanded' : '' }} {{ $low['is_archived'] ? 'bg-purple-50/20 border-purple-200 opacity-85 hover:opacity-100 transition-all' : 'bg-white border-gray-100' }}"
             data-lowongan-id="{{ $low['id'] }}"
             data-title="{{ strtolower($low['title']) }}"
             data-department="{{ $low['department'] }}"
             data-total="{{ $low['total'] }}"
             data-days-since="{{ $low['days_since'] }}"
             data-deadline-days="{{ $low['deadline_days'] }}"
             data-unreviewed="{{ $unreviewed }}"
             data-interview="{{ $low['counts']['interview'] }}"
             data-decision="{{ $low['counts']['shortlisted'] }}"
             data-archived="{{ $low['is_archived'] ? 'true' : 'false' }}"
             data-status="{{ strtolower($low['status']) }}"
             data-quota="{{ $low['quota'] ?? 0 }}"
             data-accepted="{{ $low['counts']['accepted'] ?? 0 }}">

            <!-- Card Header Wrapper with Archive action -->
            <div class="flex items-center justify-between hover:bg-gray-50/50 transition-colors border-b border-transparent">
                <button class="lowongan-toggle flex-1 flex items-center gap-4 px-6 py-4 text-left focus:outline-none">
                    <svg class="lowongan-chevron w-5 h-5 text-gray-400 transition-transform shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>

                    <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-bold text-gray-900 truncate lowongan-title">{{ $low['title'] }}</h3>
                            <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded uppercase">{{ $low['department'] }}</span>
                            @if($low['is_archived'])
                                <span class="text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-2 py-0.5 rounded-full shrink-0">ARCHIVED</span>
                            @elseif($low['status'] === 'filled')
                                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full shrink-0">{{ $statusLabel }}</span>
                            @elseif($low['status'] === 'closed')
                                <span class="text-[10px] font-bold text-red-700 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full shrink-0">{{ $statusLabel }}</span>
                            @endif

                             <!-- Auto Close displays -->
                            @if(!in_array($low['status'], ['closed', 'filled']))
                                @if(in_array($low['auto_close_method'], ['deadline', 'both']))
                                <span class="countdown-timer-badge text-[10px] font-bold text-red-700 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full flex items-center gap-1 shrink-0"
                                      data-deadline="{{ $low['deadline_timestamp'] ?? '' }}"
                                      data-fallback="{{ $low['countdown_text'] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-red-605" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="countdown-text">{{ $low['countdown_text'] }}</span>
                                </span>
                                @endif

                                @if(in_array($low['auto_close_method'], ['quota', 'both']))
                                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full flex items-center gap-1 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-blue-605" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    Quota: {{ $low['total'] }}/{{ $low['quota'] }}
                                </span>
                                @endif
                            @endif

                            @if($unreviewed >= 50)
                            <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                                {{ $unreviewed }} unreviewed
                            </span>
                            @endif

                            @if($low['days_since'] <= 3)
                            <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full new-vacancy-badge">NEW</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">
                            <span class="font-semibold text-gray-700">{{ $low['total'] }}</span> applicants total
                            <span class="mx-1">·</span>
                            Posted {{ $low['posted'] }}
                        </p>
                    </div>

                    <!-- Status breakdown pills replaced with New Applicants count -->
                    <div class="flex items-center gap-1.5 shrink-0 flex-wrap justify-end new-applicants-badge-container">
                        @if($low['new_applicants_count'] > 0)
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full flex items-center gap-1.5 new-applicants-badge animate-pulse">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                            {{ $low['new_applicants_count'] }} {{ $low['new_applicants_count'] > 1 ? 'Applicants' : 'Applicant' }} New
                        </span>
                        @endif
                    </div>
                </button>

                <!-- Complete & Archive button -->
                <div class="px-5 border-l border-gray-100 py-4 shrink-0 flex items-center">
                    @if($low['is_archived'])
                    <span class="p-2 text-purple-500 bg-purple-50 rounded-lg flex items-center justify-center cursor-default" title="Vacancy is Archived">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            <path d="m9 14 2 2 4-4"/>
                        </svg>
                    </span>
                    @else
                    <button class="btn-archive-vacancy p-2 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-all cursor-pointer focus:outline-none" 
                            title="Selesaikan & Arsipkan Lowongan" 
                            data-vacancy-id="{{ $low['id'] }}" 
                            data-title="{{ $low['title'] }}"
                            data-status="{{ $low['status'] }}"
                            data-undecided="{{ $low['counts']['submitted'] + $low['counts']['shortlisted'] + $low['counts']['interview'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            <path d="m9 14 2 2 4-4"/>
                        </svg>
                    </button>
                    @endif
                </div>
            </div>

            <!-- Card Body -->
            <div class="lowongan-body border-t border-gray-100 {{ $low['expanded'] ? '' : 'hidden' }}">

                <!-- Status Tabs -->
                <div class="flex items-center gap-1 px-6 pt-4 border-b border-gray-100 flex-wrap">
                    <button class="status-tab active-tab px-3 py-2 text-xs font-semibold text-green-800 border-b-2 border-green-700 transition-colors" data-status="all">All <span class="text-gray-400 ml-1">({{ $low['total'] }})</span></button>
                    @if($low['counts']['submitted'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="submitted">Submitted <span class="text-gray-400 ml-1">({{ $low['counts']['submitted'] }})</span></button>
                    @endif
                    @if($low['counts']['shortlisted'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="shortlisted">Shortlisted <span class="text-gray-400 ml-1">({{ $low['counts']['shortlisted'] }})</span></button>
                    @endif
                    @if($low['counts']['interview'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="interview">Interview <span class="text-gray-400 ml-1">({{ $low['counts']['interview'] }})</span></button>
                    @endif
                    @if($low['counts']['accepted'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="accepted">Accepted <span class="text-gray-400 ml-1">({{ $low['counts']['accepted'] }})</span></button>
                    @endif
                    @if($low['counts']['rejected'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="rejected">Rejected <span class="text-gray-400 ml-1">({{ $low['counts']['rejected'] }})</span></button>
                    @endif

                    <div class="ml-auto flex items-center gap-2">
                        <span class="text-[10px] text-gray-400">Sort By:</span>
                        <select class="sort-select text-xs border border-gray-200 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="recent">Recent</option>
                            <option value="score-desc">Highest Score</option>
                            <option value="score-asc">Lowest Score</option>
                            <option value="name">Name A-Z</option>
                        </select>
                    </div>
                </div>

                <!-- Applicants Table -->
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">Applicants</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">Date</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">Status</th>
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">
                                <div class="flex items-center gap-1">
                                    <span>Score</span>
                                    <div class="relative group cursor-pointer inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-400 hover:text-gray-600 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/>
                                        </svg>
                                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 hidden group-hover:block bg-gray-900 text-white text-[9px] font-medium rounded-lg p-2 shadow-lg z-50 pointer-events-none normal-case tracking-normal">
                                            Automated screening score based on GPA, skills, and work experience.
                                            <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900"></div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="applicant-tbody">                        @foreach($low['pelamar'] as $p)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors applicant-row {{ 
                            $p['status'] === 'withdrawn' ? 'opacity-30 bg-gray-50/70 select-none' : (
                                $p['status'] === 'accepted' ? 'opacity-45 bg-green-50/50 border-green-200' : (
                                    $p['status'] === 'rejected' ? 'opacity-45 bg-red-50/50 border-red-200' : ''
                                )
                            ) 
                        }}"
                            data-name="{{ strtolower($p['name']) }}"
                            data-email="{{ strtolower($p['email']) }}"
                            data-phone="{{ $p['phone'] }}"
                            data-gpa="{{ $p['gpa'] }}"
                            data-status="{{ $p['status'] }}"
                            data-score="{{ $p['score'] }}"
                            data-date-idx="{{ $loop->index }}">
                            <td class="px-6 py-4 relative">
                                <div class="flex items-center gap-3 {{ $p['status'] === 'withdrawn' ? 'filter blur-[1.5px]' : '' }}">
                                    <div class="w-10 h-10 rounded-full {{ $p['color'] }} flex items-center justify-center text-white font-bold text-xs shrink-0">{{ $p['avatar'] }}</div>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900 applicant-name flex items-center gap-1.5">
                                            {{ $p['name'] }}
                                            @if(!$p['is_seen'])
                                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full inline-block shrink-0" title="New Application"></span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-400 applicant-email">{{ $p['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-gray-500">{{ $p['date'] }}</td>
                            <td class="px-6 py-4 relative">
                                <div class="relative inline-block">
                                    <div class="{{ $p['status'] === 'withdrawn' ? 'filter blur-[1.5px]' : '' }}">
                                        @switch($p['status'])
                                            @case('submitted')
                                                <span class="text-[10px] font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full uppercase">Submitted</span>
                                                @break
                                            @case('shortlisted')
                                                <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full uppercase">Shortlisted</span>
                                                @break
                                            @case('interview')
                                                <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full uppercase">Interview</span>
                                                @break
                                            @case('accepted')
                                                <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full uppercase">Accepted</span>
                                                @break
                                            @case('rejected')
                                                <span class="text-[10px] font-bold text-red-700 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full uppercase">Rejected</span>
                                                @break
                                            @case('withdrawn')
                                                <span class="text-[10px] font-bold text-gray-500 bg-gray-100 border border-gray-300 px-2.5 py-1 rounded-full uppercase">Withdrawn</span>
                                                @break
                                        @endswitch
                                    </div>
                                    @if($p['status'] === 'withdrawn')
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                                            <span class="text-4xl text-gray-400/40 font-black italic select-none tracking-widest uppercase">WITHDRAW</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $p['score'] >= 80 ? 'bg-green-600' : ($p['score'] >= 60 ? 'bg-amber-500' : 'bg-red-400') }}" @style="'width: ' . $p['score'] . '%'"></div>
                                    </div>
                                    <span class="text-sm font-bold {{ $p['score'] >= 80 ? 'text-green-700' : ($p['score'] >= 60 ? 'text-amber-600' : 'text-red-500') }}">{{ $p['score'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="/hr/pelamar/{{ $p['id'] }}" class="inline-flex items-center gap-1 text-[11px] font-semibold text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Detail
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        <tr class="applicant-empty hidden">
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-sm text-gray-400">No applicants with this filter.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Footer -->
                <div class="px-6 py-3 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Showing <span class="filter-count">{{ count($low['pelamar']) }}</span> of {{ $low['total'] }} applicants</p>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Empty result -->
        <div id="empty-result" class="hidden bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <p class="text-sm font-semibold text-gray-700">No results found</p>
            <p class="text-xs text-gray-400 mt-1">Try other keywords or change filters.</p>
        </div>
    </div>
</div>

<!-- Export Selection Modal -->
<div id="export-modal" class="hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Export Recruitment Data
            </h3>
            <button id="btn-close-export-modal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <div class="space-y-3">
            <!-- Option: All Positions -->
            <label class="flex items-start gap-3 p-3.5 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                <input type="radio" name="export-scope" value="all" checked class="mt-0.5 text-green-700 focus:ring-green-500">
                <div>
                    <span class="text-xs font-bold text-gray-900 block">All Positions (Multi-Sheet)</span>
                    <span class="text-[10px] text-gray-400 block mt-0.5">Exports all active vacancies into separate sheets within a single Excel file.</span>
                </div>
            </label>

            <!-- Option: Single Position -->
            <label class="flex items-start gap-3 p-3.5 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                <input type="radio" name="export-scope" value="single" class="mt-0.5 text-green-700 focus:ring-green-500">
                <div class="flex-1">
                    <span class="text-xs font-bold text-gray-900 block">Single Position Only</span>
                    <span class="text-[10px] text-gray-400 block mt-0.5 mb-2">Exports only the selected vacancy data.</span>
                    <select id="export-single-select" disabled class="w-full px-3 py-2 border border-gray-200 rounded-lg text-[11px] focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700">
                        <!-- Filled dynamically -->
                    </select>
                </div>
            </label>
        </div>

        <div class="flex items-center justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
            <button id="btn-cancel-export" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-xs font-semibold hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="btn-confirm-export" class="px-4 py-2 bg-green-800 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition-all flex items-center gap-1.5 shadow-sm">
                Export Excel
            </button>
        </div>
    </div>
</div>

<!-- Export Warning Modal -->
<div id="export-warning-modal" class="hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center z-[60] transition-opacity duration-300">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                </svg>
                Export Not Available
            </h3>
            <button id="btn-close-export-warning-modal" class="text-gray-400 hover:text-gray-600 transition-colors cursor-pointer focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <div class="space-y-3 my-4">
            <p class="text-sm text-gray-600 leading-relaxed">
                This vacancy does not have any applicants yet. Please wait until at least one application is submitted before exporting the single-position Excel file.
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100">
            <button id="btn-ok-export-warning-modal" class="px-4 py-2 bg-green-800 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition-all shadow-sm">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Archive Confirmation Modal -->
<div id="archive-confirm-modal" class="hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    <path d="m9 14 2 2 4-4"/>
                </svg>
                Archive Vacancy
            </h3>
            <button id="btn-close-archive-modal" class="text-gray-400 hover:text-gray-600 transition-colors cursor-pointer focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <div class="space-y-3 my-4">
            <p class="text-xs text-gray-600 leading-relaxed">
                Are you sure you want to complete and archive <strong id="archive-job-title" class="text-gray-900"></strong>?
            </p>
            
            <!-- Active Warning Block -->
            <div id="archive-warning-active" class="hidden flex items-start gap-2.5 p-3.5 bg-red-50 border border-red-100 rounded-xl text-red-700 text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <span class="font-bold block">Vacancy Still Active!</span>
                    This vacancy is currently still open/active. Please close this vacancy first in the vacancy management panel before finalizing and archiving it.
                </div>
            </div>

            <!-- Undecided Warning Block -->
            <div id="archive-warning-undecided" class="hidden flex items-start gap-2.5 p-3.5 bg-amber-50 border border-amber-100 rounded-xl text-amber-800 text-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <span class="font-bold block">Selection Process Incomplete!</span>
                    There are still <strong id="archive-undecided-count"></strong> applicants whose selection process is not yet complete. Please complete the selection process for all applicants first before finalizing this vacancy.
                </div>
            </div>

            <p id="archive-info-text" class="text-[11px] text-gray-400">
                Archiving this vacancy will hide it from the recruitment applicant list. This action is permanent.
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
            <button id="btn-cancel-archive" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-xs font-semibold hover:bg-gray-50 transition-colors cursor-pointer focus:outline-none">Cancel</button>
            <button id="btn-confirm-archive" class="px-4 py-2 bg-green-800 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition-all flex items-center gap-1.5 shadow-sm cursor-pointer focus:outline-none">
                Archive Vacancy
            </button>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/vendor/exceljs.min.js') }}"></script>
<script src="{{ asset('js/hr/pelamar.js') }}"></script>
@endsection
