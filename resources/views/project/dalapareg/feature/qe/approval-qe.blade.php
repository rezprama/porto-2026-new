<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Approval QE — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  table.khs th, table.khs td{white-space:nowrap}
  table.khs th:nth-child(-n+2), table.khs td:nth-child(-n+2){position:sticky;background:#f6f8fa;z-index:1}
  table.khs th:nth-child(1), table.khs td:nth-child(1){left:0}
  table.khs th:nth-child(2), table.khs td:nth-child(2){left:120px}
  table.khs tbody td:nth-child(-n+2){background:var(--panel-bg)}
  table.khs .qty{text-align:center;font-variant-numeric:tabular-nums}
  table.khs .jumlah{text-align:center;font-weight:700;background:#f6f8fa}
  .wo-col{font-size:10.5px;max-width:150px;white-space:normal;line-height:1.35}
  .act-bar{display:flex;gap:8px;justify-content:flex-end;padding:12px 16px;border-top:1px solid var(--border);flex-wrap:wrap}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-approval-qe'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Approval QE</span></div>
    <h1 data-i18n="pageTitle">Approval QE</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="filter-bar">
        <div class="field narrow"><label data-i18n="month">Bulan</label><select id="fMonth"></select></div>
        <div class="field narrow"><label data-i18n="year">Tahun</label><select id="fYear"><option>2026</option><option>2025</option></select></div>
        <div class="field wide"><label>Distrik</label><select id="fDistrict"></select></div>
        <div class="field wide"><label>Mitra</label><select id="fMitra"></select></div>
        <div class="field wide"><label>Project</label><select id="fProject"></select></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
        <button class="btn-sky" id="printAll" data-i18n="printAll">Print All</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="tableTitle">Rekap BOQ KHS per Workorder</h3>
        <span class="last-update" id="summary"></span>
      </div>
      <div class="table-scroll">
        <table class="bordered khs">
          <thead id="khsHead"></thead>
          <tbody id="khsBody"></tbody>
          <tfoot><tr class="total-row" id="khsTotals"></tr></tfoot>
        </table>
      </div>
      <p class="hint-muted" style="padding:10px 16px" data-i18n="hint">Kolom hijau = sudah APPROVE QE, kuning = menunggu keputusan. Klik judul kolom untuk melihat detail workorder-nya.</p>
      <div class="act-bar">
        <button class="btn-outline warn" id="batchPending" data-i18n="pendingBatch">Pending</button>
        <button class="btn-success" id="batchApprove" data-i18n="approveBatch">Approve</button>
      </div>
    </div>
  </div>
</main>

<!-- WORKORDER DETAIL -->
<div class="modal-backdrop" id="woModal">
  <div class="modal-card modal-xl">
    <div class="modal-head"><h3 id="woTitle">Informasi</h3><button class="modal-close" id="woX">✕</button></div>
    <div class="tabs">
      <button class="on" data-tab="#woData" data-i18n="tabWo">Data Workorder</button>
      <button data-tab="#woUraian" data-i18n="tabUraian">Uraian Pekerjaan</button>
      <button data-tab="#woEvidence" data-i18n="tabEvidence">Evidence</button>
    </div>
    <div class="modal-body">
      <div id="woData">
        <div class="kv-grid" id="woGrid"></div>
        <div style="margin-top:12px"><button class="btn-outline" id="kmlBtn" data-i18n="exportKml">Export KML</button></div>
      </div>
      <div id="woUraian" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead><tr><th>Designator</th><th data-i18n="cJob">Nama Pekerjaan</th>
              <th class="num" data-i18n="cHargaMaterial">Harga Material</th><th class="num" data-i18n="cHargaJasa">Harga Jasa</th>
              <th class="num" data-i18n="cQty">Kuantitas</th><th data-i18n="cSatuan">Satuan</th><th class="num" data-i18n="total">Total</th></tr></thead>
            <tbody id="uraianBody"></tbody>
            <tfoot><tr class="total-row" id="uraianTotals"></tr></tfoot>
          </table>
        </div>
      </div>
      <div id="woEvidence" hidden><div class="evidence-row" id="evidenceRow"></div></div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="woClose" data-i18n="close">Tutup</button>
      <button class="btn-outline warn" id="woPending" data-i18n="pending">Pending</button>
      <button class="btn-success" id="woApprove" data-i18n="approveQe">Approve QE</button>
    </div>
  </div>
</div>

<!-- PENDING REASON -->
<div class="modal-backdrop" id="pendingModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="pendingTitle">Pending BOQ</h3><button class="modal-close" id="pendingX">✕</button></div>
    <div class="modal-body">
      <div class="field">
        <label data-i18n="pendingReason">Alasan Pending</label>
        <textarea id="pendingNote" rows="4" data-i18n-ph="pendingPh" placeholder="Contoh: volume kabel melebihi KHS, mohon dikoreksi TL."></textarea>
        <p class="hint" id="pendingScope" style="margin-top:6px"></p>
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
    pageTitle: 'Approval QE', tableTitle: 'Rekap BOQ KHS per Workorder', printAll: 'Print All',
    cDesMat: 'Designator Material', cDesJasa: 'Designator Jasa', cKegiatan: 'Nama Kegiatan',
    cSatuan: 'Satuan', cMaterial: 'Material', cJasa: 'Jasa', cJumlah: 'Jumlah',
    hint: 'Kolom hijau = sudah APPROVE QE, kuning = menunggu keputusan. Klik judul kolom untuk melihat detail workorder-nya.',
    summary: '{n} workorder difilter · {w} menunggu approval QE',
    approveBatch: 'Approve', pendingBatch: 'Pending', approveQe: 'Approve QE',
    tabWo: 'Data Workorder', tabUraian: 'Uraian Pekerjaan', tabEvidence: 'Evidence',
    cJob: 'Nama Pekerjaan', cHargaMaterial: 'Harga Material', cHargaJasa: 'Harga Jasa', cQty: 'Kuantitas',
    exportKml: 'Export KML',
    kDistrict: 'Distrik', kSto: 'STO', kHeadline: 'Headline', kTicket: 'Ticket', kJob: 'Nama Pekerjaan',
    kLat: 'Latitude / Longitude', kRuas: 'Ruas', kDetail: 'Detail', kMitra: 'Mitra', kTeam: 'Nama Tim',
    kTech: 'Teknisi', kStatus: 'Status Workorder', kTlDate: 'Tanggal Update TL', kQeDate: 'Tanggal Update QE',
    kTotalBoq: 'Total BOQ', kNote: 'Catatan',
    evBefore: 'Evidence Before', evAfter: 'Evidence After',
    pendingTitle: 'Pending BOQ', pendingReason: 'Alasan Pending',
    pendingPh: 'Contoh: volume kabel melebihi KHS, mohon dikoreksi TL.', savePending: 'Simpan Pending',
    scopeOne: 'Berlaku untuk workorder {x}.', scopeBatch: 'Berlaku untuk {n} workorder yang sedang difilter.',
    approvedOne: 'Workorder disetujui QE.', approvedBatch: '{n} workorder disetujui QE.',
    pendedOne: 'Workorder ditandai pending QE.', pendedBatch: '{n} workorder ditandai pending QE.',
    needReason: 'Alasan pending wajib diisi.', alreadyDone: 'Workorder ini sudah diproses QE.',
    nothingToDo: 'Tidak ada workorder yang menunggu approval QE.',
    emptyMatrix: 'Filter Data BOQ Terlebih Dahulu',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  var fMonth = document.getElementById('fMonth'), fYear = document.getElementById('fYear'),
      fDistrict = document.getElementById('fDistrict'), fMitra = document.getElementById('fMitra'),
      fProject = document.getElementById('fProject');
  fMonth.innerHTML = MONTHS.map(function(m, idx){ return '<option value="' + idx + '"' + (idx === 8 ? ' selected' : '') + '>' + m + '</option>'; }).join('');
  fillSelect(fDistrict, DISTRICTS, 'ALL');
  fillSelect(fMitra, MITRA, 'ALL');
  fillSelect(fProject, PROJECTS, 'ALL');

  /* QE only sees what TL has already signed off */
  function scopeWos(){
    return WOS.filter(function(w){
      if (rank(w.status) < 3) { return false; }
      if (w.month !== parseInt(fMonth.value, 10) || String(w.year) !== fYear.value) { return false; }
      if (fDistrict.value && w.district !== fDistrict.value) { return false; }
      if (fMitra.value && w.mitra !== fMitra.value) { return false; }
      if (fProject.value && w.project !== fProject.value) { return false; }
      return true;
    });
  }
  function awaiting(w){ return w.status === 'APPROVE_TL' || w.status === 'PENDING_QE'; }

  function renderMatrix(){
    var wos = scopeWos();
    var head = document.getElementById('khsHead'), body = document.getElementById('khsBody'), foot = document.getElementById('khsTotals');

    if (!wos.length) {
      head.innerHTML = '';
      body.innerHTML = '<tr><td style="text-align:center;color:var(--muted);padding:26px">' + t('emptyMatrix') + '</td></tr>';
      foot.innerHTML = '';
      document.getElementById('summary').textContent = '';
      return;
    }

    head.innerHTML = '<tr><th data-i18n="cDesMat">' + t('cDesMat') + '</th><th>' + t('cDesJasa') + '</th>' +
      '<th>' + t('cKegiatan') + '</th><th>' + t('cSatuan') + '</th>' +
      '<th class="num">' + t('cMaterial') + '</th><th class="num">' + t('cJasa') + '</th>' +
      wos.map(function(w){
        var tone = w.status === 'APPROVE_QE' || w.status === 'APPROVE_REGIONAL' ? 'teal' : 'amber';
        return '<th><button class="mini-btn ' + tone + ' wo-col" data-wo="' + w.id + '">' + w.pekerjaan + '<br />' + w.ticket + '</button></th>';
      }).join('') +
      '<th>' + t('cJumlah') + '</th></tr>';

    /* one row per KHS item that actually appears in the filtered workorders */
    var used = KHS.filter(function(k){
      return wos.some(function(w){ return w.lines.some(function(l){ return l.khs.d === k.d; }); });
    });

    body.innerHTML = used.map(function(k){
      var totalQty = 0;
      var cells = wos.map(function(w){
        var qty = w.lines.reduce(function(a, l){ return a + (l.khs.d === k.d ? l.qty : 0); }, 0);
        totalQty += qty;
        return '<td class="qty">' + (qty || '-') + '</td>';
      }).join('');
      return '<tr><td class="mono-cell">' + k.d + '</td><td class="mono-cell">' + k.dj + '</td>' +
        '<td>' + k.u + '</td><td>' + k.s + '</td>' +
        '<td class="num">' + rupiah(k.m) + '</td><td class="num">' + rupiah(k.j) + '</td>' +
        cells + '<td class="jumlah">' + totalQty + '</td></tr>';
    }).join('');

    foot.innerHTML = '<td colspan="6">' + t('total') + ' BOQ</td>' +
      wos.map(function(w){ return '<td class="num">' + rupiah(woTotal(w)) + '</td>'; }).join('') +
      '<td class="num">' + rupiah(wos.reduce(function(a, w){ return a + woTotal(w); }, 0)) + '</td>';

    document.getElementById('summary').textContent = t('summary')
      .replace('{n}', wos.length).replace('{w}', wos.filter(awaiting).length);
  }

  [fMonth, fYear, fDistrict, fMitra, fProject].forEach(function(el){ el.addEventListener('change', renderMatrix); });
  document.getElementById('filterBtn').addEventListener('click', renderMatrix);
  document.getElementById('printAll').addEventListener('click', function(){ toast(t('demoOnly')); });

  /* ---------- workorder detail ---------- */
  var woModal = document.getElementById('woModal'), activeWo = null;

  function renderWo(){
    var w = activeWo;
    document.getElementById('woTitle').textContent = w.ticket + ' — ' + w.lop;
    document.getElementById('woGrid').innerHTML = kvHtml([
      [t('kDistrict'), w.district], [t('kSto'), w.sto], [t('kTicket'), w.ticket],
      [t('kHeadline'), w.headline], [t('kJob'), w.pekerjaan], [t('kLat'), w.koordinat],
      [t('kRuas'), w.lines.length + ' ruas'], [t('kDetail'), w.penyebab],
      [t('kMitra'), w.mitra], [t('kTeam'), w.team], [t('kTech'), w.teknisi],
      [t('kStatus'), statusPill(w.status)], [t('kTlDate'), w.tglTl || '-'], [t('kQeDate'), w.tglQe || '-'],
      [t('kTotalBoq'), rupiah(woTotal(w))], [t('kNote'), w.note || '-'],
    ]);
    document.getElementById('uraianBody').innerHTML = w.lines.map(function(l){
      return '<tr><td class="mono-cell">' + l.khs.d + '</td><td>' + l.khs.u + '</td>' +
        '<td class="num">' + rupiah(l.khs.m) + '</td><td class="num">' + rupiah(l.khs.j) + '</td>' +
        '<td class="num">' + l.qty + '</td><td>' + l.khs.s + '</td>' +
        '<td class="num">' + rupiah((l.khs.m + l.khs.j) * l.qty) + '</td></tr>';
    }).join('');
    document.getElementById('uraianTotals').innerHTML = '<td colspan="6">' + t('total') + '</td><td class="num">' + rupiah(woTotal(w)) + '</td>';
    document.getElementById('evidenceRow').innerHTML = [
      ['evBefore', '/images/dalapa/evidence/odp-before.svg'],
      ['evAfter', '/images/dalapa/evidence/odp-after.svg'],
    ].map(function(e){
      return '<div class="evidence-item"><div class="k">' + t(e[0]) + '</div>' +
        '<button type="button" class="thumb" data-lightbox="' + e[1] + '" data-caption="' + w.ticket + ' — ' + t(e[0]) + '">' +
        '<img src="' + e[1] + '" alt="" /></button></div>';
    }).join('');
    var locked = !awaiting(w);
    document.getElementById('woApprove').disabled = locked;
    document.getElementById('woPending').disabled = locked;
  }

  document.getElementById('khsHead').addEventListener('click', function(e){
    var b = e.target.closest('[data-wo]');
    if (!b) { return; }
    activeWo = WOS.filter(function(w){ return w.id === parseInt(b.dataset.wo, 10); })[0];
    renderWo();
    woModal.classList.add('show');
  });
  document.getElementById('evidenceRow').addEventListener('click', function(e){
    var b = e.target.closest('[data-lightbox]');
    if (b) { openLightbox(b.dataset.lightbox, b.dataset.caption); }
  });
  document.getElementById('kmlBtn').addEventListener('click', function(){ toast(t('demoOnly')); });
  ['woX', 'woClose'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ woModal.classList.remove('show'); });
  });

  /* ---------- approve / pending, single or whole filtered batch ---------- */
  function approveList(list){
    list.forEach(function(w){ w.status = 'APPROVE_QE'; w.tglQe = stamp(); w.note = ''; });
  }
  document.getElementById('woApprove').addEventListener('click', function(){
    if (!awaiting(activeWo)) { toast(t('alreadyDone')); return; }
    approveList([activeWo]);
    renderWo(); renderMatrix();
    woModal.classList.remove('show');
    toast(t('approvedOne'));
  });
  document.getElementById('batchApprove').addEventListener('click', function(){
    var list = scopeWos().filter(awaiting);
    if (!list.length) { toast(t('nothingToDo')); return; }
    approveList(list);
    renderMatrix();
    toast(t('approvedBatch').replace('{n}', list.length));
  });

  var pendingModal = document.getElementById('pendingModal'), pendingTargets = [];
  function openPending(list, scopeText){
    if (!list.length) { toast(t('nothingToDo')); return; }
    pendingTargets = list;
    document.getElementById('pendingNote').value = '';
    document.getElementById('pendingScope').textContent = scopeText;
    pendingModal.classList.add('show');
  }
  document.getElementById('woPending').addEventListener('click', function(){
    if (!awaiting(activeWo)) { toast(t('alreadyDone')); return; }
    openPending([activeWo], t('scopeOne').replace('{x}', activeWo.ticket));
  });
  document.getElementById('batchPending').addEventListener('click', function(){
    var list = scopeWos().filter(awaiting);
    openPending(list, t('scopeBatch').replace('{n}', list.length));
  });
  ['pendingX', 'pendingCancel'].forEach(function(id){
    document.getElementById(id).addEventListener('click', function(){ pendingModal.classList.remove('show'); });
  });
  document.getElementById('pendingOk').addEventListener('click', function(){
    var note = document.getElementById('pendingNote').value.trim();
    if (!note) { toast(t('needReason')); return; }
    pendingTargets.forEach(function(w){ w.status = 'PENDING_QE'; w.note = note; w.tglQe = stamp(); });
    var many = pendingTargets.length > 1;
    pendingModal.classList.remove('show');
    woModal.classList.remove('show');
    renderMatrix();
    toast(many ? t('pendedBatch').replace('{n}', pendingTargets.length) : t('pendedOne'));
  });

  renderMatrix();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeApprovalQeTour = {
    id: 'dalapareg-qe-app-qe',
    steps: [
      {
        target: '.filter-bar',
        pos: 'bottom',
        title: 'Filter Evaluasi Quality Engineer',
        desc: 'Saring antrean berdasarkan Bulan, Tahun, Distrik, Mitra, dan Project. Tersedia juga tombol <b>Print All</b> untuk mencetak rekapitulasi.'
      },
      {
        target: 'table.khs thead',
        pos: 'bottom',
        title: 'Matriks BOQ KHS per Workorder',
        desc: 'Tabel lintas kolom memetakan volume material KHS terhadap setiap tiket workorder. Kolom hijau menandakan disetujui QE, kuning menunggu keputusan.'
      },
      {
        target: '.act-bar',
        pos: 'top',
        title: 'Tombol Aksi Massal (Batch Action)',
        desc: 'Gunakan tombol <b>Approve</b> untuk menyetujui seluruh workorder yang valid, atau <b>Pending</b> untuk mengembalikan perbaikan secara massal.'
      }
    ]
  };

  setTimeout(function(){
    DalapaTour.start(qeApprovalQeTour);
  }, 450);
</script>

@include('project.dalapareg.feature.partials.tour-guide')
</body>
</html>
