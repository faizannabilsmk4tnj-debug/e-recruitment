@extends('layouts.hr')
@section('title', 'Template CV')
@section('page-title', 'Template CV')
@section('nav-template', 'text-green-800 border-green-800')

@section('content')
<div class="px-6 py-8 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">Manajemen Template CV</h2>
            <p class="text-gray-500 text-sm">Kelola dan kustomisasi format ringkasan profil untuk seluruh kandidat.</p>
        </div>
        <button id="btn-tambah" class="bg-[#0f3c20] hover:bg-[#1b5e32] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Template Baru
        </button>
    </div>

    {{-- Search & Filter --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-8 flex flex-col sm:flex-row gap-3 items-center">
        <div class="relative flex-1 w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="search-template" placeholder="Search berdasarkan nama template..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <div class="flex rounded-lg border border-gray-200 overflow-hidden text-sm font-semibold">
                <button data-filter="semua" class="filter-btn px-4 py-2 bg-[#0f3c20] text-white transition-colors">All</button>
                <button data-filter="published" class="filter-btn px-4 py-2 text-gray-600 hover:bg-gray-50 transition-colors">Published</button>
                <button data-filter="draft" class="filter-btn px-4 py-2 text-gray-600 hover:bg-gray-50 transition-colors">Draft</button>
            </div>
            <button class="flex items-center gap-1.5 text-sm font-semibold text-gray-600 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/></svg>
                Urutkan
            </button>
        </div>
    </div>

    {{-- Template Grid --}}
    <div id="template-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        {{-- Card 1: Modern Executive - PRIMARY --}}
        <div class="template-card" data-status="published" data-name="modern executive 2024" data-id="1">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
                <div class="relative bg-[#0f3c20] h-48 overflow-hidden flex items-center justify-center">
                    <span class="status-badge absolute top-3 left-3 bg-[#0f3c20] border border-green-400 text-green-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">★ Primary</span>
                    {{-- CV Preview Mockup --}}
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded w-28 p-2 text-white">
                        <div class="w-8 h-8 rounded-full bg-white/30 mx-auto mb-2"></div>
                        <div class="h-1.5 bg-white/50 rounded mb-1"></div>
                        <div class="h-1 bg-white/30 rounded mb-2 w-3/4 mx-auto"></div>
                        <div class="space-y-1">
                            <div class="h-1 bg-white/20 rounded"></div>
                            <div class="h-1 bg-white/20 rounded w-5/6"></div>
                            <div class="h-1 bg-white/20 rounded"></div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button class="bg-white text-[#0f3c20] text-xs font-bold px-4 py-2 rounded-lg">Preview Template</button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-1">Modern Executive 2024</h3>
                    <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Edited 2d ago</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>1,242 users</span>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn-edit flex-1 text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors">Edit Layout</button>
                        <button class="flex-1 text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors">Settings</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Academic Specialist - PUBLISHED --}}
        <div class="template-card" data-status="published" data-name="academic specialist" data-id="2">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
                <div class="relative bg-gray-800 h-48 overflow-hidden flex items-center justify-center">
                    <span class="status-badge absolute top-3 left-3 bg-white/20 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">Published</span>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded w-28 p-2 text-white">
                        <div class="w-10 h-10 rounded-full bg-gray-600 mx-auto mb-2 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        </div>
                        <div class="h-1.5 bg-white/50 rounded mb-1"></div>
                        <div class="h-1 bg-white/30 rounded mb-2 w-3/4 mx-auto"></div>
                        <div class="space-y-1">
                            <div class="h-1 bg-white/20 rounded"></div>
                            <div class="h-1 bg-white/20 rounded w-5/6"></div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button class="bg-white text-gray-800 text-xs font-bold px-4 py-2 rounded-lg">Preview Template</button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-1">Academic Specialist</h3>
                    <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Edited 1w ago</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>842 users</span>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex-1 text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors">Edit Layout</button>
                        <button class="flex-1 text-xs font-bold bg-[#0f3c20] text-white rounded-lg py-2 hover:bg-[#1b5e32] transition-colors">Set as Default</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Creative Industrial - DRAFT --}}
        <div class="template-card" data-status="draft" data-name="creative industrial" data-id="3">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
                <div class="relative bg-slate-600 h-48 overflow-hidden flex items-center justify-center">
                    <span class="status-badge absolute top-3 left-3 bg-orange-500/80 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">Draft</span>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded w-28 p-2 text-white">
                        <div class="w-10 h-10 rounded bg-white/20 mx-auto mb-2 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white/60" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12z"/></svg>
                        </div>
                        <div class="space-y-1">
                            <div class="h-2 bg-white/40 rounded"></div>
                            <div class="h-1 bg-white/20 rounded"></div>
                            <div class="h-1 bg-white/20 rounded w-5/6"></div>
                            <div class="h-1 bg-white/20 rounded"></div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button class="bg-white text-slate-700 text-xs font-bold px-4 py-2 rounded-lg">Preview Template</button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-1">Creative Industrial</h3>
                    <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Edited 4h ago</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>0 users</span>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn-edit flex-1 text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors">Edit Layout</button>
                        <button class="btn-publish flex-1 text-xs font-bold bg-[#0f3c20] text-white rounded-lg py-2 hover:bg-[#1b5e32] transition-colors">Publish</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Compact Professional - PUBLISHED --}}
        <div class="template-card" data-status="published" data-name="compact professional" data-id="4">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
                <div class="relative bg-gray-100 h-48 overflow-hidden flex items-center justify-center">
                    <span class="status-badge absolute top-3 left-3 bg-gray-700/80 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">Published</span>
                    <div class="bg-white border border-gray-200 rounded shadow-sm w-28 p-2">
                        <div class="h-2 bg-gray-800 rounded mb-2"></div>
                        <div class="h-1 bg-gray-300 rounded mb-1 w-3/4"></div>
                        <div class="h-px bg-gray-200 my-2"></div>
                        <div class="space-y-1">
                            <div class="h-1 bg-gray-200 rounded"></div>
                            <div class="h-1 bg-gray-200 rounded w-5/6"></div>
                            <div class="h-1 bg-gray-200 rounded"></div>
                            <div class="h-1 bg-gray-200 rounded w-4/6"></div>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button class="bg-white text-gray-800 text-xs font-bold px-4 py-2 rounded-lg shadow">Preview Template</button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-1">Compact Professional</h3>
                    <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Edited 1m ago</span>
                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>431 users</span>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex-1 text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors">Edit Layout</button>
                        <button class="flex-1 text-xs font-bold bg-[#0f3c20] text-white rounded-lg py-2 hover:bg-[#1b5e32] transition-colors">Set as Default</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 5: Create From Scratch --}}
        <div id="card-create" class="template-card" data-status="create" data-name="">
            <button id="btn-create-scratch" class="w-full h-full min-h-[320px] bg-white rounded-xl border-2 border-dashed border-gray-200 hover:border-[#0f3c20] hover:bg-green-50/30 transition-all group flex flex-col items-center justify-center gap-3 p-6">
                <div class="w-14 h-14 rounded-full bg-gray-100 group-hover:bg-green-100 flex items-center justify-center transition-colors">
                    <svg class="w-7 h-7 text-gray-400 group-hover:text-[#0f3c20] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="text-center">
                    <div class="font-bold text-gray-700 group-hover:text-[#0f3c20] transition-colors">Create From Scratch</div>
                    <div class="text-xs text-gray-400 mt-1">Start building a new template using our<br>drag-and-drop editor.</div>
                </div>
            </button>
        </div>

    </div>

    {{-- Footer Info + Pagination --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <p id="pagination-info" class="text-sm text-gray-500">Showing 4 of 12 templates</p>
        <div class="flex items-center gap-1">
            <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="w-8 h-8 rounded-lg bg-[#0f3c20] text-white text-sm font-bold">1</button>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">2</button>
            <button class="w-8 h-8 rounded-lg border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition-colors">3</button>
            <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- Modal: Tambah Template --}}
