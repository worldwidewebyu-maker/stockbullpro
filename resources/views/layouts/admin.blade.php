<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') - Bull Pro</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="{{ asset('bizland/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

  @stack('styles')
</head>

<body class="dashboard-body">

  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- Sidebar -->
  <aside class="dash-sidebar" id="dashSidebar">

    <a href="{{ route('admin.dashboard') }}" class="dash-sidebar-logo">
      <i class="bi bi-shield-lock-fill" style="font-size:1.8rem; color:#cb0c9f;"></i>
      <span>Bull Pro Admin</span>
    </a>

    <hr>

    <nav class="dash-nav">
      <div class="nav-label">Management</div>

      <a href="{{ route('admin.dashboard') }}"
         class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span>
        <span class="nav-text">Dashboard</span>
      </a>

      <a href="{{ route('admin.users.index') }}"
         class="{{ Route::is('admin.users.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-people-fill"></i></span>
        <span class="nav-text">Users</span>
      </a>

      <a href="{{ route('admin.deposit-methods.index') }}"
         class="{{ Route::is('admin.deposit-methods.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-currency-bitcoin"></i></span>
        <span class="nav-text">Deposit Methods</span>
      </a>

      <a href="{{ route('admin.deposits.index') }}"
         class="{{ Route::is('admin.deposits.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-cash-stack"></i></span>
        <span class="nav-text">Deposit Logs</span>
      </a>

      <a href="{{ route('admin.withdrawal-methods.index') }}"
         class="{{ Route::is('admin.withdrawal-methods.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-bank"></i></span>
        <span class="nav-text">Withdrawal Methods</span>
      </a>

      <a href="{{ route('admin.withdrawals.index') }}"
         class="{{ Route::is('admin.withdrawals.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-arrow-up-circle"></i></span>
        <span class="nav-text">Withdrawal Logs</span>
      </a>

      <a href="{{ route('admin.investments.index') }}"
         class="{{ Route::is('admin.investments.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-graph-up-arrow"></i></span>
        <span class="nav-text">Investments</span>
      </a>

      <a href="{{ route('admin.referrals.index') }}"
         class="{{ Route::is('admin.referrals.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-person-plus-fill"></i></span>
        <span class="nav-text">Referrals</span>
      </a>

      <a href="{{ route('admin.transactions.index') }}"
         class="{{ Route::is('admin.transactions.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-list-ul"></i></span>
        <span class="nav-text">Transactions</span>
      </a>

      <div class="nav-label mt-3">Content &amp; Comms</div>

      <a href="{{ route('admin.settings.index') }}"
         class="{{ Route::is('admin.settings.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-gear-fill"></i></span>
        <span class="nav-text">Settings</span>
      </a>

      <a href="{{ route('admin.faqs.index') }}"
         class="{{ Route::is('admin.faqs.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-question-circle-fill"></i></span>
        <span class="nav-text">FAQs</span>
      </a>

      <a href="{{ route('admin.mail.create') }}"
         class="{{ Route::is('admin.mail.*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="bi bi-envelope-fill"></i></span>
        <span class="nav-text">Send Email</span>
      </a>

      <form method="POST" action="{{ route('admin.logout') }}" class="mt-1">
        @csrf
        <button type="submit" style="width:100%; background:none; border:none; padding:0; text-align:left; cursor:pointer;">
          <span class="d-flex align-items-center gap-3 px-3 py-2" style="border-radius:.75rem; color:#7b809a; font-size:.875rem; font-weight:500;" onmouseover="this.style.background='#f8f9fa';this.style.color='#344767';" onmouseout="this.style.background='transparent';this.style.color='#7b809a';">
            <span class="nav-icon" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:.5rem;background:#f8f9fa;"><i class="bi bi-box-arrow-right"></i></span>
            <span>Logout</span>
          </span>
        </button>
      </form>
    </nav>

  </aside>

  <!-- Main -->
  <div class="dash-main">

    <div class="dash-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="sidebar-toggle" id="sidebarToggle">
          <i class="bi bi-list"></i>
        </button>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
            <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
          </ol>
        </nav>
      </div>
      <div class="d-flex align-items-center gap-2">
        <span class="text-muted" style="font-size:.8rem;">{{ auth()->user()->full_name }}</span>
      </div>
    </div>

    <div class="dash-content">
      @if(session('success'))
        <div class="dash-alert-success">
          <i class="bi bi-check-circle"></i>
          {{ session('success') }}
          <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#fff;font-size:1rem;cursor:pointer;">&times;</button>
        </div>
      @endif

      @if(session('error'))
        <div class="dash-alert-success" style="background:#dc3545;">
          <i class="bi bi-exclamation-triangle"></i>
          {{ session('error') }}
          <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:#fff;font-size:1rem;cursor:pointer;">&times;</button>
        </div>
      @endif

      @yield('content')
    </div>

    <div class="dash-footer">
      © {{ date('Y') }}, Bull Pro Admin
    </div>

  </div>

  <script src="{{ asset('bizland/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script>
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
  </script>

  @stack('scripts')

</body>
</html>
