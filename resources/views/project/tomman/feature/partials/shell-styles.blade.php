{{-- Tomman skin: a hand-written replica of Bootswatch 3.3.6 "Paper" (the theme the real app loads from
     psb.tomman.info/bower_components/bootswatch-dist) plus the overrides layout.blade.php piles on top.
     Every value below is sampled from that stylesheet — do not invent colours here.
     Light mode only, Indonesian only: the real app has neither a theme toggle nor a language switcher. --}}
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
<style>
  /* ---------- Paper tokens ---------- */
  :root{
    --primary:#2196f3; --primary-dark:#0c7cd5;
    --success:#4caf50; --danger:#e51c23; --warning:#ff9800;
    --info:#FF5442;            /* layout.blade.php repaints .btn-info from Paper's purple to this */
    --text:#666666; --heading:#444444; --strong:#212121;
    --border:#dddddd; --page:#e2e2e2; --panel:#ffffff; --panel-head:#f5f5f5; --stripe:#f9f9f9;
    --brand-red:#e74c3c;       /* the "TOM" in the navbar brand */
  }
  *{box-sizing:border-box}
  html,body{margin:0;padding:0}
  body{font-family:"Roboto","Helvetica Neue",Helvetica,Arial,sans-serif;font-size:13px;line-height:1.846;
    color:var(--text);background-color:var(--page);-webkit-font-smoothing:antialiased}
  a{color:var(--primary);text-decoration:none;cursor:pointer}
  a:hover{color:#0a6ebd;text-decoration:underline}
  h1,h2,h3,h4,h5,h6{font-family:inherit;font-weight:400;line-height:1.1;color:var(--heading);margin:23px 0 11.5px}
  h3{font-size:24px}   /* layout override — Paper's own h3 is 21px */
  h4{font-size:17px}
  h5{font-size:13px}
  small{font-size:85%}
  b,strong{font-weight:700}
  hr{border:0;border-top:1px solid var(--border);margin:23px 0}

  /* ---------- grid ---------- */
  .container-fluid{padding:0 15px;margin:0 auto}
  .row{display:flex;flex-wrap:wrap;margin:0 -15px}
  .row > [class^="col-"]{padding:0 15px;width:100%}
  @media (min-width:768px){
    .col-sm-2{width:16.6667%}.col-sm-3{width:25%}.col-sm-4{width:33.3333%}.col-sm-5{width:41.6667%}
    .col-sm-6{width:50%}.col-sm-7{width:58.3333%}.col-sm-8{width:66.6667%}.col-sm-9{width:75%}.col-sm-12{width:100%}
  }
  .text-center{text-align:center}
  .text-right{text-align:right}
  .pull-right{float:right}

  /* ---------- marquee announcement (the real app pins one to the very top) ---------- */
  .mar{display:block;margin:0;border-radius:0;font-weight:700;overflow:hidden}
  .mar .mar-track{display:inline-block;white-space:nowrap;padding-left:100%;animation:mar-scroll 42s linear infinite}
  @keyframes mar-scroll{from{transform:translateX(0)}to{transform:translateX(-100%)}}

  /* ---------- navbar ---------- */
  .navbar{position:relative;min-height:64px;margin-bottom:10px;border:1px solid transparent;
    background-color:#fff;box-shadow:0 1px 10px rgba(0,0,0,.3)}
  .navbar .container-fluid{display:flex;flex-wrap:wrap;align-items:center}
  .navbar-header{display:flex;align-items:center;min-height:64px}
  .navbar-brand{padding:20.5px 15px;font-size:14px;font-weight:700;line-height:23px;color:var(--text);
    text-decoration:none;letter-spacing:.02em}
  .navbar-brand:hover{color:var(--strong);text-decoration:none}
  .navbar-brand .redxxx{color:var(--brand-red)}
  .navbar-toggle{display:none;background:none;border:1px solid #ddd;border-radius:3px;padding:9px 10px;margin-left:auto;cursor:pointer}
  .navbar-toggle .icon-bar{display:block;width:22px;height:2px;border-radius:1px;background:#888}
  .navbar-toggle .icon-bar + .icon-bar{margin-top:4px}

  .navbar-nav{display:flex;flex-wrap:wrap;align-items:center;list-style:none;margin:0;padding:0;font-size:11px}
  .navbar-nav > li{position:relative}
  .navbar-nav > li > a{display:block;padding:20.5px 15px;line-height:23px;color:var(--text);text-decoration:none;
    text-transform:uppercase;letter-spacing:.02em}
  .navbar-nav > li > a:hover{color:var(--strong);background:transparent;text-decoration:none}
  .navbar-nav > li.open > a,.navbar-nav > li.active > a{color:var(--strong);background-color:#eeeeee}
  .caret{display:inline-block;width:0;height:0;margin-left:4px;vertical-align:middle;
    border-top:4px dashed;border-right:4px solid transparent;border-left:4px solid transparent}

  .dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;min-width:190px;padding:5px 0;margin:2px 0 0;
    list-style:none;font-size:13px;text-align:left;background-color:#fff;border:1px solid rgba(0,0,0,.15);
    border-radius:3px;box-shadow:0 6px 12px rgba(0,0,0,.175)}
  .open > .dropdown-menu{display:block}
  .dropdown-menu > li > a{display:block;padding:3px 20px;clear:both;font-weight:400;line-height:23px;color:var(--text);
    white-space:nowrap;text-decoration:none;text-transform:none}
  .dropdown-menu > li > a:hover{background-color:#f5f5f5;color:var(--strong);text-decoration:none}

  @media (max-width:991px){
    .navbar-toggle{display:block}
    .navbar-header{width:100%;justify-content:space-between}
    .navbar-collapse{display:none;width:100%;border-top:1px solid #e7e7e7;padding-bottom:8px}
    .navbar-collapse.in{display:block}
    .navbar-nav{display:block;width:100%}
    .navbar-nav > li > a{padding:8px 15px}
    .dropdown-menu{position:static;float:none;width:auto;box-shadow:none;border:0;background:transparent;padding-left:12px}
  }

  /* ---------- panels ---------- */
  .panel{margin-bottom:23px;background-color:var(--panel);border:1px solid transparent;border-radius:3px;
    box-shadow:0 1px 1px rgba(0,0,0,.05)}
  .panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-radius:2px 2px 0 0;font-size:13px}
  .panel-body{padding:15px}
  .panel-default > .panel-heading{color:var(--strong);background-color:var(--panel-head);border-color:var(--border)}
  .panel-default{border-color:var(--border)}
  .panel-primary > .panel-heading{color:#fff;background-color:var(--primary);border-color:var(--primary)}
  .panel-primary{border-color:var(--primary)}
  .panel-info > .panel-heading{color:#fff;background-color:#54a0ff;border-color:#54a0ff}  /* ticketing/home override */
  .panel-info{border-color:#54a0ff}
  .panel-warning > .panel-heading{color:#fff;background-color:var(--warning);border-color:var(--warning)}
  .panel-warning{border-color:var(--warning)}
  .panel-title{margin:0;font-size:15px;color:inherit}
  .well{padding:19px;margin-bottom:20px;background-color:var(--stripe);border:1px solid transparent;border-radius:3px;
    box-shadow:inset 0 1px 1px rgba(0,0,0,.05)}

  /* ---------- tables ---------- */
  .table-responsive{background-color:#fff;overflow-x:auto;-webkit-overflow-scrolling:touch}
  .table{width:100%;max-width:100%;margin-bottom:23px;background-color:#fff;border-collapse:collapse}
  .table > thead > tr > th{vertical-align:bottom;border-bottom:2px solid var(--border);padding:8px;text-align:left}
  .table > tbody > tr > td,.table > tbody > tr > th,.table > tfoot > tr > td{padding:8px;line-height:1.846;
    vertical-align:top;border-top:1px solid var(--border)}
  .table-striped > tbody > tr:nth-of-type(odd){background-color:var(--stripe)}
  .table-bordered,.table-bordered > thead > tr > th,.table-bordered > tbody > tr > td,
  .table-bordered > tbody > tr > th,.table-bordered > tfoot > tr > td{border:1px solid var(--border)}
  .table-condensed > tbody > tr > td,.table-condensed > thead > tr > th{padding:5px}
  .table tr:hover > td{background-color:#f5f5f5}

  /* ---------- labels ---------- */
  .label{display:inline-block;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;
    text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em;text-decoration:none}
  a.label:hover{color:#fff;text-decoration:none;opacity:.86}
  .label-default{background-color:#bbbbbb}
  .label-primary{background-color:var(--primary)}
  .label-success{background-color:var(--success)}
  .label-danger{background-color:var(--danger)}
  .label-warning{background-color:var(--warning)}
  .label-info{background-color:#2196f3}   /* layout override */
  /* matrix.blade.php ships its own extra chip colours for the rarer laporan statuses */
  .label-greenx{background-color:#1abc9c}
  .label-darkgrey{background-color:#6b6b6b}
  .label-bluepas{background-color:#fd79a8}
  .label-purple{background-color:#800080}
  .label-black{background-color:#000000}
  .label-coklat{background-color:#A0522D}
  .label-golden{background-color:#008B8B}
  .myindihome{border:1px solid #000}

  /* ---------- buttons ---------- */
  .btn{display:inline-block;margin-bottom:0;font-weight:400;text-align:center;vertical-align:middle;cursor:pointer;
    border:1px solid transparent;white-space:nowrap;padding:6px 16px;font-size:13px;line-height:1.846;border-radius:3px;
    font-family:inherit;text-decoration:none;transition:background-color .15s}
  .btn:hover{text-decoration:none}
  .btn:active{box-shadow:inset 0 3px 5px rgba(0,0,0,.125)}
  .btn-default{color:#444;background-color:#fff}
  .btn-default:hover{background-color:#f0f0f0;color:#444}
  .btn-primary{color:#fff;background-color:var(--primary)}
  .btn-primary:hover{color:#fff;background-color:var(--primary-dark)}
  .btn-success{color:#fff;background-color:var(--success)}
  .btn-success:hover{color:#fff;background-color:#3d8b40}
  .btn-danger{color:#fff;background-color:var(--danger)}
  .btn-danger:hover{color:#fff;background-color:#b9151b}
  .btn-warning{color:#fff;background-color:var(--warning)}
  .btn-warning:hover{color:#fff;background-color:#cc7a00}
  .btn-info{color:#fff;background-color:var(--info)}   /* layout override: #FF5442, not Paper's purple */
  .btn-info:hover{color:#fff;background-color:#e6402e}
  .btn-sm{padding:5px 10px;font-size:12px;border-radius:3px}
  .btn-xs{padding:1px 5px;font-size:11px;border-radius:3px}

  /* ---------- forms: Paper's material underline ---------- */
  .form-group{margin-bottom:15px}
  label.control-label{display:inline-block;max-width:100%;margin-bottom:5px;font-weight:700;font-size:13px;color:var(--text)}
  .form-control{display:block;width:100%;height:37px;padding:0;font-size:16px;line-height:1.846;color:var(--text);
    background-color:transparent;border:0;border-radius:0;appearance:none;box-shadow:inset 0 -1px 0 var(--border);
    font-family:inherit;transition:box-shadow .15s}
  .form-control:focus{outline:0;border-bottom:none;box-shadow:inset 0 -2px 0 var(--primary)}
  textarea.form-control{height:auto;padding:6px 0;line-height:1.846}
  select.form-control{height:37px;line-height:37px;cursor:pointer;
    background-image:linear-gradient(45deg,transparent 50%,#666 50%),linear-gradient(135deg,#666 50%,transparent 50%);
    background-position:calc(100% - 9px) 17px,calc(100% - 4px) 17px;background-size:5px 5px;background-repeat:no-repeat;
    padding-right:20px}
  .form-control.new{box-shadow:inset 0 -1px 0 #b7b7b7}
  .help-block{display:block;margin:5px 0 10px;color:#a6a6a6;font-size:12px}
  .input-inline{display:inline-block;width:auto;vertical-align:middle;margin:0 6px}

  /* ---------- nav-tabs ---------- */
  .nav-tabs{display:flex;flex-wrap:wrap;list-style:none;margin:0 0 20px;padding:0;
    border:1px solid #D6D6D6;border-radius:3px 3px 0 0}   /* layout override adds the outline */
  .nav-tabs > li > a{display:block;margin-right:2px;padding:10px 15px;line-height:1.846;color:var(--text);
    border:1px solid transparent;border-radius:3px 3px 0 0;text-decoration:none;cursor:pointer}
  .nav-tabs > li > a:hover{color:var(--strong);text-decoration:none}
  .nav-tabs > li.active > a{border:none;box-shadow:inset 0 -2px 0 var(--primary);color:var(--primary);cursor:default}

  /* ---------- alerts ---------- */
  .alert{padding:15px;margin-bottom:23px;border:1px solid transparent;border-radius:3px}
  .alert-danger{background-color:#f9bdbb;border-color:#f7a4af;color:var(--danger)}
  .alert-success{background-color:#c8e6c9;border-color:#a3d3a5;color:#3d8b40}
  .alert-warning{background-color:#ffe0b2;border-color:#ffcc80;color:#cc7a00}
  .alert-info{background-color:#b3e5fc;border-color:#81d4fa;color:#0c7cd5}

  /* ---------- the ad-hoc helper classes the real screens declare inline ---------- */
  .red{background-color:#FF0000;color:#FFF}
  .green{background-color:#2ecc71;font-weight:700;color:#FFF}
  .green a{color:#FFF}
  .orange{background-color:#e67e22;font-weight:700;color:#FFF}
  .orange a{color:#FFF}
  .redx{background-color:#e74c3c;font-weight:700;color:#FFF}
  .redx a{color:#FFF}
  .gray{background-color:#f4f4f4}
  .center{text-align:center}
  .color_UP{color:#FFF;background-color:#1cd43e}
  .color_OGP{color:#FFF;background-color:#d4841c}
  .color_KENDALA{color:#FFF;background-color:#ff0000}
  .color_BELUM{color:#FFF;background-color:#527ee6}
  .gold{color:#f1c40f}

  /* ---------- popover (matrix chips carry one per ticket) ---------- */
  .popover{position:absolute;z-index:1060;max-width:320px;padding:1px;background:#fff;
    border:1px solid rgba(0,0,0,.2);border-radius:3px;box-shadow:0 5px 10px rgba(0,0,0,.2);font-size:12px;line-height:1.6}
  .popover-content{padding:9px 14px;word-break:break-word}
  .popover b{color:var(--strong)}

  /* ---------- modal ---------- */
  .modal-backdrop{position:fixed;inset:0;z-index:1040;background:rgba(0,0,0,.5)}
  .modal{position:fixed;inset:0;z-index:1050;overflow-y:auto;padding:30px 12px}
  .modal-dialog{margin:0 auto;max-width:600px}
  .modal-dialog.modal-lg{max-width:900px}
  .modal-content{background:#fff;border-radius:3px;box-shadow:0 5px 15px rgba(0,0,0,.5)}
  .modal-header{padding:15px;border-bottom:1px solid #e5e5e5;display:flex;align-items:center;gap:10px}
  .modal-title{margin:0;font-size:17px;color:var(--heading);flex:1}
  .modal-header .close{background:none;border:0;font-size:21px;line-height:1;color:#000;opacity:.2;cursor:pointer}
  .modal-header .close:hover{opacity:.5}
  .modal-body{padding:15px}
  .modal-footer{padding:15px;border-top:1px solid #e5e5e5;text-align:right;display:flex;justify-content:flex-end;gap:8px}
  [hidden]{display:none!important}

  /* ---------- toast: stand-in for the flash alerts the real app renders server-side ----------
     bottom is clear of the demo badge (which sits at bottom:14px with a higher z-index) — overlapping
     them made every action look like it did nothing at all */
  .toast-stack{position:fixed;right:16px;bottom:62px;z-index:1080;display:flex;flex-direction:column;gap:8px}
  .toast{background:#404040;color:#fff;padding:10px 14px;border-radius:3px;font-size:12.5px;max-width:330px;
    box-shadow:0 3px 10px rgba(0,0,0,.3);opacity:0;transform:translateY(8px);transition:opacity .2s,transform .2s}
  .toast.show{opacity:1;transform:none}

  /* ---------- portfolio demo badge (not part of the real app) ---------- */
  .demo-badge{position:fixed;right:14px;bottom:14px;z-index:1090;display:inline-flex;align-items:center;
    background:rgba(64,64,64,.92);padding:6px;border-radius:20px;text-decoration:none;overflow:hidden;transition:padding .25s}
  .demo-badge:hover{background:#404040;padding:6px 14px 6px 6px;text-decoration:none}
  .demo-badge .mark{width:22px;height:22px;border-radius:50%;background:#fff;display:flex;align-items:center;
    justify-content:center;padding:2px;flex-shrink:0;overflow:hidden}
  .demo-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .demo-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11.5px;font-weight:600;
    margin-left:0;transition:max-width .25s,opacity .2s,margin-left .25s}
  .demo-badge:hover .txt{max-width:280px;opacity:1;margin-left:8px}
</style>
