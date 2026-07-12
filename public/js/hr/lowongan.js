/**
 * HR Lowongan JS
 */
document.addEventListener('DOMContentLoaded', function () {

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

    const editSalMinInput = document.getElementById('v-salary-min');
    const editSalMaxInput = document.getElementById('v-salary-max');
    if (editSalMinInput) {
        editSalMinInput.addEventListener('input', function () {
            formatSalaryInput(this);
        });
    }
    if (editSalMaxInput) {
        editSalMaxInput.addEventListener('input', function () {
            formatSalaryInput(this);
        });
    }

    // ===== INITIALIZE CKEDITOR FOR EDIT MODAL =====
    let editDescEditor, editReqEditor;

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
        .create(document.querySelector('#v-desc'), editorConfig)
        .then(editor => {
            editDescEditor = editor;
            editor.model.document.on('change:data', () => {
                clearModalFieldError(document.getElementById('v-desc'), true);
            });
        })
        .catch(error => {
            console.error('Error initializing edit description editor:', error);
        });

    CKEDITOR.ClassicEditor
        .create(document.querySelector('#v-requirements'), editorConfig)
        .then(editor => {
            editReqEditor = editor;
            editor.model.document.on('change:data', () => {
                clearModalFieldError(document.getElementById('v-requirements'), true);
            });
        })
        .catch(error => {
            console.error('Error initializing edit requirements editor:', error);
        });

    // ===== MODAL VALIDATION HELPERS =====
    function clearModalValidationErrors() {
        document.querySelectorAll('#modal-vacancy .error-msg').forEach(el => el.remove());
        document.querySelectorAll('#modal-vacancy .border-red-500').forEach(el => el.classList.remove('border-red-500'));
    }

    function showModalValidationError(inputId, message, isEditor = false) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        let targetEl = input;
        if (isEditor || inputId === 'v-desc' || inputId === 'v-requirements') {
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

    function clearModalFieldError(input, isEditor = false) {
        let targetEl = input;
        if (isEditor || input.id === 'v-desc' || input.id === 'v-requirements') {
            targetEl = input.closest('.ck-editor-wrapper') || input;
        }
        targetEl.classList.remove('border-red-500');
        const parent = targetEl.parentElement;
        const errorMsg = parent.querySelector('.error-msg');
        if (errorMsg) {
            errorMsg.remove();
        }
    }

    // Watch modal inputs for changes to clear error validation styling live
    ['v-title','v-category','v-location','v-quota','v-deadline','v-age-min','v-age-max','v-passing-grade','v-salary-min','v-salary-max','v-benefits'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function () {
                clearModalFieldError(this);
            });
            el.addEventListener('change', function () {
                clearModalFieldError(this);
            });
        }
    });

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
            if (trendVacanciesLabel) trendVacanciesLabel.textContent = `Trend: +${data.vacancies} new ${timeSuffix}`;

            if (trendApplicantsBadge) trendApplicantsBadge.textContent = '+' + data.applicants;
            if (trendApplicantsLabel) trendApplicantsLabel.textContent = `Trend: +${data.applicants} applied ${timeSuffix}`;

            if (trendClosedBadge) trendClosedBadge.textContent = '-' + data.closed;
            if (trendClosedLabel) trendClosedLabel.textContent = `Trend: -${data.closed} closed ${timeSuffix}`;
        });
    });

    // ===== SEARCH + FILTER + PAGINATION =====
    const searchInput   = document.getElementById('search-vacancy');
    const filterStatus  = document.getElementById('filter-status');
    const filterCategory = document.getElementById('filter-category');
    const filterLocation = document.getElementById('filter-location');
    const filterEmploymentType = document.getElementById('filter-employment-type');
    const btnClearFilters = document.getElementById('btn-clear-filters');
    const cardClosingSoon = document.getElementById('card-closing-soon');
    let filterClosingSoonActive = false;

    let showArchived = sessionStorage.getItem('lowongan_show_archived') === 'true';

    // Sync button state initially
    const btnToggleArchived = document.getElementById('btn-toggle-archived');
    if (btnToggleArchived) {
        btnToggleArchived.dataset.active = showArchived ? 'true' : 'false';
        const dot = document.getElementById('archived-dot');
        if (showArchived) {
            btnToggleArchived.classList.remove('bg-white', 'border-gray-200', 'text-gray-600');
            btnToggleArchived.classList.add('bg-purple-50', 'border-purple-300', 'text-purple-800');
            if (dot) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-purple-600');
            }
        }
    }

    if (btnToggleArchived) {
        btnToggleArchived.addEventListener('click', function () {
            showArchived = !showArchived;
            sessionStorage.setItem('lowongan_show_archived', showArchived ? 'true' : 'false');
            this.dataset.active = showArchived ? 'true' : 'false';
            const dot = document.getElementById('archived-dot');
            if (showArchived) {
                this.classList.remove('bg-white', 'border-gray-200', 'text-gray-600');
                this.classList.add('bg-purple-50', 'border-purple-300', 'text-purple-800');
                if (dot) {
                    dot.classList.remove('bg-gray-300');
                    dot.classList.add('bg-purple-600');
                }
            } else {
                this.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
                this.classList.remove('bg-purple-50', 'border-purple-300', 'text-purple-800');
                if (dot) {
                    dot.classList.add('bg-gray-300');
                    dot.classList.remove('bg-purple-600');
                }
            }
            currentPage = 1;
            applyFilters();
        });
    }

    if (cardClosingSoon) {
        cardClosingSoon.addEventListener('click', function (e) {
            // Do not trigger filter if user clicks info icon or its tooltip
            if (e.target.closest('.info-btn') || e.target.closest('.info-tooltip')) {
                return;
            }
            filterClosingSoonActive = !filterClosingSoonActive;
            if (filterClosingSoonActive) {
                cardClosingSoon.classList.add('ring-2', 'ring-red-500', 'border-transparent');
                cardClosingSoon.classList.remove('border-gray-100');
            } else {
                cardClosingSoon.classList.remove('ring-2', 'ring-red-500', 'border-transparent');
                cardClosingSoon.classList.add('border-gray-100');
            }
            currentPage = 1;
            applyFilters();
        });
    }

    if (btnClearFilters) {
        btnClearFilters.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            if (filterStatus) filterStatus.value = '';
            if (filterCategory) filterCategory.value = '';
            if (filterLocation) filterLocation.value = '';
            if (filterEmploymentType) filterEmploymentType.value = '';
            
            const sortVacancySelect = document.getElementById('sort-vacancy');
            if (sortVacancySelect) sortVacancySelect.value = 'recent';
            
            if (filterClosingSoonActive) {
                filterClosingSoonActive = false;
                if (cardClosingSoon) {
                    cardClosingSoon.classList.remove('ring-2', 'ring-red-500', 'border-transparent');
                    cardClosingSoon.classList.add('border-gray-100');
                }
            }

            showArchived = false;
            sessionStorage.setItem('lowongan_show_archived', 'false');
            if (btnToggleArchived) {
                btnToggleArchived.dataset.active = 'false';
                btnToggleArchived.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
                btnToggleArchived.classList.remove('bg-purple-50', 'border-purple-300', 'text-purple-800');
                const dot = document.getElementById('archived-dot');
                if (dot) {
                    dot.classList.add('bg-gray-300');
                    dot.classList.remove('bg-purple-600');
                }
            }
            
            currentPage = 1;
            applyFilters();
        });
    }

    const pageSize = 5;
    let currentPage = 1;

    function applyFilters() {
        const q        = searchInput ? searchInput.value.toLowerCase() : '';
        const status   = filterStatus ? filterStatus.value.toUpperCase() : '';
        const category = filterCategory ? filterCategory.value.toLowerCase() : '';
        const location = filterLocation ? filterLocation.value.toLowerCase() : '';
        const employmentType = filterEmploymentType ? filterEmploymentType.value.toLowerCase() : '';

        // Toggle clear filters button visibility
        const isFilterActive = q || status || category || location || employmentType || filterClosingSoonActive || showArchived;
        if (btnClearFilters) {
            if (isFilterActive) {
                btnClearFilters.classList.remove('hidden');
                btnClearFilters.classList.add('flex');
            } else {
                btnClearFilters.classList.remove('flex');
                btnClearFilters.classList.add('hidden');
            }
        }

        // 1. Gather all rows that match the filter criteria
        const matchingRows = [];
        document.querySelectorAll('.vacancy-row').forEach(row => {
            const isArchived = row.dataset.archived === 'true';
            if (isArchived && !showArchived && status !== 'ARCHIVED') {
                row.style.display = 'none';
                return;
            }

            const matchQ  = row.dataset.title.toLowerCase().includes(q) || row.dataset.ref.toLowerCase().includes(q);
            
            let matchS = false;
            if (!status) {
                matchS = true;
            } else if (status === 'ARCHIVED') {
                matchS = isArchived;
            } else {
                matchS = row.dataset.status === status;
            }

            const matchC  = !category || row.dataset.category.toLowerCase() === category;
            let matchL = !location;
            if (location) {
                const vacancyLoc = row.dataset.location.toLowerCase();
                const filterLoc = location.toLowerCase();
                const filterFirstWord = filterLoc.split(/[ ,(]/)[0];
                matchL = vacancyLoc === filterLoc || 
                         vacancyLoc.includes(filterLoc) || 
                         filterLoc.includes(vacancyLoc) ||
                         (filterFirstWord.length > 2 && vacancyLoc.includes(filterFirstWord));
            }
            const matchE  = !employmentType || row.dataset.employmentType.toLowerCase() === employmentType;
            
            let matchClosingSoon = true;
            if (filterClosingSoonActive) {
                const deadline = row.dataset.deadline;
                if (row.dataset.status !== 'ACTIVE') {
                    matchClosingSoon = false;
                } else if (!deadline) {
                    matchClosingSoon = false;
                } else {
                    const parts = deadline.split('-');
                    const deadlineDate = new Date(parts[0], parts[1] - 1, parts[2]);
                    deadlineDate.setHours(0, 0, 0, 0);

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const maxDate = new Date();
                    maxDate.setDate(today.getDate() + 7);
                    maxDate.setHours(23, 59, 59, 999);
                    
                    if (deadlineDate < today || deadlineDate > maxDate) {
                        matchClosingSoon = false;
                    }
                }
            }
            
            if (matchQ && matchS && matchC && matchL && matchE && matchClosingSoon) {
                matchingRows.push(row);
            } else {
                row.style.display = 'none'; // hide mismatched rows immediately
            }
        });

        // 1.5 Sort matching rows by status group, then secondary sort mode
        const statusWeights = {
            'ACTIVE': 1,
            'DRAFT': 2,
            'FILLED': 3,
            'CLOSED': 4
        };

        const sortMode = document.getElementById('sort-vacancy')?.value || 'recent';

        matchingRows.sort((a, b) => {
            const statusA = a.dataset.status;
            const statusB = b.dataset.status;
            const weightA = statusWeights[statusA] || 99;
            const weightB = statusWeights[statusB] || 99;

            if (weightA !== weightB) {
                return weightA - weightB;
            }

            // Same status: sort based on the chosen mode
            if (sortMode === 'alpha') {
                return a.dataset.title.localeCompare(b.dataset.title);
            }
            // default is 'recent': newest first (highest ID first)
            return parseInt(b.dataset.id) - parseInt(a.dataset.id);
        });

        // Re-order rows in DOM so they display correctly
        const tableBody = document.getElementById('vacancy-table');
        if (tableBody) {
            matchingRows.forEach(row => {
                tableBody.appendChild(row);
            });
            // Ensure empty-state-row is always at the bottom
            const emptyState = document.getElementById('empty-state-row');
            if (emptyState) {
                tableBody.appendChild(emptyState);
            }
        }

        // 2. Paginate matching rows
        const totalItems = matchingRows.length;
        const totalPages = Math.ceil(totalItems / pageSize) || 1;

        // Keep current page in bounds
        if (currentPage > totalPages) {
            currentPage = totalPages;
        }
        if (currentPage < 1) {
            currentPage = 1;
        }

        // Show/hide based on page
        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = Math.min(startIndex + pageSize, totalItems);

        matchingRows.forEach((row, idx) => {
            if (idx >= startIndex && idx < endIndex) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // 3. Update pagination text
        const pagText = document.getElementById('pagination-text');
        if (pagText) {
            if (totalItems === 0) {
                pagText.textContent = 'Showing 0 of 0 vacancies';
            } else {
                pagText.textContent = `Showing ${startIndex + 1}-${endIndex} of ${totalItems} vacancies`;
            }
        }

        // Toggle Empty State Row
        const emptyState = document.getElementById('empty-state-row');
        if (emptyState) {
            if (totalItems === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // 4. Render pagination buttons
        renderPaginationButtons(totalPages);
    }

    function renderPaginationButtons(totalPages) {
        const container = document.getElementById('pagination-buttons');
        if (!container) return;
        container.innerHTML = '';

        // Previous button
        const prevBtn = document.createElement('button');
        prevBtn.className = `w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:bg-gray-50 transition-colors cursor-pointer ${currentPage === 1 ? 'opacity-50 pointer-events-none' : ''}`;
        prevBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>`;
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                applyFilters();
            }
        });
        container.appendChild(prevBtn);

        // Page number buttons
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            if (i === currentPage) {
                pageBtn.className = 'w-8 h-8 flex items-center justify-center bg-green-800 text-white rounded-lg text-xs font-semibold cursor-pointer';
            } else {
                pageBtn.className = 'w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-xs text-gray-500 hover:bg-gray-50 transition-colors cursor-pointer';
            }
            pageBtn.textContent = i;
            pageBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                applyFilters();
            });
            container.appendChild(pageBtn);
        }

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.className = `w-8 h-8 flex items-center justify-center border border-gray-200 rounded-lg text-gray-400 hover:bg-gray-50 transition-colors cursor-pointer ${currentPage === totalPages ? 'opacity-50 pointer-events-none' : ''}`;
        nextBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>`;
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                applyFilters();
            }
        });
        container.appendChild(nextBtn);
    }

    if (searchInput) searchInput.addEventListener('input', () => { currentPage = 1; applyFilters(); });
    if (filterStatus) filterStatus.addEventListener('change', () => { currentPage = 1; applyFilters(); });
    if (filterCategory) filterCategory.addEventListener('change', () => { currentPage = 1; applyFilters(); });
    if (filterLocation) filterLocation.addEventListener('change', () => { currentPage = 1; applyFilters(); });
    if (filterEmploymentType) filterEmploymentType.addEventListener('change', () => { currentPage = 1; applyFilters(); });
    const sortVacancySelect = document.getElementById('sort-vacancy');
    if (sortVacancySelect) sortVacancySelect.addEventListener('change', () => { currentPage = 1; applyFilters(); });

    // ===== ACTION DROPDOWN =====
    const dropdown = document.getElementById('vacancy-dropdown');
    let activeRow  = null;

    if (dropdown) {
        // Move dropdown to body to avoid offset/relative parent issues
        document.body.appendChild(dropdown);
    }

    function toggleActionDropdown(btn, row) {
        if (!dropdown) return;
        const rect = btn.getBoundingClientRect();
        const status = row.dataset.status;
        const lockedStatuses = ['CLOSED', 'EXPIRED', 'FILLED'];

        if (lockedStatuses.includes(status)) {
            dropdown.classList.add('hidden');
            return;
        }
        
        // If same button and dropdown is open, close it
        if (activeRow === row && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
            return;
        }
        
        activeRow = row;
        dropdown.style.top   = (rect.bottom + window.scrollY + 4) + 'px';
        dropdown.style.right = (window.innerWidth - rect.right + window.scrollX) + 'px';
        
        // Dynamically toggle Close / Fill buttons depending on status
        const fillBtn = dropdown.querySelector('.vd-fill');
        const closeBtn = dropdown.querySelector('.vd-close');
        
        if (status === 'DRAFT') {
            fillBtn?.classList.add('hidden');
            closeBtn?.classList.add('hidden');
        } else {
            fillBtn?.classList.remove('hidden');
            closeBtn?.classList.remove('hidden');
        }
        
        dropdown.classList.remove('hidden');
    }

    document.querySelectorAll('.btn-vacancy-action').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleActionDropdown(this, this.closest('.vacancy-row'));
        });
    });

    document.querySelectorAll('.btn-publish-draft').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent triggering row click redirection
            activeRow = this.closest('.vacancy-row');
            modalPublish?.classList.remove('hidden');
        });
    });

    document.addEventListener('click', () => dropdown.classList.add('hidden'));
    dropdown.addEventListener('click', e => e.stopPropagation());

    // Publish Vacancy Action
    const modalPublish = document.getElementById('modal-publish-vacancy');
    const btnClosePublish = document.getElementById('btn-close-publish-modal');
    const btnCancelPublish = document.getElementById('btn-cancel-publish-vacancy');
    const btnConfirmPublish = document.getElementById('btn-confirm-publish-vacancy');

    const modalIncomplete = document.getElementById('modal-incomplete-vacancy');
    const btnCloseIncomplete = document.getElementById('btn-close-incomplete-modal');
    const btnConfirmIncompleteOk = document.getElementById('btn-confirm-incomplete-ok');

    const closePublishModal = () => modalPublish?.classList.add('hidden');
    const closeIncompleteModal = () => modalIncomplete?.classList.add('hidden');

    btnClosePublish?.addEventListener('click', closePublishModal);
    btnCancelPublish?.addEventListener('click', closePublishModal);
    modalPublish?.addEventListener('click', function (e) { if (e.target === this) closePublishModal(); });

    btnCloseIncomplete?.addEventListener('click', closeIncompleteModal);
    btnConfirmIncompleteOk?.addEventListener('click', closeIncompleteModal);
    modalIncomplete?.addEventListener('click', function (e) { if (e.target === this) closeIncompleteModal(); });



    btnConfirmPublish?.addEventListener('click', function () {
        if (!activeRow) return;
        const id = activeRow.dataset.id;

        this.disabled = true;
        this.textContent = 'Publishing...';

        fetch(`/hr/lowongan/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: 'open'
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
                closePublishModal();
                modalIncomplete?.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            closePublishModal();
            if (err.message && err.message.includes('belum lengkap')) {
                modalIncomplete?.classList.remove('hidden');
            } else {
                alert(err.message || 'Terjadi kesalahan saat mempublikasikan lowongan.');
            }
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Yes, Publish';
        });
    });

    function openEditModal() {
        if (!activeRow) return;
        clearModalValidationErrors();
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
        let salaryMin    = activeRow.dataset.salaryMin || '';
        let salaryMax    = activeRow.dataset.salaryMax || '';
        const showSalary = activeRow.dataset.showSalary === '1';
        const requirements = activeRow.dataset.requirements || '';
        const benefits   = activeRow.dataset.benefits || '';
        const employmentType = activeRow.dataset.employmentType || 'full-time';
        const bannerImage = activeRow.dataset.bannerImage || '';

        // Format salary min and max with thousands separator
        if (salaryMin && !isNaN(salaryMin)) {
            salaryMin = parseInt(salaryMin).toLocaleString('id-ID');
        }
        if (salaryMax && !isNaN(salaryMax)) {
            salaryMax = parseInt(salaryMax).toLocaleString('id-ID');
        }

        document.getElementById('v-title').value    = title;
        document.getElementById('v-category').value = categoryId;
        document.getElementById('v-employment-type').value = employmentType;
        document.getElementById('v-location').value = location;
        document.getElementById('v-status').value   = status;
        document.getElementById('v-quota').value    = quota;
        document.getElementById('v-deadline').value = deadline;
        if (editDescEditor) {
            editDescEditor.setData(desc);
        } else {
            document.getElementById('v-desc').value = desc;
        }
        document.getElementById('v-auto-close').value = autoClose;
        document.getElementById('v-age-min').value = ageMin;
        document.getElementById('v-age-max').value = ageMax;
        document.getElementById('v-passing-grade').value = passingGrade;
        document.getElementById('v-salary-min').value = salaryMin;
        document.getElementById('v-salary-max').value = salaryMax;
        document.getElementById('v-show-salary').checked = showSalary;
        if (editReqEditor) {
            editReqEditor.setData(requirements);
        } else {
            document.getElementById('v-requirements').value = requirements;
        }
        document.getElementById('v-benefits').value = benefits;

        // Handle cover image preview
        const vImgPreview = document.getElementById('v-img-preview');
        const vUploadPlaceholder = document.getElementById('v-upload-placeholder');
        const btnVRemoveImg = document.getElementById('btn-v-remove-img');
        if (bannerImage) {
            vImgPreview.src = bannerImage;
            vImgPreview.classList.remove('hidden');
            vUploadPlaceholder.classList.add('hidden');
            btnVRemoveImg.classList.remove('hidden');
        } else {
            vImgPreview.src = '';
            vImgPreview.classList.add('hidden');
            vUploadPlaceholder.classList.remove('hidden');
            btnVRemoveImg.classList.add('hidden');
        }

        const isPublished = (status !== 'DRAFT');
        const lockBanner = document.getElementById('v-published-lock-banner');
        if (lockBanner) {
            if (isPublished) {
                lockBanner.classList.remove('hidden');
            } else {
                lockBanner.classList.add('hidden');
            }
        }

        const coreInputs = [
            'v-title',
            'v-category',
            'v-employment-type',
            'v-location',
            'v-salary-min',
            'v-salary-max',
            'v-show-salary',
            'v-benefits',
            'v-status',
            'v-age-min',
            'v-age-max',
            'v-passing-grade'
        ];

        coreInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.disabled = isPublished;
                if (isPublished) {
                    el.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-500');
                } else {
                    el.classList.remove('bg-gray-100', 'cursor-not-allowed', 'text-gray-500');
                }
            }
        });

        const coverUpload = document.getElementById('v-cover-upload');
        if (coverUpload) {
            coverUpload.disabled = false;
        }
        const coverPlaceholder = document.getElementById('v-upload-placeholder');
        if (coverPlaceholder) {
            coverPlaceholder.classList.remove('cursor-not-allowed', 'opacity-60');
            coverPlaceholder.style.pointerEvents = '';
        }

        if (bannerImage) {
            btnVRemoveImg.classList.remove('hidden');
        } else {
            btnVRemoveImg.classList.add('hidden');
        }

        if (editDescEditor) {
            if (isPublished) {
                if (typeof editDescEditor.enableReadOnlyMode === 'function') {
                    editDescEditor.enableReadOnlyMode('published-lock');
                } else {
                    editDescEditor.isReadOnly = true;
                }
                editDescEditor.ui.view.element.classList.add('bg-gray-50', 'cursor-not-allowed');
            } else {
                if (typeof editDescEditor.disableReadOnlyMode === 'function') {
                    editDescEditor.disableReadOnlyMode('published-lock');
                } else {
                    editDescEditor.isReadOnly = false;
                }
                editDescEditor.ui.view.element.classList.remove('bg-gray-50', 'cursor-not-allowed');
            }
        }

        if (editReqEditor) {
            if (isPublished) {
                if (typeof editReqEditor.enableReadOnlyMode === 'function') {
                    editReqEditor.enableReadOnlyMode('published-lock');
                } else {
                    editReqEditor.isReadOnly = true;
                }
                editReqEditor.ui.view.element.classList.add('bg-gray-50', 'cursor-not-allowed');
            } else {
                if (typeof editReqEditor.disableReadOnlyMode === 'function') {
                    editReqEditor.disableReadOnlyMode('published-lock');
                } else {
                    editReqEditor.isReadOnly = false;
                }
                editReqEditor.ui.view.element.classList.remove('bg-gray-50', 'cursor-not-allowed');
            }
        }

        document.querySelector('#modal-vacancy .bg-green-900 h2').textContent = 'Edit Vacancy';
        document.getElementById('btn-save-vacancy').textContent = 'Save Changes';
        document.getElementById('modal-vacancy').classList.remove('hidden');
    }

    // Edit Vacancy
    dropdown.querySelector('.vd-edit').addEventListener('click', () => {
        dropdown.classList.add('hidden');
        if (activeRow && activeRow.dataset.status === 'DRAFT') {
            window.location.href = '/hr/lowongan/buat?draft_id=' + activeRow.dataset.id;
        } else {
            openEditModal();
        }
    });

    document.getElementById('btn-incomplete-lengkapi')?.addEventListener('click', () => {
        closeIncompleteModal();
        if (activeRow) {
            window.location.href = '/hr/lowongan/buat?draft_id=' + activeRow.dataset.id;
        } else {
            openEditModal();
        }
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
        clearModalValidationErrors();
        document.querySelector('#modal-vacancy .bg-green-900 h2').textContent = 'Create New Vacancy';
        document.getElementById('btn-save-vacancy').textContent = 'Create Vacancy';
        ['v-title','v-category','v-location','v-quota','v-deadline','v-desc', 'v-age-min', 'v-age-max', 'v-salary-min', 'v-salary-max', 'v-requirements', 'v-benefits'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        document.getElementById('v-employment-type').value = 'full-time';
        document.getElementById('v-show-salary').checked = false;
        document.getElementById('v-passing-grade').value = '70';
        document.getElementById('v-status').value = 'DRAFT';
        document.getElementById('v-auto-close').value = 'both';

        // Reset image
        const vImgPreview = document.getElementById('v-img-preview');
        const vUploadPlaceholder = document.getElementById('v-upload-placeholder');
        const btnVRemoveImg = document.getElementById('btn-v-remove-img');
        if (vImgPreview) {
            vImgPreview.src = '';
            vImgPreview.classList.add('hidden');
        }
        if (vUploadPlaceholder) vUploadPlaceholder.classList.remove('hidden');
        if (btnVRemoveImg) btnVRemoveImg.classList.add('hidden');
        document.getElementById('v-cover-upload').value = '';

        document.getElementById('modal-vacancy').classList.remove('hidden');
    };
    const closeModal = () => {
        document.getElementById('modal-vacancy').classList.add('hidden');

        // Reset disabled states when modal is closed
        const lockBanner = document.getElementById('v-published-lock-banner');
        if (lockBanner) lockBanner.classList.add('hidden');

        const coreInputs = [
            'v-title',
            'v-category',
            'v-employment-type',
            'v-location',
            'v-salary-min',
            'v-salary-max',
            'v-show-salary',
            'v-benefits',
            'v-status',
            'v-age-min',
            'v-age-max',
            'v-passing-grade'
        ];

        coreInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.disabled = false;
                el.classList.remove('bg-gray-100', 'cursor-not-allowed', 'text-gray-500');
            }
        });

        const coverUpload = document.getElementById('v-cover-upload');
        if (coverUpload) coverUpload.disabled = false;

        const coverPlaceholder = document.getElementById('v-upload-placeholder');
        if (coverPlaceholder) {
            coverPlaceholder.classList.remove('cursor-not-allowed', 'opacity-60');
            coverPlaceholder.style.pointerEvents = '';
        }

        const btnVRemoveImg = document.getElementById('btn-v-remove-img');
        if (btnVRemoveImg) btnVRemoveImg.classList.remove('hidden');

        if (editDescEditor) {
            if (typeof editDescEditor.disableReadOnlyMode === 'function') {
                editDescEditor.disableReadOnlyMode('published-lock');
            } else {
                editDescEditor.isReadOnly = false;
            }
            editDescEditor.ui.view.element.classList.remove('bg-gray-50', 'cursor-not-allowed');
        }

        if (editReqEditor) {
            if (typeof editReqEditor.disableReadOnlyMode === 'function') {
                editReqEditor.disableReadOnlyMode('published-lock');
            } else {
                editReqEditor.isReadOnly = false;
            }
            editReqEditor.ui.view.element.classList.remove('bg-gray-50', 'cursor-not-allowed');
        }
    };

    document.getElementById('btn-create-vacancy')?.addEventListener('click', openModal);
    document.getElementById('btn-close-vacancy-modal').addEventListener('click', closeModal);
    document.getElementById('btn-cancel-vacancy').addEventListener('click', closeModal);
    document.getElementById('modal-vacancy').addEventListener('click', function (e) { if (e.target === this) closeModal(); });

    // Cover Image upload helper logic
    const vCoverUpload = document.getElementById('v-cover-upload');
    const vImgPreview = document.getElementById('v-img-preview');
    const vUploadPlaceholder = document.getElementById('v-upload-placeholder');
    const btnVRemoveImg = document.getElementById('btn-v-remove-img');
    const vCoverDropArea = document.getElementById('v-cover-drop-area');

    if (vUploadPlaceholder) {
        vUploadPlaceholder.addEventListener('click', () => vCoverUpload.click());
    }

    function handleVCoverFile(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function (evt) {
            vImgPreview.src = evt.target.result;
            vImgPreview.classList.remove('hidden');
            vUploadPlaceholder.classList.add('hidden');
            btnVRemoveImg.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    if (vCoverUpload) {
        vCoverUpload.addEventListener('change', function (e) {
            handleVCoverFile(this.files[0]);
        });
    }

    if (vCoverDropArea) {
        ['dragenter', 'dragover'].forEach(eventName => {
            vCoverDropArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                vCoverDropArea.classList.remove('bg-gray-50', 'border-gray-200');
                vCoverDropArea.classList.add('bg-green-50', 'border-green-600');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            vCoverDropArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                vCoverDropArea.classList.remove('bg-green-50', 'border-green-600');
                vCoverDropArea.classList.add('bg-gray-50', 'border-gray-200');
            }, false);
        });

        vCoverDropArea.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            const file = dt.files[0];
            handleVCoverFile(file);
        }, false);
    }

    if (btnVRemoveImg) {
        btnVRemoveImg.addEventListener('click', function (e) {
            e.stopPropagation();
            vCoverUpload.value = '';
            vImgPreview.src = '';
            vImgPreview.classList.add('hidden');
            vUploadPlaceholder.classList.remove('hidden');
            btnVRemoveImg.classList.add('hidden');
        });
    }

    document.getElementById('btn-save-vacancy').addEventListener('click', function () {
        const title      = document.getElementById('v-title').value.trim();
        const categoryId = document.getElementById('v-category').value;
        const location   = document.getElementById('v-location').value;
        const quota      = document.getElementById('v-quota').value;
        const deadline   = document.getElementById('v-deadline').value;
        const status     = document.getElementById('v-status').value;
        const desc       = editDescEditor ? editDescEditor.getData().trim() : document.getElementById('v-desc').value.trim();
        const autoClose  = document.getElementById('v-auto-close').value;
        const ageMin     = document.getElementById('v-age-min').value;
        const ageMax     = document.getElementById('v-age-max').value;
        const passingGrade = document.getElementById('v-passing-grade').value;
        const salaryMin  = document.getElementById('v-salary-min').value.trim();
        const salaryMax  = document.getElementById('v-salary-max').value.trim();
        const showSalary = document.getElementById('v-show-salary').checked ? 1 : 0;
        const requirements = editReqEditor ? editReqEditor.getData().trim() : document.getElementById('v-requirements').value.trim();
        const benefits   = document.getElementById('v-benefits').value.trim();
        const employmentType = document.getElementById('v-employment-type').value;
        const bannerImage = (vImgPreview && !vImgPreview.classList.contains('hidden')) ? vImgPreview.src : null;

        const isDraft = status === 'DRAFT';
        clearModalValidationErrors();
        let isValid = true;

        // Common validations (both Draft and Active)
        if (!title) {
            showModalValidationError('v-title', 'Position title is required.');
            isValid = false;
        }
        if (!categoryId) {
            showModalValidationError('v-category', 'Job category is required.');
            isValid = false;
        }
        if (!location) {
            showModalValidationError('v-location', 'Work location is required.');
            isValid = false;
        }
        if (!quota || quota < 1) {
            showModalValidationError('v-quota', 'Maximum applicants limit is required and must be at least 1.');
            isValid = false;
        }

        // Additional validations only for Active (Publish) status
        if (!isDraft) {
            if (!deadline) {
                showModalValidationError('v-deadline', 'Application deadline is required.');
                isValid = false;
            } else {
                const dlDate = new Date(deadline);
                dlDate.setHours(0, 0, 0, 0);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                if (dlDate < today) {
                    showModalValidationError('v-deadline', 'Deadline cannot be in the past.');
                    isValid = false;
                }
            }
            if (!desc) {
                showModalValidationError('v-desc', 'Job description is required.');
                isValid = false;
            }
            if (!requirements) {
                showModalValidationError('v-requirements', 'Requirements are required.');
                isValid = false;
            }
        }

        if (!isValid) {
            const firstError = document.querySelector('#modal-vacancy .border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        this.disabled = true;
        const isEditing = this.textContent.includes('Save');
        this.textContent = isEditing ? 'Saving...' : 'Creating...';

        if (isEditing) {
            const id = activeRow.dataset.id;
            let dbStatus = 'open';
            if (status === 'DRAFT') dbStatus = 'draft';
            if (status === 'CLOSED') dbStatus = 'closed';
            if (status === 'FILLED') dbStatus = 'filled';

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
                    description: desc,
                    requirements: requirements,
                    benefits: benefits,
                    salary_min: salaryMin || null,
                    salary_max: salaryMax || null,
                    show_salary: showSalary,
                    employment_type: employmentType,
                    banner_image: bannerImage
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
                    alert('Failed to save changes: ' + (data.message || ''));
                    this.disabled = false;
                    this.textContent = 'Save Changes';
                }
            })
            .catch(err => {
                console.error(err);
                if (err.errors) {
                    const firstErr = Object.values(err.errors)[0][0];
                    alert(firstErr);
                } else {
                    alert(err.message || 'An error occurred while saving changes.');
                }
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
                    requirements: requirements,
                    benefits: benefits || null,
                    salary_min: salaryMin || null,
                    salary_max: salaryMax || null,
                    show_salary: showSalary,
                    employment_type: employmentType,
                    banner_image: bannerImage
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
                    alert('Failed to create vacancy: ' + (data.message || ''));
                    this.disabled = false;
                    this.textContent = 'Create Vacancy';
                }
            })
            .catch(err => {
                console.error(err);
                if (err.errors) {
                    const firstErr = Object.values(err.errors)[0][0];
                    alert(firstErr);
                } else {
                    alert(err.message || 'An error occurred while creating the vacancy.');
                }
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
                alert('Failed to close the vacancy.');
                this.disabled = false;
                this.textContent = 'Yes, Close Vacancy';
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred while closing the vacancy.');
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
                status: 'filled'
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
                alert('Failed to update vacancy status.');
                this.disabled = false;
                this.textContent = 'Yes, Mark as Filled';
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred while updating vacancy status.');
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

    const openCatModal = (allowManage = false) => {
        if (catNameInput) catNameInput.value = '';
        const listSec = document.getElementById('manage-category-list-section');
        if (listSec) {
            if (allowManage) {
                listSec.classList.remove('hidden');
            } else {
                listSec.classList.add('hidden');
            }
        }
        modalCategory?.classList.remove('hidden');
    };
    const closeCatModal = () => modalCategory?.classList.add('hidden');

    btnOpenCategory?.addEventListener('click', () => openCatModal(true));
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
                    
                    // Insert before the "+ Add New Category" option to keep it at the bottom
                    const addNewOpt = vCat.querySelector('option[value="ADD_NEW_CATEGORY"]');
                    if (addNewOpt) {
                        vCat.insertBefore(opt, addNewOpt);
                    } else {
                        vCat.appendChild(opt);
                    }
                    
                    vCat.value = data.category.id;
                }

                // Dynamically add to management list
                const catContainer = document.getElementById('category-list-container');
                if (catContainer) {
                    const div = document.createElement('div');
                    div.className = "flex items-center justify-between bg-white px-3.5 py-2.5 rounded-lg border border-gray-200 shadow-sm";
                    div.dataset.id = data.category.id;
                    div.dataset.name = data.category.name;
                    div.innerHTML = `
                        <span class="text-sm font-semibold text-gray-700">${data.category.name}</span>
                        <button class="btn-delete-category text-gray-400 hover:text-red-600 transition-colors p-1" data-id="${data.category.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    `;
                    catContainer.appendChild(div);
                }

                if (catNameInput) catNameInput.value = '';
                showCustomAlert({
                    title: 'Category Added',
                    desc: data.message || 'New category added successfully.',
                    type: 'success'
                });
            } else {
                showCustomAlert({
                    title: 'Failed to Add',
                    desc: 'Failed to add category: ' + (data.message || ''),
                    type: 'error'
                });
            }
        })
        .catch(err => {
            console.error(err);
            showCustomAlert({
                title: 'Error',
                desc: err.message || 'An error occurred while adding the category.',
                type: 'error'
            });
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Add';
        });
    });

    // Helper function for custom confirmation modal
    function showCustomConfirm({ title, desc, iconType, onConfirm }) {
        const modal = document.getElementById('modal-custom-confirm');
        const titleEl = document.getElementById('confirm-modal-title');
        const descEl = document.getElementById('confirm-modal-desc');
        const iconContainer = document.getElementById('confirm-modal-icon-container');
        const btnOk = document.getElementById('btn-confirm-ok');
        const btnCancel = document.getElementById('btn-confirm-cancel');
        const btnClose = document.getElementById('btn-close-confirm-modal');

        if (titleEl) titleEl.textContent = title;
        if (descEl) descEl.textContent = desc;

        if (iconContainer) {
            if (iconType === 'category') {
                iconContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>`;
            } else if (iconType === 'location') {
                iconContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>`;
            }
        }

        modal?.classList.remove('hidden');

        const closeConfirm = () => {
            modal?.classList.add('hidden');
        };

        if (btnOk) {
            btnOk.onclick = function() {
                closeConfirm();
                if (onConfirm) onConfirm();
            };
        }

        if (btnCancel) {
            btnCancel.onclick = closeConfirm;
        }

        if (btnClose) {
            btnClose.onclick = closeConfirm;
        }
    }

    // Helper function for custom alert modal
    function showCustomAlert({ title, desc, type }) {
        const modal = document.getElementById('modal-custom-alert');
        const titleEl = document.getElementById('alert-modal-title');
        const descEl = document.getElementById('alert-modal-desc');
        const iconContainer = document.getElementById('alert-modal-icon-container');
        const btnOk = document.getElementById('btn-alert-ok');
        const btnClose = document.getElementById('btn-close-alert-modal');

        if (titleEl) titleEl.textContent = title;
        if (descEl) descEl.textContent = desc;

        if (iconContainer && btnOk) {
            if (type === 'success') {
                iconContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`;
                iconContainer.className = "w-14 h-14 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4";
                btnOk.className = "w-full bg-[#15803d] hover:bg-[#166534] text-white font-semibold py-2.5 rounded-lg text-sm transition-colors focus:outline-none";
            } else {
                iconContainer.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>`;
                iconContainer.className = "w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4";
                btnOk.className = "w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors focus:outline-none";
            }
        }

        modal?.classList.remove('hidden');

        const closeAlert = () => {
            modal?.classList.add('hidden');
        };

        if (btnOk) btnOk.onclick = closeAlert;
        if (btnClose) btnClose.onclick = closeAlert;
    }

    // Event delegation for deleting category
    const catContainer = document.getElementById('category-list-container');
    catContainer?.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-category');
        if (!btn) return;
        const id = btn.dataset.id;
        const row = btn.closest('[data-name]');
        const name = row.dataset.name;

        showCustomConfirm({
            title: 'Delete Category',
            desc: `Are you sure you want to delete category "${name}"?`,
            iconType: 'category',
            onConfirm: function() {
                btn.disabled = true;

                fetch(`/hr/lowongan/kategori/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) return response.json().then(err => { throw err; });
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        row.remove();

                        const filterCat = document.getElementById('filter-category');
                        if (filterCat) {
                            const opt = filterCat.querySelector(`option[value="${name}"]`);
                            opt?.remove();
                        }

                        const vCat = document.getElementById('v-category');
                        if (vCat) {
                            const opt = vCat.querySelector(`option[value="${id}"]`);
                            opt?.remove();
                        }
                    } else {
                        showCustomAlert({
                            title: 'Failed to Delete',
                            desc: data.message || 'Failed to delete category.',
                            type: 'error'
                        });
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error(err);
                    showCustomAlert({
                        title: 'Error',
                        desc: err.message || 'An error occurred while deleting the category.',
                        type: 'error'
                    });
                    btn.disabled = false;
                });
            }
        });
    });

    // Detect when "+ Tambah Kategori Baru" is selected in vacancy form
    const vCategory = document.getElementById('v-category');
    if (vCategory) {
        vCategory.addEventListener('change', function () {
            if (this.value === 'ADD_NEW_CATEGORY') {
                this.value = ''; // Reset select to placeholder
                openCatModal(false);
            }
        });
    }

    // ===== MODAL: Add Location =====
    const modalLocation = document.getElementById('modal-add-location');
    const btnOpenLocation = document.getElementById('btn-open-location-modal');
    const btnCloseLocation = document.getElementById('btn-close-location-modal');
    const btnCancelLocation = document.getElementById('btn-cancel-location');
    const btnSaveLocation = document.getElementById('btn-save-location');
    const locNameInput = document.getElementById('loc-name-input');

    const openLocModal = (allowManage = false) => {
        if (locNameInput) locNameInput.value = '';
        const listSec = document.getElementById('manage-location-list-section');
        if (listSec) {
            if (allowManage) {
                listSec.classList.remove('hidden');
            } else {
                listSec.classList.add('hidden');
            }
        }
        modalLocation?.classList.remove('hidden');
    };
    const closeLocModal = () => modalLocation?.classList.add('hidden');

    btnOpenLocation?.addEventListener('click', () => openLocModal(true));
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
                // Dynamically add to Location filter and Location selection dropdowns
                const filterLoc = document.getElementById('filter-location');
                const vLoc = document.getElementById('v-location');

                if (filterLoc) {
                    const opt = document.createElement('option');
                    opt.value = data.location.name;
                    opt.textContent = data.location.name;
                    filterLoc.appendChild(opt);
                }

                if (vLoc) {
                    const opt = document.createElement('option');
                    opt.value = data.location.name;
                    opt.textContent = data.location.name;
                    
                    const addNewOpt = vLoc.querySelector('option[value="ADD_NEW_LOCATION"]');
                    if (addNewOpt) {
                        vLoc.insertBefore(opt, addNewOpt);
                    } else {
                        vLoc.appendChild(opt);
                    }
                    
                    vLoc.value = data.location.name;
                }

                // Dynamically add to management list
                const locContainer = document.getElementById('location-list-container');
                if (locContainer) {
                    const div = document.createElement('div');
                    div.className = "flex items-center justify-between bg-white px-3.5 py-2.5 rounded-lg border border-gray-200 shadow-sm";
                    div.dataset.id = data.location.id;
                    div.dataset.name = data.location.name;
                    div.innerHTML = `
                        <span class="text-sm font-semibold text-gray-700">${data.location.name}</span>
                        <button class="btn-delete-location text-gray-400 hover:text-red-600 transition-colors p-1" data-id="${data.location.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    `;
                    locContainer.appendChild(div);
                }

                if (locNameInput) locNameInput.value = '';
                showCustomAlert({
                    title: 'Location Added',
                    desc: data.message || 'New work location added successfully.',
                    type: 'success'
                });
            } else {
                showCustomAlert({
                    title: 'Failed to Add',
                    desc: 'Failed to add location: ' + (data.message || ''),
                    type: 'error'
                });
            }
        })
        .catch(err => {
            console.error(err);
            showCustomAlert({
                title: 'Error',
                desc: err.message || 'An error occurred while adding the location.',
                type: 'error'
            });
        })
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Add';
        });
    });

    // Event delegation for deleting location
    const locContainer = document.getElementById('location-list-container');
    locContainer?.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-delete-location');
        if (!btn) return;
        const id = btn.dataset.id;
        const row = btn.closest('[data-name]');
        const name = row.dataset.name;

        showCustomConfirm({
            title: 'Delete Location',
            desc: `Are you sure you want to delete location "${name}"?`,
            iconType: 'location',
            onConfirm: function() {
                btn.disabled = true;

                fetch(`/hr/lowongan/lokasi/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) return response.json().then(err => { throw err; });
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        row.remove();

                        const filterLoc = document.getElementById('filter-location');
                        if (filterLoc) {
                            const opt = filterLoc.querySelector(`option[value="${name}"]`);
                            opt?.remove();
                        }

                        const vLoc = document.getElementById('v-location');
                        if (vLoc) {
                            const opt = vLoc.querySelector(`option[value="${name}"]`);
                            opt?.remove();
                        }
                    } else {
                        showCustomAlert({
                            title: 'Failed to Delete',
                            desc: data.message || 'Failed to delete location.',
                            type: 'error'
                        });
                        btn.disabled = false;
                    }
                })
                .catch(err => {
                    console.error(err);
                    showCustomAlert({
                        title: 'Error',
                        desc: err.message || 'An error occurred while deleting the location.',
                        type: 'error'
                    });
                    btn.disabled = false;
                });
            }
        });
    });

    // Detect when "+ Tambah Lokasi Baru" is selected in vacancy form
    const vLocation = document.getElementById('v-location');
    if (vLocation) {
        vLocation.addEventListener('change', function () {
            if (this.value === 'ADD_NEW_LOCATION') {
                this.value = ''; // Reset select to placeholder
                openLocModal(false);
            }
        });
    }

    // Click/Hover logic for the info tooltips on stats cards
    document.querySelectorAll('.relative.inline-block').forEach(wrapper => {
        const btn = wrapper.querySelector('.info-btn');
        const tooltip = wrapper.querySelector('.info-tooltip');
        if (btn && tooltip) {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // Close any other open info tooltips first
                document.querySelectorAll('.info-tooltip').forEach(t => {
                    if (t !== tooltip) t.classList.add('hidden');
                });
                tooltip.classList.toggle('hidden');
            });

            wrapper.addEventListener('mouseleave', () => {
                tooltip.classList.add('hidden');
            });
        }
    });

    // Initialize pagination
    applyFilters();

    // Auto-open edit modal if query parameter ?edit=ID is present
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');
    if (editId) {
        const targetRow = document.querySelector(`.vacancy-row[data-id="${editId}"]`);
        if (targetRow) {
            activeRow = targetRow;
            setTimeout(() => {
                openEditModal();
            }, 100);
        }
    }
});
