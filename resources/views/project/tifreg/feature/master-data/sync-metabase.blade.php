<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Sync Ticket Metabase — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
@include('project.tifreg.feature.partials.shell-styles')
<style>
  .search-row{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-top:8px;flex-wrap:wrap}
  .search-row .hint{flex:1;min-width:240px}
  .count-pills{display:flex;gap:8px;flex-wrap:wrap}
  .ticket-card{border:1px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:12px}
  .tc-head{display:flex;align-items:center;gap:8px;flex-wrap:wrap;padding:10px 14px;background:var(--gray-50);
    border-bottom:1px solid var(--border)}
  [data-theme="dark"] .tc-head{background:color-mix(in srgb,var(--gray-900) 55%,var(--panel-bg))}
  .tc-head .no{font-family:monospace;font-size:13px;font-weight:600;color:var(--text)}
  .tc-head .acts{margin-left:auto;display:flex;gap:8px}
  .tc-head .acts button{height:30px;padding:0 12px;border-radius:7px;font-size:12px;font-weight:600}
  .tc-summary{display:grid;grid-template-columns:repeat(2,1fr);gap:1px;background:var(--border)}
  @media (min-width:900px){ .tc-summary{grid-template-columns:repeat(6,1fr)} }
  .tc-cell{background:var(--panel-bg);padding:10px 14px}
  .tc-cell .k{font-size:10px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);margin-bottom:3px}
  .tc-cell .v{font-size:13px;font-weight:600;color:var(--text);word-break:break-all}
  .tc-detail{border-top:1px solid var(--border)}
  .tc-row{display:grid;grid-template-columns:1fr;gap:2px;padding:9px 14px;border-bottom:1px solid var(--border);font-size:12.5px}
  @media (min-width:640px){ .tc-row{grid-template-columns:1fr 2fr;gap:12px} }
  .tc-row:last-child{border-bottom:none}
  .tc-row .k{font-size:10.5px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted)}
  .tc-row .v{color:var(--label);word-break:break-all}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

@include('project.tifreg.feature.partials.sidebar', ['active' => 'master-sync'])
@include('project.tifreg.feature.partials.topbar')

<main>
  <div class="page-head">
    <div class="crumb">Master Data</div>
    <h1 data-i18n="pageTitle">Sync Ticket Metabase</h1>
  </div>

  <div class="stack">
    <!-- SEARCH (bare, not in a card — matches the real page) -->
    <div>
      <div class="field" style="margin-bottom:0">
        <label>Ticket</label>
        <textarea id="ticketInput" rows="3" data-i18n-ph="ticketPh"
          placeholder="Masukkan satu atau banyak tiket, pisahkan dengan koma atau baris baru">INC1234567, INC7654321
INC2468013</textarea>
      </div>
      <div class="search-row">
        <p class="hint-muted hint" data-i18n="ticketHint">Tekan Ctrl+Enter untuk mencari. Contoh: INC1234567, INC7654321 atau 1 tiket per baris.</p>
        <button class="btn-primary" id="searchBtn" data-i18n="search">Cari</button>
      </div>
    </div>

    <!-- RESULTS -->
    <div class="card">
      <div class="card-head">
        <h3 data-i18n="dataTitle">Data Ticket</h3>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
          <div class="count-pills" id="countPills"></div>
          <button class="btn-success" id="syncAllBtn" style="display:none">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12a9 9 0 1 1-2.6-6.4M21 3v5h-5"/></svg>
            <span data-i18n="syncAll">Sync Semua</span>
          </button>
        </div>
      </div>
      <div class="card-body">
        <p class="hint-muted" id="emptyHint" data-i18n="initialHint">Silakan masukkan nomor ticket untuk mencari data.</p>
        <div id="ticketList"></div>
      </div>
    </div>
  </div>
</main>

