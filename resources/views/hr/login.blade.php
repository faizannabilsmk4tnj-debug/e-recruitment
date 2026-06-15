<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Login — Ecogreen Oleochemicals</title>
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="min-h-screen bg-green-950 flex flex-col">

    <!-- NAVBAR -->
    <header class="bg-green-900 px-8 py-3.5 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto">
        </div>
        <span class="text-xs text-green-300 font-medium tracking-widest uppercase">HR Portal</span>
    </header>

    <!-- MAIN -->
    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

                <!-- Card Header -->
                <div class="bg-green-900 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-green-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white leading-none">HR Staff Login</h1>
                            <p class="text-xs text-green-300 mt-0.5">Akses khusus tim HR & Rekrutmen</p>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="px-8 py-7">

                    <!-- Alert Error -->
                    <div id="alert-error" class="hidden mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span id="alert-error-text" class="text-xs font-medium"></span>
                    </div>

                    <div class="space-y-5">

                        <!-- Email -->
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Email HR</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <input type="email" id="hr-email" placeholder="nama@ecogreen.com" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition-all">
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Password</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <input type="password" id="hr-password" placeholder="••••••••" class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition-all">
                                <button type="button" id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg id="eye-off-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="hr-remember" class="w-3.5 h-3.5 rounded border-gray-300 text-green-700 focus:ring-green-500">
                                <span class="text-xs text-gray-500">Remember me</span>
                            </label>
                            <button type="button" id="btn-forgot" class="text-xs text-green-700 hover:text-green-900 font-medium transition-colors">Forgot password?</button>
                        </div>

                        <!-- Login Button -->
                        <button id="btn-login" class="w-full py-2.5 bg-green-900 hover:bg-green-800 text-white text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2 shadow-md">
                            Masuk ke HR Panel
                        </button>
                    </div>

                    <div class="mt-6 pt-5 border-t border-gray-100">
                        <p class="text-center text-xs text-gray-400">
                            Bukan tim HR?
                            <a href="/login" class="text-green-700 font-semibold hover:text-green-900 transition-colors">Login sebagai Pelamar</a>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-green-900 py-3 px-8 flex items-center justify-between">
        <span class="text-xs text-green-400">© 2024 PT Ecogreen Oleochemicals. All rights reserved.</span>
        <div class="flex gap-4">
            <a href="#" class="text-xs text-green-400 hover:text-green-200 transition-colors">Privacy Policy</a>
            <a href="#" class="text-xs text-green-400 hover:text-green-200 transition-colors">Terms of Service</a>
        </div>
    </footer>

    <!-- MODAL: Lupa Password -->
    <div id="modal-forgot" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
            <div class="bg-green-900 px-6 py-4 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Reset Password</h3>
                <button id="btn-close-forgot" class="text-green-300 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5">
                <p class="text-xs text-gray-500 mb-4">Masukkan email HR Anda. Link reset password akan dikirim ke email tersebut.</p>
                <input type="email" id="forgot-email" placeholder="nama@ecogreen.com" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition-all mb-4">
                <button id="btn-send-reset" class="w-full py-2.5 bg-green-900 text-white text-sm font-semibold rounded-xl hover:bg-green-800 transition-colors">
                    Kirim Link Reset
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/hr/login.js') }}"></script>
</body>
</html>