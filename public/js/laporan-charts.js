// ============ DATA ============
const dbData = window.recruitmentReportsData || {};
const sourcedCount = dbData.sourcedCount !== undefined ? dbData.sourcedCount : 1284;
const applicantMoM = dbData.applicantMoM !== undefined ? dbData.applicantMoM : 12;
const offerAcceptanceRate = dbData.offerAcceptanceRate !== undefined ? dbData.offerAcceptanceRate : 94.2;
const qualifiedRatio = dbData.qualifiedRatio !== undefined ? dbData.qualifiedRatio : 42;

const monthlyData = dbData.monthlyData || {
  JAN: { total: 210, external: 147, referral: 63, hired: 6, screened: 88, interviewed: 21 },
  FEB: { total: 185, external: 130, referral: 55, hired: 5, screened: 78, interviewed: 18 },
  MAR: { total: 140, external: 84, referral: 56, hired: 4, screened: 59, interviewed: 14 },
  APR: { total: 310, external: 248, referral: 62, hired: 14, screened: 130, interviewed: 31 },
  MAY: { total: 245, external: 171, referral: 74, hired: 10, screened: 103, interviewed: 25 },
  JUN: { total: 280, external: 196, referral: 84, hired: 10, screened: 118, interviewed: 28 },
};

const funnelData = dbData.funnelData || {
  sourced: { count: 1284, pct: '100%', desc: 'Total pelamar yang masuk dari semua sumber rekrutmen.' },
  screened: { count: 540, pct: '42%', desc: 'Pelamar yang lolos seleksi administrasi awal (CV screening).' },
  interviewed: { count: 124, pct: '9.6%', desc: 'Pelamar yang dipanggil dan mengikuti sesi wawancara.' },
  offermade: { count: 52, pct: '4%', desc: 'Pelamar yang menerima surat penawaran kerja (offer letter).' },
  hired: { count: 49, pct: '3.8%', desc: 'Pelamar yang resmi bergabung sebagai karyawan.' },
};

const sourceData = dbData.sourceData || {
  linkedin: { label: 'LinkedIn', count: 706, pct: '55%', color: '#15803d', detail: 'Mayoritas pelamar senior dan profesional berasal dari LinkedIn. Konversi rata-rata 8%.' },
  jobportal: { label: 'Job Portal', count: 321, pct: '25%', color: '#166534', detail: 'Dari platform Jobstreet, Indeed, dan Kalibrr. Konversi rata-rata 5%.' },
  website: { label: 'Website', count: 257, pct: '20%', color: '#bfe3d0', detail: 'Pelamar langsung dari portal karir ecogreen.co.id. Konversi rata-rata 6%.' },
};

const deptData = dbData.deptData || {
  manufacturing: { name: 'Manufacturing', roles: 12, days: 22, status: 'OPTIMAL', color: '#15803d', bg: '#d1f4e0', detail: 'Departemen dengan performa rekrutmen terbaik. Proses seleksi efisien dan tepat waktu.' },
  engineering: { name: 'Engineering', roles: 8, days: 45, status: 'CRITICAL', color: '#9b1c1c', bg: '#fce8e8', detail: 'Kekurangan kandidat yang memenuhi kualifikasi teknis. Perlu strategi sourcing yang lebih aktif.' },
  supplychain: { name: 'Supply Chain', roles: 15, days: 14, status: 'HIGH', color: '#15803d', bg: '#d1f4e0', detail: 'Waktu rekrutmen sangat cepat. Proses onboarding perlu dioptimalkan agar kualitas terjaga.' },
  rdlabor: { name: 'R&D Labor', roles: 4, days: 31, status: 'AVERAGE', color: '#374151', bg: '#f3f4f6', detail: 'Performa standar. Rekrutmen spesialis R&D memerlukan evaluasi kompetensi yang lebih mendalam.' },
};

// ============ MODAL ============
function createModal() {
  const el = document.createElement('div');
  el.id = 'detail-modal';
  el.className = 'fixed inset-0 z-[200] flex items-center justify-center p-4';
  el.style.display = 'none';
  el.innerHTML = `
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="modal-backdrop"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto z-10 p-0">
      <div id="modal-header" class="rounded-t-2xl p-6 pb-4">
        <div class="flex justify-between items-start">
          <div>
            <div id="modal-tag" class="text-xs font-bold uppercase tracking-widest mb-2 opacity-80"></div>
            <h2 id="modal-title" class="text-2xl font-black text-white"></h2>
          </div>
          <button id="modal-close" class="text-white/70 hover:text-white ml-4 mt-1 shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
      </div>
      <div id="modal-body" class="p-6 pt-4"></div>
    </div>`;
  document.body.appendChild(el);
  document.getElementById('modal-close').onclick = closeModal;
  document.getElementById('modal-backdrop').onclick = closeModal;
  return el;
}

