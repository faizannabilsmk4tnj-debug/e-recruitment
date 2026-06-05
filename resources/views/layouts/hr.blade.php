<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HR Panel') — Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
</head>
<body class="bg-gray-50 min-h-screen font-sans">

    {{-- ============ TOP NAVBAR ============ --}}
    <header class="bg-green-900 text-white h-14 flex items-center px-5 gap-4 fixed top-0 left-0 right-0 z-50 shadow-lg">

        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
        </div>

        {{-- Page Title --}}
        <div class="flex-1">
            <h1 class="text-base font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
        </div>

        {{-- Right side --}}
        <div class="flex items-center gap-4">
            <a href="/hr/tim" class="text-sm text-green-200 hover:text-white font-medium transition-colors">HR Team</a>

            {{-- Notification --}}
            <div class="relative">
                <button id="btn-notif" onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')" class="relative text-green-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notif-badge" class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full text-[9px] flex items-center justify-center font-bold">4</span>
                </button>

                {{-- Dropdown Notif --}}
                <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800">Notifications</h3>
                        <span id="notif-header-count" class="text-[10px] text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded-full">4 New</span>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <!-- Notif Pelamar Baru -->
                        <a href="/hr/pelamar" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 font-medium">New Applicant Registered</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Ahmad Fauzi has applied for the <span class="font-semibold text-gray-700">Maintenance Staff</span> position.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">10 minutes ago</p>
                                </div>
                            </div>
                        </a>

                        <!-- Notif Jadwal Wawancara -->
                        <a href="/hr/wawancara" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 font-medium">Interview Schedule Reminder</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Interview with <span class="font-semibold text-gray-700">Siska Wijaya</span> will start at 11:30 AM.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">Just now</p>
                                </div>
                            </div>
                        </a>

                        <!-- Notif Kapasitas Loker Terpenuhi -->
                        <a href="/hr/lowongan" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 font-medium">Vacancy Capacity Reached</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Vacancy <span class="font-semibold text-gray-700">Senior Chemical Engineer</span> has reached the applicant limit but is not closed yet.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">2 hours ago</p>
                                </div>
                            </div>
                        </a>

                        <!-- Notif Batas Waktu Loker Berakhir -->
                        <a href="/hr/lowongan" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 font-medium">Vacancy Deadline Reached</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Vacancy <span class="font-semibold text-gray-700">Sustainability Officer</span> has passed the closing deadline but is not closed yet.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">Yesterday</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-100 text-center">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('notif-badge').classList.add('hidden'); document.getElementById('notif-header-count').innerText = '0 New';" class="text-xs font-semibold text-green-700 hover:text-green-900 transition-colors">Mark all as read</a>
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

            {{-- Help --}}
            <button class="text-green-200 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </button>

            {{-- Divider --}}
            <div class="w-px h-6 bg-green-700"></div>

            {{-- Avatar --}}
            <div class="relative">
                <div class="flex items-center gap-2 cursor-pointer group" onclick="document.getElementById('logout-dropdown').classList.toggle('hidden')">
                    <div class="text-right">
                        <div class="text-xs font-semibold text-white leading-none">Gilbert Blythe</div>
                        <div class="text-[10px] text-green-300 leading-none mt-0.5">HR Senior Manager</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-green-600 border-2 border-green-400 overflow-hidden flex items-center justify-center">
                        <span class="text-xs font-bold text-white">GB</span>
                    </div>
                </div>

                {{-- Dropdown Menu --}}
                <div id="logout-dropdown" class="hidden absolute right-0 mt-3 w-40 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-2 border-b border-gray-100 mb-1">
                        <p class="text-xs text-gray-500">Signed in as</p>
                        <p class="text-sm font-semibold text-gray-800 truncate">Gilbert Blythe</p>
                    </div>
                    <a href="/hr/login" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- ============ TAB NAVIGASI ============ --}}
    <nav class="bg-white border-b border-gray-200 fixed top-14 left-0 right-0 z-40 shadow-sm">
        <div class="flex items-center px-5 gap-1">
            <a href="/hr/dashboard"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-dashboard', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Dashboard
            </a>
            <a href="/hr/lowongan"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-lowongan', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Vacancies
            </a>
            <a href="/hr/pelamar"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-pelamar', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Applicants
            </a>
            <a href="/hr/wawancara"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-wawancara', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Interviews
            </a>

            <a href="/hr/laporan"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-laporan', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Reports
            </a>
            <a href="/hr/template-cv"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-template', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                CV Templates
            </a>

        </div>
    </nav>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="pt-28 min-h-screen">
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-green-950 text-white mt-16">
        <div class="px-8 py-10 grid grid-cols-3 gap-8">
            <div>
                <div class="text-sm font-bold text-white uppercase tracking-wider mb-3">Ecogreen Oleochemicals</div>
                <p class="text-xs text-green-300 leading-relaxed">
                    Leading global producer of naturally derived oleochemicals. Dedicated to sustainability, innovation, and excellence in HR management systems.
                </p>
            </div>
            <div>
                <div class="text-xs font-bold text-green-400 uppercase tracking-wider mb-3">Resources</div>
                <ul class="space-y-1.5">
                    <li><a href="#" class="text-xs text-green-300 hover:text-white transition-colors">Employee Handbook</a></li>
                    <li><a href="#" class="text-xs text-green-300 hover:text-white transition-colors">Corporate Policy</a></li>
                    <li><a href="#" class="text-xs text-green-300 hover:text-white transition-colors">Safety Guidelines</a></li>
                    <li><a href="#" class="text-xs text-green-300 hover:text-white transition-colors">IT Support</a></li>
                </ul>
            </div>
            <div>
                <div class="text-xs font-bold text-green-400 uppercase tracking-wider mb-3">Security</div>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-xs text-green-300">
                        <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        256-bit AES Encryption
                    </li>
                    <li class="flex items-center gap-2 text-xs text-green-300">
                        <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        ISO 27001 Certified
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-green-800 px-8 py-3 flex items-center justify-between">
            <span class="text-xs text-green-500">© 2024 PT Ecogreen Oleochemicals. All rights reserved.</span>
            <div class="flex gap-4">
                <a href="#" class="text-xs text-green-500 hover:text-green-300 transition-colors">Privacy Policy</a>
                <a href="#" class="text-xs text-green-500 hover:text-green-300 transition-colors">Terms of Service</a>
                <a href="#" class="text-xs text-green-500 hover:text-green-300 transition-colors">Cookie Settings</a>
            </div>
        </div>
    </footer>

    @yield('js')
    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const logoutDropdown = document.getElementById('logout-dropdown');
            const avatar = logoutDropdown.previousElementSibling;
            if (!avatar.contains(event.target) && !logoutDropdown.contains(event.target)) {
                logoutDropdown.classList.add('hidden');
            }

            const notifDropdown = document.getElementById('notif-dropdown');
            const notifBtn = document.getElementById('btn-notif');
            if (!notifBtn.contains(event.target) && !notifDropdown.contains(event.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>