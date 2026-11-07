<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Manajemen Pengguna — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
<style>
  :root{
    --brand-50:#ecf3ff; --brand-500:#465fff; --brand-600:#3641f5;
    --gray-25:#fcfcfd; --gray-50:#f9fafb; --gray-100:#f2f4f7; --gray-200:#e4e7ec; --gray-300:#d0d5dd;
    --gray-400:#98a2b3; --gray-500:#667085; --gray-700:#344054; --gray-800:#1d2939; --gray-900:#101828;
    --error-500:#f04438; --success-600:#079455; --warn-500:#f79009;
    --bg:var(--gray-50); --panel-bg:#fff; --text:var(--gray-800); --label:var(--gray-700); --muted:var(--gray-400);
    --border:var(--gray-200); --shadow-xs:0 1px 2px 0 rgba(16,24,40,.05); --shadow-md:0 4px 12px rgba(16,24,40,.1);
  }
  [data-theme="dark"]{
    --bg:var(--gray-900); --panel-bg:#101828; --text:rgba(255,255,255,.9); --label:var(--gray-400);
    --muted:rgba(255,255,255,.35); --border:var(--gray-700);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:"Outfit",system-ui,sans-serif;background:var(--bg);color:var(--text);transition:background .2s,color .2s}
  button{font-family:inherit;cursor:pointer}

  /* ---------- sidebar ---------- */
  .sidebar{position:fixed;top:0;left:0;bottom:0;width:260px;background:var(--panel-bg);border-right:1px solid var(--border);
    z-index:1100;display:flex;flex-direction:column;transition:transform .25s ease}
  .sidebar .brand{display:flex;align-items:center;gap:10px;padding:18px 20px;border-bottom:1px solid var(--border)}
  .sidebar .brand img{width:30px;height:30px;object-fit:contain}
  .sidebar .brand b{font-size:15px;color:var(--text)}
  .sidebar nav{padding:18px 14px;flex:1;overflow-y:auto}
  .nav-label{font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--muted);text-transform:uppercase;padding:0 10px;margin-bottom:8px}
  .nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;font-size:14px;font-weight:500;
    color:var(--label);text-decoration:none;margin-bottom:2px;width:100%;border:none;background:none;text-align:left}
  .nav-item svg{flex-shrink:0}
  .nav-item.active{background:var(--brand-50);color:var(--brand-600)}
  [data-theme="dark"] .nav-item.active{background:color-mix(in srgb, var(--brand-500) 16%, transparent);color:#a7b6ff}
  .nav-item .chev{margin-left:auto;transition:transform .18s}
  .nav-group.open > .nav-item .chev{transform:rotate(180deg)}
  .sub-nav{max-height:0;overflow:hidden;transition:max-height .2s ease}
  .nav-group.open > .sub-nav{max-height:640px}
  .sub-nav a{display:block;padding:8px 12px 8px 41px;font-size:13.5px;color:var(--label);text-decoration:none}
  .sub-nav a:hover{color:var(--brand-500)}
  .sub-nav a.active{color:var(--brand-600);font-weight:600}
  [data-theme="dark"] .sub-nav a.active{color:#a7b6ff}

  /* ---------- nested (3rd level) submenu, e.g. NE > GCU OLT > Monitoring ---------- */
  .sub-nav .nav-group{width:100%}
  .sub-nav .nav-group > .nav-item{padding:8px 12px 8px 41px;font-size:13.5px;font-weight:500;color:var(--label);border-radius:0}
  .sub-nav .nav-group > .nav-item:hover{color:var(--brand-500)}
  .sub-nav .nav-group.open > .nav-item, .sub-nav .nav-group > .nav-item.active{background:none;color:var(--brand-600);font-weight:600}
  [data-theme="dark"] .sub-nav .nav-group.open > .nav-item, [data-theme="dark"] .sub-nav .nav-group > .nav-item.active{color:#a7b6ff}
  .sub-nav .nav-group .sub-nav a{padding-left:64px;font-size:13px}
  .sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:1090}
  @media (max-width:991px){
    .sidebar{transform:translateX(-100%)}
    .sidebar.open{transform:translateX(0)}
    .sidebar-overlay.show{display:block}
  }

  /* ---------- header ---------- */
  .topbar{position:sticky;top:0;z-index:1200;height:64px;background:var(--panel-bg);border-bottom:1px solid var(--border);
    display:flex;align-items:center;gap:14px;padding:0 16px;margin-left:260px}
  @media (max-width:991px){ .topbar{margin-left:0} }
  .hamburger{width:38px;height:38px;border:1px solid var(--border);border-radius:8px;background:none;display:none;
    align-items:center;justify-content:center;color:var(--text)}
  @media (max-width:991px){ .hamburger{display:flex} }
  .topbar .spacer{flex:1}
  .clock-pill{display:none;align-items:center;gap:8px;height:38px;padding:0 14px;border:1px solid var(--border);border-radius:9px;
    font-family:monospace;font-size:12.5px;color:var(--label)}
  @media (min-width:640px){ .clock-pill{display:flex} }
  .icbtn{width:38px;height:38px;border-radius:50%;border:1px solid var(--border);background:none;display:grid;
    place-items:center;color:var(--text)}
  .user-block{display:flex;align-items:center;gap:8px}
  .logout-btn{text-decoration:none;color:var(--label);flex-shrink:0}
  .logout-btn:hover{border-color:var(--error-500);color:var(--error-500)}
  .avatar{width:36px;height:36px;border-radius:50%;background:var(--brand-500);color:#fff;display:grid;place-items:center;
    font-weight:600;font-size:13px;flex-shrink:0}
  .user-meta{display:none;line-height:1.2}
  @media (min-width:640px){ .user-meta{display:block} }
  .user-meta .name{font-size:13.5px;font-weight:600;color:var(--text)}
  .user-meta .role{font-size:11.5px;color:var(--muted)}
  .back-badge{position:fixed;top:12px;left:50%;transform:translateX(-50%);z-index:1250;
    display:inline-flex;align-items:center;background:color-mix(in srgb, var(--gray-900) 82%, transparent);
    padding:5px;border-radius:16px;text-decoration:none;backdrop-filter:blur(6px);overflow:hidden;transition:padding .25s ease}
  .back-badge:hover{background:var(--gray-900);padding:5px 12px 5px 5px}
  .back-badge .mark{width:20px;height:20px;border-radius:50%;background:#ffffff;display:flex;align-items:center;justify-content:center;
    padding:2px;flex-shrink:0;box-shadow:0 1px 3px rgba(0,0,0,.25);overflow:hidden}
  .back-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .back-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11px;font-weight:500;
    margin-left:0;transition:max-width .25s ease,opacity .2s ease,margin-left .25s ease}
  .back-badge:hover .txt{max-width:280px;opacity:1;margin-left:7px}

  /* ---------- main content ---------- */
  main{margin-left:260px;padding:20px 20px 40px}
  @media (max-width:991px){ main{margin-left:0} }
  .page-head{margin-bottom:16px}
  .page-head h1{font-size:20px;font-weight:600;color:var(--text)}

  .tabs-strip{display:flex;flex-wrap:wrap;gap:4px;border-bottom:1px solid var(--border);margin-bottom:18px}
  .tab-btn{padding:10px 4px;margin-right:20px;background:none;border:none;border-bottom:2px solid transparent;
    font-size:13.5px;font-weight:600;color:var(--muted)}
  .tab-btn.active{color:var(--brand-600);border-bottom-color:var(--brand-500)}

  .toolbar-row{display:flex;align-items:center;gap:10px;margin-bottom:14px}
  .toolbar-row .spacer{flex:1}
  .btn-outline, .btn-primary, .btn-danger{height:38px;padding:0 16px;border-radius:8px;font-size:13.5px;font-weight:600;
    display:inline-flex;align-items:center;gap:7px}
  .btn-outline{background:var(--panel-bg);border:1px solid var(--border);color:var(--label)}
  .btn-outline.warn{color:var(--warn-500);border-color:var(--warn-500)}
  .btn-primary{background:var(--brand-500);border:none;color:#fff}
  .btn-primary:hover{background:var(--brand-600)}
  .btn-danger{background:var(--error-500);border:none;color:#fff}

  .card{background:var(--panel-bg);border:1px solid var(--border);border-radius:12px;box-shadow:var(--shadow-xs);overflow:hidden}
  .table-toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;padding:14px 16px}
  .table-toolbar select, .table-toolbar input{height:36px;border-radius:7px;border:1px solid var(--border);
    background:transparent;padding:0 10px;font-size:13px;font-family:inherit;color:var(--text)}
  .table-toolbar input{width:220px;max-width:60vw}
  .table-scroll{overflow-x:auto}
  table{width:100%;border-collapse:collapse;font-size:12.5px;white-space:nowrap}
  thead th{background:var(--gray-50);text-transform:uppercase;font-size:10.5px;letter-spacing:.04em;color:var(--muted);
    font-weight:600;text-align:left;padding:10px 14px;border-bottom:1px solid var(--border);cursor:pointer;user-select:none}
  [data-theme="dark"] thead th{background:color-mix(in srgb, var(--gray-900) 60%, var(--panel-bg))}
  thead th .arr{font-size:9px;margin-left:3px;color:var(--muted)}
  tbody td{padding:10px 14px;border-bottom:1px solid var(--border);color:var(--label)}
  tbody tr:last-child td{border-bottom:none}
  tbody tr:hover{background:color-mix(in srgb, var(--brand-500) 4%, transparent)}
  .status-active{color:var(--success-600);font-weight:600}
  .status-inactive{color:var(--muted);font-weight:600}
  .row-actions{display:flex;gap:6px}
  .icon-btn{width:28px;height:28px;border-radius:6px;border:1px solid var(--border);background:var(--panel-bg);
    display:inline-grid;place-items:center;color:var(--label)}
  .icon-btn.edit:hover{border-color:var(--brand-500);color:var(--brand-500)}
  .icon-btn.on:hover{border-color:var(--success-600);color:var(--success-600)}
  .icon-btn.off:hover{border-color:var(--warn-500);color:var(--warn-500)}
  .icon-btn.del:hover{border-color:var(--error-500);color:var(--error-500)}
  .table-foot{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;padding:12px 16px;
    border-top:1px solid var(--border);font-size:12.5px;color:var(--muted)}
  .pager{display:flex;gap:4px}
  .pager button{width:30px;height:30px;border-radius:6px;border:1px solid var(--border);background:var(--panel-bg);
    font-size:12.5px;color:var(--label)}
  .pager button.on{background:var(--brand-500);border-color:var(--brand-500);color:#fff}
  .placeholder-card{padding:40px 20px;text-align:center;color:var(--muted);font-size:13.5px}
  .pill{display:inline-block;padding:2px 9px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap}
  .pill-amber{background:#fef0c7;color:#b54708}
  .pill-scope{background:var(--brand-50);color:var(--brand-600)}
  .pill-gray{background:var(--gray-100);color:var(--gray-500)}
  [data-theme="dark"] .pill-amber{background:color-mix(in srgb,#b54708 30%,transparent);color:#fedf89}
  [data-theme="dark"] .pill-scope{background:color-mix(in srgb,var(--brand-500) 22%,transparent);color:#a7b6ff}
  [data-theme="dark"] .pill-gray{background:color-mix(in srgb,var(--gray-500) 25%,transparent);color:var(--gray-300)}
  .mono-cell{font-family:monospace;font-size:11.5px}
  .icon-btn[disabled]{opacity:.4;cursor:not-allowed}

  /* ---------- modal / form ---------- */
  .modal-backdrop{position:fixed;inset:0;background:rgba(16,24,40,.6);backdrop-filter:blur(2px);z-index:2000;
    display:none;align-items:flex-start;justify-content:center;padding:40px 16px;overflow-y:auto}
  .modal-backdrop.show{display:flex}
  .modal-card{background:var(--panel-bg);border-radius:14px;max-width:420px;width:100%;box-shadow:var(--shadow-md);
    max-height:90vh;display:flex;flex-direction:column}
  .modal-card.modal-lg{max-width:760px}
  .modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--border)}
  .modal-head h3{font-size:16px;color:var(--text)}
  .modal-close{background:none;border:none;font-size:16px;color:var(--muted);cursor:pointer}
  .modal-body{padding:20px 22px;overflow-y:auto}
  .modal-foot{display:flex;justify-content:flex-end;gap:10px;padding:16px 22px;border-top:1px solid var(--border)}
  .modal-card:not(.modal-lg) h3{font-size:16px;padding:20px 22px 0;color:var(--text);margin-bottom:10px;line-height:1.4}
  .modal-card:not(.modal-lg) .hint-muted{padding:0 22px;margin:0 0 16px;line-height:1.5}
  .modal-card:not(.modal-lg) .pw-box{margin:0 22px 4px}

  .field{margin-bottom:14px}
  .field label{display:block;font-size:12.5px;font-weight:600;color:var(--label);margin-bottom:5px}
  .field select, .field input{width:100%;height:38px;border-radius:8px;border:1px solid var(--border);background:transparent;
    padding:0 12px;font-size:13px;font-family:inherit;color:var(--text)}
  .field select:disabled{opacity:.5}
  .row2{display:grid;grid-template-columns:1fr;gap:12px}
  .row3{display:grid;grid-template-columns:1fr;gap:12px}
  @media (min-width:560px){ .row2{grid-template-columns:1fr 1fr} .row3{grid-template-columns:1fr 1fr 1fr} }
  .hint-muted{font-size:11.5px;color:var(--muted);margin:-8px 0 14px}
  .form-toolbar{margin-bottom:14px}

  .type-toggle-row{display:grid;grid-template-columns:1fr;gap:10px}
  @media (min-width:560px){ .type-toggle-row{grid-template-columns:1fr 1fr} }
  .type-card{display:flex;gap:8px;align-items:flex-start;border:1px solid var(--border);border-radius:9px;padding:10px 12px;cursor:pointer}
  .type-card input{width:15px;height:15px;margin-top:2px;accent-color:var(--brand-500)}
  .type-card b{display:block;font-size:13px;color:var(--text)}
  .type-card small{display:block;font-size:11px;color:var(--muted);margin-top:2px}
  .type-card:has(input:checked){border-color:var(--brand-500);background:var(--brand-50)}
  [data-theme="dark"] .type-card:has(input:checked){background:color-mix(in srgb, var(--brand-500) 14%, transparent)}

  .perm-groups{border:1px solid var(--border);border-radius:9px;padding:6px 0;max-height:220px;overflow-y:auto}
  .perm-group{padding:8px 14px;border-bottom:1px solid var(--border)}
  .perm-group:last-child{border-bottom:none}
  .perm-group-head{display:flex;align-items:center;gap:7px;font-size:12.5px;font-weight:600;color:var(--text);margin-bottom:6px}
  .perm-group-items{display:flex;flex-wrap:wrap;gap:8px 16px;padding-left:22px}
  .perm-group-items label{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--label)}
  .perm-group-items input, .perm-group-head input, .check-grid-3 input{width:14px;height:14px;accent-color:var(--brand-500)}
  .check-grid-3{display:grid;grid-template-columns:1fr;gap:8px}
  @media (min-width:560px){ .check-grid-3{grid-template-columns:1fr 1fr 1fr} }
  .check-grid-3 label{display:flex;align-items:center;gap:6px;font-size:13px;color:var(--label)}

  .pw-box{display:flex;gap:8px}
  .pw-box input{flex:1;height:40px;border-radius:8px;border:1px solid var(--border);padding:0 12px;
    font-family:monospace;font-size:13px;color:var(--text);background:var(--gray-50)}
  [data-theme="dark"] .pw-box input{background:var(--gray-900)}

  .toast-stack{position:fixed;bottom:16px;right:16px;z-index:3000;display:flex;flex-direction:column;gap:8px}
  .toast{background:var(--gray-900);color:#fff;font-size:13px;padding:10px 16px;border-radius:8px;box-shadow:var(--shadow-md);
    opacity:0;transform:translateY(6px);transition:opacity .2s,transform .2s}
  .toast.show{opacity:1;transform:translateY(0)}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'user'])

@include('project.tifreg.feature.partials.topbar')

  <main>
    <div class="page-head"><h1 data-i18n="pageTitle">Manajemen Pengguna</h1></div>

    <div class="tabs-strip">
      <button class="tab-btn active" data-tab="users">Users</button>
      <button class="tab-btn" data-tab="roles">Roles</button>
      <button class="tab-btn" data-tab="menus">Menus</button>
      <button class="tab-btn" data-tab="permissions">Permissions</button>
      <button class="tab-btn" data-tab="mobile">Mobile Privilege</button>
      <button class="tab-btn" data-tab="api" data-i18n="tabApi">Akses API (External)</button>
    </div>

    <div class="tab-panel" id="tabUsers">
      <div class="toolbar-row">
        <div class="spacer"></div>
        <button class="btn-outline" id="refreshBtn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-2.6-6.4M21 3v5h-5"/></svg>
          <span data-i18n="refresh">Refresh</span>
        </button>
        <button class="btn-primary" id="addBtn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
          <span data-i18n="add">Tambah</span>
        </button>
      </div>

      <div class="card">
        <div class="table-toolbar">
          <select id="perPage">
            <option value="10" data-i18n="pp10">10 / halaman</option>
            <option value="25" data-i18n="pp25">25 / halaman</option>
            <option value="50" data-i18n="pp50">50 / halaman</option>
          </select>
          <input type="text" id="searchInput" data-i18n-ph="searchPh" placeholder="Cari nama, NIK, email..." />
        </div>
        <div class="table-scroll">
          <table>
            <thead>
              <tr>
                <th data-sort="nik">NIK<span class="arr"></span></th>
                <th data-sort="nama"><span data-i18n="cName">Nama</span><span class="arr"></span></th>
                <th data-sort="email">Email<span class="arr"></span></th>
                <th data-sort="roleName">Role<span class="arr"></span></th>
                <th data-sort="area">Area<span class="arr"></span></th>
                <th data-sort="regional">Regional<span class="arr"></span></th>
                <th data-sort="distrik"><span data-i18n="cDistrict">Distrik</span><span class="arr"></span></th>
                <th data-sort="unit"><span data-i18n="cUnit">Unit Organisasi</span><span class="arr"></span></th>
                <th data-sort="sto">STO<span class="arr"></span></th>
                <th>2FA</th>
                <th data-sort="active"><span data-i18n="cStatus">Status</span><span class="arr"></span></th>
                <th data-sort="created"><span data-i18n="cCreated">Dibuat Pada</span><span class="arr"></span></th>
                <th data-sort="updated"><span data-i18n="cUpdated">Diubah Pada</span><span class="arr"></span></th>
                <th data-i18n="cAction">Aksi</th>
              </tr>
            </thead>
            <tbody id="userTbody"></tbody>
          </table>
        </div>
        <div class="table-foot">
          <span id="pageInfo"></span>
          <div class="pager" id="pager"></div>
        </div>
      </div>
    </div>

    <div class="tab-panel" id="tabRoles" hidden></div>
    <div class="tab-panel" id="tabMenus" hidden></div>
    <div class="tab-panel" id="tabPermissions" hidden></div>
    <div class="tab-panel" id="tabMobile" hidden></div>
    <div class="tab-panel" id="tabApi" hidden></div>
  </main>

  <!-- CREATE / EDIT MODAL -->
  <div class="modal-backdrop" id="userModal">
    <div class="modal-card modal-lg">
      <div class="modal-head">
        <h3 id="modalTitle" data-i18n="addUser">Tambah User</h3>
        <button class="modal-close" id="modalClose">✕</button>
      </div>
      <div class="modal-body">
        <div class="form-toolbar" id="pwToolbar" style="display:none">
          <button type="button" class="btn-outline warn" id="resetPwBtn" data-i18n="changePw">Ubah Password</button>
        </div>

        <div class="row2">
          <div class="field"><label>NIK <span style="color:var(--error-500)">*</span></label><input id="fNik" data-i18n-ph="nikPh" placeholder="Masukkan NIK" /></div>
          <div class="field"><label><span data-i18n="fullName">Nama Lengkap</span> <span style="color:var(--error-500)">*</span></label><input id="fNama" data-i18n-ph="namePh" placeholder="Masukkan nama lengkap" /></div>
        </div>
        <div class="field"><label>Email <span style="color:var(--error-500)">*</span></label><input id="fEmail" data-i18n-ph="emailPh" placeholder="nama@perusahaan.com" /></div>
        <div class="row2">
          <div class="field"><label><span data-i18n="contact">No. Kontak</span> <span style="color:var(--error-500)">*</span></label><input id="fKontak" placeholder="08xxxxxxxxxx" /></div>
          <div class="field"><label>Telegram Chat ID <span style="color:var(--error-500)">*</span></label><input id="fTelegram" data-i18n-ph="telegramPh" placeholder="Dari bot @dalapa_helper_bot" /></div>
        </div>

        <div class="field">
          <label><span data-i18n="accountType">Tipe Akun</span> <span style="color:var(--error-500)">*</span></label>
          <div class="type-toggle-row">
            <label class="type-card">
              <input type="radio" name="tipeAkun" value="DALAPA" checked />
              <div><b data-i18n="accDalapa">Akun DALAPA</b><small data-i18n="accDalapaHint">Login dengan username dan password DALAPA. Password diganti oleh admin.</small></div>
            </label>
            <label class="type-card">
              <input type="radio" name="tipeAkun" value="LDAP" />
              <div><b data-i18n="accLdap">Akun LDAP</b><small data-i18n="accLdapHint">Password dikelola oleh tim Helpdesk, tidak lewat DALAPA.</small></div>
            </label>
          </div>
        </div>

        <div class="field">
          <label>Role <span style="color:var(--error-500)">*</span></label>
          <select id="fRole"></select>
        </div>

        <div class="row3" id="scopeRow">
          <div class="field"><label>Area</label><select id="mArea"><option value="" data-i18n="phArea">Pilih Area</option><option>PAMASUKA</option></select></div>
          <div class="field"><label>Regional</label><select id="mRegional" disabled><option value="" data-i18n="phRegional">Pilih Regional</option></select></div>
          <div class="field"><label>District</label><select id="mDistrict" disabled><option value="" data-i18n="phDistrict">Pilih District</option></select></div>
        </div>
        <div class="row2">
          <div class="field"><label data-i18n="cUnit">Unit Organisasi</label><select id="mUnit"><option value="" data-i18n="noUnit">Tanpa Unit</option><option>Network Operation</option><option>Asset Management</option><option>Field Services</option><option>IT Development</option></select></div>
          <div class="field" id="stoField" style="display:none"><label>STO</label><select id="mSto"><option value="" data-i18n="phSto">Pilih STO</option></select></div>
        </div>

        <div class="field">
          <label data-i18n="webPerm">Web Permissions</label>
          <p class="hint-muted" style="margin-top:0"><span data-i18n="webPermHint">Permission yang dipilih di sini akan menjadi override untuk user ini. Akses bisa ditambahkan atau dicabut dari permission bawaan role.</span></p>
          <div class="perm-groups" id="permGroups"></div>
        </div>

        <div class="field">
          <label data-i18n="mobilePriv">Mobile Privileges</label>
          <div class="check-grid-3">
            <label><input type="checkbox" data-mp="login" /> <span data-i18n="mpLogin">Login Mobile</span></label>
            <label><input type="checkbox" data-mp="survey" /> <span data-i18n="mpSurvey">Survey Alpro</span></label>
            <label><input type="checkbox" data-mp="approval" /> <span data-i18n="mpApproval">Approval Mobile</span></label>
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-outline" id="resetFormBtn" data-i18n="reset">Reset</button>
        <button class="btn-primary" id="saveBtn" data-i18n="save">Simpan</button>
      </div>
    </div>
  </div>

  <!-- GENERATED PASSWORD MODAL -->
  <div class="modal-backdrop" id="pwModal">
    <div class="modal-card">
      <h3 data-i18n="pwTitle">Password Sementara</h3>
      <p class="hint-muted" data-i18n="pwBody">Password sementara ini hanya ditampilkan sekali, berlaku 24 jam, dan wajib diganti saat login. Salin lalu berikan secara aman kepada user.</p>
      <div class="pw-box">
        <input type="text" id="pwValue" readonly />
        <button type="button" class="btn-primary" id="copyPwBtn" data-i18n="copyPw">Salin Password</button>
      </div>
      <div class="modal-foot"><button class="btn-outline" id="pwDone" data-i18n="done">Selesai</button></div>
    </div>
  </div>

  <!-- CONFIRM MODAL -->
  <div class="modal-backdrop" id="confirmModal">
    <div class="modal-card">
      <h3 data-i18n="confirmTitle">Apakah Anda yakin?</h3>
      <p class="hint-muted" id="confirmBody"></p>
      <div class="modal-foot">
        <button class="btn-outline" id="confirmCancel" data-i18n="cancel">Batal</button>
        <button class="btn-danger" id="confirmOk">Ya</button>
      </div>
    </div>
  </div>

<script>
  /* ---------- i18n ---------- */
  var PAGE_I18N = {
    id: {
      navMaterial: 'Tracking Material', navDataSearch: 'Cari Data', navOrganisasi: 'Organisasi',
      navStock: 'Stock Opname', navB2B: 'Monitoring B2B', navProject: 'List Project',
      navBudget: 'Anggaran', navUser: 'Manajemen Pengguna', logout: 'Keluar', localeLabel: 'Bahasa Indonesia',
      pageTitle: 'Manajemen Pengguna', refresh: 'Refresh', add: 'Tambah',
      pp10: '10 / halaman', pp25: '25 / halaman', pp50: '50 / halaman', searchPh: 'Cari nama, NIK, email...',
      cName: 'Nama', cDistrict: 'Distrik', cUnit: 'Unit Organisasi', cStatus: 'Status',
      cCreated: 'Dibuat Pada', cUpdated: 'Diubah Pada', cAction: 'Aksi', cDesc: 'Deskripsi',
      cDefaultRole: 'Default Role', cScope: 'Scope Profil', cHead: 'Head', cCode: 'Kode',
      cNameEn: 'Nama (EN)', cIcon: 'Ikon', cParent: 'Parent', cRoute: 'Route', cOrder: 'Urutan',
      cMenu: 'Menu', cMenuName: 'Nama Menu', cSystem: 'Nama Sistem', cUser: 'User',
      cIp: 'IP Allow-list', cToken: 'Token',
      addUser: 'Tambah User', editUser: 'Ubah User', changePw: 'Ubah Password',
      nikPh: 'Masukkan NIK', fullName: 'Nama Lengkap', namePh: 'Masukkan nama lengkap',
      emailPh: 'nama@perusahaan.com', contact: 'No. Kontak', telegramPh: 'Dari bot @dalapa_helper_bot',
      accountType: 'Tipe Akun', accDalapa: 'Akun DALAPA',
      accDalapaHint: 'Login dengan username dan password DALAPA. Password diganti oleh admin.',
      accLdap: 'Akun LDAP', accLdapHint: 'Password dikelola oleh tim Helpdesk, tidak lewat DALAPA.',
      phArea: 'Pilih Area', phRegional: 'Pilih Regional', phDistrict: 'Pilih District', phSto: 'Pilih STO',
      noUnit: 'Tanpa Unit', webPerm: 'Web Permissions',
      webPermHint: 'Permission yang dipilih di sini akan menjadi override untuk user ini. Akses bisa ditambahkan atau dicabut dari permission bawaan role.',
      mobilePriv: 'Mobile Privileges', mpLogin: 'Login Mobile', mpSurvey: 'Survey Alpro', mpApproval: 'Approval Mobile',
      reset: 'Reset', save: 'Simpan',
      pwTitle: 'Password Sementara',
      pwBody: 'Password sementara ini hanya ditampilkan sekali, berlaku 24 jam, dan wajib diganti saat login. Salin lalu berikan secara aman kepada user.',
      copyPw: 'Salin Password', done: 'Selesai',
      confirmTitle: 'Apakah Anda yakin?', cancel: 'Batal',
      cfEnable: 'Anda akan mengaktifkan data ini!', cfEnableOk: 'Ya, aktifkan!',
      cfDisable: 'Anda akan menonaktifkan data ini!', cfDisableOk: 'Ya, nonaktifkan!',
      cfDelUser: 'Anda tidak akan bisa mengembalikan user ini!', cfDelData: 'Anda tidak akan bisa mengembalikan data ini!',
      cfDelOk: 'Ya, hapus!',
      cfResetPw: 'Reset password pengguna ini? Semua sesi aktif akan dikeluarkan dan pengguna wajib mengganti password sementara dalam 24 jam.',
      toastRefresh: 'Data berhasil dimuat ulang.', toastRequired: 'Lengkapi field yang wajib diisi (NIK, Nama, Email, Role).',
      toastUpdated: 'User berhasil diupdate.', toastAdded: 'User berhasil ditambahkan.',
      toastEnabled: 'Data berhasil diaktifkan.', toastDisabled: 'Data berhasil dinonaktifkan.',
      toastDeleted: 'User berhasil dihapus.', toastDataDeleted: 'Data berhasil dihapus.',
      toastPwCopied: 'Password berhasil disalin.', toastEditNa: 'Form ubah belum tersedia pada demo ini.',
      toastFormNa: 'Form ini belum tersedia pada demo ini.',
      toastMenuSync: 'Menu berhasil disinkronkan.', toastPermSync: 'Permission berhasil disinkronkan.',
      yes: 'Ya', no: 'Tidak', active: 'Aktif', inactive: 'Tidak Aktif', of: 'dari', rowsWord: 'data',
      edit: 'Ubah', delete: 'Hapus', enable: 'Aktifkan', disable: 'Nonaktifkan',
      syncMenu: 'Sinkronkan Menu', syncPerm: 'Sinkronkan Permission',
      lockSuperadmin: 'SUPERADMIN tidak perlu diedit karena otomatis memiliki akses penuh.',
      tabApi: 'Akses API (External)',
    },
    en: {
      navMaterial: 'Material Tracking', navDataSearch: 'Search Data', navOrganisasi: 'Organisation',
      navStock: 'Stock Taking', navB2B: 'B2B Monitoring', navProject: 'Project List',
      navBudget: 'Budget', navUser: 'User Management', logout: 'Logout', localeLabel: 'English',
      pageTitle: 'User Management', refresh: 'Refresh', add: 'Add',
      pp10: '10 / page', pp25: '25 / page', pp50: '50 / page', searchPh: 'Search name, NIK, email...',
      cName: 'Name', cDistrict: 'District', cUnit: 'Organization Unit', cStatus: 'Status',
      cCreated: 'Created At', cUpdated: 'Updated At', cAction: 'Action', cDesc: 'Description',
      cDefaultRole: 'Default Role', cScope: 'Scope Profile', cHead: 'Head', cCode: 'Code',
      cNameEn: 'Name (EN)', cIcon: 'Icon', cParent: 'Parent', cRoute: 'Route', cOrder: 'Order',
      cMenu: 'Menu', cMenuName: 'Menu Name', cSystem: 'System Name', cUser: 'User',
      cIp: 'IP Allow-list', cToken: 'Token',
      addUser: 'Add User', editUser: 'Edit User', changePw: 'Change Password',
      nikPh: 'Enter NIK', fullName: 'Full Name', namePh: 'Enter full name',
      emailPh: 'name@company.com', contact: 'Contact No.', telegramPh: 'From @dalapa_helper_bot',
      accountType: 'Account Type', accDalapa: 'DALAPA Account',
      accDalapaHint: 'Login with DALAPA username and password. Password is reset by an admin.',
      accLdap: 'LDAP Account', accLdapHint: 'Password is managed by the Helpdesk team, not through DALAPA.',
      phArea: 'Select Area', phRegional: 'Select Regional', phDistrict: 'Select District', phSto: 'Select STO',
      noUnit: 'No Unit', webPerm: 'Web Permissions',
      webPermHint: 'Permissions selected here override this user’s defaults. Access can be added or revoked from the role’s built-in permissions.',
      mobilePriv: 'Mobile Privileges', mpLogin: 'Mobile Login', mpSurvey: 'Alpro Survey', mpApproval: 'Mobile Approval',
      reset: 'Reset', save: 'Save',
      pwTitle: 'Temporary Password',
      pwBody: 'This temporary password is shown only once, valid for 24 hours, and must be changed at login. Copy it and hand it over securely to the user.',
      copyPw: 'Copy Password', done: 'Done',
      confirmTitle: 'Are you sure?', cancel: 'Cancel',
      cfEnable: 'You are about to activate this record!', cfEnableOk: 'Yes, activate!',
      cfDisable: 'You are about to deactivate this record!', cfDisableOk: 'Yes, deactivate!',
      cfDelUser: 'You will not be able to restore this user!', cfDelData: 'You will not be able to restore this record!',
      cfDelOk: 'Yes, delete!',
      cfResetPw: 'Reset this user’s password? All active sessions will be signed out and the user must change the temporary password within 24 hours.',
      toastRefresh: 'Data reloaded successfully.', toastRequired: 'Please complete the required fields (NIK, Name, Email, Role).',
      toastUpdated: 'User updated successfully.', toastAdded: 'User added successfully.',
      toastEnabled: 'Record activated successfully.', toastDisabled: 'Record deactivated successfully.',
      toastDeleted: 'User deleted successfully.', toastDataDeleted: 'Record deleted successfully.',
      toastPwCopied: 'Password copied successfully.', toastEditNa: 'The edit form is not available in this demo.',
      toastFormNa: 'This form is not available in this demo.',
      toastMenuSync: 'Menus synchronized successfully.', toastPermSync: 'Permissions synchronized successfully.',
      yes: 'Yes', no: 'No', active: 'Active', inactive: 'Inactive', of: 'of', rowsWord: 'records',
      edit: 'Edit', delete: 'Delete', enable: 'Activate', disable: 'Deactivate',
      syncMenu: 'Sync Menus', syncPerm: 'Sync Permissions',
      lockSuperadmin: 'SUPERADMIN does not need editing — it automatically has full access.',
      tabApi: 'API Access (External)',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- confirm dialog (generic) ---------- */
  var confirmModal = document.getElementById('confirmModal'), confirmOk = document.getElementById('confirmOk');
  function askConfirm(body, okLabel, onOk){
    document.getElementById('confirmBody').textContent = body;
    confirmOk.textContent = okLabel;
    confirmModal.classList.add('show');
    confirmOk.onclick = function(){ confirmModal.classList.remove('show'); onOk(); };
  }
  document.getElementById('confirmCancel').addEventListener('click', function(){ confirmModal.classList.remove('show'); });

  /* ---------- secondary tabs: dummy datasets + generic table renderer ---------- */
  var TABS = {
    roles: {
      panel: 'tabRoles',
      toolbar: [{ label: 'add', kind: 'primary' }],
      lockedKey: 'nama', lockedValue: 'Superadmin',
      lockMsg: 'lockSuperadmin',
      cols: [
        { key: 'nama', label: 'cName' },
        { key: 'deskripsi', label: 'cDesc' },
        { key: 'defaultRole', label: 'cDefaultRole', type: 'pill-amber' },
        { key: 'scope', label: 'cScope', type: 'pill-scope' },
        { key: 'head', label: 'cHead' },
        { key: 'active', label: 'cStatus', type: 'status' },
      ],
      rows: [
        { nama: 'Superadmin', deskripsi: 'Akses penuh ke seluruh modul', defaultRole: 'Ya', scope: 'Superadmin', head: '-', active: true },
        { nama: 'Admin Area', deskripsi: 'Kelola data pada lingkup area', defaultRole: '', scope: 'Area', head: 'Reza Pratama', active: true },
        { nama: 'Admin Regional', deskripsi: 'Kelola data pada lingkup regional', defaultRole: '', scope: 'Regional', head: 'Ulsyairil', active: true },
        { nama: 'Admin District', deskripsi: 'Kelola data pada lingkup district', defaultRole: '', scope: 'Distrik', head: 'Dewi Anggraini', active: true },
        { nama: 'Mitra TL', deskripsi: 'Team Leader mitra pada lingkup STO', defaultRole: '', scope: 'STO', head: 'Bagus Wicaksono', active: true },
        { nama: 'Mitra Admin', deskripsi: 'Admin mitra pada lingkup STO', defaultRole: '', scope: 'STO', head: 'Putri Lestari', active: true },
        { nama: 'Guest / Viewer', deskripsi: 'Hanya melihat data, tanpa aksi ubah', defaultRole: 'Ya', scope: 'Guest', head: '-', active: true },
        { nama: 'Teknisi Lapangan', deskripsi: 'Akses mobile untuk survey & update lapangan', defaultRole: '', scope: 'Tanpa Scope', head: 'Andi Saputra', active: false },
      ],
    },
    menus: {
      panel: 'tabMenus',
      toolbar: [{ label: 'syncMenu', kind: 'outline', toast: 'toastMenuSync' }, { label: 'add', kind: 'primary' }],
      cols: [
        { key: 'code', label: 'cCode', type: 'mono' },
        { key: 'nama', label: 'cName' },
        { key: 'enName', label: 'cNameEn' },
        { key: 'icon', label: 'cIcon', type: 'mono' },
        { key: 'parent', label: 'cParent' },
        { key: 'route', label: 'cRoute', type: 'mono' },
        { key: 'order', label: 'cOrder' },
        { key: 'active', label: 'cStatus', type: 'status' },
      ],
      rows: [
        { code: 'map-alpro', nama: 'Map Alpro', enName: 'Map Alpro', icon: 'fas map', parent: '-', route: 'map-alpro.index', order: 1, active: true },
        { code: 'ne', nama: 'NE', enName: 'NE', icon: 'fas server', parent: '-', route: '-', order: 2, active: true },
        { code: 'ne-gcu-olt', nama: 'GCU OLT', enName: 'GCU OLT', icon: 'fas microchip', parent: 'NE', route: 'ne.gcu-olt.index', order: 1, active: true },
        { code: 'ne-tracking-material', nama: 'Tracking Material', enName: 'Material Tracking', icon: 'fas boxes', parent: 'NE', route: 'ne.material.index', order: 2, active: true },
        { code: 'nte', nama: 'NTE', enName: 'NTE', icon: 'fas shield', parent: '-', route: '-', order: 3, active: true },
        { code: 'nte-stock-opname', nama: 'Stock Opname', enName: 'Stock Opname', icon: 'fas clipboard', parent: 'NTE', route: 'nte.stock.index', order: 1, active: true },
        { code: 'qe', nama: 'QE', enName: 'QE', icon: 'fas helmet-safety', parent: '-', route: '-', order: 4, active: true },
        { code: 'qe-list-project', nama: 'List Project', enName: 'Project List', icon: 'fas list-check', parent: 'QE', route: 'qe.project.index', order: 1, active: true },
        { code: 'qe-anggaran', nama: 'Anggaran', enName: 'Budget', icon: 'fas money-bill', parent: 'QE', route: 'qe.budget.index', order: 2, active: true },
        { code: 'master-data', nama: 'Master Data', enName: 'Master Data', icon: 'fas database', parent: '-', route: '-', order: 5, active: true },
        { code: 'user-management', nama: 'Manajemen Pengguna', enName: 'User Management', icon: 'fas users-gear', parent: '-', route: 'user-management.index', order: 6, active: true },
        { code: 'nte-monitoring-b2b', nama: 'Monitoring B2B', enName: 'B2B Monitoring', icon: 'fas chart-line', parent: 'NTE', route: 'nte.b2b.index', order: 2, active: false },
      ],
    },
    permissions: {
      panel: 'tabPermissions',
      toolbar: [{ label: 'syncPerm', kind: 'outline', toast: 'toastPermSync' }, { label: 'add', kind: 'primary' }],
      cols: [
        { key: 'menu', label: 'cMenu' },
        { key: 'code', label: 'cCode', type: 'mono' },
        { key: 'nama', label: 'cName' },
        { key: 'enName', label: 'cNameEn' },
      ],
      rows: [
        { menu: 'Map Alpro', code: 'api.map.view', nama: 'Lihat Peta', enName: 'View Map' },
        { menu: 'Map Alpro', code: 'api.map.export', nama: 'Export Data Peta', enName: 'Export Map Data' },
        { menu: 'NE — GCU OLT', code: 'api.ne.gcu.view', nama: 'Lihat GCU OLT', enName: 'View GCU OLT' },
        { menu: 'NE — GCU OLT', code: 'api.ne.gcu.approve', nama: 'Approve Work Order', enName: 'Approve Work Order' },
        { menu: 'NE — Tracking Material', code: 'api.ne.material.view', nama: 'Lihat Tracking Material', enName: 'View Material Tracking' },
        { menu: 'NTE — Stock Opname', code: 'api.nte.stock.view', nama: 'Lihat Stock Opname', enName: 'View Stock Opname' },
        { menu: 'QE — List Project', code: 'api.qe.project.view', nama: 'Lihat List Project', enName: 'View Project List' },
        { menu: 'QE — List Project', code: 'api.qe.project.approve', nama: 'Approve Project', enName: 'Approve Project' },
        { menu: 'QE — Anggaran', code: 'api.qe.budget.view', nama: 'Lihat Anggaran', enName: 'View Budget' },
        { menu: 'Manajemen Pengguna', code: 'api.user.create', nama: 'Tambah User', enName: 'Create User' },
        { menu: 'Manajemen Pengguna', code: 'api.user.update', nama: 'Ubah User', enName: 'Update User' },
        { menu: 'Manajemen Pengguna', code: 'api.user.delete', nama: 'Hapus User', enName: 'Delete User' },
      ],
    },
    mobile: {
      panel: 'tabMobile',
      toolbar: [{ label: 'add', kind: 'primary' }],
      cols: [
        { key: 'nama', label: 'cMenuName' },
        { key: 'code', label: 'cCode', type: 'mono' },
        { key: 'active', label: 'cStatus', type: 'status' },
        { key: 'created', label: 'cCreated' },
      ],
      rows: [
        { nama: 'Login Mobile', code: 'mobile.login', active: true, created: '2024-02-11 09:00' },
        { nama: 'Survey Alpro', code: 'mobile.survey', active: true, created: '2024-02-11 09:02' },
        { nama: 'Update Status Gangguan', code: 'mobile.gangguan', active: true, created: '2024-05-20 13:41' },
        { nama: 'Stock Opname Mobile', code: 'mobile.stock', active: true, created: '2025-01-08 08:25' },
        { nama: 'Approval Mobile', code: 'mobile.approval', active: false, created: '2025-07-14 10:10' },
      ],
    },
    api: {
      panel: 'tabApi',
      toolbar: [{ label: 'add', kind: 'primary' }],
      cols: [
        { key: 'sistem', label: 'cSystem' },
        { key: 'deskripsi', label: 'cDesc' },
        { key: 'user', label: 'cUser' },
        { key: 'ip', label: 'cIp', type: 'mono' },
        { key: 'token', label: 'cToken', type: 'mono' },
        { key: 'active', label: 'cStatus', type: 'status' },
        { key: 'created', label: 'cCreated' },
      ],
      rows: [
        { sistem: 'TOMMAN', deskripsi: 'Integrasi tiket gangguan', user: 'Reza Pratama', ip: '10.14.2.0/24', token: 'dlp_••••4f2a', active: true, created: '2025-03-12 09:30' },
        { sistem: 'MyIndiHome Ops', deskripsi: 'Sinkronisasi data ODP', user: 'Ulsyairil', ip: '10.20.5.11', token: 'dlp_••••9b71', active: true, created: '2025-06-01 14:05' },
        { sistem: 'Dashboard Nasional', deskripsi: 'Feed KPI regional', user: 'Hilman R', ip: '10.8.1.0/24', token: 'dlp_••••2c58', active: true, created: '2025-09-20 08:15' },
        { sistem: 'Legacy DalapaRegional', deskripsi: 'Migrasi data lama', user: 'Reza Pratama', ip: '10.14.9.7', token: 'dlp_••••7e10', active: false, created: '2024-11-05 16:40' },
      ],
    },
  };

  function cellHtml(col, row){
    var val = row[col.key];
    if (col.type === 'status') { return '<span class="' + (val ? 'status-active' : 'status-inactive') + '">' + (val ? t('active') : t('inactive')) + '</span>'; }
    if (col.type === 'mono') { return '<span class="mono-cell">' + val + '</span>'; }
    if (col.type === 'pill-amber') { return val ? '<span class="pill pill-amber">' + val + '</span>' : '<span class="pill pill-gray">' + t('no') + '</span>'; }
    if (col.type === 'pill-scope') { return '<span class="pill pill-scope">' + val + '</span>'; }
    return val;
  }

  function renderTab(key){
    var cfg = TABS[key];
    var panel = document.getElementById(cfg.panel);
    var toolbar = '<div class="toolbar-row"><div class="spacer"></div>' + cfg.toolbar.map(function(b, i){
      return '<button class="btn-' + b.kind + '" data-tb="' + key + ':' + i + '">' + t(b.label) + '</button>';
    }).join('') + '</div>';

    var thead = '<tr>' + cfg.cols.map(function(c){ return '<th style="cursor:default">' + t(c.label) + '</th>'; }).join('') + '<th style="cursor:default">' + t('cAction') + '</th></tr>';

    var tbody = cfg.rows.length ? cfg.rows.map(function(row, idx){
      var locked = cfg.lockedKey && row[cfg.lockedKey] === cfg.lockedValue;
      return '<tr>' + cfg.cols.map(function(c){ return '<td>' + cellHtml(c, row) + '</td>'; }).join('') +
        '<td><div class="row-actions">' +
          '<button class="icon-btn edit" data-row="' + key + ':' + idx + ':edit"' + (locked ? ' disabled' : '') + ' title="' + t('edit') + '"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg></button>' +
          '<button class="icon-btn del" data-row="' + key + ':' + idx + ':del"' + (locked ? ' disabled' : '') + ' title="' + t('delete') + '"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg></button>' +
        '</div></td></tr>';
    }).join('') : '<tr><td colspan="' + (cfg.cols.length + 1) + '" style="text-align:center;color:var(--muted)">-</td></tr>';

    panel.innerHTML = toolbar +
      '<div class="card"><div class="table-scroll"><table><thead>' + thead + '</thead><tbody>' + tbody + '</tbody></table></div>' +
      '<div class="table-foot"><span>' + cfg.rows.length + ' ' + t('rowsWord') + '</span></div></div>';
  }

  Object.keys(TABS).forEach(renderTab);

  document.addEventListener('click', function(e){
    var tb = e.target.closest('[data-tb]');
    if (tb) {
      var parts = tb.dataset.tb.split(':');
      var btn = TABS[parts[0]].toolbar[parseInt(parts[1], 10)];
      toast(btn.toast ? t(btn.toast) : t('toastFormNa'));
      return;
    }
    var rowBtn = e.target.closest('[data-row]');
    if (rowBtn && !rowBtn.disabled) {
      var p = rowBtn.dataset.row.split(':');
      var cfg = TABS[p[0]], idx = parseInt(p[1], 10);
      if (p[2] === 'edit') { toast(t('toastEditNa')); }
      else {
        askConfirm(t('cfDelData'), t('cfDelOk'), function(){
          cfg.rows.splice(idx, 1); renderTab(p[0]); toast(t('toastDataDeleted'));
        });
      }
    }
  });

  /* ---------- tabs ---------- */
  document.querySelectorAll('.tab-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
      document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
      btn.classList.add('active');
      var tab = btn.dataset.tab;
      document.getElementById('tabUsers').hidden = tab !== 'users';
      Object.keys(TABS).forEach(function(k){ document.getElementById(TABS[k].panel).hidden = tab !== k; });
    });
  });

  /* ---------- roles ---------- */
  var ROLES = [
    { code:'superadmin', name:'Superadmin', scope:'none' },
    { code:'area', name:'Admin Area', scope:'area' },
    { code:'regional', name:'Admin Regional', scope:'regional' },
    { code:'district', name:'Admin District', scope:'district' },
    { code:'mitra_tl', name:'Mitra TL', scope:'sto' },
    { code:'mitra_admin', name:'Mitra Admin', scope:'sto' },
    { code:'guest', name:'Guest / Viewer', scope:'none' },
  ];
  var ROLE_MAP = {}; ROLES.forEach(function(r){ ROLE_MAP[r.code] = r; });
  var fRole = document.getElementById('fRole');
  ROLES.forEach(function(r){ var o = document.createElement('option'); o.value = r.code; o.textContent = r.name; fRole.appendChild(o); });

  /* ---------- permission groups (dummy) ---------- */
  var PERMISSION_GROUPS = [
    { group:'Map Alpro', items:[['map.view','Lihat Peta'],['map.export','Export Data']] },
    { group:'NE', items:[['ne.gcu','Lihat GCU OLT'],['ne.material','Lihat Tracking Material']] },
    { group:'QE', items:[['qe.list','Lihat List Project'],['qe.approve','Approve Project']] },
    { group:'Master Data', items:[['master.view','Lihat Master Data'],['master.manage','Kelola Master Data']] },
  ];
  var permGroupsEl = document.getElementById('permGroups');
  PERMISSION_GROUPS.forEach(function(g){
    var wrap = document.createElement('div'); wrap.className = 'perm-group';
    var head = document.createElement('div'); head.className = 'perm-group-head';
    head.innerHTML = '<input type="checkbox" data-group="' + g.group + '" /> ' + g.group + ' — <span style="font-weight:400;color:var(--muted)">Pilih Semua</span>';
    var items = document.createElement('div'); items.className = 'perm-group-items';
    g.items.forEach(function(it){
      items.innerHTML += '<label><input type="checkbox" data-perm="' + it[0] + '" /> ' + it[1] + '</label>';
    });
    wrap.appendChild(head); wrap.appendChild(items);
    permGroupsEl.appendChild(wrap);
    head.querySelector('input').addEventListener('change', function(e){
      items.querySelectorAll('input').forEach(function(cb){ cb.checked = e.target.checked; });
    });
  });
  function setPermissionsForRole(roleCode){
    var all = permGroupsEl.querySelectorAll('input[data-perm]');
    var viewOnly = permGroupsEl.querySelectorAll('input[data-perm$=".view"], input[data-perm="map.view"], input[data-perm="ne.gcu"], input[data-perm="ne.material"], input[data-perm="qe.list"]');
    all.forEach(function(cb){ cb.checked = false; });
    if (roleCode === 'superadmin') { all.forEach(function(cb){ cb.checked = true; }); }
    else if (roleCode !== 'guest') { viewOnly.forEach(function(cb){ cb.checked = true; }); }
    permGroupsEl.querySelectorAll('.perm-group').forEach(function(g){
      var items = g.querySelectorAll('input[data-perm]');
      var allOn = Array.prototype.every.call(items, function(cb){ return cb.checked; });
      g.querySelector('input[data-group]').checked = allOn;
    });
  }

  /* ---------- area / regional / district / sto cascading ---------- */
  var F_REGIONAL = { PAMASUKA: ['KALIMANTAN', 'SULAWESI', 'KTI'] };
  var F_DISTRICT = { KALIMANTAN: ['Balikpapan', 'Samarinda'], SULAWESI: ['Makassar'], KTI: [] };
  var F_STO = {
    Balikpapan: ['STO Balikpapan Kota', 'STO Karang Joang', 'STO Sepinggan', 'STO Batakan', 'STO Manggar', 'STO Gunung Sari', 'STO Damai'],
    Samarinda: ['STO Samarinda Kota', 'STO Samarinda Seberang'],
    Makassar: ['STO Makassar Pusat'],
  };
  function fillSelect(el, items, placeholder){
    el.innerHTML = '<option value="">' + placeholder + '</option>';
    items.forEach(function(v){ var o = document.createElement('option'); o.textContent = v; el.appendChild(o); });
  }
  var mArea = document.getElementById('mArea'), mRegional = document.getElementById('mRegional'),
    mDistrict = document.getElementById('mDistrict'), mSto = document.getElementById('mSto');
  mArea.addEventListener('change', function(){
    fillSelect(mDistrict, [], t('phDistrict')); mDistrict.disabled = true;
    fillSelect(mSto, [], t('phSto'));
    if (F_REGIONAL[mArea.value]) { fillSelect(mRegional, F_REGIONAL[mArea.value], t('phRegional')); mRegional.disabled = false; }
    else { mRegional.disabled = true; fillSelect(mRegional, [], t('phRegional')); }
  });
  mRegional.addEventListener('change', function(){
    fillSelect(mSto, [], t('phSto'));
    if (F_DISTRICT[mRegional.value]) { fillSelect(mDistrict, F_DISTRICT[mRegional.value], t('phDistrict')); mDistrict.disabled = false; }
    else { mDistrict.disabled = true; fillSelect(mDistrict, [], t('phDistrict')); }
  });
  mDistrict.addEventListener('change', function(){
    if (F_STO[mDistrict.value]) { fillSelect(mSto, F_STO[mDistrict.value], t('phSto')); }
  });
  var scopeRow = document.getElementById('scopeRow'), stoField = document.getElementById('stoField');
  fRole.addEventListener('change', function(){
    var scope = (ROLE_MAP[fRole.value] || {}).scope || 'none';
    scopeRow.style.display = scope === 'none' ? 'none' : '';
    stoField.style.display = scope === 'sto' ? '' : 'none';
    setPermissionsForRole(fRole.value);
  });

  /* ---------- dummy users dataset ---------- */
  var USERS = [
    { id:1, nik:'7101230001', nama:'Ahmad Fajar', email:'ahmad.fajar@dalapa.id', roleCode:'area', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'-', unit:'Network Operation', sto:'-', twofa:false, active:false, tipe:'DALAPA', created:'2026-09-04 09:12', updated:'2026-09-04 09:12' },
    { id:2, nik:'7101230002', nama:'Siti Rahmawati', email:'siti.rahmawati@dalapa.id', roleCode:'mitra_admin', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'Balikpapan', unit:'Field Services', sto:'STO Sepinggan', twofa:false, active:false, tipe:'DALAPA', created:'2026-09-03 15:40', updated:'2026-09-03 15:40' },
    { id:3, nik:'7000123456', nama:'Reza Pratama', email:'reza.pratama@dalapa.id', roleCode:'superadmin', area:'-', regional:'-', distrik:'-', unit:'IT Development', sto:'-', twofa:true, active:true, tipe:'DALAPA', created:'2025-01-10 08:00', updated:'2026-08-30 10:22' },
    { id:4, nik:'7101110045', nama:'Ulsyairil', email:'ulsyairil@dalapa.id', roleCode:'regional', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'-', unit:'Network Operation', sto:'-', twofa:true, active:true, tipe:'DALAPA', created:'2024-11-02 10:15', updated:'2026-09-01 14:05' },
    { id:5, nik:'7101110078', nama:'Hilman R', email:'hilman.r@dalapa.id', roleCode:'area', area:'PAMASUKA', regional:'-', distrik:'-', unit:'Network Operation', sto:'-', twofa:false, active:true, tipe:'LDAP', created:'2024-08-14 09:30', updated:'2026-07-22 11:40' },
    { id:6, nik:'7101110091', nama:'Dewi Anggraini', email:'dewi.anggraini@dalapa.id', roleCode:'district', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'Balikpapan', unit:'Asset Management', sto:'-', twofa:true, active:true, tipe:'DALAPA', created:'2024-06-01 08:45', updated:'2026-05-19 09:12' },
    { id:7, nik:'7101110102', nama:'Bagus Wicaksono', email:'bagus.wicaksono@dalapa.id', roleCode:'mitra_tl', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'Balikpapan', unit:'Field Services', sto:'STO Balikpapan Kota', twofa:false, active:true, tipe:'LDAP', created:'2024-03-22 13:20', updated:'2026-02-11 16:30' },
    { id:8, nik:'7101110113', nama:'Putri Lestari', email:'putri.lestari@dalapa.id', roleCode:'mitra_admin', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'Samarinda', unit:'Field Services', sto:'STO Samarinda Kota', twofa:true, active:true, tipe:'DALAPA', created:'2024-02-10 08:00', updated:'2025-12-30 10:00' },
    { id:9, nik:'7101110124', nama:'Andi Saputra', email:'andi.saputra@dalapa.id', roleCode:'district', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'Samarinda', unit:'Network Operation', sto:'-', twofa:false, active:true, tipe:'DALAPA', created:'2023-12-05 09:10', updated:'2025-11-18 14:22' },
    { id:10, nik:'7101110135', nama:'Nurul Hidayah', email:'nurul.hidayah@dalapa.id', roleCode:'regional', area:'PAMASUKA', regional:'SULAWESI', distrik:'-', unit:'Network Operation', sto:'-', twofa:true, active:true, tipe:'DALAPA', created:'2023-09-19 08:30', updated:'2025-09-02 09:45' },
    { id:11, nik:'7101110146', nama:'Yoga Pratama', email:'yoga.pratama@dalapa.id', roleCode:'mitra_tl', area:'PAMASUKA', regional:'SULAWESI', distrik:'Makassar', unit:'Field Services', sto:'STO Makassar Pusat', twofa:false, active:false, tipe:'LDAP', created:'2023-07-08 10:00', updated:'2024-06-14 11:15' },
    { id:12, nik:'7101110157', nama:'Maya Kusuma', email:'maya.kusuma@dalapa.id', roleCode:'guest', area:'-', regional:'-', distrik:'-', unit:'-', sto:'-', twofa:false, active:true, tipe:'DALAPA', created:'2023-05-27 08:50', updated:'2024-04-30 09:20' },
    { id:13, nik:'7101110168', nama:'Fajar Nugroho', email:'fajar.nugroho@dalapa.id', roleCode:'area', area:'PAMASUKA', regional:'-', distrik:'-', unit:'Asset Management', sto:'-', twofa:true, active:true, tipe:'DALAPA', created:'2023-02-14 09:05', updated:'2024-01-08 15:50' },
    { id:14, nik:'7101110179', nama:'Ratna Sari', email:'ratna.sari@dalapa.id', roleCode:'district', area:'PAMASUKA', regional:'KALIMANTAN', distrik:'Balikpapan', unit:'Asset Management', sto:'-', twofa:false, active:false, tipe:'DALAPA', created:'2022-11-30 08:15', updated:'2023-10-11 10:40' },
  ];
  var nextId = 15;

  function roleName(code){ return (ROLE_MAP[code] || {}).name || code; }

  /* ---------- table render: search + sort + paginate ---------- */
  var sortKey = 'created', sortDir = 'desc', currentPage = 1;
  var searchInput = document.getElementById('searchInput'), perPageSel = document.getElementById('perPage');

  function getFiltered(){
    var q = searchInput.value.trim().toLowerCase();
    var rows = USERS.map(function(u){ return Object.assign({}, u, { roleName: roleName(u.roleCode) }); });
    if (q) {
      rows = rows.filter(function(u){
        return u.nama.toLowerCase().indexOf(q) !== -1 || u.nik.indexOf(q) !== -1 || u.email.toLowerCase().indexOf(q) !== -1;
      });
    }
    rows.sort(function(a, b){
      var av = a[sortKey], bv = b[sortKey];
      if (typeof av === 'boolean') { av = av ? 1 : 0; bv = bv ? 1 : 0; }
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

    var tbody = document.getElementById('userTbody');
    if (!pageRows.length) {
      tbody.innerHTML = '<tr><td colspan="14" style="text-align:center;color:var(--muted)">-</td></tr>';
    } else {
      tbody.innerHTML = pageRows.map(function(u){
        return '<tr>' +
          '<td>' + u.nik + '</td>' +
          '<td>' + u.nama + '</td>' +
          '<td>' + u.email + '</td>' +
          '<td>' + u.roleName + '</td>' +
          '<td>' + u.area + '</td>' +
          '<td>' + u.regional + '</td>' +
          '<td>' + u.distrik + '</td>' +
          '<td>' + u.unit + '</td>' +
          '<td>' + u.sto + '</td>' +
          '<td>' + (u.twofa ? t('yes') : t('no')) + '</td>' +
          '<td class="' + (u.active ? 'status-active' : 'status-inactive') + '">' + (u.active ? t('active') : t('inactive')) + '</td>' +
          '<td>' + u.created + '</td>' +
          '<td>' + u.updated + '</td>' +
          '<td><div class="row-actions">' +
            '<button class="icon-btn edit" data-act="edit" data-id="' + u.id + '" title="' + t('edit') + '"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.1 2.1 0 0 1 3 3L12 15l-4 1 1-4Z"/></svg></button>' +
            (u.active
              ? '<button class="icon-btn off" data-act="off" data-id="' + u.id + '" title="' + t('disable') + '"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0M12 2v10"/></svg></button>'
              : '<button class="icon-btn on" data-act="on" data-id="' + u.id + '" title="' + t('enable') + '"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg></button>') +
            '<button class="icon-btn del" data-act="del" data-id="' + u.id + '" title="' + t('delete') + '"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg></button>' +
          '</div></td>' +
        '</tr>';
      }).join('');
    }

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
      var arr = th.querySelector('.arr');
      arr.textContent = th.dataset.sort === sortKey ? (sortDir === 'asc' ? '▲' : '▼') : '';
    });
  }

  document.querySelectorAll('thead th[data-sort]').forEach(function(th){
    th.addEventListener('click', function(){
      var key = th.dataset.sort;
      if (sortKey === key) { sortDir = sortDir === 'asc' ? 'desc' : 'asc'; }
      else { sortKey = key; sortDir = 'asc'; }
      renderTable();
    });
  });
  searchInput.addEventListener('input', function(){ currentPage = 1; renderTable(); });
  perPageSel.addEventListener('change', function(){ currentPage = 1; renderTable(); });
  document.getElementById('refreshBtn').addEventListener('click', function(){
    searchInput.value = ''; currentPage = 1; renderTable(); toast(t('toastRefresh'));
  });

  /* ---------- create / edit modal ---------- */
  var userModal = document.getElementById('userModal'), modalTitle = document.getElementById('modalTitle');
  var pwToolbar = document.getElementById('pwToolbar');
  var editingId = null;

  function resetForm(){
    document.getElementById('fNik').value = '';
    document.getElementById('fNama').value = '';
    document.getElementById('fEmail').value = '';
    document.getElementById('fKontak').value = '';
    document.getElementById('fTelegram').value = '';
    document.querySelector('input[name="tipeAkun"][value="DALAPA"]').checked = true;
    fRole.value = '';
    fillSelect(mRegional, [], t('phRegional')); mRegional.disabled = true;
    fillSelect(mDistrict, [], t('phDistrict')); mDistrict.disabled = true;
    fillSelect(mSto, [], t('phSto'));
    mArea.value = ''; document.getElementById('mUnit').value = '';
    scopeRow.style.display = 'none'; stoField.style.display = 'none';
    permGroupsEl.querySelectorAll('input').forEach(function(cb){ cb.checked = false; });
    document.querySelectorAll('[data-mp]').forEach(function(cb){ cb.checked = false; });
  }
  document.getElementById('resetFormBtn').addEventListener('click', resetForm);

  function openCreate(){
    editingId = null;
    modalTitle.textContent = t('addUser');
    pwToolbar.style.display = 'none';
    resetForm();
    userModal.classList.add('show');
  }
  function openEdit(id){
    var u = USERS.find(function(x){ return x.id === id; });
    if (!u) { return; }
    editingId = id;
    modalTitle.textContent = t('editUser');
    resetForm();
    document.getElementById('fNik').value = u.nik;
    document.getElementById('fNama').value = u.nama;
    document.getElementById('fEmail').value = u.email;
    document.querySelector('input[name="tipeAkun"][value="' + u.tipe + '"]').checked = true;
    fRole.value = u.roleCode;
    fRole.dispatchEvent(new Event('change'));
    pwToolbar.style.display = u.tipe === 'LDAP' ? 'none' : '';
    document.getElementById('mUnit').value = u.unit !== '-' ? u.unit : '';
    userModal.classList.add('show');
  }
  document.getElementById('addBtn').addEventListener('click', openCreate);
  document.getElementById('modalClose').addEventListener('click', function(){ userModal.classList.remove('show'); });

  document.getElementById('saveBtn').addEventListener('click', function(){
    var nik = document.getElementById('fNik').value.trim();
    var nama = document.getElementById('fNama').value.trim();
    var email = document.getElementById('fEmail').value.trim();
    if (!nik || !nama || !email || !fRole.value) {
      toast(t('toastRequired'));
      return;
    }
    var tipe = document.querySelector('input[name="tipeAkun"]:checked').value;
    var now = new Date().toISOString().slice(0, 16).replace('T', ' ');
    var payload = {
      nik: nik, nama: nama, email: email, roleCode: fRole.value,
      area: mArea.value || '-', regional: mRegional.value || '-', distrik: mDistrict.value || '-',
      unit: document.getElementById('mUnit').value || '-', sto: mSto.value || '-',
      tipe: tipe, updated: now,
    };
    if (editingId) {
      var idx = USERS.findIndex(function(x){ return x.id === editingId; });
      USERS[idx] = Object.assign({}, USERS[idx], payload);
      toast(t('toastUpdated'));
    } else {
      payload.id = nextId++; payload.twofa = false; payload.active = true; payload.created = now;
      USERS.unshift(payload);
      toast(t('toastAdded'));
      if (tipe === 'DALAPA') { showGeneratedPassword(); }
    }
    userModal.classList.remove('show');
    renderTable();
  });

  document.getElementById('userTbody').addEventListener('click', function(e){
    var btn = e.target.closest('[data-act]');
    if (!btn) { return; }
    var id = parseInt(btn.dataset.id, 10);
    var u = USERS.find(function(x){ return x.id === id; });
    if (btn.dataset.act === 'edit') { openEdit(id); }
    else if (btn.dataset.act === 'on') {
      askConfirm(t('cfEnable'), t('cfEnableOk'), function(){
        u.active = true; renderTable(); toast(t('toastEnabled'));
      });
    } else if (btn.dataset.act === 'off') {
      askConfirm(t('cfDisable'), t('cfDisableOk'), function(){
        u.active = false; renderTable(); toast(t('toastDisabled'));
      });
    } else if (btn.dataset.act === 'del') {
      askConfirm(t('cfDelUser'), t('cfDelOk'), function(){
        USERS = USERS.filter(function(x){ return x.id !== id; });
        renderTable(); toast(t('toastDeleted'));
      });
    }
  });

  /* ---------- password reset / generation ---------- */
  var pwModal = document.getElementById('pwModal');
  function generatePassword(){
    var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
    var out = '';
    for (var i = 0; i < 10; i++) { out += chars[Math.floor(Math.random() * chars.length)]; }
    return out;
  }
  function showGeneratedPassword(){
    document.getElementById('pwValue').value = generatePassword();
    pwModal.classList.add('show');
  }
  document.getElementById('resetPwBtn').addEventListener('click', function(){
    askConfirm(t('cfResetPw'), t('changePw'), function(){
      showGeneratedPassword();
    });
  });
  document.getElementById('copyPwBtn').addEventListener('click', function(){
    var val = document.getElementById('pwValue').value;
    if (navigator.clipboard) { navigator.clipboard.writeText(val); }
    toast(t('toastPwCopied'));
  });
  document.getElementById('pwDone').addEventListener('click', function(){ pwModal.classList.remove('show'); });

  renderTable();
  applyLang();
</script>
</body>
</html>
