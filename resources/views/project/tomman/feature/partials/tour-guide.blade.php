<!-- Reusable Tour Guide & Hint Component for TOMMAN Operation (Bootswatch Paper, Light Mode & Indonesian Only) -->
<style>
  /* ---------- TOMMAN Tour Guide Scoped Styles ---------- */
  .tg-spotlight {
    position: fixed;
    z-index: 9997;
    border-radius: 3px;
    box-shadow: 0 0 0 9999px rgba(33, 33, 33, 0.65), 0 0 0 2px #2196f3, 0 0 20px rgba(33, 150, 243, 0.6);
    pointer-events: none;
    transition: all 0.28s cubic-bezier(0.2, 0.8, 0.2, 1);
    opacity: 0;
  }
  .tg-spotlight.active {
    opacity: 1;
  }

  .tg-target-highlight {
    outline: 2px solid #2196f3 !important;
    outline-offset: 3px !important;
    position: relative;
    z-index: 9998 !important;
  }

  .tg-card {
    position: fixed;
    z-index: 9999;
    width: calc(100vw - 32px);
    max-width: 360px;
    background: #ffffff;
    color: #666666;
    border: 1px solid #dddddd;
    border-top: 3px solid #2196f3;
    border-radius: 3px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0,0,0,0.08);
    padding: 16px 18px 14px;
    font-family: "Roboto", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 13px;
    line-height: 1.6;
    display: none;
    flex-direction: column;
    gap: 11px;
    animation: tgPopIn 0.22s cubic-bezier(0.2, 0.8, 0.2, 1);
  }
  .tg-card.show {
    display: flex;
  }

  @keyframes tgPopIn {
    from { opacity: 0; transform: scale(0.95) translateY(5px); }
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
    padding: 2px 8px;
    border-radius: 3px;
    background: #e3f2fd;
    color: #1976d2;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    border: 1px solid #bbdefb;
  }
  .tg-counter {
    font-size: 11px;
    font-weight: 600;
    color: #9e9e9e;
    font-family: monospace;
  }
  .tg-close-btn {
    width: 24px;
    height: 24px;
    border-radius: 3px;
    border: 1px solid #dddddd;
    background: #fafafa;
    color: #757575;
    display: grid;
    place-items: center;
    cursor: pointer;
    font-size: 12px;
    line-height: 1;
    transition: all 0.15s ease;
  }
  .tg-close-btn:hover {
    color: #e51c23;
    border-color: #e51c23;
    background: #ffebee;
  }

  /* Content */
  .tg-content {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .tg-title {
    font-size: 14px;
    font-weight: 700;
    color: #212121;
    line-height: 1.35;
    margin: 0;
  }
  .tg-desc {
    font-size: 12.5px;
    color: #616161;
    line-height: 1.55;
    margin: 0;
  }
  .tg-desc b, .tg-desc strong {
    color: #212121;
  }
  .tg-desc code {
    font-family: monospace;
    font-size: 11px;
    background: #f5f5f5;
    padding: 1px 4px;
    border-radius: 3px;
    border: 1px solid #e0e0e0;
    color: #e51c23;
  }

  /* Don't show again checkbox */
  .tg-dont-show {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 11.5px;
    color: #757575;
    cursor: pointer;
    user-select: none;
    padding: 4px 0 0;
    border-top: 1px dashed #e0e0e0;
  }
  .tg-dont-show input[type="checkbox"] {
    width: 14px;
    height: 14px;
    cursor: pointer;
    accent-color: #2196f3;
  }

  /* Action buttons footer */
  .tg-foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-top: 2px;
  }
  .tg-skip-btn {
    background: none;
    border: none;
    padding: 4px 8px;
    font-size: 12px;
    color: #9e9e9e;
    cursor: pointer;
    border-radius: 3px;
    transition: color 0.15s ease;
  }
  .tg-skip-btn:hover {
    color: #e51c23;
    text-decoration: underline;
  }
  .tg-nav-btns {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .tg-prev-btn {
    height: 28px;
    padding: 0 11px;
    border-radius: 3px;
    border: 1px solid #dddddd;
    background: #fafafa;
    color: #616161;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
  }
  .tg-prev-btn:hover {
    border-color: #2196f3;
    background: #f5f5f5;
    color: #2196f3;
  }
  .tg-next-btn {
    height: 28px;
    padding: 0 13px;
    border-radius: 3px;
    border: none;
    background: #2196f3;
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(0,0,0,0.18);
    transition: background 0.15s ease;
  }
  .tg-next-btn:hover {
    background: #0c7cd5;
  }

  /* Floating persistent help trigger button */
  .tg-help-trigger {
    position: fixed;
    bottom: 66px;
    right: 20px;
    z-index: 9990;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 34px;
    padding: 0 13px;
    border-radius: 20px;
    background: #2196f3;
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 3px 12px rgba(33, 150, 243, 0.4);
    font-family: "Roboto", sans-serif;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
  }
  .tg-help-trigger:hover {
    background: #0c7cd5;
    box-shadow: 0 5px 16px rgba(12, 124, 213, 0.5);
    transform: translateY(-2px);
  }
  .tg-help-trigger .tg-trigger-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #4caf50;
    box-shadow: 0 0 6px #4caf50;
  }
