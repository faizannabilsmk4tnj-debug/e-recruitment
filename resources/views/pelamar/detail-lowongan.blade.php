@extends('layouts.pelamar')

@section('title', 'Vacancy Detail')
@section('nav-lowongan', 'active')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
    <a href="/pelamar/dashboard" class="hover:text-green-700 transition-colors">Home</a>
    <span>›</span>
    <a href="/pelamar/lowongan" class="hover:text-green-700 transition-colors">Vacancies</a>
    <span>›</span>
    <span class="text-gray-700 font-medium" id="breadcrumb-title">{{ $vacancy->title }}</span>
</div>

<!-- Main Content Grid -->
<div class="flex flex-col lg:flex-row gap-6 items-start">

    <!-- LEFT: Job Details (2/3) -->
    <div class="flex-1 space-y-6 w-full">

        <!-- Header Card -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            @if($vacancy->banner_image)
            <div class="w-full h-48 relative">
                <img src="{{ asset($vacancy->banner_image) }}" alt="Cover Banner" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="p-8 {{ $vacancy->banner_image ? 'relative -mt-6 rounded-t-3xl bg-white z-10' : '' }}">
                <!-- Category Badge -->
                <div class="mb-3">
                    <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-md uppercase tracking-wider">
                        {{ $vacancy->category->name ?? 'General' }}
                    </span>
                </div>

                <!-- Text content safely on white background -->
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-gray-900" id="job-title">{{ $vacancy->title }}</h1>
                        @if($vacancy->status === 'open')
                        <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-0.5 rounded-full uppercase shrink-0" id="job-badge">Active</span>
                        @elseif($vacancy->status === 'filled')
                        <span class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 px-2.5 py-0.5 rounded-full uppercase shrink-0" id="job-badge">Filled</span>
                        @else
                        <span class="text-xs font-bold text-red-700 bg-red-50 border border-red-200 px-2.5 py-0.5 rounded-full uppercase shrink-0" id="job-badge">Closed</span>
                        @endif
                    </div>
                    <p class="text-green-700 font-medium mt-1" id="job-company">PT Ecogreen Oleochemicals</p>
                    <div class="flex items-center gap-4 mt-4 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span id="job-location">{{ $vacancy->location }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span id="job-type">{{ ucfirst($vacancy->employment_type) }}</span>
                        </span>
                        @if($vacancy->age_min || $vacancy->age_max)
                        <span class="flex items-center gap-1.5 text-amber-700 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span id="job-age">Age: {{ $vacancy->age_min ?? 'Any' }} - {{ $vacancy->age_max ?? 'Any' }} Yrs</span>
                        </span>
                        @endif
                        @if($vacancy->show_salary && $vacancy->salary_min && $vacancy->salary_max)
                        <span class="flex items-center gap-1.5 text-green-700 font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                            <span>Rp {{ number_format($vacancy->salary_min, 0, ',', '.') }} - {{ number_format($vacancy->salary_max, 0, ',', '.') }}</span>
                        </span>
                        @endif
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            <span id="job-posted">Posted {{ $vacancy->created_at->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>
            </div>
 
            <!-- Slot Progress -->
            @php
                $remainingSlots = max(0, $vacancy->quota - $vacancy->applicant_count);
                $progress = $vacancy->quota > 0 ? min(100, ($vacancy->applicant_count / $vacancy->quota) * 100) : 0;
            @endphp
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="flex items-center justify-between mb-1">
                    <div>
                        <p class="text-sm font-bold text-gray-900">Slots Filled</p>
                        <p class="text-xs text-gray-500" id="slot-desc">{{ $remainingSlots }} positions remaining out of {{ $vacancy->quota }} total</p>
                    </div>
                    <span class="text-sm font-bold text-gray-900" id="slot-count">{{ $vacancy->applicant_count }}/{{ $vacancy->quota }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-green-600 h-2 rounded-full transition-all" id="slot-bar" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>
 
        <!-- Deskripsi -->
        <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Job Description</h2>
            <div class="text-sm text-gray-600 leading-relaxed ck-content" id="job-description">
                @if(str_contains($vacancy->description, '<') && str_contains($vacancy->description, '>'))
                    {!! $vacancy->description !!}
                @else
                    {!! nl2br(e($vacancy->description)) !!}
                @endif
            </div>
 
            <h2 class="text-lg font-bold text-gray-900 mt-8 mb-4">Qualifications</h2>
            <div class="text-sm text-gray-600 leading-relaxed ck-content" id="job-qualifications">
                @if(str_contains($vacancy->requirements, '<') && str_contains($vacancy->requirements, '>'))
                    {!! $vacancy->requirements !!}
                @else
                    <ul class="space-y-2.5 text-sm text-gray-600">
                        @foreach(explode("\n", str_replace("\r", "", $vacancy->requirements)) as $req)
                            @if(trim($req))
                                <li class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                    {{ trim($req) }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
 
            <h2 class="text-lg font-bold text-gray-900 mt-8 mb-4">Benefits & Facilities</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="job-benefits">
                @if($vacancy->benefits)
                    @foreach(explode(",", $vacancy->benefits) as $benefit)
                        @php $benefit = trim($benefit); @endphp
                        @if($benefit)
                            <div class="flex items-start gap-3 bg-gray-50 rounded-lg p-4 border border-gray-100">
                                <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">{{ $benefit }}</p>
                                    <p class="text-xs text-gray-500">Provided for this position.</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="col-span-2 text-sm text-gray-400 italic">No specific benefits listed.</div>
                @endif
            </div>
        </div>
    </div>
 
    <!-- RIGHT: Action Panel (1/3) -->
    <div class="w-full lg:w-80 shrink-0 space-y-6">
 
        <!-- Tindakan Cepat -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <h3 class="font-bold text-gray-900 mb-2">Quick Actions</h3>
            <p class="text-sm text-gray-500 mb-5">Interested in this position? Apply now before the quota is full.</p>
            
            @if($vacancy->status !== 'open')
            <span class="flex items-center justify-center gap-2 w-full bg-gray-100 border border-gray-200 text-gray-400 font-semibold py-3 rounded-lg text-sm cursor-not-allowed mb-3">
                {{ $vacancy->status === 'filled' ? 'Filled' : 'Closed' }}
            </span>
            @elseif(!auth()->user()->has_privilege)
            <button disabled class="flex items-center justify-center gap-2 w-full bg-gray-100 border border-gray-200 text-gray-400 font-semibold py-3 rounded-lg text-sm cursor-not-allowed mb-3" title="Your access privileges have been suspended by HR.">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Apply Suspended
            </button>
            <p class="text-[10px] text-red-600 text-center font-semibold mb-3">⚠️ Apply privilege suspended by HR.</p>
            @else
            <a href="/pelamar/review-lamaran/{{ $vacancy->id }}" class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                Apply Now
            </a>
            @endif

            <button id="btn-save-job" data-job-id="{{ $vacancy->id }}" class="flex items-center justify-center gap-2 w-full border {{ $isSaved ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-300 hover:bg-gray-50 text-gray-700' }} font-semibold py-3 rounded-lg text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $isSaved ? 'fill-amber-500 text-amber-500' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                </svg>
                <span>{{ $isSaved ? 'Saved' : 'Save Job' }}</span>
            </button>

            <!-- Share -->
            <div class="mt-5 pt-4 border-t border-gray-150">
                <p class="text-xs text-gray-500 flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" x2="12" y1="2" y2="15"/></svg>
                    Share this vacancy
                </p>
                <div class="flex gap-2">
                    <button class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </button>
                    <button class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </button>
                    <button class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors" onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied to clipboard!');">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tentang Perusahaan -->
        <div class="bg-green-50 rounded-2xl border border-green-200 p-6 shadow-sm">
            <h3 class="font-bold text-green-900 mb-2">About Company</h3>
            <p class="text-sm text-green-850 leading-relaxed">PT Ecogreen Oleochemicals is one of the world's leading natural fatty alcohol producers committed to sustainability and high quality.</p>
            <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 mt-3 transition-colors">
                View Company Profile
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnSave = document.getElementById('btn-save-job');
    if (btnSave) {
        btnSave.addEventListener('click', function () {
            const jobId = this.dataset.jobId;
            btnSave.disabled = true;

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
                btnSave.disabled = false;
                if (data.success) {
                    const icon = btnSave.querySelector('svg');
                    const text = btnSave.querySelector('span');
                    
                    if (data.is_saved) {
                        btnSave.className = "flex items-center justify-center gap-2 w-full border border-amber-500 bg-amber-50 text-amber-700 font-semibold py-3 rounded-lg text-sm transition-colors";
                        icon.classList.add('fill-amber-500', 'text-amber-500');
                        text.textContent = 'Saved';
                    } else {
                        btnSave.className = "flex items-center justify-center gap-2 w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 rounded-lg text-sm transition-colors";
                        icon.classList.remove('fill-amber-500', 'text-amber-500');
                        text.textContent = 'Save Job';
                    }
                } else {
                    alert('Failed to save vacancy.');
                }
            })
            .catch(e => {
                btnSave.disabled = false;
                console.error(e);
                alert('A connection error occurred.');
            });
        });
    }
});
</script>
@endsection
