/**
 * HR Setting JS
 */
document.addEventListener('DOMContentLoaded', function () {
    const routes = window.hrSettingRoutes || {
        profile: '/hr/setting/profile',
        removeAvatar: '/hr/setting/avatar/remove',
        password: '/hr/setting/password',
        notifications: '/hr/setting/notifications',
        language: '/hr/setting/language',
        sessions: '/hr/setting/sessions',
        session: '/hr/setting/session',
    };

    const icons = {
        success: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/></svg>',
        error: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/></svg>',
        warning: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>',
        info: '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>',
    };

    function getToastContainer() {
        let container = document.getElementById('setting-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'setting-toast-container';
            container.className = 'fixed top-20 right-5 z-[80] w-[min(24rem,calc(100vw-2rem))] space-y-3';
            document.body.appendChild(container);
        }

        return container;
    }

    function notify(type, title, message = '') {
        const styles = {
            success: 'border-green-200 bg-green-50 text-green-700',
            error: 'border-red-200 bg-red-50 text-red-700',
            warning: 'border-amber-200 bg-amber-50 text-amber-700',
            info: 'border-blue-200 bg-blue-50 text-blue-700',
        };

        const toast = document.createElement('div');
        toast.className = 'translate-x-3 opacity-0 rounded-lg border bg-white p-4 shadow-xl transition-all duration-300';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg ${styles[type] || styles.info}">
                    ${icons[type] || icons.info}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">${title}</p>
                    ${message ? `<p class="mt-0.5 text-xs leading-5 text-gray-500 whitespace-pre-line">${message}</p>` : ''}
                </div>
                <button type="button" class="toast-close text-gray-400 hover:text-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
        `;

        getToastContainer().appendChild(toast);
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-3', 'opacity-0');
        });

        const close = () => {
            toast.classList.add('translate-x-3', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        };

        toast.querySelector('.toast-close')?.addEventListener('click', close);
        setTimeout(close, 4200);
    }

    function getErrorMessage(err, fallback = 'An error occurred. Please try again.') {
        if (err?.errors) {
            return Object.values(err.errors).flat().join('\n');
        }

        return err?.message || fallback;
    }

    function askConfirm({ title, message, confirmText = 'Yes, continue', cancelText = 'Cancel', variant = 'danger' }) {
        return new Promise(resolve => {
            const overlay = document.createElement('div');
            const confirmClass = variant === 'danger'
                ? 'bg-red-600 hover:bg-red-700'
                : 'bg-green-900 hover:bg-green-800';

            overlay.className = 'fixed inset-0 z-[90] flex items-center justify-center bg-black/45 px-4 opacity-0 transition-opacity duration-200';
            overlay.innerHTML = `
                <div class="w-full max-w-sm scale-95 rounded-xl bg-white p-6 shadow-2xl transition-transform duration-200">
                    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full ${variant === 'danger' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-700'}">
                        ${variant === 'danger' ? icons.warning : icons.info}
                    </div>
                    <h3 class="text-center text-lg font-bold text-gray-900">${title}</h3>
                    <p class="mt-2 text-center text-sm leading-6 text-gray-500">${message}</p>
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <button type="button" data-confirm-cancel class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50">${cancelText}</button>
                        <button type="button" data-confirm-ok class="rounded-lg px-4 py-2.5 text-sm font-semibold text-white transition-colors ${confirmClass}">${confirmText}</button>
                    </div>
                </div>
            `;

            const close = value => {
                overlay.classList.add('opacity-0');
                overlay.querySelector('div')?.classList.add('scale-95');
                setTimeout(() => {
                    overlay.remove();
                    resolve(value);
                }, 180);
            };

            document.body.appendChild(overlay);
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                overlay.querySelector('div')?.classList.remove('scale-95');
            });

            overlay.querySelector('[data-confirm-ok]')?.addEventListener('click', () => close(true));
            overlay.querySelector('[data-confirm-cancel]')?.addEventListener('click', () => close(false));
            overlay.addEventListener('click', e => {
                if (e.target === overlay) close(false);
            });
        });
    }

    // ===== AJAX HELPER WITH CSRF =====
    function sendAjax(url, data, method = 'POST') {
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        };
        
        let body;
        if (data instanceof FormData) {
            body = data;
            // Browser sets Content-Type automatically for FormData with boundary
        } else {
            headers['Content-Type'] = 'application/json';
            body = JSON.stringify(data);
        }

        return fetch(url, {
            method: method,
            headers: headers,
            body: body
        }).then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        });
    }

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
        if (file.size > 2 * 1024 * 1024) {
            notify('warning', 'File too large', 'Maximum profile photo size is 2MB.');
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photo-preview').src = e.target.result;
            document.getElementById('photo-preview').classList.remove('hidden');
            document.getElementById('photo-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('btn-remove-photo').addEventListener('click', async function () {
        const confirmed = await askConfirm({
            title: 'Remove profile photo?',
            message: 'Profile photo will be removed from your HR account.',
            confirmText: 'Yes, remove',
            cancelText: 'Cancel',
            variant: 'danger',
        });

        if (confirmed) {
            sendAjax(routes.removeAvatar, {}, 'POST')
                .then(res => {
                    document.getElementById('photo-preview').classList.add('hidden');
                    document.getElementById('photo-placeholder').classList.remove('hidden');
                    photoInput.value = '';
                    
                    // Update navbar avatar if exists
                    const navImg = document.getElementById('navbar-avatar-img');
                    if (navImg) {
                        const initials = document.createElement('span');
                        initials.id = 'navbar-avatar-initials';
                        initials.className = 'text-xs font-bold text-white';
                        
                        const userName = document.querySelector('input[name="name"]').value;
                        const words = userName.split(' ');
                        let initialsText = '';
                        words.forEach(w => {
                            initialsText += (w[0] || '').toUpperCase();
                        });
                        initials.textContent = initialsText.substring(0, 2);
                        navImg.parentNode.replaceChild(initials, navImg);
                    }
                    notify('success', 'Profile photo removed', 'Account avatar cleared successfully.');
                })
                .catch(err => {
                    notify('error', 'Failed to remove profile photo', getErrorMessage(err));
                });
        }
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
            const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
            for (let i = 1; i <= 4; i++) {
                const bar = document.getElementById('bar' + i);
                if (bar) bar.className = 'h-1 flex-1 rounded ' + (i <= score ? colors[score] : 'bg-gray-200');
            }
            const lbl = document.getElementById('strength-label');
            if (lbl) lbl.textContent = val.length ? 'Strength: ' + labels[score] : 'Minimum 8 characters.';
        });
    }

    // ===== SAVE BUTTON ANIMATION HELPER =====
    function showSaving(btn, originalText, callbackPromise, successTitle = 'Changes saved', successMessage = '') {
        btn.disabled = true;
        const spinner = '<svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
        btn.innerHTML = spinner + 'Saving...';
        
        return callbackPromise
            .then(res => {
                btn.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Saved!';
                btn.classList.add('bg-green-600');
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    btn.classList.remove('bg-green-600');
                }, 2000);
                notify('success', successTitle, successMessage);
                return res;
            })
            .catch(err => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                notify('error', 'Failed to save changes', getErrorMessage(err, 'Please check your inputs and try again.'));
                throw err;
            });
    }

    // Save Profile Form
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-profile');
            const originalText = btn.innerHTML;
            
            const formData = new FormData(this);
            const promise = sendAjax(routes.profile, formData);
            
            showSaving(btn, originalText, promise, 'Profile updated successfully', 'HR profile data has been updated.')
                .then(res => {
                    // Update layout elements dynamically
                    const navNames = document.querySelectorAll('.text-xs.font-semibold.text-white.leading-none, .text-sm.font-semibold.text-gray-800.truncate');
                    navNames.forEach(el => el.textContent = res.name);
                    
                    const jobTitleEl = document.querySelector('.text-\\[10px\\].text-green-300.leading-none.mt-0\\.5');
                    if (jobTitleEl) jobTitleEl.textContent = res.job_title || 'HR Staff';
                    
                    if (res.avatar_url) {
                        let navImg = document.getElementById('navbar-avatar-img');
                        if (!navImg) {
                            const initialsSpan = document.getElementById('navbar-avatar-initials');
                            if (initialsSpan) {
                                navImg = document.createElement('img');
                                navImg.id = 'navbar-avatar-img';
                                navImg.className = 'w-full h-full object-cover';
                                initialsSpan.parentNode.replaceChild(navImg, initialsSpan);
                            }
                        }
                        if (navImg) {
                            navImg.src = res.avatar_url;
                            navImg.alt = res.name;
                        }
                    }
                });
        });
    }

    // Discard changes
    const btnDiscard = document.getElementById('btn-discard');
    if (btnDiscard) {
        btnDiscard.addEventListener('click', async () => {
            const confirmed = await askConfirm({
                title: 'Discard changes?',
                message: 'Unsaved inputs will be reverted to the last saved state.',
                confirmText: 'Yes, discard',
                cancelText: 'Keep editing',
                variant: 'danger',
            });

            if (confirmed) location.reload();
        });
    }

    // Submit Password Form
    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = document.getElementById('btn-change-pass');
            const originalText = btn.innerHTML;
            
            const np = document.getElementById('new-pass').value;
            const cp = document.getElementById('conf-pass').value;
            if (np !== cp) {
                notify('warning', 'Password confirmation does not match', 'New password and confirmation must match.');
                return;
            }
            if (np.length < 8) {
                notify('warning', 'Password too short', 'Password must be at least 8 characters.');
                return;
            }

            const formData = {
                current_password: document.getElementById('cur-pass').value,
                password: np,
                password_confirmation: cp
            };

            const promise = sendAjax(routes.password, formData)
                .then(res => {
                    // Reset fields
                    document.getElementById('cur-pass').value = '';
                    document.getElementById('new-pass').value = '';
                    document.getElementById('conf-pass').value = '';
                    
                    // Reset strength meter
                    for (let i = 1; i <= 4; i++) {
                        const bar = document.getElementById('bar' + i);
                        if (bar) bar.className = 'h-1 flex-1 rounded bg-gray-200';
                    }
                    const lbl = document.getElementById('strength-label');
                    if (lbl) lbl.textContent = 'Minimum 8 characters.';
                    return res;
                });

            showSaving(btn, originalText, promise, 'Password changed successfully', 'Use your new password for subsequent logins.');
        });
    }

    // Save Notifications Preference
    const notifForm = document.getElementById('notif-form');
    if (notifForm) {
        notifForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-notif');
            const originalText = btn.innerHTML;
            
            const formData = {
                notif_new_applicant: this.querySelector('input[name="notif_new_applicant"]').checked ? 1 : 0,
                notif_interview_schedule: this.querySelector('input[name="notif_interview_schedule"]').checked ? 1 : 0,
                notif_vacancy_capacity: this.querySelector('input[name="notif_vacancy_capacity"]').checked ? 1 : 0,
                notif_vacancy_deadline: this.querySelector('input[name="notif_vacancy_deadline"]').checked ? 1 : 0
            };

            const promise = sendAjax(routes.notifications, formData);
            showSaving(btn, originalText, promise, 'Notification preferences saved', 'Notification settings have been updated.');
        });
    }



    // ===== UPDATE ALL BUTTON =====
    const btnUpdateAll = document.getElementById('btn-update-all');
    if (btnUpdateAll) {
        btnUpdateAll.addEventListener('click', function () {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Saving All...';

            const promises = [];
            
            if (profileForm) {
                const formData = new FormData(profileForm);
                promises.push(sendAjax(routes.profile, formData));
            }
            if (notifForm) {
                const formData = {
                    notif_new_applicant: notifForm.querySelector('input[name="notif_new_applicant"]').checked ? 1 : 0,
                    notif_interview_schedule: notifForm.querySelector('input[name="notif_interview_schedule"]').checked ? 1 : 0,
                    notif_vacancy_capacity: notifForm.querySelector('input[name="notif_vacancy_capacity"]').checked ? 1 : 0,
                    notif_vacancy_deadline: notifForm.querySelector('input[name="notif_vacancy_deadline"]').checked ? 1 : 0
                };
                promises.push(sendAjax(routes.notifications, formData));
            }

            Promise.all(promises)
                .then(results => {
                    const profileRes = results[0];
                    if (profileRes && profileRes.success) {
                        const navNames = document.querySelectorAll('.text-xs.font-semibold.text-white.leading-none, .text-sm.font-semibold.text-gray-800.truncate');
                        navNames.forEach(el => el.textContent = profileRes.name);
                        
                        const jobTitleEl = document.querySelector('.text-\\[10px\\].text-green-300.leading-none.mt-0\\.5');
                        if (jobTitleEl) jobTitleEl.textContent = profileRes.job_title || 'HR Staff';
                        
                        if (profileRes.avatar_url) {
                            let navImg = document.getElementById('navbar-avatar-img');
                            if (!navImg) {
                                const initialsSpan = document.getElementById('navbar-avatar-initials');
                                if (initialsSpan) {
                                    navImg = document.createElement('img');
                                    navImg.id = 'navbar-avatar-img';
                                    navImg.className = 'w-full h-full object-cover';
                                    initialsSpan.parentNode.replaceChild(navImg, initialsSpan);
                                }
                            }
                            if (navImg) {
                                navImg.src = profileRes.avatar_url;
                                navImg.alt = profileRes.name;
                            }
                        }
                    }
                    
                    btn.innerHTML = '<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Saved All!';
                    btn.classList.add('bg-green-600');
                    notify('success', 'All settings saved', 'Profile and notifications updated successfully.');
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                        btn.classList.remove('bg-green-600');
                    }, 2000);
                })
                .catch(err => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    let msg = 'Failed to save some settings.';
                    if (err.errors) {
                        msg = Object.values(err.errors).flat().join('\n');
                    } else if (err.message) {
                        msg = err.message;
                    }
                    notify('error', 'Failed to save all settings', getErrorMessage(err, 'Some settings could not be saved.'));
                });
        });
    }

    // ===== SESSION LOGOUT =====
    let targetSessionId = null;
    let targetSessionElId = null;

    // Logout single device click
    document.querySelectorAll('.btn-logout-device').forEach(btn => {
        btn.addEventListener('click', function () {
            targetSessionId = this.dataset.id;
            targetSessionElId = this.dataset.session;
            document.getElementById('modal-device-name').textContent = this.dataset.device;
            document.getElementById('modal-logout-device').classList.remove('hidden');
        });
    });

    document.getElementById('btn-confirm-session-logout')?.addEventListener('click', function () {
        if (targetSessionId) {
            sendAjax(`${routes.session}/${targetSessionId}`, {}, 'DELETE')
                .then(res => {
                    const el = document.getElementById(targetSessionElId);
                    if (el) {
                        el.style.transition = 'opacity 0.3s';
                        el.style.opacity = '0';
                        setTimeout(() => {
                            el.remove();
                            // Check if only current session remains
                            const remainingLogoutButtons = document.querySelectorAll('.btn-logout-device');
                            if (remainingLogoutButtons.length === 0) {
                                document.getElementById('no-sessions').classList.remove('hidden');
                            }
                        }, 300);
                    }
                    notify('success', 'Device logged out successfully', 'The session on that device has been terminated.');
                })
                .catch(err => {
                    notify('error', 'Failed to terminate device session', getErrorMessage(err));
                });
        }
        document.getElementById('modal-logout-device').classList.add('hidden');
        targetSessionId = null;
        targetSessionElId = null;
    });

    document.getElementById('btn-close-session-modal')?.addEventListener('click', () => document.getElementById('modal-logout-device').classList.add('hidden'));
    document.getElementById('btn-cancel-session-modal')?.addEventListener('click', () => document.getElementById('modal-logout-device').classList.add('hidden'));
    document.getElementById('modal-logout-device')?.addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });

    // Logout all other devices click
    document.getElementById('btn-logout-all')?.addEventListener('click', () => document.getElementById('modal-logout-all').classList.remove('hidden'));

    document.getElementById('btn-confirm-all-logout')?.addEventListener('click', function () {
        sendAjax(routes.sessions, {}, 'DELETE')
            .then(res => {
                document.querySelectorAll('.btn-logout-device').forEach(btn => {
                    const el = document.getElementById(btn.dataset.session);
                    if (el) {
                        el.style.transition = 'opacity 0.3s';
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 300);
                    }
                });
                setTimeout(() => document.getElementById('no-sessions').classList.remove('hidden'), 400);
                notify('success', 'All other devices logged out', 'Sessions on other devices have been terminated.');
            })
            .catch(err => {
                notify('error', 'Failed to terminate all sessions', getErrorMessage(err));
            });
        document.getElementById('modal-logout-all').classList.add('hidden');
    });

    document.getElementById('btn-close-all-modal')?.addEventListener('click', () => document.getElementById('modal-logout-all').classList.add('hidden'));
    document.getElementById('btn-cancel-all-modal')?.addEventListener('click', () => document.getElementById('modal-logout-all').classList.add('hidden'));
    document.getElementById('modal-logout-all')?.addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });

    // Sidebar Logout confirmation
    const btnLogout = document.getElementById('btn-logout');
    if (btnLogout) {
        btnLogout.addEventListener('click', async function () {
            const confirmed = await askConfirm({
                title: 'Logout from HR Panel?',
                message: 'You will need to log back in to access the HR panel.',
                confirmText: 'Yes, logout',
                cancelText: 'Cancel',
                variant: 'danger',
            });

            if (confirmed) {
                document.getElementById('sidebar-logout-form').submit();
            }
        });
    }
});
