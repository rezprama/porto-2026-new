<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Approval GCU OLT — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .hero-banner{border-radius:14px;padding:24px;margin-bottom:20px;color:#fff;
    background:linear-gradient(90deg,#1e293b,#1e293b 40%,#075985)}
  .hero-banner h1{color:#fff;font-size:19px;margin-bottom:4px}
  .hero-banner p{color:rgba(255,255,255,.7);font-size:13px;margin-bottom:16px}
  .pill-tabs{display:inline-flex;gap:4px;background:rgba(255,255,255,.1);border-radius:10px;padding:4px}
  .pill-tabs button{padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;color:rgba(255,255,255,.7);border:none;background:none}
  .pill-tabs button.on{background:var(--brand-500);color:#fff}
  .rework-note{margin-top:6px;font-size:11.5px;color:var(--warn-500);background:color-mix(in srgb,var(--warn-500) 10%,transparent);
    border-radius:6px;padding:5px 8px}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'gcu-approval'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="hero-banner">
    <h1 data-i18n="heroTitle">Approval GCU OLT</h1>
    <p data-i18n="heroSubtitle">Tampilan approval dan update data</p>
    <div class="pill-tabs">
      <button class="on" data-tab="approval" data-i18n="tabApproval">Data Approval</button>
      <button data-tab="update" data-i18n="tabUpdate">Update Data</button>
    </div>
  </div>

  <!-- TAB A: DATA APPROVAL -->
  <div id="tabApproval" class="stack">
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field"><label>Area</label><select id="aArea"><option>PAMASUKA</option></select></div>
          <div class="field"><label>Regional</label><select id="aRegional"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option><option>KTI</option></select></div>
          <div class="field"><label>District</label><select id="aDistrict"><option value="">Semua</option><option>District Balikpapan</option><option>District Samarinda</option><option>District Makassar</option></select></div>
        </div>
        <div class="row3">
          <div class="field"><label data-i18n="fMonth">Bulan</label><select id="aMonth"><option value="" data-i18n="allMonth">Semua Bulan</option><option selected>September</option></select></div>
          <div class="field"><label data-i18n="fYear">Tahun</label><select id="aYear"><option>2026</option></select></div>
          <div class="field">
            <label data-i18n="fStatus">Status</label>
            <select id="aStatus">
              <option value="">ALL</option>
              <option value="KS" selected data-i18n="stKonfirm">Complete Teknisi</option>
              <option value="C" data-i18n="stComplete">Complete</option>
              <option value="P" data-i18n="stRework">Rework</option>
              <option value="EXPIRED" data-i18n="stExpired">Expired</option>
            </select>
          </div>
        </div>
        <div class="row3">
          <div class="field" style="grid-column:1/-1"><label data-i18n="fQuery">Cari Hostname</label><input type="text" id="aSearch" data-i18n-ph="searchPh" placeholder="Cari hostname..." /></div>
        </div>
        <button class="btn-primary" id="aFilterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th><span data-i18n="cDistrict">Distrik</span></th><th>Hostname</th><th data-i18n="cIpHostname">IP Hostname</th>
              <th data-i18n="cStatus">Status</th><th data-i18n="wodTglListing">Tanggal Listing</th>
              <th data-i18n="cTglProgress">Tanggal Progress</th><th data-i18n="wodTeknisiConfirm">Teknisi Confirm</th>
              <th data-i18n="cAction">Aksi</th>
            </tr>
          </thead>
          <tbody id="aBody"></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- TAB B: UPDATE DATA -->
  <div id="tabUpdate" class="stack" hidden>
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field"><label data-i18n="cRequest">Request</label><select id="uRequest"><option value="">ALL</option><option>GCU</option><option>PLN</option></select></div>
          <div class="field"><label data-i18n="fStatus">Status</label><select id="uStatus"><option value="">ALL</option><option value="pending" data-i18n="stPending2">Pending</option><option value="approved" data-i18n="stApproved">Approved</option><option value="rejected" data-i18n="stRejected">Rejected</option></select></div>
          <div class="field"><label>Area</label><select id="uArea"><option>PAMASUKA</option></select></div>
        </div>
        <div class="row3">
          <div class="field"><label data-i18n="cStartDate">Tanggal Mulai</label><input type="date" id="uStart" value="2026-09-01" /></div>
          <div class="field"><label data-i18n="cEndDate">Tanggal Akhir</label><input type="date" id="uEnd" value="2026-09-09" /></div>
          <div class="field"><label data-i18n="fQuery">Cari Hostname</label><input type="text" id="uSearch" data-i18n-ph="searchPh" placeholder="Cari hostname..." /></div>
        </div>
        <button class="btn-primary" id="uFilterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th data-i18n="cRequest">Request</th><th><span data-i18n="cDistrict">Distrik</span></th><th>Hostname</th>
              <th data-i18n="cStatus">Status</th><th data-i18n="cPlnId">ID PLN Pelanggan</th><th data-i18n="cRequested">Requested</th>
              <th data-i18n="cApproved">Approved</th><th data-i18n="cAction">Aksi</th>
            </tr>
          </thead>
          <tbody id="uBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- REWORK MODAL -->
<div class="modal-backdrop" id="reworkModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="reworkTitle">Rework data</h3><button class="modal-close" id="reworkX">✕</button></div>
    <div class="modal-body">
      <div class="field">
        <label data-i18n="reworkReason">Alasan</label>
        <textarea id="reworkNote" rows="3" data-i18n-ph="reworkPh" placeholder="Input alasan rework..."></textarea>
        <p class="hint" id="reworkErr" style="color:var(--error-500);display:none" data-i18n="reworkRequired">Alasan wajib diisi</p>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="reworkCancel" data-i18n="cancel">Batal</button>
      <button class="btn-danger" id="reworkOk" data-i18n="tabRework">Rework</button>
    </div>
  </div>
</div>

<!-- APPROVE CONFIRM -->
<div class="modal-backdrop" id="approveModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="approveTitle">Approve data?</h3><button class="modal-close" id="approveX">✕</button></div>
    <div class="modal-body"><p class="hint-muted" id="approveBody"></p></div>
    <div class="modal-foot">
      <button class="btn-outline" id="approveCancel" data-i18n="no2">Tidak</button>
      <button class="btn-success" id="approveOk" data-i18n="yes2">Ya</button>
    </div>
  </div>
</div>

<!-- UPDATE DATA DETAIL -->
<div class="modal-backdrop" id="udModal">
  <div class="modal-card modal-lg">
    <div class="modal-head">
      <div><h3 data-i18n="udTitle">Detail Update Data</h3><span class="pill pill-scope" id="udSource" style="margin-top:6px;display:inline-block"></span></div>
      <button class="modal-close" id="udClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="kv-grid" id="udSummary" style="margin-bottom:16px"></div>
      <div class="wod-cols">
        <div class="wod-section" style="flex:1">
          <b data-i18n="udBefore">Before</b>
          <div class="kv-grid kv-grid-1" id="udBefore"></div>
        </div>
        <div class="wod-section" style="flex:1">
          <b data-i18n="udAfter">After</b>
          <div class="kv-grid kv-grid-1" id="udAfter"></div>
        </div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="udDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

@include('project.tifreg.feature.partials.workorder-detail')
@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    id: {
      heroTitle: 'Approval GCU OLT', heroSubtitle: 'Tampilan approval dan update data',
      tabApproval: 'Data Approval', tabUpdate: 'Update Data', tabRework: 'Rework',
      fMonth: 'Bulan', allMonth: 'Semua Bulan', fYear: 'Tahun', fStatus: 'Status', filter: 'Filter',
      fQuery: 'Cari Hostname', searchPh: 'Cari hostname...',
      cDistrict: 'Distrik', cIpHostname: 'IP Hostname', cStatus: 'Status', cTglProgress: 'Tanggal Progress',
      cAction: 'Aksi', stKonfirm: 'Complete Teknisi', stComplete: 'Complete', stRework: 'Rework', stExpired: 'Expired',
      btnApprove: 'Approve', btnRework: 'Rework',
      reworkTitle: 'Rework data', reworkReason: 'Alasan', reworkPh: 'Input alasan rework...', reworkRequired: 'Alasan wajib diisi',
      approveTitle: 'Approve data?', approveBodyFor: 'Approve data untuk :h?', no2: 'Tidak', yes2: 'Ya',
      toastApprove: ' berhasil di-approve.', toastRework: ' berhasil di-rework.',
      cRequest: 'Request', stPending2: 'Pending', stApproved: 'Approved', stRejected: 'Rejected',
      cStartDate: 'Tanggal Mulai', cEndDate: 'Tanggal Akhir', cPlnId: 'ID PLN Pelanggan',
      cRequested: 'Requested', cApproved: 'Approved',
      udTitle: 'Detail Update Data', udBefore: 'Before', udAfter: 'After',
      toastPrepared: ' — action disiapkan (demo, tidak ada perubahan status sungguhan).',
      lblJenis: 'Jenis', lblLokasi: 'Lokasi', lblLong: 'Longitude', lblLat: 'Latitude',
      lblAlarm: 'Status Modul Alarm', lblRecti: 'Type Recti', lblNotes: 'Notes',
      lblPlnJenis: 'Jenis PLN', lblPlnStatus: 'Status PLN', lblPlnId: 'ID Pelanggan', lblMeteran: 'No. Meteran',
      lblKwh: 'KWH', lblTglInput: 'Tanggal Input',
    },
    en: {
      heroTitle: 'GCU OLT Approval', heroSubtitle: 'Approval and update data view',
      tabApproval: 'Data Approval', tabUpdate: 'Update Data', tabRework: 'Rework',
      fMonth: 'Month', allMonth: 'All Months', fYear: 'Year', fStatus: 'Status', filter: 'Filter',
      fQuery: 'Search Hostname', searchPh: 'Search hostname...',
      cDistrict: 'District', cIpHostname: 'IP Hostname', cStatus: 'Status', cTglProgress: 'Progress Date',
      cAction: 'Action', stKonfirm: 'Complete Technician', stComplete: 'Complete', stRework: 'Rework', stExpired: 'Expired',
      btnApprove: 'Approve', btnRework: 'Rework',
      reworkTitle: 'Rework data', reworkReason: 'Reason', reworkPh: 'Input rework reason...', reworkRequired: 'Reason is required',
      approveTitle: 'Approve data?', approveBodyFor: 'Approve data for :h?', no2: 'No', yes2: 'Yes',
      toastApprove: ' approved successfully.', toastRework: ' reworked successfully.',
      cRequest: 'Request', stPending2: 'Pending', stApproved: 'Approved', stRejected: 'Rejected',
      cStartDate: 'Start Date', cEndDate: 'End Date', cPlnId: 'PLN Customer ID',
      cRequested: 'Requested', cApproved: 'Approved',
      udTitle: 'Update Data Detail', udBefore: 'Before', udAfter: 'After',
      toastPrepared: ' action is prepared (demo, no real status change).',
      lblJenis: 'Type', lblLokasi: 'Location', lblLong: 'Longitude', lblLat: 'Latitude',
      lblAlarm: 'Alarm Module Status', lblRecti: 'Rectifier Type', lblNotes: 'Notes',
      lblPlnJenis: 'PLN Type', lblPlnStatus: 'PLN Status', lblPlnId: 'Customer ID', lblMeteran: 'Meter Number',
      lblKwh: 'KWH', lblTglInput: 'Input Date',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- Tab A: Data Approval ---------- */
  var APPROVALS = [
    { district: 'District Balikpapan', hostname: 'OLT-BPN-KJ-02', ip: '10.14.20.21', status: 'KS', tglListing: '2026-08-20', tglProgress: '2026-09-03', teknisiConfirm: 'Andi Saputra',
      ticket: 'WO-88027', tglComplete: '2026-09-03', tglApproval: '-', closing: '2026-09-18', sto: 'STO Karang Joang', teknisiApproval: '-',
      powerInput: '220V / OK', tempAc: '25°C', tempOlt: '40°C', tempRuangan: '28°C', batOutput: '52.9V', batBersih: '52.1V',
      grounding: 'OK (1.8Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Emerson R48', groundingUkur: '1.8Ω',
      lokasi: 'Jl. Soekarno-Hatta KM 8', notes: '-', koordinat: '-1.1200, 116.8360', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Prabayar', plnJenis: 'R1', plnId: '541200119911', plnMeteran: 'MTR-88422', kwhAwal: '800', kwhTerakhir: '910', kwhUpdate: '918', tglKwh: '2026-09-02' },
    { district: 'District Balikpapan', hostname: 'OLT-BPN-SPG-03', ip: '10.14.20.31', status: 'P', tglListing: '2026-08-11', tglProgress: '2026-08-19', teknisiConfirm: 'Putri Lestari',
      ticket: 'WO-88033', tglComplete: '2026-08-19', tglApproval: '-', closing: '2026-08-30', sto: 'STO Sepinggan', teknisiApproval: '-',
      powerInput: '220V / Drop', tempAc: '29°C', tempOlt: '46°C', tempRuangan: '33°C', batOutput: '49.1V', batBersih: '47.8V',
      grounding: 'NOK (6.4Ω)', bir: 'OK', powerSource: 'PLN', alarmModule: 'Alarm Aktif', typeRecti: 'Delta M2000', groundingUkur: '6.4Ω',
      lokasi: 'Jl. Marsma Iswahyudi', notes: 'Rework: grounding di atas ambang batas', koordinat: '-1.2620, 116.8850', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200145566', plnMeteran: 'MTR-88519', kwhAwal: '990', kwhTerakhir: '1055', kwhUpdate: '1060', tglKwh: '2026-08-29', rejectNote: 'Grounding di atas ambang batas, tolong ukur ulang.' },
    { district: 'District Balikpapan', hostname: 'OLT-BPN-KOTA-01', ip: '10.14.20.11', status: 'C', tglListing: '2026-08-02', tglProgress: '2026-08-04', teknisiConfirm: 'Bagus Wicaksono',
      ticket: 'WO-88001', tglComplete: '2026-08-04', tglApproval: '2026-08-05', closing: '2026-08-20', sto: 'STO Balikpapan Kota', teknisiApproval: 'Ulsyairil',
      powerInput: '220V / OK', tempAc: '24°C', tempOlt: '38°C', tempRuangan: '27°C', batOutput: '53.2V', batBersih: '52.8V',
      grounding: 'OK (2.1Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Emerson R48', groundingUkur: '2.1Ω',
      lokasi: 'Jl. Jendral Sudirman', notes: '-', koordinat: '-1.2670, 116.8310', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200112233', plnMeteran: 'MTR-88231', kwhAwal: '1200', kwhTerakhir: '1450', kwhUpdate: '1465', tglKwh: '2026-09-01' },
    { district: 'District Balikpapan', hostname: 'OLT-BPN-MGR-02', ip: '10.14.20.52', status: 'EXPIRED', tglListing: '2026-06-01', tglProgress: '-', teknisiConfirm: '-',
      ticket: 'WO-88060', tglComplete: '-', tglApproval: '-', closing: '2026-06-20', sto: 'STO Manggar', teknisiApproval: '-',
      powerInput: '-', tempAc: '-', tempOlt: '-', tempRuangan: '-', batOutput: '-', batBersih: '-', grounding: '-', bir: '-',
      powerSource: '-', alarmModule: '-', typeRecti: '-', groundingUkur: '-',
      lokasi: 'Jl. Mulawarman', notes: 'Melewati closing date tanpa progress', koordinat: '-1.2300, 116.8900', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: '-',
      plnStatus: '-', plnJenis: '-', plnId: '-', plnMeteran: '-', kwhAwal: '-', kwhTerakhir: '-', kwhUpdate: '-', tglKwh: '-' },
    { district: 'District Samarinda', hostname: 'OLT-SMD-KOTA-05', ip: '10.14.32.15', status: 'KS', tglListing: '2026-09-01', tglProgress: '2026-09-07', teknisiConfirm: 'Budi Santoso',
      ticket: 'WO-88071', tglComplete: '2026-09-07', tglApproval: '-', closing: '2026-09-22', sto: 'STO Samarinda Kota', teknisiApproval: '-',
      powerInput: '220V / OK', tempAc: '26°C', tempOlt: '41°C', tempRuangan: '29°C', batOutput: '52.4V', batBersih: '51.9V',
      grounding: 'OK (2.4Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'ZTE ZXDU68', groundingUkur: '2.4Ω',
      lokasi: 'Jl. Basuki Rahmat', notes: '-', koordinat: '-0.5020, 117.1470', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200178820', plnMeteran: 'MTR-89104', kwhAwal: '640', kwhTerakhir: '705', kwhUpdate: '712', tglKwh: '2026-09-06' },
    { district: 'District Samarinda', hostname: 'OLT-SMD-PLB-02', ip: '10.14.32.44', status: 'C', tglListing: '2026-08-14', tglProgress: '2026-08-17', teknisiConfirm: 'Rina Amelia',
      ticket: 'WO-88045', tglComplete: '2026-08-17', tglApproval: '2026-08-18', closing: '2026-09-02', sto: 'STO Palaran', teknisiApproval: 'Ulsyairil',
      powerInput: '220V / OK', tempAc: '27°C', tempOlt: '39°C', tempRuangan: '30°C', batOutput: '53.0V', batBersih: '52.5V',
      grounding: 'OK (1.5Ω)', bir: 'OK', powerSource: 'PLN', alarmModule: 'Normal', typeRecti: 'Emerson R48', groundingUkur: '1.5Ω',
      lokasi: 'Jl. Cipto Mangunkusumo', notes: '-', koordinat: '-0.5980, 117.1830', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Prabayar', plnJenis: 'R1', plnId: '541200182234', plnMeteran: 'MTR-89187', kwhAwal: '410', kwhTerakhir: '498', kwhUpdate: '505', tglKwh: '2026-08-16' },
    { district: 'District Makassar', hostname: 'OLT-MKS-PST-04', ip: '10.14.55.09', status: 'KS', tglListing: '2026-08-29', tglProgress: '2026-09-05', teknisiConfirm: 'Muh. Ilham',
      ticket: 'WO-88082', tglComplete: '2026-09-05', tglApproval: '-', closing: '2026-09-20', sto: 'STO Makassar Pusat', teknisiApproval: '-',
      powerInput: '220V / OK', tempAc: '28°C', tempOlt: '43°C', tempRuangan: '31°C', batOutput: '51.8V', batBersih: '51.0V',
      grounding: 'OK (2.9Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Delta M2000', groundingUkur: '2.9Ω',
      lokasi: 'Jl. Ahmad Yani', notes: '-', koordinat: '-5.1460, 119.4220', regional: 'SULAWESI', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200203391', plnMeteran: 'MTR-89340', kwhAwal: '980', kwhTerakhir: '1066', kwhUpdate: '1071', tglKwh: '2026-09-04' },
    { district: 'District Makassar', hostname: 'OLT-MKS-TLO-01', ip: '10.14.55.28', status: 'EXPIRED', tglListing: '2026-06-10', tglProgress: '-', teknisiConfirm: '-',
      ticket: 'WO-88090', tglComplete: '-', tglApproval: '-', closing: '2026-06-30', sto: 'STO Tello', teknisiApproval: '-',
      powerInput: '-', tempAc: '-', tempOlt: '-', tempRuangan: '-', batOutput: '-', batBersih: '-', grounding: '-', bir: '-',
      powerSource: '-', alarmModule: '-', typeRecti: '-', groundingUkur: '-',
      lokasi: 'Jl. Perintis Kemerdekaan', notes: 'Melewati closing date tanpa progress', koordinat: '-5.1210, 119.4890', regional: 'SULAWESI', area: 'PAMASUKA', batteryExist: '-',
      plnStatus: '-', plnJenis: '-', plnId: '-', plnMeteran: '-', kwhAwal: '-', kwhTerakhir: '-', kwhUpdate: '-', tglKwh: '-' },
  ];

  function approvalStatusBadge(a){
    var map = { KS: ['pill-teal', t('stKonfirm')], C: ['pill-green', t('stComplete')], P: ['pill-amber', t('stRework')], EXPIRED: ['pill-red', t('stExpired')] };
    var m = map[a.status] || ['pill-gray', a.status];
    return '<span class="pill pill-sq ' + m[0] + '">' + m[1] + '</span>' + (a.status === 'P' && a.rejectNote ? '<div class="rework-note">' + a.rejectNote + '</div>' : '');
  }

  function renderApproval(){
    var reg = document.getElementById('aRegional').value, d = document.getElementById('aDistrict').value, st = document.getElementById('aStatus').value;
    var q = document.getElementById('aSearch').value.trim().toLowerCase();
    var rows = APPROVALS.filter(function(a){
      return (!reg || a.regional === reg) && (!d || a.district === d) && (!st || a.status === st) &&
        (!q || a.hostname.toLowerCase().indexOf(q) !== -1);
    });
    document.getElementById('aBody').innerHTML = rows.length ? rows.map(function(a){
      var idx = APPROVALS.indexOf(a);
      var canAct = a.status === 'KS' || (a.status === 'EXPIRED' && a.tglProgress !== '-');
      return '<tr><td>' + a.district + '</td><td class="mono-cell">' + a.hostname + '</td><td class="mono-cell">' + a.ip + '</td>' +
        '<td>' + approvalStatusBadge(a) + '</td><td>' + a.tglListing + '</td><td>' + a.tglProgress + '</td><td>' + a.teknisiConfirm + '</td>' +
        '<td><div class="row-actions">' +
          '<button class="mini-btn brand" data-adetail="' + idx + '">' + t('detail') + '</button>' +
          (canAct ? '<button class="mini-btn teal" data-approve="' + idx + '">' + t('btnApprove') + '</button>' +
                    '<button class="mini-btn amber" data-rework="' + idx + '">' + t('btnRework') + '</button>' : '') +
        '</div></td></tr>';
    }).join('') : '<tr><td colspan="8" style="text-align:center;color:var(--muted)">-</td></tr>';
  }
  document.getElementById('aFilterBtn').addEventListener('click', renderApproval);
  document.getElementById('aRegional').addEventListener('change', renderApproval);
  document.getElementById('aDistrict').addEventListener('change', renderApproval);
  document.getElementById('aStatus').addEventListener('change', renderApproval);
  document.getElementById('aSearch').addEventListener('input', renderApproval);

  var approveModal = document.getElementById('approveModal'), approveOk = document.getElementById('approveOk');
  var reworkModal = document.getElementById('reworkModal');
  document.getElementById('aBody').addEventListener('click', function(e){
    var d = e.target.closest('[data-adetail]');
    if (d) { openWorkorderDetail(APPROVALS[parseInt(d.dataset.adetail, 10)]); return; }
    var ap = e.target.closest('[data-approve]');
    if (ap) {
      var row = APPROVALS[parseInt(ap.dataset.approve, 10)];
      document.getElementById('approveBody').textContent = t('approveBodyFor').replace(':h', row.hostname);
      approveModal.classList.add('show');
      approveOk.onclick = function(){
        approveModal.classList.remove('show');
        row.status = 'C'; row.tglApproval = new Date().toISOString().slice(0, 10);
        renderApproval();
        toast(row.hostname + t('toastApprove'));
      };
      return;
    }
    var rw = e.target.closest('[data-rework]');
    if (rw) {
      var rrow = APPROVALS[parseInt(rw.dataset.rework, 10)];
      document.getElementById('reworkNote').value = '';
      document.getElementById('reworkErr').style.display = 'none';
      reworkModal.classList.add('show');
      document.getElementById('reworkOk').onclick = function(){
        var note = document.getElementById('reworkNote').value.trim();
        if (!note) { document.getElementById('reworkErr').style.display = 'block'; return; }
        reworkModal.classList.remove('show');
        rrow.status = 'P'; rrow.rejectNote = note;
        renderApproval();
        toast(rrow.hostname + t('toastRework'));
      };
    }
  });
  document.getElementById('approveCancel').addEventListener('click', function(){ approveModal.classList.remove('show'); });
  document.getElementById('approveX').addEventListener('click', function(){ approveModal.classList.remove('show'); });
  document.getElementById('reworkCancel').addEventListener('click', function(){ reworkModal.classList.remove('show'); });
  document.getElementById('reworkX').addEventListener('click', function(){ reworkModal.classList.remove('show'); });

  /* ---------- Tab B: Update Data ---------- */
  var UPDATES = [
    { request: 'GCU', district: 'District Balikpapan', hostname: 'OLT-BPN-GS-04', status: 'pending', plnId: '-', requestedBy: 'Andi Saputra', approvedBy: '-',
      before: { lblJenis: 'INDOOR', lblLokasi: 'Jl. Gunung Sari Ulu', lblLong: '116.8210', lblLat: '-1.2480', lblAlarm: 'Normal', lblRecti: 'Emerson R48', lblNotes: '-' },
      after: { lblJenis: 'OUTDOOR', lblLokasi: 'Jl. Gunung Sari Ulu (relokasi kabinet)', lblLong: '116.8215', lblLat: '-1.2483', lblAlarm: 'Normal', lblRecti: 'Emerson R48', lblNotes: 'Relokasi kabinet 5m ke utara' } },
    { request: 'PLN', district: 'District Samarinda', hostname: 'OLT-SMD-KOTA-01', status: 'approved', plnId: '541200167712', requestedBy: 'Reza Pratama', approvedBy: 'Ulsyairil',
      before: { lblPlnJenis: 'R1', lblPlnStatus: 'Prabayar', lblPlnId: '541200167712', lblMeteran: 'MTR-89011', lblKwh: '1100', lblTglInput: '2026-07-30' },
      after: { lblPlnJenis: 'R2', lblPlnStatus: 'Pascabayar', lblPlnId: '541200167712', lblMeteran: 'MTR-89011', lblKwh: '1230', lblTglInput: '2026-08-30' } },
    { request: 'GCU', district: 'District Makassar', hostname: 'OLT-MKS-PST-01', status: 'rejected', plnId: '-', requestedBy: 'Reza Pratama', approvedBy: 'Ulsyairil',
      before: { lblJenis: 'INDOOR', lblLokasi: 'Jl. Ahmad Yani', lblLong: '119.4220', lblLat: '-5.1460', lblAlarm: 'Normal', lblRecti: 'Delta M2000', lblNotes: '-' },
      after: { lblJenis: 'INDOOR', lblLokasi: 'Jl. Ahmad Yani No. 12', lblLong: '119.4222', lblLat: '-5.1462', lblAlarm: 'Normal', lblRecti: 'Delta M2000', lblNotes: 'Update alamat lengkap' } },
  ];

  function updateStatusBadge(u){
    var map = { pending: ['pill-amber', t('stPending2')], approved: ['pill-green', t('stApproved')], rejected: ['pill-red', t('stRejected')] };
    var m = map[u.status] || ['pill-gray', u.status];
    return '<span class="pill pill-sq ' + m[0] + '">' + m[1] + '</span>';
  }

  function renderUpdates(){
    var req = document.getElementById('uRequest').value, st = document.getElementById('uStatus').value;
    var q = document.getElementById('uSearch').value.trim().toLowerCase();
    var rows = UPDATES.filter(function(u){
      return (!req || u.request === req) && (!st || u.status === st) && (!q || u.hostname.toLowerCase().indexOf(q) !== -1);
    });
    document.getElementById('uBody').innerHTML = rows.length ? rows.map(function(u){
      var idx = UPDATES.indexOf(u);
      return '<tr><td>' + u.request + '</td><td>' + u.district + '</td><td class="mono-cell">' + u.hostname + '</td>' +
        '<td>' + updateStatusBadge(u) + '</td><td class="mono-cell">' + u.plnId + '</td><td>' + u.requestedBy + '</td><td>' + u.approvedBy + '</td>' +
        '<td><div class="row-actions">' +
          '<button class="mini-btn brand" data-udetail="' + idx + '">' + t('detail') + '</button>' +
          (u.status === 'pending' ? '<button class="mini-btn teal" data-uapprove="' + idx + '">' + t('btnApprove') + '</button>' +
                                     '<button class="mini-btn red" data-ureject="' + idx + '">Reject</button>' : '') +
        '</div></td></tr>';
    }).join('') : '<tr><td colspan="8" style="text-align:center;color:var(--muted)">-</td></tr>';
  }
  document.getElementById('uFilterBtn').addEventListener('click', renderUpdates);
  document.getElementById('uRequest').addEventListener('change', renderUpdates);
  document.getElementById('uStatus').addEventListener('change', renderUpdates);
  document.getElementById('uSearch').addEventListener('input', renderUpdates);

  var udModal = document.getElementById('udModal');
  function kvFromObj(obj){ return kvHtml(Object.keys(obj).map(function(k){ return [t(k), obj[k]]; })); }
  document.getElementById('uBody').addEventListener('click', function(e){
    var d = e.target.closest('[data-udetail]');
    if (d) {
      var u = UPDATES[parseInt(d.dataset.udetail, 10)];
      document.getElementById('udSource').textContent = 'Request Source: ' + u.request;
      document.getElementById('udSummary').innerHTML = kvHtml([
        ['Hostname', u.hostname], [t('cIpHostname'), '-'], ['STO', '-'], [t('cDistrict'), u.district], ['Regional', '-'], ['Area', 'PAMASUKA'],
      ]);
      document.getElementById('udBefore').innerHTML = kvFromObj(u.before);
      document.getElementById('udAfter').innerHTML = kvFromObj(u.after);
      udModal.classList.add('show');
      return;
    }
    var a = e.target.closest('[data-uapprove]'), r = e.target.closest('[data-ureject]');
    if (a) { toast(UPDATES[parseInt(a.dataset.uapprove, 10)].hostname + t('toastPrepared')); }
    if (r) { toast(UPDATES[parseInt(r.dataset.ureject, 10)].hostname + t('toastPrepared')); }
  });
  document.getElementById('udClose').addEventListener('click', function(){ udModal.classList.remove('show'); });
  document.getElementById('udDone').addEventListener('click', function(){ udModal.classList.remove('show'); });

  /* ---------- tab switch ---------- */
  document.querySelectorAll('.pill-tabs [data-tab]').forEach(function(btn){
    btn.addEventListener('click', function(){
      document.querySelectorAll('.pill-tabs [data-tab]').forEach(function(b){ b.classList.remove('on'); });
      btn.classList.add('on');
      document.getElementById('tabApproval').hidden = btn.dataset.tab !== 'approval';
      document.getElementById('tabUpdate').hidden = btn.dataset.tab !== 'update';
    });
  });

  function onLangChange(){ renderApproval(); renderUpdates(); }
  renderApproval();
  renderUpdates();
  applyLang();
</script>
</body>
</html>
