@extends('layouts.admin')
@section('title', 'Referrals: ' . $user->username)
@section('breadcrumb', 'Referrals')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
    <div>
        <h4 class="dash-page-title">{{ $user->username }}'s Referrals</h4>
        <p class="text-muted mb-0" style="font-size:.875rem">Referral code: <code>{{ $user->referral_code }}</code></p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.show', $user) }}" class="btn-dash-outline">User Profile</a>
        <a href="{{ route('admin.referrals.index') }}" class="btn-dash-outline">Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Referrals</div>
                <div class="stat-value">{{ $referredUsers->count() }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Earned</div>
                <div class="stat-value">${{ number_format($user->referral_total, 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-stars"></i></div>
        </div>
    </div>
</div>

<!-- Referred users -->
<div class="section-heading">Referred Users</div>
<div class="dash-table mb-4">
    <table>
        <thead>
            <tr><th>User</th><th>Email</th><th>Approved Deposits</th><th>Joined</th></tr>
        </thead>
        <tbody>
            @forelse($referredUsers as $ref)
            <tr>
                <td class="fw-semibold">
                    <a href="{{ route('admin.users.show', $ref) }}" style="color:var(--dash-pink); text-decoration:none;">{{ $ref->username }}</a>
                </td>
                <td>{{ $ref->email }}</td>
                <td>${{ number_format($ref->approved_deposits_sum ?? 0, 2) }}</td>
                <td>{{ $ref->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No referred users.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Earnings breakdown -->
<div class="section-heading">Earnings Breakdown</div>
<div class="dash-table">
    <table>
        <thead>
            <tr><th>From User</th><th>Bonus Earned</th><th>Deposit Amount</th><th>Date</th></tr>
        </thead>
        <tbody>
            @forelse($earnings as $earning)
            <tr>
                <td>{{ $earning->referred?->username ?? '—' }}</td>
                <td class="fw-semibold" style="color:#2e7d32;">+${{ number_format($earning->amount, 2) }}</td>
                <td>${{ number_format($earning->deposit?->amount ?? 0, 2) }}</td>
                <td>{{ $earning->created_at->format('M d, Y g:i A') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No earnings yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
