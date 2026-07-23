/**
 * Login Page JS
 * Features: toggle password, validation, login via fetch API
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
                alertErrorText.textContent = 'Please fill in your email and password.';
                alertError.classList.remove('hidden');
                return;
            }

            if (!isValidEmail(email)) {
                alertErrorText.textContent = 'Invalid email format.';
                alertError.classList.remove('hidden');
                return;
            }

            // Loading state
            btnLogin.disabled = true;
            btnLogin.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

            fetch('/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: new URLSearchParams({
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
                alertErrorText.textContent = 'An error occurred. Please try again.';
                alertError.classList.remove('hidden');
                btnLogin.disabled = false;
                btnLogin.innerHTML = 'Sign In';
            });
        });

        // Enter key trigger login
        [emailInput, passwordInput].forEach(input => {
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') btnLogin.click();
            });
            input.addEventListener('input', function () {
                if (alertError) alertError.classList.add('hidden');
            });
        });
    }

    function isValidEmail(email) {
        // Enforce valid email format with trusted email providers (.com)
        return /^[a-zA-Z0-9._%+-]+@(gmail|yahoo|ymail|outlook|hotmail|live|icloud|ecogreen)\.com$/i.test(email);
    }
});
