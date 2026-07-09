/**
 * HR Lowongan Buat JS
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== INITIALIZE CKEDITOR =====
    let descEditor, reqEditor;

    const editorConfig = {
        toolbar: {
            items: [
                'undo', 'redo', '|',
                'heading', '|',
                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'alignment', '|',
                'bulletedList', 'numberedList', '|',
                'link', 'insertTable', 'blockQuote'
            ],
            shouldNotGroupWhenFull: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
        },
        fontSize: {
            options: [
                8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 20, 22, 24, 26, 28, 30, 32, 36, 40, 48, 56, 72
            ],
            supportAllValues: true
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        // Disable ALL premium plugins to avoid license errors
        removePlugins: [
            'ExportPdf', 'ExportWord', 'ImportWord',
            'CKBox', 'CKFinder', 'EasyImage',
            'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory', 'RealTimeCollaborativeEditing',
            'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData',
            'RevisionHistory', 'Pagination',
            'WProofreader', 'MathType',
            'SlashCommand', 'Template', 'MultiLevelList',
            'DocumentOutline', 'FormatPainter', 'TableOfContents',
            'PasteFromOfficeEnhanced', 'CaseChange', 'AIAssistant',
            'Mention', 'ListProperties'
        ]
    };

    CKEDITOR.ClassicEditor
        .create(document.querySelector('#f-description'), editorConfig)
        .then(editor => {
            descEditor = editor;
            editor.model.document.on('change:data', () => {
                clearFieldError(document.getElementById('f-description'), true);
                triggerAutosave();
            });
        })
        .catch(error => {
            console.error('Error initializing description editor:', error);
        });

    CKEDITOR.ClassicEditor
        .create(document.querySelector('#f-requirements'), editorConfig)
        .then(editor => {
            reqEditor = editor;
            editor.model.document.on('change:data', () => {
                clearFieldError(document.getElementById('f-requirements'), true);
                triggerAutosave();
            });
        })
        .catch(error => {
            console.error('Error initializing requirements editor:', error);
        });

    // ===== TOGGLE SALARY =====
    document.getElementById('toggle-salary').addEventListener('change', function () {
        const range = document.getElementById('salary-range');
        range.style.display = this.checked ? 'grid' : 'none';
    });

    // ===== SALARY INPUT FORMATTING =====
    function formatSalaryInput(input) {
        let value = input.value;
        let selectionStart = input.selectionStart;
        let oldLength = value.length;
        
        let clean = value.replace(/\D/g, '');
        if (clean === '') {
            input.value = '';
            return;
        }
        
        let formatted = parseInt(clean, 10).toLocaleString('id-ID');
        input.value = formatted;
        
        let newLength = formatted.length;
        input.selectionStart = input.selectionEnd = selectionStart + (newLength - oldLength);
    }

    const salMinInput = document.getElementById('f-salary-min');
    const salMaxInput = document.getElementById('f-salary-max');
    if (salMinInput) {
        salMinInput.addEventListener('input', function () {
            formatSalaryInput(this);
        });
    }
    if (salMaxInput) {
        salMaxInput.addEventListener('input', function () {
            formatSalaryInput(this);
        });
    }

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

    function handleHeaderImageFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            imgPreview.src = e.target.result;
            imgPreview.classList.remove('hidden');
            imgDefault.classList.add('hidden');
            imgFilename.textContent = file.name;
            if (typeof triggerAutosave === 'function') triggerAutosave();
        };
        reader.readAsDataURL(file);
    }

    imageInput.addEventListener('change', function () {
        handleHeaderImageFile(this.files[0]);
    });

    // Drag & Drop events
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('bg-green-50', 'border-green-300');
            uploadArea.classList.add('bg-green-100', 'border-green-600');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('bg-green-100', 'border-green-600');
            uploadArea.classList.add('bg-green-50', 'border-green-300');
        }, false);
    });

    uploadArea.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        handleHeaderImageFile(file);
    }, false);

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
        // Show "Saving..."
        autosaveText.textContent = 'Saving...';
        autosaveIcon.innerHTML   = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>';
        autosaveIcon.classList.add('animate-spin');

        clearTimeout(autosaveTimer);
        autosaveTimer = setTimeout(() => {
            autosaveIcon.classList.remove('animate-spin');
            autosaveIcon.innerHTML = '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>';
            autosaveText.textContent = 'Draft saved · ' + new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }, 1500);
    }

    function clearValidationErrors() {
        document.querySelectorAll('.error-msg').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
    }

    function showValidationError(inputId, message, isEditor = false) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        let targetEl = input;
        if (isEditor) {
            targetEl = input.closest('.ck-editor-wrapper') || input;
        }
        
        targetEl.classList.add('border-red-500');
        
        const parent = targetEl.parentElement;
        let errorMsg = parent.querySelector('.error-msg');
        if (!errorMsg) {
            errorMsg = document.createElement('span');
            errorMsg.className = 'error-msg text-[10px] text-red-500 font-semibold mt-1 block';
            errorMsg.textContent = message;
            parent.appendChild(errorMsg);
        }
    }

    function clearFieldError(input, isEditor = false) {
        let targetEl = input;
        if (isEditor || input.id === 'f-description' || input.id === 'f-requirements') {
            targetEl = input.closest('.ck-editor-wrapper') || input;
        }
        targetEl.classList.remove('border-red-500');
        const parent = targetEl.parentElement;
        const errorMsg = parent.querySelector('.error-msg');
        if (errorMsg) {
            errorMsg.remove();
        }
    }

    // Watch all inputs for changes & clear errors live
    const watchFields = ['f-title', 'f-category', 'f-employment-type', 'f-location', 'f-quota', 'f-age-min', 'f-age-max', 'f-passing-grade', 'f-deadline', 'f-auto-close', 'f-salary-min', 'f-salary-max'];
    watchFields.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function () {
                clearFieldError(this);
                triggerAutosave();
            });
            el.addEventListener('change', function () {
                clearFieldError(this);
                triggerAutosave();
            });
        }
    });

    // ===== SAVE OR PUBLISH VACANCY =====
    function saveVacancy(status) {
        const title = document.getElementById('f-title').value.trim();
        const quota = document.getElementById('f-quota').value;
        const isDraft = status === 'draft';

        const btnPublish = document.getElementById('btn-publish');
        const btnDraft = document.getElementById('btn-draft');
        const activeBtn = isDraft ? btnDraft : btnPublish;
        const originalHtml = activeBtn.innerHTML;

        const descVal = descEditor ? descEditor.getData().trim() : '';
        const reqVal = reqEditor ? reqEditor.getData().trim() : '';

        // Perform validation only when publishing
        if (!isDraft) {
            clearValidationErrors();
            let isValid = true;

            // 1. Position Title
            if (!title) {
                showValidationError('f-title', 'Position title is required.');
                isValid = false;
            }

            // 2. Job Category
            const category = document.getElementById('f-category').value;
            if (!category) {
                showValidationError('f-category', 'Job category is required.');
                isValid = false;
            }

            // 3. Employment Type
            const employmentType = document.getElementById('f-employment-type').value;
            if (!employmentType) {
                showValidationError('f-employment-type', 'Employment type is required.');
                isValid = false;
            }

            // 4. Work Location
            const location = document.getElementById('f-location').value;
            if (!location) {
                showValidationError('f-location', 'Work location is required.');
                isValid = false;
            }

            // 5. Target Quota
            if (!quota || quota < 1) {
                showValidationError('f-quota', 'Maximum applicants limit is required and must be at least 1.');
                isValid = false;
            }

            // 6. Application Deadline
            const deadline = document.getElementById('f-deadline').value;
            if (!deadline) {
                showValidationError('f-deadline', 'Application deadline is required.');
                isValid = false;
            } else {
                const dlDate = new Date(deadline);
                dlDate.setHours(0, 0, 0, 0);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                if (dlDate < today) {
                    showValidationError('f-deadline', 'Deadline cannot be in the past.');
                    isValid = false;
                }
            }

            // 7. Job Description
            if (!descVal) {
                showValidationError('f-description', 'Job description is required.', true);
                isValid = false;
            }

            // 8. Requirements
            if (!reqVal) {
                showValidationError('f-requirements', 'Requirements are required.', true);
                isValid = false;
            }

            if (!isValid) {
                const firstError = document.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
        } else {
            // For draft, we still need at least title and quota for DB constraints
            if (!title) { alert('Position title is required to save draft.'); return; }
            if (!quota || quota < 1) { alert('Maximum applicants limit must be at least 1 to save draft.'); return; }
        }

        btnPublish.disabled = true;
        if (btnDraft) btnDraft.disabled = true;
        activeBtn.innerHTML = '<svg class="w-4 h-4 animate-spin inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>' + (isDraft ? 'Saving Draft...' : 'Publishing...');

        const bannerImage = (imgPreview && !imgPreview.classList.contains('hidden')) ? imgPreview.src : null;

        const payload = {
            title: title,
            category_id: document.getElementById('f-category').value,
            employment_type: document.getElementById('f-employment-type').value,
            location: document.getElementById('f-location').value,
            quota: quota,
            age_min: document.getElementById('f-age-min').value || null,
            age_max: document.getElementById('f-age-max').value || null,
            passing_grade: document.getElementById('f-passing-grade').value || null,
            deadline: document.getElementById('f-deadline').value || null,
            auto_close_method: document.getElementById('f-auto-close').value,
            salary_min: document.getElementById('f-salary-min').value || null,
            salary_max: document.getElementById('f-salary-max').value || null,
            show_salary: document.getElementById('toggle-salary').checked ? 1 : 0,
            description: descVal,
            requirements: reqVal,
            benefits: Array.from(document.querySelectorAll('.benefit-tag')).map(t => t.childNodes[0].textContent.trim()),
            banner_image: bannerImage,
            status: status
        };

        const url = window.draftId ? `/hr/lowongan/${window.draftId}` : '/hr/lowongan';
        const method = window.draftId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = '/hr/lowongan';
            } else {
                alert('Failed to save: ' + (data.message || 'Unknown error.'));
                btnPublish.disabled = false;
                if (btnDraft) btnDraft.disabled = false;
                activeBtn.innerHTML = originalHtml;
            }
        })
        .catch(err => {
            console.error(err);
            if (err.errors) {
                const firstErr = Object.values(err.errors)[0][0];
                alert(firstErr);
            } else {
                alert(err.message || 'An error occurred while saving the vacancy.');
            }
            btnPublish.disabled = false;
            if (btnDraft) btnDraft.disabled = false;
            activeBtn.innerHTML = originalHtml;
        });
    }

    document.getElementById('btn-publish')?.addEventListener('click', () => saveVacancy('open'));
    document.getElementById('btn-draft')?.addEventListener('click', () => saveVacancy('draft'));

    // ===== PREVIEW MODAL =====
    const modalPreview = document.getElementById('modal-preview');

    document.getElementById('btn-preview').addEventListener('click', function () {
        // Title
        const title = document.getElementById('f-title').value.trim();
        document.getElementById('prev-title').textContent = title || '(Not Filled)';

        // Category & Location
        const catSelect = document.getElementById('f-category');
        document.getElementById('prev-category').textContent = catSelect.options[catSelect.selectedIndex].text;
        document.getElementById('prev-location').textContent = document.getElementById('f-location').value;

        // Employment Type
        const empTypeSelect = document.getElementById('f-employment-type');
        document.getElementById('prev-employment-type').textContent = empTypeSelect.options[empTypeSelect.selectedIndex].text;

        // Quota
        document.getElementById('prev-quota').textContent = document.getElementById('f-quota').value || '1';

        // Deadline
        const deadline = document.getElementById('f-deadline').value;
        document.getElementById('prev-deadline').textContent = deadline
            ? new Date(deadline).toLocaleDateString('en-US', { day: '2-digit', month: 'short', year: 'numeric' })
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
        const descPreview = document.getElementById('prev-description');
        const descVal = descEditor ? descEditor.getData().trim() : '';
        if (descVal && descVal !== '<p></p>') {
            descPreview.innerHTML = descVal;
        } else {
            descPreview.innerHTML = '<em class="text-gray-400">No description yet.</em>';
        }

        // Requirements
        const reqPreview = document.getElementById('prev-requirements');
        const reqVal = reqEditor ? reqEditor.getData().trim() : '';
        if (reqVal && reqVal !== '<p></p>') {
            reqPreview.innerHTML = reqVal;
        } else {
            reqPreview.innerHTML = '<em class="text-gray-400">No requirements yet.</em>';
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

    // ===== MODAL: Add Category =====
    const modalCategory = document.getElementById('modal-add-category');
    const btnCloseCategory = document.getElementById('btn-close-category-modal');
    const btnCancelCategory = document.getElementById('btn-cancel-category');
    const btnSaveCategory = document.getElementById('btn-save-category');
    const catNameInput = document.getElementById('cat-name-input');

    const openCatModal = () => {
        if (catNameInput) catNameInput.value = '';
        modalCategory?.classList.remove('hidden');
    };
    const closeCatModal = () => modalCategory?.classList.add('hidden');

    btnCloseCategory?.addEventListener('click', closeCatModal);
    btnCancelCategory?.addEventListener('click', closeCatModal);
    modalCategory?.addEventListener('click', function (e) { if (e.target === this) closeCatModal(); });

    btnSaveCategory?.addEventListener('click', function () {
        const name = catNameInput.value.trim();
        if (!name) { alert('Category name is required.'); return; }

        this.disabled = true;
        this.textContent = 'Saving...';

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
                const fCat = document.getElementById('f-category');
                if (fCat) {
                    const opt = document.createElement('option');
                    opt.value = data.category.id;
                    opt.textContent = data.category.name;

                    const addNewOpt = fCat.querySelector('option[value="ADD_NEW_CATEGORY"]');
                    if (addNewOpt) {
                        fCat.insertBefore(opt, addNewOpt);
                    } else {
                        fCat.appendChild(opt);
                    }
                    fCat.value = data.category.id;
                }

                closeCatModal();
                alert(data.message || 'New category added successfully.');
            } else {
                alert('Failed to add category: ' + (data.message || ''));
            }
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'An error occurred while adding the category.');
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Save';
        });
    });

    const fCategory = document.getElementById('f-category');
    if (fCategory) {
        fCategory.addEventListener('change', function () {
            if (this.value === 'ADD_NEW_CATEGORY') {
                this.value = ''; // Reset selection
                openCatModal();
            }
        });
    }

    // ===== MODAL: Add Location =====
    const modalLocation = document.getElementById('modal-add-location');
    const btnCloseLocation = document.getElementById('btn-close-location-modal');
    const btnCancelLocation = document.getElementById('btn-cancel-location');
    const btnSaveLocation = document.getElementById('btn-save-location');
    const locNameInput = document.getElementById('loc-name-input');

    const openLocModal = () => {
        if (locNameInput) locNameInput.value = '';
        modalLocation?.classList.remove('hidden');
    };
    const closeLocModal = () => modalLocation?.classList.add('hidden');

    btnCloseLocation?.addEventListener('click', closeLocModal);
    btnCancelLocation?.addEventListener('click', closeLocModal);
    modalLocation?.addEventListener('click', function (e) { if (e.target === this) closeLocModal(); });

    btnSaveLocation?.addEventListener('click', function () {
        const name = locNameInput.value.trim();
        if (!name) { alert('Location name is required.'); return; }

        this.disabled = true;
        this.textContent = 'Saving...';

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
                const fLoc = document.getElementById('f-location');
                if (fLoc) {
                    const opt = document.createElement('option');
                    opt.value = data.location.name;
                    opt.textContent = data.location.name;

                    const addNewOpt = fLoc.querySelector('option[value="ADD_NEW_LOCATION"]');
                    if (addNewOpt) {
                        fLoc.insertBefore(opt, addNewOpt);
                    } else {
                        fLoc.appendChild(opt);
                    }
                    fLoc.value = data.location.name;
                }

                closeLocModal();
                alert(data.message || 'New work location added successfully.');
            } else {
                alert('Failed to add location: ' + (data.message || ''));
            }
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'An error occurred while adding the location.');
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Save';
        });
    });

    const fLocation = document.getElementById('f-location');
    if (fLocation) {
        fLocation.addEventListener('change', function () {
            if (this.value === 'ADD_NEW_LOCATION') {
                this.value = ''; // Reset selection
                openLocModal();
            }
        });
    }
});