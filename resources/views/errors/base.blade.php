<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .content-bg {
            background-color: #f1f5f2;
            background-image:
                radial-gradient(ellipse at 0% 0%, rgba(34, 197, 94, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 100% 100%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 30%, rgba(187, 247, 208, 0.15) 0%, transparent 40%);
            background-size: 100% 100%, 100% 100%, 100% 100%;
        }
    </style>
</head>
<body class="h-screen bg-gray-200 flex flex-col overflow-hidden font-sans">

    <!-- Header -->
    <nav style="background: #15803d !important; border-bottom: 2px solid #14532d !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08) !important;" class="px-6 md:px-16 py-3 flex items-center justify-between z-50 shrink-0">
        <div class="flex items-center gap-3">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="flex-1 content-bg flex flex-col items-center justify-center p-6 relative">
        <div class="relative bg-white rounded-2xl max-w-md w-full p-8 shadow-xl border border-gray-150 transform transition-all duration-300 flex flex-col items-center text-center">
            
            <!-- Error Icon Section -->
            <div class="mb-6">
                @yield('icon')
            </div>

            <!-- Error Code -->
            <h1 class="text-7xl font-extrabold text-green-950 tracking-tight mb-2">@yield('code')</h1>

            <!-- Error Headline -->
            <h2 class="text-xl font-bold text-gray-900 mb-4">@yield('headline')</h2>

            <!-- Error Description -->
            <p class="text-sm text-gray-600 leading-relaxed mb-8">
                @yield('description')
            </p>

            <!-- Action Buttons -->
            <div class="w-full flex flex-col gap-2.5">
                <button onclick="history.back()" class="inline-flex justify-center items-center w-full px-6 py-3 rounded-lg text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors shadow-sm gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Halaman Sebelumnya
                </button>
                
                @auth
                    @if(auth()->user()->role === 'hr' || auth()->user()->role === 'hr_master')
                        <a href="/hr/dashboard" class="inline-flex justify-center items-center w-full px-6 py-2.5 rounded-lg text-xs font-bold text-green-700 hover:text-green-800 bg-green-50 hover:bg-green-100 transition-colors gap-2">
                            Ke Dashboard HR
                        </a>
                    @else
                        <a href="/pelamar/dashboard" class="inline-flex justify-center items-center w-full px-6 py-2.5 rounded-lg text-xs font-bold text-green-700 hover:text-green-800 bg-green-50 hover:bg-green-100 transition-colors gap-2">
                            Ke Dashboard Pelamar
                        </a>
                    @endif
                @else
                    <a href="/" class="inline-flex justify-center items-center w-full px-6 py-2.5 rounded-lg text-xs font-bold text-green-700 hover:text-green-800 bg-green-50 hover:bg-green-100 transition-colors gap-2">
                        Ke Beranda Utama
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: #15803d !important; border-top: 2px solid #14532d !important; box-shadow: none !important;" class="text-white px-6 md:px-16 py-3 shrink-0 relative z-50">
        <div class="flex flex-col md:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto">
                <p class="text-green-50 text-[11px] border-l border-green-700/30 pl-4">© 2023 PT Ecogreen Oleochemicals</p>
            </div>
            <div class="flex flex-wrap gap-5 text-[11px] text-green-50">
                <a href="#" class="cursor-pointer hover:text-white hover:underline transition-colors relative z-50">Career Portal</a>
                <a href="#" class="cursor-pointer hover:text-white hover:underline transition-colors relative z-50">Help Center</a>
                <a href="#" class="cursor-pointer hover:text-white hover:underline transition-colors relative z-50">Terms & Privacy</a>
            </div>
        </div>
    </footer>

</body>
</html>
