<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Listing GCU OLT — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .legend-row{display:flex;flex-wrap:wrap;gap:18px;padding:14px 16px;border-top:1px solid var(--border);font-size:12px;color:var(--muted)}
  .legend-row .item{display:flex;align-items:center;gap:8px}
  .legend-row .sw{width:16px;height:16px;border-radius:5px;flex-shrink:0}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'gcu-listing'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">NE / GCU OLT</div>
    <h1 data-i18n="pageTitle">Listing GCU OLT</h1>
  </div>

  <div class="stack">
    <div class="card" id="listFilterCard">
      <div class="card-body">
        <div class="row3" id="listFilterRowRegion">
          <div class="field"><label>Area</label><select id="fArea"><option>PAMASUKA</option></select></div>
          <div class="field"><label>Regional</label><select id="fRegional"><option value="">Semua</option><option>KALIMANTAN</option><option>SULAWESI</option><option>KTI</option></select></div>
          <div class="field"><label>District</label><select id="fDistrict"><option value="">Semua</option><option>District Balikpapan</option><option>District Samarinda</option><option>District Makassar</option></select></div>
        </div>
        <div class="row3" id="listFilterRowPeriod">
          <div class="field"><label>STO</label><select id="fSto"><option value="" data-i18n="allSto">Semua STO</option></select></div>
          <div class="field"><label data-i18n="fSemester">Semester</label><select id="fSemester"><option value="1">Semester 1</option><option value="2" selected>Semester 2</option></select></div>
          <div class="field"><label data-i18n="fMonth">Bulan</label><select id="fMonth"><option value="" data-i18n="allMonth">Semua Bulan</option><option selected>September</option><option>Oktober</option></select></div>
        </div>
        <div class="row3" id="listFilterRowStatus">
          <div class="field"><label data-i18n="fYear">Tahun</label><select id="fYear"><option>2026</option><option>2025</option></select></div>
          <div class="field">
            <label data-i18n="fStatus">Status</label>
            <select id="fStatus">
              <option value="" data-i18n="stAll">SEMUA</option>
              <option value="NOT_YET" data-i18n="stNotYet">BELUM LISTING</option>
              <option value="NOT_COMPLETE" data-i18n="stNotComplete">BELUM COMPLETE</option>
              <option value="COMPLETE" data-i18n="stComplete2">COMPLETE</option>
            </select>
          </div>
          <div class="field" style="align-self:end"><button class="btn-primary" id="filterBtn" style="width:100%" data-i18n="filter">Filter</button></div>
        </div>
      </div>
    </div>

    <div class="card" id="listTableCard">
      <div class="card-head"><h3>Data Listing</h3></div>
      <div class="table-toolbar" id="listTableToolbar">
        <select id="perPage"><option value="10">10 / halaman</option><option value="25">25 / halaman</option></select>
        <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari hostname / STO..." />
      </div>
      <div class="table-scroll">
        <table id="listTable">
          <thead>
            <tr>
              <th data-sort="district"><span data-i18n="cDistrict">Distrik</span><span class="arr"></span></th>
              <th data-sort="sto">STO<span class="arr"></span></th>
              <th data-sort="hostname"><span data-i18n="cOltName">Nama OLT</span><span class="arr"></span></th>
              <th data-sort="tglListing"><span data-i18n="cTglListing">Tanggal Listing</span><span class="arr"></span></th>
              <th data-i18n="cWorkforce">Workforce Listing</th>
              <th data-i18n="cStatusListing">Status Listing</th>
              <th data-i18n="cAction">Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody"></tbody>
        </table>
      </div>
      <div class="table-foot"><span id="pageInfo"></span><div class="pager" id="pager"></div></div>
      <div class="legend-row" id="listLegendRow">
        <div class="item"><span class="sw" style="background:#ef4444"></span><span data-i18n="legendRed">GPON belum di listing</span></div>
        <div class="item"><span class="sw" style="background:#fbbf24"></span><span data-i18n="legendAmber">GPON sudah di listing, namun status belum COMPLETE</span></div>
        <div class="item"><span class="sw" style="background:#84cc16"></span><span data-i18n="legendLime">GPON sudah di listing, dengan status COMPLETE</span></div>
      </div>
    </div>
  </div>
</main>

