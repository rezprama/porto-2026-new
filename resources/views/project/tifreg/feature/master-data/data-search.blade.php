<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cari Data — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .filter-grid{display:grid;grid-template-columns:1fr;gap:12px;align-items:end}
  @media (min-width:900px){ .filter-grid{grid-template-columns:3fr 8fr 1fr} }
  .filter-grid .field{margin-bottom:0}
  .summary-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1px;background:var(--border);
    border:1px solid var(--border);border-radius:10px;overflow:hidden}
  @media (min-width:768px){ .summary-grid{grid-template-columns:repeat(6,1fr)} }
  .summary-cell{background:var(--panel-bg);padding:10px 12px}
  .summary-cell .k{font-size:10px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);margin-bottom:3px}
  .summary-cell .v{font-size:13px;font-weight:600;color:var(--text);word-break:break-all}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'master-search'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">Master Data</div>
    <h1 data-i18n="pageTitle">Cari Data</h1>
  </div>

  <div class="stack">
    <!-- FILTER -->
    <div class="card">
      <div class="card-head"><h3 data-i18n="filterTitle">Search Data Filter</h3></div>
      <div class="card-body">
        <div class="filter-grid">
          <div class="field">
            <label data-i18n="filterType">Jenis Data</label>
            <select id="fType">
              <option value="odp" data-i18n="optOdp">Nama ODP</option>
              <option value="sid" data-i18n="optSid">SID</option>
              <option value="ticket" data-i18n="optTicket">Nomor Tiket</option>
            </select>
          </div>
          <div class="field">
            <label data-i18n="filterKeyword">Pencarian</label>
            <input type="text" id="fKeyword" value="ODP-BPN-014" data-i18n-ph="phOdp" placeholder="Masukkan nama ODP" />
          </div>
          <div class="field">
            <button class="btn-primary" id="filterBtn" style="width:100%" data-i18n="filterBtn">Filter</button>
          </div>
        </div>
      </div>
    </div>

    <!-- INITIAL / UNDER CONSTRUCTION -->
    <div class="card" id="stateCard">
      <div class="empty-box" id="stateText" data-i18n="stateInitial">Masukkan nama ODP lalu klik Filter untuk melihat data.</div>
    </div>

    <!-- RESULTS -->
    <div id="results" hidden class="stack">
      <!-- 1. Latest Valins -->
      <div class="card">
        <div class="card-head">
          <h3 data-i18n="valinsTitle">Data Valins Terbaru</h3>
          <button class="btn-success" id="refreshValins" data-i18n="refresh">Refresh</button>
        </div>
        <div class="card-note" data-i18n="valinsNote">Data Valins Terbaru digunakan untuk proses Mapping E2E ketika ODP kosong atau ONT lapangan tidak tersedia.</div>
        <div class="table-scroll" style="margin-top:12px">
          <table>
            <thead>
              <tr>
                <th>Valins ID</th>
                <th data-i18n="cOdpPanel">Panel ODP</th>
                <th>Hostname</th>
                <th>IP</th>
                <th>Slot</th>
                <th>Port</th>
                <th data-i18n="cValinsDate">Tanggal Valins</th>
                <th data-i18n="cDalapaStatus">Status Dalapa</th>
                <th data-i18n="cUpdatedAt">Tanggal Update</th>
              </tr>
            </thead>
            <tbody id="valinsBody"></tbody>
          </table>
        </div>
      </div>

      <!-- 2. Field Validation -->
      <div class="card">
        <div class="card-head"><h3 data-i18n="fieldTitle">Data Validasi Lapangan</h3></div>
        <div class="card-note" data-i18n="fieldNote">Tabel ini menampilkan data validasi lapangan yang sudah tercatat untuk ODP yang dipilih.</div>
        <div class="table-scroll" style="margin-top:12px">
          <table>
            <thead>
              <tr>
                <th>No.</th><th>ODP</th><th>Voice</th><th>Inet</th><th>GPON</th>
                <th data-i18n="cGponPort">Port GPON</th><th>SN ONT</th><th>Valins ID</th>
                <th data-i18n="cOntAdded">Tanggal Penambahan ONT</th><th>Updated By</th>
              </tr>
            </thead>
            <tbody id="fieldBody"></tbody>
          </table>
        </div>
      </div>

      <!-- 3. Mapping E2E (readonly) -->
      <div class="card">
        <div class="card-head">
          <h3 data-i18n="e2eTitle">Data Mapping E2E</h3>
          <button class="btn-sky" id="reprocessE2E">Reprocess</button>
        </div>
        <div class="card-body">
          <div class="row3">
            <div class="field"><label>ODP Name</label><input readonly value="ODP-BPN-014" /></div>
            <div class="field"><label>ODP EID</label><input readonly value="EID-4471" /></div>
            <div class="field"><label>ODP ID</label><input readonly value="41182291" /></div>
          </div>
          <div class="row3">
            <div class="field"><label>Regional</label><input readonly value="KALIMANTAN" /></div>
            <div class="field"><label>Witel</label><input readonly value="KALTIMTARA" /></div>
            <div class="field"><label>STO</label><input readonly value="BPP" /></div>
          </div>
          <div class="row2">
            <div class="field"><label>ODP OLT UIM</label><textarea rows="4" readonly>BPP-D3-01/1/2/4
