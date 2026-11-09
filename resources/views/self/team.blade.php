@verbatim
<section id="team">
  <div class="wrap">
    <div class="sec-head">
      <span class="sec-badge"><span class="sec-badge-dot"></span> {{ t.teamBadge }}</span>
      <h2>{{ t.teamTitle }}</h2>
      <p>{{ t.teamSubtitle }}</p>
    </div>

    <!-- Team Photos Bento Grid -->
    <div class="team-grid">
      <div 
        v-for="(photo, pIdx) in teamPhotos" 
        :key="photo.id"
        class="team-card reveal from-up"
        :class="{ 'featured': photo.featured }"
        @click="openTeamPhoto(photo, pIdx)"
        tabindex="0"
        @keydown.enter="openTeamPhoto(photo, pIdx)"
        role="button"
        :aria-label="photo.title[lang]"
      >
        <div class="team-thumb-box">
          <img :src="photo.src" :alt="photo.title[lang]" class="team-thumb-img" loading="lazy" />
          <div class="team-thumb-overlay">
            <span class="team-view-badge">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
              {{ t.teamZoomBtn }}
            </span>
          </div>
          <span class="team-date-badge mono">{{ photo.date[lang] }}</span>
          <span class="team-tag-badge">{{ photo.tag[lang] }}</span>
        </div>
        <div class="team-card-body">
          <div class="team-card-org">
            <span class="dot"></span>
            <span>{{ photo.org }}</span>
          </div>
          <h4 class="team-card-title">{{ photo.title[lang] }}</h4>
          <p class="team-card-desc">{{ photo.desc[lang] }}</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Lightbox Modal for Team Photos -->
  <transition name="modal-fade">
    <div class="team-modal-backdrop" v-if="previewTeamPhoto" v-cloak @click.self="closeTeamPhoto">
      <div class="team-modal-dialog" role="dialog" aria-modal="true" :aria-label="previewTeamPhoto.title[lang]">
        <!-- Modal Header -->
        <div class="team-modal-header">
          <div class="team-modal-title-group">
            <div class="team-modal-badges">
              <span class="team-tag-badge">{{ previewTeamPhoto.tag[lang] }}</span>
              <span class="team-modal-org">{{ previewTeamPhoto.org }}</span>
              <span class="team-modal-date mono">{{ previewTeamPhoto.date[lang] }}</span>
            </div>
            <h3 class="team-modal-title">{{ previewTeamPhoto.title[lang] }}</h3>
          </div>
          <button type="button" class="modal-close-btn" @click="closeTeamPhoto" :aria-label="t.teamCloseBtn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
          </button>
        </div>

        <!-- Modal Body Image with Navigation Arrows -->
        <div class="team-modal-body">
          <button 
            type="button" 
            class="team-modal-nav-btn prev" 
            @click.stop="prevTeamPhoto" 
            :title="t.teamPrevBtn" 
            aria-label="Foto Sebelumnya"
          >
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          </button>
          <div class="team-modal-img-wrap">
            <img :src="previewTeamPhoto.src" :alt="previewTeamPhoto.title[lang]" class="team-modal-img" />
          </div>
          <button 
            type="button" 
            class="team-modal-nav-btn next" 
            @click.stop="nextTeamPhoto" 
            :title="t.teamNextBtn" 
            aria-label="Foto Selanjutnya"
          >
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>

        <!-- Modal Footer / Caption -->
        <div class="team-modal-footer">
          <p class="team-modal-caption">{{ previewTeamPhoto.desc[lang] }}</p>
          <div class="team-modal-counter mono">
            {{ previewTeamPhotoIdx + 1 }} / {{ teamPhotos.length }}
          </div>
        </div>
      </div>
    </div>
  </transition>
</section>
@endverbatim

