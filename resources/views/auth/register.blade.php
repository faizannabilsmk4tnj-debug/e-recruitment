@extends('layouts.auth')

@section('title', 'Register')

@section('nav-right')
    <span class="text-green-400 mx-1">|</span>
    <a href="/login" class="text-white font-medium hover:text-green-200 transition-colors text-sm">Sign In</a>
@endsection

@section('footer-title', 'Ecogreen Careers')

@section('content')
<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">
        <!-- Icon -->
        <div class="flex justify-center mb-5">
            <div class="w-14 h-14 bg-green-950 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" x2="19" y1="8" y2="14"/>
                    <line x1="22" x2="16" y1="11" y2="11"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-green-950 mb-2">Create Applicant Account</h1>
        <p class="text-center text-gray-500 text-sm mb-8">Start your career journey with PT Ecogreen Oleochemicals.</p>

        <!-- Form -->
        <div class="space-y-5">
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                <div class="relative">
                    <input
                        type="text"
                        id="nama"
                        placeholder="Enter your full name as per ID card"
                        class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="14" x="3" y="5" rx="2"/>
                            <path d="M7 15h0"/>
                            <path d="M3 10h18"/>
                            <circle cx="10" cy="14" r="2"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Alamat Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <input
                        type="email"
                        id="email"
                        placeholder="example@email.com"
                        class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">We will send a verification link to this email.</p>
            </div>

            <!-- Password Row -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Kata Sandi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            placeholder="••••••••"
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Konfirmasi Sandi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password_confirmation"
                            placeholder="••••••••"
                            class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terms Checkbox -->
            <div class="flex items-start gap-3">
                <input
                    type="checkbox"
                    id="terms"
                    class="mt-1 h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-600 accent-green-800 cursor-pointer"
                >
                <label for="terms" class="text-sm text-gray-600 cursor-pointer">
                    Saya menyetujui <a href="#" class="font-semibold text-green-800 underline hover:text-green-600">Terms & Conditions</a> serta <a href="#" class="font-semibold text-green-800 underline hover:text-green-600">Privacy Policy</a> yang berlaku.
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="button"
                id="btn-register"
                class="w-full bg-green-950 hover:bg-green-900 text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm flex items-center justify-center gap-2"
            >
                Register
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"/>
                    <path d="m12 5 7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Divider -->
        <div class="my-6 flex items-center gap-4">
            <div class="flex-1 border-t border-gray-200"></div>
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Or</span>
            <div class="flex-1 border-t border-gray-200"></div>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600">
            Already have an account?
            <a href="/login" class="font-bold text-green-900 hover:text-green-700 transition-colors">Login</a>
        </p>
    </div>

    <!-- Security Badges -->
    <div class="flex items-center justify-center gap-6 mt-6">
        <div class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Encrypted Session</span>
        </div>
        <span class="text-gray-300">•</span>
        <div class="flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Certified Recruitment</span>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/auth/register.js') }}"></script>
@endsection