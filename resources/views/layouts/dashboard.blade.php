<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') - Bull Pro</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap + Icons -->
  <link href="{{ asset('bizland/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- Dashboard CSS -->
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

  @stack('styles')
</head>

<body class="dashboard-body">

  @if(session('impersonator_id'))
    <div style="background:#cb0c9f; color:#fff; padding:.6rem 1rem; display:flex; align-items:center; justify-content:center; gap:1rem; font-size:.85rem; flex-wrap:wrap; position:sticky; top:0; z-index:200;">
      <span><i class="bi bi-eye-fill me-1"></i> You are viewing as <strong>{{ auth()->user()->username }}</strong> (admin).</span>
      <form method="POST" action="{{ route('admin.impersonate.stop') }}" class="m-0">
        @csrf
        <button type="submit" style="background:#fff; color:#cb0c9f; border:none; border-radius:.4rem; padding:.25rem .8rem; font-weight:700; font-size:.75rem; cursor:pointer;">
          Return to admin
        </button>
      </form>
    </div>
  @endif

  <!-- Sidebar overlay (mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- ══ SIDEBAR ══════════════════════════════════════════════ -->
  <aside class="dash-sidebar" id="dashSidebar">

    <!-- Logo -->
    <a href="{{ route('dashboard.index') }}" class="dash-sidebar-logo">
      <i class="bi bi-graph-up-arrow" style="font-size:1.8rem; color:#cb0c9f;"></i>
      <span>Bull Pro</span>
    </a>

    <hr>

    <!-- Navigation -->
    <nav class="dash-nav">
      <div class="nav-label">Pages</div>

      <a href="{{ route('dashboard.index') }}"
         class="{{ Route::is('dashboard.index') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>

      <a href="{{ route('dashboard.deposit') }}"
         class="{{ Route::is('dashboard.deposit*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-credit-card"></i></span>
        <span class="nav-text">Deposit</span>
      </a>

      <a href="{{ route('dashboard.withdraw') }}"
         class="{{ Route::is('dashboard.withdraw*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-arrow-up-circle"></i></span>
        <span class="nav-text">Withdraw</span>
      </a>

      <a href="{{ route('dashboard.invest') }}"
         class="{{ Route::is('dashboard.invest*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-layers"></i></span>
        <span class="nav-text">Invest Now</span>
      </a>

      <a href="{{ route('dashboard.plans') }}"
         class="{{ Route::is('dashboard.plans*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-journal-text"></i></span>
        <span class="nav-text">My Investment Plans</span>
      </a>

      <a href="{{ route('dashboard.transactions') }}"
         class="{{ Route::is('dashboard.transactions*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-list-ul"></i></span>
        <span class="nav-text">Transaction History</span>
      </a>

      <a href="{{ route('dashboard.profile') }}"
         class="{{ Route::is('dashboard.profile*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-person-circle"></i></span>
        <span class="nav-text">Profile</span>
      </a>

      <a href="{{ route('dashboard.swap') }}"
         class="{{ Route::is('dashboard.swap*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-arrow-left-right"></i></span>
        <span class="nav-text">Crypto Swap</span>
      </a>

      <a href="{{ route('dashboard.transfer') }}"
         class="{{ Route::is('dashboard.transfer*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-send-fill"></i></span>
        <span class="nav-text">Transfer</span>
      </a>

      <a href="{{ route('dashboard.referrals') }}"
         class="{{ Route::is('dashboard.referrals*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-person-plus-fill"></i></span>
        <span class="nav-text">Referrals</span>
      </a>

      <form method="POST" action="{{ route('logout') }}" class="mt-1">
        @csrf
        <button type="submit" style="width:100%; background:none; border:none; padding:0; text-align:left; cursor:pointer;">
          <span class="d-flex align-items-center gap-3 px-3 py-2" style="border-radius:.75rem; color:#7b809a; font-size:.875rem; font-weight:500; transition:background .2s;" onmouseover="this.style.background='#f8f9fa';this.style.color='#344767';" onmouseout="this.style.background='transparent';this.style.color='#7b809a';">
            <span class="nav-icon" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:.5rem;background:#f8f9fa;"><i class="bi bi-box-arrow-right"></i></span>
            <span>Logout</span>
          </span>
        </button>
      </form>
    </nav>

    <!-- Help card -->
    <div class="dash-help-card">
      <div class="help-icon">
        <i class="bi {{ $whatsappLink ? 'bi-whatsapp' : 'bi-diamond-fill' }}"></i>
      </div>
      <p>Need help?</p>
      @if($whatsappLink)
        <a href="{{ $whatsappLink }}" target="_blank" rel="noopener noreferrer">WHATSAPP</a>
      @else
        <a href="{{ route('home') }}#contact">SUPPORT</a>
      @endif
    </div>

  </aside>
  <!-- ══ /SIDEBAR ══════════════════════════════════════════════ -->

  <!-- ══ MAIN ══════════════════════════════════════════════════ -->
  <div class="dash-main">

    <!-- Top bar -->
    <div class="dash-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="sidebar-toggle" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Bull Pro</a></li>
            <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
          </ol>
        </nav>
      </div>
      <button class="btn-topbar" title="Fullscreen" onclick="toggleFullscreen()">
        <i class="bi bi-fullscreen"></i>
      </button>
    </div>

    <!-- Page content -->
    <div class="dash-content">
      @if(session('success'))
        <div class="dash-alert-success">
          <i class="bi bi-hand-thumbs-up-fill"></i>
          {{ session('success') }}
          <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#fff;font-size:1rem;cursor:pointer;">&times;</button>
        </div>
      @endif

      @yield('content')
    </div>

    <!-- Footer -->
    <div class="dash-footer">
      © {{ date('Y') }}, Bull Pro
    </div>

  </div>
  <!-- ══ /MAIN ══════════════════════════════════════════════════ -->

  <!-- Bootstrap JS -->
  <script src="{{ asset('bizland/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    // Mobile sidebar toggle
    const sidebar  = document.getElementById('dashSidebar');
    const overlay  = document.getElementById('sidebarOverlay');
    const toggle   = document.getElementById('sidebarToggle');

    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('open');
    });
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('open');
    });

    // Fullscreen
    function toggleFullscreen() {
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
      } else {
        document.exitFullscreen();
      }
    }
  </script>

  @stack('scripts')

</body>
</html>
