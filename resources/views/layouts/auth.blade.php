<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') — PT Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
    <style>
        .bg-gradient-eco {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #cbd5e1 100%);
        }
        .green-blob-left {
            position: absolute;
            top: 10%;
            left: -5%;
            width: 400px;
            height: 500px;
            background: radial-gradient(ellipse, rgba(187, 247, 208, 0.4) 0%, transparent 70%);
            pointer-events: none;
        }
        .green-blob-right {
            position: absolute;
            top: 5%;
            right: -5%;
            width: 450px;
            height: 600px;
            background: radial-gradient(ellipse, rgba(187, 247, 208, 0.3) 0%, transparent 70%);
            pointer-events: none;
        }
        .green-blob-bottom {
            position: absolute;
            bottom: 10%;
            right: 10%;
            width: 350px;
            height: 400px;
            background: radial-gradient(ellipse, rgba(220, 252, 231, 0.5) 0%, transparent 70%);
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-gray-200">

    <!-- Navbar -->
    <nav style="background-color: #15803d !important; border-color: #15803d !important; box-shadow: none !important;" class="px-10 py-3 flex items-center justify-between relative z-50 border-b">
        <div class="flex items-center gap-3">
            <!-- Logo + Company Name -->
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-12 w-auto">
            </a>
        </div>
        <div class="flex items-center gap-6">
            <a href="/" class="text-green-50 hover:text-white text-sm transition-colors font-medium">Home</a>
            <a href="/tentang-kami" class="text-green-50 hover:text-white text-sm transition-colors font-medium">About Us</a>
            <!-- Help Icon -->
            <a href="#" class="text-white hover:text-green-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                    <path d="M12 17h.01"/>
                </svg>
            </a>
            @yield('nav-right')
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 relative overflow-hidden bg-gradient-eco">
        <!-- Decorative blobs -->
        <div class="green-blob-left"></div>
        <div class="green-blob-right"></div>
        <div class="green-blob-bottom"></div>

        <div class="relative z-10 flex items-center justify-center py-12 px-4">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer style="background-color: #15803d !important; border-color: #15803d !important; box-shadow: none !important;" class="text-white py-4 px-8 relative z-50 border-t">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PT Ecogreen" class="h-8 w-auto">
                <div>
                    <h3 class="font-semibold text-sm text-white">@yield('footer-title', 'PT Ecogreen Oleochemicals')</h3>
                    <p class="text-green-50 text-xs mt-0.5">© 2024 PT Ecogreen Oleochemicals. All rights reserved.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-green-50">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-white transition-colors">Sustainability Report</a>
                <a href="#" class="hover:text-white transition-colors">Contact Support</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>