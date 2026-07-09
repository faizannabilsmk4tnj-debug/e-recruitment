/**
 * HR Pelamar List JS — Enhanced
 */
document.addEventListener('DOMContentLoaded', function () {

    const state = {
        focus: 'all',
        search: '',
        dept: '',
        sort: 'pelamar-desc',
    };

    const container = document.getElementById('lowongan-container');
    const cards = () => Array.from(document.querySelectorAll('.lowongan-card'));
    const emptyResult = document.getElementById('empty-result');
    const activeFilterBar = document.getElementById('active-filter-bar');
    const activeFilterPills = document.getElementById('active-filter-pills');
    const visibleLowEl = document.getElementById('visible-lowongan-count');
    const visibleAppEl = document.getElementById('visible-applicant-count');

    // Per-card status tab state
    const statusTabState = new WeakMap();

    // ===== MAIN APPLY =====
    function apply() {
        let visibleLowCount = 0;
        let visibleAppCount = 0;

        cards().forEach(card => {
            const title = card.dataset.title;
            const dept = card.dataset.department;
            const rows = card.querySelectorAll('.applicant-row');
            const emptyRow = card.querySelector('.applicant-empty');
            const statusTab = statusTabState.get(card) || 'all';

            const deptMatch = !state.dept || dept === state.dept;
            const titleMatch = !state.search || title.includes(state.search);

            let matchedRows = 0;
            rows.forEach(row => {
                const name = row.dataset.name;
                const email = row.dataset.email;
                const status = row.dataset.status;

                const searchMatch = !state.search || titleMatch || name.includes(state.search) || email.includes(state.search);

                let focusMatch = true;
                if (state.focus === 'review') focusMatch = (status === 'terkirim' || status === 'shortlisted');
                if (state.focus === 'interview') focusMatch = (status === 'interview');
                if (state.focus === 'decision') focusMatch = (status === 'shortlisted');

                const statusTabMatch = (statusTab === 'all') || (status === statusTab);

                const show = searchMatch && focusMatch && statusTabMatch;
                row.style.display = show ? '' : 'none';

                if (show) matchedRows++;
                highlightSearch(row, state.search);
            });

            const countEl = card.querySelector('.filter-count');
            if (countEl) countEl.textContent = matchedRows;

            if (emptyRow) {
                if (matchedRows === 0 && card.classList.contains('is-expanded')) {
                    emptyRow.classList.remove('hidden');
                } else {
                    emptyRow.classList.add('hidden');
                }
            }

            const noActiveFilter = state.focus === 'all' && !state.search && !state.dept;
            const showCard = deptMatch && (
                matchedRows > 0 ||
                noActiveFilter ||
                (titleMatch && state.focus === 'all')
            );

            if (showCard) {
                card.style.display = '';
                visibleLowCount++;
                visibleAppCount += matchedRows;

                if (state.search && matchedRows > 0 && !titleMatch) {
                    expandCard(card);
                }
            } else {
                card.style.display = 'none';
            }
        });

        visibleLowEl.textContent = visibleLowCount;
        visibleAppEl.textContent = visibleAppCount;

        if (visibleLowCount === 0) emptyResult.classList.remove('hidden');
        else emptyResult.classList.add('hidden');

        updateActiveFilters();
        sortCards();
    }

    // ===== HIGHLIGHT SEARCH =====
    function highlightSearch(row, query) {
        const nameEl = row.querySelector('.applicant-name');
        const emailEl = row.querySelector('.applicant-email');
        if (!nameEl || !emailEl) return;

        const originalName = nameEl.textContent;
        const originalEmail = emailEl.textContent;

        if (!query) {
            nameEl.innerHTML = originalName;
            emailEl.innerHTML = originalEmail;
            return;
        }

        const regex = new RegExp('(' + query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
        nameEl.innerHTML = originalName.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
        emailEl.innerHTML = originalEmail.replace(regex, '<mark class="bg-yellow-200 text-gray-900 px-0.5 rounded">$1</mark>');
    }

    // ===== SORT CARDS =====
    function sortCards() {
        const list = cards().filter(c => c.style.display !== 'none');
        const mode = state.sort;

        list.sort((a, b) => {
            if (mode === 'pelamar-desc') return parseInt(b.dataset.total) - parseInt(a.dataset.total);
            if (mode === 'urgency') {
                const ua = parseInt(a.dataset.deadlineDays) - (parseInt(a.dataset.unreviewed) / 20);
                const ub = parseInt(b.dataset.deadlineDays) - (parseInt(b.dataset.unreviewed) / 20);
                return ua - ub;
            }
            if (mode === 'newest') return parseInt(a.dataset.daysSince) - parseInt(b.dataset.daysSince);
            if (mode === 'alpha') return a.dataset.title.localeCompare(b.dataset.title);
            return 0;
        });

        list.forEach(c => container.appendChild(c));
        container.appendChild(emptyResult);
    }

    // ===== ACTIVE FILTER PILLS =====
    function updateActiveFilters() {
        const pills = [];

        if (state.focus !== 'all') {
            const labels = {
                review: 'Needs Review',
                interview: 'Interviewing',
                decision: 'Needs Decision',
            };
            pills.push({ label: labels[state.focus], type: 'focus' });
        }

        if (state.search) pills.push({ label: 'Search: "' + state.search + '"', type: 'search' });
        if (state.dept) pills.push({ label: 'Dept: ' + state.dept, type: 'dept' });

        if (pills.length === 0) {
            activeFilterBar.classList.add('hidden');
            activeFilterPills.innerHTML = '';
            return;
        }

        activeFilterBar.classList.remove('hidden');
        activeFilterPills.innerHTML = pills.map(p =>
            '<span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-200 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full">'
            + p.label
            + '<button class="hover:text-red-600 transition-colors" data-remove="' + p.type + '">'
            + '<svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>'
            + '</button></span>'
        ).join('');

        activeFilterPills.querySelectorAll('button[data-remove]').forEach(btn => {
            btn.addEventListener('click', () => {
                const type = btn.dataset.remove;
                if (type === 'focus') { state.focus = 'all'; updateQuickFilterUI(); }
                if (type === 'search') { state.search = ''; document.getElementById('global-search').value = ''; }
                if (type === 'dept') { state.dept = ''; document.getElementById('filter-dept').value = ''; }
                apply();
            });
        });
    }

    // ===== QUICK FILTER =====
    function updateQuickFilterUI() {
        document.querySelectorAll('.quick-filter').forEach(btn => {
            const isActive = btn.dataset.focus === state.focus;
            if (isActive) {
                btn.classList.add('active-quick', 'bg-green-800', 'text-white');
                btn.classList.remove('bg-gray-50', 'border', 'border-gray-200', 'text-gray-600');
            } else {
                btn.classList.remove('active-quick', 'bg-green-800', 'text-white');
                btn.classList.add('bg-gray-50', 'border', 'border-gray-200', 'text-gray-600');
            }
        });
    }

    document.querySelectorAll('.quick-filter').forEach(btn => {
        btn.addEventListener('click', function () {
            state.focus = this.dataset.focus;
            updateQuickFilterUI();
            if (state.focus !== 'all') {
                cards().forEach(c => expandCard(c));
            }
            apply();
        });
    });

    // ===== SEARCH / DEPT / SORT =====
    document.getElementById('global-search').addEventListener('input', function () {
        state.search = this.value.toLowerCase().trim();
        apply();
    });

    document.getElementById('filter-dept').addEventListener('change', function () {
        state.dept = this.value;
        apply();
    });

    document.getElementById('sort-lowongan').addEventListener('change', function () {
        state.sort = this.value;
        apply();
    });

    document.getElementById('btn-clear-filters').addEventListener('click', () => {
        state.focus = 'all';
        state.search = '';
        state.dept = '';
        document.getElementById('global-search').value = '';
        document.getElementById('filter-dept').value = '';
        updateQuickFilterUI();
        apply();
    });

    // ===== COLLAPSIBLE & SEEN STATE =====
    function markVacancyAsSeen(card) {
        const vacancyId = card.dataset.lowonganId;
        const unreadDots = card.querySelectorAll('.bg-blue-500'); // Blue dot elements
        if (unreadDots.length === 0) return;

        fetch(`/hr/pelamar/lowongan/${vacancyId}/mark-seen`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                unreadDots.forEach(dot => {
                    dot.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    setTimeout(() => dot.remove(), 300);
                });
                card.querySelectorAll('.applicant-row').forEach(row => {
                    row.dataset.isSeen = 'true';
                });
            }
        })
        .catch(err => console.error('Failed to mark vacancy as seen:', err));
    }

    function removeNewBadge(card) {
        const badge = card.querySelector('.new-vacancy-badge');
        if (badge) {
            badge.remove();
        }
    }

    function expandCard(card) {
        card.classList.add('is-expanded');
        card.querySelector('.lowongan-body').classList.remove('hidden');
        card.querySelector('.lowongan-chevron').style.transform = 'rotate(90deg)';
        markVacancyAsSeen(card);
        removeNewBadge(card);
    }
    function collapseCard(card) {
        card.classList.remove('is-expanded');
        card.querySelector('.lowongan-body').classList.add('hidden');
        card.querySelector('.lowongan-chevron').style.transform = 'rotate(0deg)';
        removeNewBadge(card);
    }

    document.querySelectorAll('.lowongan-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const card = this.closest('.lowongan-card');
            if (card.classList.contains('is-expanded')) collapseCard(card);
            else expandCard(card);
        });

        const card = btn.closest('.lowongan-card');
        if (card.classList.contains('is-expanded')) {
            btn.querySelector('.lowongan-chevron').style.transform = 'rotate(90deg)';
        }
    });

    document.getElementById('btn-expand-all').addEventListener('click', () => {
        cards().forEach(c => expandCard(c));
    });
    document.getElementById('btn-collapse-all').addEventListener('click', () => {
        cards().forEach(c => collapseCard(c));
    });

    const statusWeights = {
        'terkirim': 1,
        'shortlisted': 2,
        'interview': 3,
        'rejected': 4,
        'accepted': 5,
        'withdrawn': 6
    };

    function sortAndGroup(card) {
        const tbody = card.querySelector('.applicant-tbody');
        if (!tbody) return;
        const rowsArray = Array.from(card.querySelectorAll('.applicant-row'));
        const sortSelect = card.querySelector('.sort-select');
        const mode = sortSelect ? sortSelect.value : 'recent';
        const emptyEl = card.querySelector('.applicant-empty');

        rowsArray.sort((a, b) => {
            const statusA = a.dataset.status;
            const statusB = b.dataset.status;
            const weightA = statusWeights[statusA] || 99;
            const weightB = statusWeights[statusB] || 99;

            if (weightA !== weightB) {
                return weightA - weightB;
            }

            // Same status: sort based on the chosen mode
            if (mode === 'score-desc') return parseInt(b.dataset.score) - parseInt(a.dataset.score);
            if (mode === 'score-asc') return parseInt(a.dataset.score) - parseInt(b.dataset.score);
            if (mode === 'name') return a.dataset.name.localeCompare(b.dataset.name);
            return parseInt(a.dataset.dateIdx) - parseInt(b.dataset.dateIdx);
        });

        rowsArray.forEach(r => tbody.appendChild(r));
        if (emptyEl) tbody.appendChild(emptyEl);
    }

    // ===== STATUS TABS (per card) =====
    document.querySelectorAll('.lowongan-card').forEach(card => {
        statusTabState.set(card, 'all');

        const tabs = card.querySelectorAll('.status-tab');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => {
                    t.classList.remove('active-tab', 'text-green-800', 'border-green-700');
                    t.classList.add('text-gray-500', 'border-transparent');
                });
                this.classList.add('active-tab', 'text-green-800', 'border-green-700');
                this.classList.remove('text-gray-500', 'border-transparent');

                statusTabState.set(card, this.dataset.status);
                removeNewBadge(card);
                apply();
            });
        });

        // SORT applicant rows
        const sortSelect = card.querySelector('.sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                sortAndGroup(card);
            });
            // Initial group & sort
            sortAndGroup(card);
        }
    });

    // ===== EXPORT EXCEL (With choice modal & SpreadsheetML worksheets) =====
    const btnExport = document.getElementById('btn-export');
    const exportModal = document.getElementById('export-modal');
    const btnCloseExportModal = document.getElementById('btn-close-export-modal');
    const btnCancelExport = document.getElementById('btn-cancel-export');
    const btnConfirmExport = document.getElementById('btn-confirm-export');
    const exportSingleSelect = document.getElementById('export-single-select');
    const radioScopeAll = document.querySelector('input[name="export-scope"][value="all"]');
    const radioScopeSingle = document.querySelector('input[name="export-scope"][value="single"]');

    if (btnExport && exportModal) {
        // Open Modal
        btnExport.addEventListener('click', function (e) {
            e.preventDefault();

            // Populating select dropdown dynamically with visible vacancies
            if (exportSingleSelect) {
                exportSingleSelect.innerHTML = '';
                let visibleCount = 0;
                cards().forEach((card, idx) => {
                    if (card.style.display !== 'none') {
                        const jobTitle = card.querySelector('.lowongan-title')?.textContent?.trim() || card.dataset.title || '';
                        const opt = document.createElement('option');
                        opt.value = idx;
                        opt.textContent = jobTitle;
                        exportSingleSelect.appendChild(opt);
                        visibleCount++;
                    }
                });

                if (visibleCount === 0) {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'No active vacancies';
                    exportSingleSelect.appendChild(opt);
                }
            }

            // Reset modal states
            if (radioScopeAll) radioScopeAll.checked = true;
            if (exportSingleSelect) exportSingleSelect.disabled = true;

            exportModal.classList.remove('hidden');
        });

        // Close Modal helpers
        const closeModal = () => {
            exportModal.classList.add('hidden');
        };

        if (btnCloseExportModal) btnCloseExportModal.addEventListener('click', closeModal);
        if (btnCancelExport) btnCancelExport.addEventListener('click', closeModal);

        // Close on clicking backdrop
        exportModal.addEventListener('click', function (e) {
            if (e.target === exportModal) closeModal();
        });

        // Toggle dropdown disable state on radio change
        document.querySelectorAll('input[name="export-scope"]').forEach(radio => {
            radio.addEventListener('change', function () {
                if (exportSingleSelect) {
                    exportSingleSelect.disabled = (this.value === 'all');
                }
            });
        });

        // Confirm & Execute Export
        if (btnConfirmExport) {
            btnConfirmExport.addEventListener('click', function () {
                const spinnerSvg = '<svg class="w-4 h-4 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
                const checkSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';
                const downloadSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>';

                btnConfirmExport.innerHTML = spinnerSvg + ' Exporting...';
                btnConfirmExport.disabled = true;

                setTimeout(() => {
                    try {
                        const isAll = radioScopeAll ? radioScopeAll.checked : true;
                        const selectedIdx = exportSingleSelect ? exportSingleSelect.value : '';

                        const usedNames = new Set();
                        const getUniqueSheetName = (title) => {
                            let base = title.replace(/[\\/?*\[\]:]/g, '');
                            if (base.length > 25) base = base.slice(0, 25);
                            let name = base.trim() || 'Vacancy';
                            let counter = 1;
                            while (usedNames.has(name.toLowerCase())) {
                                let suffix = ` (${counter})`;
                                name = base.slice(0, 31 - suffix.length) + suffix;
                                counter++;
                            }
                            usedNames.add(name.toLowerCase());
                            return name;
                        };

                        const escapeXml = (unsafe) => {
                            return String(unsafe)
                                .replace(/&/g, '&amp;')
                                .replace(/</g, '&lt;')
                                .replace(/>/g, '&gt;')
                                .replace(/"/g, '&quot;')
                                .replace(/'/g, '&apos;');
                        };

                        const activeVacancies = [];
                        cards().forEach((card, idx) => {
                            if (card.style.display === 'none') return;

                            // If exporting single, skip other cards
                            if (!isAll && String(idx) !== String(selectedIdx)) return;

                            const jobTitle = card.querySelector('.lowongan-title')?.textContent?.trim() || card.dataset.title || '';
                            const department = card.dataset.department || '';
                            const total = card.dataset.total || '0';
                            const deadlineDays = card.dataset.deadlineDays || '';
                            const deadlineText = deadlineDays ? `${deadlineDays} days` : 'N/A';

                            const applicants = [];
                            card.querySelectorAll('.applicant-row').forEach(row => {
                                if (row.style.display === 'none') return;
                                applicants.push({
                                    name: row.dataset.name || row.querySelector('.applicant-name')?.textContent?.trim() || '',
                                    email: row.dataset.email || row.querySelector('.applicant-email')?.textContent?.trim() || '',
                                    date: row.cells && row.cells[1] ? row.cells[1].textContent.trim() : '',
                                    status: row.dataset.status || '',
                                    score: row.dataset.score || ''
                                });
                            });

                            activeVacancies.push({
                                title: jobTitle,
                                department: department,
                                total: total,
                                deadline: deadlineText,
                                applicants: applicants
                            });
                        });

                        if (activeVacancies.length === 0) {
                            throw new Error('No data found to export');
                        }

                        let xml = `<?xml version="1.0" encoding="utf-8"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>PT Ecogreen Oleochemicals</Author>
  <Created>${new Date().toISOString()}</Created>
 </DocumentProperties>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:CharSet="1" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="Header">
   <Font ss:FontName="Calibri" ss:Bold="1" ss:Color="#FFFFFF" ss:Size="11"/>
   <Interior ss:Color="#15803D" ss:Pattern="Solid"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#15803D"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#166534"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#166534"/>
   </Borders>
  </Style>
  <Style ss:ID="Title">
   <Font ss:FontName="Calibri" ss:Bold="1" ss:Size="16" ss:Color="#14532D"/>
   <Alignment ss:Vertical="Center"/>
  </Style>
  <Style ss:ID="SubTitle">
   <Font ss:FontName="Calibri" ss:Italic="1" ss:Size="10" ss:Color="#475569"/>
   <Alignment ss:Vertical="Center"/>
  </Style>
  <Style ss:ID="Data">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
  </Style>
  <Style ss:ID="DataPassed">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Interior ss:Color="#DCFCE7" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="DataFailed">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Interior ss:Color="#FEE2E2" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="Score">
   <Font ss:FontName="Calibri" ss:Bold="1"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
  </Style>
  <Style ss:ID="ScorePassed">
   <Font ss:FontName="Calibri" ss:Bold="1" ss:Color="#15803D"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Interior ss:Color="#DCFCE7" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="ScoreFailed">
   <Font ss:FontName="Calibri" ss:Bold="1" ss:Color="#B91C1C"/>
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Interior ss:Color="#FEE2E2" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="StatusText">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
  </Style>
  <Style ss:ID="StatusTextPassed">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Interior ss:Color="#DCFCE7" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="StatusTextFailed">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#E2E8F0"/>
   </Borders>
   <Interior ss:Color="#FEE2E2" ss:Pattern="Solid"/>
  </Style>
 </Styles>
`;

                        // --- OVERVIEW SHEET (Only for "All" export) ---
                        if (isAll) {
                            xml += ` <Worksheet ss:Name="Overview Summary">
  <Table>
   <Column ss:Width="220"/>
   <Column ss:Width="150"/>
   <Column ss:Width="120"/>
   <Column ss:Width="100"/>
   <Column ss:Width="100"/>
   <Row ss:Height="30">
    <Cell ss:MergeAcross="4" ss:StyleID="Title"><Data ss:Type="String">Recruitment Summary Overview</Data></Cell>
   </Row>
   <Row ss:Height="20">
    <Cell ss:MergeAcross="4" ss:StyleID="SubTitle"><Data ss:Type="String">Exported on: ${new Date().toLocaleString()} • Active Vacancies: ${activeVacancies.length}</Data></Cell>
   </Row>
   <Row ss:Height="10"/>
   <Row ss:Height="25">
    <Cell ss:StyleID="Header"><Data ss:Type="String">Vacancy Position</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Department</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Total Applicants</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Deadline</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Status</Data></Cell>
   </Row>
`;

                            activeVacancies.forEach(v => {
                                xml += `   <Row ss:Height="20">
    <Cell ss:StyleID="Data"><Data ss:Type="String">${escapeXml(v.title)}</Data></Cell>
    <Cell ss:StyleID="Data"><Data ss:Type="String">${escapeXml(v.department)}</Data></Cell>
    <Cell ss:StyleID="Score"><Data ss:Type="Number">${v.applicants.length}</Data></Cell>
    <Cell ss:StyleID="Data"><Data ss:Type="String">${escapeXml(v.deadline)}</Data></Cell>
    <Cell ss:StyleID="Data"><Data ss:Type="String">Active</Data></Cell>
   </Row>
`;
                            });

                            xml += `  </Table>
 </Worksheet>
`;
                        }

                        // --- INDIVIDUAL WORKSEETS ---
                        activeVacancies.forEach(v => {
                            const sheetName = getUniqueSheetName(v.title);
                            xml += ` <Worksheet ss:Name="${escapeXml(sheetName)}">
  <Table>
   <Column ss:Width="180"/>
   <Column ss:Width="200"/>
   <Column ss:Width="120"/>
   <Column ss:Width="120"/>
   <Column ss:Width="80"/>
   <Row ss:Height="30">
    <Cell ss:MergeAcross="4" ss:StyleID="Title"><Data ss:Type="String">${escapeXml(v.title)}</Data></Cell>
   </Row>
   <Row ss:Height="20">
    <Cell ss:MergeAcross="4" ss:StyleID="SubTitle"><Data ss:Type="String">Department: ${escapeXml(v.department)} • Total Filtered Applicants: ${v.applicants.length}</Data></Cell>
   </Row>
   <Row ss:Height="10"/>
   <Row ss:Height="25">
    <Cell ss:StyleID="Header"><Data ss:Type="String">Applicant Name</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Email</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Applied Date</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Status</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Match Score</Data></Cell>
   </Row>
`;

                            if (v.applicants.length === 0) {
                                xml += `   <Row ss:Height="25">
    <Cell ss:MergeAcross="4" ss:StyleID="Data"><Data ss:Type="String">No applicants found matching active filters.</Data></Cell>
   </Row>
`;
                            } else {
                                v.applicants.forEach(p => {
                                    const scoreVal = parseInt(p.score) || 0;
                                    const isPassed = scoreVal >= 70;
                                    const rowStyle = isPassed ? 'DataPassed' : 'DataFailed';
                                    const statusStyle = isPassed ? 'StatusTextPassed' : 'StatusTextFailed';
                                    const scoreStyle = isPassed ? 'ScorePassed' : 'ScoreFailed';
                                    xml += `   <Row ss:Height="20">
    <Cell ss:StyleID="${rowStyle}"><Data ss:Type="String">${escapeXml(p.name)}</Data></Cell>
    <Cell ss:StyleID="${rowStyle}"><Data ss:Type="String">${escapeXml(p.email)}</Data></Cell>
    <Cell ss:StyleID="${rowStyle}"><Data ss:Type="String">${escapeXml(p.date)}</Data></Cell>
    <Cell ss:StyleID="${statusStyle}"><Data ss:Type="String">${escapeXml(p.status.toUpperCase())}</Data></Cell>
    <Cell ss:StyleID="${scoreStyle}"><Data ss:Type="Number">${p.score}</Data></Cell>
   </Row>
`;
                                });
                            }

                            xml += `  </Table>
 </Worksheet>
`;
                        });

                        xml += `</Workbook>`;

                        const blob = new Blob([xml], { type: 'application/vnd.ms-excel;charset=utf-8;' });
                        const url = URL.createObjectURL(blob);

                        const filename = isAll
                            ? `applicant_report_all_${new Date().toISOString().slice(0, 10)}.xls`
                            : `applicant_report_${activeVacancies[0].title.toLowerCase().replace(/[^a-z0-9]/g, '_')}_${new Date().toISOString().slice(0, 10)}.xls`;

                        const link = document.createElement("a");
                        link.setAttribute("href", url);
                        link.setAttribute("download", filename);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        // Success feedback on main button
                        btnConfirmExport.innerHTML = checkSvg + ' Success';
                        btnConfirmExport.classList.add('text-green-700', 'border-green-300', 'bg-green-50');
                        setTimeout(() => {
                            btnConfirmExport.innerHTML = downloadSvg + ' Export Excel';
                            btnConfirmExport.classList.remove('text-green-700', 'border-green-300', 'bg-green-50');
                        }, 1500);

                        closeModal();
                    } catch (e) {
                        console.error(e);
                        alert('Failed to export data: ' + e.message);
                    } finally {
                        btnConfirmExport.innerHTML = 'Export Excel';
                        btnConfirmExport.disabled = false;
                    }
                }, 800);
            });
        }
    }

    // ===== ARCHIVE MODAL =====
    const archiveModal = document.getElementById('archive-confirm-modal');
    const btnCloseArchiveModal = document.getElementById('btn-close-archive-modal');
    const btnCancelArchive = document.getElementById('btn-cancel-archive');
    const btnConfirmArchive = document.getElementById('btn-confirm-archive');
    const archiveJobTitle = document.getElementById('archive-job-title');
    const warningActive = document.getElementById('archive-warning-active');
    const warningUndecided = document.getElementById('archive-warning-undecided');
    const undecidedCountText = document.getElementById('archive-undecided-count');
    const archiveInfoText = document.getElementById('archive-info-text');

    let currentArchiveVacancyId = null;

    if (archiveModal) {
        const closeArchiveModal = () => {
            archiveModal.classList.add('hidden');
            currentArchiveVacancyId = null;
        };

        if (btnCloseArchiveModal) btnCloseArchiveModal.addEventListener('click', closeArchiveModal);
        if (btnCancelArchive) btnCancelArchive.addEventListener('click', closeArchiveModal);
        archiveModal.addEventListener('click', (e) => {
            if (e.target === archiveModal) closeArchiveModal();
        });

        document.querySelectorAll('.btn-archive-vacancy').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation(); // prevent card toggle
                
                const vacancyId = this.dataset.vacancyId;
                const title = this.dataset.title;
                const status = this.dataset.status;
                const undecided = parseInt(this.dataset.undecided) || 0;

                currentArchiveVacancyId = vacancyId;
                if (archiveJobTitle) archiveJobTitle.textContent = title;

                // Reset states
                warningActive.classList.add('hidden');
                warningUndecided.classList.add('hidden');
                archiveInfoText.classList.remove('hidden');
                btnConfirmArchive.disabled = false;
                btnConfirmArchive.classList.remove('opacity-50', 'cursor-not-allowed');

                // Validation
                if (status === 'open') {
                    warningActive.classList.remove('hidden');
                    archiveInfoText.classList.add('hidden');
                    btnConfirmArchive.disabled = true;
                    btnConfirmArchive.classList.add('opacity-50', 'cursor-not-allowed');
                } else if (undecided > 0) {
                    if (undecidedCountText) undecidedCountText.textContent = undecided;
                    warningUndecided.classList.remove('hidden');
                    archiveInfoText.classList.add('hidden');
                    btnConfirmArchive.disabled = true;
                    btnConfirmArchive.classList.add('opacity-50', 'cursor-not-allowed');
                }

                archiveModal.classList.remove('hidden');
            });
        });

        if (btnConfirmArchive) {
            btnConfirmArchive.addEventListener('click', function () {
                if (!currentArchiveVacancyId) return;

                btnConfirmArchive.disabled = true;
                btnConfirmArchive.textContent = 'Archiving...';

                fetch(`/hr/pelamar/lowongan/${currentArchiveVacancyId}/archive`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const card = document.querySelector(`.lowongan-card[data-lowongan-id="${currentArchiveVacancyId}"]`);
                        if (card) {
                            card.classList.add('opacity-0', 'transition-all', 'duration-500');
                            card.style.height = '0px';
                            card.style.margin = '0px';
                            card.style.padding = '0px';
                            setTimeout(() => {
                                card.remove();
                                apply();
                            }, 500);
                        }
                        closeArchiveModal();
                    } else {
                        alert(data.message || 'Failed to archive vacancy.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred while archiving.');
                })
                .finally(() => {
                    btnConfirmArchive.disabled = false;
                    btnConfirmArchive.textContent = 'Archive Vacancy';
                });
            });
        }
    }

    // Parse URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const lowonganId = urlParams.get('lowongan');
    const searchQuery = urlParams.get('search');

    if (searchQuery) {
        state.search = searchQuery.toLowerCase().trim();
        const searchInput = document.getElementById('global-search');
        if (searchInput) searchInput.value = searchQuery;
    }

    if (lowonganId) {
        setTimeout(() => {
            const targetCard = document.querySelector(`.lowongan-card[data-lowongan-id="${lowonganId}"]`);
            if (targetCard) {
                // Pastikan semua kartu ditutup (minimize) terlebih dahulu
                cards().forEach(c => {
                    collapseCard(c);
                });

                // 1. Tarik layar (scroll) langsung ke kartu yang masih ter-minimize
                const yOffset = -140;
                const y = targetCard.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });

                // 2. Tunggu proses scroll selesai (sekitar 800ms)
                setTimeout(() => {
                    // 3. Beri kedipan penanda (highlight-pulse) sekali saja (0.8s)
                    targetCard.classList.add('highlight-pulse');

                    // 4. Setelah kedipan selesai (800ms), buka datanya (expandCard)
                    setTimeout(() => {
                        expandCard(targetCard);
                        targetCard.classList.remove('highlight-pulse');
                    }, 800);
                }, 800);
            }
        }, 100);
    }

    // Initial
    apply();
});