<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>List Project QE — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .summary-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-bottom:18px}
  @media (min-width:860px){ .summary-grid{grid-template-columns:repeat(5,1fr)} }
  .summary-card{background:var(--panel-bg);border:1px solid var(--border);border-radius:12px;padding:14px 16px;cursor:pointer;transition:.15s}
  .summary-card:hover{border-color:var(--brand-500)}
  .summary-card.on{border-color:var(--brand-500);background:color-mix(in srgb,var(--brand-500) 6%,var(--panel-bg))}
  .summary-card .num{font-size:22px;font-weight:700;color:var(--text)}
  .summary-card .lbl{font-size:11.5px;color:var(--muted);margin-top:2px}
  .toolbar-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;margin-bottom:16px}
  .toolbar-row input[type=text]{height:38px;border-radius:8px;border:1px solid var(--border);background:var(--panel-bg);
    padding:0 12px;font-size:13px;font-family:inherit;color:var(--text);width:280px;max-width:60vw}
  .qe-grid{display:grid;grid-template-columns:1fr;gap:16px}
  @media (min-width:820px){ .qe-grid{grid-template-columns:1fr 1fr} }
  @media (min-width:1240px){ .qe-grid{grid-template-columns:1fr 1fr 1fr} }
  .qe-card{background:var(--panel-bg);border:1px solid var(--border);border-radius:14px;padding:16px;display:flex;flex-direction:column;gap:10px}
  .qe-card .loc{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.03em}
  .qe-card .title{font-size:14.5px;font-weight:600;color:var(--text);line-height:1.35}
  .qe-chips{display:flex;flex-wrap:wrap;gap:6px}
  .qe-chip{font-size:10.5px;font-weight:600;padding:3px 8px;border-radius:6px;background:var(--gray-100);color:var(--label)}
  [data-theme="dark"] .qe-chip{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .status-row{display:flex;flex-wrap:wrap;gap:6px}
  .progress-track{height:6px;border-radius:99px;background:var(--gray-100);overflow:hidden}
  [data-theme="dark"] .progress-track{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .progress-fill{height:100%;border-radius:99px;background:var(--brand-500)}
  .progress-block{display:flex;flex-direction:column;gap:3px}
  .progress-block .lbl{display:flex;justify-content:space-between;font-size:10.5px;color:var(--muted)}
  .meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:6px 12px;font-size:11px;color:var(--muted)}
  .meta-grid b{color:var(--text);font-weight:600}
  .budget-row{display:flex;justify-content:space-between;font-size:11.5px;padding-top:8px;border-top:1px dashed var(--border)}
  .budget-row .v{font-weight:700;color:var(--text)}
  .card-foot{display:flex;align-items:center;justify-content:space-between;gap:8px;padding-top:8px;border-top:1px solid var(--border)}
  .smart-status{font-size:11.5px;font-weight:600;color:var(--brand-600)}
  .card-actions{display:flex;gap:4px}
  .icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:var(--panel-bg);color:var(--label);
    display:inline-flex;align-items:center;justify-content:center}
  .icon-btn:hover{border-color:var(--brand-500);color:var(--brand-500)}
  .empty-state{text-align:center;padding:60px 20px;color:var(--muted)}
  .accordion{border:1px solid var(--border);border-radius:10px;margin-bottom:12px}
  .accordion-head{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;font-size:13px;font-weight:600;cursor:pointer}
  .accordion-body{padding:0 14px 14px;display:none}
  .accordion.open .accordion-body{display:block}
  .reviewer-row{display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-top:1px solid var(--border);font-size:12.5px}
  .reviewer-row:first-child{border-top:none}
  .drawer-backdrop{position:fixed;inset:0;background:rgba(16,24,40,.6);z-index:2100;display:none;justify-content:flex-end}
  .drawer-backdrop.show{display:flex}
  .drawer{width:380px;max-width:92vw;height:100%;background:var(--panel-bg);display:flex;flex-direction:column}
  .drawer-head{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;border-bottom:1px solid var(--border)}
  .drawer-body{padding:16px 18px;overflow-y:auto;flex:1}
  .log-item{padding:10px 0;border-bottom:1px solid var(--border);font-size:12.5px}
  .log-item .t{color:var(--muted);font-size:11px}
  .link-btn2{background:none;border:none;padding:0;color:var(--brand-600);font-weight:600;font-size:12px;cursor:pointer;text-decoration:underline}
  .checkbox-row{display:flex;flex-wrap:wrap;gap:8px 18px;padding:10px 12px;border:1px solid var(--border);border-radius:8px}
  .checkbox-row label{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--label);cursor:pointer}
  .checkbox-row input{width:15px;height:15px;accent-color:var(--brand-500);cursor:pointer}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'qe-project'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">QE</div>
    <h1 data-i18n="pageTitle">List Project</h1>
    <p class="hint-muted" data-i18n="pageSubtitle">Quality Enhancement — Network Operation Kalimantan</p>
  </div>

  <div class="row-actions" style="margin-bottom:16px">
    <button class="btn-primary" id="ajukanBtn" data-i18n="btnAjukan">+ Ajukan QE</button>
  </div>

  <div class="summary-grid" id="summaryGrid"></div>

  <div class="toolbar-row" id="qeToolbarRow">
    <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari nama / no project / district..." />
    <div class="row-actions">
      <select id="perPage"><option value="6">6</option><option value="12" selected>12</option><option value="24">24</option><option value="48">48</option></select>
      <button class="btn-outline" id="refreshBtn" data-i18n="refresh2">Refresh</button>
    </div>
  </div>

  <div class="qe-grid" id="qeGrid"></div>
  <div class="table-foot" style="margin-top:14px"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
</main>

<!-- DETAIL MODAL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card modal-xl">
    <div class="modal-head">
      <div><h3 id="detailTitle">-</h3><div class="hint-muted" id="detailSubtitle" style="margin-top:2px"></div></div>
      <button class="modal-close" id="detailClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="wod-cols">
        <div class="wod-section" style="flex:2">
          <b data-i18n="secInfo">Informasi Pekerjaan</b>
          <div class="kv-grid" id="dInfoGrid"></div>
          <div style="margin-top:14px">
            <b style="font-size:12.5px" data-i18n="secStatus">Status &amp; Progress</b>
            <div id="dProgress" style="margin-top:8px;display:flex;flex-direction:column;gap:10px"></div>
          </div>
          <div style="margin-top:14px">
            <b style="font-size:12.5px" data-i18n="secAlpro">Alpro Terdampak</b>
            <div class="table-scroll" style="margin-top:6px">
              <table class="mini-table"><thead><tr><th data-i18n="cJenisAlpro">Jenis Alpro</th><th data-i18n="cNama">Nama</th></tr></thead><tbody id="dAlproBody"></tbody></table>
            </div>
          </div>
          <div style="margin-top:14px">
            <b style="font-size:12.5px" data-i18n="secDokumen">Dokumen Pendukung</b>
            <div id="dDokumenList" style="margin-top:6px;font-size:12.5px"></div>
          </div>
          <div style="margin-top:14px">
            <b style="font-size:12.5px" data-i18n="secBudget">Anggaran</b>
            <div class="kv-grid" id="dBudgetGrid" style="margin-top:6px"></div>
          </div>
        </div>
        <div class="wod-section" style="flex:1">
          <b data-i18n="secApprovalUsulan">Approval Usulan</b>
          <div class="accordion open" id="accUsulan" style="margin-top:8px">
            <div class="accordion-head"><span id="accUsulanStage">-</span><span>▾</span></div>
            <div class="accordion-body">
              <div id="usulanReviewers"></div>
              <div class="row-actions" style="margin-top:10px" id="usulanActions"></div>
            </div>
          </div>
          <b data-i18n="secApprovalRekon">Approval Rekon</b>
          <div class="accordion open" id="accRekon" style="margin-top:8px">
            <div class="accordion-head"><span id="accRekonStage">-</span><span>▾</span></div>
            <div class="accordion-body">
              <div id="rekonReviewers"></div>
              <div class="row-actions" style="margin-top:10px" id="rekonActions"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="detailDone" data-i18n="close">Tutup</button></div>
  </div>
