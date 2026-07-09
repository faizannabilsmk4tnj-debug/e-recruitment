@php
    $src = "C:\\Users\\AFTERSHOCK\\.gemini\\antigravity\\brain\\96a9cdb0-1d05-48c0-a3bf-c4e2965d5170\\media__1783257642646.jpg";
    $dst = public_path("images/about-lake.jpg");
    if (file_exists($src)) {
        @copy($src, $dst);
    }
@endphp
@extends('layouts.landing')

@section('title', 'Tentang Kami - PT Ecogreen Oleochemicals')

@section('css')
<style>
    .hero-about {
        background: linear-gradient(180deg, rgba(20, 83, 45, 0.65) 0%, rgba(13, 56, 30, 0.85) 100%), url('{{ asset("images/factory-night.png") }}');
        background-size: cover;
        background-position: center;
        min-height: 480px;
        position: relative;
        overflow: hidden;
    }
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
    .about-image {
        background: linear-gradient(to bottom, rgba(20, 83, 45, 0.1), rgba(20, 83, 45, 0.7)), url('{{ asset("images/about-lake.jpg") }}');
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    .about-image::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(20,83,45,0.5), transparent);
    }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp 0.6s ease-out forwards; opacity: 0; }
</style>
@endsection

@section('content')

<!-- ========== HERO ========== -->
<section class="hero-about relative flex items-center px-16 py-20 min-h-[480px]">
    <!-- Background Ambient Glowing Ornaments (Moved from About Us) -->
    <div class="absolute -top-40 -left-40 w-[600px] h-[600px] rounded-full bg-green-400/10 blur-3xl pointer-events-none z-0"></div>
    <div class="absolute -bottom-40 -right-40 w-[600px] h-[600px] rounded-full bg-green-300/15 blur-3xl pointer-events-none z-0"></div>
    
    <!-- Ambient bubbles with shadow to create depth -->
    <div class="absolute top-1/4 right-[15%] w-80 h-80 rounded-full bg-green-200/10 blur-2xl pointer-events-none z-0"></div>
    <div class="absolute top-[28%] right-[10%] w-60 h-60 rounded-full bg-white/5 blur-xl pointer-events-none z-0 shadow-[0_20px_50px_rgba(255,255,255,0.02)] border border-white/10"></div>
    
    <div class="absolute bottom-1/4 left-[8%] w-72 h-72 rounded-full bg-green-200/10 blur-xl pointer-events-none z-0"></div>
    <div class="absolute bottom-[27%] left-[12%] w-48 h-48 rounded-full bg-white/5 blur-lg pointer-events-none z-0 shadow-[0_15px_30px_rgba(255,255,255,0.01)] border border-white/5"></div>

    <!-- Fine geometric rings -->
    <div class="absolute top-12 left-1/3 w-[350px] h-[350px] rounded-full border-2 border-dashed border-white/5 pointer-events-none z-0"></div>
    <div class="absolute bottom-20 right-1/3 w-[250px] h-[250px] rounded-full border border-white/10 pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto w-full flex flex-col lg:flex-row items-center justify-between gap-16 relative z-10">
        <!-- Left: Text -->
        <div class="max-w-2xl">
            <div class="w-12 h-1.5 bg-green-400 rounded-full mb-6"></div>
            <h1 class="text-5xl font-extrabold text-white leading-tight mb-4">Leading with<br>Sustainability</h1>
            <p class="text-green-100 text-base leading-relaxed mb-8 max-w-lg">Harnessing the power of nature through innovative oleochemical solutions to build a cleaner, more efficient global industrial future.</p>
            <div class="flex gap-3">
                <a href="#about" class="bg-white text-green-900 font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-green-50 transition-colors">Explore Our Impact</a>
                <a href="https://www.ecogreenoleo.com" target="_blank" class="border border-white/50 text-white font-semibold px-5 py-2.5 rounded-lg text-sm hover:bg-white/10 transition-colors flex items-center gap-2">
                    View Report
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                </a>
            </div>
        </div>

        <!-- Right: Stats glass card grid -->
        <div class="grid grid-cols-2 gap-4 max-w-md w-full shrink-0">
            <div class="bg-white/10 backdrop-blur-md border border-white/25 rounded-2xl p-5 shadow-lg">
                <span class="text-xs font-bold text-green-300 uppercase tracking-widest block mb-1">Global Scale</span>
                <span class="text-3xl font-extrabold text-white">30+</span>
                <span class="text-[10px] text-green-100 block mt-1 leading-normal">Countries served with natural solutions.</span>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/25 rounded-2xl p-5 shadow-lg">
                <span class="text-xs font-bold text-green-300 uppercase tracking-widest block mb-1">Commitment</span>
                <span class="text-3xl font-extrabold text-white">100%</span>
                <span class="text-[10px] text-green-100 block mt-1 leading-normal">RSPO certified sustainable sourcing.</span>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/25 rounded-2xl p-5 shadow-lg col-span-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center border border-green-400/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-green-300 uppercase tracking-widest block">Est. 1990</span>
                        <span class="text-sm font-semibold text-white">Pioneer in Fatty Alcohols</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== ABOUT US ========== -->
