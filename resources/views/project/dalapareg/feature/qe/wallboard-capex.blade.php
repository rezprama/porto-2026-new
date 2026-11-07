<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Capex — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.1/chart.umd.min.js"></script>
<style>
  .num{text-align:right;font-variant-numeric:tabular-nums}
  th.num{text-align:right}
  .pct-bar{height:6px;border-radius:3px;background:var(--gray-200);overflow:hidden;margin-top:4px;min-width:70px}
  .pct-bar > i{display:block;height:100%}
  .drill{background:none;border:none;font:inherit;font-weight:700;color:var(--brand-600);cursor:pointer;padding:0}
  .drill:hover{text-decoration:underline}
  .chart-wrap{height:320px}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-capex'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="crumbCapex">Wallboard Capex</span></div>
    <h1 data-i18n="pageTitle">Capex</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head"><h3 data-i18n="panelTitle">Serapan Anggaran CAPEX</h3></div>
      <div class="tabs">
        <button class="on" data-tab="#tabBoard" data-i18n="tabBoard">Wallboard</button>
        <button data-tab="#tabInput" data-i18n="tabInput">Input Data</button>
      </div>

      <div id="tabBoard">
        <div class="filter-bar">
          <div class="field narrow"><label data-i18n="year">Tahun</label><select id="fYear"><option>2026</option><option>2025</option></select></div>
          <div class="field">
            <label data-i18n="period">Periode</label>
            <select id="fPeriod">
              <option value="" data-i18n="allPeriod">Semua Periode</option>
              <option value="TW1">TRIWULAN 1</option><option value="TW2">TRIWULAN 2</option>
              <option value="TW3" selected>TRIWULAN 3</option><option value="TW4">TRIWULAN 4</option>
            </select>
          </div>
          <div class="field wide">
            <label>Project</label>
            <select id="fProject"><option value="" data-i18n="allProject">ALL</option></select>
          </div>
          <div class="row-actions">
            <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
            <button class="btn-outline" id="exportBtn" data-i18n="download">Download</button>
          </div>
        </div>

        <div class="card-body" style="padding-top:0">
          <div class="stat-grid" id="statGrid"></div>
        </div>

        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr>
                <th rowspan="2">Distrik</th>
                <th rowspan="2" class="num">NET</th>
                <th colspan="2" style="text-align:center" data-i18n="realisasi">Realisasi</th>
                <th rowspan="2" class="num">Saldo</th>
                <th rowspan="2" class="num" data-i18n="serapan">% Serapan</th>
              </tr>
              <tr>
                <th class="num" data-i18n="approveTl">Approve TL</th>
                <th class="num" data-i18n="approveQe">Approve QE</th>
              </tr>
            </thead>
            <tbody id="tbody"></tbody>
          </table>
        </div>
        <div class="card-note" data-i18n="tableNote">Klik nama distrik untuk melihat rincian project pada periode terpilih.</div>
      </div>

      <div id="tabInput" hidden>
        <div class="card-body">
          <div class="row3">
            <div class="field"><label data-i18n="projectName">Nama Project</label><input type="text" id="iProject" data-i18n-ph="projectPh" placeholder="Contoh: RECOVERY ODP 2026" /></div>
            <div class="field"><label data-i18n="period">Periode</label><select id="iPeriod"><option>TRIWULAN 1</option><option>TRIWULAN 2</option><option selected>TRIWULAN 3</option><option>TRIWULAN 4</option></select></div>
            <div class="field"><label>Distrik</label><select id="iDistrict"></select></div>
          </div>
          <div class="row3">
            <div class="field"><label data-i18n="netValue">Nilai NET (Rp)</label><input type="number" id="iNet" min="0" step="1000000" value="500000000" /></div>
            <div class="field"><label data-i18n="year">Tahun</label><select id="iYear"><option>2026</option><option>2025</option></select></div>
            <div class="field" style="align-self:end"><button class="btn-primary" id="addBtn" style="width:100%" data-i18n="addPeriod">Tambah Periode Project</button></div>
          </div>
        </div>
        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr>
                <th data-i18n="projectName">Nama Project</th><th data-i18n="period">Periode</th><th>Distrik</th>
                <th data-i18n="year">Tahun</th><th class="num">NET</th><th data-i18n="cAction">Action</th>
              </tr>
            </thead>
            <tbody id="periodBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3 data-i18n="chartTitle">NET vs Realisasi per Distrik</h3></div>
      <div class="card-body"><div class="chart-wrap"><canvas id="capexChart"></canvas></div></div>
    </div>
  </div>
