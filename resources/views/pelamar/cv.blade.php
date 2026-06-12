@extends('layouts.pelamar')

@section('title', 'My CV')
@section('nav-cv', 'active')

@section('css')
<style>
    .template-card { transition: all 0.3s; }
    .template-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }
    .template-card.selected { border-color: #15803d; box-shadow: 0 0 0 3px rgba(21,128,61,0.2); }
    .template-card.selected .select-btn { background: #15803d; color: white; }
    .cv-thumb { aspect-ratio: 3/4; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-preview { animation: fadeIn 0.4s ease-out; }
</style>
@endsection

@section('content')

<!-- Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Resume Editor</h1>
        <p class="text-gray-500 mt-1 text-sm">Editing: Senior Product Designer Role</p>
    </div>
    <div class="flex gap-3">
        <button class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" x2="12" y1="2" y2="15"/></svg>
            Share Link
        </button>
        <button class="flex items-center gap-2 px-4 py-2.5 bg-green-800 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Draft
        </button>
    </div>
</div>

<!-- Template Cards -->
<div class="grid grid-cols-3 gap-6 mb-10" id="template-grid">

    <!-- Template 1: Modern Executive 2024 -->
    <div class="template-card bg-white rounded-xl border border-gray-200 overflow-hidden cursor-pointer selected" data-template="modern">
        <div class="cv-thumb bg-green-950 relative overflow-hidden flex items-center justify-center p-6">
            <!-- Badge -->
            <span class="absolute top-3 left-3 bg-green-700 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Primary
            </span>
            <!-- Thumbnail content -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-800 rounded-lg mx-auto mb-3 flex items-center justify-center">
                    <span class="text-green-300 text-xs font-mono">CV</span>
                </div>
                <div class="space-y-1">
                    <div class="h-2 w-28 bg-green-800 rounded mx-auto"></div>
                    <div class="h-1.5 w-20 bg-green-800/60 rounded mx-auto"></div>
                    <div class="h-1 w-32 bg-green-800/40 rounded mx-auto mt-3"></div>
                    <div class="h-1 w-28 bg-green-800/40 rounded mx-auto"></div>
                    <div class="h-1 w-24 bg-green-800/40 rounded mx-auto"></div>
                </div>
            </div>
        </div>
        <div class="p-5">
            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1">Most Popular</p>
            <h3 class="font-bold text-gray-900 text-lg">Modern Executive 2024</h3>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">A bold design with a modular structure, ideal for managers and senior project leads with a contemporary layout.</p>
            <button class="select-btn w-full mt-4 bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 hover:bg-green-700">
                Select Template
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    <!-- Template 2: Academic Specialist -->
    <div class="template-card bg-white rounded-xl border border-gray-200 overflow-hidden cursor-pointer" data-template="academic">
        <div class="cv-thumb bg-gray-100 relative overflow-hidden flex items-center justify-center p-6">
            <span class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">Published</span>
            <div class="text-center">
                <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="space-y-1">
                    <div class="h-1.5 w-10 bg-gray-300 rounded mx-auto"></div>
                    <div class="text-[8px] text-gray-400 font-medium">CV</div>
                    <div class="h-1 w-32 bg-gray-200 rounded mx-auto mt-2"></div>
                    <div class="h-1 w-28 bg-gray-200 rounded mx-auto"></div>
                </div>
            </div>
        </div>
        <div class="p-5">
            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">Formal Structure</p>
            <h3 class="font-bold text-gray-900 text-lg">Academic Specialist</h3>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">An academic CV style with double columns and organized serif typography for information-dense layouts.</p>
            <button class="select-btn w-full mt-4 bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 hover:bg-green-700">
                Select Template
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    <!-- Template 3: Creative Industrial -->
    <div class="template-card bg-white rounded-xl border border-gray-200 overflow-hidden cursor-pointer" data-template="creative">
        <div class="cv-thumb bg-slate-700 relative overflow-hidden flex items-center justify-center p-6">
            <span class="absolute top-3 left-3 bg-gray-500 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">Draft</span>
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-600 rounded-full mx-auto mb-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="space-y-1">
                    <div class="h-2 w-24 bg-slate-500 rounded mx-auto"></div>
                    <div class="h-1 w-16 bg-slate-600 rounded mx-auto mt-2"></div>
                    <div class="h-1 w-20 bg-slate-600 rounded mx-auto"></div>
                </div>
            </div>
        </div>
        <div class="p-5">
            <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest mb-1">Bold Design</p>
            <h3 class="font-bold text-gray-900 text-lg">Creative Industrial</h3>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">A creative and bold CV template with architectural elements and a modern dark-theme accent.</p>
            <button class="select-btn w-full mt-4 bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 hover:bg-green-700">
                Select Template
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

<!-- CV Preview (shown after selecting template) -->
<div id="cv-preview-section" class="mb-10 hidden">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-900">Preview CV — <span id="preview-template-name">Modern Executive 2024</span></h2>
        <button onclick="document.getElementById('cv-preview-section').classList.add('hidden'); document.querySelectorAll('.cv-preview-panel').forEach(p=>p.classList.add('hidden'))" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            Close Preview
        </button>
    </div>

    <!-- ===== PREVIEW 1: Modern Executive — sidebar kiri hijau ===== -->
    <div id="tpl-modern" class="cv-preview-panel max-w-3xl mx-auto animate-preview">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="grid grid-cols-10 min-h-[700px]">
                {{-- Sidebar --}}
                <div class="col-span-3 bg-green-900 text-white p-6 space-y-6">
                    <div class="text-center pb-5 border-b border-green-700">
                        @if($profile && $profile->avatar_url)
                        <img src="{{ Storage::url($profile->avatar_url) }}" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-2 border-green-500">
                        @else
                        <div class="w-20 h-20 bg-green-800 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-green-500">
                            <span class="text-2xl font-bold text-green-300">{{ $initials }}</span>
                        </div>
                        @endif
                        <h2 class="font-bold text-base">{{ $user->name }}</h2>
                        @if($profile && $profile->city)<p class="text-green-300 text-xs mt-1">{{ $profile->city }}</p>@endif
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Contact</h4>
                        <div class="space-y-1 text-xs text-green-100">
                            <p>{{ $user->email }}</p>
                            @if($profile && $profile->city)<p>{{ $profile->city }}{{ $profile->province ? ', '.$profile->province : '' }}</p>@endif
                            @if($profile && $profile->linkedin_url)<p>{{ $profile->linkedin_url }}</p>@endif
                        </div>
                    </div>
                    @if($skills->count())
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Skills</h4>
                        <div class="space-y-2">
                            @foreach($skills->take(5) as $skill)
                            <div><p class="text-xs text-green-100 mb-1">{{ $skill->skill_name }}</p>
                            <div class="w-full bg-green-800 rounded-full h-1.5"><div class="bg-green-400 h-1.5 rounded-full" style="width:{{ $skill->level === 'expert' ? '90' : ($skill->level === 'intermediate' ? '65' : '40') }}%"></div></div></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($skills->where('category','language')->count())
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Languages</h4>
                        <div class="space-y-1 text-xs text-green-100">
                            @foreach($skills->where('category','language') as $lang)
                            <p>{{ $lang->skill_name }} — {{ ucfirst($lang->level) }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($skills->whereNotNull('cert_name')->count())
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Certifications</h4>
                        <div class="space-y-1 text-xs text-green-100">
                            @foreach($skills->whereNotNull('cert_name') as $cert)
                            <p>• {{ $cert->cert_name }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                {{-- Main Content --}}
                <div class="col-span-7 p-8 space-y-6">
                    @if($profile && $profile->bio)
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Professional Profile</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $profile->bio }}</p>
                    </div>
                    @endif
                    @if($works->count())
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-3 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Work Experience</h3>
                        <div class="space-y-4">
                            @foreach($works as $i => $w)
                            <div class="border-l-2 {{ $i===0 ? 'border-green-200' : 'border-gray-200' }} pl-4">
                                <div class="flex justify-between items-start">
                                    <p class="font-bold text-sm text-gray-900">{{ $w->position }}</p>
                                    <span class="text-xs {{ $i===0 ? 'text-green-700 bg-green-50' : 'text-gray-400' }} px-2 py-0.5 rounded font-semibold">
                                        {{ $w->start_date->format('Y') }} — {{ $w->is_current ? 'Present' : ($w->end_date ? $w->end_date->format('Y') : '') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $w->company_name }}</p>
                                @if($w->description)<p class="mt-1 text-xs text-gray-600">{{ $w->description }}</p>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($educations->count())
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-3 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Education</h3>
                        <div class="space-y-3">
                            @foreach($educations as $edu)
                            <div class="border-l-2 border-green-200 pl-4">
                                <p class="font-bold text-sm text-gray-900">{{ $edu->degree }} — {{ $edu->major }}</p>
                                <p class="text-sm text-gray-500">{{ $edu->institution }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $edu->start_year }} — {{ $edu->end_year }}{{ $edu->gpa ? ' • GPA '.$edu->gpa : '' }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($organizations->count())
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-3 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Organization</h3>
                        <div class="space-y-3">
                            @foreach($organizations as $org)
                            <div class="border-l-2 border-gray-200 pl-4">
                                <p class="font-bold text-sm text-gray-900">{{ $org->position }}</p>
                                <p class="text-sm text-gray-500">{{ $org->organization_name }}</p>
                                <p class="text-xs text-gray-400">{{ $org->start_date->format('Y') }} — {{ $org->end_date ? $org->end_date->format('Y') : 'Present' }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PREVIEW 2: Academic Specialist — formal dua kolom seimbang ===== -->
    <div id="tpl-academic" class="cv-preview-panel max-w-3xl mx-auto animate-preview hidden">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm p-10" style="font-family: 'Georgia', serif;">
            <!-- Header -->
            <div class="text-center pb-5 mb-6 border-b-2 border-gray-800">
                <h1 class="text-2xl font-bold text-gray-900 tracking-wide" style="font-family: 'Georgia', serif;">{{ strtoupper($user->name) }}</h1>
                @if($profile && $profile->city)<p class="text-sm text-gray-600 mt-1.5 tracking-wide">{{ $profile->city }}{{ $profile->province ? ', '.$profile->province : '' }}</p>@endif
                <p class="text-xs text-gray-400 mt-2">{{ $user->email }}@if($profile && $profile->linkedin_url) • {{ $profile->linkedin_url }}@endif</p>
            </div>
            @if($profile && $profile->bio)
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-2">Ringkasan Profesional</h3>
                <p class="text-sm text-gray-600 leading-relaxed" style="text-align:justify;">{{ $profile->bio }}</p>
            </div>
            @endif
            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-5">
                    @if($works->count())
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Pengalaman Profesional</h3>
                        <div class="space-y-4">
                            @foreach($works as $w)
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $w->position }}</p>
                                <p class="text-xs text-gray-500 italic">{{ $w->company_name }} — {{ $w->start_date->format('Y') }} s.d. {{ $w->is_current ? 'Sekarang' : ($w->end_date ? $w->end_date->format('Y') : '') }}</p>
                                @if($w->description)<ul class="mt-1.5 text-xs text-gray-600 space-y-1 leading-relaxed"><li>– {{ $w->description }}</li></ul>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($organizations->count())
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Organisasi</h3>
                        <div class="space-y-3">
                            @foreach($organizations as $org)
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $org->position }}</p>
                                <p class="text-xs text-gray-500 italic">{{ $org->organization_name }} — {{ $org->start_date->format('Y') }} s.d. {{ $org->end_date ? $org->end_date->format('Y') : 'Sekarang' }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="space-y-5">
                    @if($educations->count())
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Pendidikan</h3>
                        @foreach($educations as $edu)
                        <div class="mb-3">
                            <p class="font-bold text-sm text-gray-900">{{ $edu->degree }} — {{ $edu->major }}</p>
                            <p class="text-xs text-gray-500 italic">{{ $edu->institution }} — {{ $edu->start_year }} s.d. {{ $edu->end_year }}</p>
                            @if($edu->gpa)<p class="text-xs text-gray-400 mt-1">GPA: {{ $edu->gpa }} / 4.00</p>@endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if($skills->whereNotIn('category',['language'])->count())
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Kompetensi Teknis</h3>
                        <div class="text-xs text-gray-600 space-y-1">
                            @foreach($skills->whereNotIn('category',['language'])->take(6) as $skill)
                            <p>• {{ $skill->skill_name }}@if($skill->level) ({{ ucfirst($skill->level) }})@endif</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($skills->whereNotNull('cert_name')->count())
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Sertifikasi</h3>
                        <div class="text-xs text-gray-600 space-y-1">
                            @foreach($skills->whereNotNull('cert_name') as $cert)
                            <p>• {{ $cert->cert_name }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($skills->where('category','language')->count())
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Bahasa</h3>
                        <div class="text-xs text-gray-600 space-y-1">
                            @foreach($skills->where('category','language') as $lang)
                            <p>{{ $lang->skill_name }} — {{ ucfirst($lang->level) }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PREVIEW 3: Creative Industrial — dark theme, bold layout ===== -->
    <div id="tpl-creative" class="cv-preview-panel max-w-3xl mx-auto animate-preview hidden">
        <div class="bg-slate-900 rounded-xl border border-slate-700 overflow-hidden shadow-sm">
            <!-- Top Banner -->
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-8 py-6 border-b border-slate-700">
                <div class="flex items-center gap-6">
                    @if($profile && $profile->avatar_url)
                    <img src="{{ Storage::url($profile->avatar_url) }}" class="w-20 h-20 rounded-xl object-cover border-2 border-amber-500 shrink-0">
                    @else
                    <div class="w-20 h-20 bg-slate-700 rounded-xl flex items-center justify-center border-2 border-amber-500 shrink-0">
                        <span class="text-2xl font-extrabold text-amber-400">{{ $initials }}</span>
                    </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-extrabold text-white tracking-wide">{{ strtoupper($user->name) }}</h1>
                        @if($works->count())<p class="text-amber-400 font-semibold text-sm mt-0.5">{{ strtoupper($works->first()->position) }}</p>@endif
                        <div class="flex gap-4 mt-2 text-xs text-slate-400">
                            @if($profile && $profile->city)<span>{{ $profile->city }}</span><span>•</span>@endif
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Body -->
            <div class="grid grid-cols-10 min-h-[500px]">
                <!-- Main Content -->
                <div class="col-span-7 p-8 space-y-6 border-r border-slate-800">
                    @if($profile && $profile->bio)
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Profile</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">{{ $profile->bio }}</p>
                    </div>
                    @endif
                    @if($works->count())
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-4 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Experience</h3>
                        <div class="space-y-5">
                            @foreach($works as $i => $w)
                            <div class="relative pl-5 border-l-2 {{ $i===0 ? 'border-amber-500/40' : 'border-slate-700' }}">
                                <div class="absolute -left-[5px] top-1 w-2 h-2 {{ $i===0 ? 'bg-amber-500' : 'bg-slate-600' }} rounded-full"></div>
                                <div class="flex justify-between items-start">
                                    <p class="font-bold text-sm text-white">{{ $w->position }}</p>
                                    <span class="text-[10px] {{ $i===0 ? 'text-amber-400 bg-amber-500/10' : 'text-slate-500' }} px-2 py-0.5 rounded font-semibold">
                                        {{ $w->start_date->format('Y') }} — {{ $w->is_current ? 'SEKARANG' : ($w->end_date ? $w->end_date->format('Y') : '') }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $w->company_name }}</p>
                                @if($w->description)<ul class="mt-2 text-xs text-slate-300 space-y-1"><li>→ {{ $w->description }}</li></ul>@endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($educations->count())
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Education</h3>
                        @foreach($educations as $edu)
                        <div class="bg-slate-800 rounded-lg p-4 mb-2">
                            <p class="font-bold text-sm text-white">{{ $edu->degree }} {{ $edu->major }} — {{ $edu->institution }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $edu->start_year }} — {{ $edu->end_year }}{{ $edu->gpa ? ' • GPA '.$edu->gpa : '' }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @if($organizations->count())
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Organization</h3>
                        <div class="space-y-3">
                            @foreach($organizations as $org)
                            <div class="relative pl-5 border-l-2 border-slate-700">
                                <div class="absolute -left-[5px] top-1 w-2 h-2 bg-slate-600 rounded-full"></div>
                                <p class="font-bold text-sm text-white">{{ $org->position }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $org->organization_name }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <!-- Sidebar -->
                <div class="col-span-3 bg-slate-800/50 p-6 space-y-5">
                    @if($skills->whereNotIn('category',['language'])->count())
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-3">Keahlian Inti</h4>
                        <div class="space-y-2.5">
                            @foreach($skills->whereNotIn('category',['language'])->take(5) as $skill)
                            @php $pct = $skill->level==='expert' ? 92 : ($skill->level==='intermediate' ? 75 : 50); @endphp
                            <div>
                                <div class="flex justify-between mb-1">
                                    <p class="text-xs text-slate-300">{{ $skill->skill_name }}</p>
                                    <p class="text-[10px] text-amber-400">{{ $pct }}%</p>
                                </div>
                                <div class="w-full bg-slate-700 rounded-full h-1.5">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($skills->whereNotNull('cert_name')->count())
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-2">Sertifikasi</h4>
                        <div class="space-y-2 text-xs text-slate-300">
                            @foreach($skills->whereNotNull('cert_name') as $cert)
                            <div class="flex items-start gap-2"><span class="text-amber-500 mt-0.5">▸</span><span>{{ $cert->cert_name }}</span></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($skills->where('category','language')->count())
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-2">Languages</h4>
                        <div class="space-y-1.5 text-xs text-slate-300">
                            @foreach($skills->where('category','language') as $lang)
                            @php
                                $dots  = $lang->level==='expert' ? 5 : ($lang->level==='intermediate' ? 4 : 3);
                                $empty = 5 - $dots;
                            @endphp
                            <div class="flex justify-between">
                                <span>{{ $lang->skill_name }}</span>
                                <span><span class="text-amber-400 tracking-wider">{{ str_repeat('●',$dots) }}</span><span class="text-slate-600 tracking-wider">{{ str_repeat('●',$empty) }}</span></span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tips Profesional -->
<div class="bg-gradient-to-br from-green-50 to-gray-50 rounded-xl border border-gray-200 p-8 mb-8">
    <div class="flex items-start gap-8">
        <div class="flex-1">
            <h2 class="text-xl font-bold text-gray-900 italic mb-4">Pro Tips</h2>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">Choose a template with a balanced text-to-whitespace ratio. For technical roles, use <strong>Modern Executive 2024</strong>. For marketing or design positions, <strong>Creative Industrial</strong> is the best choice.</p>
            <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 transition-colors">
                Read Full Career Guide
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17l9.2-9.2M17 17V7H7"/></svg>
            </a>
        </div>
        <div class="flex gap-4 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 p-5 w-40">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <p class="font-bold text-sm text-gray-900">ATS Friendly</p>
                <p class="text-xs text-gray-500 mt-1">Passes company ATS screening bots</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 w-40">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                </div>
                <p class="font-bold text-sm text-gray-900">Auto-Save</p>
                <p class="text-xs text-gray-500 mt-1">Safely stored in the cloud</p>
            </div>
        </div>
    </div>
</div>

<!-- Fixed Download Button -->
<div class="fixed bottom-0 left-60 bg-white border-t border-gray-200 p-4 z-40 flex items-center gap-3" style="width: calc(100% - 15rem);">
    <button id="btn-download" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        <span id="btn-download-text">Download PDF</span>
    </button>
    <p id="download-hint" class="text-xs text-gray-400 italic">Pilih template terlebih dahulu untuk mengaktifkan download.</p>
</div>

<!-- Spacer for fixed button -->
<div class="h-20"></div>

@endsection

@section('scripts')
{{-- Data CV dari controller (sudah disiapkan sebagai array bersih) --}}
<script>
window.cvData = @json($cvJson);
</script>

{{-- jsPDF (programmatic, tanpa screenshot DOM = cepat) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="{{ asset('js/pelamar/cv-download.js') }}"></script>
@endsection