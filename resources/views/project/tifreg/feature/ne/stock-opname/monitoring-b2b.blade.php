<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Monitoring B2B NTE — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.1/chart.umd.min.js"></script>
<style>
  .tree-scroll{overflow-x:auto}
  table.tree-table{white-space:nowrap}
  table.tree-table th, table.tree-table td{text-align:center}
  table.tree-table th:nth-child(1), table.tree-table td:nth-child(1){text-align:left}
  table.tree-table th:nth-child(1), table.tree-table td:nth-child(1){position:sticky;left:0;background:var(--panel-bg);z-index:1}
  table.tree-table thead th:nth-child(1){background:var(--gray-50);z-index:2}
  .tree-label{display:flex;align-items:center;gap:6px}
  .tree-chev{width:18px;height:18px;border:none;background:none;color:var(--muted);cursor:pointer;flex-shrink:0;
    display:inline-flex;align-items:center;justify-content:center;transition:transform .15s}
  .tree-chev.open{transform:rotate(90deg)}
  .tree-cell{background:none;border:none;font:inherit;color:var(--brand-600);font-weight:700;cursor:pointer}
  .tree-cell.zero{color:var(--muted);font-weight:400;cursor:default}
  tr.total-row td{font-weight:700;border-top:2px solid var(--border);background:var(--gray-50)}
  [data-theme="dark"] tr.total-row td{background:color-mix(in srgb,var(--gray-900) 60%,var(--panel-bg))}
  .cat-head{color:#0f2c1a;font-weight:700}
  .last-update{font-size:11.5px;color:var(--muted);margin-top:2px}
  .chip-row{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
  .chip{font-size:11.5px;font-weight:600;padding:5px 10px;border-radius:999px;background:var(--gray-50);color:var(--text);border:1px solid var(--border)}
  [data-theme="dark"] .chip{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .chart-wrap{position:relative;height:280px}
  .chart-actions{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'nte-b2b'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">NTE / Stock Opname</div>
    <h1 data-i18n="pageTitle">Monitoring B2B NTE</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field"><label data-i18n="fRegional">Regional</label><select id="fRegional"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option></select></div>
          <div class="field"><label data-i18n="fDistrict">District</label><select id="fDistrict"><option value="">Semua</option></select></div>
          <div class="field"><label data-i18n="fDate">Tanggal Stok</label><input type="date" id="fDate" value="2026-09-09" /></div>
        </div>
        <div class="row-actions" style="margin-top:2px">
          <button class="btn-primary" id="showBtn" data-i18n="show">Tampilkan</button>
          <button class="btn-outline" id="resetBtn" data-i18n="reset">Reset</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <div>
          <h3>ONT RETAIL</h3>
          <div class="last-update"><span data-i18n="lastUpdate">Update Terakhir</span>: 2026-09-09 07:12 WITA</div>
        </div>
        <button class="btn-outline" id="exportRetail" data-i18n="exportExcel">Export Excel</button>
      </div>
      <div class="tree-scroll">
        <table class="tree-table"><thead id="RETAILHead"></thead><tbody id="RETAILBody"></tbody></table>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3>ONT PREMIUM</h3>
        <button class="btn-outline" id="exportPremium" data-i18n="exportExcel">Export Excel</button>
      </div>
      <div class="tree-scroll">
        <table class="tree-table"><thead id="PREMIUMHead"></thead><tbody id="PREMIUMBody"></tbody></table>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="chartTitle">Grafik Monitoring B2B</h3>
        <select id="chartPeriod"><option value="daily" data-i18n="pDaily">Harian</option><option value="weekly" data-i18n="pWeekly">Mingguan</option><option value="monthly" data-i18n="pMonthly">Bulanan</option></select>
      </div>
      <div class="card-body">
        <b style="font-size:12.5px" data-i18n="chartRetail">Chart ONT Retail</b>
        <div class="chart-actions" style="margin-top:8px">
          <button class="btn-outline" id="chartShowAllRetail" data-i18n="showAll">Tampilkan Semua</button>
          <button class="btn-outline" id="chartHideAllRetail" data-i18n="hideAll">Sembunyikan Semua</button>
        </div>
        <div class="chart-wrap"><canvas id="chartRETAIL"></canvas></div>
        <b style="font-size:12.5px;margin-top:22px;display:block" data-i18n="chartPremium">Chart ONT Premium</b>
        <div class="chart-actions" style="margin-top:8px">
          <button class="btn-outline" id="chartShowAllPremium" data-i18n="showAll">Tampilkan Semua</button>
          <button class="btn-outline" id="chartHideAllPremium" data-i18n="hideAll">Sembunyikan Semua</button>
        </div>
        <div class="chart-wrap"><canvas id="chartPREMIUM"></canvas></div>
      </div>
    </div>
  </div>
</main>

<!-- DETAIL DIALOG -->
<div class="modal-backdrop" id="detailDialog">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 data-i18n="detailTitle">Detail Device Stock B2B</h3><button class="modal-close" id="detailClose">✕</button></div>
    <div class="modal-body">
      <div class="chip-row" id="detailChips"></div>
      <div class="table-toolbar" style="padding:0 0 12px">
        <select id="detailPerPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option><option value="50">50 / halaman</option></select>
        <input type="text" id="detailSearch" data-i18n-ph="searchPh" placeholder="Cari serial number..." />
        <button class="btn-outline" id="detailExport" data-i18n="exportExcel">Download Excel</button>
      </div>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th data-i18n="fSerial">Serial Number</th><th data-i18n="fDeviceType2">Device Type</th><th data-i18n="fMerk">Merk</th>
              <th data-i18n="fKategori">Kategori</th><th data-i18n="fReportTelkom">Report Telkom</th><th data-i18n="cStatus">Status</th>
              <th data-i18n="hWarehouse">Warehouse</th><th data-i18n="fTglInput">Tanggal Input</th><th data-i18n="fKeterangan">Keterangan</th>
            </tr>
          </thead>
          <tbody id="detailBody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="detailPageInfo"></span><div class="pager" id="detailPager"></div></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="detailDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Monitoring B2B NTE', lastUpdate: 'Update Terakhir',
      fRegional: 'Regional', fDistrict: 'District', fDate: 'Tanggal Stok', show: 'Tampilkan', reset: 'Reset',
      hRegional: 'Regional', hDistrict: 'District', hWarehouse: 'Warehouse', totalSemua: 'Total Semua',
      exportExcel: 'Export Excel', exportToast: 'Export dinonaktifkan pada tampilan demo.',
      stNew: 'NEW', stRefurb: 'REFURBISH',
      chartTitle: 'Grafik Monitoring B2B', chartRetail: 'Chart ONT Retail', chartPremium: 'Chart ONT Premium',
      pDaily: 'Harian', pWeekly: 'Mingguan', pMonthly: 'Bulanan', showAll: 'Tampilkan Semua', hideAll: 'Sembunyikan Semua',
      detailTitle: 'Detail Device Stock B2B', chipArea: 'Area: ', chipType: 'Type: ', chipColumn: 'Kolom: ', chipTotal: 'Total Item: ',
      searchPh: 'Cari serial number...', fSerial: 'Serial Number', fDeviceType2: 'Device Type', fMerk: 'Merk',
      fKategori: 'Kategori', fReportTelkom: 'Report Telkom', cStatus: 'Status', fTglInput: 'Tanggal Input', fKeterangan: 'Keterangan',
      of: 'dari', noData: 'Tidak ada data.', close: 'Tutup',
    },
    en: {
      pageTitle: 'NTE B2B Monitoring', lastUpdate: 'Last Update',
      fRegional: 'Regional', fDistrict: 'District', fDate: 'Stock Date', show: 'Show', reset: 'Reset',
      hRegional: 'Regional', hDistrict: 'District', hWarehouse: 'Warehouse', totalSemua: 'Total All',
      exportExcel: 'Export Excel', exportToast: 'Export is disabled in this demo view.',
      stNew: 'NEW', stRefurb: 'REFURBISH',
      chartTitle: 'B2B Monitoring Chart', chartRetail: 'Chart ONT Retail', chartPremium: 'Chart ONT Premium',
      pDaily: 'Daily', pWeekly: 'Weekly', pMonthly: 'Monthly', showAll: 'Show All', hideAll: 'Hide All',
      detailTitle: 'B2B Stock Device Detail', chipArea: 'Area: ', chipType: 'Type: ', chipColumn: 'Column: ', chipTotal: 'Total Items: ',
      searchPh: 'Search serial number...', fSerial: 'Serial Number', fDeviceType2: 'Device Type', fMerk: 'Brand',
      fKategori: 'Category', fReportTelkom: 'Report Telkom', cStatus: 'Status', fTglInput: 'Input Date', fKeterangan: 'Description',
      of: 'of', noData: 'No data.', close: 'Close',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy dataset ---------- */
  var REGIONALS = ['KALIMANTAN', 'SULAWESI'];
  var DISTRICTS = { KALIMANTAN: ['District Balikpapan', 'District Samarinda'], SULAWESI: ['District Makassar'] };
  var WAREHOUSES = [
    { id: 'wh-bpn-kota', name: 'Warehouse Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN' },
    { id: 'wh-kj', name: 'Warehouse Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN' },
    { id: 'wh-smd', name: 'Warehouse Samarinda Kota', district: 'District Samarinda', regional: 'KALIMANTAN' },
    { id: 'wh-mks', name: 'Warehouse Makassar Pusat', district: 'District Makassar', regional: 'SULAWESI' },
  ];

  function buildColumns(reports, devices){
    var cols = [];
    ['NEW', 'REFURBISH'].forEach(function(status){
      reports.forEach(function(report){
        var device = devices[report];
        cols.push({ key: status + '|' + report + '|' + device, status: status, report: report, device: device });
      });
    });
    return cols;
  }

  var SECTIONS = {
    RETAIL: {
      columns: buildColumns(['DUAL BAND', 'SINGLE BAND OPEN', 'SINGLE BAND NOT OPEN'],
        { 'DUAL BAND': 'ZTE F670L', 'SINGLE BAND OPEN': 'Huawei HG8245', 'SINGLE BAND NOT OPEN': 'Fiberhome AN5506' }),
      expanded: {}, byId: {}, chart: null,
    },
    PREMIUM: {
      columns: buildColumns(['ONT PREMIUM'], { 'ONT PREMIUM': 'ZTE F670L Premium' }),
      expanded: {}, byId: {}, chart: null,
    },
  };

  function countFor(sectionKey, w, colKey){
    var idx = SECTIONS[sectionKey].columns.map(function(c){ return c.key; }).indexOf(colKey);
    var whIdx = WAREHOUSES.indexOf(w);
    var base = colKey.indexOf('NEW|') === 0 ? 18 : 5;
    var raw = base + ((whIdx * 7 + idx * 11) % 13) - (sectionKey === 'PREMIUM' ? 4 : 0);
    return Math.max(0, raw);
  }

  var fRegional = document.getElementById('fRegional'), fDistrict = document.getElementById('fDistrict');
  fRegional.addEventListener('change', function(){
    var r = fRegional.value;
    fDistrict.innerHTML = '<option value="">' + (LANG === 'en' ? 'All' : 'Semua') + '</option>' +
      (r ? DISTRICTS[r] : [].concat(DISTRICTS.KALIMANTAN, DISTRICTS.SULAWESI)).map(function(d){ return '<option>' + d + '</option>'; }).join('');
    renderAll();
  });

  function sumCounts(sectionKey, whs, cols){
    var out = {};
    cols.forEach(function(c){ out[c.key] = 0; });
    whs.forEach(function(w){ cols.forEach(function(c){ out[c.key] += countFor(sectionKey, w, c.key); }); });
    return out;
  }
  function rowTotal(row, cols){ return cols.reduce(function(a, c){ return a + (row.counts[c.key] || 0); }, 0); }

  function buildTree(sectionKey){
    var cols = SECTIONS[sectionKey].columns;
    var regionalFilter = fRegional.value, districtFilter = fDistrict.value;
    var whList = WAREHOUSES.filter(function(w){
      return (!regionalFilter || w.regional === regionalFilter) && (!districtFilter || w.district === districtFilter);
    });
    var rows = [];
    if (districtFilter) {
      whList.forEach(function(w){
        rows.push({ id: w.id, label: w.name, parentId: null, hasChildren: false, counts: sumCounts(sectionKey, [w], cols), scope: { whId: w.id } });
      });
      return { nameHeader: t('hWarehouse'), rows: rows };
    }
    if (regionalFilter) {
      DISTRICTS[regionalFilter].forEach(function(d){
        var dWh = whList.filter(function(w){ return w.district === d; });
        var did = 'd-' + d;
        rows.push({ id: did, label: d, parentId: null, hasChildren: dWh.length > 0, counts: sumCounts(sectionKey, dWh, cols), scope: { district: d } });
        dWh.forEach(function(w){
          rows.push({ id: w.id, label: w.name, parentId: did, hasChildren: false, counts: sumCounts(sectionKey, [w], cols), scope: { whId: w.id } });
        });
      });
      return { nameHeader: t('hDistrict'), rows: rows };
    }
    REGIONALS.forEach(function(r){
      var rWh = whList.filter(function(w){ return w.regional === r; });
      var rid = 'r-' + r;
      rows.push({ id: rid, label: r, parentId: null, hasChildren: rWh.length > 0, counts: sumCounts(sectionKey, rWh, cols), scope: { regional: r } });
      (DISTRICTS[r] || []).forEach(function(d){
        var dWh = rWh.filter(function(w){ return w.district === d; });
        var did = 'd-' + d;
        rows.push({ id: did, label: d, parentId: rid, hasChildren: dWh.length > 0, counts: sumCounts(sectionKey, dWh, cols), scope: { district: d } });
        dWh.forEach(function(w){
          rows.push({ id: w.id, label: w.name, parentId: did, hasChildren: false, counts: sumCounts(sectionKey, [w], cols), scope: { whId: w.id } });
        });
      });
    });
    return { nameHeader: t('hRegional'), rows: rows };
  }

  function isVisible(row, byId, expanded){
    var p = row.parentId;
    while (p) {
      if (!expanded[p]) { return false; }
      p = byId[p].parentId;
    }
    return true;
  }
  function depthOf(row, byId){
    var d = 0, p = row.parentId;
    while (p) { d++; p = byId[p].parentId; }
    return d;
  }

  function renderHead(sectionKey){
    var cols = SECTIONS[sectionKey].columns;
    var statusRow = '<tr><th rowspan="3" id="' + sectionKey + 'HeadName"></th><th rowspan="3" data-i18n="totalSemua">Total Semua</th>';
    var reportRow = '<tr>', deviceRow = '<tr>';
    ['NEW', 'REFURBISH'].forEach(function(st){
      var stCols = cols.filter(function(c){ return c.status === st; });
      if (!stCols.length) { return; }
      statusRow += '<th colspan="' + stCols.length + '" class="cat-head" style="background:' + (st === 'NEW' ? '#a7d8a9' : '#fed7aa') + '">' + t(st === 'NEW' ? 'stNew' : 'stRefurb') + '</th>';
      var reports = stCols.map(function(c){ return c.report; }).filter(function(v, i, a){ return a.indexOf(v) === i; });
      reports.forEach(function(rep){
        var repCols = stCols.filter(function(c){ return c.report === rep; });
        reportRow += '<th colspan="' + repCols.length + '">' + rep + '</th>';
        repCols.forEach(function(c){ deviceRow += '<th>' + c.device + '</th>'; });
      });
    });
    statusRow += '</tr>'; reportRow += '</tr>'; deviceRow += '</tr>';
    document.getElementById(sectionKey + 'Head').innerHTML = statusRow + reportRow + deviceRow;
  }

  function renderSection(sectionKey){
    var sec = SECTIONS[sectionKey], cols = sec.columns;
    var tree = buildTree(sectionKey);
    sec.byId = {};
    tree.rows.forEach(function(r){ sec.byId[r.id] = r; });
    renderHead(sectionKey);
    document.getElementById(sectionKey + 'HeadName').textContent = tree.nameHeader;

    var visibleRows = tree.rows.filter(function(r){ return isVisible(r, sec.byId, sec.expanded); });
    document.getElementById(sectionKey + 'Body').innerHTML = visibleRows.map(function(r){
      var depth = depthOf(r, sec.byId);
      var chev = r.hasChildren
        ? '<button type="button" class="tree-chev' + (sec.expanded[r.id] ? ' open' : '') + '" data-section="' + sectionKey + '" data-toggle-row="' + r.id + '">▶</button>'
        : '<span style="width:18px;display:inline-block"></span>';
      var total = rowTotal(r, cols);
      var totalCell = total
        ? '<button type="button" class="tree-cell" data-section="' + sectionKey + '" data-detail-row="' + r.id + '" data-detail-col="">' + total + '</button>'
        : '<span class="tree-cell zero">0</span>';
      var cellsHtml = cols.map(function(c){
        var v = r.counts[c.key] || 0;
        return '<td>' + (v ? '<button type="button" class="tree-cell" data-section="' + sectionKey + '" data-detail-row="' + r.id + '" data-detail-col="' + c.key + '">' + v + '</button>' : '<span class="tree-cell zero">0</span>') + '</td>';
      }).join('');
      return '<tr><td><div class="tree-label" style="padding-left:' + (depth * 20) + 'px">' + chev + r.label + '</div></td>' +
        '<td>' + totalCell + '</td>' + cellsHtml + '</tr>';
    }).join('') || '<tr><td colspan="' + (cols.length + 2) + '" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';

    var topRows = tree.rows.filter(function(r){ return r.parentId === null; });
    var grandTotal = {};
    cols.forEach(function(c){ grandTotal[c.key] = topRows.reduce(function(a, r){ return a + (r.counts[c.key] || 0); }, 0); });
    var grandSum = cols.reduce(function(a, c){ return a + grandTotal[c.key]; }, 0);
    document.getElementById(sectionKey + 'Body').innerHTML += '<tr class="total-row"><td>' + t('totalSemua') + '</td><td>' + grandSum + '</td>' +
      cols.map(function(c){ return '<td>' + grandTotal[c.key] + '</td>'; }).join('') + '</tr>';

    renderChart(sectionKey, topRows, cols);
  }

  function renderAll(){ renderSection('RETAIL'); renderSection('PREMIUM'); }

  document.querySelectorAll('#RETAILBody, #PREMIUMBody').forEach(function(tbody){
    tbody.addEventListener('click', function(e){
      var chevBtn = e.target.closest('[data-toggle-row]');
      if (chevBtn) {
        var sk = chevBtn.dataset.section, id = chevBtn.dataset.toggleRow;
        SECTIONS[sk].expanded[id] = !SECTIONS[sk].expanded[id];
        renderSection(sk);
        return;
      }
      var detailBtn = e.target.closest('[data-detail-row]');
      if (detailBtn) { openDetail(detailBtn.dataset.section, detailBtn.dataset.detailRow, detailBtn.dataset.detailCol); }
    });
  });

  document.getElementById('showBtn').addEventListener('click', renderAll);
  document.getElementById('resetBtn').addEventListener('click', function(){
    fRegional.value = ''; fDistrict.innerHTML = '<option value="">Semua</option>';
    SECTIONS.RETAIL.expanded = {}; SECTIONS.PREMIUM.expanded = {};
    renderAll();
  });
  document.getElementById('exportRetail').addEventListener('click', function(){ toast(t('exportToast')); });
  document.getElementById('exportPremium').addEventListener('click', function(){ toast(t('exportToast')); });

  /* ---------- detail dialog ---------- */
  var detailDialog = document.getElementById('detailDialog');
  var detailRows = [], detailPage = 1;
  function pad3(n){ return (n < 10 ? '00' : n < 100 ? '0' : '') + n; }
  function pad2(n){ return n < 10 ? '0' + n : '' + n; }

  function genDetailRows(sectionKey, warehouses, cols){
    var out = [];
    warehouses.forEach(function(w){
      cols.forEach(function(c){
        var count = countFor(sectionKey, w, c.key);
        var merk = c.device.split(' ')[0];
        for (var i = 1; i <= count; i++) {
          out.push({
            serial: 'SN-' + sectionKey + '-' + merk.toUpperCase() + '-' + w.id.toUpperCase() + '-' + pad3(i),
            deviceType: c.device, merk: merk, kategori: 'ONT', report: c.report, status: c.status,
            warehouse: w.name, tglInput: '2026-09-' + pad2(i % 9 + 1), keterangan: 'STOK',
          });
        }
      });
    });
    return out;
  }

  function openDetail(sectionKey, rowId, colKey){
    var sec = SECTIONS[sectionKey], row = sec.byId[rowId], cols = sec.columns;
    var whs = WAREHOUSES.filter(function(w){
      return (!row.scope.regional || w.regional === row.scope.regional) &&
        (!row.scope.district || w.district === row.scope.district) &&
        (!row.scope.whId || w.id === row.scope.whId);
    });
    var useCols = colKey ? cols.filter(function(c){ return c.key === colKey; }) : cols;
    detailRows = genDetailRows(sectionKey, whs, useCols);
    detailPage = 1;
    var colLabel = colKey ? colKey.split('|').join(' - ') : t('totalSemua');
    document.getElementById('detailChips').innerHTML =
      '<span class="chip">' + t('chipArea') + row.label + '</span>' +
      '<span class="chip">' + t('chipType') + sectionKey + '</span>' +
      '<span class="chip">' + t('chipColumn') + colLabel + '</span>' +
      '<span class="chip">' + t('chipTotal') + detailRows.length + '</span>';
    document.getElementById('detailSearch').value = '';
    renderDetailTable();
    detailDialog.classList.add('show');
  }

  function renderDetailTable(){
    var q = document.getElementById('detailSearch').value.trim().toLowerCase();
    var rows = detailRows.filter(function(r){ return !q || r.serial.toLowerCase().indexOf(q) !== -1; });
    var perPage = parseInt(document.getElementById('detailPerPage').value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    if (detailPage > totalPages) { detailPage = totalPages; }
    var start = (detailPage - 1) * perPage;
    var page = rows.slice(start, start + perPage);
    document.getElementById('detailBody').innerHTML = page.length ? page.map(function(r){
      return '<tr><td class="mono-cell">' + r.serial + '</td><td>' + r.deviceType + '</td><td>' + r.merk + '</td>' +
        '<td>' + r.kategori + '</td><td>' + r.report + '</td>' +
        '<td><span class="pill pill-sq ' + (r.status === 'NEW' ? 'pill-green' : 'pill-amber') + '">' + r.status + '</span></td>' +
        '<td>' + r.warehouse + '</td><td>' + r.tglInput + '</td><td>' + r.keterangan + '</td></tr>';
    }).join('') : '<tr><td colspan="9" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';
    var from = rows.length ? start + 1 : 0, to = Math.min(start + perPage, rows.length);
    document.getElementById('detailPageInfo').textContent = from + '–' + to + ' ' + t('of') + ' ' + rows.length;
    var pager = document.getElementById('detailPager');
    pager.innerHTML = '';
    for (var p = 1; p <= totalPages; p++) {
      var btn = document.createElement('button');
      btn.textContent = p;
      if (p === detailPage) { btn.classList.add('on'); }
      (function(pp){ btn.addEventListener('click', function(){ detailPage = pp; renderDetailTable(); }); })(p);
      pager.appendChild(btn);
    }
  }
  document.getElementById('detailSearch').addEventListener('input', function(){ detailPage = 1; renderDetailTable(); });
  document.getElementById('detailPerPage').addEventListener('change', function(){ detailPage = 1; renderDetailTable(); });
  document.getElementById('detailExport').addEventListener('click', function(){ toast(t('exportToast')); });
  document.getElementById('detailClose').addEventListener('click', function(){ detailDialog.classList.remove('show'); });
  document.getElementById('detailDone').addEventListener('click', function(){ detailDialog.classList.remove('show'); });

  /* ---------- charts ---------- */
  var palette = ['#465fff', '#12b76a', '#f79009', '#f04438', '#7ec7ee', '#a855f7'];
  function renderChart(sectionKey, topRows, cols){
    var sec = SECTIONS[sectionKey];
    var period = document.getElementById('chartPeriod').value;
    var points = period === 'daily' ? 14 : period === 'weekly' ? 10 : 6;
    var prefix = period === 'daily' ? 'D' : period === 'weekly' ? 'W' : 'M';
    var labels = [];
    for (var i = 1; i <= points; i++) { labels.push(prefix + i); }

    var datasets = topRows.map(function(r, idx){
      var base = rowTotal(r, cols);
      var data = [];
      for (var i = 0; i < points; i++) { data.push(Math.max(0, Math.round(base * (0.7 + 0.3 * Math.sin(i * 0.6 + idx))))); }
      return { label: r.label, data: data, borderColor: palette[idx % palette.length], backgroundColor: palette[idx % palette.length], tension: 0.3, fill: false };
    });

    var ctx = document.getElementById('chart' + sectionKey).getContext('2d');
    if (sec.chart) { sec.chart.destroy(); }
    sec.chart = new Chart(ctx, {
      type: 'line',
      data: { labels: labels, datasets: datasets },
      options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } },
    });
  }
  document.getElementById('chartPeriod').addEventListener('change', renderAll);
  function wireChartToggle(btnId, sectionKey, visible){
    document.getElementById(btnId).addEventListener('click', function(){
      var sec = SECTIONS[sectionKey];
      if (!sec.chart) { return; }
      sec.chart.data.datasets.forEach(function(_, i){ sec.chart.setDatasetVisibility(i, visible); });
      sec.chart.update();
    });
  }
  wireChartToggle('chartShowAllRetail', 'RETAIL', true);
  wireChartToggle('chartHideAllRetail', 'RETAIL', false);
  wireChartToggle('chartShowAllPremium', 'PREMIUM', true);
  wireChartToggle('chartHideAllPremium', 'PREMIUM', false);

  function onLangChange(){ renderAll(); }
  renderAll();
  applyLang();
</script>
</body>
</html>