<script>
  var PAGE_I18N = {
    id: {
      pageTitle: 'Sync Ticket Metabase',
      ticketPh: 'Masukkan satu atau banyak tiket, pisahkan dengan koma atau baris baru',
      ticketHint: 'Tekan Ctrl+Enter untuk mencari. Contoh: INC1234567, INC7654321 atau 1 tiket per baris.',
      search: 'Cari', searching: 'Mencari...', dataTitle: 'Data Ticket',
      initialHint: 'Silakan masukkan nomor ticket untuk mencari data.',
      noTickets: 'Tidak ada tiket yang ditampilkan.',
      syncAll: 'Sync Semua', syncing: 'Menyinkronkan...', sync: 'Sync',
      showDetail: 'Lihat Detail', hideDetail: 'Sembunyikan Detail', notFound: 'Tidak Ditemukan',
      pTickets: 'tiket', pFound: 'ditemukan', pNotFound: 'tidak ditemukan',
      cService: 'Service ID', cWitel: 'Witel', cWorkzone: 'Workzone',
      cSource: 'Ticket Sumber', cOwner: 'Owner', cOwnerGroup: 'Owner Group',
      msgUpdated: ': ticket berhasil diperbarui.', msgCreated: ': ticket berhasil disinkronkan.',
      msgSkipped: ': tiket sudah ada.', msgAllSynced: ' ticket berhasil disinkronkan.',
      msgSearchFail: 'Gagal mengambil data ticket.',
    },
    en: {
      pageTitle: 'Sync Ticket Metabase',
      ticketPh: 'Enter one or more tickets, separated by commas or new lines',
      ticketHint: 'Press Ctrl+Enter to search. Example: INC1234567, INC7654321 or one ticket per line.',
      search: 'Search', searching: 'Searching...', dataTitle: 'Ticket Data',
      initialHint: 'Please enter ticket number(s) to search.',
      noTickets: 'No tickets to display.',
      syncAll: 'Sync All', syncing: 'Syncing...', sync: 'Sync',
      showDetail: 'Show Detail', hideDetail: 'Hide Detail', notFound: 'Not Found',
      pTickets: 'tickets', pFound: 'found', pNotFound: 'not found',
      cService: 'Service ID', cWitel: 'Witel', cWorkzone: 'Workzone',
      cSource: 'Ticket Source', cOwner: 'Owner', cOwnerGroup: 'Owner Group',
      msgUpdated: ': ticket updated successfully.', msgCreated: ': ticket synced successfully.',
      msgSkipped: ': ticket already exists.', msgAllSynced: ' tickets synced successfully.',
      msgSearchFail: 'Failed to fetch ticket data.',
    },
  };
</script>

@include('project.tifreg.feature.partials.shell-script')

