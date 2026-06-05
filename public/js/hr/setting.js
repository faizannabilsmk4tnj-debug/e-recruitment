/**
 * HR Setting JS
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== TAB SWITCHING =====
    document.querySelectorAll('.setting-tab').forEach(btn => {
        btn.addEventListener('click', function () {
            const tab = this.dataset.tab;

            document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
            document.getElementById('tab-' + tab).classList.remove('hidden');

            document.querySelectorAll('.setting-tab').forEach(b => {
                b.classList.remove('text-green-800', 'bg-green-50');
                b.classList.add('text-gray-600');
            });
            this.classList.add('text-green-800', 'bg-green-50');
            this.classList.remove('text-gray-600');
        });
    });

    // ===== PHOTO UPLOAD =====
    const photoInput = document.getElementById('photo-input');
    document.getElementById('btn-photo-edit').addEventListener('click', () => photoInput.click());
    document.getElementById('btn-upload-photo').addEventListener('click', () => photoInput.click());

    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) { alert('Ukuran file maksimal 2MB'); return; }
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photo-preview').src = e.target.result;
            document.getElementById('photo-preview').classList.remove('hidden');
            document.getElementById('photo-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('btn-remove-photo').addEventListener('click', function () {
        document.getElementById('photo-preview').classList.add('hidden');
        document.getElementById('photo-placeholder').classList.remove('hidden');
        photoInput.value = '';
    });

    // ===== TOGGLE PASSWORD =====
    document.querySelectorAll('.toggle-pass').forEach(btn => {
        btn.addEventListener('click', function () {
            const el = document.getElementById(this.dataset.target);
            el.type = el.type === 'password' ? 'text' : 'password';
        });
    });

    // ===== PASSWORD STRENGTH =====
    const newPass = document.getElementById('new-pass');
    if (newPass) {
        newPass.addEventListener('input', function () {
            const val = this.value;
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const colors = ['', 'bg-red-400', 'bg-yellow-400', 'bg-blue-400', 'bg-green-500'];
            const labels = ['', 'Lemah', 'Cukup', 'Baik', 'Kuat'];
            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById('bar' + i);
                if (bar) bar.className = 'h-1 flex-1 rounded ' + (i <= score ? colors[score] : 'bg-gray-200');
            }
            const lbl = document.getElementById('strength-label');
            if (lbl) lbl.textContent = val.length ? 'Kekuatan: ' + labels[score] : 'Minimal 8 karakter, kombinasi huruf dan angka.';
        });
    }

    // ===== SAVE BUTTON HELPER =====
    function showSaving(btn, originalText) {
        btn.disabled = true;
        btn.innerHTML = '<svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Saving...';
        setTimeout(() => {
            btn.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Saved!';
            btn.classList.add('bg-green-600');
            setTimeout(() => {
                btn.textContent = originalText;
                btn.disabled = false;
                btn.classList.remove('bg-green-600');
            }, 2000);
        }, 1200);
    }

    // Save Profile
    const btnSaveProfile = document.getElementById('btn-save-profile');
    if (btnSaveProfile) btnSaveProfile.addEventListener('click', () => showSaving(btnSaveProfile, 'Save Profile'));

    // Discard
    const btnDiscard = document.getElementById('btn-discard');
    if (btnDiscard) btnDiscard.addEventListener('click', () => { if (confirm('Batalkan semua perubahan?')) location.reload(); });

    // Update All
    const btnUpdateAll = document.getElementById('btn-update-all');
    if (btnUpdateAll) btnUpdateAll.addEventListener('click', () => showSaving(btnUpdateAll, 'Update All'));

    // Change Password
    const btnChangePass = document.getElementById('btn-change-pass');
    if (btnChangePass) {
        btnChangePass.addEventListener('click', function () {
            const np = document.getElementById('new-pass')?.value;
            const cp = document.getElementById('conf-pass')?.value;
            if (np !== cp) { alert('Password baru dan konfirmasi tidak cocok.'); return; }
            if (np.length < 8) { alert('Password minimal 8 karakter.'); return; }
            showSaving(this, 'Update Password');
        });
    }

    // Save Notif
    const btnSaveNotif = document.getElementById('btn-save-notif');
    if (btnSaveNotif) btnSaveNotif.addEventListener('click', () => showSaving(btnSaveNotif, 'Save Preferences'));

    // Save Language
    const btnSaveLang = document.getElementById('btn-save-lang');
    if (btnSaveLang) btnSaveLang.addEventListener('click', () => showSaving(btnSaveLang, 'Save Language'));

    // ===== LANGUAGE SELECTOR =====
    document.querySelectorAll('.lang-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.lang-btn').forEach(b => {
                b.classList.remove('border-green-700', 'bg-green-50', 'active-lang');
                b.classList.add('border-gray-200');
                const txt = b.querySelector('span.text-sm');
                if (txt) txt.className = 'text-sm font-medium text-gray-600';
                const check = b.querySelector('svg');
                if (check && !b.querySelector('.text-xl + svg')) check.remove();
            });
            this.classList.add('border-green-700', 'bg-green-50', 'active-lang');
            this.classList.remove('border-gray-200');
            const txt = this.querySelector('span.text-sm');
            if (txt) txt.className = 'text-sm font-medium text-green-800';
        });
    });

    // ===== SESSION LOGOUT =====
    let targetSession = null;

    // Logout single device
    document.querySelectorAll('.btn-logout-device').forEach(btn => {
        btn.addEventListener('click', function () {
            targetSession = this.dataset.session;
            document.getElementById('modal-device-name').textContent = this.dataset.device;
            document.getElementById('modal-logout-device').classList.remove('hidden');
        });
    });

    document.getElementById('btn-confirm-session-logout')?.addEventListener('click', function () {
        if (targetSession) {
            const el = document.getElementById(targetSession);
            if (el) el.style.transition = 'opacity 0.3s', el.style.opacity = '0', setTimeout(() => {
                el.remove();
                // Show empty state if no more sessions
                const remaining = document.querySelectorAll('.btn-logout-device');
                if (remaining.length === 0) document.getElementById('no-sessions').classList.remove('hidden');
            }, 300);
        }
        document.getElementById('modal-logout-device').classList.add('hidden');
        targetSession = null;
    });

    document.getElementById('btn-close-session-modal')?.addEventListener('click', () => document.getElementById('modal-logout-device').classList.add('hidden'));
    document.getElementById('btn-cancel-session-modal')?.addEventListener('click', () => document.getElementById('modal-logout-device').classList.add('hidden'));
    document.getElementById('modal-logout-device')?.addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });

    // Logout all devices
    document.getElementById('btn-logout-all')?.addEventListener('click', () => document.getElementById('modal-logout-all').classList.remove('hidden'));

    document.getElementById('btn-confirm-all-logout')?.addEventListener('click', function () {
        document.querySelectorAll('.btn-logout-device').forEach(btn => {
            const el = document.getElementById(btn.dataset.session);
            if (el) el.style.transition = 'opacity 0.3s', el.style.opacity = '0', setTimeout(() => el.remove(), 300);
        });
        setTimeout(() => document.getElementById('no-sessions').classList.remove('hidden'), 400);
        document.getElementById('modal-logout-all').classList.add('hidden');
    });

    document.getElementById('btn-close-all-modal')?.addEventListener('click', () => document.getElementById('modal-logout-all').classList.add('hidden'));
    document.getElementById('btn-cancel-all-modal')?.addEventListener('click', () => document.getElementById('modal-logout-all').classList.add('hidden'));
    document.getElementById('modal-logout-all')?.addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });
    const btnLogout = document.getElementById('btn-logout');
    if (btnLogout) {
        btnLogout.addEventListener('click', function (e) {
            if (!confirm('Yakin ingin keluar dari HR Panel?')) {
                e.preventDefault();
            }
        });
    }
});