<section class="px-16 py-20 about-green-bg" id="about">
    <!-- Background Glassmorphic Ornaments (Moved from Hero) -->
    <div class="absolute -top-24 -right-24 w-[400px] h-[400px] rounded-full bg-white/[0.06] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute top-12 right-[35%] w-72 h-72 rounded-full bg-green-300/[0.08] blur-2xl pointer-events-none z-0"></div>
    <div class="absolute -bottom-20 -left-10 w-80 h-80 rounded-full bg-white/[0.04] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute -top-12 right-24 w-72 h-72 rounded-full border border-white/[0.06] pointer-events-none z-0"></div>
    <div class="absolute bottom-8 right-[25%] w-48 h-48 rounded-full border border-green-300/[0.04] pointer-events-none z-0"></div>
    <div class="absolute top-1/3 left-12 w-12 h-12 rounded-full border border-white/[0.03] pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto flex items-start gap-16 relative z-10 w-full">
        <!-- Left: Image -->
        <div class="w-[420px] shrink-0">
            <div class="about-image rounded-2xl h-[480px] flex items-end p-6 border border-white/10 shadow-2xl">
                <div class="relative z-10">
                    <p class="text-white font-bold text-lg">Global</p>
                    <p class="text-green-300 text-xs uppercase tracking-widest">Production Footprint</p>
                </div>
            </div>
        </div>

        <!-- Right: Text -->
        <div class="flex-1">
            <p class="text-xs font-bold text-green-300 uppercase tracking-[4px] mb-3">About Us</p>
            <h2 class="text-3xl font-extrabold text-white leading-tight mb-6">A Global Pioneer in<br>Natural Solutions</h2>

            <div class="space-y-4 text-sm text-green-100/90 leading-relaxed">
                <p>Ecogreen Oleochemicals is one of the leading producers of natural fatty alcohols in the world. We operate cutting-edge production facilities in <strong>Indonesia</strong> (PT Ecogreen Oleochemicals Batam), <strong>Singapore</strong> (Ethoxylates Manufacturing Pte Ltd), <strong>Germany</strong> (Deutsche Hydrierwerke GmbH Rodleben), and <strong>France</strong> (Ecogreen Oleochemicals Chimie).</p>
                <p>Our commitment to excellence extends through our strategically located marketing offices in <strong>Singapore, Germany (Rodleben), and the USA (Houston)</strong>, ensuring that our high-quality oleochemical solutions are accessible to clients across the globe.</p>
                <p>By utilizing renewable plant-based feedstocks and maintaining a focus on technological innovation, we bridge the gap between agricultural abundance and industrial necessity, contributing to a circular and carbon-conscious global economy.</p>
            </div>

            <div class="flex gap-12 mt-8 pt-6 border-t border-white/10">
                <div>
                    <p class="text-3xl font-extrabold text-white">4</p>
                    <p class="text-xs text-green-200 mt-1">Global Production Hubs</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-white">Major</p>
                    <p class="text-xs text-green-200 mt-1">Marketing Networks</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== VISION & MISSION ========== -->
