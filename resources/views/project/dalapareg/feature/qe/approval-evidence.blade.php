<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Approval Evidence — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .headline{max-width:250px;white-space:normal;line-height:1.45}
  .lop{max-width:190px;white-space:normal;line-height:1.45;color:var(--muted);font-size:11.5px}
  .hist-item{padding:9px 0;border-bottom:1px solid var(--border);font-size:12px}
  .hist-item:last-child{border-bottom:none}
  .hist-item .t{color:var(--muted);font-size:11px}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-approval-evidence'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Approval Evidence</span></div>
    <h1 data-i18n="pageTitle">Approval Evidence</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="filter-bar">
        <div class="field">
          <label data-i18n="status">Status</label>
          <select id="fStatus">
            <option value="" data-i18n="allStatus">All Status</option>
            <option value="APPROVE_TL">APPROVE TL</option>
            <option value="PENDING_TL">PENDING TL</option>
            <option value="APPROVE_QE">APPROVE QE</option>
            <option value="PENDING_QE">PENDING QE</option>
          </select>
        </div>
        <div class="field wide"><label>Distrik</label><select id="fDistrict"></select></div>
        <div class="field wide"><label>Mitra</label><select id="fMitra"></select></div>
        <div class="field"><label data-i18n="date">Tanggal</label><input type="date" id="fStart" value="2026-09-01" /></div>
        <div class="field"><label data-i18n="until">Sampai</label><input type="date" id="fEnd" value="2026-09-30" /></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="tableTitle">Data Evidence Workorder</h3>
        <span class="last-update" id="summary"></span>
      </div>
      <div class="table-toolbar">
        <select id="perPage"><option value="8">8 / halaman</option><option value="15">15 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari tiket / headline / teknisi..." />
      </div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th>Distrik</th><th>Headline</th><th data-i18n="cTicketNo">No Ticket</th><th data-i18n="cLop">Sub Pekerjaan (LOP)</th>
              <th data-i18n="status">Status</th><th>Mitra</th>
              <th data-i18n="cTechDate">Tanggal Update Teknisi</th><th data-i18n="cTech">Teknisi</th>
              <th data-i18n="cTlDate">Tanggal Update TL</th><th data-i18n="cQeDate">Tanggal Update QE</th>
              <th class="num" data-i18n="cTotalBoq">Total BOQ</th><th data-i18n="cAction">Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
    </div>
  </div>
</main>

<!-- DETAIL -->
<div class="modal-backdrop" id="woModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 id="woTitle">Informasi</h3><button class="modal-close" id="woX">✕</button></div>
    <div class="tabs">
      <button class="on" data-tab="#woData" data-i18n="tabWo">Data Workorder</button>
      <button data-tab="#woUraian" data-i18n="tabUraian">Uraian Pekerjaan</button>
      <button data-tab="#woRuas" data-i18n="tabRuas">Ruas QE</button>
      <button data-tab="#woEvidence" data-i18n="tabEvidence">Evidence</button>
    </div>
    <div class="modal-body">
      <div id="woData">
        <div class="kv-grid" id="woGrid"></div>
        <div style="margin-top:12px"><button class="btn-outline" id="histBtn" data-i18n="checkHistory">Check History Pending</button></div>
      </div>
      <div id="woUraian" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr><th>Designator</th><th data-i18n="cJob">Nama Pekerjaan</th>
                <th class="num" data-i18n="cHargaMaterial">Harga Material</th><th class="num" data-i18n="cHargaJasa">Harga Jasa</th>
                <th class="num" data-i18n="cQty">Kuantitas</th><th data-i18n="cSatuan">Satuan</th><th class="num" data-i18n="total">Total</th></tr>
            </thead>
            <tbody id="uraianBody"></tbody>
            <tfoot><tr class="total-row" id="uraianTotals"></tr></tfoot>
          </table>
        </div>
      </div>
      <div id="woRuas" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead><tr><th>ALPRO</th><th data-i18n="cAlproName">Alpro Name</th><th>STO</th><th data-i18n="cCoord">Koordinat</th></tr></thead>
            <tbody id="ruasBody"></tbody>
          </table>
        </div>
      </div>
      <div id="woEvidence" hidden>
        <div class="evidence-row" id="evidenceRow"></div>
        <p class="hint-muted" style="margin-top:10px" data-i18n="evHint">Approve evidence bila foto before/after sudah sesuai dengan uraian pekerjaan.</p>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="woClose" data-i18n="close">Tutup</button>
      <button class="btn-outline warn" id="woPending" data-i18n="pending">Pending</button>
      <button class="btn-success" id="woApprove" data-i18n="approveEv">Approve Evidence</button>
    </div>
  </div>
