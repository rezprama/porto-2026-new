<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5az</title>
@include('project.tomman.feature.partials.shell-styles')
<style>
  /* ticketing/dashboard.blade.php declares its own table skin inline — reproduced as-is */
  #slaTable{width:100%;border-collapse:collapse}
  #slaTable th{text-align:center;vertical-align:middle;background-color:#0073b7;padding:5px;color:#FFF;
    border:1px solid #ecf0f1;font-size:12px}
  #slaTable td{font-size:14px;padding:3px!important;border:1px solid #ecf0f1}
  #slaTable th.green{background-color:#2ecc71}
  #slaTable th.orange{background-color:#e67e22}
  #slaTable th.redx{background-color:#e74c3c}
  #slaTable td.center{text-align:center}
  #slaTable td.center a{color:#666666!important}
  #slaTable tr.gray td{background-color:#f4f4f4;font-weight:700}
  #slaTable td.hot{background-color:#fdecea;font-weight:700}
</style>
</head>
<body>

@include('project.tomman.feature.partials.navbar', ['active' => 'ticketing'])

<div class="container-fluid" style="margin-bottom:50px">
  <div class="text-center"><h3>Dashboard Ticket Tomman</h3></div>

  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">Sebaran umur tiket gangguan per sektor — klik angka untuk melihat daftarnya</div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="slaTable">
              <thead>
                <tr>
                  <th rowspan="2">SEKTOR</th>
                  <th colspan="7">DURASI (Jam)</th>
                  <th colspan="2">SUM</th>
                  <th rowspan="2">TTL</th>
                </tr>
                <tr>
                  <th class="green">0-2</th><th class="green">2-4</th><th class="green">4-6</th>
                  <th class="orange">6-8</th><th class="orange">8-10</th><th class="orange">10-12</th>
                  <th class="redx">12-24</th>
                  <th class="redx">&gt;24</th><th>&lt;24</th>
                </tr>
              </thead>
              <tbody id="slaBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal-backdrop" id="modalBackdrop" hidden></div>
<div class="modal" id="listModal" hidden>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="listTitle">Daftar Tiket</h4>
        <button class="close" data-dismiss aria-label="Tutup">&times;</button>
      </div>
      <div class="modal-body"><div class="table-responsive" id="listBody"></div></div>
      <div class="modal-footer"><button class="btn btn-default" data-dismiss>Tutup</button></div>
    </div>
  </div>
</div>

