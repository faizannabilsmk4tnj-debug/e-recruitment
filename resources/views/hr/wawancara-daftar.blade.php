@extends('layouts.hr')

@section('title', 'Interview List')
@section('page-title', 'Interview List')
@section('nav-wawancara', 'text-green-800 border-green-700 font-semibold')

@php
    function getInitials($name) {
        $words = explode(' ', trim($name));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            if (!empty($w)) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
        }
        return $initials ?: 'AP';
    }

    function getAvatarBg($name) {
        $colors = [
            'bg-blue-100 text-blue-800', 
            'bg-pink-100 text-pink-800', 
            'bg-amber-100 text-amber-800', 
            'bg-red-100 text-red-800', 
            'bg-purple-100 text-purple-800', 
            'bg-teal-100 text-teal-800', 
            'bg-green-100 text-green-800', 
            'bg-indigo-100 text-indigo-800', 
            'bg-rose-100 text-rose-800'
        ];
        $hash = crc32($name);
        return $colors[abs($hash) % count($colors)];
    }

    $typeIcons = [
        'online' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m9 9 5 3-5 3v-6"/></svg>',
        'offline' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14"/><path d="M4 19h16"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>'
    ];

    $typeLabels = [
        'online' => 'Online Meeting',
        'offline' => 'On-site Office'
    ];
@endphp

