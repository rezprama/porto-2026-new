<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Monitoring Kelistrikan GCU OLT — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'gcu-electrical'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">NE / GCU OLT</div>
    <h1 data-i18n="pageTitle">Monitoring Kelistrikan</h1>
  </div>

  <div class="stack">
    <div class="card" id="elFilterCard">
      <div class="card-body">
        <div class="row3" id="elFilterRowRegion">
          <div class="field"><label>Area</label><select id="fArea"><option>PAMASUKA</option></select></div>
          <div class="field"><label>Regional</label><select id="fRegional"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option><option>KTI</option></select></div>
          <div class="field"><label>District</label><select id="fDistrict"><option value="">Semua</option><option>District Balikpapan</option><option>District Samarinda</option><option>District Makassar</option></select></div>
        </div>
        <div class="row3" id="elFilterRowPln">
          <div class="field"><label data-i18n="fType">Type</label><select id="fType"><option value="">ALL</option><option>INDOOR</option><option>OUTDOOR</option></select></div>
          <div class="field"><label data-i18n="fPln">Status PLN</label><select id="fPln"><option value="">ALL</option><option>Pascabayar</option><option>Prabayar</option></select></div>
          <div class="field" style="align-self:end"><button class="btn-primary" id="searchBtn" style="width:100%" data-i18n="search">Cari</button></div>
        </div>
      </div>
    </div>

    <div class="card" id="elTableCard">
      <div class="table-toolbar" id="elTableToolbar">
        <select id="perPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari hostname / STO..." />
      </div>
      <div class="table-scroll">
        <table id="elTable">
          <thead>
            <tr>
              <th data-sort="hostname">Hostname<span class="arr"></span></th>
              <th data-sort="ip">IP OLT Hostname<span class="arr"></span></th>
              <th data-sort="sto">STO<span class="arr"></span></th>
              <th data-sort="district"><span data-i18n="cDistrict">Distrik</span><span class="arr"></span></th>
              <th data-i18n="cLocation">Lokasi</th>
              <th data-sort="plnStatus"><span data-i18n="cPlnStatus">Status PLN</span><span class="arr"></span></th>
              <th data-i18n="cPlnId">ID PLN Pelanggan</th>
              <th data-sort="kwhLast"><span data-i18n="cKwhLast">PLN kWh Terakhir</span><span class="arr"></span></th>
              <th data-sort="tglKwh"><span data-i18n="cTglKwh">Tanggal Input kWh</span><span class="arr"></span></th>
              <th data-i18n="cAction">Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
    </div>
  </div>
</main>

