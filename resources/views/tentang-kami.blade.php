@extends('layouts.landing')

@section('title', 'Tentang Kami - PT Ecogreen Oleochemicals')

@section('css')
<style>
    .hero-about {
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.5)), linear-gradient(135deg, #14532d 0%, #166534 30%, #15803d 60%, #22c55e 100%);
        min-height: 420px;
    }
    .hero-about::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .about-image {
        background: linear-gradient(135deg, #14532d, #166534);
        position: relative;
        overflow: hidden;
    }
    .about-image::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(20,83,45,0.7), transparent);
    }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp 0.6s ease-out forwards; opacity: 0; }
</style>
@endsection

@section('content')

<!-- ========== HERO ========== -->
<section class="hero-about relative flex items-end px-16 pb-12 pt-24">
    <div class="relative z-10 max-w-2xl">
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
    <!-- Decorative text -->
    <div class="absolute right-16 bottom-16 text-right z-10">
        <p class="text-6xl font-extrabold text-white/10 tracking-wider">RESPONSIBLE</p>
        <p class="text-4xl font-extrabold text-white/10 tracking-wider">SUSTAINABLE</p>
    </div>
</section>

<!-- ========== ABOUT US ========== -->
<section class="px-16 py-20 bg-white" id="about">
    <div class="flex items-start gap-16">
        <!-- Left: Image -->
        <div class="w-[420px] shrink-0">
            <div class="about-image rounded-2xl h-[480px] flex items-end p-6">
                <!-- Factory silhouette -->
                <div class="absolute inset-0 flex items-center justify-center opacity-15">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-48 h-48 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5"><path d="M2 20h20V8l-5 4V8l-5 4V4H2v16z"/><rect x="6" y="14" width="2" height="2"/><rect x="10" y="14" width="2" height="2"/></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-white font-bold text-lg">Global</p>
                    <p class="text-green-300 text-xs uppercase tracking-widest">Production Footprint</p>
                </div>
            </div>
        </div>

        <!-- Right: Text -->
        <div class="flex-1">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-[4px] mb-3">About Us</p>
            <h2 class="text-3xl font-extrabold text-gray-900 leading-tight mb-6">A Global Pioneer in<br>Natural Solutions</h2>

            <div class="space-y-4 text-sm text-gray-600 leading-relaxed">
                <p>Ecogreen Oleochemicals is one of the leading producers of natural fatty alcohols in the world. We operate cutting-edge production facilities in <strong>Indonesia</strong> (PT Ecogreen Oleochemicals), <strong>Singapore</strong> (Ecogreen Oleochemicals (Singapore) Pte Ltd), <strong>Germany</strong> (Ecogreen Oleochemicals GmbH), and <strong>France</strong> (Ecogreen Oleochemicals Chimie).</p>
                <p>Our commitment to excellence extends through our strategically located marketing offices in <strong>Singapore, Germany, and the USA</strong>, ensuring that our high-quality oleochemical solutions are accessible to clients across the globe.</p>
                <p>By utilizing renewable plant-based feedstocks and maintaining a focus on technological innovation, we bridge the gap between agricultural abundance and industrial necessity, contributing to a circular and carbon-conscious global economy.</p>
            </div>

            <div class="flex gap-12 mt-8 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-3xl font-extrabold text-green-800">4</p>
                    <p class="text-xs text-gray-500 mt-1">Global Production Hubs</p>
                </div>
                <div>
                    <p class="text-3xl font-extrabold text-green-800">Major</p>
                    <p class="text-xs text-gray-500 mt-1">Marketing Networks</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== VISION & MISSION ========== -->
