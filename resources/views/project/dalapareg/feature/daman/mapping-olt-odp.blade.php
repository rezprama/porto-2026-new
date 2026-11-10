<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Mapping OLT ODP — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.1/chart.umd.min.js"></script>
<style>
  .drill{background:none;border:none;font:inherit;font-weight:700;color:var(--brand-600);cursor:pointer;padding:0}
  .drill:hover{text-decoration:underline}
  .num-cell{background:none;border:none;font:inherit;color:var(--brand-600);font-weight:600;cursor:pointer;padding:0}
  .num-cell.zero{color:var(--muted);font-weight:400;cursor:default;text-decoration:none}
  .crumb-bar{display:flex;flex-wrap:wrap;gap:6px;align-items:center;padding:12px 16px;border-bottom:1px solid var(--border);font-size:12px;color:var(--muted)}
  .crumb-bar button{background:none;border:none;font:inherit;color:var(--brand-600);cursor:pointer;padding:0}
  .crumb-bar .sep{opacity:.5}
  .pct-bar{height:6px;border-radius:3px;background:var(--gray-200);overflow:hidden;margin-top:4px}
  .pct-bar > i{display:block;height:100%;background:#3cb878}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'daman-mapping-olt-odp'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navDaman">Data Management</span><span data-i18n="pageTitle">Mapping OLT ODP</span></div>
    <h1 data-i18n="pageTitle">Mapping OLT ODP</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field">
            <label data-i18n="filterBy">Filter Berdasarkan :</label>
            <select id="fType">
              <option value="NASIONAL" data-i18n="lvNasional">Nasional</option>
              <option value="REGIONAL">Regional</option>
              <option value="WITEL">Witel</option>
              <option value="STO">STO</option>
            </select>
          </div>
          <div class="field" id="wrapRegional" hidden><label data-i18n="pickRegional">Pilih Regional</label><select id="fRegional"></select></div>
          <div class="field" id="wrapWitel" hidden><label data-i18n="pickWitel">Pilih Witel</label><select id="fWitel"></select></div>
          <div class="field" id="wrapSto" hidden><label data-i18n="pickSto">Pilih STO</label><select id="fSto"></select></div>
          <div class="field" style="align-self:end"><button class="btn-success" id="filterBtn" style="width:100%" data-i18n="filter">Filter</button></div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 id="tableTitle">Rekap Validasi Port OLT</h3>
        <div style="display:flex;gap:8px;align-items:center">
          <span class="last-update">[ <span data-i18n="lastUpdate">Update Terakhir</span> : 15-09-2026 04:10:22 ]</span>
          <button class="btn-success" id="downloadBtn" data-i18n="download">Download</button>
        </div>
      </div>
      <div class="crumb-bar" id="crumbBar"></div>
      <div class="table-scroll">
        <table class="bordered centered">
          <thead>
            <tr>
              <th id="thArea">Regional</th>
              <th data-i18n="cOltTotal">OLT Total</th>
              <th data-i18n="cSlotTotal">Slot Total</th>
              <th data-i18n="cPortTotal">Port Total</th>
              <th data-i18n="cPortValid">Port Valid</th>
              <th data-i18n="cPortInvalid">Port Tidak Valid</th>
              <th data-i18n="cPortCheck">Port Cek Lapangan</th>
              <th data-i18n="cPortGendong">Port Gendong</th>
              <th data-i18n="cValidPct">% Valid</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="chartTitle">Grafik Perkembangan Data Validasi Port OLT</h3>
        <span class="last-update">[ <span data-i18n="lastUpdate">Update Terakhir</span> : 15-09-2026 02:00:00 ]</span>
      </div>
      <div class="card-body">
        <div class="row3">
          <div class="field">
            <label data-i18n="chartKind">Jenis</label>
            <select id="cKind"><option value="AREA">Area</option><option value="STATUS" data-i18n="portCategory">Kategori Port OLT</option></select>
          </div>
          <div class="field" id="wrapCStatus" hidden>
            <label data-i18n="status">Status</label>
            <select id="cStatus">
              <option value="valid">Valid</option>
              <option value="invalid">Not Valid</option>
              <option value="check" data-i18n="checkField">Check Lapangan</option>
              <option value="gendong">Gendong</option>
            </select>
          </div>
          <div class="field">
            <label data-i18n="timeRange">Waktu</label>
            <select id="cTime"><option value="6" data-i18n="t6">6 Bulan Terakhir</option><option value="12" data-i18n="t12">12 Bulan Terakhir</option></select>
          </div>
        </div>
        <div class="chart-wrap"><canvas id="trendChart"></canvas></div>
      </div>
    </div>
  </div>
</main>

<!-- PORT DETAIL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 id="detailTitle">Detail Port</h3><button class="modal-close" id="detailX">✕</button></div>
    <div class="tabs">
      <button class="on" data-tab="#detailOdp" data-i18n="tabDetailOdp">Data Detail ODP</button>
      <button data-tab="#detailSummary" data-i18n="tabSummary">Ringkasan Status</button>
    </div>
    <div class="modal-body">
      <div id="detailOdp">
        <div class="table-toolbar" style="padding:0 0 12px">
          <input type="text" id="detailSearch" data-i18n-ph="searchOltPh" placeholder="Cari hostname / ODP..." />
          <button class="btn-outline" id="detailExport" data-i18n="download">Download</button>
        </div>
        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr>
                <th data-i18n="cHostname">Hostname OLT</th>
                <th data-i18n="cSlotPort">Slot / Port</th>
                <th>ODP</th>
                <th data-i18n="cOnt">ONT Aktif</th>
                <th data-i18n="cStatusPort">Status Port</th>
                <th data-i18n="cLastCheck">Cek Terakhir</th>
              </tr>
            </thead>
            <tbody id="detailBody"></tbody>
          </table>
        </div>
      </div>
      <div id="detailSummary" hidden>
        <table class="bordered centered">
          <thead><tr><th data-i18n="colStatus">Status</th><th data-i18n="cPortTotal">Port Total</th><th data-i18n="cValidPct">% Valid</th></tr></thead>
          <tbody id="summaryBody"></tbody>
        </table>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="detailClose" data-i18n="close">Tutup</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    pageTitle: 'Mapping OLT ODP', filterBy: 'Filter Berdasarkan :', lvNasional: 'Nasional',
    pickRegional: 'Pilih Regional', pickWitel: 'Pilih Witel', pickSto: 'Pilih STO',
    cOltTotal: 'OLT Total', cSlotTotal: 'Slot Total', cPortTotal: 'Port Total', cPortValid: 'Port Valid',
    cPortInvalid: 'Port Tidak Valid', cPortCheck: 'Port Cek Lapangan', cPortGendong: 'Port Gendong', cValidPct: '% Valid',
    chartTitle: 'Grafik Perkembangan Data Validasi Port OLT', chartKind: 'Jenis', portCategory: 'Kategori Port OLT',
    status: 'Status', checkField: 'Check Lapangan', timeRange: 'Waktu',
    t6: '6 Bulan Terakhir', t12: '12 Bulan Terakhir',
    tableTitleNas: 'Rekap Validasi Port OLT — Nasional',
    colRegional: 'Regional', colWitel: 'Witel', colSto: 'STO',
    detailTitle: 'Detail Port OLT', searchOltPh: 'Cari hostname / ODP...',
    cHostname: 'Hostname OLT', cSlotPort: 'Slot / Port', cOnt: 'ONT Aktif', cStatusPort: 'Status Port', cLastCheck: 'Cek Terakhir',
    stValid: 'VALID', stInvalid: 'TIDAK VALID', stCheck: 'CEK LAPANGAN', stGendong: 'GENDONG',
    backTo: 'Kembali ke', nasional: 'Nasional',
    tabDetailOdp: 'Data Detail ODP', tabSummary: 'Ringkasan Status', colStatus: 'Status',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')

<script>
  /* ---------- dummy hierarchy: Regional > Witel > STO ---------- */
  var TREE = [
    { area: 'REGIONAL 5', children: [
      { area: 'WITEL SURABAYA', children: [
        { area: 'STO RUNGKUT',    olt: 14, slot: 96,  valid: 6820, invalid: 412, check: 236, gendong: 118 },
        { area: 'STO GUBENG',     olt: 11, slot: 74,  valid: 5240, invalid: 366, check: 190, gendong: 84 },
      ]},
      { area: 'WITEL MALANG', children: [
        { area: 'STO KLOJEN',     olt: 9,  slot: 62,  valid: 4180, invalid: 298, check: 154, gendong: 62 },
      ]},
    ]},
    { area: 'REGIONAL 6', children: [
      { area: 'WITEL BALIKPAPAN', children: [
        { area: 'STO BALIKPAPAN KOTA', olt: 12, slot: 88, valid: 6104, invalid: 388, check: 212, gendong: 96 },
        { area: 'STO SEPINGGAN',       olt: 8,  slot: 56, valid: 3910, invalid: 264, check: 148, gendong: 55 },
        { area: 'STO KARANG JOANG',    olt: 6,  slot: 41, valid: 2680, invalid: 202, check: 116, gendong: 41 },
        { area: 'STO MANGGAR',         olt: 7,  slot: 48, valid: 3204, invalid: 236, check: 130, gendong: 48 },
        { area: 'STO GUNUNG SARI',     olt: 5,  slot: 34, valid: 2210, invalid: 176, check: 92,  gendong: 33 },
      ]},
      { area: 'WITEL SAMARINDA', children: [
        { area: 'STO SAMARINDA KOTA',  olt: 10, slot: 71, valid: 4980, invalid: 322, check: 176, gendong: 74 },
        { area: 'STO SUNGAI KUNJANG',  olt: 7,  slot: 49, valid: 3320, invalid: 244, check: 128, gendong: 50 },
        { area: 'STO AIR PUTIH',       olt: 6,  slot: 42, valid: 2790, invalid: 198, check: 104, gendong: 38 },
      ]},
      { area: 'WITEL BANJARMASIN', children: [
        { area: 'STO BANJARMASIN',     olt: 9,  slot: 63, valid: 4310, invalid: 286, check: 162, gendong: 66 },
        { area: 'STO BANJARBARU',      olt: 5,  slot: 36, valid: 2380, invalid: 184, check: 96,  gendong: 35 },
      ]},
    ]},
    { area: 'REGIONAL 7', children: [
      { area: 'WITEL MAKASSAR', children: [
        { area: 'STO MAKASSAR PUSAT',  olt: 13, slot: 92, valid: 6420, invalid: 402, check: 224, gendong: 102 },
        { area: 'STO PANAKKUKANG',     olt: 8,  slot: 55, valid: 3760, invalid: 268, check: 142, gendong: 58 },
      ]},
      { area: 'WITEL KENDARI', children: [
        { area: 'STO KENDARI KOTA',    olt: 6,  slot: 40, valid: 2540, invalid: 194, check: 108, gendong: 40 },
      ]},
    ]},
  ];

  var METRICS = ['olt', 'slot', 'valid', 'invalid', 'check', 'gendong'];
  function agg(node){
    if (!node.children) { return node; }
    var out = { area: node.area, children: node.children };
    METRICS.forEach(function(k){
      out[k] = node.children.reduce(function(s, c){ return s + agg(c)[k]; }, 0);
    });
    return out;
  }
  function portTotal(n){ return n.valid + n.invalid + n.check + n.gendong; }
  function findNodeByArea(area, list){
    list = list || TREE;
    for (var i = 0; i < list.length; i++) {
      if (list[i].area === area) { return agg(list[i]); }
      if (list[i].children) {
        var hit = findNodeByArea(area, list[i].children);
        if (hit) { return hit; }
      }
    }
    return null;
  }

  /* ---------- drill-down state: [] = nasional, [reg], [reg, witel] ---------- */
  var path = [];
  function nodesAt(p){
    var list = TREE;
    for (var i = 0; i < p.length; i++) {
      list = list.filter(function(n){ return n.area === p[i]; })[0].children;
    }
    return list.map(agg);
  }
  function levelLabel(){ return [t('colRegional'), t('colWitel'), t('colSto')][path.length]; }

  var tbody = document.getElementById('tbody');

  function cell(node, key){
    var v = node[key];
    if (!v) { return '<span class="num-cell zero">0</span>'; }
    return '<button class="num-cell" data-area="' + node.area + '" data-key="' + key + '">' + v.toLocaleString('id-ID') + '</button>';
  }

  function renderTable(){
    var rows = nodesAt(path);
    document.getElementById('thArea').textContent = levelLabel();
    document.getElementById('tableTitle').textContent = path.length ? path[path.length - 1] : t('tableTitleNas');

    var crumb = document.getElementById('crumbBar');
    crumb.innerHTML = '<button data-go="0">' + t('nasional') + '</button>' +
      path.map(function(a, i){ return '<span class="sep">/</span><button data-go="' + (i + 1) + '">' + a + '</button>'; }).join('');

    var totals = { olt: 0, slot: 0, valid: 0, invalid: 0, check: 0, gendong: 0 };
    tbody.innerHTML = rows.map(function(n){
      METRICS.forEach(function(k){ totals[k] += n[k]; });
      var pct = portTotal(n) ? Math.round((n.valid / portTotal(n)) * 1000) / 10 : 0;
      var name = n.children
        ? '<button class="drill" data-drill="' + n.area + '">' + n.area + '</button>'
        : n.area;
      return '<tr>' +
        '<td>' + name + '</td>' +
        '<td>' + n.olt + '</td><td>' + n.slot + '</td>' +
        '<td>' + portTotal(n).toLocaleString('id-ID') + '</td>' +
        '<td>' + cell(n, 'valid') + '</td><td>' + cell(n, 'invalid') + '</td>' +
        '<td>' + cell(n, 'check') + '</td><td>' + cell(n, 'gendong') + '</td>' +
        '<td>' + pct + '%<div class="pct-bar"><i style="width:' + pct + '%"></i></div></td>' +
        '</tr>';
    }).join('');

    var tPort = totals.valid + totals.invalid + totals.check + totals.gendong;
    var tPct = tPort ? Math.round((totals.valid / tPort) * 1000) / 10 : 0;
    tbody.insertAdjacentHTML('beforeend', '<tr class="total-row"><td>' + t('total') + '</td><td>' + totals.olt +
      '</td><td>' + totals.slot + '</td><td>' + tPort.toLocaleString('id-ID') + '</td><td>' + totals.valid.toLocaleString('id-ID') +
      '</td><td>' + totals.invalid.toLocaleString('id-ID') + '</td><td>' + totals.check.toLocaleString('id-ID') +
      '</td><td>' + totals.gendong.toLocaleString('id-ID') + '</td><td>' + tPct + '%</td></tr>');
  }

  tbody.addEventListener('click', function(e){
    var d = e.target.closest('[data-drill]');
    if (d) { path.push(d.dataset.drill); renderTable(); return; }
    var n = e.target.closest('.num-cell:not(.zero)');
    if (n) { openDetail(n.dataset.area, n.dataset.key); }
  });
  document.getElementById('crumbBar').addEventListener('click', function(e){
    var b = e.target.closest('[data-go]');
    if (!b) { return; }
    path = path.slice(0, parseInt(b.dataset.go, 10));
    renderTable();
  });

  /* ---------- filter panel drives the same drill state ---------- */
  var fType = document.getElementById('fType'), fRegional = document.getElementById('fRegional'),
      fWitel = document.getElementById('fWitel'), fSto = document.getElementById('fSto');
  function setOptions(sel, values){
    sel.innerHTML = values.map(function(v){ return '<option>' + v + '</option>'; }).join('');
  }
  function syncFilterSelects(){
    var lvl = fType.value;
    document.getElementById('wrapRegional').hidden = lvl === 'NASIONAL';
    document.getElementById('wrapWitel').hidden = (lvl === 'NASIONAL' || lvl === 'REGIONAL');
    document.getElementById('wrapSto').hidden = lvl !== 'STO';
    setOptions(fRegional, TREE.map(function(r){ return r.area; }));
  }
  function syncWitel(){
    var reg = TREE.filter(function(r){ return r.area === fRegional.value; })[0];
    setOptions(fWitel, reg ? reg.children.map(function(w){ return w.area; }) : []);
    syncSto();
  }
  function syncSto(){
    var reg = TREE.filter(function(r){ return r.area === fRegional.value; })[0];
    var wit = reg && reg.children.filter(function(w){ return w.area === fWitel.value; })[0];
    setOptions(fSto, wit ? wit.children.map(function(s){ return s.area; }) : []);
  }
  fType.addEventListener('change', function(){ syncFilterSelects(); syncWitel(); });
  fRegional.addEventListener('change', syncWitel);
  fWitel.addEventListener('change', syncSto);
  syncFilterSelects(); syncWitel();

  document.getElementById('filterBtn').addEventListener('click', function(){
    var lvl = fType.value;
    if (lvl === 'NASIONAL') { path = []; }
    else if (lvl === 'REGIONAL') { path = [fRegional.value]; }
    else { path = [fRegional.value, fWitel.value]; }
    renderTable();
    if (lvl === 'STO') { openDetail(fSto.value, 'valid'); }
  });
  document.getElementById('downloadBtn').addEventListener('click', function(){ toast(t('demoOnly')); });
  document.getElementById('detailExport').addEventListener('click', function(){ toast(t('demoOnly')); });

  /* ---------- port detail modal ---------- */
  var STATUS_META = {
    valid:    { key: 'stValid',    pill: 'pill-green' },
    invalid:  { key: 'stInvalid',  pill: 'pill-red' },
    check:    { key: 'stCheck',    pill: 'pill-amber' },
    gendong:  { key: 'stGendong',  pill: 'pill-purple' },
  };
  var detailRows = [];
  function openDetail(area, key){
    var meta = STATUS_META[key];
    var slug = area.replace(/^(STO|WITEL|REGIONAL)\s+/, '').split(' ').map(function(w){ return w.slice(0, 3); }).join('').toUpperCase();
    detailRows = [];
    for (var i = 1; i <= 24; i++) {
      detailRows.push({
        hostname: 'OLT-' + slug + '-' + String(Math.ceil(i / 6)).padStart(2, '0'),
        slotPort: (1 + (i % 8)) + ' / ' + (1 + (i % 16)),
        odp: 'ODP-' + slug + '-FR/' + String(i).padStart(3, '0'),
        ont: key === 'valid' ? 4 + (i % 5) : (key === 'gendong' ? 1 + (i % 3) : 0),
        lastCheck: '2026-0' + (6 + (i % 4)) + '-' + String(1 + (i % 27)).padStart(2, '0'),
      });
    }
    document.getElementById('detailTitle').textContent = t('detailTitle') + ' — ' + area + ' · ' + t(meta.key);
    document.getElementById('detailSearch').value = '';
    renderDetail(meta);
    renderSummary(area);
    document.getElementById('detailModal').classList.add('show');
  }
  function renderSummary(area){
    var node = findNodeByArea(area) || { valid: 0, invalid: 0, check: 0, gendong: 0 };
    var total = portTotal(node);
    document.getElementById('summaryBody').innerHTML = ['valid', 'invalid', 'check', 'gendong'].map(function(k){
      var pct = total ? Math.round((node[k] / total) * 1000) / 10 : 0;
      return '<tr><td><span class="pill ' + STATUS_META[k].pill + '">' + t(STATUS_META[k].key) + '</span></td>' +
        '<td>' + node[k].toLocaleString('id-ID') + '</td><td>' + pct + '%</td></tr>';
    }).join('');
  }
  function renderDetail(meta){
    var q = document.getElementById('detailSearch').value.trim().toLowerCase();
    var rows = detailRows.filter(function(r){
      return !q || r.hostname.toLowerCase().indexOf(q) !== -1 || r.odp.toLowerCase().indexOf(q) !== -1;
    });
    document.getElementById('detailBody').innerHTML = rows.length ? rows.map(function(r){
      return '<tr><td class="mono-cell">' + r.hostname + '</td><td>' + r.slotPort + '</td>' +
        '<td class="mono-cell">' + r.odp + '</td><td>' + r.ont + '</td>' +
        '<td><span class="pill ' + meta.pill + '">' + t(meta.key) + '</span></td><td>' + r.lastCheck + '</td></tr>';
    }).join('') : '<tr><td colspan="6" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
    document.getElementById('detailSearch').oninput = function(){ renderDetail(meta); };
  }
  ['detailX', 'detailClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ document.getElementById('detailModal').classList.remove('show'); });
  });

  /* ---------- trend chart ---------- */
  var MONTHS = ['Okt 25','Nov 25','Des 25','Jan 26','Feb 26','Mar 26','Apr 26','Mei 26','Jun 26','Jul 26','Agu 26','Sep 26'];
  var SERIES = {
    'REGIONAL 5': [14980,15240,15510,15790,16020,16310,16590,16840,17080,17330,17560,17820],
    'REGIONAL 6': [28140,28720,29310,29880,30420,31010,31560,32090,32610,33150,33690,34220],
    'REGIONAL 7': [11420,11680,11950,12210,12470,12740,12990,13240,13480,13730,13980,14220],
  };
  var STATUS_SERIES = {
    valid:   [51200,52100,53050,53980,54890,55820,56720,57610,58480,59360,60240,61110],
    invalid: [4820,4710,4640,4530,4460,4380,4290,4210,4140,4060,3980,3910],
    check:   [2610,2570,2520,2480,2440,2390,2350,2310,2270,2220,2180,2140],
    gendong: [1120,1140,1160,1180,1190,1210,1230,1240,1260,1280,1290,1310],
  };
  var PALETTE = ['#2f5d8a', '#3cb878', '#f0ad4e', '#d9534f'];
  var chart = null;
  function renderChart(){
    var months = parseInt(document.getElementById('cTime').value, 10);
    var labels = MONTHS.slice(-months);
    var kind = document.getElementById('cKind').value;
    document.getElementById('wrapCStatus').hidden = kind !== 'STATUS';

    var datasets;
    if (kind === 'AREA') {
      datasets = Object.keys(SERIES).map(function(k, i){
        return { label: k, data: SERIES[k].slice(-months), borderColor: PALETTE[i], backgroundColor: PALETTE[i], tension: .3 };
      });
    } else {
      var key = document.getElementById('cStatus').value;
      datasets = [{ label: t(STATUS_META[key].key), data: STATUS_SERIES[key].slice(-months),
        borderColor: PALETTE[0], backgroundColor: 'rgba(47,93,138,.15)', fill: true, tension: .3 }];
    }

    var tickColor = (getComputedStyle(document.body).getPropertyValue('--muted') || '').trim() || '#98a2b3';
    if (chart) { chart.destroy(); }
    chart = new Chart(document.getElementById('trendChart'), {
      type: 'line',
      data: { labels: labels, datasets: datasets },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { labels: { color: tickColor, boxWidth: 12 } } },
        scales: {
          x: { ticks: { color: tickColor }, grid: { display: false } },
          y: { ticks: { color: tickColor }, grid: { color: 'rgba(127,127,127,.15)' } },
        },
      },
    });
  }
  ['cKind', 'cStatus', 'cTime'].forEach(function(id){ document.getElementById(id).addEventListener('change', renderChart); });

  renderTable();
  renderChart();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var damanMappingTour = {
    id: 'dalapareg-daman-mapping',
    steps: [
      {
        target: '.sidebar nav',
        pos: 'right',
        title: 'Modul Data Management',
        desc: 'Menu Data Management memvalidasi integritas data jaringan fiber optik, memetakan relasi port OLT terhadap persebaran perangkat ODP di lapangan.'
      },
      {
        target: '#fType',
        pos: 'bottom',
        title: 'Filter Hirarki Wilayah',
        desc: 'Pilih tingkatan agregasi data: <b>Nasional</b>, <b>Regional</b> (Reg 5, 6, 7), <b>Witel</b>, atau level <b>STO</b> untuk mempersempit jangkauan rekap.'
      },
      {
        target: '.card:nth-child(2) table thead',
        pos: 'bottom',
        title: 'Tabel Rekapitulasi Validasi Port OLT',
        desc: 'Merangkum OLT Total, Slot Total, Port Total, Port Valid, Port Tidak Valid, Port Cek Lapangan, Port Gendong, dan persentase <b>% Valid</b>.'
      },
      {
        target: '#tbody tr:first-child .drill',
        pos: 'bottom',
        title: 'Drill-down Hirarki Interaktif',
        desc: 'Klik nama wilayah (misal <b>REGIONAL 6</b>) untuk melakukan drill-down langsung ke daftar Witel dan STO di bawahnya.'
      },
      {
        target: '#tbody tr:first-child .num-cell:not(.zero)',
        pos: 'top',
        title: 'Rincian Detail Port & ODP Terhubung',
        desc: 'Klik angka port pada sel tabel untuk membuka dialog detail OLT, nomor slot/port, ODP yang terhubung, ONT aktif, dan tanggal pengecekan terakhir.'
      },
      {
        target: '.card:nth-child(3) .card-head',
        pos: 'bottom',
        title: 'Grafik Tren Perkembangan Validasi',
        desc: 'Visualisasi tren bulanan (6 atau 12 bulan terakhir) berdasarkan sebaran area regional atau kategori status port (Valid, Invalid, Cek Lapangan, Gendong).'
      }
    ]
  };

  setTimeout(function(){
    DalapaTour.start(damanMappingTour);
  }, 450);
</script>

@include('project.dalapareg.feature.partials.tour-guide')
</body>
</html>
