@extends('layouts.hr')

@section('title', 'Vacancies')
@section('page-title', 'Vacancies')
@section('css')
<style>
    /* Make all font size options inside the dropdown menu a uniform, clean size */
    .ck.ck-fontsize-option .ck-button__label {
        font-size: 14px !important;
    }
    /* Restrict dropdown height and enable scrollbar so it doesn't stretch off-screen */
    .ck.ck-dropdown__panel {
        max-height: 220px !important;
        overflow-y: auto !important;
    }
</style>
@endsection

@section('content')
<div class="px-8 py-6">

    <!-- Header Row with Period Selector -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Recruitment Performance Metrics</h2>
        </div>
        <div class="flex bg-gray-100 rounded-lg p-0.5 gap-0.5 border border-gray-200">
            <button class="btn-period px-3 py-1.5 text-xs font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700" data-period="daily">Daily</button>
            <button class="btn-period px-3 py-1.5 text-xs font-semibold rounded-md transition-all bg-white text-gray-800 shadow-sm" data-period="weekly">Weekly</button>
            <button class="btn-period px-3 py-1.5 text-xs font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700" data-period="monthly">Monthly</button>
            <button class="btn-period px-3 py-1.5 text-xs font-semibold rounded-md transition-all text-gray-500 hover:text-gray-700" data-period="yearly">Yearly</button>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-3 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full" id="trend-vacancies-badge">+{{ $trends['weekly']['vacancies'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ str_pad($totalVacancies, 2, '0', STR_PAD_LEFT) }}</p>
            <div class="flex items-center gap-1.5 mt-1">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Vacancies</span>
                <div class="relative inline-block leading-none z-20">
                    <button type="button" class="info-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    </button>
                    <div class="info-tooltip hidden absolute z-30 w-56 bg-gray-900 text-white text-[10px] font-semibold rounded-lg p-2.5 shadow-lg -left-20 top-6 pointer-events-none normal-case tracking-normal leading-normal">
                        <p class="mb-1 text-gray-300">Total of all job vacancies ever created (including drafts, active, and closed postings).</p>
                        <p class="text-green-400 font-bold">+ : New vacancies created within the selected period.</p>
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1 font-medium" id="trend-vacancies-label">Trend: +{{ $trends['weekly']['vacancies'] }} new this week</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full" id="trend-applicants-badge">+{{ $trends['weekly']['applicants'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ number_format($activeApplicants) }}</p>
            <div class="flex items-center gap-1.5 mt-1">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Active Applicants</span>
                <div class="relative inline-block leading-none z-20">
                    <button type="button" class="info-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    </button>
                    <div class="info-tooltip hidden absolute z-30 w-56 bg-gray-900 text-white text-[10px] font-semibold rounded-lg p-2.5 shadow-lg -left-20 top-6 pointer-events-none normal-case tracking-normal leading-normal">
                        <p class="mb-1 text-gray-300">Number of applicants whose applications are under review, shortlisted, or in the interview stage.</p>
                        <p class="text-green-400 font-bold">+ : New applicants who submitted their applications within the selected period.</p>
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1 font-medium" id="trend-applicants-label">Trend: +{{ $trends['weekly']['applicants'] }} applied this week</p>
        </div>
        <div id="card-closing-soon" class="bg-white rounded-2xl border border-gray-100 p-5 cursor-pointer hover:shadow-md transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full" id="trend-closed-badge">-{{ $trends['weekly']['closed'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ str_pad($closingSoon, 2, '0', STR_PAD_LEFT) }}</p>
            <div class="flex items-center gap-1.5 mt-1">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Closing Soon</span>
                <div class="relative inline-block leading-none z-20">
                    <button type="button" class="info-btn text-gray-400 hover:text-gray-600 transition-colors focus:outline-none cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    </button>
                    <div class="info-tooltip hidden absolute z-30 w-56 bg-gray-900 text-white text-[10px] font-semibold rounded-lg p-2.5 shadow-lg -left-20 top-6 pointer-events-none normal-case tracking-normal leading-normal">
                        <p class="mb-1.5 text-gray-300">Number of active vacancies whose application deadlines will expire soon (next 7 days).</p>
                        <p class="text-red-400 font-bold">- : Number of vacancies successfully closed within the selected period.</p>
                    </div>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1 font-medium" id="trend-closed-label">Trend: -{{ $trends['weekly']['closed'] }} closed this week</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">

        <!-- Filters -->
        <div class="flex items-center gap-3 mb-5">
            <div class="relative flex-1 max-w-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="search-vacancy" placeholder="Search position or reference..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <select id="filter-status" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-600">
                <option value="">Status: All</option>
                <option value="ACTIVE">Active</option>
                <option value="DRAFT">Draft</option>
                <option value="CLOSED">Closed</option>
                <option value="FILLED">Filled</option>
                <option value="ARCHIVED">Archived</option>
            </select>
            <select id="filter-category" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-600">
                <option value="">Category: All</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <select id="filter-location" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-600">
                <option value="">Location: All</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->name }}">{{ $loc->name }}</option>
                @endforeach
            </select>
            <select id="filter-employment-type" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-600">
                <option value="">Type: All</option>
                <option value="full-time">Full-time</option>
                <option value="part-time">Part-time</option>
                <option value="contract">Contract</option>
                <option value="internship">Internship</option>
            </select>
            
            <select id="sort-vacancy" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-600">
                <option value="recent">Sort: Newest</option>
                <option value="alpha">Sort: A-Z</option>
            </select>

            <!-- Show Archived Toggle Button -->
            <button id="btn-toggle-archived" class="flex items-center gap-1.5 border border-gray-200 text-gray-600 hover:border-purple-300 hover:text-purple-750 font-semibold px-3.5 py-2 rounded-lg text-sm transition-all bg-white cursor-pointer" data-active="false" type="button">
                <span id="archived-dot" class="w-1.5 h-1.5 rounded-full bg-gray-300 transition-colors"></span>
                Show Archived
            </button>
            
            <button id="btn-clear-filters" class="hidden items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 transition-all px-3 py-2 rounded-lg border border-red-200 hover:border-red-300 bg-red-50 hover:bg-red-100/80 shadow-sm cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                Reset Filters
            </button>
            
            <button id="btn-open-category-modal" class="flex items-center gap-1.5 border border-green-700 text-green-800 hover:bg-green-50 font-semibold px-4 py-2 rounded-lg text-sm transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Category
            </button>
            
            <button id="btn-open-location-modal" class="flex items-center gap-1.5 border border-green-700 text-green-800 hover:bg-green-50 font-semibold px-4 py-2 rounded-lg text-sm transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Location
            </button>

            <a href="/hr/lowongan/buat" class="ml-auto flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                Create New Vacancy
            </a>
        </div>

        <!-- Table -->
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Position</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Category</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Location</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Applicants</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Max Applicants</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Deadline</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Status</th>
                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Actions</th>
                </tr>
            </thead>
            <tbody id="vacancy-table">

                @foreach($vacancies as $v)
                @php
                    $isLockedStatus = in_array($v->status, ['closed', 'filled']);
                    $isFilled = $v->status === 'filled';

                    // Map database status to uppercase badge text
                    $statusBadge = 'DRAFT';
                    if ($v->status === 'open') {
                        $statusBadge = 'ACTIVE';
                    } elseif ($v->status === 'filled') {
                        $statusBadge = 'FILLED';
                    } elseif ($v->status === 'closed') {
                        if ($v->quota > 0 && $v->applicant_count >= $v->quota) {
                            $statusBadge = 'FILLED';
                        } else {
                            $statusBadge = 'CLOSED';
                        }
                    }
                    
                    // Compute progress
                    $progress = $isFilled
                        ? 100
                        : ($v->quota > 0 ? min(100, ($v->applicant_count / $v->quota) * 100) : 0);
                    $displayApplicants = $isFilled ? $v->quota : $v->applicant_count;
                    
                    // Reference ID format (REF-ECO-YEAR-ID)
                    $refId = 'REF-ECO-' . $v->created_at->format('Y') . '-' . str_pad($v->id, 3, '0', STR_PAD_LEFT);
                @endphp
                <tr class="border-t border-gray-50 transition-colors cursor-pointer vacancy-row {{ $v->is_archived ? 'bg-purple-50/20 hover:bg-purple-50/40 opacity-80' : 'hover:bg-gray-50' }} {{ $isLockedStatus && !$v->is_archived ? 'opacity-50' : '' }}"
                    data-id="{{ $v->id }}"
                    data-title="{{ strtolower($v->title) }}"
                    data-ref="{{ strtolower($refId) }}"
                    data-status="{{ $statusBadge }}"
                    data-archived="{{ $v->is_archived ? 'true' : 'false' }}"
                    data-category="{{ $v->category->name ?? '' }}"
                    data-category-id="{{ $v->category_id }}"
                    data-location="{{ $v->location }}"
                    data-quota="{{ $v->quota }}"
                    data-deadline="{{ $v->deadline ? $v->deadline->format('Y-m-d') : '' }}"
                    data-desc="{{ $v->description }}"
                    data-auto-close-method="{{ $v->auto_close_method }}"
                    data-age-min="{{ $v->age_min }}"
                    data-age-max="{{ $v->age_max }}"
                    data-passing-grade="{{ $v->passing_grade }}"
                    data-salary-min="{{ $v->salary_min }}"
                    data-salary-max="{{ $v->salary_max }}"
                    data-show-salary="{{ $v->show_salary }}"
                    data-requirements="{{ $v->requirements }}"
                    data-benefits="{{ $v->benefits }}"
                    data-employment-type="{{ $v->employment_type }}"
                    data-banner-image="{{ $v->banner_image ? asset($v->banner_image) : '' }}"
                    onclick="if(!event.target.closest('button')) window.location.href='{{ $v->status === 'draft' ? '/hr/lowongan/buat?draft_id=' . $v->id : '/hr/lowongan/' . $v->id }}'">

                    <td class="py-4 pr-4">
                        <div class="flex items-center gap-2">
                            <p class="font-bold text-sm {{ $isLockedStatus ? 'line-through text-gray-400' : 'text-gray-900' }}">{{ $v->title }}</p>
                            <span class="text-[9px] font-bold text-green-700 bg-green-50 border border-green-200 px-1.5 py-0.5 rounded uppercase shrink-0">{{ str_replace('-', ' ', $v->employment_type) }}</span>
                            @if($v->is_archived)
                                <span class="text-[9px] font-bold text-purple-700 bg-purple-50 border border-purple-200 px-1.5 py-0.5 rounded uppercase shrink-0">ARCHIVED</span>
                            @endif
                        </div>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $refId }}</p>
                    </td>
                    <td class="py-4 pr-4 text-sm text-gray-500">{{ $v->category->name ?? '-' }}</td>
                    <td class="py-4 pr-4 text-sm text-gray-500">{{ $v->location ?? '-' }}</td>
                    <td class="py-4 pr-4">
                        @if($v->applicant_count === 0 && !$isFilled)
                            <span class="text-sm text-green-600 font-medium">No applicants yet</span>
                        @else
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ in_array($v->status, ['closed', 'filled']) ? 'bg-gray-400' : 'bg-green-600' }} rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $displayApplicants }}</span>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 pr-4 text-sm font-semibold text-gray-700">{{ str_pad($v->quota, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-4 pr-4 text-sm text-gray-500">{{ $v->deadline ? $v->deadline->format('d M Y') : '-' }}</td>
                    <td class="py-4 pr-4">
                        @if($v->is_archived)
                            <span class="text-xs font-bold text-purple-700 bg-purple-50 border border-purple-200 px-2.5 py-1 rounded-full">ARCHIVED</span>
                        @elseif($statusBadge === 'ACTIVE')
                            <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full">ACTIVE</span>
                        @elseif($statusBadge === 'DRAFT')
                            <span class="text-xs font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full">DRAFT</span>
                        @elseif($statusBadge === 'FILLED')
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-1 rounded-full">FILLED</span>
                        @else
                            <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full">CLOSED</span>
                        @endif
                    </td>
                    <td class="py-4 text-right relative">
                        @if($v->status === 'draft')
                            <button class="btn-publish-draft bg-green-800 hover:bg-green-750 text-white text-xs font-bold px-3.5 py-1.5 rounded-lg transition-colors shadow-sm inline-flex items-center gap-1.5 mr-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Publish
                            </button>
                        @elseif(!$isLockedStatus)
                            <button class="btn-vacancy-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        @else
                            <span class="text-xs font-semibold text-gray-400 italic pr-1">Closed</span>
                        @endif
                    </td>
                </tr>
                @endforeach

                <!-- Empty State Row -->
                <tr id="empty-state-row" class="hidden">
                    <td colspan="8" class="py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12.01" y1="8" y2="8"/><path d="M12 12v4"/></svg>
                            <p class="text-sm font-semibold text-gray-500">No vacancies found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your filters or search term.</p>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
            <p id="pagination-text" class="text-xs text-gray-400">Showing {{ min($vacancies->count(), 5) }} of {{ $vacancies->count() }} vacancies</p>
            <div id="pagination-buttons" class="flex items-center gap-1">
                <!-- Rendered dynamically by lowongan.js -->
            </div>
        </div>
    </div>
