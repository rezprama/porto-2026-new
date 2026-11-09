<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Anggaran QE — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .tab-nav{display:flex;gap:4px;border-bottom:1px solid var(--border);margin-bottom:18px;overflow-x:auto}
  .tab-nav button{padding:10px 16px;border:none;background:none;font-size:13.5px;font-weight:600;color:var(--muted);
    border-bottom:2px solid transparent;white-space:nowrap}
  .tab-nav button.on{color:var(--brand-600);border-color:var(--brand-500)}
  .stat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:16px}
  @media (min-width:860px){ .stat-grid{grid-template-columns:repeat(4,1fr)} }
  .stat-card{background:var(--panel-bg);border:1px solid var(--border);border-radius:12px;padding:14px 16px}
  .stat-card .num{font-size:18px;font-weight:700;color:var(--text)}
  .stat-card .lbl{font-size:11px;color:var(--muted);margin-top:2px}
  .seg3{display:flex;height:6px;border-radius:99px;overflow:hidden;background:var(--gray-100)}
  [data-theme="dark"] .seg3{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .seg3 .realisasi{background:#12b76a} .seg3 .alokasi{background:#60a5fa} .seg3 .avail{background:var(--gray-300)}
  [data-theme="dark"] .seg3 .avail{background:var(--gray-700)}
  .legend-row{display:flex;flex-wrap:wrap;gap:16px;padding:14px 2px;font-size:11.5px;color:var(--muted)}
  .legend-row .item{display:flex;align-items:center;gap:6px}
  .legend-row .dot{width:10px;height:10px;border-radius:50%}

  /* ---------- Sumber Anggaran: filter bar + narrow contract cards ---------- */
  .src-filter-bar{display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:18px}
  .src-filter-bar select{height:38px;border-radius:8px;border:1px solid var(--border);background:var(--panel-bg);
    padding:0 10px;font-size:13px;font-family:inherit;color:var(--text)}
  .seg-btns{display:flex;align-items:center;border:1px solid var(--border);border-radius:8px;overflow:hidden;height:38px}
  .seg-btns button{height:100%;padding:0 12px;border:none;background:var(--panel-bg);font-family:inherit;font-size:12.5px;
    font-weight:500;color:var(--muted)}
  .seg-btns button + button{border-left:1px solid var(--border)}
  .seg-btns button.on{background:var(--brand-500);color:#fff}
  .src-card-grid{display:flex;flex-wrap:wrap;gap:16px;align-items:flex-start}
  .src-card{background:var(--panel-bg);border:1px solid var(--border);border-radius:14px;box-shadow:var(--shadow-xs);
    width:100%;overflow:hidden}
  @media (min-width:640px){ .src-card{width:330px} }
  .src-card-head{padding:12px 14px;border-bottom:1px solid var(--border)}
  .src-card-head .top{display:flex;align-items:flex-start;gap:6px}
  .src-card-head h4{flex:1;font-size:13px;font-weight:700;line-height:1.35;color:var(--text)}
  .src-card-head .meta{margin-top:3px;font-size:10.5px;color:var(--muted)}
  .release-row{padding:10px 14px;border-bottom:1px solid var(--border)}
  .release-head{display:flex;align-items:flex-start;justify-content:space-between;gap:8px}
  .release-head .org{font-size:11.5px;font-weight:600;color:var(--label)}
  .release-head .amt{margin-top:2px;font-size:13.5px;font-weight:700;color:var(--text)}
  .dist-pill{background:#eef2ff;color:#4338ca;border-radius:99px;padding:2px 7px;font-size:10px;font-weight:600;white-space:nowrap}
  [data-theme="dark"] .dist-pill{background:color-mix(in srgb,#6366f1 25%,transparent);color:#c7d2fe}
  .bar-note{margin-top:5px;font-size:10px;color:var(--muted)}
  .release-detail{padding:10px 14px;background:var(--gray-50);border-bottom:1px solid var(--border)}
  [data-theme="dark"] .release-detail{background:color-mix(in srgb,var(--gray-900) 45%,var(--panel-bg))}
  .info-box{background:var(--panel-bg);border:1px solid var(--border);border-radius:10px;padding:10px 12px}
  .info-box .hd{display:flex;align-items:center;gap:6px;font-size:11.5px;font-weight:600;color:var(--label);margin-bottom:9px}
  .ico-sq{width:19px;height:19px;border-radius:5px;display:inline-flex;align-items:center;justify-content:center;font-size:10px}
  .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:9px}
  .info-grid .k{font-size:9.5px;color:var(--muted);margin-bottom:2px;display:flex;align-items:center;gap:4px}
  .info-grid .v{font-size:11.5px;font-weight:600;color:var(--text)}
  .mini-pct{border-radius:4px;padding:0 4px;font-size:9.5px;font-weight:700}
  .sect-hd{display:flex;align-items:center;gap:7px;font-size:11.5px;font-weight:600;color:var(--text);margin:14px 0 8px}
  .qt-row{padding:8px 0;border-bottom:1px solid var(--border)}
  .qt-row:last-of-type{border-bottom:none}
  .qt-top{display:flex;align-items:flex-start;justify-content:space-between;gap:8px}
  .qt-name{font-size:11.5px;font-weight:600;color:var(--text)}
  .qt-amt{font-size:11.5px;font-weight:700;color:var(--text);text-align:right}
  .qt-sub{margin-top:3px;font-size:9.5px;color:var(--muted);text-align:right}
  .prog-box{margin:7px 0 0 8px;border:1px solid var(--border);border-radius:8px;background:var(--panel-bg);padding:6px 10px}
  .prog-line{display:flex;align-items:center;gap:7px;padding:4px 0;font-size:11px}
  .prog-line .bullet{width:6px;height:6px;border-radius:50%;background:var(--gray-300);flex-shrink:0}
  .prog-line .nm{flex:1;color:var(--label);font-weight:500}
  .qt-bar{display:flex;height:6px;border-radius:99px;overflow:hidden;background:var(--gray-200);margin-top:10px}
  [data-theme="dark"] .qt-bar{background:var(--gray-700)}
  .qt-legend{display:flex;flex-wrap:wrap;gap:4px 12px;margin-top:6px}
  .qt-legend span{display:flex;align-items:center;gap:4px;font-size:9.5px;color:var(--muted)}
  .qt-legend i{width:6px;height:6px;border-radius:50%;display:inline-block}
  .show-more{padding:8px 14px;text-align:center}
  .show-more button{background:none;border:none;font-size:10.5px;font-weight:600;color:var(--brand-600);font-family:inherit}
  .src-card-foot{padding:10px 14px;background:var(--gray-50);border-top:1px solid var(--border)}
  [data-theme="dark"] .src-card-foot{background:color-mix(in srgb,var(--gray-900) 45%,var(--panel-bg))}
  .foot-top{display:flex;align-items:center;gap:8px}
  .foot-top .lbl{flex:1;font-size:11.5px;font-weight:600;color:var(--label)}
  .foot-top .amt{font-size:13px;font-weight:700;color:var(--text)}
  .foot-break{display:none;margin-top:8px;padding-top:8px;border-top:1px solid var(--border)}
  .foot-break.open{display:block}
  .foot-break .ln{display:flex;justify-content:space-between;font-size:10.5px;padding:1px 0}
  .foot-break .ln .val{font-family:monospace;font-weight:600}
  .tree-scroll{overflow-x:auto}
  table.tree-table{white-space:nowrap}
  table.tree-table th, table.tree-table td{text-align:center}
  table.tree-table th:nth-child(1), table.tree-table td:nth-child(1){text-align:left;position:sticky;left:0;background:var(--panel-bg);z-index:1}
  table.tree-table thead th:nth-child(1){background:var(--gray-50);z-index:2}
  .tree-label{display:flex;align-items:center;gap:6px}
  .tree-chev{width:18px;height:18px;border:none;background:none;color:var(--muted);cursor:pointer;flex-shrink:0;
    display:inline-flex;align-items:center;justify-content:center;transition:transform .15s}
  .tree-chev.open{transform:rotate(90deg)}
  tr.total-row td{font-weight:700;border-top:2px solid var(--border);background:var(--gray-50)}
  [data-theme="dark"] tr.total-row td{background:color-mix(in srgb,var(--gray-900) 60%,var(--panel-bg))}
  .prog-mini{width:90px;height:6px;border-radius:99px;background:var(--gray-100);overflow:hidden;display:inline-block;vertical-align:middle}
  [data-theme="dark"] .prog-mini{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .prog-mini .f{height:100%;background:var(--brand-500)}
  .icon-btn{width:26px;height:26px;border-radius:7px;border:1px solid var(--border);background:var(--panel-bg);color:var(--label);
    display:inline-flex;align-items:center;justify-content:center;font-size:12px}
  .icon-btn:hover{border-color:var(--brand-500);color:var(--brand-500)}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'qe-budget'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">QE</div>
    <h1 data-i18n="pageTitle">Anggaran</h1>
  </div>

  <div class="tab-nav" id="tabNav">
    <button class="on" data-tab="contract" data-i18n="tabContract">Kontrak Anggaran</button>
    <button data-tab="source" data-i18n="tabSource">Sumber Anggaran</button>
    <button data-tab="distribution" data-i18n="tabDistribution">Distribusi Anggaran</button>
    <button data-tab="program" data-i18n="tabProgram">Program</button>
  </div>

  <!-- TAB: KONTRAK -->
  <div id="tabContractPane" class="stack">
    <div class="toolbar-row" id="contractToolbarRow" style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px">
      <input type="text" id="contractSearch" data-i18n-ph="searchPh" placeholder="Cari kontrak..." style="height:38px;border-radius:8px;border:1px solid var(--border);background:var(--panel-bg);padding:0 12px;font-size:13px;font-family:inherit;color:var(--text);width:260px" />
      <button class="btn-primary" id="addContractBtn" data-i18n="btnAddContract">+ Tambah Kontrak Anggaran</button>
    </div>
    <div class="card" id="contractCard">
      <div class="table-scroll">
        <table id="contractTable">
          <thead><tr>
            <th>#</th><th data-i18n="cName">Nama</th><th data-i18n="cSource">Sumber Anggaran</th><th data-i18n="cOrg">Organisasi</th>
            <th data-i18n="cPeriod">Periode</th><th data-i18n="cBudget">Total Budget</th><th data-i18n="cDistributed">Terdistribusi</th>
            <th data-i18n="cAlokasi">Alokasi</th><th data-i18n="cRealisasi">Realisasi</th><th data-i18n="cAvailable">Available</th><th data-i18n="cAction">Aksi</th>
          </tr></thead>
          <tbody id="contractBody"></tbody>
          <tfoot><tr class="total-row" id="contractTotals"></tr></tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB: SUMBER ANGGARAN -->
  <div id="tabSourcePane" class="stack" hidden>
    <div class="src-filter-bar">
      <select id="srcYear" style="width:96px"><option>2026</option><option>2025</option></select>
      <select id="srcScope" style="width:150px"><option value="" data-i18n="fAllScope">Semua Scope</option><option>AREA</option><option>REGION</option><option>DISTRICT</option></select>
      <select id="srcArea" style="width:170px"><option value="" data-i18n="fAllArea">Semua Area</option><option>KALIMANTAN</option><option>SULAWESI</option></select>
      <div class="seg-btns" id="srcStatus">
        <button class="on" data-status="" data-i18n="fAll">Semua</button>
        <button data-status="active" data-i18n="active">Aktif</button>
        <button data-status="inactive" data-i18n="inactive">Non Aktif</button>
      </div>
      <button class="btn-primary" id="addSourceBtn" style="margin-left:auto" data-i18n="btnAddSource">+ Tambah Sumber Anggaran</button>
    </div>
    <div class="src-card-grid" id="sourceCards"></div>
    <div class="legend-row">
      <div class="item"><span class="dot" style="background:#12b76a"></span><span data-i18n="legendRealisasi">Terealisasi</span></div>
      <div class="item"><span class="dot" style="background:#60a5fa"></span><span data-i18n="legendAlokasi">Teralokasi</span></div>
      <div class="item"><span class="dot" style="background:var(--gray-300)"></span><span data-i18n="legendAvailable">Available</span></div>
    </div>
  </div>

  <!-- RELEASE DETAIL DIALOG -->
  <div class="modal-backdrop" id="relDetailModal">
    <div class="modal-card modal-lg">
      <div class="modal-head"><h3 data-i18n="relDetailTitle">Rincian Pelimpahan</h3><button class="modal-close" id="relDetailX">✕</button></div>
      <div class="modal-body">
        <div class="hint-muted" id="relDetailSub" style="margin-bottom:10px"></div>
        <div class="table-scroll">
          <table class="mini-table">
            <thead><tr><th data-i18n="cPelimpahan">Pelimpahan</th><th data-i18n="cBudget">Budget</th><th data-i18n="cDistributed">Terdistribusi</th><th data-i18n="cAlokasi">Alokasi</th><th data-i18n="cRealisasi">Realisasi</th><th data-i18n="cAvailable">Available</th></tr></thead>
            <tbody id="relDetailBody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-foot"><button class="btn-outline" id="relDetailDone" data-i18n="close">Tutup</button></div>
    </div>
  </div>

  <!-- TAB: DISTRIBUSI -->
  <div id="tabDistributionPane" class="stack" hidden>
    <div class="card"><div class="card-body">
      <div class="row3">
        <div class="field"><label data-i18n="fMonth">Bulan</label><input type="month" id="distMonth" value="2026-09" /></div>
        <div class="field"><label data-i18n="fArea">Area</label><select id="distArea"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option></select></div>
        <div class="field"><label data-i18n="cRelease">Rilis Budget</label><select id="distRelease"><option value="">Semua</option></select></div>
      </div>
      <div class="row-actions" style="margin-top:12px">
        <button class="btn-primary" id="distShowBtn" data-i18n="show">Tampilkan</button>
        <button class="btn-outline" id="addDistBtn" data-i18n="btnAddDist">+ Tambah Distribusi</button>
      </div>
    </div></div>
    <div class="stat-grid">
      <div class="stat-card"><div class="num" id="distStatBudget">-</div><div class="lbl" data-i18n="cBudget">Total Budget</div></div>
      <div class="stat-card"><div class="num" id="distStatAlokasi">-</div><div class="lbl" data-i18n="cAlokasi">Alokasi</div></div>
      <div class="stat-card"><div class="num" id="distStatRealisasi">-</div><div class="lbl" data-i18n="cRealisasi">Realisasi</div></div>
      <div class="stat-card"><div class="num" id="distStatAvailable">-</div><div class="lbl" data-i18n="cAvailable">Available</div></div>
    </div>
    <div class="card">
      <div class="tree-scroll">
        <table class="tree-table">
          <thead><tr>
            <th data-i18n="cRegionalDistrict">Regional / District</th><th data-i18n="cTicket">Jumlah Tiket</th><th data-i18n="cBudget">Budget</th>
            <th data-i18n="cProgress">Progres</th><th data-i18n="cAlokasi">Alokasi</th><th data-i18n="cRealisasi">Realisasi</th><th data-i18n="cAvailable">Available</th>
          </tr></thead>
          <tbody id="distBody"></tbody>
        </table>
      </div>
      <div class="legend-row">
        <div class="item"><span class="sw" style="background:#12b76a"></span><span data-i18n="legendRealisasi">Terealisasi</span></div>
        <div class="item"><span class="sw" style="background:#465fff"></span><span data-i18n="legendAlokasi">Teralokasi</span></div>
        <div class="item"><span class="sw" style="background:var(--gray-200)"></span><span data-i18n="legendAvailable">Available</span></div>
      </div>
    </div>
  </div>

  <!-- TAB: PROGRAM -->
  <div id="tabProgramPane" class="stack" hidden>
    <div class="toolbar-row" style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px">
      <input type="text" id="programSearch" data-i18n-ph="searchPh" placeholder="Cari program..." style="height:38px;border-radius:8px;border:1px solid var(--border);background:var(--panel-bg);padding:0 12px;font-size:13px;font-family:inherit;color:var(--text);width:260px" />
      <button class="btn-primary" id="addProgramBtn" data-i18n="btnAddProgram">+ Tambah Program</button>
    </div>
    <div class="card">
      <div class="table-scroll">
        <table>
          <thead><tr><th data-i18n="cNamaProgram">Nama Program</th><th data-i18n="cJenisQe">Jenis QE</th><th data-i18n="cSource">Sumber Anggaran</th><th data-i18n="fStatus">Status</th><th data-i18n="cAction">Aksi</th></tr></thead>
          <tbody id="programBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- CONTRACT DIALOG -->
<div class="modal-backdrop" id="contractModal">
  <div class="modal-card">
    <div class="modal-head"><h3 id="contractModalTitle">-</h3><button class="modal-close" id="contractX">✕</button></div>
    <div class="modal-body">
      <div class="field"><label data-i18n="cName">Nama Kontrak</label><input type="text" id="cfName" /></div>
      <div class="field" style="margin-top:10px"><label data-i18n="cSource">Sumber Anggaran</label><select id="cfSource"></select></div>
      <div class="field" style="margin-top:10px"><label data-i18n="cOrg">Organisasi</label><select id="cfOrg"><option>PAMASUKA</option><option>KALIMANTAN</option><option>SULAWESI</option></select></div>
      <div class="row3" style="margin-top:10px">
        <div class="field"><label data-i18n="cStart">Awal Periode</label><input type="month" id="cfStart" value="2026-01" /></div>
        <div class="field"><label data-i18n="cEnd">Akhir Periode</label><input type="month" id="cfEnd" value="2026-12" /></div>
      </div>
      <div class="field" style="margin-top:10px"><label data-i18n="cBudgetProvided">Budget Provided (HO)</label><input type="number" id="cfBudget" /></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="contractCancel" data-i18n="cancel">Batal</button><button class="btn-primary" id="contractSave" data-i18n="save2">Simpan</button></div>
  </div>
</div>

<!-- SOURCE (RELEASE) DIALOG -->
<div class="modal-backdrop" id="sourceModal">
  <div class="modal-card">
    <div class="modal-head"><h3 id="sourceModalTitle">-</h3><button class="modal-close" id="sourceX">✕</button></div>
    <div class="modal-body">
      <div class="field"><label data-i18n="cContract">Kontrak Anggaran</label><select id="sfContract"></select></div>
      <div class="field" style="margin-top:10px"><label data-i18n="cPelimpahan">Pelimpahan (Organisasi)</label><select id="sfOrg"></select></div>
      <div class="field" style="margin-top:10px"><label data-i18n="cNominal">Nominal</label><input type="number" id="sfBudget" /></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="sourceCancel" data-i18n="cancel">Batal</button><button class="btn-primary" id="sourceSave" data-i18n="save2">Simpan</button></div>
  </div>
</div>

<!-- DISTRIBUTION DIALOG -->
<div class="modal-backdrop" id="distModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="btnAddDist">Tambah Distribusi</h3><button class="modal-close" id="distX">✕</button></div>
    <div class="modal-body">
      <div class="field"><label data-i18n="cRelease">Rilis Budget</label><select id="dfRelease"></select></div>
      <div class="field" style="margin-top:10px"><label data-i18n="fMonth">Bulan Distribusi</label><input type="month" id="dfMonth" value="2026-09" /></div>
      <div class="row3" style="margin-top:10px">
        <div class="field"><label data-i18n="fRegional">Regional</label><select id="dfRegional"><option>KALIMANTAN</option><option>SULAWESI</option></select></div>
        <div class="field"><label data-i18n="fDistrict">District</label><select id="dfDistrict"></select></div>
      </div>
      <div class="field" style="margin-top:10px"><label data-i18n="cBudgetRp">Budget (Rp)</label><input type="number" id="dfBudget" /></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="distCancel" data-i18n="cancel">Batal</button><button class="btn-primary" id="distSave" data-i18n="save2">Simpan</button></div>
  </div>
</div>

<!-- PROGRAM DIALOG -->
<div class="modal-backdrop" id="programModal">
  <div class="modal-card">
    <div class="modal-head"><h3 id="programModalTitle">-</h3><button class="modal-close" id="programX">✕</button></div>
    <div class="modal-body">
      <div class="field"><label data-i18n="cNamaProgram">Nama Program</label><input type="text" id="pfName" /></div>
      <div class="field" style="margin-top:10px"><label data-i18n="cJenisQe">Jenis QE</label>
        <select id="pfType"><option>PREVENTIF</option><option>KURATIF</option><option>RELOKASI</option><option>NIQE</option></select>
      </div>
      <div class="field" style="margin-top:10px"><label data-i18n="cSource">Sumber Anggaran</label><select id="pfSource"></select></div>
      <div class="field" style="margin-top:10px"><label data-i18n="fStatus">Status</label><select id="pfStatus"><option value="1" data-i18n="active">Aktif</option><option value="0" data-i18n="inactive">Tidak Aktif</option></select></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="programCancel" data-i18n="cancel">Batal</button><button class="btn-primary" id="programSave" data-i18n="save2">Simpan</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Anggaran', tabContract: 'Kontrak Anggaran', tabSource: 'Sumber Anggaran', tabDistribution: 'Distribusi Anggaran', tabProgram: 'Program',
      searchPh: 'Cari...', btnAddContract: '+ Tambah Kontrak Anggaran', btnAddSource: '+ Tambah Sumber Anggaran',
      btnAddDist: '+ Tambah Distribusi', btnAddProgram: '+ Tambah Program',
      cName: 'Nama', cSource: 'Sumber Anggaran', cOrg: 'Organisasi', cPeriod: 'Periode', cBudget: 'Total Budget',
      cDistributed: 'Terdistribusi', cAlokasi: 'Alokasi', cRealisasi: 'Realisasi', cAvailable: 'Available', cAction: 'Aksi',
      cStart: 'Awal Periode', cEnd: 'Akhir Periode', cBudgetProvided: 'Budget Provided (HO)', cContract: 'Kontrak Anggaran',
      cPelimpahan: 'Pelimpahan (Organisasi)', cPelimpahanPh: 'mis. District Balikpapan', cNominal: 'Nominal',
      cRelease: 'Rilis Budget', cBudgetRp: 'Budget (Rp)', cRegionalDistrict: 'Regional / District', cTicket: 'Jumlah Tiket',
      cProgress: 'Progres', cNamaProgram: 'Nama Program', cJenisQe: 'Jenis QE',
      fYear: 'Tahun', fArea: 'Area', fRegional: 'Regional', fDistrict: 'District', fMonth: 'Bulan', fStatus: 'Status',
      fAllScope: 'Semua Scope', fAllArea: 'Semua Area', fAll: 'Semua',
      active: 'Aktif', inactive: 'Non Aktif', show: 'Tampilkan', cancel: 'Batal', save2: 'Simpan',
      legendRealisasi: 'Terealisasi', legendAlokasi: 'Teralokasi', legendAvailable: 'Available',
      edit: 'Edit', deactivate: 'Nonaktifkan', activate: 'Aktifkan', of: 'dari', noData: 'Tidak ada data.',
      unitB: 'M', unitM: 'jt', unitK: 'rb', billable: 'Billable', nonBillable: 'Non-Billable',
      srcDistribution: 'Distribusi:', srcViewReleaseDetail: 'Lihat rincian pelimpahan',
      srcGeneralInfo: 'Informasi Umum', srcQeRealDetail: 'Rincian Realisasi QE',
      srcPlanned: 'Terencana', srcUnplanned: 'Tidak Terencana', srcFromTotalReal: 'dari total realisasi',
      srcShowMore: '▾ Lihat :count lainnya', srcHide: '▴ Sembunyikan', relDetailTitle: 'Rincian Pelimpahan',
      emptySrc: 'Belum ada data sumber anggaran.', close: 'Tutup',
      addContractTitle: 'Tambah Kontrak Anggaran', editContractTitle: 'Edit Kontrak Anggaran',
      addSourceTitle: 'Tambah Sumber Anggaran', editSourceTitle: 'Edit Sumber Anggaran',
      addProgramTitle: 'Tambah Program', editProgramTitle: 'Edit Program',
      toastSaved: 'Perubahan berhasil disimpan.', toastDeactivated: 'berhasil dinonaktifkan.', toastActivated: 'berhasil diaktifkan.',
      total: 'Total',
    },
    en: {
      pageTitle: 'Budget', tabContract: 'Budget Contracts', tabSource: 'Budget Sources', tabDistribution: 'Budget Distribution', tabProgram: 'Program',
      searchPh: 'Search...', btnAddContract: '+ Add Budget Contract', btnAddSource: '+ Add Budget Source',
      btnAddDist: '+ Add Distribution', btnAddProgram: '+ Add Program',
      cName: 'Name', cSource: 'Budget Source', cOrg: 'Organization', cPeriod: 'Period', cBudget: 'Total Budget',
      cDistributed: 'Distributed', cAlokasi: 'Allocation', cRealisasi: 'Realization', cAvailable: 'Available', cAction: 'Action',
      cStart: 'Start Period', cEnd: 'End Period', cBudgetProvided: 'Budget Provided (HO)', cContract: 'Budget Contract',
      cPelimpahan: 'Assignment (Organization)', cPelimpahanPh: 'e.g. District Balikpapan', cNominal: 'Amount',
      cRelease: 'Budget Release', cBudgetRp: 'Budget (Rp)', cRegionalDistrict: 'Regional / District', cTicket: 'Ticket Count',
      cProgress: 'Progress', cNamaProgram: 'Program Name', cJenisQe: 'QE Type',
      fYear: 'Year', fArea: 'Area', fRegional: 'Regional', fDistrict: 'District', fMonth: 'Month', fStatus: 'Status',
      fAllScope: 'All Scopes', fAllArea: 'All Areas', fAll: 'All',
      active: 'Active', inactive: 'Inactive', show: 'Show', cancel: 'Cancel', save2: 'Save',
      legendRealisasi: 'Realized', legendAlokasi: 'Allocated', legendAvailable: 'Available',
      edit: 'Edit', deactivate: 'Deactivate', activate: 'Activate', of: 'of', noData: 'No data.',
      unitB: 'B', unitM: 'M', unitK: 'K', billable: 'Billable', nonBillable: 'Non-Billable',
      srcDistribution: 'Distribution:', srcViewReleaseDetail: 'View delegation details',
      srcGeneralInfo: 'General Information', srcQeRealDetail: 'QE Realization Details',
      srcPlanned: 'Planned', srcUnplanned: 'Unplanned', srcFromTotalReal: 'of total realization',
      srcShowMore: '▾ View :count more', srcHide: '▴ Hide', relDetailTitle: 'Delegation Details',
      emptySrc: 'No budget source data yet.', close: 'Close',
      addContractTitle: 'Add Budget Contract', editContractTitle: 'Edit Budget Contract',
      addSourceTitle: 'Add Budget Source', editSourceTitle: 'Edit Budget Source',
      addProgramTitle: 'Add Program', editProgramTitle: 'Edit Program',
      toastSaved: 'Changes saved successfully.', toastDeactivated: 'deactivated successfully.', toastActivated: 'activated successfully.',
      total: 'Total',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy dataset ---------- */
  var SOURCES = [
    { id: 'src-1', name: 'OPEX QE 2026', scope: 'REGION', isBillable: true },
    { id: 'src-2', name: 'CAPEX Non-Billable 2026', scope: 'AREA', isBillable: false },
  ];
  var CONTRACTS = [
    { id: 'ct-1', name: 'Kontrak QE Kalimantan 2026', sourceId: 'src-1', org: 'KALIMANTAN', startMonth: '2026-01', endMonth: '2026-12', budgetProvided: 800000000, isActive: true },
    { id: 'ct-2', name: 'Kontrak QE Sulawesi 2026', sourceId: 'src-1', org: 'SULAWESI', startMonth: '2026-01', endMonth: '2026-12', budgetProvided: 350000000, isActive: true },
    { id: 'ct-3', name: 'Kontrak Non-Billable Nasional 2026', sourceId: 'src-2', org: 'PAMASUKA', startMonth: '2026-01', endMonth: '2026-12', budgetProvided: 150000000, isActive: true },
  ];
  var RELEASES = [
    { id: 'rl-1', contractId: 'ct-1', org: 'Unit QE Kaltimtara', budgetProvided: 300000000, distributed: 270000000, committed: 190000000, realisasi: 140000000, isActive: true,
      qeTypes: [
        { qeType: 'PREVENTIF', isPlanned: true, realisasi: 70000000, programs: [{ name: 'ODP Sehat', realisasi: 45000000 }, { name: 'ODC Sehat', realisasi: 25000000 }] },
        { qeType: 'KURATIF', isPlanned: true, realisasi: 40000000, programs: [] },
        { qeType: 'RECOVERY', isPlanned: false, realisasi: 20000000, programs: [] },
        { qeType: 'MAGU', isPlanned: false, realisasi: 10000000, programs: [] },
      ] },
    { id: 'rl-2', contractId: 'ct-1', org: 'Unit Mitra Balikpapan', budgetProvided: 200000000, distributed: 160000000, committed: 120000000, realisasi: 88000000, isActive: true,
      qeTypes: [
        { qeType: 'PREVENTIF', isPlanned: true, realisasi: 48000000, programs: [{ name: 'ODP Sehat', realisasi: 30000000 }, { name: 'Permanenisasi', realisasi: 18000000 }] },
        { qeType: 'KURATIF', isPlanned: true, realisasi: 28000000, programs: [] },
        { qeType: 'RELOKASI', isPlanned: true, realisasi: 12000000, programs: [] },
      ] },
    { id: 'rl-3', contractId: 'ct-1', org: 'Unit NE Samarinda', budgetProvided: 150000000, distributed: 120000000, committed: 95000000, realisasi: 61000000, isActive: true,
      qeTypes: [
        { qeType: 'PREVENTIF', isPlanned: true, realisasi: 33000000, programs: [{ name: 'ODC Sehat', realisasi: 33000000 }] },
        { qeType: 'KURATIF', isPlanned: true, realisasi: 20000000, programs: [] },
        { qeType: 'RECOVERY', isPlanned: false, realisasi: 8000000, programs: [] },
      ] },
    { id: 'rl-4', contractId: 'ct-1', org: 'District Balikpapan', budgetProvided: 90000000, distributed: 70000000, committed: 55000000, realisasi: 40000000, isActive: true,
      qeTypes: [
        { qeType: 'PREVENTIF', isPlanned: true, realisasi: 25000000, programs: [{ name: 'ODP Sehat', realisasi: 25000000 }] },
        { qeType: 'KURATIF', isPlanned: true, realisasi: 15000000, programs: [] },
      ] },
    { id: 'rl-5', contractId: 'ct-1', org: 'District Samarinda', budgetProvided: 60000000, distributed: 45000000, committed: 30000000, realisasi: 18000000, isActive: false,
      qeTypes: [
        { qeType: 'KURATIF', isPlanned: true, realisasi: 12000000, programs: [] },
        { qeType: 'NIQE', isPlanned: false, realisasi: 6000000, programs: [] },
      ] },
    { id: 'rl-6', contractId: 'ct-2', org: 'Unit QE Sulsel', budgetProvided: 220000000, distributed: 180000000, committed: 150000000, realisasi: 96000000, isActive: true,
      qeTypes: [
        { qeType: 'PREVENTIF', isPlanned: true, realisasi: 56000000, programs: [{ name: 'ODP Sehat', realisasi: 36000000 }, { name: 'ODC Sehat', realisasi: 20000000 }] },
        { qeType: 'KURATIF', isPlanned: true, realisasi: 25000000, programs: [] },
        { qeType: 'RECOVERY', isPlanned: false, realisasi: 15000000, programs: [] },
      ] },
    { id: 'rl-7', contractId: 'ct-2', org: 'District Makassar', budgetProvided: 130000000, distributed: 100000000, committed: 78000000, realisasi: 52000000, isActive: true,
      qeTypes: [
        { qeType: 'PREVENTIF', isPlanned: true, realisasi: 30000000, programs: [{ name: 'ODC Sehat', realisasi: 30000000 }] },
        { qeType: 'RELOKASI', isPlanned: true, realisasi: 14000000, programs: [] },
        { qeType: 'MAGU', isPlanned: false, realisasi: 8000000, programs: [] },
      ] },
    { id: 'rl-8', contractId: 'ct-3', org: 'Unit Anggaran PAMASUKA', budgetProvided: 150000000, distributed: 90000000, committed: 44000000, realisasi: 38000000, isActive: false,
      qeTypes: [
        { qeType: 'RECOVERY', isPlanned: false, realisasi: 30000000, programs: [] },
        { qeType: 'MAGU', isPlanned: false, realisasi: 8000000, programs: [] },
      ] },
  ];
  var DISTRICTS = { KALIMANTAN: ['District Balikpapan', 'District Samarinda'], SULAWESI: ['District Makassar'] };
  var DIST_DATA = [
    { district: 'District Balikpapan', regional: 'KALIMANTAN', tickets: 18, budget: 300000000, alokasi: 120000000, realisasi: 80000000,
      programs: [{ name: 'ODP Sehat', budget: 150000000, alokasi: 70000000, realisasi: 50000000 }, { name: 'ODC Sehat', budget: 100000000, alokasi: 40000000, realisasi: 25000000 }, { name: 'Permanenisasi', budget: 50000000, alokasi: 10000000, realisasi: 5000000 }] },
    { district: 'District Samarinda', regional: 'KALIMANTAN', tickets: 11, budget: 250000000, alokasi: 90000000, realisasi: 45000000,
      programs: [{ name: 'ODP Sehat', budget: 130000000, alokasi: 55000000, realisasi: 28000000 }, { name: 'ODC Sehat', budget: 80000000, alokasi: 25000000, realisasi: 12000000 }, { name: 'Permanenisasi', budget: 40000000, alokasi: 10000000, realisasi: 5000000 }] },
    { district: 'District Makassar', regional: 'SULAWESI', tickets: 14, budget: 350000000, alokasi: 150000000, realisasi: 90000000,
      programs: [{ name: 'ODP Sehat', budget: 200000000, alokasi: 100000000, realisasi: 60000000 }, { name: 'ODC Sehat', budget: 100000000, alokasi: 40000000, realisasi: 25000000 }, { name: 'Permanenisasi', budget: 50000000, alokasi: 10000000, realisasi: 5000000 }] },
  ];
  var PROGRAMS = [
    { id: 'pg-1', name: 'ODP Sehat', qeType: 'PREVENTIF', sourceId: 'src-1', isActive: true },
    { id: 'pg-2', name: 'ODC Sehat', qeType: 'PREVENTIF', sourceId: 'src-1', isActive: true },
    { id: 'pg-3', name: 'Permanenisasi', qeType: 'RELOKASI', sourceId: 'src-1', isActive: true },
    { id: 'pg-4', name: 'Recovery Storm', qeType: 'RELOKASI', sourceId: 'src-2', isActive: false },
  ];
  var QE_TYPE_TONE = { PREVENTIF: 'blue', KURATIF: 'green', RELOKASI: 'gray', NIQE: 'purple', RECOVERY: 'red', MAGU: 'amber' };
  /* same palette the real app uses for the QE stacked bar (QE_COLORS) */
  var QE_COLORS = { RECOVERY: '#f87171', MAGU: '#fb923c', PREVENTIF: '#3b82f6', KURATIF: '#34d399', RELOKASI: '#9ca3af', NIQE: '#c084fc' };
  var SCOPE_TONE = { AREA: 'purple', REGION: 'blue', DISTRICT: 'teal' };
  var MONTHS_ID = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  var MONTHS_EN = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  function fmtRp(n){ return 'Rp ' + n.toLocaleString('id-ID'); }
  /* compact currency, mirrors the real shortRp(): Rp 1,2 M / Rp 300 jt / Rp 50 rb */
  function shortRp(n){
    if (!n && n !== 0) { return 'Rp 0'; }
    var loc = LANG === 'en' ? 'en-US' : 'id-ID', abs = Math.abs(n);
    if (abs >= 1e9) { return 'Rp ' + (n / 1e9).toLocaleString(loc, { maximumFractionDigits: 1 }) + t('unitB'); }
    if (abs >= 1e6) { return 'Rp ' + (n / 1e6).toLocaleString(loc, { maximumFractionDigits: 1 }) + t('unitM'); }
    if (abs >= 1e3) { return 'Rp ' + Math.round(n / 1e3).toLocaleString(loc) + t('unitK'); }
    return 'Rp ' + Math.round(n).toLocaleString(loc);
  }
  function pct(v, total){ return total > 0 ? Math.round(Math.min(100, Math.max(0, (v / total) * 100))) : 0; }
  function barPct(v, total){ return total > 0 ? Math.min(100, Math.max(0, (v / total) * 100)).toFixed(1) + '%' : '0%'; }
  function monthLabel(ym){
    var parts = (ym || '').split('-'), names = LANG === 'en' ? MONTHS_EN : MONTHS_ID;
    return parts.length === 2 ? names[parseInt(parts[1], 10) - 1] : ym;
  }
  function dateRange(start, end){
    var ys = start.split('-')[0], ye = end.split('-')[0];
    return ys === ye ? monthLabel(start) + '–' + monthLabel(end) + ' ' + ys : monthLabel(start) + ' ' + ys + '–' + monthLabel(end) + ' ' + ye;
  }
  function sourceOf(id){ return SOURCES.filter(function(x){ return x.id === id; })[0]; }
  function sourceName(id){ var s = sourceOf(id); return s ? s.name : '-'; }
  function contractName(id){ var c = CONTRACTS.filter(function(x){ return x.id === id; })[0]; return c ? c.name : '-'; }
  function releasesOf(contractId){ return RELEASES.filter(function(r){ return r.contractId === contractId; }); }

  /* ---------- tabs ---------- */
  document.querySelectorAll('#tabNav [data-tab]').forEach(function(btn){
    btn.addEventListener('click', function(){
      document.querySelectorAll('#tabNav [data-tab]').forEach(function(b){ b.classList.remove('on'); });
      btn.classList.add('on');
      ['contract', 'source', 'distribution', 'program'].forEach(function(k){
        document.getElementById('tab' + k.charAt(0).toUpperCase() + k.slice(1) + 'Pane').hidden = k !== btn.dataset.tab;
      });
    });
  });

  /* ---------- KONTRAK tab ---------- */
  function renderContracts(){
    var q = document.getElementById('contractSearch').value.trim().toLowerCase();
    var rows = CONTRACTS.filter(function(c){ return !q || c.name.toLowerCase().indexOf(q) !== -1; });
    document.getElementById('contractBody').innerHTML = rows.length ? rows.map(function(c, i){
      var rels = releasesOf(c.id);
      var distributed = rels.reduce(function(a, r){ return a + r.budgetProvided; }, 0);
      var alokasi = rels.reduce(function(a, r){ return a + r.committed; }, 0);
      var realisasi = rels.reduce(function(a, r){ return a + r.realisasi; }, 0);
      var available = c.budgetProvided - distributed;
      var src = sourceOf(c.sourceId);
      return '<tr><td>' + (i + 1) + '</td><td>' + c.name + ' <span class="pill pill-sq ' + (c.isActive ? 'pill-green' : 'pill-gray') + '">' + t(c.isActive ? 'active' : 'inactive') + '</span>' +
        (src && src.isBillable ? ' <span class="pill pill-sq pill-teal">' + t('billable') + '</span>' : ' <span class="pill pill-sq pill-gray">' + t('nonBillable') + '</span>') + '</td>' +
        '<td>' + sourceName(c.sourceId) + ' <span class="pill pill-sq pill-' + ((src && SCOPE_TONE[src.scope]) || 'gray') + '">' + (src ? src.scope : '-') + '</span></td>' +
        '<td>' + c.org + '</td><td>' + dateRange(c.startMonth, c.endMonth) + '</td>' +
        '<td>' + fmtRp(c.budgetProvided) + '</td><td>' + fmtRp(distributed) + '</td>' +
        '<td style="color:#1570ef">' + fmtRp(alokasi) + '</td><td style="color:#12b76a">' + fmtRp(realisasi) + '</td>' +
        '<td style="color:' + (available < 0 ? 'var(--error-500)' : 'inherit') + '">' + fmtRp(available) + '</td>' +
        '<td><div class="row-actions"><button class="mini-btn brand" data-edit-contract="' + c.id + '">' + t('edit') + '</button>' +
          '<button class="mini-btn ' + (c.isActive ? 'red' : 'teal') + '" data-toggle-contract="' + c.id + '">' + t(c.isActive ? 'deactivate' : 'activate') + '</button></div></td></tr>';
    }).join('') : '<tr><td colspan="11" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';

    var tB = rows.reduce(function(a, c){ return a + c.budgetProvided; }, 0);
    var tD = rows.reduce(function(a, c){ return a + releasesOf(c.id).reduce(function(a2, r){ return a2 + r.budgetProvided; }, 0); }, 0);
    var tR = rows.reduce(function(a, c){ return a + releasesOf(c.id).reduce(function(a2, r){ return a2 + r.realisasi; }, 0); }, 0);
    document.getElementById('contractTotals').innerHTML = '<td colspan="5">' + t('total') + ' (' + rows.length + ')</td><td>' + fmtRp(tB) + '</td><td>' + fmtRp(tD) + '</td><td>-</td><td>' + fmtRp(tR) + '</td><td>-</td><td>-</td>';
  }
  document.getElementById('contractSearch').addEventListener('input', renderContracts);

  var contractModal = document.getElementById('contractModal'), editingContractId = null;
  function fillSourceSelect(sel){ sel.innerHTML = SOURCES.map(function(s){ return '<option value="' + s.id + '">' + s.name + '</option>'; }).join(''); }
  document.getElementById('addContractBtn').addEventListener('click', function(){
    editingContractId = null;
    document.getElementById('contractModalTitle').textContent = t('addContractTitle');
    fillSourceSelect(document.getElementById('cfSource'));
    document.getElementById('cfName').value = ''; document.getElementById('cfOrg').value = 'PAMASUKA';
    document.getElementById('cfStart').value = '2026-01'; document.getElementById('cfEnd').value = '2026-12'; document.getElementById('cfBudget').value = '';
    contractModal.classList.add('show');
  });
  document.getElementById('contractBody').addEventListener('click', function(e){
    var ed = e.target.closest('[data-edit-contract]');
    if (ed) {
      var c = CONTRACTS.filter(function(x){ return x.id === ed.dataset.editContract; })[0];
      editingContractId = c.id;
      document.getElementById('contractModalTitle').textContent = t('editContractTitle');
      fillSourceSelect(document.getElementById('cfSource'));
      document.getElementById('cfName').value = c.name; document.getElementById('cfSource').value = c.sourceId; document.getElementById('cfOrg').value = c.org;
      document.getElementById('cfStart').value = c.startMonth; document.getElementById('cfEnd').value = c.endMonth; document.getElementById('cfBudget').value = c.budgetProvided;
      contractModal.classList.add('show');
      return;
    }
    var tg = e.target.closest('[data-toggle-contract]');
    if (tg) {
      var c2 = CONTRACTS.filter(function(x){ return x.id === tg.dataset.toggleContract; })[0];
      c2.isActive = !c2.isActive;
      toast(c2.name + ' ' + t(c2.isActive ? 'toastActivated' : 'toastDeactivated'));
      renderContracts();
    }
  });
  document.getElementById('contractSave').addEventListener('click', function(){
    var data = { name: document.getElementById('cfName').value.trim() || 'Kontrak Baru', sourceId: document.getElementById('cfSource').value,
      org: document.getElementById('cfOrg').value, startMonth: document.getElementById('cfStart').value, endMonth: document.getElementById('cfEnd').value,
      budgetProvided: parseInt(document.getElementById('cfBudget').value, 10) || 0 };
    if (editingContractId) { Object.assign(CONTRACTS.filter(function(x){ return x.id === editingContractId; })[0], data); }
    else { CONTRACTS.push(Object.assign({ id: 'ct-' + Date.now(), isActive: true }, data)); }
    contractModal.classList.remove('show');
    toast(t('toastSaved'));
    renderContracts();
  });
  document.getElementById('contractCancel').addEventListener('click', function(){ contractModal.classList.remove('show'); });
  document.getElementById('contractX').addEventListener('click', function(){ contractModal.classList.remove('show'); });

  /* ---------- SUMBER ANGGARAN tab ---------- */
  var srcStatus = '', expandedRows = {}, expandedCards = {}, expandedFooters = {};

  function seg3Html(realisasi, committed, available, total){
    return '<div class="seg3">' +
      '<div class="realisasi" style="width:' + barPct(realisasi, total) + '"></div>' +
      '<div class="alokasi" style="width:' + barPct(Math.max(0, committed - realisasi), total) + '"></div>' +
      '<div class="avail" style="width:' + barPct(available, total) + '"></div></div>';
  }
  function barNote(realisasi, committed, available){
    return '<div class="bar-note">' + t('legendRealisasi') + ': ' + shortRp(realisasi) + ' · ' +
      t('cAlokasi') + ': ' + shortRp(committed) + ' · ' + t('cAvailable') + ': ' + shortRp(available) + '</div>';
  }

  function qeTypesHtml(r){
    var totalReal = r.realisasi || r.qeTypes.reduce(function(a, q){ return a + q.realisasi; }, 0);
    var types = r.qeTypes.map(function(q){
      var programs = q.programs.length
        ? '<div class="prog-box">' + q.programs.map(function(p){
            return '<div class="prog-line"><span class="bullet"></span><span class="nm">' + p.name + '</span>' +
              '<span style="font-weight:700">' + shortRp(p.realisasi) + '</span>' +
              '<span class="mini-pct" style="background:#eff6ff;color:#1d4ed8">' + pct(p.realisasi, totalReal) + '%</span></div>';
          }).join('') + '</div>'
        : '';
      return '<div class="qt-row"><div class="qt-top">' +
        '<div><div class="qt-name">' + q.qeType + '</div>' +
          '<span class="pill pill-sq ' + (q.isPlanned ? 'pill-green' : 'pill-gray') + '" style="margin-top:4px;display:inline-block">' +
            t(q.isPlanned ? 'srcPlanned' : 'srcUnplanned') + '</span></div>' +
        '<div><div class="qt-amt">' + shortRp(q.realisasi) + '</div>' +
          '<div class="qt-sub"><span class="mini-pct" style="background:#eff6ff;color:#1d4ed8">' + pct(q.realisasi, totalReal) + '%</span> ' + t('srcFromTotalReal') + '</div></div>' +
        '</div>' + programs + '</div>';
    }).join('');
    var stacked = '<div class="qt-bar">' + r.qeTypes.map(function(q){
      return '<div style="width:' + pct(q.realisasi, totalReal) + '%;background:' + (QE_COLORS[q.qeType] || '#d0d5dd') + '"></div>';
    }).join('') + '</div>';
    var legend = '<div class="qt-legend">' + r.qeTypes.map(function(q){
      return '<span><i style="background:' + (QE_COLORS[q.qeType] || '#d0d5dd') + '"></i>' + q.qeType + '</span>';
    }).join('') + '</div>';
    return types + stacked + legend;
  }

  function releaseDetailHtml(r){
    var available = Math.max(0, r.budgetProvided - r.committed);
    return '<div class="release-detail">' +
      '<div class="info-box"><div class="hd"><span class="ico-sq" style="background:#dbeafe;color:#2563eb">i</span>' + t('srcGeneralInfo') + '</div>' +
        '<div class="info-grid">' +
          '<div><div class="k">' + t('cBudget') + '</div><div class="v">' + shortRp(r.budgetProvided) + '</div></div>' +
          '<div><div class="k">' + t('legendRealisasi') + ' <span class="mini-pct" style="background:#d1fadf;color:#027a48">' + pct(r.realisasi, r.budgetProvided) + '%</span></div><div class="v">' + shortRp(r.realisasi) + '</div></div>' +
          '<div><div class="k">' + t('cAlokasi') + ' <span class="mini-pct" style="background:#dbeafe;color:#1d4ed8">' + pct(r.committed, r.budgetProvided) + '%</span></div><div class="v">' + shortRp(r.committed) + '</div></div>' +
          '<div><div class="k">' + t('cAvailable') + ' <span class="mini-pct" style="background:var(--gray-100);color:var(--gray-500)">' + pct(available, r.budgetProvided) + '%</span></div><div class="v">' + shortRp(available) + '</div></div>' +
        '</div></div>' +
      '<div class="sect-hd"><span class="ico-sq" style="background:var(--gray-100);color:var(--gray-500)">≡</span>' + t('srcQeRealDetail') + '</div>' +
      qeTypesHtml(r) +
    '</div>';
  }

  function releaseRowHtml(r){
    var available = Math.max(0, r.budgetProvided - r.committed);
    var open = !!expandedRows[r.id];
    return '<div class="release-row' + (open ? ' open' : '') + '">' +
        '<div class="release-head">' +
          '<div><div class="org">' + r.org + '</div><div class="amt">' + shortRp(r.budgetProvided) + '</div></div>' +
          '<div style="display:flex;align-items:center;gap:6px;flex-shrink:0">' +
            '<span class="dist-pill" title="' + t('cDistributed') + ': ' + shortRp(r.distributed) + '">' + t('srcDistribution') + ' ' + pct(r.distributed, r.budgetProvided) + '%</span>' +
            '<button class="icon-btn" data-row-toggle="' + r.id + '" title="' + t('cAction') + '">' + (open ? '▴' : '▾') + '</button>' +
          '</div>' +
        '</div>' +
        '<div style="margin-top:8px">' + seg3Html(r.realisasi, r.committed, available, r.budgetProvided) + '</div>' +
        barNote(r.realisasi, r.committed, available) +
      '</div>' + (open ? releaseDetailHtml(r) : '');
  }

  function renderSources(){
    var area = document.getElementById('srcArea').value, scope = document.getElementById('srcScope').value;
    var cards = CONTRACTS.filter(function(c){
      var src = sourceOf(c.sourceId);
      return (!area || c.org === area) && (!scope || (src && src.scope === scope));
    }).map(function(c){
      var rels = releasesOf(c.id).filter(function(r){ return !srcStatus || (srcStatus === 'active' ? r.isActive : !r.isActive); });
      if (!rels.length) { return ''; }
      var totalBudget = rels.reduce(function(a, r){ return a + r.budgetProvided; }, 0);
      var totalCommitted = rels.reduce(function(a, r){ return a + r.committed; }, 0);
      var totalRealisasi = rels.reduce(function(a, r){ return a + r.realisasi; }, 0);
      var totalAvail = Math.max(0, totalBudget - totalCommitted);
      var shown = expandedCards[c.id] ? rels : rels.slice(0, 3);
      var footOpen = !!expandedFooters[c.id];
      return '<div class="src-card">' +
        '<div class="src-card-head">' +
          '<div class="top"><h4>' + c.name + '</h4>' +
            '<span class="pill pill-sq ' + (c.isActive ? 'pill-green' : 'pill-gray') + '">' + (c.isActive ? '✓ ' : '') + t(c.isActive ? 'active' : 'inactive') + '</span>' +
            (rels.length > 1 ? '<button class="icon-btn" data-rel-detail="' + c.id + '" title="' + t('srcViewReleaseDetail') + '">i</button>' : '') +
            '<button class="icon-btn" data-edit-release="' + rels[0].id + '" title="' + t('edit') + '">✎</button>' +
            '<button class="icon-btn" data-toggle-contract2="' + c.id + '" title="' + t(c.isActive ? 'deactivate' : 'activate') + '">⏻</button>' +
          '</div>' +
          '<div class="meta">' + sourceName(c.sourceId) + ' · ' + c.org + ' · ' + dateRange(c.startMonth, c.endMonth) + '</div>' +
        '</div>' +
        shown.map(releaseRowHtml).join('') +
        (rels.length > 3 ? '<div class="show-more"><button data-card-toggle="' + c.id + '">' +
          (expandedCards[c.id] ? t('srcHide') : t('srcShowMore').replace(':count', rels.length - 3)) + '</button></div>' : '') +
        '<div class="src-card-foot">' +
          '<div class="foot-top"><span class="lbl">' + t('total') + ' <span style="font-weight:400;color:var(--muted)">– ' + c.org + '</span></span>' +
            '<span class="amt">' + shortRp(totalBudget) + '</span>' +
            '<button class="icon-btn" data-foot-toggle="' + c.id + '">' + (footOpen ? '▴' : '▾') + '</button></div>' +
          '<div style="margin-top:8px">' + seg3Html(totalRealisasi, totalCommitted, totalAvail, totalBudget) + '</div>' +
          barNote(totalRealisasi, totalCommitted, totalAvail) +
          '<div class="foot-break' + (footOpen ? ' open' : '') + '">' +
            '<div class="ln"><span style="color:var(--muted)">' + t('cAlokasi') + '</span><span class="val" style="color:#1570ef">' + shortRp(totalCommitted) + '</span></div>' +
            '<div class="ln"><span style="color:var(--muted)">' + t('legendRealisasi') + '</span><span class="val" style="color:#12b76a">' + shortRp(totalRealisasi) + '</span></div>' +
            '<div class="ln"><span style="color:var(--muted)">' + t('cAvailable') + '</span><span class="val">' + shortRp(totalAvail) + '</span></div>' +
          '</div>' +
        '</div>' +
      '</div>';
    }).join('');
    document.getElementById('sourceCards').innerHTML = cards ||
      '<div style="width:100%;padding:44px;text-align:center;color:var(--muted);border:1px dashed var(--border);border-radius:14px">' + t('emptySrc') + '</div>';
  }

  document.getElementById('sourceCards').addEventListener('click', function(e){
    var rowT = e.target.closest('[data-row-toggle]');
    if (rowT) { var id = rowT.dataset.rowToggle; expandedRows[id] = !expandedRows[id]; renderSources(); return; }
    var cardT = e.target.closest('[data-card-toggle]');
    if (cardT) { var cid = cardT.dataset.cardToggle; expandedCards[cid] = !expandedCards[cid]; renderSources(); return; }
    var footT = e.target.closest('[data-foot-toggle]');
    if (footT) { var fid = footT.dataset.footToggle; expandedFooters[fid] = !expandedFooters[fid]; renderSources(); return; }
    var relD = e.target.closest('[data-rel-detail]');
    if (relD) { openReleaseDetail(relD.dataset.relDetail); return; }
    var ed = e.target.closest('[data-edit-release]');
    if (ed) { openSourceDialog(ed.dataset.editRelease); return; }
    var tg = e.target.closest('[data-toggle-contract2]');
    if (tg) {
      var c = CONTRACTS.filter(function(x){ return x.id === tg.dataset.toggleContract2; })[0];
      c.isActive = !c.isActive;
      toast(c.name + ' ' + t(c.isActive ? 'toastActivated' : 'toastDeactivated'));
      renderSources(); renderContracts();
    }
  });
  ['srcYear', 'srcArea', 'srcScope'].forEach(function(id){ document.getElementById(id).addEventListener('change', renderSources); });
  document.getElementById('srcStatus').addEventListener('click', function(e){
    var b = e.target.closest('[data-status]');
    if (!b) { return; }
    srcStatus = b.dataset.status;
    document.querySelectorAll('#srcStatus button').forEach(function(x){ x.classList.toggle('on', x === b); });
    renderSources();
  });

  /* release detail dialog */
  var relDetailModal = document.getElementById('relDetailModal');
  function openReleaseDetail(contractId){
    var c = CONTRACTS.filter(function(x){ return x.id === contractId; })[0];
    document.getElementById('relDetailSub').textContent = c.name + ' · ' + sourceName(c.sourceId);
    document.getElementById('relDetailBody').innerHTML = releasesOf(contractId).map(function(r){
      return '<tr><td>' + r.org + '</td><td>' + fmtRp(r.budgetProvided) + '</td><td>' + fmtRp(r.distributed) + '</td>' +
        '<td style="color:#1570ef">' + fmtRp(r.committed) + '</td><td style="color:#12b76a">' + fmtRp(r.realisasi) + '</td>' +
        '<td>' + fmtRp(Math.max(0, r.budgetProvided - r.committed)) + '</td></tr>';
    }).join('');
    relDetailModal.classList.add('show');
  }
  document.getElementById('relDetailX').addEventListener('click', function(){ relDetailModal.classList.remove('show'); });
  document.getElementById('relDetailDone').addEventListener('click', function(){ relDetailModal.classList.remove('show'); });

  var sourceModal = document.getElementById('sourceModal'), editingReleaseId = null;
  /* org units available for pelimpahan — same names used on Master Data › Organisasi */
  var ORG_UNITS = ['Unit QE Kaltimtara', 'Unit Mitra Balikpapan', 'Unit NE Samarinda', 'Unit QE Sulsel',
    'Unit Anggaran PAMASUKA', 'District Balikpapan', 'District Samarinda', 'District Makassar'];
  function fillContractSelect(sel){ sel.innerHTML = CONTRACTS.map(function(c){ return '<option value="' + c.id + '">' + c.name + '</option>'; }).join(''); }
  function fillOrgSelect(sel){ sel.innerHTML = ORG_UNITS.map(function(o){ return '<option>' + o + '</option>'; }).join(''); }
  document.getElementById('addSourceBtn').addEventListener('click', function(){
    editingReleaseId = null;
    document.getElementById('sourceModalTitle').textContent = t('addSourceTitle');
    fillContractSelect(document.getElementById('sfContract'));
    fillOrgSelect(document.getElementById('sfOrg'));
    document.getElementById('sfBudget').value = '';
    sourceModal.classList.add('show');
  });
  function openSourceDialog(id){
    var r = RELEASES.filter(function(x){ return x.id === id; })[0];
    editingReleaseId = id;
    document.getElementById('sourceModalTitle').textContent = t('editSourceTitle');
    fillContractSelect(document.getElementById('sfContract'));
    fillOrgSelect(document.getElementById('sfOrg'));
    document.getElementById('sfContract').value = r.contractId; document.getElementById('sfOrg').value = r.org; document.getElementById('sfBudget').value = r.budgetProvided;
    sourceModal.classList.add('show');
  }
  document.getElementById('sourceSave').addEventListener('click', function(){
    var data = { contractId: document.getElementById('sfContract').value, org: document.getElementById('sfOrg').value,
      budgetProvided: parseInt(document.getElementById('sfBudget').value, 10) || 0 };
    if (editingReleaseId) { Object.assign(RELEASES.filter(function(x){ return x.id === editingReleaseId; })[0], data); }
    else { RELEASES.push(Object.assign({ id: 'rl-' + Date.now(), isActive: true, distributed: 0, committed: 0, realisasi: 0, qeTypes: [] }, data)); }
    sourceModal.classList.remove('show');
    toast(t('toastSaved'));
    renderSources(); renderContracts();
  });
  document.getElementById('sourceCancel').addEventListener('click', function(){ sourceModal.classList.remove('show'); });
  document.getElementById('sourceX').addEventListener('click', function(){ sourceModal.classList.remove('show'); });

  /* ---------- DISTRIBUSI tab (tree) ---------- */
  var distExpanded = {}, distById = {};
  function distFilterArea(){ return document.getElementById('distArea').value; }
  function buildDistTree(){
    var area = distFilterArea();
    var rows = [];
    Object.keys(DISTRICTS).forEach(function(reg){
      if (area && area !== reg) { return; }
      var regDistricts = DIST_DATA.filter(function(d){ return d.regional === reg; });
      var rid = 'r-' + reg;
      var agg = regDistricts.reduce(function(a, d){ a.tickets += d.tickets; a.budget += d.budget; a.alokasi += d.alokasi; a.realisasi += d.realisasi; return a; }, { tickets: 0, budget: 0, alokasi: 0, realisasi: 0 });
      rows.push({ id: rid, label: reg, parentId: null, hasChildren: true, data: agg });
      regDistricts.forEach(function(d){
        var did = 'd-' + d.district;
        rows.push({ id: did, label: d.district, parentId: rid, hasChildren: true, data: d });
        d.programs.forEach(function(p, i){
          rows.push({ id: did + '-p' + i, label: p.name, parentId: did, hasChildren: false, data: p, isProgram: true });
        });
      });
    });
    return rows;
  }
  function isDistVisible(row){
    var p = row.parentId;
    while (p) { if (!distExpanded[p]) { return false; } p = distById[p].parentId; }
    return true;
  }
  function distDepth(row){ var d = 0, p = row.parentId; while (p) { d++; p = distById[p].parentId; } return d; }
  function progressBarHtml(alokasi, realisasi, budget){
    var pctR = budget ? Math.min(100, Math.round((realisasi / budget) * 100)) : 0;
    return '<div class="prog-mini"><div class="f" style="width:' + pctR + '%"></div></div> ' + pctR + '%';
  }
  function renderDistTree(){
    var rows = buildDistTree();
    distById = {}; rows.forEach(function(r){ distById[r.id] = r; });
    var visible = rows.filter(isDistVisible);
    document.getElementById('distBody').innerHTML = visible.length ? visible.map(function(r){
      var depth = distDepth(r);
      var chev = r.hasChildren ? '<button type="button" class="tree-chev' + (distExpanded[r.id] ? ' open' : '') + '" data-dist-toggle="' + r.id + '">▶</button>' : '<span style="width:18px;display:inline-block"></span>';
      var available = Math.max(0, r.data.budget - r.data.alokasi);
      return '<tr><td><div class="tree-label" style="padding-left:' + (depth * 20) + 'px">' + chev + r.label + '</div></td>' +
        '<td>' + (r.isProgram ? '-' : r.data.tickets) + '</td><td>' + fmtRp(r.data.budget) + '</td>' +
        '<td>' + progressBarHtml(r.data.alokasi, r.data.realisasi, r.data.budget) + '</td>' +
        '<td style="color:#1570ef">' + fmtRp(r.data.alokasi) + '</td><td style="color:#12b76a">' + fmtRp(r.data.realisasi) + '</td><td>' + fmtRp(available) + '</td></tr>';
    }).join('') : '<tr><td colspan="7" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';

    var topRows = rows.filter(function(r){ return r.parentId === null; });
    var totals = topRows.reduce(function(a, r){ a.budget += r.data.budget; a.alokasi += r.data.alokasi; a.realisasi += r.data.realisasi; a.tickets += r.data.tickets; return a; }, { budget: 0, alokasi: 0, realisasi: 0, tickets: 0 });
    document.getElementById('distStatBudget').textContent = fmtRp(totals.budget);
    document.getElementById('distStatAlokasi').textContent = fmtRp(totals.alokasi);
    document.getElementById('distStatRealisasi').textContent = fmtRp(totals.realisasi);
    document.getElementById('distStatAvailable').textContent = fmtRp(Math.max(0, totals.budget - totals.alokasi));
  }
  document.getElementById('distBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-dist-toggle]');
    if (b) { distExpanded[b.dataset.distToggle] = !distExpanded[b.dataset.distToggle]; renderDistTree(); }
  });
  document.getElementById('distShowBtn').addEventListener('click', renderDistTree);
  document.getElementById('distArea').addEventListener('change', renderDistTree);

  var distModal = document.getElementById('distModal');
  function fillReleaseSelect(sel){ sel.innerHTML = RELEASES.map(function(r){ return '<option value="' + r.id + '">' + contractName(r.contractId) + ' — ' + r.org + '</option>'; }).join(''); }
  function fillDfDistrict(){
    var reg = document.getElementById('dfRegional').value;
    document.getElementById('dfDistrict').innerHTML = (DISTRICTS[reg] || []).map(function(d){ return '<option>' + d + '</option>'; }).join('');
  }
  document.getElementById('dfRegional').addEventListener('change', fillDfDistrict);
  document.getElementById('addDistBtn').addEventListener('click', function(){
    fillReleaseSelect(document.getElementById('dfRelease'));
    document.getElementById('dfRegional').value = 'KALIMANTAN'; fillDfDistrict();
    document.getElementById('dfBudget').value = '';
    distModal.classList.add('show');
  });
  document.getElementById('distSave').addEventListener('click', function(){
    var district = document.getElementById('dfDistrict').value, regional = document.getElementById('dfRegional').value;
    var budget = parseInt(document.getElementById('dfBudget').value, 10) || 0;
    var row = DIST_DATA.filter(function(d){ return d.district === district; })[0];
    if (row) { row.budget += budget; }
    else { DIST_DATA.push({ district: district, regional: regional, tickets: 0, budget: budget, alokasi: 0, realisasi: 0, programs: [] }); }
    distModal.classList.remove('show');
    toast(t('toastSaved'));
    renderDistTree();
  });
  document.getElementById('distCancel').addEventListener('click', function(){ distModal.classList.remove('show'); });
  document.getElementById('distX').addEventListener('click', function(){ distModal.classList.remove('show'); });

  /* ---------- PROGRAM tab ---------- */
  function renderPrograms(){
    var q = document.getElementById('programSearch').value.trim().toLowerCase();
    var rows = PROGRAMS.filter(function(p){ return !q || p.name.toLowerCase().indexOf(q) !== -1; });
    document.getElementById('programBody').innerHTML = rows.length ? rows.map(function(p){
      return '<tr><td>' + p.name + '</td><td><span class="pill pill-sq pill-' + (QE_TYPE_TONE[p.qeType] || 'gray') + '">' + p.qeType + '</span></td>' +
        '<td>' + sourceName(p.sourceId) + '</td><td><span class="pill pill-sq ' + (p.isActive ? 'pill-green' : 'pill-gray') + '">' + t(p.isActive ? 'active' : 'inactive') + '</span></td>' +
        '<td><button class="mini-btn brand" data-edit-program="' + p.id + '">' + t('edit') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="5" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';
  }
  document.getElementById('programSearch').addEventListener('input', renderPrograms);

  var programModal = document.getElementById('programModal'), editingProgramId = null;
  document.getElementById('addProgramBtn').addEventListener('click', function(){
    editingProgramId = null;
    document.getElementById('programModalTitle').textContent = t('addProgramTitle');
    fillSourceSelect(document.getElementById('pfSource'));
    document.getElementById('pfName').value = ''; document.getElementById('pfType').value = 'PREVENTIF'; document.getElementById('pfStatus').value = '1';
    programModal.classList.add('show');
  });
  document.getElementById('programBody').addEventListener('click', function(e){
    var ed = e.target.closest('[data-edit-program]');
    if (!ed) { return; }
    var p = PROGRAMS.filter(function(x){ return x.id === ed.dataset.editProgram; })[0];
    editingProgramId = p.id;
    document.getElementById('programModalTitle').textContent = t('editProgramTitle');
    fillSourceSelect(document.getElementById('pfSource'));
    document.getElementById('pfName').value = p.name; document.getElementById('pfType').value = p.qeType; document.getElementById('pfSource').value = p.sourceId; document.getElementById('pfStatus').value = p.isActive ? '1' : '0';
    programModal.classList.add('show');
  });
  document.getElementById('programSave').addEventListener('click', function(){
    var data = { name: document.getElementById('pfName').value.trim() || 'Program Baru', qeType: document.getElementById('pfType').value, sourceId: document.getElementById('pfSource').value, isActive: document.getElementById('pfStatus').value === '1' };
    if (editingProgramId) { Object.assign(PROGRAMS.filter(function(x){ return x.id === editingProgramId; })[0], data); }
    else { PROGRAMS.push(Object.assign({ id: 'pg-' + Date.now() }, data)); }
    programModal.classList.remove('show');
    toast(t('toastSaved'));
    renderPrograms();
  });
  document.getElementById('programCancel').addEventListener('click', function(){ programModal.classList.remove('show'); });
  document.getElementById('programX').addEventListener('click', function(){ programModal.classList.remove('show'); });

  function onLangChange(){ renderContracts(); renderSources(); renderDistTree(); renderPrograms(); }
  renderContracts(); renderSources(); renderDistTree(); renderPrograms();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeBudgetTour = {
    id: 'tifreg-qe-budget',
    steps: [
      {
        target: '#tabNav',
        pos: 'bottom',
        title: { id: '4 Pilar Manajemen Anggaran QE', en: '4 QE Budget Management Pillars' },
        desc: {
          id: 'Kelola siklus pendanaan proyek QE melalui 4 pilar: Kontrak Anggaran (master kontrak), Sumber Anggaran (kartu alokasi per rilis), Distribusi Anggaran (hierarki wilayah & program), dan Master Program.',
          en: 'Manage the entire QE financing lifecycle across 4 pillars: Budget Contracts, Budget Sources, Regional & Program Distribution, and Master Programs.'
        }
      },
      {
        target: '#contractToolbarRow',
        pos: 'bottom',
        title: { id: 'Pencarian & Penambahan Kontrak', en: 'Search & Add Budget Contract' },
        desc: {
          id: 'Gunakan input pencarian untuk menyaring nomor atau nama kontrak, atau klik <b>+ Tambah Kontrak Anggaran</b> untuk mendaftarkan kesepakatan dana baru.',
          en: 'Use the search box to filter contract numbers or names, or click <b>+ Tambah Kontrak Anggaran</b> to register a new funding agreement.'
        }
      },
      {
        target: '#contractTable thead',
        pos: 'bottom',
        title: { id: 'Tabel Rekapitulasi Kontrak', en: 'Contract Recapitulation Table' },
        desc: {
          id: 'Melacak nilai Total Budget, dana Terdistribusi, Alokasi komitmen lapangan, Realisasi yang telah dibayar, serta saldo Available.',
          en: 'Tracks Total Budget value, Distributed funds, committed Allocations, realized expenditures, and remaining Available balances.'
        }
      },
      {
        target: '#contractTotals',
        pos: 'top',
        title: { id: 'Total Akumulasi Seluruh Kontrak', en: 'All-Contract Cumulative Totals' },
        desc: {
          id: 'Menampilkan ringkasan total neraca keuangan seluruh kontrak aktif di regional, memastikan transparansi penyerapan dana QE.',
          en: 'Displays a cumulative summary of all active regional contracts, ensuring full transparency in QE fund absorption.'
        }
      },
      {
        target: '#tabNav button[data-tab="distribution"]',
        pos: 'bottom',
        title: { id: 'Distribusi Hierarki & Program', en: 'Hierarchical & Program Distribution' },
        desc: {
          id: 'Beralih ke tab <b>Distribusi Anggaran</b> untuk melihat visualisasi tree-table alokasi dana per Distrik hingga program pekerjaan spesifik.',
          en: 'Switch to the <b>Distribusi Anggaran</b> tab to inspect tree-table breakdowns across operational Districts and specific work programs.'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(qeBudgetTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
