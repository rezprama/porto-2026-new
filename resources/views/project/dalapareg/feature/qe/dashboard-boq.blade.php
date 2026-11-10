<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard BOQ — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .job{max-width:230px;white-space:normal;line-height:1.45}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-dashboard-boq'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Dashboard BOQ</span></div>
    <h1 data-i18n="pageTitle">Dashboard BOQ</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head"><h3 data-i18n="filterTitle">Filter Pekerjaan</h3></div>
      <div class="filter-bar">
        <div class="field narrow"><label data-i18n="month">Bulan</label><select id="fMonth"></select></div>
        <div class="field narrow"><label data-i18n="year">Tahun</label><select id="fYear"><option>2026</option><option>2025</option></select></div>
        <div class="field wide"><label>Distrik</label><select id="fDistrict"></select></div>
        <div class="field wide"><label>Mitra</label><select id="fMitra"></select></div>
        <div class="field wide"><label>Project</label><select id="fProject"></select></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
        <button class="btn-sky" id="printAll" data-i18n="printAll">Print All</button>
      </div>
    </div>

    <div class="stat-grid">
      <div class="stat"><div class="k" data-i18n="sWo">Workorder</div><div class="v" id="sWo">0</div></div>
      <div class="stat"><div class="k" data-i18n="sValue">Nilai BOQ</div><div class="v" id="sValue">Rp 0</div></div>
      <div class="stat"><div class="k" data-i18n="sFinal">BOQ Final</div><div class="v" id="sFinal">0</div></div>
      <div class="stat"><div class="k" data-i18n="sPending">Perlu Recheck</div><div class="v" id="sPending">0</div></div>
    </div>

    <div class="card">
      <div class="card-head"><h3 data-i18n="tableTitle">Data BOQ Workorder</h3></div>
      <div class="table-toolbar">
        <select id="perPage"><option value="10">10 / halaman</option><option value="20">20 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari tiket / teknisi / tim..." />
      </div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>No</th><th>Mitra</th><th>Tim</th><th data-i18n="cTech">Teknisi</th>
              <th data-i18n="cBoqStatus">Status BOQ</th><th data-i18n="cWorkDate">Tanggal Pengerjaan</th>
              <th data-i18n="cJob">Pekerjaan</th><th data-i18n="cTicketNo">No Tiket</th>
              <th class="num" data-i18n="cTotalValue">Nilai Total</th><th data-i18n="cAction">Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
    </div>
  </div>
</main>