@section('content')
<div class="px-8 py-8 max-w-7xl mx-auto">
    <!-- Top Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1">MANAGEMENT SYSTEM</p>
            <h1 class="text-3xl font-extrabold text-gray-900">Interview List</h1>
        </div>
        <div class="flex items-center gap-4">
            <!-- Search Form -->
            <form action="/hr/wawancara/daftar" method="GET" class="relative">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                @if(request('date')) <input type="hidden" name="date" value="{{ request('date') }}"> @endif
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sessions..." class="pl-9 pr-4 py-2 bg-gray-100/50 border border-transparent rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white w-64 transition-all">
            </form>
            
            <button onclick="openScheduleModal()" class="bg-green-800 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-900 transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Schedule New
            </button>
            <div class="flex items-center bg-gray-100 rounded-lg p-1 border border-gray-200 shadow-inner">
                <span class="px-3.5 py-1.5 text-xs font-bold text-green-900 bg-white shadow-sm rounded-md transition-colors">List View</span>
                <a href="/hr/wawancara" class="px-3.5 py-1.5 text-xs font-bold text-gray-500 rounded-md hover:text-gray-900 transition-colors">Month View</a>
            </div>

        </div>
    </div>

    {{-- ===== RESCHEDULE REQUEST ALERT BANNER ===== --}}
    @if($rescheduleCount > 0)
    <div id="reschedule-alert-banner" class="mb-6 bg-amber-50 border-2 border-amber-300 rounded-2xl p-5 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-extrabold text-amber-700 uppercase tracking-widest">Action Required</span>
                        <span class="bg-amber-600 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full">{{ $rescheduleCount }} Pending</span>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900">Reschedule Requests Awaiting Decision</h3>
                    <p class="text-sm text-amber-700 mt-0.5">{{ $rescheduleCount }} applicants requested interview rescheduling. Review and decide promptly.</p>
                </div>
            </div>
        </div>

        {{-- Mini table of requests --}}
        <div class="mt-4 bg-white rounded-xl border border-amber-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-amber-50 border-b border-amber-100">
                    <tr>
                        <th class="px-4 py-2.5 text-left text-[10px] font-extrabold text-amber-700 uppercase tracking-widest">Applicant</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-extrabold text-amber-700 uppercase tracking-widest">Position</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-extrabold text-amber-700 uppercase tracking-widest">Original Schedule</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-extrabold text-amber-700 uppercase tracking-widest">Proposed New Schedule</th>
                        <th class="px-4 py-2.5 text-left text-[10px] font-extrabold text-amber-700 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-50">
                    @foreach($rescheduleRequests as $req)
                    @php
                        $reqData = [
                            'id'                    => $req->id,
                            'scheduled_at'          => $req->scheduled_at ? $req->scheduled_at->toISOString() : null,
                            'duration_minutes'      => $req->duration_minutes,
                            'interview_type'        => $req->interview_type,
                            'location_or_link'      => $req->location_or_link,
                            'proposed_scheduled_at' => $req->proposed_scheduled_at ? $req->proposed_scheduled_at->toISOString() : null,
                            'proposed_interview_type' => $req->proposed_interview_type,
                            'reschedule_reason'     => $req->reschedule_reason,
                            'notes'                 => $req->notes,
                            'application' => [
                                'user' => ['name' => $req->application?->user?->name, 'email' => $req->application?->user?->email],
                                'job'  => ['title' => $req->application?->job?->title],
                            ],
                        ];
                    @endphp
                    <tr class="hover:bg-amber-50/40 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full {{ getAvatarBg($req->application?->user?->name ?? 'AP') }} flex items-center justify-center font-bold text-[10px] shrink-0">
                                    {{ getInitials($req->application?->user?->name ?? 'AP') }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs">{{ $req->application?->user?->name ?? 'N/A' }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $req->application?->user?->email ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold text-gray-700">{{ $req->application?->job?->title ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($req->scheduled_at)
                                <p class="text-xs font-bold text-gray-900">{{ $req->scheduled_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-gray-500">{{ $req->scheduled_at->format('H:i') }} ({{ $req->duration_minutes }}m)</p>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($req->proposed_scheduled_at)
                                <p class="text-xs font-bold text-amber-700">{{ $req->proposed_scheduled_at->format('d M Y') }}</p>
                                <p class="text-[10px] text-amber-600">{{ $req->proposed_scheduled_at->format('H:i') }} &mdash; {{ $req->proposed_interview_type ? ucfirst($req->proposed_interview_type) : '' }}</p>
                            @elseif($req->reschedule_reason)
                                <span class="text-xs text-amber-600 italic">View reason in modal</span>
                            @else
                                <span class="text-xs text-gray-400">No proposed time</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <button onclick='openRescheduleReviewModal(@json($reqData))'
                                    class="bg-amber-100 hover:bg-amber-200 text-amber-800 font-bold text-xs px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5 border border-amber-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Review & Decide
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Date Navigation Widget (Only when date is filtered) -->
    @if(request('date'))
        @php
            try {
                $selectedDate = \Carbon\Carbon::parse(request('date'));
                $prevDate = (clone $selectedDate)->subDay()->toDateString();
                $nextDate = (clone $selectedDate)->addDay()->toDateString();
                $formattedSelected = $selectedDate->format('d F Y');
                $isValidDate = true;
            } catch(\Exception $e) {
                $isValidDate = false;
            }
        @endphp
        @if($isValidDate)
            <div class="bg-green-50/70 border border-green-200 rounded-2xl p-4 mb-6 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-green-700 uppercase tracking-widest block">Selected Date</span>
                        <span class="text-sm font-extrabold text-green-950">{{ $formattedSelected }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ request()->fullUrlWithQuery(['date' => $prevDate]) }}" class="px-3.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-green-850 transition-all flex items-center gap-1.5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        Previous Day
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['date' => $nextDate]) }}" class="px-3.5 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-green-850 transition-all flex items-center gap-1.5 shadow-sm">
                        Next Day
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7-7" /></svg>
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['date' => null]) }}" class="px-3.5 py-2 bg-red-50 border border-red-150 rounded-lg text-xs font-bold text-red-700 hover:bg-red-100 transition-all flex items-center gap-1.5 shadow-sm">
                        All Dates
                    </a>
                </div>
            </div>
        @endif
    @endif

    <!-- Filters Section -->
    <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-5 mb-8 flex flex-wrap items-end gap-6">
        <div>
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">STATUS FILTER</label>
            <div class="flex items-center bg-white border border-gray-200 rounded-lg p-1">
                <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="px-4 py-1.5 text-xs font-bold rounded-md transition-colors {{ request('status', 'all') === 'all' ? 'text-white bg-green-900 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">All</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'scheduled']) }}" class="px-4 py-1.5 text-xs font-bold rounded-md transition-colors {{ request('status') === 'scheduled' ? 'text-white bg-green-900 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Scheduled</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'rescheduled']) }}" class="px-4 py-1.5 text-xs font-bold rounded-md transition-colors {{ request('status') === 'rescheduled' ? 'text-white bg-amber-600 shadow-sm' : 'text-amber-700 hover:text-amber-900 bg-amber-50' }} flex items-center gap-1.5">
                    Rescheduled
                    @if($rescheduleCount > 0)
                        <span class="bg-amber-600 text-white text-[9px] font-extrabold px-1.5 py-0.5 rounded-full leading-none {{ request('status') === 'rescheduled' ? 'bg-white text-amber-700' : '' }}">{{ $rescheduleCount }}</span>
                    @endif
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}" class="px-4 py-1.5 text-xs font-bold rounded-md transition-colors {{ request('status') === 'completed' ? 'text-white bg-green-900 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Completed</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'cancelled']) }}" class="px-4 py-1.5 text-xs font-bold rounded-md transition-colors {{ request('status') === 'cancelled' ? 'text-white bg-green-900 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Cancelled</a>
            </div>
        </div>

        <form action="/hr/wawancara/daftar" method="GET" class="flex items-end gap-6 flex-1">
            @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">DATE (YYYY-MM-DD)</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    <input type="text" name="date" id="filter-date" value="{{ request('date') }}" placeholder="YYYY-MM-DD" class="pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none w-[200px]">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">TYPE</label>
                <div class="relative">
                    <select name="type" onchange="this.form.submit()" class="pl-4 pr-10 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none w-[180px] appearance-none">
                        <option value="all" @selected(request('type', 'all') === 'all')>All Types</option>
                        <option value="online" @selected(request('type') === 'online')>Online Meeting</option>
                        <option value="offline" @selected(request('type') === 'offline')>On-site Office</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                </div>
            </div>

            <button type="submit" class="bg-green-800 text-white p-2.5 rounded-lg shadow-sm hover:bg-green-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </button>

            @if(request()->anyFilled(['search', 'status', 'type', 'date']))
            <a href="/hr/wawancara/daftar" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold transition-colors self-center">
                Clear Filters
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">CANDIDATE NAME</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">POSITION</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">DATE & TIME</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">TYPE</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">STATUS</th>
                    <th class="text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($interviews as $interview)
                @php
                    $candidateName = $interview->application->user->name ?? 'Candidate';
                    $candidateEmail = $interview->application->user->email ?? 'N/A';
                    $jobTitle = $interview->application->job->title ?? 'N/A';
                    $initials = getInitials($candidateName);
                    $avatarBg = getAvatarBg($candidateName);

                    $statusClasses = [
                        'scheduled' => 'text-green-700 bg-green-50 border border-green-200',
                        'completed' => 'text-emerald-700 bg-emerald-50 border border-emerald-200',
                        'cancelled' => 'text-red-700 bg-red-50 border border-red-200',
                        'rescheduled' => 'text-amber-700 bg-amber-50 border border-amber-200'
                    ];
                    $statusClass = $statusClasses[$interview->status] ?? 'text-gray-700 bg-gray-50 border border-gray-200';
                    $isAccepted = $interview->application && $interview->application->status === 'accepted';
                @endphp
                <tr class="hover:bg-gray-50/50 transition-colors group {{ $isAccepted ? 'opacity-60 bg-gray-100/90 border-gray-200 cursor-not-allowed' : 'cursor-pointer' }}" 
                    @if($isAccepted) onclick="event.preventDefault();" @else onclick="window.location.href='/hr/pelamar/{{ $interview->application_id }}'" @endif>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ $avatarBg }} flex items-center justify-center font-bold text-xs shrink-0">{{ $initials }}</div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 {{ !$isAccepted ? 'group-hover:text-green-800' : '' }} transition-colors">{{ $candidateName }}</p>
                                <p class="text-xs text-gray-400">{{ $candidateEmail }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold text-gray-700 bg-gray-100">{{ $jobTitle }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm text-gray-900">{{ $interview->scheduled_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $interview->scheduled_at->format('H:i') }} ({{ $interview->duration_minutes }}m)</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                            {!! $typeIcons[$interview->interview_type] ?? '' !!}
                            {{ $typeLabels[$interview->interview_type] ?? ucfirst($interview->interview_type) }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusClass }} w-fit">
                                <span class="w-1.5 h-1.5 rounded-full {{ $interview->status === 'scheduled' ? 'bg-green-500' : ($interview->status === 'completed' ? 'bg-emerald-500' : ($interview->status === 'rescheduled' ? 'bg-amber-500' : 'bg-red-500')) }}"></span>
                                {{ strtoupper($interview->status) }}
                            </span>
                            @if($interview->attendance_status === 'present')
                                <span class="text-[9px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded w-fit flex items-center gap-1 text-left" title="Attended at: {{ $interview->attendance_confirmed_at ? $interview->attendance_confirmed_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '' }} WIB">
                                    <svg class="w-2.5 h-2.5 text-emerald-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Present ({{ $interview->attendance_confirmed_at ? $interview->attendance_confirmed_at->setTimezone('Asia/Jakarta')->format('H:i') : '' }})
                                </span>
                                @if($interview->attendance_photo)
                                    <a href="{{ $interview->attendance_photo }}" target="_blank" class="text-[9px] font-bold text-green-700 hover:text-green-800 underline flex items-center gap-1 mt-0.5 w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                        Selfie Photo
                                    </a>
                                @endif
                            @elseif($interview->attendance_status === 'absent')
                                <span class="text-[9px] font-bold text-red-800 bg-red-50 border border-red-100 px-1.5 py-0.5 rounded w-fit">
                                    Absent
                                </span>
                            @else
                                <span class="text-[9px] font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded w-fit">
                                    Not Attended Yet
                                </span>
                            @endif

                            @if($interview->result)
                                <div class="text-[10px] text-gray-500 mt-1 border-t border-gray-100 pt-1 flex flex-col gap-0.5">
                                    <span><span class="font-bold">Score:</span> {{ $interview->result->score }}/100</span>
                                    <span><span class="font-bold">Rec:</span> <span class="uppercase font-bold @if($interview->result->recommendation === 'proceed') text-green-600 @elseif($interview->result->recommendation === 'hold') text-amber-600 @else text-red-600 @endif">{{ $interview->result->recommendation }}</span></span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right" onclick="event.stopPropagation()">
                        <div class="flex justify-end gap-2">
                             @if($isAccepted)
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Accepted (No action allowed)">
                                    Profile
                                </span>
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Accepted (No action allowed)">
                                    Reschedule
                                </span>
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Accepted (No action allowed)">
                                    Status / Evaluate
                                </span>
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Accepted (No action allowed)">
                                    Delete
                                </span>
                            @else
                                <a href="/hr/pelamar/{{ $interview->application_id }}" class="text-green-800 hover:text-green-950 font-semibold text-xs bg-green-50 hover:bg-green-100 px-2 py-1 rounded transition-colors" title="View Profile">
                                    Profile
                                </a>
                                <button onclick='openRescheduleModal(@json($interview))' class="text-blue-800 hover:text-blue-950 font-semibold text-xs bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded transition-colors" title="Reschedule">
                                    Reschedule
                                </button>
                                <button onclick='openStatusModal(@json($interview))' class="text-amber-800 hover:text-amber-950 font-semibold text-xs bg-amber-50 hover:bg-amber-100 px-2 py-1 rounded transition-colors" title="Status & Evaluation">
                                    Status / Evaluate
                                </button>
                                <button onclick="deleteInterview({{ $interview->id }})" class="text-red-800 hover:text-red-950 font-semibold text-xs bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition-colors" title="Delete">
                                    Delete
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                        No interview sessions found matching your filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Footer -->
        @if($interviews->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $interviews->links() }}
        </div>
        @endif
    </div>

    <!-- Bottom Section: Stats & Location Templates -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-900 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
                <div class="absolute -right-4 -top-4 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-green-100 mb-1">Active Scheduled</h3>
                    <div class="text-4xl font-extrabold mb-1">{{ $totalScheduled }}</div>
                    <p class="text-[10px] font-medium text-green-300">Requires attendance</p>
                </div>
            </div>

            <div class="bg-green-100 border border-green-200 text-green-900 rounded-2xl p-6 shadow-sm">
                <div class="w-10 h-10 bg-green-200/50 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-green-800 mb-1">Attendance Rate</h3>
                <div class="text-4xl font-extrabold mb-1">{{ $attendanceRate }}%</div>
                <p class="text-[10px] font-bold text-green-700 flex items-center gap-1">
                    Completed vs Cancelled
                </p>
            </div>

            <div class="bg-gray-100 border border-gray-200 text-gray-900 rounded-2xl p-6 shadow-sm">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mb-4 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-6-6m6 6v-4.8m0 4.8h-4.8"/><path d="M3 16.2V21m0 0h4.8M3 21l6-6"/><path d="M21 7.8V3m0 0h-4.8M21 3l-6 6"/><path d="M3 7.8V3m0 0h4.8M3 3l6 6"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Average Duration</h3>
                <div class="text-4xl font-extrabold mb-1">{{ $avgDuration }}m</div>
                <p class="text-[10px] font-medium text-gray-500">Scheduled standard minutes</p>
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 h-full flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Location Templates</h3>
                        <button type="button" onclick="openCentralLocTemplateModal()" class="text-[10px] text-green-700 hover:text-green-900 font-bold transition flex items-center gap-1 cursor-pointer">
                            ⚙️ Manage
                        </button>
                    </div>
                    <div class="space-y-2.5 max-h-48 overflow-y-auto pr-1" id="central-loc-templates-list">
                        <!-- Populated dynamically via JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Schedule New Interview -->
