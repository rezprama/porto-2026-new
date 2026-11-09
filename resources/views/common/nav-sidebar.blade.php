@verbatim
<!-- FLOATING AUTO-MAXIMIZING SIDEBAR -->
<aside class="nav-rail" aria-label="Quick Navigation">
  <div class="nav-rail-header">
    <span class="dot"></span>
    <span class="title">{{ t.navHeader }}</span>
  </div>
  <ul class="nav-rail-list">
    <li v-for="item in navItems" :key="item.id">
      <button 
        type="button" 
        class="nav-rail-btn" 
        :class="{ active: activeSection === item.id }" 
        @click="goToSection(item.id)" 
        :title="t.nav[item.id]"
      >
        <span class="nav-icon" v-html="item.icon"></span>
        <span class="nav-label">
          <span class="nav-num mono">{{ item.num }}</span>
          <span class="nav-text">{{ t.nav[item.id] }}</span>
        </span>
      </button>
    </li>
  </ul>
</aside>
@endverbatim

<script>
window.NAV_ITEMS = [
  {
    id: "hero",
    num: "00",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>'
  },
  {
    id: "exp",
    num: "01",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>'
  },
  {
    id: "skills",
    num: "02",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>'
  },
  {
    id: "certifications",
    num: "03",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>'
  },
  {
    id: "project",
    num: "04",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>'
  },
  {
    id: "team",
    num: "05",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
  },
  {
    id: "contact",
    num: "06",
    icon: '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>'
  }
];

Object.assign(I18N.en, {
  navHeader: "Navigation",
  nav: {
    hero: "Profile",
    exp: "Experience",
    skills: "Skills & Edu",
    certifications: "Certificates",
    project: "Project List",
    team: "Team Moments",
    contact: "Contact"
  }
});

Object.assign(I18N.id, {
  navHeader: "Navigasi",
  nav: {
    hero: "Profil",
    exp: "Pengalaman",
    skills: "Keahlian & Edu",
    certifications: "Sertifikasi",
    project: "Daftar Proyek",
    team: "Galeri Tim",
    contact: "Kontak"
  }
});
</script>
