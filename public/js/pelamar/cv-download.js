/* cv-download.js — jsPDF programmatic PDF generator */
document.addEventListener('DOMContentLoaded', function () {

    const cards          = document.querySelectorAll('.template-card');
    const previewSection = document.getElementById('cv-preview-section');
    const previewName    = document.getElementById('preview-template-name');
    const btnDownload    = document.getElementById('btn-download');
    const btnText        = document.getElementById('btn-download-text');
    const hint           = document.getElementById('download-hint');
    let   activeTemplate = null;

    const tplNames = {
        modern:   'Modern Executive 2024',
        academic: 'Academic Specialist',
        creative: 'Creative Industrial'
    };

    btnDownload.disabled = true;

    cards.forEach(card => {
        const btn = card.querySelector('.select-btn');
        if (btn) btn.addEventListener('click', e => { e.stopPropagation(); pick(card); });
        card.addEventListener('click', function () { pick(this); });
    });

    function pick(card) {
        cards.forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        activeTemplate = card.dataset.template;
        previewName.textContent = tplNames[activeTemplate] || activeTemplate;
        document.querySelectorAll('.cv-preview-panel').forEach(p => p.classList.add('hidden'));
        const p = document.getElementById('tpl-' + activeTemplate);
        if (p) p.classList.remove('hidden');
        previewSection.classList.remove('hidden');
        previewSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        btnDownload.disabled = false;
        hint.textContent = 'Template: ' + (tplNames[activeTemplate] || activeTemplate);
    }

    btnDownload.addEventListener('click', function () {
        if (!activeTemplate || !window.cvData || !window.jspdf) return;
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        const d   = window.cvData;
        const fn  = `CV_${d.name.replace(/\s+/g,'_')}_${activeTemplate}.pdf`;

        if      (activeTemplate === 'modern')   buildModern(doc, d);
        else if (activeTemplate === 'academic') buildAcademic(doc, d);
        else if (activeTemplate === 'creative') buildCreative(doc, d);

        doc.save(fn);
    });

    /* ─── helpers ─── */
    function t(doc, s, x, y, o)  { doc.text(String(s ?? ''), x, y, o || {}); }
    function wr(doc, s, x, y, mw, lh) {
        const ln = doc.splitTextToSize(String(s ?? ''), mw);
        doc.text(ln, x, y);
        return y + ln.length * lh;
    }
    function sh(doc, lbl, x, y, w, rgb) {
        doc.setFont('helvetica','bold'); doc.setFontSize(7);
        doc.setTextColor(...rgb); t(doc, lbl, x, y);
        doc.setDrawColor(...rgb); doc.setLineWidth(0.25);
        doc.line(x, y+1, x+w, y+1);
        return y + 5;
    }

    /* ─── MODERN EXECUTIVE ─── */
    function buildModern(doc, d) {
        const SW=63, PW=210, PH=297, MX=SW+8, MW=PW-SW-16;
        doc.setFillColor(20,83,45);  doc.rect(0,0,SW,PH,'F');
        doc.setFillColor(22,101,52); doc.circle(SW/2,25,12,'F');
        doc.setTextColor(134,239,172); doc.setFont('helvetica','bold'); doc.setFontSize(13);
        t(doc, d.initials, SW/2, 29, {align:'center'});

        doc.setTextColor(255,255,255); doc.setFontSize(10);
        const nl = doc.splitTextToSize(d.name, SW-12);
        doc.text(nl, SW/2, 40, {align:'center'});
        let sy = 40 + nl.length*4 + 2;
        if (d.city) { doc.setTextColor(134,239,172); doc.setFont('helvetica','normal'); doc.setFontSize(7); t(doc,d.city,SW/2,sy,{align:'center'}); sy+=4; }
        doc.setDrawColor(22,101,52); doc.setLineWidth(0.3); doc.line(6,sy+2,SW-6,sy+2); sy+=7;

        // Contact
        doc.setTextColor(74,222,128); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'CONTACT',6,sy); sy+=4;
        doc.setTextColor(220,252,231); doc.setFont('helvetica','normal'); doc.setFontSize(6.5);
        sy = wr(doc,d.email,6,sy,SW-12,3.5);
        if (d.city)    sy = wr(doc, d.city+(d.province?', '+d.province:''),6,sy,SW-12,3.5);
        if (d.linkedin) sy = wr(doc, d.linkedin,6,sy,SW-12,3.5);
        sy += 4;

        // Skills
        const tsk = d.skills.filter(s=>s.cat!=='language');
        if (tsk.length) {
            doc.setTextColor(74,222,128); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'SKILLS',6,sy); sy+=4;
            tsk.slice(0,5).forEach(sk => {
                doc.setTextColor(220,252,231); doc.setFont('helvetica','normal'); doc.setFontSize(6.5); t(doc,sk.name,6,sy); sy+=2.5;
                const p = sk.lvl==='expert'?.9:sk.lvl==='intermediate'?.65:.4;
                doc.setFillColor(22,101,52); doc.rect(6,sy,SW-12,1.5,'F');
                doc.setFillColor(74,222,128); doc.rect(6,sy,(SW-12)*p,1.5,'F');
                sy+=4;
            }); sy+=2;
        }
        // Languages
        const lngs = d.skills.filter(s=>s.cat==='language');
        if (lngs.length) {
            doc.setTextColor(74,222,128); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'LANGUAGES',6,sy); sy+=4;
            lngs.forEach(l => { doc.setTextColor(220,252,231); doc.setFont('helvetica','normal'); doc.setFontSize(6.5); t(doc,`${l.name} — ${l.lvl}`,6,sy); sy+=4; });
        }

        // Main
        let my = 15;
        if (d.bio) { my = sh(doc,'PROFESSIONAL PROFILE',MX,my,MW,[22,101,52]); doc.setTextColor(75,85,99); doc.setFont('helvetica','normal'); doc.setFontSize(7.5); my = wr(doc,d.bio,MX,my,MW,3.5)+4; }
        if (d.works.length) {
            my = sh(doc,'WORK EXPERIENCE',MX,my,MW,[22,101,52]);
            d.works.forEach((w,i) => {
                doc.setDrawColor(i===0?134:209,i===0?239:213,i===0?172:219); doc.setLineWidth(0.5); doc.line(MX,my-1,MX,my+9);
                doc.setFont('helvetica','bold'); doc.setFontSize(8); doc.setTextColor(17,24,39); t(doc,w.pos,MX+3,my+2);
                doc.setFont('helvetica','normal'); doc.setFontSize(7); doc.setTextColor(107,114,128); t(doc,w.co,MX+3,my+6);
                doc.setFont('helvetica','bold'); doc.setFontSize(6.5); doc.setTextColor(i===0?21:107,i===0?128:114,i===0?61:128);
                t(doc,`${w.s}–${w.e}`,MX+MW,my+2,{align:'right'}); my+=9;
                if (w.desc) { doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(75,85,99); my = wr(doc,w.desc,MX+3,my,MW-5,3)+2; }
                my+=2;
            }); my+=2;
        }
        if (d.educs.length) {
            my = sh(doc,'EDUCATION',MX,my,MW,[22,101,52]);
            d.educs.forEach(e => {
                doc.setDrawColor(134,239,172); doc.setLineWidth(0.5); doc.line(MX,my-1,MX,my+9);
                doc.setFont('helvetica','bold'); doc.setFontSize(8); doc.setTextColor(17,24,39); t(doc,`${e.deg} — ${e.maj}`,MX+3,my+2);
                doc.setFont('helvetica','normal'); doc.setFontSize(7); doc.setTextColor(107,114,128);
                t(doc,`${e.inst} • ${e.s}–${e.e}${e.gpa?' • GPA '+e.gpa:''}`,MX+3,my+6); my+=12;
            }); my+=2;
        }
        if (d.orgs.length) {
            my = sh(doc,'ORGANIZATION',MX,my,MW,[22,101,52]);
            d.orgs.forEach(o => {
                doc.setDrawColor(209,213,219); doc.setLineWidth(0.5); doc.line(MX,my-1,MX,my+9);
                doc.setFont('helvetica','bold'); doc.setFontSize(8); doc.setTextColor(17,24,39); t(doc,o.pos,MX+3,my+2);
                doc.setFont('helvetica','normal'); doc.setFontSize(7); doc.setTextColor(107,114,128); t(doc,`${o.org} • ${o.s}–${o.e}`,MX+3,my+6); my+=12;
            });
        }
    }

    /* ─── ACADEMIC SPECIALIST ─── */
    function buildAcademic(doc, d) {
        const PW=210, M=15, CW=PW-M*2;
        let y=20;
        doc.setFont('times','bold'); doc.setFontSize(18); doc.setTextColor(17,24,39);
        t(doc,d.name.toUpperCase(),PW/2,y,{align:'center'}); y+=7;
        if (d.city) { doc.setFont('times','normal'); doc.setFontSize(9); doc.setTextColor(75,85,99); t(doc,d.city+(d.province?', '+d.province:''),PW/2,y,{align:'center'}); y+=5; }
        doc.setFont('times','normal'); doc.setFontSize(8); doc.setTextColor(156,163,175);
        t(doc,d.email+(d.linkedin?' • '+d.linkedin:''),PW/2,y,{align:'center'}); y+=4;
        doc.setDrawColor(17,24,39); doc.setLineWidth(0.5); doc.line(M,y,PW-M,y); y+=7;
        if (d.bio) { y = sh(doc,'RINGKASAN PROFESIONAL',M,y,CW,[31,41,55]); doc.setFont('times','normal'); doc.setFontSize(8); doc.setTextColor(75,85,99); y = wr(doc,d.bio,M,y,CW,4)+5; }

        const colW=(CW-8)/2, c1=M, c2=M+colW+8;
        let y1=y, y2=y;
        if (d.works.length) {
            y1 = sh(doc,'PENGALAMAN PROFESIONAL',c1,y1,colW,[31,41,55]);
            d.works.forEach(w => {
                doc.setFont('times','bold'); doc.setFontSize(8); doc.setTextColor(17,24,39); y1 = wr(doc,w.pos,c1,y1,colW,4);
                doc.setFont('times','italic'); doc.setFontSize(7.5); doc.setTextColor(107,114,128); y1 = wr(doc,`${w.co} — ${w.s} s.d. ${w.e}`,c1,y1,colW,3.5);
                if (w.desc) { doc.setFont('times','normal'); doc.setFontSize(7); doc.setTextColor(75,85,99); y1 = wr(doc,'– '+w.desc,c1,y1,colW,3)+1; }
                y1+=4;
            });
        }
        if (d.orgs.length) {
            y1+=2; y1 = sh(doc,'ORGANISASI',c1,y1,colW,[31,41,55]);
            d.orgs.forEach(o => {
                doc.setFont('times','bold'); doc.setFontSize(8); doc.setTextColor(17,24,39); t(doc,o.pos,c1,y1); y1+=4;
                doc.setFont('times','italic'); doc.setFontSize(7.5); doc.setTextColor(107,114,128); t(doc,`${o.org} — ${o.s} s.d. ${o.e}`,c1,y1); y1+=5;
            });
        }
        if (d.educs.length) {
            y2 = sh(doc,'PENDIDIKAN',c2,y2,colW,[31,41,55]);
            d.educs.forEach(e => {
                doc.setFont('times','bold'); doc.setFontSize(8); doc.setTextColor(17,24,39); y2 = wr(doc,`${e.deg} — ${e.maj}`,c2,y2,colW,4);
                doc.setFont('times','italic'); doc.setFontSize(7.5); doc.setTextColor(107,114,128); t(doc,`${e.inst} — ${e.s} s.d. ${e.e}`,c2,y2); y2+=3.5;
                if (e.gpa) { doc.setFont('times','normal'); doc.setFontSize(7); doc.setTextColor(156,163,175); t(doc,'GPA: '+e.gpa+' / 4.00',c2,y2); y2+=3; }
                y2+=4;
            });
        }
        const tsk = d.skills.filter(s=>s.cat!=='language');
        if (tsk.length) {
            y2+=2; y2 = sh(doc,'KOMPETENSI TEKNIS',c2,y2,colW,[31,41,55]);
            tsk.slice(0,6).forEach(s => { doc.setFont('times','normal'); doc.setFontSize(7.5); doc.setTextColor(75,85,99); t(doc,`• ${s.name}${s.lvl?' ('+s.lvl+')':''}`,c2,y2); y2+=4; });
        }
        const lngs = d.skills.filter(s=>s.cat==='language');
        if (lngs.length) {
            y2+=2; y2 = sh(doc,'BAHASA',c2,y2,colW,[31,41,55]);
            lngs.forEach(l => { doc.setFont('times','normal'); doc.setFontSize(7.5); doc.setTextColor(75,85,99); t(doc,`${l.name} — ${l.lvl}`,c2,y2); y2+=4; });
        }
    }

    /* ─── CREATIVE INDUSTRIAL ─── */
    function buildCreative(doc, d) {
        const PW=210, PH=297, BH=38, MX=7, MW=PW*0.7-MX*2, SX=PW*0.7;
        doc.setFillColor(30,41,59);  doc.rect(0,0,PW,BH,'F');
        doc.setFillColor(51,65,85);  doc.rect(8,8,22,22,'F');
        doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(13);
        t(doc,d.initials,19,22,{align:'center'});
        doc.setTextColor(255,255,255); doc.setFontSize(13); t(doc,d.name.toUpperCase(),36,16);
        if (d.works.length) { doc.setTextColor(251,191,36); doc.setFont('helvetica','normal'); doc.setFontSize(8); t(doc,d.works[0].pos.toUpperCase(),36,22); }
        doc.setTextColor(148,163,184); doc.setFontSize(7); t(doc,(d.city?d.city+' • ':'')+d.email,36,28);

        doc.setFillColor(15,23,42);  doc.rect(0,BH,PW,PH-BH,'F');
        doc.setFillColor(30,41,59);  doc.rect(SX,BH,PW-SX,PH-BH,'F');

        let my=BH+8;
        if (d.bio) { doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'— PROFILE',MX,my); my+=4; doc.setTextColor(203,213,225); doc.setFont('helvetica','normal'); doc.setFontSize(7.5); my=wr(doc,d.bio,MX,my,MW,3.5)+5; }
        if (d.works.length) {
            doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'— EXPERIENCE',MX,my); my+=5;
            d.works.forEach((w,i) => {
                doc.setDrawColor(i===0?251:71,i===0?191:85,i===0?36:105); doc.setLineWidth(0.5); doc.line(MX,my-1,MX,my+9);
                doc.setFont('helvetica','bold'); doc.setFontSize(8); doc.setTextColor(255,255,255); t(doc,w.pos,MX+4,my+2);
                doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(148,163,184); t(doc,w.co,MX+4,my+6);
                doc.setFont('helvetica','bold'); doc.setFontSize(6.5); doc.setTextColor(i===0?251:107,i===0?191:114,i===0?36:128);
                t(doc,`${w.s}–${w.e}`,SX-MX,my+2,{align:'right'}); my+=9;
                if (w.desc) { doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(203,213,225); my=wr(doc,'→ '+w.desc,MX+4,my,MW-6,3)+2; }
                my+=3;
            }); my+=2;
        }
        if (d.educs.length) {
            doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'— EDUCATION',MX,my); my+=5;
            d.educs.forEach(e => {
                doc.setFillColor(30,41,59); doc.rect(MX,my-2,MW,10,'F');
                doc.setFont('helvetica','bold'); doc.setFontSize(7.5); doc.setTextColor(255,255,255); t(doc,`${e.deg} ${e.maj} — ${e.inst}`,MX+3,my+2);
                doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(148,163,184); t(doc,`${e.s}–${e.e}${e.gpa?' • GPA '+e.gpa:''}`,MX+3,my+7); my+=13;
            });
        }

        let sy=BH+8;
        const tsk=d.skills.filter(s=>s.cat!=='language');
        if (tsk.length) {
            doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'KEAHLIAN',SX+5,sy); sy+=5;
            tsk.slice(0,5).forEach(sk => {
                const p=sk.lvl==='expert'?.92:sk.lvl==='intermediate'?.75:.5;
                doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(203,213,225); t(doc,sk.name,SX+5,sy);
                doc.setTextColor(251,191,36); t(doc,Math.round(p*100)+'%',PW-5,sy,{align:'right'}); sy+=3;
                doc.setFillColor(51,65,85); doc.rect(SX+5,sy,PW-SX-10,1.5,'F');
                doc.setFillColor(251,191,36); doc.rect(SX+5,sy,(PW-SX-10)*p,1.5,'F'); sy+=5;
            }); sy+=3;
        }
        const lngs=d.skills.filter(s=>s.cat==='language');
        if (lngs.length) {
            doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'BAHASA',SX+5,sy); sy+=5;
            lngs.forEach(l => { doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(203,213,225); t(doc,`${l.name} — ${l.lvl}`,SX+5,sy); sy+=4; });
        }
        if (d.orgs.length) {
            sy+=3; doc.setTextColor(251,191,36); doc.setFont('helvetica','bold'); doc.setFontSize(6.5); t(doc,'ORGANISASI',SX+5,sy); sy+=5;
            d.orgs.forEach(o => {
                doc.setFont('helvetica','bold'); doc.setFontSize(7); doc.setTextColor(255,255,255); sy=wr(doc,o.pos,SX+5,sy,PW-SX-10,3.5);
                doc.setFont('helvetica','normal'); doc.setFontSize(6.5); doc.setTextColor(148,163,184); t(doc,o.org,SX+5,sy); sy+=4;
            });
        }
    }
});
