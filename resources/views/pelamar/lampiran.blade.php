@extends('layouts.pelamar')
@section('title','Attachments & Documents')
@section('nav-lampiran','active')
@section('content')

@if(session('success'))
<div id="flash" class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 rounded-xl mb-5 text-sm font-medium">
    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl mb-5 text-sm">
    <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="bg-white rounded-xl border border-gray-200 p-8 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Attachments & Documents</h1>
    <p class="text-gray-500 mt-1">Manage your skills, certificates and portfolio here.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex border-b border-gray-200 px-6">
        <button class="tab-btn px-5 py-3.5 text-sm font-semibold border-b-2 text-green-700 border-green-700" data-tab="skill">Skills & Certificates</button>
        <button class="tab-btn px-5 py-3.5 text-sm font-semibold border-b-2 text-gray-400 border-transparent hover:text-gray-600" data-tab="portofolio">Portfolio</button>
    </div>

    {{-- ===== TAB SKILLS ===== --}}
    <div class="tab-content p-6" id="tab-skill">

        {{-- Group by category --}}
        @php
            $categoryLabels = ['technical'=>'Technical','soft'=>'Soft Skills','language'=>'Language'];
            $levelColors    = ['beginner'=>'bg-blue-50 text-blue-700','intermediate'=>'bg-amber-50 text-amber-700','expert'=>'bg-green-50 text-green-700'];
        @endphp

        @forelse($skills->groupBy('category') as $cat => $group)
        <div class="mb-6">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">{{ $categoryLabels[$cat] ?? $cat }}</h3>
            <div class="grid grid-cols-3 gap-4">
                @foreach($group as $skill)
                <div class="skill-card rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all" data-id="{{ $skill->id }}">
                    <div class="flex items-start justify-between mb-2">
                        <p class="font-semibold text-sm text-gray-900 skill-name">{{ $skill->skill_name }}</p>
                        <div class="flex gap-1.5">
                            <button class="btn-edit-skill text-gray-300 hover:text-green-600 transition-colors"
                                data-id="{{ $skill->id }}"
                                data-skill="{{ $skill->skill_name }}"
                                data-category="{{ $skill->category }}"
                                data-level="{{ $skill->level }}"
                                data-cert_name="{{ $skill->cert_name }}"
                                data-has_cert_file="{{ $skill->cert_file_path ? '1' : '0' }}"
                                data-url="{{ route('pelamar.skill.update', $skill) }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                            </button>
                            <button class="btn-delete-skill text-gray-300 hover:text-red-500 transition-colors"
                                data-id="{{ $skill->id }}"
                                data-url="{{ route('pelamar.skill.destroy', $skill) }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $levelColors[$skill->level] ?? 'bg-gray-50 text-gray-500' }}">{{ ucfirst($skill->level) }}</span>
                    @if($skill->cert_name)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">📄 {{ $skill->cert_name }}</p>
                        @if($skill->cert_file_path)
                        <div class="flex gap-3 mt-1 text-xs">
                            <a href="{{ Storage::url($skill->cert_file_path) }}" target="_blank" class="text-green-700 hover:text-green-600">View</a>
                            <a href="{{ Storage::url($skill->cert_file_path) }}" download class="text-green-700 hover:text-green-600">Download</a>
                            @if($skill->cert_file_size)<span class="ml-auto text-gray-400">{{ number_format($skill->cert_file_size/1048576,1) }} MB</span>@endif
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M12 2a3 3 0 0 0-3 3v1H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-4V5a3 3 0 0 0-3-3z"/></svg>
            <p class="text-sm">No skills added yet.</p>
        </div>
        @endforelse

        <button id="btn-tambah-skill" class="mt-4 w-full border-2 border-dashed border-gray-300 rounded-xl py-4 flex items-center justify-center gap-2 hover:border-green-400 hover:bg-green-50/30 transition-all text-sm text-gray-500 font-medium">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Add Skill / Certificate
        </button>
    </div>

    {{-- ===== TAB PORTOFOLIO ===== --}}
    <div class="tab-content p-6 hidden" id="tab-portofolio">

        @forelse($portofolios->groupBy('type') as $type => $group)
        <div class="mb-6">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">{{ $type === 'link' ? 'Link URL' : 'File Upload' }}</h3>
            <div class="grid grid-cols-3 gap-4">
                @foreach($group as $porto)
                <div class="porto-card rounded-xl border border-gray-200 p-4 hover:shadow-md transition-all" data-id="{{ $porto->id }}">
                    <div class="flex items-start justify-between mb-2">
                        <p class="font-semibold text-sm text-gray-900">{{ $porto->title }}</p>
                        <div class="flex gap-1.5">
                            <button class="btn-edit-porto text-gray-300 hover:text-green-600 transition-colors"
                                data-id="{{ $porto->id }}"
                                data-title="{{ $porto->title }}"
                                data-description="{{ $porto->description }}"
                                data-type="{{ $porto->type }}"
                                data-link="{{ $porto->link_url }}"
                                data-url="{{ route('pelamar.portofolio.update', $porto) }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                            </button>
                            <button class="btn-delete-porto text-gray-300 hover:text-red-500 transition-colors"
                                data-url="{{ route('pelamar.portofolio.destroy', $porto) }}">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $porto->type==='link' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">{{ ucfirst($porto->type) }}</span>
                    @if($porto->type==='link' && $porto->link_url)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">🔗 {{ $porto->description ?? '-' }}</p>
                        <a href="{{ $porto->link_url }}" target="_blank" class="text-xs text-green-700 hover:text-green-600 break-all">{{ $porto->link_url }}</a>
                    </div>
                    @elseif($porto->file_url)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">📄 {{ $porto->description ?? basename($porto->file_url) }}</p>
                        <div class="flex gap-3 mt-1 text-xs text-gray-500">
                            <a href="{{ Storage::url($porto->file_url) }}" target="_blank" class="hover:text-gray-700">View</a>
                            <a href="{{ Storage::url($porto->file_url) }}" download class="hover:text-gray-700">Download</a>
                            @if($porto->file_size)<span class="ml-auto text-gray-400">{{ number_format($porto->file_size/1048576,1) }} MB</span>@endif
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
            <p class="text-sm">No portfolio added yet.</p>
        </div>
        @endforelse

        <button id="btn-tambah-porto" class="mt-4 w-full border-2 border-dashed border-gray-300 rounded-xl py-4 flex items-center justify-center gap-2 hover:border-green-400 hover:bg-green-50/30 transition-all text-sm text-gray-500 font-medium">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Add New Portfolio
        </button>
    </div>
