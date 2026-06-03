/**
 * Login Page JS
 * Features: toggle password, validasi client-side, submit ke server via fetch POST
 */

document.addEventListener('DOMContentLoaded', function () {

    // ===== TOGGLE PASSWORD =====
    const toggleBtn     = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeIcon       = document.getElementById('eye-icon');
    const eyeOffIcon    = document.getElementById('eye-off-icon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');
        });
    }

    // ===== LOGIN =====
    const btnLogin       = document.getElementById('btn-login');
    const emailInput     = document.getElementById('email');
    const alertError     = document.getElementById('alert-error');
    const alertErrorText = document.getElementById('alert-error-text');

    if (btnLogin) {
        btnLogin.addEventListener('click', handleLogin);

        // Enter key trigger login
        [emailInput, passwordInput].forEach(input => {
            input.addEventListener('keydown', e => {
                if (e.key === 'Enter') handleLogin();
            });
        });
    }

    function handleLogin() {
        hideError();

        const email    = emailInput.value.trim();
        const password = passwordInput.value;

        // === Validasi client-side ===
        if (!email || !password) {
            showError('Harap isi email dan kata sandi terlebih dahulu.');
            return;
        }

        if (!isValidEmail(email)) {
            showError('Format email tidak valid.');
            return;
        }

        // === Loading state ===
        setLoading(true);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ email, password }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Login berhasil — redirect ke dashboard
                window.location.href = data.redirect_url;
            } else {
                // Login gagal — tampilkan pesan error
                const msg = data.message || 'Email atau password salah.';
                showError(msg);
                setLoading(false);

                // Shake efek pada input agar lebih terasa
                shakeInputs();
            }
        })
        .catch(() => {
            showError('Terjadi kesalahan koneksi. Coba lagi nanti.');
            setLoading(false);
        });
    }

    // === Helpers ===

    function showError(message) {
        alertErrorText.textContent = message;
        alertError.classList.remove('hidden');
        // Smooth scroll ke alert jika perlu
        alertError.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideError() {
        alertError.classList.add('hidden');
    }

    function setLoading(isLoading) {
        if (isLoading) {
            btnLogin.disabled = true;
            btnLogin.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
        } else {
            btnLogin.disabled = false;
            btnLogin.textContent = 'Sign In';
        }
    }

    function shakeInputs() {
        [emailInput, passwordInput].forEach(input => {
            input.classList.add('shake-error');
            setTimeout(() => input.classList.remove('shake-error'), 600);
        });
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
});