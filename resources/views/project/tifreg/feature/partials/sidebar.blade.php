@php($masterActive = in_array($active ?? '', ['master-search', 'master-org', 'master-sync']))
@php($gcuActive = in_array($active ?? '', ['gcu-monitoring', 'gcu-electrical', 'gcu-listing', 'gcu-approval']))
@php($neActive = $gcuActive || in_array($active ?? '', ['ne-material']))
@php($nteActive = in_array($active ?? '', ['nte-stock', 'nte-minimum', 'nte-b2b']))
@php($qeActive = in_array($active ?? '', ['qe-project', 'qe-budget']))
<div class="sidebar-overlay" id="sideOverlay"></div>
<aside class="sidebar" id="sidebar">
  <div class="brand">
    <img src="/images/tifreg/logo.png" alt="DALAPA" />
    <b>DALAPA Regional</b>
  </div>
  <nav>
    <div class="nav-label">Menu</div>

    <a class="nav-item {{ ($active ?? '') === 'map' ? 'active' : '' }}" href="{{ route('project.tifreg.dashboard') }}">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 20l-6-3V4l6 3 6-3 6 3v13l-6-3-6 3Z"/><path d="M9 4v13M15 7v13"/></svg>
      Map Alpro
    </a>

    <div class="nav-group {{ $neActive ? 'open' : '' }}">
      <button class="nav-item {{ $neActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        NE
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <div class="nav-group {{ $gcuActive ? 'open' : '' }}">
          <button class="nav-item {{ $gcuActive ? 'active' : '' }}" data-toggle>
            GCU OLT
            <svg class="chev" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
          </button>
          <div class="sub-nav">
            <a class="{{ ($active ?? '') === 'gcu-monitoring' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.gcu-olt.monitoring') }}" data-i18n="navGcuMonitoring">Monitoring</a>
            <a class="{{ ($active ?? '') === 'gcu-electrical' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.gcu-olt.electrical') }}" data-i18n="navGcuElectrical">Monitoring Kelistrikan</a>
            <a class="{{ ($active ?? '') === 'gcu-listing' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.gcu-olt.listing') }}" data-i18n="navGcuListing">Listing</a>
            <a class="{{ ($active ?? '') === 'gcu-approval' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.gcu-olt.approval') }}" data-i18n="navGcuApproval">Approval</a>
          </div>
        </div>
        <a class="{{ ($active ?? '') === 'ne-material' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.material-tracking.monitoring') }}" data-i18n="navMaterial">Tracking Material</a>
      </div>
    </div>

    <div class="nav-group {{ $nteActive ? 'open' : '' }}">
      <button class="nav-item {{ $nteActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 2 3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z"/></svg>
        NTE
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'nte-stock' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.stock-opname.monitoring') }}" data-i18n="navStock">Stock Opname</a>
        <a class="{{ ($active ?? '') === 'nte-minimum' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.stock-opname.minimum') }}" data-i18n="navMinStock">Minimum Stock</a>
        <a class="{{ ($active ?? '') === 'nte-b2b' ? 'active' : '' }}" href="{{ route('project.tifreg.ne.stock-opname.b2b') }}" data-i18n="navB2B">Monitoring B2B</a>
      </div>
    </div>

    <div class="nav-group {{ $qeActive ? 'open' : '' }}">
      <button class="nav-item {{ $qeActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        QE
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'qe-project' ? 'active' : '' }}" href="{{ route('project.tifreg.qe.list-project') }}" data-i18n="navProject">List Project</a>
        <a class="{{ ($active ?? '') === 'qe-budget' ? 'active' : '' }}" href="{{ route('project.tifreg.qe.budget') }}" data-i18n="navBudget">Anggaran</a>
      </div>
    </div>

    <div class="nav-group {{ $masterActive ? 'open' : '' }}">
      <button class="nav-item {{ $masterActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.7 4 3 9 3s9-1.3 9-3V5M3 12c0 1.7 4 3 9 3s9-1.3 9-3"/></svg>
        Master Data
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'master-search' ? 'active' : '' }}" href="{{ route('project.tifreg.master.data-search') }}" data-i18n="navDataSearch">Cari Data</a>
        <a class="{{ ($active ?? '') === 'master-org' ? 'active' : '' }}" href="{{ route('project.tifreg.master.unit-qe') }}" data-i18n="navOrganisasi">Organisasi</a>
        <a class="{{ ($active ?? '') === 'master-sync' ? 'active' : '' }}" href="{{ route('project.tifreg.master.sync-metabase') }}">Sync Metabase</a>
      </div>
    </div>

    <a class="nav-item {{ ($active ?? '') === 'user' ? 'active' : '' }}" href="{{ route('project.tifreg.user-management') }}">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <span data-i18n="navUser">Manajemen Pengguna</span>
    </a>
  </nav>
</aside>

<a class="back-badge" href="/">
  <span class="mark"><img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" /></span>
  <span class="txt">Demo · Portfolio Reza Pratama</span>
</a>
