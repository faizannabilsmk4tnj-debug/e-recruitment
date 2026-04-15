/**
 * Pelamar Profil JS
 * Functional features: foto preview, copy alamat KTP, hitung umur otomatis
 */

document.addEventListener('DOMContentLoaded', function () {

    // ===== FOTO PROFIL PREVIEW =====
    const fotoInput = document.getElementById('foto-input');
    const avatarPreview = document.getElementById('avatar-preview');

    if (fotoInput) {
        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi ukuran (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file melebihi 2MB. Silakan pilih foto lain.');
                fotoInput.value = '';
                return;
            }

            // Validasi format
            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                alert('Format file harus JPG atau PNG.');
                fotoInput.value = '';
                return;
            }

            // Preview
            const reader = new FileReader();
            reader.onload = function (e) {
                avatarPreview.innerHTML = '<img src="' + e.target.result + '" alt="Foto Profil" class="w-full h-full object-cover">';
            };
            reader.readAsDataURL(file);
        });
    }

    // ===== SAMA DENGAN KTP CHECKBOX =====
    const samaKtp = document.getElementById('sama-ktp');
    const ktpFields = ['provinsi', 'kota', 'kecamatan', 'kelurahan', 'alamat'];

    if (samaKtp) {
        samaKtp.addEventListener('change', function () {
            ktpFields.forEach(field => {
                const ktpInput = document.getElementById('ktp-' + field);
                const domInput = document.getElementById('dom-' + field);
                if (samaKtp.checked) {
                    domInput.value = ktpInput.value;
                    domInput.readOnly = true;
                    domInput.classList.add('bg-gray-100', 'text-gray-500');
                } else {
                    domInput.readOnly = false;
                    domInput.classList.remove('bg-gray-100', 'text-gray-500');
                }
            });
        });

        // Sync real-time saat KTP diketik dan checkbox aktif
        ktpFields.forEach(field => {
            const ktpInput = document.getElementById('ktp-' + field);
            if (ktpInput) {
                ktpInput.addEventListener('input', function () {
                    if (samaKtp.checked) {
                        document.getElementById('dom-' + field).value = ktpInput.value;
                    }
                });
            }
        });
    }

    // ===== HITUNG UMUR OTOMATIS =====
    const tanggalLahir = document.getElementById('tanggal-lahir');
    const umurInput = document.getElementById('umur');

    if (tanggalLahir) {
        tanggalLahir.addEventListener('change', function () {
            const birthDate = new Date(tanggalLahir.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (age > 0 && age < 100) {
                umurInput.value = age;
            }
        });
    }

    // ===== NIK FORMAT (hanya angka, max 16 digit) =====
    const nikInput = document.getElementById('nik');
    if (nikInput) {
        nikInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    }

    // ===== SIMPAN PERUBAHAN =====
    const btnSimpan = document.getElementById('btn-simpan');
    if (btnSimpan) {
        btnSimpan.addEventListener('click', function () {
            // TODO: AJAX simpan ke API
            // const formData = new FormData();
            // formData.append('nik', document.getElementById('nik').value);
            // formData.append('nama', document.getElementById('nama').value);
            // ... dst
            //
            // fetch('/api/pelamar/profil', {
            //     method: 'PUT',
            //     headers: { 'Authorization': 'Bearer ' + localStorage.getItem('token') },
            //     body: formData
            // })
            // .then(res => res.json())
            // .then(data => { ... });

            // Feedback sementara
            btnSimpan.textContent = '✓ Tersimpan!';
            btnSimpan.classList.remove('bg-green-800', 'hover:bg-green-700');
            btnSimpan.classList.add('bg-green-600');
            setTimeout(() => {
                btnSimpan.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg> Simpan Perubahan';
                btnSimpan.classList.remove('bg-green-600');
                btnSimpan.classList.add('bg-green-800', 'hover:bg-green-700');
            }, 2000);
        });
    }

    console.log('Profil page loaded');
});