<div class="modal-backdrop" id="confirmModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="confirmTitle">Konfirmasi</h3><button class="modal-close" id="confirmX">✕</button></div>
    <div class="modal-body"><p class="hint-muted" id="confirmBody"></p></div>
    <div class="modal-foot">
      <button class="btn-outline" id="confirmCancel" data-i18n="cancel">Batal</button>
      <button class="btn-primary" id="confirmOk" data-i18n="yes2">Ya</button>
    </div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Listing GCU OLT', allSto: 'Semua STO', fSemester: 'Semester', fMonth: 'Bulan', allMonth: 'Semua Bulan',
      fYear: 'Tahun', fStatus: 'Status', stAll: 'SEMUA', stNotYet: 'BELUM LISTING', stNotComplete: 'BELUM COMPLETE', stComplete2: 'COMPLETE',
      filter: 'Filter', searchPh: 'Cari hostname / STO...',
      cDistrict: 'Distrik', cOltName: 'Nama OLT', cTglListing: 'Tanggal Listing', cWorkforce: 'Workforce Listing',
      cStatusListing: 'Status Listing', cAction: 'Aksi',
      legendRed: 'GPON belum di listing', legendAmber: 'GPON sudah di listing, namun status belum COMPLETE',
      legendLime: 'GPON sudah di listing, dengan status COMPLETE',
      lblNotYet: 'Belum Listing', lblComplete: 'Selesai', lblNotComplete: 'Belum Selesai', btnListing: 'Listing',
      confirmTitle: 'Konfirmasi', confirmListing: 'Apakah anda yakin melakukan listing dengan OLT ini?', yes2: 'Ya',
      toastAdded: 'Work order berhasil ditambahkan.',
    },
    en: {
      pageTitle: 'GCU OLT Listing', allSto: 'All STO', fSemester: 'Semester', fMonth: 'Month', allMonth: 'All Months',
      fYear: 'Year', fStatus: 'Status', stAll: 'ALL', stNotYet: 'NOT YET LISTING', stNotComplete: 'NOT COMPLETE', stComplete2: 'COMPLETE',
      filter: 'Filter', searchPh: 'Search hostname / STO...',
      cDistrict: 'District', cOltName: 'OLT Name', cTglListing: 'Listing Date', cWorkforce: 'Listing Workforce',
      cStatusListing: 'Listing Status', cAction: 'Action',
      legendRed: 'GPON has not been listed yet', legendAmber: 'GPON listed, but the status is not COMPLETE yet',
      legendLime: 'GPON listed, with COMPLETE status',
      lblNotYet: 'Not Yet Listed', lblComplete: 'Complete', lblNotComplete: 'Not Complete', btnListing: 'Listing',
      confirmTitle: 'Confirmation', confirmListing: 'Are you sure you want to create a listing for this OLT?', yes2: 'Yes',
      toastAdded: 'Work order created successfully.',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  var ROWS = [
    { district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Balikpapan Kota', hostname: 'OLT-BPN-KOTA-01', tglListing: '2026-08-02', workforce: 'Bagus Wicaksono', statusWo: 'C', expired: false },
    { district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Karang Joang', hostname: 'OLT-BPN-KJ-02', tglListing: '2026-08-20', workforce: 'Andi Saputra', statusWo: 'KS', expired: false },
    { district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Sepinggan', hostname: 'OLT-BPN-SPG-03', tglListing: '2026-08-11', workforce: 'Putri Lestari', statusWo: 'P', expired: false },
    { district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Gunung Sari', hostname: 'OLT-BPN-GS-04', tglListing: '', workforce: '-', statusWo: '', expired: false },
    { district: 'District Balikpapan', regional: 'KALIMANTAN', sto: 'STO Manggar', hostname: 'OLT-BPN-MGR-02', tglListing: '2026-06-01', workforce: 'Dewi Anggraini', statusWo: 'PTK', expired: true },
    { district: 'District Samarinda', regional: 'KALIMANTAN', sto: 'STO Samarinda Kota', hostname: 'OLT-SMD-KOTA-01', tglListing: '2026-08-30', workforce: 'Reza Pratama', statusWo: 'C', expired: false },
    { district: 'District Makassar', regional: 'SULAWESI', sto: 'STO Makassar Pusat', hostname: 'OLT-MKS-PST-01', tglListing: '', workforce: '-', statusWo: '', expired: false },
  ];

  var fStoSel = document.getElementById('fSto');
  ROWS.map(function(r){ return r.sto; }).filter(function(v, i, a){ return a.indexOf(v) === i; }).sort().forEach(function(sto){
    var opt = document.createElement('option');
    opt.textContent = sto;
    fStoSel.appendChild(opt);
  });

  function rowStatus(r){
    if (!r.tglListing) { return { cat: 'NOT_YET', color: '#ef4444', label: t('lblNotYet') }; }
    if (r.statusWo === 'C') { return { cat: 'COMPLETE', color: '#84cc16', label: t('lblComplete') }; }
    return { cat: 'NOT_COMPLETE', color: '#fbbf24', label: t('lblNotComplete') };
  }

  var sortKey = 'sto', sortDir = 'asc', currentPage = 1;
  var searchInput = document.getElementById('searchInput'), perPageSel = document.getElementById('perPage');
  var fRegional = document.getElementById('fRegional'), fDistrict = document.getElementById('fDistrict');
  var fStatus = document.getElementById('fStatus');

  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    var rows = ROWS.slice();
    if (fRegional.value) { rows = rows.filter(function(r){ return r.regional === fRegional.value; }); }
    if (fDistrict.value) { rows = rows.filter(function(r){ return r.district === fDistrict.value; }); }
    if (fStoSel.value) { rows = rows.filter(function(r){ return r.sto === fStoSel.value; }); }
    if (fStatus.value) { rows = rows.filter(function(r){ return rowStatus(r).cat === fStatus.value; }); }
    if (q) { rows = rows.filter(function(r){ return r.hostname.toLowerCase().indexOf(q) !== -1 || r.sto.toLowerCase().indexOf(q) !== -1; }); }
    rows.sort(function(a, b){
      var av = a[sortKey] || '', bv = b[sortKey] || '';
      if (av < bv) { return sortDir === 'asc' ? -1 : 1; }
      if (av > bv) { return sortDir === 'asc' ? 1 : -1; }
      return 0;
    });
    return rows;
  }

  function renderTable(){
    var rows = getFiltered();
    var perPage = parseInt(perPageSel.value, 10);
    var totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    if (currentPage > totalPages) { currentPage = totalPages; }
    var start = (currentPage - 1) * perPage;
    var page = rows.slice(start, start + perPage);

    document.getElementById('tbody').innerHTML = page.length ? page.map(function(r){
      var idx = ROWS.indexOf(r), st = rowStatus(r);
      var nameCell = '<span class="pill pill-sq" style="background:' + st.color + '22;color:' + st.color + '">' + r.hostname + '</span>' +
        (r.expired ? '<div style="color:var(--error-500);font-size:10.5px;font-weight:700;margin-top:3px">EXPIRED</div>' : '');
      var action = st.cat === 'NOT_YET'
        ? '<button class="mini-btn teal" data-listing="' + idx + '">' + t('btnListing') + '</button>'
        : '<span style="color:var(--muted);font-size:11.5px">—</span>';
      return '<tr><td>' + r.district + '</td><td>' + r.sto + '</td><td>' + nameCell + '</td>' +
        '<td>' + (r.tglListing || '-') + '</td><td>' + r.workforce + '</td>' +
        '<td><span class="pill pill-sq" style="background:' + st.color + '22;color:' + st.color + '">' + st.label + '</span></td>' +
        '<td>' + action + '</td></tr>';
    }).join('') : '<tr><td colspan="7" style="text-align:center;color:var(--muted)">-</td></tr>';

    var from = rows.length ? start + 1 : 0, to = Math.min(start + perPage, rows.length);
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
    document.querySelectorAll('thead th[data-sort]').forEach(function(th){
      th.querySelector('.arr').textContent = th.dataset.sort === sortKey ? (sortDir === 'asc' ? '▲' : '▼') : '';
    });
  }

  document.querySelectorAll('thead th[data-sort]').forEach(function(th){
    th.addEventListener('click', function(){
      var key = th.dataset.sort;
      if (sortKey === key) { sortDir = sortDir === 'asc' ? 'desc' : 'asc'; } else { sortKey = key; sortDir = 'asc'; }
      renderTable();
    });
  });
  [fRegional, fDistrict, fStoSel, fStatus, perPageSel].forEach(function(el){ el.addEventListener('change', function(){ currentPage = 1; renderTable(); }); });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  document.getElementById('filterBtn').addEventListener('click', function(){ currentPage = 1; renderTable(); });

  var confirmModal = document.getElementById('confirmModal'), confirmOk = document.getElementById('confirmOk');
  document.getElementById('tbody').addEventListener('click', function(e){
    var b = e.target.closest('[data-listing]');
    if (!b) { return; }
    var row = ROWS[parseInt(b.dataset.listing, 10)];
    document.getElementById('confirmBody').textContent = t('confirmListing');
    confirmModal.classList.add('show');
    confirmOk.onclick = function(){
      confirmModal.classList.remove('show');
      row.tglListing = new Date().toISOString().slice(0, 10);
      row.workforce = 'Reza Pratama';
      row.statusWo = 'N';
      renderTable();
      toast(t('toastAdded'));
    };
  });
  document.getElementById('confirmCancel').addEventListener('click', function(){ confirmModal.classList.remove('show'); });
  document.getElementById('confirmX').addEventListener('click', function(){ confirmModal.classList.remove('show'); });

  function onLangChange(){ renderTable(); }
  renderTable();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var gcuListingTour = {
    id: 'tifreg-gcu-listing',
    steps: [
      {
        target: '#listFilterRowRegion',
        pos: 'bottom',
        title: { id: 'Filter Wilayah Teritorial', en: 'Territory Region Filter' },
        desc: {
          id: 'Pilih Area (PAMASUKA), Regional (Kalimantan, Sulawesi, KTI), dan Distrik penugasan untuk menyaring daftar GPON/OLT.',
          en: 'Select Area (PAMASUKA), Regional territories, and Districts to filter the registered GPON/OLT list.'
        }
      },
      {
        target: '#listFilterRowPeriod',
        pos: 'bottom',
        title: { id: 'Pemilihan STO & Periode Listing', en: 'STO & Listing Period Selection' },
        desc: {
          id: 'Tentukan STO spesifik dan alokasi periode pengerjaan (Semester 1 / Semester 2 serta Bulan penugasan).',
          en: 'Specify the STO and assign work periods (Semester 1 / 2 and Target Month).'
        }
      },
      {
        target: '#listFilterRowStatus',
        pos: 'bottom',
        title: { id: 'Status Kelayakan Listing', en: 'Listing Eligibility Status' },
        desc: {
          id: 'Saring berdasarkan status pengerjaan: BELUM LISTING, BELUM COMPLETE, atau COMPLETE, lalu klik <b>Filter</b>.',
          en: 'Filter by workorder readiness: NOT YET LISTED, INCOMPLETE, or COMPLETE, then click <b>Filter</b>.'
        }
      },
      {
        target: '#listTable thead',
        pos: 'bottom',
        title: { id: 'Daftar Aset OLT & Tim Pelaksana', en: 'OLT Asset & Workforce Register' },
        desc: {
          id: 'Tabel memuat Nama OLT, tanggal listing resmi, nama teknisi/workforce pelaksana, dan badge status pengerjaan saat ini.',
          en: 'Displays OLT hostname, official listing date, assigned technician name, and current status badges.'
        }
      },
      {
        target: '#tbody tr:first-child td:last-child',
        pos: 'left',
        title: { id: 'Tombol Aksi Tambah Listing', en: 'Listing Action Trigger' },
        desc: {
          id: 'Klik tombol <b>Listing</b> pada OLT yang belum terdaftar untuk memicu pembuatan workorder baru ke teknisi lapangan.',
          en: 'Click the <b>Listing</b> button on unlisted OLTs to initiate a new workorder assignment for field technicians.'
        }
      },
      {
        target: '#listLegendRow',
        pos: 'top',
        title: { id: 'Legenda Indikator Status GPON', en: 'GPON Status Indicators Legend' },
        desc: {
          id: 'Keterangan kode warna baris: Merah (Belum Listing), Kuning (Dalam Proses / Belum Complete), dan Hijau (Telah Selesai / Complete).',
          en: 'Color legend guide: Red (Unlisted), Amber (In Progress / Incomplete), and Green (Fully Completed).'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(gcuListingTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