</div>

{{-- ===== MODAL SKILL ===== --}}
<div id="modal-skill" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 p-8 relative">
        <button class="modal-close-skill absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <h2 id="skill-modal-title" class="text-lg font-bold text-gray-900 mb-6">Add Skill</h2>
        <form id="form-skill" method="POST" action="{{ route('pelamar.skill.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <span id="skill-method-field"></span>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name <span class="text-red-500">*</span></label>
                <input type="text" name="skill_name" id="skill-name" placeholder="e.g. Laravel, Photoshop"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                    <select name="category" id="skill-category" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="technical">Technical</option>
                        <option value="soft">Soft Skill</option>
                        <option value="language">Language</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level <span class="text-red-500">*</span></label>
                    <select name="level" id="skill-level" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="expert">Expert</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificate Name <span class="text-xs text-gray-400">(optional)</span></label>
                <input type="text" name="cert_name" id="skill-cert-name" placeholder="e.g. AWS Certified Developer"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div id="skill-cert-file-wrap">
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificate File <span class="text-xs text-gray-400">(optional, PDF/JPG/PNG, max 5MB)</span></label>
                <input type="file" name="cert_file" id="skill-cert-file" accept="application/pdf,image/jpeg,image/png"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p id="skill-cert-current" class="hidden mt-1 text-xs text-gray-400">Current file is saved. Choose a new file to replace it.</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Save</button>
                <button type="button" class="modal-close-skill flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL PORTFOLIO ===== --}}
