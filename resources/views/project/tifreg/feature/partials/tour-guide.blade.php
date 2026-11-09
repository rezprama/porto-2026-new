<!-- Reusable Tour Guide & Hint Component for DALAPA TIFREG -->
<style>
  /* ---------- Tour Guide Scoped Styles ---------- */
  .tg-spotlight {
    position: fixed;
    z-index: 9997;
    border-radius: 8px;
    box-shadow: 0 0 0 9999px rgba(10, 16, 26, 0.68), 0 0 0 2px var(--brand-500, #465fff), 0 0 24px rgba(70, 95, 255, 0.65);
    pointer-events: none;
    transition: all 0.28s cubic-bezier(0.2, 0.8, 0.2, 1);
    opacity: 0;
  }
  .tg-spotlight.active {
    opacity: 1;
  }

  .tg-target-highlight {
    outline: 2px solid var(--brand-500, #465fff) !important;
    outline-offset: 3px !important;
    position: relative;
    z-index: 9998 !important;
  }

  .tg-card {
    position: fixed;
    z-index: 9999;
    width: calc(100vw - 32px);
    max-width: 360px;
    background: var(--panel-bg, #ffffff);
    color: var(--text, #1d2939);
    border: 1px solid var(--border, #d0d5dd);
    border-radius: 14px;
    box-shadow: 0 20px 40px -10px rgba(16, 24, 40, 0.3), 0 0 0 1px rgba(0,0,0,0.06);
    padding: 18px 20px 16px;
    font-family: inherit;
    display: none;
    flex-direction: column;
    gap: 12px;
    animation: tgPopIn 0.22s cubic-bezier(0.2, 0.8, 0.2, 1);
  }
  .tg-card.show {
    display: flex;
  }

  @keyframes tgPopIn {
    from { opacity: 0; transform: scale(0.94) translateY(6px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
  }

  /* Header */
  .tg-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }
  .tg-badge-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .tg-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 20px;
    background: color-mix(in srgb, var(--brand-500, #465fff) 12%, transparent);
    color: var(--brand-600, #3641f5);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.02em;
    text-transform: uppercase;
  }
  [data-theme="dark"] .tg-pill {
    color: #a7b6ff;
    background: rgba(70, 95, 255, 0.2);
  }
  .tg-counter {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--muted, #98a2b3);
    font-family: ui-monospace, monospace;
  }
  .tg-close-btn {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    border: 1px solid var(--border, #d0d5dd);
    background: var(--bg, #f9fafb);
    color: var(--muted, #98a2b3);
    display: grid;
    place-items: center;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .tg-close-btn:hover {
    color: var(--text, #101828);
    border-color: var(--brand-500, #465fff);
  }

  /* Content */
  .tg-body {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .tg-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text, #101828);
    line-height: 1.35;
  }
  .tg-desc {
    font-size: 13px;
    color: var(--label, #344054);
    line-height: 1.55;
  }
  .tg-desc b, .tg-desc strong {
    color: var(--text, #101828);
    font-weight: 600;
  }

  /* Footer & Action Buttons */
  .tg-footer {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding-top: 10px;
    border-top: 1px solid var(--border, #e4e7ec);
    margin-top: 2px;
  }
  .tg-opt-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
  }
  .tg-chk-label {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 12px;
    color: var(--muted, #667085);
    cursor: pointer;
    user-select: none;
  }
  .tg-chk-label input {
    width: 14px;
    height: 14px;
    accent-color: var(--brand-500, #465fff);
    cursor: pointer;
  }
  .tg-nav-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
  }
  .tg-btn {
    height: 32px;
    padding: 0 13px;
    border-radius: 7px;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  .tg-btn.ghost {
    background: transparent;
    color: var(--muted, #667085);
    border: 1px solid transparent;
  }
  .tg-btn.ghost:hover {
    color: var(--text, #101828);
    background: var(--bg, #f9fafb);
  }
  .tg-btn.outline {
    background: var(--panel-bg, #fff);
    color: var(--label, #344054);
    border: 1px solid var(--border, #d0d5dd);
  }
  .tg-btn.outline:hover {
    border-color: var(--brand-500, #465fff);
    color: var(--brand-600, #3641f5);
  }
  .tg-btn.primary {
    background: var(--brand-500, #465fff);
    color: #ffffff;
  }
  .tg-btn.primary:hover {
    background: var(--brand-600, #3641f5);
    filter: brightness(1.05);
  }

  /* Floating Help / Re-open Button */
  .tg-help-trigger {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 14px;
    border-radius: 20px;
    background: var(--panel-bg, #ffffff);
    color: var(--text, #1d2939);
    border: 1px solid var(--border, #d0d5dd);
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16, 24, 40, 0.14);
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .tg-help-trigger:hover {
    border-color: var(--brand-500, #465fff);
    color: var(--brand-600, #3641f5);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(70, 95, 255, 0.2);
  }
  .tg-help-trigger .tg-help-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--brand-500, #465fff);
    box-shadow: 0 0 6px var(--brand-500, #465fff);
    animation: tgPulse 2s infinite;
  }
  @keyframes tgPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.85); }
  }

  @media (max-width: 640px) {
    .tg-card {
      width: calc(100vw - 24px);
      left: 12px !important;
      right: 12px !important;
      max-width: none;
    }
  }
</style>

<div id="tgSpotlight" class="tg-spotlight" aria-hidden="true"></div>

<div id="tgCard" class="tg-card" role="dialog" aria-modal="true">
  <div class="tg-head">
    <div class="tg-badge-wrap">
      <span class="tg-pill" id="tgBadge">💡 Hint</span>
      <span class="tg-counter" id="tgCounter">1 / 5</span>
    </div>
    <button type="button" class="tg-close-btn" id="tgCloseBtn" aria-label="Tutup panduan">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
  </div>

  <div class="tg-body">
    <div class="tg-title" id="tgTitle">Judul Hint</div>
    <div class="tg-desc" id="tgDesc">Deskripsi petunjuk penggunaan.</div>
  </div>

  <div class="tg-footer">
    <div class="tg-opt-row">
      <label class="tg-chk-label" for="tgDontShow">
        <input type="checkbox" id="tgDontShow" />
        <span id="tgDontShowLabel">Jangan tampilkan lagi</span>
      </label>
      <button type="button" class="tg-btn ghost" id="tgSkipBtn">Lewati</button>
    </div>
    <div class="tg-nav-row">
      <button type="button" class="tg-btn outline" id="tgPrevBtn" style="display:none">Sebelumnya</button>
      <button type="button" class="tg-btn primary" id="tgNextBtn">Lanjut</button>
    </div>
  </div>
</div>

<button type="button" class="tg-help-trigger" id="tgHelpTrigger" title="Buka Panduan Penggunaan">
  <span class="tg-help-dot"></span>
  <span>💡</span>
  <span id="tgHelpTriggerTxt">Panduan</span>
</button>

<script>
window.TourGuide = (function(){
  var currentTour = null;
  var currentStep = 0;
  var spotlight = document.getElementById('tgSpotlight');
  var card = document.getElementById('tgCard');
  var badge = document.getElementById('tgBadge');
  var counter = document.getElementById('tgCounter');
  var title = document.getElementById('tgTitle');
  var desc = document.getElementById('tgDesc');
  var dontShow = document.getElementById('tgDontShow');
  var dontShowLabel = document.getElementById('tgDontShowLabel');
  var skipBtn = document.getElementById('tgSkipBtn');
  var prevBtn = document.getElementById('tgPrevBtn');
  var nextBtn = document.getElementById('tgNextBtn');
  var closeBtn = document.getElementById('tgCloseBtn');
  var helpTrigger = document.getElementById('tgHelpTrigger');
  var helpTriggerTxt = document.getElementById('tgHelpTriggerTxt');

  var activeTargets = [];

  function clearActiveTargets() {
    while (activeTargets.length > 0) {
      var item = activeTargets.pop();
      if (item && item.el) {
        item.el.style.zIndex = item.prevZ || '';
        item.el.classList.remove('tg-target-highlight');
      }
    }
  }

  function elevateTarget(el) {
    if (!el) return;
    activeTargets.push({ el: el, prevZ: el.style.zIndex });
    el.style.zIndex = '9998';
    el.classList.add('tg-target-highlight');

    // If inside fixed sidebar, also elevate the sidebar container
    var sidebar = el.closest('.sidebar');
    if (sidebar && sidebar !== el) {
      activeTargets.push({ el: sidebar, prevZ: sidebar.style.zIndex });
      sidebar.style.zIndex = '9998';
    }
    // If inside topbar, also elevate topbar container
    var topbar = el.closest('.topbar');
    if (topbar && topbar !== el) {
      activeTargets.push({ el: topbar, prevZ: topbar.style.zIndex });
      topbar.style.zIndex = '9998';
    }
  }

  function getLang() {
    try {
      return localStorage.getItem('dalapa-lang') || 'id';
    } catch(e) {
      return 'id';
    }
  }

  function getText(val) {
    if (!val) return '';
    if (typeof val === 'string') return val;
    var l = getLang();
    return val[l] || val.id || val.en || '';
  }

  function updateStaticTexts() {
    var l = getLang();
    var isId = l === 'id';
    if (badge) badge.textContent = isId ? '💡 Panduan' : '💡 Guide';
    if (dontShowLabel) dontShowLabel.textContent = isId ? 'Jangan tampilkan lagi' : 'Do not show again';
    if (skipBtn) skipBtn.textContent = isId ? 'Lewati' : 'Skip';
    if (prevBtn) prevBtn.textContent = isId ? 'Sebelumnya' : 'Back';
    if (helpTriggerTxt) helpTriggerTxt.textContent = isId ? 'Panduan' : 'Guide';
  }

  function positionCard(targetRect, preferredPos) {
    if (!card) return;
    var cardW = card.offsetWidth || 340;
    var cardH = card.offsetHeight || 180;
    var pad = 14;
    var viewW = window.innerWidth;
    var viewH = window.innerHeight;

    var top, left;

    if (!targetRect) {
      // Center in screen
      top = Math.max(pad, (viewH - cardH) / 2);
      left = Math.max(pad, (viewW - cardW) / 2);
      card.style.top = top + 'px';
      card.style.left = left + 'px';
      return;
    }

    var pos = preferredPos || 'bottom';

    if (pos === 'bottom') {
      top = targetRect.bottom + pad;
      if (top + cardH > viewH - pad) {
        top = Math.max(pad, targetRect.top - cardH - pad);
      }
      left = targetRect.left + (targetRect.width / 2) - (cardW / 2);
    } else if (pos === 'top') {
      top = targetRect.top - cardH - pad;
      if (top < pad) {
        top = targetRect.bottom + pad;
      }
      left = targetRect.left + (targetRect.width / 2) - (cardW / 2);
    } else if (pos === 'left') {
      left = targetRect.left - cardW - pad;
      if (left < pad) {
        left = targetRect.right + pad;
      }
      top = targetRect.top + (targetRect.height / 2) - (cardH / 2);
    } else if (pos === 'right') {
      left = targetRect.right + pad;
      if (left + cardW > viewW - pad) {
        left = targetRect.left - cardW - pad;
      }
      top = targetRect.top + (targetRect.height / 2) - (cardH / 2);
    }

    // Boundary clamp
    left = Math.max(pad, Math.min(viewW - cardW - pad, left));
    top = Math.max(pad, Math.min(viewH - cardH - pad, top));

    card.style.top = top + 'px';
    card.style.left = left + 'px';
  }

  function renderStep(idx) {
    if (!currentTour || !currentTour.steps || idx < 0 || idx >= currentTour.steps.length) {
      endTour();
      return;
    }
    currentStep = idx;
    var step = currentTour.steps[idx];
    updateStaticTexts();
    clearActiveTargets();

    var targetEl = null;
    if (step.target) {
      targetEl = typeof step.target === 'string' ? document.querySelector(step.target) : step.target;
    }

    var isId = getLang() === 'id';
    var total = currentTour.steps.length;
    counter.textContent = (idx + 1) + ' / ' + total;
    title.innerHTML = getText(step.title);
    desc.innerHTML = getText(step.desc);

    prevBtn.style.display = idx > 0 ? 'inline-flex' : 'none';
    nextBtn.textContent = idx === total - 1 ? (isId ? 'Selesai' : 'Got it') : (isId ? 'Lanjut' : 'Next');

    card.classList.add('show');

    if (targetEl) {
      elevateTarget(targetEl);
      targetEl.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
      setTimeout(function(){
        var rect = targetEl.getBoundingClientRect();
        spotlight.style.top = (rect.top - 5) + 'px';
        spotlight.style.left = (rect.left - 5) + 'px';
        spotlight.style.width = (rect.width + 10) + 'px';
        spotlight.style.height = (rect.height + 10) + 'px';
        spotlight.classList.add('active');
        positionCard(rect, step.pos);
      }, 100);
    } else {
      spotlight.classList.remove('active');
      positionCard(null, 'center');
    }
  }

  function startTour(tourConfig, force) {
    if (!tourConfig || !tourConfig.id || !tourConfig.steps || tourConfig.steps.length === 0) return;
    currentTour = tourConfig;

    var storageKey = 'tour-dismissed-' + tourConfig.id;
    try {
      if (!force && localStorage.getItem(storageKey) === 'true') {
        return; // Suppressed by user
      }
    } catch(e) {}

    dontShow.checked = false;
    renderStep(0);
  }

  function endTour() {
    clearActiveTargets();
    if (spotlight) spotlight.classList.remove('active');
    if (card) card.classList.remove('show');

    if (currentTour && dontShow && dontShow.checked) {
      try {
        localStorage.setItem('tour-dismissed-' + currentTour.id, 'true');
      } catch(e) {}
    }
    currentStep = 0;
  }

  function nextStep() {
    if (!currentTour) return;
    if (currentStep < currentTour.steps.length - 1) {
      renderStep(currentStep + 1);
    } else {
      endTour();
    }
  }

  function prevStep() {
    if (!currentTour) return;
    if (currentStep > 0) {
      renderStep(currentStep - 1);
    }
  }

  // Bind Event Listeners
  if (nextBtn) nextBtn.addEventListener('click', nextStep);
  if (prevBtn) prevBtn.addEventListener('click', prevStep);
  if (skipBtn) skipBtn.addEventListener('click', endTour);
  if (closeBtn) closeBtn.addEventListener('click', endTour);
  if (helpTrigger) {
    helpTrigger.addEventListener('click', function(){
      if (currentTour) startTour(currentTour, true);
    });
  }

  // Handle window resize
  window.addEventListener('resize', function(){
    if (card && card.classList.contains('show') && currentTour) {
      renderStep(currentStep);
    }
  });

  // Handle keyboard
  window.addEventListener('keydown', function(e){
    if (!card || !card.classList.contains('show')) return;
    if (e.key === 'Escape') {
      endTour();
    } else if (e.key === 'ArrowRight' || e.key === 'Enter') {
      nextStep();
    } else if (e.key === 'ArrowLeft') {
      prevStep();
    }
  });

  return {
    start: startTour,
    end: endTour,
    render: renderStep,
    updateTexts: updateStaticTexts
  };
})();
</script>
