<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Approval TL — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .num{text-align:right;font-variant-numeric:tabular-nums}
  th.num{text-align:right}
  .qty-input{width:68px;height:28px;border:1px solid var(--border);border-radius:4px;background:transparent;
    color:var(--text);font-family:inherit;font-size:12px;padding:0 6px;text-align:right}
  .headline{max-width:260px;white-space:normal;line-height:1.45}
  .lop{max-width:220px;white-space:normal;line-height:1.45;color:var(--muted);font-size:11.5px}
  .boq-total{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:12px 14px;margin-top:12px;
    border:1px solid var(--border);border-radius:4px;background:var(--gray-50);font-size:13px}
  .boq-total b{font-size:16px}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-approval-tl'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Approval TL</span></div>
    <h1 data-i18n="pageTitle">Approval TL</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="filter-bar">
        <div class="field narrow"><label data-i18n="month">Bulan</label><select id="fMonth"></select></div>
        <div class="field narrow"><label data-i18n="year">Tahun</label><select id="fYear"><option>2026</option><option>2025</option></select></div>
        <div class="field wide"><label>Distrik</label><select id="fDistrict"><option value="" data-i18n="all">Semua</option></select></div>
        <div class="field wide"><label>Mitra</label><select id="fMitra"><option value="" data-i18n="all">Semua</option></select></div>
        <div class="field wide">
          <label data-i18n="status">Status</label>
          <select id="fStatus">
            <option value="" data-i18n="all">Semua</option>
            <option value="WAITING" data-i18n="stWaiting">MENUNGGU APPROVAL TL</option>
            <option value="APPROVED" data-i18n="stApproved">APPROVED TL</option>
            <option value="PENDING" data-i18n="stPending">PENDING</option>
          </select>
        </div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="tableTitle">Data Workorder Menunggu Approval</h3>
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
              <th>Distrik</th><th data-i18n="cTicket">Tiket</th><th>Headline</th>
              <th data-i18n="cLop">Sub pekerjaan (LOP)</th><th data-i18n="status">Status</th><th>Mitra</th>
              <th data-i18n="cTechDate">Tanggal Update Teknisi</th><th data-i18n="cTech">Teknisi</th>
              <th data-i18n="cTlDate">Tanggal Update TL</th>
              <th class="num" data-i18n="cTotalBoq">Total BOQ</th>
              <th data-i18n="cAction">Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
    </div>
  </div>
</main>

<!-- WORKORDER DETAIL -->
<div class="modal-backdrop" id="woModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 id="woTitle">Informasi</h3><button class="modal-close" id="woX">✕</button></div>
    <div class="tabs" id="woTabs">
      <button class="on" data-tab="#woData" data-i18n="tabWo">Data Workorder</button>
      <button data-tab="#woUraian" data-i18n="tabUraian">Uraian Pekerjaan</button>
      <button data-tab="#woRuas" data-i18n="tabRuas">Ruas QE</button>
      <button data-tab="#woEvidence" data-i18n="tabEvidence">Evidence</button>
    </div>
    <div class="modal-body">
      <div id="woData"><div class="kv-grid" id="woGrid"></div></div>

      <div id="woUraian" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead>
              <tr>
                <th>Designator</th><th data-i18n="cJobName">Nama Pekerjaan</th>
                <th class="num" data-i18n="cHargaMaterial">Harga Material</th>
                <th class="num" data-i18n="cHargaJasa">Harga Jasa</th>
                <th class="num" data-i18n="cQty">Kuantitas</th>
                <th data-i18n="cSatuan">Satuan</th>
                <th class="num" data-i18n="cTotal">Total</th>
                <th data-i18n="cAction">Action</th>
              </tr>
            </thead>
            <tbody id="uraianBody"></tbody>
          </table>
        </div>
        <div class="boq-total">
          <span data-i18n="totalBoqLabel">Total BOQ Workorder</span>
          <b id="uraianTotal">Rp 0</b>
        </div>
        <p class="hint-muted" style="margin-top:8px" data-i18n="uraianHint">TL dapat mengoreksi kuantitas atau menghapus baris sebelum menyetujui BOQ.</p>
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
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="woClose" data-i18n="close">Tutup</button>
      <button class="btn-outline warn" id="woPending" data-i18n="setPending">Pending</button>
      <button class="btn-success" id="woApprove" data-i18n="approve">Approve TL</button>
    </div>
  </div>