<!-- RECHECK -->
<div class="modal-backdrop" id="recheckModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="recheckTitle">Recheck BOQ</h3><button class="modal-close" id="recheckX">✕</button></div>
    <div class="modal-body">
      <p class="hint-muted" id="recheckBody"></p>
      <div class="field" style="margin-top:10px">
        <label data-i18n="recheckReason">Catatan Recheck</label>
        <textarea id="recheckNote" rows="3" data-i18n-ph="recheckPh" placeholder="Contoh: qty penarikan kabel perlu diverifikasi ulang."></textarea>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="recheckCancel" data-i18n="cancel">Batal</button>
      <button class="btn-danger" id="recheckOk" data-i18n="recheckSubmit">Kirim Recheck</button>
    </div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    pageTitle: 'Dashboard BOQ', filterTitle: 'Filter Pekerjaan', tableTitle: 'Data BOQ Workorder', printAll: 'Print All',
    searchPh: 'Cari tiket / teknisi / tim...',
    cTech: 'Teknisi', cBoqStatus: 'Status BOQ', cWorkDate: 'Tanggal Pengerjaan', cJob: 'Pekerjaan',
    cTicketNo: 'No Tiket', cTotalValue: 'Nilai Total', cAction: 'Action',
    sWo: 'Workorder', sValue: 'Nilai BOQ', sFinal: 'BOQ Final', sPending: 'Perlu Recheck',
    bqNone: 'BELUM ADA BOQ', bqTl: 'MENUNGGU TL', bqQe: 'MENUNGGU QE', bqRegional: 'MENUNGGU REGIONAL', bqFinal: 'FINAL',
    recheck: 'Recheck BOQ', print: 'Print',
    recheckTitle: 'Recheck BOQ', recheckReason: 'Catatan Recheck',
    recheckPh: 'Contoh: qty penarikan kabel perlu diverifikasi ulang.', recheckSubmit: 'Kirim Recheck',
    recheckBody: 'BOQ {x} akan dikembalikan ke TL untuk diperiksa ulang.',
    needReason: 'Catatan recheck wajib diisi.', rechecked: 'BOQ dikembalikan ke TL untuk recheck.',
    cannotRecheck: 'BOQ ini belum bisa di-recheck.',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  /* BOQ status is just the ladder read from the BOQ's point of view */
  function boqStatus(w){
    if (rank(w.status) < 2) { return { key: 'bqNone', pill: 'pill-gray' }; }
    if (w.status === 'COMPLETE' || w.status === 'PENDING_TL' || w.status === 'PENDING') { return { key: 'bqTl', pill: 'pill-amber' }; }
    if (w.status === 'APPROVE_TL' || w.status === 'PENDING_QE') { return { key: 'bqQe', pill: 'pill-blue' }; }
    if (w.status === 'APPROVE_QE') { return { key: 'bqRegional', pill: 'pill-teal' }; }
    return { key: 'bqFinal', pill: 'pill-green' };
  }
  function canRecheck(w){ return rank(w.status) >= 2 && w.status !== 'APPROVE_REGIONAL'; }

  var fMonth = document.getElementById('fMonth'), fYear = document.getElementById('fYear'),
      fDistrict = document.getElementById('fDistrict'), fMitra = document.getElementById('fMitra'),
      fProject = document.getElementById('fProject'), perPage = document.getElementById('perPage'),
      searchInput = document.getElementById('searchInput');
  fMonth.innerHTML = MONTHS.map(function(m, idx){ return '<option value="' + idx + '"' + (idx === 8 ? ' selected' : '') + '>' + m + '</option>'; }).join('');
  fillSelect(fDistrict, DISTRICTS, 'ALL');
  fillSelect(fMitra, MITRA, 'ALL');
  fillSelect(fProject, PROJECTS, 'ALL');

  var currentPage = 1;
  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return WOS.filter(function(w){
      if (w.month !== parseInt(fMonth.value, 10) || String(w.year) !== fYear.value) { return false; }
      if (fDistrict.value && w.district !== fDistrict.value) { return false; }
      if (fMitra.value && w.mitra !== fMitra.value) { return false; }
      if (fProject.value && w.project !== fProject.value) { return false; }
      if (q && (w.ticket + ' ' + w.teknisi + ' ' + w.team + ' ' + w.pekerjaan).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderTable(){
    var rows = getFiltered();
    var res = paginate(rows, currentPage, parseInt(perPage.value, 10), function(p){ currentPage = p; renderTable(); });
    currentPage = res.page;
    var offset = (currentPage - 1) * parseInt(perPage.value, 10);

    document.getElementById('tbody').innerHTML = res.slice.length ? res.slice.map(function(w, i){
      var bq = boqStatus(w);
      var actions = '<div class="row-actions">' +
        (canRecheck(w) ? '<button class="mini-btn red" data-recheck="' + w.id + '">' + t('recheck') + '</button>' : '') +
        '<button class="mini-btn slate" data-print="' + w.id + '">' + t('print') + '</button></div>';
      return '<tr><td>' + (offset + i + 1) + '</td><td>' + w.mitra + '</td><td>' + w.team + '</td><td>' + w.teknisi + '</td>' +
        '<td><span class="pill ' + bq.pill + '">' + t(bq.key) + '</span></td>' +
        '<td>' + (w.tglTeknisi || w.tglListing) + '</td>' +
        '<td class="job">' + w.pekerjaan + '</td><td class="mono-cell">' + w.ticket + '</td>' +
        '<td class="num">' + rupiah(woTotal(w)) + '</td><td>' + actions + '</td></tr>';
    }).join('') : '<tr><td colspan="10" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    document.getElementById('sWo').textContent = rows.length;
    document.getElementById('sValue').textContent = rupiah(rows.reduce(function(a, w){ return a + woTotal(w); }, 0));
    document.getElementById('sFinal').textContent = rows.filter(function(w){ return w.status === 'APPROVE_REGIONAL'; }).length;
    document.getElementById('sPending').textContent = rows.filter(function(w){ return w.status === 'PENDING_TL' || w.status === 'PENDING_QE'; }).length;
  }

  [fMonth, fYear, fDistrict, fMitra, fProject, perPage].forEach(function(el){
    el.addEventListener('change', function(){ currentPage = 1; renderTable(); });
  });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });
  document.getElementById('printAll').addEventListener('click', function(){ toast(t('demoOnly')); });

  /* ---------- recheck ---------- */
  var recheckModal = document.getElementById('recheckModal'), recheckTarget = null;
  document.getElementById('tbody').addEventListener('click', function(e){
    var p = e.target.closest('[data-print]');
    if (p) { toast(t('demoOnly')); return; }
    var b = e.target.closest('[data-recheck]');
    if (!b) { return; }
    recheckTarget = WOS.filter(function(w){ return w.id === parseInt(b.dataset.recheck, 10); })[0];
    if (!canRecheck(recheckTarget)) { toast(t('cannotRecheck')); return; }
    document.getElementById('recheckBody').textContent = t('recheckBody').replace('{x}', recheckTarget.ticket);
    document.getElementById('recheckNote').value = '';
    recheckModal.classList.add('show');
  });
  ['recheckX', 'recheckCancel'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ recheckModal.classList.remove('show'); });
  });
  document.getElementById('recheckOk').addEventListener('click', function(){
    var note = document.getElementById('recheckNote').value.trim();
    if (!note) { toast(t('needReason')); return; }
    recheckTarget.status = 'PENDING_TL';
    recheckTarget.note = note;
    recheckTarget.tglTl = stamp();
    recheckModal.classList.remove('show');
    renderTable();
    toast(t('rechecked'));
  });

  renderTable();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeDashboardBoqTour = {
    id: 'dalapareg-qe-boq',
    steps: [
      {
        target: '.filter-bar',
        pos: 'bottom',
        title: 'Filter Dashboard BOQ',
        desc: 'Saring pantauan BOQ berdasarkan Bulan, Tahun, Distrik, Mitra, dan Project penugasan. Cetak dokumen rekap melalui tombol <b>Print All</b>.'
      },
      {
        target: '.stat-grid',
        pos: 'bottom',
        title: 'Ringkasan Anggaran & Volume',
        desc: 'Metrik agregat memuat jumlah total workorder, total akumulasi nilai BOQ, kuantitas BOQ final, dan tiket yang perlu recheck.'
      },
      {
        target: 'table thead',
        pos: 'bottom',
        title: 'Tabel Detail BOQ Workorder',
        desc: 'Rincian data per tiket: mitra pelaksana, teknisi, tanggal pengerjaan, status BOQ, nomor tiket, dan nilai total rupiah.'
      },
      {
        target: '#tbody tr:first-child td:last-child',
        pos: 'left',
        title: 'Aksi Review & Cetak BOQ',
        desc: 'Buka rincian volume material KHS yang diajukan serta cetak dokumen resmi Surat Perintah Kerja (SPK) dan BAST.'
      }
    ]
  };

  setTimeout(function(){
    DalapaTour.start(qeDashboardBoqTour);
  }, 450);
</script>

@include('project.dalapareg.feature.partials.tour-guide')
</body>
</html>
