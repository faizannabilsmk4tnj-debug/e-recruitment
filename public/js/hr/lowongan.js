/**
 * HR Lowongan JS
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== PERIOD TREND TOGGLE =====
    const periodButtons = document.querySelectorAll('.btn-period');
    const trendVacanciesBadge = document.getElementById('trend-vacancies-badge');
    const trendVacanciesLabel = document.getElementById('trend-vacancies-label');
    const trendApplicantsBadge = document.getElementById('trend-applicants-badge');
    const trendApplicantsLabel = document.getElementById('trend-applicants-label');
    const trendClosedBadge = document.getElementById('trend-closed-badge');
    const trendClosedLabel = document.getElementById('trend-closed-label');

    periodButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Remove active style from all period buttons
            periodButtons.forEach(b => {
                b.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
                b.classList.add('text-gray-500', 'hover:text-gray-700');
            });
            // Add active style to clicked button
            this.classList.remove('text-gray-500', 'hover:text-gray-700');
            this.classList.add('bg-white', 'text-gray-800', 'shadow-sm');

            const period = this.dataset.period;
            const data = window.vacancyTrends ? window.vacancyTrends[period] : null;
            if (!data) return;

            // Define suffix labels
            let timeSuffix = 'today';
            if (period === 'weekly') timeSuffix = 'this week';
            else if (period === 'monthly') timeSuffix = 'this month';
            else if (period === 'yearly') timeSuffix = 'this year';

            // Update Badges & Labels
            if (trendVacanciesBadge) trendVacanciesBadge.textContent = '+' + data.vacancies;
            if (trendVacanciesLabel) trendVacanciesLabel.textContent = `+${data.vacancies} new ${timeSuffix}`;

            if (trendApplicantsBadge) trendApplicantsBadge.textContent = '+' + data.applicants;
            if (trendApplicantsLabel) trendApplicantsLabel.textContent = `+${data.applicants} applied ${timeSuffix}`;

            if (trendClosedBadge) trendClosedBadge.textContent = '-' + data.closed;
            if (trendClosedLabel) trendClosedLabel.textContent = `-${data.closed} closed ${timeSuffix}`;
        });
    });

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
        if (!activeRow) return;
        const id = activeRow.dataset.id;
        window.location.href = '/hr/lowongan/' + id;
    });

    // Edit Vacancy
    dropdown.querySelector('.vd-edit').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        if (!activeRow) return;
        const title      = activeRow.querySelector('p.font-bold')?.textContent.trim() || '';
        const categoryId = activeRow.dataset.categoryId || '';
        const status     = activeRow.dataset.status || 'DRAFT';
        const quota      = activeRow.dataset.quota || '';
        const deadline   = activeRow.dataset.deadline || '';
        const desc       = activeRow.dataset.desc || '';

        document.getElementById('v-title').value    = title;
        document.getElementById('v-category').value = categoryId;
        document.getElementById('v-status').value   = status;
        document.getElementById('v-quota').value    = quota;
        document.getElementById('v-deadline').value = deadline;
        document.getElementById('v-desc').value     = desc;

        document.querySelector('#modal-vacancy .bg-green-900 h2').textContent = 'Edit Vacancy';
        document.getElementById('btn-save-vacancy').textContent = 'Save Changes';
        document.getElementById('modal-vacancy').classList.remove('hidden');
    });

    // Mark as Filled
    dropdown.querySelector('.vd-fill').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        if (!activeRow) return;
        const id = activeRow.dataset.id;

        if (confirm('Tandai lowongan ini sebagai terpenuhi (Mark as Filled)? Ini akan menutup lowongan.')) {
            fetch('/hr/lowongan/' + id + '/status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: 'closed'
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to update status');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Gagal memperbarui status lowongan.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan jaringan atau server.');
            });
        }
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
        const title      = document.getElementById('v-title').value.trim();
        const categoryId = document.getElementById('v-category').value;
        const quota      = document.getElementById('v-quota').value;
        const deadline   = document.getElementById('v-deadline').value;
        const status     = document.getElementById('v-status').value;
        const desc       = document.getElementById('v-desc').value;

        if (!title || !categoryId || !quota) { alert('Position, category, dan quota wajib diisi.'); return; }

        this.disabled = true;
        const isEditing = this.textContent.includes('Save');
        this.textContent = isEditing ? 'Saving...' : 'Creating...';

        if (isEditing) {
            const id = activeRow.dataset.id;
            let dbStatus = 'open';
            if (status === 'DRAFT') dbStatus = 'draft';
            if (status === 'CLOSED') dbStatus = 'closed';

            fetch('/hr/lowongan/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    title: title,
                    category_id: categoryId,
                    quota: quota,
                    deadline: deadline || null,
                    status: dbStatus,
                    description: desc
                })
            })
            .then(response => {
                if (!response.ok) return response.json().then(err => { throw err; });
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Gagal menyimpan perubahan: ' + (data.message || ''));
                    this.disabled = false;
                    this.textContent = 'Save Changes';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat menyimpan perubahan.');
                this.disabled = false;
                this.textContent = 'Save Changes';
            });
        } else {
            // Creation is handled in lowongan-buat page.
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
            row.dataset.category = document.querySelector(`#v-category option[value="${categoryId}"]`)?.textContent || '';
            row.innerHTML = `
                <td class="py-4 pr-4">
                    <p class="font-bold text-sm text-gray-900">${title}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">${ref}</p>
                </td>
                <td class="py-4 pr-4 text-sm text-gray-500">${row.dataset.category}</td>
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
            this.disabled = false;
            this.textContent = 'Create Vacancy';
            closeModal();
        }
    });

    // ===== MODAL: Close Vacancy =====
    document.getElementById('btn-close-cv-modal').addEventListener('click', () => document.getElementById('modal-close-vacancy').classList.add('hidden'));
    document.getElementById('btn-cancel-close-vacancy').addEventListener('click', () => document.getElementById('modal-close-vacancy').classList.add('hidden'));
    document.getElementById('modal-close-vacancy').addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });

    document.getElementById('btn-confirm-close-vacancy').addEventListener('click', function () {
        if (!activeRow) return;
        const id = activeRow.dataset.id;
        
        this.disabled = true;
        this.textContent = 'Closing...';

        fetch('/hr/lowongan/' + id + '/status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: 'closed'
            })
        })
        .then(response => {
            if (!response.ok) return response.json().then(err => { throw err; });
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Gagal menutup lowongan.');
                this.disabled = false;
                this.textContent = 'Yes, Close Vacancy';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menutup lowongan.');
            this.disabled = false;
            this.textContent = 'Yes, Close Vacancy';
        });
    });
});