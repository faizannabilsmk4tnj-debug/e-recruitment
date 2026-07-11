<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HR Panel') — Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
    <style>
        header, footer, footer * { background: #15803d !important; background-image: none !important; }
        button[class*="bg-green-600"], button[class*="bg-green-700"], button[class*="bg-green-800"], button[class*="bg-green-900"], button[class*="bg-[#0f3c20]"], button[class*="bg-[#166534]"],
        a[class*="bg-green-600"], a[class*="bg-green-700"], a[class*="bg-green-800"], a[class*="bg-green-900"], a[class*="bg-[#0f3c20]"], a[class*="bg-[#166534]"] {
            background-color: #15803d !important;
            border-color: #15803d !important;
        }
        button[class*="bg-green-600"]:hover, button[class*="bg-green-700"]:hover, button[class*="bg-green-800"]:hover, button[class*="bg-green-900"]:hover, button[class*="bg-[#0f3c20]"]:hover, button[class*="bg-[#166534]"]:hover,
        a[class*="bg-green-600"]:hover, a[class*="bg-green-700"]:hover, a[class*="bg-green-800"]:hover, a[class*="bg-green-900"]:hover, a[class*="bg-[#0f3c20]"]:hover, a[class*="bg-[#166534]"]:hover {
            background-color: #166534 !important;
            border-color: #166534 !important;
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen font-sans">

    {{-- ============ TOP NAVBAR ============ --}}
    <header style="background: #15803d !important; border-bottom: 2px solid #14532d !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08) !important;" class="text-white px-16 py-3 flex items-center justify-between fixed top-0 left-0 right-0 z-50">

        {{-- Kiri: Logo --}}
        <div class="flex items-center gap-3">
            <a href="/hr/dashboard" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </div>

        {{-- Kanan: Nav Links + Icons + Avatar --}}
        <div class="flex items-center gap-6">

            {{-- Nav Links --}}
            @if(Auth::check() && Auth::user()->role === 'hr_master')
                <a href="/hr/tim" class="text-green-200 hover:text-white text-sm transition-colors font-medium hidden md:block">{{ __('hr_layout.hr_team') }}</a>
            @endif

            {{-- Notification --}}
            <div class="relative">
                <button id="btn-notif" onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')" class="relative text-green-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notif-badge" class="hidden absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full text-[9px] flex items-center justify-center font-bold text-white">0</span>
                </button>

                {{-- Dropdown Notif --}}
                <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800">{{ __('hr_layout.notifications') }}</h3>
                        <span id="notif-header-count" class="text-[10px] text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded-full">0 new</span>
                    </div>
                    <div id="notif-list" class="max-h-80 overflow-y-auto">
                        <div class="px-4 py-8 text-center text-xs text-gray-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Loading notifications...
                        </div>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-100 text-center">
                        <button id="btn-mark-all-read" onclick="markAllNotificationsRead()" class="text-xs font-semibold text-green-700 hover:text-green-900 transition-colors">{{ __('hr_layout.mark_all_read') }}</button>
                    </div>
                </div>
            </div>

            {{-- Settings --}}
            <a href="/hr/setting" class="text-green-200 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </a>

            {{-- Help / Guided Tour --}}
            <button id="btn-help-tour" onclick="sessionStorage.removeItem('hr-tour-done'); startHrTour();" class="w-8 h-8 bg-[#15803d] hover:bg-[#166534] rounded-full flex items-center justify-center text-white transition-colors" title="User Guide">
                <span class="text-sm font-bold">?</span>
            </button>

            {{-- Avatar --}}
            <div class="relative">
                <div class="flex items-center gap-2 cursor-pointer group" onclick="document.getElementById('logout-dropdown').classList.toggle('hidden')">
                    <div class="text-right">
                        <div class="text-xs font-semibold text-white leading-none">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-green-300 leading-none mt-0.5">{{ Auth::user()->job_title ?: 'HR Staff' }}</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-green-600 border-2 border-green-400 overflow-hidden flex items-center justify-center">
                        @if(Auth::check() && Auth::user()->avatar)
                            <img id="navbar-avatar-img" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @elseif(Auth::check() && Auth::user()->profile && Auth::user()->profile->avatar_url)
                            <img id="navbar-avatar-img" src="{{ Str::startsWith(Auth::user()->profile->avatar_url, ['http', '/']) ? Auth::user()->profile->avatar_url : asset('storage/' . Auth::user()->profile->avatar_url) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @else
                            @php
                                $words = explode(' ', Auth::user()->name ?? 'HR');
                                $initials = '';
                                foreach ($words as $w) {
                                    $initials .= strtoupper($w[0] ?? '');
                                }
                                $initials = substr($initials, 0, 2);
                            @endphp
                            <span id="navbar-avatar-initials" class="text-xs font-bold text-white">{{ $initials }}</span>
                        @endif
                    </div>
                </div>

                {{-- Dropdown Menu --}}
                <div id="logout-dropdown" class="hidden absolute right-0 mt-3 w-40 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-2 border-b border-gray-100 mb-1">
                        <p class="text-xs text-gray-500">{{ __('hr_layout.signed_in_as') }}</p>
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            {{ __('hr_layout.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>    {{-- ============ TAB NAVIGASI ============ --}}
    <nav class="bg-white border-b border-gray-200 fixed top-[72px] left-0 right-0 z-40 shadow-sm">
        <div class="flex items-center px-16 gap-1">
            <a href="/hr/dashboard" id="tab-dashboard"
               class="px-4 py-3 text-sm transition-all duration-200 border-b-2 whitespace-nowrap
                      {{ request()->is('hr') || request()->is('hr/dashboard') || request()->is('/') ? 'text-[#15803d] border-[#15803d] bg-green-50/40 rounded-t-lg font-semibold' : 'text-gray-500 border-transparent hover:text-[#15803d] hover:bg-gray-50/50 hover:border-gray-300 font-medium' }}">
                {{ __('hr_layout.nav.dashboard') }}
            </a>
            <a href="/hr/lowongan" id="tab-lowongan"
               class="px-4 py-3 text-sm transition-all duration-200 border-b-2 whitespace-nowrap
                      {{ request()->is('hr/lowongan*') ? 'text-[#15803d] border-[#15803d] bg-green-50/40 rounded-t-lg font-semibold' : 'text-gray-500 border-transparent hover:text-[#15803d] hover:bg-gray-50/50 hover:border-gray-300 font-medium' }}">
                {{ __('hr_layout.nav.vacancies') }}
            </a>
            <a href="/hr/pelamar" id="tab-pelamar"
               class="px-4 py-3 text-sm transition-all duration-200 border-b-2 whitespace-nowrap
                      {{ request()->is('hr/pelamar*') ? 'text-[#15803d] border-[#15803d] bg-green-50/40 rounded-t-lg font-semibold' : 'text-gray-500 border-transparent hover:text-[#15803d] hover:bg-gray-50/50 hover:border-gray-300 font-medium' }}">
                {{ __('hr_layout.nav.applicants') }}
            </a>
            <a href="/hr/wawancara" id="tab-wawancara"
               class="px-4 py-3 text-sm transition-all duration-200 border-b-2 whitespace-nowrap
                      {{ request()->is('hr/wawancara*') ? 'text-[#15803d] border-[#15803d] bg-green-50/40 rounded-t-lg font-semibold' : 'text-gray-500 border-transparent hover:text-[#15803d] hover:bg-gray-50/50 hover:border-gray-300 font-medium' }}">
                {{ __('hr_layout.nav.interviews') }}
            </a>
 
            <a href="/hr/laporan" id="tab-laporan"
               class="px-4 py-3 text-sm transition-all duration-200 border-b-2 whitespace-nowrap
                      {{ request()->is('hr/laporan*') ? 'text-[#15803d] border-[#15803d] bg-green-50/40 rounded-t-lg font-semibold' : 'text-gray-500 border-transparent hover:text-[#15803d] hover:bg-gray-50/50 hover:border-gray-300 font-medium' }}">
                {{ __('hr_layout.nav.reports') }}
            </a>
            <a href="/hr/template-cv" id="tab-template"
               class="px-4 py-3 text-sm transition-all duration-200 border-b-2 whitespace-nowrap
                      {{ request()->is('hr/template-cv*') ? 'text-[#15803d] border-[#15803d] bg-green-50/40 rounded-t-lg font-semibold' : 'text-gray-500 border-transparent hover:text-[#15803d] hover:bg-gray-50/50 hover:border-gray-300 font-medium' }}">
                {{ __('hr_layout.nav.cv_templates') }}
            </a>
        </div>
    </nav>v>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="pt-32 min-h-screen">
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white px-16 py-5 mt-16">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
                <div>
                    <p class="text-sm font-semibold text-white">Ecogreen Oleochemicals</p>
                    <p class="text-green-50 text-xs mt-0.5">© 2024 PT Ecogreen Oleochemicals. Sustainable Excellence.</p>
                </div>
            </div>
            <div class="flex gap-6 text-sm text-green-50">
                <button onclick="showInfoModal('privacy')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Privacy Policy</button>
                <button onclick="showInfoModal('terms')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Terms of Service</button>
                <button onclick="showInfoModal('sustainability')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Sustainability Report</button>
                <button onclick="showInfoModal('support')" class="hover:text-white transition-colors bg-transparent border-none p-0 cursor-pointer focus:outline-none">Contact Support</button>
            </div>
        </div>
    </footer>

    {{-- ============ GUIDED TOUR OVERLAY ============ --}}
    <div id="hr-tour-overlay" class="fixed inset-0 z-[70] hidden" style="pointer-events:none;">
        <!-- Dark backdrop with hole -->
        <svg id="hr-tour-backdrop" class="absolute inset-0 w-full h-full" style="pointer-events:all;">
            <defs>
                <mask id="hr-tour-mask">
                    <rect width="100%" height="100%" fill="white"/>
                    <rect id="hr-tour-hole" rx="12" fill="black"/>
                </mask>
            </defs>
            <rect width="100%" height="100%" fill="rgba(0,0,0,0.6)" mask="url(#hr-tour-mask)"/>
        </svg>

        <!-- Tooltip card -->
        <div id="hr-tour-tooltip" class="absolute bg-white rounded-xl shadow-2xl border border-gray-200 w-80 p-5 transition-all duration-300" style="pointer-events:all;">
            <!-- Progress -->
            <div class="flex items-center justify-between mb-3">
                <span id="hr-tour-step-label" class="text-[10px] font-bold text-green-700 uppercase tracking-widest"></span>
                <button id="hr-tour-skip" class="text-[10px] text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-wider font-medium">Skip</button>
            </div>
            <div class="h-1 bg-gray-100 rounded-full mb-4">
                <div id="hr-tour-progress" class="h-1 bg-green-600 rounded-full transition-all duration-500"></div>
            </div>
            <h3 id="hr-tour-title" class="font-bold text-gray-900 mb-1.5"></h3>
            <p id="hr-tour-desc" class="text-sm text-gray-500 leading-relaxed"></p>
            <!-- Nav -->
            <div class="flex items-center justify-between mt-5">
                <button id="hr-tour-prev" class="text-sm text-gray-400 hover:text-gray-700 transition-colors flex items-center gap-1 hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                    Back
                </button>
                <div></div>
                <button id="hr-tour-next" class="bg-green-800 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition-colors flex items-center gap-1">
                    Next
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>

    @yield('js')
    <script>
        // ===== NOTIFICATION SYSTEM =====
        const NOTIF_ICONS = {
            new_applicant: {
                bg: 'bg-blue-100', color: 'text-blue-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                link: '/hr/pelamar'
            },
            status_change: {
                bg: 'bg-green-100', color: 'text-green-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                link: '/hr/pelamar'
            },
            interview_scheduled: {
                bg: 'bg-purple-100', color: 'text-purple-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                link: '/hr/wawancara'
            },
            vacancy_deadline: {
                bg: 'bg-orange-100', color: 'text-orange-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                link: '/hr/lowongan'
            },
            vacancy_closed_auto: {
                bg: 'bg-red-100', color: 'text-red-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.36 18.36A9 9 0 115.64 5.64a9 9 0 0112.72 12.72zM12 9v4m0 4h.01"/>',
                link: '/hr/lowongan'
            },
            interview_reschedule_request: {
                bg: 'bg-amber-100', color: 'text-amber-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                link: '/hr/wawancara/daftar?status=rescheduled'
            },
            interview_declined: {
                bg: 'bg-red-100', color: 'text-red-600',
                svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                link: '/hr/wawancara'
            }
        };
        const NOTIF_DEFAULT = {
            bg: 'bg-gray-100', color: 'text-gray-600',
            svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
            link: '#'
        };

        function fetchNotifications() {
            fetch('/api/notifications?limit=10', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                renderNotifications(data.notifications, data.unread_count);
            })
            .catch(e => console.error('Failed to fetch notifications:', e));
        }

        function renderNotifications(notifications, unreadCount) {
            const badge = document.getElementById('notif-badge');
            const headerCount = document.getElementById('notif-header-count');
            const list = document.getElementById('notif-list');

            // Update badge
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }

            // Update header count
            headerCount.textContent = unreadCount + ' new';

            // Empty state
            if (!notifications || notifications.length === 0) {
                list.innerHTML = `<div class="px-4 py-8 text-center text-xs text-gray-400">
                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    No notifications
                </div>`;
                return;
            }

            let html = '';
            notifications.forEach((n, i) => {
                const icon = NOTIF_ICONS[n.type] || NOTIF_DEFAULT;
                const unreadBg = n.is_unread ? 'bg-green-50/50' : '';
                const unreadDot = n.is_unread ? '<div class="w-1.5 h-1.5 bg-green-500 rounded-full absolute top-3 right-3"></div>' : '';
                const borderClass = i < notifications.length - 1 ? 'border-b border-gray-50' : '';

                html += `<a href="${icon.link}" onclick="markNotifRead(event, ${n.id})" class="block px-4 py-3 hover:bg-gray-50 transition-colors ${borderClass} ${unreadBg} relative">
                    ${unreadDot}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full ${icon.bg} flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 ${icon.color}" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon.svg}</svg>
                        </div>
                        <div class="pr-3">
                            <p class="text-xs text-gray-800 font-medium">${escapeHtml(n.title)}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5">${escapeHtml(n.message)}</p>
                            <p class="text-[9px] text-gray-400 mt-1">${n.time_ago}</p>
                        </div>
                    </div>
                </a>`;
            });

            list.innerHTML = html;
        }

        function markNotifRead(event, notifId) {
            event.preventDefault();
            const targetUrl = event.currentTarget.getAttribute('href');
            
            fetch('/api/notifications/' + notifId + '/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(() => {
                if (targetUrl && targetUrl !== '#') {
                    if (window.location.pathname === targetUrl) {
                        window.location.reload();
                    } else {
                        window.location.href = targetUrl;
                    }
                }
            })
            .catch(() => {
                if (targetUrl && targetUrl !== '#') {
                    if (window.location.pathname === targetUrl) {
                        window.location.reload();
                    } else {
                        window.location.href = targetUrl;
                    }
                }
            });
        }

        function markAllNotificationsRead() {
            fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) fetchNotifications();
            })
            .catch(() => {});
        }

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        // Fetch on page load
        document.addEventListener('DOMContentLoaded', () => {
            fetchNotifications();
            // Auto-refresh every 60 seconds
            setInterval(fetchNotifications, 60000);
        });
    </script>
    <script>
        // ===== GUIDED TOUR =====
        const hrTourSteps = [
            {
                target: '#tab-dashboard',
                title: 'Welcome to the HR Panel!',
                desc: 'This is your Dashboard — the command center. View real-time recruitment statistics: active vacancies, today\'s applicants, and upcoming interviews at a glance.',
                pos: 'bottom'
            },
            {
                target: '#tab-lowongan',
                title: '1. Manage Vacancies',
                desc: 'Create, edit, and close job vacancies. Fill in the position title, department, location, requirements, and deadline. Publish when ready or save as Draft.',
                pos: 'bottom'
            },
            {
                target: '#tab-pelamar',
                title: '2. Review Applicants',
                desc: 'View all applicant data in one place. Search by name or position, filter by status, review CVs and documents, and update the recruitment stage (e.g. Review → Interview → Hired).',
                pos: 'bottom'
            },
            {
                target: '#tab-wawancara',
                title: '3. Schedule Interviews',
                desc: 'Set up interview sessions for shortlisted candidates. Choose Online or Offline, assign interviewers, and add meeting links. Candidates receive email notifications automatically.',
                pos: 'bottom'
            },
            {
                target: '#tab-laporan',
                title: '4. Reports & Analytics',
                desc: 'Export recruitment data to Excel/CSV. Analyze key metrics: Time-to-Hire, Source of Hire, and applicant conversion funnel for management reports.',
                pos: 'bottom'
            },
            {
                target: '#tab-template',
                title: '5. CV Templates',
                desc: 'Customize the generated CV layout for applicants. Adjust the letterhead design, section order (e.g. Experience before Education), and add the company logo to exported PDFs.',
                pos: 'bottom'
            },
            {
                target: '#btn-help-tour',
                title: '6. Replay This Guide',
                desc: 'Click the "?" button anytime to replay this guided tour. You can always come back to learn how each feature works.',
                pos: 'bottom-left'
            }
        ];

        let hrTourCurrent = 0;
        const hrTourPad = 8;

        function startHrTour() {
            hrTourCurrent = 0;
            const overlay = document.getElementById('hr-tour-overlay');
            overlay.classList.remove('hidden');
            showHrTourStep(0);
        }

        function showHrTourStep(i) {
            const step = hrTourSteps[i];
            const el = document.querySelector(step.target);
            if (!el) return;

            const overlay = document.getElementById('hr-tour-overlay');
            const hole = document.getElementById('hr-tour-hole');
            const tooltip = document.getElementById('hr-tour-tooltip');
            const titleEl = document.getElementById('hr-tour-title');
            const descEl = document.getElementById('hr-tour-desc');
            const labelEl = document.getElementById('hr-tour-step-label');
            const progressEl = document.getElementById('hr-tour-progress');
            const btnNext = document.getElementById('hr-tour-next');
            const btnPrev = document.getElementById('hr-tour-prev');

            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            setTimeout(() => {
                const rect = el.getBoundingClientRect();

                // Spotlight hole
                hole.setAttribute('x', rect.left - hrTourPad);
                hole.setAttribute('y', rect.top - hrTourPad);
                hole.setAttribute('width', rect.width + hrTourPad * 2);
                hole.setAttribute('height', rect.height + hrTourPad * 2);

                // Highlight target
                el.style.position = 'relative';
                el.style.zIndex = '71';
                el.style.pointerEvents = 'none';

                // Position tooltip
                const tooltipWidth = 320;
                if (step.pos === 'bottom') {
                    tooltip.style.left = Math.max(8, Math.min(rect.left, window.innerWidth - tooltipWidth - 16)) + 'px';
                    tooltip.style.top = (rect.bottom + 16) + 'px';
                } else if (step.pos === 'bottom-left') {
                    tooltip.style.left = Math.max(8, rect.right - tooltipWidth) + 'px';
                    tooltip.style.top = (rect.bottom + 16) + 'px';
                } else if (step.pos === 'right') {
                    tooltip.style.left = (rect.right + 16) + 'px';
                    tooltip.style.top = Math.max(8, rect.top - 10) + 'px';
                }

                // Content
                titleEl.textContent = step.title;
                descEl.textContent = step.desc;
                labelEl.textContent = 'Step ' + (i + 1) + ' of ' + hrTourSteps.length;
                progressEl.style.width = ((i + 1) / hrTourSteps.length * 100) + '%';

                btnPrev.classList.toggle('hidden', i === 0);
                if (i === hrTourSteps.length - 1) {
                    btnNext.innerHTML = 'Get Started! <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
                } else {
                    btnNext.innerHTML = 'Next <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>';
                }
            }, 300);
        }

        function clearHrTourHighlights() {
            hrTourSteps.forEach(s => {
                const el = document.querySelector(s.target);
                if (el) { el.style.position = ''; el.style.zIndex = ''; el.style.pointerEvents = ''; }
            });
        }

        function closeHrTour() {
            clearHrTourHighlights();
            document.getElementById('hr-tour-overlay').classList.add('hidden');
            sessionStorage.setItem('hr-tour-done', '1');
        }

        document.getElementById('hr-tour-next').addEventListener('click', () => {
            clearHrTourHighlights();
            if (hrTourCurrent < hrTourSteps.length - 1) { hrTourCurrent++; showHrTourStep(hrTourCurrent); }
            else closeHrTour();
        });

        document.getElementById('hr-tour-prev').addEventListener('click', () => {
            if (hrTourCurrent > 0) { clearHrTourHighlights(); hrTourCurrent--; showHrTourStep(hrTourCurrent); }
        });

        document.getElementById('hr-tour-skip').addEventListener('click', closeHrTour);

        // Auto-start tour on first visit
        document.addEventListener('DOMContentLoaded', function() {
            if (!sessionStorage.getItem('hr-tour-done')) {
                setTimeout(() => startHrTour(), 800);
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const logoutDropdown = document.getElementById('logout-dropdown');
            if (logoutDropdown) {
                const avatar = logoutDropdown.previousElementSibling;
                if (avatar && !avatar.contains(event.target) && !logoutDropdown.contains(event.target)) {
                    logoutDropdown.classList.add('hidden');
                }
            }

            const notifDropdown = document.getElementById('notif-dropdown');
            const notifBtn = document.getElementById('btn-notif');
            if (notifBtn && !notifBtn.contains(event.target) && !notifDropdown.contains(event.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    </script>
    <script>
        // Force footer background to match header exactly
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            const footer = document.querySelector('footer');
            if (header && footer) {
                const headerBg = getComputedStyle(header).backgroundColor;
                footer.style.setProperty('background', headerBg, 'important');
                footer.style.setProperty('background-color', headerBg, 'important');
                footer.style.setProperty('background-image', 'none', 'important');
                footer.querySelectorAll('*').forEach(function(el) {
                    const elBg = getComputedStyle(el).backgroundColor;
                    if (elBg !== 'rgba(0, 0, 0, 0)' && elBg !== 'transparent' && elBg !== headerBg) {
                        el.style.setProperty('background', headerBg, 'important');
                        el.style.setProperty('background-color', headerBg, 'important');
                        el.style.setProperty('background-image', 'none', 'important');
                    }
                });
            }
        });
    </script>
    <!-- Generic Information Modal -->
    <div id="info-modal" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[85vh]">
            <!-- Header -->
            <div class="bg-[#15803d] px-6 py-4 flex items-center justify-between text-white shrink-0">
                <h3 id="info-modal-title" class="font-bold text-base">Information</h3>
                <button id="btn-close-info" class="text-green-200 hover:text-white transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <!-- Body -->
            <div class="px-6 py-5 overflow-y-auto text-sm text-gray-600 leading-relaxed" id="info-modal-body">
                <!-- Dynamic Content -->
            </div>
            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end shrink-0">
                <button id="btn-close-info-footer" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl text-xs transition-colors focus:outline-none">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Deactivated Modal -->
    <div id="deactivated-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl border border-gray-100 transform scale-95 transition-transform duration-300 mx-4">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center mb-3">Account Deactivated</h3>
            <p class="text-gray-500 text-sm text-center leading-relaxed mb-6">
                Your account has been deactivated by <strong>HR Master</strong>. After closing this notification, you will be automatically logged out and returned to the login page. You cannot log back in until HR Master reactivates your HR account.
            </p>
            <button id="btn-confirm-deactivated" class="w-full bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold py-3 rounded-xl transition-all duration-200 text-sm shadow-lg shadow-red-100 focus:outline-none">
                I Understand & Logout
            </button>
        </div>
    </div>

    <script>
        function showDeactivatedModal() {
            const modal = document.getElementById('deactivated-modal');
            if (modal) {
                modal.classList.remove('hidden');
                // Trigger reflow to apply transitions
                modal.offsetHeight;
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                const dialog = modal.querySelector('div');
                if (dialog) {
                    dialog.classList.remove('scale-95');
                    dialog.classList.add('scale-100');
                }
            }
        }

        document.getElementById('btn-confirm-deactivated').addEventListener('click', function() {
            window.location.href = '{{ route('hr.logout-deactivated') }}';
        });

        // Global Fetch Interceptor to catch deactivation on any AJAX actions
        const originalFetch = window.fetch;
        window.fetch = async function(...args) {
            const response = await originalFetch(...args);
            if (response.status === 403) {
                try {
                    const clone = response.clone();
                    const data = await clone.json();
                    if (data && data.redirect) {
                        if (data.is_deleted) {
                            window.location.href = data.redirect;
                        } else {
                            showDeactivatedModal();
                        }
                        // Return fake response to suppress individual alert boxes in calling JS
                        return new Response(JSON.stringify({ success: false, message: 'Account deactivated.' }), {
                            status: 200,
                            headers: { 'Content-Type': 'application/json' }
                        });
                    }
                } catch (e) {
                    // Not JSON or doesn't have redirect
                }
            }
            return response;
        };
    </script>
    <script>
        // ===== FOOTER MODALS LOGIC =====
        const infoContent = {
            privacy: {
                title: 'Privacy Policy',
                body: `
                    <p class="mb-3">PT Ecogreen Oleochemicals is committed to maintaining the confidentiality and security of your personal data as a job applicant.</p>
                    <p class="mb-3"><strong>1. Data Collection:</strong> We collect personal data that you enter voluntarily, such as your name, email address, telephone number, education history, employment history, as well as CV files and other supporting certificates.</p>
                    <p class="mb-3"><strong>2. Data Usage:</strong> Your data will only be used for the employee selection process, contacting you regarding interview stages, and professional background verification.</p>
                    <p class="mb-3"><strong>3. Data Protection:</strong> We implement technical and organizational security standards to protect your personal data from unauthorized access, loss, or manipulation by third parties.</p>
                    <p>If you have questions regarding your data, please contact our recruitment team through the help menu.</p>
                `
            },
            terms: {
                title: 'Terms of Service',
                body: `
                    <p class="mb-3">Welcome to the PT Ecogreen Oleochemicals E-Recruitment Portal. By accessing and registering on this portal, you agree to comply with the following terms:</p>
                    <p class="mb-3"><strong>1. Accuracy of Information:</strong> You declare that all data, CVs, job information, and documents you upload are true, accurate, and do not manipulate any information.</p>
                    <p class="mb-3"><strong>2. Account Security:</strong> You are fully responsible for maintaining the confidentiality of your recruitment account password and the activities that occur under that account.</p>
                    <p class="mb-3"><strong>3. Prohibition of Misuse:</strong> You are prohibited from using this portal for illegal actions, hacking security systems, spreading spam, or uploading dangerous documents (such as malware).</p>
                    <p>Violations of these terms and conditions may result in the unilateral cancellation of your application process and account deactivation.</p>
                `
            },
            sustainability: {
                title: 'Sustainability Report',
                body: `
                    <p class="mb-3">As one of the world's leading natural fatty alcohol manufacturers, PT Ecogreen Oleochemicals places sustainability as a main pillar of our operations.</p>
                    <p class="mb-3"><strong>1. Responsible Sourcing:</strong> We are fully committed to using sustainable palm oil raw materials and complying with RSPO (Roundtable on Sustainable Palm Oil) certification standards.</p>
                    <p class="mb-3"><strong>2. Environmental Management:</strong> Our plants implement ISO 14001 certified environmental management systems to minimize carbon emissions, optimize water recycling, and manage production waste responsibly.</p>
                    <p class="mb-3"><strong>3. Social Responsibility:</strong> We support the welfare of local communities around our operational areas through sustainable CSR programs and local workforce empowerment.</p>
                    <p>The complete Sustainability Report can be accessed officially through our main corporate website at <a href="https://www.ecogreenoleo.com" target="_blank" class="text-green-700 underline font-semibold">www.ecogreenoleo.com</a>.</p>
                `
            },
            support: {
                title: 'Contact Support',
                body: `
                    <p class="mb-3">If you experience technical difficulties (such as difficulty registering, uploading documents, or not receiving a password reset email), our team is ready to help you.</p>
                    <p class="mb-3"><strong>Contact Us Via:</strong></p>
                    <ul class="list-style-none mb-3 space-y-1">
                        <li><strong>HR Team Email:</strong> <a href="mailto:career@ecogreenoleo.com" class="text-green-700 underline font-medium">career@ecogreenoleo.com</a></li>
                        <li><strong>Phone (Batam Head Office):</strong> +62 778 711 777</li>
                        <li><strong>Address:</strong> Kavling 1 Kabil, Nongsa, Batam City, Riau Islands, Indonesia</li>
                    </ul>
                    <p class="text-xs text-gray-500">Support services are available on business days (Monday - Friday) from 08:00 to 17:00 WIB.</p>
                `
            }
        };

        const infoModal = document.getElementById('info-modal');
        const infoTitle = document.getElementById('info-modal-title');
        const infoBody = document.getElementById('info-modal-body');
        const btnCloseInfo = document.getElementById('btn-close-info');
        const btnCloseInfoFooter = document.getElementById('btn-close-info-footer');

        window.showInfoModal = function(type) {
            if (infoContent[type]) {
                infoTitle.textContent = infoContent[type].title;
                infoBody.innerHTML = infoContent[type].body;
                infoModal.classList.remove('hidden');
            }
        };

        function closeInfoModal() {
            infoModal.classList.add('hidden');
        }

        if (btnCloseInfo) btnCloseInfo.addEventListener('click', closeInfoModal);
        if (btnCloseInfoFooter) btnCloseInfoFooter.addEventListener('click', closeInfoModal);
        if (infoModal) {
            infoModal.addEventListener('click', function(e) {
                if (e.target === infoModal) closeInfoModal();
            });
        }
    </script>

    <!-- Custom Elegant Alert Modal -->
    <div id="custom-alert-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[99999] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-gray-100 transform scale-95 transition-transform duration-300 mx-4">
            <div class="flex items-center gap-3.5 mb-4">
                <div id="custom-alert-icon" class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Notification</h3>
            </div>
            <p id="custom-alert-message" class="text-gray-600 text-sm leading-relaxed mb-6"></p>
            <button id="btn-close-custom-alert" class="w-full bg-[#15803d] hover:bg-[#166534] active:bg-[#14532d] text-white font-semibold py-3 rounded-xl transition-all duration-200 text-xs shadow-lg shadow-green-100 focus:outline-none">
                OK
            </button>
        </div>
    </div>

    <script>
        // Global override for native window.alert
        (function() {
            const originalAlert = window.alert;
            window._originalAlert = originalAlert;

            window.alert = function(message) {
                const modal = document.getElementById('custom-alert-modal');
                const msgEl = document.getElementById('custom-alert-message');
                const btn = document.getElementById('btn-close-custom-alert');
                const iconContainer = document.getElementById('custom-alert-icon');

                if (!modal || !msgEl || !btn) {
                    originalAlert(message);
                    return;
                }

                // Dynamic icon logic based on message content
                if (iconContainer) {
                    const lowerMsg = message.toLowerCase();
                    if (lowerMsg.includes('category') || lowerMsg.includes('kategori')) {
                        // Briefcase / Work Icon
                        iconContainer.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        `;
                    } else if (lowerMsg.includes('location') || lowerMsg.includes('lokasi') || lowerMsg.includes('tempat')) {
                        // Location Pin Icon
                        iconContainer.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        `;
                    } else {
                        // Default Checkmark / Info Icon
                        iconContainer.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        `;
                    }
                }

                msgEl.textContent = message;
                modal.classList.remove('hidden');
                
                // Force reflow
                modal.offsetHeight;
                
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                
                const dialog = modal.querySelector('div');
                if (dialog) {
                    dialog.classList.remove('scale-95');
                    dialog.classList.add('scale-100');
                }

                // Focus OK button for keyboard navigation
                setTimeout(() => btn.focus(), 50);

                return new Promise((resolve) => {
                    const onClose = function() {
                        modal.classList.remove('opacity-100');
                        modal.classList.add('opacity-0');
                        if (dialog) {
                            dialog.classList.remove('scale-100');
                            dialog.classList.add('scale-95');
                        }
                        setTimeout(() => {
                            modal.classList.add('hidden');
                            resolve();
                        }, 300);
                        btn.removeEventListener('click', onClose);
                    };
                    btn.addEventListener('click', onClose);
                });
            };
        })();
    </script>

    @if(Auth::check() && !Auth::user()->is_active)
    <script>
        window.addEventListener('load', function() {
            setTimeout(showDeactivatedModal, 150);
        });
    </script>
    @endif
</body>
</html>
