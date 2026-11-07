<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Material Assurance — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .file-drop{border:1px dashed var(--border);border-radius:4px;padding:26px 18px;text-align:center;color:var(--muted);font-size:12.5px}
  .file-drop b{display:block;color:var(--text);font-size:13px;margin-bottom:4px}
  .file-drop input{display:none}
  .file-drop .pick{display:inline-block;margin-top:10px;height:32px;line-height:32px;padding:0 14px;border-radius:4px;
    background:var(--brand-600);color:#fff;font-size:12px;font-weight:700;cursor:pointer}
  .num{text-align:right;font-variant-numeric:tabular-nums}
  th.num{text-align:right}
  .sub-tabs{margin-top:0}
  .detail-empty{padding:34px 20px;text-align:center;color:var(--muted);font-size:13px}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'assurance-rekon'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="crumbRekon">Rekon Assurance</span><span data-i18n="pageTitle">Material Assurance</span></div>
    <h1 data-i18n="pageTitle">Material Assurance</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head"><h3 data-i18n="panelTitle">Data Assurance BOQ</h3></div>
      <div class="tabs">
        <button class="on" data-tab="#tabBoq" data-i18n="tabBoq">Data BOQ</button>
        <button data-tab="#tabInput" data-i18n="tabInput">Form Input Data</button>
        <button data-tab="#tabKhs" data-i18n="tabKhs">Form KHS</button>
      </div>

      <!-- ============ DATA BOQ ============ -->
      <div id="tabBoq">
        <div class="card-body">
          <div class="row3">
            <div class="field">
              <label>Type</label>
              <select id="fType">
                <option value="" data-i18n="allType">ALL TYPE</option>
                <option>ASSURANCE</option><option>ASSURANCE (Tahap 2)</option>
                <option>CCAN</option><option>WANOLO</option><option>REMO UNDERSPEC</option><option>SQM</option>
              </select>
            </div>
            <div class="field"><label>Regional</label><select id="fRegional"><option value="" data-i18n="all">Semua</option><option>REGIONAL 5</option><option>REGIONAL 6</option><option>REGIONAL 7</option></select></div>
            <div class="field"><label>Witel</label><select id="fWitel"><option value="" data-i18n="all">Semua</option></select></div>
          </div>
          <div class="row3">
            <div class="field"><label data-i18n="month">Bulan</label><select id="fMonth"><option value="" data-i18n="all">Semua</option></select></div>
            <div class="field"><label data-i18n="year">Tahun</label><select id="fYear"><option value="">2026</option></select></div>
            <div class="field" style="align-self:end"><button class="btn-success" id="filterBtn" style="width:100%" data-i18n="filter">Filter</button></div>
          </div>
        </div>

        <div class="card-body" style="padding-top:0">
          <div class="stat-grid" id="statGrid"></div>
        </div>

        <div class="table-toolbar">
          <select id="perPage"><option value="8">8 / halaman</option><option value="15">15 / halaman</option></select>
          <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari witel / file / pengirim..." />
        </div>
        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr>
                <th>Regional</th><th>Witel</th><th data-i18n="cType">Tipe</th><th data-i18n="cPeriod">Periode</th>
                <th>File</th><th data-i18n="cInputDate">Tanggal Input</th><th data-i18n="cSubmitted">Submitted By</th>
                <th class="num" data-i18n="cTotalData">Total Data</th>
                <th class="num" data-i18n="cRejected">Rejected</th>
                <th class="num" data-i18n="cApproved">Approved</th>
                <th data-i18n="cStatus">Status</th><th data-i18n="cAction">Action</th>
              </tr>
            </thead>
            <tbody id="tbody"></tbody>
          </table>
        </div>
        <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
      </div>

      <!-- ============ FORM INPUT ============ -->
      <div id="tabInput" hidden>
        <div class="card-body">
          <div class="row3">
            <div class="field"><label>Type</label><select><option>ASSURANCE</option><option>ASSURANCE (Tahap 2)</option><option>CCAN</option><option>WANOLO</option><option>REMO UNDERSPEC</option><option>SQM</option></select></div>
            <div class="field"><label>Regional</label><select><option>REGIONAL 6</option><option>REGIONAL 5</option><option>REGIONAL 7</option></select></div>
            <div class="field"><label>Witel</label><select><option>WITEL BALIKPAPAN</option><option>WITEL SAMARINDA</option><option>WITEL BANJARMASIN</option></select></div>
          </div>
          <div class="row3">
            <div class="field"><label data-i18n="month">Bulan</label><select><option>AGUSTUS</option><option selected>SEPTEMBER</option></select></div>
            <div class="field"><label data-i18n="year">Tahun</label><select><option>2026</option><option>2025</option></select></div>
            <div class="field"><label data-i18n="template">Template</label><button class="btn-outline" id="tplBtn" style="width:100%" data-i18n="downloadTpl">Download Template</button></div>
          </div>
          <div class="field">
            <label data-i18n="fileBoq">File BOQ (.xlsx)</label>
            <label class="file-drop" for="boqFile">
              <b data-i18n="dropTitle">Tarik berkas ke sini atau pilih dari komputer</b>
              <span data-i18n="dropHint">Format .xlsx, maksimal 10 MB. Kolom wajib: Ticket, STO, Service Number, Actual Solution, Designator, Volume.</span>
              <input type="file" id="boqFile" accept=".xlsx,.xls" />
              <span class="pick" data-i18n="chooseFile">Pilih Berkas</span>
              <div id="fileName" style="margin-top:8px;font-size:12px;color:var(--text)"></div>
            </label>
          </div>
          <div class="row-actions">
            <button class="btn-primary" id="uploadBtn" data-i18n="upload">Upload &amp; Validasi</button>
            <button class="btn-outline" id="resetUpload" data-i18n="reset">Reset</button>
          </div>
        </div>
      </div>

      <!-- ============ FORM KHS ============ -->
      <div id="tabKhs" hidden>
        <div class="card-note" data-i18n="khsNote">Harga Satuan Standar (HSS) yang dipakai saat rekonsiliasi BOQ. Nilai di bawah adalah data contoh.</div>
        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr>
                <th>Designator</th><th data-i18n="cUraian">Uraian Pekerjaan</th><th data-i18n="cSatuan">Satuan</th>
                <th class="num" data-i18n="cHssMaterial">HSS Material</th>
                <th class="num" data-i18n="cHssJasa">HSS Jasa</th>
                <th class="num" data-i18n="cHssTotal">Total HSS</th>
              </tr>
            </thead>
            <tbody id="khsBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ============ DETAIL PANEL ============ -->
    <div class="card" id="detailCard">
      <div class="card-head"><h3 id="detailTitle" data-i18n="detailTitle">Detail Rekonsiliasi</h3></div>
      <div class="tabs" id="detailTabs">
        <button class="on" data-tab="#dApproved" data-i18n="dApproved">Data Detail BOQ Approved</button>
        <button data-tab="#dRejected" data-i18n="dRejected">Data Detail BOQ Rejected</button>
        <button data-tab="#dActsol" data-i18n="dActsol">Data Actual Solution</button>
        <button data-tab="#dKhs" data-i18n="dKhs">Rekap KHS</button>
      </div>
      <div id="dApproved"><div class="table-scroll"><table class="bordered"><thead id="apprHead"></thead><tbody id="apprBody"></tbody></table></div></div>
      <div id="dRejected" hidden><div class="table-scroll"><table class="bordered"><thead id="rejHead"></thead><tbody id="rejBody"></tbody></table></div></div>
      <div id="dActsol" hidden><div class="table-scroll"><table class="bordered"><thead id="actHead"></thead><tbody id="actBody"></tbody></table></div></div>
      <div id="dKhs" hidden><div class="table-scroll"><table class="bordered"><thead id="rekapHead"></thead><tbody id="rekapBody"></tbody></table></div></div>
    </div>

    <div class="card" id="detailPlaceholder">
      <div class="detail-empty" data-i18n="pickBatch">Pilih salah satu baris BOQ lalu klik "Detail" untuk melihat hasil rekonsiliasi.</div>
    </div>
  </div>
</main>

<script>
  var PAGE_I18N = {
    pageTitle: 'Material Assurance', crumbRekon: 'Rekon Assurance', panelTitle: 'Data Assurance BOQ',
    tabBoq: 'Data BOQ', tabInput: 'Form Input Data', tabKhs: 'Form KHS',
    allType: 'ALL TYPE', month: 'Bulan', year: 'Tahun',
    searchPh: 'Cari witel / file / pengirim...',
    cType: 'Tipe', cPeriod: 'Periode', cInputDate: 'Tanggal Input', cSubmitted: 'Submitted By',
    cTotalData: 'Total Data', cRejected: 'Rejected', cApproved: 'Approved', cStatus: 'Status', cAction: 'Action',
    stWaiting: 'WAITING', stProses: 'PROSES REKON', stDone: 'SELESAI',
    sBatch: 'Berkas BOQ', sTicket: 'Total Tiket', sApproved: 'Tiket Approved', sRejected: 'Tiket Rejected', sValue: 'Nilai Rekonsiliasi',
    template: 'Template', downloadTpl: 'Download Template', fileBoq: 'File BOQ (.xlsx)',
    dropTitle: 'Tarik berkas ke sini atau pilih dari komputer',
    dropHint: 'Format .xlsx, maksimal 10 MB. Kolom wajib: Ticket, STO, Service Number, Actual Solution, Designator, Volume.',
    chooseFile: 'Pilih Berkas', upload: 'Upload & Validasi',
    khsNote: 'Harga Satuan Standar (HSS) yang dipakai saat rekonsiliasi BOQ. Nilai di bawah adalah data contoh.',
    cUraian: 'Uraian Pekerjaan', cSatuan: 'Satuan', cHssMaterial: 'HSS Material', cHssJasa: 'HSS Jasa', cHssTotal: 'Total HSS',
    detailTitle: 'Detail Rekonsiliasi',
    dApproved: 'Data Detail BOQ Approved', dRejected: 'Data Detail BOQ Rejected',
    dActsol: 'Data Actual Solution', dKhs: 'Rekap KHS',
    pickBatch: 'Pilih salah satu baris BOQ lalu klik "Detail" untuk melihat hasil rekonsiliasi.',
    cTicket: 'Ticket', cService: 'Service Number', cActsol: 'Actual Solution', cNote: 'Catatan',
    cTotalTicket: 'Total Ticket', cVolume: 'Volume', cNilai: 'Nilai',
    noteOver: 'Volume melebihi batas KHS', noteDup: 'Tiket duplikat pada periode yang sama',
    noteNoActsol: 'Actual solution tidak terdaftar', noteNoSn: 'Service number tidak ditemukan di INSERA',
    uploadOk: 'Berkas tervalidasi — demo, tidak dikirim ke server.', noFile: 'Pilih berkas .xlsx terlebih dahulu.',
    hss: 'HSS', volPerSto: 'STO / Volume',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')

<script>
  var MONTHS = ['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
  var WITELS = {
    'REGIONAL 5': ['WITEL SURABAYA', 'WITEL MALANG'],
    'REGIONAL 6': ['WITEL BALIKPAPAN', 'WITEL SAMARINDA', 'WITEL BANJARMASIN'],
    'REGIONAL 7': ['WITEL MAKASSAR', 'WITEL KENDARI'],
  };
  var KHS = [
    { d: 'PS-1-20',    u: 'Pasang Splitter 1:20',                 s: 'BH',  m: 1350000, j: 285000 },
    { d: 'AC-OF-SM-1', u: 'Kabel Drop Optik 1 Core',              s: 'MTR', m: 3200,    j: 1450 },
    { d: 'PC-APC-250', u: 'Patch Cord APC 250 M',                 s: 'BH',  m: 88000,   j: 21000 },
    { d: 'SOC-1',      u: 'Splice On Connector',                  s: 'BH',  m: 42000,   j: 18500 },
    { d: 'OTP-1',      u: 'Optical Termination Premise',          s: 'BH',  m: 65000,   j: 24000 },
    { d: 'TC-02',      u: 'Tiang Cor 7 Meter',                    s: 'BH',  m: 1180000, j: 420000 },
    { d: 'BC-OF-SM-8', u: 'Kabel Udara Optik 8 Core',             s: 'MTR', m: 9800,    j: 3600 },
    { d: 'PU-S7.0-400',u: 'Penarikan Kabel Udara s/d 400 Meter',  s: 'MTR', m: 0,       j: 5200 },
  ];
  var ACTSOL = ['Perbaikan Kabel Drop', 'Penggantian ONT', 'Perbaikan Konektor', 'Penggantian Splitter',
                'Perbaikan Tiang', 'Recovery Kabel Udara', 'Penggantian Patch Cord'];
  var STOS = ['BPP', 'SPG', 'KJG', 'MGR', 'GSR', 'SMD', 'SKG', 'APH'];
  var REJECT_NOTES = ['noteOver', 'noteDup', 'noteNoActsol', 'noteNoSn'];

  var BATCHES = [
    { regional:'REGIONAL 6', witel:'WITEL BALIKPAPAN',  tipe:'ASSURANCE',           month:8, year:2026, file:'BOQ_ASSR_BPP_092026.xlsx', tglInput:'2026-09-08 09:14', by:'Reza Pratama',    total:412, rejected:23, status:'DONE' },
    { regional:'REGIONAL 6', witel:'WITEL BALIKPAPAN',  tipe:'ASSURANCE (Tahap 2)', month:8, year:2026, file:'BOQ_ASSR2_BPP_092026.xlsx',tglInput:'2026-09-11 15:02', by:'Reza Pratama',    total:118, rejected:6,  status:'PROSES' },
    { regional:'REGIONAL 6', witel:'WITEL SAMARINDA',   tipe:'ASSURANCE',           month:8, year:2026, file:'BOQ_ASSR_SMD_092026.xlsx', tglInput:'2026-09-09 11:41', by:'Andi Saputra',    total:376, rejected:31, status:'DONE' },
    { regional:'REGIONAL 6', witel:'WITEL SAMARINDA',   tipe:'CCAN',                month:8, year:2026, file:'BOQ_CCAN_SMD_092026.xlsx', tglInput:'2026-09-12 08:27', by:'Andi Saputra',    total:94,  rejected:4,  status:'WAITING' },
    { regional:'REGIONAL 6', witel:'WITEL BANJARMASIN', tipe:'ASSURANCE',           month:8, year:2026, file:'BOQ_ASSR_BJM_092026.xlsx', tglInput:'2026-09-10 16:58', by:'Putri Lestari',   total:288, rejected:19, status:'DONE' },
    { regional:'REGIONAL 6', witel:'WITEL BANJARMASIN', tipe:'WANOLO',              month:7, year:2026, file:'BOQ_WANOLO_BJM_082026.xlsx',tglInput:'2026-08-14 10:05',by:'Putri Lestari',   total:142, rejected:11, status:'DONE' },
    { regional:'REGIONAL 5', witel:'WITEL SURABAYA',    tipe:'SQM',                 month:8, year:2026, file:'BOQ_SQM_SBY_092026.xlsx',  tglInput:'2026-09-07 13:33', by:'Bagus Wicaksono', total:206, rejected:14, status:'DONE' },
    { regional:'REGIONAL 5', witel:'WITEL MALANG',      tipe:'REMO UNDERSPEC',      month:8, year:2026, file:'BOQ_REMO_MLG_092026.xlsx', tglInput:'2026-09-13 07:52', by:'Bagus Wicaksono', total:77,  rejected:3,  status:'PROSES' },
    { regional:'REGIONAL 7', witel:'WITEL MAKASSAR',    tipe:'ASSURANCE',           month:8, year:2026, file:'BOQ_ASSR_MKS_092026.xlsx', tglInput:'2026-09-09 09:20', by:'Dewi Anggraini',  total:341, rejected:27, status:'DONE' },
    { regional:'REGIONAL 7', witel:'WITEL KENDARI',     tipe:'CCAN',                month:7, year:2026, file:'BOQ_CCAN_KDI_082026.xlsx', tglInput:'2026-08-18 14:47', by:'Dewi Anggraini',  total:88,  rejected:9,  status:'DONE' },
  ];
  BATCHES.forEach(function(b, i){ b.id = i; b.approved = b.total - b.rejected; });

  var STATUS_PILL = { WAITING: 'pill-gray', PROSES: 'pill-amber', DONE: 'pill-green' };
  var STATUS_KEY = { WAITING: 'stWaiting', PROSES: 'stProses', DONE: 'stDone' };

  /* ---------- filters ---------- */
  var fRegional = document.getElementById('fRegional'), fWitel = document.getElementById('fWitel'),
      fType = document.getElementById('fType'), fMonth = document.getElementById('fMonth'),
      searchInput = document.getElementById('searchInput'), perPage = document.getElementById('perPage');

  function fillKeepFirst(sel, values){
    var first = sel.firstElementChild;
    sel.innerHTML = '';
    sel.appendChild(first);
    values.forEach(function(v){
      var o = document.createElement('option');
      o.textContent = v.label !== undefined ? v.label : v;
      o.value = v.value !== undefined ? v.value : v;
      sel.appendChild(o);
    });
  }
  fillKeepFirst(fMonth, MONTHS.map(function(m, i){ return { value: i, label: m }; }));
  function syncWitel(){
    var list = fRegional.value ? WITELS[fRegional.value] : Object.keys(WITELS).reduce(function(a, k){ return a.concat(WITELS[k]); }, []);
    fillKeepFirst(fWitel, list);
  }
  fRegional.addEventListener('change', function(){ syncWitel(); currentPage = 1; renderTable(); });
  syncWitel();

  var currentPage = 1;
  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return BATCHES.filter(function(b){
      if (fRegional.value && b.regional !== fRegional.value) { return false; }
      if (fWitel.value && b.witel !== fWitel.value) { return false; }
      if (fType.value && b.tipe !== fType.value) { return false; }
      if (fMonth.value !== '' && b.month !== parseInt(fMonth.value, 10)) { return false; }
      if (q && (b.witel + ' ' + b.file + ' ' + b.by).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderStats(rows){
    var tickets = rows.reduce(function(s, b){ return s + b.total; }, 0);
    var approved = rows.reduce(function(s, b){ return s + b.approved; }, 0);
    var rejected = rows.reduce(function(s, b){ return s + b.rejected; }, 0);
    /* ponytail: sample value — approved rows × an average KHS line value. */
    var value = approved * 486000;
    document.getElementById('statGrid').innerHTML = [
      ['sBatch', rows.length.toLocaleString('id-ID'), ''],
      ['sTicket', tickets.toLocaleString('id-ID'), ''],
      ['sApproved', approved.toLocaleString('id-ID'), tickets ? Math.round(approved / tickets * 100) + '%' : '0%'],
      ['sRejected', rejected.toLocaleString('id-ID'), tickets ? Math.round(rejected / tickets * 100) + '%' : '0%'],
      ['sValue', rupiah(value), ''],
    ].map(function(s){
      return '<div class="stat"><div class="k">' + t(s[0]) + '</div><div class="v">' + s[1] + '</div>' +
        (s[2] ? '<div class="s">' + s[2] + '</div>' : '') + '</div>';
    }).join('');
  }

  function renderTable(){
    var rows = getFiltered();
    renderStats(rows);
    var per = parseInt(perPage.value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / per));
    if (currentPage > totalPages) { currentPage = totalPages; }
    var start = (currentPage - 1) * per;
    var page = rows.slice(start, start + per);

    document.getElementById('tbody').innerHTML = page.length ? page.map(function(b){
      return '<tr>' +
        '<td>' + b.regional + '</td><td>' + b.witel + '</td><td>' + b.tipe + '</td>' +
        '<td>' + MONTHS[b.month] + ' ' + b.year + '</td>' +
        '<td class="mono-cell">' + b.file + '</td><td>' + b.tglInput + '</td><td>' + b.by + '</td>' +
        '<td class="num">' + b.total + '</td>' +
        '<td class="num" style="color:var(--error-500);font-weight:600">' + b.rejected + '</td>' +
        '<td class="num" style="color:var(--success-600);font-weight:600">' + b.approved + '</td>' +
        '<td><span class="pill ' + STATUS_PILL[b.status] + '">' + t(STATUS_KEY[b.status]) + '</span></td>' +
        '<td><button class="mini-btn brand" data-detail="' + b.id + '">' + t('detail') + '</button></td>' +
        '</tr>';
    }).join('') : '<tr><td colspan="12" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    var from = rows.length ? start + 1 : 0, to = Math.min(start + per, rows.length);
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
  }
  [fType, fMonth, fWitel, perPage].forEach(function(el){ el.addEventListener('change', function(){ currentPage = 1; renderTable(); }); });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });

  /* ---------- KHS ---------- */
  function renderKhs(){
    document.getElementById('khsBody').innerHTML = KHS.map(function(k){
      return '<tr><td class="mono-cell">' + k.d + '</td><td>' + k.u + '</td><td>' + k.s + '</td>' +
        '<td class="num">' + rupiah(k.m) + '</td><td class="num">' + rupiah(k.j) + '</td>' +
        '<td class="num" style="font-weight:600">' + rupiah(k.m + k.j) + '</td></tr>';
    }).join('');
  }

  /* ---------- detail: rows are derived from the batch so they stay consistent ---------- */
  var activeBatch = null;
  function buildRows(b){
    var rows = [];
    for (var i = 0; i < Math.min(b.total, 40); i++) {
      var rejected = i < Math.min(b.rejected, 10);
      rows.push({
        ticket: 'INC' + (26090000 + b.id * 137 + i),
        sto: STOS[(b.id + i) % STOS.length],
        service: '1' + String(52000000 + b.id * 911 + i * 7),
        actsol: ACTSOL[(b.id + i) % ACTSOL.length],
        designator: KHS[(i * 3 + b.id) % KHS.length],
        volume: 1 + ((i * 5 + b.id) % 12),
        rejected: rejected,
        note: REJECT_NOTES[(b.id + i) % REJECT_NOTES.length],
      });
    }
    return rows;
  }

  function detailTableHtml(rows, withNote){
    var head = '<tr><th>' + t('cTicket') + '</th><th>STO</th><th>' + t('cService') + '</th><th>' + t('cActsol') + '</th>' +
      '<th>Designator</th><th class="num">' + t('cVolume') + '</th><th class="num">' + t('cNilai') + '</th>' +
      (withNote ? '<th>' + t('cNote') + '</th>' : '') + '</tr>';
    var body = rows.length ? rows.map(function(r){
      var nilai = (r.designator.m + r.designator.j) * r.volume;
      return '<tr><td class="mono-cell">' + r.ticket + '</td><td>' + r.sto + '</td>' +
        '<td class="mono-cell">' + r.service + '</td><td>' + r.actsol + '</td>' +
        '<td class="mono-cell">' + r.designator.d + '</td><td class="num">' + r.volume + '</td>' +
        '<td class="num">' + rupiah(nilai) + '</td>' +
        (withNote ? '<td style="color:var(--error-500)">' + t(r.note) + '</td>' : '') + '</tr>';
    }).join('') : '<tr><td colspan="8" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
    return [head, body];
  }

  function renderDetail(b){
    activeBatch = b;
    document.getElementById('detailPlaceholder').hidden = true;
    document.getElementById('detailCard').hidden = false;
    document.getElementById('detailTitle').textContent = t('detailTitle') + ' — ' + b.witel + ' · ' + b.tipe + ' · ' + MONTHS[b.month] + ' ' + b.year;

    var rows = buildRows(b);
    var appr = rows.filter(function(r){ return !r.rejected; });
    var rej = rows.filter(function(r){ return r.rejected; });

    var a = detailTableHtml(appr, false);
    document.getElementById('apprHead').innerHTML = a[0];
    document.getElementById('apprBody').innerHTML = a[1];
    var r = detailTableHtml(rej, true);
    document.getElementById('rejHead').innerHTML = r[0];
    document.getElementById('rejBody').innerHTML = r[1];

    /* Actual solution recap: tickets + volume per actual solution */
    var byActsol = {};
    appr.forEach(function(row){
      var k = row.actsol;
      byActsol[k] = byActsol[k] || { tickets: 0, volume: 0, nilai: 0 };
      byActsol[k].tickets++;
      byActsol[k].volume += row.volume;
      byActsol[k].nilai += (row.designator.m + row.designator.j) * row.volume;
    });
    document.getElementById('actHead').innerHTML = '<tr><th>' + t('cActsol') + '</th><th class="num">' + t('cTotalTicket') +
      '</th><th class="num">' + t('cVolume') + '</th><th class="num">' + t('cNilai') + '</th></tr>';
    document.getElementById('actBody').innerHTML = Object.keys(byActsol).sort().map(function(k){
      var v = byActsol[k];
      return '<tr><td>' + k + '</td><td class="num">' + v.tickets + '</td><td class="num">' + v.volume +
        '</td><td class="num">' + rupiah(v.nilai) + '</td></tr>';
    }).join('');

    /* Rekap KHS: designator × volume per STO, mirroring the pivot in the real app */
    var stos = appr.map(function(row){ return row.sto; }).filter(function(v, i, arr){ return arr.indexOf(v) === i; }).sort();
    document.getElementById('rekapHead').innerHTML =
      '<tr><th rowspan="2">Designator</th><th rowspan="2">' + t('cUraian') + '</th><th rowspan="2">' + t('cSatuan') + '</th>' +
      '<th colspan="2" style="text-align:center">' + t('hss') + '</th>' +
      '<th colspan="' + stos.length + '" style="text-align:center">' + t('volPerSto') + '</th>' +
      '<th rowspan="2" class="num">' + t('total') + '</th></tr>' +
      '<tr><th class="num">' + t('cHssMaterial') + '</th><th class="num">' + t('cHssJasa') + '</th>' +
      stos.map(function(s){ return '<th class="num">' + s + '</th>'; }).join('') + '</tr>';

    document.getElementById('rekapBody').innerHTML = KHS.map(function(k){
      var perSto = stos.map(function(s){
        return appr.filter(function(row){ return row.designator.d === k.d && row.sto === s; })
          .reduce(function(sum, row){ return sum + row.volume; }, 0);
      });
      var totalVol = perSto.reduce(function(a2, b2){ return a2 + b2; }, 0);
      if (!totalVol) { return ''; }
      return '<tr><td class="mono-cell">' + k.d + '</td><td>' + k.u + '</td><td>' + k.s + '</td>' +
        '<td class="num">' + rupiah(k.m) + '</td><td class="num">' + rupiah(k.j) + '</td>' +
        perSto.map(function(v){ return '<td class="num">' + (v || '-') + '</td>'; }).join('') +
        '<td class="num" style="font-weight:600">' + rupiah((k.m + k.j) * totalVol) + '</td></tr>';
    }).join('') || '<tr><td colspan="9" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
  }

  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-detail]');
    if (!b) { return; }
    renderDetail(BATCHES[parseInt(b.dataset.detail, 10)]);
    document.getElementById('detailCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
  });

  /* ---------- upload form ---------- */
  document.getElementById('boqFile').addEventListener('change', function(){
    document.getElementById('fileName').textContent = this.files[0] ? this.files[0].name : '';
  });
  document.getElementById('uploadBtn').addEventListener('click', function(){
    toast(document.getElementById('boqFile').files[0] ? t('uploadOk') : t('noFile'));
  });
  document.getElementById('resetUpload').addEventListener('click', function(){
    document.getElementById('boqFile').value = '';
    document.getElementById('fileName').textContent = '';
  });
  document.getElementById('tplBtn').addEventListener('click', function(){ toast(t('demoOnly')); });

  document.getElementById('detailCard').hidden = true;

  renderTable();
  renderKhs();
  applyLang();
</script>
</body>
</html>
