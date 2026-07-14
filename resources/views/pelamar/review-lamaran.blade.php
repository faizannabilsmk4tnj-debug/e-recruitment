@extends('layouts.pelamar')

@section('title', 'Review Application')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
    <a href="/pelamar/dashboard" class="hover:text-green-700 transition-colors">Home</a>
    <span>›</span>
    <a href="/pelamar/lowongan" class="hover:text-green-700 transition-colors">Vacancies</a>
    <span>›</span>
    <span class="text-gray-700 font-medium">Review: {{ $vacancy->title }}</span>
</div>

<!-- Header -->
<div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Review Application - {{ $vacancy->title }}</h1>
    <p class="text-sm text-gray-500 mt-1">Make sure all information is correct before clicking the Submit Application button.</p>
</div>

<!-- Main Content -->
<div class="flex flex-col lg:flex-row gap-6 items-start">

        <!-- LEFT: Dokumen & Cover Letter -->
        <div class="flex-1 space-y-6">

            <!-- Dokumen Terlampir -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <h2 class="font-bold text-gray-900">Attached Documents</h2>
                </div>

                <!-- CV Title Input -->
                <div class="mb-4">
                    <label for="resume-title" class="block text-sm font-semibold text-gray-700 mb-2">
                        CV Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="resume-title" placeholder="Example: CV - Web Developer - John"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <!-- Manual Upload Container -->
                <div id="manual-upload-container" class="space-y-4">
                    <!-- Upload area (shown when no file) -->
                    <div id="upload-area" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-green-400 transition-colors cursor-pointer" onclick="document.getElementById('file-input').click()">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">Click to upload document</p>
                        <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX • Max. 5 MB</p>
                        <input type="file" id="file-input" class="hidden" accept=".pdf,.doc,.docx">
                    </div>

                    <!-- File info (shown after upload) -->
                    <div id="file-info" class="hidden bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900" id="file-name"></p>
                                <p class="text-xs text-gray-400" id="file-meta"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="file-view" type="button" class="text-gray-400 hover:text-green-700 transition-colors" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <button id="file-remove" type="button" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surat Lamaran -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <h2 class="font-bold text-gray-900">Cover Letter</h2>
                </div>

                <textarea id="cover-letter" rows="8" placeholder="Write your cover letter here..." class="w-full bg-gray-50 rounded-lg p-5 text-sm text-gray-600 leading-relaxed border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
            </div>
        </div>

        <!-- RIGHT: Info Kontak & Submit -->
        <div class="w-80 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    </div>
                    <h2 class="font-bold text-gray-900">Application Summary</h2>
                </div>

                <div class="border-b border-gray-150 pb-4 mb-4">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Applying For</p>
                    <p class="text-sm font-bold text-gray-900 mt-1 leading-snug">{{ $vacancy->title }}</p>
                    <p class="text-xs text-green-700 font-semibold mt-0.5">PT Ecogreen Oleochemicals</p>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <button id="btn-kirim" class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        Submit Application
                    </button>
                </div>

                <p class="text-[11px] text-gray-400 text-center mt-4 leading-relaxed">By clicking "Submit Application", you agree to the Privacy Policy of PT Ecogreen Oleochemicals.</p>
            </div>
        </div>
</div>

