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

            <!-- Month Dropdown -->
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

            <!-- Schedule New Button -->
            <a href="/hr/wawancara/daftar#new" class="bg-green-800 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-900 transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Schedule New
            </a>

            <div class="flex items-center bg-gray-100 rounded-lg p-1 border border-gray-200 shadow-inner">
                <a href="/hr/wawancara/daftar" class="px-3.5 py-1.5 text-xs font-bold text-gray-500 rounded-md hover:text-gray-900 transition-colors">List View</a>
                <span class="px-3.5 py-1.5 text-xs font-bold text-green-900 bg-white shadow-sm rounded-md transition-colors">Month View</span>
            </div>
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
                </ul>
            </div>

            <!-- Location Templates Manager Widget -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
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

            <!-- Upcoming Events List -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Coming Up</h3>
                <div class="space-y-4">
                    @forelse($comingUpInterviews as $interview)
                    @php
                        $borderClasses = [
                            'online' => 'bg-blue-500',
                            'offline' => 'bg-purple-500',
                        ];
                        $typeLabels = [
                            'online' => 'Online Meeting',
                            'offline' => 'On-site Office',
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
                            ];
                            $typeLabels = [
                                'online' => 'Online',
                                'offline' => 'Offline',
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
                            $isCancelled = $interview->status === 'cancelled';
                            $isRescheduled = $interview->status === 'rescheduled';
                            $isInactive = $isAccepted || $isCancelled;
                            $titleText = $candidateName . ' - ' . $typeLabel . ' Interview' . ($isAccepted ? ' (Accepted)' : '') . ($isCancelled ? ' (Cancelled)' : '') . ($isRescheduled ? ' (Rescheduled)' : '');
                        @endphp
                        <div class="border border-l-2 {{ $isInactive ? 'opacity-50 grayscale bg-gray-100 text-gray-400 border-gray-300 pointer-events-none' : ($isRescheduled ? 'bg-amber-50 border-amber-100 border-l-amber-500 text-amber-750' : $colorClass) }} text-[10px] px-2 py-1.5 rounded truncate font-semibold" 
                             title="{{ $titleText }}"
                             @if($isInactive)
                                 onclick="event.stopPropagation();"
                             @else
                                 onclick="event.stopPropagation(); window.location.href='/hr/wawancara/daftar?search={{ urlencode($candidateName) }}'"
                             @endif>
                            <span class="block text-[9px] mb-0.5 font-bold opacity-60">
                                {{ $interview->scheduled_at->format('H:i') }}
                                @if($isCancelled)
                                    <span class="text-[8px] text-red-600 uppercase font-bold ml-1">(Cancelled)</span>
                                @elseif($isRescheduled)
                                    <span class="text-[8px] text-amber-600 uppercase font-bold ml-1">(Resched)</span>
                                @endif
                            </span>
                            <span class="{{ $isCancelled ? 'line-through' : '' }}">{{ $shortName }} ({{ $typeLabel }})</span>
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

        // Handle "This Month" Dropdown Selection
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
                    // Update existing
                    current[editingTemplateIdx] = { name, type, value };
                } else {
                    // Add new
                    current.push({ name, type, value });
                }

                saveLocTemplates(current);
                setFormMode('add');
                populateCentralLocationTemplatesSummary();
                populateCentralLocEditorList();
            });
        }

        // Cancel edit handler
        const btnCancelEdit = document.getElementById('btn-central-cancel-edit');
        if (btnCancelEdit) {
            btnCancelEdit.addEventListener('click', () => setFormMode('add'));
        }

        // Initial loading of summary card
        populateCentralLocationTemplatesSummary();
    });
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
