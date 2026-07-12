@extends('layouts.admin')
@section('title', 'Investments')
@section('breadcrumb', 'Investments')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Investment Logs</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Track every active investment, its progress and time to maturity.</p>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Invested</div>
                <div class="stat-value">${{ number_format($stats['total_invested'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Active Investments</div>
                <div class="stat-value">{{ number_format($stats['active_count']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-lightning-charge-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Active Capital</div>
                <div class="stat-value">${{ number_format($stats['active_amount'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Matured</div>
                <div class="stat-value">{{ number_format($stats['matured_count']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.investments.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
            <input type="text" name="q" value="{{ $search }}" class="profile-input" placeholder="Search user" style="max-width:260px;">
            <select name="status" class="profile-input" style="max-width:180px;">
                <option value="">All statuses</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active ({{ $counts['active'] }})</option>
                <option value="matured" {{ $status === 'matured' ? 'selected' : '' }}>Matured ({{ $counts['matured'] }})</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled ({{ $counts['cancelled'] }})</option>
            </select>
            <button type="submit" class="btn-dash-primary">Filter</button>
            @if($search || $status)
                <a href="{{ route('admin.investments.index') }}" class="btn-dash-outline">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>ROI</th>
                        <th>Start</th>
                        <th>Matures</th>
                        <th>Progress / Time Left</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($investments as $inv)
                    <tr>
                        <td>
                            @if($inv->user)
                                <a href="{{ route('admin.users.show', $inv->user) }}" style="color:var(--dash-pink); text-decoration:none;">{{ $inv->user->username }}</a>
                            @else — @endif
                        </td>
                        <td class="fw-semibold">{{ $inv->plan_name }}</td>
                        <td>${{ number_format($inv->amount, 2) }}</td>
                        <td style="font-size:.8rem;">{{ number_format($inv->roi_percentage, 0) }}% {{ $inv->roi_period }}<br><span class="text-muted">{{ $inv->duration_days }} days</span></td>
                        <td style="font-size:.8rem;">{{ $inv->start_date->format('M d, Y') }}</td>
                        <td style="font-size:.8rem;">{{ $inv->end_date->format('M d, Y') }}</td>
                        <td style="min-width:160px;">
                            @if($inv->status === 'active')
                                <div class="invest-progress-wrap">
                                    <div class="invest-progress-bar" style="width: {{ $inv->progress_percent }}%;"></div>
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    {{ $inv->progress_percent }}% &middot;
                                    @if($inv->days_remaining > 0)
                                        {{ $inv->days_remaining }} day(s) left
                                    @else
                                        due today
                                    @endif
                                </div>
                            @else
                                <span class="text-muted" style="font-size:.75rem;">—</span>
                            @endif
                        </td>
                        <td>{!! txn_badge($inv->status) !!}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No investments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $investments->links() }}</div>
@endsection
