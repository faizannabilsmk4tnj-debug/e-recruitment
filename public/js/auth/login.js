/**
 * Login Page JS
 * Features: toggle password, validation, simulated login redirect
 */

document.addEventListener('DOMContentLoaded', function () {

    // ===== TOGGLE PASSWORD =====
    const toggleBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeOffIcon = document.getElementById('eye-off-icon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden');
            eyeOffIcon.classList.toggle('hidden');
        });
    }

    // ===== LOGIN =====
    const btnLogin = document.getElementById('btn-login');
    const emailInput = document.getElementById('email');
    const alertError = document.getElementById('alert-error');
    const alertErrorText = document.getElementById('alert-error-text');

    if (btnLogin) {
        btnLogin.addEventListener('click', function () {
            alertError.classList.add('hidden');

            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();

            if (!email || !password) {
                alertErrorText.textContent = 'Harap isi email dan kata sandi.';
                alertError.classList.remove('hidden');
                return;
            }

            if (!isValidEmail(email)) {
                alertErrorText.textContent = 'Format email tidak valid.';
                alertError.classList.remove('hidden');
                return;
            }

            // Simulasi loading
            btnLogin.disabled = true;
            btnLogin.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

            // Simulasi delay login (seolah proses ke server)
            fetch('/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
    },
    body: JSON.stringify({
        email: email,
        password: password
    })
})
.then(response => response.json())
.then(data => {

    if (!data.success) {
        alertErrorText.textContent = data.message;
        alertError.classList.remove('hidden');

        btnLogin.disabled = false;
        btnLogin.innerHTML = 'Sign In';
        return;
    }

    if (data.role === 'hr') {
        window.location.href = '/hr/dashboard';
        return;
    }

    window.location.href = '/pelamar/dashboard';
})

.catch(error => {
    console.error(error);
});
        });

        // Enter key trigger login
        [emailInput, passwordInput].forEach(input => {
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') btnLogin.click();
            });
        });
    }
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
})
