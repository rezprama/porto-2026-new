<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Tomman Ver 1.5az</title>
@include('project.tomman.feature.partials.shell-styles')
<style>
  /* select2 stand-in: the real page renders each option as a chat-id chip + the group name in bold */
  .grp-list{border:1px solid #ddd;border-radius:3px;max-height:290px;overflow-y:auto;background:#fff}
  .grp-list label{display:flex;align-items:center;gap:8px;padding:6px 10px;cursor:pointer;
    border-bottom:1px solid #f1f1f1;font-size:12.5px;margin:0}
  .grp-list label:last-child{border-bottom:none}
  .grp-list label:hover{background:#f5f5f5}
  .grp-list input{margin:0;accent-color:#2196f3}
  .grp-list .label{font-family:monospace}
  .grp-list strong{margin-left:2px;color:#212121;font-weight:500}
  .grp-list .cnt{margin-left:auto;color:#999;font-size:11px}
  .log-entry{border-bottom:1px solid #eee;padding:8px 0;font-size:12px}
  .log-entry:last-child{border-bottom:none}
  .log-entry .meta{color:#999;font-size:11px}
  .log-entry pre{margin:4px 0 0;padding:8px 10px;background:#f7f7f7;border-radius:3px;white-space:pre-wrap;
    font-family:"Roboto Mono",Consolas,monospace;font-size:11.5px;color:#444;line-height:1.6}
  .tpl-btns{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:10px}
</style>
</head>
<body>

@include('project.tomman.feature.partials.navbar', ['active' => 'telegram'])

<div class="container-fluid" style="margin-bottom:50px">
  <h3>Send Message to Group</h3>

  <div class="row">
    <div class="col-sm-7">
      <form id="submit-form" onsubmit="return false" autocomplete="off">
        <div class="form-group">
          <label class="control-label">Groups</label>
          <div class="grp-list" id="groups"></div>
        </div>

        <div class="form-group">
          <label class="control-label" for="message">Messages</label>
          <div class="tpl-btns">
            <button type="button" class="btn btn-xs btn-default" data-tpl="dispatch">Template Dispatch</button>
            <button type="button" class="btn btn-xs btn-default" data-tpl="eskalasi">Template Eskalasi SLA</button>
            <button type="button" class="btn btn-xs btn-default" data-tpl="absen">Template Absen Pagi</button>
          </div>
          <textarea name="message" id="message" class="form-control" rows="7"></textarea>
        </div>

        <div style="margin:40px 0 20px">
          <button type="button" class="btn btn-primary" id="btnKirim">Kirim</button>
          <button type="button" class="btn btn-default" id="btnClear">Bersihkan</button>
          <span id="targetNote" style="margin-left:10px;color:#999;font-size:12px"></span>
        </div>
      </form>
    </div>

    <div class="col-sm-5">
      <div class="panel panel-default">
        <div class="panel-heading">Log Pengiriman Bot <span id="logCount" style="float:right;color:#999;font-weight:400"></span></div>
        <div class="panel-body" id="log" style="max-height:520px;overflow-y:auto">
          <i style="color:#999">Belum ada pesan terkirim pada sesi ini.</i>
        </div>
      </div>
    </div>
  </div>
</div>

@include('project.tomman.feature.partials.wo-data')
@include('project.tomman.feature.partials.shell-script')
<script>
  /* one Telegram group per sektor plus the standing ops rooms, the way the real bot is wired */
  var GROUPS = SEKTOR.map(function(s, i){
    return { id: '-100' + pad(1200000000 + seeded(i + 2, 211) % 99999999, 10), text: 'TOMMAN ' + s.title, sektor: s.key };
  }).concat([
    { id: '-1001899274410', text: 'TOMMAN OPS BALIKPAPAN', sektor: null },
    { id: '-1001455820937', text: 'TOMMAN ESKALASI SLA',   sektor: null },
    { id: '-1001730046518', text: 'TOMMAN TL & SUPERVISOR', sektor: null },
  ]);

  document.getElementById('groups').innerHTML = GROUPS.map(function(g){
    var n = g.sektor ? TIM.filter(function(t){ return t.sektor === g.sektor; }).length * 2 : 24;
    return '<label><input type="checkbox" value="' + g.id + '" data-name="' + g.text + '" />' +
      '<span class="label label-default">' + g.id + '</span><strong>' + g.text + '</strong>' +
      '<span class="cnt">' + n + ' anggota</span></label>';
  }).join('');

  function selected(){
    return Array.prototype.slice.call(document.querySelectorAll('#groups input:checked'));
  }
  function refreshNote(){
    var n = selected().length;
    document.getElementById('targetNote').textContent = n ? n + ' group dipilih' : 'Pilih Group';
  }
  document.getElementById('groups').addEventListener('change', refreshNote);
  refreshNote();

  /* templates built from the live dummy deck, so the broadcast reads like a real dispatch blast */
  var TEMPLATES = {
    dispatch: function(){
      /* the blast that goes out to a regu's group lists the orders handed to them today */
      var today = isoDate(TODAY);
      var list = WOS.filter(function(w){ return w.tim && w.dispatch_at.slice(0, 10) === today; }).slice(0, 4);
      return '[DISPATCH ORDER ' + isoDate(TODAY) + ']\n' +
        list.map(function(w, i){
          return (i + 1) + '. ' + w.tiket + ' | ' + w.jenis + '\n' +
            '   Plg  : ' + w.pelanggan + ' (' + w.nd + ')\n' +
            '   Alm  : ' + w.alamat + '\n' +
            '   ODP  : ' + w.odp + ' | STO ' + w.sto + '\n' +
            '   Tim  : ' + w.tim;
        }).join('\n') +
        '\n\nMohon update laporan maksimal 30 menit setelah tiba di lokasi.';
    },
    eskalasi: function(){
      var list = WOS.filter(function(w){ return w.umur > 24 && bucketOf(w.status) !== 'UP'; }).slice(0, 5);
      return '[ESKALASI SLA > 24 JAM]\n' +
        list.map(function(w){
          return '- ' + w.tiket + ' (' + w.umur + ' jam) | ' + w.tim + ' | ' + statusName(w.status);
        }).join('\n') +
        '\n\nTotal ' + WOS.filter(function(w){ return w.umur > 24 && bucketOf(w.status) !== 'UP'; }).length +
        ' tiket melewati SLA. Mohon TL sektor menindaklanjuti pagi ini.';
    },
    absen: function(){
      var belum = TIM.filter(function(t){ return !t.hadir; });
      return '[ABSEN PAGI ' + isoDate(TODAY) + ']\n' +
        'Regu hadir : ' + (TIM.length - belum.length) + ' / ' + TIM.length + '\n' +
        (belum.length ? 'Belum absen :\n' + belum.map(function(t){ return '- ' + t.uraian + ' (' + t.mitra + ')'; }).join('\n')
                      : 'Seluruh regu sudah absen. Terima kasih.') +
        '\n\nAbsen ditutup pukul 08.30 WITA.';
    },
  };
  document.querySelectorAll('[data-tpl]').forEach(function(b){
    b.addEventListener('click', function(){
      document.getElementById('message').value = TEMPLATES[b.dataset.tpl]();
    });
  });

  /* ---------- send ---------- */
  var sent = 0;
  document.getElementById('btnKirim').addEventListener('click', function(){
    var groups = selected();
    var msg = document.getElementById('message').value.trim();
    if (!groups.length) { toast('Pilih minimal satu group Telegram terlebih dahulu.'); return; }
    if (!msg) { toast('Pesan masih kosong.'); return; }

    var now = new Date();
    var time = pad(now.getHours(), 2) + ':' + pad(now.getMinutes(), 2) + ':' + pad(now.getSeconds(), 2);
    var log = document.getElementById('log');
    if (!sent) { log.innerHTML = ''; }
    sent += groups.length;

    log.insertAdjacentHTML('afterbegin',
      '<div class="log-entry">' +
        groups.map(function(g){
          return '<span class="label label-success">200 OK</span> <strong>' + g.dataset.name + '</strong> ' +
            '<span class="label label-default">' + g.value + '</span>';
        }).join('<br />') +
        '<div class="meta">sendMessage · ' + isoDate(now) + ' ' + time + ' WITA · ' + msg.length + ' karakter</div>' +
        '<pre>' + esc(msg) + '</pre>' +
      '</div>');
    document.getElementById('logCount').textContent = sent + ' terkirim';
    toast('Demo UI — ' + groups.length + ' broadcast "dikirim" ke Telegram Bot API.');
  });

  document.getElementById('btnClear').addEventListener('click', function(){
    document.getElementById('message').value = '';
    document.querySelectorAll('#groups input:checked').forEach(function(c){ c.checked = false; });
    refreshNote();
  });

  /* ---------- tour guide ---------- */
  var tommanTelegramTour = {
    id: 'tomman-telegram',
    steps: [
      {
        target: '#groups',
        pos: 'right',
        title: 'Pemilihan Grup Telegram Target',
        desc: 'Pilih satu atau beberapa grup Telegram sektor maupun channel eskalasi ops room yang akan menerima pesan siaran.'
      },
      {
        target: '.tpl-btns',
        pos: 'bottom',
        title: 'Template Pesan Siaran Cepat',
        desc: 'Gunakan template siap pakai untuk Dispatch WO harian, Eskalasi tiket melewati SLA, atau rekap Absen Pagi regu lapangan.'
      },
      {
        target: '#message',
        pos: 'top',
        title: 'Editor Pesan Broadcast',
        desc: 'Ketik pesan atau modifikasi draft template telegram yang akan disiarkan kepada personil atau grup koordinasi lapangan.'
      },
      {
        target: '#btnKirim',
        pos: 'top',
        title: 'Kirim Broadcast ke Bot Telegram',
        desc: 'Klik tombol ini untuk mengeksekusi pengiriman pesan siaran serentak ke API Telegram Bot.'
      },
      {
        target: '#log',
        pos: 'left',
        title: 'Log Riwayat Pengiriman Bot',
        desc: 'Pantau status transmisi API (200 OK), timestamp WITA, target channel, dan cuplikan pesan yang berhasil dikirimkan.'
      }
    ]
  };

  setTimeout(function(){
    TommanTour.start(tommanTelegramTour);
  }, 450);
</script>

@include('project.tomman.feature.partials.tour-guide')
</body>
</html>
