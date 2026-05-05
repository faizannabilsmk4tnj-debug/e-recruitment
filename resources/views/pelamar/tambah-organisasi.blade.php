@extends('layouts.pelamar')

@section('title', 'Add Organization Experience')
@section('nav-organisasi', 'active')

@section('content')

<!-- Breadcrumb -->
<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="/pelamar/organisasi" class="hover:text-green-700 transition-colors">Organization Experience</a>
    <span>›</span>
    <span class="text-gray-700 font-medium">Add New</span>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add Organization Experience</h1>
    <p class="text-gray-500 mt-1">Fill in your organization or committee involvement details.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-8">
    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Position / Title <span class="text-red-500">*</span></label>
                <input type="text" id="jabatan" placeholder="Example: Student Association President" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Organization Name <span class="text-red-500">*</span></label>
                <input type="text" id="organisasi" placeholder="Example: Faculty Student Executive Board" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Start</label>
                <input type="month" id="mulai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Finish</label>
                <input type="month" id="selesai" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Activity Description</label>
            <textarea id="deskripsi" rows="5" placeholder="Describe your responsibilities, achievements, and contributions within this organization..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>
            <p class="text-xs text-gray-400 mt-1.5 italic">Tip: Include specific numbers or concrete results to strengthen your description.</p>
        </div>

        <div class="flex gap-4 pt-4 justify-end">
            <a href="/pelamar/organisasi" class="border border-gray-300 text-gray-700 font-semibold px-8 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="button" id="btn-simpan" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition-colors">Save Experience</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('btn-simpan').addEventListener('click', function () {
        const jabatan = document.getElementById('jabatan').value.trim();
        const organisasi = document.getElementById('organisasi').value.trim();
        if (!jabatan || !organisasi) { alert('Position and Organization Name are required.'); return; }
        alert('Organization experience saved successfully! (demo)');
        window.location.href = '/pelamar/organisasi';
    });
});
</script>
@endsection