<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Minimum Stock Opname — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .area-badge{display:inline-block;font-size:11.5px;font-weight:600;padding:5px 12px;border-radius:999px;
    background:var(--brand-50);color:var(--brand-600);margin-bottom:2px}
  [data-theme="dark"] .area-badge{background:color-mix(in srgb,var(--brand-500) 20%,transparent);color:#a7b6ff}
  tr.total-row td{font-weight:700;border-top:2px solid var(--border);background:var(--brand-50);color:var(--brand-600)}
  [data-theme="dark"] tr.total-row td{background:color-mix(in srgb,var(--brand-500) 16%,transparent);color:#a7b6ff}
  .link-btn{background:none;border:none;padding:0;color:var(--brand-600);font-weight:700;font-size:inherit;cursor:pointer;text-decoration:underline}
  .chip-row{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
  .chip{font-size:11.5px;font-weight:600;padding:5px 10px;border-radius:999px;background:var(--gray-50);color:var(--text);border:1px solid var(--border)}
  [data-theme="dark"] .chip{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'nte-minimum'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">NTE / Stock Opname</div>
    <h1 data-i18n="pageTitle">Minimum Stock Opname</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-body">
        <span class="area-badge" data-i18n="areaBadge">Area: PAMASUKA</span>
        <div class="row3" style="margin-top:12px">
          <div class="field"><label data-i18n="fRegional">Regional</label><select id="fRegional"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option></select></div>
          <div class="field"><label data-i18n="fDistrict">District</label><select id="fDistrict"><option value="">Semua</option></select></div>
          <div class="field"><label data-i18n="fDate">Tanggal</label><input type="date" id="fDate" value="2026-09-09" /></div>
        </div>
        <div class="row-actions" style="margin-top:12px">
          <button class="btn-primary" id="showBtn" data-i18n="show">Tampilkan</button>
          <button class="btn-outline" id="resetBtn" data-i18n="reset">Reset</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3>ONT RETAIL</h3></div>
      <div class="table-scroll">
        <table>
          <thead><tr><th data-i18n="hWarehouse">Warehouse</th><th data-i18n="cMinStock">Minimum Stock</th><th data-i18n="cStockScmt">Stock SCMT</th><th data-i18n="cGap">GAP Stock</th></tr></thead>
          <tbody id="retailBody"></tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3>ONT PREMIUM</h3></div>
      <div class="table-scroll">
        <table>
          <thead><tr><th data-i18n="hWarehouse">Warehouse</th><th data-i18n="cMinStock">Minimum Stock</th><th data-i18n="cStockScmt">Stock SCMT</th><th data-i18n="cGap">GAP Stock</th></tr></thead>
          <tbody id="premiumBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- DETAIL DIALOG -->
<div class="modal-backdrop" id="detailDialog">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 data-i18n="detailTitle">Detail Device Stock SCMT</h3><button class="modal-close" id="detailClose">✕</button></div>
    <div class="modal-body">
      <div class="chip-row" id="detailChips"></div>
      <div class="table-toolbar" style="padding:0 0 12px">
        <select id="detailPerPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option></select>
        <input type="text" id="detailSearch" data-i18n-ph="searchPh" placeholder="Cari serial number..." />
      </div>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th data-i18n="fSerial">Serial Number</th><th data-i18n="fDeviceType2">Device Type</th><th data-i18n="fMerk">Merk</th>
              <th data-i18n="fType">Type</th><th data-i18n="fReportTelkom">Report Telkom</th><th data-i18n="cStatus">Status</th><th data-i18n="hWarehouse">Warehouse</th>
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
      pageTitle: 'Minimum Stock Opname', areaBadge: 'Area: PAMASUKA',
      fRegional: 'Regional', fDistrict: 'District', fDate: 'Tanggal', show: 'Tampilkan', reset: 'Reset',
      hWarehouse: 'Warehouse', cMinStock: 'Minimum Stock', cStockScmt: 'Stock SCMT', cGap: 'GAP Stock', alert: 'Alert',
      detailTitle: 'Detail Device Stock SCMT', chipWarehouse: 'Warehouse: ', chipType: 'Type: ', chipDate: 'Tanggal: ',
      searchPh: 'Cari serial number...', fSerial: 'Serial Number', fDeviceType2: 'Device Type', fMerk: 'Merk',
      fType: 'Type', fReportTelkom: 'Report Telkom', cStatus: 'Status', of: 'dari', noData: 'Tidak ada data.', close: 'Tutup',
    },
    en: {
      pageTitle: 'Minimum Stock Opname', areaBadge: 'Area: PAMASUKA',
      fRegional: 'Regional', fDistrict: 'District', fDate: 'Date', show: 'Show', reset: 'Reset',
      hWarehouse: 'Warehouse', cMinStock: 'Minimum Stock', cStockScmt: 'SCMT Stock', cGap: 'Stock GAP', alert: 'Alert',
      detailTitle: 'SCMT Stock Device Detail', chipWarehouse: 'Warehouse: ', chipType: 'Type: ', chipDate: 'Date: ',
      searchPh: 'Search serial number...', fSerial: 'Serial Number', fDeviceType2: 'Device Type', fMerk: 'Brand',
      fType: 'Type', fReportTelkom: 'Report Telkom', cStatus: 'Status', of: 'of', noData: 'No data.', close: 'Close',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy dataset ---------- */
  var DISTRICTS = { KALIMANTAN: ['District Balikpapan', 'District Samarinda'], SULAWESI: ['District Makassar'] };
  var SECTIONS = {
    RETAIL: [
      { id: 'wh-bpn-kota', name: 'Warehouse Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN', min: 40, stock: 32, reports: ['DUAL BAND', 'SINGLE BAND OPEN', 'SINGLE BAND NOT OPEN'] },
      { id: 'wh-kj', name: 'Warehouse Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN', min: 15, stock: 23, reports: ['DUAL BAND', 'SINGLE BAND OPEN'] },
      { id: 'wh-smd', name: 'Warehouse Samarinda Kota', district: 'District Samarinda', regional: 'KALIMANTAN', min: 20, stock: 30, reports: ['DUAL BAND', 'SINGLE BAND NOT OPEN'] },
      { id: 'wh-mks', name: 'Warehouse Makassar Pusat', district: 'District Makassar', regional: 'SULAWESI', min: 15, stock: 37, reports: ['DUAL BAND', 'SINGLE BAND OPEN', 'SINGLE BAND NOT OPEN'] },
    ],
    PREMIUM: [
      { id: 'wh-bpn-kota', name: 'Warehouse Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN', min: 10, stock: 6, reports: ['ONT PREMIUM'] },
      { id: 'wh-kj', name: 'Warehouse Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN', min: 5, stock: 5, reports: ['ONT PREMIUM'] },
      { id: 'wh-smd', name: 'Warehouse Samarinda Kota', district: 'District Samarinda', regional: 'KALIMANTAN', min: 8, stock: 9, reports: ['ONT PREMIUM'] },
      { id: 'wh-mks', name: 'Warehouse Makassar Pusat', district: 'District Makassar', regional: 'SULAWESI', min: 6, stock: 20, reports: ['ONT PREMIUM'] },
    ],
  };

  var fRegional = document.getElementById('fRegional'), fDistrict = document.getElementById('fDistrict');
  fRegional.addEventListener('change', function(){
    var r = fRegional.value;
    fDistrict.innerHTML = '<option value="">' + (LANG === 'en' ? 'All' : 'Semua') + '</option>' +
      (r ? DISTRICTS[r] : [].concat(DISTRICTS.KALIMANTAN, DISTRICTS.SULAWESI)).map(function(d){ return '<option>' + d + '</option>'; }).join('');
    renderAll();
  });

  function gapPill(gap){
    var cls = gap < 0 ? 'pill-red' : gap <= 10 ? 'pill-amber' : 'pill-green';
    return '<span class="pill pill-sq ' + cls + '">' + gap + '</span>';
  }

  function renderSection(sectionKey, tbodyId){
    var regionalFilter = fRegional.value, districtFilter = fDistrict.value;
    var rows = SECTIONS[sectionKey].filter(function(w){
      return (!regionalFilter || w.regional === regionalFilter) && (!districtFilter || w.district === districtFilter);
    });
    document.getElementById(tbodyId).innerHTML = rows.length ? rows.map(function(w){
      var gap = w.stock - w.min, belowMin = gap < 0;
      var whCell = w.name + (belowMin ? ' <span class="pill pill-sq pill-red">' + t('alert') + '</span>' : '');
      var stockCell = w.stock > 0
        ? '<button type="button" class="link-btn" data-detail="' + sectionKey + '|' + w.id + '">' + w.stock + '</button>'
        : w.stock;
      return '<tr><td>' + whCell + '</td><td>' + w.min + '</td><td>' + stockCell + '</td><td>' + gapPill(gap) + '</td></tr>';
    }).join('') : '<tr><td colspan="4" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';
    var totalMin = rows.reduce(function(a, w){ return a + w.min; }, 0);
    var totalStock = rows.reduce(function(a, w){ return a + w.stock; }, 0);
    document.getElementById(tbodyId).innerHTML += '<tr class="total-row"><td>Total</td><td>' + totalMin + '</td><td>' + totalStock + '</td><td>' + (totalStock - totalMin) + '</td></tr>';
  }

  function renderAll(){
    renderSection('RETAIL', 'retailBody');
    renderSection('PREMIUM', 'premiumBody');
  }

  document.getElementById('showBtn').addEventListener('click', renderAll);
  document.getElementById('resetBtn').addEventListener('click', function(){
    fRegional.value = ''; fDistrict.innerHTML = '<option value="">Semua</option>'; renderAll();
  });

  /* ---------- detail dialog ---------- */
  var detailDialog = document.getElementById('detailDialog');
  var detailRows = [], detailPage = 1;
  function pad3(n){ return (n < 10 ? '00' : n < 100 ? '0' : '') + n; }

  function genDetailRows(w, sectionKey){
    var out = [];
    for (var i = 1; i <= w.stock; i++) {
      out.push({
        serial: 'SN-' + sectionKey + '-' + w.id.toUpperCase() + '-' + pad3(i),
        deviceType: sectionKey === 'RETAIL' ? 'ONT Retail' : 'ONT Premium',
        merk: ['ZTE', 'Huawei', 'Fiberhome'][i % 3],
        type: sectionKey,
        report: w.reports[i % w.reports.length],
        status: i % 3 === 0 ? 'REFURBISH' : 'NEW',
        warehouse: w.name,
      });
    }
    return out;
  }

  document.querySelectorAll('#retailBody, #premiumBody').forEach(function(tbody){
    tbody.addEventListener('click', function(e){
      var b = e.target.closest('[data-detail]');
      if (!b) { return; }
      var parts = b.dataset.detail.split('|'), sectionKey = parts[0], whId = parts[1];
      var w = SECTIONS[sectionKey].filter(function(x){ return x.id === whId; })[0];
      detailRows = genDetailRows(w, sectionKey);
      detailPage = 1;
      document.getElementById('detailChips').innerHTML =
        '<span class="chip">' + t('chipWarehouse') + w.name + '</span>' +
        '<span class="chip">' + t('chipType') + sectionKey + '</span>' +
        '<span class="chip">' + t('chipDate') + document.getElementById('fDate').value + '</span>';
      document.getElementById('detailSearch').value = '';
      renderDetailTable();
      detailDialog.classList.add('show');
    });
  });

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
        '<td>' + r.type + '</td><td>' + r.report + '</td>' +
        '<td><span class="pill pill-sq ' + (r.status === 'NEW' ? 'pill-green' : 'pill-amber') + '">' + r.status + '</span></td>' +
        '<td>' + r.warehouse + '</td></tr>';
    }).join('') : '<tr><td colspan="7" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';
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
  document.getElementById('detailClose').addEventListener('click', function(){ detailDialog.classList.remove('show'); });
  document.getElementById('detailDone').addEventListener('click', function(){ detailDialog.classList.remove('show'); });

  function onLangChange(){ renderAll(); }
  renderAll();
  applyLang();
</script>
</body>
</html>