<script>
window.TEAM_PHOTOS = [
  {
    id: "infranexia-team",
    src: "/images/fototim/photo_2025-11-03_11-16-59.jpg",
    org: "InfraNexia",
    featured: true,
    tag: { id: "Milestone Tim", en: "Team Milestone" },
    date: { id: "Nov 2025", en: "Nov 2025" },
    title: {
      id: "Kebersamaan & Milestone Tim Engineering InfraNexia",
      en: "InfraNexia Engineering Team Milestone & Celebration"
    },
    desc: {
      id: "Perayaan pencapaian milestone dan kekompakan tim pengembang platform digital telekomunikasi enterprise InfraNexia.",
      en: "Team gathering and milestone celebration commemorating progress across InfraNexia telecommunication enterprise platforms."
    }
  },
  {
    id: "dalapa-mobile",
    src: "/images/fototim/photo_2026-02-06_16-50-04.jpg",
    org: "InfraNexia",
    featured: false,
    tag: { id: "Showcase Fitur", en: "Feature Showcase" },
    date: { id: "Feb 2026", en: "Feb 2026" },
    title: {
      id: "Presentasi & Showcase DALAPA Mobile QE",
      en: "DALAPA Mobile QE Feature Showcase"
    },
    desc: {
      id: "Presentasi alur titik pemasangan material Quality Engineering (QE) pada aplikasi mobile DALAPA.",
      en: "Presentation and live walkthrough of the Quality Engineering (QE) material installation points on DALAPA Mobile."
    }
  },
  {
    id: "dalapa-sprint",
    src: "/images/fototim/photo_2026-07-30_11-16-38.jpg",
    org: "InfraNexia",
    featured: false,
    tag: { id: "Review Sistem", en: "System Review" },
    date: { id: "Jul 2026", en: "Jul 2026" },
    title: {
      id: "Review & Sprint Sistem DALAPA Asset Management",
      en: "DALAPA Asset Management Review & Sprint Session"
    },
    desc: {
      id: "Sesi diskusi teknis dan review live portal DALAPA Asset Management bersama rekan tim pengembang.",
      en: "Live technical review and sprint evaluation session on DALAPA Asset Management with fellow developers."
    }
  },
  {
    id: "telecom-sync",
    src: "/images/fototim/photo_2025-10-08_10-47-01.jpg",
    org: "InfraNexia",
    featured: false,
    tag: { id: "Model QA & KHS", en: "QA Model & KHS" },
    date: { id: "Okt 2025", en: "Oct 2025" },
    title: {
      id: "Pengembangan Modul QA & Pembahasan KHS Terbaru",
      en: "QA Model Development & Latest KHS Review"
    },
    desc: {
      id: "Diskusi teknis perancangan alur Quality Assurance (QA/QE), pembahasan skema Kontrak Harga Satuan (KHS) terbaru, serta pemodelan sistem anggaran.",
      en: "Technical session on Quality Assurance (QA/QE) workflows, review of the latest KHS (Unit Price Contract) framework, and budget system modeling."
    }
  },
  {
    id: "mathilda-run",
    src: "/images/fototim/photo_2025-08-02_08-26-17.jpg",
    org: "Team Activity",
    featured: false,
    tag: { id: "Team Building", en: "Team Building" },
    date: { id: "Ags 2025", en: "Aug 2025" },
    title: {
      id: "Finisher Bersama di Pertamina Mathilda Run 2025",
      en: "Pertamina Mathilda Run 2025 Finisher with Team"
    },
    desc: {
      id: "Menjaga kesehatan, sinergi, dan kekompakan tim di luar jam kerja melalui partisipasi di ajang lari Balikpapan.",
      en: "Fostering synergy, health, and team spirit through community running and sports events in Balikpapan."
    }
  }
];

Object.assign(I18N.en, {
  teamBadge: "Workplace & Culture",
  teamTitle: "Engineering Sprints & Team Moments",
  teamSubtitle: "Documented moments of cross-functional development sprints, feature showcases, and team synergy in Balikpapan.",
  teamZoomBtn: "View Photo",
  teamPrevBtn: "Previous photo",
  teamNextBtn: "Next photo",
  teamCloseBtn: "Close",
});

Object.assign(I18N.id, {
  teamBadge: "Budaya Kerja & Kolaborasi",
  teamTitle: "Dokumentasi Sprint & Momen Tim",
  teamSubtitle: "Momen nyata kolaborasi pengembangan sistem, presentasi fitur DALAPA, dan soliditas tim kerja di Balikpapan.",
  teamZoomBtn: "Perbesar Foto",
  teamPrevBtn: "Foto sebelumnya",
  teamNextBtn: "Foto selanjutnya",
  teamCloseBtn: "Tutup",
});
</script>

