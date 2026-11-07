<!-- DETAIL WORKORDER MODAL (shared by GCU OLT Monitoring + Approval) -->
<div class="modal-backdrop" id="wodModal">
  <div class="modal-card modal-lg">
    <div class="modal-head">
      <div>
        <h3 data-i18n="wodTitle">Detail Workorder</h3>
        <div class="hint-muted" id="wodSubtitle" style="margin-top:2px"></div>
      </div>
      <button class="modal-close" id="wodClose">✕</button>
    </div>
    <div class="modal-body">
      <div class="wod-section">
        <b data-i18n="wodPrimary">Informasi Utama</b>
        <div class="kv-grid" id="wodPrimaryGrid"></div>
      </div>
      <div class="wod-cols">
        <div class="wod-section" style="flex:2">
          <b data-i18n="wodMeasure">Informasi Pengukuran</b>
          <div class="kv-grid" id="wodMeasureGrid"></div>
        </div>
        <div class="wod-section" style="flex:1">
          <b data-i18n="wodAdditional">Informasi Tambahan</b>
          <div class="kv-grid kv-grid-1" id="wodAdditionalGrid"></div>
        </div>
      </div>
      <div class="wod-section">
        <b data-i18n="wodPln">Informasi PLN</b>
        <div class="kv-grid" id="wodPlnGrid"></div>
      </div>
      <div class="wod-section">
        <b data-i18n="wodEvidence">Evidence</b>
        <div class="evidence-row" id="wodEvidenceRow"></div>
      </div>
    </div>
    <div class="modal-foot">
      <button class="btn-outline" id="wodDone" data-i18n="close">Tutup</button>
    </div>
  </div>
</div>

<script>
  var wodModal = document.getElementById('wodModal');
  function woStatusLabel(code){
    return { N: t('stWaiting'), PTK: t('stPending'), P: t('stRework'), KS: t('stKonfirm'), C: t('stComplete'), EXPIRED: t('stExpired') }[code] || code;
  }
  function openWorkorderDetail(d){
    document.getElementById('wodSubtitle').textContent = d.hostname;
    document.getElementById('wodPrimaryGrid').innerHTML = kvHtml([
      [t('wodHostname'), d.hostname], [t('wodIpHostname'), d.ip], [t('wodStatusWo'), woStatusLabel(d.status)],
      [t('wodTicket'), d.ticket], [t('wodTglListing'), d.tglListing], [t('wodTglComplete'), d.tglComplete],
      [t('wodTglApproval'), d.tglApproval], [t('wodClosing'), d.closing],
      [t('wodSto'), d.sto], [t('wodDistrict'), d.district], [t('wodTeknisiConfirm'), d.teknisiConfirm], [t('wodTeknisiApproval'), d.teknisiApproval],
    ]);
    document.getElementById('wodMeasureGrid').innerHTML = kvHtml([
      [t('wodPowerInput'), d.powerInput], [t('wodTempAc'), d.tempAc], [t('wodTempOlt'), d.tempOlt], [t('wodTempRuangan'), d.tempRuangan],
      [t('wodBatOutput'), d.batOutput], [t('wodBatBersih'), d.batBersih], [t('wodGrounding'), d.grounding], [t('wodBir'), d.bir],
      [t('wodPowerSource'), d.powerSource], [t('wodAlarmModule'), d.alarmModule], [t('wodTypeRecti'), d.typeRecti], [t('wodGroundingUkur'), d.groundingUkur],
    ]);
    document.getElementById('wodAdditionalGrid').innerHTML = kvHtml([
      [t('wodLokasi'), d.lokasi], [t('wodNotes'), d.notes], [t('wodKoordinat'), d.koordinat],
      [t('wodRegional'), d.regional], [t('wodArea'), d.area], [t('wodBatteryExist'), d.batteryExist],
    ]);
    document.getElementById('wodPlnGrid').innerHTML = kvHtml([
      [t('wodPlnStatus'), d.plnStatus], [t('wodPlnJenis'), d.plnJenis], [t('wodPlnId'), d.plnId], [t('wodPlnMeteran'), d.plnMeteran],
      [t('wodKwhAwal'), d.kwhAwal], [t('wodKwhTerakhir'), d.kwhTerakhir], [t('wodKwhUpdate'), d.kwhUpdate], [t('wodTglKwh'), d.tglKwh],
    ]);
    document.getElementById('wodEvidenceRow').innerHTML =
      '<div class="evidence-item"><div class="k">' + t('wodPowerEvidence') + ' (' + t('wodBefore') + ')</div>' +
        '<button type="button" class="thumb" data-lightbox="/images/tifreg/evidence/GCU/power-before.svg" data-caption="' + d.hostname + ' — ' + t('wodBefore') + '"><img src="/images/tifreg/evidence/GCU/power-before.svg" alt="" /></button></div>' +
      '<div class="evidence-item"><div class="k">' + t('wodPowerEvidence') + ' (' + t('wodAfter') + ')</div>' +
        '<button type="button" class="thumb" data-lightbox="/images/tifreg/evidence/GCU/power-after.svg" data-caption="' + d.hostname + ' — ' + t('wodAfter') + '"><img src="/images/tifreg/evidence/GCU/power-after.svg" alt="" /></button></div>';
    document.getElementById('wodEvidenceRow').querySelectorAll('[data-lightbox]').forEach(function(b){
      b.addEventListener('click', function(){ openLightbox(b.dataset.lightbox, b.dataset.caption); });
    });
    wodModal.classList.add('show');
  }
  document.getElementById('wodClose').addEventListener('click', function(){ wodModal.classList.remove('show'); });
  document.getElementById('wodDone').addEventListener('click', function(){ wodModal.classList.remove('show'); });
</script>
