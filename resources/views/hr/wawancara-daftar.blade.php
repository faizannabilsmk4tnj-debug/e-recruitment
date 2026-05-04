@extends('layouts.hr')

@section('title', 'Daftar Wawancara')
@section('page-title', 'Daftar Wawancara')
@section('nav-wawancara', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="px-8 py-8 max-w-7xl mx-auto">
    <!-- Top Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1">SISTEM MANAJEMEN</p>
            <h1 class="text-3xl font-extrabold text-gray-900">Daftar Wawancara</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" placeholder="Search sessions..." class="pl-9 pr-4 py-2 bg-gray-100/50 border border-transparent rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white w-64 transition-all">
            </div>
            <button class="bg-white border border-gray-200 text-green-800 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-50 transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Schedule New
            </button>
            <button class="bg-white border border-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition-colors shadow-sm flex items-center gap-2 ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                Export CSV
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-5 mb-8 flex items-end gap-6">
        <div>
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">STATUS FILTER</label>
            <div class="flex items-center bg-white border border-gray-200 rounded-lg p-1">
                <button class="px-4 py-1.5 text-xs font-bold text-white bg-green-900 rounded-md shadow-sm">All</button>
                <button class="px-4 py-1.5 text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors">Scheduled</button>
                <button class="px-4 py-1.5 text-xs font-bold text-gray-500 hover:text-gray-900 transition-colors">Completed</button>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">RENTANG TANGGAL</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <input type="text" id="filter-date" value="Oct 20, 2023 - Oct 27, 2023" class="pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none w-[240px]">
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">TIPE</label>
            <div class="relative">
                <select class="pl-4 pr-10 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-700 font-medium focus:outline-none w-[180px] appearance-none">
                    <option>Semua Tipe</option>
                    <option>Technical</option>
                    <option>HR</option>
                    <option>User</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
            </div>
        </div>

        <button class="bg-green-800 text-white p-2.5 rounded-lg shadow-sm hover:bg-green-900 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">NAMA KANDIDAT</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">POSISI</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">TANGGAL & JAM</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">TIPE</th>
                    <th class="text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">STATUS</th>
                    <th class="text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest px-6 py-4">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <!-- Row 1 -->
                <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-800 font-bold text-xs shrink-0">AS</div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Aditya Saputra</p>
                                <p class="text-xs text-gray-400">aditya.s@example.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold text-gray-700 bg-gray-100">Senior Chemist</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm text-gray-900">Oct 24, 2023</p>
                        <p class="text-xs text-gray-500">10:00 - 11:30 AM</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m9 9 5 3-5 3v-6"/></svg>
                            Online Meeting
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold text-green-700 bg-green-50 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            SCHEDULED
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-gray-400 hover:text-gray-900 p-1 rounded transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-800 font-bold text-xs shrink-0">RL</div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Ratna Lestari</p>
                                <p class="text-xs text-gray-400">ratna.l@example.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold text-gray-700 bg-gray-100">Plant Manager</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm text-gray-900">Oct 23, 2023</p>
                        <p class="text-xs text-gray-500">02:00 - 03:30 PM</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14"/><path d="M4 19h16"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                            On-site Office
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            COMPLETED
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-gray-400 hover:text-gray-900 p-1 rounded transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer opacity-75">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs shrink-0">BW</div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Budi Wijaya</p>
                                <p class="text-xs text-gray-400">budi.w@example.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold text-gray-700 bg-gray-100">HR Specialist</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm text-gray-500 line-through">Oct 22, 2023</p>
                        <p class="text-xs text-gray-400 line-through">09:00 - 10:00 AM</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><path d="m9 9 5 3-5 3v-6"/></svg>
                            Online Meeting
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold text-red-700 bg-red-50 border border-red-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            CANCELLED
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-gray-400 hover:text-gray-900 p-1 rounded transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>

                <!-- Row 4 -->
                <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-800 font-bold text-xs shrink-0">FP</div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 group-hover:text-green-800 transition-colors">Fitri Permata</p>
                                <p class="text-xs text-gray-400">fitri.p@example.com</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold text-gray-700 bg-gray-100">Production Supervisor</span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-sm text-gray-900">Oct 25, 2023</p>
                        <p class="text-xs text-gray-500">11:00 - 12:00 PM</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14"/><path d="M4 19h16"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                            On-site Office
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold text-green-700 bg-green-50 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            SCHEDULED
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-gray-400 hover:text-gray-900 p-1 rounded transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
            <span class="text-xs text-gray-500">Menampilkan <strong>4</strong> dari <strong>24</strong> sesi wawancara</span>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center text-white font-semibold bg-green-900 rounded-lg shadow-sm">1</button>
                <button class="w-8 h-8 flex items-center justify-center text-gray-600 font-semibold hover:bg-gray-100 rounded-lg transition-colors">2</button>
                <button class="w-8 h-8 flex items-center justify-center text-gray-600 font-semibold hover:bg-gray-100 rounded-lg transition-colors">3</button>
                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-green-900 text-white rounded-2xl p-6 shadow-md relative overflow-hidden">
            <div class="absolute -right-4 -top-4 opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
            </div>
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-green-100 mb-1">Total Terjadwal</h3>
                <div class="text-4xl font-extrabold mb-1">12</div>
                <p class="text-[10px] font-medium text-green-300">Minggu ini</p>
            </div>
        </div>

        <div class="bg-green-100 border border-green-200 text-green-900 rounded-2xl p-6 shadow-sm">
            <div class="w-10 h-10 bg-green-200/50 rounded-lg flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-green-800 mb-1">Tingkat Kehadiran</h3>
            <div class="text-4xl font-extrabold mb-1">94%</div>
            <p class="text-[10px] font-bold text-green-700 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m18 15-6-6-6 6"/></svg>
                +2% dari bulan lalu
            </p>
        </div>

        <div class="bg-gray-100 border border-gray-200 text-gray-900 rounded-2xl p-6 shadow-sm">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-6-6m6 6v-4.8m0 4.8h-4.8"/><path d="M3 16.2V21m0 0h4.8M3 21l6-6"/><path d="M21 7.8V3m0 0h-4.8M21 3l-6 6"/><path d="M3 7.8V3m0 0h4.8M3 3l6 6"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-600 mb-1">Rata-rata Durasi</h3>
            <div class="text-4xl font-extrabold mb-1">45m</div>
            <p class="text-[10px] font-medium text-gray-500">Standar HR Oleochemicals</p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const dateParam = urlParams.get('date');
    
    if (dateParam) {
        const dateObj = new Date(dateParam);
        if (!isNaN(dateObj)) {
            // Format to match the default input style, e.g. "May 12, 2026"
            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            const formatted = dateObj.toLocaleDateString('en-US', options);
            document.getElementById('filter-date').value = formatted;
        }
    }
});
</script>
@endsection
