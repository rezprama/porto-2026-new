@verbatim
<section id="project">
  <div class="wrap">
    <!-- Header Section with Real Estate Style Cluster Controls -->
    <div class="proj-header-wrap">
      <div class="sec-head">
        <span class="sec-badge"><span class="sec-badge-dot"></span> {{ t.projBadge }}</span>
        <h2>{{ t.projSection }}</h2>
        <p>{{ t.projSectionSub }}</p>
      </div>

      <!-- Minimalist Project Switcher Tabs -->
      <div class="proj-toolbar">
        <div class="proj-tab-nav" role="tablist" aria-label="Pilih Proyek">
          <button 
            v-for="(p, i) in projects" 
            :key="p.id" 
            type="button"
            role="tab"
            :aria-selected="activeProjIdx === i"
            class="proj-tab-item"
            :class="{ active: activeProjIdx === i }"
            @click="scrollToProj(i)"
          >
            <span class="tab-idx mono">0{{ i + 1 }}</span>
            <span class="tab-name">{{ t.proj[p.id].shortTitle }}</span>
            <span class="tab-status-dot" :class="'dot-' + p.id"></span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Expansive Horizontal Track (Breaks out for wide lateral showcase) -->
  <div class="proj-reel-outer">
    <div 
      class="proj-reel" 
      ref="projReelRef"
      @scroll="onProjReelScroll"
      @wheel.passive="onReelWheel"
      @mousedown="startDragProj"
      @mousemove="onDragProj"
      @mouseup="stopDragProj"
      @mouseleave="stopDragProj"
    >
      <div 
        v-for="(p, i) in projects" 
        :key="p.id" 
        class="proj-wide-card"
        :class="{ active: activeProjIdx === i }"
        :data-project="p.id"
      >
        <!-- Top Badge Ribbon -->
        <div class="card-ribbon">
          <span class="ribbon-project mono">PROJECT {{ p.projectCode || ('0' + (i + 1)) }}</span>
          <span class="ribbon-status" :class="'status-' + p.id">{{ t.proj[p.id].statusTag }}</span>
          <span class="ribbon-scale mono">{{ t.proj[p.id].scaleTag }}</span>
        </div>

        <div class="card-split-body">
          <!-- LEFT: Interactive Mockup Window & Visual Tour -->
          <div class="card-mockup-col">
            <div class="mockup-window">
              <!-- Window Chrome -->
              <div class="mockup-bar">
                <div class="mockup-dots">
                  <span class="dot-red"></span>
                  <span class="dot-yellow"></span>
                  <span class="dot-green"></span>
                </div>
                <div class="mockup-url mono">
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  <span>{{ p.mockupUrl }}</span>
                </div>
                <span class="mockup-live-badge mono">LIVE</span>
              </div>

              <!-- Interactive Mockup Viewport -->
              <div class="mockup-viewport">
                <!-- TIFREG Preview Simulation -->
                <div v-if="p.id === 'tifreg'" class="mock-canvas mock-tifreg">
                  <!-- Authentic GIS Map Alpro Demo Preview (Mirrors tifreg/feature/dashboard) -->
                  <div v-if="activeModuleTab.tifreg === 'gis'" class="canvas-gis-dalapa">
                    <!-- Mini Left Sidebar (Mirrors tifreg sidebar) -->
                    <aside class="mini-dash-sidebar">
                      <div class="mini-sidebar-brand">
                        <img src="/images/tifreg/logo.png" alt="DALAPA" class="mini-brand-img" />
                        <span class="mini-brand-title">DALAPA</span>
                      </div>
                      <div class="mini-sidebar-label">MENU</div>
                      <div class="mini-sidebar-nav">
                        <div class="mini-nav-item active">
                          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 20l-6-3V4l6 3 6-3 6 3v13l-6-3-6 3Z"/><path d="M9 4v13M15 7v13"/></svg>
                          <span>Map Alpro</span>
                        </div>
                        <div class="mini-nav-item">
                          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                          <span>NE / OLT</span>
                        </div>
                        <div class="mini-nav-item">
                          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 2 3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z"/></svg>
                          <span>NTE Stock</span>
                        </div>
                        <div class="mini-nav-item">
                          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                          <span>QE Proyek</span>
                        </div>
                      </div>
                    </aside>

                    <!-- Main Dashboard Area: Topbar + Real Balikpapan GIS Map Stage -->
                    <div class="mini-dash-main">
                      <!-- Mini Header Bar (Mirrors tifreg topbar) -->
                      <div class="mini-dash-topbar">
                        <div class="mini-topbar-left">
                          <span class="mini-topbar-icon">☰</span>
                          <span class="mini-topbar-title">Map Alpro — Balikpapan & Samarinda</span>
                        </div>
                        <div class="mini-topbar-right">
                          <span class="mini-topbar-clock mono">09:41 WITA</span>
                          <div class="mini-topbar-user">
                            <span class="mini-user-avatar">R</span>
                            <span class="mini-user-name">Reza</span>
                          </div>
                        </div>
                      </div>

                      <!-- Leaflet Style Cartographic Map Viewport -->
                      <div class="mini-map-viewport">
                        <!-- Lightweight SVG Vector Cartography: Balikpapan Bay, Coastline & Major Roads -->
                        <svg class="mini-carto-svg" viewBox="0 0 420 220" preserveAspectRatio="none">
                          <defs>
                            <linearGradient id="mapWaterGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                              <stop offset="0%" stop-color="#091424" />
                              <stop offset="100%" stop-color="#050c17" />
                            </linearGradient>
                            <linearGradient id="mapLandGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                              <stop offset="0%" stop-color="#111c2d" />
                              <stop offset="100%" stop-color="#0d1624" />
                            </linearGradient>
                          </defs>

                          <!-- Water (Teluk Balikpapan & Selat Makassar) -->
                          <rect width="420" height="220" fill="url(#mapWaterGrad)" />

                          <!-- Coastal Landmass: Balikpapan mainland extending northeast to Samarinda -->
                          <path d="M 0,0 L 420,0 L 420,220 L 320,220 Q 260,195 220,165 Q 180,125 160,85 Q 130,45 80,45 Q 35,45 0,70 Z" fill="url(#mapLandGrad)" stroke="#1e324a" stroke-width="1.2" />

                          <!-- Teluk Balikpapan Bay Curve -->
                          <path d="M 0,70 Q 35,45 80,45 Q 130,45 160,85 Q 180,125 220,165 Q 260,195 320,220 L 0,220 Z" fill="#07101c" opacity="0.85" />
                          <path d="M 0,70 Q 35,45 80,45 Q 130,45 160,85 Q 180,125 220,165 Q 260,195 320,220" fill="none" stroke="#2563eb" stroke-width="1.4" opacity="0.45" />

                          <!-- Highway: Tol Balikpapan - Samarinda -->
                          <path d="M 165,75 Q 230,55 310,35 T 415,15" fill="none" stroke="#334155" stroke-width="2.5" stroke-linecap="round" />
                          <path d="M 165,75 Q 230,55 310,35 T 415,15" fill="none" stroke="#60a5fa" stroke-width="1" stroke-linecap="round" stroke-dasharray="4 3" opacity="0.8" />
                          <text x="255" y="32" fill="#93c5fd" font-size="7" font-family="monospace" letter-spacing="0.5">TOL BPN - SAMARINDA ➔</text>

                          <!-- Arterial Road: Jl. Sudirman (Pesisir Balikpapan) -->
                          <path d="M 100,55 Q 140,65 170,95 T 235,145 T 310,195" fill="none" stroke="#334155" stroke-width="2.5" stroke-linecap="round" />
                          <path d="M 100,55 Q 140,65 170,95 T 235,145 T 310,195" fill="none" stroke="#94a3b8" stroke-width="0.8" stroke-linecap="round" opacity="0.6" />

                          <!-- Optical Feeder Backbone Lines (Cable Paths) -->
                          <path d="M 125,60 Q 155,85 190,105 T 270,135" fill="none" stroke="#38bdf8" stroke-width="1.8" stroke-linecap="round" />
                          <path d="M 190,105 Q 240,80 320,55" fill="none" stroke="#38bdf8" stroke-width="1.5" stroke-dasharray="3 3" opacity="0.85" />
                          <path d="M 190,105 L 220,150" fill="none" stroke="#38bdf8" stroke-width="1.2" stroke-dasharray="2 2" opacity="0.7" />
                        </svg>

                        <!-- Floating Sync Panel (Mirrors sync-panel in Leaflet app) -->
                        <div class="mini-sync-badge">
                          <div class="sync-head-line">
                            <span class="sync-pulsing-dot"></span>
                            <span class="sync-label">Sync Metabase</span>
                            <span class="sync-val mono">98.4%</span>
                          </div>
                          <div class="sync-data-line mono">
                            <span><b>48</b> OLT</span>
                            <span class="sep">·</span>
                            <span><b>1,420</b> ODP</span>
                          </div>
                        </div>

                        <!-- Floating Leaflet Toolbar (Mirrors app toolbar) -->
                        <div class="mini-map-toolbar">
                          <div class="mini-layer-pill">
                            <span class="active">Peta</span>
                            <span>Satelit</span>
                          </div>
                          <span class="mini-filter-pill">Filter</span>
                        </div>

                        <!-- Real STO / OLT POIs in Balikpapan -->
                        <!-- STO Balikpapan Kota -->
                        <div class="map-node node-sto-bpn" style="top:27%; left:29%;">
                          <span class="radar-ping"></span>
                          <span class="sto-dot"></span>
                          <div class="sto-badge">
                            <b class="sto-name">STO BPN Kota</b>
                            <span class="sto-code mono">OLT-ZTE-01</span>
                          </div>
                        </div>

                        <!-- STO Karang Joang -->
                        <div class="map-node node-sto-kj" style="top:22%; left:68%;">
                          <span class="sto-dot secondary"></span>
                          <div class="sto-badge">
                            <b class="sto-name">STO Karang Joang</b>
                            <span class="sto-code mono">OLT-HW-02</span>
                          </div>
                        </div>

                        <!-- STO Batakan -->
                        <div class="map-node node-sto-btk" style="top:66%; left:62%;">
                          <span class="sto-dot secondary"></span>
                          <div class="sto-badge">
                            <b class="sto-name">STO Batakan</b>
                            <span class="sto-code mono">OLT-FH-01</span>
                          </div>
                        </div>

                        <!-- ODP Markers with Authentic Occupancy Colors -->
                        <!-- Red (100% Okupansi) -->
                        <div class="odp-pin odp-red" style="top:47%; left:44%;" title="Okupansi 100%">
                          <span class="odp-color-dot"></span>
                          <span class="odp-tag mono">ODP-BPN-FA/04</span>
                        </div>

                        <!-- Amber (60% Okupansi) -->
                        <div class="odp-pin odp-amber" style="top:52%; left:51%;" title="Okupansi 60%">
                          <span class="odp-color-dot"></span>
                        </div>

                        <!-- Green (ODP Kosong) -->
                        <div class="odp-pin odp-green" style="top:36%; left:54%;" title="ODP Kosong">
                          <span class="odp-color-dot"></span>
                          <span class="odp-tag mono">ODP-BPN-KJ/12</span>
                        </div>

                        <div class="odp-pin odp-red" style="top:73%; left:52%;">
                          <span class="odp-color-dot"></span>
                        </div>

                        <!-- Mini Leaflet Legend (Mirrors app legend) -->
                        <div class="mini-leaflet-legend">
                          <div class="lg-row"><span class="sw bg-red"></span> Okupansi 100%</div>
                          <div class="lg-row"><span class="sw bg-amber"></span> Okupansi 60%</div>
                          <div class="lg-row"><span class="sw bg-green"></span> ODP Kosong</div>
                        </div>

                        <!-- Mini Leaflet Zoom Controls -->
                        <div class="mini-leaflet-zoom">
                          <span>+</span>
                          <span>−</span>
                        </div>

                        <!-- Bottom City Indicator (Specified city names) -->
                        <div class="mini-city-pill mono">
                          <span class="city-dot"></span>
                          <span>Kota: Balikpapan & Samarinda</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- GCU-OLT Telemetry Simulation -->
                  <div v-else-if="activeModuleTab.tifreg === 'gcu'" class="canvas-gcu">
                    <div class="gcu-readings">
                      <div class="gcu-card">
                        <div class="gcu-lbl">Rectifier DC Output</div>
                        <div class="gcu-val mono">53.4 <small>VDC</small></div>
                        <span class="gcu-stat stat-ok">● NORMAL</span>
                      </div>
                      <div class="gcu-card">
                        <div class="gcu-lbl">Total Current Load</div>
                        <div class="gcu-val mono">14.8 <small>A</small></div>
                        <span class="gcu-stat stat-ok">● BALANCED</span>
                      </div>
                      <div class="gcu-card">
                        <div class="gcu-lbl">Battery Backup SLA</div>
                        <div class="gcu-val mono">99.8 <small>%</small></div>
                        <span class="gcu-stat stat-ok">● OPTIMAL</span>
                      </div>
                    </div>
                    <div class="gcu-evidence-strip">
                      <div class="gcu-thumb-box">
                        <img src="/images/tifreg/evidence/GCU/power-after.svg" alt="Power After" class="evidence-img" />
                        <span class="evidence-lbl mono">Kwh Meter</span>
                      </div>
                      <div class="gcu-thumb-box">
                        <img src="/images/tifreg/evidence/GCU/meter-after.svg" alt="Meter After" class="evidence-img" />
                        <span class="evidence-lbl mono">Rectifier Panel</span>
                      </div>
                    </div>
                  </div>

                  <!-- BOQ Approval Flow Simulation -->
                  <div v-else class="canvas-boq">
                    <div class="boq-stepper">
                      <div class="boq-step done">
                        <span class="step-num">1</span>
                        <div class="step-info"><b class="step-title">Submission</b><span class="step-meta">TL QE Area</span></div>
                      </div>
                      <div class="boq-step-line done"></div>
                      <div class="boq-step done">
                        <span class="step-num">2</span>
                        <div class="step-info"><b class="step-title">Review Evidence</b><span class="step-meta">QE Validator</span></div>
                      </div>
                      <div class="boq-step-line done"></div>
                      <div class="boq-step active">
                        <span class="step-num">3</span>
                        <div class="step-info"><b class="step-title">Regional Approval</b><span class="step-meta">Telkom Reg 4</span></div>
                      </div>
                    </div>
                    <div class="boq-summary-card">
                      <div class="boq-row"><span>Paket Proyek:</span> <b>Relokasi Feeder OLT Samarinda</b></div>
                      <div class="boq-row"><span>Nilai Anggaran:</span> <b class="mono text-navy">Rp 142.500.000</b></div>
                      <div class="boq-row"><span>Status Verifikasi:</span> <span class="badge-approved">● Approved with Audit Trail</span></div>
                    </div>
                  </div>
                </div>

                <!-- DALAPAREG Preview Simulation -->
                <div v-else-if="p.id === 'dalapareg'" class="mock-canvas mock-dalapa">
                  <!-- Rekon Material Simulation -->
                  <div v-if="activeModuleTab.dalapareg === 'rekon'" class="canvas-rekon">
                    <div class="rekon-table-header">
                      <span>No. Tiket</span>
                      <span>Item Material</span>
                      <span>Volume</span>
                      <span>Status Rekon</span>
                    </div>
                    <div class="rekon-row">
                      <span class="mono">INC-784012</span>
                      <span>Kabel Drop 1C 150M</span>
                      <span class="mono">150 m</span>
                      <span class="rekon-chip match">MATCH</span>
                    </div>
                    <div class="rekon-row">
                      <span class="mono">INC-784088</span>
                      <span>Roset Optik SC/UPC</span>
                      <span class="mono">2 Pcs</span>
                      <span class="rekon-chip match">MATCH</span>
                    </div>
                    <div class="rekon-row">
                      <span class="mono">INC-784119</span>
                      <span>Splitter 1:8 Modular</span>
                      <span class="mono">1 Pcs</span>
                      <span class="rekon-chip verified">VERIFIED</span>
                    </div>
                  </div>

                  <!-- Wallboard Simulation -->
                  <div v-else-if="activeModuleTab.dalapareg === 'wallboard'" class="canvas-wallboard">
                    <div class="wallboard-metric-row">
                      <div class="wb-metric">
                        <span class="wb-lbl">Total Proyek Capex</span>
                        <span class="wb-num mono">348</span>
                      </div>
                      <div class="wb-metric">
                        <span class="wb-lbl">Realisasi Fisik</span>
                        <span class="wb-num mono text-navy">94.2%</span>
                      </div>
                      <div class="wb-metric">
                        <span class="wb-lbl">Closing Evidence</span>
                        <span class="wb-num mono text-green">100%</span>
                      </div>
                    </div>
                    <div class="wb-chart-bar">
                      <div class="chart-col" style="height:65%;"><span>Samarinda</span></div>
                      <div class="chart-col" style="height:90%;"><span>Balikpapan</span></div>
                      <div class="chart-col" style="height:48%;"><span>Pontianak</span></div>
                      <div class="chart-col" style="height:78%;"><span>Banjarmasin</span></div>
                      <div class="chart-col" style="height:54%;"><span>Tarakan</span></div>
                    </div>
                  </div>

                  <!-- NTE Opname Simulation -->
                  <div v-else class="canvas-nte">
                    <div class="nte-card">
                      <div class="nte-top">
                        <span class="nte-title">Stock Opname Gudang Regional</span>
                        <span class="nte-badge mono">Bulan Berjalan</span>
                      </div>
                      <div class="nte-list">
                        <div class="nte-item">
                          <span>ONT Dual Band ZTE</span>
                          <span class="mono"><b>1,240</b> Unit</span>
                        </div>
                        <div class="nte-item">
                          <span>STB Android 4K</span>
                          <span class="mono"><b>890</b> Unit</span>
                        </div>
                        <div class="nte-item">
                          <span>Patchcord SC-SC 3M</span>
                          <span class="mono"><b>4,600</b> Pcs</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- TOMMAN Preview Simulation -->
                <div v-else class="mock-canvas mock-tomman">
                  <div class="canvas-telegram">
                    <div class="tg-header">
                      <div class="tg-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="m20.665 3.717-17.73 6.837c-1.21.486-1.203 1.161-.222 1.462l4.552 1.42 10.532-6.645c.498-.303.953-.14.579.192l-8.533 7.701h-.002l-.313 4.674c.458 0 .66-.21.916-.458l2.199-2.138 4.573 3.378c.843.465 1.45.225 1.66-.782l3-14.135c.308-1.233-.47-1.791-1.211-1.506z"/></svg>
                      </div>
                      <div class="tg-title-box">
                        <span class="tg-title">TOMMAN Telegram Automation Bot</span>
                        <span class="tg-sub">Dispatched to 500+ Regional Field Techs</span>
                      </div>
                    </div>
                    <div class="tg-bubble">
                      <div class="tg-badge">🚨 TIKET GANGGUAN ASSURANCE</div>
                      <div class="tg-msg">
                        <b>ID:</b> #TK-BPN-9912<br>
                        <b>Lokasi:</b> STO Batakan, Balikpapan<br>
                        <b>Dampak:</b> 64 Pelanggan Indihome Loss<br>
                        <b>Teknisi Ditugaskan:</b> Reg-Tech Alpha (Dispatch 2m lalu)
                      </div>
                      <div class="tg-time mono">11:42 WITA · Otomasi Terkirim</div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Interactive Feature Tour Switcher Tabs -->
              <div class="mockup-tab-strip">
                <span class="tab-strip-lbl">{{ t.projPeekTour }}:</span>
                <div class="tab-strip-btns">
                  <button 
                    v-for="subTab in p.previewTabs" 
                    :key="subTab.id"
                    type="button" 
                    class="mockup-sub-tab" 
                    :class="{ active: activeModuleTab[p.id] === subTab.id }"
                    @click.stop="setActiveModuleTab(p.id, subTab.id)"
                  >
                    <span>{{ subTab.label }}</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- RIGHT: Enterprise Property Specs & Architecture Matrix -->
          <div class="card-specs-col">
            <!-- Project Identification -->
            <div class="specs-head">
              <div class="proj-brand-row">
                <div class="proj-logo-box" v-if="p.logo">
                  <img :src="p.logo" :alt="t.proj[p.id].title" class="proj-logo-img" />
                </div>
                <span class="badge" v-else>{{ t.proj[p.id].badge }}</span>
                <div>
                  <h3 class="proj-title">{{ t.proj[p.id].title }}</h3>
                  <div class="proj-sub">{{ t.proj[p.id].sub }}</div>
                </div>
              </div>

              <div class="proj-author-tag">
                <span class="role-badge">{{ t.projRoleBadge }}</span>
                <span class="author-org">{{ p.orgContext }}</span>
              </div>
            </div>

            <!-- Description -->
            <p class="proj-desc">{{ t.proj[p.id].desc }}</p>

            <!-- Real Estate Style Architectural Specifications Matrix (4-Grid) -->
            <div class="proj-spec-matrix">
              <div class="spec-cell">
                <div class="spec-lbl">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>
                  <span>{{ t.projSpecArch }}</span>
                </div>
                <div class="spec-val">{{ p.specs.arch }}</div>
              </div>

              <div class="spec-cell">
                <div class="spec-lbl">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  <span>{{ t.projSpecCapacity }}</span>
                </div>
                <div class="spec-val">{{ p.specs.capacity }}</div>
              </div>

              <div class="spec-cell">
                <div class="spec-lbl">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                  <span>{{ t.projSpecRegion }}</span>
                </div>
                <div class="spec-val">{{ p.specs.coverage }}</div>
              </div>

              <div class="spec-cell">
                <div class="spec-lbl">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                  <span>{{ t.projSpecModules }}</span>
                </div>
                <div class="spec-val">{{ p.specs.coreModules }}</div>
              </div>
            </div>

            <!-- Tech Stack Chips -->
            <div class="proj-stack-chips">
              <span class="sk mono" v-for="tag in p.tags" :key="tag">{{ tag }}</span>
            </div>

            <!-- Action CTA Group -->
            <div class="proj-card-actions">
              <a v-if="!p.comingSoon" class="btn primary" :href="p.url" target="_blank" rel="noopener">
                <span>{{ t.openProject }}</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M7 17 17 7M8 7h9v9"/></svg>
              </a>
              <button v-else class="btn disabled" disabled type="button" aria-disabled="true">
                <span>{{ t.comingSoon }}</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </button>

              <button 
                type="button" 
                class="btn ghost proj-detail-btn"
                @click="openProjectDetails(p)"
              >
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>{{ t.projViewSpecs }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="wrap">
    <!-- Bottom Interactive Progress Scrubber -->
    <div class="proj-bottom-nav">
      <div class="proj-progress-track" @click="onProgressTrackClick" title="Klik untuk navigasi proyek">
        <div class="proj-progress-fill" :style="{ width: projProgressPct + '%' }"></div>
      </div>

      <p class="proj-note">{{ t.projNote }}</p>
    </div>


  </div>

  <!-- Project Details Modal Lightbox (Like Floorplan / Full Unit Brochure Modal) -->
  <transition name="modal-fade">
    <div class="modal-backdrop" v-if="selectedDetailProj" v-cloak @click.self="selectedDetailProj = null">
      <div class="modal-dialog proj-specs-modal" role="dialog" aria-modal="true">
        <div class="modal-header">
          <div class="modal-title-box">
            <div class="modal-icon-badge">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div>
              <h3 class="modal-title">{{ t.proj[selectedDetailProj.id].title }}</h3>
              <p class="modal-sub">{{ t.proj[selectedDetailProj.id].sub }} · {{ selectedDetailProj.orgContext }}</p>
            </div>
          </div>
          <button type="button" class="modal-close-btn" @click="selectedDetailProj = null" aria-label="Close">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 6 6 18M6 6l12 12"/></svg>
          </button>
        </div>

        <div class="modal-specs-content">
          <!-- Parameter & Spesifikasi Sistem Grid -->
          <div class="modal-spec-block">
            <h4 class="modal-spec-head">{{ t.modalSpecsMatrixTitle }}</h4>
            <div class="modal-spec-grid">
              <div class="modal-grid-cell">
                <span class="cell-label">{{ t.projSpecArch }}</span>
                <b class="cell-val">{{ selectedDetailProj.specs.arch }}</b>
              </div>
              <div class="modal-grid-cell">
                <span class="cell-label">{{ t.projSpecCapacity }}</span>
                <b class="cell-val">{{ selectedDetailProj.specs.capacity }}</b>
              </div>
              <div class="modal-grid-cell">
                <span class="cell-label">{{ t.projSpecRegion }}</span>
                <b class="cell-val">{{ selectedDetailProj.specs.coverage }}</b>
              </div>
              <div class="modal-grid-cell">
                <span class="cell-label">{{ t.projSpecModules }}</span>
                <b class="cell-val">{{ selectedDetailProj.specs.coreModules }}</b>
              </div>
            </div>
          </div>

          <!-- Ikhtisar Arsitektur & Solusi Lapangan -->
          <div class="modal-spec-block">
            <h4 class="modal-spec-head">{{ t.modalArchitectureOverview }}</h4>
            <p class="modal-spec-text">{{ (selectedDetailProj.deepDive && selectedDetailProj.deepDive[lang]) || t.proj[selectedDetailProj.id].desc }}</p>
          </div>

          <!-- Fitur & Kemampuan Utama -->
          <div class="modal-spec-block">
            <h4 class="modal-spec-head">{{ t.modalKeyModules }}</h4>
            <div class="modal-module-list">
              <div class="modal-module-item" v-for="feat in selectedDetailProj.fullFeatures" :key="feat.name">
                <span class="feat-bullet">●</span>
                <div>
                  <b class="feat-name">{{ feat.name }}</b>
                  <p class="feat-desc">{{ feat.desc[lang] }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Teknologi & Framework -->
          <div class="modal-spec-block">
            <h4 class="modal-spec-head">{{ t.modalStack }}</h4>
            <div class="chips">
              <span class="sk" v-for="tag in selectedDetailProj.tags" :key="tag">{{ tag }}</span>
            </div>
          </div>
        </div>

        <div class="modal-specs-footer">
          <a v-if="!selectedDetailProj.comingSoon" class="btn primary" :href="selectedDetailProj.url" target="_blank" rel="noopener">
            {{ t.openProject }}
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 17 17 7M8 7h9v9"/></svg>
          </a>
          <button type="button" class="btn ghost" @click="selectedDetailProj = null">
            {{ t.closeModal }}
          </button>
        </div>
      </div>
    </div>
  </transition>
</section>
@endverbatim

<script>
window.PROJECTS = [
  {
    id: "tifreg",
    projectCode: "01",
    url: "{{ route('project.tifreg.login') }}",
    logo: "/images/tifreg/logo.png",
    orgContext: "InfraNexia · Telkom RAM (Balikpapan & Samarinda)",
    mockupUrl: "tifreg.dalapa.id/regional-operations",
    tags: ["Laravel 12", "Vue 3", "Inertia.js", "MySQL", "Redis", "Leaflet GIS"],
    comingSoon: false,
    specs: {
      arch: "Modular Micro-apps (Laravel 12 + Vue 3)",
      capacity: "1,200+ Tim Lapangan & Regional",
      coverage: "Balikpapan & Samarinda",
      coreModules: "GIS Peta Alpro, GCU-OLT, Approval BOQ, Stock Opname"
    },
    deepDive: {
      id: "Platform operasional modular berskala regional yang dibangun untuk menggantikan koordinasi berbasis spreadsheet dan grup pesan instan di wilayah Balikpapan & Samarinda. Arsitektur memisahkan komputasi data spasial aset jaringan, pemantauan telemetri catuan daya, dan alur persetujuan belanja modal (CAPEX). Seluruh akses diamankan dengan autentikasi SSO/LDAP terpusat korporat, proteksi 2FA, dan audit trail per transaksi untuk menjamin integritas belanja infrastruktur telekomunikasi.",
      en: "Regional-scale modular operations platform engineered to replace fragmented spreadsheet workflows across Balikpapan & Samarinda. The architecture decouples spatial GIS asset processing, power telemetry ingestion, and multi-tier CAPEX approval pipelines. Access is protected via centralized corporate LDAP/SSO, 2FA verification, and immutable per-transaction audit logs to ensure total financial compliance."
    },
    previewTabs: [
      { id: "gis", label: "GIS Peta Alpro" },
      { id: "gcu", label: "GCU-OLT Telemetri" },
      { id: "boq", label: "Alur BOQ Approval" }
    ],
    fullFeatures: [
      {
        name: "GIS Peta Alpro & Jalur Optik Spasial",
        desc: {
          id: "Pemetaan spasial E2E jalur kabel fiber optik, sentral STO (BPN Kota, Karang Joang, Batakan), dan ribuan ODP di Balikpapan & Samarinda. Dilengkapi pemantauan okupansi port live (100%, 80%, 60%, kosong), heatmap tiket gangguan pelanggan, dan routing kabel presisi.",
          en: "End-to-end geospatial mapping of optical fiber routes, central STO nodes, and thousands of ODPs across Balikpapan & Samarinda. Features live port occupancy ratios, customer trouble-ticket heatmaps, and precise cable routing."
        }
      },
      {
        name: "GCU-OLT Power & Telemetri Sentral",
        desc: {
          id: "Telemetri real-time catuan daya perangkat transmisi sentral: monitoring tegangan rectifier DC (53.4 VDC), arus beban, integrasi kWh meter PLN, dan kesehatan baterai cadangan guna mencegah insiden loss-of-power di sentral.",
          en: "Real-time telemetry monitoring for central transmission power supplies: DC rectifier voltage tracking (53.4 VDC), total load current, utility kWh meters, and backup battery health to eliminate central outage risks."
        }
      },
      {
        name: "Multi-Tier BOQ & Workflow Approval QE",
        desc: {
          id: "Alur persetujuan anggaran belanja modal (CAPEX) berjenjang 3 level (Team Leader Area -> Validator QE -> Regional Manager) dengan validasi wajib foto evidence fisik sebelum pekerjaan disahkan dan anggaran dicairkan.",
          en: "Multi-tier CAPEX approval workflow across 3 levels (Team Leader -> QE Validator -> Regional Manager) with mandatory photographic evidence verification before budget release."
        }
      },
      {
        name: "Material Tracking & Stock Opname NTE",
        desc: {
          id: "Pengawasan logistik dan rekonsiliasi stok material kabel optik, tiang, dan perangkat modem ONT/STB antara pemakaian fisik di lapangan dengan saldo pembukuan gudang kantor daerah.",
          en: "Logistics tracking and inventory reconciliation for optical cables, poles, and ONT/STB modems between physical field usage and regional warehouse ledgers."
        }
      }
    ]
  },
  {
    id: "dalapareg",
    projectCode: "02",
    url: "{{ route('project.dalapareg.login') }}",
    logo: "/images/dalapa/logo.png",
    orgContext: "Telkom RAM · Balikpapan, Samarinda, Tarakan (2020–2025)",
    mockupUrl: "dalapareg.telkom.co.id/monolithic-suite",
    tags: ["Laravel 10", "MySQL", "MongoDB", "Bootstrap", "Leaflet JS"],
    comingSoon: false,
    specs: {
      arch: "Enterprise Monolith (Laravel 10 + MySQL/Mongo)",
      capacity: "800+ User Operasional Regional",
      coverage: "Balikpapan, Samarinda, Tarakan",
      coreModules: "Rekon Material, Mapping OLT-ODP, Wallboard CAPEX"
    },
    deepDive: {
      id: "Arsitektur monolitik enterprise yang beroperasi stabil selama 5 tahun melayani operasional harian Telkom RAM di Balikpapan, Samarinda, dan Tarakan. Mengintegrasikan database relasional MySQL untuk integritas data transaksi dan MongoDB untuk pencatatan riwayat tiket bervolume tinggi, dioptimalkan dengan indexing query database untuk melayani 800+ personil lapangan dan kantor daerah secara konsisten.",
      en: "Enterprise monolithic architecture operating stably for 5 years supporting daily Telkom RAM operations in Balikpapan, Samarinda, and Tarakan. Combines relational MySQL for transactional data integrity with MongoDB for high-velocity ticket logging, optimized with database query indexing to reliably serve 800+ operational users."
    },
    previewTabs: [
      { id: "rekon", label: "Rekon Material" },
      { id: "wallboard", label: "Wallboard CAPEX" },
      { id: "nte", label: "NTE Stock Opname" }
    ],
    fullFeatures: [
      {
        name: "Rekonsiliasi Material & Tiket Assurance",
        desc: {
          id: "Pencocokan presisi antara pengeluaran fisik material kabel & aksesoris di lapangan dengan data tiket gangguan pelanggan IndiHome untuk keperluan audit operasional.",
          en: "Precision reconciliation between physical material consumption in the field and customer trouble tickets for compliance and audit requirements."
        }
      },
      {
        name: "Wallboard Realisasi CAPEX & Proyek",
        desc: {
          id: "Dashboard eksekutif yang merangkum ratusan proyek penggelaran jaringan baru, persentase realisasi fisik di lapangan, dan kelengkapan berkas berita acara (BAST).",
          en: "Executive dashboard summarizing hundreds of network buildout projects, physical completion rates, and closure documentation."
        }
      },
      {
        name: "Manajemen Gudang & Stock Opname NTE",
        desc: {
          id: "Tata kelola inventaris modem ONT dan STB TV pada seluruh gudang kantor daerah dengan pencatatan nomor seri barcode dan ambang batas minimum stock.",
          en: "Inventory management for ONT modems and STB boxes across local warehouses with barcode tracking and automated minimum safety stock thresholds."
        }
      }
    ]
  },
  {
    id: "tomman",
    projectCode: "03",
    url: "{{ route('project.tomman.login') }}",
    logo: "/images/tomman/logo.svg",
    orgContext: "Telkom Akses · Operasi Balikpapan & Sekitarnya",
    mockupUrl: "tomman.internal.net/telegram-automation",
    tags: ["Laravel", "MySQL", "Telegram Bot API", "Bootstrap", "RESTful API"],
    comingSoon: false,
    specs: {
      arch: "Automation & Dispatch Suite (Laravel + Bot API)",
      capacity: "500+ Teknisi Lapangan Aktif",
      coverage: "Balikpapan & Sekitarnya",
      coreModules: "Telegram Bot Dispatch, Tiketing, Tracking PSB"
    },
    deepDive: {
      id: "Platform otomasi alur kerja operasional lapangan yang mengintegrasikan RESTful API Laravel dengan Telegram Bot Gateway. Berfungsi mendistribusikan ribuan penugasan gangguan dan pasang baru (PSB) secara real-time ke teknisi lapangan di Balikpapan & sekitarnya, memangkas waktu respon tiket (MTTR) hingga 45%.",
      en: "Field operational workflow automation platform integrating Laravel RESTful APIs with Telegram Bot Gateway. Automatically dispatches trouble tickets and provisioning tasks in real-time to field technicians across Balikpapan, reducing mean time to repair (MTTR) by up to 45%."
    },
    previewTabs: [
      { id: "dispatch", label: "Dispatch Teknisi" },
      { id: "bot", label: "Bot Otomasi" }
    ],
    fullFeatures: [
      {
        name: "Bot Otomasi Dispatching Teknisi",
        desc: {
          id: "Broadcast otomatis tiket gangguan dan penugasan perbaikan langsung ke grup Telegram regu teknisi terdekat dalam hitungan detik setelah tiket dibuat sistem.",
          en: "Automated broadcast of incident tickets and dispatch assignments directly to nearby technician field groups within seconds of creation."
        }
      },
      {
        name: "Monitoring SLA & Eskalasi Tiket",
        desc: {
          id: "Sistem pendukung keputusan dengan ambang batas SLA ketat dan peringatan otomatis bertingkat ke supervisor apabila tiket gangguan mendekati batas waktu pengerjaan.",
          en: "Decision support system featuring strict SLA thresholds and automated escalation alerts to supervisors when incidents approach target deadlines."
        }
      }
    ]
  }
];

window.OPERATIONAL_MODULES = [
  {
    id: "mod-gis",
    projectId: "tifreg",
    tabId: "gis",
    code: "GIS-01",
    projectLabel: "DALAPA Suite 2026",
    name: {
      id: "GIS Peta Alpro & Jalur Optik",
      en: "GIS Network & Fiber Map"
    },
    desc: {
      id: "Pemetaan spasial E2E OLT ke ribuan ODP di Balikpapan & Samarinda dengan routing kabel presisi.",
      en: "Spatial E2E mapping from OLTs to thousands of ODPs across Balikpapan & Samarinda with precise routing."
    }
  },
  {
    id: "mod-gcu",
    projectId: "tifreg",
    tabId: "gcu",
    code: "PWR-02",
    projectLabel: "DALAPA Suite 2026",
    name: {
      id: "GCU-OLT Power & Telemetri",
      en: "GCU-OLT Power Telemetry"
    },
    desc: {
      id: "Pemantauan voltase DC, arus rectifier, dan kesehatan catuan daya perangkat sentral.",
      en: "DC voltage, rectifier current, and central telecom node energy health monitoring."
    }
  },
  {
    id: "mod-boq",
    projectId: "tifreg",
    tabId: "boq",
    code: "BOQ-03",
    projectLabel: "DALAPA Suite 2026",
    name: {
      id: "Wallboard & Approval BOQ",
      en: "BOQ Workflow & Approval"
    },
    desc: {
      id: "Alur persetujuan anggaran berjenjang (TL -> QE -> Regional) lengkap dengan evidence.",
      en: "Multi-tier budget approval workflow (TL -> QE -> Regional) with evidence verification."
    }
  },
  {
    id: "mod-rekon",
    projectId: "dalapareg",
    tabId: "rekon",
    code: "MAT-04",
    projectLabel: "DALAPA Legacy",
    name: {
      id: "Rekon Material & NTE",
      en: "Material Reconciliation"
    },
    desc: {
      id: "Pencocokan pemakaian kabel & modem ONT fisik terhadap tiket gangguan secara akurat.",
      en: "Automated reconciliation of physical cables and ONT modems against trouble tickets."
    }
  }
];

Object.assign(I18N.en, {
  projBadge: "Interactive Systems",
  projSection: "Featured Systems Showcase",
  projSectionSub: "Architectural overview of enterprise platforms I built and maintained",
  openProject: "Launch App",
  comingSoon: "Coming Soon",
  projNote: "All projects are interactive in-repo UI miniatures with simulated (dummy) data for demonstration purposes. Opens in a new tab.",
  projPrev: "Previous Project",
  projNext: "Next Project",
  projDragHint: "Drag or scroll horizontally to explore projects",
  projViewSpecs: "Specifications",
  projRoleBadge: "Lead Developer / Architect",
  projPeekTour: "Module Preview",
  projSpecArch: "System Architecture",
  projSpecCapacity: "User Capacity",
  projSpecRegion: "Operational Region",
  projSpecModules: "Key Capabilities",
  projModuleTourTitle: "Operational Modules & System Architecture",
  projModuleTourSub: "Key architectural components integrated into the platform ecosystem",
  jumpToSpec: "View Specs",
  modalSpecsMatrixTitle: "System Specifications & Metrics",
  modalArchitectureOverview: "Architecture Overview & Solution",
  modalKeyModules: "Core Capabilities & Modules",
  modalStack: "Technology Stack",
  closeModal: "Close",
  proj: {
    tifreg: {
      badge: "REG",
      shortTitle: "DALAPA Platform (2026)",
      title: "DALAPA Regional Platform",
      sub: "Regional Operations Suite · Enterprise 2026",
      statusTag: "ACTIVE IN PRODUCTION",
      scaleTag: "1,200+ ACTIVE USERS",
      desc: "One integrated system for regional telecom operations: GIS infrastructure mapping, QE project & BOQ multi-tier approval workflows, capital budget allocation, and material stock-opname, with LDAP/2FA authentication and audit logs."
    },
    dalapareg: {
      badge: "DLP",
      shortTitle: "DALAPA Legacy Suite",
      title: "DALAPA Regional (Legacy App)",
      sub: "Enterprise Monolithic Operations Suite",
      statusTag: "STABLE PRODUCTION",
      scaleTag: "800+ USERS",
      desc: "Monolithic regional operational suite engineered for Telkom Regional: E2E OLT-ODP mapping, assurance ticket & material reconciliation, QE capex & BOQ approval, NTE stock management, and GIS network mapping (Peta Alpro)."
    },
    tomman: {
      badge: "TMM",
      shortTitle: "TOMMAN Ops Suite",
      title: "TOMMAN Operational Suite",
      sub: "Field Operations & Telegram Automation",
      statusTag: "ENTERPRISE AUTOMATION",
      scaleTag: "500+ FIELD TECHS",
      desc: "Central operational platform for regional telecom operations: ticketing, technician dispatching, PSB/assurance tracking, and automated Telegram bot integration."
    }
  }
});

Object.assign(I18N.id, {
  projBadge: "Sistem Interaktif",
  projSection: "Showcase Proyek & Sistem",
  projSectionSub: "Eksplorasi arsitektur platform enterprise berskala regional yang saya bangun dan kelola",
  openProject: "Buka Aplikasi",
  comingSoon: "Coming Soon",
  projNote: "Seluruh proyek merupakan miniatur UI interaktif di dalam repositori ini dengan data simulasi (dummy data) untuk keperluan demonstrasi portofolio. Tautan terbuka di tab baru.",
  projPrev: "Proyek Sebelumnya",
  projNext: "Proyek Selanjutnya",
  projDragHint: "Geser menyamping dengan mouse / swipe untuk eksplorasi proyek",
  projViewSpecs: "Detail Spesifikasi",
  projRoleBadge: "Lead Developer / Architect",
  projPeekTour: "Pratinjau Modul",
  projSpecArch: "Arsitektur Sistem",
  projSpecCapacity: "Skala Pengguna",
  projSpecRegion: "Wilayah Operasi",
  projSpecModules: "Modul Unggulan",
  projModuleTourTitle: "Modul Operasional & Arsitektur Sistem",
  projModuleTourSub: "Komponen sistem kunci yang diintegrasikan dalam ekosistem platform",
  jumpToSpec: "Lihat Spesifikasi",
  modalSpecsMatrixTitle: "Parameter & Spesifikasi Sistem",
  modalArchitectureOverview: "Ikhtisar Arsitektur & Solusi",
  modalKeyModules: "Fitur & Kemampuan Utama",
  modalStack: "Teknologi & Framework",
  closeModal: "Tutup",
  proj: {
    tifreg: {
      badge: "REG",
      shortTitle: "DALAPA Platform (2026)",
      title: "DALAPA Regional Platform",
      sub: "Suite Operasional Regional · Enterprise 2026",
      statusTag: "AKTIF PRODUKSI",
      scaleTag: "1.200+ PENGGUNA",
      desc: "Satu sistem terpadu untuk tim regional telekomunikasi: pemetaan infrastruktur spasial GIS, alur persetujuan proyek QE & BOQ bertingkat, alokasi anggaran, dan stock opname material, lengkap dengan autentikasi LDAP/2FA serta audit log."
    },
    dalapareg: {
      badge: "DLP",
      shortTitle: "DALAPA Legacy Suite",
      title: "DALAPA Regional (Legacy App)",
      sub: "Suite Operasional Monolitik Enterprise",
      statusTag: "PRODUKSI STABIL",
      scaleTag: "800+ PENGGUNA",
      desc: "Sistem operasional monolitik Telkom Regional: rekonsiliasi material & tiket assurance, pemetaan E2E OLT-ODP, alur proyek QE & persetujuan BOQ, stock opname NTE, serta GIS infrastruktur jaringan (Peta Alpro)."
    },
    tomman: {
      badge: "TMM",
      shortTitle: "TOMMAN Ops Suite",
      title: "TOMMAN Operational Suite",
      sub: "Sistem Operasional Lapangan & Otomasi Bot",
      statusTag: "OTOMASI ENTERPRISE",
      scaleTag: "500+ TEKNISI LAPANGAN",
      desc: "Platform pemantauan dan pendukung keputusan utama untuk operasi telekomunikasi regional: manajemen tiket, dispatch teknisi, monitoring progres PSB/assurance, dan bot otomatisasi Telegram."
    }
  }
});
</script>
