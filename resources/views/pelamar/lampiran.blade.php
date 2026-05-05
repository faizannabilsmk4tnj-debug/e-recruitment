@extends('layouts.pelamar')

@section('title', 'Attachments & Documents')
@section('nav-lampiran', 'active')

@section('content')

<!-- Header -->
<div class="bg-white rounded-xl border border-gray-200 p-8 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Attachments & Documents</h1>
    <p class="text-gray-500 mt-1">Upload and manage your certificates or portfolio files here.</p>
</div>

<!-- Tabs -->
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex border-b border-gray-200 px-6">
        <button class="tab-btn px-5 py-3.5 text-sm font-semibold border-b-2 text-green-700 border-green-700" data-tab="sertifikat">Certificates</button>
        <button class="tab-btn px-5 py-3.5 text-sm font-semibold border-b-2 text-gray-400 border-transparent hover:text-gray-600" data-tab="portofolio">Portfolio</button>
    </div>

    <!-- ===== TAB: SERTIFIKAT ===== -->
    <div class="tab-content p-6" id="tab-sertifikat">
        <div class="grid grid-cols-3 gap-5" id="sertifikat-grid">

            <!-- Card 1 -->
            <div class="rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all" data-id="s1">
                <div class="h-40 bg-gradient-to-br from-amber-50 to-orange-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-sm text-gray-900 truncate">Sertifikat Keahlian UI/UX</p>
                    <p class="text-xs text-gray-400 mt-0.5">PDF • 2.4 MB • 12 Okt 2023</p>
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors" title="Lihat">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            View
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors" title="Download">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Download
                        </button>
                        <button class="btn-hapus-file flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors" data-id="s1" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                Delete
            </button>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all" data-id="s2">
                <div class="h-40 bg-gradient-to-br from-teal-50 to-cyan-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-teal-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
                <div class="p-4">
                    <p class="font-semibold text-sm text-gray-900 truncate">Bootcamp Web Fullstack</p>
                    <p class="text-xs text-gray-400 mt-0.5">JPG • 1.1 MB • 20 Nov 2023</p>
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            View
                        </button>
                        <button class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Download
                        </button>
                        <button class="btn-hapus-file flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors" data-id="s2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                Delete
            </button>
                    </div>
                </div>
            </div>

            <!-- Tambah Baru -->
            <label class="cursor-pointer">
                <div class="h-40 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center hover:border-green-400 hover:bg-green-50/30 transition-all">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Add New</p>
                </div>
                <input type="file" id="upload-sertifikat" accept="image/jpeg,image/png,application/pdf" class="hidden" multiple>
            </label>
        </div>
    </div>

    <!-- ===== TAB: PORTOFOLIO ===== -->
    <div class="tab-content p-6 hidden" id="tab-portofolio">
        <div class="grid grid-cols-3 gap-5" id="portofolio-grid">

            <!-- Porto Link -->
            <div class="rounded-xl border border-gray-200 p-5 hover:shadow-md transition-all" data-id="p1">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">Link</span>
                    <button class="btn-hapus-file text-gray-300 hover:text-red-500 transition-colors" data-id="p1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
                <h3 class="font-semibold text-sm text-gray-900">E-Commerce Platform</h3>
                <p class="text-xs text-gray-500 mt-1">Full-stack web app with Laravel + React</p>
                <a href="#" class="flex items-center gap-1.5 text-xs text-green-700 font-medium mt-3 hover:text-green-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                    github.com/user/project
                </a>
            </div>

            <!-- Porto File -->
            <div class="rounded-xl border border-gray-200 p-5 hover:shadow-md transition-all" data-id="p2">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2.5 py-0.5 rounded-full">File</span>
                    <button class="btn-hapus-file text-gray-300 hover:text-red-500 transition-colors" data-id="p2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
                <h3 class="font-semibold text-sm text-gray-900">Mobile App UI Design</h3>
                <p class="text-xs text-gray-500 mt-1">Redesign mobile banking UX</p>
                <p class="text-xs text-gray-400 mt-3">PDF • 5.2 MB</p>
            </div>

            <!-- Tambah Porto -->
            <button type="button" id="btn-tambah-porto" class="border-2 border-dashed border-gray-300 rounded-xl p-5 flex flex-col items-center justify-center hover:border-green-400 hover:bg-green-50/30 transition-all min-h-[140px]">
                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                </div>
                <p class="text-sm text-gray-500 font-medium">Add New</p>
            </button>
        </div>
    </div>
</div>

