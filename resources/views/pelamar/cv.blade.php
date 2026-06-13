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
        <p class="text-gray-500 mt-1 text-sm">Pilih template, lalu preview CV Anda dengan data profil terkini.</p>
    </div>
    <div class="flex gap-3">
        <button id="btn-print" onclick="printCv()"
            class="hidden items-center gap-2 px-4 py-2.5 bg-green-800 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect width="12" height="8" x="6" y="14"/>
            </svg>
            Download / Print PDF
        </button>
    </div>
</div>

{{-- Template Cards dari DB --}}
@if($templates->isEmpty())
<div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300 mb-10">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <p class="font-semibold text-gray-500">Belum ada template CV yang tersedia</p>
    <p class="text-sm text-gray-400 mt-1">Hubungi HR untuk mempublikasikan template.</p>
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
             style="background:{{ $tpl->is_default ? '#0f3c20' : '#f1f5f9' }}">
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
                     style="background:{{ $tpl->is_default ? '#1a5c35' : '#e2e8f0' }};color:{{ $tpl->is_default ? '#86efac' : '#64748b' }}">CV</div>
                <div class="space-y-1.5">
                    <div class="h-2 w-24 rounded mx-auto" style="background:{{ $tpl->is_default ? '#1a5c35' : '#cbd5e1' }}"></div>
                    <div class="h-1.5 w-16 rounded mx-auto" style="background:{{ $tpl->is_default ? '#166534' : '#e2e8f0' }}"></div>
                    <div class="h-1 w-28 rounded mx-auto mt-2" style="background:{{ $tpl->is_default ? '#14532d' : '#e2e8f0' }}"></div>
                    <div class="h-1 w-20 rounded mx-auto" style="background:{{ $tpl->is_default ? '#14532d' : '#e2e8f0' }}"></div>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="p-5">
            <p class="text-[10px] font-bold uppercase tracking-widest mb-1 {{ $tpl->is_default ? 'text-green-700' : 'text-slate-500' }}">
                {{ $tpl->is_default ? 'Template Utama' : 'Template HR' }}
            </p>
            <h3 class="font-bold text-gray-900 text-base">{{ $tpl->name }}</h3>
            @if($tpl->description)
            <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ Str::limit($tpl->description, 80) }}</p>
            @endif
            <button class="select-btn w-full mt-4 bg-gray-100 text-gray-700 font-semibold py-2.5 rounded-lg text-sm
                           transition-colors flex items-center justify-center gap-2">
                Pilih Template
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- CV Preview Section --}}
<div id="cv-preview-section" class="mb-10 {{ $templates->isNotEmpty() ? '' : 'hidden' }}">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-900">
            Preview CV —
            <span id="preview-template-name" class="text-green-800">{{ optional($templates->first())->name }}</span>
        </h2>
        <div class="flex items-center gap-4">
            <span id="preview-loading-badge" class="hidden text-xs text-gray-400 italic animate-pulse">⏳ Memuat data CV...</span>
            <button onclick="openCvModal()"
                    class="text-sm text-green-700 hover:text-green-900 font-semibold flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                </svg>
                Full Screen
            </button>
            <span class="text-gray-300">|</span>
            <button onclick="scrollToTemplates()"
                    class="text-sm text-green-700 hover:text-green-900 font-semibold flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/>
                </svg>
                Pilih Ulang Template
            </button>
            <span class="text-gray-300">|</span>
            <button onclick="document.getElementById('cv-preview-section').classList.add('hidden');
                            document.getElementById('btn-print').classList.add('hidden');
                            document.getElementById('btn-print').classList.remove('flex')"
                    class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
                Tutup Preview
            </button>
        </div>
    </div>

    <div class="max-w-[620px] mx-auto animate-preview">
        <iframe id="cv-preview-frame" title="Preview CV"></iframe>
    </div>

    <div class="max-w-3xl mx-auto mt-4 bg-amber-50 border border-amber-200 rounded-lg px-5 py-3 flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
        </svg>
        <p class="text-xs text-amber-700 leading-relaxed">
            <strong>Tips:</strong> Data yang tampil diambil dari halaman
            <a href="{{ route('pelamar.profil.edit') }}" class="underline">Profil</a>,
            <a href="{{ route('pelamar.pengalaman-kerja.index') }}" class="underline">Pengalaman Kerja</a>,
            <a href="{{ route('pelamar.pendidikan.index') }}" class="underline">Pendidikan</a>, dan
            <a href="{{ route('pelamar.lampiran') }}" class="underline">Keahlian</a>.
            Lengkapi semua halaman agar CV Anda terlihat lengkap dan profesional.
        </p>
    </div>
</div>

