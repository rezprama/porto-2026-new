<script>
  /* ---------- i18n: shell keys merged with the page's own PAGE_I18N ---------- */
  var SHELL_I18N = {
    id: {
      navMaterial: 'Tracking Material', navStock: 'Stock Opname', navMinStock: 'Minimum Stock', navB2B: 'Monitoring B2B',
      navProject: 'List Project', navBudget: 'Anggaran', navUser: 'Manajemen Pengguna',
      navDataSearch: 'Cari Data', navOrganisasi: 'Organisasi',
      navGcuMonitoring: 'Monitoring', navGcuElectrical: 'Monitoring Kelistrikan',
      navGcuListing: 'Listing', navGcuApproval: 'Approval',
      logout: 'Keluar', localeLabel: 'Bahasa Indonesia',
      yes: 'Ya', no: 'Tidak', active: 'Aktif', inactive: 'Tidak Aktif',
      of: 'dari', rowsWord: 'data', cancel: 'Batal', close: 'Tutup', save: 'Simpan',
      search: 'Cari', refresh: 'Refresh', notFoundData: 'Data tidak ditemukan.', detail: 'Detail',
      /* shared Detail Workorder modal (Monitoring + Approval) */
      wodTitle: 'Detail Workorder', wodPrimary: 'Informasi Utama', wodMeasure: 'Informasi Pengukuran',
      wodAdditional: 'Informasi Tambahan', wodPln: 'Informasi PLN', wodEvidence: 'Evidence',
      wodEmpty: 'Detail Belum Tersedia',
      wodHostname: 'Hostname', wodIpHostname: 'IP Hostname', wodStatusWo: 'Status Workorder',
      wodTicket: 'Ticket ID', wodTglListing: 'Tanggal Listing', wodTglComplete: 'Tanggal Complete Teknisi',
      wodTglApproval: 'Tanggal Approval', wodClosing: 'Closing Date Salamsim', wodSto: 'STO',
      wodDistrict: 'District', wodTeknisiConfirm: 'Teknisi Confirm', wodTeknisiApproval: 'Teknisi Approval',
      wodPowerInput: 'Power Input', wodTempAc: 'Temperatur AC', wodTempOlt: 'Temperatur OLT',
      wodTempRuangan: 'Temperatur Ruangan', wodBatOutput: 'Baterai Output', wodBatBersih: 'Baterai Bersih',
      wodGrounding: 'Grounding', wodBir: 'BIR', wodPowerSource: 'Power Source', wodAlarmModule: 'Alarm Module',
      wodTypeRecti: 'Type Recti', wodGroundingUkur: 'Grounding Ukur',
      wodLokasi: 'Lokasi', wodNotes: 'Notes', wodKoordinat: 'Koordinat', wodRegional: 'Regional',
      wodArea: 'Area', wodBatteryExist: 'Battery Exist',
      wodPlnStatus: 'Status PLN', wodPlnJenis: 'Jenis PLN', wodPlnId: 'ID Pelanggan', wodPlnMeteran: 'No. Meteran',
      wodKwhAwal: 'kWh Awal', wodKwhTerakhir: 'kWh Terakhir', wodKwhUpdate: 'kWh Update', wodTglKwh: 'Tanggal Input kWh',
      wodBefore: 'Sebelum', wodAfter: 'Sesudah', wodPowerEvidence: 'Power',
      stWaiting: 'Waiting', stPending: 'Pending', stRework: 'Rework', stKonfirm: 'Complete Teknisi',
      stComplete: 'Complete', stExpired: 'Expired',
    },
    en: {
      navMaterial: 'Material Tracking', navStock: 'Stock Opname', navMinStock: 'Minimum Stock', navB2B: 'B2B Monitoring',
      navProject: 'Project List', navBudget: 'Budget', navUser: 'User Management',
      navDataSearch: 'Search Data', navOrganisasi: 'Organisation',
      navGcuMonitoring: 'Monitoring', navGcuElectrical: 'Electrical Monitoring',
      navGcuListing: 'Listing', navGcuApproval: 'Approval',
      logout: 'Logout', localeLabel: 'English',
      yes: 'Yes', no: 'No', active: 'Active', inactive: 'Inactive',
      of: 'of', rowsWord: 'records', cancel: 'Cancel', close: 'Close', save: 'Save',
      search: 'Search', refresh: 'Refresh', notFoundData: 'No data found.', detail: 'Detail',
      wodTitle: 'Workorder Detail', wodPrimary: 'Primary Information', wodMeasure: 'Measurement Information',
      wodAdditional: 'Additional Information', wodPln: 'PLN Information', wodEvidence: 'Evidence',
      wodEmpty: 'Detail Not Available',
      wodHostname: 'Hostname', wodIpHostname: 'IP Hostname', wodStatusWo: 'Workorder Status',
      wodTicket: 'Ticket ID', wodTglListing: 'Listing Date', wodTglComplete: 'Technician Complete Date',
      wodTglApproval: 'Approval Date', wodClosing: 'Closing Date Salamsim', wodSto: 'STO',
      wodDistrict: 'District', wodTeknisiConfirm: 'Technician Confirm', wodTeknisiApproval: 'Technician Approval',
      wodPowerInput: 'Power Input', wodTempAc: 'AC Temperature', wodTempOlt: 'OLT Temperature',
      wodTempRuangan: 'Room Temperature', wodBatOutput: 'Battery Output', wodBatBersih: 'Net Battery',
      wodGrounding: 'Grounding', wodBir: 'BIR', wodPowerSource: 'Power Source', wodAlarmModule: 'Alarm Module',
      wodTypeRecti: 'Rectifier Type', wodGroundingUkur: 'Grounding Measurement',
      wodLokasi: 'Location', wodNotes: 'Notes', wodKoordinat: 'Coordinate', wodRegional: 'Regional',
      wodArea: 'Area', wodBatteryExist: 'Battery Exists',
      wodPlnStatus: 'PLN Status', wodPlnJenis: 'PLN Type', wodPlnId: 'Customer ID', wodPlnMeteran: 'Meter Number',
      wodKwhAwal: 'Initial kWh', wodKwhTerakhir: 'Last kWh', wodKwhUpdate: 'Updated kWh', wodTglKwh: 'kWh Input Date',
      wodBefore: 'Before', wodAfter: 'After', wodPowerEvidence: 'Power',
      stWaiting: 'Waiting', stPending: 'Pending', stRework: 'Rework', stKonfirm: 'Complete Technician',
      stComplete: 'Complete', stExpired: 'Expired',
    },
  };
  var I18N = { id: {}, en: {} };
  ['id', 'en'].forEach(function(l){
    Object.assign(I18N[l], SHELL_I18N[l], (typeof PAGE_I18N !== 'undefined' && PAGE_I18N[l]) || {});
  });

  var LANG = 'id';
  try { LANG = localStorage.getItem('dalapa-lang') || 'id'; } catch (e) {}
  function t(k){ return (I18N[LANG] && I18N[LANG][k]) || I18N.id[k] || k; }
  function applyLang(){
    document.querySelectorAll('[data-i18n]').forEach(function(el){ el.textContent = t(el.dataset.i18n); });
    document.querySelectorAll('[data-i18n-ph]').forEach(function(el){ el.placeholder = t(el.dataset.i18nPh); });
    document.querySelectorAll('[data-i18n-title]').forEach(function(el){ el.title = t(el.dataset.i18nTitle); });
    document.querySelectorAll('#langSwitch button').forEach(function(b){ b.classList.toggle('on', b.dataset.lang === LANG); });
    document.documentElement.lang = LANG;
    if (typeof onLangChange === 'function') { onLangChange(); }
  }
  document.querySelectorAll('#langSwitch button').forEach(function(btn){
    btn.addEventListener('click', function(){
      if (btn.dataset.lang === LANG) { return; }
      LANG = btn.dataset.lang;
      try { localStorage.setItem('dalapa-lang', LANG); } catch (e) {}
      applyLang();
    });
  });

  /* ---------- theme ---------- */
  function paintThemeIcons(){
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    document.getElementById('themeIconLight').style.display = isDark ? 'none' : '';
    document.getElementById('themeIconDark').style.display = isDark ? '' : 'none';
  }
  document.getElementById('themeBtn').addEventListener('click', function(){
    var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    try { localStorage.setItem('dalapa-theme', next); } catch (e) {}
    paintThemeIcons();
  });
  paintThemeIcons();

  /* ---------- clock ---------- */
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

  /* ---------- shared: readonly key/value grid renderer ---------- */
  function kvHtml(items){
    return items.map(function(it){
      var v = it[1];
      return '<div class="kv-item"><div class="k">' + it[0] + '</div><div class="v">' + (v === null || v === undefined || v === '' ? '-' : v) + '</div></div>';
    }).join('');
  }

  /* ---------- toast ---------- */
  function toast(msg){
    var stack = document.getElementById('toastStack');
    var el = document.createElement('div');
    el.className = 'toast';
    el.textContent = msg;
    stack.appendChild(el);
    requestAnimationFrame(function(){ el.classList.add('show'); });
    setTimeout(function(){ el.classList.remove('show'); setTimeout(function(){ el.remove(); }, 250); }, 2800);
  }
</script>
