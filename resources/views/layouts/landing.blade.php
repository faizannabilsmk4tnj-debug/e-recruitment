<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
    @yield('css')
    <style>
        body > nav, body > footer, body > footer * { background: #15803d !important; background-image: none !important; }
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
<body class="min-h-screen flex flex-col bg-gray-200">

    <!-- Navbar -->
    <nav style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="px-16 py-3 flex items-center justify-between relative z-50">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-sm transition-colors font-medium @yield('nav-beranda', 'text-green-50 hover:text-white')">Home</a>
            <a href="/lowongan" class="text-sm transition-colors font-medium @yield('nav-lowongan', 'text-green-50 hover:text-white')">Vacancies</a>
            <a href="/tentang-kami" class="text-sm transition-colors font-medium text-green-50 hover:text-white">About Us</a>
            <div class="flex items-center gap-2">
                <a href="/login" class="border border-white bg-white text-[#15803d] text-sm font-semibold px-5 py-2 rounded-lg hover:bg-green-50 transition-colors">
                    Sign In
                </a>
                <a href="/register" class="border border-white text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-white hover:text-[#15803d] transition-colors">
                    Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white px-16 py-5">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
                <div>
                    <p class="text-sm font-semibold text-white">Ecogreen Oleochemicals</p>
                    <p class="text-green-50 text-xs mt-0.5">© 2024 PT Ecogreen Oleochemicals. Sustainable Excellence.</p>
                </div>
            </div>
            <div class="flex gap-6 text-sm text-green-50">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">Cookie Settings</a>
                <a href="#" class="hover:text-white transition-colors">Sustainability Report</a>
            </div>
        </div>
    </footer>

    <!-- Login Prompt Modal -->
    <div id="modal-login-prompt" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl w-full max-w-sm mx-4 p-8 text-center relative">
            <!-- Close -->
            <button onclick="document.getElementById('modal-login-prompt').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            <!-- Icon -->
            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" x2="12" y1="8" y2="12"/>
                    <line x1="12" x2="12.01" y1="16" y2="16"/>
                </svg>
            </div>
            <!-- Title -->
            <h2 class="text-xl font-bold text-gray-900 mb-2">You Are Not Logged In</h2>
            <p class="text-sm text-gray-500 mb-8">Please login to your account or register if you don't have one.</p>
            <!-- Buttons -->
            <div class="space-y-3">
                <a href="/login" class="block w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors">
                    Sign In
                </a>
                <a href="/register" class="block w-full border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Register
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Global login prompt function
        function showLoginPrompt(e) {
            if (e) e.preventDefault();
            document.getElementById('modal-login-prompt').classList.remove('hidden');
        }
        // Close on overlay click
        document.getElementById('modal-login-prompt')?.addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
        // Attach to all elements with data-auth-required
        document.querySelectorAll('[data-auth-required]').forEach(el => {
            el.addEventListener('click', showLoginPrompt);
        });
    </script>
    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.querySelector('body > nav');
            const footer = document.querySelector('body > footer');
            if (nav && footer) {
                const navBg = getComputedStyle(nav).backgroundColor;
                footer.style.setProperty('background', navBg, 'important');
                footer.style.setProperty('background-color', navBg, 'important');
                footer.style.setProperty('background-image', 'none', 'important');
                footer.querySelectorAll('*').forEach(function(el) {
                    const elBg = getComputedStyle(el).backgroundColor;
                    if (elBg !== 'rgba(0, 0, 0, 0)' && elBg !== 'transparent' && elBg !== navBg) {
                        el.style.setProperty('background', navBg, 'important');
                        el.style.setProperty('background-color', navBg, 'important');
                        el.style.setProperty('background-image', 'none', 'important');
                    }
                });
            }
        });
    </script>
</body>
</html>