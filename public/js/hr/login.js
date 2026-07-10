/**
 * HR Login JS
 * Remember Me: simpan email ke localStorage → auto-fill saat halaman login dibuka lagi.
 */
document.addEventListener('DOMContentLoaded', function () {

    const btnLogin       = document.getElementById('btn-login');
    const emailInput     = document.getElementById('hr-email');
    const passInput      = document.getElementById('hr-password');
    const rememberChk    = document.getElementById('hr-remember');
    const alertEl        = document.getElementById('alert-error');
    const alertText      = document.getElementById('alert-error-text');
    const toggleBtn      = document.getElementById('toggle-password');
    const eyeIcon        = document.getElementById('eye-icon');
    const eyeOffIcon     = document.getElementById('eye-off-icon');
    const btnForgot      = document.getElementById('btn-forgot');
    const modalForgot    = document.getElementById('modal-forgot');
    const btnCloseForgot = document.getElementById('btn-close-forgot');
    const btnSendReset   = document.getElementById('btn-send-reset');

    // ============================================================
    // Remember Me — restore email dari localStorage saat halaman dibuka
    // ============================================================
    const savedEmail = localStorage.getItem('hr_remember_email');
    if (savedEmail && emailInput) {
        emailInput.value    = savedEmail;
        if (rememberChk) rememberChk.checked = true;
    }

    // Jika HR uncheck → hapus data tersimpan
    if (rememberChk) {
        rememberChk.addEventListener('change', function () {
            if (!this.checked) {
                localStorage.removeItem('hr_remember_email');
            }
        });
    }

    // ============================================================
    // Toggle Password
    // ============================================================
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isPass = passInput.type === 'password';
            passInput.type = isPass ? 'text' : 'password';
            if (eyeIcon) eyeIcon.classList.toggle('hidden', isPass);
            if (eyeOffIcon) eyeOffIcon.classList.toggle('hidden', !isPass);
        });
    }

    // Enter key
    [emailInput, passInput].forEach(el => {
        if (el) {
            el.addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); });
        }
    });

    // Login
    if (btnLogin) btnLogin.addEventListener('click', doLogin);

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

        const remember = rememberChk ? rememberChk.checked : false;

        fetch('/hr/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email: email, password: pass, remember: remember })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (rememberChk && rememberChk.checked) {
                    localStorage.setItem('hr_remember_email', email);
                } else {
                    localStorage.removeItem('hr_remember_email');
                }

                if (data.role === 'hr' || data.role === 'hr_master') {
                    window.location.href = '/hr/dashboard';
                } else {
                    alertText.textContent = 'This account is not an HR account.';
                    alertEl.classList.remove('hidden');
                }
            } else {
                alertText.textContent = data.message || 'Login failed.';
                alertEl.classList.remove('hidden');
            }
            btnLogin.disabled = false;
            btnLogin.innerHTML = 'Sign In to HR Panel';
        })
        .catch((err) => {
            console.log('Fetch error:', err);
            alertText.textContent = 'An error occurred. Please try again.';
            alertEl.classList.remove('hidden');
            btnLogin.disabled = false;
            btnLogin.innerHTML = 'Sign In to HR Panel';
        });
    }

    // Forgot password modal
    if (btnForgot) btnForgot.addEventListener('click', () => modalForgot.classList.remove('hidden'));
    if (btnCloseForgot) btnCloseForgot.addEventListener('click', () => modalForgot.classList.add('hidden'));
    if (modalForgot) modalForgot.addEventListener('click', e => { if (e.target === modalForgot) modalForgot.classList.add('hidden'); });

    if (btnSendReset) {
        btnSendReset.addEventListener('click', async function () {
            const email = document.getElementById('forgot-email').value.trim();
            if (!email) { alert('Please enter your email first.'); return; }
            
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Invalid email format.');
                return;
            }

            this.textContent = 'Sending...';
            this.disabled = true;

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
                    btnSendReset.textContent = '✓ Link sent to ' + email;
                    setTimeout(() => {
                        modalForgot.classList.add('hidden');
                        btnSendReset.textContent = 'Send Reset Link';
                        btnSendReset.disabled = false;
                        document.getElementById('forgot-email').value = '';
                    }, 2500);
                } else {
                    alert(data.message || 'An error occurred. Please try again.');
                    btnSendReset.textContent = 'Send Reset Link';
                    btnSendReset.disabled = false;
                }
            } catch (err) {
                alert('Failed to connect to server. Check your internet connection.');
                btnSendReset.textContent = 'Send Reset Link';
                btnSendReset.disabled = false;
            }
        });
    }

    // ===== URL PARAMETERS FOR ALERTS =====
    const params = new URLSearchParams(window.location.search);
    const alertSuccess = document.getElementById('alert-success');
    const alertSuccessTitle = document.getElementById('alert-success-title');
    const alertSuccessText = document.getElementById('alert-success-text');

    if (alertSuccess) {
        if (params.get('password_reset') === '1') {
            alertSuccessTitle.textContent = 'Password successfully updated!';
            alertSuccessText.textContent = 'Please sign in using your new password.';
            alertSuccess.classList.remove('hidden');
            window.history.replaceState({}, '', '/hr/login');
        }

        if (params.get('loggedout') === '1') {
            alertSuccessTitle.textContent = 'Successfully logged out.';
            alertSuccessText.textContent = 'Your session has been securely ended.';
            alertSuccess.classList.remove('hidden');
            window.history.replaceState({}, '', '/hr/login');
        }
    }
});
