@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

  <h1 class="page-title">Welcome, {{ auth()->user()->full_name ?? auth()->user()->username }}!</h1>

  <!-- Stats grid — row 1 -->
  <div class="row g-3 mb-3">

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Account Balance</div>
          <div class="stat-value">${{ number_format($stats['balance'], 2) }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-wallet2"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Total Profit</div>
          <div class="stat-value">${{ number_format($stats['total_profit'], 2) }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-briefcase-fill"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Total Bonus</div>
          <div class="stat-value">${{ number_format($stats['total_bonus'], 2) }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-gift-fill"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Referral Bonus</div>
          <div class="stat-value">${{ number_format($stats['referral_bonus'], 2) }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-stars"></i>
        </div>
      </div>
    </div>

  </div>

  <!-- Stats grid — row 2 -->
  <div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Total Deposited</div>
          <div class="stat-value">${{ number_format($stats['total_deposited'], 2) }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-tag-fill"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Total Withdrawal</div>
          <div class="stat-value">${{ number_format($stats['total_withdrawal'], 2) }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-arrow-left-right"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Referrals</div>
          <div class="stat-value">{{ $stats['referrals'] }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-people-fill"></i>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="stat-card">
        <div class="stat-info">
          <div class="stat-label">Managed Accounts</div>
          <div class="stat-value">{{ $stats['managed_accounts'] }}</div>
        </div>
        <div class="stat-icon">
          <i class="bi bi-grid-fill"></i>
        </div>
      </div>
    </div>

  </div>

  <!-- Active Plans -->
  <div class="section-heading">Active Plan(s) ({{ $activePlans->count() }})</div>

  @if($activePlans->isEmpty())
    <div class="empty-state mb-4">
      <p>You do not have an active investment at the moment.</p>
      <a href="{{ route('dashboard.invest') }}" class="btn-dash-primary">INVEST NOW</a>
    </div>
  @else
    <div class="row g-3 mb-4">
      @foreach($activePlans as $plan)
        <div class="col-xl-4 col-md-6">
          <div class="stat-card" style="flex-direction:column; align-items:stretch;">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="stat-value">{{ $plan->plan_name }}</div>
              <span class="badge-invest-active">Active</span>
            </div>
            <div class="stat-label mb-1">Invested: ${{ number_format($plan->amount, 2) }}</div>
            <div class="stat-label mb-2">{{ number_format($plan->roi_percentage, 0) }}% {{ $plan->roi_period }} &middot; {{ $plan->duration_days }} days</div>
            <div class="invest-progress-wrap">
              <div class="invest-progress-bar" style="width: {{ $plan->progress_percent }}%;"></div>
            </div>
            <div class="stat-label mt-1">{{ $plan->days_remaining }} day(s) remaining</div>
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <!-- Recent Transactions -->
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="section-heading mb-0">Recent transactions</div>
    <a href="{{ route('dashboard.transactions') }}" class="btn-dash-outline">VIEW ALL TRANSACTIONS</a>
  </div>

  <div class="dash-table mb-5">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Type</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentTransactions as $txn)
          <tr>
            <td>{{ $txn->created_at->format('M d, Y g:i A') }}</td>
            <td>{{ ucwords(str_replace('_', ' ', $txn->type)) }}</td>
            <td class="fw-semibold" style="color: {{ $txn->direction === 'credit' ? '#2e7d32' : '#c62828' }};">
              {{ $txn->direction === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
            </td>
          </tr>
        @empty
          <tr class="empty-row">
            <td colspan="3">No record yet</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Real Time Market Data -->
  <div class="section-heading" style="font-size:1.1rem; color:var(--dash-text); text-transform:uppercase; letter-spacing:.05em;">
    Real Time Market Data
  </div>

  <div class="dash-table" style="overflow:hidden; border-radius:.75rem;">
    <div class="tradingview-widget-container">
      <div class="tradingview-widget-container__widget"></div>
      <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js" async>
      {
        "width": "100%",
        "height": 450,
        "currencies": [
          "EUR", "USD", "JPY", "GBP", "CHF", "AUD", "CAD", "NZD", "CNY", "TRY", "SEK", "NOK"
        ],
        "isTransparent": true,
        "colorTheme": "light",
        "locale": "en"
      }
      </script>
    </div>
  </div>

@endsection