<div id="modal-porto" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 p-8 relative">
        <button class="modal-close-porto absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <h2 id="porto-modal-title" class="text-lg font-bold text-gray-900 mb-6">Add Portfolio</h2>
        <form id="form-porto" method="POST" action="{{ route('pelamar.portofolio.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <span id="porto-method-field"></span>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="porto-title" placeholder="Project name"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                <input type="text" name="description" id="porto-desc" placeholder="Brief explanation"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div id="porto-type-wrap">
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-green-500 has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                        <input type="radio" name="type" value="link" checked class="accent-green-700">
                        <div><p class="text-sm font-medium">Link URL</p><p class="text-xs text-gray-400">GitHub, Behance, etc.</p></div>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-green-500 has-[:checked]:border-green-600 has-[:checked]:bg-green-50">
                        <input type="radio" name="type" value="file" class="accent-green-700">
                        <div><p class="text-sm font-medium">Upload File</p><p class="text-xs text-gray-400">PDF, JPG, PNG</p></div>
                    </label>
                </div>
            </div>
            <div id="porto-link-field">
                <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                <input type="url" name="link_url" id="porto-url" placeholder="https://github.com/..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div id="porto-file-field" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                <input type="file" name="porto_file" accept="image/jpeg,image/png,application/pdf"
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Save</button>
                <button type="button" class="modal-close-porto flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50">Cancel</button>
            </div>
        </form>
    </div>
</div>

<form id="form-delete" method="POST" class="hidden">@csrf @method('DELETE')</form>

