<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Monitoring Anggaran New Project — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .drill{background:none;border:none;font:inherit;color:var(--brand-600);font-weight:700;cursor:pointer;padding:0}
  .drill:hover{text-decoration:underline}
  .drill.zero{color:var(--muted);font-weight:400;cursor:default;text-decoration:none}
  .row-link{color:var(--brand-600);font-weight:600;cursor:pointer}
  .row-link:hover{text-decoration:underline}
  .grp-tl{background:#eaf1f8} .grp-qe{background:#eef6f2}
  .scope-note{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-monitoring-rp'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Monitoring (Anggaran)</span></div>
    <h1 data-i18n="pageTitle">Monitoring (Anggaran)</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head"><h3 data-i18n="filterTitle">Data Monitoring Anggaran</h3></div>
      <div class="filter-bar">
        <div class="field wide"><label data-i18n="fBasis">Filter Berdasarkan</label><select id="fBasis"></select></div>
        <div class="field wide"><label>Project</label><select id="fProject"></select></div>
        <div class="field"><label data-i18n="date">Tanggal</label><input type="date" id="fStart" value="2026-09-01" /></div>
        <div class="field"><label data-i18n="until">Sampai</label><input type="date" id="fEnd" value="2026-09-30" /></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head scope-note">
        <h3 id="matrixTitle">Rekap Anggaran per Distrik</h3>
        <button class="btn-outline warn" id="backBtn" hidden data-i18n="back">Kembali</button>
      </div>
      <div class="table-scroll">
        <table class="bordered centered">
          <thead>
            <tr>
              <th rowspan="2" id="scopeCol" style="vertical-align:middle">Distrik</th>
              <th colspan="2" class="grp-tl">TL</th>
              <th colspan="2" class="grp-qe">AMQE</th>
              <th rowspan="2" style="vertical-align:middle" data-i18n="total">Total</th>
            </tr>
            <tr>
              <th class="grp-tl" data-i18n="stNeed">NEED APPROVE</th><th class="grp-tl" data-i18n="stDone">DONE</th>
              <th class="grp-qe" data-i18n="stNeed">NEED APPROVE</th><th class="grp-qe" data-i18n="stDone">DONE</th>
            </tr>
          </thead>
          <tbody id="matrixBody"></tbody>
          <tfoot><tr class="total-row" id="matrixTotals"></tr></tfoot>
        </table>
      </div>
      <p class="hint-muted" style="padding:10px 16px" data-i18n="hint">Nilai dalam rupiah dari total BOQ workorder. Klik distrik untuk rincian per STO, klik nominal untuk daftar tiketnya.</p>
    </div>
  </div>
</main>

<!-- RINCIAN TIKET -->
<div class="modal-backdrop" id="ticketModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 data-i18n="ticketTitle">Rincian Anggaran Tiket</h3><button class="modal-close" id="ticketX">✕</button></div>
    <div class="modal-body">
      <div class="hint-muted" id="ticketSub" style="margin-bottom:10px"></div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>Distrik</th><th>STO</th><th data-i18n="cTicketNo">Nomor Tiket</th><th data-i18n="cJob">Pekerjaan</th>
              <th data-i18n="cMitra">Nama Mitra</th><th data-i18n="cStatusWo">Status WO</th>
              <th class="num" data-i18n="cMaterial">Nilai Material</th><th class="num" data-i18n="cJasa">Nilai Jasa</th>
              <th class="num" data-i18n="total">Total</th>
            </tr>
          </thead>
          <tbody id="ticketBody"></tbody>
          <tfoot><tr class="total-row" id="ticketTotals"></tr></tfoot>
        </table>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline warn" id="ticketClose" data-i18n="back">Kembali</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    pageTitle: 'Monitoring (Anggaran)', filterTitle: 'Data Monitoring Anggaran', fBasis: 'Filter Berdasarkan',
    date: 'Tanggal', until: 'Sampai', back: 'Kembali', stNeed: 'NEED APPROVE', stDone: 'DONE',
    hint: 'Nilai dalam rupiah dari total BOQ workorder. Klik distrik untuk rincian per STO, klik nominal untuk daftar tiketnya.',
    ticketTitle: 'Rincian Anggaran Tiket', cTicketNo: 'Nomor Tiket', cJob: 'Pekerjaan', cMitra: 'Nama Mitra',
    cStatusWo: 'Status WO', cMaterial: 'Nilai Material', cJasa: 'Nilai Jasa',
    perDistrict: 'Rekap Anggaran per Distrik', perSto: 'Rekap Anggaran per STO — ',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  /* TL still owes a decision on anything completed but unsigned; QE owes anything TL has cleared. */
  var BUCKETS = [
    { key: 'TL_NEED', test: function(w){ return w.status === 'COMPLETE' || w.status === 'PENDING_TL'; } },
    { key: 'TL_DONE', test: function(w){ return rank(w.status) >= 3; } },
    { key: 'QE_NEED', test: function(w){ return w.status === 'APPROVE_TL' || w.status === 'PENDING_QE'; } },
    { key: 'QE_DONE', test: function(w){ return rank(w.status) >= 4; } },
  ];

  var fBasis = document.getElementById('fBasis'), fProject = document.getElementById('fProject'),
      fStart = document.getElementById('fStart'), fEnd = document.getElementById('fEnd');
  fBasis.innerHTML = '<option value="">REGIONAL</option>' + DISTRICTS.map(function(d){ return '<option>' + d + '</option>'; }).join('');
  fillSelect(fProject, PROJECTS, 'ALL');

  var drillDistrict = null;

  function inScope(w){
    if (fBasis.value && w.district !== fBasis.value) { return false; }
    if (fProject.value && w.project !== fProject.value) { return false; }
    if (fStart.value && w.tglListing < fStart.value) { return false; }
    if (fEnd.value && w.tglListing > fEnd.value) { return false; }
    return true;
  }
  function rowsFor(scope, level){
    return WOS.filter(function(w){
      return inScope(w) && (level === 'district' ? w.district === scope : w.sto === scope);
    });
  }
  function sumOf(rows){ return rows.reduce(function(a, w){ return a + woTotal(w); }, 0); }

  function cell(value, scope, level, bucket){
    if (!value) { return '<span class="drill zero">Rp 0</span>'; }
    return '<button type="button" class="drill" data-scope="' + scope + '" data-level="' + level + '" data-bucket="' + bucket + '">' + rupiah(value) + '</button>';
  }

  function renderMatrix(){
    var level = drillDistrict ? 'sto' : 'district';
    var scopes = drillDistrict ? STO_BY_DISTRICT[drillDistrict] : DISTRICTS.filter(function(d){ return !fBasis.value || d === fBasis.value; });
    document.getElementById('scopeCol').textContent = drillDistrict ? 'STO' : 'Distrik';
    document.getElementById('matrixTitle').textContent = drillDistrict ? t('perSto') + drillDistrict : t('perDistrict');
    document.getElementById('backBtn').hidden = !drillDistrict;

    var totals = { total: 0 };
    BUCKETS.forEach(function(b){ totals[b.key] = 0; });

    document.getElementById('matrixBody').innerHTML = scopes.map(function(scope){
      var rows = rowsFor(scope, level);
      var all = sumOf(rows);
      totals.total += all;
      var label = level === 'district'
        ? '<span class="row-link" data-district="' + scope + '">' + scope + '</span>'
        : scope;
      return '<tr><td>' + label + '</td>' +
        BUCKETS.map(function(b){
          var v = sumOf(rows.filter(b.test));
          totals[b.key] += v;
          return '<td>' + cell(v, scope, level, b.key) + '</td>';
        }).join('') +
        '<td>' + cell(all, scope, level, 'ALL') + '</td></tr>';
    }).join('') || '<tr><td colspan="6" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    document.getElementById('matrixTotals').innerHTML = '<td>' + t('total') + '</td>' +
      BUCKETS.map(function(b){ return '<td>' + rupiah(totals[b.key]) + '</td>'; }).join('') +
      '<td>' + rupiah(totals.total) + '</td>';
  }

  document.getElementById('matrixBody').addEventListener('click', function(e){
    var d = e.target.closest('[data-district]');
    if (d) { drillDistrict = d.dataset.district; renderMatrix(); return; }
    var b = e.target.closest('[data-scope]');
    if (b) { openTickets(b.dataset.scope, b.dataset.level, b.dataset.bucket); }
  });
  document.getElementById('backBtn').addEventListener('click', function(){ drillDistrict = null; renderMatrix(); });
  [fBasis, fProject, fStart, fEnd].forEach(function(el){ el.addEventListener('change', function(){ drillDistrict = null; renderMatrix(); }); });
  document.getElementById('filterBtn').addEventListener('click', function(){ drillDistrict = null; renderMatrix(); });

  /* ---------- ticket breakdown ---------- */
  var ticketModal = document.getElementById('ticketModal');
  var BUCKET_LABEL = { TL_NEED: 'TL · NEED APPROVE', TL_DONE: 'TL · DONE', QE_NEED: 'AMQE · NEED APPROVE', QE_DONE: 'AMQE · DONE', ALL: 'Total' };
  function openTickets(scope, level, bucketKey){
    var rows = rowsFor(scope, level);
    if (bucketKey !== 'ALL') {
      var b = BUCKETS.filter(function(x){ return x.key === bucketKey; })[0];
      rows = rows.filter(b.test);
    }
    document.getElementById('ticketSub').textContent = scope + ' · ' + BUCKET_LABEL[bucketKey] + ' · ' + rows.length + ' tiket';
    document.getElementById('ticketBody').innerHTML = rows.length ? rows.map(function(w){
      return '<tr><td>' + w.district + '</td><td>' + w.sto + '</td><td class="mono-cell">' + w.ticket + '</td>' +
        '<td>' + w.pekerjaan + '</td><td>' + w.mitra + '</td><td>' + statusPill(w.status) + '</td>' +
        '<td class="num">' + rupiah(woMaterial(w)) + '</td><td class="num">' + rupiah(woJasa(w)) + '</td>' +
        '<td class="num">' + rupiah(woTotal(w)) + '</td></tr>';
    }).join('') : '<tr><td colspan="9" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
    document.getElementById('ticketTotals').innerHTML = '<td colspan="6">' + t('total') + '</td>' +
      '<td class="num">' + rupiah(rows.reduce(function(a, w){ return a + woMaterial(w); }, 0)) + '</td>' +
      '<td class="num">' + rupiah(rows.reduce(function(a, w){ return a + woJasa(w); }, 0)) + '</td>' +
      '<td class="num">' + rupiah(sumOf(rows)) + '</td>';
    ticketModal.classList.add('show');
  }
  ['ticketX', 'ticketClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ ticketModal.classList.remove('show'); });
  });

  renderMatrix();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeMonitoringRpTour = {
    id: 'dalapareg-qe-monitoring-rp',
    steps: [
      {
        target: '.filter-bar',
        pos: 'bottom',
        title: 'Filter Evaluasi Anggaran',
        desc: 'Saring pantauan dana berdasarkan kriteria basis, nama project, dan periode tanggal pelaksanaan.'
      },
      {
        target: 'table thead',
        pos: 'bottom',
        title: 'Matriks Nilai Rupiah Tiket',
        desc: 'Memantau akumulasi rupiah BOQ pada level Team Leader (TL) dan Quality Engineer (AMQE) untuk status <b>NEED APPROVE</b> vs <b>DONE</b>.'
      },
      {
        target: '#matrixBody tr:first-child .row-link',
        pos: 'bottom',
        title: 'Drill-down Nominal STO',
        desc: 'Klik nama distrik untuk melihat rincian alokasi dan penyerapan dana rupiah per masing-masing STO.'
      },
      {
        target: '#matrixBody tr:first-child .drill:not(.zero)',
        pos: 'top',
        title: 'Rincian Nilai Material & Jasa',
        desc: 'Klik nominal rupiah untuk membuka dialog rincian nilai material, biaya jasa teknisi, dan total BOQ per tiket workorder.'
      }
    ]
  };

  setTimeout(function(){
    DalapaTour.start(qeMonitoringRpTour);
  }, 450);
</script>

@include('project.dalapareg.feature.partials.tour-guide')
</body>
</html>
