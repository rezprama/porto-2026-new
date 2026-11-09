<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Organisasi — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .card-head .filters{display:flex;gap:10px;flex-wrap:wrap}
  .card-head .filters select{height:36px;border-radius:7px;border:1px solid var(--border);background:transparent;
    padding:0 10px;font-size:13px;font-family:inherit;color:var(--text);min-width:150px}
  .detail-hero{border-radius:12px;background:linear-gradient(135deg,var(--brand-500),#2f3ec7);padding:16px;
    display:flex;align-items:center;gap:12px;margin-bottom:16px}
  .detail-hero .ic{width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.2);display:grid;
    place-items:center;color:#fff;flex-shrink:0}
  .detail-hero .nm{font-size:15px;font-weight:700;color:#fff}
  .detail-hero .org{font-size:12.5px;color:rgba(255,255,255,.7)}
  .detail-hero .rv{margin-left:auto;background:rgba(255,255,255,.2);color:#fff;font-size:11px;font-weight:600;
    padding:4px 10px;border-radius:20px;white-space:nowrap}
  .scope-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:8px}
  .scope-head b{font-size:13px;color:var(--text)}
  .scope-head span{font-size:11.5px;color:var(--muted)}
  .scope-list{border:1px solid var(--border);border-radius:9px;max-height:220px;overflow-y:auto}
  .scope-row{display:flex;justify-content:space-between;align-items:center;padding:9px 12px;
    border-bottom:1px solid var(--border);font-size:13px;color:var(--label)}
  .scope-row:last-child{border-bottom:none}
  .wf-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
  .wf-head h4{font-size:13.5px;color:var(--text)}
  .wf-search{display:flex;gap:8px;margin-bottom:12px}
  .wf-search input{flex:1;height:36px;border-radius:7px;border:1px solid var(--border);background:transparent;
    padding:0 12px;font-size:13px;font-family:inherit;color:var(--text)}
  .wf-foot{display:flex;justify-content:space-between;align-items:center;margin-top:12px;font-size:12px;color:var(--muted)}
  .wf-foot .nav{display:flex;gap:6px}
  .wf-foot .nav button{height:28px;padding:0 10px;border-radius:6px;border:1px solid var(--border);
    background:var(--panel-bg);font-size:12px;color:var(--label)}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'master-org'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">Master Data</div>
    <h1 data-i18n="pageTitle">Organisasi</h1>
  </div>

  <div class="card">
    <div class="card-head">
      <h3 data-i18n="listTitle">Daftar Organisasi</h3>
      <div class="filters">
        <select id="fHierarki">
          <option value="" data-i18n="allHierarchy">Semua</option>
          <option value="ORG" data-i18n="hOrg">Organisasi</option>
          <option value="UNIT" data-i18n="hUnit">Unit</option>
        </select>
        <select id="fLevel">
          <option value="" data-i18n="allLevel">Semua</option>
          <option>NASIONAL</option>
          <option>AREA</option>
          <option>REGIONAL</option>
          <option>DISTRICT</option>
        </select>
      </div>
    </div>

    <div class="table-toolbar">
      <select id="perPage">
        <option value="10">10 / halaman</option>
        <option value="15" selected>15 / halaman</option>
        <option value="25">25 / halaman</option>
      </select>
      <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari nama organisasi / unit..." />
    </div>

    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th>Tipe</th>
            <th data-sort="name"><span data-i18n="cName">Nama</span><span class="arr"></span></th>
            <th data-sort="level"><span data-i18n="cLevel">Level</span><span class="arr"></span></th>
            <th data-sort="parent"><span data-i18n="cParent">Parent</span><span class="arr"></span></th>
            <th data-sort="created"><span data-i18n="cCreated">Tanggal Dibuat</span><span class="arr"></span></th>
            <th data-i18n="cAction">Aksi</th>
          </tr>
        </thead>
        <tbody id="orgBody"></tbody>
      </table>
    </div>
    <div class="table-foot">
      <span id="pageInfo"></span>
      <div class="pager" id="pager"></div>
    </div>
  </div>
</main>

<!-- DETAIL MODAL -->
<div class="modal-backdrop" id="detailModal">
  <div class="modal-card">
    <div class="modal-head">
      <h3 data-i18n="detailTitle">Detail Unit</h3>
      <button class="modal-close" id="detailClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="detail-hero">
        <span class="ic">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M10 6h.01M14 6h.01M10 10h.01M14 10h.01M10 14h.01M14 14h.01M10 18h.01M14 18h.01"/></svg>
        </span>
        <div>
          <div class="nm" id="dNama">—</div>
          <div class="org" id="dOrg">—</div>
        </div>
        <span class="rv" id="dReview">—</span>
      </div>
      <div class="scope-head">
        <b data-i18n="scopeTitle">Cakupan Organisasi</b>
        <span id="dScopeCount">(0 organisasi)</span>
      </div>
      <div class="scope-list" id="dScopeList"></div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="detailDone" data-i18n="close">Tutup</button>
    </div>
  </div>
</div>

<!-- UNIT FORM MODAL -->
<div class="modal-backdrop" id="formModal">
  <div class="modal-card">
    <div class="modal-head">
      <h3 id="formTitle" data-i18n="formAdd">Tambah Unit Baru</h3>
      <button class="modal-close" id="formClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="field">
        <label><span data-i18n="unitName">Nama Unit</span> <span style="color:var(--error-500)">*</span></label>
        <input id="uName" data-i18n-ph="unitNamePh" placeholder="Masukkan nama unit" />
      </div>
      <div class="field">
        <label>Type Review</label>
        <select id="uReview"><option>ALL</option><option>General</option><option>Budget</option><option>Mitra</option></select>
      </div>
      <div class="field">
        <label>Head</label>
        <select id="uHead"><option value="" data-i18n="noHead">TIDAK ADA</option><option>TIF</option><option>MITRA</option></select>
      </div>
      <div class="field">
        <label data-i18n="cLevel">Level</label>
        <select id="uLevel"><option value="" data-i18n="allLevelOpt">Semua Level</option><option>NASIONAL</option><option>AREA</option><option>REGIONAL</option><option>DISTRICT</option></select>
      </div>
      <div class="field">
        <label data-i18n="parentOrg">Organisasi</label>
        <select id="uOrg"><option value="" data-i18n="parentOrgPh">Pilih organisasi induk</option></select>
      </div>
      <div class="field">
        <label><span data-i18n="scopeLabel">Cakupan Regional</span> <span style="color:var(--muted)" data-i18n="optional">(opsional)</span></label>
        <div class="scope-list" style="max-height:150px;padding:8px 12px">
          <label style="display:flex;gap:7px;align-items:center;font-size:13px;padding:3px 0"><input type="checkbox" /> KALIMANTAN</label>
          <label style="display:flex;gap:7px;align-items:center;font-size:13px;padding:3px 0"><input type="checkbox" /> SULAWESI</label>
          <label style="display:flex;gap:7px;align-items:center;font-size:13px;padding:3px 0"><input type="checkbox" /> KTI</label>
        </div>
        <p class="hint" data-i18n="scopeHint">Kosongkan = unit meng-cover seluruh organisasinya.</p>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="formCancel" data-i18n="cancel">Batal</button>
      <button class="btn-primary" id="formSave" data-i18n="save">Simpan</button>
    </div>
  </div>
</div>

<!-- WORKFORCE MODAL -->
<div class="modal-backdrop" id="wfModal">
  <div class="modal-card modal-lg">
    <div class="modal-head">
      <h3 data-i18n="wfTitle">Kelola Pemetaan Pegawai</h3>
      <button class="modal-close" id="wfClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="wf-head">
        <h4 data-i18n="wfListTitle">Daftar Pegawai Saat Ini:</h4>
        <button class="btn-primary" id="wfAdd" style="height:32px;font-size:12.5px" data-i18n="wfAddBtn">Tambah Pegawai</button>
      </div>
      <div class="wf-search">
        <input type="text" id="wfSearch" data-i18n-ph="wfSearchPh" placeholder="Cari nama atau NIK..." />
      </div>
      <div class="table-scroll" style="border:1px solid var(--border);border-radius:9px">
        <table>
          <thead><tr><th data-i18n="cName">Nama</th><th>NIK</th><th style="text-align:right" data-i18n="cAction">Aksi</th></tr></thead>
          <tbody id="wfBody"></tbody>
        </table>
      </div>
      <div class="wf-foot">
        <span id="wfCount">(0 pegawai)</span>
        <div class="nav">
          <span id="wfPage" style="align-self:center;margin-right:6px"></span>
          <button id="wfPrev">← Prev</button>
          <button id="wfNext">Next →</button>
        </div>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="wfDone" data-i18n="close">Tutup</button>
    </div>
  </div>
</div>

<!-- CONFIRM MODAL -->
<div class="modal-backdrop" id="confirmModal">
  <div class="modal-card">
    <div class="modal-head"><h3 data-i18n="confirmTitle">Konfirmasi</h3><button class="modal-close" id="confirmX">✕</button></div>
    <div class="modal-body"><p class="hint-muted" id="confirmBody"></p></div>
    <div class="modal-foot">
      <button class="btn-outline" id="confirmCancel" data-i18n="cancel">Batal</button>
      <button class="btn-danger" id="confirmOk" data-i18n="confirmDel">Ya, Hapus!</button>
    </div>
  </div>
</div>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Organisasi', listTitle: 'Daftar Organisasi',
      allHierarchy: 'Semua', hOrg: 'Organisasi', hUnit: 'Unit', allLevel: 'Semua',
      searchPh: 'Cari nama organisasi / unit...',
      cName: 'Nama', cLevel: 'Level', cParent: 'Parent', cCreated: 'Tanggal Dibuat', cAction: 'Aksi',
      aAddUnit: '+ Unit', aDetail: 'Detail', aEdit: 'Ubah', aDelete: 'Hapus', aWorkforce: 'Pegawai',
      detailTitle: 'Detail Unit', scopeTitle: 'Cakupan Organisasi', scopeCount: 'organisasi',
      scopeEmpty: 'Belum ada cakupan organisasi.',
      formAdd: 'Tambah Unit Baru', formEdit: 'Ubah Data Unit',
      unitName: 'Nama Unit', unitNamePh: 'Masukkan nama unit', noHead: 'TIDAK ADA',
      allLevelOpt: 'Semua Level', parentOrg: 'Organisasi', parentOrgPh: 'Pilih organisasi induk',
      scopeLabel: 'Cakupan Regional', optional: '(opsional)',
      scopeHint: 'Kosongkan = unit meng-cover seluruh organisasinya.',
      nameRequired: 'Nama unit wajib diisi.',
      wfTitle: 'Kelola Pemetaan Pegawai', wfListTitle: 'Daftar Pegawai Saat Ini:',
      wfAddBtn: 'Tambah Pegawai', wfSearchPh: 'Cari nama atau NIK...', wfEmpty: 'Belum ada pegawai.',
      wfCount: 'pegawai', wfPageWord: 'Hal',
      confirmTitle: 'Konfirmasi', confirmDel: 'Ya, Hapus!',
      confirmDeleteUnit: 'Apakah Anda yakin ingin menghapus unit ini?',
      confirmDeleteWf: 'Apakah anda yakin akan menghapus pegawai ini dari organisasi?',
      addSuccess: 'Unit berhasil ditambahkan!', editSuccess: 'Unit berhasil diperbarui!',
      deleteSuccess: 'Unit berhasil dihapus!', wfDeleted: 'Pegawai berhasil dihapus dari organisasi.',
      readonlyOrg: 'Baris Organisasi hanya bisa dilihat, tidak bisa diubah.',
    },
    en: {
      pageTitle: 'Organisation', listTitle: 'Organisation List',
      allHierarchy: 'All', hOrg: 'Organisation', hUnit: 'Unit', allLevel: 'All',
      searchPh: 'Search organisation / unit name...',
      cName: 'Name', cLevel: 'Level', cParent: 'Parent', cCreated: 'Created Date', cAction: 'Action',
      aAddUnit: '+ Unit', aDetail: 'Detail', aEdit: 'Edit', aDelete: 'Delete', aWorkforce: 'Workforce',
      detailTitle: 'Unit Detail', scopeTitle: 'Organisation Scope', scopeCount: 'organisations',
      scopeEmpty: 'No organisation scope yet.',
      formAdd: 'Add New Unit', formEdit: 'Edit Unit Data',
      unitName: 'Unit Name', unitNamePh: 'Enter unit name', noHead: 'NONE',
      allLevelOpt: 'All Levels', parentOrg: 'Organisation', parentOrgPh: 'Select parent organisation',
      scopeLabel: 'Regional Scope', optional: '(optional)',
      scopeHint: 'Leave empty = the unit covers its whole organisation.',
      nameRequired: 'Unit name is required.',
      wfTitle: 'Manage Workforce Mapping', wfListTitle: 'Current Workforce:',
      wfAddBtn: 'Add Employee', wfSearchPh: 'Search name or NIK...', wfEmpty: 'No employees yet.',
      wfCount: 'employees', wfPageWord: 'Page',
      confirmTitle: 'Confirmation', confirmDel: 'Yes, Delete!',
      confirmDeleteUnit: 'Are you sure you want to delete this unit?',
      confirmDeleteWf: 'Are you sure you want to remove this employee from the organisation?',
      addSuccess: 'Unit added successfully!', editSuccess: 'Unit updated successfully!',
      deleteSuccess: 'Unit deleted successfully!', wfDeleted: 'Employee removed from the organisation.',
      readonlyOrg: 'Organisation rows are view-only and cannot be edited.',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy data: organizations (ORG, read-only) + units (UNIT, CRUD) ---------- */
  var ROWS = [
    { type: 'ORG', name: 'Nasional', level: 'NASIONAL', parent: '-', created: '2022-01-05' },
    { type: 'ORG', name: 'PAMASUKA', level: 'AREA', parent: 'Nasional', created: '2022-01-05' },
    { type: 'ORG', name: 'KALIMANTAN', level: 'REGIONAL', parent: 'PAMASUKA', created: '2022-01-06' },
    { type: 'ORG', name: 'Balikpapan', level: 'DISTRICT', parent: 'KALIMANTAN', created: '2022-01-06' },
    { type: 'ORG', name: 'Samarinda', level: 'DISTRICT', parent: 'KALIMANTAN', created: '2022-01-06' },
    { type: 'ORG', name: 'SULAWESI', level: 'REGIONAL', parent: 'PAMASUKA', created: '2022-01-07' },
    { type: 'ORG', name: 'Makassar', level: 'DISTRICT', parent: 'SULAWESI', created: '2022-01-07' },
    { type: 'ORG', name: 'KTI', level: 'REGIONAL', parent: 'PAMASUKA', created: '2022-01-07' },
    { type: 'UNIT', name: 'Unit QE Kaltimtara', level: 'REGIONAL', parent: 'KALIMANTAN', created: '2023-03-14', review: 'General', scope: ['KALIMANTAN'] },
    { type: 'UNIT', name: 'Unit Anggaran PAMASUKA', level: 'AREA', parent: 'PAMASUKA', created: '2023-05-02', review: 'Budget', scope: ['KALIMANTAN', 'SULAWESI', 'KTI'] },
    { type: 'UNIT', name: 'Unit Mitra Balikpapan', level: 'DISTRICT', parent: 'Balikpapan', created: '2024-02-19', review: 'Mitra', scope: ['Balikpapan'] },
    { type: 'UNIT', name: 'Unit NE Samarinda', level: 'DISTRICT', parent: 'Samarinda', created: '2024-06-11', review: 'General', scope: [] },
    { type: 'UNIT', name: 'Unit QE Sulsel', level: 'REGIONAL', parent: 'SULAWESI', created: '2024-09-30', review: 'ALL', scope: ['SULAWESI'] },
    { type: 'UNIT', name: 'Unit Nasional Support', level: 'NASIONAL', parent: 'Nasional', created: '2025-01-21', review: 'ALL', scope: [] },
  ];
  var ROW_LEVEL_BY_NAME = {};
  ROWS.forEach(function(r){ ROW_LEVEL_BY_NAME[r.name] = r.level; });
  var WORKFORCE = [
    { nama: 'Reza Pratama', nik: '7000123456' }, { nama: 'Ulsyairil', nik: '7101110045' },
    { nama: 'Hilman R', nik: '7101110078' }, { nama: 'Dewi Anggraini', nik: '7101110091' },
    { nama: 'Bagus Wicaksono', nik: '7101110102' }, { nama: 'Putri Lestari', nik: '7101110113' },
    { nama: 'Andi Saputra', nik: '7101110124' },
  ];

  var sortKey = 'name', sortDir = 'asc', currentPage = 1;
  var fHierarki = document.getElementById('fHierarki'), fLevel = document.getElementById('fLevel');
  var searchInput = document.getElementById('searchInput'), perPageSel = document.getElementById('perPage');

  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    var rows = ROWS.slice();
    if (fHierarki.value) { rows = rows.filter(function(r){ return r.type === fHierarki.value; }); }
    if (fLevel.value) { rows = rows.filter(function(r){ return r.level === fLevel.value; }); }
    if (q) { rows = rows.filter(function(r){ return r.name.toLowerCase().indexOf(q) !== -1; }); }
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
    var pageRows = rows.slice(start, start + perPage);

    document.getElementById('orgBody').innerHTML = pageRows.length ? pageRows.map(function(r){
      var idx = ROWS.indexOf(r);
      var badge = r.type === 'ORG'
        ? '<span class="pill pill-sq pill-blue">Org</span>'
        : '<span class="pill pill-sq pill-teal">Unit</span>';
      var actions = r.type === 'ORG'
        ? '<button class="mini-btn teal" data-act="addunit" data-i="' + idx + '">' + t('aAddUnit') + '</button>' +
          '<button class="mini-btn brand" data-act="wf" data-i="' + idx + '">' + t('aWorkforce') + '</button>'
        : '<button class="mini-btn slate" data-act="detail" data-i="' + idx + '">' + t('aDetail') + '</button>' +
          '<button class="mini-btn amber" data-act="edit" data-i="' + idx + '">' + t('aEdit') + '</button>' +
          '<button class="mini-btn red" data-act="del" data-i="' + idx + '">' + t('aDelete') + '</button>' +
          '<button class="mini-btn brand" data-act="wf" data-i="' + idx + '">' + t('aWorkforce') + '</button>';
      return '<tr><td>' + badge + '</td><td>' + r.name + '</td><td>' + (r.level || '-') + '</td>' +
        '<td>' + (r.parent || '-') + '</td><td>' + r.created + '</td>' +
        '<td><div class="row-actions">' + actions + '</div></td></tr>';
    }).join('') : '<tr><td colspan="6" style="text-align:center;color:var(--muted)">-</td></tr>';

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
  [fHierarki, fLevel, perPageSel].forEach(function(el){ el.addEventListener('change', function(){ currentPage = 1; renderTable(); }); });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });

  /* ---------- confirm ---------- */
  var confirmModal = document.getElementById('confirmModal'), confirmOk = document.getElementById('confirmOk');
  function askConfirm(body, onOk){
    document.getElementById('confirmBody').textContent = body;
    confirmModal.classList.add('show');
    confirmOk.onclick = function(){ confirmModal.classList.remove('show'); onOk(); };
  }
  document.getElementById('confirmCancel').addEventListener('click', function(){ confirmModal.classList.remove('show'); });
  document.getElementById('confirmX').addEventListener('click', function(){ confirmModal.classList.remove('show'); });

  /* ---------- detail ---------- */
  var detailModal = document.getElementById('detailModal');
  function openDetail(r){
    document.getElementById('dNama').textContent = r.name;
    document.getElementById('dOrg').textContent = r.parent;
    document.getElementById('dReview').textContent = r.review || 'ALL';
    var scope = r.scope || [];
    document.getElementById('dScopeCount').textContent = '(' + scope.length + ' ' + t('scopeCount') + ')';
    var levelPill = { NASIONAL: 'pill-purple', AREA: 'pill-blue', REGIONAL: 'pill-teal', DISTRICT: 'pill-amber' };
    document.getElementById('dScopeList').innerHTML = scope.length
      ? scope.map(function(s){
          var lv = ROW_LEVEL_BY_NAME[s] || (s.indexOf('District') === 0 ? 'DISTRICT' : 'AREA');
          return '<div class="scope-row"><span>' + s + '</span><span class="pill ' + (levelPill[lv] || 'pill-gray') + '">' + lv + '</span></div>';
        }).join('')
      : '<div class="scope-row" style="color:var(--warn-500)">' + t('scopeEmpty') + '</div>';
    detailModal.classList.add('show');
  }
  document.getElementById('detailClose').addEventListener('click', function(){ detailModal.classList.remove('show'); });
  document.getElementById('detailDone').addEventListener('click', function(){ detailModal.classList.remove('show'); });

  /* ---------- unit form ---------- */
  var formModal = document.getElementById('formModal'), editingIdx = null;
  var uOrgSel = document.getElementById('uOrg');
  ROWS.filter(function(r){ return r.type === 'ORG'; }).forEach(function(o){
    var opt = document.createElement('option');
    opt.textContent = o.name + ' (' + o.level + ')';
    uOrgSel.appendChild(opt);
  });
  function openForm(idx){
    editingIdx = idx;
    var title = document.getElementById('formTitle');
    title.dataset.i18n = idx === null ? 'formAdd' : 'formEdit';
    title.textContent = t(idx === null ? 'formAdd' : 'formEdit');
    document.getElementById('uName').value = idx === null ? '' : ROWS[idx].name;
    document.getElementById('uReview').value = idx === null ? 'ALL' : (ROWS[idx].review || 'ALL');
    document.getElementById('uHead').disabled = idx !== null;
    formModal.classList.add('show');
  }
  document.getElementById('formClose').addEventListener('click', function(){ formModal.classList.remove('show'); });
  document.getElementById('formCancel').addEventListener('click', function(){ formModal.classList.remove('show'); });
  document.getElementById('formSave').addEventListener('click', function(){
    var name = document.getElementById('uName').value.trim();
    if (!name) { toast(t('nameRequired')); return; }
    var review = document.getElementById('uReview').value;
    if (editingIdx === null) {
      ROWS.push({ type: 'UNIT', name: name, level: document.getElementById('uLevel').value || 'REGIONAL',
        parent: (uOrgSel.value || uOrgSel.options[1] || {}).textContent || 'Nasional',
        created: new Date().toISOString().slice(0, 10), review: review, scope: [] });
      toast(t('addSuccess'));
    } else {
      ROWS[editingIdx].name = name; ROWS[editingIdx].review = review;
      toast(t('editSuccess'));
    }
    formModal.classList.remove('show');
    renderTable();
  });

  /* ---------- workforce ---------- */
  var wfModal = document.getElementById('wfModal'), wfPage = 1, wfReadonly = false, WF_SIZE = 5;
  function renderWf(){
    var q = document.getElementById('wfSearch').value.trim().toLowerCase();
    var list = WORKFORCE.filter(function(w){ return !q || w.nama.toLowerCase().indexOf(q) !== -1 || w.nik.indexOf(q) !== -1; });
    var total = Math.max(1, Math.ceil(list.length / WF_SIZE));
    if (wfPage > total) { wfPage = total; }
    var slice = list.slice((wfPage - 1) * WF_SIZE, wfPage * WF_SIZE);
    document.getElementById('wfBody').innerHTML = slice.length ? slice.map(function(w){
      var act = wfReadonly ? '' : '<button class="mini-btn red" data-wf="' + w.nik + '">' + t('aDelete') + '</button>';
      return '<tr><td>' + w.nama + '</td><td class="mono-cell">' + w.nik + '</td>' +
        '<td style="text-align:right">' + act + '</td></tr>';
    }).join('') : '<tr><td colspan="3" style="text-align:center;color:var(--muted)">' + t('wfEmpty') + '</td></tr>';
    document.getElementById('wfCount').textContent = '(' + list.length + ' ' + t('wfCount') + ')';
    document.getElementById('wfPage').textContent = t('wfPageWord') + ' ' + wfPage + ' / ' + total;
    document.getElementById('wfAdd').style.display = wfReadonly ? 'none' : '';
  }
  function openWorkforce(readonly){
    wfReadonly = readonly; wfPage = 1;
    document.getElementById('wfSearch').value = '';
    renderWf();
    if (readonly) { toast(t('readonlyOrg')); }
    wfModal.classList.add('show');
  }
  document.getElementById('wfClose').addEventListener('click', function(){ wfModal.classList.remove('show'); });
  document.getElementById('wfDone').addEventListener('click', function(){ wfModal.classList.remove('show'); });
  document.getElementById('wfSearch').addEventListener('input', function(){ wfPage = 1; renderWf(); });
  document.getElementById('wfPrev').addEventListener('click', function(){ if (wfPage > 1) { wfPage--; renderWf(); } });
  document.getElementById('wfNext').addEventListener('click', function(){ wfPage++; renderWf(); });
  document.getElementById('wfAdd').addEventListener('click', function(){ toast(t('wfAddBtn') + ' — demo'); });
  document.getElementById('wfBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-wf]');
    if (!b) { return; }
    askConfirm(t('confirmDeleteWf'), function(){
      WORKFORCE = WORKFORCE.filter(function(w){ return w.nik !== b.dataset.wf; });
      renderWf(); toast(t('wfDeleted'));
    });
  });

  /* ---------- row actions ---------- */
  document.getElementById('orgBody').addEventListener('click', function(e){
    var b = e.target.closest('[data-act]');
    if (!b) { return; }
    var idx = parseInt(b.dataset.i, 10), r = ROWS[idx];
    if (b.dataset.act === 'detail') { openDetail(r); }
    else if (b.dataset.act === 'edit') { openForm(idx); }
    else if (b.dataset.act === 'addunit') { openForm(null); }
    else if (b.dataset.act === 'wf') { openWorkforce(r.type === 'ORG'); }
    else if (b.dataset.act === 'del') {
      askConfirm(t('confirmDeleteUnit'), function(){
        ROWS.splice(idx, 1); renderTable(); toast(t('deleteSuccess'));
      });
    }
  });

  function onLangChange(){ renderTable(); if (wfModal.classList.contains('show')) { renderWf(); } }
  renderTable();
  applyLang();

  /* ---------- Interactive Tour Guide ---------- */
  var masterOrgTour = {
    id: 'tifreg-master-org',
    steps: [
      {
        target: '.card-head .filters',
        pos: 'bottom',
        title: { id: 'Filter Hierarki & Level Organisasi', en: 'Hierarchy & Level Filter' },
        desc: {
          id: 'Saring daftar berdasarkan tipe struktur (Organisasi vs Unit Operasional) serta level tingkatan: Nasional, Area, Regional, atau District.',
          en: 'Filter structural entities by type (Organization vs Unit) and hierarchy levels: National, Area, Regional, or District.'
        }
      },
      {
        target: '.table-toolbar',
        pos: 'bottom',
        title: { id: 'Pencarian Unit & Limit Halaman', en: 'Unit Search & Page Limit' },
        desc: {
          id: 'Cari cepat berdasarkan nama unit atau organisasi induk, dan tentukan jumlah baris tabel yang ditampilkan per halaman.',
          en: 'Search directly by unit name or parent organization, and toggle the number of rows displayed per page.'
        }
      },
      {
        target: 'table thead',
        pos: 'bottom',
        title: { id: 'Struktur Organisasi & Hubungan Parent', en: 'Organizational Structure & Hierarchy' },
        desc: {
          id: 'Menampilkan tingkatan level, relasi unit induk (Parent), dan tanggal pembentukan organisasi dalam platform.',
          en: 'Displays hierarchy level, parent unit relationship, and registration timestamps.'
        }
      },
      {
        target: '#orgBody tr:first-child td:last-child',
        pos: 'left',
        title: { id: 'Aksi Kelola Unit & Personel Workforce', en: 'Unit Management & Workforce Actions' },
        desc: {
          id: 'Tombol aksi untuk: <b>Detail</b> (rincian lingkup kerja), <b>Edit</b> struktur, <b>Tambah Sub-Unit</b>, dan <b>Kelola Personel</b> (daftar teknisi & workforce ber-NIK).',
          en: 'Action buttons to: view <b>Detail</b> (scope breakdown), <b>Edit</b>, <b>Add Sub-Unit</b>, and <b>Manage Workforce</b> (technician personnel with NIK).'
        }
      }
    ]
  };

  setTimeout(function(){
    TourGuide.start(masterOrgTour);
  }, 450);
</script>

@include('project.tifreg.feature.partials.tour-guide')
</body>
</html>
