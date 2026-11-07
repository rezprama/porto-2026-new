<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Monitoring New Project — DALAPA Regional</title>
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
  .scope-note{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-monitoring'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Monitoring</span></div>
    <h1 data-i18n="pageTitle">Monitoring</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head"><h3 data-i18n="filterTitle">Data Monitoring</h3></div>
      <div class="filter-bar">
        <div class="field wide"><label>Distrik</label><select id="fDistrict"></select></div>
        <div class="field wide"><label>Project</label><select id="fProject"></select></div>
        <div class="field"><label data-i18n="fRange">Rentang Hari Pekerjaan</label><input type="date" id="fStart" value="2026-09-01" /></div>
        <div class="field"><label data-i18n="until">Sampai</label><input type="date" id="fEnd" value="2026-09-30" /></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head scope-note">
        <h3 id="matrixTitle">Rekap per Distrik</h3>
        <button class="btn-outline warn" id="backBtn" hidden data-i18n="back">Kembali</button>
      </div>
      <div class="table-scroll">
        <table class="bordered centered">
          <thead>
            <tr>
              <th id="scopeCol">Distrik</th>
              <th data-i18n="total">Total</th><th>Listing</th><th>Progress</th><th>Complete</th><th>Pending</th>
              <th data-i18n="cAppTl">Approval TL</th><th data-i18n="cPenTl">Pending TL</th>
              <th data-i18n="cAppQe">Approval QE</th><th data-i18n="cPenQe">Pending QE</th>
            </tr>
          </thead>
          <tbody id="matrixBody"></tbody>
          <tfoot><tr class="total-row" id="matrixTotals"></tr></tfoot>
        </table>
      </div>
      <p class="hint-muted" style="padding:10px 16px" data-i18n="hint">Klik nama distrik untuk melihat rincian per STO, klik angka untuk melihat daftar tiketnya.</p>
    </div>
  </div>
</main>

<!-- INFORMASI TIKET -->
<div class="modal-backdrop" id="ticketModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 data-i18n="ticketTitle">Informasi Tiket</h3><button class="modal-close" id="ticketX">✕</button></div>
    <div class="modal-body">
      <div class="hint-muted" id="ticketSub" style="margin-bottom:10px"></div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>Distrik</th><th>STO</th><th data-i18n="cJob">Pekerjaan</th><th data-i18n="cTicketNo">Nomor Tiket</th>
              <th data-i18n="cTeam">Nama Tim</th><th data-i18n="cMitra">Nama Mitra</th>
              <th data-i18n="cCompDate">Comp Date</th><th data-i18n="cTlDate">Approve TL Date</th>
              <th data-i18n="cStatusWo">Status WO</th><th data-i18n="cStatusDate">Status Date</th><th>Workforce</th>
            </tr>
          </thead>
          <tbody id="ticketBody"></tbody>
        </table>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline warn" id="ticketClose" data-i18n="back">Kembali</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    pageTitle: 'Monitoring', filterTitle: 'Data Monitoring', fRange: 'Rentang Hari Pekerjaan', until: 'Sampai',
    back: 'Kembali', cAppTl: 'Approval TL', cPenTl: 'Pending TL', cAppQe: 'Approval QE', cPenQe: 'Pending QE',
    hint: 'Klik nama distrik untuk melihat rincian per STO, klik angka untuk melihat daftar tiketnya.',
    ticketTitle: 'Informasi Tiket', cJob: 'Pekerjaan', cTicketNo: 'Nomor Tiket', cTeam: 'Nama Tim', cMitra: 'Nama Mitra',
    cCompDate: 'Comp Date', cTlDate: 'Approve TL Date', cStatusWo: 'Status WO', cStatusDate: 'Status Date',
    perDistrict: 'Rekap per Distrik', perSto: 'Rekap per STO — ',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  /* each matrix column is a bucket of the workorder ladder */
  var COLS = [
    { key: 'LISTING', test: function(w){ return w.status === 'LISTING'; } },
    { key: 'PROGRESS', test: function(w){ return w.status === 'PROGRESS'; } },
    { key: 'COMPLETE', test: function(w){ return w.status === 'COMPLETE'; } },
    { key: 'PENDING', test: function(w){ return w.status === 'PENDING'; } },
    { key: 'APPROVE_TL', test: function(w){ return w.status === 'APPROVE_TL'; } },
    { key: 'PENDING_TL', test: function(w){ return w.status === 'PENDING_TL'; } },
    /* regional-approved workorders have already cleared QE, so they count in the QE column */
    { key: 'APPROVE_QE', test: function(w){ return w.status === 'APPROVE_QE' || w.status === 'APPROVE_REGIONAL'; } },
    { key: 'PENDING_QE', test: function(w){ return w.status === 'PENDING_QE'; } },
  ];

  var fDistrict = document.getElementById('fDistrict'), fProject = document.getElementById('fProject'),
      fStart = document.getElementById('fStart'), fEnd = document.getElementById('fEnd');
  fillSelect(fDistrict, DISTRICTS, 'ALL');
  fillSelect(fProject, PROJECTS, 'ALL');

  var drillDistrict = null;

  function inScope(w){
    if (fDistrict.value && w.district !== fDistrict.value) { return false; }
    if (fProject.value && w.project !== fProject.value) { return false; }
    if (fStart.value && w.tglListing < fStart.value) { return false; }
    if (fEnd.value && w.tglListing > fEnd.value) { return false; }
    return true;
  }
  function rowsFor(scopeValue, level){
    return WOS.filter(function(w){
      if (!inScope(w)) { return false; }
      /* empty scope = the Total row: every workorder currently shown in the table, not one scope */
      if (!scopeValue) { return level === 'sto' ? STO_BY_DISTRICT[drillDistrict].indexOf(w.sto) !== -1 : true; }
      return level === 'district' ? w.district === scopeValue : w.sto === scopeValue;
    });
  }

  function cell(count, scopeValue, level, colKey){
    if (!count) { return '<span class="drill zero">0</span>'; }
    return '<button type="button" class="drill" data-scope="' + scopeValue + '" data-level="' + level + '" data-col="' + colKey + '">' + count + '</button>';
  }

  function renderMatrix(){
    var level = drillDistrict ? 'sto' : 'district';
    var scopes = drillDistrict ? STO_BY_DISTRICT[drillDistrict] : DISTRICTS.filter(function(d){ return !fDistrict.value || d === fDistrict.value; });
    document.getElementById('scopeCol').textContent = drillDistrict ? 'STO' : 'Distrik';
    document.getElementById('matrixTitle').textContent = drillDistrict ? t('perSto') + drillDistrict : t('perDistrict');
    document.getElementById('backBtn').hidden = !drillDistrict;

    var totals = { total: 0 };
    COLS.forEach(function(c){ totals[c.key] = 0; });

    document.getElementById('matrixBody').innerHTML = scopes.map(function(scope){
      var rows = rowsFor(scope, level);
      totals.total += rows.length;
      var label = level === 'district'
        ? '<span class="row-link" data-district="' + scope + '">' + scope + '</span>'
        : scope;
      return '<tr><td>' + label + '</td>' +
        '<td>' + cell(rows.length, scope, level, 'ALL') + '</td>' +
        COLS.map(function(c){
          var n = rows.filter(c.test).length;
          totals[c.key] += n;
          return '<td>' + cell(n, scope, level, c.key) + '</td>';
        }).join('') + '</tr>';
    }).join('') || '<tr><td colspan="10" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    document.getElementById('matrixTotals').innerHTML = '<td>' + t('total') + '</td>' +
      '<td>' + cell(totals.total, '', level, 'ALL') + '</td>' +
      COLS.map(function(c){ return '<td>' + cell(totals[c.key], '', level, c.key) + '</td>'; }).join('');
  }

  document.getElementById('matrixBody').addEventListener('click', function(e){
    var d = e.target.closest('[data-district]');
    if (d) { drillDistrict = d.dataset.district; renderMatrix(); return; }
    var b = e.target.closest('[data-scope]');
    if (b) { openTickets(b.dataset.scope, b.dataset.level, b.dataset.col); }
  });
  document.getElementById('matrixTotals').addEventListener('click', function(e){
    var b = e.target.closest('[data-scope]');
    if (b) { openTickets(b.dataset.scope, b.dataset.level, b.dataset.col); }
  });
  document.getElementById('backBtn').addEventListener('click', function(){ drillDistrict = null; renderMatrix(); });
  [fDistrict, fProject, fStart, fEnd].forEach(function(el){ el.addEventListener('change', function(){ drillDistrict = null; renderMatrix(); }); });
  document.getElementById('filterBtn').addEventListener('click', function(){ drillDistrict = null; renderMatrix(); });

  /* ---------- ticket list ---------- */
  var ticketModal = document.getElementById('ticketModal');
  function openTickets(scope, level, colKey){
    var rows = rowsFor(scope, level);
    if (colKey !== 'ALL') {
      var col = COLS.filter(function(c){ return c.key === colKey; })[0];
      rows = rows.filter(col.test);
    }
    var scopeLabel = scope || (drillDistrict ? drillDistrict : t('total'));
    document.getElementById('ticketSub').textContent = scopeLabel + ' · ' + (colKey === 'ALL' ? t('total') : STATUS_LABEL[colKey]) + ' · ' + rows.length + ' tiket';
    document.getElementById('ticketBody').innerHTML = rows.length ? rows.map(function(w){
      return '<tr><td>' + w.district + '</td><td>' + w.sto + '</td><td>' + w.pekerjaan + '</td>' +
        '<td class="mono-cell">' + w.ticket + '</td><td>' + w.team + '</td><td>' + w.mitra + '</td>' +
        '<td>' + (w.tglTeknisi || '-') + '</td><td>' + (w.tglTl || '-') + '</td>' +
        '<td>' + statusPill(w.status) + '</td>' +
        '<td>' + (w.tglQe || w.tglTl || w.tglTeknisi || w.tglListing) + '</td><td>' + w.teknisi + '</td></tr>';
    }).join('') : '<tr><td colspan="11" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
    ticketModal.classList.add('show');
  }
  ['ticketX', 'ticketClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ ticketModal.classList.remove('show'); });
  });

  renderMatrix();
  applyLang();
</script>
</body>
</html>
