/**
 * Register Page JS
 * Features: validasi client-side, submit form ke server via POST
 */

document.addEventListener('DOMContentLoaded', function () {

    const btnRegister  = document.getElementById('btn-register');
    const namaInput    = document.getElementById('nama');
    const emailInput   = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');

    if (btnRegister) {
        btnRegister.addEventListener('click', function () {
            clearErrors();

            const nama         = namaInput.value.trim();
            const email        = emailInput.value.trim();
            const password     = passwordInput.value;
            const confirmation = confirmInput.value;
            const termsAccepted = termsCheckbox.checked;

            // === Validasi client-side ===
            let hasError = false;

            if (!nama) {
                showFieldError(namaInput, 'Nama lengkap wajib diisi.');
                hasError = true;
            }

            if (!email) {
                showFieldError(emailInput, 'Alamat email wajib diisi.');
                hasError = true;
            } else if (!isValidEmail(email)) {
                showFieldError(emailInput, 'Format email tidak valid.');
                hasError = true;
            }

            if (!password) {
                showFieldError(passwordInput, 'Kata sandi wajib diisi.');
                hasError = true;
            } else if (password.length < 8) {
                showFieldError(passwordInput, 'Kata sandi minimal 8 karakter.');
                hasError = true;
            }

            if (password !== confirmation) {
                showFieldError(confirmInput, 'Konfirmasi sandi tidak cocok.');
                hasError = true;
            }

            if (!termsAccepted) {
                showToast('Anda harus menyetujui Syarat & Ketentuan untuk melanjutkan.');
                hasError = true;
            }

            if (hasError) return;

            // === Loading state ===
            btnRegister.disabled = true;
            btnRegister.innerHTML = '<svg class="animate-spin w-5 h-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

            // === Submit ke server ===
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: nama,
                    email: email,
                    password: password,
                    password_confirmation: confirmation,
                }),
            })
.then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Register berhasil — redirect ke dashboard
                    window.location.href = data.redirect_url;
                    return;
                }

                // Tampilkan error validasi dari server
                if (data.errors) {
                    if (data.errors.name)     showFieldError(namaInput, data.errors.name[0]);
                    if (data.errors.email)    showFieldError(emailInput, data.errors.email[0]);
                    if (data.errors.password) showFieldError(passwordInput, data.errors.password[0]);
                } else {
                    showToast(data.message || 'Terjadi kesalahan. Coba lagi.');
                }

                // Reset tombol
                btnRegister.disabled = false;
                btnRegister.innerHTML = 'Register <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
            })
            .catch(() => {
                showToast('Terjadi kesalahan. Coba lagi nanti.');
                btnRegister.disabled = false;
                btnRegister.innerHTML = 'Register <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
            });
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
        const wrapper = input.closest('.relative')?.parentElement || input.parentElement;
        wrapper.appendChild(errorEl);
    }

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
        });
    }

    function showToast(message) {
        alert(message); // bisa diganti toast custom nanti
    }
});