</div>

<!-- Dropdown action vacancy -->
<div id="vacancy-dropdown" class="hidden absolute bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-44 py-1.5">
    <button class="vd-edit w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
        Edit Vacancy
    </button>
    <button class="vd-fill w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-blue-600 hover:bg-blue-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        Mark as Filled
    </button>
    <div class="my-1 border-t border-gray-100"></div>
    <button class="vd-close w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
        Close Vacancy
    </button>
</div>

<!-- Modal: Create New Vacancy -->
<div id="modal-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl">
        <div class="bg-green-900 px-6 py-5 flex items-center justify-between">
            <h2 class="text-white font-bold">Create New Vacancy</h2>
            <button id="btn-close-vacancy-modal" class="text-green-300 hover:text-white transition-colors">
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
            <button id="btn-save-vacancy" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Create Vacancy</button>
        </div>
    </div>
</div>

<!-- Modal: Close Vacancy confirm -->
<div id="modal-close-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative">
        <button id="btn-close-cv-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Close Vacancy?</h3>
        <p class="text-sm text-gray-500 mb-5">This vacancy will be closed and will not accept new applicants.</p>
        <div class="space-y-2.5">
            <button id="btn-confirm-close-vacancy" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Yes, Close Vacancy</button>
            <button id="btn-cancel-close-vacancy" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
    </div>
