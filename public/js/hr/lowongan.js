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

    function toggleActionDropdown(btn, row) {
        if (!dropdown) return;
        const rect = btn.getBoundingClientRect();
        
        // If same button and dropdown is open, close it
        if (activeRow === row && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
            return;
        }
        
        activeRow = row;
        dropdown.style.top   = (rect.bottom + window.scrollY + 4) + 'px';
        dropdown.style.right = (window.innerWidth - rect.right + window.scrollX) + 'px';
        dropdown.classList.remove('hidden');
    }

    document.querySelectorAll('.btn-vacancy-action').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleActionDropdown(this, this.closest('.vacancy-row'));
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
            let dbStatus = 'draft';
            if (status === 'ACTIVE') dbStatus = 'open';

            fetch('/hr/lowongan', {
                method: 'POST',
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
                    description: desc || 'Brief job description.',
                    location: 'Batam Plant',
                    requirements: 'Requirements will be updated soon.'
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
                    alert('Gagal membuat lowongan: ' + (data.message || ''));
                    this.disabled = false;
                    this.textContent = 'Create Vacancy';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat membuat lowongan.');
                this.disabled = false;
                this.textContent = 'Create Vacancy';
            });
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