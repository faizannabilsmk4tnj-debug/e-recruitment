@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-10">

        <!-- Icon -->
        <div class="flex justify-center mb-5">
            <div class="w-14 h-14 bg-green-950 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    <circle cx="12" cy="16" r="1"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Forgot Your Password?</h1>
        <p class="text-center text-gray-500 text-sm mb-8">Enter your registered email. We'll send a password reset link.</p>

        <!-- Success Alert -->
        <div id="alert-success" class="hidden mb-5 bg-green-50 border border-green-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            <div>
                <p class="text-green-800 text-sm font-semibold">Reset link sent!</p>
                <p class="text-green-700 text-xs mt-0.5" id="success-msg">Check your email inbox and follow the instructions.</p>
            </div>
        </div>

        <!-- Error Alert -->
        <div id="alert-error" class="hidden mb-5 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
            </svg>
            <p class="text-red-700 text-sm font-medium" id="error-msg">Email tidak ditemukan.</p>
        </div>

        <!-- Form -->
        <div class="space-y-5">
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
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

            <button
                type="button"
                id="btn-send"
                class="w-full bg-green-950 hover:bg-green-900 text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm"
            >
                Send Reset Link
            </button>
        </div>

        <div class="my-6 border-t border-dashed border-gray-200"></div>

        <p class="text-center text-sm text-gray-600">
            Remember your password?
            <a href="/login" class="font-bold text-green-900 hover:text-green-700 transition-colors">Back to Login</a>
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnSend  = document.getElementById('btn-send');
    const emailEl  = document.getElementById('email');
    const alertOk  = document.getElementById('alert-success');
    const alertErr = document.getElementById('alert-error');
    const errMsg   = document.getElementById('error-msg');

    btnSend.addEventListener('click', function () {
        alertOk.classList.add('hidden');
        alertErr.classList.add('hidden');

        const email = emailEl.value.trim();
        if (!email) { errMsg.textContent = 'Harap masukkan email.'; alertErr.classList.remove('hidden'); return; }

        btnSend.disabled = true;
        btnSend.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/forgot-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ email }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alertOk.classList.remove('hidden');
                emailEl.value = '';
                emailEl.disabled = true;
                btnSend.textContent = 'Link Sent ✓';
            } else {
                errMsg.textContent = data.message || 'Email tidak ditemukan.';
                alertErr.classList.remove('hidden');
                btnSend.disabled = false;
                btnSend.textContent = 'Send Reset Link';
            }
        })
        .catch(() => {
            errMsg.textContent = 'Terjadi kesalahan. Coba lagi nanti.';
            alertErr.classList.remove('hidden');
            btnSend.disabled = false;
            btnSend.textContent = 'Send Reset Link';
        });
    });

    emailEl.addEventListener('keydown', e => { if (e.key === 'Enter') btnSend.click(); });
});
</script>
@endsection
