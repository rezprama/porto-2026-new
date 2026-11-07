<header class="topbar">
  <button class="hamburger" id="hamburger" aria-label="Menu">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
  </button>
  <div class="clock-pill">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
    <span id="clockEl">----</span>
  </div>
  <div class="spacer"></div>
  <div class="user-block">
    <span class="avatar">R</span>
    <span class="user-meta"><div class="name">Reza Pratama</div><div class="role">Regional Access Management</div></span>
  </div>
  <a class="icbtn logout-btn" href="{{ route('project.dalapareg.login') }}" title="Keluar" aria-label="Keluar">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5M21 12H9"/></svg>
  </a>
</header>

<div class="toast-stack" id="toastStack"></div>
