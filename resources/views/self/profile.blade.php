@verbatim
<!-- HERO -->
<div class="hero" id="hero">
  <!-- Subtle Ambient Glow (Replaces rigid wavy lines for visual comfort) -->
  <div class="hero-glow" aria-hidden="true"></div>

  <div class="wrap hero-content">
    <div class="hero-layout">
      <!-- Left Column: Introduction & Value Proposition -->
      <div class="hero-intro reveal from-left">
        <div class="status-pill">
          <span class="status-dot-wrap">
            <span class="status-dot-ping"></span>
            <span class="status-dot-core"></span>
          </span>
          <span>{{ t.statusBadge }}</span>
          <span class="status-sep">·</span>
          <span class="status-loc">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 21s-7-4.35-7-10a7 7 0 0 1 14 0c0 5.65-7 10-7 10z"/><circle cx="12" cy="11" r="2.5"/></svg>
            {{ t.location }}
          </span>
        </div>

        <h1>Reza Pratama</h1>
        <div class="role">{{ t.role }}</div>
        <p class="sum" v-html="t.summary"></p>

        <!-- Primary CTA Buttons (Terminal point of eye flow) -->
        <div class="cta-row">
          <a class="btn primary" href="#project" @click.prevent="goToSection('project')">
            {{ t.ctaProject }}
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
          </a>
          <a class="btn ghost" href="#contact" @click.prevent="openContactModal">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
            {{ t.ctaContact }}
          </a>
        </div>

        <!-- Structured Enterprise Track Record (Clear context, zero confusion with CTA) -->
        <div class="hero-trust">
          <span class="trust-label">{{ t.experienceLabel }}</span>
          <div class="trust-chips">
            <span class="trust-chip"><span class="chip-dot dot-infranexia"></span>InfraNexia <span class="chip-sub">· 2026–{{ t.now }}</span></span>
            <span class="trust-chip"><span class="chip-dot dot-telkom"></span>Telkom Indonesia — RAM <span class="chip-sub">· 2020–2025</span></span>
            <span class="trust-chip"><span class="chip-dot dot-telkomakses"></span>Telkom Akses <span class="chip-sub">· 2018</span></span>
          </div>
        </div>
      </div>

      <!-- Right Column: Personal Photo Card with Floating Experience Badge -->
      <div class="hero-visual reveal from-right">
        <div class="hero-card">
          <div class="hero-photo-wrap">
            <img src="/images/fotodiri/Gemini_Generated_Image_spqjaxspqjaxspqj.jpg" alt="Reza Pratama — Full-Stack Developer" class="hero-photo" />
            <div class="hero-float-badge">
              <div class="badge-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4-4-4"/><path d="m8 14-4-4 4-4"/><rect width="18" height="18" x="3" y="3" rx="2"/></svg>
              </div>
              <div>
                <div class="badge-num mono">6+ Years</div>
                <div class="badge-txt">Enterprise & Telecom</div>
              </div>
            </div>
          </div>
          <div class="hero-card-footer">
            <span class="hero-card-dot"></span>
            <span>{{ t.photoCaption }}</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endverbatim

<script>
Object.assign(I18N.en, {
  now:"Present",
  statusBadge:"Available for projects & collaboration",
  location:"Balikpapan (WITA)",
  role:"Full-Stack Developer · Telecom & Enterprise Systems",
  summary:"Software engineer with <strong>6+ years of experience</strong> building <strong>internal platforms, operational dashboards</strong>, and workflow automations across <strong>Telkom Group & InfraNexia</strong>. Focused on engineering reliable, intuitive applications that streamline field operations.",
  ctaProject:"Explore project list", ctaContact:"Get in touch",
  experienceLabel:"Enterprise Track Record",
  photoCaption:"6+ years of experience in Telkom Group & InfraNexia",
});
Object.assign(I18N.id, {
  now:"Sekarang",
  statusBadge:"Tersedia untuk proyek & kolaborasi",
  location:"Balikpapan (WITA)",
  role:"Full-Stack Developer · Telecom & Enterprise Systems",
  summary:"Pengembang web dengan pengalaman <strong>lebih dari 6 tahun</strong> membangun <strong>sistem internal, dashboard operasional</strong>, dan otomasi alur kerja di lingkungan <strong>Telkom Group & InfraNexia</strong>. Fokus menciptakan aplikasi yang andal, efisien, dan benar-benar memudahkan pekerjaan tim di lapangan.",
  ctaProject:"Lihat daftar proyek", ctaContact:"Hubungi saya",
  experienceLabel:"Jejak Pengalaman Enterprise",
  photoCaption:"6+ tahun pengalaman di Telkom Group & InfraNexia",
});
</script>
