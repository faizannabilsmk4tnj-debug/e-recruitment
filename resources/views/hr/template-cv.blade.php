@extends('layouts.hr')
@section('title', 'Template CV')
@section('page-title', 'Template CV')
@section('nav-template', 'text-green-800 border-green-800')

@section('content')
<div class="px-6 py-8 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">CV Template Management</h2>
            <p class="text-gray-500 text-sm">Manage and customize profile summary formats for all candidates.</p>
        </div>
        <button id="btn-tambah" class="bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Template
        </button>
    </div>

    {{-- Pop-up Toast Notifications --}}
    @if(session('success'))
    <div id="toast-flash" class="fixed top-6 right-6 z-[300] bg-green-900 text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-2.5 text-xs font-semibold transform translate-x-12 opacity-0 transition-all duration-300">
        <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div id="toast-flash" class="fixed top-6 right-6 z-[300] bg-red-800 text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-2.5 text-xs font-semibold transform translate-x-12 opacity-0 transition-all duration-300">
        <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Search & Filter --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-8 flex flex-col sm:flex-row gap-3 items-center">
        <div class="relative flex-1 w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" id="search-template" placeholder="Search by template name..." value="{{ $search }}"
                class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <div class="flex rounded-lg border border-gray-200 overflow-hidden text-sm font-semibold">
                <a href="{{ route('hr.template-cv.index', ['status' => 'semua']) }}"
                   class="filter-btn px-4 py-2 transition-colors {{ $activeStatus === 'semua' ? 'bg-[#15803d] text-white' : 'text-gray-600 hover:bg-gray-50' }}">All</a>
                <a href="{{ route('hr.template-cv.index', ['status' => 'published']) }}"
                   class="filter-btn px-4 py-2 transition-colors {{ $activeStatus === 'published' ? 'bg-[#15803d] text-white' : 'text-gray-600 hover:bg-gray-50' }}">Published</a>
                <a href="{{ route('hr.template-cv.index', ['status' => 'draft']) }}"
                   class="filter-btn px-4 py-2 transition-colors {{ $activeStatus === 'draft' ? 'bg-[#15803d] text-white' : 'text-gray-600 hover:bg-gray-50' }}">Draft</a>
            </div>
        </div>
    </div>

    {{-- Template Grid (DYNAMIC from DB) --}}
    <div id="template-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        @forelse($templates as $template)
        @php
            $bgColors = ['bg-[#15803d]', 'bg-gray-800', 'bg-slate-600', 'bg-teal-700', 'bg-indigo-700'];
            $bg = $bgColors[$template->id % count($bgColors)];
        @endphp
        <div class="template-card" data-status="{{ $template->status }}" data-name="{{ strtolower($template->name) }}" data-id="{{ $template->id }}">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow h-full flex flex-col">

                {{-- Preview Area --}}
                <div class="relative {{ $bg }} h-48 overflow-hidden flex items-center justify-center flex-shrink-0">
                    {{-- Badge --}}
                    @if($template->is_default)
                        <span class="status-badge absolute top-3 left-3 bg-[#15803d] border border-green-400 text-green-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">★ Primary</span>
                    @elseif($template->status === 'published')
                        <span class="status-badge absolute top-3 left-3 bg-white/20 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">Published</span>
                    @else
                        <span class="status-badge absolute top-3 left-3 bg-orange-500/80 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">Draft</span>
                    @endif

                    {{-- CV Mockup --}}
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

                    {{-- Preview Hover Button --}}
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a href="{{ route('hr.template-cv.preview', $template) }}" target="_blank"
                           class="bg-white text-[#15803d] text-xs font-bold px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                            Preview Template
                        </a>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-900 mb-1">{{ $template->name }}</h3>
                    @if($template->description)
                        <p class="text-xs text-gray-400 mb-2 line-clamp-2">{{ $template->description }}</p>
                    @endif
                    <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $template->updated_at ? $template->updated_at->diffForHumans() : 'Just created' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $template->usage_count }} users
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-2 mt-auto">
                        <div class="flex gap-2">
                            {{-- Edit Layout: always visible --}}
                            <a href="{{ route('hr.template-cv.editor', $template) }}"
                               class="flex-1 text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors text-center">
                                Edit Layout
                            </a>

                            {{-- Secondary action based on status --}}
                            @if($template->is_default)
                                {{-- Primary template: show Primary --}}
                                <button type="button" disabled
                                    class="flex-1 text-xs font-bold border border-gray-200 text-gray-400 rounded-lg py-2 cursor-not-allowed bg-gray-50 text-center">
                                    Primary ✓
                                </button>
                            @elseif($template->status === 'draft')
                                {{-- Draft: show Publish button --}}
                                <form method="POST" action="{{ route('hr.template-cv.publish', $template) }}" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="w-full text-xs font-bold bg-[#15803d] text-white rounded-lg py-2 hover:bg-[#166534] transition-colors">
                                        Publish
                                    </button>
                                </form>
                            @else
                                {{-- Published (non-default): show Set Default --}}
                                <form method="POST" action="{{ route('hr.template-cv.setDefault', $template) }}" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="w-full text-xs font-bold bg-[#15803d] text-white rounded-lg py-2 hover:bg-[#166534] transition-colors">
                                        Set Default
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- If published and not default, show Make Private --}}
                        @if($template->status === 'published' && !$template->is_default)
                            <form method="POST" action="{{ route('hr.template-cv.setDraft', $template) }}" class="w-full">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    class="w-full text-xs font-bold border border-amber-200 bg-amber-50/50 text-amber-700 rounded-lg py-1.5 hover:bg-amber-100 hover:border-amber-300 transition-colors">
                                    Make Private (Draft)
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Delete button (separate, always shown for non-default) --}}
                    @if(!$template->is_default)
                    <form method="POST" action="{{ route('hr.template-cv.destroy', $template) }}" class="mt-2"
                          onsubmit="return confirm('Are you sure you want to delete template \'{{ addslashes($template->name) }}\'?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full text-xs text-red-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 rounded-lg py-1.5 transition-colors">
                            Delete Template
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="font-semibold">No templates found</p>
            <p class="text-xs mt-1">Try changing the filter or add a new template.</p>
        </div>
        @endforelse

        {{-- Card: Create From Scratch --}}
        <div id="card-create" class="template-card" data-status="create" data-name="">
            <button id="btn-create-scratch" class="w-full h-full min-h-[320px] bg-white rounded-xl border-2 border-dashed border-gray-200 hover:border-[#15803d] hover:bg-green-50/30 transition-all group flex flex-col items-center justify-center gap-3 p-6">
                <div class="w-14 h-14 rounded-full bg-gray-100 group-hover:bg-green-100 flex items-center justify-center transition-colors">
                    <svg class="w-7 h-7 text-gray-400 group-hover:text-[#15803d] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="text-center">
                    <div class="font-bold text-gray-700 group-hover:text-[#15803d] transition-colors">Create From Scratch</div>
                    <div class="text-xs text-gray-400 mt-1">Start building a new template using our<br>drag-and-drop editor.</div>
                </div>
            </button>
        </div>

    </div>

    {{-- Footer Info --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-sm text-gray-500">
            Showing {{ $templates->count() }} of {{ $totalTemplates }} templates
            @if($activeStatus !== 'semua') (filtered: {{ $activeStatus }}) @endif
        </p>
    </div>

</div>

{{-- Modal: Tambah Template --}}
<div id="modal-tambah" class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display:none!important;">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="modal-tambah-backdrop"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md z-10 overflow-hidden">
        <div class="bg-[#15803d] p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase tracking-widest text-green-300 mb-1">CV Template Management</div>
                    <h2 class="text-xl font-black text-white">Add New Template</h2>
                </div>
                <button type="button" id="modal-tambah-close" class="text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <form action="{{ route('hr.template-cv.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Template Name <span class="text-red-500">*</span></label>
                <input id="input-nama-template" name="name" type="text" placeholder="Example: Modern Executive 2025"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400" required>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Description</label>
                <textarea name="description" rows="3" placeholder="Brief description of this template..."
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 resize-none"></textarea>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Initial Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" id="modal-tambah-cancel" class="flex-1 border border-gray-200 text-gray-700 font-semibold text-sm py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit" class="flex-1 bg-[#15803d] text-white font-semibold text-sm py-2.5 rounded-lg hover:bg-[#166534] transition-colors">Create Template →</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ---- Client-side Search ----
    document.getElementById('search-template').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.template-card:not(#card-create)').forEach(card => {
            card.style.display = card.dataset.name.includes(q) ? '' : 'none';
        });
    });

    // ---- Modal: Tambah Template ----
    const modal = document.getElementById('modal-tambah');
    function openModal() { modal.style.setProperty('display', 'flex', 'important'); document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.style.setProperty('display', 'none', 'important'); document.body.style.overflow = ''; }

    document.getElementById('btn-tambah').addEventListener('click', openModal);
    document.getElementById('btn-create-scratch').addEventListener('click', openModal);
    document.getElementById('modal-tambah-close').addEventListener('click', closeModal);
    document.getElementById('modal-tambah-cancel').addEventListener('click', closeModal);
    document.getElementById('modal-tambah-backdrop').addEventListener('click', closeModal);

    // Close on Escape key
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // ---- Pop-up Toast Slide-in/out Animation ----
    const toastFlash = document.getElementById('toast-flash');
    if (toastFlash) {
        // Slide in
        setTimeout(() => {
            toastFlash.classList.remove('translate-x-12', 'opacity-0');
            toastFlash.classList.add('translate-x-0', 'opacity-100');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            toastFlash.classList.remove('translate-x-0', 'opacity-100');
            toastFlash.classList.add('translate-x-12', 'opacity-0');
            setTimeout(() => toastFlash.remove(), 300);
        }, 3500);
    }
});
</script>
@endsection
