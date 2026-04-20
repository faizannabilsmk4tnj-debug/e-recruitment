@extends($layout ?? 'layouts.landing')

@section('title', 'Detail Lowongan')
@if(!isset($layout))
@section('nav-lowongan', 'text-white font-semibold')
@endif

@section('content')

<!-- Breadcrumb -->
<div class="px-16 py-4 bg-white border-b border-gray-100">
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ isset($layout) ? '/pelamar/dashboard' : '/' }}" class="hover:text-green-700 transition-colors">Beranda</a>
        <span>›</span>
        <a href="{{ isset($layout) ? '/pelamar/lowongan' : '/lowongan' }}" class="hover:text-green-700 transition-colors">Lowongan</a>
        <span>›</span>
        <span class="text-gray-700 font-medium" id="breadcrumb-title">Senior Web Developer</span>
    </div>
</div>

<!-- Main Content -->
<section class="px-16 py-8 bg-gray-50">
    <div class="flex gap-6 items-start">

        <!-- LEFT: Job Details (2/3) -->
        <div class="flex-1 space-y-6">

            <!-- Header Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-8">
                <div class="flex items-start gap-5 mb-6">
                    <div class="w-16 h-16 bg-green-800 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white text-lg font-bold leading-none">E<br>G</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-gray-900" id="job-title">Senior Web Developer</h1>
                            <span class="text-xs font-bold text-orange-700 bg-orange-50 border border-orange-200 px-2.5 py-0.5 rounded-full uppercase" id="job-badge">Urgent</span>
                        </div>
                        <p class="text-green-700 font-medium mt-1" id="job-company">PT Ecogreen Oleochemicals</p>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span id="job-location">Batam, Kepulauan Riau</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span id="job-type">Full-time</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                <span id="job-posted">Diposting 2 hari yang lalu</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Slot Progress -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-1">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Slot Terisi</p>
                            <p class="text-xs text-gray-500" id="slot-desc">7 posisi tersisa dari total 10</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900" id="slot-count">3/10</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-green-600 h-2 rounded-full transition-all" id="slot-bar" style="width: 30%"></div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bg-white rounded-xl border border-gray-200 p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Deskripsi Pekerjaan</h2>
                <div class="text-sm text-gray-600 leading-relaxed space-y-3" id="job-description">
                    <p>Kami sedang mencari Senior Web Developer yang berpengalaman untuk bergabung dengan tim IT kami di Batam. Anda akan bertanggung jawab untuk membangun dan memelihara aplikasi web internal yang kritikal bagi operasional manufaktur oleokimia global kami.</p>
                    <p>Anda akan bekerja dalam lingkungan yang dinamis dengan teknologi terbaru untuk memberikan solusi perangkat lunak yang skalabel dan aman.</p>
                </div>

                <h2 class="text-lg font-bold text-gray-900 mt-8 mb-4">Kualifikasi</h2>
                <ul class="space-y-2.5 text-sm text-gray-600" id="job-qualifications">
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Minimal 5 tahun pengalaman dalam pengembangan web full-stack.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Keahlian mendalam dalam React.js, Node.js, dan database SQL/NoSQL.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Pengalaman dengan arsitektur microservices dan Docker/Kubernetes.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Memahami prinsip CI/CD dan pengujian otomatis.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Gelar Sarjana di bidang Ilmu Komputer, Teknik Informatika, atau bidang terkait.
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Mampu berkomunikasi dalam Bahasa Inggris (minimal pasif).
                    </li>
                </ul>

                <h2 class="text-lg font-bold text-gray-900 mt-8 mb-4">Keuntungan & Fasilitas</h2>
                <div class="grid grid-cols-2 gap-4" id="job-benefits">
                    <div class="flex items-start gap-3 bg-gray-50 rounded-lg p-4">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 18V6"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900">Gaji Kompetitif</p>
                            <p class="text-xs text-gray-500">Penyesuaian berkala berdasarkan performa.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-gray-50 rounded-lg p-4">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900">Asuransi Kesehatan</p>
                            <p class="text-xs text-gray-500">Cover penuh untuk karyawan dan keluarga.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-gray-50 rounded-lg p-4">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900">Work Equipment</p>
                            <p class="text-xs text-gray-500">Perangkat kerja high-end disediakan.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 bg-gray-50 rounded-lg p-4">
                        <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900">Bonus Tahunan</p>
                            <p class="text-xs text-gray-500">Tunjangan hari raya dan performa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Action Panel (1/3) -->
        <div class="w-80 shrink-0 space-y-6">

            <!-- Tindakan Cepat -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="font-bold text-gray-900 mb-2">Tindakan Cepat</h3>
                <p class="text-sm text-gray-500 mb-5">Tertarik dengan posisi ini? Lamar sekarang sebelum kuota penuh.</p>
                @if(isset($layout))
                <a href="/pelamar/review-lamaran/1" class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Lamar Sekarang
                </a>
                @else
                <button data-auth-required class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Lamar Sekarang
                </button>
                @endif
                <button data-auth-required class="flex items-center justify-center gap-2 w-full border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/></svg>
                    Simpan Pekerjaan
                </button>

                <!-- Share -->
                <div class="mt-5 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 flex items-center gap-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" x2="12" y1="2" y2="15"/></svg>
                        Bagikan lowongan ini
                    </p>
                    <div class="flex gap-2">
                        <button class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </button>
                        <button class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </button>
                        <button class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors" onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'w-4 h-4 text-green-600\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\'><path d=\'m9 12 2 2 4-4\'/><circle cx=\'12\' cy=\'12\' r=\'10\'/></svg>'; setTimeout(() => this.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'w-4 h-4\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\'><path d=\'M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71\'/><path d=\'M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71\'/></svg>', 2000)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tentang Perusahaan -->
            <div class="bg-green-50 rounded-xl border border-green-200 p-6">
                <h3 class="font-bold text-green-900 mb-2">Tentang Perusahaan</h3>
                <p class="text-sm text-green-800 leading-relaxed">PT Ecogreen Oleochemicals adalah salah satu produsen alkohol lemak alami terkemuka di dunia yang berkomitmen pada keberlanjutan dan kualitas tinggi.</p>
                <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 mt-3 transition-colors">
                    Lihat Profil Perusahaan
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection