<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Authentication Page — DALAPA Regional</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />
<style>
  /* Palette lifted from the real app: Nifty .cls-container #ecf0f5, .btn-primary #1c3550,
     .btn-mint #1f897f, plus the red of the DLP mark. Light mode only, Indonesian only. */
  :root{
    --page:#ecf0f5; --panel:#fff; --border:#d4dae0;
    --heading:#4d627b; --text:#7a878e; --muted:#a3adb5;
    --navy:#1c3550; --mint:#1f897f; --red:#d0242f;
  }
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:"Open Sans",system-ui,sans-serif;background:var(--page);color:var(--text);
    min-height:100dvh;display:flex;align-items:center;justify-content:center;padding:70px 16px 56px;position:relative}
  button{font-family:inherit;cursor:pointer}

  /* the real page paints this exact artwork behind the card at .8 opacity */
  .bg-img{position:fixed;inset:0;z-index:-1;opacity:.8;background:#fff url('/images/dalapa/login-bg.png') center center / cover no-repeat}

  .demo-badge{position:fixed;top:14px;left:50%;transform:translateX(-50%);z-index:50;
    display:inline-flex;align-items:center;background:rgba(28,53,80,.9);padding:6px;border-radius:20px;
    text-decoration:none;overflow:hidden;transition:padding .25s ease}
  .demo-badge:hover{background:var(--navy);padding:6px 14px 6px 6px}
  .demo-badge .mark{width:22px;height:22px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;
    padding:2px;flex-shrink:0;overflow:hidden}
  .demo-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .demo-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11.5px;font-weight:600;
    margin-left:0;transition:max-width .25s ease,opacity .2s ease,margin-left .25s ease}
  .demo-badge:hover .txt{max-width:280px;opacity:1;margin-left:8px}

  .panel{width:100%;max-width:378px;background:var(--panel);border:1px solid var(--border);border-radius:3px;
    box-shadow:0 2px 14px rgba(28,53,80,.1);overflow:hidden}
  .panel::before{content:"";display:block;height:3px;background:var(--red)}
  .panel-body{padding:26px 26px 22px;text-align:center}
  .logo{width:160px;height:160px;object-fit:contain;margin:0 auto 6px;display:block}
  .brand{font-size:20px;font-weight:700;letter-spacing:.08em;color:var(--heading)}
  .brand-sub{font-size:11.5px;color:var(--muted);margin:2px 0 22px}

  form{text-align:left}
  .form-group{margin-bottom:12px}
  .form-control{width:100%;height:40px;border:1px solid var(--border);border-radius:3px;background:#fff;
    padding:0 12px;font-size:13.5px;font-family:inherit;color:var(--heading)}
  .form-control::placeholder{color:#cdd2d4}
  .form-control:focus{outline:none;border-color:var(--navy);box-shadow:0 0 0 3px rgba(28,53,80,.12)}
  select.form-control{cursor:pointer}
  .pw-wrap{position:relative}
  .pw-wrap .form-control{padding-right:40px}
  .pw-eye{position:absolute;top:50%;right:11px;transform:translateY(-50%);background:none;border:none;color:var(--muted);
    display:grid;place-items:center}

  /* stand-in for the reCAPTCHA widget the real page renders */
  .captcha{display:flex;align-items:center;gap:10px;border:1px solid var(--border);border-radius:3px;
    padding:11px 12px;background:#f9f9f9}
  .captcha input{width:22px;height:22px;accent-color:var(--navy);cursor:pointer;flex-shrink:0}
  .captcha .lbl{font-size:12.5px;color:var(--heading);flex:1;cursor:pointer}
  .captcha .brand-mini{font-size:9px;color:var(--muted);text-align:right;line-height:1.3}

  .btn-login{width:100%;height:42px;border:none;border-radius:3px;background:var(--navy);color:#fff;
    font-size:14.5px;font-weight:600;transition:background .15s}
  .btn-login:hover{background:#142639}
  .note{margin-top:12px;font-size:12px;border-radius:3px;padding:9px 11px;line-height:1.5}
  .note.err{color:#a4282f;background:#fbeaea;border:1px solid #f0c8c8}
  .note.info{color:var(--text);background:#f4f6f8;border:1px solid var(--border)}
  .note.info b{color:var(--red)}

  .panel-foot{border-top:1px solid var(--border);padding:13px 26px;display:flex;align-items:center;
    justify-content:space-between;gap:10px;background:#fafbfc}
  .panel-foot .hint{font-size:11.5px;color:var(--muted)}
  .btn-mint{height:28px;padding:0 12px;border:none;border-radius:3px;background:var(--mint);color:#fff;
    font-size:11.5px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center}

  .copyright{position:fixed;bottom:12px;left:0;right:0;text-align:center;color:var(--muted);font-size:11px;padding:0 16px}
</style>
</head>
<body>

<div class="bg-img"></div>

<a class="demo-badge" href="/">
  <span class="mark"><img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" /></span>
  <span class="txt">Demo UI · Portfolio Reza Pratama</span>
</a>

<div class="panel">
  <div class="panel-body">
    <img class="logo" src="/images/dalapa/logo.png" alt="DALAPA" />
    <div class="brand">DALAPA</div>
    <div class="brand-sub">Data Lapangan — Regional VI Kalimantan</div>

    <form id="loginForm">
      <div class="form-group">
        <input type="text" id="username" class="form-control" placeholder="Email / NIK Account" autocomplete="off" autofocus />
      </div>

      <div class="form-group">
        <div class="pw-wrap">
          <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off" />
          <button type="button" class="pw-eye" id="pwEye" aria-label="Tampilkan password">
            <svg id="eyeOpen" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
            <svg id="eyeClosed" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><path d="M1 1l22 22"/></svg>
          </button>
        </div>
      </div>

      <div class="form-group">
        <select id="authType" class="form-control">
          <option value="ACCOUNT">USER ACCOUNT</option>
          <option value="LDAP">LDAP</option>
        </select>
      </div>

      <div class="form-group">
        <div class="captcha">
          <input type="checkbox" id="captcha" />
          <label class="lbl" for="captcha">Saya bukan robot</label>
          <div class="brand-mini">reCAPTCHA<br />Privacy · Terms</div>
        </div>
      </div>

      <button type="submit" class="btn-login">Login</button>
      <p class="note err" id="errNote" hidden></p>
      <p class="note info">Demo: masuk dengan <b>1111</b> / <b>1111</b>.</p>
    </form>
  </div>

  <div class="panel-foot">
    <span class="hint">Belum punya akun?</span>
    <a href="#" class="btn-mint" id="registerBtn">Register Account</a>
  </div>
</div>

<div class="copyright">&copy; 2024 Regional Access Management — Telkom Infrastruktur Indonesia Regional VI Kalimantan</div>

<script>
  var pwInput = document.getElementById('password');
  document.getElementById('pwEye').addEventListener('click', function(){
    var show = pwInput.type === 'password';
    pwInput.type = show ? 'text' : 'password';
    document.getElementById('eyeOpen').style.display = show ? 'none' : '';
    document.getElementById('eyeClosed').style.display = show ? '' : 'none';
  });

  var errNote = document.getElementById('errNote');
  function showErr(msg){ errNote.textContent = msg; errNote.hidden = false; }

  document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();
    if (!document.getElementById('captcha').checked) {
      showErr('Silakan centang verifikasi "Saya bukan robot" terlebih dahulu.');
      return;
    }
    if (document.getElementById('username').value.trim() === '1111' && pwInput.value.trim() === '1111') {
      window.location.href = "{{ route('project.dalapareg.peta-alpro') }}";
      return;
    }
    showErr('Access Denied : Email / NIK atau password salah.');
  });

  document.getElementById('registerBtn').addEventListener('click', function(e){
    e.preventDefault();
    showErr('Ini tampilan demo — pendaftaran akun tidak terhubung ke server sungguhan.');
  });
</script>
</body>
</html>
