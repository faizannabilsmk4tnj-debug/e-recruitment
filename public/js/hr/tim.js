/**
 * Tim HR JS - Database Integrated (Inline Validation & JSON Accept Version)
 */
document.addEventListener('DOMContentLoaded', function () {

    const dropdown = document.getElementById('action-dropdown');
    let activeRow = null;

    const csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenEl ? csrfTokenEl.getAttribute('content') : '';

    console.log("tim.js loaded. CSRF Token present:", !!csrfToken);

    // ===== ERROR INJECTION UTILITIES =====
    const showTambahError = (msg) => {
        const errEl = document.getElementById('tambah-error');
        if (errEl) {
            errEl.textContent = msg;
            errEl.classList.remove('hidden');
        }
    };

    const hideTambahError = () => {
        const errEl = document.getElementById('tambah-error');
        if (errEl) {
            errEl.classList.add('hidden');
            errEl.textContent = '';
        }
    };

    const showEditError = (msg) => {
        const errEl = document.getElementById('edit-error');
        if (errEl) {
            errEl.textContent = msg;
            errEl.classList.remove('hidden');
        }
    };

    const hideEditError = () => {
        const errEl = document.getElementById('edit-error');
        if (errEl) {
            errEl.classList.add('hidden');
            errEl.textContent = '';
        }
    };

    // ===== SEARCH =====
    const searchInput = document.getElementById('search-member');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.member-row').forEach(row => {
                const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
                const email = row.dataset.email ? row.dataset.email.toLowerCase() : '';
                row.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
            });
        });
    }

    // ===== TOGGLE STATUS =====
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const row = this.closest('.member-row');
            if (!row) return;
            
            const id = row.dataset.id;
            const isChecked = this.checked;
            const label = this.closest('td').querySelector('.status-label');

            console.log("Toggling status for member ID:", id, "New Status:", isChecked);

            fetch(`/hr/tim/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ is_active: isChecked })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Toggle status response received:", data);
                if (data.redirect) {
                    alert(data.message || 'Your account has been deactivated by HR Master.');
                    window.location.href = data.redirect;
                    return;
                }
                if (data.success) {
                    if (data.is_active) {
                        label.textContent = 'ACTIVE';
                        label.className = 'text-xs font-semibold text-green-700 status-label';
                    } else {
                        label.textContent = 'INACTIVE';
                        label.className = 'text-xs font-semibold text-gray-400 status-label';
                    }
                } else {
                    this.checked = !isChecked; // Revert
                    alert(data.message || 'Failed to update status.');
                }
            })
            .catch(err => {
                console.error("Failed to toggle status:", err);
                this.checked = !isChecked; // Revert
                alert('An error occurred while updating status.');
            });
        });
    });

    // ===== ACTION DROPDOWN =====
    function openDropdown(btn, row) {
        if (!dropdown) return;
        activeRow = row;
        const rect = btn.getBoundingClientRect();
        dropdown.style.position = 'fixed';
        dropdown.style.top = (rect.bottom + window.scrollY + 4) + 'px';
        dropdown.style.left = 'auto';
        dropdown.style.right = (window.innerWidth - rect.right) + 'px';
        dropdown.classList.toggle('hidden');
    }

    document.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openDropdown(this, this.closest('.member-row'));
        });
    });

    document.addEventListener('click', () => {
        if (dropdown) dropdown.classList.add('hidden');
    });
    if (dropdown) {
        dropdown.addEventListener('click', e => e.stopPropagation());
    }

    // ===== EDIT ANGGOTA =====
    const actionEdit = document.getElementById('action-edit');
    if (actionEdit) {
        actionEdit.addEventListener('click', function () {
            if (!activeRow) return;
            if (dropdown) dropdown.classList.add('hidden');

            hideEditError();

            const editName = document.getElementById('edit-name');
            const editEmail = document.getElementById('edit-email');
            const editPass = document.getElementById('edit-pass');
            const modalEdit = document.getElementById('modal-edit');

            if (editName) editName.value = activeRow.dataset.name || '';
            if (editEmail) editEmail.value = activeRow.dataset.email || '';
            if (editPass) editPass.value = '';

            if (modalEdit) modalEdit.classList.remove('hidden');
        });
    }

    const btnSaveEdit = document.getElementById('btn-save-edit');
    if (btnSaveEdit) {
        btnSaveEdit.addEventListener('click', function () {
            if (!activeRow) return;
            hideEditError();

            const id = activeRow.dataset.id;
            const nameEl = document.getElementById('edit-name');
            const emailEl = document.getElementById('edit-email');
            const passEl = document.getElementById('edit-pass');

            const name = nameEl ? nameEl.value.trim() : '';
            const email = emailEl ? emailEl.value.trim() : '';
            const pass = passEl ? passEl.value : '';

            console.log("Saving changes for member ID:", id, { name, email, passLength: pass.length });

            if (!name || !email) { showEditError('Name and email are required.'); return; }
            if (pass && pass.length < 8) { showEditError('Password must be at least 8 characters.'); return; }

            fetch(`/hr/tim/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name, email, password: pass })
            })
            .then(res => {
                return res.json().then(data => ({ status: res.status, body: data }));
            })
            .then(({ status, body }) => {
                console.log("Edit member response received:", body);
                if (body && body.redirect) {
                    alert(body.message || 'Your account has been deactivated by HR Master.');
                    window.location.href = body.redirect;
                    return;
                }
                if (status === 200 && body.success) {
                    window.location.reload();
                } else {
                    let errMsg = body.message || 'Failed to update member.';
                    if (body.errors) {
                        const firstKey = Object.keys(body.errors)[0];
                        if (firstKey && body.errors[firstKey].length > 0) {
                            errMsg = body.errors[firstKey][0];
                        }
                    }
                    showEditError(errMsg);
                }
            })
            .catch(err => {
                console.error("Failed to edit member:", err);
                showEditError('An error occurred while saving changes.');
            });
        });
    }

    const closeEdit = () => {
        const modalEdit = document.getElementById('modal-edit');
        if (modalEdit) modalEdit.classList.add('hidden');
        hideEditError();
    };
    const btnCloseEdit = document.getElementById('btn-close-edit');
    const btnCancelEdit = document.getElementById('btn-cancel-edit');
    if (btnCloseEdit) btnCloseEdit.addEventListener('click', closeEdit);
    if (btnCancelEdit) btnCancelEdit.addEventListener('click', closeEdit);
    
    const modalEdit = document.getElementById('modal-edit');
    if (modalEdit) {
        modalEdit.addEventListener('click', function (e) {
            if (e.target === this) closeEdit();
        });
    }

    // ===== HAPUS ANGGOTA =====
    const actionHapus = document.getElementById('action-hapus');
    if (actionHapus) {
        actionHapus.addEventListener('click', function () {
            if (!activeRow) return;
            const hapusName = document.getElementById('hapus-name');
            if (hapusName) hapusName.textContent = activeRow.dataset.name || '';
            
            const modalHapus = document.getElementById('modal-hapus');
            if (modalHapus) modalHapus.classList.remove('hidden');
            if (dropdown) dropdown.classList.add('hidden');
        });
    }

    const btnConfirmHapus = document.getElementById('btn-confirm-hapus');
    if (btnConfirmHapus) {
        btnConfirmHapus.addEventListener('click', function () {
            if (!activeRow) return;
            const id = activeRow.dataset.id;

            console.log("Confirming deletion of member ID:", id);

            fetch(`/hr/tim/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                console.log("Delete member response received:", data);
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to delete member.');
                }
            })
            .catch(err => {
                console.error("Failed to delete member:", err);
                alert('An error occurred while removing the member.');
            });
        });
    }

    const closeHapus = () => {
        const modalHapus = document.getElementById('modal-hapus');
        if (modalHapus) modalHapus.classList.add('hidden');
    };
    const btnCloseHapus = document.getElementById('btn-close-hapus');
    const btnCancelHapus = document.getElementById('btn-cancel-hapus');
    if (btnCloseHapus) btnCloseHapus.addEventListener('click', closeHapus);
    if (btnCancelHapus) btnCancelHapus.addEventListener('click', closeHapus);
    
    const modalHapus = document.getElementById('modal-hapus');
    if (modalHapus) {
        modalHapus.addEventListener('click', function (e) {
            if (e.target === this) closeHapus();
        });
    }

    // ===== TAMBAH ANGGOTA =====
    const btnTambahAnggota = document.getElementById('btn-tambah-anggota');
    if (btnTambahAnggota) {
        btnTambahAnggota.addEventListener('click', () => {
            hideTambahError();
            const modalTambah = document.getElementById('modal-tambah');
            if (modalTambah) modalTambah.classList.remove('hidden');
        });
    }

    const closeTambah = () => {
        const modalTambah = document.getElementById('modal-tambah');
        if (modalTambah) modalTambah.classList.add('hidden');
        hideTambahError();
    };
    const btnCloseTambah = document.getElementById('btn-close-tambah');
    const btnCancelTambah = document.getElementById('btn-cancel-tambah');
    if (btnCloseTambah) btnCloseTambah.addEventListener('click', closeTambah);
    if (btnCancelTambah) btnCancelTambah.addEventListener('click', closeTambah);
    
    const modalTambah = document.getElementById('modal-tambah');
    if (modalTambah) {
        modalTambah.addEventListener('click', function (e) {
            if (e.target === this) closeTambah();
        });
    }

    const btnSaveTambah = document.getElementById('btn-save-tambah');
    if (btnSaveTambah) {
        btnSaveTambah.addEventListener('click', function () {
            console.log("Add Member button clicked.");
            hideTambahError();

            const nameEl = document.getElementById('new-name');
            const emailEl = document.getElementById('new-email');
            const passEl = document.getElementById('new-pass');

            const name = nameEl ? nameEl.value.trim() : '';
            const email = emailEl ? emailEl.value.trim() : '';
            const pass = passEl ? passEl.value : '';

            console.log("Captured member data to add:", { name, email, passLength: pass.length });

            if (!name || !email || !pass) {
                showTambahError('All fields are required.');
                return;
            }
            if (pass.length < 8) {
                showTambahError('Password must be at least 8 characters.');
                return;
            }
            if (!email.includes('@')) {
                showTambahError('Invalid email format.');
                return;
            }

            console.log("Sending POST fetch request to /hr/tim...");
            fetch('/hr/tim', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name, email, password: pass })
            })
            .then(res => {
                return res.json().then(data => ({ status: res.status, body: data }));
            })
            .then(({ status, body }) => {
                console.log("Add member request completed with status:", status, "body:", body);
                if (body && body.redirect) {
                    alert(body.message || 'Your account has been deactivated by HR Master.');
                    window.location.href = body.redirect;
                    return;
                }
                if (status === 200 && body.success) {
                    window.location.reload();
                } else {
                    let errMsg = body.message || 'Failed to add member.';
                    if (body.errors) {
                        const firstKey = Object.keys(body.errors)[0];
                        if (firstKey && body.errors[firstKey].length > 0) {
                            errMsg = body.errors[firstKey][0];
                        }
                    }
                    showTambahError(errMsg);
                }
            })
            .catch(err => {
                console.error("Add member request failed:", err);
                showTambahError('An error occurred while adding the member.');
            });
        });
    }
});