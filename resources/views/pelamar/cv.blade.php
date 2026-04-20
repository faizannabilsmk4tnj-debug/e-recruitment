@extends('layouts.pelamar')

@section('title', 'CV Saya')
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
            <p class="text-[10px] font-bold text-green-700 uppercase tracking-widest mb-1">Paling Populer</p>
            <h3 class="font-bold text-gray-900 text-lg">Modern Executive 2024</h3>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">Desain tegas dengan struktur modular, ideal bagi manajer dan pemimpin proyek senior dengan tata letak kontemporer.</p>
            <button class="select-btn w-full mt-4 bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 hover:bg-green-700">
                Pilih Template
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
            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">Struktur Formal</p>
            <h3 class="font-bold text-gray-900 text-lg">Academic Specialist</h3>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">Gaya CV akademis dengan kolom ganda dan tipografi serif yang terorganisir untuk informasi padat.</p>
            <button class="select-btn w-full mt-4 bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 hover:bg-green-700">
                Pilih Template
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
            <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest mb-1">Desain Berani</p>
            <h3 class="font-bold text-gray-900 text-lg">Creative Industrial</h3>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">Template CV yang kreatif dan berani dengan elemen arsitektural dan aksen tema gelap yang modern.</p>
            <button class="select-btn w-full mt-4 bg-green-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 hover:bg-green-700">
                Pilih Template
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
            Tutup Preview
        </button>
    </div>

    <!-- ===== PREVIEW 1: Modern Executive — sidebar kiri hijau ===== -->
    <div id="tpl-modern" class="cv-preview-panel max-w-3xl mx-auto animate-preview">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="grid grid-cols-10 min-h-[700px]">
                <!-- Sidebar Kiri -->
                <div class="col-span-3 bg-green-900 text-white p-6 space-y-6">
                    <div class="text-center pb-5 border-b border-green-700">
                        <div class="w-20 h-20 bg-green-800 rounded-full mx-auto mb-3 flex items-center justify-center border-2 border-green-500">
                            <span class="text-2xl font-bold text-green-300">AR</span>
                        </div>
                        <h2 class="font-bold text-base">Ahmad Rizky Pratama</h2>
                        <p class="text-green-300 text-xs mt-1">Process Engineer</p>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Kontak</h4>
                        <div class="space-y-2 text-xs text-green-100">
                            <p>ahmad.rizky@email.com</p>
                            <p>+62 812 3456 7890</p>
                            <p>Batam, Kepulauan Riau</p>
                            <p>linkedin.com/in/ahmadrizky</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Keahlian Teknis</h4>
                        <div class="space-y-2.5">
                            <div><p class="text-xs text-green-100 mb-1">Process Optimization</p><div class="w-full bg-green-800 rounded-full h-1.5"><div class="bg-green-400 h-1.5 rounded-full" style="width:92%"></div></div></div>
                            <div><p class="text-xs text-green-100 mb-1">Chemical Analysis</p><div class="w-full bg-green-800 rounded-full h-1.5"><div class="bg-green-400 h-1.5 rounded-full" style="width:88%"></div></div></div>
                            <div><p class="text-xs text-green-100 mb-1">Quality Control (ISO)</p><div class="w-full bg-green-800 rounded-full h-1.5"><div class="bg-green-400 h-1.5 rounded-full" style="width:85%"></div></div></div>
                            <div><p class="text-xs text-green-100 mb-1">SAP ERP</p><div class="w-full bg-green-800 rounded-full h-1.5"><div class="bg-green-400 h-1.5 rounded-full" style="width:78%"></div></div></div>
                            <div><p class="text-xs text-green-100 mb-1">Lean Manufacturing</p><div class="w-full bg-green-800 rounded-full h-1.5"><div class="bg-green-400 h-1.5 rounded-full" style="width:82%"></div></div></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Bahasa</h4>
                        <div class="space-y-1 text-xs text-green-100"><p>Indonesia — Native</p><p>English — Professional</p></div>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-bold uppercase tracking-[2px] text-green-400 mb-2">Sertifikasi</h4>
                        <div class="space-y-1 text-xs text-green-100"><p>• Lean Six Sigma Green Belt</p><p>• K3 Umum (Kemnaker RI)</p><p>• ISO 9001:2015 Lead Auditor</p></div>
                    </div>
                </div>
                <!-- Konten Utama -->
                <div class="col-span-7 p-8 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Profil Profesional</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Process Engineer dengan pengalaman 5+ tahun di industri oleokimia. Terampil dalam optimalisasi proses produksi fatty alcohol, pengendalian mutu, dan implementasi sistem manajemen K3 & lingkungan. Berkomitmen pada prinsip sustainable manufacturing.</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-3 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Pengalaman Kerja</h3>
                        <div class="space-y-5">
                            <div class="border-l-2 border-green-200 pl-4">
                                <div class="flex justify-between items-start"><p class="font-bold text-sm text-gray-900">Senior Process Engineer</p><span class="text-xs text-green-700 bg-green-50 px-2 py-0.5 rounded font-semibold">2021 — Sekarang</span></div>
                                <p class="text-sm text-gray-500">PT Ecogreen Oleochemicals — Batam</p>
                                <ul class="mt-2 text-xs text-gray-600 space-y-1"><li>• Mengoptimalkan proses distilasi fatty alcohol, meningkatkan yield 12%</li><li>• Memimpin tim 15 operator di plant fractionation</li><li>• Implementasi SOP baru sesuai standar ISO 14001</li><li>• Menurunkan waste production sebesar 18% melalui lean manufacturing</li></ul>
                            </div>
                            <div class="border-l-2 border-gray-200 pl-4">
                                <div class="flex justify-between items-start"><p class="font-bold text-sm text-gray-900">Junior Process Engineer</p><span class="text-xs text-gray-400">2019 — 2021</span></div>
                                <p class="text-sm text-gray-500">PT Musim Mas — Medan</p>
                                <ul class="mt-2 text-xs text-gray-600 space-y-1"><li>• Monitoring parameter proses produksi CPO dan turunannya</li><li>• Analisis data produksi dan penyusunan laporan bulanan</li><li>• Koordinasi dengan tim QC untuk pemenuhan standar RSPO</li></ul>
                            </div>
                            <div class="border-l-2 border-gray-200 pl-4">
                                <div class="flex justify-between items-start"><p class="font-bold text-sm text-gray-900">Internship — Production Dept.</p><span class="text-xs text-gray-400">2018 (6 bulan)</span></div>
                                <p class="text-sm text-gray-500">PT Wilmar Nabati Indonesia — Gresik</p>
                                <ul class="mt-2 text-xs text-gray-600 space-y-1"><li>• Asisten analisis laboratorium untuk quality assurance</li></ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-green-800 uppercase tracking-[3px] mb-3 flex items-center gap-2"><span class="w-5 h-0.5 bg-green-700"></span>Pendidikan</h3>
                        <div class="border-l-2 border-green-200 pl-4">
                            <p class="font-bold text-sm text-gray-900">S1 Teknik Kimia</p>
                            <p class="text-sm text-gray-500">Institut Teknologi Sepuluh Nopember (ITS) — Surabaya</p>
                            <p class="text-xs text-gray-400 mt-0.5">2015 — 2019 • IPK 3.68 / 4.00 • Cum Laude</p>
                            <p class="text-xs text-gray-500 mt-1 italic">Skripsi: "Optimasi Proses Hidrogenasi Minyak Kelapa Sawit Menggunakan Katalis Nikel"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PREVIEW 2: Academic Specialist — formal dua kolom seimbang ===== -->
    <div id="tpl-academic" class="cv-preview-panel max-w-3xl mx-auto animate-preview hidden">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm p-10" style="font-family: 'Georgia', serif;">
            <!-- Header -->
            <div class="text-center pb-5 mb-6 border-b-2 border-gray-800">
                <h1 class="text-2xl font-bold text-gray-900 tracking-wide" style="font-family: 'Georgia', serif;">AHMAD RIZKY PRATAMA, S.T.</h1>
                <p class="text-sm text-gray-600 mt-1.5 tracking-wide">Process Engineer — Oleochemical Manufacturing</p>
                <p class="text-xs text-gray-400 mt-2">Batam, Kepulauan Riau • ahmad.rizky@email.com • +62 812 3456 7890 • linkedin.com/in/ahmadrizky</p>
            </div>
            <!-- Summary -->
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-2">Ringkasan Profesional</h3>
                <p class="text-sm text-gray-600 leading-relaxed" style="text-align:justify;">Lulusan Teknik Kimia dengan pengalaman 5 tahun di industri oleokimia dan turunan kelapa sawit. Kompetensi utama meliputi perancangan proses, pengendalian mutu berbasis ISO, dan penerapan prinsip green chemistry dalam skala produksi massal. Berpengalaman dalam lingkungan multinasional dengan standar operasional tinggi.</p>
            </div>
            <!-- Two columns -->
            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Pengalaman Profesional</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="font-bold text-sm text-gray-900">Senior Process Engineer</p>
                                <p class="text-xs text-gray-500 italic">PT Ecogreen Oleochemicals, Batam — 2021 s.d. Sekarang</p>
                                <ul class="mt-1.5 text-xs text-gray-600 space-y-1 leading-relaxed"><li>– Optimasi proses distilasi fatty alcohol dengan peningkatan yield 12%</li><li>– Memimpin inisiatif lean manufacturing di area fractionation</li><li>– Audit internal ISO 9001, ISO 14001, dan OHSAS 18001</li></ul>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Junior Process Engineer</p>
                                <p class="text-xs text-gray-500 italic">PT Musim Mas, Medan — 2019 s.d. 2021</p>
                                <ul class="mt-1.5 text-xs text-gray-600 space-y-1 leading-relaxed"><li>– Monitoring dan analisis parameter proses produksi CPO</li><li>– Penyusunan laporan produksi bulanan dan analisis tren</li><li>– Koordinasi pemenuhan standar sertifikasi RSPO</li></ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Publikasi & Karya Ilmiah</h3>
                        <div class="text-xs text-gray-600 space-y-2 leading-relaxed">
                            <p>Pratama, A.R. (2023). <em>"Sustainable Fatty Alcohol Production: Process Optimization Review."</em> Jurnal Teknik Kimia Indonesia, Vol. 12(2), pp. 45-58.</p>
                            <p>Pratama, A.R., et al. (2019). <em>"Katalisis Nikel pada Hidrogenasi Minyak Sawit."</em> Prosiding Seminar Nasional Teknik Kimia ITS.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Pendidikan</h3>
                        <div>
                            <p class="font-bold text-sm text-gray-900">Sarjana Teknik Kimia (S.T.)</p>
                            <p class="text-xs text-gray-500 italic">Institut Teknologi Sepuluh Nopember — 2015 s.d. 2019</p>
                            <p class="text-xs text-gray-400 mt-1">Predikat Cum Laude • IPK 3.68 / 4.00</p>
                            <p class="text-xs text-gray-500 mt-1">Skripsi: "Optimasi Proses Hidrogenasi Minyak Kelapa Sawit Menggunakan Katalis Nikel"</p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Kompetensi Teknis</h3>
                        <div class="text-xs text-gray-600 space-y-1"><p>• Process Design & Simulation (Aspen Plus, HYSYS)</p><p>• Quality Management System (ISO 9001, 14001)</p><p>• Lean Manufacturing & Six Sigma</p><p>• Statistical Process Control (SPC)</p><p>• SAP ERP — Modul PP & QM</p><p>• Laboratorium: HPLC, GC, Titrasi</p></div>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Sertifikasi</h3>
                        <div class="text-xs text-gray-600 space-y-1"><p>• Lean Six Sigma Green Belt — 2022</p><p>• Ahli K3 Umum — Kemnaker RI, 2021</p><p>• ISO 9001:2015 Internal Auditor — 2021</p><p>• RSPO Supply Chain Certification — 2020</p></div>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Bahasa</h3>
                        <div class="text-xs text-gray-600 space-y-1"><p>Bahasa Indonesia — Penutur Asli</p><p>English — Professional Working (TOEFL ITP: 563)</p></div>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider border-b border-gray-300 pb-1 mb-3">Penghargaan</h3>
                        <div class="text-xs text-gray-600 space-y-1"><p>• Best Improvement Project — Ecogreen, 2023</p><p>• Employee of The Quarter Q2 — Musim Mas, 2020</p></div>
                    </div>
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
                    <div class="w-20 h-20 bg-slate-700 rounded-xl flex items-center justify-center border-2 border-amber-500 shrink-0">
                        <span class="text-2xl font-extrabold text-amber-400">AR</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-white tracking-wide">AHMAD RIZKY PRATAMA</h1>
                        <p class="text-amber-400 font-semibold text-sm mt-0.5">PROCESS ENGINEER — OLEOCHEMICAL INDUSTRY</p>
                        <div class="flex gap-4 mt-2 text-xs text-slate-400">
                            <span>Batam, Indonesia</span><span>•</span><span>ahmad.rizky@email.com</span><span>•</span><span>+62 812 3456 7890</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Body -->
            <div class="grid grid-cols-10 min-h-[500px]">
                <!-- Main Content -->
                <div class="col-span-7 p-8 space-y-6 border-r border-slate-800">
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Profil</h3>
                        <p class="text-sm text-slate-300 leading-relaxed">Engineer berpengalaman di industri oleokimia dengan spesialisasi dalam optimasi proses produksi fatty alcohol dan fatty acid. Menguasai penerapan lean manufacturing dan continuous improvement di lingkungan plant berskala besar.</p>
                    </div>
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-4 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Pengalaman</h3>
                        <div class="space-y-5">
                            <div class="relative pl-5 border-l-2 border-amber-500/40">
                                <div class="absolute -left-[5px] top-1 w-2 h-2 bg-amber-500 rounded-full"></div>
                                <div class="flex justify-between items-start"><p class="font-bold text-sm text-white">Senior Process Engineer</p><span class="text-[10px] text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded font-semibold">2021 — SEKARANG</span></div>
                                <p class="text-xs text-slate-400 mt-0.5">PT Ecogreen Oleochemicals — Batam Plant</p>
                                <ul class="mt-2 text-xs text-slate-300 space-y-1"><li>→ Peningkatan yield distilasi fatty alcohol sebesar 12%</li><li>→ Lead engineer untuk commissioning unit fractionation baru</li><li>→ Implementasi program lean manufacturing, waste turun 18%</li><li>→ Supervisi tim 15 operator produksi shift rotating</li></ul>
                            </div>
                            <div class="relative pl-5 border-l-2 border-slate-700">
                                <div class="absolute -left-[5px] top-1 w-2 h-2 bg-slate-600 rounded-full"></div>
                                <div class="flex justify-between items-start"><p class="font-bold text-sm text-white">Junior Process Engineer</p><span class="text-[10px] text-slate-500">2019 — 2021</span></div>
                                <p class="text-xs text-slate-400 mt-0.5">PT Musim Mas — Medan Refinery</p>
                                <ul class="mt-2 text-xs text-slate-300 space-y-1"><li>→ Monitoring proses refining dan fractionation CPO</li><li>→ Analisis data produksi untuk continuous improvement</li><li>→ Support audit sertifikasi RSPO dan ISCC</li></ul>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-amber-400 text-[10px] font-bold uppercase tracking-[3px] mb-2 flex items-center gap-2"><span class="w-6 h-0.5 bg-amber-500"></span>Pendidikan</h3>
                        <div class="bg-slate-800 rounded-lg p-4">
                            <p class="font-bold text-sm text-white">S1 Teknik Kimia — Institut Teknologi Sepuluh Nopember</p>
                            <p class="text-xs text-slate-400 mt-1">2015 — 2019 • Cum Laude • IPK 3.68</p>
                            <p class="text-xs text-slate-500 mt-1 italic">Fokus: Teknologi Proses Oleokimia & Katalis Heterogen</p>
                        </div>
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="col-span-3 bg-slate-800/50 p-6 space-y-5">
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-3">Keahlian Inti</h4>
                        <div class="space-y-2.5">
                            <div><div class="flex justify-between mb-1"><p class="text-xs text-slate-300">Process Optimization</p><p class="text-[10px] text-amber-400">92%</p></div><div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-amber-500 h-1.5 rounded-full" style="width:92%"></div></div></div>
                            <div><div class="flex justify-between mb-1"><p class="text-xs text-slate-300">Chemical Analysis</p><p class="text-[10px] text-amber-400">88%</p></div><div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-amber-500 h-1.5 rounded-full" style="width:88%"></div></div></div>
                            <div><div class="flex justify-between mb-1"><p class="text-xs text-slate-300">ISO Quality System</p><p class="text-[10px] text-amber-400">85%</p></div><div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-amber-500 h-1.5 rounded-full" style="width:85%"></div></div></div>
                            <div><div class="flex justify-between mb-1"><p class="text-xs text-slate-300">Lean Manufacturing</p><p class="text-[10px] text-amber-400">82%</p></div><div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-amber-500 h-1.5 rounded-full" style="width:82%"></div></div></div>
                            <div><div class="flex justify-between mb-1"><p class="text-xs text-slate-300">SAP ERP (PP/QM)</p><p class="text-[10px] text-amber-400">78%</p></div><div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-amber-500 h-1.5 rounded-full" style="width:78%"></div></div></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-2">Tools & Software</h4>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded">Aspen Plus</span>
                            <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded">HYSYS</span>
                            <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded">AutoCAD</span>
                            <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded">MATLAB</span>
                            <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded">SAP</span>
                            <span class="text-[10px] bg-slate-700 text-slate-300 px-2 py-0.5 rounded">MS Office</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-2">Sertifikasi</h4>
                        <div class="space-y-2 text-xs text-slate-300">
                            <div class="flex items-start gap-2"><span class="text-amber-500 mt-0.5">▸</span><span>Lean Six Sigma Green Belt (2022)</span></div>
                            <div class="flex items-start gap-2"><span class="text-amber-500 mt-0.5">▸</span><span>Ahli K3 Umum — Kemnaker RI (2021)</span></div>
                            <div class="flex items-start gap-2"><span class="text-amber-500 mt-0.5">▸</span><span>ISO 9001 Internal Auditor (2021)</span></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-amber-400 text-[10px] font-bold uppercase tracking-[2px] mb-2">Bahasa</h4>
                        <div class="space-y-1.5 text-xs text-slate-300">
                            <div class="flex justify-between"><span>Indonesia</span><span class="text-amber-400 tracking-wider">●●●●●</span></div>
                            <div class="flex justify-between"><span>English</span><span><span class="text-amber-400 tracking-wider">●●●●</span><span class="text-slate-600 tracking-wider">●</span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tips Profesional -->
