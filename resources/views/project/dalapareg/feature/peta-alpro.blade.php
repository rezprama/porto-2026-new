<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Map Alpro — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  main{padding:16px}
  .map-panel{position:relative;height:calc(100dvh - 96px);border:1px solid var(--border);border-radius:4px;overflow:hidden}
  #map{position:absolute;inset:0}
  .leaflet-container{font-family:inherit}

  .map-overlay{position:absolute;z-index:600}
  .ov-actions{top:12px;left:12px;display:flex;flex-wrap:wrap;gap:8px}
  .ov-btn{height:34px;padding:0 12px;border:none;border-radius:4px;color:#fff;font-size:12.5px;font-weight:700;
    display:inline-flex;align-items:center;gap:7px;box-shadow:0 2px 8px rgba(0,0,0,.25)}
  .ov-btn.red{background:#d9534f}
  .ov-btn.blue{background:#5bc0de}
  .ov-btn.navy{background:var(--brand-600)}

  .ov-search{top:58px;left:12px;display:flex;gap:6px;width:min(520px,calc(100% - 24px))}
  .ov-search select{width:140px;flex-shrink:0}
  .ov-search select,.ov-search input{height:34px;border:1px solid var(--border);border-radius:4px;background:var(--panel-bg);
    color:var(--text);font-family:inherit;font-size:12.5px;padding:0 10px}
  .ov-search input{flex:1;min-width:0}
  .ov-search button{height:34px;padding:0 14px;border:none;border-radius:4px;background:#3cb878;color:#fff;font-size:12.5px;font-weight:700;flex-shrink:0}

  .ov-sync{right:12px;top:12px;width:250px}
  .sync-box{background:rgba(0,0,0,.72);border:1px solid #00c4ff;border-radius:6px;padding:13px 15px;color:#fff;
    backdrop-filter:blur(4px);font-size:12px}
  .sync-box .hd{color:#00c4ff;font-weight:700;font-size:12.5px}
  .sync-box hr{border:none;border-top:1px solid rgba(255,255,255,.15);margin:7px 0}
  .sync-box .pct{font-size:19px;font-weight:700;color:#00c4ff}
  .sync-box .row{display:flex;justify-content:space-between;gap:12px;padding:1px 0;color:#cbd5e1}
  .sync-box .row b{color:#fff}
  .sync-box .fine{font-size:10px;opacity:.6}

  .ov-legend{left:12px;bottom:12px;background:var(--panel-bg);border:1px solid var(--border);border-radius:4px;
    padding:10px 13px;font-size:11.5px;max-width:215px;box-shadow:var(--shadow-md)}
  .ov-legend .lg-title{font-weight:700;margin-bottom:6px;font-size:12px}
  .ov-legend .lg-row{display:flex;align-items:center;gap:7px;padding:1.5px 0;color:var(--label)}
  .ov-legend .dot{width:11px;height:11px;border-radius:50%;flex-shrink:0;border:1px solid rgba(0,0,0,.35)}
  .ov-count{right:12px;bottom:12px;background:var(--panel-bg);border:1px solid var(--border);border-radius:4px;
    padding:7px 12px;font-size:11.5px;color:var(--label);box-shadow:var(--shadow-md)}
  .ov-count b{color:var(--text)}

  .check-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:8px 14px}
  .check-grid label{display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--label);cursor:pointer}
  .check-grid input{width:15px;height:15px;accent-color:var(--brand-500);cursor:pointer}
  .sec-label{font-size:12.5px;font-weight:700;color:var(--text);margin:16px 0 8px;padding-top:14px;border-top:1px solid var(--border)}
  .kv-grid{grid-template-columns:1fr 1fr}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'map'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="map-panel">
    <div id="map"></div>

    <div class="map-overlay ov-actions">
      <button class="ov-btn red" id="settingBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M3 5h18M6 12h12M10 19h4"/></svg>
        <span data-i18n="settingMap">Setting Peta</span>
      </button>
      <button class="ov-btn blue" id="syncBtn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 16v-4M12 8h.01"/></svg>
        <span data-i18n="syncInfo">Info Sinkronisasi</span>
      </button>
      <button class="ov-btn navy" id="baseBtn" data-i18n="baseSat">Satelit</button>
    </div>

    <div class="map-overlay ov-search">
      <select id="searchType">
        <option value="KOORDINAT">KOORDINAT</option>
        <option value="ODP" data-i18n="odpName">NAMA ODP</option>
      </select>
      <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Nama ODP / Koordinat" />
      <button id="searchBtn" data-i18n="search">Cari</button>
    </div>

    <div class="map-overlay ov-sync" id="syncPanel" hidden>
      <div class="sync-box">
        <div class="hd"><span data-i18n="syncStatus">Status Sinkronisasi Data</span></div>
        <hr />
        <div><span class="pct">91%</span> <small data-i18n="mapping">Mapping</small></div>
        <div style="margin-top:5px">
          <div class="row"><span data-i18n="totalInc">Total Tiket INC</span><b>1.428</b></div>
          <div class="row"><span data-i18n="mappedHeat">Sudah di Heatmap</span><b>1.301</b></div>
        </div>
        <hr />
        <div class="fine" data-i18n="syncFine">*Progress ticket dalam persen</div>
      </div>
    </div>

    <div class="map-overlay ov-legend">
      <div class="lg-title" data-i18n="legendTitle">Informasi Marker ODP</div>
      <div class="lg-row"><span class="dot" style="background:#8b5cf6"></span><span data-i18n="lgNoPort">Data Port Info Tidak Ditemukan</span></div>
      <div class="lg-row"><span class="dot" style="background:#7f1d1d"></span><span data-i18n="lg100">Okupansi 100%</span></div>
      <div class="lg-row"><span class="dot" style="background:#dc2626"></span><span data-i18n="lg80">Okupansi 80%</span></div>
      <div class="lg-row"><span class="dot" style="background:#ea580c"></span><span data-i18n="lg60">Okupansi 60%</span></div>
      <div class="lg-row"><span class="dot" style="background:#facc15"></span><span data-i18n="lg40">Okupansi 40%</span></div>
      <div class="lg-row"><span class="dot" style="background:#22c55e"></span><span data-i18n="lg10">Okupansi 10%</span></div>
      <div class="lg-row"><span class="dot" style="background:#111827"></span><span data-i18n="lgEmpty">ODP Kosong</span></div>
    </div>

    <div class="map-overlay ov-count"><span data-i18n="shown">Ditampilkan</span>: <b id="countEl">0</b> <span data-i18n="alproWord">alpro</span></div>
  </div>
</main>

<!-- SETTING PETA -->
<div class="modal-backdrop" id="settingModal">
  <div class="modal-card modal-lg">
    <div class="modal-head"><h3 data-i18n="settingTitle">Pengaturan Filter Peta</h3><button class="modal-close" id="settingX">✕</button></div>
    <div class="modal-body">
      <div class="check-grid">
        <label><input type="checkbox" id="lyOdp" checked /> <span data-i18n="lyOdp">Data ODP</span></label>
        <label><input type="checkbox" id="lyKomersial" /> <span data-i18n="lyKomersial">ODP Komersial</span></label>
        <label><input type="checkbox" id="lyHeatmap" /> <span data-i18n="lyHeatmap">Heatmap Gangguan</span></label>
        <label><input type="checkbox" id="lyUnderspec" /> <span data-i18n="lyUnderspec">Heatmap Underspec</span></label>
        <label><input type="checkbox" id="lyTiang" /> <span data-i18n="lyTiang">Survey Tiang</span></label>
      </div>

      <div class="sec-label" data-i18n="filterData">Filter Data</div>
      <div class="row3">
        <div class="field"><label>Regional</label><select id="fRegional"><option value="" data-i18n="all">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option></select></div>
        <div class="field"><label>District</label><select id="fDistrict"><option value="" data-i18n="all">Semua</option></select></div>
        <div class="field"><label>STO</label><select id="fSto"><option value="" data-i18n="all">Semua</option></select></div>
      </div>
      <div class="row3">
        <div class="field"><label data-i18n="sourceCoord">Source Koordinat</label><select id="fSource"><option value="" data-i18n="all">Semua</option><option>UIM</option><option>SURVEY</option><option>VALINS</option></select></div>
        <div class="field"><label data-i18n="ageLabel">USIA &gt;= (Tahun)</label><input type="number" id="fAge" min="0" value="0" /></div>
        <div class="field" style="align-self:end"><button class="btn-success" id="applyBtn" style="width:100%" data-i18n="apply">Terapkan</button></div>
      </div>
      <p class="hint-muted" data-i18n="coordNote">* Koordinat yang digunakan adalah Koordinat ODP</p>

      <div id="heatFilters" hidden>
        <div class="sec-label" data-i18n="heatFilterLabel">Filter Heatmap Gangguan</div>
        <div class="row2">
          <div class="field"><label data-i18n="custType">Jenis Pelanggan</label><select><option data-i18n="all">Semua</option><option>HVC Diamond</option><option>HVC Platinum</option><option>HVC Gold</option><option>Reguler</option></select></div>
          <div class="field"><label>Segment</label><select><option data-i18n="all">Semua</option><option>Fiber Balikpapan</option><option>Fiber Samarinda</option><option>Fiber Banjarmasin</option></select></div>
          <div class="field"><label data-i18n="troubleType">Jenis Gangguan</label><select><option data-i18n="all">Semua</option><option>GAMAS</option><option>PERSONAL</option></select></div>
          <div class="field"><label data-i18n="dayRange">Rentang Hari</label><select><option>7</option><option selected>30</option><option>90</option><option>180</option></select></div>
        </div>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="settingClose" data-i18n="close">Tutup</button>
      <button class="btn-success" id="applyBtn2" data-i18n="apply">Terapkan</button>
    </div>
  </div>
</div>

<!-- DETAIL ALPRO -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-lg">
    <div class="modal-head"><h3 id="detailTitle">ODP</h3><button class="modal-close" id="detailX">✕</button></div>
    <div class="modal-body"><div class="kv-grid" id="detailGrid"></div></div>
    <div class="modal-foot"><button class="btn-outline" id="detailClose" data-i18n="close">Tutup</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    settingMap: 'Setting Peta', syncInfo: 'Info Sinkronisasi', baseSat: 'Satelit', baseMap: 'Peta',
    odpName: 'NAMA ODP', searchPh: 'Nama ODP / Koordinat',
    syncStatus: 'Status Sinkronisasi Data', mapping: 'Mapping', totalInc: 'Total Tiket INC',
    mappedHeat: 'Sudah di Heatmap', syncFine: '*Progress ticket dalam persen',
    legendTitle: 'Informasi Marker ODP', lgNoPort: 'Data Port Info Tidak Ditemukan',
    lg100: 'Okupansi 100%', lg80: 'Okupansi 80%', lg60: 'Okupansi 60%', lg40: 'Okupansi 40%',
    lg10: 'Okupansi 10%', lgEmpty: 'ODP Kosong', shown: 'Ditampilkan', alproWord: 'alpro',
    settingTitle: 'Pengaturan Filter Peta', lyOdp: 'Data ODP', lyKomersial: 'ODP Komersial',
    lyHeatmap: 'Heatmap Gangguan', lyUnderspec: 'Heatmap Underspec', lyTiang: 'Survey Tiang',
    filterData: 'Filter Data', sourceCoord: 'Source Koordinat', ageLabel: 'USIA >= (Tahun)',
    apply: 'Terapkan', coordNote: '* Koordinat yang digunakan adalah Koordinat ODP',
    heatFilterLabel: 'Filter Heatmap Gangguan', custType: 'Jenis Pelanggan',
    troubleType: 'Jenis Gangguan', dayRange: 'Rentang Hari',
    kSto: 'STO', kDistrict: 'District', kRegional: 'Regional', kCoord: 'Koordinat',
    kPortTotal: 'Port Total', kPortUsed: 'Port Terpakai', kPortIdle: 'Port Idle',
    kOccupancy: 'Okupansi', kAge: 'Usia Port (Tahun)', kSource: 'Source Koordinat', kUpdate: 'Update Terakhir',
    kType: 'Jenis Alpro', kStatus: 'Status', kTicket: 'Tiket Gangguan (30 Hari)',
    noResult: 'Data tidak ditemukan di area ini.', coordInvalid: 'Format koordinat tidak valid. Contoh: -1.2650, 116.8286',
    tiangName: 'Tiang', heatName: 'Titik Gangguan', underspecName: 'Titik Underspec',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
  /* ---------- dummy alpro data around Balikpapan & Samarinda ----------
       Koordinat sengaja dipatok ke kelurahan yang benar-benar daratan (Klandasan, Prapatan,
       Gunung Sari, Sepinggan, Manggar, Karang Joang; Samarinda di sisi utara Sungai Mahakam)
       supaya tidak ada marker yang jatuh di Teluk Balikpapan / Selat Makassar. */
  var ODP = [
    { name:'ODP-BPN-FR/001', sto:'STO Balikpapan Kota', district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2601, lng:116.8298, total:8,  used:8, age:6, source:'UIM',    komersial:false },
    { name:'ODP-BPN-FR/002', sto:'STO Balikpapan Kota', district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2643, lng:116.8349, total:16, used:13, age:4, source:'VALINS', komersial:false },
    { name:'ODP-BPN-FR/003', sto:'STO Balikpapan Kota', district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2566, lng:116.8404, total:8,  used:5, age:3, source:'UIM',    komersial:true  },
    { name:'ODP-BPN-FR/004', sto:'STO Sepinggan',       district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2652, lng:116.8731, total:16, used:6, age:2, source:'SURVEY', komersial:false },
    { name:'ODP-BPN-FR/005', sto:'STO Sepinggan',       district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2589, lng:116.8861, total:8,  used:1, age:1, source:'SURVEY', komersial:false },
    { name:'ODP-BPN-FR/006', sto:'STO Sepinggan',       district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2617, lng:116.8968, total:16, used:0, age:1, source:'UIM',    komersial:false },
    { name:'ODP-BPN-FR/007', sto:'STO Karang Joang',    district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.1738, lng:116.8596, total:8,  used:null, age:5, source:'UIM', komersial:false },
    { name:'ODP-BPN-FR/008', sto:'STO Karang Joang',    district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.1642, lng:116.8727, total:16, used:15, age:7, source:'VALINS', komersial:true },
    { name:'ODP-BPN-FR/009', sto:'STO Manggar',         district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2191, lng:116.9142, total:8,  used:3, age:2, source:'SURVEY', komersial:false },
    { name:'ODP-BPN-FR/010', sto:'STO Manggar',         district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2249, lng:116.9304, total:16, used:11, age:4, source:'UIM',    komersial:false },
    { name:'ODP-BPN-FR/011', sto:'STO Gunung Sari',     district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2489, lng:116.8327, total:8,  used:8, age:8, source:'UIM',    komersial:false },
    { name:'ODP-BPN-FR/012', sto:'STO Gunung Sari',     district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2404, lng:116.8389, total:16, used:9, age:3, source:'VALINS', komersial:true },
    { name:'ODP-SMD-FR/001', sto:'STO Samarinda Kota',  district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4951, lng:117.1439, total:16, used:14, age:5, source:'UIM',    komersial:false },
    { name:'ODP-SMD-FR/002', sto:'STO Samarinda Kota',  district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4889, lng:117.1524, total:8,  used:4, age:2, source:'SURVEY', komersial:false },
    { name:'ODP-SMD-FR/003', sto:'STO Samarinda Kota',  district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4998, lng:117.1355, total:8,  used:null, age:6, source:'UIM', komersial:false },
    { name:'ODP-SMD-FR/004', sto:'STO Sungai Kunjang',  district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4928, lng:117.1131, total:16, used:16, age:9, source:'UIM',    komersial:true  },
    { name:'ODP-SMD-FR/005', sto:'STO Sungai Kunjang',  district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4865, lng:117.1048, total:8,  used:2, age:1, source:'SURVEY', komersial:false },
    { name:'ODP-SMD-FR/006', sto:'STO Air Putih',       district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4791, lng:117.1588, total:16, used:7, age:3, source:'VALINS', komersial:false },
    { name:'ODP-SMD-FR/007', sto:'STO Air Putih',       district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4708, lng:117.1704, total:8,  used:0, age:1, source:'SURVEY', komersial:false },
    { name:'ODP-BJM-FR/001', sto:'STO Banjarmasin',     district:'District Banjarmasin',regional:'KALIMANTAN', lat:-3.3186, lng:114.5921, total:16, used:12, age:4, source:'UIM',    komersial:false },
    { name:'ODP-BJM-FR/002', sto:'STO Banjarmasin',     district:'District Banjarmasin',regional:'KALIMANTAN', lat:-3.3301, lng:114.6042, total:8,  used:6, age:5, source:'VALINS', komersial:true  },
    { name:'ODP-MKS-FR/001', sto:'STO Makassar Pusat',  district:'District Makassar',   regional:'SULAWESI',   lat:-5.1350, lng:119.4230, total:16, used:15, age:6, source:'UIM',    komersial:false },
    { name:'ODP-MKS-FR/002', sto:'STO Makassar Pusat',  district:'District Makassar',   regional:'SULAWESI',   lat:-5.1471, lng:119.4362, total:8,  used:3, age:2, source:'SURVEY', komersial:false },
  ];
  var TIANG = [
    { name:'TN-BPN-0114', sto:'STO Balikpapan Kota', district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2618, lng:116.8338, status:'LAYAK',      jenis:'Tiang Beton 7M' },
    { name:'TN-BPN-0271', sto:'STO Sepinggan',       district:'District Balikpapan', regional:'KALIMANTAN', lat:-1.2669, lng:116.8806, status:'TIDAK LAYAK',jenis:'Tiang Besi 7M' },
    { name:'TN-SMD-0092', sto:'STO Samarinda Kota',  district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4933, lng:117.1470, status:'LAYAK',      jenis:'Tiang Beton 9M' },
    { name:'TN-SMD-0138', sto:'STO Air Putih',       district:'District Samarinda',  regional:'KALIMANTAN', lat:-0.4760, lng:117.1668, status:'PERLU SURVEY',jenis:'Tiang Beton 7M' },
  ];
  /* titik heat digambar sebagai lingkaran radius 250 + weight*45 m, jadi pusatnya ditarik
     cukup jauh ke daratan supaya lingkarannya pun tidak melebar ke laut */
  var HEAT = [
    { lat:-1.2505, lng:116.8335, weight:34 }, { lat:-1.2600, lng:116.8730, weight:21 },
    { lat:-1.1850, lng:116.8620, weight:12 }, { lat:-1.2180, lng:116.9150, weight:27 },
    { lat:-0.4900, lng:117.1450, weight:41 }, { lat:-0.4905, lng:117.1108, weight:18 },
    { lat:-3.3240, lng:114.5980, weight:15 }, { lat:-5.1400, lng:119.4290, weight:23 },
  ];
  var UNDERSPEC = [
    { lat:-1.2520, lng:116.8460, weight:9 }, { lat:-1.2620, lng:116.8860, weight:14 },
    { lat:-0.4890, lng:117.1280, weight:7 }, { lat:-0.4820, lng:117.1580, weight:11 },
  ];

  function occupancy(o){ return o.used === null ? null : Math.round((o.used / o.total) * 100); }
  function odpColor(o){
    var p = occupancy(o);
    if (p === null) { return '#8b5cf6'; }
    if (p >= 100) { return '#7f1d1d'; }
    if (p >= 80) { return '#dc2626'; }
    if (p >= 60) { return '#ea580c'; }
    if (p >= 40) { return '#facc15'; }
    if (p > 0) { return '#22c55e'; }
    return '#111827';
  }

  /* ---------- map ---------- */
  var map = L.map('map', { zoomControl: true }).setView([-1.2654, 116.8312], 12);
  var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
  var sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: '&copy; Esri' });
  var onSat = false;
  document.getElementById('baseBtn').addEventListener('click', function(){
    onSat = !onSat;
    map.removeLayer(onSat ? osm : sat);
    map.addLayer(onSat ? sat : osm);
    document.getElementById('baseBtn').textContent = t(onSat ? 'baseMap' : 'baseSat');
  });

  var odpLayer = L.layerGroup().addTo(map);
  var tiangLayer = L.layerGroup();
  var heatLayer = L.layerGroup();
  var underspecLayer = L.layerGroup();

  var fRegional = document.getElementById('fRegional'),
      fDistrict = document.getElementById('fDistrict'),
      fSto = document.getElementById('fSto'),
      fSource = document.getElementById('fSource'),
      fAge = document.getElementById('fAge');

  function fillSelect(sel, values){
    var keep = sel.firstElementChild;
    sel.innerHTML = '';
    sel.appendChild(keep);
    values.forEach(function(v){
      var o = document.createElement('option');
      o.textContent = v;
      sel.appendChild(o);
    });
  }
  function uniq(arr){ return arr.filter(function(v, i, a){ return a.indexOf(v) === i; }).sort(); }

  function syncDistrictSto(){
    var byReg = ODP.filter(function(o){ return !fRegional.value || o.regional === fRegional.value; });
    fillSelect(fDistrict, uniq(byReg.map(function(o){ return o.district; })));
    var byDis = byReg.filter(function(o){ return !fDistrict.value || o.district === fDistrict.value; });
    fillSelect(fSto, uniq(byDis.map(function(o){ return o.sto; })));
  }
  fRegional.addEventListener('change', function(){ fDistrict.value = ''; fSto.value = ''; syncDistrictSto(); });
  fDistrict.addEventListener('change', function(){ fSto.value = ''; syncDistrictSto(); });
  syncDistrictSto();

  function matches(o){
    if (fRegional.value && o.regional !== fRegional.value) { return false; }
    if (fDistrict.value && o.district !== fDistrict.value) { return false; }
    if (fSto.value && o.sto !== fSto.value) { return false; }
    if (fSource.value && o.source !== fSource.value) { return false; }
    if (o.age !== undefined && o.age < (parseInt(fAge.value, 10) || 0)) { return false; }
    return true;
  }

  function openDetail(title, items){
    document.getElementById('detailTitle').textContent = title;
    document.getElementById('detailGrid').innerHTML = kvHtml(items);
    document.getElementById('detailModal').classList.add('show');
  }

  function render(){
    [odpLayer, tiangLayer, heatLayer, underspecLayer].forEach(function(l){ l.clearLayers(); });
    var shown = 0;

    if (document.getElementById('lyOdp').checked || document.getElementById('lyKomersial').checked) {
      var onlyKomersial = document.getElementById('lyKomersial').checked && !document.getElementById('lyOdp').checked;
      ODP.filter(matches).filter(function(o){ return !onlyKomersial || o.komersial; }).forEach(function(o){
        shown++;
        var p = occupancy(o);
        L.circleMarker([o.lat, o.lng], {
          radius: 7, color: '#fff', weight: 1.5, fillColor: odpColor(o), fillOpacity: .95,
        }).addTo(odpLayer).on('click', function(){
          openDetail(o.name, [
            [t('kType'), o.komersial ? 'ODP Komersial' : 'ODP'],
            [t('kSto'), o.sto], [t('kDistrict'), o.district], [t('kRegional'), o.regional],
            [t('kCoord'), o.lat.toFixed(4) + ', ' + o.lng.toFixed(4)],
            [t('kPortTotal'), o.total],
            [t('kPortUsed'), o.used === null ? '-' : o.used],
            [t('kPortIdle'), o.used === null ? '-' : (o.total - o.used)],
            [t('kOccupancy'), p === null ? '-' : p + '%'],
            [t('kAge'), o.age], [t('kSource'), o.source], [t('kUpdate'), '2026-09-15 04:10 WITA'],
          ]);
        });
      });
      map.addLayer(odpLayer);
    } else {
      map.removeLayer(odpLayer);
    }

    if (document.getElementById('lyTiang').checked) {
      TIANG.filter(matches).forEach(function(tg){
        shown++;
        L.circleMarker([tg.lat, tg.lng], { radius: 6, color: '#fff', weight: 1.5, fillColor: '#0ea5e9', fillOpacity: .95 })
          .addTo(tiangLayer).on('click', function(){
            openDetail(t('tiangName') + ' ' + tg.name, [
              [t('kSto'), tg.sto], [t('kDistrict'), tg.district], [t('kRegional'), tg.regional],
              [t('kCoord'), tg.lat.toFixed(4) + ', ' + tg.lng.toFixed(4)],
              [t('kType'), tg.jenis], [t('kStatus'), tg.status],
            ]);
          });
      });
      map.addLayer(tiangLayer);
    } else {
      map.removeLayer(tiangLayer);
    }

    /* ponytail: heatmap is drawn as scaled translucent circles — no leaflet.heat dependency for a demo. */
    function paintHeat(points, layer, color, label){
      points.forEach(function(h){
        L.circle([h.lat, h.lng], { radius: 250 + h.weight * 45, color: color, weight: 0, fillColor: color, fillOpacity: .3 })
          .addTo(layer).on('click', function(){
            openDetail(label, [
              [t('kCoord'), h.lat.toFixed(4) + ', ' + h.lng.toFixed(4)],
              [t('kTicket'), h.weight],
            ]);
          });
      });
    }
    if (document.getElementById('lyHeatmap').checked) { paintHeat(HEAT, heatLayer, '#ef4444', t('heatName')); map.addLayer(heatLayer); }
    else { map.removeLayer(heatLayer); }
    if (document.getElementById('lyUnderspec').checked) { paintHeat(UNDERSPEC, underspecLayer, '#f59e0b', t('underspecName')); map.addLayer(underspecLayer); }
    else { map.removeLayer(underspecLayer); }

    document.getElementById('countEl').textContent = shown;
  }

  /* ---------- setting modal ---------- */
  var settingModal = document.getElementById('settingModal');
  document.getElementById('settingBtn').addEventListener('click', function(){ settingModal.classList.add('show'); });
  ['settingX', 'settingClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ settingModal.classList.remove('show'); });
  });
  document.getElementById('lyHeatmap').addEventListener('change', function(){
    document.getElementById('heatFilters').hidden = !this.checked;
  });
  ['applyBtn', 'applyBtn2'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){
      render();
      settingModal.classList.remove('show');
    });
  });
  document.querySelectorAll('.check-grid input').forEach(function(cb){ cb.addEventListener('change', render); });

  document.getElementById('syncBtn').addEventListener('click', function(){
    var p = document.getElementById('syncPanel');
    p.hidden = !p.hidden;
  });
  ['detailX', 'detailClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ document.getElementById('detailModal').classList.remove('show'); });
  });

  /* ---------- search ---------- */
  document.getElementById('searchBtn').addEventListener('click', function(){
    var q = document.getElementById('searchInput').value.trim();
    if (!q) { return; }
    if (document.getElementById('searchType').value === 'KOORDINAT') {
      var m = q.split(',').map(function(s){ return parseFloat(s.trim()); });
      if (m.length !== 2 || isNaN(m[0]) || isNaN(m[1])) { toast(t('coordInvalid')); return; }
      map.setView(m, 16);
      return;
    }
    var hit = ODP.filter(function(o){ return o.name.toLowerCase().indexOf(q.toLowerCase()) !== -1; })[0];
    if (!hit) { toast(t('noResult')); return; }
    map.setView([hit.lat, hit.lng], 17);
  });
  document.getElementById('searchInput').addEventListener('keydown', function(e){
    if (e.key === 'Enter') { document.getElementById('searchBtn').click(); }
  });

  render();
  applyLang();
</script>
</body>
</html>