<!-- CV Preview Modal -->
<div id="preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity" id="preview-modal-backdrop"></div>

    <!-- Modal panel -->
    <div class="relative bg-white rounded-2xl overflow-hidden shadow-2xl transform transition-all max-w-4xl w-full h-[80vh] flex flex-col z-10">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
            <div>
                <h3 class="text-base font-bold text-gray-900" id="preview-modal-title">CV Preview</h3>
                <p class="text-xs text-gray-500 mt-0.5" id="preview-modal-subtitle"></p>
            </div>
            <button id="close-preview-modal" type="button" class="text-gray-400 hover:text-gray-500 transition-colors p-1.5 hover:bg-gray-150 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Modal Body (Iframe) -->
        <div class="flex-1 bg-gray-100 p-4 relative overflow-hidden flex items-center justify-center">
            <iframe id="preview-iframe" class="w-full h-full rounded-lg border border-gray-250 hidden bg-white shadow-sm"></iframe>
            <!-- fallback text for non-PDF files -->
            <div id="preview-fallback" class="hidden text-center p-8">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h4 class="font-bold text-gray-800 text-base">Cannot Preview This File Format</h4>
                <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">This file format is not supported for inline preview. Please review using the download button below instead.</p>
                <a id="preview-download-fallback" href="#" download class="inline-flex items-center gap-2 mt-5 bg-green-800 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download File
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('file-input');
    const uploadArea = document.getElementById('upload-area');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileMeta = document.getElementById('file-meta');
    const fileView = document.getElementById('file-view');
    const fileRemove = document.getElementById('file-remove');
    const resumeTitleInput = document.getElementById('resume-title');
    let currentFileUrl = null;

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Validate size
        if (file.size > 5 * 1024 * 1024) {
            alert('File size exceeds 5 MB.');
            this.value = '';
            return;
        }

        const now = new Date();
        const dateStr = now.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
        const sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';

        fileName.textContent = file.name;
        fileMeta.textContent = 'Uploaded on ' + dateStr + ' • ' + sizeStr;

        uploadArea.classList.add('hidden');
        fileInfo.classList.remove('hidden');

        // Revoke old URL if exists and create new Object URL for preview
        if (currentFileUrl) {
            URL.revokeObjectURL(currentFileUrl);
        }
        currentFileUrl = URL.createObjectURL(file);

        // Automatically set file name as resume title if it's empty
        if (!resumeTitleInput.value.trim()) {
            const nameWithoutExt = file.name.substring(0, file.name.lastIndexOf('.')) || file.name;
            resumeTitleInput.value = nameWithoutExt;
        }
    });

    fileRemove.addEventListener('click', function () {
        fileInput.value = '';
        fileInfo.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        if (currentFileUrl) {
            URL.revokeObjectURL(currentFileUrl);
            currentFileUrl = null;
        }
    });

    const previewModal = document.getElementById('preview-modal');
    const closePreviewModal = document.getElementById('close-preview-modal');
    const previewModalBackdrop = document.getElementById('preview-modal-backdrop');
    const previewIframe = document.getElementById('preview-iframe');
    const previewFallback = document.getElementById('preview-fallback');
    const previewModalSubtitle = document.getElementById('preview-modal-subtitle');
    const previewDownloadFallback = document.getElementById('preview-download-fallback');

    function openModal() {
        if (!currentFileUrl) return;
        
        const file = fileInput.files[0];
        if (file) {
            previewModalSubtitle.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
            
            if (file.type === 'application/pdf') {
                previewIframe.src = currentFileUrl;
                previewIframe.classList.remove('hidden');
                previewFallback.classList.add('hidden');
            } else {
                previewDownloadFallback.href = currentFileUrl;
                previewDownloadFallback.download = file.name;
                previewIframe.src = '';
                previewIframe.classList.add('hidden');
                previewFallback.classList.remove('hidden');
            }
        }

        previewModal.classList.remove('hidden');
        previewModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        previewModal.classList.add('hidden');
        previewModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        previewIframe.src = '';
    }

    if (fileView) {
        fileView.addEventListener('click', function (e) {
            e.preventDefault();
            if (currentFileUrl) {
                openModal();
            } else {
                alert('No file available for preview.');
            }
        });
    }

    if (closePreviewModal) {
        closePreviewModal.addEventListener('click', closeModal);
    }
    if (previewModalBackdrop) {
        previewModalBackdrop.addEventListener('click', closeModal);
    }



    // Drag & drop
    uploadArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('border-green-500', 'bg-green-50');
    });
    uploadArea.addEventListener('dragleave', function () {
        this.classList.remove('border-green-500', 'bg-green-50');
    });
    uploadArea.addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('border-green-500', 'bg-green-50');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    // Kirim lamaran
    document.getElementById('btn-kirim').addEventListener('click', function () {
        const resumeTitle = resumeTitleInput.value.trim();
        const file = fileInput.files[0];

        if (!resumeTitle) {
            alert('Please enter a CV Title.');
            resumeTitleInput.focus();
            return;
        }

        if (!file) {
            alert('Please upload your CV document.');
            return;
        }

        const coverLetter = document.getElementById('cover-letter').value;
        const formData = new FormData();
        formData.append('resume_title', resumeTitle);
        formData.append('cover_letter', coverLetter);
        formData.append('file_cv', file);

        const btn = this;
        btn.disabled = true;
        const original = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        }).then(r => r.json()).then(d => {
            if (d.success) {
                window.location.href = d.redirect_url;
            } else {
                alert(d.message || 'Error');
                btn.disabled = false;
                btn.innerHTML = original;
            }
        }).catch(e => {
            console.error(e);
            alert('Error');
            btn.disabled = false;
            btn.innerHTML = original;
        });
    });
});
</script>
@endsection