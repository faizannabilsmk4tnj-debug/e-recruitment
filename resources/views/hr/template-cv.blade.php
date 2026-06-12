@extends('layouts.hr')
@section('title', 'Template CV')
@section('page-title', 'Template CV')
@section('nav-template', 'text-green-800 border-green-800')

@php
    $statusLabels = [
        'semua' => 'All',
        'published' => 'Published',
        'draft' => 'Draft',
    ];
@endphp

@section('content')
<div class="px-6 py-8 max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-1">CV Template Management</h2>
            <p class="text-gray-500 text-sm">Manage reusable CV layouts that applicants can use.</p>
        </div>
        <button type="button" id="btn-tambah" class="bg-[#0f3c20] hover:bg-[#1b5e32] text-white font-semibold py-2.5 px-5 rounded-lg flex items-center gap-2 text-sm transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Template
        </button>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ $errors->first() }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-100 rounded-lg p-4 shadow-sm">
            <div class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Templates</div>
            <div class="text-2xl font-black text-gray-900 mt-1">{{ $totalTemplates }}</div>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-4 shadow-sm">
            <div class="text-xs font-bold uppercase tracking-wider text-gray-400">Published</div>
            <div class="text-2xl font-black text-green-800 mt-1">{{ $publishedTemplates }}</div>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-4 shadow-sm">
            <div class="text-xs font-bold uppercase tracking-wider text-gray-400">Draft</div>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ $draftTemplates }}</div>
        </div>
    </div>

    <form method="GET" action="{{ route('hr.template-cv.index') }}" class="bg-white rounded-lg border border-gray-100 shadow-sm p-4 mb-8 flex flex-col sm:flex-row gap-3 items-center">
        <div class="relative flex-1 w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" value="{{ $search }}" placeholder="Search by template name..." class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm font-semibold text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
                @foreach ($statusLabels as $value => $label)
                    <option value="{{ $value }}" @selected($activeStatus === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="bg-[#0f3c20] text-white font-semibold text-sm rounded-lg px-4 py-2 hover:bg-[#1b5e32] transition-colors">Apply</button>
            @if ($search !== '' || $activeStatus !== 'semua')
                <a href="{{ route('hr.template-cv.index') }}" class="text-sm font-semibold text-gray-500 border border-gray-200 rounded-lg px-4 py-2 hover:bg-gray-50">Reset</a>
            @endif
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse ($templates as $template)
            @php
                $isPublished = $template->status === 'published';
                $badgeClass = $template->is_default
                    ? 'bg-[#0f3c20] border border-green-400 text-green-200'
                    : ($isPublished ? 'bg-white/20 text-white' : 'bg-amber-500/90 text-white');
                $panelClass = $template->is_default
                    ? 'bg-[#0f3c20]'
                    : ($isPublished ? 'bg-gray-800' : 'bg-slate-600');
            @endphp

            <div class="bg-white rounded-lg border border-gray-100 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">
                <div class="relative {{ $panelClass }} h-48 overflow-hidden flex items-center justify-center">
                    <span class="absolute top-3 left-3 {{ $badgeClass }} text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full">
                        {{ $template->is_default ? 'Primary' : ucfirst($template->status) }}
                    </span>
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
                    <button type="button" class="btn-preview absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-xs font-bold text-white" data-preview-id="preview-{{ $template->id }}">
                        Preview Template
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-1">{{ $template->name }}</h3>
                    <p class="text-xs text-gray-500 min-h-[2.5rem]">{{ $template->description ?: 'No description yet.' }}</p>
                    <div class="flex items-center gap-3 text-xs text-gray-400 mt-3 mb-4">
                        <span>{{ optional($template->updated_at ?? $template->created_at)->diffForHumans() }}</span>
                        <span>{{ $template->usage_count }} users</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('hr.template-cv.editor', $template) }}" class="text-center text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors">Edit Layout</a>

                        @if ($template->is_default)
                            <button type="button" class="text-xs font-bold bg-green-700 text-white rounded-lg py-2 cursor-default">Default</button>
                        @elseif ($isPublished)
                            <form method="POST" action="{{ route('hr.template-cv.default', $template) }}">
                                @csrf
                                @method('PATCH')
                                <button class="w-full text-xs font-bold bg-[#0f3c20] text-white rounded-lg py-2 hover:bg-[#1b5e32] transition-colors">Set Default</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('hr.template-cv.publish', $template) }}">
                                @csrf
                                @method('PATCH')
                                <button class="w-full text-xs font-bold bg-[#0f3c20] text-white rounded-lg py-2 hover:bg-[#1b5e32] transition-colors">Publish</button>
                            </form>
                        @endif
                    </div>
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        <button type="button" class="btn-settings text-xs font-bold border border-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-50 transition-colors"
                            data-name="{{ $template->name }}"
                            data-description="{{ $template->description }}"
                            data-status="{{ ucfirst($template->status) }}"
                            data-users="{{ $template->usage_count }}"
                            data-default="{{ $template->is_default ? 'Yes' : 'No' }}">
                            Settings
                        </button>
                        <form method="POST" action="{{ route('hr.template-cv.destroy', $template) }}" onsubmit="return confirm('Hapus template ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="w-full text-xs font-bold border border-red-200 text-red-600 rounded-lg py-2 hover:bg-red-50 transition-colors" @disabled($template->is_default || $template->usage_count > 0)>Delete</button>
                        </form>
                    </div>
                    <template id="preview-{{ $template->id }}">
                        {!! $template->content_html ?: '<div class="page"><div style="padding:28px;font-family:Segoe UI,sans-serif"><h1 style="font-size:24px;margin:0 0 8px">Nama Lengkap</h1><p style="color:#0f3c20;font-weight:700;margin:0 0 18px">Posisi / Jabatan</p><hr><h2 style="font-size:13px;text-transform:uppercase;margin-top:18px">Ringkasan Profil</h2><p style="font-size:12px;line-height:1.7;color:#374151">Template ini belum memiliki konten. Buka editor untuk mulai menyusun layout.</p></div></div>' !!}
                    </template>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-dashed border-gray-200 rounded-lg p-10 text-center">
                <div class="text-lg font-bold text-gray-800">Belum ada template yang cocok</div>
                <p class="text-sm text-gray-500 mt-1">Buat template baru atau ubah filter pencarian.</p>
            </div>
        @endforelse

        <button type="button" id="btn-create-scratch" class="min-h-[320px] bg-white rounded-lg border-2 border-dashed border-gray-200 hover:border-[#0f3c20] hover:bg-green-50/30 transition-all group flex flex-col items-center justify-center gap-3 p-6">
            <div class="w-14 h-14 rounded-full bg-gray-100 group-hover:bg-green-100 flex items-center justify-center transition-colors">
                <svg class="w-7 h-7 text-gray-400 group-hover:text-[#0f3c20] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div class="text-center">
                <div class="font-bold text-gray-700 group-hover:text-[#0f3c20] transition-colors">Create From Scratch</div>
                <div class="text-xs text-gray-400 mt-1">Start building a new template in the editor.</div>
            </div>
        </button>
    </div>

    <p class="text-sm text-gray-500">Showing {{ $templates->count() }} of {{ $totalTemplates }} templates</p>