GPON-OLT-BPP-D3
Port: 4 | Slot: 2</textarea></div>
            <div class="field"><label>ODP OLT Mapping</label><textarea rows="4" readonly>BPP-D3-01/1/2/4
Mapped at 2026-08-30 10:22
Source: valins</textarea></div>
          </div>
          <div class="row3">
            <div class="field"><label>Status E2E</label><input readonly value="MAPPED" /></div>
            <div class="field"><label>Last Update E2E</label><input readonly value="2026-08-30 10:22" /></div>
            <div class="field"><label>Failed Message</label><textarea rows="3" readonly>-</textarea></div>
          </div>
        </div>
      </div>

      <!-- 4. ODP Info -->
      <div class="card">
        <div class="card-head"><h3 data-i18n="odpInfoTitle">Data ODP Info</h3></div>
        <div class="table-scroll" style="margin-top:12px">
          <table>
            <thead>
              <tr>
                <th>ODP EID</th><th>ODP Name</th><th>ODP Location</th><th>Regional</th>
                <th>Witel</th><th>STO</th><th data-i18n="cCoord">Koordinat</th><th>ODP Status</th>
                <th>Panel</th><th>ODP OLT</th>
              </tr>
            </thead>
            <tbody id="odpInfoBody"></tbody>
          </table>
        </div>
      </div>

      <!-- 5. UIM Service -->
      <div class="card">
        <div class="card-head"><h3 data-i18n="uimTitle">Data Service UIM</h3></div>
        <div class="table-scroll" style="margin-top:12px">
          <table>
            <thead>
              <tr>
                <th>Panel</th><th>Port Num</th><th>Port ID</th><th>Port Name</th>
                <th>FTTX Dropcable</th><th>Service Voice</th><th>Service BB</th><th>Service IPTV</th>
              </tr>
            </thead>
            <tbody id="uimBody"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Cari Data', filterTitle: 'Search Data Filter', filterType: 'Jenis Data',
      filterKeyword: 'Pencarian', filterBtn: 'Filter', filtering: 'Memfilter...',
      optOdp: 'Nama ODP', optSid: 'SID', optTicket: 'Nomor Tiket',
      phOdp: 'Masukkan nama ODP', phSid: 'Masukkan SID', phTicket: 'Masukkan nomor tiket',
      stateInitial: 'Masukkan nama ODP lalu klik Filter untuk melihat data.',
      stateUnderConstruction: 'Pencarian untuk SID dan Nomor Tiket masih dalam tahap pengembangan.',
      searchRequired: 'Nama ODP wajib diisi.',
      refreshSuccess: 'Refresh valins berhasil dijalankan.', reprocessSuccess: 'Reprocess E2E berhasil dijalankan.',
      valinsTitle: 'Data Valins Terbaru',
      valinsNote: 'Data Valins Terbaru digunakan untuk proses Mapping E2E ketika ODP kosong atau ONT lapangan tidak tersedia.',
      fieldTitle: 'Data Validasi Lapangan',
      fieldNote: 'Tabel ini menampilkan data validasi lapangan yang sudah tercatat untuk ODP yang dipilih.',
      e2eTitle: 'Data Mapping E2E', odpInfoTitle: 'Data ODP Info', uimTitle: 'Data Service UIM',
      cOdpPanel: 'Panel ODP', cValinsDate: 'Tanggal Valins', cDalapaStatus: 'Status Dalapa',
      cUpdatedAt: 'Tanggal Update', cGponPort: 'Port GPON', cOntAdded: 'Tanggal Penambahan ONT', cCoord: 'Koordinat',
      noValidation: 'Validasi data tidak ditemukan.',
    },
    en: {
      pageTitle: 'Search Data', filterTitle: 'Search Data Filter', filterType: 'Data Type',
      filterKeyword: 'Keyword', filterBtn: 'Filter', filtering: 'Filtering...',
      optOdp: 'ODP Name', optSid: 'SID', optTicket: 'Ticket Number',
      phOdp: 'Enter ODP name', phSid: 'Enter SID', phTicket: 'Enter ticket number',
      stateInitial: 'Enter an ODP name and click Filter to load the data.',
      stateUnderConstruction: 'Search for SID and Ticket Number is still under construction.',
      searchRequired: 'ODP name is required.',
      refreshSuccess: 'Valins refresh started successfully.', reprocessSuccess: 'E2E reprocess started successfully.',
      valinsTitle: 'Latest Valins Data',
      valinsNote: 'Latest Valins data is used for Mapping E2E when the ODP is empty or field ONT data is unavailable.',
      fieldTitle: 'Field Validation Data',
      fieldNote: 'This table shows the field validation data recorded for the selected ODP.',
      e2eTitle: 'Mapping E2E Data', odpInfoTitle: 'ODP Info Data', uimTitle: 'UIM Service Data',
      cOdpPanel: 'ODP Panel', cValinsDate: 'Valins Date', cDalapaStatus: 'Dalapa Status',
      cUpdatedAt: 'Updated At', cGponPort: 'GPON Port', cOntAdded: 'ONT Added At', cCoord: 'Coordinate',
      noValidation: 'No validation data found.',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy data ---------- */
  var VALINS = [
    { id: 'VLN-880412', panel: 'ODP-BPN-014/1', host: 'GPON-OLT-BPP-D3', ip: '10.14.22.11', slot: 2, port: 4, date: '2026-08-30', status: 'ENABLE', updated: '2026-08-30 10:22' },
    { id: 'VLN-880398', panel: 'ODP-BPN-014/2', host: 'GPON-OLT-BPP-D3', ip: '10.14.22.11', slot: 2, port: 5, date: '2026-08-28', status: 'VALID', updated: '2026-08-28 08:15' },
    { id: 'VLN-880341', panel: 'ODP-BPN-014/3', host: 'GPON-OLT-BPP-D3', ip: '10.14.22.11', slot: 2, port: 6, date: '2026-08-21', status: 'DISABLE', updated: '2026-08-21 16:40' },
    { id: 'VLN-880277', panel: 'ODP-BPN-014/4', host: 'GPON-OLT-BPP-D3', ip: '10.14.22.11', slot: 3, port: 1, date: '2026-08-12', status: 'PENDING', updated: '2026-08-12 09:05' },
  ];
  var FIELD_VALIDATION = [
    { odp: 'ODP-BPN-014', voice: '0542-77xxxx', inet: '132xxxxxxx', gpon: 'GPON-OLT-BPP-D3', port: '2/4', sn: 'ZTEGC8A12F03', valins: 'VLN-880412', added: '2026-08-30 10:20', by: 'reza.pratama' },
    { odp: 'ODP-BPN-014', voice: '-', inet: '132xxxxxxx', gpon: 'GPON-OLT-BPP-D3', port: '2/5', sn: 'ZTEGC8A12F41', valins: 'VLN-880398', added: '2026-08-28 08:12', by: 'ulsyairil' },
    { odp: 'ODP-BPN-014', voice: '0542-77xxxx', inet: '-', gpon: 'GPON-OLT-BPP-D3', port: '2/6', sn: 'FHTT2210AB77', valins: 'VLN-880341', added: '2026-08-21 16:35', by: 'bagus.wicaksono' },
  ];
  var ODP_INFO = [
    { eid: 'EID-4471', name: 'ODP-BPN-014', loc: 'Jl. Jendral Sudirman', reg: 'KALIMANTAN', witel: 'KALTIMTARA', sto: 'BPP', coord: '-1.2650, 116.8286', status: 'ACTIVE', panel: '16', olt: 'BPP-D3-01' },
  ];
  var UIM = [
    { panel: '1', num: '4', pid: 'P-41182291-4', pname: 'ODP-BPN-014/1/4', drop: 'DC-BPP-0142', voice: 'ACTIVE', bb: 'ACTIVE', iptv: 'ACTIVE' },
    { panel: '1', num: '5', pid: 'P-41182291-5', pname: 'ODP-BPN-014/1/5', drop: 'DC-BPP-0143', voice: '-', bb: 'ACTIVE', iptv: '-' },
    { panel: '2', num: '6', pid: 'P-41182291-6', pname: 'ODP-BPN-014/2/6', drop: 'DC-BPP-0151', voice: 'ACTIVE', bb: 'SUSPEND', iptv: '-' },
  ];

  function statusPill(v){
    var s = (v || '').toLowerCase(), cls = 'pill-gray';
    if (s.indexOf('enable') !== -1 || s.indexOf('valid') !== -1) { cls = 'pill-green'; }
    if (s.indexOf('disable') !== -1 || s.indexOf('invalid') !== -1) { cls = 'pill-red'; }
    return '<span class="pill ' + cls + '">' + v + '</span>';
  }
  function servicePill(v){
    if (v === '-') { return '<span class="pill pill-gray">-</span>'; }
    return '<span class="pill ' + (v === 'ACTIVE' ? 'pill-green' : 'pill-amber') + '">' + v + '</span>';
  }

  function renderTables(){
    document.getElementById('valinsBody').innerHTML = VALINS.map(function(v){
      return '<tr><td class="mono-cell">' + v.id + '</td><td>' + v.panel + '</td><td>' + v.host + '</td>' +
        '<td class="mono-cell">' + v.ip + '</td><td>' + v.slot + '</td><td>' + v.port + '</td>' +
        '<td>' + v.date + '</td><td>' + statusPill(v.status) + '</td><td>' + v.updated + '</td></tr>';
    }).join('');

    document.getElementById('fieldBody').innerHTML = FIELD_VALIDATION.map(function(f, i){
      return '<tr><td>' + (i + 1) + '</td><td>' + f.odp + '</td><td>' + f.voice + '</td><td>' + f.inet + '</td>' +
        '<td>' + f.gpon + '</td><td>' + f.port + '</td><td class="mono-cell">' + f.sn + '</td>' +
        '<td class="mono-cell">' + f.valins + '</td><td>' + f.added + '</td><td>' + f.by + '</td></tr>';
    }).join('');

    document.getElementById('odpInfoBody').innerHTML = ODP_INFO.map(function(o){
      return '<tr><td class="mono-cell">' + o.eid + '</td><td>' + o.name + '</td><td>' + o.loc + '</td>' +
        '<td>' + o.reg + '</td><td>' + o.witel + '</td><td>' + o.sto + '</td>' +
        '<td class="mono-cell">' + o.coord + '</td><td>' + statusPill(o.status) + '</td>' +
        '<td>' + o.panel + '</td><td>' + o.olt + '</td></tr>';
    }).join('');

    document.getElementById('uimBody').innerHTML = UIM.map(function(u){
      return '<tr><td>' + u.panel + '</td><td>' + u.num + '</td><td class="mono-cell">' + u.pid + '</td>' +
        '<td>' + u.pname + '</td><td class="mono-cell">' + u.drop + '</td>' +
        '<td>' + servicePill(u.voice) + '</td><td>' + servicePill(u.bb) + '</td><td>' + servicePill(u.iptv) + '</td></tr>';
    }).join('');
  }

  /* ---------- filter behavior ---------- */
  var typeSel = document.getElementById('fType'), keywordInput = document.getElementById('fKeyword');
  var stateCard = document.getElementById('stateCard'), stateText = document.getElementById('stateText');
  var results = document.getElementById('results'), filterBtn = document.getElementById('filterBtn');

  typeSel.addEventListener('change', function(){
    keywordInput.placeholder = t(typeSel.value === 'odp' ? 'phOdp' : typeSel.value === 'sid' ? 'phSid' : 'phTicket');
    keywordInput.dataset.i18nPh = typeSel.value === 'odp' ? 'phOdp' : typeSel.value === 'sid' ? 'phSid' : 'phTicket';
  });

  filterBtn.addEventListener('click', function(){
    if (typeSel.value !== 'odp') {
      results.hidden = true;
      stateCard.hidden = false;
      stateText.dataset.i18n = 'stateUnderConstruction';
      stateText.textContent = t('stateUnderConstruction');
      return;
    }
    if (!keywordInput.value.trim()) {
      toast(t('searchRequired'));
      return;
    }
    filterBtn.textContent = t('filtering');
    setTimeout(function(){
      filterBtn.textContent = t('filterBtn');
      renderTables();
      stateCard.hidden = true;
      results.hidden = false;
    }, 450);
  });
  keywordInput.addEventListener('keydown', function(e){ if (e.key === 'Enter') { filterBtn.click(); } });

  document.getElementById('refreshValins').addEventListener('click', function(){ toast(t('refreshSuccess')); });
  document.getElementById('reprocessE2E').addEventListener('click', function(){ toast(t('reprocessSuccess')); });

  function onLangChange(){ if (!results.hidden) { renderTables(); } }
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var dataSearchTour = {
    id: 'tifreg-master-search',
    steps: [
      {
        target: '.sidebar nav',
        pos: 'right',
        title: { id: 'Navigasi Master Data', en: 'Master Data Navigation' },
        desc: {
          id: 'Menu Master Data memfasilitasi pencarian menyeluruh aset jaringan, pengelolaan hierarki Organisasi & Unit QE, serta sinkronisasi tiket Metabase.',
          en: 'Master Data enables comprehensive network asset lookups, Organizational & Unit QE hierarchies, and Metabase ticket synchronization.'
        }
      },
      {
        target: '#fType',
        pos: 'bottom',
        title: { id: 'Pilihan Jenis Data Pencarian', en: 'Search Target Data Type' },
        desc: {
          id: 'Pilih jenis entitas yang ingin dilacak: <b>Nama ODP</b>, <b>SID</b> (Service ID) pelanggan, atau <b>Nomor Tiket</b> gangguan.',
          en: 'Select entity type to lookup: <b>ODP Name</b>, customer <b>SID</b>, or trouble <b>Ticket Number</b>.'
        }
      },
      {
        target: '#fKeyword',
        pos: 'bottom',
        title: { id: 'Kata Kunci & Contoh Format', en: 'Keyword Input & Examples' },
        desc: {
          id: 'Ketik nama ODP (contoh: <code>ODP-BPN-014</code>) atau SID/nomor tiket, lalu tekan Enter atau klik Filter.',
          en: 'Type the ODP name (e.g. <code>ODP-BPN-014</code>) or SID/ticket ID, then press Enter or click Filter.'
        }
      },
      {
        target: '#filterBtn',
        pos: 'bottom',
        title: { id: 'Eksekusi Filter & Sinkronisasi', en: 'Execute Filter & Fetch Data' },
        desc: {
          id: 'Klik tombol <b>Filter</b> untuk menarik dan menyatukan data dari 5 modul: Valins Terbaru, Validasi Lapangan, E2E Mapping, Info ODP, dan UIM Pelanggan.',
          en: 'Click <b>Filter</b> to aggregate data across 5 modules: Latest Valins, Field Validations, E2E Mapping, ODP Details, and Customer UIM.'
        }
      },
      {
        target: '#stateCard',
        pos: 'bottom',
        title: { id: 'Panel Agregasi Data Jaringan', en: 'Unified Network Data Panel' },
        desc: {
          id: 'Hasil pencarian akan merinci kondisi fisik ODP, port ONT terpasang, pemetaan E2E, serta status layanan broadband (Voice, Internet, IPTV).',
          en: 'Search output reveals physical ODP health, connected ONT ports, E2E mappings, and active triple-play services.'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(dataSearchTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
