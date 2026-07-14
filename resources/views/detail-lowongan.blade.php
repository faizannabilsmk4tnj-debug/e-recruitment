@extends($layout ?? 'layouts.landing')

@section('title', 'Vacancy Detail')
@if(!isset($layout))
@section('nav-lowongan', 'text-white font-semibold')
@endif

@section('content')

<!-- Breadcrumb -->
<div class="px-16 py-4 bg-white border-b border-gray-100">
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ isset($layout) ? '/pelamar/dashboard' : '/' }}" class="hover:text-green-700 transition-colors">Home</a>
        <span>›</span>
        <a href="{{ isset($layout) ? '/pelamar/lowongan' : '/lowongan' }}" class="hover:text-green-700 transition-colors">Vacancies</a>
        <span>›</span>
        <span class="text-gray-700 font-medium" id="breadcrumb-title">{{ $vacancy->title }}</span>
    </div>
</div>

<!-- Main Content -->
<section class="px-16 py-8 bg-gray-50">
    <div class="flex gap-6 items-start">

        <!-- LEFT: Job Details (2/3) -->
        <div class="flex-1 space-y-6">

            <!-- Header Card -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
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

                    <!-- Title & Status -->
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-bold text-gray-900" id="job-title">{{ $vacancy->title }}</h1>
                        @if($vacancy->status === 'open')
                        <span class="text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-0.5 rounded-full uppercase shrink-0" id="job-badge">Active</span>
                        @else
                        <span class="text-xs font-bold text-red-700 bg-red-50 border border-red-200 px-2.5 py-0.5 rounded-full uppercase shrink-0" id="job-badge">Closed</span>
                        @endif
                    </div>
                    <p class="text-green-700 font-medium mt-1" id="job-company">PT Ecogreen Oleochemicals</p>
                    
                    <div class="flex items-center gap-4 mt-4 text-sm text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span id="job-location">{{ $vacancy->location }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span id="job-type">{{ ucfirst($vacancy->employment_type) }}</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            <span id="job-posted">Posted {{ $vacancy->created_at->diffForHumans() }}</span>
                        </span>
                    </div>
                </div>

                <!-- Slot Progress -->
                @php
                    $remainingSlots = max(0, $vacancy->quota - $vacancy->applicant_count);
                    $progress = $vacancy->quota > 0 ? min(100, ($vacancy->applicant_count / $vacancy->quota) * 100) : 0;
                @endphp
                <div class="bg-gray-50 rounded-lg p-4">
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
            <div class="bg-white rounded-xl border border-gray-200 p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Job Description</h2>
                <div class="text-sm text-gray-600 leading-relaxed space-y-3" id="job-description">
                    {!! nl2br(e($vacancy->description)) !!}
                </div>

                <h2 class="text-lg font-bold text-gray-900 mt-8 mb-4">Qualifications</h2>
                <ul class="space-y-2.5 text-sm text-gray-600" id="job-qualifications">
                    @foreach(explode("\n", str_replace("\r", "", $vacancy->requirements)) as $req)
                        @if(trim($req))
                            <li class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                {{ trim($req) }}
                            </li>
                        @endif
                    @endforeach
                </ul>

                <h2 class="text-lg font-bold text-gray-900 mt-8 mb-4">Keuntungan & Fasilitas</h2>
                <div class="grid grid-cols-2 gap-4" id="job-benefits">
                    @if($vacancy->benefits)
                        @foreach(explode(",", $vacancy->benefits) as $benefit)
                            @php $benefit = trim($benefit); @endphp
                            @if($benefit)
                                <div class="flex items-start gap-3 bg-gray-50 rounded-lg p-4">
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
        <div class="w-80 shrink-0 space-y-6">

            <!-- Tindakan Cepat -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="font-bold text-gray-900 mb-2">Quick Actions</h3>
                <p class="text-sm text-gray-500 mb-5">Interested in this position? Apply now before the quota is full.</p>
                @if($vacancy->status !== 'open')
                <span class="flex items-center justify-center gap-2 w-full bg-gray-100 text-gray-400 font-semibold py-3 rounded-lg text-sm cursor-not-allowed mb-3">
                    Closed / Filled
                </span>
                @elseif(isset($layout) && $layout === 'layouts.pelamar-public')
                <a href="/pelamar/review-lamaran/{{ $vacancy->id }}" class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Apply Now
                </a>
                @else
                <button data-auth-required class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Apply Now
                </button>
                @endif
                <button data-auth-required class="flex items-center justify-center gap-2 w-full border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    Save Job
                </button>


            </div>

            <!-- Tentang Perusahaan -->
            <div class="bg-green-50 rounded-xl border border-green-200 p-6">
                <h3 class="font-bold text-green-900 mb-2">About Company</h3>
                <p class="text-sm text-green-800 leading-relaxed">PT Ecogreen Oleochemicals is one of the world's leading natural fatty alcohol producers committed to sustainability and high quality.</p>
                <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 mt-3 transition-colors">
                    View Company Profile
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection