/**
 * HR Lowongan Detail JS
 * Chart mulai dari hari loker dibuka, Weekly bisa di-klik untuk drill-down ke Daily.
 */
document.addEventListener('DOMContentLoaded', function () {

    // ===== POSTED DATE (hari pertama loker dibuka) =====
    const POSTED_DATE = window.postedDate ? new Date(window.postedDate) : new Date('2023-10-12');
    const DAYS_ID    = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const MONTHS_ID  = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    // ===== DYNAMIC DATA =====
    const weeklyDailyData = window.weeklyDailyData || [
        [0, 0, 0, 0, 0, 0, 0],   // Week 1
        [0, 0, 0, 0, 0, 0, 0],   // Week 2
        [0, 0, 0, 0, 0, 0, 0],   // Week 3
        [0, 0, 0, 0, 0, 0, 0]    // Week 4
    ];

    // ===== DOM =====
    const svg        = document.getElementById('trend-chart');
    const pathLine   = document.getElementById('chart-line');
    const pathArea   = document.getElementById('chart-area');
    const pointsG    = document.getElementById('chart-points');
    const btnDaily   = document.getElementById('btn-daily');
    const btnWeekly  = document.getElementById('btn-weekly');
    const subtitleEl = document.getElementById('chart-subtitle');
    const xLabels    = document.getElementById('x-labels');
    const chartTitle = document.querySelector('h2.font-bold.text-gray-900.text-lg');

    // Geometry
    const W = 600, H = 280;
    const padX = 30, padTop = 20, padBot = 40;
    const chartW = W - padX * 2;
    const chartH = H - padTop - padBot;

    // ===== HELPERS =====
    function formatDate(d) {
        return d.getDate() + ' ' + MONTHS_ID[d.getMonth()];
    }

    function getDailyLabels(startDate, count = 7) {
        const labels = [];
        for (let i = 0; i < count; i++) {
            const d = new Date(startDate);
            d.setDate(d.getDate() + i);
            labels.push({
                short: DAYS_ID[d.getDay()],
                full:  DAYS_ID[d.getDay()] + ', ' + formatDate(d)
            });
        }
        return labels;
    }

    function dataToPoints(values) {
        const rawMax = Math.max(...values);
        let max;
        if (rawMax === 0)       max = 5;
        else if (rawMax <= 30)  max = Math.ceil(rawMax / 5)  * 5;
        else if (rawMax <= 100) max = Math.ceil(rawMax / 10) * 10;
        else                    max = Math.ceil(rawMax / 25) * 25;

        const pts = values.map((v, i) => ({
            x: padX + (i * (chartW / (values.length - 1))),
            y: padTop + chartH - (v / max) * chartH,
            value: v
        }));
        return { pts, max };
    }

    function buildSmoothPath(pts) {
        if (pts.length < 2) return '';
        let d = `M ${pts[0].x} ${pts[0].y}`;
        for (let i = 0; i < pts.length - 1; i++) {
            const p0 = pts[i - 1] || pts[i];
            const p1 = pts[i];
            const p2 = pts[i + 1];
            const p3 = pts[i + 2] || p2;

            const cp1x = p1.x + (p2.x - p0.x) / 6;
            const cp1y = p1.y + (p2.y - p0.y) / 6;
            const cp2x = p2.x - (p3.x - p1.x) / 6;
            const cp2y = p2.y - (p3.y - p1.y) / 6;

            d += ` C ${cp1x} ${cp1y}, ${cp2x} ${cp2y}, ${p2.x} ${p2.y}`;
        }
        return d;
    }

    // Tooltip
    const tooltip = document.createElement('div');
    tooltip.className = 'fixed z-50 bg-green-900 text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-lg pointer-events-none hidden';
    document.body.appendChild(tooltip);

    // ===== RENDER =====
    function render(points, labels, max, opts = {}) {
        // Line + area
        const linePath  = buildSmoothPath(points);
        const baselineY = padTop + chartH;
        const areaPath  = linePath + ` L ${points[points.length-1].x} ${baselineY} L ${points[0].x} ${baselineY} Z`;
        pathLine.setAttribute('d', linePath);
        pathArea.setAttribute('d', areaPath);

        // Y-axis
        document.getElementById('y-max').textContent     = max;
        document.getElementById('y-mid-top').textContent = Math.round(max * 0.75);
        document.getElementById('y-mid').textContent     = Math.round(max * 0.5);
        document.getElementById('y-mid-bot').textContent = Math.round(max * 0.25);

        // Points
        pointsG.innerHTML = '';
        points.forEach((p, i) => {
            const halo = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            halo.setAttribute('cx', p.x);
            halo.setAttribute('cy', p.y);
            halo.setAttribute('r', '10');
            halo.setAttribute('fill', '#166534');
            halo.setAttribute('fill-opacity', '0.12');
            pointsG.appendChild(halo);

            const dot = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            dot.setAttribute('cx', p.x);
            dot.setAttribute('cy', p.y);
            dot.setAttribute('r', '5');
            dot.setAttribute('fill', '#166534');
            dot.setAttribute('stroke', '#ffffff');
            dot.setAttribute('stroke-width', '2.5');
            dot.style.cursor = opts.clickable ? 'pointer' : 'default';
            dot.style.transition = 'r 0.2s';

            const labelFull = labels[i].full || labels[i];
            const value     = p.value;

            dot.addEventListener('mouseenter', function () {
                dot.setAttribute('r', '7');
                const extra = opts.clickable ? '<div class="text-[10px] text-green-400 mt-1">Click for daily details →</div>' : '';
                tooltip.innerHTML = `<div class="text-[10px] text-green-300 uppercase tracking-wider mb-0.5">${labelFull}</div><div class="text-sm font-bold">${value} applicants</div>${extra}`;
                tooltip.classList.remove('hidden');
            });
            dot.addEventListener('mousemove', e => {
                tooltip.style.left = (e.clientX + 12) + 'px';
                tooltip.style.top  = (e.clientY - 50) + 'px';
            });
            dot.addEventListener('mouseleave', () => {
                dot.setAttribute('r', '5');
                tooltip.classList.add('hidden');
            });

            // Weekly drill-down: klik titik → daily view minggu itu
            if (opts.clickable) {
                dot.addEventListener('click', () => {
                    tooltip.classList.add('hidden');
                    showDaily(i); // i = index minggu (0 = Week 1)
                });
                halo.style.cursor = 'pointer';
                halo.addEventListener('click', () => {
                    tooltip.classList.add('hidden');
                    showDaily(i);
                });
            }

            pointsG.appendChild(dot);
        });

        // X-axis
        xLabels.innerHTML = labels.map(l => {
            const text = typeof l === 'string' ? l : l.short;
            return `<span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">${text}</span>`;
        }).join('');
    }

    // ===== DAILY VIEW =====
    // weekIndex: 0 = minggu ke-1 (sejak dibuka), default minggu pertama
    function showDaily(weekIndex = 0) {
        const values = weeklyDailyData[weekIndex];
        const { pts, max } = dataToPoints(values);

        // Start date untuk minggu ini
        const startDate = new Date(POSTED_DATE);
        startDate.setDate(startDate.getDate() + (weekIndex * 7));
        const labels = getDailyLabels(startDate, 7);

        chartTitle.textContent = weekIndex === 0
            ? 'Daily Applicants'
            : 'Daily Applicants — Week ' + (weekIndex + 1);

        const endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + 6);
        subtitleEl.innerHTML = weekIndex === 0
            ? 'Since vacancy opened (' + formatDate(POSTED_DATE) + ' – ' + formatDate(endDate) + ')'
            : formatDate(startDate) + ' – ' + formatDate(endDate) + ' · <button id="btn-back-weekly" class="text-green-700 hover:text-green-900 font-semibold transition-colors">← Back to Weekly</button>';

        render(pts, labels, max);

        // Active button state
        activeBtn(btnDaily, btnWeekly);

        // Bind back button (if exists)
        const btnBack = document.getElementById('btn-back-weekly');
        if (btnBack) btnBack.addEventListener('click', showWeekly);
    }

    // ===== WEEKLY VIEW =====
    function showWeekly() {
        // Sum per minggu
        const totals = weeklyDailyData.map(week => week.reduce((a, b) => a + b, 0));
        const { pts, max } = dataToPoints(totals);

        // Labels: Minggu 1..N + tanggal rentang
        const labels = totals.map((_, i) => {
            const start = new Date(POSTED_DATE);
            start.setDate(start.getDate() + (i * 7));
            const end = new Date(start);
            end.setDate(end.getDate() + 6);
            return {
                short: 'W' + (i + 1),
                full:  'Week ' + (i + 1) + ' (' + formatDate(start) + ' – ' + formatDate(end) + ')'
            };
        });

        chartTitle.textContent = 'Weekly Applicants';
        subtitleEl.textContent = 'Total applicants per week · Click data points for daily details';

        render(pts, labels, max, { clickable: true });

        activeBtn(btnWeekly, btnDaily);
    }

    function activeBtn(on, off) {
        on.classList.add('bg-white', 'text-gray-800', 'shadow-sm');
        on.classList.remove('text-gray-500');
        off.classList.remove('bg-white', 'text-gray-800', 'shadow-sm');
        off.classList.add('text-gray-500');
    }

    // ===== EVENT HANDLERS =====
    btnDaily?.addEventListener('click',  () => showDaily(0));
    btnWeekly?.addEventListener('click', () => showWeekly());

    // Initial render: daily minggu pertama
    showDaily(0);

    // ===== APPLICANT SEARCH =====
    const detailSearch = document.getElementById('detail-search');
    if (detailSearch) {
        detailSearch.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            const items = document.querySelectorAll('.recent-applicant-item');
            const noMatches = document.getElementById('no-recent-matches');
            
            let visibleCount = 0;
            items.forEach(item => {
                const name = item.dataset.name || '';
                const education = item.dataset.education || '';
                if (name.includes(query) || education.includes(query)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (noMatches) {
                if (visibleCount === 0 && items.length > 0) {
                    noMatches.classList.remove('hidden');
                } else {
                    noMatches.classList.add('hidden');
                }
            }
        });

        // Redirect on Enter key
        detailSearch.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                const vacancyId = this.dataset.vacancyId;
                if (vacancyId) {
                    window.location.href = `/hr/pelamar?lowongan=${vacancyId}&search=${encodeURIComponent(query)}`;
                }
            }
        });
    }

    // ===== PUBLISH VACANCY FROM DETAIL PAGE =====
    const btnPublishDetail = document.getElementById('btn-publish-detail');
    const modalPublish = document.getElementById('modal-publish-vacancy');
    const btnClosePublish = document.getElementById('btn-close-publish-modal');
    const btnCancelPublish = document.getElementById('btn-cancel-publish-vacancy');
    const btnConfirmPublish = document.getElementById('btn-confirm-publish-vacancy');

    const modalIncomplete = document.getElementById('modal-incomplete-vacancy');
    const btnCloseIncomplete = document.getElementById('btn-close-incomplete-modal');
    const btnConfirmIncompleteOk = document.getElementById('btn-confirm-incomplete-ok');

    if (btnPublishDetail) {
        btnPublishDetail.addEventListener('click', () => {
            modalPublish?.classList.remove('hidden');
        });
    }

    function closePublishModal() {
        modalPublish?.classList.add('hidden');
    }

    function closeIncompleteModal() {
        modalIncomplete?.classList.add('hidden');
    }

    btnClosePublish?.addEventListener('click', closePublishModal);
    btnCancelPublish?.addEventListener('click', closePublishModal);
    modalPublish?.addEventListener('click', (e) => {
        if (e.target === modalPublish) closePublishModal();
    });

    btnCloseIncomplete?.addEventListener('click', closeIncompleteModal);
    btnConfirmIncompleteOk?.addEventListener('click', closeIncompleteModal);
    modalIncomplete?.addEventListener('click', (e) => {
        if (e.target === modalIncomplete) closeIncompleteModal();
    });

    if (btnConfirmPublish && btnPublishDetail) {
        btnConfirmPublish.addEventListener('click', function () {
            const id = btnPublishDetail.dataset.id;
            if (!id) return;

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
                modalIncomplete?.classList.remove('hidden');
            })
            .finally(() => {
                this.disabled = false;
                this.textContent = 'Yes, Publish';
            });
        });
    }

    // ==========================================
    // ===== MODAL EDIT VACANCY DIRECT FLOW =====
    // ==========================================

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

    const descTextarea = document.querySelector('#v-desc');
    const reqTextarea = document.querySelector('#v-requirements');

    if (descTextarea) {
        CKEDITOR.ClassicEditor
            .create(descTextarea, editorConfig)
            .then(editor => {
                editDescEditor = editor;
                editor.model.document.on('change:data', () => {
                    clearModalFieldError(document.getElementById('v-desc'), true);
                });
            })
            .catch(error => {
                console.error('Error initializing edit description editor:', error);
            });
    }

    if (reqTextarea) {
        CKEDITOR.ClassicEditor
            .create(reqTextarea, editorConfig)
            .then(editor => {
                editReqEditor = editor;
                editor.model.document.on('change:data', () => {
                    clearModalFieldError(document.getElementById('v-requirements'), true);
                });
            })
            .catch(error => {
                console.error('Error initializing edit requirements editor:', error);
            });
    }

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

    // ===== OPEN AND CLOSE EDIT MODAL =====
    const modalVacancy = document.getElementById('modal-vacancy');
    const btnEditDetail = document.getElementById('btn-edit-detail');
    const btnCloseVacancyModal = document.getElementById('btn-close-vacancy-modal');
    const btnCancelVacancy = document.getElementById('btn-cancel-vacancy');
    const btnSaveVacancy = document.getElementById('btn-save-vacancy');

    function openEditModal() {
        const data = window.vacancyData;
        if (!data) return;

        clearModalValidationErrors();

        // Populate fields
        document.getElementById('v-title').value = data.title || '';
        document.getElementById('v-category').value = data.category_id || '';
        document.getElementById('v-employment-type').value = data.employment_type || 'full-time';
        document.getElementById('v-location').value = data.location || '';
        document.getElementById('v-quota').value = data.quota || '';
        document.getElementById('v-deadline').value = data.deadline || '';
        document.getElementById('v-age-min').value = data.age_min || '';
        document.getElementById('v-age-max').value = data.age_max || '';
        document.getElementById('v-passing-grade').value = data.passing_grade || '70';
        document.getElementById('v-auto-close').value = data.auto_close_method || 'both';
        document.getElementById('v-show-salary').checked = !!data.show_salary;
        document.getElementById('v-benefits').value = data.benefits || '';

        // Formatted Salary
        let salaryMin = data.salary_min || '';
        let salaryMax = data.salary_max || '';
        if (salaryMin && !isNaN(salaryMin)) {
            salaryMin = parseInt(salaryMin).toLocaleString('id-ID');
        }
        if (salaryMax && !isNaN(salaryMax)) {
            salaryMax = parseInt(salaryMax).toLocaleString('id-ID');
        }
        document.getElementById('v-salary-min').value = salaryMin;
        document.getElementById('v-salary-max').value = salaryMax;

        // Status
        const dbStatus = (data.status || 'draft').toUpperCase();
        document.getElementById('v-status').value = dbStatus === 'OPEN' ? 'ACTIVE' : dbStatus;

        // Description & Requirements in editors
        if (editDescEditor) {
            editDescEditor.setData(data.description || '');
        } else {
            document.getElementById('v-desc').value = data.description || '';
        }
        if (editReqEditor) {
            editReqEditor.setData(data.requirements || '');
        } else {
            document.getElementById('v-requirements').value = data.requirements || '';
        }

        // Cover Image Preview
        const vImgPreview = document.getElementById('v-img-preview');
        const vUploadPlaceholder = document.getElementById('v-upload-placeholder');
        const btnVRemoveImg = document.getElementById('btn-v-remove-img');
        if (data.banner_image) {
            vImgPreview.src = '/' + data.banner_image;
            vImgPreview.classList.remove('hidden');
            vUploadPlaceholder.classList.add('hidden');
            btnVRemoveImg.classList.remove('hidden');
        } else {
            vImgPreview.src = '';
            vImgPreview.classList.add('hidden');
            vUploadPlaceholder.classList.remove('hidden');
            btnVRemoveImg.classList.add('hidden');
        }

        // Check if vacancy is already published (not draft)
        const isPublished = (dbStatus !== 'DRAFT');
        const lockBanner = document.getElementById('v-published-lock-banner');
        if (lockBanner) {
            if (isPublished) {
                lockBanner.classList.remove('hidden');
            } else {
                lockBanner.classList.add('hidden');
            }
        }

        // Lock fields if published
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
        if (coverUpload) coverUpload.disabled = false;

        const coverPlaceholder = document.getElementById('v-upload-placeholder');
        if (coverPlaceholder) {
            coverPlaceholder.classList.remove('cursor-not-allowed', 'opacity-60');
            coverPlaceholder.style.pointerEvents = '';
        }

        if (btnVRemoveImg) {
            if (data.banner_image) {
                btnVRemoveImg.classList.remove('hidden');
            } else {
                btnVRemoveImg.classList.add('hidden');
            }
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

        modalVacancy.classList.remove('hidden');
    }

    function closeModal() {
        modalVacancy.classList.add('hidden');
    }

    if (btnEditDetail) {
        btnEditDetail.addEventListener('click', openEditModal);
    }

    btnCloseVacancyModal?.addEventListener('click', closeModal);
    btnCancelVacancy?.addEventListener('click', closeModal);
    modalVacancy?.addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    document.getElementById('btn-incomplete-lengkapi')?.addEventListener('click', () => {
        closeIncompleteModal();
        openEditModal();
    });

    // ===== COVER IMAGE UPLOAD LOGIC =====
    const vCoverUpload = document.getElementById('v-cover-upload');
    const vImgPreview = document.getElementById('v-img-preview');
    const vUploadPlaceholder = document.getElementById('v-upload-placeholder');
    const btnVRemoveImg = document.getElementById('btn-v-remove-img');
    const vCoverDropArea = document.getElementById('v-cover-drop-area');

    if (vUploadPlaceholder) {
        vUploadPlaceholder.addEventListener('click', () => {
            vCoverUpload.click();
        });
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
        vCoverUpload.addEventListener('change', function () {
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

    // ===== SAVE ACTION LOGIC =====
    if (btnSaveVacancy) {
        btnSaveVacancy.addEventListener('click', function () {
            const data = window.vacancyData;
            if (!data) return;

            const title = document.getElementById('v-title').value.trim();
            const categoryId = document.getElementById('v-category').value;
            const location = document.getElementById('v-location').value;
            const quota = document.getElementById('v-quota').value;
            const deadline = document.getElementById('v-deadline').value;
            const status = document.getElementById('v-status').value;
            const desc = editDescEditor ? editDescEditor.getData().trim() : document.getElementById('v-desc').value.trim();
            const requirements = editReqEditor ? editReqEditor.getData().trim() : document.getElementById('v-requirements').value.trim();
            const autoClose = document.getElementById('v-auto-close').value;
            const ageMin = document.getElementById('v-age-min').value;
            const ageMax = document.getElementById('v-age-max').value;
            const passingGrade = document.getElementById('v-passing-grade').value;
            const salaryMin = document.getElementById('v-salary-min').value.trim();
            const salaryMax = document.getElementById('v-salary-max').value.trim();
            const showSalary = document.getElementById('v-show-salary').checked ? 1 : 0;
            const benefits = document.getElementById('v-benefits').value.trim();
            const employmentType = document.getElementById('v-employment-type').value;
            const bannerImage = (vImgPreview && !vImgPreview.classList.contains('hidden')) ? vImgPreview.src : null;

            const isDraft = status === 'DRAFT';
            clearModalValidationErrors();
            let isValid = true;

            // Common validations
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

            // Additional validations for Active (Publish) status
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
            this.textContent = 'Saving...';

            let dbStatus = 'open';
            if (status === 'DRAFT') dbStatus = 'draft';
            if (status === 'CLOSED') dbStatus = 'closed';
            if (status === 'FILLED') dbStatus = 'filled';

            fetch('/hr/lowongan/' + data.id, {
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
            .then(resData => {
                if (resData.success) {
                    window.location.reload();
                } else {
                    alert('Failed to save changes: ' + (resData.message || ''));
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
        });
    }

    // ===========================================
    // ===== MANAGE CATEGORIES AND LOCATIONS =====
    // ===========================================

    // ===== CATEGORY MODAL FLOW =====
    const modalCategory = document.getElementById('modal-add-category');
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

    btnCloseCategory?.addEventListener('click', closeCatModal);
    btnCancelCategory?.addEventListener('click', closeCatModal);
    modalCategory?.addEventListener('click', function (e) { if (e.target === this) closeCatModal(); });

    const vCategory = document.getElementById('v-category');
    if (vCategory) {
        vCategory.addEventListener('change', function () {
            if (this.value === 'ADD_NEW_CATEGORY') {
                this.value = '';
                openCatModal(false);
            }
        });
    }

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
                const vCat = document.getElementById('v-category');
                if (vCat) {
                    const opt = document.createElement('option');
                    opt.value = data.category.id;
                    opt.textContent = data.category.name;
                    const addNewOpt = vCat.querySelector('option[value="ADD_NEW_CATEGORY"]');
                    if (addNewOpt) {
                        vCat.insertBefore(opt, addNewOpt);
                    } else {
                        vCat.appendChild(opt);
                    }
                    vCat.value = data.category.id;
                }

                // Add to management list
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

    // ===== LOCATION MODAL FLOW =====
    const modalLocation = document.getElementById('modal-add-location');
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

    btnCloseLocation?.addEventListener('click', closeLocModal);
    btnCancelLocation?.addEventListener('click', closeLocModal);
    modalLocation?.addEventListener('click', function (e) { if (e.target === this) closeLocModal(); });

    const vLocation = document.getElementById('v-location');
    if (vLocation) {
        vLocation.addEventListener('change', function () {
            if (this.value === 'ADD_NEW_LOCATION') {
                this.value = '';
                openLocModal(false);
            }
        });
    }

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
                const vLoc = document.getElementById('v-location');
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

                // Add to management list
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

    // ===== CATEGORY & LOCATION DELETION FLOW =====
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

    // ===== HELPER: CONFIRM & ALERT MODALS =====
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
        if (btnCancel) btnCancel.onclick = closeConfirm;
        if (btnClose) btnClose.onclick = closeConfirm;
    }

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

    // ===== LIVE COUNTDOWN TIMER FOR VACANCY DEADLINE =====
    const countdownContainer = document.getElementById('countdown-container');
    if (countdownContainer) {
        const deadlineStr = countdownContainer.dataset.deadline;
        const createdStr = countdownContainer.dataset.created;
        const timerEl = document.getElementById('countdown-timer');
        const warningEl = document.getElementById('time-warning-icon');
        const progressBar = document.getElementById('time-progress-bar');
        
        if (!deadlineStr) {
            if (timerEl) timerEl.textContent = 'Indefinite';
            if (progressBar) progressBar.style.width = '100%';
        } else {
            const deadlineTime = new Date(deadlineStr).getTime();
            const createdTime = new Date(createdStr).getTime();
            const totalDuration = deadlineTime - createdTime;

            function updateTimer() {
                const now = new Date().getTime();
                const diff = deadlineTime - now;

                if (diff <= 0) {
                    if (timerEl) timerEl.textContent = "Time's Up";
                    if (warningEl) {
                        warningEl.classList.remove('hidden');
                        warningEl.classList.add('inline-flex');
                    }
                    if (progressBar) progressBar.style.width = '0%';
                    clearInterval(timerInterval);
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                let displayStr = '';
                if (days > 0) {
                    displayStr += days + 'd ' + hours + 'h ' + minutes + 'm';
                } else {
                    const pad = (num) => String(num).padStart(2, '0');
                    displayStr += pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
                }

                if (timerEl) timerEl.textContent = displayStr;
                if (warningEl) {
                    warningEl.classList.add('hidden');
                    warningEl.classList.remove('inline-flex');
                }

                // Update progress bar dynamically
                if (progressBar && totalDuration > 0) {
                    const percent = Math.max(0, Math.min(100, (diff / totalDuration) * 100));
                    progressBar.style.width = percent + '%';
                }
            }

            updateTimer();
            const timerInterval = setInterval(updateTimer, 1000);
        }
    }

    // ===== CUSTOM MULTI-TRIGGER TOOLTIP SYSTEM =====
    const tooltips = document.querySelectorAll('.tooltip-container');
    tooltips.forEach(container => {
        const text = container.getAttribute('data-tooltip');
        if (!text) return;

        // Create tooltip element
        const tooltipEl = document.createElement('div');
        tooltipEl.className = 'absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs rounded py-2 px-3 w-56 z-50 shadow-2xl leading-normal text-center opacity-0 pointer-events-none transition-all duration-200 transform translate-y-1';
        tooltipEl.innerHTML = `
            ${text}
            <span class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></span>
        `;
        
        container.classList.add('relative');
        container.appendChild(tooltipEl);

        let isPinned = false;

        const showTooltip = () => {
            tooltipEl.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-1');
            tooltipEl.classList.add('opacity-100', 'translate-y-0');
        };

        const hideTooltip = () => {
            if (!isPinned) {
                tooltipEl.classList.remove('opacity-100', 'translate-y-0');
                tooltipEl.classList.add('opacity-0', 'pointer-events-none', 'translate-y-1');
            }
        };

        // Hover events
        container.addEventListener('mouseenter', showTooltip);
        container.addEventListener('mouseleave', hideTooltip);

        // Click event to toggle/pin
        container.addEventListener('click', (e) => {
            e.stopPropagation();
            isPinned = !isPinned;
            if (isPinned) {
                // Close other tooltips
                document.querySelectorAll('.tooltip-container > div').forEach(el => {
                    if (el !== tooltipEl) {
                        el.classList.remove('opacity-100', 'translate-y-0');
                        el.classList.add('opacity-0', 'pointer-events-none', 'translate-y-1');
                    }
                });
                showTooltip();
            } else {
                tooltipEl.classList.remove('opacity-100', 'translate-y-0');
                tooltipEl.classList.add('opacity-0', 'pointer-events-none', 'translate-y-1');
            }
        });

        // Close when clicking anywhere else
        document.addEventListener('click', () => {
            isPinned = false;
            tooltipEl.classList.remove('opacity-100', 'translate-y-0');
            tooltipEl.classList.add('opacity-0', 'pointer-events-none', 'translate-y-1');
        });
    });
});