@verbatim
<section id="certifications">
  <div class="wrap">
    <div class="sec-head">
      <span class="sec-badge"><span class="sec-badge-dot"></span> {{ t.certBadge }}</span>
      <h2>{{ t.certSection }}</h2>
      <p>{{ t.certSectionSub }}</p>
    </div>

    <!-- Category Filter Controls -->
    <div class="cert-filters">
      <button 
        type="button" 
        class="cert-filter-btn" 
        :class="{ active: certFilter === 'all' }" 
        @click="certFilter = 'all'"
      >
        <span>{{ t.certFilterAll }}</span>
        <span class="count mono">{{ certificates.length }}</span>
      </button>

      <button 
        type="button" 
        class="cert-filter-btn" 
        :class="{ active: certFilter === 'python' }" 
        @click="certFilter = 'python'"
      >
        <span>Python & Data</span>
        <span class="count mono">{{ countCategory('python') }}</span>
      </button>

      <button 
        type="button" 
        class="cert-filter-btn" 
        :class="{ active: certFilter === 'marketing' }" 
        @click="certFilter = 'marketing'"
      >
        <span>Google Digital Marketing</span>
        <span class="count mono">{{ countCategory('marketing') }}</span>
      </button>

      <button 
        type="button" 
        class="cert-filter-btn" 
        :class="{ active: certFilter === 'professional' }" 
        @click="certFilter = 'professional'"
      >
        <span>{{ t.certFilterProf }}</span>
        <span class="count mono">{{ countCategory('professional') }}</span>
      </button>
    </div>

    <!-- Certificates Grid -->
    <div class="cert-grid">
      <div 
        v-for="(c, idx) in displayedCertificates" 
        :key="c.id" 
        class="cert-card reveal from-up"
        :class="{ 'cert-featured': c.highlight }"
      >
        <!-- Thumbnail Cover with Zoom & Lightbox Trigger -->
        <div class="cert-thumb-box" @click="openCertPreview(c)" :title="t.clickToEnlarge">
          <img :src="c.thumb" :alt="c.title" class="cert-thumb-img" loading="lazy" />
          <div class="cert-thumb-overlay">
            <span class="cert-view-badge">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              {{ t.previewBadge }}
            </span>
          </div>
          <span class="cert-type-pill" :class="'pill-' + c.category">{{ c.badge }}</span>
        </div>

        <!-- Card Content -->
        <div class="cert-body">
          <div class="cert-meta-top">
            <span class="cert-issuer">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
              {{ c.issuer }}
            </span>
            <span class="cert-date mono">{{ c.date }}</span>
          </div>

          <h3 class="cert-title" :title="c.title">{{ c.title }}</h3>

          <div class="cert-credential mono" v-if="c.credential_id">
            <span class="lbl">ID:</span>
            <span class="val">{{ c.credential_id }}</span>
          </div>

          <!-- Skills Chips -->
          <div class="chips cert-skills">
            <span class="sk" v-for="s in c.skills" :key="s">{{ s }}</span>
          </div>

          <!-- Action Buttons -->
          <div class="cert-actions">
            <a :href="c.pdf_url" target="_blank" rel="noopener" class="cert-btn pdf-btn" :title="t.openPdfTitle">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
              <span>{{ t.viewPdf }}</span>
            </a>

            <a v-if="c.verify_url" :href="c.verify_url" target="_blank" rel="noopener" class="cert-btn verify-btn" :title="t.verifyTitle">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
              <span>{{ t.verifyCredential }}</span>
            </a>

            <button type="button" class="cert-btn ghost-btn" @click="openCertPreview(c)" :title="t.clickToEnlarge">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Read More / Read Less Toggle Button -->
    <div class="cert-more-wrap" v-if="filteredCertificates.length > certLimit">
      <button 
        type="button" 
        class="cert-more-btn" 
        @click="toggleCertsExpanded"
      >
        <span v-if="!showAllCerts" style="display:inline-flex;align-items:center;gap:8px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m8 12 4 4 4-4"/><path d="M12 8v8"/></svg>
          {{ t.showMoreCerts }} (+{{ filteredCertificates.length - certLimit }})
        </span>
        <span v-else style="display:inline-flex;align-items:center;gap:8px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m16 12-4-4-4 4"/><path d="M12 16V8"/></svg>
          {{ t.showLessCerts }}
        </span>
      </button>
    </div>
  </div>

  <!-- CERTIFICATE LIGHTBOX MODAL -->
  <transition name="modal-fade">
    <div class="cert-modal-backdrop" v-if="previewCert" v-cloak @click.self="closeCertPreview">
      <div class="cert-modal-dialog" role="dialog" aria-modal="true">
        <div class="cert-modal-header">
          <div class="cert-modal-title-group">
            <span class="cert-modal-badge">{{ previewCert.badge }}</span>
            <h3 class="cert-modal-title">{{ previewCert.title }}</h3>
            <div class="cert-modal-meta">
              <span>{{ previewCert.issuer }}</span> · <span class="mono">{{ previewCert.date }}</span>
              <span v-if="previewCert.credential_id"> · <span class="mono">ID: {{ previewCert.credential_id }}</span></span>
            </div>
          </div>
          <button type="button" class="modal-close-btn" @click="closeCertPreview" aria-label="Close">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="cert-modal-body">
          <div class="cert-modal-img-wrap">
            <img :src="previewCert.thumb" :alt="previewCert.title" class="cert-modal-full-img" />
          </div>
        </div>

        <div class="cert-modal-footer">
          <a :href="previewCert.pdf_url" target="_blank" rel="noopener" class="btn primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            {{ t.openFullPdf }}
          </a>

          <a v-if="previewCert.verify_url" :href="previewCert.verify_url" target="_blank" rel="noopener" class="btn ghost">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            {{ t.verifyOnline }}
          </a>

          <button type="button" class="btn ghost" @click="closeCertPreview">
            {{ t.closeModal }}
          </button>
        </div>
      </div>
    </div>
  </transition>
