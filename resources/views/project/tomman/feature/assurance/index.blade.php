<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5az</title>
@include('project.tomman.feature.partials.shell-styles')
<style>
  .strong{font-weight:700}
  .stronger{font-weight:700;font-size:9px}
  .ukur{font-size:11.5px;line-height:1.7;white-space:nowrap}
  .ukur b{color:#212121}
  .los{color:#e51c23;font-weight:700}
  .online{color:#4caf50;font-weight:700}
  .wo-acts .label{margin:0 3px 3px 0;display:inline-block}
</style>
</head>
<body>

@include('project.tomman.feature.partials.navbar', ['active' => 'assurance'])

<div class="container-fluid" style="margin-bottom:50px">
  <h3>ASSURANCE</h3>

  <ul class="nav nav-tabs ajax">
    <li class="active" data-pane="paneSearch"><a>Search</a></li>
    <li data-pane="paneManual"><a>Dispatch Manual</a></li>
  </ul>
  <br />

  <div id="txtHint">
    <div id="paneSearch">
      <form class="form-group" id="submit-form" onsubmit="return false">
        <label class="control-label" for="Search">Search</label>
        <input type="text" name="search" class="form-control" id="Search"
               placeholder="No. Tiket / No. Telp / No. Internet / Nama Pelanggan" />
        <br />
        <button type="button" class="btn btn-primary" id="btnSearch">Search</button>
      </form>

      <br />
      <div id="resultNote"></div>
      <div class="table-responsive" id="resultTable"></div>
    </div>

    <div id="paneManual" hidden>
      <div class="row">
        <div class="col-sm-7">
          <div class="panel panel-default">
            <div class="panel-heading">Dispatch Manual</div>
            <div class="panel-body">
              <div class="form-group">
                <label class="control-label" for="mTiket">No. Tiket</label>
                <select class="form-control" id="mTiket"></select>
              </div>
              <div class="form-group">
                <label class="control-label" for="mTim">Tim Teknisi</label>
                <select class="form-control" id="mTim"></select>
              </div>
              <div class="form-group">
                <label class="control-label" for="mCatatan">Catatan Dispatch</label>
                <textarea class="form-control" id="mCatatan" rows="3"
                          placeholder="mis. Prioritas pelanggan korporat, mohon dikerjakan pagi ini"></textarea>
              </div>
              <button type="button" class="btn btn-primary" id="btnDispatch">Dispatch</button>
              <button type="button" class="btn btn-default" data-demo>Batal</button>
            </div>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="panel panel-info">
            <div class="panel-heading">Ringkasan Tiket</div>
            <div class="panel-body" id="mSummary"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('project.tomman.feature.partials.wo-data')
@include('project.tomman.feature.partials.shell-script')
@include('project.tomman.feature.partials.dispatch-modal')
<script>
  /* ---------- tab strip ---------- */
  document.querySelectorAll('.nav-tabs.ajax li').forEach(function(li){
    li.addEventListener('click', function(){
      document.querySelectorAll('.nav-tabs.ajax li').forEach(function(o){
        o.classList.toggle('active', o === li);
        document.getElementById(o.dataset.pane).hidden = o !== li;
      });
    });
  });

  /* ---------- assurance only ever lists gangguan tickets ---------- */
  var GGN = WOS.filter(function(w){ return w.jenis === 'GANGGUAN' || w.jenis === 'ASSIST'; });

  /* iBooster redaman figures — the "Hasil Ukur" column the real screen leaves for the grabber to fill */
  function ukur(w, i){
    var los = w.status === 2 || w.status === 24;   /* ODP loss / full reads as LOS on the ONU */
    var oltTx = (2 + (seeded(i, 131) % 12) / 10).toFixed(2);
    var oltRx = (-(17 + (seeded(i, 137) % 110) / 10)).toFixed(2);
    var onuTx = (2 + (seeded(i, 139) % 14) / 10).toFixed(2);
    var onuRx = los ? '-40.00' : (-(18 + (seeded(i, 149) % 90) / 10)).toFixed(2);
    return '<div class="ukur">' +
      'ONU Link : <span class="' + (los ? 'los">LOS' : 'online">ONLINE') + '</span><br />' +
      'OLT Tx : <b>' + oltTx + '</b> dBm &nbsp; OLT Rx : <b>' + oltRx + '</b> dBm<br />' +
      'ONU Tx : <b>' + onuTx + '</b> dBm &nbsp; ONU Rx : <b>' + onuRx + '</b> dBm<br />' +
      'IP NE : 10.' + (14 + (seeded(i, 151) % 6)) + '.' + (seeded(i, 157) % 250) + '.2</div>';
  }

  function render(){
    var q = document.getElementById('Search').value.trim().toUpperCase();
    var list = q
      ? GGN.filter(function(w){
          return [w.tiket, w.nd, w.inet, w.pelanggan, w.sto, w.odp]
            .some(function(v){ return String(v).toUpperCase().indexOf(q) !== -1; });
        })
      : GGN;

    document.getElementById('resultNote').innerHTML = q
      ? '<b>' + q + '</b> — ' + list.length + ' tiket ditemukan.'
      : list.length + ' tiket gangguan aktif hari ini.';

    document.getElementById('resultTable').innerHTML = list.length
      ? '<table class="table table-striped table-bordered dataTable">' +
        '<thead><tr><th width="30">#</th><th>Workorder</th><th width="230">Hasil Ukur</th></tr></thead><tbody>' +
        list.map(function(w, i){
          /* assurance/index.blade.php branches on $result->uraian — the regu holding the ticket.
             Empty regu → "Dispatch"; regu present → "Re-Dispatch" next to the team chip. */
          return '<tr><td>' + (i + 1) + '.</td><td class="wo-acts">' +
            (w.tim
              ? '<a class="label label-info" data-dispatch="' + w.tiket + '" title="' + w.tim + '">Re-Dispatch</a>' +
                '<span class="label label-warning">' + w.tim + '</span>'
              : '<a class="label label-info" data-dispatch="' + w.tiket + '">Dispatch</a>') +
            '<a class="label label-danger" data-demo>Hapus</a>' +
            '<span class="label label-' + statusLabel(w.status) + '">' + statusName(w.status) + '</span>' +
            '<br /><a data-demo>' + w.tiket + '</a> - ' + w.nd + ' - ' + w.inet +
            '<br /><span class="strong">' + w.pelanggan + '</span> — ' + w.sto + ' / ' + w.odp +
            '<br /><span class="stronger">' + w.alamat + '</span>' +
            '<br />Sebab : ' + (w.sebab || '-') + ' &nbsp;|&nbsp; Umur : <b>' + w.umur + ' jam</b>' +
            '</td><td>' + ukur(w, i) + '</td></tr>';
        }).join('') + '</tbody></table>'
      : '<br />Data Tidak ditemukan.<br /><br /><a class="btn btn-success" data-demo>Re-sync from Nossa</a>';
  }

  document.getElementById('resultTable').addEventListener('click', function(e){
    var a = e.target.closest('[data-dispatch]');
    if (a) { openDispatch(a.dataset.dispatch); }
  });
  /* a save in the modal has to refresh both the list and the manual-dispatch queue behind it */
  onDispatched = function(){ render(); fillQueue(); };

  document.getElementById('btnSearch').addEventListener('click', render);
  document.getElementById('Search').addEventListener('input', render);
  render();

  /* ---------- dispatch manual ---------- */
  var mTiket = document.getElementById('mTiket');
  var mTim = document.getElementById('mTim');
  function fillQueue(){
    var keep = mTiket.value;
    mTiket.innerHTML = GGN.filter(function(w){ return !w.tim; }).map(function(w){
      return '<option value="' + w.tiket + '">' + w.tiket + ' — ' + w.pelanggan + '</option>';
    }).join('');
    if (keep) { mTiket.value = keep; }
    renderSummary();
  }
  TIM.filter(function(t){ return t.jns === 'asr'; }).forEach(function(t){
    mTim.insertAdjacentHTML('beforeend', '<option value="' + t.uraian + '">' + t.uraian + ' (' + t.mitra + ')</option>');
  });

  function renderSummary(){
    var w = GGN.filter(function(x){ return x.tiket === mTiket.value; })[0];
    if (!w) { document.getElementById('mSummary').innerHTML = '<i>Tidak ada tiket undispatch.</i>'; return; }
    document.getElementById('mSummary').innerHTML =
      '<table class="table table-condensed" style="margin:0">' +
      [['Tiket', w.tiket], ['Pelanggan', w.pelanggan], ['ND / Inet', w.nd + ' / ' + w.inet],
       ['STO / ODP', w.sto + ' / ' + w.odp], ['Alamat', w.alamat], ['Sebab', w.sebab || '-'],
       ['Umur', w.umur + ' jam'], ['Open', w.open_at]]
        .map(function(r){ return '<tr><td width="90"><b>' + r[0] + '</b></td><td>' + r[1] + '</td></tr>'; })
        .join('') + '</table>';
  }
  mTiket.addEventListener('change', renderSummary);
  fillQueue();

  document.getElementById('btnDispatch').addEventListener('click', function(){
    if (!mTiket.value) { toast('Tidak ada tiket undispatch untuk didispatch.'); return; }
    var w = dispatchWo(mTiket.value, mTim.value, isoDate(TODAY));
    render();
    fillQueue();
    toast(w.tiket + ' di-dispatch ke ' + w.tim + ' dan dikirim ke group Telegram sektor.');
  });
</script>
</body>
</html>