<div class="bg-gradient-to-br from-green-50 to-gray-50 rounded-xl border border-gray-200 p-8 mb-8">
    <div class="flex items-start gap-8">
        <div class="flex-1">
            <h2 class="text-xl font-bold text-gray-900 italic mb-4">Tips Profesional</h2>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">Pilih template yang memiliki rasio teks dan ruang kosong seimbang. Untuk posisi teknis, gunakan <strong>Modern Executive 2024</strong>. Untuk posisi marketing atau desain, <strong>Creative Industrial</strong> adalah pilihan terbaik.</p>
            <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 flex items-center gap-1 transition-colors">
                Baca Panduan Karir Lengkap
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17l9.2-9.2M17 17V7H7"/></svg>
            </a>
        </div>
        <div class="flex gap-4 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 p-5 w-40">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <p class="font-bold text-sm text-gray-900">ATS Friendly</p>
                <p class="text-xs text-gray-500 mt-1">Lolos seleksi bot perusahaan</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5 w-40">
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                </div>
                <p class="font-bold text-sm text-gray-900">Auto-Save</p>
                <p class="text-xs text-gray-500 mt-1">Tersimpan aman di cloud</p>
            </div>
        </div>
    </div>
</div>

<!-- Fixed Download Button -->
<div class="fixed bottom-0 left-60 bg-white border-t border-gray-200 p-4 z-40" style="width: calc(100% - 15rem);">
    <button id="btn-download" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg text-sm transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download PDF
    </button>