</style>

<!-- DOM Cutout Spotlight Mask -->
<div class="tg-spotlight" id="tgSpotlight"></div>

<!-- Card Tooltip -->
<div class="tg-card" id="tgCard" role="dialog" aria-modal="true">
  <div class="tg-head">
    <div class="tg-badge-wrap">
      <span class="tg-pill" id="tgBadge">💡 Panduan</span>
      <span class="tg-counter" id="tgCounter">1 / 5</span>
    </div>
    <button class="tg-close-btn" id="tgCloseBtn" aria-label="Tutup panduan">✕</button>
  </div>
  <div class="tg-content">
    <h4 class="tg-title" id="tgTitle">Judul Panduan</h4>
    <p class="tg-desc" id="tgDesc">Deskripsi penggunaan fitur di halaman ini.</p>
  </div>
  <label class="tg-dont-show">
    <input type="checkbox" id="tgDontShowCheckbox" />
    <span id="tgDontShowLabel">Jangan tampilkan lagi</span>
  </label>
  <div class="tg-foot">
    <button class="tg-skip-btn" id="tgSkipBtn">Lewati</button>
    <div class="tg-nav-btns">
      <button class="tg-prev-btn" id="tgPrevBtn">Sebelumnya</button>
      <button class="tg-next-btn" id="tgNextBtn">Lanjut</button>
    </div>
  </div>
</div>

<!-- Floating Help Trigger -->
<button class="tg-help-trigger" id="tgHelpTrigger" title="Buka panduan fitur">
  <span class="tg-trigger-dot"></span>
  <span id="tgHelpTriggerTxt">Panduan</span>
</button>