function openModal(bgColor, tag, title, bodyHTML) {
  let modal = document.getElementById('detail-modal');
  if (!modal) modal = createModal();
  document.getElementById('modal-header').style.background = bgColor;
  document.getElementById('modal-tag').textContent = tag;
  document.getElementById('modal-title').textContent = title;
  document.getElementById('modal-body').innerHTML = bodyHTML;
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  const modal = document.getElementById('detail-modal');
  if (modal) modal.style.display = 'none';
  document.body.style.overflow = '';
}

function statCard(label, value, note) {
  return `<div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-100">
    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">${label}</div>
    <div class="text-2xl font-black text-gray-900">${value}</div>
    ${note ? `<div class="text-xs text-gray-500 mt-1">${note}</div>` : ''}
  </div>`;
}

// ============ BAR CHART CLICK ============
function initBars() {
  document.querySelectorAll('[data-month]').forEach(bar => {
    bar.style.cursor = 'pointer';
    bar.addEventListener('click', function() {
      const m = this.dataset.month;
      const d = monthlyData[m];
      const convRate = d.total > 0 ? ((d.hired / d.total) * 100).toFixed(1) : '0.0';
      openModal(
        'linear-gradient(135deg, #15803d, #166534)',
        'Monthly Breakdown',
        `${m} 2026 — ${d.total} Pelamar`,
        `<p class="text-gray-500 text-sm mb-6">Detail lengkap aktivitas rekrutmen pada bulan ${m} 2026.</p>
        <div class="grid grid-cols-2 gap-3 mb-6">
          ${statCard('Total Masuk', d.total.toLocaleString())}
          ${statCard('External', d.external.toLocaleString(), d.total > 0 ? `${Math.round(d.external/d.total*100)}% dari total` : '0%')}
          ${statCard('Referral', d.referral.toLocaleString(), d.total > 0 ? `${Math.round(d.referral/d.total*100)}% dari total` : '0%')}
          ${statCard('Di-Screening', d.screened.toLocaleString(), d.total > 0 ? `${Math.round(d.screened/d.total*100)}% lolos` : '0%')}
          ${statCard('Diwawancara', d.interviewed.toLocaleString(), d.total > 0 ? `${Math.round(d.interviewed/d.total*100)}% dari masuk` : '0%')}
          ${statCard('Diterima', d.hired.toLocaleString(), `Konversi ${convRate}%`)}
        </div>
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
          <div class="text-xs font-bold text-green-800 uppercase tracking-wider mb-1">Catatan Bulan Ini</div>
          <p class="text-sm text-green-900">Conversion rate ${convRate}% — ${d.hired >= 10 ? 'performa rekrutmen di atas rata-rata periode ini.' : 'rekrutmen berjalan stabil sesuai target.'}</p>
        </div>`
      );
    });
    bar.addEventListener('mouseenter', function() { this.style.opacity = '0.85'; });
    bar.addEventListener('mouseleave', function() { this.style.opacity = '1'; });
  });
}

// ============ FUNNEL CLICK ============
function initFunnel() {
  document.querySelectorAll('[data-funnel]').forEach(el => {
    el.style.cursor = 'pointer';
    el.addEventListener('click', function() {
      const key = this.dataset.funnel;
      const d = funnelData[key];
      const label = this.querySelector('[data-funnel-label]')?.textContent || key;
      const dropoff = key !== 'sourced' ? ` (${d.pct} dari total sourced)` : '';
      openModal(
        'linear-gradient(135deg, #15803d, #166534)',
        'Hiring Funnel Detail',
        label,
        `<p class="text-gray-500 text-sm mb-6">${d.desc}</p>
        <div class="grid grid-cols-2 gap-3 mb-6">
          ${statCard('Jumlah', d.count.toLocaleString())}
          ${statCard('Persentase', d.pct, 'dari total sourced')}
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
          <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Posisi di Funnel</div>
          <div class="text-sm text-gray-700">${d.count.toLocaleString()} kandidat${dropoff} berhasil mencapai tahap <strong>${label}</strong>.</div>
        </div>`
      );
    });
    el.addEventListener('mouseenter', function() { this.style.opacity = '0.85'; });
    el.addEventListener('mouseleave', function() { this.style.opacity = '1'; });
  });
}

