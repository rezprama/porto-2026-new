<script>
  /* ---------- Shared dummy dataset for QE › New Project.
       One deck of workorders flows through every page (Listing → Approval TL → Approval QE →
       Approval Regional → Export), so a ticket seen on one screen shows up on the next with the
       same numbers. Values come from seeded() — never Math.random() — so they stay put on re-render. ---------- */

  var MONTHS = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
  var DISTRICTS = ['DISTRICT BALIKPAPAN', 'DISTRICT SAMARINDA', 'DISTRICT BANJARMASIN'];
  var STO_BY_DISTRICT = {
    'DISTRICT BALIKPAPAN': ['STO BALIKPAPAN KOTA', 'STO SEPINGGAN', 'STO KARANG JOANG'],
    'DISTRICT SAMARINDA': ['STO SAMARINDA KOTA', 'STO AIR PUTIH', 'STO PALARAN'],
    'DISTRICT BANJARMASIN': ['STO BANJARMASIN', 'STO KAYU TANGI'],
  };
  var MITRA = ['PT KARYA ABADI TELEKOM', 'PT NUSANTARA FIBER', 'PT BORNEO AKSES PRIMA'];
  var TEKNISI = ['Bagus Wicaksono', 'Andi Saputra', 'Putri Lestari', 'Dewi Anggraini', 'Rizal Maulana', 'Sinta Hapsari'];
  var PEMBUAT = ['Ulsyairil', 'Reza Pratama', 'Hendra Gunawan'];
  var PROJECTS = ['RECOVERY ODP 2026', 'GAMAS KABEL UDARA', 'RELOKASI ALPRO 2026', 'PENGGANTIAN TIANG 2026'];
  var HEADLINES = [
    'Gangguan massal kabel udara tertimpa pohon di ruas Jl. Soekarno Hatta',
    'ODP rusak akibat kecelakaan lalu lintas, 12 pelanggan terdampak',
    'Penggantian tiang miring rawan roboh di area perumahan',
    'Recovery kabel feeder putus akibat pekerjaan galian pihak ketiga',
    'Relokasi ODP terdampak pelebaran jalan kota',
    'Perbaikan closure bocor menyebabkan redaman tinggi',
  ];
  var LOPS = ['RECOVERY KABEL UDARA', 'PENGGANTIAN ODP', 'PENGGANTIAN TIANG', 'RECOVERY FEEDER', 'RELOKASI ALPRO', 'PERBAIKAN CLOSURE'];
  var PENYEBAB = ['Pohon tumbang', 'Kecelakaan lalu lintas', 'Galian pihak ketiga', 'Usia material', 'Pelebaran jalan', 'Cuaca ekstrem'];
  var KHS = [
    { d: 'TC-02', dj: 'PS-TC-02', u: 'Tiang Cor 7 Meter', s: 'BH', m: 1180000, j: 420000 },
    { d: 'BC-OF-SM-8', dj: 'PS-BC-8', u: 'Kabel Udara Optik 8 Core', s: 'MTR', m: 9800, j: 3600 },
    { d: 'BC-OF-SM-24', dj: 'PS-BC-24', u: 'Kabel Udara Optik 24 Core', s: 'MTR', m: 21500, j: 5200 },
    { d: 'PS-1-8', dj: 'PS-SPL-8', u: 'Pasang Splitter 1:8', s: 'BH', m: 720000, j: 180000 },
    { d: 'ODP-PB-8', dj: 'PS-ODP-8', u: 'ODP Pole Bracket 8 Port', s: 'BH', m: 1450000, j: 310000 },
    { d: 'SOC-1', dj: 'PS-SOC', u: 'Splice On Connector', s: 'BH', m: 42000, j: 18500 },
    { d: 'PU-S7.0-400', dj: 'PS-PU-400', u: 'Penarikan Kabel Udara s/d 400 Meter', s: 'MTR', m: 0, j: 5200 },
    { d: 'CL-24', dj: 'PS-CL-24', u: 'Closure 24 Core', s: 'BH', m: 980000, j: 240000 },
  ];

  /* the legacy workorder ladder, exactly the buckets the Monitoring matrix counts */
  var WO_STATUSES = ['LISTING', 'PROGRESS', 'COMPLETE', 'PENDING', 'APPROVE_TL', 'PENDING_TL', 'APPROVE_QE', 'PENDING_QE', 'APPROVE_REGIONAL'];
  var STATUS_LABEL = {
    LISTING: 'LISTING', PROGRESS: 'PROGRESS', COMPLETE: 'COMPLETE', PENDING: 'PENDING',
    APPROVE_TL: 'APPROVE TL', PENDING_TL: 'PENDING TL', APPROVE_QE: 'APPROVE QE', PENDING_QE: 'PENDING QE',
    APPROVE_REGIONAL: 'APPROVE REGIONAL',
  };
  var STATUS_PILL = {
    LISTING: 'pill-gray', PROGRESS: 'pill-blue', COMPLETE: 'pill-amber', PENDING: 'pill-red',
    APPROVE_TL: 'pill-teal', PENDING_TL: 'pill-red', APPROVE_QE: 'pill-green', PENDING_QE: 'pill-red',
    APPROVE_REGIONAL: 'pill-green',
  };
  /* how far along the ladder a status sits — lets each page ask "has TL signed this off yet?" */
  var STATUS_RANK = { LISTING: 0, PROGRESS: 1, COMPLETE: 2, PENDING: 2, PENDING_TL: 2, APPROVE_TL: 3, PENDING_QE: 3, APPROVE_QE: 4, APPROVE_REGIONAL: 5 };

  function seeded(a, b){ return ((a * 73856093) ^ (b * 19349663)) >>> 0; }
  function pad2(n){ return String(n).padStart(2, '0'); }
  function statusPill(st){ return '<span class="pill ' + STATUS_PILL[st] + '">' + STATUS_LABEL[st] + '</span>'; }
  function rank(st){ return STATUS_RANK[st]; }

  var WOS = [];
  (function(){
    /* spread the deck across every rung of the ladder so each screen has something to show */
    var plan = ['LISTING', 'LISTING', 'PROGRESS', 'PROGRESS', 'COMPLETE', 'COMPLETE', 'COMPLETE', 'PENDING',
      'APPROVE_TL', 'APPROVE_TL', 'APPROVE_TL', 'PENDING_TL', 'APPROVE_QE', 'APPROVE_QE', 'PENDING_QE', 'APPROVE_REGIONAL'];
    for (var i = 0; i < 44; i++) {
      var s = seeded(i + 1, 7);
      var status = plan[i % plan.length];
      var district = DISTRICTS[i % DISTRICTS.length];
      var stoList = STO_BY_DISTRICT[district];
      var lines = [];
      for (var k = 0; k < 3 + (s % 3); k++) {
        var khs = KHS[(i + k * 3) % KHS.length];
        lines.push({ khs: khs, qty: 1 + ((s >> (k * 3)) % 14) });
      }
      var listingDay = 1 + (i % 12);
      var compDay = listingDay + 2 + (s % 4);
      var tlDay = compDay + 1 + (s % 3);
      var qeDay = tlDay + 1 + (s % 3);
      var regDay = qeDay + 2;
      WOS.push({
        id: i,
        district: district,
        sto: stoList[i % stoList.length],
        stoWorkzone: stoList[i % stoList.length].replace('STO ', 'WZ '),
        ticket: 'IN' + (26090000 + i * 313),
        headline: HEADLINES[i % HEADLINES.length],
        lop: LOPS[i % LOPS.length],
        project: PROJECTS[i % PROJECTS.length],
        pekerjaan: LOPS[i % LOPS.length] + ' ' + stoList[i % stoList.length].replace('STO ', ''),
        penyebab: PENYEBAB[i % PENYEBAB.length],
        mitra: MITRA[i % MITRA.length],
        team: 'TIM ' + String.fromCharCode(65 + (i % 6)) + '-' + (1 + (i % 4)),
        teknisi: TEKNISI[i % TEKNISI.length],
        pembuat: PEMBUAT[i % PEMBUAT.length],
        month: 8,
        year: 2026,
        koordinat: (-1.2 - (i % 9) * 0.031).toFixed(6) + ', ' + (116.83 + (i % 7) * 0.043).toFixed(6),
        surat: {
          no: 'TEL.' + (120 + i) + '/QE-KTI/2026',
          judul: 'Permohonan pekerjaan ' + LOPS[i % LOPS.length].toLowerCase(),
          pengirim: PEMBUAT[i % PEMBUAT.length],
          tgl: '2026-09-' + pad2(Math.max(1, listingDay - 1)),
        },
        tglListing: '2026-09-' + pad2(listingDay),
        tglTeknisi: rank(status) >= 2 ? '2026-09-' + pad2(compDay) + ' ' + pad2(8 + (i % 9)) + ':' + pad2(10 + (i % 49)) : '',
        tglTl: rank(status) >= 3 ? '2026-09-' + pad2(tlDay) + ' 16:' + pad2(10 + (i % 49)) : '',
        tglQe: rank(status) >= 4 ? '2026-09-' + pad2(qeDay) + ' 10:' + pad2(5 + (i % 50)) : '',
        tglRegional: rank(status) >= 5 ? '2026-09-' + pad2(regDay) + ' 09:' + pad2(5 + (i % 50)) : '',
        reportedDate: '2026-09-' + pad2(Math.max(1, listingDay - 1)) + ' 07:' + pad2(5 + (i % 50)),
        resolveDate: rank(status) >= 2 ? '2026-09-' + pad2(compDay) + ' ' + pad2(13 + (i % 6)) + ':' + pad2(5 + (i % 50)) : '',
        status: status,
        note: status === 'PENDING_TL' ? 'Evidence after belum sesuai, mohon dilengkapi.'
          : status === 'PENDING_QE' ? 'Volume kabel melebihi KHS, perlu dikoreksi.'
          : status === 'PENDING' ? 'Menunggu material dari gudang.' : '',
        lines: lines,
      });
    }
  })();

  function woMaterial(wo){ return wo.lines.reduce(function(sum, l){ return sum + l.khs.m * l.qty; }, 0); }
  function woJasa(wo){ return wo.lines.reduce(function(sum, l){ return sum + l.khs.j * l.qty; }, 0); }
  function woTotal(wo){ return woMaterial(wo) + woJasa(wo); }

  function stamp(){
    var now = new Date();
    return new Intl.DateTimeFormat('sv-SE', { timeZone: 'Asia/Makassar' }).format(now) + ' ' +
      new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Asia/Makassar' }).format(now);
  }

  /* fills a <select> with an "all" option plus the given values */
  function fillSelect(el, values, allLabel){
    el.innerHTML = '<option value="">' + (allLabel || t('all')) + '</option>' +
      values.map(function(v){ return '<option>' + v + '</option>'; }).join('');
  }

  /* shared pager renderer: returns the page slice and paints #pageInfo / #pager */
  function paginate(rows, page, per, onGo){
    var totalPages = Math.max(1, Math.ceil(rows.length / per));
    if (page > totalPages) { page = totalPages; }
    var start = (page - 1) * per;
    var slice = rows.slice(start, start + per);
    var from = rows.length ? start + 1 : 0, to = Math.min(start + per, rows.length);
    document.getElementById('pageInfo').textContent = from + '–' + to + ' ' + t('of') + ' ' + rows.length;
    var pager = document.getElementById('pager');
    pager.innerHTML = '';
    for (var p = 1; p <= totalPages; p++) {
      var btn = document.createElement('button');
      btn.textContent = p;
      if (p === page) { btn.classList.add('on'); }
      (function(pp){ btn.addEventListener('click', function(){ onGo(pp); }); })(p);
      pager.appendChild(btn);
    }
    return { slice: slice, page: page };
  }
</script>