</div>

<!-- PENDING REASON -->
<div class="modal-backdrop" id="pendingModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="pendingTitle">Pending Workorder</h3><button class="modal-close" id="pendingX">✕</button></div>
    <div class="modal-body">
      <div class="field">
        <label data-i18n="pendingReason">Alasan Pending</label>
        <textarea id="pendingNote" rows="4" data-i18n-ph="pendingPh" placeholder="Contoh: evidence after belum sesuai, volume kabel melebihi KHS."></textarea>
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
    pageTitle: 'Approval TL', month: 'Bulan', year: 'Tahun', status: 'Status',
    stWaiting: 'MENUNGGU APPROVAL TL', stApproved: 'APPROVED TL', stPending: 'PENDING',
    tableTitle: 'Data Workorder Menunggu Approval', searchPh: 'Cari tiket / headline / teknisi...',
    cTicket: 'Tiket', cLop: 'Sub pekerjaan (LOP)', cTechDate: 'Tanggal Update Teknisi', cTech: 'Teknisi',
    cTlDate: 'Tanggal Update TL', cTotalBoq: 'Total BOQ', cAction: 'Action',
    summary: '{w} menunggu · {a} approved · {p} pending',
    tabWo: 'Data Workorder', tabUraian: 'Uraian Pekerjaan', tabRuas: 'Ruas QE', tabEvidence: 'Evidence',
    cJobName: 'Nama Pekerjaan', cHargaMaterial: 'Harga Material', cHargaJasa: 'Harga Jasa',
    cQty: 'Kuantitas', cSatuan: 'Satuan', cTotal: 'Total', cAlproName: 'Alpro Name', cCoord: 'Koordinat',
    totalBoqLabel: 'Total BOQ Workorder',
    uraianHint: 'TL dapat mengoreksi kuantitas atau menghapus baris sebelum menyetujui BOQ.',
    setPending: 'Pending', approve: 'Approve TL', delete: 'Hapus',
    pendingTitle: 'Pending Workorder', pendingReason: 'Alasan Pending',
    pendingPh: 'Contoh: evidence after belum sesuai, volume kabel melebihi KHS.',
    savePending: 'Simpan Pending',
    kDistrict: 'Distrik', kSto: 'STO', kTicket: 'Nomor Tiket', kHeadline: 'Headline', kLop: 'Sub Pekerjaan (LOP)',
    kProject: 'Project', kMitra: 'Mitra', kTeam: 'Nama Tim', kTech: 'Teknisi',
    kCompDate: 'Tanggal Complete Teknisi', kTlDate: 'Tanggal Update TL', kStatus: 'Status Workorder',
    kTotalBoq: 'Total BOQ', kNote: 'Catatan TL',
    evBefore: 'Evidence Before', evAfter: 'Evidence After',
    approved: 'Workorder disetujui TL.', pended: 'Workorder ditandai pending.',
    needReason: 'Alasan pending wajib diisi.', rowRemoved: 'Baris uraian dihapus.',
    alreadyDone: 'Workorder ini sudah diproses.',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  /* TL only ever sees workorders a technician has completed */
  var POOL = WOS.filter(function(w){ return rank(w.status) >= 2 && w.status !== 'PENDING'; });
  /* the page's own three buckets, mapped onto the shared workorder ladder */
  var BUCKET = {
    WAITING: function(w){ return w.status === 'COMPLETE'; },
    APPROVED: function(w){ return rank(w.status) >= 3; },
    PENDING: function(w){ return w.status === 'PENDING_TL'; },
  };
  function bucketOf(w){
    return BUCKET.WAITING(w) ? 'WAITING' : BUCKET.PENDING(w) ? 'PENDING' : 'APPROVED';
  }

  /* ---------- filters ---------- */
  var fMonth = document.getElementById('fMonth'), fYear = document.getElementById('fYear'),
      fDistrict = document.getElementById('fDistrict'), fMitra = document.getElementById('fMitra'),
      fStatus = document.getElementById('fStatus'), perPage = document.getElementById('perPage'),
      searchInput = document.getElementById('searchInput');

  fMonth.innerHTML = MONTHS.map(function(m, idx){ return '<option value="' + idx + '"' + (idx === 8 ? ' selected' : '') + '>' + m + '</option>'; }).join('');
  DISTRICTS.forEach(function(d){ fDistrict.insertAdjacentHTML('beforeend', '<option>' + d + '</option>'); });
  MITRA.forEach(function(m){ fMitra.insertAdjacentHTML('beforeend', '<option>' + m + '</option>'); });

  var currentPage = 1;
  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return POOL.filter(function(w){
      if (w.month !== parseInt(fMonth.value, 10)) { return false; }
      if (String(w.year) !== fYear.value) { return false; }
      if (fDistrict.value && w.district !== fDistrict.value) { return false; }
      if (fMitra.value && w.mitra !== fMitra.value) { return false; }
      if (fStatus.value && !BUCKET[fStatus.value](w)) { return false; }
      if (q && (w.ticket + ' ' + w.headline + ' ' + w.teknisi + ' ' + w.lop).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderTable(){
    var rows = getFiltered();
    var per = parseInt(perPage.value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / per));
    if (currentPage > totalPages) { currentPage = totalPages; }
    var start = (currentPage - 1) * per;
    var page = rows.slice(start, start + per);

    document.getElementById('tbody').innerHTML = page.length ? page.map(function(w){
      var action = BUCKET.WAITING(w)
        ? '<button class="mini-btn brand" data-open="' + w.id + '">' + t('detail') + '</button>'
        : '<button class="mini-btn slate" data-open="' + w.id + '">' + t('detail') + '</button>';
      return '<tr>' +
        '<td>' + w.district + '</td><td class="mono-cell">' + w.ticket + '</td>' +
        '<td class="headline">' + w.headline + '</td>' +
        '<td class="lop">' + w.lop + '</td>' +
        '<td>' + statusPill(w.status) + '</td>' +
        '<td>' + w.mitra + '</td><td>' + w.tglTeknisi + '</td><td>' + w.teknisi + '</td>' +
        '<td>' + (w.tglTl || '-') + '</td>' +
        '<td class="num">' + rupiah(woTotal(w)) + '</td>' +
        '<td>' + action + '</td></tr>';
    }).join('') : '<tr><td colspan="11" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    var counts = { WAITING: 0, APPROVED: 0, PENDING: 0 };
    rows.forEach(function(w){ counts[bucketOf(w)]++; });
    document.getElementById('summary').textContent = t('summary')
      .replace('{w}', counts.WAITING).replace('{a}', counts.APPROVED).replace('{p}', counts.PENDING);

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
  [fMonth, fYear, fDistrict, fMitra, fStatus, perPage].forEach(function(el){
    el.addEventListener('change', function(){ currentPage = 1; renderTable(); });
  });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });

  /* ---------- workorder detail ---------- */
  var activeWo = null;
  var woModal = document.getElementById('woModal');

  function renderUraian(){
    document.getElementById('uraianBody').innerHTML = activeWo.lines.length ? activeWo.lines.map(function(l, idx){
      var editable = activeWo.status === 'WAITING';
      var qtyCell = editable
        ? '<input class="qty-input" type="number" min="1" value="' + l.qty + '" data-qty="' + idx + '" />'
        : l.qty;
      var del = editable
        ? '<button class="mini-btn red" data-delline="' + idx + '">' + t('delete') + '</button>'
        : '<span style="color:var(--muted)">—</span>';
      return '<tr><td class="mono-cell">' + l.khs.d + '</td><td>' + l.khs.u + '</td>' +
        '<td class="num">' + rupiah(l.khs.m) + '</td><td class="num">' + rupiah(l.khs.j) + '</td>' +
        '<td class="num">' + qtyCell + '</td><td>' + l.khs.s + '</td>' +
        '<td class="num">' + rupiah((l.khs.m + l.khs.j) * l.qty) + '</td><td>' + del + '</td></tr>';
    }).join('') : '<tr><td colspan="8" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';
    document.getElementById('uraianTotal').textContent = rupiah(woTotal(activeWo));
  }

  function renderWo(){
    var w = activeWo;
    document.getElementById('woTitle').textContent = w.ticket + ' — ' + w.lop;
    document.getElementById('woGrid').innerHTML = kvHtml([
      [t('kTicket'), w.ticket], [t('kDistrict'), w.district], [t('kSto'), w.sto],
      [t('kProject'), w.project], [t('kLop'), w.lop],
      [t('kStatus'), statusPill(w.status)],
      [t('kMitra'), w.mitra], [t('kTeam'), w.team], [t('kTech'), w.teknisi],
      [t('kCompDate'), w.tglTeknisi], [t('kTlDate'), w.tglTl || '-'],
      [t('kTotalBoq'), rupiah(woTotal(w))],
      [t('kHeadline'), w.headline],
      [t('kNote'), w.note || '-'],
    ]);

    renderUraian();

    document.getElementById('ruasBody').innerHTML = w.lines.map(function(l, idx){
      return '<tr><td class="mono-cell">ODP-' + w.ticket.slice(-4) + '-' + String(idx + 1).padStart(2, '0') + '</td>' +
        '<td>' + l.khs.u + '</td><td>' + w.sto + '</td>' +
        '<td class="mono-cell">' + (-1.2 - idx * 0.013).toFixed(4) + ', ' + (116.83 + idx * 0.017).toFixed(4) + '</td></tr>';
    }).join('');

    document.getElementById('evidenceRow').innerHTML = [
      ['evBefore', '/images/dalapa/evidence/odp-before.svg'],
      ['evAfter', '/images/dalapa/evidence/odp-after.svg'],
    ].map(function(e){
      return '<div class="evidence-item"><div class="k">' + t(e[0]) + '</div>' +
        '<button type="button" class="thumb" data-lightbox="' + e[1] + '" data-caption="' + w.ticket + ' — ' + t(e[0]) + '">' +
        '<img src="' + e[1] + '" alt="" /></button></div>';
    }).join('');

    var done = !BUCKET.WAITING(w);
    document.getElementById('woApprove').disabled = done;
    document.getElementById('woPending').disabled = done;
  }

  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-open]');
    if (!b) { return; }
    activeWo = WOS[parseInt(b.dataset.open, 10)];
    renderWo();
    woModal.classList.add('show');
  });

  document.getElementById('uraianBody').addEventListener('input', function(e){
    var input = e.target.closest('[data-qty]');
    if (!input) { return; }
    var v = parseInt(input.value, 10);
    activeWo.lines[parseInt(input.dataset.qty, 10)].qty = isNaN(v) || v < 1 ? 1 : v;
    document.getElementById('uraianTotal').textContent = rupiah(woTotal(activeWo));
    var row = input.closest('tr');
    var l = activeWo.lines[parseInt(input.dataset.qty, 10)];
    row.children[6].textContent = rupiah((l.khs.m + l.khs.j) * l.qty);
  });
  document.getElementById('uraianBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-delline]');
    if (!b) { return; }
    activeWo.lines.splice(parseInt(b.dataset.delline, 10), 1);
    renderUraian();
    renderTable();
    toast(t('rowRemoved'));
  });

  document.getElementById('evidenceRow').addEventListener('click', function(e){
    var b = e.target.closest('[data-lightbox]');
    if (b) { openLightbox(b.dataset.lightbox, b.dataset.caption); }
  });

  ['woX', 'woClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ woModal.classList.remove('show'); });
  });

  document.getElementById('woApprove').addEventListener('click', function(){
    if (!BUCKET.WAITING(activeWo)) { toast(t('alreadyDone')); return; }
    activeWo.status = 'APPROVE_TL';
    activeWo.note = '';
    activeWo.tglTl = stamp();
    renderWo();
    renderTable();
    woModal.classList.remove('show');
    toast(t('approved'));
  });

  var pendingModal = document.getElementById('pendingModal');
  document.getElementById('woPending').addEventListener('click', function(){
    if (!BUCKET.WAITING(activeWo)) { toast(t('alreadyDone')); return; }
    document.getElementById('pendingNote').value = '';
    pendingModal.classList.add('show');
  });
  ['pendingX', 'pendingCancel'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ pendingModal.classList.remove('show'); });
  });
  document.getElementById('pendingOk').addEventListener('click', function(){
    var note = document.getElementById('pendingNote').value.trim();
    if (!note) { toast(t('needReason')); return; }
    activeWo.status = 'PENDING_TL';
    activeWo.note = note;
    activeWo.tglTl = stamp();
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