// ============ SOURCE CLICK ============
function initSources() {
  document.querySelectorAll('[data-source]').forEach(el => {
    el.style.cursor = 'pointer';
    el.addEventListener('click', function() {
      const key = this.dataset.source;
      const d = sourceData[key];
      openModal(
        `linear-gradient(135deg, ${d.color}, #166534)`,
        'Applicant Source Detail',
        d.label,
        `<p class="text-gray-500 text-sm mb-6">${d.detail}</p>
        <div class="grid grid-cols-2 gap-3 mb-6">
          ${statCard('Total Kandidat', d.count.toLocaleString())}
          ${statCard('Kontribusi', d.pct, 'dari total 1,284')}
        </div>
        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
          <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rekomendasi</div>
          <p class="text-sm text-gray-700">${d.pct === '55%' ? 'Terus tingkatkan anggaran iklan LinkedIn untuk posisi senior.' : d.pct === '25%' ? 'Eksplorasi portal kerja lokal untuk memperluas jangkauan.' : 'Optimalkan SEO halaman karir dan CTA di website utama.'}</p>
        </div>`
      );
    });
    el.addEventListener('mouseenter', function() { this.querySelector('.source-icon')?.classList.add('scale-110'); });
    el.addEventListener('mouseleave', function() { this.querySelector('.source-icon')?.classList.remove('scale-110'); });
  });
}

// ============ DEPT CLICK ============
function initDepts() {
  document.querySelectorAll('[data-dept]').forEach(el => {
    el.style.cursor = 'pointer';
    el.addEventListener('click', function() {
      const key = this.dataset.dept;
      const d = deptData[key];
      openModal(
        `linear-gradient(135deg, ${d.color === '#9b1c1c' ? '#9b1c1c, #7f1d1d' : '#15803d, #166534'})`,
        'Departmental Efficiency',
        d.name,
        `<p class="text-gray-500 text-sm mb-6">${d.detail}</p>
        <div class="grid grid-cols-3 gap-3 mb-6">
          ${statCard('Open Roles', d.roles)}
          ${statCard('Avg. Days', d.days, 'hari per rekrutmen')}
          ${statCard('Status', `<span style="color:${d.color}">${d.status}</span>`)}
        </div>
        <div style="background:${d.bg};border:1px solid ${d.color}22" class="rounded-xl p-4">
          <div class="text-xs font-bold uppercase tracking-wider mb-2" style="color:${d.color}">Saran Tindakan</div>
          <p class="text-sm" style="color:${d.color}">${d.status === 'CRITICAL' ? 'Prioritaskan sourcing aktif, posting di platform spesialis industri, dan pertimbangkan referral bonus program.' : d.status === 'OPTIMAL' ? 'Pertahankan proses rekrutmen saat ini. Jadikan standar untuk departemen lain.' : d.status === 'HIGH' ? 'Proses rekrutmen berjalan baik. Perhatikan kualitas kandidat akhir agar tidak terburu-buru.' : 'Monitor perkembangan setiap bulan dan evaluasi kualifikasi posisi yang dibuka.'}</p>
        </div>`
      );
    });
    el.addEventListener('mouseenter', function() { this.style.background = '#f9fafb'; });
    el.addEventListener('mouseleave', function() { this.style.background = ''; });
  });
}

