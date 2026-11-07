{{-- The real layout.blade.php renders a much larger level-gated menu tree. This miniature carries only
     the entries that actually resolve to a screen here — a dead menu item is worse than a missing one.
     $active is the top-level menu to highlight (workorder|assurance|matrix|ticketing|leaderboards|telegram). --}}
@php($active = $active ?? '')

<span class="mar alert alert-danger">
  <span class="mar-track">TOMMAN OPERATION # Update laporan WO maksimal 30 menit setelah tiba di lokasi pelanggan # Foto evidence wajib: ODP, redaman, dan hasil akhir instalasi # Tiket &gt; 24 jam otomatis dieskalasi ke Supervisor Sektor # Absen teknisi ditutup pukul 08.30 WITA # Demo UI portfolio — data pada halaman ini fiktif</span>
</span>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ route('project.tomman.workorder') }}"><span class="redxxx">TOM</span>MAN</a>
      <button type="button" class="navbar-toggle collapsed" data-target="#menu-main" aria-label="Menu">
        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
    </div>
    <div id="menu-main" class="navbar-collapse">
      <ul class="nav navbar-nav">

        <li class="{{ $active === 'workorder' ? 'active' : '' }}">
          <a href="{{ route('project.tomman.workorder') }}">Workorder</a>
        </li>

        <li class="{{ $active === 'assurance' ? 'active' : '' }}">
          <a href="{{ route('project.tomman.assurance') }}">Assurance</a>
        </li>

        <li class="dropdown {{ $active === 'matrix' ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle">Matrix<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('project.tomman.matrix') }}">All Sektor</a></li>
            <li><a href="{{ route('project.tomman.matrix') }}?sektor=ASR">Sektor ASR</a></li>
            <li><a href="{{ route('project.tomman.matrix') }}?sektor=PROV">Sektor PROV</a></li>
            <li><a href="{{ route('project.tomman.matrix') }}?sektor=INNER">Sektor Inner</a></li>
            <li><a href="{{ route('project.tomman.matrix') }}?sektor=OUTER">Sektor Outer</a></li>
          </ul>
        </li>

        <li class="{{ $active === 'ticketing' ? 'active' : '' }}">
          <a href="{{ route('project.tomman.ticketing') }}">Ticketing</a>
        </li>

        <li class="dropdown {{ $active === 'leaderboards' ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle">Leaderboards<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('project.tomman.leaderboards') }}?squad=ALPHA.ASR">Alpha ASR</a></li>
            <li><a href="{{ route('project.tomman.leaderboards') }}?squad=ALPHA.PROV">Alpha PROV</a></li>
            <li><a href="{{ route('project.tomman.leaderboards') }}?squad=DELTA.A">Delta A</a></li>
            <li><a href="{{ route('project.tomman.leaderboards') }}?squad=DELTA.B">Delta B</a></li>
          </ul>
        </li>

        <li class="{{ $active === 'telegram' ? 'active' : '' }}">
          <a href="{{ route('project.tomman.telegram') }}">Telegram</a>
        </li>

        <li><a href="{{ route('project.tomman.login') }}">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="toast-stack" id="toastStack"></div>

<a class="demo-badge" href="/">
  <span class="mark"><img src="/images/logo/mark-color-on-light.svg" alt="Reza Pratama" /></span>
  <span class="txt">Demo UI · Portfolio Reza Pratama</span>
</a>