<!-- DETAIL ELECTRICAL MODAL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-lg">
    <div class="modal-head"><h3 data-i18n="detailTitle">Detail Kelistrikan OLT</h3><button class="modal-close" id="detailClose">✕</button></div>
    <div class="modal-body">
      <div class="wod-section">
        <div class="kv-grid" id="dSummary"></div>
      </div>
      <div class="wod-cols">
        <div class="wod-section" style="flex:1">
          <b data-i18n="secPln">Informasi PLN</b>
          <div class="kv-grid kv-grid-1" id="dPln"></div>
        </div>
        <div class="wod-section" style="flex:1">
          <b data-i18n="secLoc">Informasi Lokasi</b>
          <div class="kv-grid kv-grid-1" id="dLoc"></div>
          <button class="btn-outline" id="dMapBtn" style="margin-top:10px" data-i18n="viewMap">Lihat Peta</button>
        </div>
      </div>
      <div class="wod-section">
        <b data-i18n="secHistory">Histori PLN</b>
        <div class="table-scroll">
          <table>
            <thead><tr>
              <th data-i18n="cTglKwh">Tanggal Input</th><th data-i18n="cPlnId">ID Pelanggan</th><th data-i18n="cMeteran">No. Meteran</th>
              <th data-i18n="cKwhAwal">kWh Awal</th><th data-i18n="cKwhLast">kWh Terakhir</th><th data-i18n="cKwhUpdate">kWh Update</th><th data-i18n="cAction">Aksi</th>
            </tr></thead>
            <tbody id="dHistory"></tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="detailDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Monitoring Kelistrikan', fType: 'Type', fPln: 'Status PLN',
      searchPh: 'Cari hostname / STO...', cDistrict: 'Distrik', cLocation: 'Lokasi',
      cPlnStatus: 'Status PLN', cPlnId: 'ID PLN Pelanggan', cKwhLast: 'PLN kWh Terakhir', cTglKwh: 'Tanggal Input kWh',
      cAction: 'Aksi', viewLoc: 'Lihat Peta', noLoc: '-',
      detailTitle: 'Detail Kelistrikan OLT', secPln: 'Informasi PLN', secLoc: 'Informasi Lokasi', secHistory: 'Histori PLN',
      viewMap: 'Lihat Peta', cMeteran: 'No. Meteran', cKwhAwal: 'kWh Awal', cKwhUpdate: 'kWh Update',
      before: 'Sebelum', after: 'Sesudah', mapToast: 'Peta lokasi: ',
    },
    en: {
      pageTitle: 'Electrical Monitoring', fType: 'Type', fPln: 'PLN Status',
      searchPh: 'Search hostname / STO...', cDistrict: 'District', cLocation: 'Location',
      cPlnStatus: 'PLN Status', cPlnId: 'PLN Customer ID', cKwhLast: 'PLN Last kWh', cTglKwh: 'kWh Input Date',
      cAction: 'Action', viewLoc: 'View Map', noLoc: '-',
      detailTitle: 'OLT Electrical Detail', secPln: 'PLN Information', secLoc: 'Location Information', secHistory: 'PLN History',
      viewMap: 'View Map', cMeteran: 'Meter Number', cKwhAwal: 'Initial kWh', cKwhUpdate: 'Updated kWh',
      before: 'Before', after: 'After', mapToast: 'Location on map: ',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  var OLTS = [
    { hostname: 'OLT-BPN-KOTA-01', ip: '10.14.20.11', sto: 'STO Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN', type: 'INDOOR', koordinat: '-1.2670, 116.8310', plnStatus: 'Pascabayar', plnId: '541200112233', meteran: 'MTR-88231', kwhAwal: 1200, kwhLast: 1450, kwhUpdate: 1465, tglKwh: '2026-09-01' },
    { hostname: 'OLT-BPN-KJ-02', ip: '10.14.20.21', sto: 'STO Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN', type: 'OUTDOOR', koordinat: '-1.1200, 116.8360', plnStatus: 'Prabayar', plnId: '541200119911', meteran: 'MTR-88422', kwhAwal: 800, kwhLast: 910, kwhUpdate: 918, tglKwh: '2026-09-02' },
    { hostname: 'OLT-BPN-SPG-03', ip: '10.14.20.31', sto: 'STO Sepinggan', district: 'District Balikpapan', regional: 'KALIMANTAN', type: 'OUTDOOR', koordinat: '-1.2620, 116.8850', plnStatus: 'Pascabayar', plnId: '541200145566', meteran: 'MTR-88519', kwhAwal: 990, kwhLast: 1055, kwhUpdate: 1060, tglKwh: '2026-08-29' },
    { hostname: 'OLT-BPN-GS-04', ip: '10.14.20.41', sto: 'STO Gunung Sari', district: 'District Balikpapan', regional: 'KALIMANTAN', type: 'INDOOR', koordinat: '-1.2480, 116.8210', plnStatus: 'Prabayar', plnId: '541200156789', meteran: 'MTR-88600', kwhAwal: 500, kwhLast: 620, kwhUpdate: 626, tglKwh: '2026-08-27' },
    { hostname: 'OLT-SMD-KOTA-01', ip: '10.14.30.11', sto: 'STO Samarinda Kota', district: 'District Samarinda', regional: 'KALIMANTAN', type: 'INDOOR', koordinat: '-0.5040, 117.1450', plnStatus: 'Pascabayar', plnId: '541200167712', meteran: 'MTR-89011', kwhAwal: 1100, kwhLast: 1230, kwhUpdate: 1235, tglKwh: '2026-08-30' },
    { hostname: 'OLT-MKS-PST-01', ip: '10.14.40.11', sto: 'STO Makassar Pusat', district: 'District Makassar', regional: 'SULAWESI', type: 'OUTDOOR', koordinat: '-5.1460, 119.4220', plnStatus: 'Pascabayar', plnId: '541200178823', meteran: 'MTR-89250', kwhAwal: 1400, kwhLast: 1580, kwhUpdate: 1590, tglKwh: '2026-08-31' },
  ];
  var HISTORY = {
    'OLT-BPN-KOTA-01': [
      { tgl: '2026-09-01', id: '541200112233', meteran: 'MTR-88231', awal: 1200, last: 1450, update: 1465 },
      { tgl: '2026-08-01', id: '541200112233', meteran: 'MTR-88231', awal: 1010, last: 1200, update: 1200 },
    ],
  };

  var sortKey = 'hostname', sortDir = 'asc', currentPage = 1;
  var searchInput = document.getElementById('searchInput'), perPageSel = document.getElementById('perPage');
  var fRegional = document.getElementById('fRegional'), fDistrict = document.getElementById('fDistrict');
  var fType = document.getElementById('fType'), fPln = document.getElementById('fPln');

  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    var rows = OLTS.slice();
    if (fRegional.value) { rows = rows.filter(function(o){ return o.regional === fRegional.value; }); }
    if (fDistrict.value) { rows = rows.filter(function(o){ return o.district === fDistrict.value; }); }
    if (fType.value) { rows = rows.filter(function(o){ return o.type === fType.value; }); }
    if (fPln.value) { rows = rows.filter(function(o){ return o.plnStatus === fPln.value; }); }
    if (q) { rows = rows.filter(function(o){ return o.hostname.toLowerCase().indexOf(q) !== -1 || o.sto.toLowerCase().indexOf(q) !== -1; }); }
    rows.sort(function(a, b){
      var av = a[sortKey], bv = b[sortKey];
      if (av < bv) { return sortDir === 'asc' ? -1 : 1; }
      if (av > bv) { return sortDir === 'asc' ? 1 : -1; }
      return 0;
    });
    return rows;
  }

  function renderTable(){
    var rows = getFiltered();
    var perPage = parseInt(perPageSel.value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    if (currentPage > totalPages) { currentPage = totalPages; }
    var start = (currentPage - 1) * perPage;
    var page = rows.slice(start, start + perPage);

    document.getElementById('tbody').innerHTML = page.length ? page.map(function(o, i){
      var idx = OLTS.indexOf(o);
      return '<tr><td class="mono-cell">' + o.hostname + '</td><td class="mono-cell">' + o.ip + '</td><td>' + o.sto + '</td>' +
        '<td>' + o.district + '</td>' +
        '<td>' + (o.koordinat ? '<button class="mini-btn brand" data-map="' + idx + '">' + t('viewLoc') + '</button>' : t('noLoc')) + '</td>' +
        '<td>' + o.plnStatus + '</td><td class="mono-cell">' + o.plnId + '</td>' +
        '<td>' + o.kwhLast + '</td><td>' + o.tglKwh + '</td>' +
        '<td><div class="row-actions">' +
          '<button class="mini-btn slate" data-detail="' + idx + '">' + t('detail') + '</button>' +
          '<button class="mini-btn brand" data-ev="' + idx + '" data-kind="before">' + t('before') + '</button>' +
          '<button class="mini-btn amber" data-ev="' + idx + '" data-kind="after">' + t('after') + '</button>' +
        '</div></td></tr>';
    }).join('') : '<tr><td colspan="10" style="text-align:center;color:var(--muted)">-</td></tr>';

    var from = rows.length ? start + 1 : 0, to = Math.min(start + perPage, rows.length);
    document.getElementById('pageInfo').textContent = from + '–' + to + ' ' + t('of') + ' ' + rows.length;
    var pager = document.getElementById('pager');
    pager.innerHTML = '';
    for (var p = 1; p <= totalPages; p++) {
      var btn = document.createElement('button');
      btn.textContent = p;
      if (p === currentPage) { btn.classList.add('on'); }
      (function(pp){ btn.addEventListener('click', function(){ currentPage = pp; renderTable(); }); })(p);
      pager.appendChild(btn);
    }
    document.querySelectorAll('thead th[data-sort]').forEach(function(th){
      th.querySelector('.arr').textContent = th.dataset.sort === sortKey ? (sortDir === 'asc' ? '▲' : '▼') : '';
    });
  }

  document.querySelectorAll('thead th[data-sort]').forEach(function(th){
    th.addEventListener('click', function(){
      var key = th.dataset.sort;
      if (sortKey === key) { sortDir = sortDir === 'asc' ? 'desc' : 'asc'; } else { sortKey = key; sortDir = 'asc'; }
      renderTable();
    });
  });
  [fRegional, fDistrict, fType, fPln, perPageSel].forEach(function(el){ el.addEventListener('change', function(){ currentPage = 1; renderTable(); }); });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('searchBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });

  var detailModal = document.getElementById('detailModal'), currentDetailOlt = null;
  function openDetail(o){
    currentDetailOlt = o;
    document.getElementById('dSummary').innerHTML = kvHtml([
      ['Hostname', o.hostname], ['IP OLT Hostname', o.ip], ['STO', o.sto], [t('cDistrict'), o.district],
    ]);
    document.getElementById('dPln').innerHTML = kvHtml([
      [t('cPlnStatus'), o.plnStatus], [t('cPlnId'), o.plnId], [t('cMeteran'), o.meteran],
      [t('cKwhAwal'), o.kwhAwal], [t('cKwhLast'), o.kwhLast], [t('cKwhUpdate'), o.kwhUpdate], [t('cTglKwh'), o.tglKwh],
    ]);
    document.getElementById('dLoc').innerHTML = kvHtml([['Longitude / Latitude', o.koordinat]]);
    document.getElementById('dMapBtn').onclick = function(){ toast(t('mapToast') + o.koordinat); };
    var hist = HISTORY[o.hostname] || [{ tgl: o.tglKwh, id: o.plnId, meteran: o.meteran, awal: o.kwhAwal, last: o.kwhLast, update: o.kwhUpdate }];
    document.getElementById('dHistory').innerHTML = hist.map(function(h){
      return '<tr><td>' + h.tgl + '</td><td class="mono-cell">' + h.id + '</td><td class="mono-cell">' + h.meteran + '</td>' +
        '<td>' + h.awal + '</td><td>' + h.last + '</td><td>' + h.update + '</td>' +
        '<td><div class="row-actions"><button class="mini-btn brand" data-hist-ev="before">' + t('before') + '</button><button class="mini-btn amber" data-hist-ev="after">' + t('after') + '</button></div></td></tr>';
    }).join('');
    detailModal.classList.add('show');
  }
  function showMeterEvidence(o, kind){
    var src = '/images/tifreg/evidence/GCU/meter-' + kind + '.svg';
    var cap = o.meteran + ' — ' + t(kind);
    openLightbox(src, cap);
  }
  document.getElementById('tbody').addEventListener('click', function(e){
    var d = e.target.closest('[data-detail]');
    if (d) { openDetail(OLTS[parseInt(d.dataset.detail, 10)]); return; }
    var m = e.target.closest('[data-map]');
    if (m) { toast(t('mapToast') + OLTS[parseInt(m.dataset.map, 10)].koordinat); return; }
    var ev = e.target.closest('[data-ev]');
    if (ev) { showMeterEvidence(OLTS[parseInt(ev.dataset.ev, 10)], ev.dataset.kind); }
  });
  document.getElementById('dHistory').addEventListener('click', function(e){
    var h = e.target.closest('[data-hist-ev]');
    if (h && currentDetailOlt) { showMeterEvidence(currentDetailOlt, h.dataset.histEv); }
  });
  document.getElementById('detailClose').addEventListener('click', function(){ detailModal.classList.remove('show'); });
  document.getElementById('detailDone').addEventListener('click', function(){ detailModal.classList.remove('show'); });

  function onLangChange(){ renderTable(); }
  renderTable();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var gcuElectricalTour = {
    id: 'tifreg-gcu-electrical',
    steps: [
      {
        target: '#elFilterRowRegion',
        pos: 'bottom',
        title: { id: 'Filter Wilayah & Regional', en: 'Territory & Region Filter' },
        desc: {
          id: 'Saring pantauan data kelistrikan OLT berdasarkan hierarki Area (PAMASUKA), Regional, hingga Distrik kerja.',
          en: 'Filter OLT electrical data by Area (PAMASUKA), Regional territories, down to operational Districts.'
        }
      },
      {
        target: '#elFilterRowPln',
        pos: 'bottom',
        title: { id: 'Filter Tipe & Jenis Meteran PLN', en: 'Type & PLN Metering Status' },
        desc: {
          id: 'Saring berdasarkan peletakan OLT (INDOOR / OUTDOOR) dan sistem kelistrikan PLN: Pascabayar atau Prabayar (Token).',
          en: 'Filter by OLT placement (INDOOR / OUTDOOR) and utility status: Postpaid or Prepaid.'
        }
      },
      {
        target: '#elTableToolbar',
        pos: 'bottom',
        title: { id: 'Toolbar Pencarian Cepat', en: 'Quick Search Toolbar' },
        desc: {
          id: 'Gunakan input pencarian untuk menemukan hostname OLT atau nama STO tertentu secara cepat, serta tentukan jumlah baris per halaman.',
          en: 'Search directly by hostname or STO name, and toggle row display limits per page.'
        }
      },
      {
        target: '#elTable thead',
        pos: 'bottom',
        title: { id: 'Data Parameter Kelistrikan', en: 'Electrical Parameter Data' },
        desc: {
          id: 'Menyajikan informasi krusial daya: ID PLN Pelanggan, No. Meteran, Rekaman kWh Terakhir, serta Tanggal Pembaruan kWh.',
          en: 'Presents power metrics: PLN Customer ID, Meter Number, Last Recorded kWh, and update timestamps.'
        }
      },
      {
        target: '#tbody tr:first-child td:last-child',
        pos: 'left',
        title: { id: 'Aksi Detail & Lokasi Peta', en: 'Details & Location Actions' },
        desc: {
          id: 'Klik tombol <b>Detail</b> untuk melihat riwayat pencatatan kWh & foto meteran, atau klik <b>Lihat Peta</b> untuk cek koordinat fisik OLT.',
          en: 'Click <b>Detail</b> to view historical meter logs and photo evidence, or <b>Lihat Peta</b> to view GPS coordinates.'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(gcuElectricalTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
