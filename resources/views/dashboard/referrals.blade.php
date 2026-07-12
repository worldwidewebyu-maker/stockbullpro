@extends('layouts.dashboard')
@section('title', 'Referrals')
@section('breadcrumb', 'Referrals')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Referrals</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Invite friends and earn a bonus on their deposits.</p>
</div>

@if(! $stats['enabled'])
<div class="dash-alert-success mb-3" style="background:#ff9800;">
    <i class="bi bi-info-circle"></i> The referral program is currently unavailable. Please check back later.
</div>
@endif

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Referrals</div>
                <div class="stat-value">{{ $stats['total_referrals'] }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Referral Earnings</div>
                <div class="stat-value">${{ number_format($stats['total_earned'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-stars"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Commission Rate</div>
                <div class="stat-value">{{ rtrim(rtrim(number_format($stats['percentage'], 2), '0'), '.') }}%</div>
            </div>
            <div class="stat-icon"><i class="bi bi-percent"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Earn On First</div>
                <div class="stat-value">{{ $stats['max_deposits'] ? $stats['max_deposits'].' deposit(s)' : 'Unlimited' }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-hash"></i></div>
        </div>
    </div>
</div>

<!-- Referral link -->
<div class="card shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="profile-section-title">Your referral link</h5>
        <p class="text-muted" style="font-size:.85rem">
            Share this link. You earn <strong>{{ rtrim(rtrim(number_format($stats['percentage'], 2), '0'), '.') }}%</strong>
            of each referred user's approved deposits{{ $stats['max_deposits'] ? ', for their first '.$stats['max_deposits'].' deposit(s)' : '' }}.
        </p>

        <div class="address-box mb-3">
            <span class="address-text" id="refLink">{{ $stats['referral_link'] }}</span>
            <button class="btn-copy" type="button" onclick="copyRef('{{ $stats['referral_link'] }}', this)">Copy</button>
        </div>

        <div class="profile-field" style="max-width:220px;">
            <label>Your referral code</label>
            <div class="address-box">
                <span class="address-text">{{ $stats['referral_code'] }}</span>
                <button class="btn-copy" type="button" onclick="copyRef('{{ $stats['referral_code'] }}', this)">Copy</button>
            </div>
        </div>
    </div>
</div>

<!-- Referred users -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Country</th>
                        <th>Approved Deposits</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referredUsers as $ref)
                    <tr>
                        <td class="fw-semibold">{{ $ref->username }}</td>
                        <td>{{ $ref->country }}</td>
                        <td>${{ number_format($ref->approved_deposits_sum ?? 0, 2) }}</td>
                        <td>{{ $ref->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">You haven't referred anyone yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyRef(text, btn) {
    navigator.clipboard.writeText(text).then(function () {
        const original = btn.textContent;
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = original, 1500);
    });
}
</script>
@endpush
@endsection
