<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5x</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
<style>
  /* The real login.blade.php is deliberately bare: Bootswatch Paper + three inline rules.
     Everything here is that stylesheet's own values — Roboto 13px/1.846, text #666,
     primary #2196f3, material underline inputs, 3px radii. Light mode only, Indonesian only. */
  *{box-sizing:border-box}
  html,body{margin:0;padding:0}
  body{font-family:"Roboto","Helvetica Neue",Helvetica,Arial,sans-serif;font-size:13px;line-height:1.846;
    color:#666;background:#fff;-webkit-font-smoothing:antialiased}
  .container{max-width:1170px;margin:0 auto;padding:0 15px}
  h5{font-family:inherit;font-weight:400;line-height:1.1;color:#444;font-size:13px;margin:0}

  form{margin:40px 0}
  @media (min-width:769px){ form{width:400px;margin:100px auto} }

  .form-group{margin-bottom:15px}
  label.control-label{display:inline-block;margin-bottom:5px;font-weight:700;color:#666}
  .form-control{display:block;width:100%;height:37px;padding:0;font-size:16px;line-height:1.846;color:#666;
    background:transparent;border:0;border-radius:0;appearance:none;box-shadow:inset 0 -1px 0 #ddd;font-family:inherit;
    transition:box-shadow .15s}
  .form-control:focus{outline:0;box-shadow:inset 0 -2px 0 #2196f3}
  /* the two inline rules the real page adds on top of Paper */
  .form-control.new{border:1px solid #b7b7b7;padding:0 8px}
  .form-control.new:focus{border-color:#2196f3}

  .btn{display:inline-block;padding:6px 16px;font-size:13px;line-height:1.846;border:1px solid transparent;
    border-radius:3px;cursor:pointer;font-family:inherit;color:#fff;background:#2196f3;transition:background .15s}
  .btn:hover{background:#0c7cd5}

  .alert{padding:15px;margin-bottom:23px;border:1px solid transparent;border-radius:3px;font-size:13px}
  .alert-danger{background:#f9bdbb;border-color:#f7a4af;color:#e51c23}
  .alert-info{background:#b3e5fc;border-color:#81d4fa;color:#0c7cd5}
  .alert-info b{color:#e51c23}

  .brand{font-size:26px;font-weight:700;letter-spacing:.04em;color:#666;margin-bottom:2px}
  .brand .redxxx{color:#e74c3c}

  .demo-badge{position:fixed;top:14px;left:50%;transform:translateX(-50%);z-index:50;display:inline-flex;
    align-items:center;background:rgba(64,64,64,.92);padding:6px;border-radius:20px;text-decoration:none;
    overflow:hidden;transition:padding .25s}
  .demo-badge:hover{background:#404040;padding:6px 14px 6px 6px}
  .demo-badge .mark{width:22px;height:22px;border-radius:50%;background:#fff;display:flex;align-items:center;
    justify-content:center;padding:2px;flex-shrink:0;overflow:hidden}
  .demo-badge .mark img{width:100%;height:100%;object-fit:contain;display:block}
  .demo-badge .txt{max-width:0;opacity:0;white-space:nowrap;overflow:hidden;color:#fff;font-size:11.5px;
    font-weight:600;margin-left:0;transition:max-width .25s,opacity .2s,margin-left .25s}
  .demo-badge:hover .txt{max-width:280px;opacity:1;margin-left:8px}
</style>
</head>
<body>

<a class="demo-badge" href="/">
  <span class="mark"><img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" /></span>
  <span class="txt">Demo UI · Portfolio Reza Pratama</span>
</a>

<div class="container" style="margin-top:40px">
  <form id="loginForm" autocomplete="off">
    <div class="alert alert-danger" id="errNote" hidden></div>

    <div class="form-group">
      <div class="brand"><span class="redxxx">TOM</span>MAN</div>
      <h5>Tomman Operation v1.5</h5>
    </div>

    <div class="form-group">
      <label class="control-label" for="input-login">Login</label>
      <input name="login" type="text" id="input-login" class="form-control new" autofocus />
    </div>

    <div class="form-group">
      <label class="control-label" for="input-password">Password</label>
      <input name="password" type="password" id="input-password" class="form-control" />
    </div>

    <div>
      <button type="submit" class="btn">Login</button>
    </div>

    <div class="alert alert-info" style="margin-top:20px">Demo: masuk dengan <b>1111</b> / <b>1111</b>.</div>
  </form>
</div>

<script>
  var errNote = document.getElementById('errNote');
  document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();
    var u = document.getElementById('input-login').value.trim();
    var p = document.getElementById('input-password').value.trim();
    if (u === '1111' && p === '1111') {
      window.location.href = "{{ route('project.tomman.matrix') }}";
      return;
    }
    errNote.textContent = 'Login atau password salah.';
    errNote.hidden = false;
  });

  /* ---------- Interactive Tour Guide ---------- */
  var tommanLoginTour = {
    id: 'tomman-login',
    steps: [
      {
        target: '.brand',
        pos: 'top',
        title: 'Aplikasi TOMMAN Operation',
        desc: 'TOMMAN (Total Operation & Maintenance Management) adalah platform dispatching tiket, monitoring kinerja teknisi lapangan, dan rekap assurance jaringan.'
      },
      {
        target: '#input-login',
        pos: 'top',
        title: 'Input Username / NIK',
        desc: 'Masukkan username atau NIK akun operasional Anda. Untuk mencoba simulasi sistem demo, gunakan akun <b>1111</b>.'
      },
      {
        target: '#input-password',
        pos: 'bottom',
        title: 'Kata Sandi Akun',
        desc: 'Masukkan password akun dinas Anda (akun demo: <b>1111</b>).'
      },
      {
        target: 'button[type="submit"]',
        pos: 'bottom',
        title: 'Tombol Masuk Sistem',
        desc: 'Klik tombol <b>Login</b> untuk masuk langsung ke dashboard matriks operasional TOMMAN.'
      }
    ]
  };

  setTimeout(function(){
    TommanTour.start(tommanLoginTour);
  }, 450);
</script>

@include('project.tomman.feature.partials.tour-guide')
</body>
</html>