</section>
@endverbatim

<script>
window.CERTIFICATES = [
  {
    id: "py-specialization",
    title: "Python for Everybody Specialization",
    category: "python",
    issuer: "University of Michigan · Coursera",
    issuer_short: "Univ. of Michigan",
    date: "Feb 2025",
    credential_id: "R58K6ER96232",
    verify_url: "https://coursera.org/verify/specialization/R58K6ER96232",
    pdf_url: "/images/sertifikat/Coursera PY 6.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_PY_6.jpg",
    highlight: true,
    badge: "Specialization (5 Courses)",
    skills: ["Python", "Data Structures", "Web Scraping", "Databases (SQL)", "Data Visualization"]
  },
  {
    id: "py-capstone",
    title: "Capstone: Retrieving, Processing, and Visualizing Data with Python",
    category: "python",
    issuer: "University of Michigan · Coursera",
    issuer_short: "Univ. of Michigan",
    date: "Feb 2025",
    credential_id: "QA733M3BFX1K",
    verify_url: "https://coursera.org/verify/QA733M3BFX1K",
    pdf_url: "/images/sertifikat/Coursera PY 5.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_PY_5.jpg",
    highlight: false,
    badge: "With Honors",
    skills: ["Data Pipelines", "JSON/XML APIs", "SQLite", "D3.js Visualization"]
  },
  {
    id: "py-databases",
    title: "Using Databases with Python",
    category: "python",
    issuer: "University of Michigan · Coursera",
    issuer_short: "Univ. of Michigan",
    date: "Jan 2025",
    credential_id: "X1NBJLX9KODX",
    verify_url: "https://coursera.org/verify/X1NBJLX9KODX",
    pdf_url: "/images/sertifikat/Coursera PY 4.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_PY_4.jpg",
    highlight: false,
    badge: "Course Certificate",
    skills: ["SQL", "SQLite3", "Data Models", "Relational Database"]
  },
  {
    id: "py-web-data",
    title: "Using Python to Access Web Data",
    category: "python",
    issuer: "University of Michigan · Coursera",
    issuer_short: "Univ. of Michigan",
    date: "Jan 2025",
    credential_id: "QQKDRNSYX4LB",
    verify_url: "https://coursera.org/verify/QQKDRNSYX4LB",
    pdf_url: "/images/sertifikat/Coursera PY 3.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_PY_3.jpg",
    highlight: false,
    badge: "Course Certificate",
    skills: ["Web Scraping", "REST APIs", "BeautifulSoup", "JSON Parsing"]
  },
  {
    id: "py-data-structures",
    title: "Python Data Structures",
    category: "python",
    issuer: "University of Michigan · Coursera",
    issuer_short: "Univ. of Michigan",
    date: "Dec 2024",
    credential_id: "ZJMH2B1JS9OE",
    verify_url: "https://coursera.org/verify/ZJMH2B1JS9OE",
    pdf_url: "/images/sertifikat/Coursera PY 2.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_PY_2.jpg",
    highlight: false,
    badge: "Course Certificate",
    skills: ["Data Structures", "Lists & Dictionaries", "Tuples", "File I/O"]
  },
  {
    id: "py-intro",
    title: "Programming for Everybody (Getting Started with Python)",
    category: "python",
    issuer: "University of Michigan · Coursera",
    issuer_short: "Univ. of Michigan",
    date: "Nov 2024",
    credential_id: "6P8CCUG98J4Q",
    verify_url: "https://coursera.org/verify/6P8CCUG98J4Q",
    pdf_url: "/images/sertifikat/Coursera PY 1.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_PY_1.jpg",
    highlight: false,
    badge: "Course Certificate",
    skills: ["Python Fundamentals", "Algorithms", "Control Flow", "Functions"]
  },
  {
    id: "google-dm-1",
    title: "Foundations of Digital Marketing and E-commerce",
    category: "marketing",
    issuer: "Google · Coursera",
    issuer_short: "Google",
    date: "Nov 2023",
    credential_id: "Z7EXSFMBB8VY",
    verify_url: "https://coursera.org/verify/Z7EXSFMBB8VY",
    pdf_url: "/images/sertifikat/Coursera DM 1.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_DM_1.jpg",
    highlight: false,
    badge: "Google Career Certificate",
    skills: ["Digital Marketing", "E-Commerce Strategy", "Customer Funnels"]
  },
  {
    id: "google-dm-2",
    title: "Attract and Engage Customers with Digital Marketing",
    category: "marketing",
    issuer: "Google · Coursera",
    issuer_short: "Google",
    date: "Jan 2024",
    credential_id: "2TVQTWTMJMPR",
    verify_url: "https://coursera.org/verify/2TVQTWTMJMPR",
    pdf_url: "/images/sertifikat/Coursera DM 2.pdf",
    thumb: "/images/sertifikat/thumbnails/Coursera_DM_2.jpg",
    highlight: false,
    badge: "Google Career Certificate",
    skills: ["Search Engine Optimization (SEO)", "Search Ads", "Audience Engagement"]
  },
  {
    id: "k3-sierra",
    title: "Pemahaman Sistem Manajemen Keselamatan dan Kesehatan Kerja (SMK3 - PP. No. 50/2012)",
    category: "professional",
    issuer: "PT Sierra Bisnis Konsulting",
    issuer_short: "Sierra Consulting",
    date: "Sep 2020",
    credential_id: "01197/SBK-HS04/A.IX/20",
    verify_url: "",
    pdf_url: "/images/sertifikat/REZA PRATAMA, S.Si.Kom. (1).pdf",
    thumb: "/images/sertifikat/thumbnails/REZA_PRATAMA__S_Si_Kom___1.jpg",
    highlight: false,
    badge: "Pelatihan Profesional K3",
    skills: ["K3 (SMK3)", "Regulasi PP 50/2012", "Keselamatan Kerja Lapangan"]
  },
  {
    id: "telkom-ldk",
    title: "Certificate of Completion — Staff Departemen Finance Pusat",
    category: "professional",
    issuer: "Universitas Telkom · LDK Al-Fath",
    issuer_short: "Telkom University",
    date: "Des 2018",
    credential_id: "SRT-027/ALFATH-UNITEL/XII/2018",
    verify_url: "",
    pdf_url: "/images/sertifikat/Reza Pratama (1).pdf",
    thumb: "/images/sertifikat/thumbnails/Reza_Pratama__1.jpg",
    highlight: false,
    badge: "Organisasi Kampus",
    skills: ["Finance & Budgeting", "Manajemen Organisasi", "Tata Kelola Keuangan"]
  },
  {
    id: "nyic-unair",
    title: "Finalis Lomba National Youth Innovation Competition (NYIC) 2016",
    category: "professional",
    issuer: "Fakultas Ekonomi & Bisnis Universitas Airlangga",
    issuer_short: "Universitas Airlangga",
    date: "Nov 2016",
    credential_id: "304/A.3/NYIC-WEFD/WEBS/X/2016",
    verify_url: "",
    pdf_url: "/images/sertifikat/Sertifikat lomba NYIC.pdf",
    thumb: "/images/sertifikat/thumbnails/Sertifikat_lomba_NYIC.jpg",
    highlight: false,
    badge: "Kompetisi Nasional",
    skills: ["Inovasi Bisnis", "Kompetisi Mahasiswa", "Kewirausahaan Kreatif"]
  }
];