<script>
window.TommanTour = (function(){
  var currentTour = null;
  var currentStep = 0;
  var activeTargets = [];

  var spotlight = document.getElementById('tgSpotlight');
  var card = document.getElementById('tgCard');
  var counter = document.getElementById('tgCounter');
  var title = document.getElementById('tgTitle');
  var desc = document.getElementById('tgDesc');
  var dontShow = document.getElementById('tgDontShowCheckbox');
  var closeBtn = document.getElementById('tgCloseBtn');
  var skipBtn = document.getElementById('tgSkipBtn');
  var prevBtn = document.getElementById('tgPrevBtn');
  var nextBtn = document.getElementById('tgNextBtn');
  var helpTrigger = document.getElementById('tgHelpTrigger');

  function isDismissed(tourId) {
    try {
      return localStorage.getItem('tomman-tour-dismissed-' + tourId) === 'true';
    } catch(e) { return false; }
  }

  function setDismissed(tourId, val) {
    try {
      if (val) {
        localStorage.setItem('tomman-tour-dismissed-' + tourId, 'true');
      } else {
        localStorage.removeItem('tomman-tour-dismissed-' + tourId);
      }
    } catch(e) {}
  }

  function getText(val) {
    if (!val) return '';
    if (typeof val === 'string') return val;
    return val.id || val.en || '';
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
    clearActiveTargets();

    var targetEl = null;
    if (step.target) {
      targetEl = typeof step.target === 'string' ? document.querySelector(step.target) : step.target;
    }

    var total = currentTour.steps.length;
    counter.textContent = (idx + 1) + ' / ' + total;
    title.innerHTML = getText(step.title);
    desc.innerHTML = getText(step.desc);

    prevBtn.style.display = idx > 0 ? 'inline-block' : 'none';
    nextBtn.textContent = idx === total - 1 ? 'Selesai' : 'Lanjut';

    card.classList.add('show');

    if (targetEl) {
      elevateTarget(targetEl);
      targetEl.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'nearest' });
      setTimeout(function(){
        var rect = targetEl.getBoundingClientRect();
        spotlight.style.top = (rect.top - 4) + 'px';
        spotlight.style.left = (rect.left - 4) + 'px';
        spotlight.style.width = (rect.width + 8) + 'px';
        spotlight.style.height = (rect.height + 8) + 'px';
        spotlight.classList.add('active');
        positionCard(rect, step.pos || 'bottom');
      }, 100);
    } else {
      spotlight.classList.remove('active');
      positionCard(null, 'center');
    }
  }

  function elevateTarget(el) {
    el.classList.add('tg-target-highlight');
    activeTargets.push(el);

    var parent = el.parentElement;
    while (parent && parent !== document.body) {
      var pos = window.getComputedStyle(parent).position;
      if (pos === 'fixed' || pos === 'sticky' || pos === 'absolute') {
        parent.style.zIndex = '9998';
        activeTargets.push(parent);
      }
      parent = parent.parentElement;
    }
  }

  function clearActiveTargets() {
    activeTargets.forEach(function(el){
      if (el) {
        el.classList.remove('tg-target-highlight');
        if (el.style && el.style.zIndex === '9998') {
          el.style.zIndex = '';
        }
      }
    });
    activeTargets = [];
  }

  function startTour(tourConfig, force) {
    if (!tourConfig || !tourConfig.steps || !tourConfig.steps.length) return;
    currentTour = tourConfig;

    if (!force && isDismissed(tourConfig.id)) {
      if (helpTrigger) helpTrigger.style.display = 'inline-flex';
      return;
    }

    if (dontShow) {
      dontShow.checked = isDismissed(tourConfig.id);
    }

    if (helpTrigger) helpTrigger.style.display = 'inline-flex';
    renderStep(0);
  }

  function endTour() {
    if (currentTour && dontShow && dontShow.checked) {
      setDismissed(currentTour.id, true);
    }
    clearActiveTargets();
    if (spotlight) spotlight.classList.remove('active');
    if (card) card.classList.remove('show');
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

  // Attach event handlers
  if (closeBtn) closeBtn.addEventListener('click', endTour);
  if (skipBtn) skipBtn.addEventListener('click', endTour);
  if (nextBtn) nextBtn.addEventListener('click', nextStep);
  if (prevBtn) prevBtn.addEventListener('click', prevStep);

  if (dontShow) {
    dontShow.addEventListener('change', function(){
      if (currentTour) {
        setDismissed(currentTour.id, this.checked);
      }
    });
  }

  if (helpTrigger) {
    helpTrigger.addEventListener('click', function(){
      if (currentTour) {
        startTour(currentTour, true);
      }
    });
  }

  // Keyboard navigation
  window.addEventListener('keydown', function(e){
    if (!card || !card.classList.contains('show')) return;
    if (e.key === 'ArrowRight' || e.key === 'Enter') {
      nextStep();
    } else if (e.key === 'ArrowLeft') {
      prevStep();
    } else if (e.key === 'Escape') {
      endTour();
    }
  });

  window.addEventListener('resize', function(){
    if (!card || !card.classList.contains('show') || !currentTour) return;
    var step = currentTour.steps[currentStep];
    if (step && step.target) {
      var targetEl = typeof step.target === 'string' ? document.querySelector(step.target) : step.target;
      if (targetEl) {
        var rect = targetEl.getBoundingClientRect();
        spotlight.style.top = (rect.top - 4) + 'px';
        spotlight.style.left = (rect.left - 4) + 'px';
        spotlight.style.width = (rect.width + 8) + 'px';
        spotlight.style.height = (rect.height + 8) + 'px';
        positionCard(rect, step.pos || 'bottom');
      }
    }
  });

  return {
    start: startTour,
    end: endTour,
    next: nextStep,
    prev: prevStep,
    render: renderStep
  };
})();
</script>

