<script>
  /* ---------- Indonesian-only string table: shell keys merged with the page's own PAGE_I18N.
       The legacy app ships no language switcher, so this is just one central copy deck. ---------- */
  var SHELL_I18N = {
    navMapAlpro: 'Map Alpro', navDaman: 'Data Management', navMappingOltOdp: 'Mapping OLT-ODP',
    navAssurance: 'Assurance', navRekonMaterial: 'Rekon Material Assurance',
    navQe: 'QE', navCapex: 'Wallboard CAPEX', navNewProject: 'New Project',
    navMonitoring: 'Monitoring', navMonitoringRp: 'Monitoring (Anggaran)', navListing: 'Listing',
    navApprovalTl: 'Approval TL', navApprovalEvidence: 'Approval Evidence', navApprovalQe: 'Approval QE',
    navApprovalRegional: 'Approval Regional', navDashboardBoq: 'Dashboard BOQ',
    navExportQe: 'Export Nilai Anggaran New Project',
    navNte: 'NTE', navStockOpname: 'Stock Opname New',
    logout: 'Keluar', home: 'Beranda',
    of: 'dari', cancel: 'Batal', close: 'Tutup', save: 'Simpan', detail: 'Detail', delete: 'Hapus',
    approve: 'Approve', pending: 'Pending', status: 'Status', month: 'Bulan', year: 'Tahun', date: 'Tanggal',
    filter: 'Filter', reset: 'Reset', download: 'Download', search: 'Cari',
    all: 'Semua', notFoundData: 'Data tidak ditemukan.', filterFirst: 'Filter data terlebih dahulu.',
    yes: 'Ya', no: 'Tidak', total: 'Total', lastUpdate: 'Update Terakhir',
    demoOnly: 'Demo UI — aksi ini tidak terhubung ke server sungguhan.',
  };
  var I18N = Object.assign({}, SHELL_I18N, (typeof PAGE_I18N !== 'undefined' && PAGE_I18N) || {});
  function t(k){ return I18N[k] || k; }
  function applyLang(){
    document.querySelectorAll('[data-i18n]').forEach(function(el){ el.textContent = t(el.dataset.i18n); });
    document.querySelectorAll('[data-i18n-ph]').forEach(function(el){ el.placeholder = t(el.dataset.i18nPh); });
    document.querySelectorAll('[data-i18n-title]').forEach(function(el){ el.title = t(el.dataset.i18nTitle); });
  }

  /* ---------- clock (the real app runs on WITA) ---------- */
  function tick(){
    var now = new Date();
    var d = new Intl.DateTimeFormat('sv-SE', { timeZone: 'Asia/Makassar' }).format(now);
    var tm = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false, timeZone: 'Asia/Makassar' }).format(now);
    document.getElementById('clockEl').textContent = d + ' ' + tm + ' WITA';
  }
  tick(); setInterval(tick, 1000);

  /* ---------- sidebar ---------- */
  var sidebar = document.getElementById('sidebar'), sideOverlay = document.getElementById('sideOverlay');
  document.getElementById('hamburger').addEventListener('click', function(){ sidebar.classList.add('open'); sideOverlay.classList.add('show'); });
  sideOverlay.addEventListener('click', function(){ sidebar.classList.remove('open'); sideOverlay.classList.remove('show'); });
  document.querySelectorAll('.nav-group [data-toggle]').forEach(function(btn){
    btn.addEventListener('click', function(){ btn.closest('.nav-group').classList.toggle('open'); });
  });

  /* ---------- helpers ---------- */
  function rupiah(n){ return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }
  function kvHtml(items){
    return items.map(function(it){
      var v = it[1];
      return '<div class="kv-item"><div class="k">' + it[0] + '</div><div class="v">' + (v === null || v === undefined || v === '' ? '-' : v) + '</div></div>';
    }).join('');
  }
  function toast(msg){
    var stack = document.getElementById('toastStack');
    var el = document.createElement('div');
    el.className = 'toast';
    el.textContent = msg;
    stack.appendChild(el);
    requestAnimationFrame(function(){ el.classList.add('show'); });
    setTimeout(function(){ el.classList.remove('show'); setTimeout(function(){ el.remove(); }, 250); }, 2800);
  }

  /* ---------- tab strips: <div class="tabs"><button data-tab="#id">…  ---------- */
  document.querySelectorAll('.tabs').forEach(function(strip){
    strip.addEventListener('click', function(e){
      var btn = e.target.closest('button[data-tab]');
      if (!btn) { return; }
      strip.querySelectorAll('button[data-tab]').forEach(function(b){
        b.classList.toggle('on', b === btn);
        document.querySelector(b.dataset.tab).hidden = b !== btn;
      });
    });
  });
</script>
