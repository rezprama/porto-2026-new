{{-- Legacy skin: reuse the shared demo shell CSS, then repaint it as the real app's Nifty "type-e / theme-navy" look.
     Light mode only — the legacy app has no dark theme, so no [data-theme="dark"] rules here. --}}
@include('project.tifreg.feature.partials.shell-styles')
<style>
  :root{
    /* sampled from the real theme-navy.min.css + the red of the DLP mark */
    --brand-50:#e7eef6; --brand-500:#35608c; --brand-600:#25476a;
    --bg:#ecf0f5; --panel-bg:#fff;
    --text:#4d627b; --label:#7a878e; --muted:#a3adb5; --border:#dfe5eb;
  }
  body{font-family:"Open Sans",system-ui,sans-serif}

  /* legacy = square-ish corners everywhere */
  .card,.btn-outline,.btn-primary,.btn-danger,.btn-success,.btn-sky,.modal-card,.icon-btn,.mini-btn,
  .field select,.field input,.field textarea,.table-toolbar select,.table-toolbar input,.pager button{border-radius:4px}

  /* legacy panel-heading bar */
  .card-head{padding:11px 16px;border-bottom:1px solid var(--border);background:#f6f8fa}
  .card-head h3{font-size:14px;color:var(--text)}

  /* legacy navbar: the real Nifty header splits in two — .navbar-header (logo, sits on the
     page's light background) and .navbar-content (menu/search/user links, solid navy
     #25476a with light-grey #dbdbdb text). Our fixed sidebar already plays the .navbar-header
     role, so .topbar here is the .navbar-content half — it must be solid navy, not a light
     bar with a red rule (that rule never existed in the real theme-navy.css). */
  .topbar{background:var(--brand-600);border-bottom:none}
  .topbar .hamburger,.topbar .icbtn,.topbar .logout-btn{color:#dbdbdb;border-color:rgba(255,255,255,.18)}
  .topbar .hamburger:hover,.topbar .icbtn:hover,.topbar .logout-btn:hover{color:#fff;background:rgba(255,255,255,.08)}
  .topbar .clock-pill{color:#dbdbdb;background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.18)}
  .topbar .avatar{background:#fff;color:var(--brand-600)}
  .topbar .user-meta .name{color:#fff}
  .topbar .user-meta .role{color:#b5c2d1}
  .sidebar .brand{background:var(--panel-bg);border-bottom:1px solid var(--border);height:64px;padding:0 20px}
  .sidebar .brand b{color:var(--text)}

  /* legacy breadcrumb */
  .page-head .crumb{display:flex;flex-wrap:wrap;gap:6px;align-items:center}
  .page-head .crumb span + span::before{content:"/";margin-right:6px;opacity:.6}
  .page-head h1{font-size:19px;font-weight:600}

  /* legacy tables: condensed + bordered */
  table{font-size:12px}
  thead th{padding:8px 12px;text-transform:none;font-size:11px;letter-spacing:0;background:#f6f8fa}
  tbody td, tfoot td{padding:7px 12px}
  table.bordered th,table.bordered td{border:1px solid var(--border)}
  table.centered th,table.centered td{text-align:center}
  table.centered th:first-child,table.centered td:first-child{text-align:left}
  tr.total-row td{font-weight:700;background:#f6f8fa;border-top:2px solid var(--border)}

  /* legacy tab strip inside a panel-primary heading — the real Nifty admin wraps every
     detail/drill-down modal's tab-nav in a <div class="panel panel-primary"><div class="panel-heading">,
     which paints that bar navy (#25476a, sampled from theme-navy.min.css .panel-primary .panel-heading).
     That navy bar is the "blue" signature of this legacy app; a plain grey strip here was the bug. */
  .tabs{display:flex;flex-wrap:wrap;gap:2px;padding:8px 16px 0;background:var(--brand-600)}
  .tabs button{height:36px;padding:0 14px;border:1px solid transparent;border-bottom:none;background:none;
    font-size:12.5px;font-weight:600;color:rgba(255,255,255,.7);border-radius:4px 4px 0 0}
  .tabs button:hover{color:#fff}
  .tabs button.on{background:var(--panel-bg);border-color:var(--panel-bg);color:var(--brand-600)}

  .stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px}
  .stat{border:1px solid var(--border);border-radius:4px;padding:12px 14px;background:var(--panel-bg)}
  .stat .k{font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:.04em}
  .stat .v{font-size:21px;font-weight:700;color:var(--text);margin-top:3px;line-height:1.1}
  .stat .s{font-size:11.5px;color:var(--muted);margin-top:2px}
  .chart-wrap{position:relative;height:300px}
  .last-update{font-size:11.5px;color:var(--muted);margin-top:2px}

  /* money columns line up on the decimal across every QE screen */
  .num, th.num{text-align:right;font-variant-numeric:tabular-nums}

  /* compact one-line filter strip — the legacy app packs these into narrow columns,
     so don't let .row3 stretch them to full width */
  .filter-bar{display:flex;flex-wrap:wrap;align-items:flex-end;gap:8px 10px;padding:12px 16px}
  .filter-bar .field{margin-bottom:0;width:168px;flex:0 0 auto}
  .filter-bar .field.wide{width:230px}
  .filter-bar .field.narrow{width:120px}
  .filter-bar .field label{font-size:11px;font-weight:600;margin-bottom:3px}
  .filter-bar .field select, .filter-bar .field input{height:32px;font-size:12px;padding:0 8px;border-radius:4px}
  .filter-bar .btn-success, .filter-bar .btn-sky, .filter-bar .btn-outline{height:32px;padding:0 18px;font-size:12px}
  @media (max-width:640px){ .filter-bar .field, .filter-bar .field.wide, .filter-bar .field.narrow{width:100%} }
</style>
