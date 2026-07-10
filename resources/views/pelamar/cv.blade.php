@extends('layouts.pelamar')

@section('title', 'My CV')
@section('nav-cv', 'active')

@section('css')
<style>
    .template-card { transition: all 0.3s; cursor: pointer; }
    .template-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.10); }
    .template-card.selected { border-color: #15803d; box-shadow: 0 0 0 3px rgba(21,128,61,0.2); }
    .template-card.selected .select-btn { background: #15803d !important; color: white !important; }
    .cv-thumb { height: 200px; display: flex; align-items: center; justify-content: center; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .animate-preview { animation: fadeIn 0.4s ease-out; }
    #cv-preview-frame {
        border: none;
        width: 100%;
        height: 500px;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0,0,0,.08);
        background: #fff;
        transition: opacity .3s;
    }
</style>
@endsection

@section('content')

{{-- Header --}}
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">My CV</h1>
        <p class="text-gray-500 mt-1 text-sm">Select a template, then preview your CV with your latest profile data.</p>
    </div>
</div>

{{-- Template Cards dari DB --}}
@if($templates->isEmpty())
<div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300 mb-10">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <p class="font-semibold text-gray-500">No CV templates available</p>
    <p class="text-sm text-gray-400 mt-1">Please contact HR to publish a template.</p>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10" id="template-grid">
    @foreach($templates as $tpl)
    <div class="template-card bg-white rounded-xl border border-gray-200 overflow-hidden{{ $loop->first ? ' selected' : '' }}"
         data-template-id="{{ $tpl->id }}"
         data-generate-url="{{ route('pelamar.cv.generate', $tpl) }}"
         onclick="selectTemplate(this)">

        {{-- Thumbnail --}}
        <div class="cv-thumb relative overflow-hidden flex items-center justify-center p-6"
             style="background:{{ $tpl->is_default ? '#15803d' : '#f1f5f9' }}">
            @if($tpl->is_default)
            <span class="absolute top-3 left-3 bg-green-600 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Default
            </span>
            @endif
            <div class="text-center">
                <div class="w-14 h-14 rounded-lg mx-auto mb-3 flex items-center justify-center text-xs font-mono font-bold"
                     style="background:{{ $tpl->is_default ? '#166534' : '#e2e8f0' }};color:{{ $tpl->is_default ? '#86efac' : '#64748b' }}">CV</div>
                <div class="space-y-1.5">
                    <div class="h-2 w-24 rounded mx-auto" style="background:{{ $tpl->is_default ? '#166534' : '#cbd5e1' }}"></div>
                    <div class="h-1.5 w-16 rounded mx-auto" style="background:{{ $tpl->is_default ? '#14532d' : '#e2e8f0' }}"></div>
                    <div class="h-1 w-28 rounded mx-auto mt-2" style="background:{{ $tpl->is_default ? '#14532d' : '#e2e8f0' }}"></div>
                    <div class="h-1 w-20 rounded mx-auto" style="background:{{ $tpl->is_default ? '#14532d' : '#e2e8f0' }}"></div>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-5">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1 {{ $tpl->is_default ? 'text-green-700' : 'text-slate-500' }}">
                {{ $tpl->is_default ? 'Primary Template' : 'HR Template' }}
            </p>
            <h3 class="font-bold text-gray-900 text-base">{{ $tpl->name }}</h3>
            @if($tpl->description)
            <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ Str::limit($tpl->description, 80) }}</p>
            @endif
            <button class="select-btn w-full mt-4 bg-gray-100 text-gray-700 font-semibold py-2.5 rounded-lg text-sm
                           transition-colors flex items-center justify-center gap-2">
                Select Template
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- CV Workspace Section (Preview & Kelengkapan side-by-side) --}}
<div id="cv-preview-section" class="mb-10 scroll-mt-8 {{ $templates->isNotEmpty() ? '' : 'hidden' }}">
    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4 pt-2">
        <h2 class="text-xl font-bold text-gray-900">
            CV Workspace —
            <span id="preview-template-name" class="text-green-800">{{ optional($templates->first())->name }}</span>
        </h2>
        <div class="flex items-center gap-3">
            <span id="preview-loading-badge" class="hidden text-xs text-gray-400 italic animate-pulse">⏳ Loading CV data...</span>
            
            <button onclick="scrollToTemplates()"
                    class="text-xs bg-gray-100 text-gray-700 hover:bg-gray-200 px-3.5 py-2 rounded-lg font-semibold flex items-center gap-1.5 transition-colors border border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                </svg>
                Reselect Template
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        {{-- Left: Live Preview (lg:col-span-7) --}}
        <div class="lg:col-span-7 flex flex-col items-center">
            <div class="w-full bg-slate-100 rounded-2xl p-4 border border-gray-200 shadow-sm">
                <!-- Toolbar Preview -->
                <div class="flex items-center justify-between mb-3 px-1">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">CV Live Preview</span>
                    <div class="flex items-center gap-2">
                        <!-- Full Screen -->
                        <button onclick="openCvModal()"
                                class="p-1.5 text-gray-500 hover:text-green-700 hover:bg-white rounded-lg transition-all"
                                title="Full Screen Preview">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                            </svg>
                        </button>
                        <!-- Print -->
                        <button id="btn-print" onclick="printCv()"
                                class="p-1.5 text-gray-500 hover:text-green-700 hover:bg-white rounded-lg transition-all hidden"
                                title="Print CV">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 6 2 18 2 18 9"/>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                                <rect width="12" height="8" x="6" y="14"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="animate-preview w-full">
                    <iframe id="cv-preview-frame" title="Preview CV" class="w-full"></iframe>
                </div>
            </div>
        </div>

        {{-- Right: Kelengkapan Data & Actions (lg:col-span-5) --}}
        <div class="lg:col-span-5 space-y-6">
            {{-- Action Cards (Download) --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-3 text-slate-500">Download Document</h3>
                <h2 class="text-base font-bold text-gray-900 mb-2">Save CV as PDF</h2>
                <p class="text-xs text-gray-500 mb-4">Export your CV into high-quality standard A4 PDF format.</p>
                
                <button id="btn-download" onclick="downloadCvPdf()"
                    class="w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-3 px-6 rounded-lg text-sm transition-colors shadow-sm flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" x2="12" y1="3" y2="15"/>
                    </svg>
                    Download PDF CV
                </button>
            </div>

            {{-- Kelengkapan Data CV --}}
            <div id="kelengkapan-section" class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-50">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">CV Data Completeness</h3>
                    <span class="text-[10px] font-semibold text-green-700 bg-green-50 px-2.5 py-0.5 rounded-full">Real-time Check</span>
                </div>
                
                <div class="space-y-3">
                    {{-- Profil --}}
                    <a href="{{ route('pelamar.profil.edit') }}" class="flex items-center justify-between p-3 rounded-lg border transition-all hover:bg-gray-50
                        {{ $profile ? 'border-green-100 bg-green-50/30' : 'border-gray-100 hover:border-green-200 hover:shadow-sm' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                {{ $profile ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-700">Profile</p>
                                <p class="text-[10px] text-gray-400">Personal data, bio & social media</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold {{ $profile ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $profile ? 'Complete ✓' : 'Incomplete' }}
                        </span>
                    </a>

                    {{-- Pengalaman Kerja --}}
                    <a href="{{ route('pelamar.pengalaman-kerja.index') }}" class="flex items-center justify-between p-3 rounded-lg border transition-all hover:bg-gray-50
                        {{ $works->count() ? 'border-green-100 bg-green-50/30' : 'border-gray-100 hover:border-green-200 hover:shadow-sm' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                {{ $works->count() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-700">Work Experience</p>
                                <p class="text-[10px] text-gray-400">Career & job description</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold {{ $works->count() ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $works->count() ? $works->count().' entries ✓' : 'Incomplete' }}
                        </span>
                    </a>

                    {{-- Pendidikan --}}
                    <a href="{{ route('pelamar.pendidikan.index') }}" class="flex items-center justify-between p-3 rounded-lg border transition-all hover:bg-gray-50
                        {{ $educations->count() ? 'border-green-100 bg-green-50/30' : 'border-gray-100 hover:border-green-200 hover:shadow-sm' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                {{ $educations->count() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-700">Education</p>
                                <p class="text-[10px] text-gray-400">School/University & GPA</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold {{ $educations->count() ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $educations->count() ? $educations->count().' entries ✓' : 'Incomplete' }}
                        </span>
                    </a>

                    {{-- Lampiran & Keahlian --}}
                    @php
                        $hasAttachment = $skills->count() > 0 || $portos->count() > 0;
                    @endphp
                    <a href="{{ route('pelamar.lampiran') }}" class="flex items-center justify-between p-3 rounded-lg border transition-all hover:bg-gray-50
                        {{ $hasAttachment ? 'border-green-100 bg-green-50/30' : 'border-gray-100 hover:border-green-200 hover:shadow-sm' }}">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                {{ $hasAttachment ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48 2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48 2.83-2.83"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-700">Attachments & Skills</p>
                                <p class="text-[10px] text-gray-400">Certificates & competencies</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold {{ $hasAttachment ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $hasAttachment ? 'Complete ✓' : 'Incomplete' }}
                        </span>
                    </a>
                </div>
            </div>

            {{-- Tips Profesional --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
                    </svg>
                    <div>
                        <h4 class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-1">Professional Tips</h4>
                        <p class="text-xs text-amber-700 leading-relaxed">
                            Choose a template with a balanced text-to-space ratio. A clean design helps recruiters read your main skills faster.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Full Screen Preview --}}
<div id="cv-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black bg-opacity-70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl h-[92vh] flex flex-col shadow-2xl overflow-hidden animate-preview">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">
                Full Screen Preview — <span id="modal-template-name" class="text-green-800"></span>
            </h3>
            <div class="flex items-center gap-3">
                <!-- Download Button -->
                <button onclick="downloadCvPdfFromModal()" class="flex items-center gap-1.5 px-3 py-1.5 bg-green-800 hover:bg-green-700 text-white rounded-lg text-xs font-semibold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Download PDF
                </button>
                <!-- Print Button -->
                <button onclick="printCvFromModal()" class="flex items-center gap-1.5 px-3 py-1.5 border border-green-800 text-green-800 hover:bg-green-50 rounded-lg text-xs font-semibold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect width="12" height="8" x="6" y="14"/>
                    </svg>
                    Print CV
                </button>
                <button onclick="closeCvModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="flex-1 p-6 overflow-y-auto bg-slate-100 flex justify-center items-start">
            <iframe id="cv-modal-frame" class="border-0 shadow-lg rounded-lg bg-white" style="width: 595px; height: 842px;"></iframe>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
// Global variable to store fetched CV HTML
window.currentCvHtml = '';

function selectTemplate(card, shouldScroll = true) {
    // Update selected state
    document.querySelectorAll('.template-card').forEach(function(c) {
        c.classList.remove('selected');
    });
    card.classList.add('selected');

    var name = card.querySelector('h3').textContent.trim();
    var url  = card.dataset.generateUrl;

    document.getElementById('preview-template-name').textContent = name;

    // Show preview section
    var previewSec = document.getElementById('cv-preview-section');
    previewSec.classList.remove('hidden');

    // Smooth scroll down to the preview section header
    if (shouldScroll) {
        setTimeout(function() {
            if (previewSec) {
                previewSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    }

    // Loading state
    var badge = document.getElementById('preview-loading-badge');
    badge.classList.remove('hidden');
    var frame = document.getElementById('cv-preview-frame');
    frame.style.opacity = '0.3';
    frame.srcdoc = '';

    // Fetch generated CV HTML
    fetch(url, { credentials: 'same-origin' })
        .then(function(r) { return r.text(); })
        .then(function(html) {
            window.currentCvHtml = html; // Save html for PDF downloading
            frame.srcdoc = html;
            frame.style.opacity = '1';
            badge.classList.add('hidden');
            
            // Show print button
            var btnPrint = document.getElementById('btn-print');
            if (btnPrint) {
                btnPrint.classList.remove('hidden');
                btnPrint.classList.add('flex');
            }
            // Show download button
            var btnDownload = document.getElementById('btn-download');
            if (btnDownload) {
                btnDownload.classList.remove('hidden');
                btnDownload.classList.add('flex');
            }
        })
        .catch(function(err) {
            badge.textContent = 'Failed to load CV. Try refreshing the page.';
            console.error(err);
        });
}

function printCv() {
    var frame = document.getElementById('cv-preview-frame');
    if (!frame || !frame.contentWindow) {
        alert('CV preview not available. Please choose a template first.');
        return;
    }
    frame.contentWindow.focus();
    frame.contentWindow.print();
}

function downloadCvPdf() {
    if (!window.currentCvHtml) {
        alert('CV preview not available. Please choose a template first.');
        return;
    }
    
    // Create temporary off-screen container in parent document to bypass iframe origin restrictions
    var tempDiv = document.createElement('div');
    tempDiv.style.position = 'absolute';
    tempDiv.style.left = '-9999px';
    tempDiv.style.top = '-9999px';
    tempDiv.style.width = '595px'; // Standard A4 width
    tempDiv.innerHTML = window.currentCvHtml;
    document.body.appendChild(tempDiv);

    var element = tempDiv.querySelector('.page');
    if (!element) {
        alert('Failed to download PDF. Template element (.page) not found.');
        document.body.removeChild(tempDiv);
        return;
    }

    var templateName = document.getElementById('preview-template-name').textContent.trim().replace(/\s+/g, '_');
    var fileName = 'CV_' + '{{ str_replace(" ", "_", $user->name) }}' + '_' + templateName + '.pdf';

    var opt = {
        margin:       0,
        filename:     fileName,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2.5, useCORS: true, letterRendering: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save().then(function() {
        document.body.removeChild(tempDiv);
    }).catch(function(err) {
        console.error(err);
        document.body.removeChild(tempDiv);
    });
}

function scrollToTemplates() {
    var main = document.querySelector('main');
    if (main) {
        main.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function openCvModal() {
    var sourceFrame = document.getElementById('cv-preview-frame');
    var modalFrame = document.getElementById('cv-modal-frame');
    var templateName = document.getElementById('preview-template-name').textContent;
    
    document.getElementById('modal-template-name').textContent = templateName;
    modalFrame.srcdoc = sourceFrame.srcdoc;
    document.getElementById('cv-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // prevent background scroll
}

function closeCvModal() {
    document.getElementById('cv-modal').classList.add('hidden');
    document.body.style.overflow = ''; // restore scrolling
}

function printCvFromModal() {
    var frame = document.getElementById('cv-modal-frame');
    if (!frame || !frame.contentWindow) return;
    frame.contentWindow.focus();
    frame.contentWindow.print();
}

function downloadCvPdfFromModal() {
    if (!window.currentCvHtml) return;
    
    // Create temporary off-screen container in parent document to bypass iframe origin restrictions
    var tempDiv = document.createElement('div');
    tempDiv.style.position = 'absolute';
    tempDiv.style.left = '-9999px';
    tempDiv.style.top = '-9999px';
    tempDiv.style.width = '595px'; // Standard A4 width
    tempDiv.innerHTML = window.currentCvHtml;
    document.body.appendChild(tempDiv);

    var element = tempDiv.querySelector('.page');
    if (!element) {
        alert('Failed to download PDF. Template element (.page) not found.');
        document.body.removeChild(tempDiv);
        return;
    }

    var templateName = document.getElementById('modal-template-name').textContent.trim().replace(/\s+/g, '_');
    var fileName = 'CV_' + '{{ str_replace(" ", "_", $user->name) }}' + '_' + templateName + '.pdf';

    var opt = {
        margin:       0,
        filename:     fileName,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2.5, useCORS: true, letterRendering: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save().then(function() {
        document.body.removeChild(tempDiv);
    }).catch(function(err) {
        console.error(err);
        document.body.removeChild(tempDiv);
    });
}

// Auto-load template pertama saat halaman dibuka
window.addEventListener('DOMContentLoaded', function() {
    @if($templates->isNotEmpty())
    var firstCard = document.querySelector('.template-card');
    if (firstCard) { selectTemplate(firstCard, false); }
    @endif
});
</script>
@endsection