</div>

<div id="modal-tambah" class="fixed inset-0 z-[200] flex items-center justify-center p-4" style="display:none!important;">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-close-modal></div>
    <form method="POST" action="{{ route('hr.template-cv.store') }}" class="relative bg-white rounded-lg shadow-2xl w-full max-w-md z-10 overflow-hidden">
        @csrf
        <div class="bg-[#0f3c20] p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase tracking-widest text-green-300 mb-1">CV Template Management</div>
                    <h2 class="text-xl font-black text-white">Add New Template</h2>
                </div>
                <button type="button" data-close-modal class="text-white/70 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Template Name</label>
                <input name="name" type="text" required maxlength="100" placeholder="Example: Modern Executive 2026" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Description</label>
                <textarea name="description" rows="3" maxlength="1000" placeholder="Brief description of this template..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400 resize-none"></textarea>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1.5">Initial Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-400">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" data-close-modal class="flex-1 border border-gray-200 text-gray-700 font-semibold text-sm py-2.5 rounded-lg hover:bg-gray-50 transition-colors">Cancel</button>
                <button class="flex-1 bg-[#0f3c20] text-white font-semibold text-sm py-2.5 rounded-lg hover:bg-[#1b5e32] transition-colors">Create Template</button>
            </div>
        </div>
    </form>
