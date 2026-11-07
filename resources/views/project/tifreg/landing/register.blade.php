<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Registrasi — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
<style>
  :root{
    --brand-50:#ecf3ff; --brand-500:#465fff; --brand-600:#3641f5;
    --gray-25:#fcfcfd; --gray-50:#f9fafb; --gray-100:#f2f4f7; --gray-200:#e4e7ec; --gray-300:#d0d5dd;
    --gray-400:#98a2b3; --gray-500:#667085; --gray-700:#344054; --gray-800:#1d2939; --gray-900:#101828;
    --error-500:#f04438; --success-50:#ecfdf3; --success-200:#abefc6; --success-700:#067647;
    --warn-500:#f59e0b;
    --bg:#fff; --panel-bg:#fff; --text:var(--gray-800); --label:var(--gray-700); --muted:var(--gray-400);
    --border:var(--gray-300); --shadow-xs:0 1px 2px 0 rgba(16,24,40,.05);
  }
  [data-theme="dark"]{
    --bg:var(--gray-900); --panel-bg:var(--gray-900); --text:rgba(255,255,255,.9); --label:var(--gray-400);
    --muted:rgba(255,255,255,.3); --border:var(--gray-700);
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:"Outfit",system-ui,sans-serif;background:var(--bg);color:var(--text);min-height:100dvh;transition:background .2s,color .2s}
  .layout{display:flex;flex-direction:column;min-height:100dvh}
  @media (min-width:992px){ .layout{flex-direction:row;min-height:100dvh} }

  .demo-badge{position:fixed;top:14px;left:50%;transform:translateX(-50%);z-index:1250;
    display:inline-flex;align-items:center;background:color-mix(in srgb, var(--gray-900) 82%, transparent);
    padding:6px;border-radius:20px;text-decoration:none;backdrop-filter:blur(6px);overflow:hidden;transition:padding .25s ease}
  .demo-badge .mark{width:22px;height:22px;border-radius:50%;background:#ffffff;display:flex;align-items:center;justify-content:center;
    padding:2px;flex-shrink:0;box-shadow:0 1px 3px rgba(0,0,0,.25);overflow:hidden}
  .demo-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .demo-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11.5px;font-weight:500;
    margin-left:0;transition:max-width .25s ease,opacity .2s ease,margin-left .25s ease}
  .demo-badge:hover .txt{max-width:280px;opacity:1;margin-left:8px}

  .form-side{flex:1;display:flex;flex-direction:column;overflow-y:auto;padding:76px 24px 40px}
  @media (min-width:640px){ .form-side{padding:76px 40px 40px} }
  .top-controls{position:absolute;top:16px;right:16px;display:flex;align-items:center;gap:10px}
  @media (min-width:640px){ .top-controls{top:24px;right:24px} }
  .theme-btn{width:40px;height:40px;border-radius:50%;border:1px solid var(--border);background:var(--panel-bg);
    display:grid;place-items:center;color:var(--text);cursor:pointer}
  .locale-select{height:40px;border:1px solid var(--border);border-radius:8px;background:var(--panel-bg);color:var(--text);
    font-family:inherit;font-size:13px;padding:0 10px}

  .back-link{display:inline-flex;align-items:center;gap:6px;font-size:13.5px;font-weight:500;color:var(--label);
    text-decoration:none;margin-bottom:20px}
  .back-link:hover{color:var(--brand-500)}

  .form-wrap{margin:0 auto;width:100%;max-width:480px}
  .form-wrap h1{font-size:22px;font-weight:600;color:var(--text);margin-bottom:24px}

  .field{margin-bottom:18px}
  .field label{display:block;font-size:14px;font-weight:500;color:var(--label);margin-bottom:6px}
  .field label .req{color:var(--error-500)}
  .field .hint{font-size:12px;color:var(--muted);margin-top:5px}
  .field input, .field select{width:100%;height:44px;border-radius:8px;border:1px solid var(--border);background:transparent;
    padding:0 14px;font-size:14px;font-family:inherit;color:var(--text);box-shadow:var(--shadow-xs)}
  .field select:disabled{opacity:.5;cursor:not-allowed}
  .field input::placeholder{color:var(--muted)}
  .field input:focus, .field select:focus{outline:none;border-color:var(--brand-500);box-shadow:0 0 0 3px color-mix(in srgb, var(--brand-500) 12%, transparent)}

  .row2{display:grid;grid-template-columns:1fr;gap:14px}
  .row3{display:grid;grid-template-columns:1fr;gap:14px}
  @media (min-width:560px){ .row2{grid-template-columns:1fr 1fr} .row3{grid-template-columns:1fr 1fr 1fr} }

  .pw-wrap{position:relative}
  .pw-wrap input{padding-right:44px}
  .pw-eye{position:absolute;top:50%;right:14px;transform:translateY(-50%);cursor:pointer;color:var(--muted);
    display:grid;place-items:center;background:none;border:none}

  .strength{display:grid;grid-template-columns:repeat(4,1fr);gap:5px;margin-top:8px}
  .strength i{height:4px;border-radius:3px;background:var(--gray-200);display:block}
  [data-theme="dark"] .strength i{background:var(--gray-700)}

  .submit-btn{width:100%;height:46px;border-radius:8px;border:none;background:var(--brand-500);color:#fff;
    font-family:inherit;font-size:14px;font-weight:500;cursor:pointer;transition:.15s;margin-top:6px}
  .submit-btn:hover{background:var(--brand-600)}

  .below-links{margin-top:20px;text-align:center}
  .below-links p{font-size:13.5px;color:var(--label)}
  .below-links a{color:var(--brand-500);text-decoration:none;font-weight:500}
  .below-links a:hover{color:var(--brand-600);text-decoration:underline}

  /* ---------- success panel ---------- */
  .success-panel{background:var(--success-50);border:1px solid var(--success-200);border-radius:12px;padding:22px}
  [data-theme="dark"] .success-panel{background:color-mix(in srgb, var(--success-700) 18%, transparent)}
  .success-panel h2{font-size:17px;color:var(--success-700);margin-bottom:8px}
  [data-theme="dark"] .success-panel h2{color:#75e0a7}
  .success-panel p{font-size:13.5px;color:var(--label);margin-bottom:14px}
  .success-dl{background:var(--panel-bg);border:1px solid var(--border);border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:13px}
  .success-dl div{display:flex;justify-content:space-between;padding:3px 0}
  .success-dl b{color:var(--text)}
  .success-panel .submit-btn{background:var(--brand-500)}

  /* ---------- right: banner panel ---------- */
  .banner-side{display:none;position:relative;background:var(--gray-800);overflow:hidden}
  @media (min-width:992px){ .banner-side{display:flex;flex:1;align-items:center;justify-content:center} }
  .grid-shape{position:absolute;width:100%;max-width:450px;opacity:.5;z-index:0}
  .grid-shape.tr{top:0;right:0}
  .grid-shape.bl{bottom:0;left:0;transform:rotate(180deg)}
  .banner-content{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;max-width:300px;text-align:center}
  .banner-content img{width:100%;max-width:220px;height:auto;margin-bottom:16px}
  .banner-content p{color:#e4e7ec;font-weight:700;font-size:15px}
</style>
<script>try{var _th=localStorage.getItem("dalapa-theme");if(_th){document.documentElement.setAttribute("data-theme",_th);}}catch(e){}</script>
</head>
<body>

  <a class="demo-badge" href="/">
    <span class="mark"><img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" /></span>
    <span class="txt">Demo UI · Portfolio Reza Pratama</span>
  </a>

  <div class="layout">
    <div class="form-side" style="position:relative">
      <div class="top-controls">
        <button class="theme-btn" id="themeBtn" type="button" aria-label="Ganti tema">
          <svg id="themeIconLight" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/></svg>
          <svg id="themeIconDark" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
        </button>
        <select class="locale-select" id="localeSelect" aria-label="Bahasa">
          <option value="id">Bahasa Indonesia</option>
          <option value="en">English</option>
        </select>
      </div>

      <div class="form-wrap">
        <a class="back-link" href="{{ route('project.tifreg.login') }}">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
          <span data-i18n="backLogin">Kembali ke Halaman Login</span>
        </a>
        <h1 data-i18n="title">Registrasi</h1>

        <form id="regForm">
          <div class="field row2">
            <div><label>NIK <span class="req">*</span></label><input type="text" id="nik" data-i18n-ph="nikPh" placeholder="Nomor Induk Karyawan" required /></div>
            <div><label><span data-i18n="nameLabel">Nama</span> <span class="req">*</span></label><input type="text" id="nama" data-i18n-ph="namePh" placeholder="Nama lengkap" required /></div>
          </div>

          <div class="field">
            <label>Email <span class="req">*</span></label>
            <input type="email" data-i18n-ph="emailPh" placeholder="nama@perusahaan.com" required />
          </div>

          <div class="field row2">
            <div><label><span data-i18n="contactLabel">Kontak</span> <span class="req">*</span></label><input type="text" placeholder="08xxxxxxxxxx" required /></div>
            <div>
              <label>Telegram Chat ID <span class="req">*</span></label>
              <input type="text" data-i18n-ph="telegramPh" placeholder="Dari bot @dalapa_helper_bot" required />
            </div>
          </div>
          <p class="hint" style="margin:-10px 0 18px" data-i18n="telegramHint">Chat ID didapat dengan mengirim pesan ke bot Telegram @dalapa_helper_bot.</p>

          <div class="field">
            <label>Role <span class="req">*</span></label>
            <select id="role">
              <option value="" data-i18n="rolePh">Pilih role</option>
              <option value="area">Admin Area</option>
              <option value="regional">Admin Regional</option>
              <option value="district">Admin District</option>
              <option value="sto">Admin STO</option>
              <option value="guest">Guest / Viewer</option>
            </select>
          </div>

          <div class="field row3">
            <div><label>Area</label><select id="area"><option value="" data-i18n="areaPh">Pilih area</option><option>Kalimantan</option><option>Sulawesi</option><option>Jawa Bagian Barat</option></select></div>
            <div><label>Regional</label><select id="regional" disabled><option value="" data-i18n="regionalPh">Pilih regional</option></select></div>
            <div><label>District</label><select id="district" disabled><option value="" data-i18n="districtPh">Pilih district</option></select></div>
          </div>

          <div class="field">
            <label data-i18n="unitLabel">Unit Organisasi</label>
            <select><option value="" data-i18n="unitPh">Tanpa Unit</option><option>Network Operation</option><option>Asset Management</option><option>Field Services</option></select>
          </div>

          <div class="field">
            <label>Password <span class="req">*</span></label>
            <div class="pw-wrap">
              <input type="password" id="pw1" data-i18n-ph="pw1Ph" placeholder="Minimal 12 karakter" required />
              <button type="button" class="pw-eye" id="pwEye1" aria-label="Tampilkan kata sandi">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <div class="strength"><i></i><i></i><i></i><i></i></div>
            <p class="hint" data-i18n="pwHint">Minimal 12 karakter, mengandung huruf besar, huruf kecil, dan angka.</p>
          </div>

          <div class="field">
            <label><span data-i18n="pw2Label">Konfirmasi Kata Sandi</span> <span class="req">*</span></label>
            <div class="pw-wrap">
              <input type="password" id="pw2" data-i18n-ph="pw2Ph" placeholder="Ulangi kata sandi" required />
              <button type="button" class="pw-eye" id="pwEye2" aria-label="Tampilkan kata sandi">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
          </div>

          <button type="submit" class="submit-btn" data-i18n="submit">Register</button>
        </form>

        <div class="success-panel" id="successPanel" hidden>
          <h2 data-i18n="successTitle">Registrasi Berhasil</h2>
          <p data-i18n="successBody">Akun Anda telah terdaftar dan sedang menunggu persetujuan DALAPA Helpdesk sebelum dapat digunakan. Aktivasi akan diinfokan melalui Telegram.</p>
          <div class="success-dl">
            <div><span>NIK</span><b id="sNik">—</b></div>
            <div><span data-i18n="nameLabel">Nama</span><b id="sNama">—</b></div>
          </div>
          <a class="submit-btn" style="display:block;text-align:center;text-decoration:none;line-height:46px" href="https://t.me/dalapa_helpdesk" target="_blank" rel="noopener" data-i18n="contactHelpdesk">Hubungi @dalapa_helpdesk</a>
        </div>

        <div class="below-links">
          <p><span data-i18n="haveAccount">Sudah Punya Akun?</span> <a href="{{ route('project.tifreg.login') }}">Login</a></p>
        </div>
      </div>
    </div>

    <div class="banner-side">
      <img class="grid-shape tr" src="/images/tifreg/grid-01.svg" alt="" aria-hidden="true" />
      <img class="grid-shape bl" src="/images/tifreg/grid-01.svg" alt="" aria-hidden="true" />
      <div class="banner-content">
        <img src="/images/tifreg/logo.png" alt="DALAPA" />
        <p>Asset Management</p>
      </div>
    </div>
  </div>

<script>
  /* ---------- i18n ---------- */
  var I18N = {
    id: {
      backLogin: 'Kembali ke Halaman Login', title: 'Registrasi',
      nikPh: 'Nomor Induk Karyawan', nameLabel: 'Nama', namePh: 'Nama lengkap',
      emailPh: 'nama@perusahaan.com', contactLabel: 'Kontak', telegramPh: 'Dari bot @dalapa_helper_bot',
      telegramHint: 'Chat ID didapat dengan mengirim pesan ke bot Telegram @dalapa_helper_bot.',
      rolePh: 'Pilih role', areaPh: 'Pilih area', regionalPh: t('regionalPh'), districtPh: t('districtPh'),
      unitLabel: 'Unit Organisasi', unitPh: 'Tanpa Unit',
      pw1Ph: 'Minimal 12 karakter', pwHint: 'Minimal 12 karakter, mengandung huruf besar, huruf kecil, dan angka.',
      pw2Label: 'Konfirmasi Kata Sandi', pw2Ph: 'Ulangi kata sandi', submit: 'Register',
      successTitle: 'Registrasi Berhasil',
      successBody: 'Akun Anda telah terdaftar dan sedang menunggu persetujuan DALAPA Helpdesk sebelum dapat digunakan. Aktivasi akan diinfokan melalui Telegram.',
      contactHelpdesk: 'Hubungi @dalapa_helpdesk', haveAccount: 'Sudah Punya Akun?',
    },
    en: {
      backLogin: 'Back to Login Page', title: 'Registration',
      nikPh: 'Employee ID number', nameLabel: 'Name', namePh: 'Full name',
      emailPh: 'name@company.com', contactLabel: 'Contact', telegramPh: 'From @dalapa_helper_bot',
      telegramHint: 'Get your Chat ID by sending a message to the Telegram bot @dalapa_helper_bot.',
      rolePh: 'Select role', areaPh: 'Select area', regionalPh: 'Select regional', districtPh: 'Select district',
      unitLabel: 'Organization Unit', unitPh: 'No Unit',
      pw1Ph: 'At least 12 characters', pwHint: 'At least 12 characters, containing uppercase, lowercase, and a number.',
      pw2Label: 'Confirm Password', pw2Ph: 'Repeat password', submit: 'Register',
      successTitle: 'Registration Successful',
      successBody: 'Your account has been registered and is waiting for DALAPA Helpdesk approval before it can be used. Activation will be notified via Telegram.',
      contactHelpdesk: 'Contact @dalapa_helpdesk', haveAccount: 'Already have an account?',
    },
  };
  var LANG = 'id';
  try { LANG = localStorage.getItem('dalapa-lang') || 'id'; } catch (e) {}
  function t(k){ return (I18N[LANG] && I18N[LANG][k]) || I18N.id[k] || k; }
  function applyLang(){
    document.querySelectorAll('[data-i18n]').forEach(function(el){ el.textContent = t(el.dataset.i18n); });
    document.querySelectorAll('[data-i18n-ph]').forEach(function(el){ el.placeholder = t(el.dataset.i18nPh); });
    document.documentElement.lang = LANG;
  }
  var localeSelect = document.getElementById('localeSelect');
  localeSelect.value = LANG;
  localeSelect.addEventListener('change', function(){
    LANG = localeSelect.value;
    try { localStorage.setItem('dalapa-lang', LANG); } catch (e) {}
    applyLang();
  });
  applyLang();

  var themeBtn = document.getElementById('themeBtn');
  function paintThemeIcons(){
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    document.getElementById('themeIconLight').style.display = isDark ? 'none' : '';
    document.getElementById('themeIconDark').style.display = isDark ? '' : 'none';
  }
  themeBtn.addEventListener('click', function(){
    var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    try { localStorage.setItem('dalapa-theme', next); } catch (e) {}
    paintThemeIcons();
  });
  paintThemeIcons();

  function wireEye(btnId, inputId){
    var btn = document.getElementById(btnId), input = document.getElementById(inputId);
    btn.addEventListener('click', function(){ input.type = input.type === 'password' ? 'text' : 'password'; });
  }
  wireEye('pwEye1', 'pw1');
  wireEye('pwEye2', 'pw2');

  var REGIONAL = {
    Kalimantan: ['Regional Kalimantan Timur', 'Regional Kalimantan Selatan'],
    Sulawesi: ['Regional Sulawesi Selatan', 'Regional Sulawesi Utara'],
    'Jawa Bagian Barat': ['Regional Jakarta', 'Regional Bandung'],
  };
  var DISTRICT = {
    'Regional Kalimantan Timur': ['District Balikpapan', 'District Samarinda'],
    'Regional Kalimantan Selatan': ['District Banjarmasin'],
    'Regional Sulawesi Selatan': ['District Makassar'],
    'Regional Sulawesi Utara': ['District Manado'],
    'Regional Jakarta': ['District Jakarta Pusat', 'District Jakarta Selatan'],
    'Regional Bandung': ['District Bandung Kota'],
  };
  function fillSelect(el, items, placeholder){
    el.innerHTML = '<option value="">' + placeholder + '</option>';
    items.forEach(function(v){ var o = document.createElement('option'); o.textContent = v; el.appendChild(o); });
  }
  var areaEl = document.getElementById('area'), regionalEl = document.getElementById('regional'), districtEl = document.getElementById('district');
  areaEl.addEventListener('change', function(){
    districtEl.disabled = true; fillSelect(districtEl, [], t('districtPh'));
    if (REGIONAL[areaEl.value]) { fillSelect(regionalEl, REGIONAL[areaEl.value], t('regionalPh')); regionalEl.disabled = false; }
    else { regionalEl.disabled = true; fillSelect(regionalEl, [], t('regionalPh')); }
  });
  regionalEl.addEventListener('change', function(){
    if (DISTRICT[regionalEl.value]) { fillSelect(districtEl, DISTRICT[regionalEl.value], t('districtPh')); districtEl.disabled = false; }
    else { districtEl.disabled = true; fillSelect(districtEl, [], t('districtPh')); }
  });

  var pw1 = document.getElementById('pw1');
  var bars = document.querySelectorAll('.strength i');
  var colors = ['#f04438', '#f59e0b', '#84cc16', '#22c55e'];
  pw1.addEventListener('input', function(){
    var v = pw1.value;
    var score = 0;
    if (v.length >= 12) score++;
    if (/[A-Z]/.test(v)) score++;
    if (/[a-z]/.test(v)) score++;
    if (/[0-9]/.test(v)) score++;
    bars.forEach(function(bar, i){ bar.style.background = i < score ? colors[score - 1] : ''; });
  });

  document.getElementById('regForm').addEventListener('submit', function(e){
    e.preventDefault();
    document.getElementById('sNik').textContent = document.getElementById('nik').value || '—';
    document.getElementById('sNama').textContent = document.getElementById('nama').value || '—';
    this.hidden = true;
    document.getElementById('successPanel').hidden = false;
  });
</script>
</body>
</html>