@include('project.tomman.feature.partials.wo-data')
@include('project.tomman.feature.partials.shell-script')
<script>
  /* the SQL behind this screen buckets by umur_gangguan; the named keys are the URL segments
     the real cells link to (/ticketing/dashboardList/{sektor}/{bucket}) */
  var BUCKETS = [
    { key: 'x0dan2',   label: '0-2',   test: function(h){ return h < 2; } },
    { key: 'x2dan4',   label: '2-4',   test: function(h){ return h >= 2 && h < 4; } },
    { key: 'x4dan6',   label: '4-6',   test: function(h){ return h >= 4 && h < 6; } },
    { key: 'x6dan8',   label: '6-8',   test: function(h){ return h >= 6 && h < 8; } },
    { key: 'x8dan10',  label: '8-10',  test: function(h){ return h >= 8 && h < 10; } },
    { key: 'x10dan12', label: '10-12', test: function(h){ return h >= 10 && h < 12; } },
    { key: 'x12dan24', label: '12-24', test: function(h){ return h >= 12 && h < 24; } },
    { key: 'lebih24',  label: '> 24',  test: function(h){ return h >= 24; } },
    { key: 'kurang24', label: '< 24',  test: function(h){ return h < 24; } },
  ];

  /* this dashboard only counts still-open gangguan — a UP ticket has left the queue */
  var OPEN = WOS.filter(function(w){
    return (w.jenis === 'GANGGUAN' || w.jenis === 'ASSIST') && w.status !== 1 && w.status !== 37;
  });
  /* UNDISPATCH means no regu has been assigned — not "no report yet". A dispatched ticket sitting at
     NO UPDATE still belongs to its sektor's row, which is how the real dashboard counts it. */
  var UNDISPATCH = OPEN.filter(function(w){ return !w.tim; });
  var DISPATCHED = OPEN.filter(function(w){ return !!w.tim; });

  function rowsIn(scope, bucketKey){
    var pool = scope === 'undispatch' ? UNDISPATCH
      : scope === 'ALL' ? DISPATCHED
      : DISPATCHED.filter(function(w){ return w.sektor === scope; });
    if (bucketKey === 'ALL') { return pool; }
    var b = BUCKETS.filter(function(x){ return x.key === bucketKey; })[0];
    return pool.filter(function(w){ return b.test(w.umur); });
  }

  function cell(scope, bucketKey, hot){
    var n = rowsIn(scope, bucketKey).length;
    return '<td class="center' + (hot && n > 0 ? ' hot' : '') + '">' +
      '<a data-scope="' + scope + '" data-bucket="' + bucketKey + '">' + n + '</a></td>';
  }
  function rowFor(scope, label, cls){
    return '<tr' + (cls ? ' class="' + cls + '"' : '') + '><td>' + label + '</td>' +
      BUCKETS.map(function(b){ return cell(scope, b.key, b.key === 'lebih24'); }).join('') +
      cell(scope, 'ALL', false) + '</tr>';
  }

  document.getElementById('slaBody').innerHTML =
    SEKTOR.map(function(s){ return rowFor(s.key, s.key, ''); }).join('') +
    rowFor('undispatch', 'UNDISPATCH', '') +
    rowFor('ALL', 'TOTAL', 'gray');

  document.getElementById('slaBody').addEventListener('click', function(e){
    var a = e.target.closest('a[data-scope]');
    if (!a) { return; }
    var scope = a.dataset.scope, bucket = a.dataset.bucket;
    var list = rowsIn(scope, bucket);
    var bl = bucket === 'ALL' ? 'SEMUA' : BUCKETS.filter(function(x){ return x.key === bucket; })[0].label + ' jam';
    document.getElementById('listTitle').textContent = 'Tiket ' + scope + ' — ' + bl + ' (' + list.length + ')';
    document.getElementById('listBody').innerHTML = list.length
      ? '<table class="table table-striped table-bordered table-condensed">' +
        '<thead><tr><th>#</th><th>Tiket</th><th>Pelanggan</th><th>ND</th><th>STO</th>' +
        '<th>Tim</th><th>Status</th><th>Umur</th><th>Open</th></tr></thead><tbody>' +
        list.map(function(w, i){
          return '<tr><td>' + (i + 1) + '</td><td>' + w.tiket + '</td><td>' + w.pelanggan + '</td>' +
            '<td>' + w.nd + '</td><td>' + w.sto + '</td>' +
            '<td>' + (scope === 'undispatch' ? '<i>belum dispatch</i>' : w.tim) + '</td>' +
            '<td><span class="label label-' + statusLabel(w.status) + '">' + statusName(w.status) + '</span></td>' +
            '<td>' + w.umur + ' jam</td><td>' + w.open_at + '</td></tr>';
        }).join('') + '</tbody></table>'
      : '<div class="alert alert-warning" style="margin:0">Tidak ada tiket pada rentang ini.</div>';
    openModal('#listModal');
  });

  /* ---------- Interactive Tour Guide ---------- */
  var tommanTicketingTour = {
    id: 'tomman-ticketing',
    steps: [
      {
        target: '#slaTable thead',
        pos: 'bottom',
        title: 'Tabel Distribusi Umur Tiket (SLA)',
        desc: 'Matriks membagi tiket ke dalam interval pengerjaan: Hijau (0-6 jam), Oranye (6-12 jam), dan Merah (>12 hingga >24 jam).'
      },
      {
        target: '#slaTable th.redx',
        pos: 'bottom',
        title: 'Tiket Kritis & Melewati SLA',
        desc: 'Kolom merah menyoroti tiket yang telah berumur lebih dari 24 jam dan memerlukan eskalasi penanganan prioritas.'
      },
      {
        target: '#slaBody tr:nth-last-child(2)',
        pos: 'top',
        title: 'Baris Undispatch',
        desc: 'Menghitung kuantitas tiket masuk yang belum ditetapkan ke regu teknisi mana pun.'
      },
      {
        target: '#slaBody td.center a:first-child',
        pos: 'top',
        title: 'Interaktif: Drill-down Tiket',
        desc: 'Klik angka pada sel mana pun untuk membuka dialog daftar tiket lengkap beserta nama pelanggan, nomor ND, STO, tim, dan umur order.'
      }
    ]
  };

  setTimeout(function(){
    TommanTour.start(tommanTicketingTour);
  }, 450);
</script>

@include('project.tomman.feature.partials.tour-guide')
</body>
</html>
