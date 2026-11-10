<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5az</title>
@include('project.tomman.feature.partials.shell-styles')
<style>
  /* dispatch/searchform.blade.php stacks the search box inside a .form-control-looking wrapper */
  .result-box{background:#fff;border:1px solid #ddd;border-radius:3px;padding:12px 15px;margin-bottom:20px}
  .wo-table td{font-size:12px;line-height:1.7}
  .wo-table .acts .label{margin:0 3px 3px 0;display:inline-block}
  .wo-num{width:34px;text-align:center;vertical-align:top!important;font-weight:700}
  .search-row{display:flex;flex-wrap:wrap;gap:8px;align-items:flex-end}
  .search-row .grow{flex:1 1 260px}
  .search-row select{height:37px;font-size:13px;padding:0 4px}
</style>
</head>
<body>

@include('project.tomman.feature.partials.navbar', ['active' => 'workorder'])

<div class="container-fluid" style="margin-bottom:50px">

  {{-- workorderlist.blade.php: the heading + the one-tab strip the real screen renders --}}
  <h3>MONITORING WORK ORDER</h3>
  <ul class="nav nav-tabs" style="margin-bottom:20px">
    <li class="active"><a>SEARCH</a></li>
  </ul>

  <div>
    <form class="form-group" id="submit-form" onsubmit="return false">
      <div class="search-row">
        <div class="grow">
          <label class="control-label" for="Search">Search</label>
          <input type="text" name="Search" class="form-control" id="Search"
                 placeholder="No. Tiket / SC / Nama Pelanggan / ND / STO" />
        </div>
        <div>
          <label class="control-label" for="fStatus">Status</label>
          <select class="form-control" id="fStatus"><option value="">-- SEMUA --</option></select>
        </div>
        <div>
          <label class="control-label" for="fJenis">Jenis</label>
          <select class="form-control" id="fJenis"><option value="">-- SEMUA --</option></select>
        </div>
        <div><button type="button" class="btn btn-primary" id="btnSearch">Search</button></div>
      </div>
    </form>
  </div>

  <br />
  <div class="result-box" id="resultBox"></div>
  <div class="table-responsive" id="resultTable"></div>
</div>

@include('project.tomman.feature.partials.wo-data')
@include('project.tomman.feature.partials.shell-script')
@include('project.tomman.feature.partials.dispatch-modal')
<script>
  var qEl = document.getElementById('Search');
  var fStatus = document.getElementById('fStatus');
  var fJenis = document.getElementById('fJenis');

  Object.keys(STATUS).forEach(function(k){
    fStatus.insertAdjacentHTML('beforeend', '<option value="' + k + '">' + STATUS[k].name + '</option>');
  });
  JENIS.forEach(function(j){
    fJenis.insertAdjacentHTML('beforeend', '<option value="' + j + '">' + j + '</option>');
  });

  function matches(w){
    var q = qEl.value.trim().toUpperCase();
    if (fStatus.value && String(w.status) !== fStatus.value) { return false; }
    if (fJenis.value && w.jenis !== fJenis.value) { return false; }
    if (!q) { return true; }
    return [w.tiket, w.pelanggan, w.nd, w.inet, w.sto, w.odp, w.tim, w.alamat]
      .some(function(v){ return String(v).toUpperCase().indexOf(q) !== -1; });
  }

  function rowsFor(list){
    return list.map(function(w, i){
      var done = w.status === 1 || w.status === 37;
      /* workorderlist.blade.php keys this off id_r: no regu yet → a lone "Dispatch" chip;
         regu already assigned → its name, its mitra, the dispatch stamp, and "Re-Dispatch". */
      var acts = w.tim
        ? '<span class="label label-warning">' + w.tim + '</span>' +
          '<a class="label label-info" data-dispatch="' + w.tiket + '" title="' + w.tim + '">Re-Dispatch</a>' +
          '<span class="label label-warning">' + w.mitra + '</span>' +
          '<span class="label label-warning">' + w.dispatch_at + '</span>'
        : '<a class="label label-info" data-dispatch="' + w.tiket + '">Dispatch</a>';

      acts +=
        '<a class="label label-info" data-demo>Update MS2N</a>' +
        '<a class="label label-warning" data-demo>Send SMS</a>' +
        (done ? '<span class="label label-success">' + statusName(w.status) + '</span>' +
                '<a class="label label-primary" data-demo>Send To KPRO</a>' : '') +
        (w.channel === '6' ? '<span class="label label-default">MYINDIHOME</span>' : '') +
        '<a class="label label-danger" data-demo>H a p u s</a>';

      return '<tr>' +
          '<td rowspan="3" class="wo-num">' + (i + 1) + '.</td>' +
          '<td colspan="2" class="acts">' + acts + '</td>' +
        '</tr>' +
        '<tr>' +
          '<td>' +
            '<span class="label label-' + statusLabel(w.status) + '">' + statusName(w.status) + '</span>' +
            (w.sektor ? ' WO Cluster ' + w.sektor : ' <i>belum ter-dispatch</i>') + '<br />' +
            '<a data-demo>SC' + w.tiket + '</a> / ' + w.open_at + '<br />' +
            w.nd + '~' + w.inet + '<br />' +
            w.pelanggan + '<br />' +
            w.sto + ' / ' + w.jenis + '<br />' +
            'NCLI : ' + pad(seeded(i, 127) % 99999999, 8) + '<br />' +
            w.layanan + '<br />' +
            w.odp + '<br />' +
            '(' + w.lat + ', ' + w.lng + ') / ' + w.olt_ip + ' / ' + w.olt + '<br />' +
            'Lokasi ODP : maps.google.com/?q=' + w.koor + '<br />' +
            w.alamat + '<br />' +
            'Koordinat Pelanggan : <b>' + w.koor + '</b><br />' +
            'Alamat Sales : <b>' + w.alamat + '</b>' +
          '</td>' +
          '<td>' +
            'Umur Order : <b>' + w.umur + ' Jam</b><br />' +
            'Mitra : ' + (w.mitra || '-') + '<br />' +
            'Sektor : ' + (w.sektor || '-') + '<br />' +
            'Dispatch : ' + (w.dispatch_at || '-') + '<br />' +
            'Update Terakhir : ' + (w.modified_at || '-') +
          '</td>' +
        '</tr>' +
        '<tr>' +
          '<td><span>Sebab : <br />' + (w.sebab || '-') + '</span><br />' +
              '<span>Solusi : <br />' + (w.catatan || '-') + '</span></td>' +
          '<td valign="top">Catatan Teknisi : <br />' + (w.catatan || 'Tidak ada') + '<br />' +
              'Due Date Solusi : ' + (w.dispatch_at || '-') + '</td>' +
        '</tr>';
    }).join('');
  }

  function render(){
    var list = WOS.filter(matches);
    var q = qEl.value.trim();
    document.getElementById('resultBox').innerHTML =
      (q ? q + '.' : 'Semua work order.') + '<br />Result (' + list.length + ') Found.';
    document.getElementById('resultTable').innerHTML = list.length
      ? '<table class="table table-striped table-bordered wo-table">' +
          '<thead><tr><th>#</th><th width="75" colspan="2">Work Order</th></tr></thead>' +
          '<tbody>' + rowsFor(list) + '</tbody></table>'
      : '<div class="alert alert-warning">Data Tidak ditemukan.</div>';
  }

  document.getElementById('resultTable').addEventListener('click', function(e){
    var a = e.target.closest('[data-dispatch]');
    if (a) { openDispatch(a.dataset.dispatch); }
  });
  onDispatched = render;

  document.getElementById('btnSearch').addEventListener('click', render);
  qEl.addEventListener('input', render);
  fStatus.addEventListener('change', render);
  fJenis.addEventListener('change', render);
  render();

  /* ---------- Interactive Tour Guide ---------- */
  var tommanMonitoringTour = {
    id: 'tomman-dispatch-monitoring',
    steps: [
      {
        target: '#submit-form',
        pos: 'bottom',
        title: 'Toolbar Pencarian Workorder',
        desc: 'Cari tiket secara fleksibel berdasarkan No. Tiket, No. SC, Nama Pelanggan, Nomor Telepon/ND, atau nama STO.'
      },
      {
        target: '#fStatus',
        pos: 'bottom',
        title: 'Filter Status Order',
        desc: 'Saring antrean workorder berdasarkan status pengerjaan: Open, Progress, Kendala Teknis, atau Solved.'
      },
      {
        target: '#resultBox',
        pos: 'bottom',
        title: 'Hasil Pencarian & Total Ditemukan',
        desc: 'Menampilkan ringkasan kata kunci pencarian dan total kuantitas order yang cocok dalam sistem.'
      },
      {
        target: '#resultTable table tbody tr:first-child',
        pos: 'top',
        title: 'Baris Data Workorder Lapangan',
        desc: 'Memuat nomor tiket, nama pelanggan, alamat instalasi, umur tiket (Hours), mitra pelaksana, dan timeline penugasan.'
      },
      {
        target: '#resultTable [data-dispatch]:first-child',
        pos: 'bottom',
        title: 'Aksi Dispatch & Re-Dispatch',
        desc: 'Klik tombol <b>Dispatch</b> (atau <b>Re-Dispatch</b>) untuk membuka modal penugasan tiket langsung ke regu teknisi lapangan yang tersedia.'
      }
    ]
  };

  setTimeout(function(){
    TommanTour.start(tommanMonitoringTour);
  }, 450);
</script>

@include('project.tomman.feature.partials.tour-guide')
</body>
</html>