<section class="px-16 py-20 bg-gradient-to-br from-[#e8f5ed] via-white to-[#f0f9f4] border-y border-green-100/50 relative overflow-hidden">
    <!-- Background Glassmorphic Ornaments -->
    <div class="absolute -top-32 right-1/4 w-96 h-96 rounded-full bg-[#dcf2e3]/45 blur-3xl pointer-events-none z-0"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 rounded-full bg-white/95 blur-xl pointer-events-none z-0 shadow-[0_15px_35px_rgba(21,128,61,0.04)] border border-green-100/40"></div>
    <div class="absolute top-1/3 left-1/4 w-80 h-80 rounded-full border border-green-200/25 pointer-events-none z-0"></div>
    <div class="absolute -bottom-10 right-1/3 w-[300px] h-[300px] rounded-full border-2 border-dashed border-green-200/15 pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto grid grid-cols-2 gap-16 relative z-10 w-full">
        <!-- Vision -->
        <div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Our Vision</h3>
            <p class="text-green-800 font-semibold italic mb-4">"To be a leading and environmentally friendly company in the oleochemicals industry"</p>
            <p class="text-sm text-gray-600 leading-relaxed">Our vision is to be a leading and environmentally friendly company in the oleochemicals industry by growing profitability through delivery of high-quality products competitively to customers and developing the high skills of our people.</p>
        </div>

        <!-- Mission -->
        <div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-[#15803d] rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-white text-xs font-bold">1</span></div>
                    <p class="text-sm text-gray-600 leading-relaxed">To produce and supply high-quality products competitively and exceed customer expectations</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-[#15803d] rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-white text-xs font-bold">2</span></div>
                    <p class="text-sm text-gray-600 leading-relaxed">To achieve efficiency and attain sustainable growth for profitability</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-[#15803d] rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-white text-xs font-bold">3</span></div>
                    <p class="text-sm text-gray-600 leading-relaxed">To develop human resources competency through continuous improvement</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CORE VALUES ========== -->
<section class="px-16 py-20 about-green-bg">
    <!-- Background Glassmorphic Ornaments (Moved from Hero/Adapted) -->
    <div class="absolute -bottom-20 -left-20 w-[500px] h-[500px] rounded-full bg-white/[0.05] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute top-1/4 right-[5%] w-80 h-80 rounded-full bg-white/[0.07] blur-xl pointer-events-none z-0"></div>
    <div class="absolute bottom-12 left-1/3 w-[300px] h-[300px] rounded-full border-2 border-dashed border-white/[0.05] pointer-events-none z-0"></div>
    <div class="absolute top-10 right-1/4 w-72 h-72 rounded-full border border-white/[0.06] pointer-events-none z-0"></div>

    <div class="text-center mb-12 relative z-10">
        <p class="text-xs font-bold text-green-300 uppercase tracking-[4px] mb-3">Core Values</p>
        <h2 class="text-3xl font-extrabold text-white mb-3">The Foundation of Our Culture</h2>
        <p class="text-sm text-green-100/90 max-w-xl mx-auto">We adopt the philosophy of Integrity, Achievement Oriented, Customer Service Oriented, Organization Commitment and Team Work to meet Customers and Stakeholders expectation.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 max-w-7xl mx-auto relative z-10 w-full">
        <!-- Integrity -->
        <div class="text-center">
            <div class="w-16 h-16 bg-white/10 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <h3 class="font-bold text-white mb-2">Integrity</h3>
            <p class="text-xs text-green-200 leading-relaxed">We act consistently with professional honesty and sincerity in all of our daily activities.</p>
        </div>
        <!-- Achievement Orientation -->
        <div class="text-center">
            <div class="w-16 h-16 bg-white/10 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
            <h3 class="font-bold text-white mb-2">Achievement Orientation</h3>
            <p class="text-xs text-green-200 leading-relaxed">We take pride in our work and commit extra effort to achieve outstanding results.</p>
        </div>
        <!-- Customer Service Orientation -->
        <div class="text-center">
            <div class="w-16 h-16 bg-white/10 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 class="font-bold text-white mb-2">Customer Service</h3>
            <p class="text-xs text-green-200 leading-relaxed">We make utmost efforts to discover, understand, and exceed our customers' needs.</p>
        </div>
        <!-- Organization Commitment -->
        <div class="text-center">
            <div class="w-16 h-16 bg-white/10 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M3 7v1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7m0 1a3 3 0 0 0 6 0V7H3"/><path d="M4 21V10h16v11"/></svg>
            </div>
            <h3 class="font-bold text-white mb-2">Organization Commitment</h3>
            <p class="text-xs text-green-200 leading-relaxed">We align our behaviors and priorities with the company's goals, interests, and policies.</p>
        </div>
        <!-- Team Work -->
        <div class="text-center sm:col-span-2 lg:col-span-1">
            <div class="w-16 h-16 bg-white/10 border border-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 class="font-bold text-white mb-2">Team Work</h3>
            <p class="text-xs text-green-200 leading-relaxed">We collaborate and communicate effectively across all departments to achieve common success.</p>
        </div>
    </div>
</section>

<!-- ========== JOURNEY OF GROWTH ========== -->
<section class="px-16 py-20 bg-gradient-to-br from-[#e8f5ed] via-white to-[#f0f9f4] border-y border-green-100/50 relative overflow-hidden">
    <!-- Background Glassmorphic Ornaments -->
    <div class="absolute -top-24 left-1/4 w-[400px] h-[400px] rounded-full bg-[#dcf2e3]/45 blur-3xl pointer-events-none z-0"></div>
    <div class="absolute bottom-10 right-10 w-72 h-72 rounded-full bg-white/95 blur-xl pointer-events-none z-0 shadow-[0_15px_30px_rgba(21,128,61,0.04)] border border-green-100/40"></div>
    <div class="absolute top-1/3 right-1/3 w-[280px] h-[280px] rounded-full border border-green-200/20 pointer-events-none z-0"></div>
    <div class="absolute -bottom-10 left-10 w-64 h-64 rounded-full border border-green-200/10 pointer-events-none z-0"></div>

    <div class="text-center mb-14 relative z-10">
        <h2 class="text-3xl font-extrabold text-gray-900">Our Journey of Growth</h2>
    </div>

    <div class="grid grid-cols-4 gap-8 max-w-6xl mx-auto relative z-10 w-full">
        <div class="text-center">
            <div class="w-12 h-12 bg-[#15803d] rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">1</span></div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">1990</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Establishment of PT Ecogreen Oleochemicals as a pioneer in the fatty alcohols sector.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-[#15803d] rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">2</span></div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">2001</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Acquisition by consortium (Wings, Lautan Luas, Djarum) driving significant global scale.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-[#15803d] rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">3</span></div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">2010</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Strengthening sustainability through RSPO certifications and global standard integrations.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-[#15803d] rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">4</span></div>
            <h3 class="text-xl font-extrabold text-[#15803d] mb-2">Present</h3>
            <p class="text-xs text-gray-500 leading-relaxed">A leading global producer of natural fatty alcohols supplying clients in over 30 countries.</p>
        </div>
    </div>
</section>

<!-- ========== CTA ========== -->
<section class="px-16 py-20 about-green-bg border-t border-green-950/20">
    <!-- Background Glassmorphic Ornaments (Moved/Adapted) -->
    <div class="absolute -top-20 left-[10%] w-[500px] h-[500px] rounded-full bg-white/[0.04] blur-3xl pointer-events-none z-0"></div>
    <div class="absolute -bottom-20 right-[5%] w-[450px] h-[450px] rounded-full bg-white/[0.06] blur-3xl pointer-events-none z-0"></div>

    <div class="bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl rounded-2xl p-12 text-center max-w-5xl mx-auto relative overflow-hidden z-10">
        <!-- Decorative inside Card -->
        <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none z-0"></div>
        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-white/5 rounded-full blur-xl pointer-events-none z-0"></div>
        <div class="absolute top-1/4 left-10 w-16 h-16 border border-white/10 rounded-full pointer-events-none z-0"></div>

        <h2 class="text-2xl font-extrabold text-white mb-3 relative z-10">Join our sustainable mission</h2>
        <p class="text-sm text-green-100 mb-8 relative z-10">Interested in working with us or learning more about our solutions? Connect with our global team today.</p>
        <div class="flex gap-3 justify-center relative z-10">
            <button id="btn-hubungi-hrd" class="bg-white text-green-900 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg text-sm transition-colors">Hubungi HRD</button>
            <a href="/lowongan" class="border border-white/30 text-white font-semibold px-6 py-3 rounded-lg text-sm hover:bg-white/10 transition-colors">Career Opportunities</a>
        </div>
    </div>
</section>

<!-- Modal Hubungi HRD -->
<div id="modal-hrd" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-8 relative">
        <button onclick="document.getElementById('modal-hrd').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>

        <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center mx-auto mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 text-center mb-5">Hubungi Tim HRD</h2>

        <div class="space-y-4">
            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Email</p>
                    <p class="text-sm font-semibold text-gray-900">career@ecogreenoleo.com</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Telepon</p>
                    <p class="text-sm font-semibold text-gray-900">+62 778 711002</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Alamat</p>
                    <p class="text-sm font-semibold text-gray-900">Jl. Pelabuhan Kav. 1, Kabil, Batam 29467, Kepulauan Riau</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('btn-hubungi-hrd').addEventListener('click', function () {
    document.getElementById('modal-hrd').classList.remove('hidden');
});
document.getElementById('modal-hrd').addEventListener('click', function (e) {
    if (e.target === this) this.classList.add('hidden');
});
</script>
@endsection