{{-- Kelengkapan Data CV --}}
<div id="kelengkapan-section" class="bg-white rounded-xl border border-gray-200 p-6 mb-24">
    <h2 class="text-base font-bold text-gray-900 mb-4">Kelengkapan Data CV</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        {{-- Profil --}}
        <a href="{{ route('pelamar.profil.edit') }}" class="group flex flex-col items-center p-4 rounded-xl border transition-all
            {{ $profile && $profile->bio ? 'border-green-200 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2
                {{ $profile && $profile->bio ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <p class="text-xs font-semibold {{ $profile && $profile->bio ? 'text-green-700' : 'text-gray-500' }}">Profil</p>
            <p class="text-[10px] {{ $profile && $profile->bio ? 'text-green-500' : 'text-gray-400' }} mt-0.5">
                {{ $profile && $profile->bio ? '✓ Lengkap' : 'Belum diisi' }}
            </p>
        </a>

        {{-- Pengalaman Kerja --}}
        <a href="{{ route('pelamar.pengalaman-kerja.index') }}" class="group flex flex-col items-center p-4 rounded-xl border transition-all
            {{ $works->count() ? 'border-green-200 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2
                {{ $works->count() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
            <p class="text-xs font-semibold {{ $works->count() ? 'text-green-700' : 'text-gray-500' }}">Pengalaman</p>
            <p class="text-[10px] {{ $works->count() ? 'text-green-500' : 'text-gray-400' }} mt-0.5">
                {{ $works->count() ? $works->count().' entri' : 'Belum diisi' }}
            </p>
        </a>

        {{-- Pendidikan --}}
        <a href="{{ route('pelamar.pendidikan.index') }}" class="group flex flex-col items-center p-4 rounded-xl border transition-all
            {{ $educations->count() ? 'border-green-200 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2
                {{ $educations->count() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <p class="text-xs font-semibold {{ $educations->count() ? 'text-green-700' : 'text-gray-500' }}">Pendidikan</p>
            <p class="text-[10px] {{ $educations->count() ? 'text-green-500' : 'text-gray-400' }} mt-0.5">
                {{ $educations->count() ? $educations->count().' entri' : 'Belum diisi' }}
            </p>
        </a>

        {{-- Keahlian --}}
        <a href="{{ route('pelamar.lampiran') }}" class="group flex flex-col items-center p-4 rounded-xl border transition-all
            {{ $skills->count() ? 'border-green-200 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
            <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2
                {{ $skills->count() ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48 2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48 2.83-2.83"/>
                </svg>
            </div>
            <p class="text-xs font-semibold {{ $skills->count() ? 'text-green-700' : 'text-gray-500' }}">Keahlian</p>
            <p class="text-[10px] {{ $skills->count() ? 'text-green-500' : 'text-gray-400' }} mt-0.5">
                {{ $skills->count() ? $skills->count().' keahlian' : 'Belum diisi' }}
            </p>
        </a>

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
                <button onclick="printCvFromModal()" class="flex items-center gap-1.5 px-4 py-2 bg-green-800 hover:bg-green-700 text-white rounded-lg text-xs font-semibold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 6 2 18 2 18 9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect width="12" height="8" x="6" y="14"/>
                    </svg>
                    Print / PDF
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
<script>
function selectTemplate(card) {
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

    // Smooth scroll down to the preview section header (accounting for the sticky navbar height of 52px + margins)
    setTimeout(function() {
        if (previewSec) {
            var rect = previewSec.getBoundingClientRect();
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var targetY = rect.top + scrollTop - 70; // 70px offset is perfect to clear the navbar
            window.scrollTo({ top: targetY, behavior: 'smooth' });
        }
    }, 100);

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
            frame.srcdoc = html;
            frame.style.opacity = '1';
            badge.classList.add('hidden');
            // Show print button
            var btn = document.getElementById('btn-print');
            btn.classList.remove('hidden');
            btn.classList.add('flex');
        })
        .catch(function(err) {
            badge.textContent = 'Gagal memuat CV. Coba refresh halaman.';
            console.error(err);
        });
}

function printCv() {
    var frame = document.getElementById('cv-preview-frame');
    if (!frame || !frame.contentWindow) {
        alert('Preview CV belum tersedia. Pilih template terlebih dahulu.');
        return;
    }
    frame.contentWindow.focus();
    frame.contentWindow.print();
}

function scrollToTemplates() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
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

// Auto-load template pertama saat halaman dibuka
window.addEventListener('DOMContentLoaded', function() {
    @if($templates->isNotEmpty())
    var firstCard = document.querySelector('.template-card');
    if (firstCard) { selectTemplate(firstCard); }
    @endif
});
</script>
@endsection