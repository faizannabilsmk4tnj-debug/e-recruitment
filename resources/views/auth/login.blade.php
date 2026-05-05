@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">
        <!-- Icon -->
        <div class="flex justify-center mb-5">
            <div class="w-14 h-14 bg-green-950 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Login to Your Account</h1>
        <p class="text-center text-gray-500 text-sm mb-8">Welcome back! Please sign in to manage your account.</p>

        <!-- Error Alert (hidden by default, shown via JS) -->
        <div id="alert-error" class="hidden mb-4 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m15 9-6 6"/>
                <path d="m9 9 6 6"/>
            </svg>
            <p class="text-red-700 text-sm font-medium" id="alert-error-text">Incorrect email or password. Please check your credentials again.</p>
        </div>

        <!-- Warning Alert (hidden by default, shown via JS) -->
        <div id="alert-warning" class="hidden mb-4 bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <p class="text-amber-700 text-sm font-medium" id="alert-warning-text">Account temporarily locked due to multiple failed login attempts. Please try again in 30 minutes.</p>
        </div>

        <!-- Form -->
        <div class="space-y-5">
            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <input
                        type="email"
                        id="email"
                        placeholder="nama@email.com"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Password</label>
                    <a href="#" class="text-xs font-semibold text-green-800 hover:text-green-600 underline transition-colors">Forgot Password?</a>
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
                        id="password"
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

            <!-- Encrypted Session Badge -->
            <div class="flex items-center justify-center gap-2 py-1">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Secure Encrypted Session</span>
            </div>

            <!-- Submit Button -->
            <button
                type="button"
                id="btn-login"
                class="w-full bg-green-950 hover:bg-green-900 text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm"
            >
                Sign In
            </button>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-dashed border-gray-300"></div>

        <!-- Register Link -->
        <p class="text-center text-sm text-gray-600">
            Don't have an account?
            <a href="/register" class="font-bold text-green-900 hover:text-green-700 transition-colors">Register Now</a>
        </p>
    </div>

    <!-- Terms Text -->
    <p class="text-center text-xs text-gray-400 mt-6 px-4">
        By signing in, you agree to the Terms of Service<br>
        and Privacy Policy of PT Ecogreen Oleochemicals.
    </p>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/auth/login.js') }}"></script>
@endsection