// ============ EXPORT PDF ============
function initExport() {
  const btn = document.getElementById('btn-export');
  if (!btn) return;

  btn.addEventListener('click', async function() {
    if (!window.jspdf) { alert('Library PDF sedang dimuat, coba lagi sebentar.'); return; }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });

    const green = [15, 60, 32];
    const lightGreen = [209, 244, 224];
    const gray = [107, 114, 128];
    const darkGray = [55, 65, 81];
    const pageW = doc.internal.pageSize.getWidth();
    const now = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    // ---- HEADER BAND ----
    doc.setFillColor(...green);
    doc.rect(0, 0, pageW, 32, 'F');

    doc.setTextColor(255, 255, 255);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(18);
    doc.text('Recruitment Analytics Report', 14, 14);

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9);
    doc.setTextColor(180, 220, 195);
    doc.text(`Reporting Period: January 1, 2026 – June 30, 2026  |  Diekspor: ${now}  |  PT Ecogreen Oleochemicals`, 14, 22);
    doc.text('Dokumen Rahasia — Hanya untuk Internal HR', 14, 28);

    let y = 40;

    // ---- KPI SECTION ----
    doc.setTextColor(...green);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.text('KEY PERFORMANCE INDICATORS', 14, y);
    doc.setDrawColor(...green);
    doc.setLineWidth(0.5);
    doc.line(14, y + 2, pageW - 14, y + 2);
    y += 8;

    const kpis = [
      { label: 'Total Applicants', value: sourcedCount.toLocaleString(), note: `${applicantMoM >= 0 ? '↑ +' : '↓ '}${applicantMoM}% vs bulan lalu` },
      { label: 'Offer Acceptance', value: `${offerAcceptanceRate.toFixed(1)}%`, note: '— Stable performance' },
      { label: 'Qualified Ratio', value: `${qualifiedRatio}%`, note: '↑ Profile quality ratio' },
    ];
    const kpiW = (pageW - 28 - 6) / 3;
    kpis.forEach((k, i) => {
      const x = 14 + i * (kpiW + 3);
      doc.setFillColor(248, 250, 252);
      doc.roundedRect(x, y, kpiW, 22, 2, 2, 'F');
      doc.setDrawColor(209, 244, 224);
      doc.setLineWidth(0.8);
      doc.line(x, y + 22, x + kpiW, y + 22);

      doc.setTextColor(...gray);
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(6.5);
      doc.text(k.label.toUpperCase(), x + 3, y + 5);

      doc.setTextColor(...green);
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(14);
      doc.text(k.value, x + 3, y + 14);

      doc.setTextColor(...gray);
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(7);
      doc.text(k.note, x + 3, y + 20);
    });
    y += 30;

    // ---- MONTHLY TRENDS TABLE ----
    doc.setTextColor(...green);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.text('MONTHLY APPLICATION TRENDS', 14, y);
    doc.setDrawColor(...green);
    doc.line(14, y + 2, pageW - 14, y + 2);
    y += 6;

    const totalApplicants = Object.values(monthlyData).reduce((s, d) => s + d.total, 0);
    const totalHired = Object.values(monthlyData).reduce((s, d) => s + d.hired, 0);
    const totalInterviewed = Object.values(monthlyData).reduce((s, d) => s + d.interviewed, 0);
    const totalScreened = Object.values(monthlyData).reduce((s, d) => s + d.screened, 0);
    const totalExternal = Object.values(monthlyData).reduce((s, d) => s + d.external, 0);
    const totalReferral = Object.values(monthlyData).reduce((s, d) => s + d.referral, 0);

    const monthRows = Object.entries(monthlyData).map(([m, d]) => [
      m, d.total, d.external, d.referral, d.screened, d.interviewed, d.hired,
      d.total > 0 ? `${((d.hired / d.total) * 100).toFixed(1)}%` : '0.0%'
    ]);
    monthRows.push(['TOTAL', totalApplicants, totalExternal, totalReferral, totalScreened, totalInterviewed, totalHired,
      totalApplicants > 0 ? `${((totalHired / totalApplicants) * 100).toFixed(1)}%` : '0.0%']);

    doc.autoTable({
      startY: y,
      head: [['Bulan', 'Total', 'External', 'Referral', 'Screened', 'Interview', 'Hired', 'Konversi']],
      body: monthRows,
      styles: { fontSize: 8, cellPadding: 3, textColor: darkGray },
      headStyles: { fillColor: green, textColor: [255, 255, 255], fontStyle: 'bold', fontSize: 7.5 },
      didParseCell: (data) => {
        if (data.row.index === monthRows.length - 1) {
          data.cell.styles.fillColor = [240, 253, 244];
          data.cell.styles.fontStyle = 'bold';
          data.cell.styles.textColor = green;
        }
        if (data.column.index === 6 && data.section === 'body' && data.row.index < monthRows.length - 1) {
          data.cell.styles.textColor = green;
          data.cell.styles.fontStyle = 'bold';
        }
      },
      alternateRowStyles: { fillColor: [249, 250, 251] },
      margin: { left: 14, right: 14 },
    });
    y = doc.lastAutoTable.finalY + 10;

    // ---- HIRING FUNNEL ----
    if (y > 200) { doc.addPage(); y = 20; }
    doc.setTextColor(...green);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.text('HIRING FUNNEL', 14, y);
    doc.setDrawColor(...green);
    doc.line(14, y + 2, pageW - 14, y + 2);
    y += 8;

    const funnel = [
      { label: 'Sourced', count: funnelData.sourced.count, pct: 1.0, color: [15, 60, 32] },
      { label: 'Screened', count: funnelData.screened.count, pct: funnelData.sourced.count > 0 ? (funnelData.screened.count / funnelData.sourced.count) : 0.0, color: [27, 94, 50] },
      { label: 'Interviewed', count: funnelData.interviewed.count, pct: funnelData.sourced.count > 0 ? (funnelData.interviewed.count / funnelData.sourced.count) : 0.0, color: [91, 156, 116] },
      { label: 'Offer Made', count: funnelData.offermade.count, pct: funnelData.sourced.count > 0 ? (funnelData.offermade.count / funnelData.sourced.count) : 0.0, color: [140, 190, 159] },
      { label: 'Hired', count: funnelData.hired.count, pct: funnelData.sourced.count > 0 ? (funnelData.hired.count / funnelData.sourced.count) : 0.0, color: [74, 222, 128] },
    ];
    const maxBarW = pageW - 60;
    funnel.forEach(f => {
      const bw = maxBarW * f.pct;
      doc.setFillColor(...f.color);
      doc.rect(14, y, bw, 8, 'F');
      doc.setTextColor(255, 255, 255);
      doc.setFont('helvetica', 'bold');
      doc.setFontSize(8);
      if (bw > 30) doc.text(`${f.label} (${f.count.toLocaleString()})`, 17, y + 5.5);
      doc.setTextColor(...darkGray);
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(8);
      doc.text(`${Math.round(f.pct * 100)}%`, 14 + bw + 3, y + 5.5);
      y += 11;
    });
    y += 4;

    // ---- SIDE BY SIDE: SOURCES + DEPT ----
    if (y > 200) { doc.addPage(); y = 20; }
    const halfW = (pageW - 28 - 6) / 2;

    doc.setTextColor(...green);
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.text('APPLICANT SOURCES', 14, y);
    doc.setDrawColor(...green);
    doc.line(14, y + 2, 14 + halfW, y + 2);
    doc.text('DEPARTMENTAL EFFICIENCY', 14 + halfW + 6, y);
    doc.line(14 + halfW + 6, y + 2, pageW - 14, y + 2);
    y += 6;

    doc.autoTable({
      startY: y,
      head: [['Sumber', 'Kandidat', '%']],
      body: [
        [sourceData.linkedin.label, sourceData.linkedin.count.toString(), sourceData.linkedin.pct],
        [sourceData.jobportal.label, sourceData.jobportal.count.toString(), sourceData.jobportal.pct],
        [sourceData.website.label, sourceData.website.count.toString(), sourceData.website.pct]
      ],
      styles: { fontSize: 8, cellPadding: 3, textColor: darkGray },
      headStyles: { fillColor: green, textColor: [255, 255, 255], fontStyle: 'bold', fontSize: 7.5 },
      alternateRowStyles: { fillColor: [249, 250, 251] },
      margin: { left: 14, right: 14 + halfW + 6 },
      tableWidth: halfW,
    });

    const deptStatusColors = { OPTIMAL: [15,60,32], CRITICAL: [155,28,28], HIGH: [15,60,32], AVERAGE: [107,114,128] };
    doc.autoTable({
      startY: y,
      head: [['Departemen', 'Roles', 'Avg. Days', 'Status']],
      body: Object.values(deptData).map(d => [
        d.name, d.roles.toString(), d.days.toString(), d.status
      ]),
      styles: { fontSize: 8, cellPadding: 3, textColor: darkGray },
      headStyles: { fillColor: green, textColor: [255, 255, 255], fontStyle: 'bold', fontSize: 7.5 },
      alternateRowStyles: { fillColor: [249, 250, 251] },
      didParseCell: (data) => {
        if (data.column.index === 3 && data.section === 'body') {
          data.cell.styles.textColor = deptStatusColors[data.cell.raw] || darkGray;
          data.cell.styles.fontStyle = 'bold';
        }
      },
      margin: { left: 14 + halfW + 6, right: 14 },
      tableWidth: halfW,
    });

    // ---- FOOTER ON ALL PAGES ----
    const totalPages = doc.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
      doc.setPage(i);
      const fY = doc.internal.pageSize.getHeight() - 8;
      doc.setFillColor(...green);
      doc.rect(0, fY - 2, pageW, 12, 'F');
      doc.setTextColor(180, 220, 195);
      doc.setFont('helvetica', 'normal');
      doc.setFontSize(7);
      doc.text('PT Ecogreen Oleochemicals — Sistem Rekrutmen Internal | Dokumen Rahasia', 14, fY + 3);
      doc.text(`Halaman ${i} dari ${totalPages}`, pageW - 14, fY + 3, { align: 'right' });
    }

    doc.save(`Recruitment_Analytics_Report_${now.replace(/\s/g,'_')}.pdf`);
  });
}

// ============ INIT ============
document.addEventListener('DOMContentLoaded', function() {
  initBars();
  initFunnel();
  initSources();
  initDepts();
  initExport();
});


