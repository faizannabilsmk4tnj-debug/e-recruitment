@extends('layouts.hr')

@section('title', 'Vacancies')
@section('page-title', 'Vacancies')
@section('nav-lowongan', 'text-green-800 border-green-700 font-semibold')

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
    <div class="grid grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full" id="trend-vacancies-badge">+{{ $trends['weekly']['vacancies'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ str_pad($totalVacancies, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-1">Total Vacancies</p>
            <p class="text-[10px] text-gray-400 mt-1 font-medium" id="trend-vacancies-label">+{{ $trends['weekly']['vacancies'] }} new this week</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span class="text-xs font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full" id="trend-applicants-badge">+{{ $trends['weekly']['applicants'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ number_format($activeApplicants) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-1">Active Applicants</p>
            <p class="text-[10px] text-gray-400 mt-1 font-medium" id="trend-applicants-label">+{{ $trends['weekly']['applicants'] }} applied this week</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full" id="trend-closed-badge">-{{ $trends['weekly']['closed'] }}</span>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ str_pad($closingSoon, 2, '0', STR_PAD_LEFT) }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-1">Closing Soon</p>
            <p class="text-[10px] text-gray-400 mt-1 font-medium" id="trend-closed-label">-{{ $trends['weekly']['closed'] }} closed this week</p>
        </div>
        <div class="bg-green-900 rounded-2xl p-5 relative overflow-hidden">
            <p class="text-xs font-semibold text-green-300 uppercase tracking-wider mb-2">Recruitment Target</p>
            <p class="text-4xl font-extrabold text-white mb-3">{{ $recruitmentTargetPercentage }}%</p>
            <div class="h-1.5 bg-green-700 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full" style="width: {{ $recruitmentTargetPercentage }}%"></div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute bottom-3 right-4 w-12 h-12 text-green-700 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/></svg>
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
            </select>
            <select id="filter-category" class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-gray-600">
                <option value="">Category: All</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                @endforeach
            </select>
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
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Applicants</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Quota</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Deadline</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3 pr-4">Status</th>
                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider pb-3">Actions</th>
                </tr>
            </thead>
            <tbody id="vacancy-table">

                @foreach($vacancies as $v)
                @php
                    // Map database status to uppercase badge text
                    $statusBadge = 'DRAFT';
                    if ($v->status === 'open') {
                        $statusBadge = 'ACTIVE';
                    } elseif ($v->status === 'closed') {
                        $statusBadge = 'CLOSED';
                    } elseif ($v->status === 'expired') {
                        $statusBadge = 'CLOSED';
                    }
                    
                    // Compute progress
                    $progress = $v->quota > 0 ? min(100, ($v->applicant_count / $v->quota) * 100) : 0;
                    
                    // Reference ID format (REF-ECO-YEAR-ID)
                    $refId = 'REF-ECO-' . $v->created_at->format('Y') . '-' . str_pad($v->id, 3, '0', STR_PAD_LEFT);
                @endphp
                <tr class="border-t border-gray-50 hover:bg-gray-50 transition-colors cursor-pointer vacancy-row {{ $v->status === 'closed' || $v->status === 'expired' ? 'opacity-50' : '' }}"
                    data-id="{{ $v->id }}"
                    data-title="{{ strtolower($v->title) }}"
                    data-ref="{{ strtolower($refId) }}"
                    data-status="{{ $statusBadge }}"
                    data-category="{{ $v->category->name ?? '' }}"
                    data-category-id="{{ $v->category_id }}"
                    data-quota="{{ $v->quota }}"
                    data-deadline="{{ $v->deadline ? $v->deadline->format('Y-m-d') : '' }}"
                    data-desc="{{ $v->description }}"
                    onclick="if(!event.target.closest('button')) window.location.href='/hr/lowongan/{{ $v->id }}'">

                    <td class="py-4 pr-4">
                        <p class="font-bold text-sm {{ $v->status === 'closed' || $v->status === 'expired' ? 'line-through text-gray-400' : 'text-gray-900' }}">{{ $v->title }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $refId }}</p>
                    </td>
                    <td class="py-4 pr-4 text-sm text-gray-500">{{ $v->category->name ?? '-' }}</td>
                    <td class="py-4 pr-4">
                        @if($v->applicant_count === 0)
                            <span class="text-sm text-green-600 font-medium">No applicants yet</span>
                        @else
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $v->status === 'closed' || $v->status === 'expired' ? 'bg-gray-400' : 'bg-green-600' }} rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $v->applicant_count }}</span>
                            </div>
                        @endif
                    </td>
                    <td class="py-4 pr-4 text-sm font-semibold text-gray-700">{{ str_pad($v->quota, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-4 pr-4 text-sm text-gray-500">{{ $v->deadline ? $v->deadline->format('d M Y') : '-' }}</td>
                    <td class="py-4 pr-4">
                        @if($statusBadge === 'ACTIVE')
                            <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full">ACTIVE</span>
                        @elseif($statusBadge === 'DRAFT')
                            <span class="text-xs font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full">DRAFT</span>
                        @else
                            <span class="text-xs font-bold text-red-600 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full">CLOSED</span>
                        @endif
                    </td>
                    <td class="py-4 text-right relative">
                        @if($v->status !== 'closed' && $v->status !== 'expired')
                            <button class="btn-vacancy-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        @else
                            <span class="text-xs font-semibold text-gray-400 italic pr-1">Closed</span>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-400">Showing {{ $vacancies->count() }} of {{ $totalVacancies }} vacancies</p>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center bg-green-800 text-white rounded-lg text-xs font-semibold">1</button>
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-xs text-gray-500 hover:bg-gray-50 transition-colors">2</button>
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-xs text-gray-500 hover:bg-gray-50 transition-colors">3</button>
                <button class="w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom: Internal Mobility + Active Recruiters -->
    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2 rounded-2xl overflow-hidden relative h-40" style="background: linear-gradient(135deg, #14532d, #166534);">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 p-6 h-full flex flex-col justify-between">
                <div>
                    <h3 class="text-white font-bold text-xl">Internal Mobility Insights</h3>
                    <p class="text-green-200 text-sm mt-1 max-w-md">Discover potential internal candidates based on skill-gap analysis across your current workforce.</p>
                </div>
                <button class="flex items-center gap-1 text-white font-bold text-xs hover:text-green-300 transition-colors w-fit">
                    RUN ANALYSIS
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-4">Active Recruiters</p>
            <div class="flex items-center gap-2 mb-3">
                <div class="flex -space-x-2">
                    <div class="w-9 h-9 rounded-full bg-green-700 border-2 border-white flex items-center justify-center text-white text-xs font-bold">AR</div>
                    <div class="w-9 h-9 rounded-full bg-blue-500 border-2 border-white flex items-center justify-center text-white text-xs font-bold">SA</div>
                    <div class="w-9 h-9 rounded-full bg-amber-500 border-2 border-white flex items-center justify-center text-white text-xs font-bold">BS</div>
                    <div class="w-9 h-9 rounded-full bg-gray-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">+4</div>
                </div>
            </div>
            <p class="text-xs text-gray-500 leading-relaxed">Currently managing 14 separate talent pools across ASEAN production sites.</p>
        </div>
    </div>
</div>

<!-- Dropdown action vacancy -->
<div id="vacancy-dropdown" class="hidden absolute bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-44 py-1.5">
    <button class="vd-view w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        View Applicants
    </button>
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
        <div class="p-6 grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Position Title</label>
                <input type="text" id="v-title" placeholder="e.g. Chemical Process Engineer" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Category</label>
                <select id="v-category" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">Select category...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Quota</label>
                <input type="number" id="v-quota" placeholder="e.g. 3" min="1" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Deadline</label>
                <input type="date" id="v-deadline" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Status</label>
                <select id="v-status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="DRAFT">Draft</option>
                    <option value="ACTIVE">Active</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Description</label>
                <textarea id="v-desc" rows="3" placeholder="Brief job description..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
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

@endsection

@section('js')
<script>
    window.vacancyTrends = @json($trends);
</script>
<script src="{{ asset('js/hr/lowongan.js') }}"></script>
@endsection