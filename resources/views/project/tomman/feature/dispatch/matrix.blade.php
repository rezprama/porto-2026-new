<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5az</title>
@include('project.tomman.feature.partials.shell-styles')
<style>
  /* the rules dispatch/matrix.blade.php declares inline, kept verbatim */
  th{text-align:center;vertical-align:middle}
  .geser_kiri_dikit{position:relative;left:-12px}
  #matrix table{font-size:12px}
  #matrix td{vertical-align:middle}
  .list-cell{text-align:left;line-height:2.1}
  .list-cell .label{margin-right:3px}
  .hot{vertical-align:middle;margin-left:-10px}
  .filter-form{display:flex;flex-wrap:wrap;align-items:center;gap:8px;font-size:12px}
  .filter-form select,.filter-form input[type="date"]{height:30px;padding:0 6px;font-size:12px;font-family:inherit;
    color:#666;border:1px solid #ddd;border-radius:3px;background:#fff}
  .legend{display:flex;flex-wrap:wrap;gap:6px 10px;font-size:11px;margin-top:4px}
  .legend span.label{font-weight:400}
</style>
</head>
<body>

@include('project.tomman.feature.partials.navbar', ['active' => 'matrix'])

<div class="container-fluid" style="margin-bottom:50px">
  <div style="padding-bottom:10px">
    <h3>Matrix Workorder</h3>
    <form class="filter-form" id="filterForm" onsubmit="return false">
      <label for="fSektor">SEKTOR :</label>
      <select name="sektor" id="fSektor">
        <option value="ALL">ALL</option>
        <option value="ASR">ASR ONLY</option>
        <option value="PROV">PROV ONLY</option>
        <option value="INNER">INNER ONLY</option>
        <option value="OUTER">OUTER ONLY</option>
      </select>
      <label for="fDate">DATE :</label>
      <input type="date" name="date" id="fDate" />
      <button type="button" class="btn btn-sm btn-primary" id="btnApply">Submit</button>
      <span id="woCount" style="color:#999"></span>
    </form>
    <div class="legend" id="legend"></div>
  </div>

  <div id="matrix"></div>
</div>

@include('project.tomman.feature.partials.wo-data')
@include('project.tomman.feature.partials.shell-script')
<script>
  /* ---------- man-hours per order type, mirroring the *_MH columns the real query sums ---------- */
  var MH_OF = { GANGGUAN: 1, ASSIST: 1, PSB: 2, MIGRASI: 2, CCAN: 3 };

  var fSektor = document.getElementById('fSektor');
  var fDate = document.getElementById('fDate');

  SEKTOR.forEach(function(s){
    fSektor.insertAdjacentHTML('beforeend', '<option value="' + s.key + '">' + s.key + '</option>');
  });
  fDate.value = isoDate(TODAY);

  var params = new URLSearchParams(window.location.search);
  if (params.get('sektor')) { fSektor.value = params.get('sektor'); }

  function matchSektor(tim){
    var v = fSektor.value;
    if (v === 'ALL') { return true; }
    if (v === 'ASR' || v === 'PROV') { return tim.jns === v.toLowerCase(); }
    if (v === 'INNER' || v === 'OUTER') { return tim.area === v; }
    return tim.sektor === v;
  }
  function matchDate(wo){ return wo.dispatch_at.slice(0, 10) === fDate.value; }

  /* the real chips render the ticket, its age, and a popover with the full dispatch trail */
  function chip(wo){
    var content = '<b>Open Order</b> :<br />' + wo.open_at +
      '<br /><b>Dispatch at</b> :<br />' + wo.dispatch_at +
      '<br /><b>Status</b> : <br />' + statusName(wo.status) + ' / <small>' + (wo.modified_at || '~') + '</small>' +
      '<br /><b>Jenis Psb : </b><br />' + wo.jenis +
      '<br /><b>Jenis Layanan : </b><br />' + wo.layanan +
      '<br /><b>Catatan Teknisi</b> : <br />' + (wo.catatan || '-');
    var text = (wo.action === 1 ? '• ' : '') + wo.tiket + ' (' + wo.umur + ' Hour)';
    var cls = 'label label-' + statusLabel(wo.status) + (wo.channel === '6' ? ' myindihome' : '');
    var hot = '';
    if (wo.umur > 72) { hot = flame('#e51c23'); } else if (wo.umur > 48) { hot = flame('#ff9800'); }
    return '<a data-toggle="popover" data-content="' + esc(content) + '" class="' + cls + '">' + text + '</a>' + hot;
  }
  function flame(color){
    return '<svg class="hot geser_kiri_dikit" width="13" height="13" viewBox="0 0 24 24" fill="' + color + '">' +
      '<path d="M12 2s5 4.5 5 9a5 5 0 0 1-10 0c0-1.6.6-3 1.4-4.2C8.1 8.6 8 10 8 10S6 8 6 5.5C6 3.6 12 2 12 2Z"/></svg>';
  }

  function render(){
    var host = document.getElementById('matrix');
    var visibleTim = TIM.filter(matchSektor);
    var groups = SEKTOR.filter(function(s){
      return visibleTim.some(function(t){ return t.sektor === s.key; });
    });

    var shown = 0;
    var html = groups.map(function(s){
      var rows = '';
      var tot = { target: 0, jumlah: 0, mh: 0, noupd: 0, prog: 0, kendala: 0, up: 0, mhup: 0, prod: 0 };
      var n = 0;

      visibleTim.filter(function(t){ return t.sektor === s.key; }).forEach(function(tim){
        var list = woOf(tim.uraian).filter(matchDate);
        if (!list.length) { return; }   /* the real view skips regu with an empty listWO */
        n++;
        shown += list.length;

        var mh = 0, mhUp = 0, c = { NO_UPDATE: 0, PROGRESS: 0, KENDALA: 0, UP: 0 };
        list.forEach(function(w){
          var m = MH_OF[w.jenis] || 1;
          mh += m;
          c[bucketOf(w.status)]++;
          if (bucketOf(w.status) === 'UP') { mhUp += m; }
        });
        var prod = (mhUp / tim.kemampuan) * 100;

        tot.target += tim.target_MH; tot.jumlah += list.length; tot.mh += mh;
        tot.noupd += c.NO_UPDATE; tot.prog += c.PROGRESS; tot.kendala += c.KENDALA;
        tot.up += c.UP; tot.mhup += mhUp; tot.prod += prod;

        var hadir = tim.hadir
          ? '<span class="label label-success">HADIR</span>'
          : '<span class="label label-info">BELUM HADIR</span>';
        /* the real view paints PROD red when a prov regu has not clocked in */
        var prodCls = (tim.jns === 'prov' && !tim.hadir) ? ' class="red"' : '';

        rows += '<tr>' +
          '<td>' + n + '</td>' +
          '<td style="text-align:left"><small>' + tim.nik1 + ' // ' + tim.nik2 + '</small><br />' +
            tim.uraian + ' <span class="label label-primary">' + tim.mitra + '</span> ' + hadir + '</td>' +
          '<td>' + tim.target_MH + '</td>' +
          '<td>' + list.length + '</td>' +
          '<td>' + mh + '</td>' +
          (c.NO_UPDATE > 0 ? '<td class="red">' : '<td>') + c.NO_UPDATE + '</td>' +
          '<td>' + c.PROGRESS + '</td>' +
          '<td>' + c.KENDALA + '</td>' +
          '<td>' + c.UP + '</td>' +
          '<td>' + mhUp + '</td>' +
          '<td' + prodCls + '>' + pct(prod) + '</td>' +
          '<td class="list-cell">' + list.map(chip).join(' ') + '</td>' +
          '</tr>';
      });

      if (!n) { return ''; }

      rows += '<tr class="gray"><td colspan="2"><b>Total</b></td>' +
        '<td><b>' + tot.target + '</b></td><td><b>' + tot.jumlah + '</b></td><td><b>' + tot.mh + '</b></td>' +
        '<td><b>' + tot.noupd + '</b></td><td><b>' + tot.prog + '</b></td><td><b>' + tot.kendala + '</b></td>' +
        '<td><b>' + tot.up + '</b></td><td><b>' + tot.mhup + '</b></td><td><b>' + pct(tot.prod / n) + '</b></td>' +
        '<td></td></tr>';

      return '<div class="panel panel-primary">' +
        '<div class="panel-heading">MATRIX ORDER ' + s.title + '</div>' +
        '<div class="panel-body"><div class="table-responsive">' +
        '<table class="table table-striped table-bordered">' +
        '<thead>' +
          '<tr>' +
            '<th width="10" rowspan="2">No</th><th width="200" rowspan="2">Nama Tim</th>' +
            '<th width="60" rowspan="2">Target MH</th><th colspan="2">WO</th>' +
            '<th width="60" rowspan="2">NO UPDATE</th><th width="60" rowspan="2">PROGRESS</th>' +
            '<th width="60" rowspan="2">KENDALA</th><th width="60" rowspan="2">UP</th>' +
            '<th width="60" rowspan="2">MH ACH</th><th width="60" rowspan="2">PROD</th>' +
            '<th rowspan="2">LIST</th>' +
          '</tr>' +
          '<tr><th width="30">Jumlah</th><th width="30">MH</th></tr>' +
        '</thead><tbody>' + rows + '</tbody></table></div></div></div>';
    }).join('');

    host.innerHTML = html || '<div class="alert alert-warning">Tidak ada order yang ter-dispatch pada tanggal / sektor ini.</div>';
    document.getElementById('woCount').textContent = shown + ' order';
  }

  /* legend: one chip per distinct laporan_status so the colour ladder is readable */
  document.getElementById('legend').innerHTML = Object.keys(STATUS).map(function(k){
    return '<span class="label label-' + STATUS[k].label + '">' + STATUS[k].name + '</span>';
  }).join('');

  document.getElementById('btnApply').addEventListener('click', render);
  fSektor.addEventListener('change', render);
  fDate.addEventListener('change', render);
  render();
</script>
</body>
</html>