<div id="modal-buat" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeScheduleModal()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl bg-white shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-green-900">Schedule Interview</h2>
                <p class="text-sm text-gray-500 mt-1">Schedule a session for an applicant</p>
            </div>
            <button onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-buat" class="flex-1 flex flex-col">
            @csrf
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Select Candidate</label>
                    <select name="application_id" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="">-- Choose Candidate --</option>
                        @foreach($applications as $app)
                            <option value="{{ $app->id }}">{{ $app->user->name ?? 'N/A' }} - {{ $app->job->title ?? 'N/A' }} (Status: {{ ucfirst($app->status) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Date</label>
                        <input type="date" id="buat_date" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Time (24h)</label>
                        <div class="flex items-center gap-1.5">
                            <select id="buat_hour" class="w-full px-2 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-center">
                                @for($i = 0; $i < 24; $i++)
                                    @php $h = sprintf('%02d', $i); @endphp
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endfor
                            </select>
                            <span class="text-gray-400 font-bold">:</span>
                            <select id="buat_minute" class="w-full px-2 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-center">
                                @for($i = 0; $i < 60; $i += 5)
                                    @php $m = sprintf('%02d', $i); @endphp
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                        <input name="scheduled_at" type="hidden" id="buat_scheduled_at">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Duration</label>
                        <select name="duration_minutes" id="buat_duration" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="30">30 Minutes</option>
                            <option value="45">45 Minutes</option>
                            <option value="60" selected>60 Minutes</option>
                            <option value="90">90 Minutes</option>
                            <option value="120">120 Minutes</option>
                        </select>
                    </div>
                </div>
                
                {{-- Booked slots timeline container --}}
                <div id="buat_booked_timeline" class="hidden text-xs bg-amber-50/60 border border-amber-200 rounded-xl p-3.5 text-amber-900 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Booked Interview Schedule Today:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5" id="buat_booked_slots_list">
                    </ul>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                        <select name="interview_type" id="buat_interview_type" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="online" selected>Online Meeting</option>
                            <option value="offline">On-site / Offline</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Quick Select Template</label>
                        <select id="buat_template_select" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="">-- Choose Template --</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Location / Meeting Link</label>
                        <button type="button" onclick="openCentralLocTemplateModal()" class="text-[10px] text-green-700 hover:text-green-900 font-bold transition flex items-center gap-1 cursor-pointer">
                            ⚙️ Manage Templates
                        </button>
                    </div>
                    <input name="location_or_link" id="buat_location_or_link" type="text" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Notes..."></textarea>
                </div>
            </div>
            <div class="border-t border-gray-100 px-8 py-4 flex items-center justify-between bg-white">
                <button type="button" onclick="closeScheduleModal()" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Cancel</button>
                <button type="submit" class="bg-green-800 hover:bg-green-900 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md transition">Schedule Session</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Reschedule Interview -->
<div id="modal-reschedule" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeRescheduleModal()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl bg-white shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-green-900">Reschedule Interview</h2>
                <p id="reschedule-candidate-name" class="text-sm text-gray-500 mt-1"></p>
            </div>
            <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-reschedule" class="flex-1 flex flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="reschedule-id">
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Date</label>
                        <input type="date" id="reschedule_date" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Time (24h)</label>
                        <div class="flex items-center gap-1.5">
                            <select id="reschedule_hour" class="w-full px-2 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-center">
                                @for($i = 0; $i < 24; $i++)
                                    @php $h = sprintf('%02d', $i); @endphp
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endfor
                            </select>
                            <span class="text-gray-400 font-bold">:</span>
                            <select id="reschedule_minute" class="w-full px-2 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-center">
                                @for($i = 0; $i < 60; $i += 5)
                                    @php $m = sprintf('%02d', $i); @endphp
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                        <input name="scheduled_at" type="hidden" id="reschedule-scheduled-at">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Duration</label>
                        <select name="duration_minutes" id="reschedule-duration" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="30">30 Minutes</option>
                            <option value="45">45 Minutes</option>
                            <option value="60" selected>60 Minutes</option>
                            <option value="90">90 Minutes</option>
                            <option value="120">120 Minutes</option>
                        </select>
                    </div>
                </div>

                {{-- Booked slots timeline container --}}
                <div id="reschedule_booked_timeline" class="hidden text-xs bg-amber-50/60 border border-amber-200 rounded-xl p-3.5 text-amber-900 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Booked Interview Schedule Today:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5" id="reschedule_booked_slots_list">
                    </ul>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                        <select name="interview_type" id="reschedule-type" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="online">Online Meeting</option>
                            <option value="offline">On-site / Offline</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Quick Select Template</label>
                        <select id="reschedule_template_select" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="">-- Choose Template --</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest">Location / Meeting Link</label>
                        <button type="button" onclick="openCentralLocTemplateModal()" class="text-[10px] text-green-700 hover:text-green-900 font-bold transition flex items-center gap-1 cursor-pointer">
                            ⚙️ Manage Templates
                        </button>
                    </div>
                    <input name="location_or_link" id="reschedule-location" type="text" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Notes</label>
                    <textarea name="notes" id="reschedule-notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Notes..."></textarea>
                </div>
            </div>
            <div class="border-t border-gray-100 px-8 py-4 flex items-center justify-between bg-white">
                <button type="button" onclick="closeRescheduleModal()" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Cancel</button>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md transition">Update Schedule</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Update Interview Status & Feedback -->
<div id="modal-status" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeStatusModal()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl bg-white shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-green-900">Update Status & Evaluation</h2>
                <p id="status-candidate-name" class="text-sm text-gray-500 mt-1"></p>
            </div>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-status" class="flex-1 flex flex-col">
            @csrf
            <input type="hidden" id="status-id">
            <input type="hidden" id="status-application-id">
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Status</label>
                    <select name="status" id="status-select" required class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed / Evaluate</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Evaluation Fields (Visible only when status == completed) -->
                <div id="evaluation-fields" class="space-y-5 hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Score (0-100)</label>
                            <input type="number" name="score" id="evaluate-score" min="0" max="100" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="e.g. 85">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Recommendation</label>
                            <select name="recommendation" id="evaluate-recommendation" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="proceed">Proceed</option>
                                <option value="hold">Hold</option>
                                <option value="reject">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Candidate Attendance</label>
                        <select name="attendance_status" id="evaluate-attendance-status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="pending">Pending</option>
                            <option value="present" selected>Present</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Feedback & Assessment Notes</label>
                        
                        {{-- Quick Templates Selection --}}
                        <div id="eval-templates-container" class="mb-3">
                            <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Select Feedback Template:</span>
                            <div class="flex flex-col gap-1.5 max-h-36 overflow-y-auto p-2 bg-gray-50 border border-gray-150 rounded-xl" id="eval-templates-list">
                                <!-- populated by JS based on recommendation -->
                            </div>
                        </div>

                        <textarea name="feedback" id="evaluate-feedback" rows="4" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Write in-depth interview feedback..."></textarea>
                    </div>
                </div>

                <div id="notes-field">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Feedback / Notes</label>
                    <textarea name="notes" id="status-notes" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Write feedback or notes of the interview result..."></textarea>
                </div>
            </div>
            <div class="border-t border-gray-100 px-8 py-4 flex items-center justify-between bg-white">
                <button type="button" onclick="closeStatusModal()" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Cancel</button>
                <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md transition">Save Status & Evaluation</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    function showToast(message, type = 'success') {
        const oldToast = document.getElementById('custom-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.className = 'fixed top-6 left-1/2 -translate-x-1/2 z-[200] px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold transition-all';
        toast.classList.add(type === 'success' ? 'bg-green-900' : 'bg-red-700', 'text-white');
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    async function submitJson(url, method, payload) {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            const message = data.message || Object.values(data.errors || {}).flat()[0] || 'Request failed.';
            throw new Error(message);
        }
        return data;
    }

    // Schedule Modal
    function openScheduleModal() {
        document.getElementById('modal-buat').classList.remove('hidden');
    }
    function closeScheduleModal() {
        document.getElementById('modal-buat').classList.add('hidden');
    }

    document.getElementById('form-buat').addEventListener('submit', async function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        try {
            const data = await submitJson('/hr/wawancara/buat', 'POST', {
                application_id: fd.get('application_id'),
                scheduled_at: fd.get('scheduled_at'),
                duration_minutes: fd.get('duration_minutes'),
                interview_type: fd.get('interview_type'),
                location_or_link: fd.get('location_or_link'),
                notes: fd.get('notes'),
            });
            closeScheduleModal();
            showToast(data.message || 'Interview scheduled.');
            setTimeout(() => window.location.reload(), 1000);
        } catch(err) {
            showToast(err.message, 'error');
        }
    });

    // Helper functions for booked slots booking system
    function timeToMinutes(timeStr) {
        const parts = timeStr.split(':');
        return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
    }

    async function fetchBookedSlots(dateInput, hourSelect, minuteSelect, durationSelect, timelineDiv, listUl, excludeId = null) {
        const dateVal = dateInput.value;
        if (!dateVal) {
            timelineDiv.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`/hr/wawancara/booked-slots?date=${dateVal}`);
            const data = await response.json();
            if (!data.success) return;

            // Filter out the excluded interview ID (if rescheduling)
            const slots = (data.slots || []).filter(s => s.id != excludeId);

            // Render Timeline list
            listUl.innerHTML = '';
            if (slots.length > 0) {
                slots.forEach(s => {
                    const li = document.createElement('li');
                    li.className = 'font-semibold text-[11px] text-amber-900 list-disc';
                    li.textContent = `${s.start} - ${s.end} : Interview ${s.candidate} (${s.job})`;
                    listUl.appendChild(li);
                });
                timelineDiv.classList.remove('hidden');
            } else {
                timelineDiv.classList.add('hidden');
            }

            // Cache slots on the hourSelect dataset
            hourSelect.dataset.slots = JSON.stringify(slots);

            // Trigger updates on Hour and Minute options
            updateOptionsAvailability(hourSelect, minuteSelect, durationSelect, slots);

        } catch (e) {
            console.error(e);
        }
    }

    function updateOptionsAvailability(hourSelect, minuteSelect, durationSelect, slots) {
        const selectedHour = hourSelect.value;
        const duration = parseInt(durationSelect.value, 10);

        // 1. Update Hour Options
        Array.from(hourSelect.options).forEach(opt => {
            const hVal = parseInt(opt.value, 10);
            const hStart = hVal * 60;
            const hEnd = hStart + 60;

            let booking = null;
            const isBooked = slots.some(s => {
                const start = timeToMinutes(s.start);
                const end = timeToMinutes(s.end);
                // Overlap between Hour slot [H:00 - H:59] and booked slot
                return hStart < end && hEnd > start && (booking = s, true);
            });

            if (isBooked) {
                opt.disabled = true;
                opt.title = `Already booked for interview with ${booking.candidate} (${booking.job}) at ${booking.start} - ${booking.end}`;
                opt.style.cursor = 'not-allowed';
                if (!opt.textContent.includes('(Booked)')) {
                    opt.textContent = `${opt.value} (Booked)`;
                }
            } else {
                opt.disabled = false;
                opt.title = '';
                opt.style.cursor = 'default';
                opt.textContent = opt.value;
            }
        });

        // 2. Update Minute Options based on currently selected Hour
        if (selectedHour !== '') {
            const hVal = parseInt(selectedHour, 10);
            Array.from(minuteSelect.options).forEach(opt => {
                const mVal = parseInt(opt.value, 10);
                const timeMin = hVal * 60 + mVal;

                let booking = null;
                const isBooked = slots.some(s => {
                    const start = timeToMinutes(s.start);
                    const end = timeToMinutes(s.end);
                    return timeMin >= start && timeMin < end && (booking = s, true);
                });

                if (isBooked) {
                    opt.disabled = true;
                    opt.title = `Already booked for interview with ${booking.candidate} (${booking.job}) at ${booking.start} - ${booking.end}`;
                    opt.style.cursor = 'not-allowed';
                    if (!opt.textContent.includes('(Booked)')) {
                        opt.textContent = `${opt.value} (Booked)`;
                    }
                } else {
                    opt.disabled = false;
                    opt.title = '';
                    opt.style.cursor = 'default';
                    opt.textContent = opt.value;
                }
            });
        }

        // 3. Overall validation warning
        validateSelectedTime(hourSelect, minuteSelect, durationSelect, slots);
    }

    function validateSelectedTime(hourSelect, minuteSelect, durationSelect, slots) {
        const hVal = hourSelect.value;
        const mVal = minuteSelect.value;
        const duration = parseInt(durationSelect.value, 10);
        const form = hourSelect.closest('form');
        const submitBtn = form.querySelector('button[type="submit"]');

        if (!hVal || !mVal) return;

        const selStart = parseInt(hVal, 10) * 60 + parseInt(mVal, 10);
        const selEnd = selStart + duration;

        let booking = null;
        const isConflict = slots.some(s => {
            const start = timeToMinutes(s.start);
            const end = timeToMinutes(s.end);
            return selStart < end && selEnd > start && (booking = s, true);
        });

        // Remove existing warning
        const oldWarning = form.querySelector('.time-conflict-warning');
        if (oldWarning) oldWarning.remove();

        if (isConflict) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

            const warning = document.createElement('div');
            warning.className = 'time-conflict-warning text-xs text-red-650 font-bold bg-red-50 border border-red-200 rounded-xl p-3.5 mt-3';
            warning.innerHTML = `⚠️ The selected time conflicts with interview for <strong>${booking.candidate}</strong> (${booking.job}) at <strong>${booking.start} - ${booking.end}</strong>. Please choose another time or duration.`;
            
            const grid = hourSelect.closest('.grid') || hourSelect.parentElement;
            grid.after(warning);
        } else {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    // Bind logic for Buat Modal
    const buatDate = document.getElementById('buat_date');
    const buatHour = document.getElementById('buat_hour');
    const buatMinute = document.getElementById('buat_minute');
    const buatDuration = document.getElementById('buat_duration');
    const buatScheduledAt = document.getElementById('buat_scheduled_at');
    const buatTimeline = document.getElementById('buat_booked_timeline');
    const buatTimelineList = document.getElementById('buat_booked_slots_list');

    function syncBuatScheduledAt() {
        if (buatDate.value) {
            buatScheduledAt.value = `${buatDate.value}T${buatHour.value}:${buatMinute.value}`;
        } else {
            buatScheduledAt.value = '';
        }
    }

    buatDate.addEventListener('change', () => {
        syncBuatScheduledAt();
        fetchBookedSlots(buatDate, buatHour, buatMinute, buatDuration, buatTimeline, buatTimelineList);
    });

    const triggerBuatUpdate = () => {
        syncBuatScheduledAt();
        const slots = JSON.parse(buatHour.dataset.slots || '[]');
        updateOptionsAvailability(buatHour, buatMinute, buatDuration, slots);
    };

    buatHour.addEventListener('change', triggerBuatUpdate);
    buatMinute.addEventListener('change', triggerBuatUpdate);
    buatDuration.addEventListener('change', triggerBuatUpdate);

    // Bind logic for Reschedule Modal
    const rescheduleDate = document.getElementById('reschedule_date');
    const rescheduleHour = document.getElementById('reschedule_hour');
    const rescheduleMinute = document.getElementById('reschedule_minute');
    const rescheduleDuration = document.getElementById('reschedule-duration');
    const rescheduleScheduledAt = document.getElementById('reschedule-scheduled-at');
    const rescheduleTimeline = document.getElementById('reschedule_booked_timeline');
    const rescheduleTimelineList = document.getElementById('reschedule_booked_slots_list');
    const rescheduleId = document.getElementById('reschedule-id');

    function syncRescheduleScheduledAt() {
        if (rescheduleDate.value) {
            rescheduleScheduledAt.value = `${rescheduleDate.value}T${rescheduleHour.value}:${rescheduleMinute.value}`;
        } else {
            rescheduleScheduledAt.value = '';
        }
    }

    rescheduleDate.addEventListener('change', () => {
        syncRescheduleScheduledAt();
        fetchBookedSlots(rescheduleDate, rescheduleHour, rescheduleMinute, rescheduleDuration, rescheduleTimeline, rescheduleTimelineList, rescheduleId.value);
    });

    const triggerRescheduleUpdate = () => {
        syncRescheduleScheduledAt();
        const slots = JSON.parse(rescheduleHour.dataset.slots || '[]');
        updateOptionsAvailability(rescheduleHour, rescheduleMinute, rescheduleDuration, slots);
    };

    rescheduleHour.addEventListener('change', triggerRescheduleUpdate);
    rescheduleMinute.addEventListener('change', triggerRescheduleUpdate);
    rescheduleDuration.addEventListener('change', triggerRescheduleUpdate);

    // Reschedule Modal
    function openRescheduleModal(interview) {
        document.getElementById('reschedule-id').value = interview.id;
        document.getElementById('reschedule-candidate-name').textContent = interview.application?.user?.name || 'Candidate';
        
        // Format to local ISO parts
        if (interview.scheduled_at) {
            const dateObj = new Date(interview.scheduled_at);
            
            const yyyy = dateObj.getFullYear();
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd = String(dateObj.getDate()).padStart(2, '0');
            rescheduleDate.value = `${yyyy}-${mm}-${dd}`;
            
            const hh = String(dateObj.getHours()).padStart(2, '0');
            const rawMinutes = dateObj.getMinutes();
            const roundedMinutes = String(Math.floor(rawMinutes / 5) * 5).padStart(2, '0');
            
            rescheduleHour.value = hh;
            rescheduleMinute.value = roundedMinutes;
            
            syncRescheduleScheduledAt();
        }
        
        document.getElementById('reschedule-duration').value = interview.duration_minutes || '60';
        document.getElementById('reschedule-type').value = interview.interview_type || 'online';
        document.getElementById('reschedule-location').value = interview.location_or_link || '';
        document.getElementById('reschedule-notes').value = interview.notes || '';
        
        document.getElementById('modal-reschedule').classList.remove('hidden');

        // Fetch booked slots for the initial date
        fetchBookedSlots(rescheduleDate, rescheduleHour, rescheduleMinute, rescheduleDuration, rescheduleTimeline, rescheduleTimelineList, interview.id);
    }
    function closeRescheduleModal() {
        document.getElementById('modal-reschedule').classList.add('hidden');
    }

    document.getElementById('form-reschedule').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('reschedule-id').value;
        const fd = new FormData(this);
        try {
            const data = await submitJson(`/hr/wawancara/${id}`, 'POST', {
                _method: 'PUT',
                scheduled_at: fd.get('scheduled_at'),
                duration_minutes: fd.get('duration_minutes'),
                interview_type: fd.get('interview_type'),
                location_or_link: fd.get('location_or_link'),
                notes: fd.get('notes'),
            });
            closeRescheduleModal();
            showToast(data.message || 'Schedule updated.');
            setTimeout(() => window.location.reload(), 1000);
        } catch(err) {
            showToast(err.message, 'error');
        }
    });

    // ===== EVALUATION QUICK TEMPLATES =====
    const evalTemplates = {
        proceed: [
            "Candidate has very strong technical skills and relevant experience. Smooth communication and high enthusiasm. Recommended to proceed to the offer stage.",
            "Technical competency & core architecture skills are excellent. Structured thinking, good problem-solving ability, and fits the culture well. Recommended to proceed.",
            "Candidate shows outstanding initiative, a strong portfolio, and can answer problem-solving questions coherently and logically. Highly recommended."
        ],
        hold: [
            "Candidate has a reasonably good foundation but needs improvement in practical experience. Placed on hold for comparison with other candidates.",
            "Technical skills are adequate, but communication/soft skills could be improved. Placing on hold until other interviews are completed.",
            "Technically meets core qualifications, but salary expectation or start date still needs further negotiation."
        ],
        reject: [
            "Candidate's technical qualifications and understanding of basic concepts are still below the minimum standard required for this position.",
            "Experience and profile fit do not match the criteria sought for this position. Technical test results were unsatisfactory.",
            "Communication was less effective and the candidate had difficulty explaining their portfolio or previous projects in detail."
        ]
    };

    const recSelect = document.getElementById('evaluate-recommendation');
    const evalTemplatesList = document.getElementById('eval-templates-list');

    function populateEvalTemplates() {
        if (!recSelect || !evalTemplatesList) return;
        const val = recSelect.value || 'proceed';
        evalTemplatesList.innerHTML = '';
        const list = evalTemplates[val] || [];
        list.forEach(tpl => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'w-full text-left text-[11px] bg-white hover:bg-green-50/50 border border-gray-200 hover:border-green-300 rounded-lg p-2 text-gray-700 transition cursor-pointer font-medium leading-relaxed';
            btn.textContent = tpl;
            btn.addEventListener('click', () => {
                evalFeedback.value = tpl;
            });
            evalTemplatesList.appendChild(btn);
        });
    }

    if (recSelect) {
        recSelect.addEventListener('change', populateEvalTemplates);
    }

    // Status Modal
    const statusSelect = document.getElementById('status-select');
    const evalFields = document.getElementById('evaluation-fields');
    const notesField = document.getElementById('notes-field');
    const evalScore = document.getElementById('evaluate-score');
    const evalFeedback = document.getElementById('evaluate-feedback');

    function toggleEvalFields() {
        if (statusSelect.value === 'completed') {
            evalFields.classList.remove('hidden');
            notesField.classList.add('hidden');
            evalScore.required = true;
            evalFeedback.required = true;
        } else {
            evalFields.classList.add('hidden');
            notesField.classList.remove('hidden');
            evalScore.required = false;
            evalFeedback.required = false;
        }
    }

    statusSelect.addEventListener('change', toggleEvalFields);

    function openStatusModal(interview) {
        document.getElementById('status-id').value = interview.id;
        document.getElementById('status-application-id').value = interview.application_id;
        statusSelect.value = interview.status || 'scheduled';
        document.getElementById('status-notes').value = interview.notes || '';
        document.getElementById('status-candidate-name').textContent = interview.application?.user?.name || 'Candidate';
        
        // Populate eval fields if they exist
        if (interview.result) {
            evalScore.value = interview.result.score || '';
            document.getElementById('evaluate-recommendation').value = interview.result.recommendation || 'proceed';
            evalFeedback.value = interview.result.feedback || '';
        } else {
            evalScore.value = '';
            document.getElementById('evaluate-recommendation').value = 'proceed';
            evalFeedback.value = '';
        }
        document.getElementById('evaluate-attendance-status').value = interview.attendance_status || 'present';

        populateEvalTemplates();
        toggleEvalFields();
        document.getElementById('modal-status').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('modal-status').classList.add('hidden');
    }

    document.getElementById('form-status').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('status-id').value;
        const appId = document.getElementById('status-application-id').value;
        const status = statusSelect.value;
        const fd = new FormData(this);
        
        try {
            let url, payload;
            if (status === 'completed') {
                url = `/hr/pelamar/${appId}/interview/${id}/evaluate`;
                payload = {
                    score: fd.get('score'),
                    recommendation: fd.get('recommendation'),
                    feedback: fd.get('feedback'),
                    attendance_status: fd.get('attendance_status'),
                };
            } else {
                url = `/hr/wawancara/${id}/status`;
                payload = {
                    status: status,
                    notes: fd.get('notes'),
                };
            }

            const data = await submitJson(url, 'POST', payload);
            closeStatusModal();
            showToast(data.message || 'Status updated.');
            setTimeout(() => window.location.reload(), 1000);
        } catch(err) {
            showToast(err.message, 'error');
        }
    });

    // Delete Session
    async function deleteInterview(id) {
        if (!confirm('Are you sure you want to delete this interview session? This action cannot be undone.')) return;
        try {
            const data = await submitJson(`/hr/wawancara/${id}`, 'POST', {
                _method: 'DELETE'
            });
            showToast(data.message || 'Interview session deleted.');
            setTimeout(() => window.location.reload(), 1000);
        } catch(err) {
            showToast(err.message, 'error');
        }
    }
