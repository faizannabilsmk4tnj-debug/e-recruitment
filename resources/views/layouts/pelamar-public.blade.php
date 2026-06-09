<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — Portal Pelamar</title>
    @vite(['resources/css/app.css'])
    @yield('css')
</head>
<body class="min-h-screen bg-gray-200 flex flex-col">

    <!-- Navbar Pelamar (tanpa sidebar) -->
    <nav class="bg-[#15803d] px-16 py-3 flex items-center justify-between sticky top-0 z-50 shadow-sm border-b border-[#166534]">
        <div class="flex items-center gap-3">
            <a href="/pelamar/dashboard" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-green-50 hover:text-white text-sm transition-colors font-medium">Home</a>
            <a href="/pelamar/lowongan" class="text-white font-semibold text-sm hover:text-green-200 transition-colors">Vacancies</a>
            <a href="/tentang-kami" class="text-green-50 hover:text-white text-sm transition-colors font-medium">About Us</a>
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
    <footer class="bg-[#15803d] text-white px-16 py-8 shadow-sm border-t border-[#166534]">
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
</body>
</html>