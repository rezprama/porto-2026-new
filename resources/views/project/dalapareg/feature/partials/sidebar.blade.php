@php($damanActive = in_array($active ?? '', ['daman-mapping-olt-odp']))
@php($assuranceActive = in_array($active ?? '', ['assurance-rekon']))
@php($newProjectActive = in_array($active ?? '', ['qe-monitoring', 'qe-monitoring-rp', 'qe-listing', 'qe-approval-tl', 'qe-approval-evidence', 'qe-approval-qe', 'qe-approval-regional', 'qe-dashboard-boq', 'qe-export']))
@php($qeActive = $newProjectActive || in_array($active ?? '', ['qe-capex']))
@php($nteActive = in_array($active ?? '', ['nte-stock']))
<div class="sidebar-overlay" id="sideOverlay"></div>
<aside class="sidebar" id="sidebar">
  <div class="brand">
    <img src="/images/dalapa/logo.png" alt="DALAPA" />
    <b>DALAPA</b>
  </div>
  <nav>
    <div class="nav-label">Main</div>

    <a class="nav-item {{ ($active ?? '') === 'map' ? 'active' : '' }}" href="{{ route('project.dalapareg.peta-alpro') }}">
      <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 20l-6-3V4l6 3 6-3 6 3v13l-6-3-6 3Z"/><path d="M9 4v13M15 7v13"/></svg>
      <span data-i18n="navMapAlpro">Map Alpro</span>
    </a>

    <div class="nav-group {{ $damanActive ? 'open' : '' }}">
      <button class="nav-item {{ $damanActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.7 4 3 9 3s9-1.3 9-3V5M3 12c0 1.7 4 3 9 3s9-1.3 9-3"/></svg>
        <span data-i18n="navDaman">Data Management</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'daman-mapping-olt-odp' ? 'active' : '' }}" href="{{ route('project.dalapareg.daman.mapping-olt-odp') }}" data-i18n="navMappingOltOdp">Mapping OLT-ODP</a>
      </div>
    </div>

    <div class="nav-group {{ $assuranceActive ? 'open' : '' }}">
      <button class="nav-item {{ $assuranceActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 2 3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z"/><path d="m9 12 2 2 4-4"/></svg>
        <span data-i18n="navAssurance">Assurance</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'assurance-rekon' ? 'active' : '' }}" href="{{ route('project.dalapareg.assurance.rekon-material') }}" data-i18n="navRekonMaterial">Rekon Material Assurance</a>
      </div>
    </div>

    <div class="nav-group {{ $qeActive ? 'open' : '' }}">
      <button class="nav-item {{ $qeActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        <span data-i18n="navQe">QE</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'qe-capex' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.wallboard-capex') }}" data-i18n="navCapex">Wallboard CAPEX</a>
        <div class="nav-group {{ $newProjectActive ? 'open' : '' }}">
          <button class="nav-item {{ $newProjectActive ? 'active' : '' }}" data-toggle>
            <span data-i18n="navNewProject">New Project</span>
            <svg class="chev" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
          </button>
          <div class="sub-nav">
            <a class="{{ ($active ?? '') === 'qe-monitoring' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.monitoring') }}" data-i18n="navMonitoring">Monitoring</a>
            <a class="{{ ($active ?? '') === 'qe-monitoring-rp' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.monitoring-rp') }}" data-i18n="navMonitoringRp">Monitoring (Anggaran)</a>
            <a class="{{ ($active ?? '') === 'qe-listing' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.listing') }}" data-i18n="navListing">Listing</a>
            <a class="{{ ($active ?? '') === 'qe-approval-tl' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.approval-tl') }}" data-i18n="navApprovalTl">Approval TL</a>
            <a class="{{ ($active ?? '') === 'qe-approval-evidence' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.approval-evidence') }}" data-i18n="navApprovalEvidence">Approval Evidence</a>
            <a class="{{ ($active ?? '') === 'qe-approval-qe' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.approval-qe') }}" data-i18n="navApprovalQe">Approval QE</a>
            <a class="{{ ($active ?? '') === 'qe-approval-regional' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.approval-regional') }}" data-i18n="navApprovalRegional">Approval Regional</a>
            <a class="{{ ($active ?? '') === 'qe-dashboard-boq' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.dashboard-boq') }}" data-i18n="navDashboardBoq">Dashboard BOQ</a>
            <a class="{{ ($active ?? '') === 'qe-export' ? 'active' : '' }}" href="{{ route('project.dalapareg.qe.export-qe') }}" data-i18n="navExportQe">Export Nilai Anggaran New Project</a>
          </div>
        </div>
      </div>
    </div>

    <div class="nav-group {{ $nteActive ? 'open' : '' }}">
      <button class="nav-item {{ $nteActive ? 'active' : '' }}" data-toggle>
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2M2 13h20"/></svg>
        <span data-i18n="navNte">NTE</span>
        <svg class="chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="sub-nav">
        <a class="{{ ($active ?? '') === 'nte-stock' ? 'active' : '' }}" href="{{ route('project.dalapareg.nte.stock-opname') }}" data-i18n="navStockOpname">Stock Opname New</a>
      </div>
    </div>
  </nav>
</aside>

<a class="back-badge" href="/">
  <span class="mark"><img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" /></span>
  <span class="txt">Demo · Portfolio Reza Pratama</span>
</a>
