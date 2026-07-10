@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="w-full max-w-md">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">
        <!-- Icon -->
        <div class="flex justify-center mb-5">
            <div class="w-14 h-14 bg-[#15803d] rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                    <line x1="12" x2="12" y1="15" y2="17"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Create New Password</h1>
        <p class="text-center text-gray-500 text-sm mb-8">
            Enter your new password. Make sure it is at least 8 characters long.
        </p>

        <!-- Error Alert -->
        <div id="alert-error" class="hidden mb-5 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="m15 9-6 6"/><path d="m9 9 6 6"/>
            </svg>
            <p class="text-red-700 text-sm font-medium" id="alert-error-text">An error occurred.</p>
        </div>

        <!-- Token Expired Alert -->
        @if(session('token_error'))
        <div class="mb-5 bg-amber-50 border border-amber-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <p class="text-amber-700 text-sm font-medium">{{ session('token_error') }}</p>
        </div>
        @endif

        <!-- Form -->
        <div class="space-y-5">
            <!-- Hidden Token -->
            <input type="hidden" id="reset-token" value="{{ $token }}">

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
                        placeholder="nama@email.com"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                </div>
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">New Password</label>
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
                        placeholder="At least 8 characters"
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
                <!-- Password Strength -->
                <div class="mt-2 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div id="strength-bar" class="h-full rounded-full transition-all duration-300 w-0"></div>
                </div>
                <p id="strength-label" class="text-xs text-gray-400 mt-1"></p>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Confirm Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input
                        type="password"
                        id="password_confirmation"
                        placeholder="Repeat new password"
                        class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all"
                    >
                    <button type="button" id="toggle-confirm" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" id="eye-icon-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" id="eye-off-icon-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/>
                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/>
                            <path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/>
                            <path d="m2 2 20 20"/>
                        </svg>
                    </button>
                </div>
                <p id="match-label" class="text-xs mt-1 hidden"></p>
            </div>

            <!-- Submit Button -->
            <button
                type="button"
                id="btn-reset"
                class="w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm flex items-center justify-center gap-2"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
                Save New Password
            </button>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-dashed border-gray-300"></div>

        <!-- Back to Login -->
        <p class="text-center text-sm text-gray-600">
            Remember password?
            <a href="/login" class="font-bold text-green-900 hover:text-green-700 transition-colors">Back to Login</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn            = document.getElementById('btn-reset');
    const tokenInput     = document.getElementById('reset-token');
    const emailInput     = document.getElementById('email');
    const pwInput        = document.getElementById('password');
    const pwConfirm      = document.getElementById('password_confirmation');
    const alertError     = document.getElementById('alert-error');
    const alertErrorText = document.getElementById('alert-error-text');
    const strengthBar    = document.getElementById('strength-bar');
    const strengthLabel  = document.getElementById('strength-label');
    const matchLabel     = document.getElementById('match-label');

    // ---- Toggle password visibility ----
    function setupToggle(btnId, inputId, eyeId, eyeOffId) {
        document.getElementById(btnId).addEventListener('click', function () {
            const inp = document.getElementById(inputId);
            const isHidden = inp.type === 'password';
            inp.type = isHidden ? 'text' : 'password';
            document.getElementById(eyeId).classList.toggle('hidden', isHidden);
            document.getElementById(eyeOffId).classList.toggle('hidden', !isHidden);
        });
    }
    setupToggle('toggle-password', 'password', 'eye-off-icon', 'eye-icon');
    setupToggle('toggle-confirm', 'password_confirmation', 'eye-off-icon-2', 'eye-icon-2');

    // ---- Password strength ----
    pwInput.addEventListener('input', function () {
        const val = pwInput.value;
        let score = 0;
        if (val.length >= 8)   score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
        const labels = ['', 'Weak', 'Medium', 'Strong', 'Very Strong'];
        const widths = ['0%', '25%', '50%', '75%', '100%'];

        strengthBar.className = 'h-full rounded-full transition-all duration-300 ' + (colors[score - 1] || '');
        strengthBar.style.width = widths[score];
        strengthLabel.textContent = val.length === 0 ? '' : labels[score];
        strengthLabel.className = 'text-xs mt-1 ' + (score <= 1 ? 'text-red-500' : score === 2 ? 'text-orange-500' : score === 3 ? 'text-yellow-600' : 'text-green-600');
    });

    // ---- Confirm password match ----
    pwConfirm.addEventListener('input', function () {
        if (!pwConfirm.value) {
            matchLabel.classList.add('hidden');
            return;
        }
        const match = pwInput.value === pwConfirm.value;
        matchLabel.classList.remove('hidden');
        matchLabel.textContent  = match ? '✓ Passwords match' : '✗ Passwords do not match';
        matchLabel.className    = 'text-xs mt-1 ' + (match ? 'text-green-600' : 'text-red-500');
    });

    // ---- Show error ----
    function showError(msg) {
        alertErrorText.textContent = msg;
        alertError.classList.remove('hidden');
        alertError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    function hideError() { alertError.classList.add('hidden'); }

    // ---- Submit ----
    btn.addEventListener('click', async function () {
        hideError();

        const email    = emailInput.value.trim();
        const password = pwInput.value;
        const confirm  = pwConfirm.value;
        const token    = tokenInput.value;

        if (!email) { showError('Email address is required.'); return; }
        if (!password) { showError('New password is required.'); return; }
        if (password.length < 8) { showError('Password must be at least 8 characters.'); return; }
        if (password !== confirm) { showError('Passwords do not match.'); return; }

        // Loading state
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            Saving...
        `;

        try {
            const res = await fetch('/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ token, email, password, password_confirmation: confirm }),
            });

            const data = await res.json();

            if (data.success) {
                if (data.role === 'hr' || data.role === 'hr_master') {
                    window.location.href = '/hr/login?password_reset=1';
                } else {
                    window.location.href = '/login?password_reset=1';
                }
            } else {
                showError(data.message || 'An error occurred. Please try again.');
                btn.disabled = false;
                btn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    Save New Password
                `;
            }
        } catch (err) {
            showError('Failed to connect to the server. Check your internet connection.');
            btn.disabled = false;
            btn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
                Save New Password
            `;
        }
    });
});
</script>
@endsection
