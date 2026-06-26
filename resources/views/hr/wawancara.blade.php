@extends('layouts.hr')

@section('title', 'Interview Schedule')
@section('page-title', 'Interview Calendar')
@section('nav-wawancara', 'text-green-800 border-green-700 font-semibold')

@section('css')
<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection

@php
    $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $currentMonthName = $monthNames[$month - 1];
@endphp

@section('content')
<div class="px-8 py-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-green-900">Interview Schedule</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor and manage all candidate interview schedules in calendar view.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- New Month Selector Dropdown (Jan - Dec) -->
            <div class="relative">
                <button id="btn-select-month" class="bg-white border border-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <span id="label-select-month-btn">{{ $currentMonthName }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div id="dropdown-select-month" class="absolute right-0 top-full mt-2 w-44 bg-white border border-gray-100 rounded-xl shadow-lg hidden z-50 py-1 max-h-60 overflow-y-auto">
                    @foreach($monthNames as $index => $mName)
                    <button class="dropdown-item-select-month w-full text-left px-4 py-2 text-sm {{ ($index + 1) == $month ? 'font-bold text-green-800 bg-green-50' : 'text-gray-700' }} hover:bg-green-50 hover:text-green-800 transition-colors" data-val="{{ $mName }}" data-index="{{ $index + 1 }}">{{ $mName }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Bulan Dropdown -->
            <div class="relative">
                <button id="btn-bulan" class="bg-white border border-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <span id="label-bulan-btn">This Month</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div id="dropdown-bulan" class="absolute right-0 top-full mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-lg hidden z-50 py-1">
                    <button class="dropdown-item-bulan w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 transition-colors" data-val="Last Month">Last Month</button>
                    <button class="dropdown-item-bulan w-full text-left px-4 py-2 text-sm font-bold text-green-800 bg-green-50 transition-colors" data-val="This Month">This Month</button>
                    <button class="dropdown-item-bulan w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 transition-colors" data-val="Next Month">Next Month</button>
                </div>
            </div>

            <a href="/hr/wawancara/daftar" class="bg-green-800 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-900 transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                List View
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Calendar Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Mini Calendar -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-900 calendar-month-title">{{ $currentMonthName }} {{ $year }}</h3>
                    <div class="flex gap-1">
                        <button class="btn-prev-month text-gray-400 hover:text-green-700 transition"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg></button>
                        <button class="btn-next-month text-gray-400 hover:text-green-700 transition"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7-7" /></svg></button>
                    </div>
                </div>
                <div class="grid grid-cols-7 text-center text-[10px] font-bold text-gray-400 mb-2">
                    <div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div><div>S</div>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-700">
                    {{-- Empty days/Prev Month days --}}
                    @for($i = $emptyDaysBefore; $i > 0; $i--)
                        @php $prevDayVal = $daysInPrevMonth - $i + 1; @endphp
                        <div class="text-gray-300 py-1">{{ $prevDayVal }}</div>
                    @endfor
                    
                    {{-- Actual days --}}
                    @for($i = 1; $i <= $daysInMonth; $i++)
                        @php
                            $isToday = ($i == now()->day && $month == now()->month && $year == now()->year);
                            $hasEvent = isset($interviews[$i]) && $interviews[$i]->count() > 0;
                        @endphp
                        <div class="py-1 rounded-full cursor-pointer {{ $isToday ? 'bg-green-600 text-white font-bold shadow-sm' : ($hasEvent ? 'bg-green-100 text-green-900 font-bold border border-green-200' : 'hover:bg-green-50 hover:text-green-800') }}"
                             onclick="window.location.href='/hr/wawancara/daftar?date={{ $year }}-{{ sprintf('%02d', $month) }}-{{ sprintf('%02d', $i) }}'">
                            {{ $i }}
                        </div>
                    @endfor
                    
                    {{-- Next Month days --}}
                    @for($i = 1; $i <= $emptyDaysAfter; $i++)
                        <div class="text-gray-300 py-1">{{ $i }}</div>
                    @endfor
                </div>
            </div>

            <!-- Legends -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Interview Type</h3>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-sm border border-white"></div>
                        <span class="text-sm font-semibold text-gray-700">Online Meeting</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-purple-500 shadow-sm border border-white"></div>
                        <span class="text-sm font-semibold text-gray-700">On-site / Offline</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-amber-500 shadow-sm border border-white"></div>
                        <span class="text-sm font-semibold text-gray-700">Phone Call</span>
                    </li>
                </ul>
            </div>

            <!-- Upcoming Events List -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Coming Up</h3>
                <div class="space-y-4">
                    @forelse($comingUpInterviews as $interview)
                    @php
                        $borderClasses = [
                            'online' => 'bg-blue-500',
                            'offline' => 'bg-purple-500',
                            'phone' => 'bg-amber-500',
                        ];
                        $typeLabels = [
                            'online' => 'Online Meeting',
                            'offline' => 'On-site Office',
                            'phone' => 'Phone Call',
                        ];
                        $borderClass = $borderClasses[$interview->interview_type] ?? 'bg-gray-500';
                        $typeLabel = $typeLabels[$interview->interview_type] ?? ucfirst($interview->interview_type);
                        
                        $scheduledTime = $interview->scheduled_at;
                        $timeStr = '';
                        if ($scheduledTime->isToday()) {
                            $timeStr = 'Today, ' . $scheduledTime->format('H:i') . ' - ' . (clone $scheduledTime)->addMinutes($interview->duration_minutes)->format('H:i');
                        } elseif ($scheduledTime->isTomorrow()) {
                            $timeStr = 'Tomorrow, ' . $scheduledTime->format('H:i') . ' - ' . (clone $scheduledTime)->addMinutes($interview->duration_minutes)->format('H:i');
                        } else {
                            $timeStr = $scheduledTime->format('d M, H:i') . ' - ' . (clone $scheduledTime)->addMinutes($interview->duration_minutes)->format('H:i');
                        }
                        $isAccepted = $interview->application && $interview->application->status === 'accepted';
                    @endphp
                    <div class="flex gap-3 {{ $isAccepted ? 'opacity-50 grayscale cursor-not-allowed' : 'cursor-pointer hover:bg-gray-50' }} p-1.5 rounded-lg transition-colors" 
                         @if($isAccepted) onclick="event.stopPropagation();" @else onclick="window.location.href='/hr/wawancara/daftar?search={{ urlencode($interview->application->user->name ?? 'Candidate') }}'" @endif>
                        <div class="w-1.5 {{ $isAccepted ? 'bg-gray-400' : $borderClass }} rounded-full shrink-0"></div>
                        <div>
                            <div class="text-xs text-gray-500 font-bold mb-0.5">{{ $timeStr }}</div>
                            <div class="text-sm font-bold text-gray-900">{{ $interview->application->user->name ?? 'Candidate' }} {{ $isAccepted ? '(Accepted)' : '' }}</div>
                            <div class="text-[11px] text-gray-500 mt-1">{{ $typeLabel }} • {{ $interview->location_or_link ?? 'No Link/Location' }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 font-medium">No upcoming interviews.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Calendar Layout -->
        <div class="lg:col-span-3 bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden flex flex-col h-full min-h-[600px]">
            <!-- Calendar Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-4">
                    <button class="btn-prev-month p-1.5 text-gray-400 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <h2 class="text-xl font-bold text-gray-900 calendar-month-title">{{ $currentMonthName }} {{ $year }}</h2>
                    <button class="btn-next-month p-1.5 text-gray-400 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7-7" /></svg>
                    </button>
                </div>
                <div class="flex items-center bg-gray-200/60 rounded-lg p-1">
                    <button id="tab-minggu" onclick="window.location.href='/hr/wawancara/daftar'" class="px-4 py-1.5 text-xs font-bold text-gray-500 rounded-md hover:text-gray-900 transition-colors">List View</button>
                    <button id="tab-bulan" class="px-4 py-1.5 text-xs font-bold text-green-900 bg-white shadow-sm rounded-md transition-colors">Month</button>
                </div>
            </div>

            <!-- Days of Week -->
            <div class="grid grid-cols-7 border-b border-gray-100 bg-white">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                <div class="py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $day }}</div>
                @endforeach
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 auto-rows-fr bg-gray-100 gap-px flex-1">
                <!-- Empty days from prev month -->
                @for($i = $emptyDaysBefore; $i > 0; $i--)
                    @php $prevDayVal = $daysInPrevMonth - $i + 1; @endphp
                    <div class="bg-gray-50/40 p-2"><span class="text-xs font-bold text-gray-300">{{ $prevDayVal }}</span></div>
                @endfor
                
                <!-- Actual days -->
                @for($i = 1; $i <= $daysInMonth; $i++)
                @php
                    $dayInterviews = $interviews[$i] ?? collect();
                    $hasEvent = $dayInterviews->count() > 0;
                    $isToday = ($i == now()->day && $month == now()->month && $year == now()->year);
                    $formattedDate = sprintf('%04d-%02d-%02d', $year, $month, $i);
                @endphp
                <div class="bg-white p-2 flex flex-col group hover:bg-gray-50/80 transition-colors relative cursor-pointer min-h-[120px] select-none"
                     onclick="window.location.href='/hr/wawancara/daftar?date={{ $formattedDate }}'">
                    
                    <span class="text-xs font-bold mb-1 {{ $isToday ? 'bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-sm font-extrabold' : 'text-gray-700 w-6 h-6 flex items-center justify-center' }}">{{ $i }}</span>
                    
                    <div class="space-y-1.5 overflow-y-auto hide-scrollbar flex-1">
                        @foreach($dayInterviews as $interview)
                        @php
                            $colorClasses = [
                                'online' => 'bg-blue-50 border-blue-100 border-l-blue-500 text-blue-700',
                                'offline' => 'bg-purple-50 border-purple-100 border-l-purple-500 text-purple-700',
                                'phone' => 'bg-amber-50 border-amber-100 border-l-amber-500 text-amber-700',
                            ];
                            $typeLabels = [
                                'online' => 'Online',
                                'offline' => 'Offline',
                                'phone' => 'Phone',
                            ];
                            $colorClass = $colorClasses[$interview->interview_type] ?? 'bg-gray-50 border-gray-100 border-l-gray-500 text-gray-700';
                            $typeLabel = $typeLabels[$interview->interview_type] ?? ucfirst($interview->interview_type);
                            $candidateName = $interview->application->user->name ?? 'Candidate';
                            
                            $nameParts = explode(' ', trim($candidateName));
                            $shortName = $nameParts[0];
                            if (count($nameParts) > 1) {
                                $shortName .= ' ' . substr($nameParts[1], 0, 1) . '.';
                            }
                            $isAccepted = $interview->application && $interview->application->status === 'accepted';
                        @endphp
                        <div class="border border-l-2 {{ $isAccepted ? 'opacity-50 grayscale bg-gray-100 text-gray-400 border-gray-300 pointer-events-none' : $colorClass }} text-[10px] px-2 py-1.5 rounded truncate font-semibold" 
                             title="{{ $candidateName }} - {{ $typeLabel }} Interview {{ $isAccepted ? '(Accepted)' : '' }}"
                             @if($isAccepted)
                                 onclick="event.stopPropagation();"
                             @else
                                 onclick="event.stopPropagation(); window.location.href='/hr/wawancara/daftar?search={{ urlencode($candidateName) }}'"
                             @endif>
                            <span class="block text-[9px] mb-0.5 font-bold opacity-60">{{ $interview->scheduled_at->format('H:i') }}</span>
                            {{ $shortName }} ({{ $typeLabel }})
                        </div>
                        @endforeach
                    </div>
                </div>
                @endfor
                
                <!-- Next month leading days -->
                @for($i = 1; $i <= $emptyDaysAfter; $i++)
                    <div class="bg-gray-50/40 p-2"><span class="text-xs font-bold text-gray-300">{{ $i }}</span></div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Dropdowns
        const btnBulan = document.getElementById('btn-bulan');
        const dropdownBulan = document.getElementById('dropdown-bulan');
        const labelBulanBtn = document.getElementById('label-bulan-btn');

        const btnSelectMonth = document.getElementById('btn-select-month');
        const dropdownSelectMonth = document.getElementById('dropdown-select-month');
        const labelSelectMonthBtn = document.getElementById('label-select-month-btn');

        function closeAllDropdowns() {
            if (dropdownBulan) dropdownBulan.classList.add('hidden');
            if (dropdownSelectMonth) dropdownSelectMonth.classList.add('hidden');
        }

        if (btnBulan) {
            btnBulan.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = dropdownBulan.classList.contains('hidden');
                closeAllDropdowns();
                if (isHidden) dropdownBulan.classList.remove('hidden');
            });
        }

        if (btnSelectMonth) {
            btnSelectMonth.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = dropdownSelectMonth.classList.contains('hidden');
                closeAllDropdowns();
                if (isHidden) dropdownSelectMonth.classList.remove('hidden');
            });
        }

        document.addEventListener('click', closeAllDropdowns);

        // Handle "Bulan Ini" Dropdown Selection
        document.querySelectorAll('.dropdown-item-bulan').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-item-bulan').forEach(el => {
                    el.className = 'dropdown-item-bulan w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 transition-colors';
                });
                this.className = 'dropdown-item-bulan w-full text-left px-4 py-2 text-sm font-bold text-green-800 bg-green-50 transition-colors';
                
                if (labelBulanBtn) labelBulanBtn.textContent = this.dataset.val;
                closeAllDropdowns();

                const now = new Date();
                let targetMonth, targetYear;
                if(this.dataset.val === 'Last Month') {
                    let d = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                    targetMonth = d.getMonth() + 1;
                    targetYear = d.getFullYear();
                } else if(this.dataset.val === 'Next Month') {
                    let d = new Date(now.getFullYear(), now.getMonth() + 1, 1);
                    targetMonth = d.getMonth() + 1;
                    targetYear = d.getFullYear();
                } else {
                    targetMonth = now.getMonth() + 1;
                    targetYear = now.getFullYear();
                }
                window.location.href = `/hr/wawancara?month=${targetMonth}&year=${targetYear}`;
            });
        });

        // Handle Dropdown Select Month (Jan - Dec)
        document.querySelectorAll('.dropdown-item-select-month').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.dropdown-item-select-month').forEach(el => {
                    el.className = 'dropdown-item-select-month w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 transition-colors';
                });
                this.className = 'dropdown-item-select-month w-full text-left px-4 py-2 text-sm font-bold text-green-800 bg-green-50 transition-colors';
                
                if (labelSelectMonthBtn) labelSelectMonthBtn.textContent = this.dataset.val;
                closeAllDropdowns();

                currentMonthIndex = parseInt(this.dataset.index) - 1;
                updateMonthDisplay();
            });
        });

        // Month Navigation
        let currentMonthIndex = {{ $month - 1 }};
        let currentYear = {{ $year }};
        
        const btnPrevMonth = document.querySelectorAll('.btn-prev-month');
        const btnNextMonth = document.querySelectorAll('.btn-next-month');

        function updateMonthDisplay() {
            window.location.href = `/hr/wawancara?month=${currentMonthIndex + 1}&year=${currentYear}`;
        }

        btnPrevMonth.forEach(btn => {
            btn.addEventListener('click', () => {
                currentMonthIndex--;
                if(currentMonthIndex < 0) {
                    currentMonthIndex = 11;
                    currentYear--;
                }
                updateMonthDisplay();
            });
        });

        btnNextMonth.forEach(btn => {
            btn.addEventListener('click', () => {
                currentMonthIndex++;
                if(currentMonthIndex > 11) {
                    currentMonthIndex = 0;
                    currentYear++;
                }
                updateMonthDisplay();
            });
        });
    });
</script>
@endsection
