/**
 * HR Login JS
 */
document.addEventListener('DOMContentLoaded', function () {

    const btnLogin    = document.getElementById('btn-login');
    const emailInput  = document.getElementById('hr-email');
    const passInput   = document.getElementById('hr-password');
    const alertEl     = document.getElementById('alert-error');
    const alertText   = document.getElementById('alert-error-text');
    const toggleBtn   = document.getElementById('toggle-password');
    const eyeIcon     = document.getElementById('eye-icon');
    const eyeOffIcon  = document.getElementById('eye-off-icon');
    const btnForgot   = document.getElementById('btn-forgot');
    const modalForgot = document.getElementById('modal-forgot');
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
            alertText.textContent = 'Email and password are required.';
            alertEl.classList.remove('hidden');
            return;
        }

        btnLogin.disabled = true;
        btnLogin.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg><span>Verifying...</span>';

        setTimeout(() => {
            window.location.href = '/hr/dashboard';
        }, 1200);
    }

    // Forgot password modal
    btnForgot.addEventListener('click', () => modalForgot.classList.remove('hidden'));
    btnCloseForgot.addEventListener('click', () => modalForgot.classList.add('hidden'));
    modalForgot.addEventListener('click', e => { if (e.target === modalForgot) modalForgot.classList.add('hidden'); });

    btnSendReset.addEventListener('click', function () {
        const email = document.getElementById('forgot-email').value.trim();
        if (!email) { alert('Please enter your email first.'); return; }
        this.textContent = 'Sending...';
        this.disabled = true;
        setTimeout(() => {
            this.textContent = '✓ Link sent to ' + email;
            setTimeout(() => {
                modalForgot.classList.add('hidden');
                this.textContent = 'Send Reset Link';
                this.disabled = false;
                document.getElementById('forgot-email').value = '';
            }, 2000);
        }, 1500);
    });
});