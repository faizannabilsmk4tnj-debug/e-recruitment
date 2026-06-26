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
        'offline' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14"/><path d="M4 19h16"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>',
        'phone' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>'
    ];

    $typeLabels = [
        'online' => 'Online Meeting',
        'offline' => 'On-site Office',
        'phone' => 'Phone Call'
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
            <a href="/hr/wawancara" class="bg-white border border-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Calendar View
            </a>
        </div>
    </div>

    <!-- Date Navigation Widget (Only when date is filtered) -->
    @if(request('date'))
        @php
            try {
                $selectedDate = \Carbon\Carbon::parse(request('date'));
                $prevDate = (clone $selectedDate)->subDay()->toDateString();
                $nextDate = (clone $selectedDate)->addDay()->toDateString();
                $formattedSelected = $selectedDate->translatedFormat('d F Y');
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
                        <option value="phone" @selected(request('type') === 'phone')>Phone Call</option>
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
                        'cancelled' => 'text-red-700 bg-red-50 border border-red-200'
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
                                <span class="w-1.5 h-1.5 rounded-full {{ $interview->status === 'scheduled' ? 'bg-green-500' : ($interview->status === 'completed' ? 'bg-emerald-500' : 'bg-red-500') }}"></span>
                                {{ strtoupper($interview->status) }}
                            </span>
                            @if($interview->attendance_status === 'present')
                                <span class="text-[9px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded w-fit flex items-center gap-1 text-left" title="Absen pada: {{ $interview->attendance_confirmed_at ? $interview->attendance_confirmed_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') : '' }} WIB">
                                    <svg class="w-2.5 h-2.5 text-emerald-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Hadir ({{ $interview->attendance_confirmed_at ? $interview->attendance_confirmed_at->setTimezone('Asia/Jakarta')->format('H:i') : '' }})
                                </span>
                                @if($interview->attendance_photo)
                                    <a href="{{ $interview->attendance_photo }}" target="_blank" class="text-[9px] font-bold text-green-700 hover:text-green-800 underline flex items-center gap-1 mt-0.5 w-fit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                        Foto Selfie
                                    </a>
                                @endif
                            @elseif($interview->attendance_status === 'absent')
                                <span class="text-[9px] font-bold text-red-800 bg-red-50 border border-red-100 px-1.5 py-0.5 rounded w-fit">
                                    Absen (Tidak Hadir)
                                </span>
                            @else
                                <span class="text-[9px] font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded w-fit">
                                    Belum Absen
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
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Diterima (Tidak bisa diinteraksi)">
                                    Profile
                                </span>
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Diterima (Tidak bisa diinteraksi)">
                                    Reschedule
                                </span>
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Diterima (Tidak bisa diinteraksi)">
                                    Status / Evaluasi
                                </span>
                                <span class="text-gray-400 font-semibold text-xs bg-gray-100 px-2 py-1 rounded cursor-not-allowed select-none" title="Diterima (Tidak bisa diinteraksi)">
                                    Delete
                                </span>
                            @else
                                <a href="/hr/pelamar/{{ $interview->application_id }}" class="text-green-800 hover:text-green-950 font-semibold text-xs bg-green-50 hover:bg-green-100 px-2 py-1 rounded transition-colors" title="View Profile">
                                    Profile
                                </a>
                                <button onclick='openRescheduleModal(@json($interview))' class="text-blue-800 hover:text-blue-950 font-semibold text-xs bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded transition-colors" title="Reschedule">
                                    Reschedule
                                </button>
                                <button onclick='openStatusModal(@json($interview))' class="text-amber-800 hover:text-amber-950 font-semibold text-xs bg-amber-50 hover:bg-amber-100 px-2 py-1 rounded transition-colors" title="Status & Evaluasi">
                                    Status / Evaluasi
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

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                        Jadwal Wawancara Terisi Hari Ini:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5" id="buat_booked_slots_list">
                    </ul>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                    <select name="interview_type" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="online" selected>Online Meeting</option>
                        <option value="offline">On-site / Offline</option>
                        <option value="phone">Phone Call</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Location / Meeting Link</label>
                    <input name="location_or_link" type="text" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Catatan..."></textarea>
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
                        Jadwal Wawancara Terisi Hari Ini:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5" id="reschedule_booked_slots_list">
                    </ul>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                    <select name="interview_type" id="reschedule-type" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="online">Online Meeting</option>
                        <option value="offline">On-site / Offline</option>
                        <option value="phone">Phone Call</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Location / Meeting Link</label>
                    <input name="location_or_link" id="reschedule-location" type="text" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Notes</label>
                    <textarea name="notes" id="reschedule-notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Catatan..."></textarea>
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
                <h2 class="text-2xl font-extrabold text-green-900">Update Status & Evaluasi</h2>
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
                                <option value="proceed">Proceed (Lanjut)</option>
                                <option value="hold">Hold (Ditangguhkan)</option>
                                <option value="reject">Reject (Tolak)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Candidate Attendance</label>
                        <select name="attendance_status" id="evaluate-attendance-status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="pending">Pending (Belum Absen)</option>
                            <option value="present" selected>Hadir (Present)</option>
                            <option value="absent">Tidak Hadir (Absent)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Feedback & Assessment Notes</label>
                        
                        {{-- Quick Templates Selection --}}
                        <div id="eval-templates-container" class="mb-3">
                            <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Pilih Template Feedback:</span>
                            <div class="flex flex-col gap-1.5 max-h-36 overflow-y-auto p-2 bg-gray-50 border border-gray-150 rounded-xl" id="eval-templates-list">
                                <!-- populated by JS based on recommendation -->
                            </div>
                        </div>

                        <textarea name="feedback" id="evaluate-feedback" rows="4" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tulis feedback wawancara secara mendalam..."></textarea>
                    </div>
                </div>

                <div id="notes-field">
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Feedback / Notes</label>
                    <textarea name="notes" id="status-notes" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tulis masukan atau catatan hasil interview..."></textarea>
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
                opt.title = `Sudah dibooking untuk interview ${booking.candidate} (${booking.job}) pada pukul ${booking.start} - ${booking.end}`;
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
                    opt.title = `Sudah dibooking untuk interview ${booking.candidate} (${booking.job}) pada pukul ${booking.start} - ${booking.end}`;
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
            warning.innerHTML = `⚠️ Waktu yang dipilih bentrok dengan interview <strong>${booking.candidate}</strong> (${booking.job}) pada pukul <strong>${booking.start} - ${booking.end}</strong>. Silakan pilih jam atau durasi lain.`;
            
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
            "Kandidat memiliki skill teknis yang sangat kuat dan pengalaman yang relevan. Komunikasi lancar dan antusiasme tinggi. Direkomendasikan untuk lanjut ke tahap penawaran.",
            "Technical competency & core architecture skills are excellent. Structured thinking, good problem-solving ability, and fits the culture well. Recommended to proceed.",
            "Kandidat menunjukkan inisiatif luar biasa, portofolio kuat, dan mampu menjawab pertanyaan problem-solving dengan runut dan logis. Sangat direkomendasikan."
        ],
        hold: [
            "Kandidat memiliki dasar yang cukup baik, namun perlu peningkatan dalam pengalaman praktis. Ditangguhkan untuk perbandingan dengan kandidat lain.",
            "Technical skills are adequate, but communication/soft skills could be improved. Placing on hold until other interviews are completed.",
            "Secara teknis memenuhi kualifikasi dasar, namun ekspektasi gaji atau tanggal mulai kerja masih perlu dinegosiasikan lebih lanjut."
        ],
        reject: [
            "Kualifikasi teknis dan pemahaman konsep dasar kandidat masih di bawah standar minimum yang dibutuhkan untuk posisi ini.",
            "Pengalaman dan kecocokan profil kurang sesuai dengan kriteria yang dicari pada posisi ini. Hasil tes teknis kurang memuaskan.",
            "Komunikasi kurang efektif dan kandidat kesulitan menjelaskan portofolio atau proyek sebelumnya secara mendetail."
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
@endsection