<section class="px-16 py-20 bg-gray-50">
    <div class="grid grid-cols-2 gap-16">
        <!-- Vision -->
        <div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Our Vision</h3>
            <p class="text-green-800 font-semibold italic mb-4">"A Leading Company in the Oleochemicals Industry"</p>
            <p class="text-sm text-gray-600 leading-relaxed">Our vision is a landmark of direction to grow profitability through delivery of high quality products competitively to customers and develop high skill of our people in the oleochemicals industry.</p>
        </div>

        <!-- Mission -->
        <div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-green-800 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-white text-xs font-bold">1</span></div>
                    <p class="text-sm text-gray-600 leading-relaxed">To produce and supply high quality products and exceed client's need</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-green-800 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-white text-xs font-bold">2</span></div>
                    <p class="text-sm text-gray-600 leading-relaxed">To develop efficiency and attain sustainable growth for profitability</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-green-800 rounded-lg flex items-center justify-center shrink-0 mt-0.5"><span class="text-white text-xs font-bold">3</span></div>
                    <p class="text-sm text-gray-600 leading-relaxed">To develop human resources competency through continual improvement</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CORE VALUES ========== -->
<section class="px-16 py-20 bg-white">
    <div class="text-center mb-12">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-[4px] mb-3">Core Values</p>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-3">The Foundation of Our Culture</h2>
        <p class="text-sm text-gray-500 max-w-xl mx-auto">We adopt the philosophy of Integrity, Achievement Oriented, Customer Service Oriented, Organization Commitment and Team Work to meet Customers and Stakeholders expectation.</p>
    </div>

    <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Integrity</h3>
            <p class="text-xs text-gray-500 leading-relaxed">We act consistently of professional honesty and sincerity of what we will do in our daily activities.</p>
        </div>
        <div class="text-center">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Customer Service</h3>
            <p class="text-xs text-gray-500 leading-relaxed">We do utmost efforts on discovering and understanding the customer client's need.</p>
        </div>
        <div class="text-center">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Achievement</h3>
            <p class="text-xs text-gray-500 leading-relaxed">We bring pride in our work and are proud to spend extra effort to get the desired result.</p>
        </div>
    </div>
</section>

<!-- ========== JOURNEY OF GROWTH ========== -->
<section class="px-16 py-20 bg-gray-50">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-extrabold text-gray-900">Our Journey of Growth</h2>
    </div>

    <div class="grid grid-cols-4 gap-8 max-w-4xl mx-auto">
        <div class="text-center">
            <div class="w-12 h-12 bg-green-800 rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">1</span></div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">1990</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Founding of PT Ecogreen Oleochemicals with initial focus on fatty alcohols.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-green-800 rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">2</span></div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">2005</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Major expansion of refining capacities and global distribution offices established.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-green-800 rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">3</span></div>
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">2015</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Achievement of world-class sustainability certifications and carbon neutral goals.</p>
        </div>
        <div class="text-center">
            <div class="w-12 h-12 bg-green-800 rounded-xl flex items-center justify-center mx-auto mb-4"><span class="text-white font-bold">4</span></div>
            <h3 class="text-xl font-extrabold text-green-800 mb-2">Present</h3>
            <p class="text-xs text-gray-500 leading-relaxed">Global leader in oleochemical innovation with a net-zero future vision.</p>
        </div>
    </div>
</section>

<!-- ========== CTA ========== -->
<section class="px-16 py-20 bg-white">
    <div class="bg-gray-50 rounded-2xl p-12 text-center max-w-3xl mx-auto relative overflow-hidden">
        <!-- Decorative -->
        <div class="absolute top-4 right-8 w-16 h-16 bg-green-100 rounded-full opacity-40"></div>
        <div class="absolute bottom-4 right-16 w-10 h-10 bg-green-100 rounded-full opacity-30"></div>

        <h2 class="text-2xl font-extrabold text-gray-900 mb-3 relative z-10">Join our sustainable mission</h2>
        <p class="text-sm text-gray-500 mb-8 relative z-10">Interested in working with us or learning more about our solutions? Connect with our global team today.</p>
        <div class="flex gap-3 justify-center relative z-10">
            <button id="btn-hubungi-hrd" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg text-sm transition-colors">Hubungi HRD</button>
            <a href="/lowongan" class="border border-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg text-sm hover:bg-gray-100 transition-colors">Career Opportunities</a>
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
                    <p class="text-sm font-semibold text-gray-900">+62 778 123 456</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Alamat</p>
                    <p class="text-sm font-semibold text-gray-900">Kabil, Batam, Kepulauan Riau</p>
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