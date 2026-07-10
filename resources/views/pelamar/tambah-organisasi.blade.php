@extends('layouts.pelamar')

@section('title', $organizationExperience->exists ? 'Edit Organization Experience' : 'Add Organization Experience')
@section('nav-organisasi', 'active')

@section('content')

@php
    $isEdit = $organizationExperience->exists;
@endphp

<div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
    <a href="{{ route('pelamar.organisasi.index') }}" class="hover:text-green-700 transition-colors">Organization Experience</a>
    <span>&rsaquo;</span>
    <span class="text-gray-700 font-medium">{{ $isEdit ? 'Edit' : 'Add New' }}</span>
</div>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit Organization Experience' : 'Add Organization Experience' }}</h1>
    <p class="text-gray-500 mt-1">Fill in your organization or committee involvement details.</p>
</div>

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <p class="font-semibold">Please check the organization data.</p>
        <ul class="mt-1 list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $isEdit ? route('pelamar.organisasi.update', $organizationExperience) : route('pelamar.organisasi.store') }}" method="POST" class="bg-white rounded-xl border border-gray-200 p-8">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="position" class="block text-sm font-medium text-gray-700 mb-1.5">Position / Title <span class="text-red-500">*</span></label>
                <input type="text" id="position" name="position" value="{{ old('position', $organizationExperience->position) }}" placeholder="Example: Student Association President" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>
            <div>
                <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-1.5">Organization Name <span class="text-red-500">*</span></label>
                <input type="text" id="organization_name" name="organization_name" value="{{ old('organization_name', $organizationExperience->organization_name) }}" placeholder="Example: Faculty Student Executive Board" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_month" class="block text-sm font-medium text-gray-700 mb-1.5">Start</label>
                <input type="month" id="start_month" name="start_month" value="{{ old('start_month', optional($organizationExperience->start_date)->format('Y-m')) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <input type="hidden" id="start_date" name="start_date" value="{{ old('start_date', optional($organizationExperience->start_date)->format('Y-m-d')) }}">
            </div>
            <div>
                <label for="end_month" class="block text-sm font-medium text-gray-700 mb-1.5">Finish</label>
                <input type="month" id="end_month" name="end_month" value="{{ old('end_month', optional($organizationExperience->end_date)->format('Y-m')) }}" class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <input type="hidden" id="end_date" name="end_date" value="{{ old('end_date', optional($organizationExperience->end_date)->format('Y-m-d')) }}">
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Activity Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Describe your responsibilities, achievements, and contributions within this organization..." class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none">{{ old('description', $organizationExperience->description) }}</textarea>
            <p class="text-xs text-gray-400 mt-1.5 italic">Tip: Include specific numbers or concrete results to strengthen your description.</p>
        </div>

        <div class="flex gap-4 pt-4 justify-end">
            <a href="{{ route('pelamar.organisasi.index') }}" class="border border-gray-300 text-gray-700 font-semibold px-8 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</a>
            <button type="submit" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition-colors">
                {{ $isEdit ? 'Update Experience' : 'Save Experience' }}
            </button>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const startMonth = document.getElementById('start_month');
    const endMonth = document.getElementById('end_month');
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    function syncMonthInput(monthInput, dateInput) {
        dateInput.value = monthInput.value ? monthInput.value + '-01' : '';
    }

    startMonth.addEventListener('change', () => syncMonthInput(startMonth, startDate));
    endMonth.addEventListener('change', () => syncMonthInput(endMonth, endDate));
    syncMonthInput(startMonth, startDate);
    syncMonthInput(endMonth, endDate);
});
</script>
@endsection