</div>

<!-- Modal: Mark as Filled confirm -->
<div id="modal-fill-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative">
        <button id="btn-close-fill-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Mark as Filled?</h3>
        <p class="text-sm text-gray-500 mb-5">This vacancy will be marked as filled and closed for new applications.</p>
        <div class="space-y-2.5">
            <button id="btn-confirm-fill-vacancy" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Yes, Mark as Filled</button>
            <button id="btn-cancel-fill-vacancy" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
    </div>
</div>

<!-- Modal: Publish Vacancy confirm -->
<div id="modal-publish-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative animate-fade-in">
        <button id="btn-close-publish-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="w-14 h-14 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Publish Vacancy?</h3>
        <p class="text-sm text-gray-500 mb-5">Are you sure you want to publish this vacancy? It will immediately go active and be open to the public for applications.</p>
        <div class="space-y-2.5">
            <button id="btn-confirm-publish-vacancy" class="w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Yes, Publish</button>
            <button id="btn-cancel-publish-vacancy" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
    </div>
</div>

<!-- Modal: Vacancy Incomplete Alert -->
<div id="modal-incomplete-vacancy" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative animate-fade-in">
        <button id="btn-close-incomplete-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Incomplete Data</h3>
        <p class="text-sm text-gray-500 mb-5">The details for this vacancy are incomplete. Please complete all required information before publishing.</p>
        <div class="space-y-2.5">
            <button id="btn-incomplete-lengkapi" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Complete Data</button>
            <button id="btn-confirm-incomplete-ok" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
    </div>
</div>

<!-- Modal: Add Category -->
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
            <!-- Dynamic Icon (Briefcase or MapPin) -->
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
            <!-- Dynamic Icon (checkmark or warning) -->
        </div>
        <h3 id="alert-modal-title" class="text-lg font-bold text-gray-900 mb-2">Notification</h3>
        <p id="alert-modal-desc" class="text-sm text-gray-500 mb-6">Something happened.</p>
        <button id="btn-alert-ok" class="w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-2.5 rounded-lg text-sm transition-colors focus:outline-none">OK</button>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
<script>
    window.vacancyTrends = @json($trends);
</script>
<script src="{{ asset('js/hr/lowongan.js') }}"></script>
@endsection
