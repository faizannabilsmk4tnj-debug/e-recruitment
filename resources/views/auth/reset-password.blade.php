@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="w-full max-w-md">
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

        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">Set New Password</h1>
        <p class="text-center text-gray-500 text-sm mb-8">Enter your new password below. Make sure it's at least 8 characters.</p>

        <!-- Error Alert (token expired dll) -->
        <div id="alert-error" class="hidden mb-5 bg-red-50 border border-red-200 rounded-lg px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
            </svg>
            <p class="text-red-700 text-sm font-medium" id="error-msg">Terjadi kesalahan.</p>
        </div>

        <div class="space-y-5">
            <!-- Hidden token -->
            <input type="hidden" id="reset-token" value="{{ $token }}">

            <!-- New Password -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">New Password</label>
                <div class="relative">
                    <input type="password" id="password" placeholder="Min. 8 characters"
                        class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Confirm New Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" placeholder="Repeat your new password"
                        class="w-full pl-4 pr-4 py-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition-all">
                </div>
            </div>

            <button
                type="button"
                id="btn-reset"
                class="w-full bg-green-950 hover:bg-green-900 text-white font-semibold py-3.5 rounded-lg transition-colors duration-200 text-sm"
            >
                Reset Password
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnReset  = document.getElementById('btn-reset');
    const passEl    = document.getElementById('password');
    const confirmEl = document.getElementById('password_confirmation');
    const tokenEl   = document.getElementById('reset-token');
    const alertErr  = document.getElementById('alert-error');
    const errMsg    = document.getElementById('error-msg');

    btnReset.addEventListener('click', function () {
        alertErr.classList.add('hidden');

        const password = passEl.value;
        const confirmation = confirmEl.value;
        const token = tokenEl.value;

        if (password.length < 8) {
            errMsg.textContent = 'Password minimal 8 karakter.';
            alertErr.classList.remove('hidden');
            return;
        }
        if (password !== confirmation) {
            errMsg.textContent = 'Konfirmasi password tidak cocok.';
            alertErr.classList.remove('hidden');
            return;
        }

        btnReset.disabled = true;
        btnReset.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/reset-password', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ token, password, password_confirmation: confirmation }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                errMsg.textContent = data.message || 'Reset gagal. Link mungkin sudah kadaluarsa.';
                alertErr.classList.remove('hidden');
                btnReset.disabled = false;
                btnReset.textContent = 'Reset Password';
            }
        })
        .catch(() => {
            errMsg.textContent = 'Terjadi kesalahan. Coba lagi nanti.';
            alertErr.classList.remove('hidden');
            btnReset.disabled = false;
            btnReset.textContent = 'Reset Password';
        });
    });
});
</script>
@endsection
