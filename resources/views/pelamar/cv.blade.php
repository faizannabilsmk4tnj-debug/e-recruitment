@extends('layouts.pelamar')

@section('title', 'CV Saya')
@section('nav-cv', 'active')

@section('css')
<style>
    .template-card { transition: all 0.2s; }
    .template-card.active { border-color: #15803d; box-shadow: 0 0 0 2px #15803d; }
    .template-card.active .check-badge { display: flex; }
    .cv-preview { font-family: 'Georgia', serif; }
    .cv-preview h1 { font-family: 'Georgia', serif; }
    .cv-preview .section-title { font-size: 11px; letter-spacing: 2px; font-weight: 700; color: #15803d; margin-bottom: 8px; text-transform: uppercase; }
</style>
@endsection

@section('content')

<!-- Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Resume Editor</h1>
        <p class="text-gray-500 mt-1">CV Anda dibuat otomatis dari data profil. Pilih template dan unduh.</p>
    </div>
    <div class="flex gap-3">
        <button class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" x2="12" y1="2" y2="15"/></svg>
            Share Link
        </button>
        <button class="flex items-center gap-2 px-4 py-2.5 bg-green-800 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Draft
        </button>
    </div>
</div>

<!-- Preview Section -->
<div class="bg-white rounded-xl border border-gray-200 mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-bold text-gray-900">Real-time Preview</h2>
        <div class="flex gap-1">
            <button id="zoom-in" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6"/><path d="M8 11h6"/></svg>
            </button>
            <button id="zoom-out" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M8 11h6"/></svg>
            </button>
        </div>
    </div>

    <!-- CV Preview -->
    <div class="p-8 flex justify-center bg-gray-50 overflow-auto" style="max-height: 700px;">
        <div class="cv-preview bg-white shadow-lg border border-gray-200 w-full max-w-2xl p-10" id="cv-content" style="min-height: 900px;">

            <!-- Header -->
            <div class="flex justify-between items-start mb-8 pb-6 border-b border-gray-200">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900" id="cv-nama">Ahmad Budi Santoso</h1>
                    <p class="text-base text-green-700 font-medium mt-1 uppercase tracking-wider" id="cv-title">Senior Product Designer</p>
                </div>
                <div class="text-right text-sm text-gray-500 space-y-1">
                    <p id="cv-email">ahmad.santoso@email.com</p>
                    <p id="cv-phone">+62 812 3456 7890</p>
                    <p id="cv-location">Jakarta, Indonesia</p>
                </div>
            </div>

            <!-- Professional Summary -->
            <div class="mb-6">
                <p class="section-title">Professional Summary</p>
                <p class="text-sm text-gray-700 leading-relaxed" id="cv-summary">Experienced Product Designer with over 8 years in the tech industry. Focused on building user-centric interfaces and improving customer experience through data-driven design and collaborative development cycles.</p>
            </div>

            <!-- Experience -->
            <div class="mb-6">
                <p class="section-title">Experience</p>
                <div class="space-y-4" id="cv-experience">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-bold text-sm text-gray-900">Tech Giant Corp</p>
                            <p class="text-sm text-gray-600 italic">Lead UI/UX Designer</p>
                            <ul class="mt-2 space-y-1 text-sm text-gray-600 list-disc list-inside">
                                <li>Spearheaded redesign of flagship mobile app reaching 10M+ users</li>
                                <li>Implemented Design System across 4 cross-functional squads</li>
                            </ul>
                        </div>
                        <p class="text-sm text-gray-500 shrink-0 ml-4">2020 - Present</p>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <p class="font-bold text-sm text-gray-900">Startup Inovasi</p>
                            <p class="text-sm text-gray-600 italic">Junior Developer</p>
                            <ul class="mt-2 space-y-1 text-sm text-gray-600 list-disc list-inside">
                                <li>Built responsive web applications using modern frameworks</li>
                                <li>Collaborated with product team on 3 major feature launches</li>
                            </ul>
                        </div>
                        <p class="text-sm text-gray-500 shrink-0 ml-4">2017 - 2019</p>
                    </div>
                </div>
            </div>

            <!-- Education -->
            <div class="mb-6">
                <p class="section-title">Education</p>
                <div class="space-y-3" id="cv-education">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-bold text-sm text-gray-900">Universitas Indonesia</p>
                            <p class="text-sm text-gray-600">S1 Teknik Kimia — IPK: 3.75/4.00</p>
                        </div>
                        <p class="text-sm text-gray-500 shrink-0 ml-4">2018 - 2022</p>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <p class="font-bold text-sm text-gray-900">SMA Negeri 1 Jakarta</p>
                            <p class="text-sm text-gray-600">IPA</p>
                        </div>
                        <p class="text-sm text-gray-500 shrink-0 ml-4">2015 - 2018</p>
                    </div>
                </div>
            </div>

            <!-- Organization -->
            <div class="mb-6">
                <p class="section-title">Organization</p>
                <div class="space-y-3" id="cv-organization">
                    <div class="flex justify-between">
                        <div>
                            <p class="font-bold text-sm text-gray-900">Ketua Himpunan Mahasiswa Informatika</p>
                            <p class="text-sm text-gray-600">Universitas Indonesia</p>
                        </div>
                        <p class="text-sm text-gray-500 shrink-0 ml-4">2022</p>
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div>
                <p class="section-title">Certifications</p>
                <div class="flex flex-wrap gap-2" id="cv-certs">
                    <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full">Sertifikat Keahlian UI/UX</span>
                    <span class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full">Bootcamp Web Fullstack</span>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Template Selector -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Pilih Template CV</h2>
        <a href="#" class="text-sm font-semibold text-green-700 hover:text-green-600 transition-colors">Lihat Semua Template</a>
    </div>

    <div class="grid grid-cols-4 gap-5" id="template-grid">
        <!-- Template 1: Modern Professional (Active) -->
        <div class="template-card active rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer relative" data-template="modern">
            <div class="check-badge absolute top-2 right-2 w-6 h-6 bg-green-700 rounded-full flex items-center justify-center z-10" style="display:flex;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="h-44 bg-gray-50 p-4">
                <div class="w-full h-full bg-white rounded border border-gray-200 p-3">
                    <div class="h-2 w-20 bg-gray-300 rounded mb-2"></div>
                    <div class="h-1.5 w-14 bg-green-200 rounded mb-3"></div>
                    <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                    <div class="h-1 w-4/5 bg-gray-100 rounded mb-3"></div>
                    <div class="h-1.5 w-10 bg-green-100 rounded mb-1.5"></div>
                    <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                    <div class="h-1 w-3/4 bg-gray-100 rounded"></div>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-900 text-center py-3">Modern Professional</p>
        </div>

        <!-- Template 2: Minimalist Executive -->
        <div class="template-card rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer relative" data-template="minimalist">
            <div class="check-badge absolute top-2 right-2 w-6 h-6 bg-green-700 rounded-full items-center justify-center z-10 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="h-44 bg-gray-50 p-4">
                <div class="w-full h-full bg-white rounded border border-gray-200 p-3">
                    <div class="h-2 w-16 bg-gray-800 rounded mb-1"></div>
                    <div class="h-1 w-12 bg-gray-300 rounded mb-3"></div>
                    <div class="border-t border-gray-200 pt-2">
                        <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-5/6 bg-gray-100 rounded mb-2"></div>
                        <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-2/3 bg-gray-100 rounded"></div>
                    </div>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-900 text-center py-3">Minimalist Executive</p>
        </div>

        <!-- Template 3: Creative Portfolio -->
        <div class="template-card rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer relative" data-template="creative">
            <div class="check-badge absolute top-2 right-2 w-6 h-6 bg-green-700 rounded-full items-center justify-center z-10 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="h-44 bg-gray-50 p-4">
                <div class="w-full h-full bg-white rounded border border-gray-200 p-3 flex gap-2">
                    <div class="w-1/3 bg-green-800 rounded p-2">
                        <div class="h-1 w-full bg-green-600 rounded mb-1"></div>
                        <div class="h-1 w-3/4 bg-green-600 rounded mb-2"></div>
                        <div class="h-1 w-full bg-green-700 rounded mb-1"></div>
                        <div class="h-1 w-2/3 bg-green-700 rounded"></div>
                    </div>
                    <div class="flex-1">
                        <div class="h-2 w-14 bg-gray-300 rounded mb-2"></div>
                        <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-4/5 bg-gray-100 rounded mb-2"></div>
                        <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-3/5 bg-gray-100 rounded"></div>
                    </div>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-900 text-center py-3">Creative Portfolio</p>
        </div>

        <!-- Template 4: Swiss Academic -->
        <div class="template-card rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer relative" data-template="swiss">
            <div class="check-badge absolute top-2 right-2 w-6 h-6 bg-green-700 rounded-full items-center justify-center z-10 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="h-44 bg-gray-50 p-4">
                <div class="w-full h-full bg-white rounded border border-gray-200 p-3 flex gap-2">
                    <div class="w-8 bg-gray-100 rounded flex flex-col items-center pt-2">
                        <div class="w-5 h-5 bg-gray-300 rounded-full mb-2"></div>
                        <div class="h-1 w-5 bg-gray-200 rounded mb-1"></div>
                        <div class="h-1 w-4 bg-gray-200 rounded"></div>
                    </div>
                    <div class="flex-1">
                        <div class="h-2 w-16 bg-gray-300 rounded mb-1"></div>
                        <div class="h-1 w-12 bg-gray-200 rounded mb-3"></div>
                        <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-5/6 bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-full bg-gray-100 rounded mb-1"></div>
                        <div class="h-1 w-2/3 bg-gray-100 rounded"></div>
                    </div>
                </div>
            </div>
            <p class="text-sm font-medium text-gray-900 text-center py-3">Swiss Academic</p>
        </div>
    </div>
</div>

<!-- Download Button -->
<div class="flex justify-center">
    <button id="btn-download" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors text-sm flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download PDF
    </button>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== TEMPLATE SELECTOR =====
    document.querySelectorAll('.template-card').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('.template-card').forEach(c => {
                c.classList.remove('active');
                c.querySelector('.check-badge').style.display = 'none';
            });
            this.classList.add('active');
            this.querySelector('.check-badge').style.display = 'flex';

            // TODO: Switch CV preview template style
            const template = this.dataset.template;
            const cv = document.getElementById('cv-content');

            if (template === 'minimalist') {
                cv.style.fontFamily = "'Helvetica Neue', sans-serif";
                cv.querySelectorAll('.section-title').forEach(t => t.style.color = '#111');
            } else if (template === 'creative') {
                cv.style.fontFamily = "'Georgia', serif";
                cv.querySelectorAll('.section-title').forEach(t => t.style.color = '#15803d');
            } else {
                cv.style.fontFamily = "'Georgia', serif";
                cv.querySelectorAll('.section-title').forEach(t => t.style.color = '#15803d');
            }
        });
    });

    // ===== ZOOM =====
    let zoom = 1;
    const cv = document.getElementById('cv-content');
    document.getElementById('zoom-in').addEventListener('click', () => {
        zoom = Math.min(zoom + 0.1, 1.5);
        cv.style.transform = 'scale(' + zoom + ')';
        cv.style.transformOrigin = 'top center';
    });
    document.getElementById('zoom-out').addEventListener('click', () => {
        zoom = Math.max(zoom - 0.1, 0.6);
        cv.style.transform = 'scale(' + zoom + ')';
        cv.style.transformOrigin = 'top center';
    });

    // ===== DOWNLOAD =====
    document.getElementById('btn-download').addEventListener('click', function () {
        // TODO: Nanti kirim request ke Laravel route yang generate PDF pakai dompdf
        // window.location.href = '/api/pelamar/cv/download?template=' + activeTemplate;
        alert('Download PDF berhasil! (demo - nanti disambungkan ke dompdf)');
    });
});
</script>
@endsection