@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const CSRF = '{{ csrf_token() }}';

    // Tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('text-green-700','border-green-700'); b.classList.add('text-gray-400','border-transparent'); });
            this.classList.add('text-green-700','border-green-700'); this.classList.remove('text-gray-400','border-transparent');
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById('tab-' + this.dataset.tab).classList.remove('hidden');
        });
    });
    if (window.location.hash === '#tab-portofolio') document.querySelector('[data-tab="portofolio"]').click();

    // ===== SKILL MODAL =====
    const modalSkill = document.getElementById('modal-skill');
    const formSkill  = document.getElementById('form-skill');

    function openSkillModal(mode, data = {}) {
        document.getElementById('skill-modal-title').textContent = mode === 'add' ? 'Add Skill' : 'Edit Skill';
        document.getElementById('skill-name').value      = data.skill     || '';
        document.getElementById('skill-category').value  = data.category  || 'technical';
        document.getElementById('skill-level').value     = data.level     || 'beginner';
        document.getElementById('skill-cert-name').value = data.cert_name || '';
        // Reset file input setiap buka modal
        document.getElementById('skill-cert-file').value = '';
        // Tampilkan hint jika mode edit dan sudah ada file tersimpan
        const hintEl = document.getElementById('skill-cert-current');
        hintEl.classList.toggle('hidden', !(mode === 'edit' && data.has_cert_file));
        document.getElementById('skill-method-field').innerHTML = '';
        if (mode === 'edit') {
            formSkill.action = data.url;
            document.getElementById('skill-method-field').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
        } else {
            formSkill.action = '{{ route('pelamar.skill.store') }}';
        }
        modalSkill.classList.remove('hidden');
    }

    document.getElementById('btn-tambah-skill').addEventListener('click', () => openSkillModal('add'));
    document.querySelectorAll('.modal-close-skill').forEach(b => b.addEventListener('click', () => modalSkill.classList.add('hidden')));
    modalSkill.addEventListener('click', e => { if (e.target === modalSkill) modalSkill.classList.add('hidden'); });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-edit-skill');
        if (!btn) return;
        openSkillModal('edit', {
            skill:         btn.dataset.skill,
            category:      btn.dataset.category,
            level:         btn.dataset.level,
            cert_name:     btn.dataset.cert_name,
            has_cert_file: btn.dataset.has_cert_file === '1',
            url:           btn.dataset.url,
        });
    });

    // Submit skill via AJAX saat mode edit (PATCH)
    formSkill.addEventListener('submit', function (e) {
        const methodField = document.getElementById('skill-method-field');
        const isPatch = methodField.innerHTML.includes('PATCH');
        if (!isPatch) return; // biarkan store (POST) berjalan normal

        e.preventDefault();

        const fd = new FormData(formSkill);
        fetch(formSkill.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        })
        .then(r => r.json())
        .then(data => {
            if (data.message === 'OK') {
                // Update card di DOM tanpa reload
                const newName     = document.getElementById('skill-name').value;
                const newCategory = document.getElementById('skill-category').value;
                const newLevel    = document.getElementById('skill-level').value;
                const newCertName = document.getElementById('skill-cert-name').value;

                const actionUrl = formSkill.action;
                document.querySelectorAll('.skill-card').forEach(card => {
                    const editBtn = card.querySelector('.btn-edit-skill');
                    if (editBtn && editBtn.dataset.url === actionUrl) {
                        // Update nama skill di card
                        const nameEl = card.querySelector('.skill-name');
                        if (nameEl) nameEl.textContent = newName;
                        // Update data-attr tombol edit
                        editBtn.dataset.skill     = newName;
                        editBtn.dataset.category  = newCategory;
                        editBtn.dataset.level     = newLevel;
                        editBtn.dataset.cert_name = newCertName;
                        // Update level badge
                        const levelBadge = card.querySelector('span.rounded-full');
                        if (levelBadge) {
                            levelBadge.textContent = newLevel.charAt(0).toUpperCase() + newLevel.slice(1);
                            levelBadge.className = 'text-xs font-medium px-2.5 py-0.5 rounded-full ' +
                                ({ beginner: 'bg-blue-50 text-blue-700', intermediate: 'bg-amber-50 text-amber-700', expert: 'bg-green-50 text-green-700' }[newLevel] || 'bg-gray-50 text-gray-500');
                        }
                        // Update cert name if visible
                        const certEl = card.querySelector('.border-t p.text-xs');
                        if (certEl && newCertName) {
                            certEl.textContent = '📄 ' + newCertName;
                        }
                    }
                });

                modalSkill.classList.add('hidden');
            } else if (data.errors) {
                alert(Object.values(data.errors).flat().join('\n'));
            }
        })
        .catch(() => alert('Failed to save. Try again.'));
    });

    // Delete skill (AJAX)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-skill');
        if (!btn || !confirm('Delete this skill?')) return;
        const card = btn.closest('.skill-card');
        fetch(btn.dataset.url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
            .then(r => { if (r.ok) { card.style.opacity='0'; card.style.transition='opacity .3s'; setTimeout(()=>card.remove(),300); } });
    });

    // ===== PORTO MODAL =====
    const modalPorto = document.getElementById('modal-porto');
    const formPorto  = document.getElementById('form-porto');

    function openPortoModal(mode, data = {}) {
        document.getElementById('porto-modal-title').textContent = mode === 'add' ? 'Add Portfolio' : 'Edit Portfolio';
        document.getElementById('porto-title').value = data.title       || '';
        document.getElementById('porto-desc').value  = data.description || '';
        document.getElementById('porto-url').value   = data.link        || '';
        // Reset file input
        const fileInput = document.querySelector('#form-porto input[name="porto_file"]');
        if (fileInput) fileInput.value = '';

        document.getElementById('porto-method-field').innerHTML = '';
        document.getElementById('porto-type-wrap').classList.toggle('hidden', mode === 'edit');
        
        // Ensure enctype is always multipart/form-data to support file uploads in both store and update
        formPorto.setAttribute('enctype', 'multipart/form-data');

        if (mode === 'edit') {
            formPorto.action = data.url;
            document.getElementById('porto-method-field').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
            document.getElementById('porto-link-field').classList.toggle('hidden', data.type !== 'link');
            document.getElementById('porto-file-field').classList.toggle('hidden', data.type !== 'file');
        } else {
            formPorto.action = '{{ route('pelamar.portofolio.store') }}';
            document.getElementById('porto-link-field').classList.remove('hidden');
            document.getElementById('porto-file-field').classList.add('hidden');
            // reset radio buttons to link
            document.querySelectorAll('#form-porto input[name="type"]').forEach(r => {
                r.checked = r.value === 'link';
            });
        }
        modalPorto.classList.remove('hidden');
    }

    document.getElementById('btn-tambah-porto').addEventListener('click', () => openPortoModal('add'));
    document.querySelectorAll('.modal-close-porto').forEach(b => b.addEventListener('click', () => modalPorto.classList.add('hidden')));
    modalPorto.addEventListener('click', e => { if (e.target === modalPorto) modalPorto.classList.add('hidden'); });

    document.querySelectorAll('#form-porto input[name="type"]').forEach(r => {
        r.addEventListener('change', function () {
            document.getElementById('porto-link-field').classList.toggle('hidden', this.value !== 'link');
            document.getElementById('porto-file-field').classList.toggle('hidden', this.value !== 'file');
        });
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-edit-porto');
        if (!btn) return;
        openPortoModal('edit', { title: btn.dataset.title, description: btn.dataset.description, type: btn.dataset.type, link: btn.dataset.link, url: btn.dataset.url });
    });

    // Submit porto via AJAX saat mode edit (PATCH)
    formPorto.addEventListener('submit', function (e) {
        const methodField = document.getElementById('porto-method-field');
        const isPatch = methodField.innerHTML.includes('PATCH');
        if (!isPatch) return; // biarkan store (POST) berjalan normal

        e.preventDefault();

        const fd = new FormData(formPorto);
        fetch(formPorto.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        })
        .then(r => r.json())
        .then(data => {
            if (data.message === 'OK') {
                const p = data.portfolio;
                const actionUrl = formPorto.action;

                document.querySelectorAll('.porto-card').forEach(card => {
                    const editBtn = card.querySelector('.btn-edit-porto');
                    if (editBtn && editBtn.dataset.url === actionUrl) {
                        // Update teks judul
                        const titleEl = card.querySelector('p.font-semibold');
                        if (titleEl) titleEl.textContent = p.title;

                        // Update data attributes on edit button
                        editBtn.dataset.title       = p.title;
                        editBtn.dataset.description = p.description;
                        editBtn.dataset.link        = p.link_url;

                        if (editBtn.dataset.type === 'link') {
                            // Link type
                            const descEl = card.querySelector('p.text-xs.text-gray-500.font-medium');
                            if (descEl) descEl.textContent = '🔗 ' + (p.description || '-');

                            const linkEl = card.querySelector('a[target="_blank"]');
                            if (linkEl && p.link_url) {
                                linkEl.href = p.link_url;
                                linkEl.textContent = p.link_url;
                            }
                        } else {
                            // File type
                            const descEl = card.querySelector('p.text-xs.text-gray-500.font-medium');
                            if (descEl) {
                                const fileName = p.file_url ? p.file_url.split('/').pop() : '';
                                descEl.textContent = '📄 ' + (p.description || fileName || '-');
                            }

                            // Update View and Download links if a new file was uploaded
                            if (p.file_url) {
                                const links = card.querySelectorAll('.flex.gap-3.mt-1.text-xs.text-gray-500 a');
                                if (links.length >= 2) {
                                    links[0].href = p.file_url; // View
                                    links[1].href = p.file_url; // Download
                                }
                            }

                            // Update file size if a new file was uploaded
                            if (p.file_size_formatted) {
                                const sizeEl = card.querySelector('span.text-gray-400');
                                if (sizeEl) {
                                    sizeEl.textContent = p.file_size_formatted;
                                }
                            }
                        }
                    }
                });

                modalPorto.classList.add('hidden');
            }
        })
        .catch(() => alert('Failed to save. Try again.'));
    });

    // Delete porto (AJAX)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-porto');
        if (!btn || !confirm('Delete this portfolio?')) return;
        const card = btn.closest('.porto-card');
        fetch(btn.dataset.url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' } })
            .then(r => { if (r.ok) { card.style.opacity='0'; card.style.transition='opacity .3s'; setTimeout(()=>card.remove(),300); } });
    });

    // Auto-dismiss flash
    const flash = document.getElementById('flash');
    if (flash) setTimeout(() => { flash.style.opacity='0'; flash.style.transition='opacity .5s'; setTimeout(()=>flash.remove(),500); }, 3000);
});
</script>
@endsection