Object.assign(I18N.en, {
  certBadge: "Credentials",
  certSection: "Licenses & Certifications",
  certSectionSub: "Verified professional credentials, software engineering specializations, and honors",
  certFilterAll: "All",
  certFilterProf: "Professional & Honors",
  clickToEnlarge: "Click to preview certificate",
  previewBadge: "Preview",
  viewPdf: "View PDF",
  openPdfTitle: "Open original PDF document in new tab",
  verifyCredential: "Verify Online",
  verifyTitle: "Verify certificate credential online",
  openFullPdf: "Open Original PDF",
  verifyOnline: "Verify on Coursera",
  closeModal: "Close",
  showMoreCerts: "Show More Certificates",
  showLessCerts: "Show Less"
});

Object.assign(I18N.id, {
  certBadge: "Kredensial Resmi",
  certSection: "Lisensi & Sertifikasi",
  certSectionSub: "Kredensial profesional terverifikasi, spesialisasi rekayasa perangkat lunak, dan penghargaan",
  certFilterAll: "Semua",
  certFilterProf: "Profesional & Penghargaan",
  clickToEnlarge: "Klik untuk memperbesar sertifikat",
  previewBadge: "Pratinjau",
  viewPdf: "Lihat PDF",
  openPdfTitle: "Buka dokumen PDF asli di tab baru",
  verifyCredential: "Verifikasi",
  verifyTitle: "Verifikasi kredensial sertifikat secara online",
  openFullPdf: "Buka Dokumen PDF Asli",
  verifyOnline: "Verifikasi di Coursera",
  closeModal: "Tutup",
  showMoreCerts: "Tampilkan Lebih Banyak",
  showLessCerts: "Tampilkan Lebih Sedikit"
});
</script>
