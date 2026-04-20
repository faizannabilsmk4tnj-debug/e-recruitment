@extends($layout ?? 'layouts.landing')

@section('title', 'Lowongan - Sustainable Careers')
@if(!isset($layout))
@section('nav-lowongan', 'text-white font-semibold')
@endif

@section('css')
<style>
    .progress-bar { height: 4px; border-radius: 2px; }
    .progress-bar-fill { height: 100%; border-radius: 2px; transition: width 0.6s ease-out; }
</style>
@endsection

@section('content')

<!-- Header -->
<section class="bg-white px-16 py-10 border-b border-gray-100">
    <div>
        <h1 class="text-4xl font-extrabold text-gray-900">Sustainable Careers</h1>
        <p class="text-gray-500 mt-2 text-sm max-w-md">Join PT Ecogreen Oleochemicals and contribute to global excellence in natural ingredients.</p>
    </div>
</section>

<!-- Filters -->
<section class="bg-gray-100 border-b border-gray-200 px-16 py-4">
    <div class="flex items-center gap-4">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" id="search-job" placeholder="Search by position..." class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <!-- All Categories -->
            <div class="relative">
                <button id="btn-filter-cat" class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    All Categories
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div id="dropdown-cat" class="hidden absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-50 w-48">
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Engineering"> Engineering</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Sustainability"> Sustainability</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="IT & Digital"> IT & Digital</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Finance"> Finance</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Operations"> Operations</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="R&D"> R&D</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Human Resources"> Human Resources</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Safety"> Safety</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="Supply Chain"> Supply Chain</label>
                </div>
            </div>

            <!-- Job Type -->
            <div class="relative">
                <button id="btn-filter-type" class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    Job Type
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div id="dropdown-type" class="hidden absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-50 w-40">
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-type" class="filter-type accent-green-700 w-4 h-4" value="Full-time"> Full-time</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-type" class="filter-type accent-green-700 w-4 h-4" value="Contract"> Contract</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-type" class="filter-type accent-green-700 w-4 h-4" value="Internship"> Internship</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-type" class="filter-type accent-green-700 w-4 h-4" value="Part-time"> Part-time</label>
                </div>
            </div>

            <!-- Location -->
            <div class="relative">
                <button id="btn-filter-loc" class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    Location
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div id="dropdown-loc" class="hidden absolute top-full right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-50 w-48">
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-loc" class="filter-loc accent-green-700 w-4 h-4" value="Batam Plant"> Batam Plant</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-loc" class="filter-loc accent-green-700 w-4 h-4" value="Medan Site"> Medan Site</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-loc" class="filter-loc accent-green-700 w-4 h-4" value="Jakarta HQ"> Jakarta HQ</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-loc" class="filter-loc accent-green-700 w-4 h-4" value="Surabaya Plant"> Surabaya Plant</label>
                    <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700"><input type="radio" name="filter-loc" class="filter-loc accent-green-700 w-4 h-4" value="Dumai Site"> Dumai Site</label>
                </div>
            </div>

            <button id="btn-reset-filter" class="bg-green-900 hover:bg-green-800 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">Reset Filter</button>
        </div>
    </div>
</section>