<script>
  /* ---------- dummy ticket dataset ---------- */
  var TICKETS = {
    INC1234567: {
      found: true, status: 'CLOSED', source: 'metabase',
      service: '152412340021', witel: 'KALTIMTARA', workzone: 'BPP', owner: 'Reza Pratama', ownerGroup: 'TIF REG KALIMANTAN',
      detail: {
        'Customer Name': 'PT Sinar Bahari Sejahtera', 'Customer Segment': 'HVC Platinum',
        'Reported Date': '2026-08-24 09:14', 'Closed Date': '2026-08-24 15:02',
        'Root Cause': 'Kabel drop putus akibat pekerjaan galian pihak ketiga',
        'TTR Agent': '02:14:11', 'TTR Customer': '05:48:20', 'TTR Nasional': '05:48:20',
        'Service ID': '152412340021', 'ODP': 'ODP-BPN-014',
        'Worklog Summary': 'Penggantian dropcore 80m, splicing ulang di ODP, tes redaman OK (-19.4 dBm).',
      },
    },
    INC7654321: {
      found: true, status: 'IN PROGRESS', source: 'ticket_insera',
      service: '152498760112', witel: 'KALTIMTARA', workzone: 'SMD', owner: 'Andi Saputra', ownerGroup: 'TIF DISTRICT SAMARINDA',
      detail: {
        'Customer Name': 'CV Mahakam Digital', 'Customer Segment': 'HVC Gold',
        'Reported Date': '2026-09-04 07:41', 'Closed Date': '-',
        'Root Cause': 'Loss of signal, dugaan ONT rusak',
        'TTR Agent': '01:02:35', 'TTR Customer': '-', 'TTR Nasional': '-',
        'Service ID': '152498760112', 'ODP': 'ODP-SMD-009',
        'Worklog Summary': 'Dispatch teknisi lapangan, penggantian ONT dijadwalkan 2026-09-05.',
      },
    },
    INC2468013: { found: false },
  };

  var results = [];
  var searchBtn = document.getElementById('searchBtn'), ticketInput = document.getElementById('ticketInput');
  var syncAllBtn = document.getElementById('syncAllBtn');

  function statusPill(v){
    var s = (v || '').toUpperCase(), cls = 'pill-gray';
    if (['CLOSED', 'DONE', 'RESOLVED', 'COMPLETED'].indexOf(s) !== -1) { cls = 'pill-green'; }
    else if (['OPEN', 'IN PROGRESS', 'PENDING'].indexOf(s) !== -1) { cls = 'pill-amber'; }
    else if (['CANCEL', 'CANCELLED', 'FAILED'].indexOf(s) !== -1) { cls = 'pill-red'; }
    return '<span class="pill pill-sq ' + cls + '">' + v + '</span>';
  }
  function sourcePill(v){
    if (v === 'metabase') { return '<span class="pill pill-sq pill-blue">Metabase</span>'; }
    if (v === 'ticket_insera') { return '<span class="pill pill-sq pill-purple">Ticket Insera</span>'; }
    return '';
  }

  function renderResults(){
    var list = document.getElementById('ticketList');
    var pills = document.getElementById('countPills');
    var hint = document.getElementById('emptyHint');

    if (!results.length) {
      list.innerHTML = '';
      pills.innerHTML = '';
      syncAllBtn.style.display = 'none';
      hint.hidden = false;
      hint.textContent = t('initialHint');
      return;
    }
    hint.hidden = true;
    syncAllBtn.style.display = '';

    var found = results.filter(function(r){ return r.found; }).length;
    var notFound = results.length - found;
    pills.innerHTML = '<span class="pill pill-sq pill-scope">' + results.length + ' ' + t('pTickets') + '</span>' +
      (found ? '<span class="pill pill-sq pill-green">' + found + ' ' + t('pFound') + '</span>' : '') +
      (notFound ? '<span class="pill pill-sq pill-red">' + notFound + ' ' + t('pNotFound') + '</span>' : '');

    list.innerHTML = results.map(function(r, i){
      var head = '<div class="tc-head"><span class="no">' + r.ticket + '</span>' +
        (r.found ? statusPill(r.status) + sourcePill(r.source) : '<span class="pill pill-sq pill-red">' + t('notFound') + '</span>') +
        '<div class="acts">' +
          (r.found ? '<button class="btn-outline" data-toggle-detail="' + i + '">' + (r.open ? t('hideDetail') : t('showDetail')) + '</button>' +
                     '<button class="btn-success" data-sync="' + i + '">' + t('sync') + '</button>' : '') +
        '</div></div>';

      if (!r.found) { return '<div class="ticket-card">' + head + '</div>'; }

      var cells = [
        [t('cService'), r.service], [t('cWitel'), r.witel], [t('cWorkzone'), r.workzone],
        [t('cSource'), r.source === 'metabase' ? 'Metabase' : 'Ticket Insera'],
        [t('cOwner'), r.owner], [t('cOwnerGroup'), r.ownerGroup],
      ];
      var summary = '<div class="tc-summary">' + cells.map(function(c){
        return '<div class="tc-cell"><div class="k">' + c[0] + '</div><div class="v">' + (c[1] || '-') + '</div></div>';
      }).join('') + '</div>';

      var detail = r.open ? '<div class="tc-detail">' + Object.keys(r.detail).map(function(k){
        return '<div class="tc-row"><div class="k">' + k + '</div><div class="v">' + r.detail[k] + '</div></div>';
      }).join('') + '</div>' : '';

      return '<div class="ticket-card">' + head + summary + detail + '</div>';
    }).join('');
  }

  function doSearch(){
    var raw = ticketInput.value.split(/[\n,]+/).map(function(s){ return s.trim().toUpperCase(); }).filter(Boolean);
    if (!raw.length) { toast(t('msgSearchFail')); return; }
    searchBtn.textContent = t('searching');
    setTimeout(function(){
      searchBtn.textContent = t('search');
      results = raw.map(function(no){
        var d = TICKETS[no];
        return d ? Object.assign({ ticket: no, open: false }, d) : { ticket: no, found: false, open: false };
      });
      renderResults();
    }, 450);
  }
  searchBtn.addEventListener('click', doSearch);
  ticketInput.addEventListener('keydown', function(e){
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') { doSearch(); }
  });

  document.getElementById('ticketList').addEventListener('click', function(e){
    var td = e.target.closest('[data-toggle-detail]');
    if (td) {
      var i = parseInt(td.dataset.toggleDetail, 10);
      results[i].open = !results[i].open;
      renderResults();
      return;
    }
    var sy = e.target.closest('[data-sync]');
    if (sy) {
      var r = results[parseInt(sy.dataset.sync, 10)];
      toast(r.ticket + (r.source === 'ticket_insera' ? t('msgUpdated') : t('msgCreated')));
    }
  });

  syncAllBtn.addEventListener('click', function(){
    var n = results.filter(function(r){ return r.found; }).length;
    syncAllBtn.disabled = true;
    var label = syncAllBtn.querySelector('span');
    label.textContent = t('syncing');
    setTimeout(function(){
      syncAllBtn.disabled = false;
      label.textContent = t('syncAll');
      label.dataset.i18n = 'syncAll';
      toast(n + t('msgAllSynced'));
    }, 700);
  });

  function onLangChange(){ renderResults(); }
  applyLang();
</script>
</body>
</html>
