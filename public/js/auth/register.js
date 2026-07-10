/**
 * Register Page - Auth JS
 * Handles: form validation, AJAX register
 */

document.addEventListener('DOMContentLoaded', function () {

    const btnRegister = document.getElementById('btn-register');
    const namaInput = document.getElementById('nama');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');

    if (btnRegister) {
        btnRegister.addEventListener('click', async function () {
            // Clear previous error styles
            clearErrors();

            const nama = namaInput.value.trim();
            const email = emailInput.value.trim();
            const password = passwordInput.value;
            const confirmation = confirmInput.value;
            const termsAccepted = termsCheckbox.checked;

            // Validation
            let hasError = false;

            if (!nama) {
                showFieldError(namaInput, 'Full name is required.');
                hasError = true;
            }

            if (!email) {
                showFieldError(emailInput, 'Email address is required.');
                hasError = true;
            } else if (!isValidEmail(email)) {
                showFieldError(emailInput, 'Invalid email format.');
                hasError = true;
            }

            if (!password) {
                showFieldError(passwordInput, 'Password is required.');
                hasError = true;
            } else if (password.length < 8) {
                showFieldError(passwordInput, 'Password must be at least 8 characters.');
                hasError = true;
            }

            if (password !== confirmation) {
                showFieldError(confirmInput, 'Password confirmation does not match.');
                hasError = true;
            }

            if (!termsAccepted) {
                alert('You must agree to the Terms & Conditions to proceed.');
                hasError = true;
            }

            if (hasError) return;

            // Simulasi loading
            btnRegister.disabled = true;
            btnRegister.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    body: JSON.stringify({
                        nama,
                        email,
                        password,
                        password_confirmation: confirmation
                    })
                });

                const data = await response.json();

                if (data.success) {
                    window.location.href = '/login';
                } else {
                    alert(data.message || 'Registration failed');
                    btnRegister.disabled = false;
                    btnRegister.innerHTML = 'Register';
                }
            } catch (err) {
                alert('An error occurred. Please try again later.');
                btnRegister.disabled = false;
                btnRegister.innerHTML = 'Register';
            }
        });
    }

    // === Helpers ===
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showFieldError(input, message) {
        input.classList.add('border-red-500', 'ring-1', 'ring-red-500');
        const errorEl = document.createElement('p');
        errorEl.className = 'text-xs text-red-500 mt-1 field-error';
        errorEl.textContent = message;
        input.closest('.relative')?.parentElement?.appendChild(errorEl) ||
        input.parentElement.appendChild(errorEl);
    }

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
        });
    }
});
