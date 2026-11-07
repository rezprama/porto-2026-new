<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Stock Opname New — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.1/chart.umd.min.js"></script>
<style>
  table.matrix{white-space:nowrap}
  table.matrix th,table.matrix td{text-align:center;border:1px solid var(--border)}
  table.matrix th:first-child,table.matrix td:first-child{text-align:left;position:sticky;left:0;z-index:1;background:var(--panel-bg);min-width:210px}
  table.matrix thead th:first-child{z-index:2;background:var(--gray-50)}
  .cell-btn{background:none;border:none;font:inherit;color:var(--brand-600);font-weight:600;cursor:pointer;padding:0}
  .cell-btn.zero{color:var(--muted);font-weight:400;cursor:default}
  .cat-head{color:#fff;font-weight:700}
  .checkbox-row{display:flex;flex-wrap:wrap;gap:8px 18px;padding:10px 12px;border:1px solid var(--border);border-radius:4px}
  .checkbox-row label{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--label);cursor:pointer}
  .checkbox-row input{width:15px;height:15px;accent-color:var(--brand-500);cursor:pointer}
  .chip-row{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:12px}
  .chip{font-size:11.5px;font-weight:600;padding:5px 10px;border-radius:999px;background:var(--gray-50);color:var(--text);border:1px solid var(--border)}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'nte-stock'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navNte">NTE</span><span data-i18n="pageTitle">Stock Opname New</span></div>
    <h1 data-i18n="pageTitle">Stock Opname New</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field"><label>Regional</label><select id="fRegional"><option value="" data-i18n="all">Semua</option><option>REGIONAL 6</option></select></div>
          <div class="field"><label data-i18n="groupBy">Tampilkan Per</label><select id="fGroup"><option value="warehouse">Warehouse</option><option value="status">Status NTE</option></select></div>
          <div class="field"><label data-i18n="date">Tanggal</label><input type="date" id="fDate" value="2026-09-15" /></div>
        </div>
        <div class="field">
          <label data-i18n="catFilter">Kategori (kosongkan untuk semua)</label>
          <div class="checkbox-row" id="catRow"></div>
        </div>
        <div class="row-actions">
          <button class="btn-success" id="showBtn" data-i18n="show">Tampilkan</button>
          <button class="btn-outline" id="resetBtn" data-i18n="reset">Reset</button>
          <button class="btn-outline" id="exportBtn" data-i18n="download">Download</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body" style="padding-bottom:0"><div class="stat-grid" id="statGrid"></div></div>
      <div class="card-head" style="border-top:1px solid var(--border);margin-top:16px">
        <div>
          <h3 data-i18n="matrixTitle">Stock Opname Revisi - NTE</h3>
          <div class="last-update"><span data-i18n="lastUpdate">Update Terakhir</span>: 2026-09-15 06:30 WITA</div>
        </div>
      </div>
      <div class="table-scroll">
        <table class="matrix">
          <thead id="matrixHead"></thead>
          <tbody id="matrixBody"></tbody>
        </table>
      </div>
      <div class="card-note" data-i18n="matrixNote">Klik angka pada sel untuk melihat daftar serial number perangkat.</div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="chartTitle">Grafik Harian Stock Opname</h3>
        <select id="chartRange"><option value="14" data-i18n="r14">14 Hari Terakhir</option><option value="30" data-i18n="r30">30 Hari Terakhir</option></select>
      </div>
      <div class="card-body"><div class="chart-wrap"><canvas id="stockChart"></canvas></div></div>
    </div>
  </div>
</main>