</script>

{{-- ===== MODAL: REVIEW RESCHEDULE REQUEST ===== --}}
<div id="modal-reschedule-review" class="fixed inset-0 z-[110] hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeRescheduleReviewModal()"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-2xl bg-white shadow-2xl flex flex-col overflow-y-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between px-8 py-6 border-b border-amber-100 bg-amber-50 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-200 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-amber-900">Review Reschedule Request</h2>
                    <p class="text-xs text-amber-600 mt-0.5" id="rr-candidate-subtitle">—</p>
                </div>
            </div>
            <button onclick="closeRescheduleReviewModal()" class="text-gray-400 hover:text-gray-600 bg-white border border-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="flex-1 px-8 py-6 space-y-6">

            {{-- Comparison: Current vs Proposed --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                    <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Original Schedule (HR)</p>
                    <p class="text-lg font-extrabold text-gray-900" id="rr-old-date">—</p>
                    <p class="text-sm text-gray-500" id="rr-old-time">—</p>
                    <span class="inline-block mt-2 text-[10px] font-bold px-2 py-0.5 rounded-full border bg-blue-50 text-blue-700 border-blue-200" id="rr-old-type">—</span>
                </div>
                <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-4">
                    <p class="text-[10px] font-extrabold text-amber-600 uppercase tracking-widest mb-2">Applicant Proposed</p>
                    <p class="text-lg font-extrabold text-amber-900" id="rr-proposed-date">—</p>
                    <p class="text-sm text-amber-700" id="rr-proposed-time">—</p>
                    <span class="inline-block mt-2 text-[10px] font-bold px-2 py-0.5 rounded-full border bg-amber-100 text-amber-700 border-amber-200" id="rr-proposed-type">—</span>
                </div>
            </div>

            {{-- Alasan dari Pelamar --}}
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Reschedule Reason from Applicant</p>
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 text-sm text-gray-700 leading-relaxed whitespace-pre-line" id="rr-reason">—</div>
            </div>

            {{-- Conflict Check Status --}}
            <div id="rr-conflict-status" class="hidden">
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-2">Schedule Conflict Status</p>
                <div id="rr-conflict-box" class="rounded-xl p-3 text-sm font-semibold flex items-center gap-2"></div>
            </div>

            <hr class="border-gray-100">

            {{-- Decision Tabs --}}
            <div>
                <p class="text-sm font-extrabold text-gray-800 mb-4">Select Decision:</p>
                <div class="flex gap-3 mb-6">
                    <button id="btn-decision-approve" onclick="switchDecision('approve')"
                            class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-green-200 bg-green-50 text-green-800 font-bold text-sm hover:bg-green-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Approve Reschedule
                    </button>
                    <button id="btn-decision-decline" onclick="switchDecision('decline')"
                            class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-red-200 bg-red-50 text-red-800 font-bold text-sm hover:bg-red-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Decline Request
                    </button>
                </div>

                {{-- Approve: edit schedule form --}}
                <div id="panel-approve" class="hidden space-y-4">
                    <p class="text-xs text-gray-500 bg-green-50 border border-green-100 rounded-lg p-3">
                        ✅ <strong>New Schedule</strong> will be confirmed with the applicant. You can adjust the proposed schedule or use a different time slot. The system will auto-check for conflicts.
                    </p>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Date</label>
                            <input type="date" id="rr-new-date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Hour</label>
                            <select id="rr-new-hour" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                @for($i = 7; $i <= 18; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Minute</label>
                            <select id="rr-new-minute" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                @for($i = 0; $i < 60; $i += 5)
                                    <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Duration (minutes)</label>
                            <select id="rr-new-duration" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60" selected>60 minutes</option>
                                <option value="90">90 minutes</option>
                                <option value="120">120 minutes</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                            <select id="rr-new-type" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                <option value="online">Online Meeting</option>
                                <option value="offline">On-site / Offline</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Location / Meeting Link</label>
                        <input type="text" id="rr-new-location" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                    </div>
                    {{-- Conflict live check --}}
                    <div id="rr-live-conflict" class="text-xs text-gray-400 italic flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                        Select a date to check for schedule conflicts automatically.
                    </div>
                </div>

                {{-- Decline: reason form --}}
                <div id="panel-decline" class="hidden space-y-4">
                    <p class="text-xs text-gray-500 bg-red-50 border border-red-100 rounded-lg p-3">
                        ❌ <strong>Original schedule remains active.</strong> The applicant will be notified that their reschedule request was declined and must attend the scheduled session.
                    </p>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Reason for Rejection (optional)</label>
                        <textarea id="rr-decline-reason" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400" placeholder="Example: The proposed schedule is not available. Please attend the original session."></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Action Buttons --}}
        <div class="shrink-0 px-8 py-5 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
            <button onclick="closeRescheduleReviewModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 font-semibold rounded-xl text-sm hover:bg-gray-100 transition-colors">
                Cancel
            </button>
            <button id="btn-submit-reschedule-review" onclick="submitRescheduleDecision()"
                    class="px-6 py-2.5 font-bold rounded-xl text-sm transition-colors flex items-center gap-2 bg-gray-200 text-gray-400 cursor-not-allowed" disabled>
                Confirm Decision
            </button>
        </div>
    </div>
</div>

<script>
    // ===== RESCHEDULE REVIEW MODAL =====
    let rrCurrentInterviewId = null;
    let rrCurrentDecision = null;

    function openRescheduleReviewModal(interview) {
        rrCurrentInterviewId = interview.id;
        rrCurrentDecision = null;

        // Fill header
        const candidateName = interview.application?.user?.name ?? 'Candidate';
        const jobTitle = interview.application?.job?.title ?? 'Position';
        document.getElementById('rr-candidate-subtitle').textContent = candidateName + ' — ' + jobTitle;

        // Fill comparison panel
        if (interview.scheduled_at) {
            const oldDate = new Date(interview.scheduled_at);
            document.getElementById('rr-old-date').textContent = oldDate.toLocaleDateString('en-US', {day:'2-digit', month:'long', year:'numeric'});
            document.getElementById('rr-old-time').textContent = oldDate.toLocaleTimeString('en-US', {hour:'2-digit', minute:'2-digit'}) + ' (' + interview.duration_minutes + ' minutes)';
        }
        document.getElementById('rr-old-type').textContent = interview.interview_type ? (interview.interview_type.charAt(0).toUpperCase() + interview.interview_type.slice(1)) : '—';

        if (interview.proposed_scheduled_at) {
            const propDate = new Date(interview.proposed_scheduled_at);
            document.getElementById('rr-proposed-date').textContent = propDate.toLocaleDateString('en-US', {day:'2-digit', month:'long', year:'numeric'});
            document.getElementById('rr-proposed-time').textContent = propDate.toLocaleTimeString('en-US', {hour:'2-digit', minute:'2-digit'});

            // Pre-fill the approve form with proposed values
            const yyyy = propDate.getFullYear();
            const mm = String(propDate.getMonth()+1).padStart(2,'0');
            const dd = String(propDate.getDate()).padStart(2,'0');
            document.getElementById('rr-new-date').value = `${yyyy}-${mm}-${dd}`;
            document.getElementById('rr-new-hour').value = String(propDate.getHours()).padStart(2,'0');
            document.getElementById('rr-new-minute').value = String(Math.floor(propDate.getMinutes()/5)*5).padStart(2,'0');
        } else {
            document.getElementById('rr-proposed-date').textContent = 'No proposal';
            document.getElementById('rr-proposed-time').textContent = '—';
        }

        if (interview.proposed_interview_type) {
            document.getElementById('rr-proposed-type').textContent = interview.proposed_interview_type.charAt(0).toUpperCase() + interview.proposed_interview_type.slice(1);
            document.getElementById('rr-new-type').value = interview.proposed_interview_type;
        } else {
            document.getElementById('rr-proposed-type').textContent = '—';
        }

        // Location
        document.getElementById('rr-new-location').value = interview.location_or_link || '';

        // Duration
        document.getElementById('rr-new-duration').value = interview.duration_minutes || 60;

        // Reason
        document.getElementById('rr-reason').textContent = interview.reschedule_reason || 'No reason provided.';

        // Reset UI state
        document.getElementById('rr-conflict-status').classList.add('hidden');
        document.getElementById('panel-approve').classList.add('hidden');
        document.getElementById('panel-decline').classList.add('hidden');
        document.getElementById('rr-decline-reason').value = '';
        document.getElementById('rr-live-conflict').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg> Select a date to check for schedule conflicts automatically.';
        resetDecisionButtons();

        // Add change listeners for conflict check
        ['rr-new-date','rr-new-hour','rr-new-minute','rr-new-duration'].forEach(id => {
            const el = document.getElementById(id);
            el.removeEventListener('change', rrCheckConflict);
            el.addEventListener('change', rrCheckConflict);
        });

        // Check conflict for proposed time immediately if available
        if (interview.proposed_scheduled_at) {
            setTimeout(rrCheckConflict, 300);
        }

        document.getElementById('modal-reschedule-review').classList.remove('hidden');
    }

    function closeRescheduleReviewModal() {
        document.getElementById('modal-reschedule-review').classList.add('hidden');
        rrCurrentInterviewId = null;
        rrCurrentDecision = null;
    }

    function switchDecision(decision) {
        rrCurrentDecision = decision;
        const approvePanel = document.getElementById('panel-approve');
        const declinePanel = document.getElementById('panel-decline');
        const btnApprove = document.getElementById('btn-decision-approve');
        const btnDecline = document.getElementById('btn-decision-decline');
        const submitBtn = document.getElementById('btn-submit-reschedule-review');

        if (decision === 'approve') {
            approvePanel.classList.remove('hidden');
            declinePanel.classList.add('hidden');
            btnApprove.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-green-600 bg-green-700 text-white font-bold text-sm transition-all';
            btnDecline.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-red-200 bg-red-50 text-red-800 font-bold text-sm hover:bg-red-100 transition-all';
            submitBtn.className = 'px-6 py-2.5 font-bold rounded-xl text-sm transition-colors flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white cursor-pointer';
            submitBtn.disabled = false;
            submitBtn.textContent = '✓ Approve & Confirm New Schedule';
        } else {
            declinePanel.classList.remove('hidden');
            approvePanel.classList.add('hidden');
            btnDecline.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-red-600 bg-red-700 text-white font-bold text-sm transition-all';
            btnApprove.className = 'flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-green-200 bg-green-50 text-green-800 font-bold text-sm hover:bg-green-100 transition-all';
            submitBtn.className = 'px-6 py-2.5 font-bold rounded-xl text-sm transition-colors flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white cursor-pointer';
            submitBtn.disabled = false;
            submitBtn.textContent = '✕ Decline Reschedule Request';
        }
    }

    function resetDecisionButtons() {
        const submitBtn = document.getElementById('btn-submit-reschedule-review');
        submitBtn.className = 'px-6 py-2.5 font-bold rounded-xl text-sm transition-colors flex items-center gap-2 bg-gray-200 text-gray-400 cursor-not-allowed';
        submitBtn.disabled = true;
        submitBtn.textContent = 'Confirm Decision';
        document.getElementById('btn-decision-approve').className = 'flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-green-200 bg-green-50 text-green-800 font-bold text-sm hover:bg-green-100 transition-all';
        document.getElementById('btn-decision-decline').className = 'flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-red-200 bg-red-50 text-red-800 font-bold text-sm hover:bg-red-100 transition-all';
    }

    async function rrCheckConflict() {
        const date = document.getElementById('rr-new-date').value;
        const hour = document.getElementById('rr-new-hour').value;
        const minute = document.getElementById('rr-new-minute').value;
        const duration = document.getElementById('rr-new-duration').value;

        if (!date || !hour || !minute) return;

        const scheduledAt = `${date} ${hour}:${minute}:00`;
        const liveEl = document.getElementById('rr-live-conflict');
        liveEl.innerHTML = '<span class="animate-pulse text-gray-400">Checking schedule conflicts...</span>';

        try {
            const resp = await fetch(`/hr/wawancara/booked-slots?date=${date}`, {
                headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
            });
            const data = await resp.json();

            if (!data.success) {
                liveEl.innerHTML = '<span class="text-gray-400">Unable to check conflict.</span>';
                return;
            }

            const newStart = new Date(`${date}T${hour}:${minute}:00`);
            const newEnd = new Date(newStart.getTime() + parseInt(duration) * 60000);
            let hasConflict = false;
            let conflictWith = '';

            (data.slots || []).forEach(slot => {
                if (slot.id == rrCurrentInterviewId) return; // exclude self
                const slotStart = new Date(`${date}T${slot.start_time}`);
                const slotEnd = new Date(`${date}T${slot.end_time}`);
                if (newStart < slotEnd && newEnd > slotStart) {
                    hasConflict = true;
                    conflictWith = `${slot.candidate} (${slot.start}–${slot.end})`;
                }
            });

            if (hasConflict) {
                liveEl.innerHTML = `<span class="text-red-600 font-semibold flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>⚠️ Conflict with schedule: <strong>${conflictWith}</strong>. Please select another time.</span>
                </span>`;
            } else {
                liveEl.innerHTML = `<span class="text-green-700 font-semibold flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Schedule safe — no conflict at this time.</span>
                </span>`;
            }
        } catch(e) {
            liveEl.innerHTML = '<span class="text-gray-400">Failed to check conflict.</span>';
        }
    }

    async function submitRescheduleDecision() {
        if (!rrCurrentInterviewId || !rrCurrentDecision) return;

        const submitBtn = document.getElementById('btn-submit-reschedule-review');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';

        // Map JS values ('approve'/'decline') to controller values ('approved'/'declined')
        const decisionMap = { approve: 'approved', decline: 'declined' };
        const mappedDecision = decisionMap[rrCurrentDecision] || rrCurrentDecision;

        let payload = {
            decision: mappedDecision,
            _token: document.querySelector('meta[name="csrf-token"]').content,
        };

        if (mappedDecision === 'approved') {
            const date = document.getElementById('rr-new-date').value;
            const hour = document.getElementById('rr-new-hour').value;
            const minute = document.getElementById('rr-new-minute').value;
            if (!date || !hour) {
                showToast('Complete date and time of the new schedule.', 'error');
                submitBtn.disabled = false;
                switchDecision('approve');
                return;
            }
            payload.scheduled_at      = `${date} ${hour}:${minute}:00`;
            payload.duration_minutes  = document.getElementById('rr-new-duration').value;
            payload.interview_type    = document.getElementById('rr-new-type').value;
            payload.location_or_link  = document.getElementById('rr-new-location').value;
        } else {
            payload.decline_reason = document.getElementById('rr-decline-reason').value;
        }

        try {
            const resp = await fetch(`/hr/wawancara/${rrCurrentInterviewId}/reschedule-decision`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(payload),
            });
            const data = await resp.json();
            if (!data.success) throw new Error(data.message || 'Failed to process.');
            closeRescheduleReviewModal();
            showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 1200);
        } catch(err) {
            showToast(err.message, 'error');
            submitBtn.disabled = false;
            if (rrCurrentDecision === 'approve') {
                submitBtn.textContent = '✓ Approve & Confirm New Schedule';
            } else {
                submitBtn.textContent = '✕ Decline Reschedule Request';
            }
        }
    }
    // ===== CENTRAL LOCATION TEMPLATES SYSTEM =====
    const defaultLocationTemplates = [
        { name: 'Google Meet (HR Room 1)', type: 'online', value: 'https://meet.google.com/abc-defg-hij' },
        { name: 'Zoom Meeting (Ecogreen)', type: 'online', value: 'https://zoom.us/j/9876543210' },
        { name: 'HQ Batam (Main Office)', type: 'offline', value: 'Ruko Eco Green Block A No. 12, Batam Center (https://maps.app.goo.gl/default1)' },
        { name: 'Branch Office Jakarta', type: 'offline', value: 'Sudirman Tower Lt. 15, Jakarta Selatan (https://maps.app.goo.gl/default2)' }
    ];

    const getLocTemplates = () => {
        const stored = localStorage.getItem('interview_location_templates');
        if (!stored) {
            localStorage.setItem('interview_location_templates', JSON.stringify(defaultLocationTemplates));
            return defaultLocationTemplates;
        }
        return JSON.parse(stored);
    };

    const saveLocTemplates = (templates) => {
        localStorage.setItem('interview_location_templates', JSON.stringify(templates));
    };

    const populateCentralLocationTemplatesSummary = () => {
        const listContainer = document.getElementById('central-loc-templates-list');
        if (!listContainer) return;
        const templates = getLocTemplates();
        listContainer.innerHTML = '';
        if (templates.length === 0) {
            listContainer.innerHTML = '<span class="text-[10px] text-gray-400 italic">No templates defined.</span>';
            return;
        }
        templates.forEach(tpl => {
            const item = document.createElement('div');
            item.className = 'p-2 bg-gray-50 border border-gray-150 rounded-xl text-xs flex flex-col gap-0.5 hover:bg-gray-100/60 transition shadow-sm';
            item.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="font-bold text-gray-800 truncate max-w-[120px]">${tpl.name}</span>
                    <span class="text-[8px] font-extrabold px-1.5 py-0.5 rounded uppercase ${tpl.type === 'online' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-purple-50 text-purple-700 border border-purple-100'}">${tpl.type}</span>
                </div>
                <div class="text-[10px] text-gray-400 truncate" title="${tpl.value}">${tpl.value}</div>
            `;
            listContainer.appendChild(item);
        });
    };

    let editingTemplateIdx = -1;

    const setFormMode = (mode, tpl = null, idx = -1) => {
        const nameInput   = document.getElementById('central-new-name');
        const typeSelect  = document.getElementById('central-new-type');
        const valInput    = document.getElementById('central-new-val');
        const addBtn      = document.getElementById('btn-central-add-template');
        const cancelBtn   = document.getElementById('btn-central-cancel-edit');
        const formTitle   = document.getElementById('central-form-title');

        if (mode === 'edit' && tpl) {
            editingTemplateIdx = idx;
            nameInput.value   = tpl.name;
            typeSelect.value  = tpl.type;
            valInput.value    = tpl.value;
            addBtn.textContent = 'Update Template';
            addBtn.classList.replace('bg-green-800', 'bg-blue-700');
            addBtn.classList.replace('hover:bg-green-900', 'hover:bg-blue-800');
            cancelBtn.classList.remove('hidden');
            formTitle.textContent = 'Edit Template';
            nameInput.focus();
        } else {
            editingTemplateIdx = -1;
            nameInput.value   = '';
            typeSelect.value  = 'online';
            valInput.value    = '';
            addBtn.textContent = 'Add Template';
            addBtn.classList.replace('bg-blue-700', 'bg-green-800');
            addBtn.classList.replace('hover:bg-blue-800', 'hover:bg-green-900');
            cancelBtn.classList.add('hidden');
            formTitle.textContent = 'Create New Template';
        }
    };

    const populateCentralLocEditorList = () => {
        const editorList = document.getElementById('central-loc-editor-list');
        if (!editorList) return;

        const templates = getLocTemplates();
        editorList.innerHTML = '';

        if (templates.length === 0) {
            editorList.innerHTML = '<p class="text-xs text-gray-400 italic py-2 text-center bg-gray-50 rounded-xl">No templates configured.</p>';
            return;
        }

        templates.forEach((tpl, idx) => {
            const row = document.createElement('div');
            row.className = 'flex items-center justify-between gap-2 p-2.5 bg-white border border-gray-150 rounded-xl text-xs shadow-sm hover:border-gray-300 transition';
            
            row.innerHTML = `
                <div class="truncate flex-1">
                    <span class="font-bold text-gray-800">${tpl.name}</span>
                    <span class="text-[8px] font-extrabold px-1.5 py-0.5 rounded border ml-1.5 uppercase ${tpl.type === 'online' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-purple-50 text-purple-700 border-purple-100'}">${tpl.type}</span>
                    <div class="text-[10px] text-gray-400 truncate mt-0.5" title="${tpl.value}">${tpl.value}</div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" class="btn-edit-tpl text-blue-500 hover:text-blue-700 p-1.5 hover:bg-blue-50 rounded-lg transition" data-idx="${idx}" title="Edit">✏️</button>
                    <button type="button" class="btn-delete-tpl text-red-500 hover:text-red-700 p-1.5 hover:bg-red-50 rounded-lg transition font-bold" data-idx="${idx}" title="Delete">✕</button>
                </div>
            `;

            row.querySelector('.btn-edit-tpl').addEventListener('click', function() {
                const i = parseInt(this.dataset.idx, 10);
                const current = getLocTemplates();
                setFormMode('edit', current[i], i);
            });

            row.querySelector('.btn-delete-tpl').addEventListener('click', function() {
                const i = parseInt(this.dataset.idx, 10);
                if (confirm('Delete this template?')) {
                    const current = getLocTemplates();
                    current.splice(i, 1);
                    saveLocTemplates(current);
                    setFormMode('add');
                    populateCentralLocationTemplatesSummary();
                    populateCentralLocEditorList();
                    populateModalTemplateSelects();
                }
            });

            editorList.appendChild(row);
        });
    };

    window.openCentralLocTemplateModal = () => {
        document.getElementById('modal-central-loc-templates').classList.remove('hidden');
        populateCentralLocEditorList();
    };

    window.closeCentralLocTemplateModal = () => {
        document.getElementById('modal-central-loc-templates').classList.add('hidden');
    };

    // Add / Update template handler
    const btnAddTpl = document.getElementById('btn-central-add-template');
    if (btnAddTpl) {
        btnAddTpl.addEventListener('click', () => {
            const nameInput  = document.getElementById('central-new-name');
            const typeSelect = document.getElementById('central-new-type');
            const valInput   = document.getElementById('central-new-val');

            const name  = nameInput.value.trim();
            const type  = typeSelect.value;
            const value = valInput.value.trim();

            if (!name || !value) {
                alert('Please fill in all template fields.');
                return;
            }

            const current = getLocTemplates();

            if (editingTemplateIdx >= 0) {
                current[editingTemplateIdx] = { name, type, value };
            } else {
                current.push({ name, type, value });
            }

            saveLocTemplates(current);
            setFormMode('add');
            populateCentralLocationTemplatesSummary();
            populateCentralLocEditorList();
            populateModalTemplateSelects();
        });
    }

    // Cancel edit handler
    const btnCancelEdit = document.getElementById('btn-central-cancel-edit');
    if (btnCancelEdit) {
        btnCancelEdit.addEventListener('click', () => setFormMode('add'));
    }

    // Modal template select dropdown population logic
    const populateModalTemplateSelects = () => {
        const templates = getLocTemplates();
        
        // 1. Buat Modal templates
        const buatTypeSelect = document.getElementById('buat_interview_type');
        const buatTemplateSelect = document.getElementById('buat_template_select');
        const buatLocInput = document.getElementById('buat_location_or_link');

        if (buatTypeSelect && buatTemplateSelect) {
            const selectedType = buatTypeSelect.value;
            buatTemplateSelect.innerHTML = '<option value="">-- Choose Template --</option>';
            templates.filter(t => t.type === selectedType).forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.value;
                opt.textContent = t.name;
                buatTemplateSelect.appendChild(opt);
            });
        }

        // 2. Reschedule Modal templates
        const rescheduleTypeSelect = document.getElementById('reschedule-type');
        const rescheduleTemplateSelect = document.getElementById('reschedule_template_select');
        const rescheduleLocInput = document.getElementById('reschedule-location');

        if (rescheduleTypeSelect && rescheduleTemplateSelect) {
            const selectedType = rescheduleTypeSelect.value;
            rescheduleTemplateSelect.innerHTML = '<option value="">-- Choose Template --</option>';
            templates.filter(t => t.type === selectedType).forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.value;
                opt.textContent = t.name;
                rescheduleTemplateSelect.appendChild(opt);
            });
        }
    };

    // Listeners for select templates selection changes
    const buatTypeSelect = document.getElementById('buat_interview_type');
    const buatTemplateSelect = document.getElementById('buat_template_select');
    const buatLocInput = document.getElementById('buat_location_or_link');

    if (buatTypeSelect) {
        buatTypeSelect.addEventListener('change', () => {
            populateModalTemplateSelects();
            if (buatLocInput) buatLocInput.value = '';
        });
    }
    if (buatTemplateSelect && buatLocInput) {
        buatTemplateSelect.addEventListener('change', () => {
            if (buatTemplateSelect.value) {
                buatLocInput.value = buatTemplateSelect.value;
            }
        });
    }

    const rescheduleTypeSelect = document.getElementById('reschedule-type');
    const rescheduleTemplateSelect = document.getElementById('reschedule_template_select');
    const rescheduleLocInput = document.getElementById('reschedule-location');

    if (rescheduleTypeSelect) {
        rescheduleTypeSelect.addEventListener('change', () => {
            populateModalTemplateSelects();
            if (rescheduleLocInput) rescheduleLocInput.value = '';
        });
    }
    if (rescheduleTemplateSelect && rescheduleLocInput) {
        rescheduleTemplateSelect.addEventListener('change', () => {
            if (rescheduleTemplateSelect.value) {
                rescheduleLocInput.value = rescheduleTemplateSelect.value;
            }
        });
    }

    // Override openRescheduleModal to pre-populate and set templates dropdown correctly
    const originalOpenRescheduleModal = window.openRescheduleModal;
    window.openRescheduleModal = function(interview) {
        if (originalOpenRescheduleModal) originalOpenRescheduleModal(interview);
        
        // Now sync templates selector
        setTimeout(() => {
            populateModalTemplateSelects();
            // Pre-select matching template if exact value matches
            if (rescheduleTemplateSelect && rescheduleLocInput) {
                rescheduleTemplateSelect.value = '';
                Array.from(rescheduleTemplateSelect.options).forEach(opt => {
                    if (opt.value === rescheduleLocInput.value) {
                        rescheduleTemplateSelect.value = opt.value;
                    }
                });
            }
        }, 100);
    };

    // Override openScheduleModal to sync templates
    const originalOpenScheduleModal = window.openScheduleModal;
    window.openScheduleModal = function() {
        if (originalOpenScheduleModal) originalOpenScheduleModal();
        populateModalTemplateSelects();
        if (buatLocInput) buatLocInput.value = '';
        if (buatTemplateSelect) buatTemplateSelect.value = '';
    };

    // Initial loading
    populateCentralLocationTemplatesSummary();
    populateModalTemplateSelects();
</script>

<!-- Modal: Central Location Templates Manager -->
<div id="modal-central-loc-templates" class="fixed inset-0 z-[120] hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeCentralLocTemplateModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-150 max-w-lg w-full overflow-hidden animate-card">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-extrabold text-lg text-gray-950">Manage Location Templates</h3>
                    <p class="text-xs text-gray-500 font-semibold mt-0.5">Define pre-configured addresses or online meeting links</p>
                </div>
                <button type="button" onclick="closeCentralLocTemplateModal()" class="text-gray-400 hover:text-gray-600 bg-gray-100 rounded-full p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Current Templates List -->
                <div>
                    <span class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Configured Templates</span>
                    <div id="central-loc-editor-list" class="space-y-2 max-h-56 overflow-y-auto pr-1">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Add / Edit Template Section -->
                <div class="border-t border-gray-200 pt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span id="central-form-title" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Create New Template</span>
                        <button type="button" id="btn-central-cancel-edit" class="hidden text-[10px] text-gray-500 hover:text-gray-700 font-bold px-2 py-1 rounded-lg hover:bg-gray-100 transition">✕ Cancel Edit</button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase mb-1">Template Name</label>
                            <input type="text" id="central-new-name" placeholder="e.g. Zoom Room A" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-gray-400 uppercase mb-1">Interview Type</label>
                            <select id="central-new-type" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-gray-400 uppercase mb-1">Location Value (Link / Address)</label>
                        <input type="text" id="central-new-val" placeholder="e.g. Ruko Eco Green or https://zoom.us/..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    </div>
                    <button type="button" id="btn-central-add-template" class="w-full bg-green-800 hover:bg-green-900 text-white text-xs font-bold py-2 rounded-lg transition shadow-md">Add Template</button>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button type="button" onclick="closeCentralLocTemplateModal()" class="bg-white border border-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-xs hover:bg-gray-50 transition-colors shadow-sm">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
