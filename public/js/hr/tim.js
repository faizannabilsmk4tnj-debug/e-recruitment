/**
 * Tim HR JS
 */
document.addEventListener('DOMContentLoaded', function () {

    const dropdown   = document.getElementById('action-dropdown');
    let activeRow    = null;

    // ===== SEARCH =====
    document.getElementById('search-member').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.member-row').forEach(row => {
            const name  = row.dataset.name.toLowerCase();
            const email = row.dataset.email.toLowerCase();
            row.style.display = (name.includes(q) || email.includes(q)) ? '' : 'none';
        });
    });

    // ===== TOGGLE STATUS =====
    document.querySelectorAll('.toggle-status').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const label = this.closest('td').querySelector('.status-label');
            if (this.checked) {
                label.textContent = 'AKTIF';
                label.className = 'text-xs font-semibold text-green-700 status-label';
            } else {
                label.textContent = 'NONAKTIF';
                label.className = 'text-xs font-semibold text-gray-400 status-label';
            }
        });
    });

    // ===== ACTION DROPDOWN =====
    function openDropdown(btn, row) {
        activeRow = row;
        const rect = btn.getBoundingClientRect();
        dropdown.style.top  = (rect.bottom + window.scrollY + 4) + 'px';
        dropdown.style.right = (window.innerWidth - rect.right) + 'px';
        dropdown.classList.toggle('hidden');
    }

    document.querySelectorAll('.btn-action').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openDropdown(this, this.closest('.member-row'));
        });
    });

    document.addEventListener('click', () => dropdown.classList.add('hidden'));
    dropdown.addEventListener('click', e => e.stopPropagation());

    // ===== EDIT ANGGOTA =====
    document.getElementById('action-edit').addEventListener('click', function () {
        if (!activeRow) return;
        dropdown.classList.add('hidden');

        // Pre-fill modal dengan data existing
        document.getElementById('edit-name').value  = activeRow.dataset.name;
        document.getElementById('edit-email').value = activeRow.dataset.email;
        document.getElementById('edit-role').value  = activeRow.dataset.role;
        document.getElementById('edit-pass').value  = '';

        document.getElementById('modal-edit').classList.remove('hidden');
    });

    document.getElementById('btn-save-edit').addEventListener('click', function () {
        const name  = document.getElementById('edit-name').value.trim();
        const email = document.getElementById('edit-email').value.trim();
        const role  = document.getElementById('edit-role').value;
        const pass  = document.getElementById('edit-pass').value;

        if (!name || !email || !role) { alert('Nama, email, dan peran wajib diisi.'); return; }
        if (pass && pass.length < 8) { alert('Password minimal 8 karakter.'); return; }

        if (activeRow) {
            // Update data-* attributes
            activeRow.dataset.name  = name;
            activeRow.dataset.email = email;
            activeRow.dataset.role  = role;

            // Update tabel: nama & email
            const nameEl  = activeRow.querySelector('p.font-semibold.text-sm');
            const emailEl = activeRow.querySelector('p.text-xs.text-gray-400');
            if (nameEl)  nameEl.textContent  = name;
            if (emailEl) emailEl.textContent = email;

            // Update inisial avatar
            const initials = name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
            const avatar   = activeRow.querySelector('.rounded-full.flex');
            if (avatar) avatar.textContent = initials;

            // Update badge peran
            const badge = activeRow.querySelector('td:nth-child(2) span');
            if (badge) {
                if (role === 'HR Master') {
                    badge.textContent = 'HR Master';
                    badge.className   = 'text-xs font-bold text-purple-700 bg-purple-50 border border-purple-200 px-3 py-1 rounded-full';
                } else {
                    badge.textContent = 'HR';
                    badge.className   = 'text-xs font-bold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full';
                }
            }
        }

        document.getElementById('modal-edit').classList.add('hidden');
    });

    const closeEdit = () => document.getElementById('modal-edit').classList.add('hidden');
    document.getElementById('btn-close-edit').addEventListener('click', closeEdit);
    document.getElementById('btn-cancel-edit').addEventListener('click', closeEdit);
    document.getElementById('modal-edit').addEventListener('click', function (e) { if (e.target === this) closeEdit(); });

    // ===== HAPUS ANGGOTA =====
    document.getElementById('action-hapus').addEventListener('click', function () {
        if (!activeRow) return;
        document.getElementById('hapus-name').textContent = activeRow.dataset.name;
        document.getElementById('modal-hapus').classList.remove('hidden');
        dropdown.classList.add('hidden');
    });

    document.getElementById('btn-confirm-hapus').addEventListener('click', function () {
        if (activeRow) {
            activeRow.style.transition = 'opacity 0.3s';
            activeRow.style.opacity    = '0';
            setTimeout(() => { activeRow.remove(); activeRow = null; }, 300);
        }
        document.getElementById('modal-hapus').classList.add('hidden');
    });

    const closeHapus = () => document.getElementById('modal-hapus').classList.add('hidden');
    document.getElementById('btn-close-hapus').addEventListener('click', closeHapus);
    document.getElementById('btn-cancel-hapus').addEventListener('click', closeHapus);
    document.getElementById('modal-hapus').addEventListener('click', function (e) { if (e.target === this) closeHapus(); });

    // ===== TAMBAH ANGGOTA =====
    document.getElementById('btn-tambah-anggota').addEventListener('click', () => {
        document.getElementById('modal-tambah').classList.remove('hidden');
    });

    const closeTambah = () => document.getElementById('modal-tambah').classList.add('hidden');
    document.getElementById('btn-close-tambah').addEventListener('click', closeTambah);
    document.getElementById('btn-cancel-tambah').addEventListener('click', closeTambah);
    document.getElementById('modal-tambah').addEventListener('click', function (e) { if (e.target === this) closeTambah(); });

    document.getElementById('btn-save-tambah').addEventListener('click', function () {
        const name  = document.getElementById('new-name').value.trim();
        const email = document.getElementById('new-email').value.trim();
        const role  = document.getElementById('new-role').value;
        const pass  = document.getElementById('new-pass').value;

        if (!name || !email || !role || !pass) { alert('Semua field wajib diisi.'); return; }
        if (pass.length < 8) { alert('Password minimal 8 karakter.'); return; }
        if (!email.includes('@')) { alert('Format email tidak valid.'); return; }

        const initials = name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
        const colors   = ['bg-green-600', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500', 'bg-pink-500'];
        const color    = colors[Math.floor(Math.random() * colors.length)];
        const badgeClass = role === 'HR Master'
            ? 'text-xs font-bold text-purple-700 bg-purple-50 border border-purple-200 px-3 py-1 rounded-full'
            : 'text-xs font-bold text-green-800 bg-green-50 border border-green-200 px-3 py-1 rounded-full';

        const row = document.createElement('tr');
        row.className = 'border-t border-gray-100 hover:bg-gray-50 transition-colors member-row';
        row.dataset.name   = name;
        row.dataset.email  = email;
        row.dataset.role   = role;
        row.dataset.status = 'aktif';
        row.innerHTML = `
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full ${color} flex items-center justify-center text-white font-bold text-sm shrink-0">${initials}</div>
                    <div>
                        <p class="font-semibold text-sm text-gray-900">${name}</p>
                        <p class="text-xs text-gray-400">${email}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4"><span class="${badgeClass}">${role}</span></td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer toggle-status" checked>
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-green-700 peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                    <span class="text-xs font-semibold text-green-700 status-label">AKTIF</span>
                </div>
            </td>
            <td class="px-6 py-4 text-right">
                <button class="btn-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                </button>
            </td>`;

        // Attach events to new row
        row.querySelector('.toggle-status').addEventListener('change', function () {
            const label = this.closest('td').querySelector('.status-label');
            if (this.checked) { label.textContent = 'AKTIF'; label.className = 'text-xs font-semibold text-green-700 status-label'; }
            else              { label.textContent = 'NONAKTIF'; label.className = 'text-xs font-semibold text-gray-400 status-label'; }
        });
        row.querySelector('.btn-action').addEventListener('click', function (e) {
            e.stopPropagation();
            openDropdown(this, row);
        });

        document.getElementById('member-table').appendChild(row);

        // Reset & close
        ['new-name', 'new-email', 'new-pass'].forEach(id => document.getElementById(id).value = '');
        document.getElementById('new-role').value = '';
        closeTambah();
    });
});