<!-- DETAIL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 id="detailTitle" data-i18n="detailTitle">Detail Stock NTE</h3><button class="modal-close" id="detailX">✕</button></div>
    <div class="modal-body">
      <div class="chip-row" id="detailChips"></div>
      <div class="table-toolbar" style="padding:0 0 12px">
        <select id="detailPerPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option></select>
        <input type="text" id="detailSearch" data-i18n-ph="snPh" placeholder="Cari serial number..." />
      </div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>No</th><th data-i18n="cSn">Serial Number</th><th data-i18n="cDevice">Device Type</th>
              <th data-i18n="cBrand">Merk</th><th data-i18n="cCategory">Kategori</th><th data-i18n="status">Status</th>
              <th>Warehouse</th><th data-i18n="cInputDate">Tanggal Input</th><th data-i18n="cNote">Keterangan</th>
            </tr>
          </thead>
          <tbody id="detailBody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="detailInfo"></span><div class="pager" id="detailPager"></div></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="detailClose" data-i18n="close">Tutup</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    pageTitle: 'Stock Opname New', groupBy: 'Tampilkan Per', date: 'Tanggal',
    catFilter: 'Kategori (kosongkan untuk semua)', show: 'Tampilkan',
    matrixTitle: 'Stock Opname Revisi - NTE',
    matrixNote: 'Klik angka pada sel untuk melihat daftar serial number perangkat.',
    nameWarehouse: 'Warehouse', nameStatus: 'Status NTE', totalAll: 'Total Semua',
    chartTitle: 'Grafik Harian Stock Opname', r14: '14 Hari Terakhir', r30: '30 Hari Terakhir',
    detailTitle: 'Detail Stock NTE', snPh: 'Cari serial number...',
    cSn: 'Serial Number', cDevice: 'Device Type', cBrand: 'Merk', cCategory: 'Kategori',
    status: 'Status', cInputDate: 'Tanggal Input', cNote: 'Keterangan',
    sTotal: 'Total Perangkat', sGood: 'Kondisi Baik', sRusak: 'Rusak / Reject', sCategory: 'Kategori Aktif',
    stGood: 'GOOD', stUsed: 'USED', stRusak: 'RUSAK', stReject: 'REJECT',
    noteOk: 'Sesuai hasil opname', noteMinor: 'Casing lecet, fungsi normal',
    noteBroken: 'Port LAN tidak berfungsi', noteMissing: 'Adaptor tidak lengkap',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')

