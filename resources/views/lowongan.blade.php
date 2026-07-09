@extends($layout ?? 'layouts.landing')

@section('title', 'Vacancies - Sustainable Careers')
@if(!isset($layout))
@section('nav-lowongan', 'text-white font-semibold')
@endif

@section('css')
<style>
    .job-card { transition: transform 0.2s, box-shadow 0.2s; }
    .job-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .filter-active { background: #14532d; color: #fff; border-color: #14532d; }
</style>
@endsection

@section('content')

{{-- ===== HERO HEADER ===== --}}
<section class="bg-[#15803d] px-16 py-12 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 pointer-events-none flex items-center justify-end pr-16">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-64 h-64 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
    </div>
    <div class="relative z-10">
        <div class="flex items-center gap-2 mb-3">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            <span class="text-xs font-bold text-green-400 uppercase tracking-widest">Now Hiring</span>
        </div>
        <h1 class="text-4xl font-extrabold text-white mb-3">Sustainable Careers</h1>
        <p class="text-green-300 text-sm max-w-lg leading-relaxed">Discover opportunities at PT Ecogreen Oleochemicals — a global leader in sustainable oleochemical manufacturing.</p>
    </div>
</section>

{{-- ===== FILTER BAR ===== --}}
<section class="bg-white border-b border-gray-200 px-16 py-4 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center gap-3 flex-wrap">
        {{-- Search --}}
        <div class="relative flex-1 min-w-[200px] max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" id="search-job" placeholder="Search position..." class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50">
        </div>

        {{-- Dropdowns --}}
        <div class="relative">
            <button id="btn-filter-cat" class="flex items-center gap-2 px-3.5 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-green-400 hover:text-green-800 transition-colors bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/></svg>
                Category
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="dropdown-cat" class="hidden absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-50 w-48">
                @foreach($categories as $cat)
                <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700">
                    <input type="checkbox" class="filter-cat accent-green-700 w-4 h-4 rounded" value="{{ $cat->name }}"> {{ $cat->name }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <button id="btn-filter-type" class="flex items-center gap-2 px-3.5 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-green-400 hover:text-green-800 transition-colors bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Job Type
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="dropdown-type" class="hidden absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-50 w-40">
                @foreach(['Full-time','Contract','Internship','Part-time'] as $type)
                <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700">
                    <input type="radio" name="filter-type" class="filter-type accent-green-700 w-4 h-4" value="{{ $type }}"> {{ $type }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <button id="btn-filter-loc" class="flex items-center gap-2 px-3.5 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:border-green-400 hover:text-green-800 transition-colors bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                Location
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="dropdown-loc" class="hidden absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-50 w-48">
                @foreach($locations as $loc)
                <label class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-gray-50 cursor-pointer text-sm text-gray-700">
                    <input type="radio" name="filter-loc" class="filter-loc accent-green-700 w-4 h-4" value="{{ $loc->name }}"> {{ $loc->name }}
                </label>
                @endforeach
            </div>
        </div>

        <div class="ml-auto flex items-center gap-3">
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-500 hover:text-gray-700 select-none">
                <input type="checkbox" id="toggle-show-closed" class="accent-green-700 w-4 h-4 rounded">
                Show Closed
            </label>
            <button id="btn-reset-filter" class="text-sm text-gray-500 hover:text-red-600 border border-gray-200 hover:border-red-300 px-3.5 py-2 rounded-lg transition-colors">
                Reset
            </button>
        </div>
    </div>
</section>

{{-- ===== JOB CARDS ===== --}}
<section class="px-16 py-10 bg-gray-50 min-h-[400px]">
    <div class="grid grid-cols-3 gap-5" id="job-grid">

        @php
        $iconMap = [
            'engineering' => [
                'bg' => 'bg-green-50',
                'color' => 'text-green-700',
                'svg' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>'
            ],
            'r&d' => [
                'bg' => 'bg-purple-50',
                'color' => 'text-purple-600',
                'svg' => '<path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/>'
            ],
            'r&d lab' => [
                'bg' => 'bg-purple-50',
                'color' => 'text-purple-600',
                'svg' => '<path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/>'
            ],
            'human resources' => [
                'bg' => 'bg-blue-50',
                'color' => 'text-blue-600',
                'svg' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'
            ],
            'hr & legal' => [
                'bg' => 'bg-blue-50',
                'color' => 'text-blue-600',
                'svg' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'
            ],
            'supply chain' => [
                'bg' => 'bg-amber-50',
                'color' => 'text-amber-600',
                'svg' => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/>'
            ],
            'logistics' => [
                'bg' => 'bg-amber-50',
                'color' => 'text-amber-600',
                'svg' => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/>'
            ],
            'safety' => [
                'bg' => 'bg-red-50',
                'color' => 'text-red-600',
                'svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'
            ],
            'technology' => [
                'bg' => 'bg-cyan-50',
                'color' => 'text-cyan-600',
                'svg' => '<path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/>'
            ],
            'it & digital' => [
                'bg' => 'bg-cyan-50',
                'color' => 'text-cyan-600',
                'svg' => '<path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/>'
            ]
        ];
        @endphp

        @foreach($jobs as $job)
        @php
            $catName = $job->category->name ?? '';
            $catLower = strtolower($catName);
            $icon = $iconMap[$catLower] ?? [
                'bg' => 'bg-gray-50',
                'color' => 'text-gray-600',
                'svg' => '<path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>'
            ];
            
            $jobType = ucfirst($job->employment_type);
            
            $isActive = $job->status === 'open';
            $isClosed = $job->status === 'closed';
            $isFilled = $job->status === 'filled';
            
            $statusStr = $isActive ? 'ACTIVE' : ($isClosed ? 'CLOSED' : 'FILLED');
            $cardOpacity = ($isClosed || $isFilled) ? 'opacity-60' : '';
            $cardHover   = $isActive ? 'job-card cursor-pointer' : 'job-card';
            $url = isset($layout) ? '/pelamar/lowongan/'.$job->id : '/lowongan/'.$job->id;
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 p-6 {{ $cardHover }} {{ $cardOpacity }}"
             data-category="{{ $catName }}" data-type="{{ $jobType }}"
             data-location="{{ $job->location }}" data-status="{{ $statusStr }}"
             @if($isActive) onclick="window.location.href='{{ $url }}'" @endif>

            {{-- Card Header --}}
            <div class="flex items-start justify-between mb-4">
                <div class="w-11 h-11 {{ $icon['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $icon['color'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon['svg'] !!}</svg>
                </div>
                {{-- Status badge --}}
                @if($isActive)
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-50 text-green-700 border border-green-200 shrink-0">● OPEN</span>
                @elseif($isClosed)
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-red-50 text-red-500 border border-red-200 shrink-0">● CLOSED</span>
                @else
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-blue-50 text-blue-500 border border-blue-200 shrink-0">● FILLED</span>
                @endif
            </div>

            {{-- Title --}}
            <h3 class="font-bold text-gray-900 text-sm leading-snug mb-3 {{ $isClosed ? 'line-through text-gray-400' : '' }}">{{ $job->title }}</h3>

            {{-- Meta info --}}
            <div class="space-y-1.5 text-xs text-gray-500 mb-4">
                <p class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    {{ $catName }}
                </p>
                <p class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $jobType }}
                </p>
                <p class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $job->location }}
                </p>
            </div>

            {{-- Footer --}}
            <div class="pt-4 border-t border-gray-100 flex items-center justify-between" onclick="event.stopPropagation();">
                <div>
                    @if($isActive)
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Deadline</p>
                    <p class="text-xs font-bold text-green-700 mt-0.5">{{ $job->deadline ? $job->deadline->format('d M Y') : '-' }}</p>
                    @elseif($isClosed)
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Closed</p>
                    <p class="text-xs font-bold text-red-500 mt-0.5">{{ $job->deadline ? $job->deadline->format('d M Y') : '-' }}</p>
                    @else
                    <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Status</p>
                    <p class="text-xs font-bold text-blue-500 mt-0.5">Position Filled</p>
                    @endif
                </div>
                @if($isActive)
                <a href="{{ $url }}" class="bg-[#15803d] hover:bg-[#166534] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                    View Details
                </a>
                @elseif($isClosed)
                <span class="bg-gray-100 text-gray-400 text-xs font-semibold px-4 py-2 rounded-lg cursor-not-allowed">Closed</span>
                @else
                <span class="bg-gray-100 text-gray-400 text-xs font-semibold px-4 py-2 rounded-lg cursor-not-allowed">Filled</span>
                @endif
            </div>
        </div>
        @endforeach

    </div>

    {{-- Empty state --}}
    <div id="no-results" class="hidden text-center py-16">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <p class="text-gray-500 font-semibold">No vacancies match your filters</p>
        <p class="text-gray-400 text-sm mt-1">Try adjusting your search or reset the filters</p>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
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
            dropdowns.forEach(d => document.getElementById(d.dd).classList.add('hidden'));
            if (!isOpen) el.classList.remove('hidden');
        });
    });

    document.addEventListener('click', () => dropdowns.forEach(d => document.getElementById(d.dd).classList.add('hidden')));
    document.querySelectorAll('[id^="dropdown-"]').forEach(dd => dd.addEventListener('click', e => e.stopPropagation()));

    function applyFilters() {
        const selectedCats = [...document.querySelectorAll('.filter-cat:checked')].map(c => c.value);
        const selectedType = document.querySelector('.filter-type:checked')?.value.toLowerCase() || '';
        const selectedLoc  = document.querySelector('.filter-loc:checked')?.value.toLowerCase().split(' ')[0] || '';
        const searchQ      = document.getElementById('search-job').value.toLowerCase();
        const showClosed   = document.getElementById('toggle-show-closed').checked;

        let visible = 0;
        document.querySelectorAll('.job-card').forEach(card => {
            const status = card.dataset.status || 'ACTIVE';
            if (status === 'FILLED') { card.style.display = 'none'; return; }
            if (status === 'CLOSED' && !showClosed) { card.style.display = 'none'; return; }

            const matchCat    = selectedCats.length === 0 || selectedCats.includes(card.dataset.category || '');
            const matchType   = !selectedType || (card.dataset.type || '').toLowerCase() === selectedType;
            const matchLoc    = !selectedLoc  || (card.dataset.location || '').toLowerCase().includes(selectedLoc);
            const matchSearch = !searchQ || card.textContent.toLowerCase().includes(searchQ);
            const show = matchCat && matchType && matchLoc && matchSearch;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('no-results').classList.toggle('hidden', visible > 0);
    }

    document.getElementById('search-job').addEventListener('input', applyFilters);
    document.querySelectorAll('.filter-cat, .filter-type, .filter-loc').forEach(cb => cb.addEventListener('change', applyFilters));
    document.getElementById('toggle-show-closed').addEventListener('change', applyFilters);

    document.getElementById('btn-reset-filter').addEventListener('click', function () {
        document.querySelectorAll('.filter-cat').forEach(cb => cb.checked = false);
        document.querySelectorAll('.filter-type, .filter-loc').forEach(rb => rb.checked = false);
        document.getElementById('search-job').value = '';
        document.getElementById('toggle-show-closed').checked = false;
        dropdowns.forEach(d => document.getElementById(d.dd).classList.add('hidden'));
        // Redirect to clear the backend query as well
        window.location.href = window.location.pathname;
    });

    // Read ?q= from URL (from landing page hero search)
    const urlQ = new URLSearchParams(window.location.search).get('q');
    if (urlQ) {
        document.getElementById('search-job').value = urlQ;
    }

    // Read ?category= from URL (from popular categories modal on landing)
    const urlCat = new URLSearchParams(window.location.search).get('category');
    if (urlCat) {
        const catCheckbox = [...document.querySelectorAll('.filter-cat')].find(cb => cb.value.toLowerCase() === urlCat.toLowerCase());
        if (catCheckbox) {
            catCheckbox.checked = true;
        }
    }

    // Read ?open_categories= from URL to automatically open category dropdown
    if (new URLSearchParams(window.location.search).get('open_categories') === '1') {
        const catDd = document.getElementById('dropdown-cat');
        if (catDd) {
            catDd.classList.remove('hidden');
        }
    }

    // Trigger backend search on Enter keypress
    document.getElementById('search-job').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const q = this.value.trim();
            window.location.href = window.location.pathname + (q ? '?q=' + encodeURIComponent(q) : '');
        }
    });

    applyFilters();
});
</script>
@endsection