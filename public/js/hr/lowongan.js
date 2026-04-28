/**
 * HR Lowongan JS
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== SEARCH + FILTER =====
    const searchInput   = document.getElementById('search-vacancy');
    const filterStatus  = document.getElementById('filter-status');
    const filterCategory = document.getElementById('filter-category');

    function applyFilters() {
        const q        = searchInput.value.toLowerCase();
        const status   = filterStatus.value.toUpperCase();
        const category = filterCategory.value.toLowerCase();

        document.querySelectorAll('.vacancy-row').forEach(row => {
            const matchQ  = row.dataset.title.includes(q) || row.dataset.ref.includes(q);
            const matchS  = !status   || row.dataset.status   === status;
            const matchC  = !category || row.dataset.category.toLowerCase() === category;
            row.style.display = (matchQ && matchS && matchC) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', applyFilters);
    filterStatus.addEventListener('change', applyFilters);
    filterCategory.addEventListener('change', applyFilters);

    // ===== ACTION DROPDOWN =====
    const dropdown = document.getElementById('vacancy-dropdown');
    let activeRow  = null;

    document.querySelectorAll('.btn-vacancy-action').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            activeRow = this.closest('.vacancy-row');
            const rect = this.getBoundingClientRect();
            dropdown.style.top   = (rect.bottom + window.scrollY + 4) + 'px';
            dropdown.style.right = (window.innerWidth - rect.right) + 'px';
            dropdown.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', () => dropdown.classList.add('hidden'));
    dropdown.addEventListener('click', e => e.stopPropagation());

    // View Applicants
    dropdown.querySelector('.vd-view').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        // Find row index
        const rows = Array.from(document.querySelectorAll('.vacancy-row'));
        const idx  = rows.indexOf(activeRow) + 1;
        window.location.href = '/hr/lowongan/' + idx;
    });

    // Edit Vacancy
    dropdown.querySelector('.vd-edit').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        if (!activeRow) return;
        const title    = activeRow.querySelector('p.font-bold')?.textContent || '';
        const category = activeRow.dataset.category;
        const status   = activeRow.dataset.status;

        document.getElementById('v-title').value    = title;
        document.getElementById('v-category').value = category;
        document.getElementById('v-status').value   = status;

        document.querySelector('#modal-vacancy .bg-green-900 h2').textContent = 'Edit Vacancy';
        document.getElementById('btn-save-vacancy').textContent = 'Save Changes';
        document.getElementById('modal-vacancy').classList.remove('hidden');
    });

    // Close Vacancy
    dropdown.querySelector('.vd-close').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        document.getElementById('modal-close-vacancy').classList.remove('hidden');
    });

    // ===== MODAL: Create New Vacancy =====
    const openModal  = () => {
        document.querySelector('#modal-vacancy .bg-green-900 h2').textContent = 'Create New Vacancy';
        document.getElementById('btn-save-vacancy').textContent = 'Create Vacancy';
        ['v-title','v-category','v-quota','v-deadline','v-desc'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        document.getElementById('v-status').value = 'DRAFT';
        document.getElementById('modal-vacancy').classList.remove('hidden');
    };
    const closeModal = () => document.getElementById('modal-vacancy').classList.add('hidden');

    document.getElementById('btn-create-vacancy')?.addEventListener('click', openModal);
    document.getElementById('btn-close-vacancy-modal').addEventListener('click', closeModal);
    document.getElementById('btn-cancel-vacancy').addEventListener('click', closeModal);
    document.getElementById('modal-vacancy').addEventListener('click', function (e) { if (e.target === this) closeModal(); });

    document.getElementById('btn-save-vacancy').addEventListener('click', function () {
        const title    = document.getElementById('v-title').value.trim();
        const category = document.getElementById('v-category').value;
        const quota    = document.getElementById('v-quota').value;
        const deadline = document.getElementById('v-deadline').value;
        const status   = document.getElementById('v-status').value;

        if (!title || !category || !quota) { alert('Position, category, dan quota wajib diisi.'); return; }

        if (this.textContent.includes('Create')) {
            // Add new row
            const ref = 'REF-ECO-2024-' + String(Math.floor(Math.random() * 900) + 100);
            const deadlineFormatted = deadline ? new Date(deadline).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'}) : '-';
            const badgeClass = status === 'ACTIVE'
                ? 'text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full'
                : 'text-xs font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full';

            const row = document.createElement('tr');
            row.className = 'border-t border-gray-50 hover:bg-gray-50 transition-colors vacancy-row';
            row.dataset.title    = title.toLowerCase();
            row.dataset.ref      = ref.toLowerCase();
            row.dataset.status   = status;
            row.dataset.category = category;
            row.innerHTML = `
                <td class="py-4 pr-4">
                    <p class="font-bold text-sm text-gray-900">${title}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">${ref}</p>
                </td>
                <td class="py-4 pr-4 text-sm text-gray-500">${category}</td>
                <td class="py-4 pr-4"><span class="text-sm text-green-600 font-medium">No applicants yet</span></td>
                <td class="py-4 pr-4 text-sm font-semibold text-gray-700">${String(quota).padStart(2,'0')}</td>
                <td class="py-4 pr-4 text-sm text-gray-500">${deadlineFormatted}</td>
                <td class="py-4 pr-4"><span class="${badgeClass}">${status}</span></td>
                <td class="py-4 text-right relative">
                    <button class="btn-vacancy-action text-gray-400 hover:text-gray-700 transition-colors p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                    </button>
                </td>`;

            row.querySelector('.btn-vacancy-action').addEventListener('click', function (e) {
                e.stopPropagation();
                activeRow = row;
                const rect = this.getBoundingClientRect();
                dropdown.style.top   = (rect.bottom + window.scrollY + 4) + 'px';
                dropdown.style.right = (window.innerWidth - rect.right) + 'px';
                dropdown.classList.toggle('hidden');
            });

            document.getElementById('vacancy-table').appendChild(row);
        } else {
            // Update existing row
            if (activeRow) {
                activeRow.querySelector('p.font-bold').textContent = title;
                activeRow.querySelector('td:nth-child(2)').textContent = category;
                const badge = activeRow.querySelector('td:nth-child(6) span');
                if (badge) {
                    badge.textContent = status;
                    if (status === 'ACTIVE') badge.className = 'text-xs font-bold text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full';
                    else badge.className = 'text-xs font-bold text-gray-500 bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-full';
                }
                activeRow.dataset.status   = status;
                activeRow.dataset.category = category;
                activeRow.dataset.title    = title.toLowerCase();
            }
        }

        closeModal();
    });

    // ===== MODAL: Close Vacancy =====
    document.getElementById('btn-close-cv-modal').addEventListener('click', () => document.getElementById('modal-close-vacancy').classList.add('hidden'));
    document.getElementById('btn-cancel-close-vacancy').addEventListener('click', () => document.getElementById('modal-close-vacancy').classList.add('hidden'));
    document.getElementById('modal-close-vacancy').addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });

    document.getElementById('btn-confirm-close-vacancy').addEventListener('click', function () {
        if (activeRow) {
            activeRow.classList.add('opacity-50');
            const titleEl = activeRow.querySelector('p.font-bold');
            if (titleEl) { titleEl.classList.add('line-through', 'text-gray-400'); titleEl.classList.remove('text-gray-900'); }
            const badge = activeRow.querySelector('td:nth-child(6) span');
            if (badge) { badge.textContent = 'CLOSED'; badge.className = 'text-xs font-bold text-red-600 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full'; }
            activeRow.dataset.status = 'CLOSED';
        }
        document.getElementById('modal-close-vacancy').classList.add('hidden');
    });
});