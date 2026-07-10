@extends('layouts.pelamar')

@section('title', 'Education')
@section('nav-pendidikan', 'active')

@section('content')

<!-- Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Education</h1>
        <p class="text-gray-500 mt-1">Manage your formal education history to complete your professional profile.<br>Make sure the data entered matches your original certificates.</p>
    </div>
    <a href="{{ route('pelamar.pendidikan.create') }}" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Add Education
    </a>
</div>

@if (session('success'))
    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
        {{ session('success') }}
    </div>
@endif

@if ($educations->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center" id="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
        <p class="text-gray-500 font-medium">No education history found.</p>
        <p class="text-gray-400 text-sm mt-1">Click "Add Education" to add one.</p>
    </div>
@else
    <!-- Education Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden" id="education-list">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Institution</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Level / Major</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Period</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Documents</th>
                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($educations as $education)
                <tr class="border-t border-gray-100 hover:bg-green-50/30 transition-colors" data-id="{{ $education->id }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-green-50 rounded-lg flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">{{ $education->institution }}</p>
                                @if ($education->certificate_number)
                                    <p class="text-xs text-gray-400">Cert. No.: {{ $education->certificate_number }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[10px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded uppercase">
                            {{ $education->degree }}@if($education->major) - {{ $education->major }}@endif
                        </span>
                        @if($education->gpa)
                            <p class="text-xs text-gray-400 mt-1">GPA: {{ $education->gpa }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $education->start_year }} - {{ $education->end_year ?? 'Present' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            @if ($education->diploma_file)
                                <a href="{{ asset('storage/' . $education->diploma_file) }}" target="_blank" class="text-xs text-green-700 hover:underline flex items-center gap-1 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    Certificate / Diploma
                                </a>
                            @endif
                            @if ($education->skhu_file)
                                <a href="{{ asset('storage/' . $education->skhu_file) }}" target="_blank" class="text-xs text-green-700 hover:underline flex items-center gap-1 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    SKHU
                                </a>
                            @endif
                            @if (!$education->diploma_file && !$education->skhu_file)
                                <span class="text-xs text-gray-400 italic">No Document</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-1 justify-end">
                            <a href="{{ route('pelamar.pendidikan.edit', $education) }}" class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-green-700 hover:bg-green-50 transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                            </a>
                            <form action="{{ route('pelamar.pendidikan.destroy', $education) }}" method="POST" class="inline delete-education-form" onsubmit="return confirm('Are you sure you want to delete this education record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection

@section('scripts')
@endsection