<!-- Modal Porto -->
<div id="modal-porto" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 p-8 relative">
        <button class="modal-close-porto absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <h2 class="text-lg font-bold text-gray-900 mb-6">Add Portfolio</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" id="porto-judul" placeholder="Project or work name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                <input type="text" id="porto-desc" placeholder="Brief explanation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-green-500 has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                        <input type="radio" name="porto-type" value="link" checked class="accent-green-700">
                        <div><p class="text-sm font-medium">Link URL</p><p class="text-xs text-gray-400">GitHub, Behance, dll</p></div>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-green-500 has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                        <input type="radio" name="porto-type" value="file" class="accent-green-700">
                        <div><p class="text-sm font-medium">Upload File</p><p class="text-xs text-gray-400">PDF, JPG, PNG</p></div>
                    </label>
                </div>
            </div>
            <div id="porto-link-field">
                <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                <input type="url" id="porto-url" placeholder="https://github.com/user/project" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div id="porto-file-field" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                <input type="file" id="porto-file" accept="image/jpeg,image/png,application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>
        </div>
        <div class="flex gap-3 mt-8">
            <button type="button" id="btn-porto-simpan" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm">Save</button>
            <button type="button" id="btn-porto-batal" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50">Cancel</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('text-green-700', 'border-green-700'); b.classList.add('text-gray-400', 'border-transparent'); });
            this.classList.remove('text-gray-400', 'border-transparent'); this.classList.add('text-green-700', 'border-green-700');
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
        });
    });

    // Upload sertifikat
    document.getElementById('upload-sertifikat').addEventListener('change', function (e) {
        Array.from(e.target.files).forEach(file => {
            if (file.size > 5 * 1024 * 1024) { alert(file.name + ' exceeds 5MB.'); return; }
            const ext = file.name.split('.').pop().toUpperCase();
            const size = (file.size / (1024 * 1024)).toFixed(1);
            const date = new Date().toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
            const id = 's' + Date.now();
            const card = document.createElement('div');
            card.className = 'rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-all';
            card.dataset.id = id;
            card.innerHTML = `<div class="h-40 bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg></div><div class="p-4"><p class="font-semibold text-sm text-gray-900 truncate">${file.name.replace(/\.[^/.]+$/, '')}</p><p class="text-xs text-gray-400 mt-0.5">${ext} • ${size} MB • ${date}</p><div class="flex items-center gap-2 mt-3 pt-3 border-t border-gray-100"><button class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50">View</button><button class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-gray-50">Download</button><button class="btn-hapus-file flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs text-gray-500 hover:bg-red-50 hover:text-red-600" data-id="${id}">Delete</button></div></div>`;
            document.querySelector('#sertifikat-grid label').parentNode.insertBefore(card, document.querySelector('#sertifikat-grid label'));
        });
        this.value = '';
    });

    // Hapus file
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-hapus-file');
        if (btn && confirm('Delete this file?')) {
            const card = btn.closest('[data-id]');
            card.style.transition = 'opacity 0.3s'; card.style.opacity = '0';
            setTimeout(() => card.remove(), 300);
        }
    });

    // Modal porto
    const modal = document.getElementById('modal-porto');
    document.getElementById('btn-tambah-porto').addEventListener('click', () => modal.classList.remove('hidden'));
    document.getElementById('btn-porto-batal').addEventListener('click', () => modal.classList.add('hidden'));
    document.querySelector('.modal-close-porto').addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });

    document.querySelectorAll('input[name="porto-type"]').forEach(r => {
        r.addEventListener('change', function () {
            document.getElementById('porto-link-field').classList.toggle('hidden', this.value !== 'link');
            document.getElementById('porto-file-field').classList.toggle('hidden', this.value !== 'file');
        });
    });

    document.getElementById('btn-porto-simpan').addEventListener('click', function () {
        const judul = document.getElementById('porto-judul').value.trim();
        if (!judul) { alert('Title is required.'); return; }
        const desc = document.getElementById('porto-desc').value.trim();
        const type = document.querySelector('input[name="porto-type"]:checked').value;
        const url = document.getElementById('porto-url').value.trim();
        const id = 'p' + Date.now();
        const badge = type === 'link' ? '<span class="text-xs font-medium text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">Link</span>' : '<span class="text-xs font-medium text-purple-600 bg-purple-50 px-2.5 py-0.5 rounded-full">File</span>';
        const bottom = type === 'link' ? `<a href="${url}" target="_blank" class="flex items-center gap-1.5 text-xs text-green-700 font-medium mt-3 hover:text-green-600">${url}</a>` : '<p class="text-xs text-gray-400 mt-3">File uploaded</p>';
        const html = `<div class="rounded-xl border border-gray-200 p-5 hover:shadow-md transition-all" data-id="${id}"><div class="flex items-center justify-between mb-3">${badge}<button class="btn-hapus-file text-gray-300 hover:text-red-500" data-id="${id}"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button></div><h3 class="font-semibold text-sm text-gray-900">${judul}</h3><p class="text-xs text-gray-500 mt-1">${desc || '-'}</p>${bottom}</div>`;
        document.getElementById('btn-tambah-porto').insertAdjacentHTML('beforebegin', html);
        modal.classList.add('hidden');
        document.getElementById('porto-judul').value = ''; document.getElementById('porto-desc').value = ''; document.getElementById('porto-url').value = '';
    });
});
</script>
@endsection