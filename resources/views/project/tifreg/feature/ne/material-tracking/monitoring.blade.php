<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tracking Material Monitoring — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .mat-scroll{overflow-x:auto}
  table.mat-matrix{white-space:nowrap}
  table.mat-matrix th, table.mat-matrix td{text-align:center}
  table.mat-matrix th:nth-child(1), table.mat-matrix td:nth-child(1){text-align:left}
  tr.total-row td{font-weight:700;border-top:2px solid var(--border);background:var(--gray-50)}
  [data-theme="dark"] tr.total-row td{background:color-mix(in srgb,var(--gray-900) 60%,var(--panel-bg))}
  .chip-row{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
  .chip{font-size:11.5px;font-weight:600;padding:5px 10px;border-radius:999px;background:var(--gray-50);color:var(--text);border:1px solid var(--border)}
  [data-theme="dark"] .chip{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .mini-table{width:100%;border-collapse:collapse;font-size:11.5px}
  .mini-table th, .mini-table td{padding:6px 8px;border-bottom:1px solid var(--border);text-align:left;white-space:nowrap}
  .mini-table th{background:var(--gray-50);color:var(--muted);text-transform:uppercase;font-size:9.5px;letter-spacing:.04em}
  [data-theme="dark"] .mini-table th{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .link-btn{background:none;border:none;padding:0;color:var(--brand-600);font-weight:600;font-size:inherit;cursor:pointer;text-decoration:underline}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'ne-material'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">NE / Tracking Material</div>
    <h1 data-i18n="pageTitle">Monitoring</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-body">
        <div class="row3">
          <div class="field">
            <label data-i18n="fStatus">Status</label>
            <select id="fStatus">
              <option value="" data-i18n="stAll">SEMUA</option>
              <option value="sent" data-i18n="stOnDelivery">Dalam Pengiriman</option>
              <option value="received" data-i18n="stReceived">Diterima</option>
              <option value="waiting" data-i18n="stWaiting2">Menunggu</option>
            </select>
          </div>
          <div class="field">
            <label data-i18n="fPeriod">Periode</label>
            <select id="fPeriod"><option value="bulan" data-i18n="pBulan">BULAN</option><option value="semester" data-i18n="pSemester">SEMESTER</option><option value="tahun" data-i18n="pTahun">TAHUN</option></select>
          </div>
          <div class="field"><label data-i18n="fYear">Tahun</label><select id="fYear"><option>2026</option><option>2025</option><option>2024</option></select></div>
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
        </div>
        <div class="row-actions" style="margin-top:2px">
          <button class="btn-primary" id="searchBtn" data-i18n="show">Tampilkan</button>
          <button class="btn-outline" id="exportBtn" data-i18n="export">Export</button>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3 data-i18n="matrixTitle">Monitoring Tracking Material</h3></div>
      <p class="hint-muted" style="padding:0 16px 12px" data-i18n="scrollHint">Geser tabel untuk melihat seluruh kolom. Klik angka untuk melihat daftar work order.</p>
      <div class="mat-scroll">
        <table class="mat-matrix">
          <thead>
            <tr>
              <th data-i18n="cDistrict">District</th>
              <th data-i18n="modControl">Control</th>
              <th data-i18n="modService">Service</th>
              <th data-i18n="modPower">Power</th>
              <th data-i18n="modFan">Fan</th>
              <th data-i18n="modFrame">Frame</th>
              <th data-i18n="modRectifier">Rectifier</th>
              <th data-i18n="modOther">Lainnya</th>
            </tr>
          </thead>
          <tbody id="matrixBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- LEVEL 2: WORK ORDER LIST DIALOG -->
<div class="modal-backdrop" id="listDialog">
  <div class="modal-card modal-xl">
    <div class="modal-head">
      <div>
        <h3 data-i18n="listTitle">Daftar Work Order</h3>
        <div class="hint-muted" id="listSubtitle" style="margin-top:2px"></div>
      </div>
      <button class="modal-close" id="listClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="chip-row" id="listChips"></div>
      <div class="table-toolbar" style="padding:0 0 12px">
        <select id="listPerPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option><option value="50">50 / halaman</option><option value="100">100 / halaman</option></select>
        <input type="text" id="listSearch" data-i18n-ph="searchPh" placeholder="Cari di semua kolom..." />
      </div>
      <div class="table-scroll">
        <table>
          <thead>
            <tr>
              <th data-i18n="fAsal">Asal</th><th data-i18n="fTujuan">Tujuan</th><th>OLT</th><th data-i18n="cIpHostname">IP OLT</th>
              <th data-i18n="cDistrictOlt">District OLT</th><th data-i18n="fVendor">Vendor</th><th data-i18n="fTipeModul">Tipe Modul</th>
              <th data-i18n="fJenis">Jenis</th><th data-i18n="fKondisi">Kondisi</th><th data-i18n="fSerial">Serial Number</th>
              <th data-i18n="cStatus">Status</th><th data-i18n="fEkspedisi">Ekspedisi</th><th data-i18n="fResi">No. Resi</th>
              <th data-i18n="fPengirim">Nama Pengirim</th><th data-i18n="fTglDibuat">Tgl Dibuat</th><th data-i18n="fPenerima">Nama Penerima</th>
              <th data-i18n="fTglSelesai">Tgl Selesai</th><th class="sticky-col" data-i18n="cAction">Aksi</th>
            </tr>
          </thead>
          <tbody id="listBody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="listPageInfo"></span><div class="pager" id="listPager"></div></div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="listDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

<!-- LEVEL 3: WORK ORDER DETAIL DIALOG -->
<div class="modal-backdrop" id="woDialog">
  <div class="modal-card modal-xl">
    <div class="modal-head">
      <div><h3 data-i18n="woTitle">Detail Work Order</h3><div class="hint-muted" id="woSubtitle" style="margin-top:2px"></div></div>
      <button class="modal-close" id="woClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="wod-section">
        <b data-i18n="secWoInfo">Informasi Work Order</b>
        <div class="kv-grid" id="woInfoGrid"></div>
      </div>
      <div class="wod-section">
        <b data-i18n="secExpedition">Informasi Ekspedisi</b>
        <div class="kv-grid" id="woExpGrid"></div>
      </div>
      <div class="wod-section">
        <b data-i18n="secBa">Berita Acara Serah Terima</b>
        <div class="wod-cols">
          <div class="wod-section" style="flex:1;margin-bottom:0">
            <b style="font-size:11.5px" data-i18n="baSender">BA Pengirim</b>
            <div class="doc-frame" id="woBaSender" style="margin-top:8px"></div>
          </div>
          <div class="wod-section" style="flex:1;margin-bottom:0">
            <b style="font-size:11.5px" data-i18n="baReceiver">BA Penerima</b>
            <div class="doc-frame" id="woBaReceiver" style="margin-top:8px"></div>
          </div>
        </div>
      </div>
      <div class="wod-section">
        <b data-i18n="secMaterial">Daftar Material</b>
        <div class="wod-cols">
          <div class="wod-section" style="flex:1;margin-bottom:0">
            <b style="font-size:11.5px" data-i18n="matSender">Material Pengirim</b>
            <div class="table-scroll" style="margin-top:8px">
              <table class="mini-table">
                <thead><tr><th data-i18n="fTipeModul">Tipe Modul</th><th data-i18n="fJenis">Jenis</th><th data-i18n="fKondisi">Kondisi</th><th data-i18n="fSerial">Serial</th><th data-i18n="cStatus">Status</th><th data-i18n="fEvidence">Bukti</th></tr></thead>
                <tbody id="woMatSender"></tbody>
              </table>
            </div>
          </div>
          <div class="wod-section" style="flex:1;margin-bottom:0">
            <b style="font-size:11.5px" data-i18n="matReceiver">Material Penerima</b>
            <div class="table-scroll" style="margin-top:8px">
              <table class="mini-table">
                <thead><tr><th data-i18n="fTipeModul">Tipe Modul</th><th data-i18n="fJenis">Jenis</th><th data-i18n="fKondisi">Kondisi</th><th data-i18n="fSerial">Serial</th><th data-i18n="cStatus">Status</th><th data-i18n="fEvidence">Bukti</th></tr></thead>
                <tbody id="woMatReceiver"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="wod-section" id="woHistorySection" style="margin-bottom:0">
        <b data-i18n="secHistory2">Riwayat Tracking Resi</b>
        <div class="kv-grid kv-grid-1" id="woHistoryGrid"></div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="woDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Monitoring', matrixTitle: 'Monitoring Tracking Material',
      scrollHint: 'Geser tabel untuk melihat seluruh kolom. Klik angka untuk melihat daftar work order.',
      fStatus: 'Status', stAll: 'SEMUA', stOnDelivery: 'Dalam Pengiriman', stReceived: 'Diterima', stWaiting2: 'Menunggu',
      fPeriod: 'Periode', pBulan: 'BULAN', pSemester: 'SEMESTER', pTahun: 'TAHUN',
      fYear: 'Tahun', fMonth: 'Bulan', fSemester: 'Semester', show: 'Tampilkan', export: 'Export',
      exportToast: 'Export dinonaktifkan pada tampilan demo.',
      cDistrict: 'Distrik', modControl: 'Control', modService: 'Service', modPower: 'Power', modFan: 'Fan',
      modFrame: 'Frame', modRectifier: 'Rectifier', modOther: 'Lainnya', totalRowLabel: 'Total Regional KALIMANTAN',
      listTitle: 'Daftar Work Order', listSubtitleFor: 'Work order :module dari :district.',
      allDistrict: 'Semua District', searchPh: 'Cari di semua kolom...',
      fAsal: 'Asal', fTujuan: 'Tujuan', cIpHostname: 'IP OLT', cDistrictOlt: 'District OLT', fVendor: 'Vendor',
      fTipeModul: 'Tipe Modul', fJenis: 'Jenis', fKondisi: 'Kondisi', fSerial: 'Serial Number', cStatus: 'Status',
      fEkspedisi: 'Ekspedisi', fResi: 'No. Resi', fPengirim: 'Nama Pengirim', fTglDibuat: 'Tgl Dibuat',
      fPenerima: 'Nama Penerima', fTglSelesai: 'Tgl Selesai', cAction: 'Aksi', detail: 'Detail',
      chipDistrict: 'District: ', chipModule: 'Modul: ', chipTotal: 'Total: ',
      of: 'dari', noData: 'Tidak ada work order untuk kondisi ini.',
      woTitle: 'Detail Work Order', secWoInfo: 'Informasi Work Order', secExpedition: 'Informasi Ekspedisi',
      secBa: 'Berita Acara Serah Terima', baSender: 'BA Pengirim', baReceiver: 'BA Penerima',
      secMaterial: 'Daftar Material', matSender: 'Material Pengirim', matReceiver: 'Material Penerima',
      secHistory2: 'Riwayat Tracking Resi', fEvidence: 'Bukti', viewEvidence: 'Lihat',
      evidenceToast: 'Bukti (demo) — tidak ada file sungguhan.', openDoc: 'Buka dokumen',
      docToast: 'Dokumen demo — tidak ada file sungguhan.', noDoc: 'Belum ada dokumen.',
      fAreaTujuan: 'Area Tujuan', fNamaEkspedisi: 'Nama Petugas', close: 'Tutup',
    },
    en: {
      pageTitle: 'Monitoring', matrixTitle: 'Material Tracking Monitoring',
      scrollHint: 'Scroll the table to see every column. Click a number to view its work order list.',
      fStatus: 'Status', stAll: 'ALL', stOnDelivery: 'On Delivery', stReceived: 'Received', stWaiting2: 'Waiting',
      fPeriod: 'Period', pBulan: 'MONTH', pSemester: 'SEMESTER', pTahun: 'YEAR',
      fYear: 'Year', fMonth: 'Month', fSemester: 'Semester', show: 'Show', export: 'Export',
      exportToast: 'Export is disabled in this demo view.',
      cDistrict: 'District', modControl: 'Control', modService: 'Service', modPower: 'Power', modFan: 'Fan',
      modFrame: 'Frame', modRectifier: 'Rectifier', modOther: 'Other', totalRowLabel: 'Total Regional KALIMANTAN',
      listTitle: 'Work Order List', listSubtitleFor: ':module work orders from :district.',
      allDistrict: 'All Districts', searchPh: 'Search across all columns...',
      fAsal: 'Origin', fTujuan: 'Destination', cIpHostname: 'IP OLT', cDistrictOlt: 'OLT District', fVendor: 'Vendor',
      fTipeModul: 'Module Type', fJenis: 'Type', fKondisi: 'Condition', fSerial: 'Serial Number', cStatus: 'Status',
      fEkspedisi: 'Expedition', fResi: 'Receipt No.', fPengirim: 'Sender Name', fTglDibuat: 'Created Date',
      fPenerima: 'Receiver Name', fTglSelesai: 'Completed Date', cAction: 'Action', detail: 'Detail',
      chipDistrict: 'District: ', chipModule: 'Module: ', chipTotal: 'Total: ',
      of: 'of', noData: 'No work orders for this condition.',
      woTitle: 'Work Order Detail', secWoInfo: 'Work Order Information', secExpedition: 'Expedition Information',
      secBa: 'Handover Documents', baSender: 'Sender BA', baReceiver: 'Receiver BA',
      secMaterial: 'Material List', matSender: 'Sender Material', matReceiver: 'Receiver Material',
      secHistory2: 'Receipt Tracking History', fEvidence: 'Evidence', viewEvidence: 'View',
      evidenceToast: 'Evidence (demo) — no real file attached.', openDoc: 'Open document',
      docToast: 'Demo document — no real file attached.', noDoc: 'No document yet.',
      fAreaTujuan: 'Destination Area', fNamaEkspedisi: 'Contact Person', close: 'Close',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy dataset ---------- */
  var WORKORDERS = [
    { id: 1, district: 'District Balikpapan', module: 'CONTROL', status: 'received',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Balikpapan Kota', olt: 'OLT-BPN-KOTA-01', ip_olt: '10.14.20.11', district_olt: 'District Balikpapan',
      vendor: 'Huawei', tipe_modul: 'Control Module', jenis: 'SCU', kondisi: 'Baik', serial_number: 'SN-CTRL-0091',
      ekspedisi: 'JNE Trucking', nama_ekspedisi: 'Slamet Riyadi', no_resi: 'RESI-88213',
      nama_pengirim: 'Andi Saputra', tgl_dibuat: '2026-08-20', nama_penerima: 'Bagus Wicaksono', tgl_selesai: '2026-08-24' },
    { id: 2, district: 'District Balikpapan', module: 'SERVICE', status: 'sent',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Karang Joang', olt: 'OLT-BPN-KJ-02', ip_olt: '10.14.20.21', district_olt: 'District Balikpapan',
      vendor: 'ZTE', tipe_modul: 'Service Module', jenis: 'SFU', kondisi: 'Baik', serial_number: 'SN-SVC-0044',
      ekspedisi: 'SiCepat Cargo', nama_ekspedisi: 'Dewi Kurnia', no_resi: 'RESI-88254',
      nama_pengirim: 'Andi Saputra', tgl_dibuat: '2026-09-02', nama_penerima: '-', tgl_selesai: '-' },
    { id: 3, district: 'District Balikpapan', module: 'POWER', status: 'waiting',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Sepinggan', olt: 'OLT-BPN-SPG-03', ip_olt: '10.14.20.31', district_olt: 'District Balikpapan',
      vendor: 'Emerson', tipe_modul: 'Power Supply Unit', jenis: 'PSU-48V', kondisi: 'Baik', serial_number: 'SN-PWR-0117',
      ekspedisi: '-', nama_ekspedisi: '-', no_resi: '-',
      nama_pengirim: 'Andi Saputra', tgl_dibuat: '2026-09-05', nama_penerima: '-', tgl_selesai: '-' },
    { id: 4, district: 'District Balikpapan', module: 'FAN', status: 'received',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Batakan', olt: 'OLT-BPN-BTK-01', ip_olt: '10.14.20.41', district_olt: 'District Balikpapan',
      vendor: 'Huawei', tipe_modul: 'Fan Tray Module', jenis: 'FTM', kondisi: 'Baik', serial_number: 'SN-FAN-0032',
      ekspedisi: 'JNE Trucking', nama_ekspedisi: 'Slamet Riyadi', no_resi: 'RESI-88190',
      nama_pengirim: 'Bagus Wicaksono', tgl_dibuat: '2026-08-10', nama_penerima: 'Putri Lestari', tgl_selesai: '2026-08-14' },
    { id: 5, district: 'District Balikpapan', module: 'FRAME', status: 'sent',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Manggar', olt: 'OLT-BPN-MGR-01', ip_olt: '10.14.20.51', district_olt: 'District Balikpapan',
      vendor: 'ZTE', tipe_modul: 'Sub Rack Frame', jenis: 'SR-320', kondisi: 'Baik', serial_number: 'SN-FRM-0021',
      ekspedisi: 'Herona Express', nama_ekspedisi: 'Yusuf Hidayat', no_resi: 'RESI-88301',
      nama_pengirim: 'Bagus Wicaksono', tgl_dibuat: '2026-09-06', nama_penerima: '-', tgl_selesai: '-' },
    { id: 6, district: 'District Samarinda', module: 'CONTROL', status: 'sent',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Samarinda Kota', olt: 'OLT-SMD-KOTA-01', ip_olt: '10.14.30.11', district_olt: 'District Samarinda',
      vendor: 'Huawei', tipe_modul: 'Control Module', jenis: 'SCU', kondisi: 'Baik', serial_number: 'SN-CTRL-0102',
      ekspedisi: 'SiCepat Cargo', nama_ekspedisi: 'Dewi Kurnia', no_resi: 'RESI-88266',
      nama_pengirim: 'Andi Saputra', tgl_dibuat: '2026-09-01', nama_penerima: '-', tgl_selesai: '-' },
    { id: 7, district: 'District Samarinda', module: 'POWER', status: 'received',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Palaran', olt: 'OLT-SMD-PLB-02', ip_olt: '10.14.32.44', district_olt: 'District Samarinda',
      vendor: 'Delta', tipe_modul: 'Power Supply Unit', jenis: 'PSU-48V', kondisi: 'Rusak Ringan', serial_number: 'SN-PWR-0088',
      ekspedisi: 'Herona Express', nama_ekspedisi: 'Yusuf Hidayat', no_resi: 'RESI-88177',
      nama_pengirim: 'Budi Santoso', tgl_dibuat: '2026-08-14', nama_penerima: 'Rina Amelia', tgl_selesai: '2026-08-18' },
    { id: 8, district: 'District Samarinda', module: 'RECTIFIER', status: 'waiting',
      asal: 'Gudang Regional Balikpapan', tujuan: 'STO Samarinda Kota', olt: 'OLT-SMD-KOTA-01', ip_olt: '10.14.30.11', district_olt: 'District Samarinda',
      vendor: 'Delta M2000', tipe_modul: 'Rectifier Module', jenis: 'R48-3000', kondisi: 'Baik', serial_number: 'SN-RECT-0056',
      ekspedisi: '-', nama_ekspedisi: '-', no_resi: '-',
      nama_pengirim: 'Budi Santoso', tgl_dibuat: '2026-09-07', nama_penerima: '-', tgl_selesai: '-' },
    { id: 9, district: 'IM Regional Kalimantan', module: 'OTHER', status: 'received',
      asal: 'Vendor Pusat Jakarta', tujuan: 'Gudang Regional Balikpapan', olt: '-', ip_olt: '-', district_olt: '-',
      vendor: 'ZTE', tipe_modul: 'Kabel Patchcord', jenis: 'LC-LC 5m', kondisi: 'Baik', serial_number: 'SN-OTH-0301',
      ekspedisi: 'JNE Trucking', nama_ekspedisi: 'Slamet Riyadi', no_resi: 'RESI-88055',
      nama_pengirim: 'Warehouse Jakarta', tgl_dibuat: '2026-07-28', nama_penerima: 'Andi Saputra', tgl_selesai: '2026-08-01' },
    { id: 10, district: 'IM Regional Kalimantan', module: 'RECTIFIER', status: 'sent',
      asal: 'Vendor Pusat Jakarta', tujuan: 'Gudang Regional Balikpapan', olt: '-', ip_olt: '-', district_olt: '-',
      vendor: 'Emerson', tipe_modul: 'Rectifier Module', jenis: 'R48-3000', kondisi: 'Baik', serial_number: 'SN-RECT-0071',
      ekspedisi: 'SiCepat Cargo', nama_ekspedisi: 'Dewi Kurnia', no_resi: 'RESI-88322',
      nama_pengirim: 'Warehouse Jakarta', tgl_dibuat: '2026-09-08', nama_penerima: '-', tgl_selesai: '-' },
  ];

  var DISTRICTS = ['District Balikpapan', 'District Samarinda', 'IM Regional Kalimantan'];
  var MODULES = ['CONTROL', 'SERVICE', 'POWER', 'FAN', 'FRAME', 'RECTIFIER', 'OTHER'];
  var MODULE_KEY = { CONTROL: 'modControl', SERVICE: 'modService', POWER: 'modPower', FAN: 'modFan', FRAME: 'modFrame', RECTIFIER: 'modRectifier', OTHER: 'modOther' };

  function statusBadge(status){
    var map = { received: ['pill-green', t('stReceived')], sent: ['pill-teal', t('stOnDelivery')], waiting: ['pill-amber', t('stWaiting2')] };
    var m = map[status] || ['pill-gray', status];
    return '<span class="pill pill-sq ' + m[0] + '">' + m[1] + '</span>';
  }

  var MONTH_NUM = { Januari: 0, Februari: 1, Maret: 2, April: 3, Mei: 4, Juni: 5, Juli: 6, Agustus: 7, September: 8, Oktober: 9, November: 10, Desember: 11 };
  function pad2(n){ return n < 10 ? '0' + n : '' + n; }
  function periodRange(){
    var period = document.getElementById('fPeriod').value;
    var year = parseInt(document.getElementById('fYear').value, 10);
    var startMonth = 0, endMonth = 11;
    if (period === 'bulan') {
      startMonth = endMonth = MONTH_NUM[document.getElementById('fMonth').value];
    } else if (period === 'semester') {
      var sem = document.getElementById('fSemester').value;
      startMonth = sem === '1' ? 0 : 6;
      endMonth = sem === '1' ? 5 : 11;
    }
    var lastDay = new Date(year, endMonth + 1, 0).getDate();
    return { start: year + '-' + pad2(startMonth + 1) + '-01', end: year + '-' + pad2(endMonth + 1) + '-' + pad2(lastDay) };
  }
  function inRange(dateStr, range){ return dateStr && dateStr !== '-' && dateStr >= range.start && dateStr <= range.end; }

  function filteredWorkorders(){
    var status = document.getElementById('fStatus').value;
    var range = periodRange();
    return WORKORDERS.filter(function(w){
      if (status && w.status !== status) { return false; }
      var relevantDate = (status || w.status) === 'received' ? w.tgl_selesai : w.tgl_dibuat;
      return inRange(relevantDate, range);
    });
  }

  function renderMatrix(){
    var rows = filteredWorkorders();
    var counts = {};
    DISTRICTS.forEach(function(d){
      counts[d] = {};
      MODULES.forEach(function(m){ counts[d][m] = rows.filter(function(w){ return w.district === d && w.module === m; }).length; });
    });

    function numCell(district, module){
      var val = counts[district][module];
      if (!val) { return '<span class="cell-num zero" style="color:var(--muted)">0</span>'; }
      return '<button type="button" class="cell-num" style="background:none;border:none;font:inherit;color:var(--brand-600);font-weight:700;cursor:pointer" data-district="' + district + '" data-module="' + module + '">' + val + '</button>';
    }

    document.getElementById('matrixBody').innerHTML = DISTRICTS.map(function(d){
      return '<tr><td>' + d + '</td>' + MODULES.map(function(m){ return '<td>' + numCell(d, m) + '</td>'; }).join('') + '</tr>';
    }).join('') + '<tr class="total-row"><td>' + t('totalRowLabel') + '</td>' +
      MODULES.map(function(m){
        var total = DISTRICTS.reduce(function(acc, d){ return acc + counts[d][m]; }, 0);
        if (!total) { return '<td><span style="color:var(--muted)">0</span></td>'; }
        return '<td><button type="button" class="cell-num" style="background:none;border:none;font:inherit;color:var(--brand-600);font-weight:700;cursor:pointer" data-district="" data-module="' + m + '">' + total + '</button></td>';
      }).join('') + '</tr>';
  }

  /* ---------- filter toolbar ---------- */
  document.getElementById('fPeriod').addEventListener('change', function(){
    var v = this.value;
    document.getElementById('fMonthWrap').style.display = v === 'bulan' ? '' : 'none';
    document.getElementById('fSemesterWrap').style.display = v === 'semester' ? '' : 'none';
    renderMatrix();
  });
  document.getElementById('searchBtn').addEventListener('click', renderMatrix);
  document.getElementById('fStatus').addEventListener('change', renderMatrix);
  document.getElementById('fMonth').addEventListener('change', renderMatrix);
  document.getElementById('fSemester').addEventListener('change', renderMatrix);
  document.getElementById('fYear').addEventListener('change', renderMatrix);
  document.getElementById('exportBtn').addEventListener('click', function(){ toast(t('exportToast')); });

  /* ---------- level 2: work order list dialog ---------- */
  var listDialog = document.getElementById('listDialog'), woDialog = document.getElementById('woDialog');
  var listRows = [], listPage = 1;

  function openListDialog(district, module){
    listRows = filteredWorkorders().filter(function(w){ return (!district || w.district === district) && w.module === module; });
    listPage = 1;
    document.getElementById('listSubtitle').textContent = t('listSubtitleFor').replace(':module', t(MODULE_KEY[module])).replace(':district', district || t('allDistrict'));
    document.getElementById('listChips').innerHTML =
      '<span class="chip">' + t('chipDistrict') + (district || t('allDistrict')) + '</span>' +
      '<span class="chip">' + t('chipModule') + t(MODULE_KEY[module]) + '</span>' +
      '<span class="chip">' + t('chipTotal') + listRows.length + '</span>';
    document.getElementById('listSearch').value = '';
    renderListTable();
    listDialog.classList.add('show');
  }

  function renderListTable(){
    var q = document.getElementById('listSearch').value.trim().toLowerCase();
    var rows = listRows.filter(function(w){
      if (!q) { return true; }
      return Object.keys(w).some(function(k){ return String(w[k]).toLowerCase().indexOf(q) !== -1; });
    });
    var perPage = parseInt(document.getElementById('listPerPage').value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    if (listPage > totalPages) { listPage = totalPages; }
    var start = (listPage - 1) * perPage;
    var page = rows.slice(start, start + perPage);

    document.getElementById('listBody').innerHTML = page.length ? page.map(function(w){
      return '<tr><td>' + w.asal + '</td><td>' + w.tujuan + '</td><td class="mono-cell">' + w.olt + '</td><td class="mono-cell">' + w.ip_olt + '</td>' +
        '<td>' + w.district_olt + '</td><td>' + w.vendor + '</td><td>' + w.tipe_modul + '</td><td>' + w.jenis + '</td>' +
        '<td>' + w.kondisi + '</td><td class="mono-cell">' + w.serial_number + '</td><td>' + statusBadge(w.status) + '</td>' +
        '<td>' + w.ekspedisi + '</td><td class="mono-cell">' + w.no_resi + '</td><td>' + w.nama_pengirim + '</td>' +
        '<td>' + w.tgl_dibuat + '</td><td>' + w.nama_penerima + '</td><td>' + w.tgl_selesai + '</td>' +
        '<td class="sticky-col"><button class="mini-btn brand" data-wo-detail="' + w.id + '">' + t('detail') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="18" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';

    var from = rows.length ? start + 1 : 0, to = Math.min(start + perPage, rows.length);
    document.getElementById('listPageInfo').textContent = from + '–' + to + ' ' + t('of') + ' ' + rows.length;
    var pager = document.getElementById('listPager');
    pager.innerHTML = '';
    for (var p = 1; p <= totalPages; p++) {
      var btn = document.createElement('button');
      btn.textContent = p;
      if (p === listPage) { btn.classList.add('on'); }
      (function(pp){ btn.addEventListener('click', function(){ listPage = pp; renderListTable(); }); })(p);
      pager.appendChild(btn);
    }
  }

  document.getElementById('matrixBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-module]');
    if (b) { openListDialog(b.dataset.district, b.dataset.module); }
  });
  document.getElementById('listSearch').addEventListener('input', function(){ listPage = 1; renderListTable(); });
  document.getElementById('listPerPage').addEventListener('change', function(){ listPage = 1; renderListTable(); });
  document.getElementById('listClose').addEventListener('click', function(){ listDialog.classList.remove('show'); });
  document.getElementById('listDone').addEventListener('click', function(){ listDialog.classList.remove('show'); });

  /* ---------- level 3: work order detail dialog ---------- */
  function docFrame(available, label){
    if (!available) { return '<span>' + t('noDoc') + '</span>'; }
    return '<span>' + label + '</span><br /><a href="#" data-doc-toast>' + t('openDoc') + '</a>';
  }
  function materialRow(m){
    return '<tr><td>' + m.tipe_modul + '</td><td>' + m.jenis + '</td><td>' + m.kondisi + '</td><td class="mono-cell">' + m.serial_number + '</td>' +
      '<td>' + statusBadge(m.status_item) + '</td><td><button type="button" class="link-btn" data-ev-toast>' + t('viewEvidence') + '</button></td></tr>';
  }
  function humanize(key){ return key.split('_').map(function(w){ return w.charAt(0).toUpperCase() + w.slice(1); }).join(' '); }

  document.getElementById('listBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-wo-detail]');
    if (!b) { return; }
    var w = WORKORDERS.filter(function(x){ return x.id === parseInt(b.dataset.woDetail, 10); })[0];
    document.getElementById('woSubtitle').textContent = w.olt !== '-' ? w.olt : w.serial_number;
    document.getElementById('woInfoGrid').innerHTML = kvHtml([
      [t('fAsal'), w.asal], [t('fAreaTujuan'), w.tujuan], ['OLT', w.olt], [t('cIpHostname'), w.ip_olt],
      [t('cDistrictOlt'), w.district_olt], [t('fVendor'), w.vendor], [t('fPengirim'), w.nama_pengirim],
      [t('fPenerima'), w.nama_penerima], [t('cStatus'), statusBadge(w.status)],
    ]);
    document.getElementById('woExpGrid').innerHTML = kvHtml([
      [t('fEkspedisi'), w.ekspedisi], [t('fNamaEkspedisi'), w.nama_ekspedisi], [t('fResi'), w.no_resi],
      [t('fEvidence'), w.no_resi !== '-' ? '<button type="button" class="link-btn" data-ev-toast>' + t('viewEvidence') + '</button>' : '-'],
    ]);
    var hasBa = w.status !== 'waiting';
    document.getElementById('woBaSender').innerHTML = docFrame(hasBa, 'BA-' + w.serial_number + '-OUT.pdf');
    document.getElementById('woBaReceiver').innerHTML = docFrame(w.status === 'received', 'BA-' + w.serial_number + '-IN.pdf');
    var matSender = [{ tipe_modul: w.tipe_modul, jenis: w.jenis, kondisi: w.kondisi, serial_number: w.serial_number, status_item: 'sent' }];
    var matReceiver = w.status === 'received'
      ? [{ tipe_modul: w.tipe_modul, jenis: w.jenis, kondisi: w.kondisi, serial_number: w.serial_number, status_item: 'received' }]
      : [];
    document.getElementById('woMatSender').innerHTML = matSender.map(materialRow).join('');
    document.getElementById('woMatReceiver').innerHTML = matReceiver.length ? matReceiver.map(materialRow).join('')
      : '<tr><td colspan="6" style="text-align:center;color:var(--muted)">' + t('noData') + '</td></tr>';

    var historySection = document.getElementById('woHistorySection');
    if (w.status === 'waiting') {
      historySection.style.display = 'none';
    } else {
      historySection.style.display = '';
      var hist = { dikirim_dari_gudang: w.tgl_dibuat, dalam_perjalanan: w.tgl_dibuat, tiba_di_tujuan: w.tgl_selesai !== '-' ? w.tgl_selesai : '-' };
      if (w.status !== 'received') { delete hist.tiba_di_tujuan; }
      document.getElementById('woHistoryGrid').innerHTML = kvHtml(Object.keys(hist).map(function(k){ return [humanize(k), hist[k]]; }));
    }
    woDialog.classList.add('show');
  });
  woDialog.addEventListener('click', function(e){
    if (e.target.closest('[data-doc-toast]')) { e.preventDefault(); toast(t('docToast')); }
    if (e.target.closest('[data-ev-toast]')) { toast(t('evidenceToast')); }
  });
  document.getElementById('woClose').addEventListener('click', function(){ woDialog.classList.remove('show'); });
  document.getElementById('woDone').addEventListener('click', function(){ woDialog.classList.remove('show'); });

  function onLangChange(){ renderMatrix(); }
  renderMatrix();
  applyLang();
</script>
</body>
</html>
