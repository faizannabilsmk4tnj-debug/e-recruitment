@extends('layouts.hr')

@section('title', 'Applicant Detail')
@section('page-title', 'Applicant Detail')
@section('nav-pelamar', 'text-green-800 border-green-800')

@php
    $empty = 'Not specified';
    $statusLabels = [
        'applied' => 'Submitted',
        'shortlisted' => 'Shortlisted',
        'interview' => 'Interview',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
        'withdrawn' => 'Withdrawn',
    ];
    $statusClasses = [
        'applied' => 'bg-gray-100 text-gray-700 border-gray-200',
        'shortlisted' => 'bg-amber-50 text-amber-700 border-amber-200',
        'interview' => 'bg-blue-50 text-blue-700 border-blue-200',
        'accepted' => 'bg-green-50 text-green-700 border-green-200',
        'rejected' => 'bg-red-50 text-red-700 border-red-200',
        'withdrawn' => 'bg-gray-100 text-gray-500 border-gray-200',
    ];
    $updateStatusOptions = [
        'shortlisted' => 'Shortlisted',
        'interview' => 'Interview',
        'accepted' => 'Accepted',
        'rejected' => 'Rejected',
    ];
    $latestRole = $workExperiences->first()?->position ?? $user->job_title ?? 'Applicant';
    $cityLine = collect([optional($profile)->city, optional($profile)->province])->filter()->implode(', ');
    $ktpSameAsDom = optional($profile)->ktp_address
        && optional($profile)->ktp_address === optional($profile)->dom_address
        && optional($profile)->ktp_city === optional($profile)->dom_city
        && optional($profile)->ktp_province === optional($profile)->dom_province;
@endphp