<!-- Job Cards Grid -->
<section class="px-16 py-10 bg-gray-50">
    <div class="grid grid-cols-3 gap-6" id="job-grid">

        <!-- Job 1 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all job-card" data-category="Engineering" data-type="Full-time" data-location="Batam Plant">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                </div>
                <button data-auth-required class="text-gray-300 hover:text-yellow-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                </button>
            </div>
            <h3 class="font-bold text-gray-900 mb-3">Mechanical Process Engineer</h3>
            <div class="space-y-1.5 text-sm text-gray-500">
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> Engineering</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Full-time</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Batam Plant</p>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs mb-1.5">
                    <span class="font-semibold text-gray-500 uppercase tracking-wider">Applicants</span>
                    <span class="font-bold text-gray-700">14 / 20</span>
                </div>
                <div class="progress-bar bg-gray-100"><div class="progress-bar-fill bg-green-500" style="width: 70%"></div></div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div><p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Deadline</p><p class="text-sm font-semibold text-green-700">Oct 24, 2024</p></div>
                <a href="{{ isset($layout) ? '/pelamar/lowongan/1' : '/lowongan/1' }}" class="bg-green-900 hover:bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">View Details</a>
            </div>
        </div>

        <!-- Job 2 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all job-card" data-category="R&D" data-type="Full-time" data-location="Medan Site">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/></svg>
                </div>
                <button data-auth-required class="text-gray-300 hover:text-yellow-500 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
            </div>
            <h3 class="font-bold text-gray-900 mb-3">QC Analyst Lab (Oleochemicals)</h3>
            <div class="space-y-1.5 text-sm text-gray-500">
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> R&D</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Full-time</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Medan Site</p>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs mb-1.5"><span class="font-semibold text-gray-500 uppercase tracking-wider">Applicants</span><span class="font-bold text-gray-700">5 / 15</span></div>
                <div class="progress-bar bg-gray-100"><div class="progress-bar-fill bg-green-500" style="width: 33%"></div></div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div><p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Deadline</p><p class="text-sm font-semibold text-green-700">Nov 12, 2024</p></div>
                <a href="{{ isset($layout) ? '/pelamar/lowongan/2' : '/lowongan/2' }}" class="bg-green-900 hover:bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">View Details</a>
            </div>
        </div>

        <!-- Job 3 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all job-card" data-category="Human Resources" data-type="Full-time" data-location="Jakarta HQ">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <button data-auth-required class="text-gray-300 hover:text-yellow-500 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
            </div>
            <h3 class="font-bold text-gray-900 mb-3">HR Specialist - Talent Acquisition</h3>
            <div class="space-y-1.5 text-sm text-gray-500">
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> Human Resources</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Full-time</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Jakarta HQ</p>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs mb-1.5"><span class="font-semibold text-gray-500 uppercase tracking-wider">Applicants</span><span class="font-bold text-red-600">28 / 30</span></div>
                <div class="progress-bar bg-gray-100"><div class="progress-bar-fill bg-red-500" style="width: 93%"></div></div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div><p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Deadline</p><p class="text-sm font-semibold text-red-600">Oct 18, 2024</p></div>
                <a href="{{ isset($layout) ? '/pelamar/lowongan/3' : '/lowongan/3' }}" class="bg-green-900 hover:bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">View Details</a>
            </div>
        </div>

        <!-- Job 4 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all job-card" data-category="Supply Chain" data-type="Full-time" data-location="Surabaya Plant">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <button data-auth-required class="text-gray-300 hover:text-yellow-500 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
            </div>
            <h3 class="font-bold text-gray-900 mb-3">Supply Chain Coordinator</h3>
            <div class="space-y-1.5 text-sm text-gray-500">
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> Supply Chain</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Full-time</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Surabaya Plant</p>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs mb-1.5"><span class="font-semibold text-gray-500 uppercase tracking-wider">Applicants</span><span class="font-bold text-gray-700">8 / 12</span></div>
                <div class="progress-bar bg-gray-100"><div class="progress-bar-fill bg-green-500" style="width: 67%"></div></div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div><p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Deadline</p><p class="text-sm font-semibold text-green-700">Nov 05, 2024</p></div>
                <a href="{{ isset($layout) ? '/pelamar/lowongan/4' : '/lowongan/4' }}" class="bg-green-900 hover:bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">View Details</a>
            </div>
        </div>

        <!-- Job 5 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all job-card" data-category="Engineering" data-type="Full-time" data-location="Batam Plant">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <button data-auth-required class="text-gray-300 hover:text-yellow-500 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
            </div>
            <h3 class="font-bold text-gray-900 mb-3">Electrical Maintenance Lead</h3>
            <div class="space-y-1.5 text-sm text-gray-500">
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> Engineering</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Full-time</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Batam Plant</p>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs mb-1.5"><span class="font-semibold text-gray-500 uppercase tracking-wider">Applicants</span><span class="font-bold text-gray-700">3 / 8</span></div>
                <div class="progress-bar bg-gray-100"><div class="progress-bar-fill bg-green-500" style="width: 38%"></div></div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div><p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Deadline</p><p class="text-sm font-semibold text-green-700">Dec 01, 2024</p></div>
                <a href="{{ isset($layout) ? '/pelamar/lowongan/5' : '/lowongan/5' }}" class="bg-green-900 hover:bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">View Details</a>
            </div>
        </div>

        <!-- Job 6 -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all job-card" data-category="Safety" data-type="Full-time" data-location="Medan Site">
            <div class="flex items-start justify-between mb-5">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                <button data-auth-required class="text-gray-300 hover:text-yellow-500 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg></button>
            </div>
            <h3 class="font-bold text-gray-900 mb-3">HSE Officer</h3>
            <div class="space-y-1.5 text-sm text-gray-500">
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg> Safety</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Full-time</p>
                <p class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> Medan Site</p>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between text-xs mb-1.5"><span class="font-semibold text-gray-500 uppercase tracking-wider">Applicants</span><span class="font-bold text-red-600">12 / 15</span></div>
                <div class="progress-bar bg-gray-100"><div class="progress-bar-fill bg-red-500" style="width: 80%"></div></div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div><p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Deadline</p><p class="text-sm font-semibold text-red-600">Oct 30, 2024</p></div>
                <a href="{{ isset($layout) ? '/pelamar/lowongan/6' : '/lowongan/6' }}" class="bg-green-900 hover:bg-green-800 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">View Details</a>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dropdown toggles
    const dropdowns = [
        { btn: 'btn-filter-cat', dd: 'dropdown-cat' },
        { btn: 'btn-filter-type', dd: 'dropdown-type' },
        { btn: 'btn-filter-loc', dd: 'dropdown-loc' }
    ];

    dropdowns.forEach(({ btn, dd }) => {
        document.getElementById(btn).addEventListener('click', function (e) {
            e.stopPropagation();
            const el = document.getElementById(dd);
            const isOpen = !el.classList.contains('hidden');
            // Close all first
            dropdowns.forEach(d => document.getElementById(d.dd).classList.add('hidden'));
            if (!isOpen) el.classList.remove('hidden');
        });
    });

    // Close dropdowns on click outside
    document.addEventListener('click', function () {
        dropdowns.forEach(d => document.getElementById(d.dd).classList.add('hidden'));
    });

    // Stop propagation inside dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(dd => {
        dd.addEventListener('click', e => e.stopPropagation());
    });

    // Search
    document.getElementById('search-job').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.job-card').forEach(card => {
            card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // Filter logic
    function applyFilters() {
        const selectedCats = [...document.querySelectorAll('.filter-cat:checked')].map(c => c.value);
        const selectedType = document.querySelector('.filter-type:checked')?.value || '';
        const selectedLoc = document.querySelector('.filter-loc:checked')?.value || '';

        let visible = 0;
        document.querySelectorAll('.job-card').forEach(card => {
            const cat = card.dataset.category || '';
            const type = card.dataset.type || '';
            const loc = card.dataset.location || '';
            const matchCat = selectedCats.length === 0 || selectedCats.includes(cat);
            const matchType = !selectedType || type === selectedType;
            const matchLoc = !selectedLoc || loc === selectedLoc;
            const show = matchCat && matchType && matchLoc;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });
    }

    document.querySelectorAll('.filter-cat, .filter-type, .filter-loc').forEach(cb => {
        cb.addEventListener('change', applyFilters);
    });

    document.getElementById('btn-reset-filter').addEventListener('click', function () {
        document.querySelectorAll('.filter-cat').forEach(cb => cb.checked = false);
        document.querySelectorAll('.filter-type').forEach(rb => rb.checked = false);
        document.querySelectorAll('.filter-loc').forEach(rb => rb.checked = false);
        document.getElementById('search-job').value = '';
        document.querySelectorAll('.job-card').forEach(card => card.style.display = '');
        dropdowns.forEach(d => document.getElementById(d.dd).classList.add('hidden'));
    });
});
</script>
@endsection