</div>

<!-- MULAI PEKERJAAN DIALOG -->
<div class="modal-backdrop" id="mulaiModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="mulaiTitle">Mulai Pekerjaan</h3><button class="modal-close" id="mulaiX">✕</button></div>
    <div class="modal-body">
      <div class="field"><label data-i18n="fUnitMitra">Unit Mitra</label>
        <select id="mulaiMitra"><option>Mitra TL Balikpapan</option><option>Mitra TL Samarinda</option><option>Mitra TL Makassar</option></select>
      </div>
      <div class="field" style="margin-top:10px"><label data-i18n="fTeknisi">Teknisi</label>
        <div class="checkbox-row" id="mulaiTeknisi"></div>
      </div>
      <div class="field" style="margin-top:10px"><label data-i18n="fCatatan">Catatan</label><textarea id="mulaiNote" rows="2"></textarea></div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="mulaiCancel" data-i18n="cancel">Batal</button>
      <button class="btn-primary" id="mulaiOk" data-i18n="mulaiSubmit">Mulai</button>
    </div>
  </div>
</div>

<!-- APPROVAL REASON MODAL (reject/return) -->
<div class="modal-backdrop" id="reasonModal">
  <div class="modal-card">
    <div class="modal-head"><h3 id="reasonTitle">-</h3><button class="modal-close" id="reasonX">✕</button></div>
    <div class="modal-body">
      <div class="field"><label data-i18n="reasonLabel">Alasan</label><textarea id="reasonNote" rows="3"></textarea>
        <p class="hint" id="reasonErr" style="color:var(--error-500);display:none" data-i18n="reasonRequired">Alasan wajib diisi</p>
      </div>
    </div>
    <div class="modal-foot"><button class="btn-outline" id="reasonCancel" data-i18n="cancel">Batal</button><button class="btn-danger" id="reasonOk" data-i18n="submit2">Kirim</button></div>
  </div>
</div>

