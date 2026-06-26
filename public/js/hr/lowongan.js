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
        const location   = activeRow.dataset.location || '';
        const status     = activeRow.dataset.status || 'DRAFT';
        const quota      = activeRow.dataset.quota || '';
        const deadline   = activeRow.dataset.deadline || '';
        const desc       = activeRow.dataset.desc || '';
        const autoClose  = activeRow.dataset.autoCloseMethod || 'both';
        const ageMin     = activeRow.dataset.ageMin || '';
        const ageMax     = activeRow.dataset.ageMax || '';
        const passingGrade = activeRow.dataset.passingGrade || '70';

        document.getElementById('v-title').value    = title;
        document.getElementById('v-category').value = categoryId;
        document.getElementById('v-location').value = location;
        document.getElementById('v-status').value   = status;
        document.getElementById('v-quota').value    = quota;
        document.getElementById('v-deadline').value = deadline;
        document.getElementById('v-desc').value     = desc;
        document.getElementById('v-auto-close').value = autoClose;
        document.getElementById('v-age-min').value = ageMin;
        document.getElementById('v-age-max').value = ageMax;
        document.getElementById('v-passing-grade').value = passingGrade;

        document.querySelector('#modal-vacancy .bg-green-900 h2').textContent = 'Edit Vacancy';
        document.getElementById('btn-save-vacancy').textContent = 'Save Changes';
        document.getElementById('modal-vacancy').classList.remove('hidden');
    });

    // Mark as Filled
    dropdown.querySelector('.vd-fill').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        document.getElementById('modal-fill-vacancy').classList.remove('hidden');
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
        ['v-title','v-category','v-location','v-quota','v-deadline','v-desc', 'v-age-min', 'v-age-max'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        document.getElementById('v-passing-grade').value = '70';
        document.getElementById('v-status').value = 'DRAFT';
        document.getElementById('v-auto-close').value = 'both';
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
        const location   = document.getElementById('v-location').value;
        const quota      = document.getElementById('v-quota').value;
        const deadline   = document.getElementById('v-deadline').value;
        const status     = document.getElementById('v-status').value;
        const desc       = document.getElementById('v-desc').value;
        const autoClose  = document.getElementById('v-auto-close').value;
        const ageMin     = document.getElementById('v-age-min').value;
        const ageMax     = document.getElementById('v-age-max').value;
        const passingGrade = document.getElementById('v-passing-grade').value;

        if (!title || !categoryId || !location || !quota) { alert('Position, category, location, dan quota wajib diisi.'); return; }

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
                    location: location,
                    quota: quota,
                    age_min: ageMin || null,
                    age_max: ageMax || null,
                    passing_grade: passingGrade || null,
                    deadline: deadline || null,
                    status: dbStatus,
                    auto_close_method: autoClose,
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
                    location: location,
                    quota: quota,
                    age_min: ageMin || null,
                    age_max: ageMax || null,
                    passing_grade: passingGrade || null,
                    deadline: deadline || null,
                    status: dbStatus,
                    auto_close_method: autoClose,
                    description: desc || 'Brief job description.',
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

    // ===== MODAL: Mark as Filled =====
    document.getElementById('btn-close-fill-modal').addEventListener('click', () => document.getElementById('modal-fill-vacancy').classList.add('hidden'));
    document.getElementById('btn-cancel-fill-vacancy').addEventListener('click', () => document.getElementById('modal-fill-vacancy').classList.add('hidden'));
    document.getElementById('modal-fill-vacancy').addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });

    document.getElementById('btn-confirm-fill-vacancy').addEventListener('click', function () {
        if (!activeRow) return;
        const id = activeRow.dataset.id;
        
        this.disabled = true;
        this.textContent = 'Saving...';

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
                alert('Gagal memperbarui status lowongan.');
                this.disabled = false;
                this.textContent = 'Yes, Mark as Filled';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat memperbarui status lowongan.');
            this.disabled = false;
            this.textContent = 'Yes, Mark as Filled';
        });
    });

    // ===== MODAL: Add Category =====
    const modalCategory = document.getElementById('modal-add-category');
    const btnOpenCategory = document.getElementById('btn-open-category-modal');
    const btnCloseCategory = document.getElementById('btn-close-category-modal');
    const btnCancelCategory = document.getElementById('btn-cancel-category');
    const btnSaveCategory = document.getElementById('btn-save-category');
    const catNameInput = document.getElementById('cat-name-input');

    const openCatModal = () => {
        if (catNameInput) catNameInput.value = '';
        modalCategory?.classList.remove('hidden');
    };
    const closeCatModal = () => modalCategory?.classList.add('hidden');

    btnOpenCategory?.addEventListener('click', openCatModal);
    btnCloseCategory?.addEventListener('click', closeCatModal);
    btnCancelCategory?.addEventListener('click', closeCatModal);
    modalCategory?.addEventListener('click', function (e) { if (e.target === this) closeCatModal(); });

    btnSaveCategory?.addEventListener('click', function () {
        const name = catNameInput.value.trim();
        if (!name) { alert('Nama kategori wajib diisi.'); return; }

        this.disabled = true;
        this.textContent = 'Menyimpan...';

        fetch('/hr/lowongan/kategori', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => {
            if (!response.ok) return response.json().then(err => { throw err; });
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Dynamically add to Category filter and Category selection dropdowns
                const filterCat = document.getElementById('filter-category');
                const vCat = document.getElementById('v-category');

                if (filterCat) {
                    const opt = document.createElement('option');
                    opt.value = data.category.name;
                    opt.textContent = data.category.name;
                    filterCat.appendChild(opt);
                }

                if (vCat) {
                    const opt = document.createElement('option');
                    opt.value = data.category.id;
                    opt.textContent = data.category.name;
                    vCat.appendChild(opt);
                }

                closeCatModal();
                alert(data.message || 'Kategori baru berhasil ditambahkan.');
            } else {
                alert('Gagal menambahkan kategori: ' + (data.message || ''));
            }
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat menambahkan kategori.');
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Simpan';
        });
    });

    // ===== MODAL: Add Location =====
    const modalLocation = document.getElementById('modal-add-location');
    const btnOpenLocation = document.getElementById('btn-open-location-modal');
    const btnCloseLocation = document.getElementById('btn-close-location-modal');
    const btnCancelLocation = document.getElementById('btn-cancel-location');
    const btnSaveLocation = document.getElementById('btn-save-location');
    const locNameInput = document.getElementById('loc-name-input');

    const openLocModal = () => {
        if (locNameInput) locNameInput.value = '';
        modalLocation?.classList.remove('hidden');
    };
    const closeLocModal = () => modalLocation?.classList.add('hidden');

    btnOpenLocation?.addEventListener('click', openLocModal);
    btnCloseLocation?.addEventListener('click', closeLocModal);
    btnCancelLocation?.addEventListener('click', closeLocModal);
    modalLocation?.addEventListener('click', function (e) { if (e.target === this) closeLocModal(); });

    btnSaveLocation?.addEventListener('click', function () {
        const name = locNameInput.value.trim();
        if (!name) { alert('Nama lokasi wajib diisi.'); return; }

        this.disabled = true;
        this.textContent = 'Menyimpan...';

        fetch('/hr/lowongan/lokasi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => {
            if (!response.ok) return response.json().then(err => { throw err; });
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Dynamically add to Location selection dropdown in create/edit modal
                const vLoc = document.getElementById('v-location');
                if (vLoc) {
                    const opt = document.createElement('option');
                    opt.value = data.location.name;
                    opt.textContent = data.location.name;
                    vLoc.appendChild(opt);
                }

                closeLocModal();
                alert(data.message || 'Lokasi kerja baru berhasil ditambahkan.');
            } else {
                alert('Gagal menambahkan lokasi: ' + (data.message || ''));
            }
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Terjadi kesalahan saat menambahkan lokasi.');
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Simpan';
        });
    });
});