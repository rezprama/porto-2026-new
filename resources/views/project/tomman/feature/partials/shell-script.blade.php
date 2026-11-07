{{-- Vanilla stand-ins for the jQuery/Bootstrap 3 behaviour the real app loads from psb.tomman.info:
     navbar dropdowns + submenus, the collapse toggle, and the popover every matrix chip carries. --}}
<script>
  /* ---------- navbar dropdowns ---------- */
  document.querySelectorAll('.navbar-nav .dropdown > .dropdown-toggle').forEach(function(a){
    a.addEventListener('click', function(e){
      e.preventDefault();
      var li = a.parentElement, wasOpen = li.classList.contains('open');
      document.querySelectorAll('.navbar-nav .open').forEach(function(o){ o.classList.remove('open'); });
      li.classList.toggle('open', !wasOpen);
    });
  });
  document.addEventListener('click', function(e){
    if (e.target.closest('.navbar-nav')) { return; }
    document.querySelectorAll('.navbar-nav .open').forEach(function(o){ o.classList.remove('open'); });
  });
  document.querySelector('.navbar-toggle').addEventListener('click', function(){
    document.getElementById('menu-main').classList.toggle('in');
  });

  /* ---------- toast ---------- */
  function toast(msg){
    var el = document.createElement('div');
    el.className = 'toast';
    el.textContent = msg;
    document.getElementById('toastStack').appendChild(el);
    requestAnimationFrame(function(){ el.classList.add('show'); });
    setTimeout(function(){ el.classList.remove('show'); setTimeout(function(){ el.remove(); }, 250); }, 2800);
  }
  /* data-demo now only ever sits on in-screen action chips (Re-Dispatch, Hapus, Send SMS …) that the
     real app posts to a controller — the navbar carries no dead entries at all. */
  document.addEventListener('click', function(e){
    var a = e.target.closest('[data-demo]');
    if (!a) { return; }
    e.preventDefault();
    toast('Demo UI — aksi ini tidak terhubung ke server sungguhan.');
  });

  /* ---------- popover: data-content holds HTML, same contract as the real chips ---------- */
  var openPop = null;
  function closePop(){ if (openPop) { openPop.remove(); openPop = null; } }
  document.addEventListener('click', function(e){
    var trigger = e.target.closest('[data-toggle="popover"]');
    closePop();
    if (!trigger) { return; }
    e.preventDefault();
    var pop = document.createElement('div');
    pop.className = 'popover';
    pop.innerHTML = '<div class="popover-content">' + trigger.getAttribute('data-content') + '</div>';
    document.body.appendChild(pop);
    var r = trigger.getBoundingClientRect();
    var top = r.bottom + window.scrollY + 6;
    var left = Math.min(r.left + window.scrollX, window.innerWidth - pop.offsetWidth - 12);
    pop.style.top = top + 'px';
    pop.style.left = Math.max(8, left) + 'px';
    openPop = pop;
  });
  window.addEventListener('resize', closePop);

  /* ---------- modal: [data-modal="#id"] opens, [data-dismiss] closes ---------- */
  /* pages without a modal never call this, but the backdrop lookup still has to tolerate its absence */
  function backdrop(){ return document.getElementById('modalBackdrop'); }
  function openModal(sel){
    var m = document.querySelector(sel), b = backdrop();
    if (!m) { return; }
    m.hidden = false;
    if (b) { b.hidden = false; }
  }
  function closeModal(){
    document.querySelectorAll('.modal').forEach(function(m){ m.hidden = true; });
    var b = backdrop();
    if (b) { b.hidden = true; }
  }
  document.addEventListener('click', function(e){
    var open = e.target.closest('[data-modal]');
    if (open) { e.preventDefault(); openModal(open.getAttribute('data-modal')); return; }
    if (e.target.closest('[data-dismiss]') || e.target.id === 'modalBackdrop') { closeModal(); }
  });

  /* ---------- helpers shared by the screens ---------- */
  function esc(s){ return String(s === null || s === undefined ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;'); }
  function pct(n){ return (Math.round(n * 100) / 100).toFixed(2) + '%'; }
</script>
