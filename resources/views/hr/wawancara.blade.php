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

@section('content')
<div class="px-8 py-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-green-900">Interview Schedule</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor and manage all candidate interview schedules in calendar view.</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Filter Dropdown -->
            <div class="relative">
                <button id="btn-filter" class="bg-white border border-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    Filter
                </button>
                <div id="dropdown-filter" class="absolute right-0 top-full mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-lg hidden z-50 p-3">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Interview Type</p>
                    <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" checked class="rounded text-green-600 focus:ring-green-500">
                        <span class="text-sm text-gray-700">Technical Interview</span>
                    </label>
                    <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" checked class="rounded text-green-600 focus:ring-green-500">
                        <span class="text-sm text-gray-700">HR Interview</span>
                    </label>
                    <label class="flex items-center gap-2 p-1.5 hover:bg-gray-50 rounded cursor-pointer">
                        <input type="checkbox" checked class="rounded text-green-600 focus:ring-green-500">
                        <span class="text-sm text-gray-700">User Interview</span>
                    </label>
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
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Calendar Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Mini Calendar (Mock) -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-900 calendar-month-title">Oktober 2024</h3>
                    <div class="flex gap-1">
                        <button class="btn-prev-month text-gray-400 hover:text-green-700 transition"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg></button>
                        <button class="btn-next-month text-gray-400 hover:text-green-700 transition"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7-7" /></svg></button>
                    </div>
                </div>
                <div class="grid grid-cols-7 text-center text-[10px] font-bold text-gray-400 mb-2">
                    <div>S</div><div>S</div><div>R</div><div>K</div><div>J</div><div>S</div><div>M</div>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-700">
                    <div class="text-gray-300 py-1">29</div><div class="text-gray-300 py-1">30</div>
                    @for($i=1; $i<=31; $i++)
                        <div class="py-1 rounded-full cursor-pointer {{ $i == 24 ? 'bg-green-600 text-white font-bold shadow-sm' : 'hover:bg-green-50 hover:text-green-800' }}">{{ $i }}</div>
                    @endfor
                    <div class="text-gray-300 py-1">1</div><div class="text-gray-300 py-1">2</div>
                </div>
            </div>

            <!-- Legends -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Interview Type</h3>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-sm border border-white"></div>
                        <span class="text-sm font-semibold text-gray-700">Technical Interview</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-purple-500 shadow-sm border border-white"></div>
                        <span class="text-sm font-semibold text-gray-700">HR Interview</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-amber-500 shadow-sm border border-white"></div>
                        <span class="text-sm font-semibold text-gray-700">User / Final Interview</span>
                    </li>
                </ul>
            </div>

            <!-- Upcoming Events List -->
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Coming Up</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-1.5 bg-amber-500 rounded-full shrink-0"></div>
                        <div>
                            <div class="text-xs text-gray-500 font-bold mb-0.5">Today, 10:00 - 11:00</div>
                            <div class="text-sm font-bold text-gray-900">Budi Santoso, S.T.</div>
                            <div class="text-[11px] text-gray-500 mt-1">User Interview • Via Google Meet</div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-1.5 bg-blue-500 rounded-full shrink-0"></div>
                        <div>
                            <div class="text-xs text-gray-500 font-bold mb-0.5">Tomorrow, 14:00 - 15:00</div>
                            <div class="text-sm font-bold text-gray-900">Dewi Kartika</div>
                            <div class="text-[11px] text-gray-500 mt-1">Technical Interview • Via Zoom</div>
                        </div>
                    </div>
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
                    <h2 class="text-xl font-bold text-gray-900 calendar-month-title">Oktober 2024</h2>
                    <button class="btn-next-month p-1.5 text-gray-400 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7-7" /></svg>
                    </button>
                </div>
                <div class="flex items-center bg-gray-200/60 rounded-lg p-1">
                    <button id="tab-minggu" class="px-4 py-1.5 text-xs font-bold text-gray-500 rounded-md hover:text-gray-900 transition-colors">Week</button>
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
                <!-- Empty days -->
                <div class="bg-gray-50/40 p-2"><span class="text-xs font-bold text-gray-300">29</span></div>
                <div class="bg-gray-50/40 p-2"><span class="text-xs font-bold text-gray-300">30</span></div>
                
                <!-- Actual days -->
                @for($i = 1; $i <= 31; $i++)
                @php
                    $hasEvent = in_array($i, [5, 12, 24, 28]);
                @endphp
                <div class="bg-white p-2 flex flex-col group hover:bg-gray-50/80 transition-colors relative cursor-pointer min-h-[100px]"
                     @if($hasEvent) onclick="window.location.href='/hr/wawancara/daftar'" @endif>
                    <span class="text-xs font-bold mb-1 {{ $i == 24 ? 'bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center shadow-sm' : 'text-gray-700 w-6 h-6 flex items-center justify-center' }}">{{ $i }}</span>
                    
                    <div class="space-y-1.5 overflow-y-auto hide-scrollbar flex-1">
                        @if($i == 5)
                        <div class="bg-blue-50 border border-blue-100 border-l-2 border-l-blue-500 text-blue-700 text-[10px] px-2 py-1.5 rounded truncate font-semibold" title="Budi Santoso - Technical">
                            <span class="block text-blue-800/60 text-[9px] mb-0.5 font-bold">09:00</span>
                            Budi S. (Tech)
                        </div>
                        @endif
                        @if($i == 12)
                        <div class="bg-purple-50 border border-purple-100 border-l-2 border-l-purple-500 text-purple-700 text-[10px] px-2 py-1.5 rounded truncate font-semibold" title="Siti Aminah - HR">
                            <span class="block text-purple-800/60 text-[9px] mb-0.5 font-bold">11:00</span>
                            Siti A. (HR)
                        </div>
                        <div class="bg-blue-50 border border-blue-100 border-l-2 border-l-blue-500 text-blue-700 text-[10px] px-2 py-1.5 rounded truncate font-semibold" title="Andi Wijaya - Technical">
                            <span class="block text-blue-800/60 text-[9px] mb-0.5 font-bold">14:00</span>
                            Andi W. (Tech)
                        </div>
                        @endif
                        @if($i == 24)
                        <div class="bg-amber-50 border border-amber-100 border-l-2 border-l-amber-500 text-amber-700 text-[10px] px-2 py-1.5 rounded truncate font-semibold shadow-sm ring-1 ring-amber-500/20" title="Budi Santoso - User">
                            <span class="block text-amber-800/60 text-[9px] mb-0.5 font-bold">10:00</span>
                            Budi S. (User)
                        </div>
                        @endif
                        @if($i == 28)
                        <div class="bg-blue-50 border border-blue-100 border-l-2 border-l-blue-500 text-blue-700 text-[10px] px-2 py-1.5 rounded truncate font-semibold" title="Dewi Kartika - Technical">
                            <span class="block text-blue-800/60 text-[9px] mb-0.5 font-bold">14:00</span>
                            Dewi K. (Tech)
                        </div>
                        @endif
                    </div>
                </div>
                @endfor
                
                <div class="bg-gray-50/40 p-2"><span class="text-xs font-bold text-gray-300">1</span></div>
                <div class="bg-gray-50/40 p-2"><span class="text-xs font-bold text-gray-300">2</span></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Dropdowns
        const btnFilter = document.getElementById('btn-filter');
        const dropdownFilter = document.getElementById('dropdown-filter');
        
        const btnBulan = document.getElementById('btn-bulan');
        const dropdownBulan = document.getElementById('dropdown-bulan');
        const labelBulanBtn = document.getElementById('label-bulan-btn');

        function closeAllDropdowns() {
            dropdownFilter.classList.add('hidden');
            dropdownBulan.classList.add('hidden');
        }

        btnFilter.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = dropdownFilter.classList.contains('hidden');
            closeAllDropdowns();
            if (isHidden) dropdownFilter.classList.remove('hidden');
        });

        btnBulan.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = dropdownBulan.classList.contains('hidden');
            closeAllDropdowns();
            if (isHidden) dropdownBulan.classList.remove('hidden');
        });

        document.addEventListener('click', closeAllDropdowns);
        dropdownFilter.addEventListener('click', (e) => e.stopPropagation());

        // Handle "Bulan Ini" Dropdown Selection
        document.querySelectorAll('.dropdown-item-bulan').forEach(item => {
            item.addEventListener('click', function() {
                // Reset all to default style
                document.querySelectorAll('.dropdown-item-bulan').forEach(el => {
                    el.className = 'dropdown-item-bulan w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-800 transition-colors';
                });
                // Set active style
                this.className = 'dropdown-item-bulan w-full text-left px-4 py-2 text-sm font-bold text-green-800 bg-green-50 transition-colors';
                
                labelBulanBtn.textContent = this.dataset.val;
                closeAllDropdowns();

                // Mock changing month based on selection
                if(this.dataset.val === 'Last Month') {
                    currentMonthIndex = 8; // September
                } else if(this.dataset.val === 'Next Month') {
                    currentMonthIndex = 10; // November
                } else {
                    currentMonthIndex = 9; // October
                }
                updateMonthDisplay();
            });
        });

        // Toggle Tabs Minggu/Bulan
        const tabMinggu = document.getElementById('tab-minggu');
        const tabBulan = document.getElementById('tab-bulan');
        
        tabMinggu.addEventListener('click', function() {
            tabBulan.className = 'px-4 py-1.5 text-xs font-bold text-gray-500 rounded-md hover:text-gray-900 transition-colors';
            tabMinggu.className = 'px-4 py-1.5 text-xs font-bold text-green-900 bg-white shadow-sm rounded-md transition-colors';
            // In a real app, this would switch the calendar view
        });

        tabBulan.addEventListener('click', function() {
            tabMinggu.className = 'px-4 py-1.5 text-xs font-bold text-gray-500 rounded-md hover:text-gray-900 transition-colors';
            tabBulan.className = 'px-4 py-1.5 text-xs font-bold text-green-900 bg-white shadow-sm rounded-md transition-colors';
        });

        // Month Navigation
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        let currentMonthIndex = 9; // October
        let currentYear = 2024;
        
        const monthTitles = document.querySelectorAll('.calendar-month-title');
        const btnPrevMonth = document.querySelectorAll('.btn-prev-month');
        const btnNextMonth = document.querySelectorAll('.btn-next-month');

        function updateMonthDisplay() {
            const text = `${months[currentMonthIndex]} ${currentYear}`;
            monthTitles.forEach(el => el.textContent = text);
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
