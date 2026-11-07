{{-- Stand-in for /dispatch/{orderId} (dispatch/input.blade.php). Same field list as the real form:
     Regu, Tanggal, Status Manja, Manja, Koordinat Pelanggan, Alamat Sales, plus the read-only
     UNSC SDI block. Saving actually assigns the regu in the shared deck and re-renders the caller. --}}
<div class="modal-backdrop" id="modalBackdrop" hidden></div>
<div class="modal" id="dispatchModal" hidden>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="dispatchTitle">Dispatch WO</h4>
        <button class="close" data-dismiss aria-label="Tutup">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label" for="dRegu">Regu</label>
              <select class="form-control" id="dRegu"></select>
            </div>
            <div class="form-group">
              <label class="control-label" for="dTgl">Tanggal</label>
              <input type="date" class="form-control" id="dTgl" />
            </div>
            <div class="form-group">
              <label class="control-label" for="dManjaStatus">Status Manja</label>
              <select class="form-control" id="dManjaStatus">
                <option value="1">MANJA OK</option>
                <option value="0">BELUM MANJA</option>
                <option value="2">MANJA NOK</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label" for="dManja">Manja</label>
              <textarea class="form-control" id="dManja" rows="3"
                        placeholder="mis. Pelanggan siap dikunjungi pukul 13.00 WITA"></textarea>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label class="control-label" for="dKoor">Koordinat Pelanggan</label>
              <input type="text" class="form-control" id="dKoor" />
            </div>
            <div class="form-group">
              <label class="control-label" for="dAlamat">Alamat Sales</label>
              <textarea class="form-control" id="dAlamat" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Catatan UNSC SDI</label>
              <textarea class="form-control" id="dUnsc" rows="2" readonly></textarea>
            </div>
            <div class="well" style="padding:10px;margin:0" id="dInfo"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss>Batal</button>
        <button class="btn btn-primary" id="dSimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
  /* the caller re-renders its table through this; pages that include the modal override it */
  var onDispatched = function(){};

  var dRegu = document.getElementById('dRegu');
  var dTgl = document.getElementById('dTgl');
  var currentWo = null;

  TIM.forEach(function(t){
    dRegu.insertAdjacentHTML('beforeend',
      '<option value="' + t.uraian + '">' + t.uraian + ' — ' + t.mitra + (t.hadir ? '' : ' (belum absen)') + '</option>');
  });

  function openDispatch(tiket){
    currentWo = WOS.filter(function(w){ return w.tiket === tiket; })[0];
    if (!currentWo) { return; }
    var w = currentWo;

    document.getElementById('dispatchTitle').textContent =
      (w.tim ? 'Re-Dispatch' : 'Dispatch') + ' WO ' + w.pelanggan;
    /* re-dispatching preselects the regu currently holding the order, the way the real form seeds
       its id_regu input from old() falling back to the order's current regu */
    dRegu.value = w.tim || TIM[0].uraian;
    dTgl.value = isoDate(TODAY);
    document.getElementById('dManjaStatus').value = w.tim ? '1' : '0';
    document.getElementById('dManja').value = '';
    document.getElementById('dKoor').value = w.koor;
    document.getElementById('dAlamat').value = w.alamat;
    document.getElementById('dUnsc').value = w.sebab || '-';
    document.getElementById('dInfo').innerHTML =
      '<b>' + w.tiket + '</b> · ' + w.jenis + ' · ' + w.layanan + '<br />' +
      w.nd + ' ~ ' + w.inet + '<br />' +
      'STO ' + w.sto + ' / ' + w.odp + '<br />' +
      'Open : ' + w.open_at + ' (' + w.umur + ' jam)<br />' +
      'Regu saat ini : ' + (w.tim ? w.tim + ' (' + w.mitra + ')' : '<i>belum ada</i>');

    openModal('#dispatchModal');
  }

  document.getElementById('dSimpan').addEventListener('click', function(){
    if (!currentWo) { return; }
    var wasEmpty = !currentWo.tim;
    var previous = currentWo.tim;
    if (!wasEmpty && previous === dRegu.value) {
      toast('Regu tidak berubah — pilih regu lain untuk re-dispatch.');
      return;
    }
    var w = dispatchWo(currentWo.tiket, dRegu.value, dTgl.value);
    closeModal();
    onDispatched(w);
    toast(wasEmpty
      ? w.tiket + ' di-dispatch ke ' + w.tim + '.'
      : w.tiket + ' dipindah dari ' + previous + ' ke ' + w.tim + '.');
  });
</script>
