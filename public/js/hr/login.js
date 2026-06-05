/**
 * HR Login JS
 */
document.addEventListener('DOMContentLoaded', function () {

    const btnLogin       = document.getElementById('btn-login');
    const emailInput     = document.getElementById('hr-email');
    const passInput      = document.getElementById('hr-password');
    const alertEl        = document.getElementById('alert-error');
    const alertText      = document.getElementById('alert-error-text');
    const toggleBtn      = document.getElementById('toggle-password');
    const eyeIcon        = document.getElementById('eye-icon');
    const eyeOffIcon     = document.getElementById('eye-off-icon');
    const btnForgot      = document.getElementById('btn-forgot');
    const modalForgot    = document.getElementById('modal-forgot');
    const btnCloseForgot = document.getElementById('btn-close-forgot');
    const btnSendReset   = document.getElementById('btn-send-reset');

    // Toggle password
    toggleBtn.addEventListener('click', function () {
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        eyeIcon.classList.toggle('hidden', isPass);
        eyeOffIcon.classList.toggle('hidden', !isPass);
    });

    // Enter key
    [emailInput, passInput].forEach(el => {
        el.addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); });
    });

    // Login
    btnLogin.addEventListener('click', doLogin);

    function doLogin() {
        const email = emailInput.value.trim();
        const pass  = passInput.value.trim();
        alertEl.classList.add('hidden');

        if (!email || !pass) {
            alertText.textContent = 'Email dan password wajib diisi.';
            alertEl.classList.remove('hidden');
            return;
        }

        btnLogin.disabled = true;
        btnLogin.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg><span>Verifying...</span>';

        fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: email, password: pass })
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.success && data.role === 'hr') {
                window.location.href = '/hr/dashboard';
            } else if (data.success && data.role !== 'hr') {
                alertText.textContent = 'Akun ini bukan akun HR.';
                alertEl.classList.remove('hidden');
            } else {
                alertText.textContent = data.message || 'Login gagal.';
                alertEl.classList.remove('hidden');
            }
            btnLogin.disabled = false;
            btnLogin.innerHTML = 'Masuk ke HR Panel';
        })
        .catch((err) => {
            console.log('Fetch error:', err);
            alertText.textContent = 'Terjadi kesalahan. Coba lagi.';
            alertEl.classList.remove('hidden');
            btnLogin.disabled = false;
            btnLogin.innerHTML = 'Masuk ke HR Panel';
        });
    }

    // Forgot password modal
    if (btnForgot) btnForgot.addEventListener('click', () => modalForgot.classList.remove('hidden'));
    if (btnCloseForgot) btnCloseForgot.addEventListener('click', () => modalForgot.classList.add('hidden'));
    if (modalForgot) modalForgot.addEventListener('click', e => { if (e.target === modalForgot) modalForgot.classList.add('hidden'); });

    if (btnSendReset) {
        btnSendReset.addEventListener('click', function () {
            const email = document.getElementById('forgot-email').value.trim();
            if (!email) { alert('Masukkan email terlebih dahulu.'); return; }
            this.textContent = 'Mengirim...';
            this.disabled = true;
            setTimeout(() => {
                this.textContent = '✓ Link dikirim ke ' + email;
                setTimeout(() => modalForgot.classList.add('hidden'), 2000);
            }, 1500);
        });
    }
});
