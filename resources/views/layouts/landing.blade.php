<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
    @yield('css')
</head>
<body class="min-h-screen flex flex-col bg-white">

    <!-- Navbar -->
    <nav class="bg-green-900 px-16 py-3 flex items-center justify-between relative z-50">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
                <span class="text-white font-bold text-sm">PT Eco green Oleochemicals</span>
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-sm transition-colors @yield('nav-beranda', 'text-green-300 hover:text-white')">Beranda</a>
            <a href="/lowongan" class="text-sm transition-colors @yield('nav-lowongan', 'text-green-300 hover:text-white')">Lowongan</a>
            <a href="/tentang-kami" class="text-sm transition-colors text-green-300 hover:text-white">Tentang Kami</a>
            <a href="/register" class="border border-white text-white text-sm font-semibold px-5 py-2 rounded-lg hover:bg-white hover:text-green-900 transition-colors">
                Daftar
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-950 text-white px-16 py-8">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="font-bold text-base">Ecogreen Careers</h3>
                <p class="text-green-400 text-sm mt-1">© 2024 PT Ecogreen Oleochemicals. Sustainable Excellence.</p>
            </div>
            <div class="flex gap-8 text-sm text-green-300">
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
            <h2 class="text-xl font-bold text-gray-900 mb-2">Anda Belum Login</h2>
            <p class="text-sm text-gray-500 mb-8">Silahkan masukkan akun Anda atau jika belum punya silahkan mendaftar.</p>
            <!-- Buttons -->
            <div class="space-y-3">
                <a href="/login" class="block w-full bg-green-800 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-sm transition-colors">
                    Login
                </a>
                <a href="/register" class="block w-full border border-gray-300 text-gray-700 font-semibold py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                    Daftar
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
</body>
</html>