</div>

<div id="modal-preview" class="fixed inset-0 z-[210] flex items-center justify-center p-4" style="display:none!important;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" data-close-preview></div>
    <div class="relative bg-slate-200 rounded-lg shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-auto p-6">
        <button type="button" data-close-preview class="absolute top-3 right-3 bg-white border border-gray-200 rounded-lg px-3 py-1 text-sm font-bold text-gray-600">Close</button>
        <div id="preview-body" class="mx-auto bg-white shadow-lg" style="width:595px;min-height:842px;"></div>
    </div>
</div>

<div id="modal-settings" class="fixed inset-0 z-[220] flex items-center justify-center p-4" style="display:none!important;">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-close-settings></div>
    <div class="relative bg-white rounded-lg shadow-2xl w-full max-w-md z-10 overflow-hidden">
        <div class="bg-[#0f3c20] p-5 flex items-center justify-between">
            <h2 class="text-lg font-black text-white">Template Settings</h2>
            <button type="button" data-close-settings class="text-white/70 hover:text-white">Close</button>
        </div>
        <div class="p-5 space-y-3 text-sm">
            <div><span class="font-bold text-gray-500">Name:</span> <span id="settings-name" class="text-gray-900"></span></div>
            <div><span class="font-bold text-gray-500">Status:</span> <span id="settings-status" class="text-gray-900"></span></div>
            <div><span class="font-bold text-gray-500">Default:</span> <span id="settings-default" class="text-gray-900"></span></div>
            <div><span class="font-bold text-gray-500">Used by:</span> <span id="settings-users" class="text-gray-900"></span> users</div>
            <div><span class="font-bold text-gray-500">Description:</span> <p id="settings-description" class="text-gray-700 mt-1"></p></div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-tambah');
    const preview = document.getElementById('modal-preview');
    const settings = document.getElementById('modal-settings');

    function show(el) { el.style.setProperty('display', 'flex', 'important'); document.body.style.overflow = 'hidden'; }
    function hide(el) { el.style.setProperty('display', 'none', 'important'); document.body.style.overflow = ''; }

    document.getElementById('btn-tambah').addEventListener('click', () => show(modal));
    document.getElementById('btn-create-scratch').addEventListener('click', () => show(modal));
    document.querySelectorAll('[data-close-modal]').forEach((el) => el.addEventListener('click', () => hide(modal)));
    document.querySelectorAll('[data-close-preview]').forEach((el) => el.addEventListener('click', () => hide(preview)));
    document.querySelectorAll('[data-close-settings]').forEach((el) => el.addEventListener('click', () => hide(settings)));

    document.querySelectorAll('.btn-preview').forEach((button) => {
        button.addEventListener('click', () => {
            const template = document.getElementById(button.dataset.previewId);
            document.getElementById('preview-body').innerHTML = template ? template.innerHTML : '';
            show(preview);
        });
    });

    document.querySelectorAll('.btn-settings').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('settings-name').textContent = button.dataset.name || '-';
            document.getElementById('settings-status').textContent = button.dataset.status || '-';
            document.getElementById('settings-default').textContent = button.dataset.default || 'No';
            document.getElementById('settings-users').textContent = button.dataset.users || '0';
            document.getElementById('settings-description').textContent = button.dataset.description || 'No description yet.';
            show(settings);
        });
    });
});
</script>
@endsection
