@extends('layouts.hr')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('nav-setting', 'text-green-800 border-green-700 font-semibold')

@section('content')
<div class="flex min-h-[calc(100vh-7rem)]">

    {{-- ============ SIDEBAR KIRI ============ --}}
    <aside class="w-52 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col" style="min-height: calc(100vh - 7rem)">

        <div class="px-4 py-6 flex-1">
            <div class="mb-4">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-sm font-semibold text-gray-800">Settings</span>
                </div>
                <p class="text-xs text-gray-400 pl-4">Manage your preferences</p>
            </div>

            <nav class="space-y-0.5">
                <button data-tab="account" class="setting-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all text-green-800 bg-green-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Account Profile
                </button>
                <button data-tab="security" class="setting-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all text-gray-600 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Security
                </button>
                <button data-tab="notifications" class="setting-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all text-gray-600 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifications
                </button>
                <button data-tab="language" class="setting-tab w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all text-gray-600 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                    Language
                </button>
            </nav>
        </div>

        {{-- Tombol bawah sidebar --}}
        <div class="px-4 py-4 border-t border-gray-100 space-y-2">
            <button id="btn-update-all" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-900 hover:bg-green-800 text-white text-xs font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Update All
            </button>
            <button id="btn-logout" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-red-200 text-red-500 hover:bg-red-50 text-xs font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </div>
    </aside>

    {{-- ============ KONTEN UTAMA ============ --}}
    <div class="flex-1 p-8">

        {{-- TAB: ACCOUNT PROFILE --}}
        <div id="tab-account" class="tab-content">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-green-900">Account Profile</h2>
                <p class="text-sm text-gray-500 mt-1">Update your personal information and profile visibility settings.</p>
            </div>

            {{-- Profile Photo --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-5">
                <div class="flex items-start gap-5">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-xl bg-gray-800 flex items-center justify-center overflow-hidden border-2 border-gray-200">
                            <svg class="w-10 h-10 text-gray-400" id="photo-placeholder" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <img id="photo-preview" src="" alt="Profile" class="w-full h-full object-cover hidden">
                        </div>
                        <button id="btn-photo-edit" class="absolute -bottom-1.5 -right-1.5 w-6 h-6 bg-green-700 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </button>
                        <input type="file" id="photo-input" accept="image/jpeg,image/png" class="hidden">
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 mb-1">Profile Photo</h3>
                        <p class="text-xs text-gray-500 mb-3">Upload a high-resolution professional photo.<br>Accepted formats: JPG, PNG. Max size: 2MB.</p>
                        <div class="flex items-center gap-3">
                            <button id="btn-upload-photo" class="px-4 py-1.5 text-xs font-medium border border-green-700 text-green-800 rounded-lg hover:bg-green-50 transition-colors">Upload New</button>
                            <button id="btn-remove-photo" class="text-xs font-medium text-red-500 hover:text-red-700 transition-colors">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Personal Details --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-5">
                <div class="flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <h3 class="text-sm font-semibold text-gray-800">Personal Details</h3>
                </div>
                <div class="grid grid-cols-2 gap-x-8 gap-y-5">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Full Name</label>
                        <input type="text" value="Budi Santoso" class="w-full text-sm text-gray-800 border-0 border-b border-gray-300 pb-1.5 focus:outline-none focus:border-green-600 bg-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Email Address</label>
                        <input type="email" value="budi.santoso@ecogreen.com" class="w-full text-sm text-gray-800 border-0 border-b border-gray-300 pb-1.5 focus:outline-none focus:border-green-600 bg-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Job Title</label>
                        <input type="text" value="Senior HR Operations Manager" class="w-full text-sm text-gray-800 border-0 border-b border-gray-300 pb-1.5 focus:outline-none focus:border-green-600 bg-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Employee ID</label>
                        <input type="text" value="ECG-99821" readonly class="w-full text-sm text-gray-500 border-0 border-b border-gray-200 pb-1.5 focus:outline-none bg-transparent cursor-not-allowed">
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                    <button id="btn-discard" class="text-sm text-gray-500 hover:text-gray-700 transition-colors font-medium">Discard Changes</button>
                    <button id="btn-save-profile" class="px-5 py-2 bg-green-900 text-white text-sm font-medium rounded-lg hover:bg-green-800 transition-colors flex items-center gap-2">
                        Save Profile
                    </button>
                </div>
            </div>

            {{-- Status Cards --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-green-50 border border-green-100 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div><div class="text-[9px] font-bold text-green-600 uppercase tracking-wider">Account Status</div><div class="text-xs font-semibold text-green-900 mt-0.5">Active Member</div></div>
                </div>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div><div class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Last Updated</div><div class="text-xs font-semibold text-gray-700 mt-0.5">2 days ago</div></div>
                </div>
                <div class="bg-green-50 border border-green-100 rounded-xl p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <div><div class="text-[9px] font-bold text-green-600 uppercase tracking-wider">Privacy Level</div><div class="text-xs font-semibold text-green-900 mt-0.5">Standard Secure</div></div>
                </div>
            </div>
        </div>

        {{-- TAB: SECURITY --}}
        <div id="tab-security" class="tab-content hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-green-900">Security</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your account security and authentication settings.</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-5">
                <h3 class="text-sm font-semibold text-gray-800 mb-5">Change Password</h3>
                <div class="space-y-4 max-w-md">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Current Password</label>
                        <div class="relative">
                            <input type="password" id="cur-pass" placeholder="••••••••" class="w-full text-sm border-0 border-b border-gray-300 pb-1.5 pr-8 focus:outline-none focus:border-green-600 bg-transparent">
                            <button class="toggle-pass absolute right-0 top-0 text-gray-400 hover:text-gray-600" data-target="cur-pass">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">New Password</label>
                        <div class="relative">
                            <input type="password" id="new-pass" placeholder="••••••••" class="w-full text-sm border-0 border-b border-gray-300 pb-1.5 pr-8 focus:outline-none focus:border-green-600 bg-transparent">
                            <button class="toggle-pass absolute right-0 top-0 text-gray-400 hover:text-gray-600" data-target="new-pass">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <div class="mt-2 flex gap-1">
                            <div class="h-1 flex-1 rounded bg-gray-200" id="bar1"></div>
                            <div class="h-1 flex-1 rounded bg-gray-200" id="bar2"></div>
                            <div class="h-1 flex-1 rounded bg-gray-200" id="bar3"></div>
                            <div class="h-1 flex-1 rounded bg-gray-200" id="bar4"></div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1" id="strength-label">Minimal 8 karakter, kombinasi huruf dan angka.</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1.5">Confirm New Password</label>
                        <input type="password" id="conf-pass" placeholder="••••••••" class="w-full text-sm border-0 border-b border-gray-300 pb-1.5 focus:outline-none focus:border-green-600 bg-transparent">
                    </div>
                </div>
                <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                    <button id="btn-change-pass" class="px-5 py-2 bg-green-900 text-white text-sm font-medium rounded-lg hover:bg-green-800 transition-colors">Update Password</button>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-sm font-semibold text-gray-800">Active Sessions</h3>
                    <button id="btn-logout-all" class="text-xs text-red-500 hover:text-red-700 font-medium transition-colors">Logout All Devices</button>
                </div>
                <div class="space-y-3" id="session-list">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100" id="session-current">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-800">Windows — Chrome 120</div>
                                <div class="text-[10px] text-gray-400">Batam, Indonesia · Sekarang</div>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Current</span>
                    </div>
                    <div class="flex items-center justify-between py-3" id="session-iphone">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-800">iPhone — Safari</div>
                                <div class="text-[10px] text-gray-400">Batam, Indonesia · 2 jam lalu</div>
                            </div>
                        </div>
                        <button class="btn-logout-device text-xs text-red-400 hover:text-red-600 transition-colors font-medium" data-device="iPhone — Safari" data-session="session-iphone">Logout</button>
                    </div>
                </div>

                <!-- Empty sessions state -->
                <div id="no-sessions" class="hidden py-6 text-center">
                    <p class="text-xs text-gray-400">Tidak ada sesi aktif lain.</p>
                </div>
            </div>

            <!-- Modal: Konfirmasi Logout Device -->
            <div id="modal-logout-device" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
                <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 relative">
                    <button id="btn-close-session-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                    <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Logout Perangkat?</h3>
                    <p class="text-sm text-gray-500 text-center mb-1">Perangkat berikut akan dikeluarkan:</p>
                    <p class="text-sm font-semibold text-gray-800 text-center mb-5" id="modal-device-name"></p>
                    <div class="space-y-2.5">
                        <button id="btn-confirm-session-logout" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Ya, Logout Perangkat Ini</button>
                        <button id="btn-cancel-session-modal" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
                    </div>
                </div>
            </div>

            <!-- Modal: Konfirmasi Logout All -->
            <div id="modal-logout-all" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
                <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-7 relative">
                    <button id="btn-close-all-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                    <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Logout Semua Perangkat?</h3>
                    <p class="text-sm text-gray-500 text-center mb-5">Semua sesi aktif selain perangkat ini akan dikeluarkan secara permanen.</p>
                    <div class="space-y-2.5">
                        <button id="btn-confirm-all-logout" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">Ya, Logout Semua</button>
                        <button id="btn-cancel-all-modal" class="w-full border border-gray-300 text-gray-700 font-semibold py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: NOTIFICATIONS --}}
        <div id="tab-notifications" class="tab-content hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-green-900">Notifications</h2>
                <p class="text-sm text-gray-500 mt-1">Choose what notifications you want to receive.</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
                @php
                $notifItems = [
                    ['title' => 'Pelamar Baru', 'desc' => 'Notifikasi saat ada pelamar baru mendaftar', 'default' => true],
                    ['title' => 'Jadwal Wawancara', 'desc' => 'Pengingat jadwal wawancara yang akan datang', 'default' => true],
                    ['title' => 'Kapasitas Loker Terpenuhi', 'desc' => 'Notifikasi saat lowongan sudah memenuhi kapasitas namun belum ditutup secara otomatis', 'default' => true],
                    ['title' => 'Batas Waktu Loker Berakhir', 'desc' => 'Notifikasi saat lowongan melewati batas waktu pendaftaran namun belum ditutup secara otomatis', 'default' => true],
                ];
                @endphp
                @foreach($notifItems as $item)
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $item['title'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $item['desc'] }}</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" {{ $item['default'] ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-700"></div>
                    </label>
                </div>
                @endforeach
            </div>
            <div class="flex justify-end mt-5">
                <button id="btn-save-notif" class="px-5 py-2 bg-green-900 text-white text-sm font-medium rounded-lg hover:bg-green-800 transition-colors">Save Preferences</button>
            </div>
        </div>

        {{-- TAB: LANGUAGE --}}
        <div id="tab-language" class="tab-content hidden">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-green-900">Language</h2>
                <p class="text-sm text-gray-500 mt-1">Set your preferred language for the interface.</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="grid grid-cols-2 gap-3 max-w-md">
                    <button class="lang-btn active-lang flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-green-700 bg-green-50 transition-all" data-lang="id">
                        <span class="text-xl">🇮🇩</span>
                        <span class="text-sm font-medium text-green-800">Bahasa Indonesia</span>
                        <svg class="w-4 h-4 text-green-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                    <button class="lang-btn flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all" data-lang="en">
                        <span class="text-xl">🇺🇸</span>
                        <span class="text-sm font-medium text-gray-600">English</span>
                    </button>
                </div>
                <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                    <button id="btn-save-lang" class="px-5 py-2 bg-green-900 text-white text-sm font-medium rounded-lg hover:bg-green-800 transition-colors">Save Language</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/hr/setting.js') }}"></script>
@endsection