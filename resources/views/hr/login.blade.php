@extends('layouts.auth')

@section('title', 'HR Login')

@section('content')
<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">
        <!-- Icon -->
        <div class="flex justify-center mb-5">
            <div class="w-14 h-14 bg-[#15803d] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">HR Staff Login</h1>
        <p class="text-center text-gray-500 text-sm mb-8">Exclusive access for HR & Recruitment team</p>

        {{-- Auth Warning (dari redirect middleware) --}}
        @if(session('auth_warning'))
        <div class="mb-4 bg-amber-50 border border-amber-300 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <p class="text-amber-700 text-sm font-medium">{{ session('auth_warning') }}</p>
        </div>
        @endif

        <!-- Success Alert — muncul setelah reset-password berhasil atau logout -->
        <div id="alert-success" class="hidden mb-4 bg-green-50 border border-green-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            <div>
                <p class="text-green-800 text-sm font-semibold" id="alert-success-title">Berhasil!</p>
                <p class="text-green-700 text-xs mt-0.5" id="alert-success-text"></p>
            </div>
        </div>

        <!-- Error Alert (hidden by default, shown via JS) -->
        <div id="alert-error" class="hidden mb-4 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m15 9-6 6"/>
                <path d="m9 9 6 6"/>
            </svg>
            <p class="text-red-700 text-sm font-medium" id="alert-error-text"></p>
        </div>

        <!-- Form -->
        <div class="space-y-5">
            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">HR Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="hr-email"
                        placeholder="name@ecogreen.com"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Password</label>
                    <button type="button" id="btn-forgot" class="text-xs font-semibold text-green-800 hover:text-green-600 underline transition-colors">Forgot Password?</button>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input
                        type="password"
                        id="hr-password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" id="eye-off-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                            <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                            <path d="m2 2 20 20"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center py-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="hr-remember" class="w-4.5 h-4.5 rounded border-gray-300 text-green-700 focus:ring-green-500">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Remember me</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="button"
                id="btn-login"
                class="w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm flex items-center justify-center gap-2"
            >
                Login to HR Panel
            </button>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-dashed border-gray-300"></div>

        <!-- Link & Admin Contact Info -->
        <div class="space-y-4 text-center text-sm text-gray-500">
            <div>
                <p class="font-semibold text-gray-800">
                    Authorized HR Personnel Only
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Access to this portal is restricted to Human Resources staff.
                </p>
            </div>
            <div class="pt-2 border-t border-gray-100">
                <p class="text-center text-xs text-gray-400">
                    Not HR staff?
                    <a href="/login" class="text-green-700 font-semibold hover:text-green-900 transition-colors">Login as Applicant</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Terms Text -->
    <p class="text-center text-xs text-gray-400 mt-6 px-4">
        By signing in, you agree to the Terms of Service<br>
        and Privacy Policy of PT Ecogreen Oleochemicals.
    </p>
</div>

<!-- MODAL: Lupa Password -->
<div id="modal-forgot" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <div class="bg-[#15803d] px-6 py-4 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-white">Reset Password</h3>
            <button id="btn-close-forgot" class="text-green-300 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <p class="text-xs text-gray-500 mb-4">Enter your HR email. A password reset link will be sent to that email.</p>
            <input type="email" id="forgot-email" placeholder="name@ecogreen.com" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition-all mb-4">
            <button id="btn-send-reset" class="w-full py-2.5 bg-[#15803d] text-white text-sm font-semibold rounded-xl hover:bg-[#166534] transition-colors">
                Send Reset Link
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/hr/login.js') }}?v={{ time() }}"></script>
@endsection