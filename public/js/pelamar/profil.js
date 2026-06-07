/**
 * Pelamar Profil JS
 * Features: foto preview, copy alamat KTP, hitung umur otomatis, submit state.
 */

document.addEventListener('DOMContentLoaded', function () {
    const fotoInput = document.getElementById('foto-input');
    const avatarPreview = document.getElementById('avatar-preview');

    if (fotoInput && avatarPreview) {
        fotoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file melebihi 2MB. Silakan pilih foto lain.');
                fotoInput.value = '';
                return;
            }

            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                alert('Format file harus JPG atau PNG.');
                fotoInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (readerEvent) {
                avatarPreview.innerHTML = '<img src="' + readerEvent.target.result + '" alt="Foto Profil" class="w-full h-full object-cover">';
            };
            reader.readAsDataURL(file);
        });
    }

    const samaKtp = document.getElementById('sama-ktp');
    const ktpFields = ['provinsi', 'kota', 'kecamatan', 'kelurahan', 'alamat'];

    function syncDomisiliWithKtp() {
        ktpFields.forEach(function (field) {
            const ktpInput = document.getElementById('ktp-' + field);
            const domInput = document.getElementById('dom-' + field);
            if (!ktpInput || !domInput) return;

            if (samaKtp.checked) {
                domInput.value = ktpInput.value;
                domInput.readOnly = true;
                domInput.classList.add('bg-gray-100', 'text-gray-500');
            } else {
                domInput.readOnly = false;
                domInput.classList.remove('bg-gray-100', 'text-gray-500');
            }
        });
    }

    if (samaKtp) {
        samaKtp.addEventListener('change', syncDomisiliWithKtp);

        ktpFields.forEach(function (field) {
            const ktpInput = document.getElementById('ktp-' + field);
            if (!ktpInput) return;

            ktpInput.addEventListener('input', function () {
                if (samaKtp.checked) {
                    syncDomisiliWithKtp();
                }
            });
        });
    }

    const tanggalLahir = document.getElementById('tanggal-lahir');
    const umurInput = document.getElementById('umur');

    function calculateAge() {
        if (!tanggalLahir || !umurInput || !tanggalLahir.value) return;

        const birthDate = new Date(tanggalLahir.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        umurInput.value = age > 0 && age < 100 ? age : '';
    }

    if (tanggalLahir) {
        tanggalLahir.addEventListener('change', calculateAge);
        calculateAge();
    }

    const nikInput = document.getElementById('nik');
    if (nikInput) {
        nikInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    }

    const btnSimpan = document.getElementById('btn-simpan');
    const form = btnSimpan ? btnSimpan.closest('form') : null;

    if (form && btnSimpan) {
        form.addEventListener('submit', function () {
            btnSimpan.disabled = true;
            btnSimpan.classList.add('opacity-75', 'cursor-not-allowed');
            btnSimpan.textContent = 'Saving...';
        });
    }
});
