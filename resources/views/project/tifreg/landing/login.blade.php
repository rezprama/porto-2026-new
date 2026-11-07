<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login — DALAPA Regional Platform</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet" />
<style>
  :root{
    --brand-50:#ecf3ff; --brand-500:#465fff; --brand-600:#3641f5;
    --gray-25:#fcfcfd; --gray-50:#f9fafb; --gray-100:#f2f4f7; --gray-200:#e4e7ec; --gray-300:#d0d5dd;
    --gray-400:#98a2b3; --gray-500:#667085; --gray-700:#344054; --gray-800:#1d2939; --gray-900:#101828;
    --error-500:#f04438;
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
  @media (min-width:992px){ .layout{flex-direction:row;height:100dvh} }

  /* ---------- back-to-portfolio badge: minimal logo, expands on hover ---------- */
  .demo-badge{position:fixed;top:14px;left:50%;transform:translateX(-50%);z-index:1250;
    display:inline-flex;align-items:center;background:color-mix(in srgb, var(--gray-900) 82%, transparent);
    padding:6px;border-radius:20px;text-decoration:none;backdrop-filter:blur(6px);overflow:hidden;transition:padding .25s ease}
  .demo-badge .mark{width:22px;height:22px;border-radius:50%;background:#ffffff;display:flex;align-items:center;justify-content:center;
    padding:2px;flex-shrink:0;box-shadow:0 1px 3px rgba(0,0,0,.25);overflow:hidden}
  .demo-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .demo-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11.5px;font-weight:500;
    margin-left:0;transition:max-width .25s ease,opacity .2s ease,margin-left .25s ease}
  .demo-badge:hover .txt{max-width:280px;opacity:1;margin-left:8px}

  /* ---------- left: form panel ---------- */
  .form-side{flex:1;display:flex;flex-direction:column;overflow-y:auto;padding:76px 24px 32px}
  @media (min-width:640px){ .form-side{padding:76px 40px 32px} }
  .top-controls{position:absolute;top:16px;right:16px;display:flex;align-items:center;gap:10px}
  @media (min-width:640px){ .top-controls{top:24px;right:24px} }
  .theme-btn{width:40px;height:40px;border-radius:50%;border:1px solid var(--border);background:var(--panel-bg);
    display:grid;place-items:center;color:var(--text);cursor:pointer}
  .locale-select{height:40px;border:1px solid var(--border);border-radius:8px;background:var(--panel-bg);color:var(--text);
    font-family:inherit;font-size:13px;padding:0 10px}

  .form-wrap{margin:auto;width:100%;max-width:400px}
  .form-wrap h1{font-size:22px;font-weight:600;color:var(--text);margin-bottom:28px}

  .field{margin-bottom:20px}
  .field label{display:block;font-size:14px;font-weight:500;color:var(--label);margin-bottom:6px}
  .field label .req{color:var(--error-500)}
  .field input{width:100%;height:44px;border-radius:8px;border:1px solid var(--border);background:transparent;
    padding:0 16px;font-size:14px;font-family:inherit;color:var(--text);box-shadow:var(--shadow-xs)}
  .field input::placeholder{color:var(--muted)}
  .field input:focus{outline:none;border-color:var(--brand-500);box-shadow:0 0 0 3px color-mix(in srgb, var(--brand-500) 12%, transparent)}

  .type-toggle{display:grid;grid-template-columns:1fr 1fr;gap:12px}
  .type-btn{height:46px;border-radius:8px;border:1px solid var(--border);background:transparent;color:var(--label);
    font-family:inherit;font-size:13.5px;font-weight:500;cursor:pointer;transition:.15s}
  .type-btn.on{border-color:var(--brand-500);background:var(--brand-50);color:var(--brand-600)}
  [data-theme="dark"] .type-btn.on{background:color-mix(in srgb, var(--brand-500) 18%, transparent)}

  .pw-wrap{position:relative}
  .pw-wrap input{padding-right:44px}
  .pw-eye{position:absolute;top:50%;right:14px;transform:translateY(-50%);cursor:pointer;color:var(--muted);
    display:grid;place-items:center;background:none;border:none}
  .forgot-row{text-align:right;margin-top:8px}
  .forgot-row button{background:none;border:none;font-family:inherit;font-size:13.5px;font-weight:500;color:var(--brand-500);cursor:pointer}
  .forgot-row button:hover{color:var(--brand-600);text-decoration:underline}

  .submit-btn{width:100%;height:46px;border-radius:8px;border:none;background:var(--brand-500);color:#fff;
    font-family:inherit;font-size:14px;font-weight:500;cursor:pointer;transition:.15s}
  .submit-btn:hover{background:var(--brand-600)}

  .demo-note{margin-top:12px;font-size:12.5px;color:var(--error-500);background:color-mix(in srgb, var(--error-500) 8%, transparent);
    border-radius:8px;padding:9px 12px}

  .below-links{margin-top:20px;display:flex;flex-direction:column;gap:8px}
  .below-links p{font-size:13.5px;color:var(--label)}
  .below-links a{color:var(--brand-500);text-decoration:none;font-weight:500}
  .below-links a:hover{color:var(--brand-600);text-decoration:underline}

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
        <h1 data-i18n="welcome">Selamat Datang !</h1>

        <form id="loginForm">
          <div class="field">
            <label><span data-i18n="loginType">Login Type</span> <span class="req">*</span></label>
            <div class="type-toggle">
              <button type="button" class="type-btn on" id="typeLdap">LDAP Telkom</button>
              <button type="button" class="type-btn" id="typeAccount" data-i18n="typeAccount">DALAPA Account</button>
            </div>
          </div>

          <div class="field">
            <label for="username"><span data-i18n="usernameLabel">Username / NIK / Email</span> <span class="req">*</span></label>
            <input type="text" id="username" data-i18n-ph="usernamePh" placeholder="Masukkan username, NIK, atau email" autocomplete="off" />
          </div>

          <div class="field">
            <label for="password"><span data-i18n="passwordLabel">Kata Sandi</span> <span class="req">*</span></label>
            <div class="pw-wrap">
              <input type="password" id="password" data-i18n-ph="passwordPh" placeholder="Masukkan kata sandi" autocomplete="off" />
              <button type="button" class="pw-eye" id="pwEye" aria-label="Tampilkan kata sandi">
                <svg id="eyeOpen" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg id="eyeClosed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><path d="M1 1l22 22"/></svg>
              </button>
            </div>
            <div class="forgot-row">
              <button type="button" id="forgotBtn" data-i18n="forgot">Lupa kata sandi?</button>
            </div>
          </div>

          <button type="submit" class="submit-btn" data-i18n="submit">Masuk</button>
          <p class="demo-note" id="demoNote" hidden></p>
        </form>

        <div class="below-links">
          <p><span data-i18n="noAccount">Belum memiliki akun?</span> <a href="{{ route('project.tifreg.register') }}" data-i18n="register">Registrasi</a></p>
          <p><a href="#" onclick="return false" data-i18n="guide">Buka Panduan Pengguna DALAPA</a></p>
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
      welcome: 'Selamat Datang !', loginType: 'Login Type', typeAccount: 'Akun DALAPA',
      usernameLabel: 'Username / NIK / Email', usernamePh: 'Masukkan username, NIK, atau email',
      passwordLabel: 'Kata Sandi', passwordPh: 'Masukkan kata sandi',
      forgot: 'Lupa kata sandi?', submit: 'Masuk',
      noAccount: 'Belum memiliki akun?', register: 'Registrasi', guide: 'Buka Panduan Pengguna DALAPA',
      wrongCred: 'Username atau kata sandi salah. (Coba 1111 / 1111 untuk demo)',
      forgotNote: 'Ini tampilan demo — reset kata sandi tidak terhubung ke server sungguhan.',
    },
    en: {
      welcome: 'Welcome !', loginType: 'Login Type', typeAccount: 'DALAPA Account',
      usernameLabel: 'Username / NIK / Email', usernamePh: 'Enter username, NIK, or email',
      passwordLabel: 'Password', passwordPh: 'Enter password',
      forgot: 'Forgot password?', submit: 'Login',
      noAccount: "Don't have an account?", register: 'Register', guide: 'Open DALAPA User Guide',
      wrongCred: 'Wrong username or password. (Try 1111 / 1111 for the demo)',
      forgotNote: 'This is a UI demo — password reset is not connected to a real server.',
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

  var typeLdap = document.getElementById('typeLdap');
  var typeAccount = document.getElementById('typeAccount');
  typeLdap.addEventListener('click', function(){ typeLdap.classList.add('on'); typeAccount.classList.remove('on'); });
  typeAccount.addEventListener('click', function(){ typeAccount.classList.add('on'); typeLdap.classList.remove('on'); });

  var pwInput = document.getElementById('password');
  var pwEye = document.getElementById('pwEye');
  pwEye.addEventListener('click', function(){
    var show = pwInput.type === 'password';
    pwInput.type = show ? 'text' : 'password';
    document.getElementById('eyeOpen').style.display = show ? 'none' : '';
    document.getElementById('eyeClosed').style.display = show ? '' : 'none';
  });

  var demoNote = document.getElementById('demoNote');
  function showNote(msg){ demoNote.textContent = msg; demoNote.hidden = false; }

  document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();
    var u = document.getElementById('username').value.trim();
    var p = document.getElementById('password').value.trim();
    if (u === '1111' && p === '1111') {
      window.location.href = "{{ route('project.tifreg.dashboard') }}";
      return;
    }
    showNote(t('wrongCred'));
  });
  document.getElementById('forgotBtn').addEventListener('click', function(){
    showNote(t('forgotNote'));
  });
</script>
</body>
</html>