</div>

<!-- Spacer for fixed button -->
<div class="h-20"></div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const cards = document.querySelectorAll('.template-card');
    const previewSection = document.getElementById('cv-preview-section');
    const previewName = document.getElementById('preview-template-name');

    const templateNames = {
        modern: 'Modern Executive 2024',
        academic: 'Academic Specialist',
        creative: 'Creative Industrial'
    };

    cards.forEach(card => {
        // Click anywhere on card OR on button
        const btn = card.querySelector('.select-btn');
        if (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                selectTemplate(card);
            });
        }
        card.addEventListener('click', function () {
            selectTemplate(this);
        });
    });

    function selectTemplate(card) {
        cards.forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');

        const tmpl = card.dataset.template;
        previewName.textContent = templateNames[tmpl] || tmpl;

        // Hide all preview panels, show selected
        document.querySelectorAll('.cv-preview-panel').forEach(p => p.classList.add('hidden'));
        const preview = document.getElementById('tpl-' + tmpl);
        if (preview) preview.classList.remove('hidden');

        previewSection.classList.remove('hidden');
        previewSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Download PDF (demo)
    document.getElementById('btn-download').addEventListener('click', function () {
        alert('CV berhasil diunduh! (demo — nanti terhubung ke dompdf)');
    });
});
</script>
@endsection