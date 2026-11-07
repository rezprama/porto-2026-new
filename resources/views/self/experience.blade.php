@verbatim
<section id="exp">
  <div class="wrap">
    <div class="sec-head">
      <span class="sec-badge"><span class="sec-badge-dot"></span> {{ t.expBadge }}</span>
      <h2>{{ t.expSection }}</h2>
      <p>{{ t.expSectionSub }}</p>
    </div>
    <div class="timeline">
      <div class="tl reveal" :class="i%2===0 ? 'from-left' : 'from-right'" v-for="(e,i) in t.experience" :key="e.org">
        <div class="when">{{ e.when }}</div>
        <div>
          <div class="tl-head">
            <div class="tl-logo-box" v-if="e.logo">
              <img :src="e.logo" :alt="e.org" class="tl-logo-img" />
            </div>
            <div>
              <div class="org">{{ e.org }}<span class="tag" v-if="e.tag">{{ e.tag }}</span></div>
              <div class="rl">{{ e.role }}</div>
            </div>
          </div>
          <div class="desc">{{ e.desc }}</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endverbatim

<script>
Object.assign(I18N.en, {
  expBadge:"Career History",
  expSection:"Professional Experience",
  expSectionSub:"Enterprise engineering track record across telecommunication and network management systems.",
  experience:[
    {when:"2026 — Present",org:"InfraNexia",logo:"/images/fotopengalaman/infranexia.png",role:"Full-Stack Developer",tag:"current",
      desc:"Developing the DALAPA platform: internal web tools, analytics dashboards, and workflow automation for telecom and network operations."},
    {when:"2020 — 2025",org:"Telkom Indonesia — Regional Access Management (RAM)",logo:"/images/fotopengalaman/telkom-indonesia.png",role:"IT Support & Full-Stack Developer · Regional 4",
      desc:"Built internal web tools for operational monitoring and reporting. Served as lead developer for Tomman and developed core DALAPA modules covering Assurance, QE, and NE."},
    {when:"2018",org:"Telkom Akses Balikpapan",logo:"/images/fotopengalaman/telkom-akses.png",role:"IT Help Desk Intern (Data Management)",
      desc:"Help desk support and operational data management: resolving user requests, maintaining network asset logs, and preparing regional reports."},
  ],
});
Object.assign(I18N.id, {
  expBadge:"Riwayat Karir",
  expSection:"Pengalaman Profesional",
  expSectionSub:"Rekam jejak rekayasa perangkat lunak enterprise pada sektor telekomunikasi dan operasional jaringan.",
  experience:[
    {when:"2026 — Sekarang",org:"InfraNexia",logo:"/images/fotopengalaman/infranexia.png",role:"Full-Stack Developer",tag:"terkini",
      desc:"Mengembangkan platform DALAPA: aplikasi web internal, dashboard analitik, dan otomatisasi alur kerja untuk kebutuhan operasi telekomunikasi dan jaringan."},
    {when:"2020 — 2025",org:"Telkom Indonesia — Regional Access Management (RAM)",logo:"/images/fotopengalaman/telkom-indonesia.png",role:"IT Support & Full-Stack Developer · Regional 4",
      desc:"Membangun aplikasi web internal untuk pemantauan operasional dan pelaporan. Menjadi lead developer untuk Tomman serta mengembangkan modul inti DALAPA mencakup Assurance, QE, dan NE."},
    {when:"2018",org:"Telkom Akses Balikpapan",logo:"/images/fotopengalaman/telkom-akses.png",role:"IT Help Desk Intern (Manajemen Data)",
      desc:"Dukungan help desk dan tata kelola data operasional: menangani permintaan pengguna, pembaruan data aset jaringan, serta penyusunan laporan rutin tingkat regional."},
  ],
});
</script>
