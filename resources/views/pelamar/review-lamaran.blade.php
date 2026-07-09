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
                        CV Title / Judul CV <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="resume-title" placeholder="Contoh: CV - Web Developer - Ahmad"
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
                            <button class="text-gray-400 hover:text-green-700 transition-colors" title="Lihat">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <button id="file-remove" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
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
                <div class="flex items-center gap-2 mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <h2 class="font-bold text-gray-900">Contact Information</h2>
                </div>

                <div class="space-y-5">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Full Name</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Email</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $user->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91"/></svg>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Phone Number</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $profile->phone ?? $user->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Location</p>
                            <p class="text-sm font-semibold text-gray-900 mt-0.5">
                                @if(optional($profile)->city || optional($profile)->province)
                                    {{ $profile->city ?? '' }}{{ $profile->city && $profile->province ? ', ' : '' }}{{ $profile->province ?? '' }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 space-y-3">
                    <button id="btn-kirim" class="flex items-center justify-center gap-2 w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        Submit Application
                    </button>
                    <button onclick="history.back()" class="w-full border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                        Back to Edit
                    </button>
                </div>

                <p class="text-xs text-gray-400 text-center mt-4 leading-relaxed">By clicking "Submit Application", you agree to the Privacy Policy of PT Ecogreen Oleochemicals.</p>
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
    const fileRemove = document.getElementById('file-remove');
    const resumeTitleInput = document.getElementById('resume-title');

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
    });

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