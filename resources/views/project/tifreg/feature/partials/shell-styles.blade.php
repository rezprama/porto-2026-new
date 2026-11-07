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
  .lang-switch{display:none;align-items:center;height:38px;border:1px solid var(--border);border-radius:9px;overflow:hidden}
  @media (min-width:640px){ .lang-switch{display:flex} }
  .lang-switch button{height:100%;padding:0 12px;border:none;background:none;font-family:inherit;font-size:12.5px;
    font-weight:600;color:var(--muted);transition:.15s}
  .lang-switch button:hover{color:var(--text)}
  .lang-switch button.on{background:var(--brand-500);color:#fff}
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

  /* ---------- content shell ---------- */
  main{margin-left:260px;padding:20px 20px 40px}
  @media (max-width:991px){ main{margin-left:0} }
  .page-head{margin-bottom:16px}
  .page-head h1{font-size:20px;font-weight:600;color:var(--text)}
  .page-head .crumb{font-size:12.5px;color:var(--muted);margin-bottom:4px}
  .stack{display:flex;flex-direction:column;gap:20px}
  [hidden]{display:none!important}

  /* ---------- buttons ---------- */
  .btn-outline, .btn-primary, .btn-danger, .btn-success, .btn-sky{height:38px;padding:0 16px;border-radius:8px;
    font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;gap:7px}
  .btn-outline{background:var(--panel-bg);border:1px solid var(--border);color:var(--label)}
  .btn-outline.warn{color:var(--warn-500);border-color:var(--warn-500)}
  .btn-primary{background:var(--brand-500);border:none;color:#fff}
  .btn-primary:hover{background:var(--brand-600)}
  .btn-danger{background:var(--error-500);border:none;color:#fff}
  .btn-success{background:#12b76a;border:none;color:#fff}
  .btn-sky{background:#0ba5ec;border:none;color:#fff}
  .btn-primary:disabled, .btn-success:disabled{opacity:.5;cursor:not-allowed}

  /* ---------- card + table ---------- */
  .card{background:var(--panel-bg);border:1px solid var(--border);border-radius:12px;box-shadow:var(--shadow-xs);overflow:hidden}
  .card-head{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;padding:16px 16px 0}
  .card-head h3{font-size:15px;font-weight:600;color:var(--text)}
  .card-note{font-size:12px;color:var(--muted);padding:6px 16px 0;line-height:1.5}
  .card-body{padding:16px}
  .table-toolbar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;padding:14px 16px}
  .table-toolbar select, .table-toolbar input{height:36px;border-radius:7px;border:1px solid var(--border);
    background:transparent;padding:0 10px;font-size:13px;font-family:inherit;color:var(--text)}
  .table-toolbar input{width:220px;max-width:60vw}
  .table-scroll{overflow-x:auto}
  table{width:100%;border-collapse:collapse;font-size:12.5px;white-space:nowrap}
  thead th{background:var(--gray-50);text-transform:uppercase;font-size:10.5px;letter-spacing:.04em;color:var(--muted);
    font-weight:600;text-align:left;padding:10px 14px;border-bottom:1px solid var(--border);user-select:none}
  [data-theme="dark"] thead th{background:color-mix(in srgb, var(--gray-900) 60%, var(--panel-bg))}
  thead th[data-sort]{cursor:pointer}
  thead th .arr{font-size:9px;margin-left:3px;color:var(--muted)}
  tbody td{padding:10px 14px;border-bottom:1px solid var(--border);color:var(--label)}
  tbody tr:last-child td{border-bottom:none}
  tbody tr:hover{background:color-mix(in srgb, var(--brand-500) 4%, transparent)}
  .status-active{color:var(--success-600);font-weight:600}
  .status-inactive{color:var(--muted);font-weight:600}
  .row-actions{display:flex;gap:6px;flex-wrap:wrap}
  .icon-btn{width:28px;height:28px;border-radius:6px;border:1px solid var(--border);background:var(--panel-bg);
    display:inline-grid;place-items:center;color:var(--label)}
  .icon-btn.edit:hover{border-color:var(--brand-500);color:var(--brand-500)}
  .icon-btn.on:hover{border-color:var(--success-600);color:var(--success-600)}
  .icon-btn.off:hover{border-color:var(--warn-500);color:var(--warn-500)}
  .icon-btn.del:hover{border-color:var(--error-500);color:var(--error-500)}
  .icon-btn[disabled]{opacity:.4;cursor:not-allowed}
  .mini-btn{height:28px;padding:0 10px;border-radius:6px;border:none;font-size:11.5px;font-weight:600}
  .mini-btn.teal{background:color-mix(in srgb,#14b8a6 12%,transparent);color:#0d9488}
  .mini-btn.brand{background:color-mix(in srgb,var(--brand-500) 12%,transparent);color:var(--brand-600)}
  .mini-btn.slate{background:color-mix(in srgb,var(--gray-500) 14%,transparent);color:var(--gray-500)}
  .mini-btn.amber{background:color-mix(in srgb,#f59e0b 14%,transparent);color:#b54708}
  .mini-btn.red{background:color-mix(in srgb,var(--error-500) 12%,transparent);color:var(--error-500)}
  .table-foot{display:flex;flex-wrap:wrap;gap:10px;align-items:center;justify-content:space-between;padding:12px 16px;
    border-top:1px solid var(--border);font-size:12.5px;color:var(--muted)}
  .pager{display:flex;gap:4px}
  .pager button{width:30px;height:30px;border-radius:6px;border:1px solid var(--border);background:var(--panel-bg);
    font-size:12.5px;color:var(--label)}
  .pager button.on{background:var(--brand-500);border-color:var(--brand-500);color:#fff}
  .empty-box{border:1px dashed var(--border);border-radius:10px;padding:32px 24px;text-align:center;
    color:var(--muted);font-size:13px;margin:16px}

  /* ---------- pills / badges ---------- */
  .pill{display:inline-block;padding:2px 9px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap}
  .pill-sq{border-radius:6px;padding:3px 8px}
  .pill-amber{background:#fef0c7;color:#b54708}
  .pill-scope{background:var(--brand-50);color:var(--brand-600)}
  .pill-gray{background:var(--gray-100);color:var(--gray-500)}
  .pill-green{background:#d1fadf;color:#027a48}
  .pill-red{background:#fee4e2;color:#b42318}
  .pill-blue{background:#d1e9ff;color:#175cd3}
  .pill-purple{background:#ebe9fe;color:#5925dc}
  .pill-teal{background:#ccfbf1;color:#0f766e}
  [data-theme="dark"] .pill-amber{background:color-mix(in srgb,#b54708 30%,transparent);color:#fedf89}
  [data-theme="dark"] .pill-scope{background:color-mix(in srgb,var(--brand-500) 22%,transparent);color:#a7b6ff}
  [data-theme="dark"] .pill-gray{background:color-mix(in srgb,var(--gray-500) 25%,transparent);color:var(--gray-300)}
  [data-theme="dark"] .pill-green{background:color-mix(in srgb,#027a48 30%,transparent);color:#75e0a7}
  [data-theme="dark"] .pill-red{background:color-mix(in srgb,#b42318 30%,transparent);color:#fda29b}
  [data-theme="dark"] .pill-blue{background:color-mix(in srgb,#175cd3 30%,transparent);color:#84caff}
  [data-theme="dark"] .pill-purple{background:color-mix(in srgb,#5925dc 30%,transparent);color:#bdb4fe}
  [data-theme="dark"] .pill-teal{background:color-mix(in srgb,#0f766e 35%,transparent);color:#5eead4}
  .mono-cell{font-family:monospace;font-size:11.5px}

  /* ---------- form fields ---------- */
  .field{margin-bottom:14px}
  .field label{display:block;font-size:12.5px;font-weight:600;color:var(--label);margin-bottom:5px}
  .field select, .field input, .field textarea{width:100%;border-radius:8px;border:1px solid var(--border);background:transparent;
    padding:9px 12px;font-size:13px;font-family:inherit;color:var(--text)}
  .field select, .field input{height:38px;padding:0 12px}
  .field textarea{resize:vertical;line-height:1.5}
  .field select:disabled, .field input:disabled, .field input[readonly], .field textarea[readonly]{
    background:var(--gray-50);color:var(--muted)}
  [data-theme="dark"] .field select:disabled, [data-theme="dark"] .field input[readonly], [data-theme="dark"] .field textarea[readonly]{
    background:color-mix(in srgb,var(--gray-900) 70%,transparent)}
  .field .hint{font-size:11.5px;color:var(--muted);margin-top:5px;line-height:1.5}
  .row2{display:grid;grid-template-columns:1fr;gap:12px}
  .row3{display:grid;grid-template-columns:1fr;gap:12px}
  @media (min-width:560px){ .row2{grid-template-columns:1fr 1fr} .row3{grid-template-columns:1fr 1fr 1fr} }
  .hint-muted{font-size:11.5px;color:var(--muted);line-height:1.5}

  /* ---------- modal ---------- */
  .modal-backdrop{position:fixed;inset:0;background:rgba(16,24,40,.6);backdrop-filter:blur(2px);z-index:2000;
    display:none;align-items:flex-start;justify-content:center;padding:40px 16px;overflow-y:auto}
  .modal-backdrop.show{display:flex}
  .modal-card{background:var(--panel-bg);border-radius:14px;max-width:460px;width:100%;box-shadow:var(--shadow-md);
    max-height:90vh;display:flex;flex-direction:column}
  .modal-card.modal-lg{max-width:760px}
  .modal-card.modal-xl{max-width:1180px}
  .doc-frame{border:1px dashed var(--border);border-radius:10px;background:var(--gray-50);padding:24px 16px;
    text-align:center;color:var(--muted);font-size:12.5px}
  [data-theme="dark"] .doc-frame{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .doc-frame a{color:var(--brand-600);font-weight:600;text-decoration:none}
  .sticky-col{position:sticky;right:0;background:var(--panel-bg);box-shadow:-6px 0 8px -6px rgba(16,24,40,.15)}
  thead .sticky-col{background:var(--gray-50)}
  [data-theme="dark"] thead .sticky-col{background:var(--gray-900)}
  .modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1px solid var(--border)}
  .modal-head h3{font-size:16px;color:var(--text)}
  .modal-close{background:none;border:none;font-size:16px;color:var(--muted);cursor:pointer}
  .modal-body{padding:20px 22px;overflow-y:auto}
  .modal-foot{display:flex;justify-content:flex-end;gap:10px;padding:16px 22px;border-top:1px solid var(--border)}

  /* ---------- shared: key/value readonly grid + workorder detail ---------- */
  .wod-section{margin-bottom:18px}
  .wod-section:last-child{margin-bottom:0}
  .wod-section > b{display:block;font-size:13px;color:var(--text);margin-bottom:10px}
  .wod-cols{display:flex;flex-direction:column;gap:18px}
  @media (min-width:768px){ .wod-cols{flex-direction:row} }
  .kv-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px 16px;background:var(--gray-50);
    border:1px solid var(--border);border-radius:10px;padding:12px 14px}
  [data-theme="dark"] .kv-grid{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  @media (min-width:640px){ .kv-grid{grid-template-columns:1fr 1fr 1fr} }
  .kv-grid.kv-grid-1{grid-template-columns:1fr}
  .kv-item .k{font-size:10px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);margin-bottom:2px}
  .kv-item .v{font-size:13px;color:var(--text);font-weight:500;word-break:break-word}
  .evidence-row{display:flex;flex-wrap:wrap;gap:12px}
  .evidence-item{width:130px;text-align:center}
  .evidence-item .k{font-size:11px;color:var(--muted);margin-bottom:6px}
  .evidence-item .thumb{width:100%;height:90px;border-radius:8px;overflow:hidden;border:1px solid var(--border);
    background:none;padding:0;cursor:pointer;display:block}
  .evidence-item .thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .15s}
  .evidence-item .thumb:hover img{transform:scale(1.05)}

  /* ---------- lightbox (evidence photo viewer) ---------- */
  .lightbox-backdrop{position:fixed;inset:0;background:rgba(10,14,20,.88);z-index:4000;display:none;
    align-items:center;justify-content:center;padding:24px}
  .lightbox-backdrop.show{display:flex}
  .lightbox-box{max-width:640px;width:100%}
  .lightbox-box img{width:100%;border-radius:10px;box-shadow:0 20px 50px rgba(0,0,0,.5)}
  .lightbox-cap{color:#fff;text-align:center;font-size:12.5px;margin-top:10px;opacity:.85}
  .lightbox-close{position:absolute;top:20px;right:24px;width:38px;height:38px;border-radius:50%;
    background:rgba(255,255,255,.12);color:#fff;font-size:16px;border:none}

  /* ---------- toast ---------- */
  .toast-stack{position:fixed;bottom:16px;right:16px;z-index:3000;display:flex;flex-direction:column;gap:8px;max-width:340px}
  .toast{background:var(--gray-900);color:#fff;font-size:13px;padding:10px 16px;border-radius:8px;box-shadow:var(--shadow-md);
    opacity:0;transform:translateY(6px);transition:opacity .2s,transform .2s}
  .toast.show{opacity:1;transform:translateY(0)}
</style>
