<!-- EVIDENCE PHOTO LIGHTBOX (shared) -->
<div class="lightbox-backdrop" id="lightboxBackdrop">
  <button class="lightbox-close" id="lightboxClose">✕</button>
  <div class="lightbox-box">
    <img id="lightboxImg" src="" alt="Evidence" />
    <div class="lightbox-cap" id="lightboxCap"></div>
  </div>
</div>

<script>
  var lightboxBackdrop = document.getElementById('lightboxBackdrop');
  function openLightbox(src, caption){
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxCap').textContent = caption || '';
    lightboxBackdrop.classList.add('show');
  }
  document.getElementById('lightboxClose').addEventListener('click', function(){ lightboxBackdrop.classList.remove('show'); });
  lightboxBackdrop.addEventListener('click', function(e){ if (e.target === lightboxBackdrop) { lightboxBackdrop.classList.remove('show'); } });
</script>
