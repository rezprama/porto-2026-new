<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Listing New Project — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .job{max-width:240px;white-space:normal;line-height:1.45}
  .file-box{border:1px dashed var(--border);border-radius:4px;padding:10px 12px;font-size:12px;color:var(--muted);background:#f6f8fa}
  .file-box b{color:var(--text)}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-listing'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Listing</span></div>
    <h1 data-i18n="pageTitle">Listing</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head">
        <h3 data-i18n="tableTitle">Data Listing Pekerjaan</h3>
        <button class="btn-success" id="addBtn" data-i18n="addListing">Tambah Listing</button>
      </div>
      <div class="table-toolbar">
        <select id="fDistrict"></select>
        <select id="fProject"></select>
        <select id="perPage"><option value="10">10 / halaman</option><option value="20">20 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari pekerjaan / tiket / tim..." />
      </div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>Distrik</th><th>STO</th><th>Project</th><th data-i18n="cJob">Nama Pekerjaan</th>
              <th data-i18n="cListDate">Tanggal Listing</th><th data-i18n="status">Status</th>
              <th data-i18n="cTeam">Tim Mitra</th><th data-i18n="cCreator">Pembuat List</th><th data-i18n="cAction">Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
    </div>
  </div>
</main>

<!-- TAMBAH LISTING -->
<div class="modal-backdrop" id="addModal">
  <div class="modal-card modal-lg">
    <div class="modal-head"><h3 data-i18n="addTitle">Input Data Listing</h3><button class="modal-close" id="addX">✕</button></div>
    <div class="modal-body">
      <div class="row3">
        <div class="field"><label>Distrik</label><select id="aDistrict"></select></div>
        <div class="field"><label>STO</label><select id="aSto"></select></div>
        <div class="field"><label>Project</label><select id="aProject"></select></div>
      </div>
      <div class="row3" style="margin-top:10px">
        <div class="field"><label>Mitra</label><select id="aMitra"></select></div>
        <div class="field"><label data-i18n="cTeam">Tim Mitra</label><select id="aTeam"></select></div>
        <div class="field"><label data-i18n="cJob">Nama Pekerjaan</label><input type="text" id="aJob" data-i18n-ph="jobPh" placeholder="mis. RECOVERY KABEL UDARA SEPINGGAN" /></div>
      </div>
      <div class="field" style="margin-top:10px">
        <label data-i18n="fBoqFile">File Data BOQ</label>
        <div class="file-box"><b>boq-listing.xlsx</b> — <span data-i18n="uploadDemo">unggah berkas dinonaktifkan pada demo ini.</span></div>
      </div>
      <div class="row3" style="margin-top:10px">
        <div class="field"><label data-i18n="fSuratNo">Nomor Surat</label><input type="text" id="aSuratNo" /></div>
        <div class="field"><label data-i18n="fSuratTgl">Tanggal Surat</label><input type="date" id="aSuratTgl" value="2026-09-15" /></div>
        <div class="field"><label data-i18n="fSuratPengirim">Pengirim Surat</label><select id="aSuratPengirim"></select></div>
      </div>
      <div class="field" style="margin-top:10px"><label data-i18n="fSuratJudul">Judul Surat</label><input type="text" id="aSuratJudul" /></div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="addCancel" data-i18n="cancel">Batal</button>
      <button class="btn-success" id="addSave" data-i18n="save">Simpan</button>
    </div>
  </div>
</div>

<!-- DETAIL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 id="detailTitle">Informasi</h3><button class="modal-close" id="detailX">✕</button></div>
    <div class="tabs">
      <button class="on" data-tab="#dInfo" data-i18n="tabInfo">Informasi</button>
      <button data-tab="#dBoq" data-i18n="tabBoq">Data BOQ</button>
      <button data-tab="#dEvidence" data-i18n="tabEvidence">Evidence</button>
    </div>
    <div class="modal-body">
      <div id="dInfo"><div class="kv-grid" id="dGrid"></div></div>
      <div id="dBoq" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead><tr><th>Designator</th><th data-i18n="cJob">Nama Pekerjaan</th><th class="num" data-i18n="cQty">Kuantitas</th><th data-i18n="cSatuan">Satuan</th><th data-i18n="cAction">Action</th></tr></thead>
            <tbody id="dBoqBody"></tbody>
          </table>
        </div>
      </div>
      <div id="dEvidence" hidden><div class="evidence-row" id="evidenceRow"></div></div>
    </div>
    <div class="modal-foot"><button class="btn-outline warn" id="detailClose" data-i18n="back">Kembali</button></div>
  </div>
</div>

@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    pageTitle: 'Listing', tableTitle: 'Data Listing Pekerjaan', addListing: 'Tambah Listing',
    searchPh: 'Cari pekerjaan / tiket / tim...', status: 'Status',
    cJob: 'Nama Pekerjaan', cListDate: 'Tanggal Listing', cTeam: 'Tim Mitra', cCreator: 'Pembuat List',
    cAction: 'Action', cQty: 'Kuantitas', cSatuan: 'Satuan', back: 'Kembali',
    addTitle: 'Input Data Listing', jobPh: 'mis. RECOVERY KABEL UDARA SEPINGGAN',
    fBoqFile: 'File Data BOQ', uploadDemo: 'unggah berkas dinonaktifkan pada demo ini.',
    fSuratNo: 'Nomor Surat', fSuratTgl: 'Tanggal Surat', fSuratPengirim: 'Pengirim Surat', fSuratJudul: 'Judul Surat',
    tabInfo: 'Informasi', tabBoq: 'Data BOQ', tabEvidence: 'Evidence',
    kDistrict: 'Distrik', kSto: 'STO', kJob: 'Pekerjaan', kTicket: 'Nomor Tiket', kProject: 'Project',
    kCoord: 'Koordinat', kSuratNo: 'Nomor Surat', kSuratTgl: 'Tanggal Surat', kSuratPengirim: 'Pengirim Surat',
    kSuratJudul: 'Judul Surat', kSuratFile: 'File Surat', kStatus: 'Status', kMitra: 'Mitra', kTeam: 'Tim Mitra',
    kCreator: 'Pembuat List', kListDate: 'Tanggal Listing', kTotalBoq: 'Total BOQ',
    evBefore: 'Evidence Before', evAfter: 'Evidence After', evNone: 'Evidence baru tersedia setelah teknisi menyelesaikan pekerjaan.',
    listingAdded: 'Listing baru ditambahkan.', needJob: 'Nama pekerjaan wajib diisi.',
    lineRemoved: 'Baris BOQ dihapus.', notEditable: 'BOQ hanya bisa diubah saat status masih LISTING.',
    viewFile: 'Lihat',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  var fDistrict = document.getElementById('fDistrict'), fProject = document.getElementById('fProject'),
      perPage = document.getElementById('perPage'), searchInput = document.getElementById('searchInput');
  fillSelect(fDistrict, DISTRICTS);
  fillSelect(fProject, PROJECTS);

  var currentPage = 1;

  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return WOS.filter(function(w){
      if (fDistrict.value && w.district !== fDistrict.value) { return false; }
      if (fProject.value && w.project !== fProject.value) { return false; }
      if (q && (w.pekerjaan + ' ' + w.ticket + ' ' + w.team + ' ' + w.sto).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderTable(){
    var res = paginate(getFiltered(), currentPage, parseInt(perPage.value, 10), function(p){ currentPage = p; renderTable(); });
    currentPage = res.page;
    document.getElementById('tbody').innerHTML = res.slice.length ? res.slice.map(function(w){
      return '<tr><td>' + w.district + '</td><td>' + w.sto + '</td><td>' + w.project + '</td>' +
        '<td class="job">' + w.pekerjaan + '<div class="hint-muted mono-cell">' + w.ticket + '</div></td>' +
        '<td>' + w.tglListing + '</td><td>' + statusPill(w.status) + '</td>' +
        '<td>' + w.team + '<div class="hint-muted">' + w.mitra + '</div></td>' +
        '<td>' + w.pembuat + '</td>' +
        '<td><button class="mini-btn brand" data-open="' + w.id + '">' + t('detail') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="9" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
  }
  [fDistrict, fProject, perPage].forEach(function(el){ el.addEventListener('change', function(){ currentPage = 1; renderTable(); }); });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });

  /* ---------- tambah listing ---------- */
  var addModal = document.getElementById('addModal');
  var aDistrict = document.getElementById('aDistrict'), aSto = document.getElementById('aSto');
  aDistrict.innerHTML = DISTRICTS.map(function(d){ return '<option>' + d + '</option>'; }).join('');
  function fillSto(){ aSto.innerHTML = STO_BY_DISTRICT[aDistrict.value].map(function(s){ return '<option>' + s + '</option>'; }).join(''); }
  aDistrict.addEventListener('change', fillSto);
  fillSto();
  document.getElementById('aProject').innerHTML = PROJECTS.map(function(p){ return '<option>' + p + '</option>'; }).join('');
  document.getElementById('aMitra').innerHTML = MITRA.map(function(m){ return '<option>' + m + '</option>'; }).join('');
  document.getElementById('aTeam').innerHTML = ['TIM A-1', 'TIM B-2', 'TIM C-3', 'TIM D-1'].map(function(x){ return '<option>' + x + '</option>'; }).join('');
  document.getElementById('aSuratPengirim').innerHTML = PEMBUAT.map(function(p){ return '<option>' + p + '</option>'; }).join('');

  document.getElementById('addBtn').addEventListener('click', function(){
    document.getElementById('aJob').value = '';
    document.getElementById('aSuratNo').value = 'TEL.' + (200 + WOS.length) + '/QE-KTI/2026';
    document.getElementById('aSuratJudul').value = 'Permohonan pekerjaan new project';
    addModal.classList.add('show');
  });
  ['addX', 'addCancel'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ addModal.classList.remove('show'); });
  });
  document.getElementById('addSave').addEventListener('click', function(){
    var job = document.getElementById('aJob').value.trim();
    if (!job) { toast(t('needJob')); return; }
    var id = WOS.length;
    var s = seeded(id + 1, 7);
    var lines = [];
    for (var k = 0; k < 3; k++) { lines.push({ khs: KHS[(id + k * 3) % KHS.length], qty: 1 + ((s >> (k * 3)) % 9) }); }
    WOS.unshift({
      id: id, district: aDistrict.value, sto: aSto.value, stoWorkzone: aSto.value.replace('STO ', 'WZ '),
      ticket: 'IN' + (26099000 + id * 7), headline: job, lop: job.toUpperCase(),
      project: document.getElementById('aProject').value, pekerjaan: job, penyebab: PENYEBAB[id % PENYEBAB.length],
      mitra: document.getElementById('aMitra').value, team: document.getElementById('aTeam').value,
      teknisi: TEKNISI[id % TEKNISI.length], pembuat: document.getElementById('aSuratPengirim').value,
      month: 8, year: 2026,
      koordinat: (-1.2 - (id % 9) * 0.031).toFixed(6) + ', ' + (116.83 + (id % 7) * 0.043).toFixed(6),
      surat: {
        no: document.getElementById('aSuratNo').value,
        judul: document.getElementById('aSuratJudul').value,
        pengirim: document.getElementById('aSuratPengirim').value,
        tgl: document.getElementById('aSuratTgl').value,
      },
      tglListing: document.getElementById('aSuratTgl').value,
      tglTeknisi: '', tglTl: '', tglQe: '', tglRegional: '',
      reportedDate: document.getElementById('aSuratTgl').value + ' 07:30', resolveDate: '',
      status: 'LISTING', note: '', lines: lines,
    });
    addModal.classList.remove('show');
    currentPage = 1;
    renderTable();
    toast(t('listingAdded'));
  });

  /* ---------- detail ---------- */
  var detailModal = document.getElementById('detailModal'), activeWo = null;

  function renderBoq(){
    var editable = activeWo.status === 'LISTING';
    document.getElementById('dBoqBody').innerHTML = activeWo.lines.length ? activeWo.lines.map(function(l, idx){
      var act = editable
        ? '<button class="mini-btn red" data-delline="' + idx + '">' + t('delete') + '</button>'
        : '<span style="color:var(--muted)">—</span>';
      return '<tr><td class="mono-cell">' + l.khs.d + '</td><td>' + l.khs.u + '</td>' +
        '<td class="num">' + l.qty + '</td><td>' + l.khs.s + '</td><td>' + act + '</td></tr>';
    }).join('') : '<tr><td colspan="5" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
  }

  function renderDetail(){
    var w = activeWo;
    document.getElementById('detailTitle').textContent = w.ticket + ' — ' + w.pekerjaan;
    document.getElementById('dGrid').innerHTML = kvHtml([
      [t('kDistrict'), w.district], [t('kSto'), w.sto], [t('kProject'), w.project],
      [t('kTicket'), w.ticket], [t('kJob'), w.pekerjaan], [t('kCoord'), w.koordinat],
      [t('kStatus'), statusPill(w.status)], [t('kMitra'), w.mitra], [t('kTeam'), w.team],
      [t('kCreator'), w.pembuat], [t('kListDate'), w.tglListing], [t('kTotalBoq'), rupiah(woTotal(w))],
      [t('kSuratNo'), w.surat.no], [t('kSuratTgl'), w.surat.tgl], [t('kSuratPengirim'), w.surat.pengirim],
      [t('kSuratJudul'), w.surat.judul],
      [t('kSuratFile'), '<button type="button" class="mini-btn slate" data-demo>' + t('viewFile') + '</button>'],
    ]);
    renderBoq();
    document.getElementById('evidenceRow').innerHTML = rank(w.status) >= 2
      ? [['evBefore', '/images/dalapa/evidence/odp-before.svg'], ['evAfter', '/images/dalapa/evidence/odp-after.svg']].map(function(e){
          return '<div class="evidence-item"><div class="k">' + t(e[0]) + '</div>' +
            '<button type="button" class="thumb" data-lightbox="' + e[1] + '" data-caption="' + w.ticket + ' — ' + t(e[0]) + '">' +
            '<img src="' + e[1] + '" alt="" /></button></div>';
        }).join('')
      : '<p class="hint-muted">' + t('evNone') + '</p>';
  }

  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-open]');
    if (!b) { return; }
    activeWo = WOS.filter(function(w){ return w.id === parseInt(b.dataset.open, 10); })[0];
    renderDetail();
    detailModal.classList.add('show');
  });
  document.getElementById('dBoqBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-delline]');
    if (!b) { return; }
    if (activeWo.status !== 'LISTING') { toast(t('notEditable')); return; }
    activeWo.lines.splice(parseInt(b.dataset.delline, 10), 1);
    renderBoq();
    toast(t('lineRemoved'));
  });
  detailModal.addEventListener('click', function(e){
    if (e.target.closest('[data-demo]')) { toast(t('demoOnly')); }
    var lb = e.target.closest('[data-lightbox]');
    if (lb) { openLightbox(lb.dataset.lightbox, lb.dataset.caption); }
  });
  ['detailX', 'detailClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ detailModal.classList.remove('show'); });
  });

  renderTable();
  applyLang();
</script>
</body>
</html>
