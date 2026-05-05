@extends('layouts.hr')

@section('title', 'Pelamar')
@section('page-title', 'Pelamar')
@section('nav-pelamar', 'text-green-800 border-green-700 font-semibold')

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
            Export CSV
        </button>
    </div>

    <!-- 5 Summary Stat Cards -->
    <div class="grid grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Applicants</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">128</p>
        </div>
        <div class="bg-white rounded-xl border-l-4 border-gray-300 border-y border-r border-r-gray-100 border-y-gray-100 p-4">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Submitted</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">42</p>
        </div>
        <div class="bg-white rounded-xl border-l-4 border-amber-400 border-y border-r border-r-gray-100 border-y-gray-100 p-4">
            <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Shortlisted</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">38</p>
        </div>
        <div class="bg-white rounded-xl border-l-4 border-blue-500 border-y border-r border-r-gray-100 border-y-gray-100 p-4">
            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Interview</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">18</p>
        </div>
        <div class="bg-white rounded-xl border-l-4 border-green-600 border-y border-r border-r-gray-100 border-y-gray-100 p-4">
            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest">Accepted</p>
            <p class="text-2xl font-extrabold text-gray-900 mt-1">6</p>
        </div>
    </div>

    <!-- Quick Filter Pills (Global Status Filter) -->
    <div class="bg-white rounded-xl border border-gray-100 p-4 mb-4">
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-2">Job Focus:</span>
            <button class="quick-filter active-quick bg-green-800 text-white font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="all">All</button>
            <button class="quick-filter bg-gray-50 border border-gray-200 text-gray-600 hover:border-amber-300 hover:text-amber-700 font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="review">
                <span class="inline-block w-1.5 h-1.5 bg-amber-400 rounded-full mr-1"></span>
                Needs Review <span class="text-gray-400 ml-0.5">(80)</span>
            </button>
            <button class="quick-filter bg-gray-50 border border-gray-200 text-gray-600 hover:border-blue-300 hover:text-blue-700 font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="interview">
                <span class="inline-block w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></span>
                In Interview <span class="text-gray-400 ml-0.5">(18)</span>
            </button>
            <button class="quick-filter bg-gray-50 border border-gray-200 text-gray-600 hover:border-purple-300 hover:text-purple-700 font-semibold px-3.5 py-1.5 rounded-full text-xs transition-all" data-focus="decision">
                <span class="inline-block w-1.5 h-1.5 bg-purple-500 rounded-full mr-1"></span>
                Needs Decision <span class="text-gray-400 ml-0.5">(29)</span>
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

            <!-- Departemen Filter -->
            <select id="filter-dept" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 min-w-[160px]">
                <option value="">All Departments</option>
                <option value="Production">Production</option>
                <option value="Operations">Operations</option>
                <option value="R&D Lab">R&D Lab</option>
                <option value="Logistics">Logistics</option>
                <option value="Technology">Technology</option>
            </select>

            <!-- Sort lowongan -->
            <select id="sort-lowongan" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-700 min-w-[180px]">
                <option value="pelamar-desc">Sort: Most Applicants</option>
                <option value="urgency">Sort: Most Urgent</option>
                <option value="newest">Sort: Newest</option>
                <option value="alpha">Sort: A-Z</option>
            </select>

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
        <p>Total: <span class="font-bold text-gray-700">128 applicants</span> in 3 active vacancies</p>
    </div>

    <!-- Lowongan Cards -->
    <div class="space-y-4" id="lowongan-container">

        @php
        $lowonganList = [
            [
                'id' => 1,
                'title' => 'Chemical Process Engineer',
                'department' => 'Production',
                'total' => 124,
                'posted' => '12 Oct 2024',
                'days_since' => 12,
                'deadline_days' => 3,   // urgent
                'counts' => ['terkirim' => 40, 'shortlisted' => 35, 'interview' => 18, 'reviewed' => 20, 'rejected' => 11],
                'expanded' => true,
                'pelamar' => [
                    ['name' => 'Aditya Pratama',   'email' => 'aditya.p@email.com',   'date' => '12 Mei 2024', 'status' => 'shortlisted', 'score' => 85, 'avatar' => 'AP', 'color' => 'bg-blue-500'],
                    ['name' => 'Siti Aminah',      'email' => 'siti.amin@email.com',  'date' => '10 Mei 2024', 'status' => 'interview',   'score' => 92, 'avatar' => 'SA', 'color' => 'bg-pink-500'],
                    ['name' => 'Budi Santoso',     'email' => 'budi.san@email.com',   'date' => '08 Mei 2024', 'status' => 'reviewed',    'score' => 65, 'avatar' => 'BS', 'color' => 'bg-amber-500'],
                    ['name' => 'Lestari Putri',    'email' => 'l.putri@email.com',    'date' => '05 Mei 2024', 'status' => 'rejected',    'score' => 45, 'avatar' => 'LP', 'color' => 'bg-red-400'],
                    ['name' => 'Rahmat Hidayat',   'email' => 'r.hidayat@email.com',  'date' => '03 Mei 2024', 'status' => 'terkirim',    'score' => 78, 'avatar' => 'RH', 'color' => 'bg-purple-500'],
                ],
            ],
            [
                'id' => 2,
                'title' => 'EHS Specialist',
                'department' => 'Operations',
                'total' => 42,
                'posted' => '08 Nov 2024',
                'days_since' => 4,
                'deadline_days' => 18,
                'counts' => ['terkirim' => 15, 'shortlisted' => 12, 'interview' => 5, 'reviewed' => 7, 'rejected' => 3],
                'expanded' => false,
                'pelamar' => [
                    ['name' => 'Dewi Kartika',     'email' => 'dewi.k@email.com',     'date' => '15 Mei 2024', 'status' => 'shortlisted', 'score' => 88, 'avatar' => 'DK', 'color' => 'bg-teal-500'],
                    ['name' => 'Ahmad Fauzi',      'email' => 'a.fauzi@email.com',    'date' => '14 Mei 2024', 'status' => 'interview',   'score' => 95, 'avatar' => 'AF', 'color' => 'bg-green-600'],
                    ['name' => 'Maya Sari',        'email' => 'maya.s@email.com',     'date' => '11 Mei 2024', 'status' => 'terkirim',    'score' => 72, 'avatar' => 'MS', 'color' => 'bg-indigo-500'],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Analytical Chemist',
                'department' => 'R&D Lab',
                'total' => 18,
                'posted' => '10 Nov 2024',
                'days_since' => 2,
                'deadline_days' => 25,
                'counts' => ['terkirim' => 8, 'shortlisted' => 5, 'interview' => 3, 'reviewed' => 2, 'rejected' => 0],
                'expanded' => false,
                'pelamar' => [
                    ['name' => 'Andi Wijaya',      'email' => 'a.wijaya@email.com',   'date' => '16 Mei 2024', 'status' => 'interview',   'score' => 91, 'avatar' => 'AW', 'color' => 'bg-blue-600'],
                    ['name' => 'Rina Kusuma',      'email' => 'rina.k@email.com',     'date' => '13 Mei 2024', 'status' => 'shortlisted', 'score' => 82, 'avatar' => 'RK', 'color' => 'bg-rose-500'],
                ],
            ],
        ];
        @endphp

        @foreach($lowonganList as $low)
        @php
            $unreviewed = $low['counts']['terkirim'] + $low['counts']['shortlisted'];
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden lowongan-card {{ $low['expanded'] ? 'is-expanded' : '' }}"
             data-lowongan-id="{{ $low['id'] }}"
             data-title="{{ strtolower($low['title']) }}"
             data-department="{{ $low['department'] }}"
             data-total="{{ $low['total'] }}"
             data-days-since="{{ $low['days_since'] }}"
             data-deadline-days="{{ $low['deadline_days'] }}"
             data-unreviewed="{{ $unreviewed }}"
             data-interview="{{ $low['counts']['interview'] }}"
             data-decision="{{ $low['counts']['reviewed'] + $low['counts']['shortlisted'] }}">

            <!-- Card Header -->
            <button class="lowongan-toggle w-full flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors text-left">
                <svg class="lowongan-chevron w-5 h-5 text-gray-400 transition-transform shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>

                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="font-bold text-gray-900 truncate lowongan-title">{{ $low['title'] }}</h3>
                        <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded uppercase">{{ $low['department'] }}</span>

                        <!-- Urgency badges -->
                        @if($low['deadline_days'] <= 7)
                        <span class="text-[10px] font-bold text-red-700 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6"/><path d="M12 16h.01"/></svg>
                            Deadline {{ $low['deadline_days'] }} days
                        </span>
                        @endif

                        @if($unreviewed >= 50)
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                            {{ $unreviewed }} unreviewed
                        </span>
                        @endif

                        @if($low['days_since'] <= 3)
                        <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">NEW</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">
                        <span class="font-semibold text-gray-700">{{ $low['total'] }}</span> applicants total
                        <span class="mx-1">·</span>
                        Posted {{ $low['posted'] }}
                    </p>
                </div>

                <!-- Status breakdown pills -->
                <div class="flex items-center gap-1.5 shrink-0 flex-wrap justify-end">
                    @if($low['counts']['terkirim'] > 0)
                    <span class="text-[10px] font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2 py-1 rounded">{{ $low['counts']['terkirim'] }} Submitted</span>
                    @endif
                    @if($low['counts']['shortlisted'] > 0)
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-1 rounded">{{ $low['counts']['shortlisted'] }} Shortlisted</span>
                    @endif
                    @if($low['counts']['interview'] > 0)
                    <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2 py-1 rounded">{{ $low['counts']['interview'] }} Interview</span>
                    @endif
                    @if($low['counts']['reviewed'] > 0)
                    <span class="text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-2 py-1 rounded">{{ $low['counts']['reviewed'] }} Reviewed</span>
                    @endif
                    @if($low['counts']['rejected'] > 0)
                    <span class="text-[10px] font-bold text-red-700 bg-red-50 border border-red-200 px-2 py-1 rounded">{{ $low['counts']['rejected'] }} Rejected</span>
                    @endif
                </div>
            </button>

            <!-- Card Body -->
            <div class="lowongan-body border-t border-gray-100 {{ $low['expanded'] ? '' : 'hidden' }}">

                <!-- Status Tabs -->
                <div class="flex items-center gap-1 px-6 pt-4 border-b border-gray-100 flex-wrap">
                    <button class="status-tab active-tab px-3 py-2 text-xs font-semibold text-green-800 border-b-2 border-green-700 transition-colors" data-status="all">All <span class="text-gray-400 ml-1">({{ $low['total'] }})</span></button>
                    @if($low['counts']['terkirim'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="terkirim">Submitted <span class="text-gray-400 ml-1">({{ $low['counts']['terkirim'] }})</span></button>
                    @endif
                    @if($low['counts']['shortlisted'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="shortlisted">Shortlisted <span class="text-gray-400 ml-1">({{ $low['counts']['shortlisted'] }})</span></button>
                    @endif
                    @if($low['counts']['interview'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="interview">Interview <span class="text-gray-400 ml-1">({{ $low['counts']['interview'] }})</span></button>
                    @endif
                    @if($low['counts']['reviewed'] > 0)
                    <button class="status-tab px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-800 border-b-2 border-transparent transition-colors" data-status="reviewed">Reviewed <span class="text-gray-400 ml-1">({{ $low['counts']['reviewed'] }})</span></button>
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
                            <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">Score</th>
                            <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-widest px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="applicant-tbody">
                        @foreach($low['pelamar'] as $pIdx => $p)
                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors applicant-row"
                            data-status="{{ $p['status'] }}"
                            data-name="{{ strtolower($p['name']) }}"
                            data-email="{{ strtolower($p['email']) }}"
                            data-score="{{ $p['score'] }}"
                            data-date-idx="{{ $pIdx }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full {{ $p['color'] }} flex items-center justify-center text-white font-bold text-xs shrink-0">{{ $p['avatar'] }}</div>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900 applicant-name">{{ $p['name'] }}</p>
                                        <p class="text-xs text-gray-400 applicant-email">{{ $p['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $p['date'] }}</td>
                            <td class="px-6 py-4">
                                @switch($p['status'])
                                    @case('terkirim')
                                        <span class="text-[10px] font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full uppercase">Submitted</span>
                                        @break
                                    @case('shortlisted')
                                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full uppercase">Shortlisted</span>
                                        @break
                                    @case('interview')
                                        <span class="text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full uppercase">Interview</span>
                                        @break
                                    @case('reviewed')
                                        <span class="text-[10px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-2.5 py-1 rounded-full uppercase">Reviewed</span>
                                        @break
                                    @case('rejected')
                                        <span class="text-[10px] font-bold text-red-700 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full uppercase">Rejected</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $p['score'] >= 80 ? 'bg-green-600' : ($p['score'] >= 60 ? 'bg-amber-500' : 'bg-red-400') }}" style="width: {{ $p['score'] }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold {{ $p['score'] >= 80 ? 'text-green-700' : ($p['score'] >= 60 ? 'text-amber-600' : 'text-red-500') }}">{{ $p['score'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="/hr/pelamar/{{ $pIdx + 1 }}" class="inline-flex items-center gap-1 text-[11px] font-semibold text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors">
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
@endsection

@section('js')
<script src="{{ asset('js/hr/pelamar.js') }}"></script>
@endsection