</main>

<!-- DETAIL DISTRICT -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-lg">
    <div class="modal-head"><h3 id="detailTitle">Detail</h3><button class="modal-close" id="detailX">✕</button></div>
    <div class="modal-body">
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>Project</th><th data-i18n="period">Periode</th>
              <th class="num">NET</th><th class="num" data-i18n="approveTl">Approve TL</th>
              <th class="num" data-i18n="approveQe">Approve QE</th><th class="num">Saldo</th>
            </tr>
          </thead>
          <tbody id="detailBody"></tbody>
        </table>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="detailClose" data-i18n="close">Tutup</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    pageTitle: 'Capex', crumbCapex: 'Wallboard Capex', panelTitle: 'Serapan Anggaran CAPEX',
    tabBoard: 'Wallboard', tabInput: 'Input Data',
    year: 'Tahun', period: 'Periode', allPeriod: 'Semua Periode', allProject: 'SEMUA PROJECT',
    realisasi: 'Realisasi', approveTl: 'Approve TL', approveQe: 'Approve QE', serapan: '% Serapan',
    tableNote: 'Klik nama distrik untuk melihat rincian project pada periode terpilih.',
    sNet: 'Total NET', sTl: 'Realisasi Approve TL', sQe: 'Realisasi Approve QE', sSaldo: 'Saldo', sSerapan: '% Serapan',
    projectName: 'Nama Project', projectPh: 'Contoh: RECOVERY ODP 2026', netValue: 'Nilai NET (Rp)',
    addPeriod: 'Tambah Periode Project', cAction: 'Action',
    chartTitle: 'NET vs Realisasi per Distrik', dsNet: 'NET', dsTl: 'Approve TL', dsQe: 'Approve QE',
    detailTitle: 'Rincian Project', delete: 'Hapus',
    addOk: 'Periode project ditambahkan (demo, data lokal).', addInvalid: 'Nama project dan nilai NET wajib diisi.',
    deleted: 'Periode project dihapus.',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')

