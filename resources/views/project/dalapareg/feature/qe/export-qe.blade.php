<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Export Nilai Anggaran New Project — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
@include('project.dalapareg.feature.partials.shell-styles')
<style>
  .headline{max-width:260px;white-space:normal;line-height:1.45}
  .job{max-width:200px;white-space:normal;line-height:1.45}
  table.wide th, table.wide td{white-space:nowrap}
</style>
</head>
<body>

@include('project.dalapareg.feature.partials.sidebar', ['active' => 'qe-export'])
@include('project.dalapareg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb"><span data-i18n="home">Beranda</span><span data-i18n="navQe">QE</span><span data-i18n="navNewProject">New Project</span><span data-i18n="pageTitle">Export QE</span></div>
    <h1 data-i18n="pageTitle">Export QE</h1>
  </div>

  <div class="stack">
    <div class="card">
      <div class="card-head"><h3 data-i18n="filterTitle">Filter Export Nilai Anggaran</h3></div>
      <div class="filter-bar">
        <div class="field wide"><label data-i18n="fBasis">Filter Berdasarkan</label><select id="fBasis"></select></div>
        <div class="field narrow"><label data-i18n="month">Bulan</label><select id="fMonth"></select></div>
        <div class="field narrow"><label data-i18n="year">Tahun</label><select id="fYear"><option>2026</option><option>2025</option></select></div>
        <button class="btn-success" id="filterBtn" data-i18n="filter">Filter</button>
        <button class="btn-sky" id="downloadBtn" data-i18n="download">Download</button>
      </div>
    </div>

    <div class="card">
      <div class="card-head">
        <h3 data-i18n="tableTitle">Nilai Anggaran New Project</h3>
        <span class="last-update" id="summary"></span>
      </div>
      <div class="table-toolbar">
        <select id="perPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari tiket / headline / STO..." />
      </div>
      <div class="table-scroll">
        <table class="bordered wide">
          <thead>
            <tr>
              <th data-i18n="cJob">Pekerjaan</th><th>Type</th><th data-i18n="cProject">Nama Project</th>
              <th>Month</th><th>Year</th><th>Distrik</th><th>STO</th><th data-i18n="cWorkzone">STO Workzone</th>
              <th data-i18n="cTicket">Tiket</th><th>Headline</th>
              <th class="num" data-i18n="cMaterial">Nilai material</th><th class="num" data-i18n="cJasa">Nilai jasa</th>
              <th class="num" data-i18n="total">Total</th><th data-i18n="status">Status</th>
              <th>Complete</th><th data-i18n="cAppTl">Approval TL</th><th data-i18n="cAppQe">Approval QE</th>
              <th data-i18n="cResolve">Resolve date</th><th data-i18n="cReported">Reported date</th><th data-i18n="cAction">Action</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
          <tfoot><tr class="total-row" id="totals"></tr></tfoot>
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
      <button class="on" data-tab="#woData" data-i18n="tabInfo">Informasi</button>
      <button data-tab="#woUraian" data-i18n="tabUraian">Uraian Pekerjaan</button>
      <button data-tab="#woEvidence" data-i18n="tabEvidence">Evidence</button>
    </div>
    <div class="modal-body">
      <div id="woData"><div class="kv-grid" id="woGrid"></div></div>
      <div id="woUraian" hidden>
        <div class="table-scroll">
          <table class="bordered">
            <thead><tr><th>Designator</th><th data-i18n="cJobName">Nama Pekerjaan</th>
              <th class="num" data-i18n="cHargaMaterial">Harga Material</th><th class="num" data-i18n="cHargaJasa">Harga Jasa</th>
              <th class="num" data-i18n="cQty">Kuantitas</th><th data-i18n="cSatuan">Satuan</th><th class="num" data-i18n="total">Total</th></tr></thead>
            <tbody id="uraianBody"></tbody>
            <tfoot><tr class="total-row" id="uraianTotals"></tr></tfoot>
          </table>
        </div>
      </div>
      <div id="woEvidence" hidden><div class="evidence-row" id="evidenceRow"></div></div>
    </div>
    <div class="modal-foot"><button class="btn-outline warn" id="woClose" data-i18n="back">Kembali</button></div>
  </div>
</div>

@include('project.tifreg.feature.partials.lightbox')

<script>
  var PAGE_I18N = {
    pageTitle: 'Export QE', filterTitle: 'Filter Export Nilai Anggaran', tableTitle: 'Nilai Anggaran New Project',
    fBasis: 'Filter Berdasarkan', searchPh: 'Cari tiket / headline / STO...', back: 'Kembali',
    cJob: 'Pekerjaan', cProject: 'Nama Project', cWorkzone: 'STO Workzone', cTicket: 'Tiket',
    cMaterial: 'Nilai material', cJasa: 'Nilai jasa', cAppTl: 'Approval TL', cAppQe: 'Approval QE',
    cResolve: 'Resolve date', cReported: 'Reported date', cAction: 'Action',
    summary: '{n} workorder · total {rp}',
    downloadToast: 'Berkas export dinonaktifkan pada demo ini — datanya ditampilkan langsung di tabel.',
    tabInfo: 'Informasi', tabUraian: 'Uraian Pekerjaan', tabEvidence: 'Evidence',
    cJobName: 'Nama Pekerjaan', cHargaMaterial: 'Harga Material', cHargaJasa: 'Harga Jasa',
    cQty: 'Kuantitas', cSatuan: 'Satuan',
    kDistrict: 'Distrik', kSto: 'STO', kJob: 'Pekerjaan', kCoord: 'Koordinat', kTicket: 'Tiket', kHeadline: 'Headline',
    kSuratNo: 'Nomor Surat', kSuratTgl: 'Tanggal Surat', kSuratPengirim: 'Pengirim Surat', kSuratJudul: 'Judul Surat',
    kSuratFile: 'File Surat', kStatus: 'Status', kMaterial: 'Nilai Material', kJasa: 'Nilai Jasa', kTotal: 'Total',
    viewFile: 'Lihat', evBefore: 'Evidence Before', evAfter: 'Evidence After',
    evNone: 'Evidence baru tersedia setelah teknisi menyelesaikan pekerjaan.',
  };
</script>

@include('project.dalapareg.feature.partials.shell-script')
@include('project.dalapareg.feature.partials.qe-data')

<script>
  var fBasis = document.getElementById('fBasis'), fMonth = document.getElementById('fMonth'),
      fYear = document.getElementById('fYear'), perPage = document.getElementById('perPage'),
      searchInput = document.getElementById('searchInput');
  fBasis.innerHTML = '<option value="">REGIONAL</option>' + DISTRICTS.map(function(d){ return '<option>' + d + '</option>'; }).join('');
  fMonth.innerHTML = MONTHS.map(function(m, idx){ return '<option value="' + idx + '"' + (idx === 8 ? ' selected' : '') + '>' + m + '</option>'; }).join('');

  var currentPage = 1;
  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    return WOS.filter(function(w){
      if (fBasis.value && w.district !== fBasis.value) { return false; }
      if (w.month !== parseInt(fMonth.value, 10) || String(w.year) !== fYear.value) { return false; }
      if (q && (w.ticket + ' ' + w.headline + ' ' + w.sto).toLowerCase().indexOf(q) === -1) { return false; }
      return true;
    });
  }

  function renderTable(){
    var rows = getFiltered();
    var res = paginate(rows, currentPage, parseInt(perPage.value, 10), function(p){ currentPage = p; renderTable(); });
    currentPage = res.page;

    document.getElementById('tbody').innerHTML = res.slice.length ? res.slice.map(function(w){
      return '<tr><td class="job">' + w.pekerjaan + '</td><td class="mono-cell">NEW_PROJECT</td><td>' + w.project + '</td>' +
        '<td>' + MONTHS[w.month] + '</td><td>' + w.year + '</td><td>' + w.district + '</td><td>' + w.sto + '</td>' +
        '<td>' + w.stoWorkzone + '</td><td class="mono-cell">' + w.ticket + '</td><td class="headline">' + w.headline + '</td>' +
        '<td class="num">' + rupiah(woMaterial(w)) + '</td><td class="num">' + rupiah(woJasa(w)) + '</td>' +
        '<td class="num">' + rupiah(woTotal(w)) + '</td><td>' + statusPill(w.status) + '</td>' +
        '<td>' + (w.tglTeknisi || '-') + '</td><td>' + (w.tglTl || '-') + '</td><td>' + (w.tglQe || '-') + '</td>' +
        '<td>' + (w.resolveDate || '-') + '</td><td>' + w.reportedDate + '</td>' +
        '<td><button class="mini-btn brand" data-open="' + w.id + '">' + t('detail') + '</button></td></tr>';
    }).join('') : '<tr><td colspan="20" style="text-align:center;color:var(--muted)">' + t('notFoundData') + '</td></tr>';

    document.getElementById('totals').innerHTML = '<td colspan="10">' + t('total') + '</td>' +
      '<td class="num">' + rupiah(rows.reduce(function(a, w){ return a + woMaterial(w); }, 0)) + '</td>' +
      '<td class="num">' + rupiah(rows.reduce(function(a, w){ return a + woJasa(w); }, 0)) + '</td>' +
      '<td class="num">' + rupiah(rows.reduce(function(a, w){ return a + woTotal(w); }, 0)) + '</td>' +
      '<td colspan="7"></td>';

    document.getElementById('summary').textContent = t('summary')
      .replace('{n}', rows.length)
      .replace('{rp}', rupiah(rows.reduce(function(a, w){ return a + woTotal(w); }, 0)));
  }

  [fBasis, fMonth, fYear, perPage].forEach(function(el){
    el.addEventListener('change', function(){ currentPage = 1; renderTable(); });
  });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });
  document.getElementById('downloadBtn').addEventListener('click', function(){ toast(t('downloadToast')); });

  /* ---------- detail ---------- */
  var woModal = document.getElementById('woModal'), activeWo = null;
  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-open]');
    if (!b) { return; }
    var w = WOS.filter(function(x){ return x.id === parseInt(b.dataset.open, 10); })[0];
    activeWo = w;
    document.getElementById('woTitle').textContent = w.ticket + ' — ' + w.pekerjaan;
    document.getElementById('woGrid').innerHTML = kvHtml([
      [t('kDistrict'), w.district], [t('kSto'), w.sto], [t('kJob'), w.pekerjaan], [t('kCoord'), w.koordinat],
      [t('kTicket'), w.ticket], [t('kHeadline'), w.headline], [t('kStatus'), statusPill(w.status)],
      [t('kSuratNo'), w.surat.no], [t('kSuratTgl'), w.surat.tgl], [t('kSuratPengirim'), w.surat.pengirim],
      [t('kSuratJudul'), w.surat.judul],
      [t('kSuratFile'), '<button type="button" class="mini-btn slate" data-demo>' + t('viewFile') + '</button>'],
      [t('kMaterial'), rupiah(woMaterial(w))], [t('kJasa'), rupiah(woJasa(w))], [t('kTotal'), rupiah(woTotal(w))],
    ]);
    document.getElementById('uraianBody').innerHTML = w.lines.map(function(l){
      return '<tr><td class="mono-cell">' + l.khs.d + '</td><td>' + l.khs.u + '</td>' +
        '<td class="num">' + rupiah(l.khs.m) + '</td><td class="num">' + rupiah(l.khs.j) + '</td>' +
        '<td class="num">' + l.qty + '</td><td>' + l.khs.s + '</td>' +
        '<td class="num">' + rupiah((l.khs.m + l.khs.j) * l.qty) + '</td></tr>';
    }).join('');
    document.getElementById('uraianTotals').innerHTML = '<td colspan="6">' + t('total') + '</td><td class="num">' + rupiah(woTotal(w)) + '</td>';
    document.getElementById('evidenceRow').innerHTML = rank(w.status) >= 2
      ? [['evBefore', '/images/dalapa/evidence/odp-before.svg'], ['evAfter', '/images/dalapa/evidence/odp-after.svg']].map(function(e){
          return '<div class="evidence-item"><div class="k">' + t(e[0]) + '</div>' +
            '<button type="button" class="thumb" data-lightbox="' + e[1] + '" data-caption="' + w.ticket + ' — ' + t(e[0]) + '">' +
            '<img src="' + e[1] + '" alt="" /></button></div>';
        }).join('')
      : '<p class="hint-muted">' + t('evNone') + '</p>';
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

  renderTable();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var qeExportTour = {
    id: 'dalapareg-qe-export',
    steps: [
      {
        target: '.filter-bar',
        pos: 'bottom',
        title: 'Filter Ekspor Data Nilai Anggaran',
        desc: 'Tentukan kriteria penarikan data berdasarkan basis klasifikasi, bulan, dan tahun pelaksanaan proyek.'
      },
      {
        target: '#downloadBtn',
        pos: 'bottom',
        title: 'Unduh Rekapitulasi Anggaran (Excel)',
        desc: 'Klik tombol ini untuk mengekspor seluruh tabel nilai anggaran proyek New Project ke dalam berkas spreadsheet.'
      },
      {
        target: 'table thead',
        pos: 'bottom',
        title: 'Tabel Master Nilai Anggaran',
        desc: 'Menampilkan data lengkap: nama project, distrik, STO, nilai material, nilai jasa, total rupiah, dan status approval TL/QE.'
      }
    ]
  };

  setTimeout(function(){
    DalapaTour.start(qeExportTour);
  }, 450);
</script>

@include('project.dalapareg.feature.partials.tour-guide')
</body>
</html>
