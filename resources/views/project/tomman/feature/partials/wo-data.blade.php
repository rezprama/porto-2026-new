{{-- One shared dummy deck so Matrix, Monitoring WO, Assurance, Ticketing and Leaderboards all describe
     the same fictional day of operations. Every number comes from the deterministic seeded() hash —
     never Math.random() — so a re-render (or a filter change) never shuffles the figures under the user. --}}
<script>
  /* ---------- deterministic pseudo-random ---------- */
  function seeded(a, b){ return ((a * 73856093) ^ (b * 19349663)) >>> 0; }
  function pick(arr, a, b){ return arr[seeded(a, b) % arr.length]; }
  function between(lo, hi, a, b){ return lo + (seeded(a, b) % (hi - lo + 1)); }
  function pad(n, w){ var s = String(n); while (s.length < w) { s = '0' + s; } return s; }

  /* ---------- laporan_status: the real table is psb_laporan_status; ids and chip colours
       follow matrix.blade.php's branch ladder exactly ---------- */
  var STATUS = {
    1:  { name: 'UP',                   label: 'success'  },
    37: { name: 'UP (VALIDASI QC)',     label: 'success'  },
    5:  { name: 'ONGOING',              label: 'warning'  },
    4:  { name: 'BELUM SURVEY',         label: 'info'     },
    6:  { name: 'NO UPDATE',            label: 'default'  },
    7:  { name: 'PENDING HD',           label: 'darkgrey' },
    28: { name: 'MANJA HARI H',         label: 'bluepas'  },
    29: { name: 'MANJA H+',             label: 'bluepas'  },
    31: { name: 'KONFIRMASI ULANG',     label: 'purple'   },
    43: { name: 'CANCEL ORDER',         label: 'black'    },
    44: { name: 'REVOKE',               label: 'black'    },
    45: { name: 'UNSC SDI',             label: 'coklat'   },
    46: { name: 'RETUR MATERIAL',       label: 'coklat'   },
    50: { name: 'PS QRCODE',            label: 'golden'   },
    2:  { name: 'KENDALA ODP LOSS',     label: 'danger'   },
    11: { name: 'KENDALA INSERT TIANG', label: 'danger'   },
    12: { name: 'KENDALA PELANGGAN',    label: 'danger'   },
    16: { name: 'KENDALA TEKNIK',       label: 'danger'   },
    24: { name: 'KENDALA ODP FULL',     label: 'danger'   },
  };
  var STATUS_POOL = [1, 1, 1, 1, 37, 5, 5, 4, 6, 6, 7, 28, 29, 31, 43, 45, 50, 2, 11, 12, 16, 24];

  /* matrix.blade.php buckets every WO into exactly one of these four counters */
  function bucketOf(st){
    if (st === 6) { return 'NO_UPDATE'; }
    if (st === 5) { return 'PROGRESS'; }
    if (st === 1 || st === 37) { return 'UP'; }
    if (st === 4) { return 'NO_UPDATE'; }
    return 'KENDALA';
  }

  /* ---------- sektor / tim ---------- */
  var SEKTOR = [
    { key: 'BPN KOTA',    title: 'SEKTOR BALIKPAPAN KOTA',    jns: 'asr',  area: 'INNER' },
    { key: 'BPN UTARA',   title: 'SEKTOR BALIKPAPAN UTARA',   jns: 'asr',  area: 'OUTER' },
    { key: 'BPN SELATAN', title: 'SEKTOR BALIKPAPAN SELATAN', jns: 'asr',  area: 'INNER' },
    { key: 'PENAJAM',     title: 'SEKTOR PENAJAM',            jns: 'asr',  area: 'OUTER' },
    { key: 'PROV BPN',    title: 'SEKTOR PROVISIONING BPN',   jns: 'prov', area: 'INNER' },
  ];
  var MITRA = ['UPATEK', 'CUI', 'TELKOM AKSES', 'MITRATEL'];
  var STO = ['BPN', 'KRJ', 'BTK', 'SPG', 'GSR', 'MGR', 'PNJ'];
  var TEKNISI = [
    'AHMAD RIZALDI', 'BUDI SANTOSO', 'CANDRA WIJAYA', 'DEDI KURNIAWAN', 'EKO PRASETYO',
    'FAJAR NUGROHO', 'GUNAWAN SAPUTRA', 'HENDRA MAULANA', 'IRFAN HIDAYAT', 'JOKO SUSILO',
    'KURNIAWAN ADI', 'LUKMAN HAKIM', 'MUHAMMAD YUSUF', 'NANDA PRATAMA', 'OKTAVIAN RAMADHAN',
    'PANDU SETIAWAN', 'RIZKY FEBRIAN', 'SAMSUL ARIFIN', 'TAUFIK HIDAYAT', 'WAHYU UTOMO',
    'YUDHA PERMANA', 'ZAINAL ABIDIN', 'AGUS SALIM', 'BAMBANG TRIONO', 'DIMAS ARYA',
    'ERWIN SYAHPUTRA', 'FIKRI RAMADHAN', 'GILANG MAHENDRA', 'HARIS SETIAWAN', 'INDRA GUNAWAN',
    'JEFRI ANANDA', 'KRISNA WIBOWO',
  ];
  var PELANGGAN = [
    'SITI NURHALIZA', 'BAGAS PRASETYO', 'RATNA DEWI', 'HERMAN SUSANTO', 'LINDA MARLINA',
    'ANTON WIJAYA', 'DEWI LESTARI', 'RUDI HARTONO', 'MAYA SARI', 'IWAN SETIAWAN',
    'NOVITA RAHAYU', 'BASUKI RAHMAT', 'SRI WAHYUNI', 'TEGUH IMANTO', 'ELLA FITRIANI',
    'DARMAWAN PUTRA', 'RENI ANGGRAINI', 'SUGENG RIYADI', 'TIARA PUSPITA', 'ARIF BUDIMAN',
    'CV SUMBER REZEKI', 'PT BAHARI JAYA', 'KOPERASI MAKMUR', 'WARUNG BU TINI', 'HOTEL PESONA',
  ];
  var JALAN = [
    'JL. MT HARYONO', 'JL. SOEKARNO HATTA', 'JL. AHMAD YANI', 'JL. JENDERAL SUDIRMAN',
    'JL. MARSMA ISWAHYUDI', 'JL. SYARIFUDDIN YOES', 'JL. MULAWARMAN', 'JL. PROJAKAL',
    'JL. RUHUI RAHAYU', 'JL. STRAAT III', 'JL. PATTIMURA', 'JL. GUNUNG SARI ILIR',
  ];
  var JENIS = ['GANGGUAN', 'PSB', 'MIGRASI', 'CCAN', 'ASSIST'];
  var LAYANAN = ['INTERNET', 'INTERNET + IPTV', 'TRIPLE PLAY', 'VOICE', 'ASTINET'];
  var SEBAB = [
    'KABEL DROP PUTUS', 'REDAMAN TINGGI DI ODP', 'ONT TIDAK BOOTING', 'PATCHCORD KOTOR',
    'CONNECTOR LONGGAR', 'ODP TERENDAM AIR', 'TIANG MIRING TERTIMPA POHON', 'PORT ODP RUSAK',
  ];
  var SOLUSI = [
    'PENGGANTIAN DROPCORE 80M', 'CLEANING CONNECTOR + REDAMAN NORMAL', 'PENGGANTIAN ONT',
    'RE-SPLICING DI ODP', 'RELOKASI PORT ODP', 'PENGGANTIAN PATCHCORD', 'PERBAIKAN TIANG',
  ];

  /* ---------- tim: 3 regu per sektor, 15 regu total ---------- */
  var TIM = [];
  (function buildTim(){
    SEKTOR.forEach(function(s, si){
      for (var i = 0; i < 3; i++) {
        var h = seeded(si + 11, i + 7);
        TIM.push({
          uraian: s.key.replace(/ /g, '.') + '.' + pad(i + 1, 2),
          sektor: s.key,
          jns: s.jns,
          area: s.area,
          mitra: MITRA[h % MITRA.length],
          nik1: '9' + pad(between(100000, 999999, si + 3, i + 5), 6) + pad(si, 1),
          nik2: '9' + pad(between(100000, 999999, si + 9, i + 2), 6) + pad(i, 1),
          nama1: TEKNISI[(si * 3 + i * 2) % TEKNISI.length],
          nama2: TEKNISI[(si * 5 + i * 7 + 13) % TEKNISI.length],
          target_MH: s.jns === 'prov' ? 12 : 10,
          kemampuan: s.jns === 'prov' ? 12 : 10,
          hadir: (h % 9) !== 0,
        });
      }
    });
  })();

  /* ---------- workorder deck ---------- */
  var TODAY = new Date();
  /* the real app pins everything to WITA (layout.blade.php calls date_default_timezone_set('Asia/Makassar')),
     so date AND time must come out of the same Makassar formatter — never mix in the viewer's local clock */
  var WITA_DATE = new Intl.DateTimeFormat('sv-SE', { timeZone: 'Asia/Makassar' });
  var WITA_STAMP = new Intl.DateTimeFormat('sv-SE', {
    timeZone: 'Asia/Makassar', year: 'numeric', month: '2-digit', day: '2-digit',
    hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false,
  });
  function isoDate(d){ return WITA_DATE.format(d); }
  function stamp(hoursAgo){ return WITA_STAMP.format(new Date(TODAY.getTime() - hoursAgo * 3600000)); }

  var WOS = [];
  (function buildWo(){
    for (var i = 0; i < 118; i++) {
      var tim = TIM[seeded(i + 1, 17) % TIM.length];
      /* An order exists before anybody is sent to it. The real views key off id_r / uraian (the regu),
         NOT off the report status: empty regu renders a "Dispatch" chip, a filled one renders the team
         name plus "Re-Dispatch". So a slice of the deck has to carry no regu at all. */
      var undispatched = seeded(i, 163) % 8 === 0;
      var st = undispatched ? 6 : STATUS_POOL[seeded(i + 4, 29) % STATUS_POOL.length];
      var jenis = tim.jns === 'prov'
        ? pick(['PSB', 'MIGRASI', 'CCAN'], i + 2, 31)
        : pick(['GANGGUAN', 'GANGGUAN', 'GANGGUAN', 'ASSIST'], i + 2, 31);
      /* most of the book is same-day work, with a long tail of ageing tickets — that mix is what makes
         the matrix look like a real shift: dense today, a handful of >48h orders carrying a hot flag */
      var age = st === 1 || st === 37
        ? between(1, 12, i, 41)
        : (seeded(i, 43) % 10 < 7 ? between(1, 16, i, 41) : between(20, 78, i, 41));
      /* half the closed orders belong to an earlier shift, so the DATE filter on the matrix has
         something to find on previous days while today still carries the bulk of the board */
      var shift = (st === 1 || st === 37) && seeded(i, 151) % 2 === 0 ? between(1, 3, i, 157) * 24 : 0;
      var umur = age + shift;
      var dispatchAgo = shift + (age > 20 ? between(0, 7, i, 71) : Math.max(age - between(1, 4, i, 71), 0));
      var isGgn = jenis === 'GANGGUAN' || jenis === 'ASSIST';
      /* somewhere inland around Balikpapan, so the coordinate reads plausibly on a map link */
      var lat = (-1.24 - (seeded(i + 2, 101) % 700) / 10000).toFixed(6);
      var lng = (116.80 + (seeded(i + 5, 103) % 900) / 10000).toFixed(6);
      WOS.push({
        id: 'DT' + pad(480000 + i * 7, 6),
        tiket: (isGgn ? 'IN' : 'SC') + pad(between(1000000, 9999999, i + 6, 13), 7),
        jenis: jenis,
        layanan: pick(LAYANAN, i + 8, 19),
        status: st,
        tim: undispatched ? '' : tim.uraian,
        sektor: undispatched ? '' : tim.sektor,
        mitra: undispatched ? '' : tim.mitra,
        sto: pick(STO, i + 3, 23),
        pelanggan: PELANGGAN[seeded(i + 5, 37) % PELANGGAN.length],
        nd: '0542' + pad(between(100000, 999999, i + 7, 43), 6),
        inet: '1' + pad(between(10000000, 99999999, i + 11, 47), 8),
        alamat: pick(JALAN, i + 13, 53) + ' NO. ' + between(1, 180, i, 59) + ', BALIKPAPAN',
        odp: 'ODP-' + pick(STO, i + 3, 23) + '-' + pick(['FA', 'FB', 'FC', 'FD'], i, 61) + '/' + pad(between(1, 24, i, 67), 2),
        lat: lat,
        lng: lng,
        koor: lat + ',' + lng,
        olt_ip: '10.' + (14 + (seeded(i, 107) % 6)) + '.' + (seeded(i, 109) % 200) + '.1',
        olt: 'OLT-' + pick(STO, i + 3, 23) + '-D' + (1 + (seeded(i, 113) % 4)),
        umur: umur,
        open_at: stamp(umur),
        /* an ageing ticket gets re-dispatched, so it lands on today's matrix still carrying its full
           umur — that is exactly the case the hot.png flame marks in the real view */
        dispatch_at: undispatched ? '' : stamp(dispatchAgo),
        modified_at: st === 6 ? '' : stamp(Math.min(shift + Math.max(age - between(2, 6, i, 73), 0), dispatchAgo)),
        catatan: st === 6 ? '' : pick(SOLUSI, i + 2, 79),
        sebab: isGgn ? pick(SEBAB, i + 1, 83) : '',
        channel: seeded(i, 89) % 7 === 0 ? '6' : '',   /* channel 6 = MyIndiHome, gets the black outline */
        action: seeded(i, 97) % 5 === 0 ? 1 : 0,
      });
    }
  })();

  function statusName(st){ return (STATUS[st] || STATUS[6]).name; }
  function statusLabel(st){ return (STATUS[st] || STATUS[6]).label; }
  /* '' is the undispatched marker, so never let it match a regu */
  function woOf(tim){ return WOS.filter(function(w){ return tim && w.tim === tim; }); }

  /* What /dispatch/{orderId} does on save: fill in the regu (id_r / uraian) and stamp the dispatch
     time. The report status stays NO UPDATE — only the technician's own report moves it off 6. */
  function dispatchWo(tiket, timName, tanggal){
    var w = WOS.filter(function(x){ return x.tiket === tiket; })[0];
    var t = TIM.filter(function(x){ return x.uraian === timName; })[0];
    if (!w || !t) { return null; }
    w.tim = t.uraian;
    w.sektor = t.sektor;
    w.mitra = t.mitra;
    w.dispatch_at = tanggal + WITA_STAMP.format(new Date()).slice(10);
    return w;
  }
</script>
