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
            <a href="/" class="text-green-200 hover:text-white text-sm transition-colors font-medium hidden md:block">Home</a>
            <a href="/tentang-kami" class="text-green-200 hover:text-white text-sm transition-colors font-medium hidden md:block">About Us</a>
            <a href="/hr/tim" class="text-green-200 hover:text-white text-sm transition-colors font-medium hidden md:block">{{ __('hr_layout.hr_team') }}</a>

            {{-- Notification --}}
            <div class="relative">
                <button id="btn-notif" onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')" class="relative text-green-200 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notif-badge" class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full text-[9px] flex items-center justify-center font-bold text-white">4</span>
                </button>

                {{-- Dropdown Notif --}}
                <div id="notif-dropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800">{{ __('hr_layout.notifications') }}</h3>
                        <span id="notif-header-count" class="text-[10px] text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded-full">{{ __('hr_layout.new_count', ['count' => 4]) }}</span>
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
                                    <p class="text-xs text-gray-800 font-medium">Interview Schedule</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Budi Santoso is ready for HR interview at 14:00.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">1 hour ago</p>
                                </div>
                            </div>
                        </a>

                        <!-- Notif Penilaian -->
                        <a href="/hr/penilaian" class="block px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 font-medium">Assessment Completed</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">Siti Aminah has finished technical test with score 85.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">2 hours ago</p>
                                </div>
                            </div>
                        </a>

                        <!-- Notif Lowongan -->
                        <a href="/hr/lowongan" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-800 font-medium">Vacancy Closing Soon</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">IT Support vacancy will expire in 2 days.</p>
                                    <p class="text-[9px] text-gray-400 mt-1">1 day ago</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="px-4 py-2 border-t border-gray-100 text-center">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('notif-badge').classList.add('hidden'); document.getElementById('notif-header-count').innerText = '{{ __('hr_layout.new_count', ['count' => 0]) }}';" class="text-xs font-semibold text-green-700 hover:text-green-900 transition-colors">{{ __('hr_layout.mark_all_read') }}</a>
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
                            <img id="navbar-avatar-img" src="{{ Auth::user()->profile->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
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
    </header>

    {{-- ============ TAB NAVIGASI ============ --}}
    <nav class="bg-white border-b border-gray-200 fixed top-[72px] left-0 right-0 z-40 shadow-sm">
        <div class="flex items-center px-16 gap-1">
            <a href="/hr/dashboard" id="tab-dashboard"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-dashboard', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                {{ __('hr_layout.nav.dashboard') }}
            </a>
            <a href="/hr/lowongan" id="tab-lowongan"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-lowongan', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                {{ __('hr_layout.nav.vacancies') }}
            </a>
            <a href="/hr/pelamar" id="tab-pelamar"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-pelamar', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                {{ __('hr_layout.nav.applicants') }}
            </a>
            <a href="/hr/wawancara" id="tab-wawancara"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-wawancara', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                {{ __('hr_layout.nav.interviews') }}
            </a>

            <a href="/hr/laporan" id="tab-laporan"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-laporan', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                {{ __('hr_layout.nav.reports') }}
            </a>
            <a href="/hr/template-cv" id="tab-template"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-template', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                {{ __('hr_layout.nav.cv_templates') }}
            </a>

        </div>
    </nav>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="pt-32 min-h-screen">
        @yield('content')
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white mt-16">
        <div class="px-16 py-10 grid grid-cols-3 gap-8">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-10 w-auto mb-3">
                <div class="text-sm font-bold text-white uppercase tracking-wider mb-3">Ecogreen Oleochemicals</div>
                <p class="text-xs text-green-50 leading-relaxed">
                    Leading global producer of naturally derived oleochemicals. Dedicated to sustainability, innovation, and excellence in HR management systems.
                </p>
            </div>
            <div>
                <div class="text-xs font-bold text-white uppercase tracking-wider mb-3">Resources</div>
                <ul class="space-y-1.5">
                    <li><a href="#" class="text-xs text-green-50 hover:text-white transition-colors">Employee Handbook</a></li>
                    <li><a href="#" class="text-xs text-green-50 hover:text-white transition-colors">Corporate Policy</a></li>
                    <li><a href="#" class="text-xs text-green-50 hover:text-white transition-colors">Safety Guidelines</a></li>
                    <li><a href="#" class="text-xs text-green-50 hover:text-white transition-colors">IT Support</a></li>
                </ul>
            </div>
            <div>
                <div class="text-xs font-bold text-white uppercase tracking-wider mb-3">Security</div>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-xs text-green-50">
                        <svg class="w-3.5 h-3.5 text-green-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        256-bit AES Encryption
                    </li>
                    <li class="flex items-center gap-2 text-xs text-green-50">
                        <svg class="w-3.5 h-3.5 text-green-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        ISO 27001 Certified
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-green-700/30 px-16 py-3 flex items-center justify-between">
            <span class="text-xs text-green-50">© 2024 PT Ecogreen Oleochemicals. All rights reserved.</span>
            <div class="flex gap-4">
                <a href="#" class="text-xs text-green-50 hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="text-xs text-green-50 hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="text-xs text-green-50 hover:text-white transition-colors">Cookie Settings</a>
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
</body>
</html>
