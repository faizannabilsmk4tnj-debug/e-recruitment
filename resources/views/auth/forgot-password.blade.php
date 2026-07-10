@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">
        <!-- Icon -->
        <div class="flex justify-center mb-5">
            <div class="w-14 h-14 bg-[#15803d] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Forgot Password?</h1>
        <p class="text-center text-gray-500 text-sm mb-8">
            Enter your registered email. We will send you a link to reset your password.
        </p>

        <!-- Success Alert (hidden by default) -->
        <div id="alert-success" class="hidden mb-5 bg-green-50 border border-green-200 rounded-lg px-4 py-4">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <path d="m9 11 3 3L22 4"/>
                </svg>
                <div>
                    <p class="text-green-800 text-sm font-semibold">Reset link sent successfully!</p>
                    <p class="text-green-700 text-xs mt-0.5" id="success-detail">If your email is registered, the password reset link has been sent. Please check your email inbox.</p>
                </div>
            </div>
        </div>

        <!-- Error Alert (hidden by default) -->
        <div id="alert-error" class="hidden mb-5 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m15 9-6 6"/><path d="m9 9 6 6"/>
            </svg>
            <p class="text-red-700 text-sm font-medium" id="alert-error-text">An error occurred. Please try again.</p>
        </div>

        <!-- Form -->
        <div id="form-wrapper" class="space-y-5">
            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
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
                        placeholder="name@email.com"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button
                type="button"
                id="btn-send"
                class="w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm flex items-center justify-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                </svg>
                Send Reset Link
            </button>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-dashed border-gray-300"></div>

        <!-- Back to Login -->
        <p class="text-center text-sm text-gray-600">
            Remember your password?
            <a href="/login" class="font-bold text-green-900 hover:text-green-700 transition-colors">Back to Login</a>
        </p>
    </div>

    <!-- Terms Text -->
    <p class="text-center text-xs text-gray-400 mt-6 px-4">
        Need help? Contact PT Ecogreen Oleochemicals HR team.
    </p>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn        = document.getElementById('btn-send');
    const emailInput = document.getElementById('email');
    const alertError = document.getElementById('alert-error');
    const alertErrorText = document.getElementById('alert-error-text');
    const alertSuccess = document.getElementById('alert-success');
    const formWrapper  = document.getElementById('form-wrapper');

    function showError(msg) {
        alertErrorText.textContent = msg;
        alertError.classList.remove('hidden');
        alertSuccess.classList.add('hidden');
    }

    function hideError() {
        alertError.classList.add('hidden');
    }

    btn.addEventListener('click', async function () {
        hideError();
        const email = emailInput.value.trim();

        if (!email) {
            showError('Email address is required.');
            emailInput.focus();
            return;
        }

        // Basic email format check
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError('Invalid email address format.');
            emailInput.focus();
            return;
        }

        // Loading state
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            Sending...
        `;

        try {
            const res = await fetch('/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ email }),
            });

            const data = await res.json();

            if (data.success) {
                // Sembunyikan form, tampilkan success
                formWrapper.classList.add('hidden');
                alertSuccess.classList.remove('hidden');
            } else {
                showError(data.message || 'An error occurred. Please try again.');
                btn.disabled = false;
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                    </svg>
                    Send Reset Link
                `;
            }
        } catch (err) {
            showError('Failed to connect to the server. Check your internet connection.');
            btn.disabled = false;
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>
                </svg>
                Send Reset Link
            `;
        }
    });

    // Submit on Enter key
    emailInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') btn.click();
    });
});
</script>
@endsection
