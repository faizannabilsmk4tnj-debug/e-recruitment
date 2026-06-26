@extends('layouts.pelamar')

@section('title', 'Saved Vacancies')
@section('nav-saved-jobs', 'active')

@section('css')
<style>
    .job-card { transition: transform 0.2s, box-shadow 0.2s; }
    .job-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
</style>
@endsection

@section('content')

{{-- ===== DASHBOARD HEADER ===== --}}
<div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Saved Jobs</h1>
    <p class="text-sm text-gray-500 mt-1">Keep track of the jobs you've bookmarked. You can apply directly or remove them from your list.</p>
</div>

{{-- ===== JOB CARDS ===== --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="job-grid">

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

    @forelse($savedJobs as $saved)
    @php
        $job = $saved->jobPosting;
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
        
        $cardOpacity = ($isClosed || $isFilled) ? 'opacity-60' : '';
        $cardHover   = $isActive ? 'job-card cursor-pointer' : 'job-card';
        $url = '/pelamar/lowongan/'.$job->id;
    @endphp
    <div class="bg-white rounded-2xl border border-gray-200 p-6 {{ $cardHover }} {{ $cardOpacity }} relative" 
         id="saved-card-{{ $job->id }}"
         @if($isActive) onclick="window.location.href='{{ $url }}'" @endif>

        {{-- Card Header --}}
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 {{ $icon['bg'] }} rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $icon['color'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon['svg'] !!}</svg>
            </div>
            
            <div class="flex items-center gap-2">
                {{-- Status badge --}}
                @if($isActive)
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-green-50 text-green-700 border border-green-200 shrink-0">● OPEN</span>
                @elseif($isClosed)
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-red-50 text-red-500 border border-red-200 shrink-0">● CLOSED</span>
                @else
                <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-blue-50 text-blue-500 border border-blue-200 shrink-0">● FILLED</span>
                @endif

                {{-- Unsave icon button --}}
                <button onclick="event.stopPropagation(); toggleUnsave({{ $job->id }});" class="text-amber-500 hover:text-red-500 p-1.5 rounded-lg hover:bg-gray-50 transition-colors" title="Hapus bookmark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-amber-500 hover:fill-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                    </svg>
                </button>
            </div>
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
    @empty
    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200" id="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
        </svg>
        <p class="text-gray-500 font-semibold">No saved vacancies</p>
        <p class="text-gray-400 text-sm mt-1 mb-6">Explore our vacancies and bookmark them to keep track of them here.</p>
        <a href="/pelamar/lowongan" class="inline-flex items-center gap-2 bg-[#15803d] hover:bg-[#166534] text-white text-xs font-semibold px-5 py-2.5 rounded-lg transition-colors">
            Browse Vacancies
        </a>
    </div>
    @endforelse

</div>

@endsection

@section('scripts')
<script>
function toggleUnsave(jobId) {
    if (!confirm('Apakah Anda yakin ingin menghapus lowongan ini dari daftar lowongan tersimpan?')) {
        return;
    }

    fetch(`/pelamar/lowongan/${jobId}/toggle-save`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && !data.is_saved) {
            const card = document.getElementById(`saved-card-${jobId}`);
            if (card) {
                // Fade out/remove effect
                card.style.transition = 'opacity 0.3s, transform 0.3s';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.remove();
                    // If no cards left, show empty state
                    const remainingCards = document.querySelectorAll('[id^="saved-card-"]');
                    if (remainingCards.length === 0) {
                        const grid = document.getElementById('job-grid');
                        grid.innerHTML = `
                            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200" id="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                                </svg>
                                <p class="text-gray-500 font-semibold">No saved vacancies</p>
                                <p class="text-gray-400 text-sm mt-1 mb-6">Explore our vacancies and bookmark them to keep track of them here.</p>
                                <a href="/pelamar/lowongan" class="inline-flex items-center gap-2 bg-[#15803d] hover:bg-[#166534] text-white text-xs font-semibold px-5 py-2.5 rounded-lg transition-colors">
                                    Browse Vacancies
                                </a>
                            </div>
                        `;
                    }
                }, 300);
            }
        } else {
            alert('Gagal menghapus bookmark.');
        }
    })
    .catch(e => {
        console.error(e);
        alert('Terjadi kesalahan koneksi.');
    });
}
</script>
@endsection
