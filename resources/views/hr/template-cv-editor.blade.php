<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $template ? 'Edit: '.$template->name : 'Template Editor' }}</title>
@vite(['resources/css/app.css','resources/js/app.js'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
<style>
*{box-sizing:border-box}body{margin:0;font-family:'Segoe UI',sans-serif;background:#f1f5f9;overflow:hidden}
#bar{height:52px;background:#0f3c20;display:flex;align-items:center;padding:0 16px;gap:8px;position:fixed;top:0;left:0;right:0;z-index:100}
#ribbon{height:40px;background:#fff;border-bottom:1px solid #e5e7eb;position:fixed;top:52px;left:0;right:0;z-index:99;display:flex;align-items:center;padding:0 8px;gap:2px;overflow-x:auto}
#sb{width:260px;background:#fff;border-right:1px solid #e5e7eb;position:fixed;top:92px;left:0;bottom:0;overflow-y:auto;padding:12px}
#canvas{position:fixed;top:92px;left:260px;right:0;bottom:0;overflow-y:auto;background:#cbd5e1;display:flex;flex-direction:column;align-items:center;padding:24px}
.page{width:595px;background:#fff;height:842px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.15);margin-bottom:24px;position:relative}
.blk{position:relative;border:2px solid transparent}
.blk:hover{border-color:#86efac;cursor:default}
.blk.sel{border-color:#0f3c20;border-style:dashed}
.bh{position:absolute;top:4px;right:4px;display:none;gap:4px;z-index:5}
.blk:hover .bh,.blk.sel .bh{display:flex}
.hb{background:#0f3c20;color:#fff;border:none;border-radius:4px;padding:2px 6px;font-size:10px;cursor:pointer;font-weight:700}
.ab{display:flex;align-items:center;gap:8px;width:100%;padding:8px 10px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;cursor:pointer;font-size:12px;font-weight:600;color:#374151;margin-bottom:5px}
.ab:hover{background:#f0fdf4;border-color:#0f3c20;color:#0f3c20}
.rb{background:none;border:none;color:#374151;cursor:pointer;padding:4px 6px;border-radius:5px;font-size:12px;font-weight:700;display:flex;align-items:center}
.rb:hover,.rb.on{background:#dcfce7;color:#0f3c20}
.rs{width:1px;height:20px;background:#e5e7eb;margin:0 3px}
.rs2{background:#f9fafb;border:1px solid #e5e7eb;border-radius:5px;padding:3px 5px;font-size:11px;font-weight:600;cursor:pointer;outline:none;height:28px}
[contenteditable]{outline:none}[contenteditable]:focus{background:#fffbeb8a}
.tb{background:rgba(255,255,255,.15);color:#fff;border:none;border-radius:6px;padding:6px 12px;font-size:12px;font-weight:600;cursor:pointer}
.tb:disabled{opacity:.4;cursor:not-allowed}
</style>
</head>
<body>
<div id="bar">
  <a href="/hr/template-cv" style="color:#86efac;font-size:12px;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:4px">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali
  </a>
  <div style="flex:1"></div>
  <div contenteditable="true" id="tname" style="color:#fff;font-weight:700;font-size:14px;outline:none;min-width:120px;text-align:center">Template Baru</div>
  <div style="flex:1"></div>
  <label class="tb" style="display:flex;align-items:center;gap:5px;cursor:pointer">
    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>Import
    <input type="file" id="fimport" accept=".docx,.html" style="display:none" onchange="doImport(this)">
  </label>
  <button id="bundo" class="tb" disabled onclick="undo()" title="Ctrl+Z">&#8617; Undo</button>
  <button id="bredo" class="tb" disabled onclick="redo()" title="Ctrl+Y">&#8618; Redo</button>
  <button class="tb" onclick="saveDraft()">Save</button>
  <button class="tb" onclick="doPreview()">Preview</button>
  <button onclick="doPublish()" style="background:#4ade80;color:#0f3c20;border:none;border-radius:6px;padding:6px 14px;font-size:12px;font-weight:700;cursor:pointer">Publish</button>
</div>
<div id="ribbon">
  <select class="rs2" onchange="fmt('formatBlock',this.value)" style="width:96px"><option value="p">Paragraf</option><option value="h1">Heading 1</option><option value="h2">Heading 2</option><option value="h3">Heading 3</option></select>
  <select class="rs2" onchange="fmtSize(this.value)" style="width:52px;margin-left:4px"><option value="10">10</option><option value="11">11</option><option value="12" selected>12</option><option value="13">13</option><option value="14">14</option><option value="16">16</option><option value="18">18</option><option value="20">20</option><option value="24">24</option><option value="28">28</option><option value="32">32</option></select>
  <div class="rs"></div>
  <button class="rb" id="rb-b" onclick="fmt('bold')" title="Ctrl+B"><b>B</b></button>
  <button class="rb" id="rb-i" onclick="fmt('italic')" title="Ctrl+I"><i>I</i></button>
  <button class="rb" id="rb-u" onclick="fmt('underline')" title="Ctrl+U"><u>U</u></button>
  <button class="rb" id="rb-s" onclick="fmt('strikeThrough')"><s>S</s></button>
  <div class="rs"></div>
  <button class="rb" onclick="fmt('justifyLeft')" title="Kiri"><svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5h18v2H3zm0 4h12v2H3zm0 4h18v2H3zm0 4h12v2H3z"/></svg></button>
  <button class="rb" onclick="fmt('justifyCenter')" title="Tengah"><svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5h18v2H3zm3 4h12v2H6zm-3 4h18v2H3zm3 4h12v2H6z"/></svg></button>
  <button class="rb" onclick="fmt('justifyRight')" title="Kanan"><svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5h18v2H3zm6 4h12v2H9zm-6 4h18v2H3zm6 4h12v2H9z"/></svg></button>
  <div class="rs"></div>
  <button class="rb" onclick="fmt('insertUnorderedList')"><svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6a1 1 0 110-2 1 1 0 010 2zm3-1h13v2H7zm-3 5a1 1 0 110-2 1 1 0 010 2zm3-1h13v2H7zm-3 5a1 1 0 110-2 1 1 0 010 2zm3-1h13v2H7z"/></svg></button>
  <button class="rb" onclick="fmt('insertOrderedList')"><svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M3 4h2v4H4V5H3zm1 9h1.5v.5H4v1h1.5V15H3v1h3v-4H3zm0 5H3v1h2.5v.5H3v1h3v-4H3v1h2v.5zM7 5v2h13V5zm0 6v2h13v-2zm0 6v2h13v-2z"/></svg></button>
  <div class="rs"></div>
  <label class="rb" title="Warna Teks" style="position:relative;gap:2px;flex-direction:column">
    <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24"><path d="M12.09 2.91C9.5 2.91 7.06 4.05 5.3 5.9L2 22l16.1-3.3c1.85-1.76 3-4.2 3-6.79 0-4.97-4.03-9-9.01-9z"/></svg>
    <span id="cp" style="width:14px;height:3px;background:#111;border-radius:1px"></span>
    <input type="color" value="#111111" oninput="fmtColor(this.value)" style="position:absolute;opacity:0;inset:0;cursor:pointer">
  </label>
  <div class="rs"></div>
  <button class="rb" onclick="fmt('removeFormat')" style="font-size:10px;color:#6b7280">&#x2715; Clear</button>
  <div style="flex:1"></div>
  <span style="font-size:10px;color:#9ca3af;padding-right:8px">Ctrl+B Bold &middot; Ctrl+I Italic &middot; Ctrl+U Underline</span>
</div>
<div id="sb">
  <div style="font-size:10px;font-weight:800;text-transform:uppercase;color:#6b7280;letter-spacing:.06em;margin-bottom:8px">Tambah Seksi</div>
  <button class="ab" onclick="addBlk('header')">&#128100; Profil / Header</button>
  <button class="ab" onclick="addBlk('exp')">&#128188; Pengalaman Kerja</button>
  <button class="ab" onclick="addBlk('edu')">&#127979; Pendidikan</button>
  <button class="ab" onclick="addBlk('skills')">&#128161; Keahlian</button>
  <button class="ab" onclick="addBlk('contact')">&#128140; Kontak</button>
  <button class="ab" onclick="addBlk('summary')">&#128221; Ringkasan</button>
  <button class="ab" onclick="addBlk('div')">&#8213; Pemisah</button>
</div>
<div id="canvas">
  <div class="page" id="p1"></div>
</div>
<script>
var pages=[document.getElementById('p1')], pgN=1, blkN=0;
var hist=[], hIdx=-1, mut=false;
function curPage(){return pages[pages.length-1]}
function save(){if(mut)return;hist.splice(hIdx+1);hist.push(document.getElementById('canvas').innerHTML);if(hist.length>50)hist.shift();hIdx=hist.length-1;updUD()}
function undo(){if(hIdx<=0)return;hIdx--;mut=true;document.getElementById('canvas').innerHTML=hist[hIdx];mut=false;syncPages();updUD();toast('Undo','#374151')}
function redo(){if(hIdx>=hist.length-1)return;hIdx++;mut=true;document.getElementById('canvas').innerHTML=hist[hIdx];mut=false;syncPages();updUD();toast('Redo','#374151')}
function updUD(){var u=document.getElementById('bundo'),r=document.getElementById('bredo');u.disabled=hIdx<=0;r.disabled=hIdx>=hist.length-1}
function syncPages(){pages=Array.from(document.querySelectorAll('.page'))}
var t2;new MutationObserver(function(){if(mut)return;clearTimeout(t2);t2=setTimeout(save,700)}).observe(document.getElementById('canvas'),{childList:true,subtree:true,characterData:true,attributes:true})
document.addEventListener('keydown',function(e){if((e.ctrlKey||e.metaKey)&&!e.shiftKey&&e.key==='z'){e.preventDefault();undo()}if((e.ctrlKey||e.metaKey)&&(e.key==='y'||(e.shiftKey&&e.key==='z'))){e.preventDefault();redo()}if((e.ctrlKey||e.metaKey)&&e.key==='b'){e.preventDefault();fmt('bold')}if((e.ctrlKey||e.metaKey)&&e.key==='i'){e.preventDefault();fmt('italic')}if((e.ctrlKey||e.metaKey)&&e.key==='u'){e.preventDefault();fmt('underline')}})
document.getElementById('canvas').addEventListener('input', function(e) {
  var pg = curPage();
  if (pg.scrollHeight > 842) {
    document.execCommand('undo');
    if(pg.scrollHeight > 842 && hist[hIdx]) { pg.innerHTML = hist[hIdx]; }
    toast('Batas halaman tercapai. Konten berlebih ditolak.', '#dc2626');
  }
});
function fmt(c,v){document.execCommand(c,false,v||null);updRibbon()}
function fmtSize(s){document.execCommand('fontSize',false,7);document.querySelectorAll('[size="7"]').forEach(function(e){e.removeAttribute('size');e.style.fontSize=s+'px'})}
function fmtColor(c){document.getElementById('cp').style.background=c;document.execCommand('foreColor',false,c)}
function updRibbon(){['b','i','u','s'].forEach(function(k,i){document.getElementById('rb-'+k).classList.toggle('on',document.queryCommandState(['bold','italic','underline','strikeThrough'][i]))})}
document.addEventListener('selectionchange',updRibbon)
function mkBlk(id,type,inner){return '<div class="blk" id="'+id+'" data-type="'+type+'" onclick="selBlk(this)"><div class="bh"><button class="hb" onclick="event.stopPropagation();mvUp(\''+id+'\')">&#8679;</button><button class="hb" onclick="event.stopPropagation();mvDn(\''+id+'\')">&#8681;</button><button class="hb" onclick="event.stopPropagation();delBlk(\''+id+'\')" style="background:#dc2626">&#x2715;</button></div>'+inner+'</div>'}
var acc='#0f3c20'
function addBlk(type){var id='b'+(++blkN),h='';if(type==='header')h='<div style="display:flex;align-items:center;gap:16px;padding:20px 28px"><div style="width:64px;height:64px;border-radius:50%;background:#e5e7eb;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:24px">&#128100;</div><div><div contenteditable="true" style="font-size:20px;font-weight:800;color:#111">Nama Lengkap</div><div contenteditable="true" style="font-size:12px;font-weight:600;margin-top:3px;color:'+acc+'">Posisi / Jabatan</div></div></div>';else if(type==='contact')h='<div style="padding:10px 28px;background:#f9fafb;display:flex;gap:20px;flex-wrap:wrap;font-size:11px"><span>&#9993; <span contenteditable="true">email@contoh.com</span></span><span>&#128222; <span contenteditable="true">+62 812 0000 0000</span></span><span>&#128205; <span contenteditable="true">Medan, Indonesia</span></span></div>';else if(type==='summary')h='<div style="padding:16px 28px"><div contenteditable="true" style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:'+acc+';margin-bottom:8px">Ringkasan Profil</div><p contenteditable="true" style="font-size:11px;line-height:1.7;color:#374151;margin:0;border-left:3px solid '+acc+';padding-left:10px">Tuliskan ringkasan singkat Anda di sini.</p></div>';else if(type==='exp')h='<div style="padding:16px 28px"><div contenteditable="true" style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:'+acc+';margin-bottom:10px">Work Experience</div><div style="display:flex;justify-content:space-between"><div><div contenteditable="true" style="font-size:12px;font-weight:700;color:#111">Nama Jabatan</div><div contenteditable="true" style="font-size:11px;color:#6b7280">Perusahaan &middot; Kota</div></div><div contenteditable="true" style="font-size:10px;color:#9ca3af">Jan 2022 &ndash; Skrg</div></div><ul contenteditable="true" style="margin:8px 0 0 16px;font-size:11px;color:#374151;line-height:1.6"><li>Tanggung jawab utama</li><li>Pencapaian terukur</li></ul></div>';else if(type==='edu')h='<div style="padding:16px 28px"><div contenteditable="true" style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:'+acc+';margin-bottom:10px">Education</div><div style="display:flex;justify-content:space-between"><div><div contenteditable="true" style="font-size:12px;font-weight:700;color:#111">S1 Nama Jurusan</div><div contenteditable="true" style="font-size:11px;color:#6b7280">Nama Universitas</div></div><div contenteditable="true" style="font-size:10px;color:#9ca3af">2018 &ndash; 2022</div></div></div>';else if(type==='skills')h='<div style="padding:16px 28px"><div contenteditable="true" style="font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:'+acc+';margin-bottom:8px">Keahlian</div><div style="display:flex;flex-wrap:wrap;gap:5px" id="'+id+'-tags"><span contenteditable="true" style="background:#f0fdf4;color:#0f3c20;font-size:10px;font-weight:600;padding:2px 9px;border-radius:20px;border:1px solid #bbf7d0">Keahlian 1</span><span contenteditable="true" style="background:#f0fdf4;color:#0f3c20;font-size:10px;font-weight:600;padding:2px 9px;border-radius:20px;border:1px solid #bbf7d0">Keahlian 2</span></div></div>';else if(type==='div')h='<div style="padding:4px 0"><hr style="border:none;border-top:1px solid #e5e7eb;margin:0 28px"></div>';else h='<div contenteditable="true" style="padding:16px 28px;font-size:11px;color:#374151">Konten...</div>';
var pg=curPage();var oldH=pg.innerHTML;pg.insertAdjacentHTML('beforeend',mkBlk(id,type,h));
if(pg.scrollHeight>842){pg.innerHTML=oldH;toast('Gagal: Seksi baru melebihi kapasitas halaman.','#dc2626');}
}
function selBlk(el){document.querySelectorAll('.blk').forEach(function(b){b.classList.remove('sel')});el.classList.add('sel')}
function mvUp(id){var el=document.getElementById(id),p=el.previousElementSibling;if(p&&p.classList.contains('blk')){el.parentNode.insertBefore(el,p);}}
function mvDn(id){var el=document.getElementById(id),n=el.nextElementSibling;if(n&&n.classList.contains('blk')){el.parentNode.insertBefore(n,el);}}
function delBlk(id){if(confirm('Hapus seksi ini?')){document.getElementById(id).remove();}}
function saveDraft(){
  var name=document.getElementById('tname').textContent.trim()||'Template Baru';
  var html=document.getElementById('canvas').innerHTML;
  if(!TEMPLATE_ID){toast('Simpan gagal: buka template melalui halaman daftar template.','#dc2626');return;}
  var fd=new FormData();
  fd.append('_token',document.querySelector('meta[name="csrf-token"]').content);
  fd.append('_method','PUT');
  fd.append('name',name);
  fd.append('content_html',html);
  fd.append('description',TEMPLATE_DESCRIPTION);
  fd.append('status',TEMPLATE_STATUS);
  fetch(UPDATE_URL,{method:'POST',body:fd})
    .then(function(r){toast('Tersimpan!','#0f3c20');})
    .catch(function(){toast('Gagal menyimpan!','#dc2626');});
}
function doPreview(){var w=window.open('','_blank');var html='<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Preview CV</title><style>body{margin:0;background:#cbd5e1;display:flex;flex-direction:column;align-items:center;padding:24px;font-family:\'Segoe UI\',sans-serif}.page{width:595px;background:#fff;min-height:842px;overflow:visible;box-shadow:0 2px 16px rgba(0,0,0,.15);margin-bottom:24px}[contenteditable]{outline:none}.bh{display:none}.blk{border:none!important}</style></head><body>'+document.getElementById('canvas').innerHTML+'</body></html>';w.document.write(html);w.document.close();}
function doPublish(){
  var name=document.getElementById('tname').textContent.trim()||'Template Baru';
  var html=document.getElementById('canvas').innerHTML;
  if(!TEMPLATE_ID){toast('Publish gagal: buka template melalui halaman daftar template.','#dc2626');return;}
  var fd=new FormData();
  fd.append('_token',document.querySelector('meta[name="csrf-token"]').content);
  fd.append('_method','PUT');
  fd.append('name',name);
  fd.append('content_html',html);
  fd.append('description',TEMPLATE_DESCRIPTION);
  fd.append('status','published');
  fetch(UPDATE_URL,{method:'POST',body:fd})
    .then(function(){toast('Dipublikasikan!','#166534');setTimeout(function(){window.location.href='/hr/template-cv';},1200);})
    .catch(function(){toast('Gagal publish!','#dc2626');});
}
function toast(m,bg){var t=document.createElement('div');t.style.cssText='position:fixed;bottom:20px;right:20px;z-index:999;background:'+bg+';color:#fff;padding:10px 18px;border-radius:8px;font-size:12px;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,.2)';t.textContent=m;document.body.appendChild(t);setTimeout(function(){t.remove()},2200)}
var iHTML='';
function doImport(inp){var f=inp.files[0];if(!f)return;var ext=f.name.split('.').pop().toLowerCase();if(ext==='docx'){var rd=new FileReader();rd.onload=function(e){mammoth.convertToHtml({arrayBuffer:e.target.result}).then(function(r){iHTML=cleanHTML(r.value);applyImport()}).catch(function(e){toast('Gagal: '+e.message,'#dc2626')})}; rd.readAsArrayBuffer(f)}else if(ext==='html'||ext==='htm'){var rd=new FileReader();rd.onload=function(e){var doc=new DOMParser().parseFromString(e.target.result,'text/html');iHTML=cleanHTML(doc.body?doc.body.innerHTML:e.target.result);applyImport()};rd.readAsText(f)}else{toast('Gunakan .docx atau .html','#dc2626')}inp.value=''}
function cleanHTML(h){return h.replace(/<script[\s\S]*?<\/script>/gi,'').replace(/<style[\s\S]*?<\/style>/gi,'').replace(/src\s*=\s*["'][^"']*["']/gi,'').replace(/font-family\s*:[^;"']*/gi,"font-family:'Segoe UI',sans-serif").replace(/<p>\s*<\/p>/gi,'')}
function applyImport(){
  if(!iHTML)return;
  var pg = curPage();
  var oldHTML = pg.innerHTML;
  pg.innerHTML = '';
  
  var tmp=document.createElement('div');
  tmp.innerHTML=iHTML;
  var groups=[],cur=[];
  Array.from(tmp.children).forEach(function(ch){
    var t=ch.tagName.toLowerCase();
    if((t==='h1'||t==='h2')&&cur.length>0){groups.push(cur.join(''));cur=[];}
    cur.push(ch.outerHTML);
  });
  if(cur.length)groups.push(cur.join(''));
  if(!groups.length)groups=[iHTML];
  
  groups.forEach(function(html){
    var id='b'+(++blkN);
    var el=document.createElement('div');
    el.className='blk';el.id=id;el.dataset.type='imported';
    el.onclick=function(){selBlk(this);};
    el.innerHTML='<div class="bh"><button class="hb" onclick="event.stopPropagation();mvUp(\''+id+'\')">&#8679;</button><button class="hb" onclick="event.stopPropagation();mvDn(\''+id+'\')">&#8681;</button><button class="hb" onclick="event.stopPropagation();delBlk(\''+id+'\')" style="background:#dc2626">&#x2715;</button></div><div contenteditable="true" style="padding:14px 28px;font-family:\'Segoe UI\',sans-serif;font-size:11px;line-height:1.7;color:#374151">'+html+'</div>';
    pg.appendChild(el);
  });
  
  if (pg.scrollHeight > 842) {
    pg.innerHTML = oldHTML;
    toast('Gagal: Template melebihi 1 halaman (tidak didukung).', '#dc2626');
  } else {
    toast('Import berhasil ditimpa!', '#0f3c20');
    save();
  }
  iHTML='';
}

// ── Data template dari Laravel ──
var TEMPLATE_ID          = {{ $template ? $template->id : 'null' }};
var TEMPLATE_STATUS      = @json($template ? $template->status : 'draft');
var TEMPLATE_DESCRIPTION = @json($template ? ($template->description ?? '') : '');
var TEMPLATE_HTML        = @json($template ? ($template->content_html ?? '') : '');
var TEMPLATE_NAME        = @json($template ? $template->name : null);
var UPDATE_URL           = {!! json_encode($template ? route('hr.template-cv.update', $template) : '') !!};

// Tampilkan nama template (pakai @json agar quote tidak di-escape Blade)
document.getElementById('tname').textContent = TEMPLATE_NAME ||
  (new URLSearchParams(location.search).get('name')
    ? decodeURIComponent(new URLSearchParams(location.search).get('name'))
    : 'Template Baru');

// Load konten dari DB jika ada, atau pakai blok default
if(TEMPLATE_HTML && TEMPLATE_HTML.trim() !== ''){
  document.getElementById('canvas').innerHTML = TEMPLATE_HTML;
  syncPages();
} else {
  ['header','contact','summary','exp','edu','skills'].forEach(addBlk);
}
save();
</script>
</body>
</html>

