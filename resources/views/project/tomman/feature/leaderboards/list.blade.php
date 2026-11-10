<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5az</title>
@include('project.tomman.feature.partials.shell-styles')
<style>
  /* leaderboards/list.blade.php's inline table rules */
  #rankTable th{padding:5px;text-align:left;vertical-align:middle}
  #rankTable td{padding:5px;border-color:#000}
  #rankTable td.num{text-align:center}
  .rank-1 td{background-color:#fff9e0!important}
  .medal{font-weight:700;color:#f1c40f}
  .period{display:flex;flex-wrap:wrap;gap:8px;align-items:center;font-size:12px;margin-bottom:12px}
  .period input[type="date"]{height:30px;padding:0 6px;font-size:12px;font-family:inherit;color:#666;
    border:1px solid #ddd;border-radius:3px;background:#fff}
</style>
</head>
<body>

@include('project.tomman.feature.partials.navbar', ['active' => 'leaderboards'])

<div class="container-fluid" style="margin-bottom:50px">
  <div style="padding-bottom:10px">
    <h3>Leaderboards</h3>

    <ul class="nav nav-tabs" id="squadTabs">
      <li data-squad="ALPHA.PROV"><a>ALPHA.PROV</a></li>
      <li data-squad="ALPHA.ASR"><a>ALPHA.ASR</a></li>
      <li data-squad="DELTA.A"><a>DELTA.A</a></li>
      <li data-squad="DELTA.B"><a>DELTA.B</a></li>
    </ul>

    <div class="period">
      <label for="pStart">Periode :</label>
      <input type="date" id="pStart" />
      <span>s/d</span>
      <input type="date" id="pEnd" />
      <label for="pMitra">Mitra :</label>
      <select id="pMitra" style="height:30px;font-size:12px;border:1px solid #ddd;border-radius:3px;background:#fff;color:#666">
        <option value="ALL">ALL</option>
      </select>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">RANKED <span id="rankNote" style="float:right;font-weight:400;color:#888"></span></div>
          <div class="panel-body table-responsive">
            <table class="table table-striped table-bordered" id="rankTable">
              <thead>
                <tr>
                  <th rowspan="2" width="20">RANKING</th>
                  <th rowspan="2">NIK</th>
                  <th rowspan="2">LABORCODE</th>
                  <th rowspan="2">WARRIOR</th>
                  <th rowspan="2">MITRA</th>
                  <th rowspan="2">JUMLAH GGN</th>
                  <th rowspan="2">JUMLAH GGN UP</th>
                  <th colspan="8">POINT</th>
                </tr>
                <tr>
                  <th>A.D</th><th>A.C</th><th>A.F</th><th>P.A</th><th>P.1</th><th>M</th><th>MIG</th><th>TOTAL</th>
                </tr>
              </thead>
              <tbody id="rankBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('project.tomman.feature.partials.wo-data')
@include('project.tomman.feature.partials.shell-script')
<script>
  /* Each squad is a slice of the workforce: ALPHA works assurance/provisioning day shift,
     DELTA the two maintenance rosters. Each regu contributes its two warriors. */
  var SQUADS = {
    'ALPHA.PROV': function(t){ return t.jns === 'prov'; },
    'ALPHA.ASR':  function(t){ return t.jns === 'asr'; },
    'DELTA.A':    function(t){ return t.area === 'INNER'; },
    'DELTA.B':    function(t){ return t.area === 'OUTER'; },
  };
  var POINTS = ['a_d', 'a_c', 'a_f', 'p_a', 'p_1', 'm', 'mig'];

  var pStart = document.getElementById('pStart');
  var pEnd = document.getElementById('pEnd');
  var pMitra = document.getElementById('pMitra');
  MITRA.forEach(function(m){ pMitra.insertAdjacentHTML('beforeend', '<option value="' + m + '">' + m + '</option>'); });

  (function initPeriod(){
    var today = isoDate(TODAY);
    pEnd.value = today;
    pStart.value = today.slice(0, 8) + '01';
  })();

  var squad = new URLSearchParams(window.location.search).get('squad') || 'ALPHA.ASR';

  function warriorsOf(squadKey){
    var rows = [];
    TIM.filter(SQUADS[squadKey]).forEach(function(t, ti){
      [[t.nik1, t.nama1, 0], [t.nik2, t.nama2, 1]].forEach(function(w, wi){
        var list = woOf(t.uraian).filter(function(o){
          var d = o.dispatch_at.slice(0, 10);
          return d >= pStart.value && d <= pEnd.value;
        });
        /* the two warriors of a regu split its order book */
        var mine = list.filter(function(o, oi){ return oi % 2 === wi; });
        var up = mine.filter(function(o){ return bucketOf(o.status) === 'UP'; });
        var row = {
          nik: w[0], warrior: w[1], mitra: t.mitra,
          laborcode: t.uraian + '.' + (wi === 0 ? 'A' : 'B'),
          jumlah_ggn: mine.length, jumlah_ggn_up: up.length, total: 0,
        };
        POINTS.forEach(function(p, pi){
          row[p] = between(0, 14 - pi, ti + pi + 3, wi + 5);
          row.total += row[p];
        });
        row.total += up.length * 3;   /* a closed order is worth three plain points */
        rows.push(row);
      });
    });
    return rows.sort(function(a, b){ return b.total - a.total || b.jumlah_ggn_up - a.jumlah_ggn_up; });
  }

  function render(){
    document.querySelectorAll('#squadTabs li').forEach(function(li){
      li.classList.toggle('active', li.dataset.squad === squad);
    });
    var rows = warriorsOf(squad).filter(function(r){ return pMitra.value === 'ALL' || r.mitra === pMitra.value; });
    document.getElementById('rankNote').textContent =
      squad + ' · ' + pStart.value + ' s/d ' + pEnd.value + ' · ' + rows.length + ' warrior';
    document.getElementById('rankBody').innerHTML = rows.length
      ? rows.map(function(r, i){
          return '<tr' + (i === 0 ? ' class="rank-1"' : '') + '>' +
            '<td class="num">' + (i === 0 ? '<span class="medal">1.</span>' : (i + 1) + '.') + '</td>' +
            '<td>' + r.nik + '</td><td>' + r.laborcode + '</td><td>' + r.warrior + '</td>' +
            '<td><span class="label label-primary">' + r.mitra + '</span></td>' +
            '<td class="num">' + r.jumlah_ggn + '</td><td class="num">' + r.jumlah_ggn_up + '</td>' +
            POINTS.map(function(p){ return '<td class="num">' + r[p] + '</td>'; }).join('') +
            '<td class="num"><b>' + r.total + '</b></td></tr>';
        }).join('')
      : '<tr><td colspan="15">Tidak ada data pada periode / mitra ini.</td></tr>';
  }

  document.getElementById('squadTabs').addEventListener('click', function(e){
    var li = e.target.closest('li[data-squad]');
    if (!li) { return; }
    squad = li.dataset.squad;
    render();
  });
  [pStart, pEnd, pMitra].forEach(function(el){ el.addEventListener('change', render); });
  render();

  /* ---------- Interactive Tour Guide ---------- */
  var tommanLeaderboardsTour = {
    id: 'tomman-leaderboards',
    steps: [
      {
        target: '#squadTabs',
        pos: 'bottom',
        title: 'Tab Klasemen Squad Teknisi',
        desc: 'Beralih antara squad operasional: ALPHA.PROV (Provisioning), ALPHA.ASR (Assurance), DELTA.A (Inner Maintenance), dan DELTA.B (Outer Maintenance).'
      },
      {
        target: '.period',
        pos: 'bottom',
        title: 'Filter Rentang Tanggal & Mitra',
        desc: 'Tentukan rentang tanggal evaluasi produktivitas poin serta filter per mitra kerja telekomunikasi.'
      },
      {
        target: '#rankTable thead',
        pos: 'bottom',
        title: 'Tabel Peringkat Warrior & Skoring Poin',
        desc: 'Menampilkan NIK, nama teknisi (Warrior), jumlah gangguan ditangani vs diselesaikan (UP), serta akumulasi poin insentif per kategori.'
      },
      {
        target: '#rankBody tr:first-child',
        pos: 'top',
        title: 'Juara Peringkat Pertama (Rank 1)',
        desc: 'Baris berlatar kuning menyoroti teknisi dengan perolehan poin tertinggi pada squad terpilih.'
      }
    ]
  };

  setTimeout(function(){
    TommanTour.start(tommanLeaderboardsTour);
  }, 450);
</script>

@include('project.tomman.feature.partials.tour-guide')
</body>
</html>
