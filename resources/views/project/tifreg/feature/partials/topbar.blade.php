<header class="topbar">
  <button class="hamburger" id="hamburger" aria-label="Menu">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
  </button>
  <div class="clock-pill">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
    <span id="clockEl">----</span>
  </div>
  <div class="spacer"></div>
  <div class="lang-switch" id="langSwitch">
    <button type="button" data-lang="id">ID</button>
    <button type="button" data-lang="en">EN</button>
  </div>
  <button class="icbtn" id="themeBtn" aria-label="Ganti tema">
    <svg id="themeIconLight" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/></svg>
    <svg id="themeIconDark" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
  </button>
  <div class="user-block">
    <span class="avatar">R</span>
    <span class="user-meta"><div class="name">Reza</div><div class="role">Superadmin</div></span>
  </div>
  <a class="icbtn logout-btn" href="{{ route('project.tifreg.login') }}" data-i18n-title="logout" title="Logout" aria-label="Logout">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
  </a>
</header>

<div class="toast-stack" id="toastStack"></div>