<script>
  var DISTRICTS = ['DISTRICT BALIKPAPAN', 'DISTRICT SAMARINDA', 'DISTRICT BANJARMASIN', 'DISTRICT PALANGKARAYA', 'DISTRICT TARAKAN'];
  var PROJECTS = ['RECOVERY ODP 2026', 'GAMAS KABEL UDARA', 'RELOKASI ALPRO', 'SOLUSI GGN NODE B', 'REMO UNDERSPEC'];
  var PERIODS = ['TW1', 'TW2', 'TW3', 'TW4'];
  var PERIOD_LABEL = { TW1: 'TRIWULAN 1', TW2: 'TRIWULAN 2', TW3: 'TRIWULAN 3', TW4: 'TRIWULAN 4' };

  /* ponytail: one deterministic seed so the demo numbers never reshuffle between renders. */
  function seeded(a, b, c){ return ((a * 73856093) ^ (b * 19349663) ^ (c * 83492791)) >>> 0; }

  var ROWS = [];
  DISTRICTS.forEach(function(d, di){
    PROJECTS.forEach(function(p, pi){
      PERIODS.forEach(function(per, qi){
        var s = seeded(di + 1, pi + 1, qi + 1);
        var net = (300 + (s % 12) * 50) * 1000000;
        var qe = Math.round(net * (0.35 + ((s >> 3) % 50) / 100));
        var tl = Math.min(net, qe + Math.round(net * (((s >> 7) % 18) / 100)));
        ROWS.push({ district: d, project: p, period: per, year: 2026, net: net, tl: tl, qe: qe });
      });
    });
  });

  var fYear = document.getElementById('fYear'), fPeriod = document.getElementById('fPeriod'), fProject = document.getElementById('fProject');
  PROJECTS.forEach(function(p){
    var o = document.createElement('option');
    o.textContent = p;
    fProject.appendChild(o);
  });
  document.getElementById('iDistrict').innerHTML = DISTRICTS.map(function(d){ return '<option>' + d + '</option>'; }).join('');

  function filtered(){
    return ROWS.filter(function(r){
      if (String(r.year) !== fYear.value) { return false; }
      if (fPeriod.value && r.period !== fPeriod.value) { return false; }
      if (fProject.value && r.project !== fProject.value) { return false; }
      return true;
    });
  }

  function byDistrict(rows){
    return DISTRICTS.map(function(d){
      var own = rows.filter(function(r){ return r.district === d; });
      return {
        district: d,
        net: own.reduce(function(s, r){ return s + r.net; }, 0),
        tl: own.reduce(function(s, r){ return s + r.tl; }, 0),
        qe: own.reduce(function(s, r){ return s + r.qe; }, 0),
      };
    }).filter(function(x){ return x.net > 0; });
  }

  function pctBar(pct){
    var color = pct >= 85 ? '#3cb878' : (pct >= 60 ? '#f0ad4e' : '#d9534f');
    return pct + '%<div class="pct-bar"><i style="width:' + Math.min(100, pct) + '%;background:' + color + '"></i></div>';
  }

  function renderBoard(){
    var rows = byDistrict(filtered());
    var tNet = rows.reduce(function(s, r){ return s + r.net; }, 0);
    var tTl = rows.reduce(function(s, r){ return s + r.tl; }, 0);
    var tQe = rows.reduce(function(s, r){ return s + r.qe; }, 0);

    document.getElementById('statGrid').innerHTML = [
      ['sNet', rupiah(tNet), ''],
      ['sTl', rupiah(tTl), tNet ? Math.round(tTl / tNet * 100) + '%' : '0%'],
      ['sQe', rupiah(tQe), tNet ? Math.round(tQe / tNet * 100) + '%' : '0%'],
      ['sSaldo', rupiah(tNet - tQe), ''],
    ].map(function(s){
      return '<div class="stat"><div class="k">' + t(s[0]) + '</div><div class="v">' + s[1] + '</div>' +
        (s[2] ? '<div class="s">' + s[2] + '</div>' : '') + '</div>';
    }).join('');

    document.getElementById('tbody').innerHTML = rows.map(function(r){
      var pct = r.net ? Math.round(r.qe / r.net * 100) : 0;
      return '<tr>' +
        '<td><button class="drill" data-district="' + r.district + '">' + r.district + '</button></td>' +
        '<td class="num">' + rupiah(r.net) + '</td>' +
        '<td class="num">' + rupiah(r.tl) + '</td>' +
        '<td class="num">' + rupiah(r.qe) + '</td>' +
        '<td class="num">' + rupiah(r.net - r.qe) + '</td>' +
        '<td class="num">' + pctBar(pct) + '</td></tr>';
    }).join('');

    var tPct = tNet ? Math.round(tQe / tNet * 100) : 0;
    document.getElementById('tbody').insertAdjacentHTML('beforeend',
      '<tr class="total-row"><td>' + t('total') + '</td><td class="num">' + rupiah(tNet) + '</td>' +
      '<td class="num">' + rupiah(tTl) + '</td><td class="num">' + rupiah(tQe) + '</td>' +
      '<td class="num">' + rupiah(tNet - tQe) + '</td><td class="num">' + tPct + '%</td></tr>');

    renderChart(rows);
  }

  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-district]');
    if (!b) { return; }
    var d = b.dataset.district;
    var rows = filtered().filter(function(r){ return r.district === d; });
    document.getElementById('detailTitle').textContent = t('detailTitle') + ' — ' + d;
    document.getElementById('detailBody').innerHTML = rows.map(function(r){
      return '<tr><td>' + r.project + '</td><td>' + PERIOD_LABEL[r.period] + '</td>' +
        '<td class="num">' + rupiah(r.net) + '</td><td class="num">' + rupiah(r.tl) + '</td>' +
        '<td class="num">' + rupiah(r.qe) + '</td><td class="num">' + rupiah(r.net - r.qe) + '</td></tr>';
    }).join('');
    document.getElementById('detailModal').classList.add('show');
  });
  ['detailX', 'detailClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ document.getElementById('detailModal').classList.remove('show'); });
  });

  /* ---------- chart ---------- */
  var chart = null;
  function renderChart(rows){
    var tick = (getComputedStyle(document.body).getPropertyValue('--muted') || '').trim() || '#98a2b3';
    if (chart) { chart.destroy(); }
    chart = new Chart(document.getElementById('capexChart'), {
      type: 'bar',
      data: {
        labels: rows.map(function(r){ return r.district.replace('DISTRICT ', ''); }),
        datasets: [
          { label: t('dsNet'), data: rows.map(function(r){ return r.net / 1e6; }), backgroundColor: '#2f5d8a' },
          { label: t('dsTl'), data: rows.map(function(r){ return r.tl / 1e6; }), backgroundColor: '#f0ad4e' },
          { label: t('dsQe'), data: rows.map(function(r){ return r.qe / 1e6; }), backgroundColor: '#3cb878' },
        ],
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
          legend: { labels: { color: tick, boxWidth: 12 } },
          tooltip: { callbacks: { label: function(c){ return c.dataset.label + ': ' + rupiah(c.parsed.y * 1e6); } } },
        },
        scales: {
          x: { ticks: { color: tick }, grid: { display: false } },
          y: { ticks: { color: tick, callback: function(v){ return v + ' jt'; } }, grid: { color: 'rgba(127,127,127,.15)' } },
        },
      },
    });
  }

  /* ---------- input tab ---------- */
  function renderPeriods(){
    var rows = ROWS.filter(function(r){ return r.custom; });
    document.getElementById('periodBody').innerHTML = rows.length ? rows.map(function(r){
      return '<tr><td>' + r.project + '</td><td>' + PERIOD_LABEL[r.period] + '</td><td>' + r.district + '</td>' +
        '<td>' + r.year + '</td><td class="num">' + rupiah(r.net) + '</td>' +
        '<td><button class="mini-btn red" data-del="' + ROWS.indexOf(r) + '">' + t('delete') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="6" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
  }
  document.getElementById('addBtn').addEventListener('click', function(){
    var name = document.getElementById('iProject').value.trim();
    var net = parseInt(document.getElementById('iNet').value, 10);
    if (!name || !net) { toast(t('addInvalid')); return; }
    var periodLabel = document.getElementById('iPeriod').value;
    var period = PERIODS[['TRIWULAN 1', 'TRIWULAN 2', 'TRIWULAN 3', 'TRIWULAN 4'].indexOf(periodLabel)];
    ROWS.push({
      district: document.getElementById('iDistrict').value, project: name, period: period,
      year: parseInt(document.getElementById('iYear').value, 10), net: net, tl: 0, qe: 0, custom: true,
    });
    if (PROJECTS.indexOf(name) === -1) {
      PROJECTS.push(name);
      var o = document.createElement('option');
      o.textContent = name;
      fProject.appendChild(o);
    }
    document.getElementById('iProject').value = '';
    renderPeriods();
    renderBoard();
    toast(t('addOk'));
  });
  document.getElementById('periodBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-del]');
    if (!b) { return; }
    ROWS.splice(parseInt(b.dataset.del, 10), 1);
    renderPeriods();
    renderBoard();
    toast(t('deleted'));
  });

  [fYear, fPeriod, fProject].forEach(function(el){ el.addEventListener('change', renderBoard); });
  document.getElementById('filterBtn').addEventListener('click', renderBoard);
  document.getElementById('exportBtn').addEventListener('click', function(){ toast(t('demoOnly')); });

  renderBoard();
  renderPeriods();
  applyLang();
</script>
</body>
</html>
