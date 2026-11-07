<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>GCU OLT Monitoring — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .matrix-scroll{overflow-x:auto}
  table.matrix{white-space:nowrap}
  table.matrix th, table.matrix td{text-align:center}
  table.matrix th:nth-child(1), table.matrix td:nth-child(1){text-align:left}
  table.matrix .grp-cond{background:color-mix(in srgb,var(--brand-500) 6%,var(--gray-50))}
  [data-theme="dark"] table.matrix .grp-cond{background:color-mix(in srgb,var(--brand-500) 10%,transparent)}
  .cell-num{background:none;border:none;font:inherit;color:var(--brand-600);font-weight:700;cursor:pointer;padding:0}
  .cell-num:hover{text-decoration:underline}
  .cell-num.zero{color:var(--muted);font-weight:400;cursor:default;text-decoration:none}
  .cond-c1{background:#fee4e2} .cond-c2{background:#fef0c7} .cond-c3{background:#fef9c3}
  .cond-c4{background:#d1fadf} .cond-c5{background:#ccfbf1} .cond-c6{background:#d1e9ff} .cond-c7{background:#e0e7ff}
  [data-theme="dark"] .cond-c1{background:color-mix(in srgb,#f04438 22%,transparent)}
  [data-theme="dark"] .cond-c2{background:color-mix(in srgb,#f79009 22%,transparent)}
  [data-theme="dark"] .cond-c3{background:color-mix(in srgb,#eab308 22%,transparent)}
  [data-theme="dark"] .cond-c4{background:color-mix(in srgb,#12b76a 22%,transparent)}
  [data-theme="dark"] .cond-c5{background:color-mix(in srgb,#0d9488 22%,transparent)}
  [data-theme="dark"] .cond-c6{background:color-mix(in srgb,#1570ef 22%,transparent)}
  [data-theme="dark"] .cond-c7{background:color-mix(in srgb,#6366f1 22%,transparent)}
  tr.totals-row td{font-weight:700;border-top:2px solid var(--border);background:var(--gray-50)}
  [data-theme="dark"] tr.totals-row td{background:color-mix(in srgb,var(--gray-900) 60%,var(--panel-bg))}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'gcu-monitoring'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">NE / GCU OLT</div>
    <h1 data-i18n="pageTitle">Monitoring</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field"><label>Area</label><select id="fArea"><option>PAMASUKA</option></select></div>
          <div class="field"><label>Regional</label><select id="fRegional"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option><option>KTI</option></select></div>
          <div class="field"><label>District</label><select id="fDistrict"><option value="">Semua</option><option>District Balikpapan</option><option>District Samarinda</option><option>District Makassar</option></select></div>
        </div>
        <div class="row3">
          <div class="field">
            <label data-i18n="fType">Type</label>
            <select id="fType"><option value="">ALL</option><option>INDOOR</option><option>OUTDOOR</option></select>
          </div>
          <div class="field">
            <label data-i18n="fPeriod">Period</label>
            <select id="fPeriod"><option value="bulan" data-i18n="pBulan">BULAN</option><option value="semester" data-i18n="pSemester">SEMESTER</option><option value="tahun" data-i18n="pTahun">TAHUN</option></select>
          </div>
          <div class="field">
            <label data-i18n="fYear">Tahun</label>
            <select id="fYear"><option>2026</option><option>2025</option><option>2024</option></select>
          </div>
        </div>
        <div class="row3">
          <div class="field" id="fMonthWrap">
            <label data-i18n="fMonth">Bulan</label>
            <select id="fMonth"><option>Januari</option><option>Februari</option><option>Maret</option><option selected>September</option><option>Desember</option></select>
          </div>
          <div class="field" id="fSemesterWrap" style="display:none">
            <label data-i18n="fSemester">Semester</label>
            <select id="fSemester"><option value="1">Semester 1</option><option value="2">Semester 2</option></select>
          </div>
          <div class="field">
            <label data-i18n="fCondition">Kondisi</label>
            <select id="fCondition"><option value="">ALL</option><option value="NOK">NOK</option><option value="OK">OK</option></select>
          </div>
          <div class="field"><label data-i18n="fQuery">Cari STO / Hostname</label><input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari STO / hostname..." /></div>
          <div class="field" style="align-self:end">
            <button class="btn-primary" id="searchBtn" style="width:100%" data-i18n="search">Cari</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3 data-i18n="matrixTitle">Achievement Matrix</h3></div>
      <div class="matrix-scroll">
        <table class="matrix">
          <thead>
            <tr>
              <th rowspan="2" data-i18n="cSto">STO</th>
              <th rowspan="2" data-i18n="cTotalOlt">Total OLT</th>
              <th rowspan="2" data-i18n="cTarget">Target</th>
              <th rowspan="2" data-i18n="cNotYet">Not Yet GCU</th>
              <th rowspan="2" data-i18n="stWaiting">Waiting</th>
              <th rowspan="2" data-i18n="stPending">Pending</th>
              <th rowspan="2" data-i18n="stRework">Rework</th>
              <th rowspan="2" data-i18n="stKonfirm">Complete Teknisi</th>
              <th rowspan="2" data-i18n="cCompleteApproval">Complete Approval</th>
              <th rowspan="2" data-i18n="stExpired">Expired</th>
              <th rowspan="2" data-i18n="cAchievement">Achievement (%)</th>
              <th colspan="7" class="grp-cond" data-i18n="cAllCondition">Semua Kondisi</th>
            </tr>
            <tr>
              <th class="grp-cond">Power OLT</th>
              <th class="grp-cond">AC</th>
              <th class="grp-cond" data-i18n="cTemperature">Temperatur</th>
              <th class="grp-cond" data-i18n="cBattery">Baterai</th>
              <th class="grp-cond">Grounding</th>
              <th class="grp-cond">BIR</th>
              <th class="grp-cond" data-i18n="cBatteryMeasure">Baterai Ukur</th>
            </tr>
          </thead>
          <tbody id="matrixBody"></tbody>
          <tfoot><tr class="totals-row" id="matrixTotals"></tr></tfoot>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- WORKORDER LIST DIALOG (generic drill-down for the matrix) -->
<div class="modal-backdrop" id="listDialog">
  <div class="modal-card modal-lg">
    <div class="modal-head"><h3 id="listDialogTitle">-</h3><button class="modal-close" id="listDialogClose">✕</button></div>
    <div class="modal-body">
      <div class="kv-grid kv-grid-1" id="listDialogSummary" style="margin-bottom:14px"></div>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th data-i18n="cDistrict">District</th><th>STO</th><th>Hostname</th><th data-i18n="cIpHostname">IP Hostname</th>
              <th data-i18n="cStatus">Status</th><th data-i18n="wodTglListing">Tanggal Listing</th><th data-i18n="cAction">Aksi</th>
            </tr>
          </thead>
          <tbody id="listDialogBody"></tbody>
        </table>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="listDialogDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

@include('project.tifreg.feature.partials.workorder-detail')
@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Monitoring', matrixTitle: 'Achievement Matrix',
      fType: 'Type', fPeriod: 'Periode', pBulan: 'BULAN', pSemester: 'SEMESTER', pTahun: 'TAHUN',
      fYear: 'Tahun', fMonth: 'Bulan', fSemester: 'Semester', fCondition: 'Kondisi', fQuery: 'Cari STO / Hostname', searchPh: 'Cari STO / hostname...',
      cSto: 'STO', cTotalOlt: 'Total OLT', cTarget: 'Target', cNotYet: 'Belum GCU',
      cCompleteApproval: 'Complete Approval', cAchievement: 'Achievement (%)', cAllCondition: 'Semua Kondisi',
      cTemperature: 'Temperatur', cBattery: 'Baterai', cBatteryMeasure: 'Baterai Ukur',
      cDistrict: 'Distrik', cIpHostname: 'IP Hostname', cStatus: 'Status', cAction: 'Aksi',
      listTitleFor: 'Daftar Workorder', noWorkorder: 'Tidak ada workorder untuk kondisi ini.',
    },
    en: {
      pageTitle: 'Monitoring', matrixTitle: 'Achievement Matrix',
      fType: 'Type', fPeriod: 'Period', pBulan: 'MONTH', pSemester: 'SEMESTER', pTahun: 'YEAR',
      fYear: 'Year', fMonth: 'Month', fSemester: 'Semester', fCondition: 'Condition', fQuery: 'Search STO / Hostname', searchPh: 'Search STO / hostname...',
      cSto: 'STO', cTotalOlt: 'Total OLT', cTarget: 'Target', cNotYet: 'Not Yet GCU',
      cCompleteApproval: 'Complete Approval', cAchievement: 'Achievement (%)', cAllCondition: 'All Conditions',
      cTemperature: 'Temperature', cBattery: 'Battery', cBatteryMeasure: 'Battery Measurement',
      cDistrict: 'District', cIpHostname: 'IP Hostname', cStatus: 'Status', cAction: 'Action',
      listTitleFor: 'Workorder List', noWorkorder: 'No workorders for this condition.',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy dataset ---------- */
  var WORKORDERS = [
    { sto: 'STO Balikpapan Kota', district: 'District Balikpapan', hostname: 'OLT-BPN-KOTA-01', ip: '10.14.20.11', status: 'C',
      ticket: 'WO-88001', tglListing: '2026-08-02', tglComplete: '2026-08-04', tglApproval: '2026-08-05', closing: '2026-08-20',
      teknisiConfirm: 'Bagus Wicaksono', teknisiApproval: 'Ulsyairil',
      powerInput: '220V / OK', tempAc: '24°C', tempOlt: '38°C', tempRuangan: '27°C', batOutput: '53.2V', batBersih: '52.8V',
      grounding: 'OK (2.1Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Emerson R48', groundingUkur: '2.1Ω',
      lokasi: 'Jl. Jendral Sudirman', notes: '-', koordinat: '-1.2670, 116.8310', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200112233', plnMeteran: 'MTR-88231', kwhAwal: '1200', kwhTerakhir: '1450', kwhUpdate: '1465', tglKwh: '2026-09-01' },
    { sto: 'STO Balikpapan Kota', district: 'District Balikpapan', hostname: 'OLT-BPN-KOTA-02', ip: '10.14.20.12', status: 'N',
      ticket: 'WO-88014', tglListing: '2026-09-01', tglComplete: '-', tglApproval: '-', closing: '2026-09-15',
      teknisiConfirm: '-', teknisiApproval: '-',
      powerInput: '-', tempAc: '-', tempOlt: '-', tempRuangan: '-', batOutput: '-', batBersih: '-',
      grounding: '-', bir: '-', powerSource: '-', alarmModule: '-', typeRecti: '-', groundingUkur: '-',
      lokasi: 'Jl. Jendral Sudirman', notes: 'Menunggu jadwal teknisi', koordinat: '-1.2670, 116.8310', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: '-',
      plnStatus: '-', plnJenis: '-', plnId: '-', plnMeteran: '-', kwhAwal: '-', kwhTerakhir: '-', kwhUpdate: '-', tglKwh: '-' },
    { sto: 'STO Karang Joang', district: 'District Balikpapan', hostname: 'OLT-BPN-KJ-02', ip: '10.14.20.21', status: 'KS',
      ticket: 'WO-88027', tglListing: '2026-08-20', tglComplete: '2026-09-03', tglApproval: '-', closing: '2026-09-18',
      teknisiConfirm: 'Andi Saputra', teknisiApproval: '-',
      powerInput: '220V / OK', tempAc: '25°C', tempOlt: '40°C', tempRuangan: '28°C', batOutput: '52.9V', batBersih: '52.1V',
      grounding: 'OK (1.8Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Emerson R48', groundingUkur: '1.8Ω',
      lokasi: 'Jl. Soekarno-Hatta KM 8', notes: 'Menunggu approval', koordinat: '-1.1200, 116.8360', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Prabayar', plnJenis: 'R1', plnId: '541200119911', plnMeteran: 'MTR-88422', kwhAwal: '800', kwhTerakhir: '910', kwhUpdate: '918', tglKwh: '2026-09-02' },
    { sto: 'STO Sepinggan', district: 'District Balikpapan', hostname: 'OLT-BPN-SPG-03', ip: '10.14.20.31', status: 'P',
      ticket: 'WO-88033', tglListing: '2026-08-11', tglComplete: '2026-08-19', tglApproval: '-', closing: '2026-08-30',
      teknisiConfirm: 'Putri Lestari', teknisiApproval: '-',
      powerInput: '220V / Drop', tempAc: '29°C', tempOlt: '46°C', tempRuangan: '33°C', batOutput: '49.1V', batBersih: '47.8V',
      grounding: 'NOK (6.4Ω)', bir: 'OK', powerSource: 'PLN', alarmModule: 'Alarm Aktif', typeRecti: 'Delta M2000', groundingUkur: '6.4Ω',
      lokasi: 'Jl. Marsma Iswahyudi', notes: 'Rework: grounding di atas ambang batas', koordinat: '-1.2620, 116.8850', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200145566', plnMeteran: 'MTR-88519', kwhAwal: '990', kwhTerakhir: '1055', kwhUpdate: '1060', tglKwh: '2026-08-29' },
    { sto: 'STO Batakan', district: 'District Balikpapan', hostname: 'OLT-BPN-BTK-01', ip: '10.14.20.41', status: 'PTK',
      ticket: 'WO-88045', tglListing: '2026-09-04', tglComplete: '-', tglApproval: '-', closing: '2026-09-19',
      teknisiConfirm: '-', teknisiApproval: '-',
      powerInput: '-', tempAc: '-', tempOlt: '-', tempRuangan: '-', batOutput: '-', batBersih: '-',
      grounding: '-', bir: '-', powerSource: '-', alarmModule: '-', typeRecti: '-', groundingUkur: '-',
      lokasi: 'Jl. Gunung Sari Ulu', notes: 'Pending — menunggu material', koordinat: '-1.2480, 116.8210', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: '-',
      plnStatus: '-', plnJenis: '-', plnId: '-', plnMeteran: '-', kwhAwal: '-', kwhTerakhir: '-', kwhUpdate: '-', tglKwh: '-' },
    { sto: 'STO Manggar', district: 'District Balikpapan', hostname: 'OLT-BPN-MGR-01', ip: '10.14.20.51', status: 'C',
      ticket: 'WO-88052', tglListing: '2026-07-15', tglComplete: '2026-07-20', tglApproval: '2026-07-22', closing: '2026-08-05',
      teknisiConfirm: 'Dewi Anggraini', teknisiApproval: 'Ulsyairil',
      powerInput: '220V / OK', tempAc: '23°C', tempOlt: '36°C', tempRuangan: '26°C', batOutput: '53.5V', batBersih: '53.0V',
      grounding: 'OK (1.5Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Emerson R48', groundingUkur: '1.5Ω',
      lokasi: 'Jl. Mulawarman', notes: '-', koordinat: '-1.2300, 116.8900', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200177788', plnMeteran: 'MTR-88601', kwhAwal: '700', kwhTerakhir: '820', kwhUpdate: '825', tglKwh: '2026-08-01' },
    { sto: 'STO Manggar', district: 'District Balikpapan', hostname: 'OLT-BPN-MGR-02', ip: '10.14.20.52', status: 'EXPIRED',
      ticket: 'WO-88060', tglListing: '2026-06-01', tglComplete: '-', tglApproval: '-', closing: '2026-06-20',
      teknisiConfirm: '-', teknisiApproval: '-',
      powerInput: '-', tempAc: '-', tempOlt: '-', tempRuangan: '-', batOutput: '-', batBersih: '-',
      grounding: '-', bir: '-', powerSource: '-', alarmModule: '-', typeRecti: '-', groundingUkur: '-',
      lokasi: 'Jl. Mulawarman', notes: 'Melewati closing date tanpa progress', koordinat: '-1.2300, 116.8900', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: '-',
      plnStatus: '-', plnJenis: '-', plnId: '-', plnMeteran: '-', kwhAwal: '-', kwhTerakhir: '-', kwhUpdate: '-', tglKwh: '-' },
    { sto: 'STO Samarinda Kota', district: 'District Samarinda', hostname: 'OLT-SMD-KOTA-01', ip: '10.14.30.11', status: 'C',
      ticket: 'WO-88070', tglListing: '2026-08-25', tglComplete: '2026-08-30', tglApproval: '2026-08-30', closing: '2026-09-14',
      teknisiConfirm: 'Budi Santoso', teknisiApproval: 'Ulsyairil',
      powerInput: '220V / OK', tempAc: '26°C', tempOlt: '39°C', tempRuangan: '29°C', batOutput: '52.6V', batBersih: '52.0V',
      grounding: 'OK (2.0Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'ZTE ZXDU68', groundingUkur: '2.0Ω',
      lokasi: 'Jl. Basuki Rahmat', notes: '-', koordinat: '-0.5040, 117.1450', regional: 'KALIMANTAN', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200167712', plnMeteran: 'MTR-89011', kwhAwal: '1100', kwhTerakhir: '1230', kwhUpdate: '1235', tglKwh: '2026-08-30' },
    { sto: 'STO Makassar Pusat', district: 'District Makassar', hostname: 'OLT-MKS-PST-01', ip: '10.14.40.11', status: 'KS',
      ticket: 'WO-88081', tglListing: '2026-08-28', tglComplete: '2026-09-04', tglApproval: '-', closing: '2026-09-19',
      teknisiConfirm: 'Muh. Ilham', teknisiApproval: '-',
      powerInput: '220V / OK', tempAc: '28°C', tempOlt: '42°C', tempRuangan: '31°C', batOutput: '51.9V', batBersih: '51.2V',
      grounding: 'OK (2.7Ω)', bir: 'OK', powerSource: 'PLN + Baterai', alarmModule: 'Normal', typeRecti: 'Delta M2000', groundingUkur: '2.7Ω',
      lokasi: 'Jl. Ahmad Yani', notes: 'Menunggu approval', koordinat: '-5.1460, 119.4220', regional: 'SULAWESI', area: 'PAMASUKA', batteryExist: 'Ya',
      plnStatus: 'Pascabayar', plnJenis: 'R2', plnId: '541200178823', plnMeteran: 'MTR-89250', kwhAwal: '1400', kwhTerakhir: '1580', kwhUpdate: '1590', tglKwh: '2026-08-31' },
  ];

  var STOS = [
    { name: 'STO Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN', totalOlt: 18, target: 18, cond: { power: 1, ac: 0, temp: 2, bat: 0, ground: 0, bir: 0, batUkur: 1 } },
    { name: 'STO Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN', totalOlt: 10, target: 10, cond: { power: 0, ac: 0, temp: 1, bat: 1, ground: 0, bir: 0, batUkur: 0 } },
    { name: 'STO Sepinggan', district: 'District Balikpapan', regional: 'KALIMANTAN', totalOlt: 8, target: 8, cond: { power: 1, ac: 1, temp: 1, bat: 1, ground: 1, bir: 0, batUkur: 0 } },
    { name: 'STO Batakan', district: 'District Balikpapan', regional: 'KALIMANTAN', totalOlt: 6, target: 6, cond: { power: 0, ac: 0, temp: 0, bat: 0, ground: 0, bir: 0, batUkur: 0 } },
    { name: 'STO Manggar', district: 'District Balikpapan', regional: 'KALIMANTAN', totalOlt: 9, target: 9, cond: { power: 0, ac: 0, temp: 0, bat: 0, ground: 0, bir: 1, batUkur: 1 } },
    { name: 'STO Samarinda Kota', district: 'District Samarinda', regional: 'KALIMANTAN', totalOlt: 7, target: 7, cond: { power: 0, ac: 0, temp: 0, bat: 0, ground: 0, bir: 0, batUkur: 0 } },
    { name: 'STO Makassar Pusat', district: 'District Makassar', regional: 'SULAWESI', totalOlt: 11, target: 11, cond: { power: 0, ac: 1, temp: 1, bat: 0, ground: 0, bir: 0, batUkur: 0 } },
  ];

  function countStatus(sto, status){ return WORKORDERS.filter(function(w){ return w.sto === sto && w.status === status; }).length; }
  function computeRow(s){
    var used = WORKORDERS.filter(function(w){ return w.sto === s.name; }).length;
    var waiting = countStatus(s.name, 'N'), pending = countStatus(s.name, 'PTK'), rework = countStatus(s.name, 'P');
    var konfirm = countStatus(s.name, 'KS'), complete = countStatus(s.name, 'C'), expired = countStatus(s.name, 'EXPIRED');
    var notYet = Math.max(0, s.totalOlt - used);
    var achievement = s.target ? Math.round((complete / s.target) * 100) : 0;
    return { sto: s.name, totalOlt: s.totalOlt, target: s.target, notYet: notYet, waiting: waiting, pending: pending,
      rework: rework, konfirm: konfirm, complete: complete, expired: expired, achievement: achievement, cond: s.cond };
  }

  function numCell(val, sto, status){
    if (!val) { return '<span class="cell-num zero">0</span>'; }
    return '<button type="button" class="cell-num" data-sto="' + sto + '" data-status="' + status + '">' + val + '</button>';
  }

  function renderMatrix(){
    var regionalFilter = document.getElementById('fRegional').value;
    var districtFilter = document.getElementById('fDistrict').value;
    var condFilter = document.getElementById('fCondition').value;
    var q = document.getElementById('searchInput').value.trim().toLowerCase();
    var rows = STOS.filter(function(s){
      return (!regionalFilter || s.regional === regionalFilter) &&
        (!districtFilter || s.district === districtFilter) &&
        (!q || s.name.toLowerCase().indexOf(q) !== -1);
    }).map(computeRow);
    if (condFilter) {
      rows = rows.filter(function(r){
        var sum = Object.keys(r.cond).reduce(function(acc, k){ return acc + r.cond[k]; }, 0);
        return condFilter === 'NOK' ? sum > 0 : sum === 0;
      });
    }

    document.getElementById('matrixBody').innerHTML = rows.length ? rows.map(function(r){
      return '<tr><td>' + r.sto + '</td><td>' + r.totalOlt + '</td><td>' + r.target + '</td><td>' + r.notYet + '</td>' +
        '<td>' + numCell(r.waiting, r.sto, 'N') + '</td><td>' + numCell(r.pending, r.sto, 'PTK') + '</td>' +
        '<td>' + numCell(r.rework, r.sto, 'P') + '</td><td>' + numCell(r.konfirm, r.sto, 'KS') + '</td>' +
        '<td>' + numCell(r.complete, r.sto, 'C') + '</td><td>' + numCell(r.expired, r.sto, 'EXPIRED') + '</td>' +
        '<td><b>' + r.achievement + '%</b></td>' +
        '<td class="cond-c1">' + r.cond.power + '</td><td class="cond-c2">' + r.cond.ac + '</td><td class="cond-c3">' + r.cond.temp + '</td>' +
        '<td class="cond-c4">' + r.cond.bat + '</td><td class="cond-c5">' + r.cond.ground + '</td><td class="cond-c6">' + r.cond.bir + '</td>' +
        '<td class="cond-c7">' + r.cond.batUkur + '</td></tr>';
    }).join('') : '<tr><td colspan="18" style="text-align:center;color:var(--muted)">-</td></tr>';

    var t0 = { totalOlt: 0, target: 0, notYet: 0, waiting: 0, pending: 0, rework: 0, konfirm: 0, complete: 0, expired: 0,
      cond: { power: 0, ac: 0, temp: 0, bat: 0, ground: 0, bir: 0, batUkur: 0 } };
    rows.forEach(function(r){
      ['totalOlt', 'target', 'notYet', 'waiting', 'pending', 'rework', 'konfirm', 'complete', 'expired'].forEach(function(k){ t0[k] += r[k]; });
      Object.keys(t0.cond).forEach(function(k){ t0.cond[k] += r.cond[k]; });
    });
    var achv = t0.target ? Math.round((t0.complete / t0.target) * 100) : 0;
    document.getElementById('matrixTotals').innerHTML =
      '<td data-i18n="total">Total</td><td>' + t0.totalOlt + '</td><td>' + t0.target + '</td><td>' + t0.notYet + '</td>' +
      '<td>' + t0.waiting + '</td><td>' + t0.pending + '</td><td>' + t0.rework + '</td><td>' + t0.konfirm + '</td>' +
      '<td>' + t0.complete + '</td><td>' + t0.expired + '</td><td>' + achv + '%</td>' +
      '<td class="cond-c1">' + t0.cond.power + '</td><td class="cond-c2">' + t0.cond.ac + '</td><td class="cond-c3">' + t0.cond.temp + '</td>' +
      '<td class="cond-c4">' + t0.cond.bat + '</td><td class="cond-c5">' + t0.cond.ground + '</td><td class="cond-c6">' + t0.cond.bir + '</td>' +
      '<td class="cond-c7">' + t0.cond.batUkur + '</td>';
  }

  /* ---------- filter conditional fields ---------- */
  document.getElementById('fPeriod').addEventListener('change', function(){
    var v = this.value;
    document.getElementById('fMonthWrap').style.display = v === 'bulan' ? '' : 'none';
    document.getElementById('fSemesterWrap').style.display = v === 'semester' ? '' : 'none';
  });
  document.getElementById('searchBtn').addEventListener('click', renderMatrix);
  document.getElementById('fRegional').addEventListener('change', renderMatrix);
  document.getElementById('fDistrict').addEventListener('change', renderMatrix);
  document.getElementById('fCondition').addEventListener('change', renderMatrix);
  document.getElementById('searchInput').addEventListener('input', renderMatrix);

  /* ---------- drill-down: workorder list dialog ---------- */
  var listDialog = document.getElementById('listDialog');
  document.getElementById('matrixBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-sto]');
    if (!b) { return; }
    var sto = b.dataset.sto, status = b.dataset.status;
    var rows = WORKORDERS.filter(function(w){ return w.sto === sto && w.status === status; });
    document.getElementById('listDialogTitle').textContent = t('listTitleFor') + ' — ' + sto;
    document.getElementById('listDialogSummary').innerHTML = kvHtml([[t('cStatus'), woStatusLabel(status)], [t('cSto'), sto]]);
    document.getElementById('listDialogBody').innerHTML = rows.length ? rows.map(function(w, i){
      return '<tr><td>' + w.district + '</td><td>' + w.sto + '</td><td class="mono-cell">' + w.hostname + '</td>' +
        '<td class="mono-cell">' + w.ip + '</td><td>' + woStatusLabel(w.status) + '</td><td>' + w.tglListing + '</td>' +
        '<td><button class="mini-btn brand" data-wo="' + i + '" data-list-sto="' + sto + '" data-list-status="' + status + '">' + t('detail') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="7" style="text-align:center;color:var(--muted)">' + t('noWorkorder') + '</td></tr>';
    listDialog.classList.add('show');
  });
  document.getElementById('listDialogBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-wo]');
    if (!b) { return; }
    var rows = WORKORDERS.filter(function(w){ return w.sto === b.dataset.listSto && w.status === b.dataset.listStatus; });
    openWorkorderDetail(rows[parseInt(b.dataset.wo, 10)]);
  });
  document.getElementById('listDialogClose').addEventListener('click', function(){ listDialog.classList.remove('show'); });
  document.getElementById('listDialogDone').addEventListener('click', function(){ listDialog.classList.remove('show'); });

  function onLangChange(){ renderMatrix(); }
  renderMatrix();
  applyLang();
</script>
</body>
</html>