<!-- HISTORY DRAWER -->
<div class="drawer-backdrop" id="historyDrawer">
  <div class="drawer">
    <div class="drawer-head"><h3 data-i18n="historyTitle">Riwayat / Log</h3><button class="modal-close" id="historyClose">✕</button></div>
    <div class="drawer-body" id="historyBody"></div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'List Project', pageSubtitle: 'Quality Enhancement — Network Operation Kalimantan',
      btnAjukan: '+ Ajukan QE', ajukanToast: 'Wizard pengajuan QE (6 langkah) dinonaktifkan pada versi demo.',
      sProposal: 'Proses Usulan', sWork: 'Proses Pekerjaan', sReview: 'Proses Review &amp; Rekon', sDeadline: 'Batas Waktu', sInbox: 'My Inbox',
      searchPh: 'Cari nama / no project / district...', refresh2: 'Refresh', of: 'dari', noData: 'Tidak ada project yang cocok dengan filter saat ini.',
      secInfo: 'Informasi Pekerjaan', secStatus: 'Status &amp; Progress', secAlpro: 'Alpro Terdampak', secDokumen: 'Dokumen Pendukung',
      secBudget: 'Anggaran', secApprovalUsulan: 'Approval Usulan', secApprovalRekon: 'Approval Rekon',
      cJenisAlpro: 'Jenis Alpro', cNama: 'Nama', close: 'Tutup',
      lProposal: 'Kode', lWo: 'No. WO', lLokasi: 'Lokasi', lSto: 'STO', lRequester: 'Requester', lAlasan: 'Alasan Usulan',
      lEstLama: 'Estimasi Lama', lEstSelesai: 'Estimasi Selesai', lKabel: 'Kebutuhan Kabel Armoured', lTitik: 'Jumlah Titik Gangguan',
      lScope: 'Scope', lType: 'Jenis QE', lProgram: 'Program', lTeknisi: 'Teknisi', lPanjangKabel: 'Panjang Kabel',
      lProposed: 'Usulan Anggaran', lAllocation: 'Alokasi', lRealization: 'Realisasi', lCommitted: 'Committed', lAvailable: 'Available',
      pProposal: 'Usulan', pWork: 'Pekerjaan', pReview: 'Review/Rekon',
      docLihat: 'Lihat', docToast: 'Dokumen demo — tidak ada file sungguhan.', noDocs: 'Tidak ada dokumen.',
      mulaiTitle: 'Mulai Pekerjaan', fUnitMitra: 'Unit Mitra', fTeknisi: 'Teknisi', fCatatan: 'Catatan (opsional)',
      mulaiSubmit: 'Mulai', cancel: 'Batal', mulaiToast: ' — pekerjaan dimulai.',
      reasonLabel: 'Alasan', reasonRequired: 'Alasan wajib diisi', submit2: 'Kirim',
      approveTitle: 'Approve', rejectTitle: 'Reject', returnTitle: 'Return',
      btnApprove: 'Approve', btnReject: 'Reject', btnReturn: 'Return',
      toastApprove: ' berhasil di-approve.', toastReject: ' di-reject.', toastReturn: ' dikembalikan.',
      noAction: 'Tidak ada aksi tersedia pada tahap ini.', editToast: 'Form Edit Anggaran dinonaktifkan pada versi demo.',
      deleteToast: 'Hapus project dinonaktifkan pada versi demo.', historyTitle: 'Riwayat / Log',
      ssOnReview: 'On Review - :unit', ssNeedAssign: 'Need Assign Teknisi', ssNeedStart: 'Need Start Project',
      ssOnProgress: 'On Progress', ssNeedUpdate: 'Need Update Progress', ssKendala: 'Kendala - :c',
      ssReturnPemohon: 'Return To Pemohon', ssRejected: 'Rejected', ssNeedReview: 'Need Review', ssComplete: 'PROJECT COMPLETED',
      stSubmit: 'Submit', stOnReview: 'On Review', stBudgetReview: 'Review Budget', stApproved: 'Approved', stReject: 'Reject', stReturn: 'Return',
      stReady: 'Ready', stAssign: 'Assign', stStart: 'Start', stSurvey: 'Survey', stProgress: 'Progress', stKendala: 'Kendala', stCancel: 'Cancel', stDone: 'Done', stComplete: 'Complete',
      stApproveTl: 'Approve TL', stApproveDistrict: 'Approve District', stRekonReview: 'Rekon Review', stApproveRekon: 'Approve Rekon',
      overBudget: 'Over Budget +:pct%',
    },
    en: {
      pageTitle: 'List Project', pageSubtitle: 'Quality Enhancement — Network Operation Kalimantan',
      btnAjukan: '+ Submit QE', ajukanToast: 'The 6-step QE submission wizard is disabled in this demo view.',
      sProposal: 'Proposal', sWork: 'Work', sReview: 'Review &amp; Rekon', sDeadline: 'Deadline', sInbox: 'My Inbox',
      searchPh: 'Search name / project no / district...', refresh2: 'Refresh', of: 'of', noData: 'No project matches the current filters.',
      secInfo: 'Work Information', secStatus: 'Status &amp; Progress', secAlpro: 'Affected Assets', secDokumen: 'Supporting Documents',
      secBudget: 'Budget', secApprovalUsulan: 'Proposal Approval', secApprovalRekon: 'Reconciliation Approval',
      cJenisAlpro: 'Asset Type', cNama: 'Name', close: 'Close',
      lProposal: 'Code', lWo: 'WO No.', lLokasi: 'Location', lSto: 'STO', lRequester: 'Requester', lAlasan: 'Proposal Reason',
      lEstLama: 'Est. Duration', lEstSelesai: 'Est. Finish', lKabel: 'Armoured Cable Needed', lTitik: 'Disruption Points',
      lScope: 'Scope', lType: 'QE Type', lProgram: 'Program', lTeknisi: 'Technician', lPanjangKabel: 'Cable Length',
      lProposed: 'Proposed Budget', lAllocation: 'Allocation', lRealization: 'Realization', lCommitted: 'Committed', lAvailable: 'Available',
      pProposal: 'Proposal', pWork: 'Work', pReview: 'Review/Rekon',
      docLihat: 'View', docToast: 'Demo document — no real file attached.', noDocs: 'No documents.',
      mulaiTitle: 'Start Work', fUnitMitra: 'Partner Unit', fTeknisi: 'Technicians', fCatatan: 'Note (optional)',
      mulaiSubmit: 'Start', cancel: 'Cancel', mulaiToast: ' — work started.',
      reasonLabel: 'Reason', reasonRequired: 'Reason is required', submit2: 'Submit',
      approveTitle: 'Approve', rejectTitle: 'Reject', returnTitle: 'Return',
      btnApprove: 'Approve', btnReject: 'Reject', btnReturn: 'Return',
      toastApprove: ' approved successfully.', toastReject: ' rejected.', toastReturn: ' returned.',
      noAction: 'No action available at this stage.', editToast: 'The Edit Budget form is disabled in this demo view.',
      deleteToast: 'Deleting a project is disabled in this demo view.', historyTitle: 'History / Log',
      ssOnReview: 'On Review - :unit', ssNeedAssign: 'Need Assign Technician', ssNeedStart: 'Need Start Project',
      ssOnProgress: 'On Progress', ssNeedUpdate: 'Need Update Progress', ssKendala: 'Issue - :c',
      ssReturnPemohon: 'Return To Requester', ssRejected: 'Rejected', ssNeedReview: 'Need Review', ssComplete: 'PROJECT COMPLETED',
      stSubmit: 'Submit', stOnReview: 'On Review', stBudgetReview: 'Review Budget', stApproved: 'Approved', stReject: 'Reject', stReturn: 'Return',
      stReady: 'Ready', stAssign: 'Assign', stStart: 'Start', stSurvey: 'Survey', stProgress: 'Progress', stKendala: 'Issue', stCancel: 'Cancel', stDone: 'Done', stComplete: 'Complete',
      stApproveTl: 'Approve TL', stApproveDistrict: 'Approve District', stRekonReview: 'Rekon Review', stApproveRekon: 'Approve Rekon',
      overBudget: 'Over Budget +:pct%',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy dataset ---------- */
  var TODAY = new Date('2026-09-11');
  var PROJECTS = [
    { id: 1, code: 'QE-2026-0091', title: 'Preventif Kabel Feeder STO Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Balikpapan Kota',
      scope: 'BILLABLE', qeType: 'PREVENTIF', program: 'ODP Sehat', proposalStatus: 'SUBMIT', workStatus: 'READY', reviewStatus: 'SUBMIT',
      proposalPct: 20, workPct: 0, reviewPct: 0, proposed: 45000000, allocation: 0, realization: 0, committed: 0,
      inputAt: '2026-09-10', estFinish: '2026-10-05', jumlahAlpro: 3, lastUpdate: '2026-09-10', teknisi: '-', panjangKabel: 0,
      requester: 'Andi Saputra', alasan: 'Menjaga performa feeder ring agar tidak terjadi gangguan berulang di musim hujan.',
      estLamaHari: 25, kabelArmoured: 800, titikGangguan: 0 },
    { id: 2, code: 'QE-2026-0088', title: 'Kuratif Gangguan Berulang STO Sepinggan', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Sepinggan',
      scope: 'BILLABLE', qeType: 'KURATIF', program: null, proposalStatus: 'ON_REVIEW', workStatus: 'READY', reviewStatus: 'SUBMIT',
      proposalPct: 40, workPct: 0, reviewPct: 0, proposed: 32000000, allocation: 0, realization: 0, committed: 0,
      inputAt: '2026-09-05', estFinish: '2026-09-25', jumlahAlpro: 2, lastUpdate: '2026-09-06', teknisi: '-', panjangKabel: 0,
      requester: 'Putri Lestari', alasan: 'Gangguan berulang 5x dalam sebulan akibat kabel drop tergesek pohon.',
      estLamaHari: 15, kabelArmoured: 400, titikGangguan: 2 },
    { id: 3, code: 'QE-2026-0075', title: 'Relokasi Kabinet OLT Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Karang Joang',
      scope: 'BILLABLE', qeType: 'RELOKASI', program: null, proposalStatus: 'APPROVED', workStatus: 'ASSIGN', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 10, reviewPct: 0, proposed: 68000000, allocation: 68000000, realization: 0, committed: 10000000,
      inputAt: '2026-08-20', estFinish: '2026-09-18', jumlahAlpro: 4, lastUpdate: '2026-09-09', teknisi: '-', panjangKabel: 0,
      requester: 'Bagus Wicaksono', alasan: 'Relokasi kabinet karena penyempitan bahu jalan proyek pemerintah.',
      estLamaHari: 20, kabelArmoured: 600, titikGangguan: 1 },
    { id: 4, code: 'QE-2026-0070', title: 'Preventif Feeder Ring Samarinda Kota', district: 'District Samarinda', regional: 'KALIMANTAN', sto: 'STO Samarinda Kota',
      scope: 'BILLABLE', qeType: 'PREVENTIF', program: 'ODP Sehat', proposalStatus: 'APPROVED', workStatus: 'START', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 30, reviewPct: 0, proposed: 55000000, allocation: 55000000, realization: 12000000, committed: 20000000,
      inputAt: '2026-08-15', estFinish: '2026-09-30', jumlahAlpro: 5, lastUpdate: '2026-09-10', teknisi: 'Budi Santoso, Rina Amelia', panjangKabel: 300,
      requester: 'Budi Santoso', alasan: 'Penguatan feeder ring untuk redundansi jalur utama kota.',
      estLamaHari: 30, kabelArmoured: 1000, titikGangguan: 0 },
    { id: 5, code: 'QE-2026-0066', title: 'Kuratif Gangguan Fiber Cut Palaran', district: 'District Samarinda', regional: 'KALIMANTAN', sto: 'STO Palaran',
      scope: 'BILLABLE', qeType: 'KURATIF', program: null, proposalStatus: 'APPROVED', workStatus: 'SURVEY', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 45, reviewPct: 0, proposed: 28000000, allocation: 28000000, realization: 5000000, committed: 8000000,
      inputAt: '2026-08-10', estFinish: '2026-09-16', jumlahAlpro: 2, lastUpdate: '2026-09-08', teknisi: 'Budi Santoso', panjangKabel: 150,
      requester: 'Rina Amelia', alasan: 'Fiber cut akibat longsor kecil di bahu jalan.',
      estLamaHari: 10, kabelArmoured: 250, titikGangguan: 1 },
    { id: 6, code: 'QE-2026-0055', title: 'Preventif ODC Sehat Makassar Pusat', district: 'District Makassar', regional: 'SULAWESI', sto: 'STO Makassar Pusat',
      scope: 'BILLABLE', qeType: 'PREVENTIF', program: 'ODC Sehat', proposalStatus: 'APPROVED', workStatus: 'PROGRESS', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 70, reviewPct: 0, proposed: 72000000, allocation: 72000000, realization: 40000000, committed: 55000000,
      inputAt: '2026-07-20', estFinish: '2026-09-14', jumlahAlpro: 6, lastUpdate: '2026-09-09', teknisi: 'Muh. Ilham', panjangKabel: 900,
      requester: 'Muh. Ilham', alasan: 'Perapian ODC yang belum sehat sesuai standar kabel dan splitter.',
      estLamaHari: 40, kabelArmoured: 1500, titikGangguan: 0, lastLogDaysAgo: 1 },
    { id: 7, code: 'QE-2026-0050', title: 'Recovery Ticket Storm Makassar', district: 'District Makassar', regional: 'SULAWESI', sto: 'STO Makassar Pusat',
      scope: 'NON_BILLABLE', qeType: 'RECOVERY', program: null, proposalStatus: 'APPROVED', workStatus: 'PROGRESS', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 70, reviewPct: 0, proposed: 40000000, allocation: 40000000, realization: 38000000, committed: 44000000,
      inputAt: '2026-07-10', estFinish: '2026-09-20', jumlahAlpro: 8, lastUpdate: '2026-09-05', teknisi: 'Muh. Ilham', panjangKabel: 1100,
      requester: 'Reza Pratama', alasan: 'Recovery massal pasca badai — banyak ticket pelanggan padam bersamaan.',
      estLamaHari: 45, kabelArmoured: 2000, titikGangguan: 12, lastLogDaysAgo: 6 },
    { id: 8, code: 'QE-2026-0044', title: 'Kuratif Gangguan Massal Balikpapan Kota', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Balikpapan Kota',
      scope: 'BILLABLE', qeType: 'KURATIF', program: null, proposalStatus: 'APPROVED', workStatus: 'KENDALA', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 60, reviewPct: 0, proposed: 50000000, allocation: 50000000, realization: 30000000, committed: 35000000,
      inputAt: '2026-07-01', estFinish: '2026-09-12', jumlahAlpro: 3, lastUpdate: '2026-09-07', teknisi: 'Bagus Wicaksono', panjangKabel: 500,
      requester: 'Bagus Wicaksono', alasan: 'Gangguan massal akibat tiang miring pasca banjir.',
      estLamaHari: 20, kabelArmoured: 700, titikGangguan: 3,
      kendalaComment: 'Akses lokasi tertutup proyek jalan, menunggu izin dinas PU.' },
    { id: 9, code: 'QE-2026-0033', title: 'Preventif Feeder Balikpapan Selatan', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Balikpapan Kota',
      scope: 'BILLABLE', qeType: 'PREVENTIF', program: 'ODP Sehat', proposalStatus: 'APPROVED', workStatus: 'DONE', reviewStatus: 'SUBMIT',
      proposalPct: 100, workPct: 90, reviewPct: 10, proposed: 60000000, allocation: 60000000, realization: 58000000, committed: 60000000,
      inputAt: '2026-06-15', estFinish: '2026-08-30', jumlahAlpro: 5, lastUpdate: '2026-08-29', teknisi: 'Andi Saputra', panjangKabel: 1200,
      requester: 'Andi Saputra', alasan: 'Penguatan feeder wilayah selatan yang rawan gangguan cuaca.',
      estLamaHari: 35, kabelArmoured: 1300, titikGangguan: 0 },
    { id: 10, code: 'QE-2026-0020', title: 'Permanenisasi ODC Sehat Karang Joang', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Karang Joang',
      scope: 'BILLABLE', qeType: 'PREVENTIF', program: 'Permanenisasi', proposalStatus: 'APPROVED', workStatus: 'COMPLETE', reviewStatus: 'APPROVE_REKON',
      proposalPct: 100, workPct: 100, reviewPct: 100, proposed: 90000000, allocation: 90000000, realization: 88500000, committed: 90000000,
      inputAt: '2026-05-01', estFinish: '2026-07-01', jumlahAlpro: 9, lastUpdate: '2026-07-05', teknisi: 'Andi Saputra, Bagus Wicaksono', panjangKabel: 2400,
      requester: 'Andi Saputra', alasan: 'Permanenisasi tiket temporer menjadi jalur permanen.',
      estLamaHari: 60, kabelArmoured: 2500, titikGangguan: 0 },
    { id: 11, code: 'QE-2026-0015', title: 'Relokasi OLT Manggar', district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Manggar',
      scope: 'BILLABLE', qeType: 'RELOKASI', program: null, proposalStatus: 'RETURN', workStatus: 'READY', reviewStatus: 'SUBMIT',
      proposalPct: 30, workPct: 0, reviewPct: 0, proposed: 35000000, allocation: 0, realization: 0, committed: 0,
      inputAt: '2026-08-25', estFinish: '-', jumlahAlpro: 1, lastUpdate: '2026-09-02', teknisi: '-', panjangKabel: 0,
      requester: 'Dewi Anggraini', alasan: 'Relokasi OLT karena lahan akan digunakan proyek jalan tol.',
      estLamaHari: 18, kabelArmoured: 350, titikGangguan: 0, returnNote: 'Dokumen KML tidak lengkap, mohon dilengkapi.' },
    { id: 12, code: 'QE-2026-0008', title: 'Kuratif Gangguan STO Samarinda', district: 'District Samarinda', regional: 'KALIMANTAN', sto: 'STO Samarinda Kota',
      scope: 'BILLABLE', qeType: 'KURATIF', program: null, proposalStatus: 'REJECT', workStatus: 'READY', reviewStatus: 'SUBMIT',
      proposalPct: 10, workPct: 0, reviewPct: 0, proposed: 25000000, allocation: 0, realization: 0, committed: 0,
      inputAt: '2026-08-18', estFinish: '-', jumlahAlpro: 1, lastUpdate: '2026-08-22', teknisi: '-', panjangKabel: 0,
      requester: 'Rina Amelia', alasan: 'Gangguan sporadis pada 1 pelanggan enterprise.',
      estLamaHari: 10, kabelArmoured: 100, titikGangguan: 1, rejectNote: 'Anggaran regional sudah habis untuk periode ini.' },
  ];

  var ALPRO_SAMPLE = ['ODP-BPN-014', 'ODP-BPN-027', 'ODC-BPN-03', 'Feeder Ring Utara', 'Site Telkomsel BPN-04'];
  var DOC_SAMPLE = ['Foto Alpro', 'Layout ManCore', 'Foto Lokasi', 'Surat Pendukung'];
  var TEKNISI_POOL = ['Andi Saputra', 'Bagus Wicaksono', 'Putri Lestari', 'Budi Santoso', 'Rina Amelia', 'Muh. Ilham'];

  function statusLabel(track, code){
    var map = {
      proposal: { SUBMIT: 'stSubmit', ON_REVIEW: 'stOnReview', BUDGET_REVIEW: 'stBudgetReview', APPROVED: 'stApproved', REJECT: 'stReject', RETURN: 'stReturn' },
      work: { READY: 'stReady', ASSIGN: 'stAssign', START: 'stStart', SURVEY: 'stSurvey', PROGRESS: 'stProgress', KENDALA: 'stKendala', CANCEL: 'stCancel', DONE: 'stDone', COMPLETE: 'stComplete' },
      review: { SUBMIT: 'stSubmit', APPROVE_TL: 'stApproveTl', APPROVE_DISTRICT: 'stApproveDistrict', REKON_REVIEW: 'stRekonReview', RETURN: 'stReturn', REJECT: 'stReject', APPROVE_REKON: 'stApproveRekon' },
    };
    return t(map[track][code] || code);
  }
  function statusTone(track, code){
    var map = {
      proposal: { SUBMIT: 'gray', ON_REVIEW: 'blue', BUDGET_REVIEW: 'purple', APPROVED: 'green', REJECT: 'red', RETURN: 'amber' },
      work: { READY: 'gray', ASSIGN: 'amber', START: 'blue', SURVEY: 'blue', PROGRESS: 'amber', KENDALA: 'red', CANCEL: 'gray', DONE: 'teal', COMPLETE: 'green' },
      review: { SUBMIT: 'gray', APPROVE_TL: 'blue', APPROVE_DISTRICT: 'blue', REKON_REVIEW: 'purple', RETURN: 'amber', REJECT: 'red', APPROVE_REKON: 'green' },
    };
    return map[track][code] || 'gray';
  }
  function statusPill(track, code){
    return '<span class="pill pill-sq pill-' + statusTone(track, code) + '">' + statusLabel(track, code) + '</span>';
  }

  function daysLeft(p){
    if (p.proposalStatus !== 'APPROVED' || p.estFinish === '-') { return null; }
    var diff = Math.round((new Date(p.estFinish) - TODAY) / 86400000);
    return diff;
  }
  function countdownPill(p){
    var d = daysLeft(p);
    if (d === null || p.workStatus === 'COMPLETE') { return ''; }
    var tone = d < 3 ? 'red' : d <= 7 ? 'amber' : d <= 29 ? 'amber' : 'green';
    var label = d < 0 ? Math.abs(d) + 'd overdue' : d + 'd';
    return '<span class="pill pill-sq pill-' + tone + '">' + label + '</span>';
  }
  function isOverBudget(p){ return p.allocation > 0 && p.committed > p.allocation; }
  function overBudgetPct(p){ return Math.round(((p.committed - p.allocation) / p.allocation) * 100); }

  function smartStatus(p){
    if (p.proposalStatus === 'RETURN') { return t('ssReturnPemohon'); }
    if (p.proposalStatus === 'REJECT') { return t('ssRejected'); }
    if (p.proposalStatus !== 'APPROVED') { return t('ssOnReview').replace(':unit', p.district.replace('District ', '')); }
    switch (p.workStatus) {
      case 'READY': return t('ssNeedAssign');
      case 'ASSIGN': return t('ssNeedStart');
      case 'KENDALA': return t('ssKendala').replace(':c', p.kendalaComment || '-');
      case 'DONE': return t('ssNeedReview');
      case 'COMPLETE': return p.reviewStatus === 'APPROVE_REKON' ? t('ssComplete') : t('ssNeedReview');
      case 'PROGRESS': return (p.lastLogDaysAgo || 0) >= 3 ? t('ssNeedUpdate') : t('ssOnProgress');
      default: return t('ssOnProgress');
    }
  }

  function fmtRp(n){ return 'Rp ' + n.toLocaleString('id-ID'); }

  /* ---------- summary filter cards ---------- */
  var activeFilter = null, currentPage = 1;
  var SUMMARY_DEFS = [
    { key: 'proposal', label: 'sProposal', test: function(p){ return ['SUBMIT', 'ON_REVIEW', 'BUDGET_REVIEW'].indexOf(p.proposalStatus) !== -1; } },
    { key: 'work', label: 'sWork', test: function(p){ return p.proposalStatus === 'APPROVED' && ['READY', 'ASSIGN', 'START', 'SURVEY', 'PROGRESS', 'KENDALA'].indexOf(p.workStatus) !== -1; } },
    { key: 'review', label: 'sReview', test: function(p){ return p.workStatus === 'DONE' || (p.workStatus === 'COMPLETE' && p.reviewStatus !== 'APPROVE_REKON'); } },
    { key: 'deadline', label: 'sDeadline', test: function(p){ var d = daysLeft(p); return d !== null && d <= 7 && p.workStatus !== 'COMPLETE'; } },
    { key: 'inbox', label: 'sInbox', test: function(p){ return p.requester === 'Reza Pratama' || (p.teknisi || '').indexOf('Reza Pratama') !== -1; } },
  ];

  function renderSummary(){
    document.getElementById('summaryGrid').innerHTML = SUMMARY_DEFS.map(function(s){
      var count = PROJECTS.filter(s.test).length;
      return '<div class="summary-card ' + (activeFilter === s.key ? 'on' : '') + '" data-summary="' + s.key + '">' +
        '<div class="num">' + count + '</div><div class="lbl">' + t(s.label) + '</div></div>';
    }).join('');
  }
  document.getElementById('summaryGrid').addEventListener('click', function(e){
    var c = e.target.closest('[data-summary]');
    if (!c) { return; }
    var key = c.dataset.summary;
    activeFilter = activeFilter === key ? null : key;
    currentPage = 1;
    renderAll();
  });

  /* ---------- grid + pagination ---------- */
  function getFiltered(){
    var q = document.getElementById('searchInput').value.trim().toLowerCase();
    var rows = PROJECTS.slice();
    if (activeFilter) { rows = rows.filter(SUMMARY_DEFS.filter(function(s){ return s.key === activeFilter; })[0].test); }
    if (q) {
      rows = rows.filter(function(p){
        return p.title.toLowerCase().indexOf(q) !== -1 || p.code.toLowerCase().indexOf(q) !== -1 || p.district.toLowerCase().indexOf(q) !== -1;
      });
    }
    return rows;
  }

  function renderGrid(){
    var rows = getFiltered();
    var perPage = parseInt(document.getElementById('perPage').value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    if (currentPage > totalPages) { currentPage = totalPages; }
    var start = (currentPage - 1) * perPage;
    var page = rows.slice(start, start + perPage);

    document.getElementById('qeGrid').innerHTML = page.length ? page.map(function(p){
      var overall = Math.round((p.proposalPct + p.workPct + p.reviewPct) / 3);
      var chips = '<span class="qe-chip">' + p.scope.replace('_', ' ') + '</span><span class="qe-chip">' + p.qeType + '</span>' +
        (p.program ? '<span class="qe-chip">' + p.program + '</span>' : '');
      var alerts = (isOverBudget(p) ? '<span class="pill pill-sq pill-red">' + t('overBudget').replace(':pct', overBudgetPct(p)) + '</span>' : '') + countdownPill(p);
      var canMulai = p.proposalStatus === 'APPROVED' && p.workStatus === 'ASSIGN';
      var canEdit = p.proposalStatus === 'RETURN';
      return '<div class="qe-card">' +
        '<div><div class="loc">' + p.district + ' · ' + p.code + '</div><div class="title">' + p.title + '</div></div>' +
        '<div class="qe-chips">' + chips + '</div>' +
        '<div class="status-row">' + statusPill('proposal', p.proposalStatus) + statusPill('work', p.workStatus) + statusPill('review', p.reviewStatus) + '</div>' +
        (alerts ? '<div class="status-row">' + alerts + '</div>' : '') +
        '<div class="progress-block"><div class="lbl"><span>' + t('pProposal') + ' / ' + t('pWork') + ' / ' + t('pReview') + '</span><span>' + overall + '%</span></div>' +
          '<div class="progress-track"><div class="progress-fill" style="width:' + overall + '%"></div></div></div>' +
        '<div class="meta-grid">' +
          '<div><b>' + p.inputAt + '</b> ' + t('lLokasi') + '</div><div><b>' + p.estFinish + '</b> ' + t('lEstSelesai') + '</div>' +
          '<div><b>' + p.jumlahAlpro + '</b> Alpro</div><div><b>' + p.lastUpdate + '</b> Update</div>' +
        '</div>' +
        '<div class="budget-row"><span>' + t('lProposed') + '</span><span class="v">' + fmtRp(p.proposed) + '</span></div>' +
        '<div class="budget-row"><span>' + t('lRealization') + '</span><span class="v">' + fmtRp(p.realization) + '</span></div>' +
        '<div class="card-foot">' +
          '<span class="smart-status">' + smartStatus(p) + '</span>' +
          '<div class="card-actions">' +
            '<button class="icon-btn" data-history="' + p.id + '" title="History">🕒</button>' +
            '<button class="icon-btn" data-detail="' + p.id + '" title="Detail">👁</button>' +
            (canMulai ? '<button class="icon-btn" data-mulai="' + p.id + '" title="Mulai Pekerjaan">▶</button>' : '') +
            (canEdit ? '<button class="icon-btn" data-edit="' + p.id + '" title="Edit">✎</button>' : '') +
            '<button class="icon-btn" data-delete="' + p.id + '" title="Delete">🗑</button>' +
          '</div>' +
        '</div>' +
      '</div>';
    }).join('') : '<div class="empty-state" style="grid-column:1/-1">' + t('noData') + '</div>';

    var from = rows.length ? start + 1 : 0, to = Math.min(start + perPage, rows.length);
    document.getElementById('pageInfo').textContent = from + '–' + to + ' ' + t('of') + ' ' + rows.length;
    var pager = document.getElementById('pager');
    pager.innerHTML = '';
    for (var p2 = 1; p2 <= totalPages; p2++) {
      var btn = document.createElement('button');
      btn.textContent = p2;
      if (p2 === currentPage) { btn.classList.add('on'); }
      (function(pp){ btn.addEventListener('click', function(){ currentPage = pp; renderGrid(); }); })(p2);
      pager.appendChild(btn);
    }
  }

  function renderAll(){ renderSummary(); renderGrid(); }

  document.getElementById('searchInput').addEventListener('input', function(){ currentPage = 1; renderGrid(); });
  document.getElementById('perPage').addEventListener('change', function(){ currentPage = 1; renderGrid(); });
  document.getElementById('refreshBtn').addEventListener('click', renderAll);
  document.getElementById('ajukanBtn').addEventListener('click', function(){ toast(t('ajukanToast')); });

  /* ---------- card actions ---------- */
  document.getElementById('qeGrid').addEventListener('click', function(e){
    var d = e.target.closest('[data-detail]'); if (d) { openDetail(parseInt(d.dataset.detail, 10)); return; }
    var h = e.target.closest('[data-history]'); if (h) { openHistory(parseInt(h.dataset.history, 10)); return; }
    var m = e.target.closest('[data-mulai]'); if (m) { openMulai(parseInt(m.dataset.mulai, 10)); return; }
    var ed = e.target.closest('[data-edit]'); if (ed) { toast(t('editToast')); return; }
    var del = e.target.closest('[data-delete]'); if (del) { toast(t('deleteToast')); return; }
  });

  function findProject(id){ return PROJECTS.filter(function(p){ return p.id === id; })[0]; }

  /* ---------- detail modal ---------- */
  var detailModal = document.getElementById('detailModal'), currentProject = null;
  function openDetail(id){
    currentProject = findProject(id);
    var p = currentProject;
    document.getElementById('detailTitle').textContent = p.title;
    document.getElementById('detailSubtitle').textContent = p.code + ' · ' + p.district;
    document.getElementById('dInfoGrid').innerHTML = kvHtml([
      [t('lProposal'), p.code], [t('lRequester'), p.requester], [t('lSto'), p.sto], [t('lAlasan'), p.alasan],
      [t('lEstLama'), p.estLamaHari + ' hari'], [t('lEstSelesai'), p.estFinish], [t('lKabel'), p.kabelArmoured + ' m'],
      [t('lTitik'), p.titikGangguan], [t('lScope'), p.scope], [t('lType'), p.qeType], [t('lProgram'), p.program || '-'],
      [t('lTeknisi'), p.teknisi], [t('lPanjangKabel'), p.panjangKabel + ' m'],
    ]);
    document.getElementById('dProgress').innerHTML =
      ['proposal', 'work', 'review'].map(function(track){
        var code = track === 'proposal' ? p.proposalStatus : track === 'work' ? p.workStatus : p.reviewStatus;
        var pct = track === 'proposal' ? p.proposalPct : track === 'work' ? p.workPct : p.reviewPct;
        return '<div class="progress-block"><div class="lbl"><span>' + t('p' + track.charAt(0).toUpperCase() + track.slice(1)) + ' — ' + statusPill(track, code) + '</span><span>' + pct + '%</span></div>' +
          '<div class="progress-track"><div class="progress-fill" style="width:' + pct + '%"></div></div></div>';
      }).join('');
    var alproRows = [];
    for (var i = 0; i < p.jumlahAlpro && i < 5; i++) { alproRows.push({ jenis: i % 2 === 0 ? 'ODP' : 'ODC', nama: ALPRO_SAMPLE[i % ALPRO_SAMPLE.length] }); }
    document.getElementById('dAlproBody').innerHTML = alproRows.length ? alproRows.map(function(a){ return '<tr><td>' + a.jenis + '</td><td>' + a.nama + '</td></tr>'; }).join('')
      : '<tr><td colspan="2" style="text-align:center;color:var(--muted)">-</td></tr>';
    var docRows = p.proposalStatus === 'SUBMIT' || p.proposalStatus === 'ON_REVIEW' ? [] : DOC_SAMPLE.slice(0, (p.id % 4) + 1);
    document.getElementById('dDokumenList').innerHTML = docRows.length
      ? docRows.map(function(d){ return '<div style="display:flex;justify-content:space-between;padding:5px 0;border-top:1px solid var(--border)"><span>' + d + '</span><button type="button" class="link-btn2" data-doc-toast>' + t('docLihat') + '</button></div>'; }).join('')
      : '<span class="hint-muted">' + t('noDocs') + '</span>';
    document.getElementById('dBudgetGrid').innerHTML = kvHtml([
      [t('lProposed'), fmtRp(p.proposed)], [t('lAllocation'), fmtRp(p.allocation)],
      [t('lRealization'), fmtRp(p.realization)], [t('lCommitted'), fmtRp(p.committed)],
      [t('lAvailable'), fmtRp(Math.max(0, p.allocation - p.committed))],
    ]);

    renderApprovalSection('usulan', p);
    renderApprovalSection('rekon', p);
    detailModal.classList.add('show');
  }
  detailModal.addEventListener('click', function(e){ if (e.target.closest('[data-doc-toast]')) { toast(t('docToast')); } });

  function renderApprovalSection(kind, p){
    var isUsulan = kind === 'usulan';
    var stageCode = isUsulan ? p.proposalStatus : p.reviewStatus;
    var track = isUsulan ? 'proposal' : 'review';
    document.getElementById(isUsulan ? 'accUsulanStage' : 'accRekonStage').innerHTML = statusPill(track, stageCode);
    var reviewers = isUsulan
      ? [{ name: 'Ulsyairil', role: 'Team Leader', done: p.proposalPct >= 40 }, { name: 'Kepala District', role: 'District Head', done: p.proposalPct >= 70 }]
      : [{ name: 'Ulsyairil', role: 'Team Leader', done: p.reviewPct >= 50 }, { name: 'Rekon Reviewer', role: 'Regional', done: p.reviewPct >= 100 }];
    var body = document.getElementById(isUsulan ? 'usulanReviewers' : 'rekonReviewers');
    body.innerHTML = reviewers.map(function(r){
      return '<div class="reviewer-row"><span>' + r.name + '<br /><span class="hint-muted">' + r.role + '</span></span>' +
        '<span class="pill pill-sq ' + (r.done ? 'pill-green' : 'pill-gray') + '">' + (r.done ? t('stApproved') : t('stSubmit')) + '</span></div>';
    }).join('');

    var canAct = isUsulan
      ? ['SUBMIT', 'ON_REVIEW', 'BUDGET_REVIEW'].indexOf(p.proposalStatus) !== -1
      : p.workStatus === 'DONE' && p.reviewStatus !== 'APPROVE_REKON';
    var actionsEl = document.getElementById(isUsulan ? 'usulanActions' : 'rekonActions');
    actionsEl.innerHTML = canAct
      ? '<button class="mini-btn teal" data-act="approve" data-kind="' + kind + '">' + t('btnApprove') + '</button>' +
        '<button class="mini-btn red" data-act="reject" data-kind="' + kind + '">' + t('btnReject') + '</button>' +
        '<button class="mini-btn amber" data-act="return" data-kind="' + kind + '">' + t('btnReturn') + '</button>'
      : '<span class="hint-muted">' + t('noAction') + '</span>';
  }

  var reasonModal = document.getElementById('reasonModal'), pendingAction = null;
  detailModal.addEventListener('click', function(e){
    var b = e.target.closest('[data-act]');
    if (!b) { return; }
    var action = b.dataset.act, kind = b.dataset.kind;
    if (action === 'approve') {
      applyApproval(kind, 'approve', null);
      return;
    }
    pendingAction = { kind: kind, action: action };
    document.getElementById('reasonTitle').textContent = action === 'reject' ? t('rejectTitle') : t('returnTitle');
    document.getElementById('reasonNote').value = '';
    document.getElementById('reasonErr').style.display = 'none';
    reasonModal.classList.add('show');
  });
  document.getElementById('reasonOk').addEventListener('click', function(){
    var note = document.getElementById('reasonNote').value.trim();
    if (!note) { document.getElementById('reasonErr').style.display = 'block'; return; }
    reasonModal.classList.remove('show');
    applyApproval(pendingAction.kind, pendingAction.action, note);
  });
  document.getElementById('reasonCancel').addEventListener('click', function(){ reasonModal.classList.remove('show'); });
  document.getElementById('reasonX').addEventListener('click', function(){ reasonModal.classList.remove('show'); });

  function applyApproval(kind, action, note){
    var p = currentProject;
    if (kind === 'usulan') {
      if (action === 'approve') { p.proposalStatus = 'APPROVED'; p.proposalPct = 100; p.allocation = p.proposed; p.workStatus = 'ASSIGN'; p.workPct = 10; }
      if (action === 'reject') { p.proposalStatus = 'REJECT'; p.rejectNote = note; }
      if (action === 'return') { p.proposalStatus = 'RETURN'; p.returnNote = note; }
    } else {
      if (action === 'approve') { p.reviewStatus = 'APPROVE_REKON'; p.reviewPct = 100; p.workStatus = 'COMPLETE'; }
      if (action === 'reject') { p.reviewStatus = 'REJECT'; p.rejectNote = note; }
      if (action === 'return') { p.reviewStatus = 'RETURN'; p.returnNote = note; }
    }
    toast(p.code + (action === 'approve' ? t('toastApprove') : action === 'reject' ? t('toastReject') : t('toastReturn')));
    renderApprovalSection(kind, p);
    renderAll();
  }
  document.getElementById('detailClose').addEventListener('click', function(){ detailModal.classList.remove('show'); });
  document.getElementById('detailDone').addEventListener('click', function(){ detailModal.classList.remove('show'); });

  /* ---------- mulai pekerjaan dialog ---------- */
  var mulaiModal = document.getElementById('mulaiModal'), mulaiTarget = null;
  document.getElementById('mulaiTeknisi').innerHTML = TEKNISI_POOL.map(function(nm){ return '<label><input type="checkbox" value="' + nm + '" /> ' + nm + '</label>'; }).join('');
  function openMulai(id){
    mulaiTarget = findProject(id);
    document.getElementById('mulaiNote').value = '';
    Array.prototype.forEach.call(document.querySelectorAll('#mulaiTeknisi input'), function(c){ c.checked = false; });
    mulaiModal.classList.add('show');
  }
  document.getElementById('mulaiOk').addEventListener('click', function(){
    var picked = Array.prototype.slice.call(document.querySelectorAll('#mulaiTeknisi input:checked')).map(function(c){ return c.value; });
    mulaiModal.classList.remove('show');
    mulaiTarget.workStatus = 'START'; mulaiTarget.workPct = 30;
    mulaiTarget.teknisi = picked.length ? picked.join(', ') : '-';
    toast(mulaiTarget.code + t('mulaiToast'));
    renderAll();
  });
  document.getElementById('mulaiCancel').addEventListener('click', function(){ mulaiModal.classList.remove('show'); });
  document.getElementById('mulaiX').addEventListener('click', function(){ mulaiModal.classList.remove('show'); });

  /* ---------- history drawer ---------- */
  var historyDrawer = document.getElementById('historyDrawer');
  function openHistory(id){
    var p = findProject(id);
    var logs = [
      { t: p.inputAt, m: 'Project diajukan oleh ' + p.requester + '.' },
      { t: p.inputAt, m: 'Status usulan: ' + statusLabel('proposal', p.proposalStatus) + '.' },
    ];
    if (p.workStatus !== 'READY') { logs.push({ t: p.lastUpdate, m: 'Status pekerjaan: ' + statusLabel('work', p.workStatus) + '.' }); }
    if (p.kendalaComment) { logs.push({ t: p.lastUpdate, m: 'Kendala: ' + p.kendalaComment }); }
    if (p.returnNote) { logs.push({ t: p.lastUpdate, m: 'Return: ' + p.returnNote }); }
    if (p.rejectNote) { logs.push({ t: p.lastUpdate, m: 'Reject: ' + p.rejectNote }); }
    document.getElementById('historyBody').innerHTML = logs.map(function(l){ return '<div class="log-item"><div class="t">' + l.t + '</div>' + l.m + '</div>'; }).join('');
    historyDrawer.classList.add('show');
  }
  document.getElementById('historyClose').addEventListener('click', function(){ historyDrawer.classList.remove('show'); });
  historyDrawer.addEventListener('click', function(e){ if (e.target === historyDrawer) { historyDrawer.classList.remove('show'); } });

  function onLangChange(){ renderAll(); }
  renderAll();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeProjectTour = {
    id: 'tifreg-qe-project',
    steps: [
      {
        target: '.sidebar nav',
        pos: 'right',
        title: { id: 'Navigasi Modul QE', en: 'QE Module Navigation' },
        desc: {
          id: 'Modul Quality Enhancement (QE) terdiri dari List Project (manajemen siklus proyek lapangan) dan Anggaran (pengelolaan kontrak & alokasi dana).',
          en: 'The Quality Enhancement (QE) suite consists of List Project (field project lifecycle) and Anggaran (budget contracts & fund distribution).'
        }
      },
      {
        target: '#ajukanBtn',
        pos: 'bottom',
        title: { id: 'Pengajuan Proyek QE Baru', en: 'Submit New QE Project' },
        desc: {
          id: 'Klik tombol ini untuk membuka formulir pengajuan proyek QE baru, menentukan tipe program (Preventif/Kuratif), distrik, target segmen jaringan, dan estimasi BOQ material.',
          en: 'Click to open the new QE submission form to set program type (Preventive/Curative), district, network segment targets, and estimated material BOQ.'
        }
      },
      {
        target: '#summaryGrid',
        pos: 'bottom',
        title: { id: 'Kartu Ringkasan Status Proyek', en: 'Project Status Summary Cards' },
        desc: {
          id: 'Metrik total proyek berdasarkan tahapan siklus: ALL, DRAFT, SUBMIT (menunggu review), PROGRESS (sedang dikerjakan teknisi), dan FINISH (rekon & approval selesai). Klik kartu untuk memfilter.',
          en: 'Total project metrics across lifecycle stages: ALL, DRAFT, SUBMIT (pending review), PROGRESS (underway by technicians), and FINISH (reconciliation approved). Click any card to filter.'
        }
      },
      {
        target: '#qeToolbarRow',
        pos: 'bottom',
        title: { id: 'Pencarian & Kontrol Tampilan', en: 'Search & Display Controls' },
        desc: {
          id: 'Cari cepat berdasarkan nama proyek, nomor kode proyek, atau distrik, serta sesuaikan jumlah kartu proyek yang ditampilkan per halaman.',
          en: 'Search quickly by project name, project code number, or district, and adjust the number of project cards shown per page.'
        }
      },
      {
        target: '#qeGrid .qe-card:first-child',
        pos: 'top',
        title: { id: 'Kartu Proyek QE & Progres Pengerjaan', en: 'QE Project Card & Work Progress' },
        desc: {
          id: 'Memuat kode proyek, distrik, target volume, tracking progress usulan & fisik teknisi, nilai anggaran, dan status smart label terintegrasi.',
          en: 'Displays project code, district, target volumes, approval & physical progress bars, budget value, and smart status badges.'
        }
      },
      {
        target: '#qeGrid .qe-card:first-child .card-actions',
        pos: 'top',
        title: { id: 'Tombol Aksi Cepat Proyek', en: 'Quick Project Action Buttons' },
        desc: {
          id: 'Ikon aksi untuk: <b>Detail</b> (rincian BOQ, foto evidens sebelum/sesudah, dan approval TL/QE), <b>Mulai Pekerjaan</b> (penugasan tim teknisi), dan <b>Riwayat</b> log timeline.',
          en: 'Action icons to: inspect <b>Detail</b> (BOQ breakdown, before/after evidence photos, and TL/QE approval), <b>Start Work</b> (assign field technicians), and view <b>History</b> logs.'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(qeProjectTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