<div id="modal-tambah" class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display:none!important;">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="modal-tambah-backdrop"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 overflow-hidden">
        <div class="bg-[#0f3c20] p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase tracking-widest text-green-300 mb-1">Manajemen Template CV</div>
                    <h2 class="text-xl font-black text-white">Tambah Template Baru</h2>
                </div>
                <button id="modal-tambah-close" class="text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Nama Template</label>
                <input id="input-nama-template" type="text" placeholder="Contoh: Modern Executive 2025" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Description</label>
                <textarea rows="3" placeholder="Deskripsi singkat template ini..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 resize-none"></textarea>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Status Awal</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button id="modal-tambah-cancel" class="flex-1 border border-gray-200 text-gray-700 font-semibold text-sm py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                <button id="btn-buat-template" class="flex-1 bg-[#0f3c20] text-white font-semibold text-sm py-2.5 rounded-lg hover:bg-[#1b5e32] transition-colors">Buat Template →</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ---- Search ----
    document.getElementById('search-template').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.template-card:not(#card-create)').forEach(card => {
            card.style.display = card.dataset.name.includes(q) ? '' : 'none';
        });
    });

    // ---- Filter Tabs ----
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.style.background = ''; b.style.color = '#4b5563';
            });
            this.style.background = '#0f3c20'; this.style.color = '#fff';
            const f = this.dataset.filter;
            let shown = 0;
            document.querySelectorAll('.template-card:not(#card-create)').forEach(card => {
                const show = f === 'semua' || card.dataset.status === f;
                card.style.display = show ? '' : 'none';
                if (show) shown++;
            });
            document.getElementById('pagination-info').textContent = `Showing ${shown} of 12 templates`;
        });
    });

    // ---- Edit Layout: Navigate to Editor ----
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.closest('.template-card').dataset.id || 1;
            const name = encodeURIComponent(this.closest('.template-card').dataset.name);
            window.location.href = `/hr/template-cv/editor/${id}?name=${name}`;
        });
    });

    // ---- Publish: Draft → Published ----
    document.querySelectorAll('.btn-publish').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.template-card');
            card.dataset.status = 'published';
            // Update badge
            const badge = card.querySelector('.status-badge');
            badge.textContent = 'Published';
            badge.style.background = 'rgba(255,255,255,0.2)';
            badge.style.color = '#fff';
            // Change button to "Set as Default"
            this.textContent = 'Set as Default';
            this.classList.remove('btn-publish');
            this.classList.add('btn-default');
            this.removeEventListener('click', arguments.callee);
            initDefaultBtn(this);
            showToast('Template berhasil dipublikasikan!', 'success');
        });
    });

    // ---- Set as Default ----
    function initDefaultBtn(btn) {
        btn.addEventListener('click', function() {
            // Remove existing primary badges
            document.querySelectorAll('.status-badge-primary').forEach(el => {
                el.textContent = 'Published';
                el.classList.remove('status-badge-primary');
                el.style.background = 'rgba(255,255,255,0.2)';
                el.style.color = '#fff';
            });
            document.querySelectorAll('.btn-default').forEach(b => {
                if (b !== this) { b.textContent = 'Set as Default'; }
            });
            // Set this one as primary
            const badge = this.closest('.template-card').querySelector('.status-badge');
            badge.textContent = '★ Primary';
            badge.style.background = 'rgba(15,60,32,0.9)';
            badge.style.borderColor = '#4ade80';
            badge.style.color = '#86efac';
            badge.classList.add('status-badge-primary');
            this.textContent = 'Primary ✓';
            this.style.background = '#166534';
            showToast('Template dijadikan default untuk semua pelamar!', 'success');
        });
    }
    document.querySelectorAll('.btn-default').forEach(initDefaultBtn);

    // ---- Modal: Tambah / Create ----
    const modal = document.getElementById('modal-tambah');
    function openTambahModal() { modal.style.setProperty('display','flex','important'); document.body.style.overflow='hidden'; }
    function closeTambahModal() { modal.style.setProperty('display','none','important'); document.body.style.overflow=''; }
    document.getElementById('btn-tambah').addEventListener('click', openTambahModal);
    document.getElementById('btn-create-scratch').addEventListener('click', openTambahModal);
    document.getElementById('modal-tambah-close').addEventListener('click', closeTambahModal);
    document.getElementById('modal-tambah-cancel').addEventListener('click', closeTambahModal);
    document.getElementById('modal-tambah-backdrop').addEventListener('click', closeTambahModal);

    // ---- Modal Submit: Go to Editor ----
    document.getElementById('btn-buat-template').addEventListener('click', function() {
        const name = document.getElementById('input-nama-template').value.trim();
        if (!name) {
            document.getElementById('input-nama-template').classList.add('border-red-400','ring-2','ring-red-200');
            return;
        }
        window.location.href = `/hr/template-cv/editor?name=${encodeURIComponent(name)}&new=1`;
    });

    // ---- Toast ----
    function showToast(msg, type) {
        const t = document.createElement('div');
        t.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:999;background:${type==='success'?'#0f3c20':'#9b1c1c'};color:#fff;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:600;box-shadow:0 4px 20px rgba(0,0,0,.2);transition:opacity .3s;`;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 3000);
    }
});
</script>
@endsection
