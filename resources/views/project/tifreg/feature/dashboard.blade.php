<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Map Alpro — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<style>
  :root{
    --brand-50:#ecf3ff; --brand-500:#465fff; --brand-600:#3641f5;
    --gray-25:#fcfcfd; --gray-50:#f9fafb; --gray-100:#f2f4f7; --gray-200:#e4e7ec; --gray-300:#d0d5dd;
    --gray-400:#98a2b3; --gray-500:#667085; --gray-700:#344054; --gray-800:#1d2939; --gray-900:#101828;
    --error-500:#f04438;
    --bg:var(--gray-50); --panel-bg:#fff; --text:var(--gray-800); --label:var(--gray-700); --muted:var(--gray-400);
    --border:var(--gray-200); --shadow-xs:0 1px 2px 0 rgba(16,24,40,.05); --shadow-md:0 4px 12px rgba(16,24,40,.1);
  }
  [data-theme="dark"]{
    --bg:var(--gray-900); --panel-bg:#101828; --text:rgba(255,255,255,.9); --label:var(--gray-400);
    --muted:rgba(255,255,255,.35); --border:var(--gray-700);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:"Outfit",system-ui,sans-serif;background:var(--bg);color:var(--text);transition:background .2s,color .2s}
  button{font-family:inherit;cursor:pointer}

  /* ---------- sidebar ---------- */
  .sidebar{position:fixed;top:0;left:0;bottom:0;width:260px;background:var(--panel-bg);border-right:1px solid var(--border);
    z-index:1100;display:flex;flex-direction:column;transition:transform .25s ease}
  .sidebar .brand{display:flex;align-items:center;gap:10px;padding:18px 20px;border-bottom:1px solid var(--border)}
  .sidebar .brand img{width:30px;height:30px;object-fit:contain}
  .sidebar .brand b{font-size:15px;color:var(--text)}
  .sidebar nav{padding:18px 14px;flex:1;overflow-y:auto}
  .nav-label{font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--muted);text-transform:uppercase;padding:0 10px;margin-bottom:8px}
  .nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;font-size:14px;font-weight:500;
    color:var(--label);text-decoration:none;margin-bottom:2px;width:100%;border:none;background:none;text-align:left}
  .nav-item svg{flex-shrink:0}
  .nav-item.active{background:var(--brand-50);color:var(--brand-600)}
  [data-theme="dark"] .nav-item.active{background:color-mix(in srgb, var(--brand-500) 16%, transparent);color:#a7b6ff}
  .nav-item .chev{margin-left:auto;transition:transform .18s}
  .nav-group.open > .nav-item .chev{transform:rotate(180deg)}
  .sub-nav{max-height:0;overflow:hidden;transition:max-height .2s ease}
  .nav-group.open > .sub-nav{max-height:640px}
  .sub-nav a{display:block;padding:8px 12px 8px 41px;font-size:13.5px;color:var(--label);text-decoration:none}
  .sub-nav a:hover{color:var(--brand-500)}
  .sub-nav a.active{color:var(--brand-600);font-weight:600}
  [data-theme="dark"] .sub-nav a.active{color:#a7b6ff}

  /* ---------- nested (3rd level) submenu, e.g. NE > GCU OLT > Monitoring ---------- */
  .sub-nav .nav-group{width:100%}
  .sub-nav .nav-group > .nav-item{padding:8px 12px 8px 41px;font-size:13.5px;font-weight:500;color:var(--label);border-radius:0}
  .sub-nav .nav-group > .nav-item:hover{color:var(--brand-500)}
  .sub-nav .nav-group.open > .nav-item, .sub-nav .nav-group > .nav-item.active{background:none;color:var(--brand-600);font-weight:600}
  [data-theme="dark"] .sub-nav .nav-group.open > .nav-item, [data-theme="dark"] .sub-nav .nav-group > .nav-item.active{color:#a7b6ff}
  .sub-nav .nav-group .sub-nav a{padding-left:64px;font-size:13px}
  .sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:1090}

  @media (max-width:991px){
    .sidebar{transform:translateX(-100%)}
    .sidebar.open{transform:translateX(0)}
    .sidebar-overlay.show{display:block}
  }

  /* ---------- header ---------- */
  .topbar{position:sticky;top:0;z-index:1200;height:64px;background:var(--panel-bg);border-bottom:1px solid var(--border);
    display:flex;align-items:center;gap:14px;padding:0 16px;margin-left:260px}
  @media (max-width:991px){ .topbar{margin-left:0} }
  .hamburger{width:38px;height:38px;border:1px solid var(--border);border-radius:8px;background:none;display:none;
    align-items:center;justify-content:center;color:var(--text)}
  @media (max-width:991px){ .hamburger{display:flex} }
  .topbar .spacer{flex:1}
  .clock-pill{display:none;align-items:center;gap:8px;height:38px;padding:0 14px;border:1px solid var(--border);border-radius:9px;
    font-family:monospace;font-size:12.5px;color:var(--label)}
  @media (min-width:640px){ .clock-pill{display:flex} }
  .icbtn{width:38px;height:38px;border-radius:50%;border:1px solid var(--border);background:none;display:grid;
    place-items:center;color:var(--text)}
  .user-block{display:flex;align-items:center;gap:8px}
  .logout-btn{text-decoration:none;color:var(--label);flex-shrink:0}
  .logout-btn:hover{border-color:var(--error-500);color:var(--error-500)}
  .avatar{width:36px;height:36px;border-radius:50%;background:var(--brand-500);color:#fff;display:grid;place-items:center;
    font-weight:600;font-size:13px;flex-shrink:0}
  .user-meta{display:none;line-height:1.2}
  @media (min-width:640px){ .user-meta{display:block} }
  .user-meta .name{font-size:13.5px;font-weight:600;color:var(--text)}
  .user-meta .role{font-size:11.5px;color:var(--muted)}
  .back-badge{position:fixed;top:12px;left:50%;transform:translateX(-50%);z-index:1250;
    display:inline-flex;align-items:center;background:color-mix(in srgb, var(--gray-900) 82%, transparent);
    padding:5px;border-radius:16px;text-decoration:none;backdrop-filter:blur(6px);overflow:hidden;transition:padding .25s ease}
  .back-badge:hover{background:var(--gray-900);padding:5px 12px 5px 5px}
  .back-badge .mark{width:20px;height:20px;border-radius:50%;background:#ffffff;display:flex;align-items:center;justify-content:center;
    padding:2px;flex-shrink:0;box-shadow:0 1px 3px rgba(0,0,0,.25);overflow:hidden}
  .back-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .back-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11px;font-weight:500;
    margin-left:0;transition:max-width .25s ease,opacity .2s ease,margin-left .25s ease}
  .back-badge:hover .txt{max-width:280px;opacity:1;margin-left:7px}

  /* ---------- main / map ---------- */
  main{margin-left:260px;padding:16px}
  @media (max-width:991px){ main{margin-left:0} }
  .map-panel{position:relative;height:calc(100dvh - 96px);border-radius:14px;overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-xs)}
  #map{position:absolute;inset:0}

  /* ---------- floating toolbar ---------- */
  .toolbar{position:absolute;top:14px;right:14px;z-index:500;display:flex;align-items:center;gap:8px}
  .layer-pill{display:flex;background:var(--panel-bg);border:1px solid var(--border);border-radius:9px;overflow:hidden;box-shadow:var(--shadow-md)}
  .layer-pill button{width:36px;height:36px;border:none;background:none;display:grid;place-items:center;color:var(--label)}
  .layer-pill button.on{background:var(--brand-500);color:#fff}
  .round-btn{width:36px;height:36px;border-radius:9px;border:1px solid var(--border);background:var(--panel-bg);
    display:grid;place-items:center;color:var(--label);box-shadow:var(--shadow-md)}
  .round-btn.on{background:var(--brand-500);color:#fff;border-color:var(--brand-500)}
  .filter-btn{height:36px;padding:0 14px;border-radius:9px;border:1px solid var(--border);background:var(--panel-bg);
    color:var(--label);font-size:13px;font-weight:600;box-shadow:var(--shadow-md)}

  /* ---------- legend ---------- */
  .legend{position:absolute;bottom:14px;left:14px;z-index:500;background:var(--panel-bg);border:1px solid var(--border);
    border-radius:10px;padding:10px 14px;box-shadow:var(--shadow-md);font-size:12px;max-width:220px}
  .legend .lg-title{font-weight:600;margin-bottom:6px;color:var(--text)}
  .legend .lg-row{display:flex;align-items:center;gap:7px;padding:2px 0;color:var(--label)}
  .legend .sw{width:10px;height:10px;border-radius:3px;flex-shrink:0}

  /* ---------- sync panel ---------- */
  .sync-panel{position:absolute;top:14px;left:60px;z-index:500;background:rgba(15,23,42,.92);color:#fff;border-radius:10px;
    padding:12px 16px;box-shadow:var(--shadow-md);font-size:12px;min-width:190px}
  .sync-panel .x{position:absolute;top:6px;right:8px;background:none;border:none;color:#94a3b8;font-size:14px;cursor:pointer}
  .sync-panel .pct{font-size:24px;font-weight:700;color:#22d3ee;line-height:1}
  .sync-panel .lab{color:#94a3b8;margin-bottom:6px}
  .sync-panel .row{display:flex;justify-content:space-between;padding:2px 0;color:#cbd5e1}

  /* ---------- measure panel ---------- */
  .measure-panel{position:absolute;bottom:14px;right:14px;z-index:500;background:var(--panel-bg);border:1px solid var(--border);
    border-radius:10px;padding:12px 14px;box-shadow:var(--shadow-md);font-size:12.5px;min-width:180px}
  .measure-panel .val{font-size:16px;font-weight:600;color:var(--brand-600);margin:4px 0 8px}
  .measure-panel .btns{display:flex;gap:6px}
  .measure-panel .btns button{flex:1;height:30px;border-radius:6px;border:1px solid var(--border);background:var(--bg);
    font-size:11.5px;color:var(--label)}

  /* ---------- filter modal ---------- */
  .modal-backdrop{position:fixed;inset:0;background:rgba(16,24,40,.6);backdrop-filter:blur(2px);z-index:2000;
    display:none;align-items:flex-start;justify-content:center;padding:56px 16px;overflow-y:auto}
  .modal-backdrop.show{display:flex}
  .modal-card{background:var(--panel-bg);border-radius:12px;max-width:660px;width:100%;padding:18px 20px;box-shadow:var(--shadow-md)}
  .modal-card h3{font-size:16px;margin-bottom:1px;color:var(--text)}
  .modal-card .sub{font-size:12.5px;color:var(--muted);margin-bottom:14px}
  .modal-close{float:right;background:none;border:none;font-size:16px;color:var(--muted);cursor:pointer}
  .radio-row{display:flex;flex-wrap:wrap;gap:14px 20px;margin-bottom:14px}
  .radio-row label{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--label);cursor:pointer}
  .field{margin-bottom:12px}
  .field label{display:block;font-size:12px;font-weight:600;color:var(--label);margin-bottom:4px}
  .field select, .field input{width:100%;height:36px;border-radius:7px;border:1px solid var(--border);background:transparent;
    padding:0 10px;font-size:13px;font-family:inherit;color:var(--text)}
  .field select:disabled{opacity:.5}
  .row3{display:grid;grid-template-columns:1fr;gap:10px}
  @media (min-width:560px){ .row3{grid-template-columns:1fr 1fr 1fr 1fr} }
  .check-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 14px;margin-bottom:14px}
  @media (min-width:560px){ .check-grid{grid-template-columns:repeat(4,1fr)} }
  .check-grid label{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--label);cursor:pointer}

  /* custom-drawn radio/checkbox: fixed size in every browser, no native-control quirks */
  .radio-row input, .check-grid input{
    appearance:none;-webkit-appearance:none;width:15px;height:15px;flex-shrink:0;margin:0;padding:0;
    border:1.5px solid var(--gray-300);background:var(--panel-bg);position:relative;cursor:pointer
  }
  .radio-row input[type="radio"], .check-grid input[type="radio"]{border-radius:50%}
  .check-grid input[type="checkbox"]{border-radius:4px}
  .radio-row input:checked, .check-grid input:checked{border-color:var(--brand-500)}
  .radio-row input[type="radio"]:checked::after, .check-grid input[type="radio"]:checked::after{
    content:'';position:absolute;inset:3px;border-radius:50%;background:var(--brand-500)}
  .check-grid input[type="checkbox"]:checked{background:var(--brand-500)}
  .check-grid input[type="checkbox"]:checked::after{
    content:'';position:absolute;left:4px;top:1px;width:4px;height:8px;border:solid #fff;border-width:0 2px 2px 0;transform:rotate(45deg)}
  .modal-foot{display:flex;justify-content:flex-end;margin-top:6px}
  .apply-btn{height:36px;padding:0 18px;border-radius:7px;border:none;background:var(--brand-500);color:#fff;font-weight:600;font-size:13px}

  /* ---------- marker detail modal ---------- */
  .detail-card{max-width:420px}
  .detail-card table{width:100%;border-collapse:collapse;font-size:12.5px}
  .detail-card td{padding:5px 0;border-bottom:1px solid var(--border);color:var(--label)}
  .detail-card td:first-child{color:var(--muted);width:40%}

  .odp-icon{display:flex;flex-direction:column;align-items:center}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'map'])

@include('project.tifreg.feature.partials.topbar')

  <main>
    <div class="map-panel">
      <div id="map"></div>

      <div class="sync-panel" id="syncPanel">
        <button class="x" id="syncClose">✕</button>
        <div class="lab" data-i18n="syncTitle">Status Sinkronisasi Data</div>
        <div class="pct">92%</div>
        <div class="lab" style="margin:2px 0 8px" data-i18n="syncMapping">Mapping</div>
        <div class="row"><span data-i18n="syncTotal">Total Tiket INC</span><b>143</b></div>
        <div class="row"><span data-i18n="syncMapped">Sudah di Heatmap</span><b>131</b></div>
      </div>
      <button class="round-btn" id="syncOpen" style="position:absolute;top:14px;left:60px;z-index:499;display:none" aria-label="Info sinkronisasi">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
      </button>

      <div class="toolbar">
        <div class="layer-pill">
          <button id="layerOsm" class="on" data-i18n-title="tMap" title="Peta">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 20l-6-3V4l6 3 6-3 6 3v13l-6-3-6 3Z"/></svg>
          </button>
          <button id="layerSat" data-i18n-title="tSat" title="Satelit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>
          </button>
        </div>
        <button class="round-btn" id="measureBtn" data-i18n-title="tMeasure" title="Ukur jarak">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m2 12 6-6 3 3-6 6ZM11 9l3-3M14 12l3-3M17 15l3-3M2 12l10 10 10-10"/></svg>
        </button>
        <button class="filter-btn" id="filterBtn" data-i18n="showFilter">Tampilkan Filter</button>
      </div>

      <div class="legend">
        <div id="legendOdp">
          <div class="lg-title" data-i18n="legendOdp">Informasi Marker ODP</div>
          <div class="lg-row"><span class="sw" style="background:#8B5CF6"></span><span data-i18n="lgNotFound">Data tidak ditemukan</span></div>
          <div class="lg-row"><span class="sw" style="background:#DC2626"></span><span data-i18n="lgOcc100">Okupansi 100%</span></div>
          <div class="lg-row"><span class="sw" style="background:#EF4444"></span><span data-i18n="lgOcc80">Okupansi 80%</span></div>
          <div class="lg-row"><span class="sw" style="background:#F59E0B"></span><span data-i18n="lgOcc60">Okupansi 60%</span></div>
          <div class="lg-row"><span class="sw" style="background:#FACC15"></span><span data-i18n="lgOcc40">Okupansi 40%</span></div>
          <div class="lg-row"><span class="sw" style="background:#22C55E"></span><span data-i18n="lgOcc10">Okupansi 10%</span></div>
          <div class="lg-row"><span class="sw" style="background:#111827"></span><span data-i18n="lgEmpty">ODP Kosong</span></div>
        </div>
        <div id="legendOlt" style="display:none">
          <div class="lg-title" data-i18n="legendOlt">Informasi Marker OLT</div>
          <div class="lg-row"><span class="sw" style="background:#16A34A"></span>ZTE</div>
          <div class="lg-row"><span class="sw" style="background:#EA580C"></span>FIBERHOME</div>
          <div class="lg-row"><span class="sw" style="background:#DC2626"></span>HUAWEI</div>
          <div class="lg-row"><span class="sw" style="background:#7C3AED"></span>ALU</div>
          <div class="lg-row"><span class="sw" style="background:#6B7280"></span><span data-i18n="others">Lainnya</span></div>
        </div>
      </div>

      <div class="measure-panel" id="measurePanel" hidden>
        <b data-i18n="measureTitle">Ukur Jarak</b>
        <div class="val" id="measureVal">0 m</div>
        <div class="btns">
          <button id="measureUndo">Undo</button>
          <button id="measureClear" data-i18n="clear">Bersihkan</button>
          <button id="measureDone" data-i18n="done">Selesai</button>
        </div>
      </div>
    </div>
  </main>

  <!-- FILTER MODAL -->
  <div class="modal-backdrop" id="filterModal">
    <div class="modal-card">
      <button class="modal-close" id="filterClose">✕</button>
      <h3 data-i18n="filterTitle">Filter Peta</h3>
      <div class="sub" data-i18n="filterSub">Atur layer dan fokus tampilan peta</div>

      <div class="field">
        <label data-i18n="searchTypeLabel">Jenis Pencarian</label>
        <div class="radio-row">
          <label><input type="radio" name="searchType" value="area" checked /> <span data-i18n="byArea">Cari by area</span></label>
          <label><input type="radio" name="searchType" value="koordinat" /> <span data-i18n="byCoord">Cari by koordinat</span></label>
          <label><input type="radio" name="searchType" value="nama" /> <span data-i18n="byName">Cari by nama alpro</span></label>
        </div>
      </div>

      <div id="searchArea">
        <div class="row3">
          <div class="field"><label>Area</label><select id="fArea"><option value="" data-i18n="phArea">Pilih Area</option><option>Kalimantan</option><option>Sulawesi</option></select></div>
          <div class="field"><label>Regional</label><select id="fRegional" disabled><option value="" data-i18n="phRegional">Pilih Regional</option></select></div>
          <div class="field"><label>District</label><select id="fDistrict" disabled><option value="" data-i18n="phDistrict">Pilih District</option></select></div>
          <div class="field"><label>STO</label><select id="fSto" disabled><option value="" data-i18n="phSto">Pilih STO</option></select></div>
        </div>
      </div>
      <div id="searchKoordinat" style="display:none" class="field">
        <label data-i18n="coordLabel">Koordinat ODP</label>
        <input type="text" id="fKoordinat" value="-1.2650, 116.8286" />
        <p id="coordError" style="display:none;font-size:11.5px;color:var(--error-500);margin-top:4px"></p>
      </div>
      <div id="searchNama" style="display:none" class="field">
        <label data-i18n="nameLabel">Nama ODP</label>
        <input type="text" id="fNama" value="ODP-BPN-014" />
      </div>

      <div class="field">
        <label data-i18n="dataTypeLabel">Tipe Data</label>
        <div class="check-grid">
          <label><input type="radio" name="dataType" value="odp" checked /> ODP</label>
          <label><input type="radio" name="dataType" value="odp_komersial" /> <span data-i18n="odpKom">ODP Komersial</span></label>
          <label><input type="radio" name="dataType" value="heatmap" /> <span data-i18n="heatmapLabel">Heatmap Gangguan</span></label>
          <label><input type="radio" name="dataType" value="olt" /> OLT</label>
        </div>
      </div>

      <div id="extraOdpKomersial" style="display:none" class="field">
        <label data-i18n="ageLabel">Usia Minimum Port (Tahun)</label>
        <input type="number" min="0" data-i18n-ph="agePh" placeholder="Contoh: 3" />
      </div>

      <div id="extraOlt" style="display:none" class="field">
        <label data-i18n="merkLabel">Merk OLT</label>
        <select id="fOltMerk"><option value="" data-i18n="allBrands">Semua merk</option><option>ZTE</option><option>FIBERHOME</option><option>HUAWEI</option><option>ALU</option><option data-i18n="others">Lainnya</option></select>
      </div>

      <div id="extraHeatmap" style="display:none">
        <div class="row3">
          <div class="field"><label data-i18n="custType">Jenis Pelanggan</label><select><option value="" data-i18n="all">Semua</option><option>HVC Platinum</option><option>HVC Gold</option><option>HVC Silver</option><option>HVC Diamond</option><option>Non-Indihome</option></select></div>
          <div class="field"><label>Segment</label><select><option value="" data-i18n="allSegment">Semua segment</option><option>Fiber Balikpapan</option><option>Fiber Samarinda</option><option>Fiber Makassar</option></select></div>
          <div class="field"><label data-i18n="troubleType">Jenis Gangguan</label><select><option data-i18n="all">Semua</option><option>Gamas</option><option>Personal</option></select></div>
          <div class="field"><label data-i18n="dayRange">Rentang Hari</label><select><option data-i18n="d7">7 Hari</option><option data-i18n="d30">30 Hari</option><option data-i18n="d90">90 Hari</option><option data-i18n="d180">180 Hari</option></select></div>
        </div>
      </div>

      <div class="modal-foot">
        <button class="apply-btn" id="applyFilter" data-i18n="apply">Terapkan</button>
      </div>
    </div>
  </div>

  <!-- MARKER DETAIL MODAL -->
  <div class="modal-backdrop" id="detailModal">
    <div class="modal-card detail-card">
      <button class="modal-close" id="detailClose">✕</button>
      <h3 id="detailTitle">ODP</h3>
      <div class="sub" data-i18n="detailSub">Detail Alpro</div>
      <table id="detailTable"></table>
    </div>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
<script>
  /* ---------- i18n ---------- */
  var PAGE_I18N = {
    id: {
      navMaterial: 'Tracking Material', navDataSearch: 'Cari Data', navOrganisasi: 'Organisasi',
      navStock: 'Stock Opname', navB2B: 'Monitoring B2B', navProject: 'List Project',
      navBudget: 'Anggaran', navUser: 'Manajemen Pengguna', logout: 'Keluar',
      syncTitle: 'Status Sinkronisasi Data', syncMapping: 'Mapping',
      syncTotal: 'Total Tiket INC', syncMapped: 'Sudah di Heatmap',
      tMap: 'Peta', tSat: 'Satelit', tMeasure: 'Ukur jarak', showFilter: 'Tampilkan Filter',
      legendOdp: 'Informasi Marker ODP', legendOlt: 'Informasi Marker OLT',
      lgNotFound: 'Data tidak ditemukan', lgOcc100: 'Okupansi 100%', lgOcc80: 'Okupansi 80%',
      lgOcc60: 'Okupansi 60%', lgOcc40: 'Okupansi 40%', lgOcc10: 'Okupansi 10%',
      lgEmpty: 'ODP Kosong', others: 'Lainnya',
      measureTitle: 'Ukur Jarak', clear: 'Bersihkan', done: 'Selesai',
      filterTitle: 'Filter Peta', filterSub: 'Atur layer dan fokus tampilan peta',
      searchTypeLabel: 'Jenis Pencarian', byArea: 'Cari by area', byCoord: 'Cari by koordinat', byName: 'Cari by nama alpro',
      phArea: 'Pilih Area', phRegional: 'Pilih Regional', phDistrict: 'Pilih District', phSto: 'Pilih STO',
      coordLabel: 'Koordinat ODP', nameLabel: 'Nama ODP', dataTypeLabel: 'Tipe Data',
      odpKom: 'ODP Komersial', heatmapLabel: 'Heatmap Gangguan',
      ageLabel: 'Usia Minimum Port (Tahun)', agePh: 'Contoh: 3', merkLabel: 'Merk OLT', allBrands: 'Semua merk',
      custType: 'Jenis Pelanggan', all: 'Semua', allSegment: 'Semua segment', troubleType: 'Jenis Gangguan',
      dayRange: 'Rentang Hari', d7: '7 Hari', d30: '30 Hari', d90: '90 Hari', d180: '180 Hari',
      apply: 'Terapkan', detailSub: 'Detail Alpro',
      coordInvalid: 'Format tidak valid. Contoh: -1.2650, 116.8286',
      rRegional: 'Regional', rDistrict: 'District', rCoord: 'Koordinat', rPanel: 'Panel',
      rFilled: 'ISI', rTotal: 'TOTAL', rUpdated: 'Update Terakhir',
      rBrand: 'Merk / Model', rLocation: 'Lokasi', rYear: 'Tahun Instalasi',
      localeLabel: 'Bahasa Indonesia',
    },
    en: {
      navMaterial: 'Material Tracking', navDataSearch: 'Search Data', navOrganisasi: 'Organisation',
      navStock: 'Stock Taking', navB2B: 'B2B Monitoring', navProject: 'Project List',
      navBudget: 'Budget', navUser: 'User Management', logout: 'Logout',
      syncTitle: 'Data Sync Status', syncMapping: 'Mapping',
      syncTotal: 'Total INC Tickets', syncMapped: 'Mapped to Heatmap',
      tMap: 'Map', tSat: 'Satellite', tMeasure: 'Measure distance', showFilter: 'Show Filter',
      legendOdp: 'ODP Marker Info', legendOlt: 'OLT Marker Info',
      lgNotFound: 'Data not found', lgOcc100: 'Occupancy 100%', lgOcc80: 'Occupancy 80%',
      lgOcc60: 'Occupancy 60%', lgOcc40: 'Occupancy 40%', lgOcc10: 'Occupancy 10%',
      lgEmpty: 'Empty ODP', others: 'Others',
      measureTitle: 'Measure Distance', clear: 'Clear', done: 'Done',
      filterTitle: 'Map Filter', filterSub: 'Adjust layers and map focus',
      searchTypeLabel: 'Search Type', byArea: 'Search by area', byCoord: 'Search by coordinate', byName: 'Search by alpro name',
      phArea: 'Select Area', phRegional: 'Select Regional', phDistrict: 'Select District', phSto: 'Select STO',
      coordLabel: 'ODP Coordinate', nameLabel: 'ODP Name', dataTypeLabel: 'Data Type',
      odpKom: 'Commercial ODP', heatmapLabel: 'Trouble Heatmap',
      ageLabel: 'Minimum Port Age (Years)', agePh: 'e.g. 3', merkLabel: 'OLT Brand', allBrands: 'All brands',
      custType: 'Customer Type', all: 'All', allSegment: 'All segments', troubleType: 'Trouble Type',
      dayRange: 'Day Range', d7: '7 Days', d30: '30 Days', d90: '90 Days', d180: '180 Days',
      apply: 'Apply', detailSub: 'Alpro Detail',
      coordInvalid: 'Invalid format. Example: -1.2650, 116.8286',
      rRegional: 'Regional', rDistrict: 'District', rCoord: 'Coordinate', rPanel: 'Panel',
      rFilled: 'USED', rTotal: 'TOTAL', rUpdated: 'Last Update',
      rBrand: 'Brand / Model', rLocation: 'Location', rYear: 'Installation Year',
      localeLabel: 'English',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- sync panel ---------- */
  document.getElementById('syncClose').addEventListener('click', function(){
    document.getElementById('syncPanel').style.display = 'none';
    document.getElementById('syncOpen').style.display = 'grid';
  });
  document.getElementById('syncOpen').addEventListener('click', function(){
    document.getElementById('syncPanel').style.display = 'block';
    this.style.display = 'none';
  });

  /* ---------- map ---------- */
  var map = L.map('map', { zoomControl: true }).setView([-1.2379, 116.8529], 13);
  var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);
  var sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Esri' });

  document.getElementById('layerOsm').addEventListener('click', function(){
    map.removeLayer(sat); osm.addTo(map);
    this.classList.add('on'); document.getElementById('layerSat').classList.remove('on');
  });
  document.getElementById('layerSat').addEventListener('click', function(){
    map.removeLayer(osm); sat.addTo(map);
    this.classList.add('on'); document.getElementById('layerOsm').classList.remove('on');
  });

  function odpColor(total, kosong){
    if (total == null) return '#8B5CF6';
    if (total === 0) return '#111827';
    var occ = (total - kosong) / total;
    if (occ >= 1) return '#DC2626';
    if (occ >= 0.8) return '#EF4444';
    if (occ >= 0.6) return '#F59E0B';
    if (occ >= 0.4) return '#FACC15';
    return '#22C55E';
  }

  function odpDivIcon(color){
    var svg = '<svg width="26" height="34" viewBox="0 0 26 34" xmlns="http://www.w3.org/2000/svg">' +
      '<circle cx="6" cy="4" r="1.6" fill="#1d2939"/><circle cx="13" cy="4" r="1.6" fill="#1d2939"/><circle cx="20" cy="4" r="1.6" fill="#1d2939"/>' +
      '<rect x="2" y="7" width="22" height="14" rx="2" fill="' + color + '" stroke="#fff" stroke-width="1.5"/>' +
      '<line x1="13" y1="21" x2="13" y2="32" stroke="#667085" stroke-width="2"/>' +
      '</svg>';
    return L.divIcon({ html: svg, className: 'odp-icon', iconSize: [26, 34], iconAnchor: [13, 32], popupAnchor: [0, -30] });
  }

  var ODP = [
    {loc:'ODP-BPN-014', eid:'EID-4471', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Balikpapan Kota', lat:-1.2650, lng:116.8286, total:16, kosong:0, updated:'2026-08-30'},
    {loc:'ODP-BPN-021', eid:'EID-4488', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Karang Joang', lat:-1.1180, lng:116.8340, total:16, kosong:3, updated:'2026-08-28'},
    {loc:'ODP-BPN-033', eid:'EID-4502', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Sepinggan', lat:-1.2600, lng:116.8830, total:8, kosong:5, updated:'2026-08-25'},
    {loc:'ODP-BPN-045', eid:'EID-4519', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Batakan', lat:-1.2050, lng:116.8460, total:16, kosong:8, updated:'2026-08-20'},
    {loc:'ODP-BPN-052', eid:'EID-4531', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Manggar', lat:-1.2230, lng:116.8600, total:8, kosong:1, updated:'2026-08-18'},
    {loc:'ODP-BPN-060', eid:'EID-4547', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Gunung Sari', lat:-1.2460, lng:116.8190, total:16, kosong:16, updated:'2026-08-12'},
    {loc:'ODP-BPN-071', eid:'EID-4560', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Damai', lat:-1.2500, lng:116.8130, total:null, kosong:null, updated:'—'},
    {loc:'ODP-SMD-009', eid:'EID-4602', regional:'Regional Kalimantan Timur', district:'District Samarinda', sto:'STO Samarinda Kota', lat:-0.5021, lng:117.1436, total:16, kosong:2, updated:'2026-08-29'},
    {loc:'ODP-SMD-018', eid:'EID-4619', regional:'Regional Kalimantan Timur', district:'District Samarinda', sto:'STO Samarinda Seberang', lat:-0.4950, lng:117.1250, total:8, kosong:6, updated:'2026-08-22'},
    {loc:'ODP-MKS-004', eid:'EID-4701', regional:'Regional Sulawesi Selatan', district:'District Makassar', sto:'STO Makassar Pusat', lat:-5.1477, lng:119.4237, total:16, kosong:4, updated:'2026-08-27'},
  ];

  var markers = [];
  function renderMarkers(list){
    markers.forEach(function(m){ map.removeLayer(m); });
    markers = [];
    list.forEach(function(d){
      var marker = L.marker([d.lat, d.lng], { icon: odpDivIcon(odpColor(d.total, d.kosong)) }).addTo(map);
      marker.on('click', function(){ openDetail(d); });
      markers.push(marker);
    });
  }
  renderMarkers([]);

  function oltColor(merk){
    return { ZTE: '#16A34A', FIBERHOME: '#EA580C', HUAWEI: '#DC2626', ALU: '#7C3AED' }[merk] || '#6B7280';
  }

  function oltDivIcon(color){
    var svg = '<svg width="24" height="32" viewBox="0 0 24 32" xmlns="http://www.w3.org/2000/svg">' +
      '<rect x="3" y="2" width="18" height="20" rx="3" fill="' + color + '" stroke="#fff" stroke-width="1.5"/>' +
      '<rect x="6" y="6" width="12" height="2.5" rx="1" fill="#fff" opacity=".85"/>' +
      '<rect x="6" y="11" width="12" height="2.5" rx="1" fill="#fff" opacity=".85"/>' +
      '<rect x="6" y="16" width="12" height="2.5" rx="1" fill="#fff" opacity=".85"/>' +
      '<line x1="12" y1="22" x2="12" y2="30" stroke="#667085" stroke-width="2"/>' +
      '</svg>';
    return L.divIcon({ html: svg, className: 'odp-icon', iconSize: [24, 32], iconAnchor: [12, 30], popupAnchor: [0, -28] });
  }

  var OLT = [
    {hostname:'OLT-BPN-KOTA-01', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Balikpapan Kota', lokasi:'Jl. Jendral Sudirman', merk:'ZTE', model:'C320', lat:-1.2670, lng:116.8310, tahun:2023},
    {hostname:'OLT-BPN-KJ-02', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Karang Joang', lokasi:'Jl. Soekarno-Hatta KM 8', merk:'HUAWEI', model:'MA5800', lat:-1.1200, lng:116.8360, tahun:2022},
    {hostname:'OLT-BPN-SPG-03', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Sepinggan', lokasi:'Jl. Marsma Iswahyudi', merk:'FIBERHOME', model:'AN5516', lat:-1.2620, lng:116.8850, tahun:2024},
    {hostname:'OLT-BPN-GS-04', regional:'Regional Kalimantan Timur', district:'District Balikpapan', sto:'STO Gunung Sari', lokasi:'Jl. Gunung Sari Ulu', merk:'ALU', model:'7360 ISAM', lat:-1.2480, lng:116.8210, tahun:2021},
    {hostname:'OLT-SMD-KOTA-01', regional:'Regional Kalimantan Timur', district:'District Samarinda', sto:'STO Samarinda Kota', lokasi:'Jl. Gajah Mada', merk:'ZTE', model:'C300', lat:-0.5040, lng:117.1450, tahun:2023},
    {hostname:'OLT-SMD-SBR-02', regional:'Regional Kalimantan Timur', district:'District Samarinda', sto:'STO Samarinda Seberang', lokasi:'Jl. Bung Tomo', merk:'HUAWEI', model:'MA5800', lat:-0.4970, lng:117.1270, tahun:2022},
    {hostname:'OLT-MKS-PST-01', regional:'Regional Sulawesi Selatan', district:'District Makassar', sto:'STO Makassar Pusat', lokasi:'Jl. Ahmad Yani', merk:'FIBERHOME', model:'AN5516', lat:-5.1460, lng:119.4220, tahun:2024},
  ];

  var oltMarkers = [];
  function renderOltMarkers(list){
    oltMarkers.forEach(function(m){ map.removeLayer(m); });
    oltMarkers = [];
    list.forEach(function(d){
      var marker = L.marker([d.lat, d.lng], { icon: oltDivIcon(oltColor(d.merk)) }).addTo(map);
      marker.on('click', function(){ openOltDetail(d); });
      oltMarkers.push(marker);
    });
  }
  function openOltDetail(d){
    document.getElementById('detailTitle').textContent = d.hostname;
    var rows = [
      [t('rBrand'), d.merk + ' / ' + d.model], [t('rRegional'), d.regional], [t('rDistrict'), d.district], ['STO', d.sto],
      [t('rLocation'), d.lokasi], [t('rCoord'), d.lat.toFixed(4) + ', ' + d.lng.toFixed(4)], [t('rYear'), d.tahun],
    ];
    document.getElementById('detailTable').innerHTML = rows.map(function(r){
      return '<tr><td>' + r[0] + '</td><td>' + r[1] + '</td></tr>';
    }).join('');
    document.getElementById('detailModal').classList.add('show');
  }
  function setLegend(type){
    document.getElementById('legendOdp').style.display = type === 'olt' ? 'none' : '';
    document.getElementById('legendOlt').style.display = type === 'olt' ? '' : 'none';
  }

  /* ---------- dummy heatmap gangguan ---------- */
  var heatLayer = null;
  function heatPointsFor(list){
    var pts = [];
    list.forEach(function(d){
      var n = 5 + Math.floor(Math.random() * 6);
      for (var i = 0; i < n; i++){
        pts.push([
          d.lat + (Math.random() - 0.5) * 0.014,
          d.lng + (Math.random() - 0.5) * 0.014,
          0.3 + Math.random() * 0.7,
        ]);
      }
    });
    return pts;
  }
  function showHeatmap(list){
    hideHeatmap();
    heatLayer = L.heatLayer(heatPointsFor(list), { radius: 28, blur: 20, maxZoom: 16 }).addTo(map);
  }
  function hideHeatmap(){
    if (heatLayer) { map.removeLayer(heatLayer); heatLayer = null; }
  }

  function openDetail(d){
    document.getElementById('detailTitle').textContent = d.loc;
    var filled = (d.total == null) ? '—' : (d.total - d.kosong);
    var rows = [
      ['EID', d.eid], [t('rRegional'), d.regional], [t('rDistrict'), d.district], ['STO', d.sto],
      [t('rCoord'), d.lat.toFixed(4) + ', ' + d.lng.toFixed(4)],
      [t('rPanel'), d.total == null ? t('lgNotFound') : (t('rFilled') + ': ' + filled + ' / ' + t('rTotal') + ': ' + d.total)],
      [t('rUpdated'), d.updated],
    ];
    document.getElementById('detailTable').innerHTML = rows.map(function(r){
      return '<tr><td>' + r[0] + '</td><td>' + r[1] + '</td></tr>';
    }).join('');
    document.getElementById('detailModal').classList.add('show');
  }
  document.getElementById('detailClose').addEventListener('click', function(){ document.getElementById('detailModal').classList.remove('show'); });

  /* ---------- filter modal ---------- */
  var filterModal = document.getElementById('filterModal');
  document.getElementById('filterBtn').addEventListener('click', function(){ filterModal.classList.add('show'); });
  document.getElementById('filterClose').addEventListener('click', function(){ filterModal.classList.remove('show'); });

  document.querySelectorAll('input[name="searchType"]').forEach(function(r){
    r.addEventListener('change', function(){
      document.getElementById('searchArea').style.display = this.value === 'area' ? '' : 'none';
      document.getElementById('searchKoordinat').style.display = this.value === 'koordinat' ? '' : 'none';
      document.getElementById('searchNama').style.display = this.value === 'nama' ? '' : 'none';
    });
  });

  /* ---------- extra fields per data type (matches the real app's conditional fields) ---------- */
  function updateExtraFields(){
    var dataType = document.querySelector('input[name="dataType"]:checked').value;
    document.getElementById('extraOdpKomersial').style.display = dataType === 'odp_komersial' ? '' : 'none';
    document.getElementById('extraOlt').style.display = dataType === 'olt' ? '' : 'none';
    document.getElementById('extraHeatmap').style.display = dataType === 'heatmap' ? '' : 'none';
  }
  document.querySelectorAll('input[name="dataType"]').forEach(function(r){ r.addEventListener('change', updateExtraFields); });

  var F_REGIONAL = { Kalimantan: ['Regional Kalimantan Timur'], Sulawesi: ['Regional Sulawesi Selatan'] };
  var F_DISTRICT = { 'Regional Kalimantan Timur': ['District Balikpapan', 'District Samarinda'], 'Regional Sulawesi Selatan': ['District Makassar'] };
  var F_STO = {
    'District Balikpapan': ['STO Balikpapan Kota', 'STO Karang Joang', 'STO Sepinggan', 'STO Batakan', 'STO Manggar', 'STO Gunung Sari', 'STO Damai'],
    'District Samarinda': ['STO Samarinda Kota', 'STO Samarinda Seberang'],
    'District Makassar': ['STO Makassar Pusat'],
  };
  function fillSelect(el, items, placeholder){
    el.innerHTML = '<option value="">' + placeholder + '</option>';
    items.forEach(function(v){ var o = document.createElement('option'); o.textContent = v; el.appendChild(o); });
  }
  var fArea = document.getElementById('fArea'), fRegional = document.getElementById('fRegional'),
    fDistrict = document.getElementById('fDistrict'), fSto = document.getElementById('fSto');
  fArea.addEventListener('change', function(){
    fillSelect(fDistrict, [], t('phDistrict')); fDistrict.disabled = true;
    fillSelect(fSto, [], t('phSto')); fSto.disabled = true;
    if (F_REGIONAL[fArea.value]) { fillSelect(fRegional, F_REGIONAL[fArea.value], t('phRegional')); fRegional.disabled = false; }
    else { fRegional.disabled = true; fillSelect(fRegional, [], t('phRegional')); }
  });
  fRegional.addEventListener('change', function(){
    fillSelect(fSto, [], t('phSto')); fSto.disabled = true;
    if (F_DISTRICT[fRegional.value]) { fillSelect(fDistrict, F_DISTRICT[fRegional.value], t('phDistrict')); fDistrict.disabled = false; }
    else { fDistrict.disabled = true; fillSelect(fDistrict, [], t('phDistrict')); }
  });
  fDistrict.addEventListener('change', function(){
    if (F_STO[fDistrict.value]) { fillSelect(fSto, F_STO[fDistrict.value], t('phSto')); fSto.disabled = false; }
    else { fSto.disabled = true; fillSelect(fSto, [], t('phSto')); }
  });

  /* ---------- search-by-coordinate helpers ---------- */
  var searchMarker = null, searchCircle = null;
  function clearSearchPoint(){
    if (searchMarker) { map.removeLayer(searchMarker); searchMarker = null; }
    if (searchCircle) { map.removeLayer(searchCircle); searchCircle = null; }
  }
  function parseCoord(str){
    var parts = (str || '').split(',').map(function(s){ return parseFloat(s.trim()); });
    if (parts.length !== 2 || isNaN(parts[0]) || isNaN(parts[1])) { return null; }
    return { lat: parts[0], lng: parts[1] };
  }

  document.getElementById('applyFilter').addEventListener('click', function(){
    var dataType = document.querySelector('input[name="dataType"]:checked').value;
    var searchType = document.querySelector('input[name="searchType"]:checked').value;
    var source = dataType === 'olt' ? OLT : ODP;
    var nameKey = dataType === 'olt' ? 'hostname' : 'loc';
    var coordError = document.getElementById('coordError');
    coordError.style.display = 'none';
    clearSearchPoint();

    var filtered = source;
    var skipFitBounds = false;

    if (searchType === 'koordinat') {
      var coord = parseCoord(document.getElementById('fKoordinat').value);
      if (!coord) {
        coordError.textContent = t('coordInvalid');
        coordError.style.display = 'block';
        return;
      }
      var center = L.latLng(coord.lat, coord.lng);
      filtered = source.filter(function(d){ return center.distanceTo([d.lat, d.lng]) <= 350; });
      searchMarker = L.circleMarker(center, { radius: 6, color: '#465fff', weight: 2, fillColor: '#465fff', fillOpacity: .8 }).addTo(map);
      searchCircle = L.circle(center, { radius: 350, color: '#465fff', weight: 1, fillOpacity: .06 }).addTo(map);
      map.setView(center, 15);
      skipFitBounds = true;
    } else if (searchType === 'nama') {
      var q = document.getElementById('fNama').value.trim().toLowerCase();
      filtered = q ? source.filter(function(d){ return d[nameKey].toLowerCase().indexOf(q) !== -1; }) : source;
    } else {
      if (fSto.value) { filtered = source.filter(function(d){ return d.sto === fSto.value; }); }
      else if (fDistrict.value) { filtered = source.filter(function(d){ return d.district === fDistrict.value; }); }
      else if (fRegional.value) { filtered = source.filter(function(d){ return d.regional === fRegional.value; }); }
    }

    if (dataType === 'olt') {
      var merk = document.getElementById('fOltMerk').value;
      if (merk) { filtered = filtered.filter(function(d){ return d.merk === merk; }); }
      hideHeatmap(); renderMarkers([]);
      renderOltMarkers(filtered);
      setLegend('olt');
    } else if (dataType === 'heatmap') {
      renderMarkers([]); renderOltMarkers([]);
      showHeatmap(filtered.length ? filtered : ODP);
      setLegend('odp');
    } else {
      hideHeatmap(); renderOltMarkers([]);
      renderMarkers(filtered);
      setLegend('odp');
    }
    if (!skipFitBounds && filtered.length) {
      map.fitBounds(L.latLngBounds(filtered.map(function(d){ return [d.lat, d.lng]; })), { padding: [40, 40], maxZoom: 14 });
    }
    filterModal.classList.remove('show');
  });

  /* ---------- measure tool ---------- */
  var measureMode = false, measurePoints = [], measureLine = null;
  var measureBtn = document.getElementById('measureBtn'), measurePanel = document.getElementById('measurePanel');
  function updateMeasure(){
    if (measureLine) { map.removeLayer(measureLine); measureLine = null; }
    if (measurePoints.length > 1) { measureLine = L.polyline(measurePoints, { color: '#465fff', weight: 3 }).addTo(map); }
    var total = 0;
    for (var i = 1; i < measurePoints.length; i++) { total += measurePoints[i - 1].distanceTo(measurePoints[i]); }
    document.getElementById('measureVal').textContent = total >= 1000 ? (total / 1000).toFixed(2) + ' km' : Math.round(total) + ' m';
  }
  measureBtn.addEventListener('click', function(){
    measureMode = !measureMode;
    measureBtn.classList.toggle('on', measureMode);
    measurePanel.hidden = !measureMode && measurePoints.length === 0;
  });
  map.on('click', function(e){
    if (!measureMode) { return; }
    measurePoints.push(e.latlng);
    measurePanel.hidden = false;
    updateMeasure();
  });
  document.getElementById('measureUndo').addEventListener('click', function(){ measurePoints.pop(); updateMeasure(); });
  document.getElementById('measureClear').addEventListener('click', function(){
    measurePoints = []; updateMeasure(); measurePanel.hidden = true;
  });
  document.getElementById('measureDone').addEventListener('click', function(){
    measureMode = false; measureBtn.classList.remove('on');
  });

  applyLang();

  /* ---------- Tour Guide & Hints Integration (Map Alpro) ---------- */
  var mapTour = {
    id: 'tifreg-map-alpro',
    steps: [
      {
        target: '.sidebar nav',
        pos: 'right',
        title: { id: 'Navigasi Modul Operasional', en: 'Operational Modules Menu' },
        desc: {
          id: 'Sidebar navigasi untuk mengakses seluruh modul DALAPA: <b>Map Alpro</b>, User Management, Master Data, Network Element (NE), dan Quality Engineering (QE).',
          en: 'Use the sidebar menu to explore all DALAPA modules: <b>Map Alpro</b>, User Management, Master Data, Network Element (NE), and Quality Engineering (QE).'
        }
      },
      {
        target: '.layer-pill',
        pos: 'bottom',
        title: { id: 'Ganti Lapisan Peta (Layer)', en: 'Map Layer Switcher' },
        desc: {
          id: 'Beralih instan antara <b>Peta Standar (OSM)</b> dan <b>Citra Satelit</b> resolusi tinggi untuk memverifikasi posisi fisik tiang/ODP di lapangan.',
          en: 'Instantly toggle between <b>Standard Street Map (OSM)</b> and <b>High-Res Satellite</b> imagery to verify physical surroundings of network assets.'
        }
      },
      {
        target: '#measureBtn',
        pos: 'bottom',
        title: { id: 'Alat Ukur Jarak Bentang', en: 'Distance Measurement Tool' },
        desc: {
          id: 'Ukur jarak bentang kabel fiber optik antar tiang/ODP dengan mengklik titik-titik pada peta untuk kalkulasi jarak presisi dalam meter.',
          en: 'Measure fiber cable spans between poles/ODPs by clicking points directly on the map for automated distance calculations in meters.'
        }
      },
      {
        target: '#filterBtn',
        pos: 'bottom',
        title: { id: 'Filter & Pencarian Aset', en: 'Asset Filter & Search' },
        desc: {
          id: 'Buka panel filter untuk menyaring marker berdasarkan Witel, STO, vendor OLT (ZTE, Huawei, Fiberhome, ALU), dan persentase okupansi port.',
          en: 'Open the filter dialog to filter markers by Witel, STO, OLT vendor, and port occupancy levels.'
        }
      },
      {
        target: '#syncPanel',
        pos: 'right',
        title: { id: 'Status Sinkronisasi Heatmap', en: 'Sync Status & Heatmap' },
        desc: {
          id: 'Menampilkan persentase integrasi data tiket gangguan (INC) yang telah terpetakan ke dalam koordinat heatmap secara real-time.',
          en: 'Displays the live sync percentage of trouble tickets (INC) mapped into real-time operational heatmap coordinates.'
        }
      },
      {
        target: '.legend',
        pos: 'top',
        title: { id: 'Legenda Status Okupansi ODP', en: 'ODP Occupancy Legend' },
        desc: {
          id: 'Panduan arti warna marker ODP: dari kosong (hitam), kapasitas rendah (hijau), hingga okupansi penuh 80-100% (merah).',
          en: 'Visual guide to ODP marker colors: from empty (black), low capacity (green), to full 80-100% occupancy (red).'
        }
      },
      {
        target: '.topbar',
        pos: 'bottom',
        title: { id: 'Bar Kontrol & Jam WITA', en: 'Control Bar & Local Clock' },
        desc: {
          id: 'Pantau jam kerja lokal (WITA Balikpapan), beralih tema gelap/terang, ganti bahasa sistem ID/EN, dan kelola sesi akun Anda.',
          en: 'Monitor operational local time (WITA Balikpapan), toggle dark/light theme, switch language, and manage account session.'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(mapTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