<script>
  var CATEGORIES = [
    { name: 'ONT',    color: '#2f5d8a', brands: ['ZTE', 'HUAWEI', 'FIBERHOME', 'NOKIA'] },
    { name: 'STB',    color: '#3cb878', brands: ['ZTE', 'HUAWEI'] },
    { name: 'ROUTER', color: '#f0ad4e', brands: ['TP-LINK', 'TENDA'] },
    { name: 'ONT B2B',color: '#8b5cf6', brands: ['HUAWEI', 'NOKIA'] },
  ];
  var WAREHOUSES = ['WH BALIKPAPAN', 'WH SAMARINDA', 'WH BANJARMASIN', 'WH PALANGKARAYA', 'WH TARAKAN'];
  var STATUSES = ['stGood', 'stUsed', 'stRusak', 'stReject'];
  var NOTES = ['noteOk', 'noteMinor', 'noteBroken', 'noteMissing'];

  /* ponytail: deterministic counts so the matrix, stats and detail list always agree. */
  function seeded(a, b, c){ return ((a * 73856093) ^ (b * 19349663) ^ (c * 83492791)) >>> 0; }
  function countFor(rowIdx, catIdx, brandIdx){
    return seeded(rowIdx + 1, catIdx + 1, brandIdx + 1) % 140;
  }
  /* A device's status is derived from the same seed, so "damaged" totals stay stable too. */
  function statusFor(rowIdx, catIdx, brandIdx, n){
    var s = seeded(rowIdx + 3, catIdx + 5, brandIdx + 7 + n);
    return STATUSES[s % 10 < 6 ? 0 : (s % 10 < 8 ? 1 : (s % 10 < 9 ? 2 : 3))];
  }

  var catRow = document.getElementById('catRow');
  catRow.innerHTML = CATEGORIES.map(function(c, i){
    return '<label><input type="checkbox" data-cat="' + i + '" /> ' + c.name + '</label>';
  }).join('');

  var fGroup = document.getElementById('fGroup');
  function rowNames(){
    return fGroup.value === 'warehouse' ? WAREHOUSES : STATUSES.map(function(s){ return t(s); });
  }
  function activeCats(){
    var picked = Array.prototype.filter.call(catRow.querySelectorAll('input'), function(cb){ return cb.checked; })
      .map(function(cb){ return CATEGORIES[parseInt(cb.dataset.cat, 10)]; });
    return picked.length ? picked : CATEGORIES;
  }

  function renderMatrix(){
    var cats = activeCats();
    var names = rowNames();

    document.getElementById('matrixHead').innerHTML =
      '<tr><th rowspan="2">' + t(fGroup.value === 'warehouse' ? 'nameWarehouse' : 'nameStatus') + '</th>' +
      '<th rowspan="2">' + t('totalAll') + '</th>' +
      cats.map(function(c){ return '<th class="cat-head" colspan="' + c.brands.length + '" style="background:' + c.color + '">' + c.name + '</th>'; }).join('') +
      '</tr><tr>' +
      cats.map(function(c){ return c.brands.map(function(b){ return '<th>' + b + '</th>'; }).join(''); }).join('') +
      '</tr>';

    var colTotals = [];
    var grand = 0;
    var body = names.map(function(name, ri){
      var rowTotal = 0;
      var cells = '';
      var col = 0;
      cats.forEach(function(c, ci){
        c.brands.forEach(function(b, bi){
          var n = countFor(ri, CATEGORIES.indexOf(c), bi);
          rowTotal += n;
          colTotals[col] = (colTotals[col] || 0) + n;
          col++;
          cells += '<td>' + (n
            ? '<button class="cell-btn" data-row="' + ri + '" data-cat="' + CATEGORIES.indexOf(c) + '" data-brand="' + bi + '">' + n + '</button>'
            : '<span class="cell-btn zero">0</span>') + '</td>';
        });
      });
      grand += rowTotal;
      return '<tr><td>' + name + '</td><td style="font-weight:700">' + rowTotal.toLocaleString('id-ID') + '</td>' + cells + '</tr>';
    }).join('');

    body += '<tr class="total-row"><td>' + t('total') + '</td><td>' + grand.toLocaleString('id-ID') + '</td>' +
      colTotals.map(function(v){ return '<td>' + v.toLocaleString('id-ID') + '</td>'; }).join('') + '</tr>';
    document.getElementById('matrixBody').innerHTML = body;

    renderStats(cats, names, grand);
    renderChart(cats);
  }

  function renderStats(cats, names, grand){
    var good = 0, broken = 0;
    names.forEach(function(_, ri){
      cats.forEach(function(c){
        c.brands.forEach(function(_b, bi){
          var n = countFor(ri, CATEGORIES.indexOf(c), bi);
          for (var i = 0; i < n; i++) {
            var st = statusFor(ri, CATEGORIES.indexOf(c), bi, i);
            if (st === 'stGood') { good++; }
            if (st === 'stRusak' || st === 'stReject') { broken++; }
          }
        });
      });
    });
    document.getElementById('statGrid').innerHTML = [
      ['sTotal', grand.toLocaleString('id-ID'), ''],
      ['sGood', good.toLocaleString('id-ID'), grand ? Math.round(good / grand * 100) + '%' : '0%'],
      ['sRusak', broken.toLocaleString('id-ID'), grand ? Math.round(broken / grand * 100) + '%' : '0%'],
      ['sCategory', cats.length + ' / ' + CATEGORIES.length, ''],
    ].map(function(s){
      return '<div class="stat"><div class="k">' + t(s[0]) + '</div><div class="v">' + s[1] + '</div>' +
        (s[2] ? '<div class="s">' + s[2] + '</div>' : '') + '</div>';
    }).join('');
  }

  /* ---------- detail ---------- */
  var detailRows = [], detailPage = 1, detailCtx = null;
  document.getElementById('matrixBody').addEventListener('click', function(e){
    var b = e.target.closest('.cell-btn:not(.zero)');
    if (!b) { return; }
    var ri = parseInt(b.dataset.row, 10), ci = parseInt(b.dataset.cat, 10), bi = parseInt(b.dataset.brand, 10);
    var cat = CATEGORIES[ci], brand = cat.brands[bi];
    var n = countFor(ri, ci, bi);
    detailCtx = { name: rowNames()[ri], cat: cat.name, brand: brand };
    detailRows = [];
    for (var i = 0; i < n; i++) {
      var s = seeded(ri + 11, ci + 13, bi + 17 + i);
      detailRows.push({
        sn: brand.slice(0, 3).toUpperCase() + String(10000000 + (s % 89999999)),
        device: cat.name + '-' + brand.slice(0, 2) + (100 + (s % 900)),
        brand: brand, cat: cat.name,
        status: statusFor(ri, ci, bi, i),
        warehouse: fGroup.value === 'warehouse' ? rowNames()[ri] : WAREHOUSES[s % WAREHOUSES.length],
        input: '2026-09-' + String(1 + (s % 15)).padStart(2, '0'),
        note: NOTES[s % NOTES.length],
      });
    }
    detailPage = 1;
    document.getElementById('detailSearch').value = '';
    document.getElementById('detailTitle').textContent = t('detailTitle') + ' — ' + detailCtx.name;
    document.getElementById('detailChips').innerHTML =
      ['<span class="chip">' + detailCtx.cat + '</span>',
       '<span class="chip">' + detailCtx.brand + '</span>',
       '<span class="chip">' + n.toLocaleString('id-ID') + ' ' + t('sTotal') + '</span>'].join('');
    renderDetail();
    document.getElementById('detailModal').classList.add('show');
  });

  var STATUS_PILL = { stGood: 'pill-green', stUsed: 'pill-blue', stRusak: 'pill-amber', stReject: 'pill-red' };
  function renderDetail(){
    var q = document.getElementById('detailSearch').value.trim().toLowerCase();
    var rows = detailRows.filter(function(r){ return !q || r.sn.toLowerCase().indexOf(q) !== -1; });
    var per = parseInt(document.getElementById('detailPerPage').value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / per));
    if (detailPage > totalPages) { detailPage = totalPages; }
    var start = (detailPage - 1) * per;
    var page = rows.slice(start, start + per);

    document.getElementById('detailBody').innerHTML = page.length ? page.map(function(r, i){
      return '<tr><td>' + (start + i + 1) + '</td><td class="mono-cell">' + r.sn + '</td><td>' + r.device + '</td>' +
        '<td>' + r.brand + '</td><td>' + r.cat + '</td>' +
        '<td><span class="pill ' + STATUS_PILL[r.status] + '">' + t(r.status) + '</span></td>' +
        '<td>' + r.warehouse + '</td><td>' + r.input + '</td><td>' + t(r.note) + '</td></tr>';
    }).join('') : '<tr><td colspan="9" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    var from = rows.length ? start + 1 : 0, to = Math.min(start + per, rows.length);
    document.getElementById('detailInfo').textContent = from + '–' + to + ' ' + t('of') + ' ' + rows.length;
    var pager = document.getElementById('detailPager');
    pager.innerHTML = '';
    for (var p = 1; p <= totalPages; p++) {
      var btn = document.createElement('button');
      btn.textContent = p;
      if (p === detailPage) { btn.classList.add('on'); }
      (function(pp){ btn.addEventListener('click', function(){ detailPage = pp; renderDetail(); }); })(p);
      pager.appendChild(btn);
    }
  }
  document.getElementById('detailSearch').addEventListener('input', function(){ detailPage = 1; renderDetail(); });
  document.getElementById('detailPerPage').addEventListener('change', function(){ detailPage = 1; renderDetail(); });
  ['detailX', 'detailClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ document.getElementById('detailModal').classList.remove('show'); });
  });

  /* ---------- daily chart ---------- */
  var chart = null;
  function renderChart(cats){
    var days = parseInt(document.getElementById('chartRange').value, 10);
    var labels = [];
    for (var d = days - 1; d >= 0; d--) {
      var dt = new Date(2026, 8, 15 - d);
      labels.push(String(dt.getDate()).padStart(2, '0') + '/' + String(dt.getMonth() + 1).padStart(2, '0'));
    }
    var tick = (getComputedStyle(document.body).getPropertyValue('--muted') || '').trim() || '#98a2b3';
    if (chart) { chart.destroy(); }
    chart = new Chart(document.getElementById('stockChart'), {
      type: 'line',
      data: {
        labels: labels,
        datasets: cats.map(function(c, ci){
          var base = c.brands.reduce(function(s, _b, bi){
            return s + WAREHOUSES.reduce(function(s2, _w, ri){ return s2 + countFor(ri, CATEGORIES.indexOf(c), bi); }, 0);
          }, 0);
          return {
            label: c.name, borderColor: c.color, backgroundColor: c.color, tension: .3, pointRadius: 2,
            data: labels.map(function(_l, i){ return Math.round(base * (0.88 + ((seeded(ci + 1, i + 1, 3) % 24) / 100))); }),
          };
        }),
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { labels: { color: tick, boxWidth: 12 } } },
        scales: {
          x: { ticks: { color: tick }, grid: { display: false } },
          y: { ticks: { color: tick }, grid: { color: 'rgba(127,127,127,.15)' } },
        },
      },
    });
  }

  fGroup.addEventListener('change', renderMatrix);
  catRow.addEventListener('change', renderMatrix);
  document.getElementById('chartRange').addEventListener('change', renderMatrix);
  document.getElementById('showBtn').addEventListener('click', renderMatrix);
  document.getElementById('resetBtn').addEventListener('click', function(){
    catRow.querySelectorAll('input').forEach(function(cb){ cb.checked = false; });
    fGroup.value = 'warehouse';
    renderMatrix();
  });
  document.getElementById('exportBtn').addEventListener('click', function(){ toast(t('demoOnly')); });

  renderMatrix();
  applyLang();
</script>
</body>
</html>
