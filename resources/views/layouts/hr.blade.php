<!DOCTYPE html>
<html lang="id">
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
        <div class="flex items-center gap-2 min-w-[180px]">
            <div class="w-8 h-8 bg-white rounded flex items-center justify-center flex-shrink-0">
                <svg viewBox="0 0 32 32" class="w-6 h-6" fill="none">
                    <circle cx="16" cy="16" r="14" fill="#14532d"/>
                    <path d="M10 22 Q16 8 22 22" stroke="#4ade80" stroke-width="2.5" fill="none"/>
                    <circle cx="16" cy="13" r="3" fill="#4ade80"/>
                </svg>
            </div>
            <div class="leading-tight">
                <div class="text-xs font-bold text-white leading-none">Ecogreen</div>
                <div class="text-[10px] text-green-300 leading-none">Oleochemicals</div>
            </div>
        </div>

        {{-- Page Title --}}
        <div class="flex-1">
            <h1 class="text-base font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
        </div>

        {{-- Right side --}}
        <div class="flex items-center gap-4">
            <a href="/hr/tim" class="text-sm text-green-200 hover:text-white font-medium transition-colors">Tim HR</a>

            {{-- Notification --}}
            <button class="relative text-green-200 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full text-[9px] flex items-center justify-center font-bold">3</span>
            </button>

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
            <div class="flex items-center gap-2 cursor-pointer group">
                <div class="text-right">
                    <div class="text-xs font-semibold text-white leading-none">Gilbert Blythe</div>
                    <div class="text-[10px] text-green-300 leading-none mt-0.5">HR Senior Manager</div>
                </div>
                <div class="w-8 h-8 rounded-full bg-green-600 border-2 border-green-400 overflow-hidden flex items-center justify-center">
                    <span class="text-xs font-bold text-white">GB</span>
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
                Lowongan
            </a>
            <a href="/hr/pelamar"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-pelamar', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Pelamar
            </a>
            <a href="/hr/wawancara"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-wawancara', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Wawancara
            </a>
            <a href="/hr/laporan"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-laporan', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Laporan
            </a>
            <a href="/hr/template-cv"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-template', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Template CV
            </a>
            <a href="/hr/setting"
               class="px-4 py-3 text-sm font-medium transition-all border-b-2 whitespace-nowrap
                      @yield('nav-setting', 'text-gray-500 border-transparent hover:text-green-800 hover:border-green-300')">
                Setting
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
</body>
</html>