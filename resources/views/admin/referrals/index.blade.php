@extends('layouts.admin')
@section('title', 'Referrals')
@section('breadcrumb', 'Referrals')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Referrals</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">
        Users who have referred others and their earnings.
        @if($stats['enabled'])
            Program pays <strong>{{ rtrim(rtrim(number_format($stats['percentage'], 2), '0'), '.') }}%</strong>
            on the first <strong>{{ $stats['max_deposits'] ? $stats['max_deposits'].' deposit(s)' : 'unlimited deposits' }}</strong> per referral.
        @else
            <span style="color:#dc3545;">Referral program is currently disabled.</span>
        @endif
    </p>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Active Referrers</div>
                <div class="stat-value">{{ number_format($stats['total_referrers']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-person-plus-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Referred Users</div>
                <div class="stat-value">{{ number_format($stats['total_referred']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Bonus Paid</div>
                <div class="stat-value">${{ number_format($stats['total_paid'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-stars"></i></div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.referrals.index') }}" class="d-flex gap-2">
            <input type="text" name="q" value="{{ $search }}" class="profile-input"
                placeholder="Search referrer by username, email or name" style="max-width:360px;">
            <button type="submit" class="btn-dash-primary">Search</button>
            @if($search)
                <a href="{{ route('admin.referrals.index') }}" class="btn-dash-outline">Clear</a>
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
                        <th>Referrer</th>
                        <th>Referral Code</th>
                        <th>Referrals</th>
                        <th>Earned</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referrers as $ref)
                    <tr>
                        <td class="fw-semibold">
                            <a href="{{ route('admin.users.show', $ref) }}" style="color:var(--dash-pink); text-decoration:none;">{{ $ref->username }}</a>
                            <div class="text-muted" style="font-size:.75rem;">{{ $ref->email }}</div>
                        </td>
                        <td><code>{{ $ref->referral_code }}</code></td>
                        <td>{{ $ref->referrals_count }}</td>
                        <td class="fw-semibold" style="color:#2e7d32;">${{ number_format($ref->referral_earned ?? 0, 2) }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.referrals.show', $ref) }}" class="btn-dash-outline" style="padding:.35rem .8rem; font-size:.7rem;">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No referrers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $referrers->links() }}</div>
@endsection
