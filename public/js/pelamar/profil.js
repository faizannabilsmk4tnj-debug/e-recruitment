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
                alert('File size exceeds 2MB. Please select another photo.');
                fotoInput.value = '';
                return;
            }

            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                alert('File format must be JPG or PNG.');
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

    // ===== POPUP LEAVE CONFIRMATION & PROFILE INCOMPLETE DETECTION =====
    let isDirty = false;
    let isSubmitting = false;

    // Track dirty state of form fields
    const formFields = document.querySelectorAll('form input, form select, form textarea');
    formFields.forEach(field => {
        if (field.type === 'hidden') return;
        
        field.addEventListener('input', () => {
            isDirty = true;
        });
        field.addEventListener('change', () => {
            isDirty = true;
        });
    });

    // Mark clean when forms are submitted (excluding logout)
    document.querySelectorAll('form').forEach(f => {
        f.addEventListener('submit', () => {
            if (f.id !== 'logout-form') {
                isSubmitting = true;
                isDirty = false;
            }
        });
    });

    // Check if the profile is incomplete (has empty fields)
    function isProfileIncomplete() {
        const requiredFields = [
            'nik', 'nama', 'jenis-kelamin', 'telepon', 'email',
            'tempat-lahir', 'tanggal-lahir', 'status-nikah',
            'pendidikan', 'sekolah', 'selesai-pendidikan', 'ipk',
            'ktp-provinsi', 'ktp-kota', 'ktp-kecamatan', 'ktp-kelurahan', 'ktp-alamat',
            'dom-provinsi', 'dom-kota', 'dom-kecamatan', 'dom-kelurahan', 'dom-alamat'
        ];
        
        for (const id of requiredFields) {
            const el = document.getElementById(id);
            if (el && !el.value.trim()) {
                return true; // Profile is incomplete
            }
        }
        return false;
    }

    // Modal management logic
    let pendingTarget = null;

    window.closeLeaveConfirmModal = function() {
        const modal = document.getElementById('leave-confirm-modal');
        const panel = document.getElementById('leave-confirm-panel');
        if (!modal || !panel) return;
        
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            pendingTarget = null;
        }, 300);
    };

    function showLeaveConfirmModal(target) {
        pendingTarget = target;
        const modal = document.getElementById('leave-confirm-modal');
        const panel = document.getElementById('leave-confirm-panel');
        if (!modal || !panel) return;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger transition
        void modal.offsetWidth;
        panel.classList.remove('scale-95', 'opacity-0');
        panel.classList.add('scale-100', 'opacity-100');
    }

    const btnConfirmLeave = document.getElementById('btn-confirm-leave');
    if (btnConfirmLeave) {
        btnConfirmLeave.addEventListener('click', () => {
            isDirty = false;
            closeLeaveConfirmModal();
            
            if (typeof pendingTarget === 'function') {
                pendingTarget();
            } else if (typeof pendingTarget === 'string') {
                window.location.href = pendingTarget;
            }
        });
    }

    // Intercept local link navigation
    document.addEventListener('click', function (event) {
        const anchor = event.target.closest('a');
        if (!anchor) return;
        
        const href = anchor.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
        if (anchor.target === '_blank') return;
        
        // Check if navigation is actually leaving the profile edit path
        const currentUrl = new URL(window.location.href);
        const targetUrl = new URL(href, window.location.href);
        if (currentUrl.pathname === targetUrl.pathname && currentUrl.search === targetUrl.search) {
            return; // Same page navigation
        }
        
        if (isDirty) {
            event.preventDefault();
            showLeaveConfirmModal(href);
        }
    });

    // Intercept logout form submission
    const logoutForm = document.getElementById('logout-form');
    if (logoutForm) {
        logoutForm.addEventListener('submit', function (event) {
            if (isDirty) {
                event.preventDefault();
                showLeaveConfirmModal(() => {
                    logoutForm.submit();
                });
            }
        });
    }

    // Intercept browser close / refresh / back-forward
    window.addEventListener('beforeunload', function (e) {
        if (isDirty && !isSubmitting) {
            e.preventDefault();
            e.returnValue = 'The data you just entered has not been saved and will be reset (lost) if you leave this page. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
});
