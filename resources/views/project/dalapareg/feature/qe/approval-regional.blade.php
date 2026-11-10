<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Approval Regional — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .headline{max-width:270px;white-space:normal;line-height:1.45}
  .check-col{width:34px;text-align:center}
  .check-col input{width:15px;height:15px;accent-color:var(--brand-500);cursor:pointer}
  .act-bar{display:flex;gap:8px;justify-content:space-between;align-items:center;padding:12px 16px;border-top:1px solid var(--border);flex-wrap:wrap}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-approval-regional'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Approval Regional</span></div>
    <h1 data-i18n="pageTitleLong">Approval Regional - New Project</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="filter-bar">
        <div class="field wide"><label>Distrik</label><select id="fDistrict"></select></div>
        <div class="field wide"><label>Mitra</label><select id="fMitra"></select></div>
        <div class="field"><label data-i18n="fCompDate">Tanggal Complete Teknisi</label><input type="date" id="fStart" value="2026-09-01" /></div>
        <div class="field"><label data-i18n="until">Sampai</label><input type="date" id="fEnd" value="2026-09-30" /></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="tableTitle">Workorder Menunggu Approval Regional</h3>
        <span class="last-update" id="summary"></span>
      </div>
      <div class="table-toolbar">
        <select id="perPage"><option value="8">8 / halaman</option><option value="15">15 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari tiket / headline / mitra..." />
      </div>
      <div class="table-scroll">
        <table class="bordered">
          <thead>
            <tr>
              <th class="check-col"><input type="checkbox" id="checkAll" /></th>
              <th>Distrik</th><th>STO</th><th data-i18n="cTicket">Tiket</th><th>Headline</th><th>Mitra</th>
              <th data-i18n="cStatusWo">Status WO</th><th data-i18n="cCompDate">Tgl Complete</th>
              <th data-i18n="cQeDate">Tgl APPROVE QE</th><th class="num" data-i18n="cTotalBoq">Total BOQ</th>
              <th data-i18n="cAction">Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="act-bar">
        <span class="hint-muted" id="selInfo"></span>
        <button class="btn-success" id="approveSelected" data-i18n="approveSelected">Approve Regional Terpilih</button>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
    </div>
  </div>
</main>

<!-- DETAIL -->
<div class="modal-backdrop" id="woModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 data-i18n="detailTitle">Informasi Workorder</h3><button class="modal-close" id="woX">✕</button></div>
    <div class="tabs">
      <button class="on" data-tab="#woData" data-i18n="tabInfo">Informasi</button>
      <button data-tab="#woBoq" data-i18n="tabBoq">BOQ</button>
      <button data-tab="#woAlpro" data-i18n="tabAlpro">Area / Alpro</button>
      <button data-tab="#woEvidence" data-i18n="tabEvidence">Evidence</button>
    </div>
    <div class="modal-body">
      <div id="woData"><div class="kv-grid" id="woGrid"></div></div>
      <div id="woBoq" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead><tr><th>Designator</th><th data-i18n="cJob">Pekerjaan</th><th class="num">Mat</th><th class="num">Jasa</th>
              <th class="num">Qty</th><th>Sat</th><th class="num" data-i18n="total">Total</th></tr></thead>
            <tbody id="boqBody"></tbody>
            <tfoot><tr class="total-row" id="boqTotals"></tr></tfoot>
          </table>
        </div>
      </div>
      <div id="woAlpro" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead><tr><th>Area</th><th>Alpro</th></tr></thead>
            <tbody id="alproBody"></tbody>
          </table>
        </div>
      </div>
      <div id="woEvidence" hidden><div class="evidence-row" id="evidenceRow"></div></div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline warn" id="woClose" data-i18n="back">Kembali</button>
      <button class="btn-success" id="woApprove" data-i18n="approveOne">Approve Regional</button>
    </div>
  </div>
</div>

