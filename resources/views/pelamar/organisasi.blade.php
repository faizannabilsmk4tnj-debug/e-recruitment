@extends('layouts.pelamar')

@section('title', 'Organization Experience')
@section('nav-organisasi', 'active')

@section('content')

<div class="flex items-start justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Organization Experience</h1>
        <p class="text-gray-500 mt-1">Manage your organization and committee involvement history.</p>
    </div>
    <a href="{{ route('pelamar.organisasi.create') }}" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-2 shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Add Experience
    </a>
</div>

@if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
        {{ session('success') }}
    </div>
@endif

@if ($organizationExperiences->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($organizationExperiences as $experience)
            <div class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md hover:border-green-200 transition-all">
                <div class="flex items-center gap-3 mb-2.5">
                    <div class="w-2 h-10 bg-green-700 rounded-full shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm text-gray-900 truncate">{{ $experience->position }}</h3>
                        <p class="text-xs text-green-700 font-medium truncate">{{ $experience->organization_name }}</p>
                    </div>
                    @if ($experience->start_date || $experience->end_date)
                        <span class="text-[10px] text-gray-400 bg-gray-50 px-2 py-1 rounded-md shrink-0 font-medium">
                            {{ optional($experience->start_date)->format('Y') ?? '-' }}{{ $experience->end_date ? ' - '.$experience->end_date->format('Y') : '' }}
                        </span>
                    @endif
                </div>

                @if ($experience->description)
                    <p class="text-xs text-gray-500 leading-relaxed ml-5">{{ $experience->description }}</p>
                @endif

                <div class="flex gap-3 mt-3 ml-5">
                    <a href="{{ route('pelamar.organisasi.edit', $experience) }}" class="text-[11px] text-gray-400 hover:text-green-700 transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        Edit
                    </a>
                    <form action="{{ route('pelamar.organisasi.destroy', $experience) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this organization experience?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-[11px] text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <p class="text-gray-500 font-medium">No organization experience found.</p>
        <p class="text-gray-400 text-sm mt-1">Click "Add Experience" to add.</p>
    </div>
@endif

@endsection
