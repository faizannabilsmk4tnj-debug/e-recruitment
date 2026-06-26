<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — Portal Pelamar</title>
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
<body class="min-h-screen bg-gray-200 flex flex-col">

    <!-- Navbar Pelamar (tanpa sidebar) -->
    <nav style="background: #15803d !important; border-bottom: 2px solid #14532d !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08) !important;" class="px-16 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <a href="/pelamar/dashboard" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-green-50 hover:text-white text-sm transition-colors font-medium">Home</a>
            <a href="/tentang-kami" class="text-green-50 hover:text-white text-sm transition-colors font-medium">About Us</a>
            <a href="/pelamar/lowongan" class="text-white font-semibold text-sm hover:text-green-200 transition-colors">Vacancies</a>
            <a href="/pelamar/profil" class="text-green-50 hover:text-white text-sm transition-colors font-medium">My Profile</a>
            <div class="w-9 h-9 bg-white rounded-full flex items-center justify-center text-[#15803d] font-bold text-sm ring-2 ring-[#89B184] overflow-hidden">
                <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.textContent='A';">
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: #15803d !important; border: none !important; box-shadow: none !important;" class="text-white px-16 py-8">
        <div class="flex items-start justify-between">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-10 w-auto mb-2">
                <h3 class="font-bold text-base">Ecogreen Careers</h3>
                <p class="text-green-50 text-sm mt-1">© 2024 PT Ecogreen Oleochemicals. Sustainable Excellence.</p>
            </div>
            <div class="flex gap-8 text-sm text-green-50">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
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