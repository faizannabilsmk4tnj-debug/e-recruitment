@extends('layouts.landing')

@section('title', 'Careers - PT Ecogreen Oleochemicals')
@section('nav-beranda', 'text-white font-semibold')

@section('css')
<style>
    .hero-image {
        background: linear-gradient(135deg, #14532d 0%, #166534 40%, #1a7a4a 70%, #15803d 100%);
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
<section class="px-16 py-16 bg-white">
    <div class="flex items-center justify-between gap-16">
        <div class="max-w-xl flex-1">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-2.5 h-2.5 bg-green-600 rounded-full"></span>
                <span class="text-xs font-bold text-green-800 uppercase tracking-widest">Join Our Green Mission</span>
            </div>
            <h1 class="text-5xl font-extrabold text-gray-900 leading-tight mb-6">Cultivate Your<br>Sustainable Career.</h1>
            <p class="text-gray-600 text-base leading-relaxed mb-8">Join PT Ecogreen Oleochemicals and lead the transformation towards a greener future. We empower talent to innovate for a cleaner tomorrow.</p>
            <div class="relative max-w-md">
                <input type="text" placeholder="Search roles, skills, or departments..." class="w-full pl-5 pr-12 py-3.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <button class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-green-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </div>
        </div>
        <div class="hero-image w-[480px] h-[380px] rounded-2xl flex flex-col justify-end p-8 shrink-0">
            <div class="absolute top-5 right-5 z-10 flex items-center gap-2 bg-white/15 backdrop-blur-sm px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                <span class="text-xs text-white font-medium">Secure Career Portal</span>
            </div>
            <div class="absolute inset-0 flex items-center justify-center opacity-20 z-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-48 h-48 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5"><path d="M2 20h20V8l-5 4V8l-5 4V4H2v16z"/><rect x="6" y="14" width="2" height="2"/><rect x="10" y="14" width="2" height="2"/></svg>
            </div>
            <div class="relative z-10">
                <p class="text-3xl font-extrabold text-white/70 tracking-wider mb-1">SUSTAINABILITY</p>
                <p class="text-lg font-bold text-white/90 tracking-widest">SAFE FOR WORK</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== STATS SECTION ========== -->
<section class="bg-gray-50 px-16 py-14 border-t border-gray-100">
    <div class="grid grid-cols-4 gap-8 text-center">
        <div>
            <p class="text-5xl font-extrabold stat-number">500+</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Global Talents</p>
        </div>
        <div>
            <p class="text-5xl font-extrabold stat-number">20+</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Countries Served</p>
        </div>
        <div>
            <p class="text-5xl font-extrabold stat-number">100%</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Sustainable Sourcing</p>
        </div>
        <div>
            <p class="text-5xl font-extrabold stat-number">40+</p>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-2">Years Excellence</p>
        </div>
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

        <div class="grid grid-cols-4 gap-4 mt-6">
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Engineering</p>
                <p class="text-xs text-gray-400 mt-1">124 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Finance</p>
                <p class="text-xs text-gray-400 mt-1">85 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Marketing</p>
                <p class="text-xs text-gray-400 mt-1">92 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">IT & Digital</p>
                <p class="text-xs text-gray-400 mt-1">156 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Research</p>
                <p class="text-xs text-gray-400 mt-1">43 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Operations</p>
                <p class="text-xs text-gray-400 mt-1">210 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">Sustainability</p>
                <p class="text-xs text-gray-400 mt-1">67 Vacancies</p>
            </div>
            <div class="kategori-card border border-gray-200 rounded-xl p-5 text-center hover:border-green-300 hover:shadow-sm transition-all cursor-pointer group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-green-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <p class="text-xs font-bold text-green-900 uppercase tracking-wider">HR & People</p>
                <p class="text-xs text-gray-400 mt-1">31 Vacancies</p>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Security Pulse: Encrypted Session</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="text-sm font-semibold text-green-800 hover:text-green-600 transition-colors">View All Categories</a>
                <button class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">Search Jobs</button>
            </div>
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
            <div class="flex items-center justify-between py-4 hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors">
                <div>
                    <h3 class="font-bold text-gray-900">Production Engineer</h3>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2.5 py-0.5 rounded-md flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            Operations
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            2 hours ago
                        </span>
                    </div>
                </div>
                <button data-auth-required class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">
                    Apply Now <span>→</span>
                </a>
            </div>
            <div class="flex items-center justify-between py-4 hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors">
                <div>
                    <h3 class="font-bold text-gray-900">Sustainability Specialist</h3>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2.5 py-0.5 rounded-md flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Environmental
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            5 hours ago
                        </span>
                    </div>
                </div>
                <button data-auth-required class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">Apply Now →</button>
            </div>
            <div class="flex items-center justify-between py-4 hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors">
                <div>
                    <h3 class="font-bold text-gray-900">QA/QC Analyst</h3>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2.5 py-0.5 rounded-md flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"/></svg>
                            Quality Control
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Today
                        </span>
                    </div>
                </div>
                <button data-auth-required class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">Apply Now →</button>
            </div>
            <div class="flex items-center justify-between py-4 hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors">
                <div>
                    <h3 class="font-bold text-gray-900">Human Resources Generalist</h3>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2.5 py-0.5 rounded-md flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            Corporate
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Yesterday
                        </span>
                    </div>
                </div>
                <button data-auth-required class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">Apply Now →</button>
            </div>
            <div class="flex items-center justify-between py-4 hover:bg-gray-50 -mx-4 px-4 rounded-lg transition-colors">
                <div>
                    <h3 class="font-bold text-gray-900">Supply Chain Coordinator</h3>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2.5 py-0.5 rounded-md flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            Logistics
                        </span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Yesterday
                        </span>
                    </div>
                </div>
                <button data-auth-required class="text-sm font-semibold text-green-800 border border-green-800 px-4 py-1.5 rounded-lg hover:bg-green-800 hover:text-white transition-colors flex items-center gap-1">Apply Now →</button>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
            <button id="btn-lihat-kategori" class="text-sm font-semibold text-gray-700 hover:text-green-700 flex items-center gap-1 transition-colors">
                View All Vacancies
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Secure Portal</span>
            </div>
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

    // Lihat All Lowongan -> open Kategori modal
    document.getElementById('btn-lihat-kategori').addEventListener('click', function () {
        closeModal('modal-lowongan');
        setTimeout(() => openModal('modal-kategori'), 200);
    });

    // Kategori cards -> redirect to login
    document.querySelectorAll('.kategori-card').forEach(card => {
        card.addEventListener('click', function () {
            window.location.href = '/lowongan';
        });
    });
});
</script>
@endsection