</div>

<!-- HISTORY PENDING -->
<div class="modal-backdrop" id="histModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="histTitle">History Pending</h3><button class="modal-close" id="histX">✕</button></div>
    <div class="modal-body"><div id="histBody"></div></div>
    <div class="modal-foot"><button class="btn-outline warn" id="histClose" data-i18n="back">Kembali</button></div>
  </div>
</div>

<!-- PENDING REASON -->
<div class="modal-backdrop" id="pendingModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="pendingTitle">Pending Evidence</h3><button class="modal-close" id="pendingX">✕</button></div>
    <div class="modal-body">
      <div class="field">
        <label data-i18n="pendingReason">Alasan Pending</label>
        <textarea id="pendingNote" rows="4" data-i18n-ph="pendingPh" placeholder="Contoh: foto after tidak menampilkan label ODP."></textarea>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="pendingCancel" data-i18n="cancel">Batal</button>
      <button class="btn-danger" id="pendingOk" data-i18n="savePending">Simpan Pending</button>
    </div>
  </div>
</div>

@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    pageTitle: 'Approval Evidence', tableTitle: 'Data Evidence Workorder', allStatus: 'All Status', until: 'Sampai',
    searchPh: 'Cari tiket / headline / teknisi...',
    cTicketNo: 'No Ticket', cLop: 'Sub Pekerjaan (LOP)', cTechDate: 'Tanggal Update Teknisi', cTech: 'Teknisi',
    cTlDate: 'Tanggal Update TL', cQeDate: 'Tanggal Update QE', cTotalBoq: 'Total BOQ', cAction: 'Action',
    summary: '{n} workorder · {e} evidence siap direview',
    tabWo: 'Data Workorder', tabUraian: 'Uraian Pekerjaan', tabRuas: 'Ruas QE', tabEvidence: 'Evidence',
    cJob: 'Nama Pekerjaan', cHargaMaterial: 'Harga Material', cHargaJasa: 'Harga Jasa', cQty: 'Kuantitas',
    cSatuan: 'Satuan', cAlproName: 'Alpro Name', cCoord: 'Koordinat',
    checkHistory: 'Check History Pending', histTitle: 'History Pending', back: 'Kembali',
    approveEv: 'Approve Evidence', pendingTitle: 'Pending Evidence', pendingReason: 'Alasan Pending',
    pendingPh: 'Contoh: foto after tidak menampilkan label ODP.', savePending: 'Simpan Pending',
    evHint: 'Approve evidence bila foto before/after sudah sesuai dengan uraian pekerjaan.',
    kDistrict: 'Distrik', kSto: 'STO', kHeadline: 'Headline', kTicket: 'Ticket', kPenyebab: 'Penyebab',
    kLat: 'Latitude / Longitude', kRuas: 'Ruas', kDetail: 'Detail', kMitra: 'Mitra', kTeam: 'Nama Tim',
    kTech: 'Teknisi', kStatus: 'Status Workorder', kTechDate: 'Tanggal Update Teknisi', kTlDate: 'Tanggal Update TL',
    kQeDate: 'Tanggal Update QE', kTotalBoq: 'Total BOQ', kNote: 'Catatan Terakhir',
    evBefore: 'Evidence Before', evAfter: 'Evidence After',
    approved: 'Evidence workorder disetujui.', pended: 'Evidence ditandai pending, teknisi diminta unggah ulang.',
    needReason: 'Alasan pending wajib diisi.', alreadyDone: 'Evidence workorder ini sudah diproses.',
    noHistory: 'Belum pernah di-pending.',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  /* evidence review only makes sense once a technician has completed the job */
  var POOL = WOS.filter(function(w){ return rank(w.status) >= 2 && w.status !== 'PENDING'; });

  var fStatus = document.getElementById('fStatus'), fDistrict = document.getElementById('fDistrict'),
      fMitra = document.getElementById('fMitra'), fStart = document.getElementById('fStart'),
      fEnd = document.getElementById('fEnd'), perPage = document.getElementById('perPage'),
      searchInput = document.getElementById('searchInput');
  fillSelect(fDistrict, DISTRICTS, 'All Distrik');
  fillSelect(fMitra, MITRA, 'All Mitra');

  var currentPage = 1;
  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return POOL.filter(function(w){
      if (fStatus.value && w.status !== fStatus.value) { return false; }
      if (fDistrict.value && w.district !== fDistrict.value) { return false; }
      if (fMitra.value && w.mitra !== fMitra.value) { return false; }
      if (fStart.value && w.tglListing < fStart.value) { return false; }
      if (fEnd.value && w.tglListing > fEnd.value) { return false; }
      if (q && (w.ticket + ' ' + w.headline + ' ' + w.teknisi + ' ' + w.lop).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderTable(){
    var rows = getFiltered();
    var res = paginate(rows, currentPage, parseInt(perPage.value, 10), function(p){ currentPage = p; renderTable(); });
    currentPage = res.page;
    document.getElementById('tbody').innerHTML = res.slice.length ? res.slice.map(function(w){
      return '<tr><td>' + w.district + '</td><td class="headline">' + w.headline + '</td>' +
        '<td class="mono-cell">' + w.ticket + '</td><td class="lop">' + w.lop + '</td>' +
        '<td>' + statusPill(w.status) + '</td><td>' + w.mitra + '</td>' +
        '<td>' + (w.tglTeknisi || '-') + '</td><td>' + w.teknisi + '</td>' +
        '<td>' + (w.tglTl || '-') + '</td><td>' + (w.tglQe || '-') + '</td>' +
        '<td class="num">' + rupiah(woTotal(w)) + '</td>' +
        '<td><button class="mini-btn brand" data-open="' + w.id + '">' + t('detail') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="12" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    var reviewable = rows.filter(canReview).length;
    document.getElementById('summary').textContent = t('summary').replace('{n}', rows.length).replace('{e}', reviewable);
  }
  function canReview(w){ return w.status === 'APPROVE_TL' || w.status === 'PENDING_QE'; }

  [fStatus, fDistrict, fMitra, fStart, fEnd, perPage].forEach(function(el){
    el.addEventListener('change', function(){ currentPage = 1; renderTable(); });
  });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });

  /* ---------- detail ---------- */
  var woModal = document.getElementById('woModal'), activeWo = null;

  function renderWo(){
    var w = activeWo;
    document.getElementById('woTitle').textContent = w.ticket + ' — ' + w.lop;
    document.getElementById('woGrid').innerHTML = kvHtml([
      [t('kDistrict'), w.district], [t('kSto'), w.sto], [t('kTicket'), w.ticket],
      [t('kHeadline'), w.headline], [t('kPenyebab'), w.penyebab], [t('kLat'), w.koordinat],
      [t('kRuas'), w.lines.length + ' ruas'], [t('kDetail'), w.pekerjaan],
      [t('kMitra'), w.mitra], [t('kTeam'), w.team], [t('kTech'), w.teknisi],
      [t('kStatus'), statusPill(w.status)],
      [t('kTechDate'), w.tglTeknisi || '-'], [t('kTlDate'), w.tglTl || '-'], [t('kQeDate'), w.tglQe || '-'],
      [t('kTotalBoq'), rupiah(woTotal(w))], [t('kNote'), w.note || '-'],
    ]);

    document.getElementById('uraianBody').innerHTML = w.lines.map(function(l){
      return '<tr><td class="mono-cell">' + l.khs.d + '</td><td>' + l.khs.u + '</td>' +
        '<td class="num">' + rupiah(l.khs.m) + '</td><td class="num">' + rupiah(l.khs.j) + '</td>' +
        '<td class="num">' + l.qty + '</td><td>' + l.khs.s + '</td>' +
        '<td class="num">' + rupiah((l.khs.m + l.khs.j) * l.qty) + '</td></tr>';
    }).join('');
    document.getElementById('uraianTotals').innerHTML = '<td colspan="6">' + t('total') + '</td><td class="num">' + rupiah(woTotal(w)) + '</td>';

    document.getElementById('ruasBody').innerHTML = w.lines.map(function(l, idx){
      return '<tr><td class="mono-cell">ODP-' + w.ticket.slice(-4) + '-' + String(idx + 1).padStart(2, '0') + '</td>' +
        '<td>' + l.khs.u + '</td><td>' + w.sto + '</td><td class="mono-cell">' + w.koordinat + '</td></tr>';
    }).join('');

    document.getElementById('evidenceRow').innerHTML = [
      ['evBefore', '/images/dalapa/evidence/odp-before.svg'],
      ['evAfter', '/images/dalapa/evidence/odp-after.svg'],
    ].map(function(e){
      return '<div class="evidence-item"><div class="k">' + t(e[0]) + '</div>' +
        '<button type="button" class="thumb" data-lightbox="' + e[1] + '" data-caption="' + w.ticket + ' — ' + t(e[0]) + '">' +
        '<img src="' + e[1] + '" alt="" /></button></div>';
    }).join('');

    var locked = !canReview(w);
    document.getElementById('woApprove').disabled = locked;
    document.getElementById('woPending').disabled = locked;
  }

  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-open]');
    if (!b) { return; }
    activeWo = WOS.filter(function(w){ return w.id === parseInt(b.dataset.open, 10); })[0];
    renderWo();
    woModal.classList.add('show');
  });
  document.getElementById('evidenceRow').addEventListener('click', function(e){
    var b = e.target.closest('[data-lightbox]');
    if (b) { openLightbox(b.dataset.lightbox, b.dataset.caption); }
  });
  ['woX', 'woClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ woModal.classList.remove('show'); });
  });

  /* ---------- history pending ---------- */
  var histModal = document.getElementById('histModal');
  document.getElementById('histBtn').addEventListener('click', function(){
    var w = activeWo;
    var items = [];
    if (w.note) { items.push({ t: w.tglTl || w.tglTeknisi, m: w.note }); }
    if (w.status === 'PENDING_QE') { items.push({ t: w.tglQe || w.tglTl, m: 'Evidence dikembalikan oleh AMQE untuk diperbaiki.' }); }
    document.getElementById('histBody').innerHTML = items.length
      ? items.map(function(h){ return '<div class="hist-item"><div class="t">' + h.t + '</div>' + h.m + '</div>'; }).join('')
      : '<p class="hint-muted">' + t('noHistory') + '</p>';
    histModal.classList.add('show');
  });
  ['histX', 'histClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ histModal.classList.remove('show'); });
  });

  /* ---------- approve / pending ---------- */
  document.getElementById('woApprove').addEventListener('click', function(){
    if (!canReview(activeWo)) { toast(t('alreadyDone')); return; }
    activeWo.status = 'APPROVE_QE';
    activeWo.tglQe = stamp();
    activeWo.note = '';
    renderWo();
    renderTable();
    woModal.classList.remove('show');
    toast(t('approved'));
  });

  var pendingModal = document.getElementById('pendingModal');
  document.getElementById('woPending').addEventListener('click', function(){
    if (!canReview(activeWo)) { toast(t('alreadyDone')); return; }
    document.getElementById('pendingNote').value = '';
    pendingModal.classList.add('show');
  });
  ['pendingX', 'pendingCancel'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ pendingModal.classList.remove('show'); });
  });
  document.getElementById('pendingOk').addEventListener('click', function(){
    var note = document.getElementById('pendingNote').value.trim();
    if (!note) { toast(t('needReason')); return; }
    activeWo.status = 'PENDING_QE';
    activeWo.note = note;
    activeWo.tglQe = stamp();
    pendingModal.classList.remove('show');
    renderWo();
    renderTable();
    woModal.classList.remove('show');
    toast(t('pended'));
  });

  renderTable();
  applyLang();
</script>
</body>
</html>
