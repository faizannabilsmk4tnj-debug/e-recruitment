@extends('layouts.hr')

@section('title', 'HR Team')
@section('page-title', 'HR Team')
@section('nav-tim', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="px-8 py-8">

    <!-- Header -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-green-900">HR Team</h1>
            <p class="text-gray-500 mt-1">Manage access and roles for your HR management team members.</p>
        </div>
        <button id="btn-tambah-anggota" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M19 8v6"/><path d="M22 11h-6"/></svg>
            Add New Member
        </button>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border-b-4 border-green-700 p-6">
            <p class="text-sm text-gray-500">Total Members</p>
            <p class="text-4xl font-extrabold text-green-900 mt-1">{{ $totalCount }}</p>
        </div>
        <div class="bg-gray-50 rounded-xl border-b-4 border-gray-200 p-6">
            <p class="text-sm text-gray-500">HR Master</p>
            <p class="text-4xl font-extrabold text-gray-800 mt-1">{{ $masterCount }}</p>
        </div>
        <div class="bg-white rounded-xl border-b-4 border-green-300 p-6">
            <p class="text-sm text-gray-500">HR Staff</p>
            <p class="text-4xl font-extrabold text-green-900 mt-1">{{ $staffCount }}</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-green-900">Member List</h2>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="search-member" placeholder="Search by name or email..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-64">
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Member</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Role</th>
                    <th class="text-left text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                    <th class="text-right text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="member-table">

                @foreach($members as $member)
                @php
                    $words = explode(' ', $member->name);
                    $initials = '';
                    foreach ($words as $w) {
                        $initials .= strtoupper($w[0] ?? '');
                    }
                    $initials = substr($initials, 0, 2);

                    $colors = ['bg-green-800', 'bg-blue-600', 'bg-purple-600', 'bg-pink-500', 'bg-amber-500'];
                    $colorClass = $colors[$member->id % count($colors)];
                @endphp
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors member-row"
                    data-id="{{ $member->id }}"
                    data-name="{{ $member->name }}"
                    data-email="{{ $member->email }}"
                    data-role="{{ $member->role === 'hr_master' ? 'HR Master' : 'HR' }}"
                    data-status="{{ $member->is_active ? 'aktif' : 'nonaktif' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ $colorClass }} flex items-center justify-center text-white font-bold text-sm shrink-0">{{ $initials }}</div>
                            <div>
                                <p class="font-semibold text-sm text-gray-900">{{ $member->name }}</p>
                                <p class="text-xs text-gray-400">{{ $member->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($member->role === 'hr_master')
                            <span class="text-xs font-bold text-purple-700 bg-purple-50 border border-purple-200 px-3 py-1 rounded-full">HR Master</span>
                        @else
                            <span class="text-xs font-bold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full">HR</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer toggle-status" {{ $member->is_active ? 'checked' : '' }} {{ Auth::id() == $member->id ? 'disabled' : '' }}>
                                <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                            <span class="text-xs font-semibold {{ $member->is_active ? 'text-green-700' : 'text-gray-400' }} status-label">{{ $member->is_active ? 'ACTIVE' : 'INACTIVE' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if(Auth::id() != $member->id)
                            <button class="btn-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100">
            <p class="text-xs text-gray-500">Showing {{ $members->count() }} of {{ $members->count() }} members</p>
        </div>
    </div>
</div>

<!-- Dropdown action menu (Edit + Hapus only) -->
<div id="action-dropdown" class="hidden absolute bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-40 py-1.5">
    <button id="action-edit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
        Edit Member
    </button>
    <div class="my-1 border-t border-gray-100"></div>
    <button id="action-hapus" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
        Remove Member
    </button>
</div>

<!-- Modal: Tambah Anggota -->
<div id="modal-tambah" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl">
        <div class="bg-green-900 px-6 py-5 flex items-center justify-between">
            <h2 class="text-white font-bold">Add HR Member</h2>
            <button id="btn-close-tambah" class="text-green-300 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div id="tambah-error" class="hidden text-xs text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-200"></div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Full Name</label>
                <input type="text" id="new-name" placeholder="Enter full name" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" id="new-email" placeholder="nama@ecogreen.com" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Temporary Password</label>
                <input type="password" id="new-pass" placeholder="Min. 8 characters" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                <p class="text-[10px] text-gray-400 mt-1">Member can change their password after first login.</p>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="btn-cancel-tambah" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="btn-save-tambah" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Add Member</button>
        </div>
    </div>
</div>

<!-- Modal: Edit Anggota -->
<div id="modal-edit" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 overflow-hidden shadow-2xl">
        <div class="bg-green-900 px-6 py-5 flex items-center justify-between">
            <h2 class="text-white font-bold">Edit Member</h2>
            <button id="btn-close-edit" class="text-green-300 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div id="edit-error" class="hidden text-xs text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-200"></div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Full Name</label>
                <input type="text" id="edit-name" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                <input type="email" id="edit-email" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">New Password <span class="text-gray-300 normal-case font-normal">(leave blank to keep unchanged)</span></label>
                <input type="password" id="edit-pass" placeholder="Min. 8 characters" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button id="btn-cancel-edit" class="flex-1 border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="btn-save-edit" class="flex-1 bg-green-800 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Save Changes</button>
        </div>
    </div>
</div>

<!-- Modal: Hapus Anggota -->
<div id="modal-hapus" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 text-center relative">
        <button id="btn-close-hapus" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
        <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Remove Member?</h3>
        <p class="text-sm text-gray-500 mb-1">The following member will be removed from the system:</p>
        <p class="text-sm font-semibold text-gray-900 mb-5" id="hapus-name"></p>
        <div class="space-y-2.5">
            <button id="btn-confirm-hapus" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Yes, Remove Member</button>
            <button id="btn-cancel-hapus" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/hr/tim.js') }}?v={{ time() }}"></script>
@endsection