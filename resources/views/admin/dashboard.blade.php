@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Admin Dashboard</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Platform overview at a glance.</p>
</div>

<!-- Stats row 1 -->
<div class="row g-3 mb-3">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Deposited</div>
                <div class="stat-value">${{ number_format($stats['total_deposited'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Withdrawn</div>
                <div class="stat-value">${{ number_format($stats['total_withdrawn'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-arrow-up-circle"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Platform Liability</div>
                <div class="stat-value">${{ number_format($stats['platform_liability'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
        </div>
    </div>
</div>

<!-- Stats row 2 -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Pending Deposits</div>
                <div class="stat-value">{{ number_format($stats['pending_deposits']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Pending Withdrawals</div>
                <div class="stat-value">{{ number_format($stats['pending_withdrawals']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Active Investments</div>
                <div class="stat-value">${{ number_format($stats['active_investments'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent users -->
    <div class="col-lg-4">
        <div class="section-heading">Recent Users</div>
        <div class="dash-table">
            <table>
                <thead>
                    <tr><th>User</th><th>Balance</th></tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $u)
                    <tr>
                        <td><a href="{{ route('admin.users.show', $u) }}" style="color:var(--dash-pink); text-decoration:none;">{{ $u->username }}</a></td>
                        <td>${{ number_format($u->balance, 2) }}</td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="2">No users yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent deposits -->
    <div class="col-lg-4">
        <div class="section-heading">Recent Deposits</div>
        <div class="dash-table">
            <table>
                <thead>
                    <tr><th>User</th><th>Amount</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($recentDeposits as $dep)
                    <tr>
                        <td>{{ $dep->user?->username ?? '—' }}</td>
                        <td>${{ number_format($dep->amount, 2) }}</td>
                        <td>{!! txn_badge($dep->status) !!}</td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="3">No deposits yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent withdrawals -->
    <div class="col-lg-4">
        <div class="section-heading">Recent Withdrawals</div>
        <div class="dash-table">
            <table>
                <thead>
                    <tr><th>User</th><th>Amount</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($recentWithdrawals as $wd)
                    <tr>
                        <td>{{ $wd->user?->username ?? '—' }}</td>
                        <td>${{ number_format($wd->amount, 2) }}</td>
                        <td>{!! txn_badge($wd->status) !!}</td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="3">No withdrawals yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
