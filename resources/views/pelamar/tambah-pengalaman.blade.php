@extends('layouts.pelamar')

@section('title', $workExperience->exists ? 'Edit Work Experience' : 'Add Work Experience')
@section('nav-pengalaman', 'active')

@section('content')

@php
    $isEdit = $workExperience->exists;
@endphp

<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="{{ route('pelamar.pengalaman-kerja.index') }}" class="hover:text-green-700 transition-colors">Work Experience</a>
    <span>&rsaquo;</span>
    <span class="text-gray-700 font-medium">{{ $isEdit ? 'Edit' : 'Add New' }}</span>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Work Experience' : 'Add Work Experience' }}</h1>
    <p class="text-gray-500 mt-1">Complete your professional experience details for a better profile.</p>
</div>

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Please check the work experience data.</p>
        <ul class="mt-1 list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $isEdit ? route('pelamar.pengalaman-kerja.update', $workExperience) : route('pelamar.pengalaman-kerja.store') }}" method="POST" class="bg-white rounded-xl border border-gray-200 p-8">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-1.5">Position / Job Title <span class="text-red-500">*</span></label>
                <input type="text" id="position" name="position" value="{{ old('position', $workExperience->position) }}" placeholder="Example: Chemical Engineer" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1.5">Company Name <span class="text-red-500">*</span></label>
                <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $workExperience->company_name) }}" placeholder="Example: PT Ecogreen Oleochemicals" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1.5">Start Date <span class="text-red-500">*</span></label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', optional($workExperience->start_date)->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1.5">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date', optional($workExperience->end_date)->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="is_current" name="is_current" value="1" @checked(old('is_current', $workExperience->is_current)) class="h-4 w-4 rounded border-gray-300 accent-green-800 cursor-pointer">
            <span class="text-sm text-gray-600">I am currently working in this role</span>
        </label>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Job Description</label>
            <textarea id="description" name="description" rows="6" placeholder="Describe your responsibilities and achievements during this position..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none">{{ old('description', $workExperience->description) }}</textarea>
            <p class="text-xs text-gray-400 mt-1.5 italic">Tips: Use bullet points to describe your key achievements.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
            <button type="submit" class="bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ $isEdit ? 'Update Experience' : 'Save Experience' }}
            </button>
            <a href="{{ route('pelamar.pengalaman-kerja.index') }}" class="border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors flex items-center justify-center">
                Cancel
            </a>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const currentCheckbox = document.getElementById('is_current');
    const endDateInput = document.getElementById('end_date');

    function syncEndDate() {
        endDateInput.disabled = currentCheckbox.checked;
        if (currentCheckbox.checked) {
            endDateInput.value = '';
        }
    }

    currentCheckbox.addEventListener('change', syncEndDate);
    syncEndDate();
});
</script>
@endsection