@section('content')
<div class="px-8 py-8 max-w-7xl mx-auto">
    <div class="mb-6 flex items-center text-sm text-gray-500 gap-2">
        <a href="/hr/pelamar" class="hover:text-green-800 transition-colors">Applicants</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">{{ $user->name }}</span>
    </div>

    {{-- Header Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col lg:flex-row items-start gap-6 relative">
        {{-- Photo --}}
        <div class="relative">
            <img src="{{ optional($profile)->avatar_url ? (Str::startsWith($profile->avatar_url, ['http', '/']) ? $profile->avatar_url : asset('storage/' . $profile->avatar_url)) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=14532d&color=fff&size=128' }}" alt="{{ $user->name }}" class="w-28 h-28 rounded-xl object-cover shadow-sm">
            {{-- Verified Badge --}}
            <div class="absolute -bottom-2 -right-2 bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center border-2 border-white">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </div>

        <div class="flex-1 pt-1">
            <div class="flex flex-wrap items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                <span id="current-status-badge" class="text-[11px] font-bold px-3 py-1 rounded-full border uppercase {{ $statusClasses[$application->status] ?? $statusClasses['applied'] }}">
                    {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                </span>
            </div>
            <div class="text-gray-600 mt-1 mb-4 font-medium">{{ $latestRole }} for {{ optional($application->job)->title ?? $empty }}</div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="font-semibold text-gray-900">Email:</span> {{ $user->email }}
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span class="font-semibold text-gray-900">Phone:</span> {{ $user->phone ?? optional($profile)->phone ?? $empty }}
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-semibold text-gray-900">Location:</span> {{ $cityLine ?: $empty }}
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="font-semibold text-gray-900">Applied:</span> {{ optional($application->created_at)->format('d M Y H:i') ?? $empty }}
                </div>
                <div class="flex items-center gap-2 col-span-1 md:col-span-2 lg:col-span-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    <span class="font-semibold text-gray-900">Source:</span> 
                    <span class="capitalize bg-green-50 text-green-800 text-xs px-2 py-0.5 rounded-full border border-green-200 font-bold">{{ $application->source ?: 'Website' }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 w-full lg:w-auto items-stretch lg:items-end">
            <div class="flex items-center gap-2">
                <button type="button" onclick="openCvPreviewModal('/hr/pelamar/{{ $application->id }}/cv-preview')"
                   class="inline-flex justify-center items-center gap-2 border border-green-200 bg-green-50 text-green-800 font-semibold px-4 py-2 rounded-lg text-sm hover:bg-green-100 transition-colors shadow-sm w-full cursor-pointer">
                    Open CV
                </button>
            </div>
            @if($application->resume_title)
                <div class="text-[11px] text-gray-500 font-medium lg:text-right mt-1">
                    CV File: <span class="text-green-800 font-semibold">{{ $application->resume_title }}</span>
                </div>
            @endif
        </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIK</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->nik ?? $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Full Name</div><div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Gender</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->gender ? ucfirst($profile->gender) : $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Marital Status</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->marital_status ? ucfirst($profile->marital_status) : $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Birth</div><div class="text-sm font-semibold text-gray-900">{{ collect([optional($profile)->birth_place, optional(optional($profile)->birth_date)->format('d M Y')])->filter()->implode(', ') ?: $empty }}</div></div>
                    <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Age</div><div class="text-sm font-semibold text-gray-900">{{ $age }}</div></div>
                </div>
            </section>

            @if($application->cover_letter)
            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Cover Letter</h3>
                <div class="bg-green-50/20 border border-green-100/50 rounded-xl p-5 text-sm text-gray-700 whitespace-pre-line leading-relaxed">{{ $application->cover_letter }}</div>
            </section>
            @endif

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Education</h3>
                @forelse($educations as $education)
                    <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <div class="font-bold text-gray-900">{{ $education->degree ?? $empty }}{{ $education->major ? ' - ' . $education->major : '' }}</div>
                                <div class="text-sm text-gray-600">{{ $education->institution ?? $empty }}</div>
                            </div>
                            <div class="text-sm text-gray-500">{{ $education->start_year ?? '?' }} - {{ $education->end_year ?? '?' }}</div>
                        </div>
                        <div class="text-sm text-gray-500 mt-2">GPA: {{ $education->gpa ?? optional($profile)->gpa ?? $empty }}</div>
                    </div>
                @empty
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Latest Education</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->latest_education ? strtoupper($profile->latest_education) : $empty }}</div></div>
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">School / University</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->school_name ?? $empty }}</div></div>
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Graduation</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->education_completed_at ?? $empty }}</div></div>
                        <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">GPA</div><div class="text-sm font-semibold text-gray-900">{{ optional($profile)->gpa ?? $empty }}</div></div>
                    </div>
                @endforelse
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Address Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="bg-green-50/40 border border-green-100 rounded-xl p-5">
                        <h4 class="text-sm font-bold text-green-900 tracking-wider mb-4">ID Card Address</h4>
                        <div class="space-y-3 text-sm">
                            <div><span class="font-semibold text-gray-900">Province:</span> {{ optional($profile)->ktp_province ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">City:</span> {{ optional($profile)->ktp_city ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">District:</span> {{ optional($profile)->ktp_district ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Sub-district:</span> {{ optional($profile)->ktp_subdistrict ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Address:</span> {{ optional($profile)->ktp_address ?? optional($profile)->address ?? $empty }}</div>
                        </div>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <h4 class="text-sm font-bold text-green-900 tracking-wider">Domicile Address</h4>
                            @if($ktpSameAsDom)
                                <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Same as ID</span>
                            @endif
                        </div>
                        <div class="space-y-3 text-sm">
                            <div><span class="font-semibold text-gray-900">Province:</span> {{ optional($profile)->dom_province ?? optional($profile)->province ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">City:</span> {{ optional($profile)->dom_city ?? optional($profile)->city ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">District:</span> {{ optional($profile)->dom_district ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Sub-district:</span> {{ optional($profile)->dom_subdistrict ?? $empty }}</div>
                            <div><span class="font-semibold text-gray-900">Address:</span> {{ optional($profile)->dom_address ?? optional($profile)->address ?? $empty }}</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Experience & Skills</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Work Experience</h4>
                        @forelse($workExperiences as $work)
                            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                                <div class="font-bold text-gray-900">{{ $work->position ?? $empty }}</div>
                                <div class="text-sm text-gray-600">{{ $work->company_name ?? $empty }} | {{ optional($work->start_date)->format('M Y') ?? '?' }} - {{ $work->is_current ? 'Present' : (optional($work->end_date)->format('M Y') ?? '?') }}</div>
                                @if($work->description)<p class="text-sm text-gray-500 mt-2">{{ $work->description }}</p>@endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No work experience added.</p>
                        @endforelse
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Organization Experience</h4>
                        @forelse($organizationExperiences as $org)
                            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                                <div class="font-bold text-gray-900">{{ $org->position ?? $empty }}</div>
                                <div class="text-sm text-gray-600">{{ $org->organization_name ?? $empty }} | {{ optional($org->start_date)->format('M Y') ?? '?' }} - {{ optional($org->end_date)->format('M Y') ?? 'Present' }}</div>
                                @if($org->description)<p class="text-sm text-gray-500 mt-2">{{ $org->description }}</p>@endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No organization experience added.</p>
                        @endforelse
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Skills</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($skills as $skill)
                                <span class="text-xs font-semibold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full">{{ $skill->skill_name }}</span>
                            @empty
                                <span class="text-sm text-gray-400">No skills added.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900">CV Preview</h3>
                    <div class="flex items-center gap-4">
                        @if($application->resume_url)
                            <a href="{{ asset($application->resume_url) }}" target="_blank" class="text-sm text-blue-700 font-bold hover:underline flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                Download Uploaded CV
                            </a>
                        @endif
                        <a href="/hr/pelamar/{{ $application->id }}/cv-preview" target="_blank" class="text-sm text-green-800 font-bold hover:underline">Open full CV</a>
                    </div>
                </div>
                <div class="bg-gray-100 rounded-xl p-4 overflow-hidden">
                    @if($application->resume_url && (Str::endsWith($application->resume_url, '.pdf') || Str::endsWith($application->resume_url, '.PDF')))
                        <iframe src="{{ asset($application->resume_url) }}" title="CV {{ $user->name }}" class="w-full h-[720px] bg-white rounded border border-gray-200"></iframe>
                    @else
                        <iframe src="/hr/pelamar/{{ $application->id }}/cv-preview" title="CV {{ $user->name }}" class="w-full h-[720px] bg-white rounded border border-gray-200"></iframe>
                    @endif
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Application Status</h3>
                
                <div class="mb-5 flex items-center justify-between bg-gray-50 border border-gray-100 rounded-xl p-3.5 shadow-inner">
                    <span class="text-xs font-bold text-gray-500">Current Status:</span>
                    <span id="current-status-badge" class="text-[10px] font-bold px-2.5 py-1 rounded-full border uppercase {{ $statusClasses[$application->status] ?? $statusClasses['applied'] }}">
                        {{ $statusLabels[$application->status] ?? $application->status }}
                    </span>
                </div>

                <div class="space-y-2.5">
                    <!-- 1. Shortlist -->
                    <button onclick="triggerQuickStatus('shortlisted')" 
                            @disabled(in_array($application->status, ['shortlisted', 'interview', 'accepted', 'rejected', 'withdrawn']))
                            class="w-full text-left bg-amber-50 hover:bg-amber-100 text-amber-800 border {{ $application->status === 'shortlisted' ? 'border-amber-500 ring-2 ring-amber-500/20 font-bold' : 'border-amber-100' }} text-sm font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-between group disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Mark as Shortlisted
                        </span>
                        @if($application->status === 'shortlisted')
                            <span class="text-[9px] bg-amber-600 text-white px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shadow-sm">Current</span>
                        @elseif(in_array($application->status, ['interview', 'accepted', 'rejected', 'withdrawn']))
                            <span class="text-[10px] text-gray-400">Completed</span>
                        @else
                            <span class="text-xs text-amber-500 group-hover:translate-x-1 transition-transform">→</span>
                        @endif
                    </button>

                    <!-- 2. Schedule Interview -->
                    <button id="btn-action-interview"
                            @disabled(in_array($application->status, ['applied', 'accepted', 'rejected', 'withdrawn']))
                            class="w-full text-left bg-blue-50 hover:bg-blue-100 text-blue-800 border {{ $application->status === 'interview' ? 'border-blue-500 ring-2 ring-blue-500/20 font-bold' : 'border-blue-100' }} text-sm font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-between group disabled:opacity-55 disabled:cursor-not-allowed"
                            title="{{ $application->status === 'applied' ? 'Must shortlist applicant before scheduling interview' : '' }}">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            Schedule Interview
                        </span>
                        @if($application->status === 'interview')
                            <span class="text-[9px] bg-blue-600 text-white px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shadow-sm">Current</span>
                        @elseif($application->status === 'applied')
                            <span class="text-[9px] bg-gray-200 text-gray-500 px-2 py-0.5 rounded font-medium">LOCKED</span>
                        @else
                            <span class="text-xs text-blue-500 group-hover:translate-x-1 transition-transform">→</span>
                        @endif
                    </button>

                    <!-- 3. Accept -->
                    <button onclick="triggerQuickStatus('accepted')" 
                            @disabled(in_array($application->status, ['accepted', 'rejected', 'withdrawn']))
                            class="w-full text-left bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border {{ $application->status === 'accepted' ? 'border-emerald-500 ring-2 ring-emerald-500/20 font-bold' : 'border-emerald-100' }} text-sm font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-between group disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Accept & Offer
                        </span>
                        @if($application->status === 'accepted')
                            <span class="text-[9px] bg-emerald-600 text-white px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shadow-sm">Current</span>
                        @else
                            <span class="text-xs text-emerald-500 group-hover:translate-x-1 transition-transform">→</span>
                        @endif
                    </button>

                    <!-- 4. Reject -->
                    <button onclick="triggerQuickStatus('rejected')" 
                            @disabled(in_array($application->status, ['accepted', 'rejected', 'withdrawn']))
                            class="w-full text-left bg-red-50 hover:bg-red-100 text-red-800 border {{ $application->status === 'rejected' ? 'border-red-500 ring-2 ring-red-500/20 font-bold' : 'border-red-100' }} text-sm font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-between group disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Reject Candidate
                        </span>
                        @if($application->status === 'rejected')
                            <span class="text-[9px] bg-red-600 text-white px-2 py-0.5 rounded-full font-bold uppercase tracking-wider shadow-sm">Current</span>
                        @else
                            <span class="text-xs text-red-500 group-hover:translate-x-1 transition-transform">→</span>
                        @endif
                    </button>
                </div>

                <!-- Admin override section -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="toggleAdminOverride()" class="text-[10px] text-gray-400 hover:text-green-800 font-bold transition-colors uppercase tracking-wider block mx-auto">
                        ⚙ Manual Override
                    </button>
                    <div id="admin-override-box" class="hidden mt-3 bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                        <form id="form-ubah-status" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[9px] font-bold text-gray-450 uppercase tracking-widest mb-1">Status</label>
                                <select name="status" class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                                    @foreach($updateStatusOptions as $value => $label)
                                        <option value="{{ $value }}" @selected($application->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold py-2 rounded-lg transition">Apply</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- System Privilege Control --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Access Privilege Control</h3>
                <p class="text-xs text-gray-500 mb-4">
                    This candidate's application privilege is managed directly on the database server by the <strong>Database Administrator (DBA)</strong>.
                </p>
                
                <div class="mb-5 flex items-center justify-between bg-gray-50 border border-gray-100 rounded-xl p-3.5 shadow-inner">
                    <span class="text-xs font-bold text-gray-500">Access Privilege Status:</span>
                    <span id="privilege-status-badge" class="text-[10px] font-bold px-2.5 py-1 rounded-full border uppercase {{ $user->has_privilege ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                        {{ $user->has_privilege ? 'Granted' : 'Revoked' }}
                    </span>
                </div>

                {{-- Simulation Button for DBA changes --}}
                <button type="button" onclick="togglePrivilegeAccess()" id="btn-toggle-privilege" 
                        class="w-full flex items-center justify-center gap-2 border border-dashed {{ $user->has_privilege ? 'border-red-300 bg-red-50/50 text-red-800 hover:bg-red-50' : 'border-green-300 bg-green-50/50 text-green-800 hover:bg-green-50' }} text-xs font-semibold px-5 py-2.5 rounded-lg transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @if($user->has_privilege)
                        Simulate Revoke Access (DBA Revoke)
                    @else
                        Simulate Grant Access (DBA Grant)
                    @endif
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Internal Note</h3>
                <form id="form-add-note" class="space-y-4">
                    @csrf
                    <textarea name="note" rows="3" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Write internal HR note..."></textarea>
                    <button type="submit" class="w-full border border-green-200 bg-green-50 text-green-800 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-green-100 transition">Add Note</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Activity Log</h3>
                <div id="activity-log" class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($statusLogs as $log)
                        <div class="border-l-2 border-green-700 pl-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="text-xs font-bold text-gray-900">{{ $log->changer_name }}</div>
                                <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $statusLabels[$log->old_status] ?? $log->old_status }} -> {{ $statusLabels[$log->new_status] ?? $log->new_status }}</div>
                            @if($log->reason)<div class="text-sm text-gray-700 mt-2 bg-gray-50 rounded-lg p-3">{{ $log->reason }}</div>@endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">No activity logged yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Interview Session</h3>
                <p class="text-xs text-gray-500 mb-4">All matters related to the interview (schedule, reschedule, attendance status, and evaluation inputs) are managed on the Interview page.</p>
                <a href="/hr/wawancara/daftar?search={{ urlencode($user->name) }}" class="inline-flex items-center justify-center w-full bg-green-800 hover:bg-green-950 text-white text-xs font-semibold py-2.5 rounded-lg transition-colors gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Manage Candidate Interview
                </a>
            </div>
        </div>
    </div>
</div>

<div id="modal-jadwal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" id="modal-jadwal-backdrop"></div>
    <div class="absolute inset-y-0 right-0 w-full max-w-xl bg-white shadow-2xl flex flex-col">
        <div class="flex items-center justify-between px-8 py-6 border-b border-gray-100">
            <div>
                <h2 class="text-2xl font-extrabold text-green-900">Schedule Interview</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $user->name }}</p>
            </div>
            <button type="button" id="btn-close-modal" class="text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="form-interview" class="flex-1 flex flex-col">
            @csrf
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Candidate</label>
                    <input type="text" value="{{ $user->name }}" readonly class="w-full px-4 py-2 border border-gray-200 bg-gray-50 rounded-lg text-sm text-gray-700 font-semibold focus:outline-none">
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Date</label>
                        <input type="date" id="interview_date" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Time (24h)</label>
                        <div class="flex items-center gap-1.5">
                            <select id="interview_hour" class="w-full px-2 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-center">
                                @for($i = 0; $i < 24; $i++)
                                    @php $h = sprintf('%02d', $i); @endphp
                                    <option value="{{ $h }}">{{ $h }}</option>
                                @endfor
                            </select>
                            <span class="text-gray-400 font-bold">:</span>
                            <select id="interview_minute" class="w-full px-2 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white text-center">
                                @for($i = 0; $i < 60; $i += 5)
                                    @php $m = sprintf('%02d', $i); @endphp
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endfor
                            </select>
                        </div>
                        <input name="scheduled_at" type="hidden" id="interview_scheduled_at">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Duration</label>
                        <select name="duration_minutes" id="interview_duration" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                            <option value="30">30 Minutes</option>
                            <option value="60" selected>60 Minutes</option>
                            <option value="90">90 Minutes</option>
                            <option value="120">120 Minutes</option>
                        </select>
                    </div>
                </div>

                {{-- Booked slots timeline container --}}
                <div id="interview_booked_timeline" class="hidden text-xs bg-amber-50/60 border border-amber-200 rounded-xl p-3.5 text-amber-900 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Booked Interviews for Today:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5" id="interview_booked_slots_list">
                    </ul>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Interview Type</label>
                    <select name="interview_type" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Location / Meeting Link</label>
                    <input name="location_or_link" type="text" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="https://meet.google.com/...">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Notes</label>
                    
                    {{-- Quick Templates for Interview --}}
                    <div id="interview-templates-container" class="mb-3">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Choose Interview Notes Template:</span>
                        <div class="flex flex-col gap-1.5 max-h-36 overflow-y-auto p-1 bg-gray-50 border border-gray-150 rounded-xl" id="interview-templates-list">
                            <!-- populated by JS -->
                        </div>
                    </div>

                    <textarea name="notes" id="interview-notes-input" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Interview notes..."></textarea>
                </div>
            </div>
            <div class="border-t border-gray-100 px-8 py-4 flex items-center justify-between bg-white">
                <button type="button" id="btn-cancel-modal" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 transition-colors">Cancel</button>
                <button type="submit" class="bg-green-800 hover:bg-green-900 text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md transition">Schedule Session</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Quick Status Update -->
<div id="modal-quick-status" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeQuickStatusModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 max-w-md w-full overflow-hidden animate-card" style="opacity: 1;">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <h3 id="quick-modal-title" class="font-extrabold text-lg text-gray-900">Change Status</h3>
                <button type="button" onclick="closeQuickStatusModal()" class="text-gray-400 hover:text-gray-600 bg-gray-100 rounded-full p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="form-quick-status" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="status" id="quick-status-input">
                <p id="quick-modal-desc" class="text-sm text-gray-500 font-medium"></p>
                <div>
                    <label id="quick-modal-label" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Notes / Feedback for Applicant</label>
                    
                    {{-- Quick Templates Selection --}}
                    <div id="quick-templates-container" class="mb-3 hidden">
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Choose Response Template:</span>
                        <div class="flex flex-col gap-1.5 max-h-36 overflow-y-auto p-1 bg-gray-50 border border-gray-150 rounded-xl" id="quick-templates-list">
                            <!-- populated by JS -->
                        </div>
                    </div>

                    <textarea name="reason" id="quick-reason-input" rows="4" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Optional notes..."></textarea>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-3 justify-end pt-2">
                    <button type="button" onclick="closeQuickStatusModal()" class="w-full sm:w-auto text-sm font-semibold text-gray-500 hover:text-gray-800 px-4 py-2 order-3 sm:order-1 text-center">Cancel</button>
                    <button type="button" id="quick-modal-schedule-btn" onclick="switchToInterviewModal()" class="w-full sm:w-auto hidden bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-bold px-4 py-2.5 rounded-xl border border-blue-200 order-2 text-center transition-colors">Schedule Interview Instead</button>
                    <button type="submit" id="quick-modal-submit" class="w-full sm:w-auto bg-green-800 hover:bg-green-900 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition order-1 sm:order-3">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const statusLabels = @json($statusLabels);
    const statusClasses = @json($statusClasses);
    const applicationId = {{ $application->id }};

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

    async function submitJson(url, payload) {
        const response = await fetch(url, {
            method: 'POST',
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

    // ===== QUICK STATUS MODAL =====
    const quickModal = document.getElementById('modal-quick-status');
    const quickTitle = document.getElementById('quick-modal-title');
    const quickDesc = document.getElementById('quick-modal-desc');
    const quickStatusInput = document.getElementById('quick-status-input');
    const quickReasonInput = document.getElementById('quick-reason-input');
    const quickSubmitBtn = document.getElementById('quick-modal-submit');

    const scheduleBtnInQuickModal = document.getElementById('quick-modal-schedule-btn');

    // Predefined feedback templates for HR status changes and scheduling
    const feedbackTemplates = {
        shortlisted: [
            "Documents meet the requirements, scheduling for the interview phase.",
            "Your profile and portfolio align with the qualifications we need.",
            "Qualifications match, added to the priority shortlist for scheduling interviews."
        ],
        interview: [
            "The interview will be conducted online via Google Meet. Please prepare your CV and portfolio.",
            "Offline (face-to-face) interview at the Ecogreen main office. Please arrive 15 minutes before the scheduled time dressed in professional business attire.",
            "Initial screening (introductory) chat via phone to align expectations and scheduling."
        ],
        accepted: [
            "Congratulations! You have passed the selection process and are invited to join our team. The Offering Letter will be sent to your email shortly.",
            "Welcome aboard! You have been selected for this position. HR will contact you today to discuss the Offering Letter and onboarding date.",
            "Based on the interview results, we highly recommend you for this position. The HR team will contact you via phone shortly to discuss benefits and compensation package."
        ],
        rejected: [
            "[Document Review Unsuccessful] Thank you for applying. After reviewing your application, we regret to inform you that your qualifications/experience do not match our technical criteria at this time.",
            "[Interview Unsuccessful] Thank you for your time during the interview session. While we appreciated your profile, we have decided to move forward with another candidate who more closely fits the role requirements.",
            "[Talent Pool Database] Your qualifications are impressive, but this position has been filled. We will retain your profile in our talent pool and contact you if matching opportunities arise in the future."
        ]
    };

    // Helper to populate static interview templates
    const populateInterviewTemplates = () => {
        const templatesContainer = document.getElementById('interview-templates-container');
        const templatesList = document.getElementById('interview-templates-list');
        const notesInput = document.getElementById('interview-notes-input');
        if (templatesContainer && templatesList && notesInput) {
            templatesList.innerHTML = '';
            const list = feedbackTemplates.interview || [];
            list.forEach(tpl => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'w-full text-left text-[11px] bg-white hover:bg-green-50/50 border border-gray-200 hover:border-green-300 rounded-lg p-2 text-gray-700 transition cursor-pointer font-medium leading-relaxed';
                btn.textContent = tpl;
                btn.addEventListener('click', () => {
                    notesInput.value = tpl;
                });
                templatesList.appendChild(btn);
            });
        }
    };

    // Initialize interview templates
    populateInterviewTemplates();

    window.triggerQuickStatus = function(status) {
        quickStatusInput.value = status;
        quickReasonInput.value = '';
        
        const reasonLabel = document.getElementById('quick-modal-label');
        quickReasonInput.required = false;
        quickReasonInput.placeholder = 'Optional notes...';

        // Render Quick Templates
        const templatesContainer = document.getElementById('quick-templates-container');
        const templatesList = document.getElementById('quick-templates-list');
        if (templatesContainer && templatesList) {
            templatesList.innerHTML = '';
            const list = feedbackTemplates[status] || [];
            if (list.length > 0) {
                list.forEach(tpl => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'w-full text-left text-[11px] bg-white hover:bg-green-50/50 border border-gray-200 hover:border-green-300 rounded-lg p-2 text-gray-700 transition cursor-pointer font-medium leading-relaxed';
                    btn.textContent = tpl;
                    btn.addEventListener('click', () => {
                        quickReasonInput.value = tpl;
                    });
                    templatesList.appendChild(btn);
                });
                templatesContainer.classList.remove('hidden');
            } else {
                templatesContainer.classList.add('hidden');
            }
        }

        // Default: hide the schedule instead button
        if (scheduleBtnInQuickModal) scheduleBtnInQuickModal.classList.add('hidden');

        // Customize text based on status
        if (status === 'shortlisted') {
            quickTitle.textContent = 'Shortlist Candidate';
            quickDesc.textContent = 'Move this candidate to the Shortlist phase. You can then schedule an interview.';
            quickSubmitBtn.className = 'bg-amber-600 hover:bg-amber-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition';
            quickSubmitBtn.textContent = 'Confirm Shortlist';
        } else if (status === 'rejected') {
            quickTitle.textContent = 'Reject Candidate';
            quickDesc.textContent = 'Mark this application as Unsuccessful. An update will be posted to the applicant\'s dashboard.';
            quickSubmitBtn.className = 'bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition';
            quickSubmitBtn.textContent = 'Confirm Rejection';
        } else if (status === 'accepted') {
            // Check if skipping interview stage!
            const currentStatus = '{{ $application->status }}';
            if (currentStatus !== 'interview') {
                quickTitle.textContent = 'Skip Interview & Accept?';
                quickDesc.innerHTML = `<div class="bg-amber-50 border border-amber-200 rounded-xl p-3.5 text-xs text-amber-800 font-semibold mb-2 flex items-start gap-2 leading-relaxed">
                    <svg class="w-4 h-4 shrink-0 mt-0.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Warning: This candidate has not passed the interview stage yet. Are you sure you want to accept them directly? Please provide your justification below, or schedule an interview first.</span>
                </div>`;
                reasonLabel.textContent = 'Reason for skipping interview (Required)';
                quickReasonInput.placeholder = 'Explain why you are skipping the interview stage to accept this candidate...';
                quickReasonInput.required = true;
                quickSubmitBtn.className = 'bg-amber-600 hover:bg-amber-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition';
                quickSubmitBtn.textContent = 'Yes, Accept Candidate';

                // Show the "Schedule Interview Instead" button
                if (scheduleBtnInQuickModal) scheduleBtnInQuickModal.classList.remove('hidden');
            } else {
                quickTitle.textContent = 'Accept Candidate';
                quickDesc.textContent = 'Welcome the candidate and offer them the position. Enter any onboarding notes or feedback.';
                reasonLabel.textContent = 'Notes / Feedback for Applicant';
                quickSubmitBtn.className = 'bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-md transition';
                quickSubmitBtn.textContent = 'Confirm Acceptance';
            }
        }
        
        quickModal.classList.remove('hidden');
    };

    window.switchToInterviewModal = function() {
        closeQuickStatusModal();
        const interviewModal = document.getElementById('modal-jadwal');
        if (interviewModal) interviewModal.classList.remove('hidden');
    };

    window.closeQuickStatusModal = function() {
        quickModal.classList.add('hidden');
    };

    window.toggleAdminOverride = function() {
        const box = document.getElementById('admin-override-box');
        box.classList.toggle('hidden');
    };

    window.togglePrivilegeAccess = async function() {
        if (!confirm('Are you sure you want to change this applicant\'s application privilege?')) {
            return;
        }
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/toggle-privilege`, {});
            showToast(data.message || 'Access privilege updated successfully.');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            showToast(error.message || 'An error occurred.', 'error');
        }
    };

    document.getElementById('form-quick-status').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const targetStatus = formData.get('status');
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/status`, {
                status: targetStatus,
                reason: formData.get('reason'),
            });
            closeQuickStatusModal();
            showToast(data.message || 'Status successfully updated.');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    // ===== ADMINISTRATIVE OVERRIDE FORM =====
    document.getElementById('form-ubah-status').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/status`, {
                status: formData.get('status'),
                reason: formData.get('reason'),
            });
            showToast(data.message || 'Status successfully updated.');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    document.getElementById('form-add-note').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/note`, {
                note: formData.get('note'),
            });
            this.reset();
            showToast(data.message || 'Note saved successfully.');
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    // ===== INTERVIEW MODAL HANDLERS =====
    const modal = document.getElementById('modal-jadwal');
    
    const interviewDate = document.getElementById('interview_date');
    const interviewHour = document.getElementById('interview_hour');
    const interviewMinute = document.getElementById('interview_minute');
    const interviewDuration = document.getElementById('interview_duration');
    const interviewScheduledAt = document.getElementById('interview_scheduled_at');
    const interviewTimeline = document.getElementById('interview_booked_timeline');
    const interviewTimelineList = document.getElementById('interview_booked_slots_list');

    // Helper functions for booked slots booking system
    function timeToMinutes(timeStr) {
        const parts = timeStr.split(':');
        return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
    }

    async function fetchBookedSlots(dateInput, hourSelect, minuteSelect, durationSelect, timelineDiv, listUl) {
        const dateVal = dateInput.value;
        if (!dateVal) {
            timelineDiv.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`/hr/wawancara/booked-slots?date=${dateVal}`);
            const data = await response.json();
            if (!data.success) return;

            const slots = data.slots || [];

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
                return hStart < end && hEnd > start && (booking = s, true);
            });

            if (isBooked) {
                opt.disabled = true;
                opt.title = `Already booked for interview with ${booking.candidate} (${booking.job}) at ${booking.start} - ${booking.end}`;
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
                    opt.title = `Already booked for interview with ${booking.candidate} (${booking.job}) at ${booking.start} - ${booking.end}`;
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
            warning.innerHTML = `⚠️ Selected time conflicts with interview for <strong>${booking.candidate}</strong> (${booking.job}) at <strong>${booking.start} - ${booking.end}</strong>. Please choose another time or duration.`;
            
            const grid = hourSelect.closest('.grid') || hourSelect.parentElement;
            grid.after(warning);
        } else {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function syncScheduledAt() {
        if (interviewDate.value) {
            interviewScheduledAt.value = `${interviewDate.value}T${interviewHour.value}:${interviewMinute.value}`;
        } else {
            interviewScheduledAt.value = '';
        }
    }

    interviewDate.addEventListener('change', () => {
        syncScheduledAt();
        fetchBookedSlots(interviewDate, interviewHour, interviewMinute, interviewDuration, interviewTimeline, interviewTimelineList);
    });

    const triggerInterviewUpdate = () => {
        syncScheduledAt();
        const slots = JSON.parse(interviewHour.dataset.slots || '[]');
        updateOptionsAvailability(interviewHour, interviewMinute, interviewDuration, slots);
    };

    interviewHour.addEventListener('change', triggerInterviewUpdate);
    interviewMinute.addEventListener('change', triggerInterviewUpdate);
    interviewDuration.addEventListener('change', triggerInterviewUpdate);

    const openModal = () => modal.classList.remove('hidden');
    const closeModal = () => modal.classList.add('hidden');

    const btnInterview = document.getElementById('btn-action-interview');
    if (btnInterview) btnInterview.addEventListener('click', openModal);

    const btnReschedule = document.getElementById('btn-action-reschedule');
    if (btnReschedule) btnReschedule.addEventListener('click', openModal);

    document.getElementById('btn-close-modal').addEventListener('click', closeModal);
    document.getElementById('btn-cancel-modal').addEventListener('click', closeModal);
    document.getElementById('modal-jadwal-backdrop').addEventListener('click', closeModal);

    document.getElementById('form-interview').addEventListener('submit', async function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        try {
            const data = await submitJson(`/hr/pelamar/${applicationId}/interview`, {
                scheduled_at: formData.get('scheduled_at'),
                duration_minutes: formData.get('duration_minutes'),
                interview_type: formData.get('interview_type'),
                location_or_link: formData.get('location_or_link'),
                notes: formData.get('notes'),
            });
            closeModal();
            showToast(data.message || 'Interview scheduled successfully.');
            setTimeout(() => window.location.reload(), 900);
        } catch (error) {
            showToast(error.message, 'error');
        }
    });
});

window.openCvPreviewModal = function(url) {
    const modal = document.getElementById('cv-preview-modal');
    const iframe = document.getElementById('modal-cv-iframe');
    if (modal && iframe) {
        iframe.src = url;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
};

window.closeCvPreviewModal = function() {
    const modal = document.getElementById('cv-preview-modal');
    const iframe = document.getElementById('modal-cv-iframe');
    if (modal && iframe) {
        modal.classList.add('hidden');
        iframe.src = '';
        document.body.classList.remove('overflow-hidden');
    }
};
</script>

{{-- CV Preview Modal --}}
<div id="cv-preview-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 sm:p-6 md:p-10">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeCvPreviewModal()"></div>
    
    <!-- Modal content wrapper -->
    <div class="relative bg-white w-full max-w-5xl h-[85vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-150 transition-all transform animate-modal-in">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-150 flex items-center justify-between bg-white z-10">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-base leading-tight">CV Preview - {{ $user->name }}</h3>
                    <p class="text-xs text-gray-500 font-medium">Previewing applicant document</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Download Button -->
                @if($application->resume_url)
                    <a href="{{ asset($application->resume_url) }}" 
                       download
                       target="_blank"
                       class="inline-flex items-center gap-1.5 bg-green-750 hover:bg-green-800 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition-colors shadow-sm cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download CV
                    </a>
                @else
                    <a href="/hr/pelamar/{{ $application->id }}/cv-preview" 
                       target="_blank"
                       class="inline-flex items-center gap-1.5 bg-green-750 hover:bg-green-800 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition-colors shadow-sm cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download CV
                    </a>
                @endif
                
                <!-- Close Button -->
                <button type="button" onclick="closeCvPreviewModal()" class="w-8 h-8 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 flex items-center justify-center transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Modal Body (Iframe) -->
        <div class="flex-1 bg-gray-50 p-4 relative">
            <iframe id="modal-cv-iframe" class="w-full h-full bg-white rounded-xl border border-gray-200 shadow-inner" src="" title="CV Preview"></iframe>
        </div>
    </div>
</div>
@endsection
