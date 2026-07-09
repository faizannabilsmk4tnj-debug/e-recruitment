@extends('layouts.landing')

@section('title', 'Careers - PT Ecogreen Oleochemicals')
@section('nav-beranda', 'text-white font-semibold')

@section('css')
<style>
    .hero-image {
        background: linear-gradient(to bottom, rgba(20, 83, 45, 0.1), rgba(20, 83, 45, 0.8)), url('{{ asset("images/hero-factory.jpg") }}');
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    .hero-image::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            radial-gradient(circle at 30% 60%, rgba(255,255,255,0.08) 0%, transparent 50%),
            radial-gradient(circle at 70% 30%, rgba(255,255,255,0.05) 0%, transparent 40%);
    }
    .hero-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40%;
        background: linear-gradient(to top, rgba(20, 83, 45, 0.6), transparent);
    }
    .stat-number {
        background: linear-gradient(135deg, #15803d, #166534);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeInUp 0.6s ease-out forwards; opacity: 0; }
    .animate-in:nth-child(1) { animation-delay: 0.1s; }
    .animate-in:nth-child(2) { animation-delay: 0.2s; }
    .modal-overlay { transition: opacity 0.3s; }
    .modal-box { transition: transform 0.3s, opacity 0.3s; }
    .modal-overlay.hidden .modal-box { transform: translateY(20px); opacity: 0; }
    
    .about-green-bg {
        background: radial-gradient(circle at 70% 30%, #166534 0%, #14532d 55%, #0d381e 100%);
        position: relative;
        overflow: hidden;
    }
    .about-green-bg::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
</style>
@endsection

@section('content')

<!-- ========== QUICK LINKS ========== -->
<section class="px-16 py-5 bg-white border-b border-gray-100">
    <div class="grid grid-cols-2 gap-5">
        <button id="btn-kategori" class="animate-in flex items-center gap-4 bg-white border border-gray-200 rounded-xl px-6 py-4 hover:shadow-md hover:border-green-200 transition-all group text-left">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/></svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-gray-900 group-hover:text-green-800 transition-colors">Popular Categories</p>
                <p class="text-sm text-gray-500">Explore R&D, Operations, and Sustainability divisions.</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>

        <button id="btn-lowongan" class="animate-in flex items-center gap-4 bg-white border border-gray-200 rounded-xl px-6 py-4 hover:shadow-md hover:border-green-200 transition-all group text-left">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-green-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-gray-900 group-hover:text-green-800 transition-colors">Latest Vacancies</p>
                <p class="text-sm text-gray-500">Daily updates on technical and managerial positions.</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </button>
    </div>
</section>

<!-- ========== HERO SECTION ========== -->
<section class="px-16 py-20 about-green-bg relative overflow-hidden">
    <!-- Background Glassmorphic Ornaments -->
    <div class="absolute -top-24 -right-24 w-[400px] h-[400px] rounded-full bg-white/[0.06] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute top-12 right-[35%] w-72 h-72 rounded-full bg-green-300/[0.08] blur-2xl pointer-events-none z-0"></div>
    <div class="absolute -bottom-20 -left-10 w-80 h-80 rounded-full bg-white/[0.04] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute -top-12 right-24 w-72 h-72 rounded-full border border-white/[0.06] pointer-events-none z-0"></div>
    <div class="absolute bottom-8 right-[25%] w-48 h-48 rounded-full border border-green-300/[0.04] pointer-events-none z-0"></div>
    <div class="absolute top-1/3 left-12 w-12 h-12 rounded-full border border-white/[0.03] pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto flex items-center justify-between gap-16 relative z-10 w-full">
        <div class="max-w-xl flex-1">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 bg-green-400 rounded-full"></span>
                <span class="text-xs font-bold text-green-300 uppercase tracking-widest">Join Our Green Mission</span>
            </div>
            <h1 class="text-[4.25rem] font-black text-white leading-[1.05] mb-4 tracking-tight">Cultivate Your<br>Sustainable Career.</h1>
            <p class="text-green-100/90 text-lg leading-relaxed max-w-lg">Join PT Ecogreen Oleochemicals and lead the transformation towards a greener future. We empower talent to innovate for a cleaner tomorrow.</p>
        </div>
        <div class="hero-image w-[480px] h-[380px] rounded-2xl flex flex-col justify-end p-8 shrink-0 border border-white/15 shadow-2xl relative">
            <div class="absolute top-5 right-5 z-10 flex items-center gap-2 bg-white/15 backdrop-blur-sm px-3 py-1.5 rounded-full">
                <span class="w-2.5 h-2.5 bg-green-400 rounded-full"></span>
                <span class="text-xs text-white font-medium">Secure Career Portal</span>
            </div>
            <div class="relative z-10">
                <p class="text-3xl font-extrabold text-white/70 tracking-wider mb-1">SUSTAINABILITY</p>
                <p class="text-lg font-bold text-white/95 tracking-widest">SAFE FOR WORK</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== STATS SECTION ========== -->
<section class="bg-gray-50 px-16 pt-14 pb-8 border-t border-gray-100">
    <div class="grid grid-cols-4 gap-8 text-center">
        <div>
            <p class="text-5xl font-extrabold stat-number">1300+</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Global Talents</p>
        </div>
        <div>
            <p class="text-5xl font-extrabold stat-number">30+</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Countries Served</p>
        </div>
        <div>
            <p class="text-5xl font-extrabold stat-number">100%</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Sustainable Sourcing</p>
        </div>
        <div>
            <p class="text-5xl font-extrabold stat-number">35+</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Years Excellence</p>
        </div>
    </div>
    <div class="text-center mt-16 text-[10px] text-gray-400 font-semibold tracking-wider uppercase opacity-75">
        Source: PT Ecogreen Oleochemicals Corporate Profile & RSPO Reports
    </div>
</section>

<!-- ========== MODAL: KATEGORI POPULER ========== -->
<div id="modal-kategori" class="modal-overlay fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="modal-box bg-white rounded-2xl w-full max-w-3xl mx-4 p-8">
        <div class="flex items-start justify-between mb-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Popular Categories</h2>
                <p class="text-sm text-gray-500 mt-1">Find career opportunities that match your expertise in the green and sustainability industry sector.</p>
            </div>
            <button class="modal-close text-gray-400 hover:text-gray-700 transition-colors p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        @php
            if (!function_exists('getCategoryIcon')) {
                function getCategoryIcon($slug) {
                    $iconClass = 'w-6 h-6 text-green-700';
                    $slug = strtolower($slug);
                    if (str_contains($slug, 'it') || str_contains($slug, 'engineering')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>';
                    } elseif (str_contains($slug, 'finance') || str_contains($slug, 'accounting')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>';
                    } elseif (str_contains($slug, 'human') || str_contains($slug, 'hr') || str_contains($slug, 'people')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>';
                    } elseif (str_contains($slug, 'operations') || str_contains($slug, 'production')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>';
                    } elseif (str_contains($slug, 'marketing') || str_contains($slug, 'sales')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>';
                    } elseif (str_contains($slug, 'logistics') || str_contains($slug, 'supply') || str_contains($slug, 'chain')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="7.5" cy="18" r="1.5"/><circle cx="16.5" cy="18" r="1.5"/></svg>';
                    } elseif (str_contains($slug, 'quality') || str_contains($slug, 'control') || str_contains($slug, 'qc')) {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>';
                    } else {
                        return '<svg xmlns="http://www.w3.org/2000/svg" class="'.$iconClass.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/></svg>';
                    }
                }
            }
        @endphp

        <div class="grid grid-cols-4 gap-4 mt-6">
            @forelse($categories ?? [] as $category)
                <div onclick="window.location.href='/lowongan?category={{ urlencode($category->name) }}'" class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                        {!! getCategoryIcon($category->slug ?? '') !!}
                    </div>
                    <p class="text-xs font-bold text-green-900 uppercase tracking-wider line-clamp-1" title="{{ $category->name }}">{{ $category->name }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $category->job_postings_count }} Vacancies</p>
                </div>
            @empty
                <div class="col-span-4 text-center py-6 text-sm text-gray-500">
                    No active categories found.
                </div>
            @endforelse
        </div>

        <div class="flex items-center justify-end mt-6 pt-5 border-t border-gray-100">
            <a href="/lowongan?open_categories=1" class="text-sm font-semibold text-green-800 hover:text-green-600 transition-colors">View All Categories</a>
        </div>
    </div>
</div>

<!-- ========== MODAL: LOWONGAN TERBARU ========== -->
<div id="modal-lowongan" class="modal-overlay fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="modal-box bg-white rounded-2xl w-full max-w-2xl mx-4 p-8">
        <div class="flex items-start justify-between mb-1">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-6 h-1 bg-green-800 rounded-full"></div>
                    <span class="text-xs font-bold text-green-800 uppercase tracking-widest">Ecogreen Opportunities</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Latest Vacancies</h2>
                <p class="text-sm text-gray-500 mt-1">Find your dream career in the sustainable oleochemical industry.</p>
            </div>
            <button class="modal-close text-gray-400 hover:text-gray-700 transition-colors p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <div class="mt-6 divide-y divide-gray-100">
            @forelse($latestJobs ?? [] as $job)
                <div class="flex items-center justify-between py-4 hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors">
                    <div>
                        <h3 class="font-bold text-gray-900">{{ $job->title }}</h3>
                        <div class="flex items-center gap-3 mt-1.5">
                            <span class="text-xs font-medium text-green-700 bg-green-50 px-2.5 py-0.5 rounded-md flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                {{ $job->category->name ?? 'General' }}
                            </span>
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    @auth
                        @if(Auth::user()->role === 'applicant')
                            <a href="/pelamar/lowongan/{{ $job->id }}" class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">
                                Apply Now <span>→</span>
                            </a>
                        @else
                            <a href="/hr/lowongan/{{ $job->id }}" class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">
                                View Details <span>→</span>
                            </a>
                        @endif
                    @else
                        <button data-auth-required class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">
                            Apply Now <span>→</span>
                        </button>
                    @endauth
                </div>
            @empty
                <p class="text-sm text-gray-500 py-6 text-center">No active vacancies at the moment.</p>
            @endforelse
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-start">
            <button id="btn-lihat-kategori" class="text-sm font-semibold text-gray-700 hover:text-green-700 flex items-center gap-1 transition-colors">
                View All Vacancies
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Stat counters
    document.querySelectorAll('.stat-number').forEach(el => {
        const text = el.textContent;
        const isPercent = text.includes('%');
        const target = parseInt(text);
        let current = 0;
        const step = Math.max(1, Math.ceil(target / 50));
        el.textContent = '0' + (isPercent ? '%' : '+');
        setTimeout(() => {
            const timer = setInterval(() => {
                current += step;
                if (current >= target) { current = target; clearInterval(timer); }
                el.textContent = current + (isPercent ? '%' : '+');
            }, 20);
        }, 500);
    });

    // Modal handlers
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    document.getElementById('btn-kategori').addEventListener('click', () => openModal('modal-kategori'));
    document.getElementById('btn-lowongan').addEventListener('click', () => openModal('modal-lowongan'));

    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', function () {
            this.closest('.modal-overlay').classList.add('hidden');
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function (e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });

    // View All Vacancies click -> redirect to general vacancies page
    document.getElementById('btn-lihat-kategori').addEventListener('click', function () {
        window.location.href = '/lowongan';
    });

    // Kategori cards -> redirect to lowongan
    document.querySelectorAll('.kategori-card').forEach(card => {
        card.addEventListener('click', function () {
            window.location.href = '/lowongan';
        });
    });



    // Close modals on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function (e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });
});
</script>
@endsection