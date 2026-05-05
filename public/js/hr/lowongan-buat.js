/**
 * HR Lowongan Buat JS
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== CONTENTEDITABLE PLACEHOLDER =====
    document.querySelectorAll('[contenteditable][data-placeholder]').forEach(el => {
        el.addEventListener('focus', function () {
            if (this.textContent === this.dataset.placeholder) {
                this.textContent = '';
                this.classList.remove('text-gray-300');
            }
        });
        el.addEventListener('blur', function () {
            if (!this.textContent.trim()) {
                this.textContent = this.dataset.placeholder;
                this.classList.add('text-gray-300');
            }
        });
        // Set initial placeholder style
        if (!el.textContent.trim()) {
            el.textContent = el.dataset.placeholder;
            el.classList.add('text-gray-300');
        }
    });

    // ===== FORMAT BUTTONS =====
    document.querySelectorAll('.fmt-btn').forEach(btn => {
        btn.addEventListener('mousedown', function (e) {
            e.preventDefault();
            const targetId = this.dataset.target || 'f-description';
            document.getElementById(targetId).focus();
            document.execCommand(this.dataset.cmd, false, null);
        });
    });

    // ===== TOGGLE SALARY =====
    document.getElementById('toggle-salary').addEventListener('change', function () {
        const range = document.getElementById('salary-range');
        range.style.display = this.checked ? 'grid' : 'none';
    });

    // ===== BENEFITS =====
    document.querySelectorAll('.remove-benefit').forEach(btn => {
        btn.addEventListener('click', function () {
            this.closest('.benefit-tag').remove();
        });
    });

    document.getElementById('btn-add-benefit').addEventListener('click', () => {
        document.getElementById('benefit-input').value = '';
        document.getElementById('modal-benefit').classList.remove('hidden');
        setTimeout(() => document.getElementById('benefit-input').focus(), 100);
    });

    document.getElementById('btn-close-benefit').addEventListener('click', () =>
        document.getElementById('modal-benefit').classList.add('hidden'));
    document.getElementById('modal-benefit').addEventListener('click', function (e) {
        if (e.target === this) this.classList.add('hidden');
    });

    document.getElementById('btn-confirm-benefit').addEventListener('click', addBenefit);
    document.getElementById('benefit-input').addEventListener('keydown', e => {
        if (e.key === 'Enter') addBenefit();
    });

    function addBenefit() {
        const val = document.getElementById('benefit-input').value.trim();
        if (!val) return;

        const tag = document.createElement('span');
        tag.className = 'benefit-tag flex items-center gap-1 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full';
        tag.innerHTML = `${val} <button class="remove-benefit text-green-500 hover:text-red-500 transition-colors ml-0.5">×</button>`;
        tag.querySelector('.remove-benefit').addEventListener('click', function () {
            tag.remove();
        });

        const addBtn = document.getElementById('btn-add-benefit');
        document.getElementById('benefits-list').insertBefore(tag, addBtn);
        document.getElementById('modal-benefit').classList.add('hidden');
    }

    // ===== HEADER IMAGE UPLOAD =====
    const uploadArea = document.getElementById('upload-area');
    const imageInput = document.getElementById('header-image-input');
    const imgPreview = document.getElementById('img-preview');
    const imgDefault = document.getElementById('img-preview-default');
    const imgFilename = document.getElementById('img-filename');

    uploadArea.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            imgPreview.src = e.target.result;
            imgPreview.classList.remove('hidden');
            imgDefault.classList.add('hidden');
            imgFilename.textContent = file.name;
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('btn-remove-img').addEventListener('click', function () {
        imgPreview.src = '';
        imgPreview.classList.add('hidden');
        imgDefault.classList.remove('hidden');
        imgFilename.textContent = 'default_factory.jpg';
        imageInput.value = '';
    });

    // ===== AUTO SAVE =====
    const autosaveText = document.getElementById('autosave-text');
    const autosaveIcon = document.getElementById('autosave-icon');
    let autosaveTimer  = null;

    function triggerAutosave() {
        // Show "Menyimpan..."
        autosaveText.textContent = 'Menyimpan...';
        autosaveIcon.innerHTML   = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>';
        autosaveIcon.classList.add('animate-spin');

        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(() => {
            autosaveIcon.classList.remove('animate-spin');
            autosaveIcon.innerHTML = '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>';
            autosaveText.textContent = 'Draft tersimpan · ' + new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }, 1500);
    }

    // Watch all inputs for changes
    const watchFields = ['f-title', 'f-category', 'f-location', 'f-quota', 'f-deadline', 'f-salary-min', 'f-salary-max'];
    watchFields.forEach(id => {
        document.getElementById(id)?.addEventListener('input', triggerAutosave);
        document.getElementById(id)?.addEventListener('change', triggerAutosave);
    });
    // Watch contenteditable fields
    document.querySelectorAll('[contenteditable]').forEach(el => {
        el.addEventListener('input', triggerAutosave);
    });

    // ===== PUBLISH =====
    document.getElementById('btn-publish').addEventListener('click', function () {
        const title = document.getElementById('f-title').value.trim();
        const quota = document.getElementById('f-quota').value;
        if (!title) { alert('Position title wajib diisi.'); return; }
        if (!quota || quota < 1) { alert('Target quota wajib diisi.'); return; }

        this.disabled = true;
        this.innerHTML = '<svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>Publishing...';

        setTimeout(() => {
            window.location.href = '/hr/lowongan';
        }, 1500);
    });

    // ===== PREVIEW MODAL =====
    const modalPreview = document.getElementById('modal-preview');

    document.getElementById('btn-preview').addEventListener('click', function () {
        // Title
        const title = document.getElementById('f-title').value.trim();
        document.getElementById('prev-title').textContent = title || '(Belum Diisi)';

        // Category & Location
        document.getElementById('prev-category').textContent = document.getElementById('f-category').value;
        document.getElementById('prev-location').textContent = document.getElementById('f-location').value;

        // Quota
        document.getElementById('prev-quota').textContent = document.getElementById('f-quota').value || '1';

        // Deadline
        const deadline = document.getElementById('f-deadline').value;
        document.getElementById('prev-deadline').textContent = deadline
            ? new Date(deadline).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
            : '-';

        // Salary
        const salaryWrap = document.getElementById('prev-salary-wrap');
        if (document.getElementById('toggle-salary').checked) {
            salaryWrap.style.display = '';
            document.getElementById('prev-salary-min').textContent = document.getElementById('f-salary-min').value;
            document.getElementById('prev-salary-max').textContent = document.getElementById('f-salary-max').value;
        } else {
            salaryWrap.style.display = 'none';
        }

        // Description
        const descEl = document.getElementById('f-description');
        const descText = descEl.textContent.trim();
        const descPreview = document.getElementById('prev-description');
        if (descText && descText !== descEl.dataset.placeholder) {
            descPreview.innerHTML = descEl.innerHTML;
        } else {
            descPreview.innerHTML = '<em class="text-gray-400">Belum ada deskripsi.</em>';
        }

        // Requirements
        const reqEl = document.getElementById('f-requirements');
        const reqText = reqEl.textContent.trim();
        const reqPreview = document.getElementById('prev-requirements');
        if (reqText && reqText !== reqEl.dataset.placeholder) {
            reqPreview.innerHTML = reqEl.innerHTML;
        } else {
            reqPreview.innerHTML = '<em class="text-gray-400">Belum ada persyaratan.</em>';
        }

        // Benefits
        const benefits = Array.from(document.querySelectorAll('.benefit-tag')).map(t => t.childNodes[0].textContent.trim());
        const benefitsContainer = document.getElementById('prev-benefits');
        const benefitsWrap      = document.getElementById('prev-benefits-wrap');
        if (benefits.length === 0) {
            benefitsWrap.style.display = 'none';
        } else {
            benefitsWrap.style.display = '';
            benefitsContainer.innerHTML = benefits.map(b =>
                `<span class="flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>${b}</span>`
            ).join('');
        }

        // Header image
        const imgPreview = document.getElementById('img-preview');
        if (!imgPreview.classList.contains('hidden') && imgPreview.src) {
            document.getElementById('prev-header-img').src = imgPreview.src;
            document.getElementById('prev-header-img').classList.remove('hidden');
            document.getElementById('prev-header-default').classList.add('hidden');
        } else {
            document.getElementById('prev-header-img').classList.add('hidden');
            document.getElementById('prev-header-default').classList.remove('hidden');
        }

        modalPreview.classList.remove('hidden');
    });

    document.getElementById('btn-close-preview').addEventListener('click', () => modalPreview.classList.add('hidden'));
    modalPreview.addEventListener('click', function (e) { if (e.target === this) this.classList.add('hidden'); });
});