@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    pageTitle: 'Approval Regional', pageTitleLong: 'Approval Regional - New Project',
    tableTitle: 'Workorder Menunggu Approval Regional', fCompDate: 'Tanggal Complete Teknisi', until: 'Sampai',
    searchPh: 'Cari tiket / headline / mitra...', back: 'Kembali',
    cTicket: 'Tiket', cStatusWo: 'Status WO', cCompDate: 'Tgl Complete', cQeDate: 'Tgl APPROVE QE',
    cTotalBoq: 'Total BOQ', cAction: 'Action', cJob: 'Pekerjaan',
    summary: '{w} menunggu regional · {d} sudah approve',
    selInfo: '{n} workorder dipilih · total {rp}', selNone: 'Belum ada workorder dipilih.',
    approveSelected: 'Approve Regional Terpilih', approveOne: 'Approve Regional',
    detailTitle: 'Informasi Workorder', tabInfo: 'Informasi', tabBoq: 'BOQ', tabAlpro: 'Area / Alpro', tabEvidence: 'Evidence',
    kDistrict: 'Distrik', kSto: 'STO', kHeadline: 'Headline', kTicket: 'Ticket', kJob: 'Pekerjaan', kCoord: 'Koordinat',
    kSuratNo: 'No Surat', kSuratJudul: 'Judul Surat', kSuratPengirim: 'Pengirim', kSuratTgl: 'Tgl Surat', kSuratFile: 'File',
    kStatus: 'Status WO', kMitra: 'Mitra', kCompDate: 'Tgl Complete', kQeDate: 'Tgl APPROVE QE', kTotalBoq: 'Total BOQ',
    viewFile: 'Lihat', evBefore: 'Before', evAfter: 'After',
    approvedOne: 'Workorder disetujui Regional.', approvedBatch: '{n} workorder disetujui Regional.',
    alreadyDone: 'Workorder ini sudah disetujui Regional.', nothingSelected: 'Pilih minimal satu workorder dulu.',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  /* regional signs off only what QE has already approved */
  function pool(){ return WOS.filter(function(w){ return rank(w.status) >= 4; }); }
  function awaiting(w){ return w.status === 'APPROVE_QE'; }

  var fDistrict = document.getElementById('fDistrict'), fMitra = document.getElementById('fMitra'),
      fStart = document.getElementById('fStart'), fEnd = document.getElementById('fEnd'),
      perPage = document.getElementById('perPage'), searchInput = document.getElementById('searchInput');
  fillSelect(fDistrict, DISTRICTS);
  fillSelect(fMitra, MITRA);

  var currentPage = 1, selected = {};

  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return pool().filter(function(w){
      if (fDistrict.value && w.district !== fDistrict.value) { return false; }
      if (fMitra.value && w.mitra !== fMitra.value) { return false; }
      var comp = (w.tglTeknisi || '').slice(0, 10);
      if (fStart.value && comp && comp < fStart.value) { return false; }
      if (fEnd.value && comp && comp > fEnd.value) { return false; }
      if (q && (w.ticket + ' ' + w.headline + ' ' + w.mitra).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderTable(){
    var rows = getFiltered();
    var res = paginate(rows, currentPage, parseInt(perPage.value, 10), function(p){ currentPage = p; renderTable(); });
    currentPage = res.page;

    document.getElementById('tbody').innerHTML = res.slice.length ? res.slice.map(function(w){
      var box = awaiting(w)
        ? '<input type="checkbox" data-pick="' + w.id + '"' + (selected[w.id] ? ' checked' : '') + ' />'
        : '<span style="color:var(--muted)">—</span>';
      return '<tr><td class="check-col">' + box + '</td>' +
        '<td>' + w.district + '</td><td>' + w.sto + '</td><td class="mono-cell">' + w.ticket + '</td>' +
        '<td class="headline">' + w.headline + '</td><td>' + w.mitra + '</td>' +
        '<td>' + statusPill(w.status) + '</td><td>' + (w.tglTeknisi || '-') + '</td><td>' + (w.tglQe || '-') + '</td>' +
        '<td class="num">' + rupiah(woTotal(w)) + '</td>' +
        '<td><button class="mini-btn brand" data-open="' + w.id + '">' + t('detail') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="11" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    document.getElementById('summary').textContent = t('summary')
      .replace('{w}', rows.filter(awaiting).length)
      .replace('{d}', rows.filter(function(w){ return w.status === 'APPROVE_REGIONAL'; }).length);
    renderSelInfo();
  }

  function selectedWos(){
    return WOS.filter(function(w){ return selected[w.id] && awaiting(w); });
  }
  function renderSelInfo(){
    var list = selectedWos();
    document.getElementById('selInfo').textContent = list.length
      ? t('selInfo').replace('{n}', list.length).replace('{rp}', rupiah(list.reduce(function(a, w){ return a + woTotal(w); }, 0)))
      : t('selNone');
  }

  document.getElementById('tbody').addEventListener('change', function(e){
    var box = e.target.closest('[data-pick]');
    if (!box) { return; }
    selected[box.dataset.pick] = box.checked;
    renderSelInfo();
  });
  document.getElementById('checkAll').addEventListener('change', function(){
    var on = this.checked;
    getFiltered().filter(awaiting).forEach(function(w){ selected[w.id] = on; });
    renderTable();
  });
  [fDistrict, fMitra, fStart, fEnd, perPage].forEach(function(el){
    el.addEventListener('change', function(){ currentPage = 1; renderTable(); });
  });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });

  /* ---------- detail ---------- */
  var woModal = document.getElementById('woModal'), activeWo = null;

  function renderWo(){
    var w = activeWo;
    document.getElementById('woGrid').innerHTML = kvHtml([
      [t('kDistrict'), w.district], [t('kSto'), w.sto], [t('kTicket'), w.ticket],
      [t('kHeadline'), w.headline], [t('kJob'), w.pekerjaan], [t('kCoord'), w.koordinat],
      [t('kSuratNo'), w.surat.no], [t('kSuratJudul'), w.surat.judul], [t('kSuratPengirim'), w.surat.pengirim],
      [t('kSuratTgl'), w.surat.tgl],
      [t('kSuratFile'), '<button type="button" class="mini-btn slate" data-demo>' + t('viewFile') + '</button>'],
      [t('kStatus'), statusPill(w.status)], [t('kMitra'), w.mitra],
      [t('kCompDate'), w.tglTeknisi || '-'], [t('kQeDate'), w.tglQe || '-'], [t('kTotalBoq'), rupiah(woTotal(w))],
    ]);
    document.getElementById('boqBody').innerHTML = w.lines.map(function(l){
      return '<tr><td class="mono-cell">' + l.khs.d + '</td><td>' + l.khs.u + '</td>' +
        '<td class="num">' + rupiah(l.khs.m) + '</td><td class="num">' + rupiah(l.khs.j) + '</td>' +
        '<td class="num">' + l.qty + '</td><td>' + l.khs.s + '</td>' +
        '<td class="num">' + rupiah((l.khs.m + l.khs.j) * l.qty) + '</td></tr>';
    }).join('');
    document.getElementById('boqTotals').innerHTML = '<td colspan="6">' + t('total') + '</td><td class="num">' + rupiah(woTotal(w)) + '</td>';
    document.getElementById('alproBody').innerHTML = w.lines.map(function(l, idx){
      return '<tr><td>' + w.sto.replace('STO ', '') + '</td>' +
        '<td class="mono-cell">ODP-' + w.ticket.slice(-4) + '-' + String(idx + 1).padStart(2, '0') + ' · ' + l.khs.u + '</td></tr>';
    }).join('');
    document.getElementById('evidenceRow').innerHTML = [
      ['evBefore', '/images/dalapa/evidence/odp-before.svg'],
      ['evAfter', '/images/dalapa/evidence/odp-after.svg'],
    ].map(function(e){
      return '<div class="evidence-item"><div class="k">' + t(e[0]) + '</div>' +
        '<button type="button" class="thumb" data-lightbox="' + e[1] + '" data-caption="' + w.ticket + ' — ' + t(e[0]) + '">' +
        '<img src="' + e[1] + '" alt="" /></button></div>';
    }).join('');
    document.getElementById('woApprove').disabled = !awaiting(w);
  }

  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-open]');
    if (!b) { return; }
    activeWo = WOS.filter(function(w){ return w.id === parseInt(b.dataset.open, 10); })[0];
    renderWo();
    woModal.classList.add('show');
  });
  woModal.addEventListener('click', function(e){
    if (e.target.closest('[data-demo]')) { toast(t('demoOnly')); }
    var lb = e.target.closest('[data-lightbox]');
    if (lb) { openLightbox(lb.dataset.lightbox, lb.dataset.caption); }
  });
  ['woX', 'woClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ woModal.classList.remove('show'); });
  });

  function approveList(list){
    list.forEach(function(w){ w.status = 'APPROVE_REGIONAL'; w.tglRegional = stamp(); delete selected[w.id]; });
  }
  document.getElementById('woApprove').addEventListener('click', function(){
    if (!awaiting(activeWo)) { toast(t('alreadyDone')); return; }
    approveList([activeWo]);
    renderWo(); renderTable();
    woModal.classList.remove('show');
    toast(t('approvedOne'));
  });
  document.getElementById('approveSelected').addEventListener('click', function(){
    var list = selectedWos();
    if (!list.length) { toast(t('nothingSelected')); return; }
    approveList(list);
    document.getElementById('checkAll').checked = false;
    renderTable();
    toast(t('approvedBatch').replace('{n}', list.length));
  });

  renderTable();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeApprovalRegionalTour = {
    id: 'dalapareg-qe-app-regional',
    steps: [
      {
        target: '.filter-bar',
        pos: 'bottom',
        title: 'Filter Antrean Approval Regional',
        desc: 'Saring workorder yang siap diverifikasi di level Regional berdasarkan Distrik, Mitra kerja, dan tanggal penyelesaian teknisi.'
      },
      {
        target: 'table thead',
        pos: 'bottom',
        title: 'Workorder Terverifikasi TL & QE',
        desc: 'Menampilkan daftar tiket yang telah sukses melewati tahapan review Team Leader dan Quality Engineer, siap untuk final approval.'
      },
      {
        target: '#checkAll',
        pos: 'bottom',
        title: 'Seleksi Cepat Seluruh Workorder',
        desc: 'Centang kotak ini untuk memilih seluruh tiket pada halaman aktif guna memproses persetujuan secara simultan.'
      },
      {
        target: '#approveSelected',
        pos: 'top',
        title: 'Eksekusi Approve Regional',
        desc: 'Klik tombol ini untuk mengonfirmasi persetujuan tingkat regional terhadap seluruh tiket terpilih dalam satu klik.'
      }
    ]
  };

  setTimeout(function(){
    DalapaTour.start(qeApprovalRegionalTour);
  }, 450);
</script>

@include('project.dalapareg.feature.partials.tour-guide')
</body>
</html>
