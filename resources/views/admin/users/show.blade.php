@extends('layouts.admin')
@section('title', 'User: ' . $user->username)
@section('breadcrumb', $user->username)

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
    <div>
        <h4 class="dash-page-title">{{ $user->full_name }} <span class="text-muted">(&#64;{{ $user->username }})</span></h4>
        <p class="text-muted mb-0" style="font-size:.875rem">{{ $user->email }} &middot; Joined {{ $user->created_at->format('M d, Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('admin.users.impersonate', $user) }}"
              onsubmit="return confirm('Log in silently as {{ $user->username }}? You will be redirected to their dashboard.');">
            @csrf
            <button type="submit" class="btn-dash-outline"><i class="bi bi-box-arrow-in-right"></i> Login as user</button>
        </form>
        <a href="{{ route('admin.users.index') }}" class="btn-dash-outline">Back</a>
    </div>
</div>

@if($errors->any())
<div class="dash-alert-success mb-3" style="background:#dc3545;">
    <i class="bi bi-exclamation-triangle"></i> {{ $errors->first() }}
</div>
@endif

<!-- Balances -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Account Balance</div>
                <div class="stat-value">${{ number_format($user->balance, 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Profit</div>
                <div class="stat-value">${{ number_format($user->profit_total, 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Bonus</div>
                <div class="stat-value">${{ number_format($user->bonus_total, 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-gift-fill"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Referral Bonus</div>
                <div class="stat-value">${{ number_format($user->referral_total, 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-stars"></i></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Fund / deduct -->
    <div class="col-lg-5">
        <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
                <h5 class="profile-section-title">Fund Account</h5>
                <p class="text-muted" style="font-size:.85rem">
                    Credit this user's balance directly. Creates an approved deposit and transaction record, and emails the user.
                </p>
                <form method="POST" action="{{ route('admin.users.fund', $user) }}">
                    @csrf
                    <div class="profile-field mb-3">
                        <label>Amount ($)</label>
                        <input type="number" name="amount" step="any" min="0.01"
                            class="profile-input @error('amount') is-invalid @enderror"
                            value="{{ old('amount') }}" required>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="profile-field mb-3">
                        <label>Note (optional)</label>
                        <input type="text" name="note" maxlength="255"
                            class="profile-input @error('note') is-invalid @enderror"
                            value="{{ old('note') }}" placeholder="e.g. Promotional credit">
                        @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn-dash-primary">
                        <i class="bi bi-cash-coin me-1"></i> Fund Account
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="profile-section-title">Deduct from Account</h5>
                <p class="text-muted" style="font-size:.85rem">
                    Remove funds from this user's spendable balance. Recorded as an adjustment in the transaction ledger, and emails the user.
                </p>
                <form method="POST" action="{{ route('admin.users.deduct', $user) }}"
                      onsubmit="return confirm('Deduct funds from {{ $user->username }}? This cannot be undone.');">
                    @csrf
                    <div class="profile-field mb-3">
                        <label>Amount ($)</label>
                        <input type="number" name="amount" step="any" min="0.01" max="{{ $user->balance }}"
                            class="profile-input @error('amount') is-invalid @enderror"
                            value="{{ old('amount') }}" required>
                        <small class="text-muted">Available: ${{ number_format($user->balance, 2) }}</small>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="profile-field mb-3">
                        <label>Note (optional)</label>
                        <input type="text" name="note" maxlength="255"
                            class="profile-input @error('note') is-invalid @enderror"
                            value="{{ old('note') }}" placeholder="e.g. Correction / penalty">
                        @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn-dash-outline" style="color:#dc3545; border-color:#dc3545;">
                        <i class="bi bi-dash-circle me-1"></i> Deduct Funds
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile & referral -->
    <div class="col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="profile-section-title">Profile & Referrals</h5>
                <div class="row g-3">
                    <div class="col-md-6"><div class="stat-label">Phone</div><div>{{ $user->phone ?: '—' }}</div></div>
                    <div class="col-md-6"><div class="stat-label">Country</div><div>{{ $user->country }}</div></div>
                    <div class="col-md-6"><div class="stat-label">Email verified</div><div>{{ $user->email_verified_at ? 'Yes' : 'No' }}</div></div>
                    <div class="col-md-6"><div class="stat-label">Referral code</div><div>{{ $user->referral_code }}</div></div>
                    <div class="col-md-6"><div class="stat-label">Referred by</div><div>{{ optional($user->referrer)->username ?? '—' }}</div></div>
                    <div class="col-md-6"><div class="stat-label">Total referrals</div><div>{{ $user->referrals_count }}</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deposits -->
<div class="section-heading">Recent Deposits</div>
<div class="dash-table mb-4">
    <table>
        <thead><tr><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($deposits as $dep)
            <tr>
                <td class="fw-semibold">${{ number_format($dep->amount, 2) }}</td>
                <td>{{ $dep->method?->name ?? 'Admin Credit' }}</td>
                <td>{!! txn_badge($dep->status) !!}</td>
                <td>{{ $dep->created_at->format('M d, Y g:i A') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No deposits</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Withdrawals -->
<div class="section-heading">Recent Withdrawals</div>
<div class="dash-table mb-4">
    <table>
        <thead><tr><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($withdrawals as $wd)
            <tr>
                <td class="fw-semibold">${{ number_format($wd->amount, 2) }}</td>
                <td>{{ $wd->method?->name ?? '—' }}</td>
                <td>{!! txn_badge($wd->status) !!}</td>
                <td>{{ $wd->created_at->format('M d, Y g:i A') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No withdrawals</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Investments -->
<div class="section-heading">Investments</div>
<div class="dash-table mb-4">
    <table>
        <thead><tr><th>Plan</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($investments as $inv)
            <tr>
                <td>{{ $inv->plan_name }}</td>
                <td class="fw-semibold">${{ number_format($inv->amount, 2) }}</td>
                <td>{!! txn_badge($inv->status) !!}</td>
                <td>{{ $inv->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No investments</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Transfers -->
<div class="section-heading">Transfers</div>
<div class="dash-table mb-4">
    <table>
        <thead><tr><th>Direction</th><th>Counterparty</th><th>Amount</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($transfers as $tr)
            @php $isSent = $tr->sender_id === $user->id; @endphp
            <tr>
                <td>{!! $isSent ? '<span class="badge-txn-danger">Sent</span>' : '<span class="badge-txn-success">Received</span>' !!}</td>
                <td>{{ $isSent ? ($tr->recipient?->username ?? '—') : ($tr->sender?->username ?? '—') }}</td>
                <td class="fw-semibold">{{ $isSent ? '-' : '+' }}${{ number_format($tr->amount, 2) }}</td>
                <td>{{ $tr->created_at->format('M d, Y g:i A') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="4">No transfers</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Ledger -->
<div class="section-heading">Transaction Ledger</div>
<div class="dash-table mb-4">
    <table>
        <thead><tr><th>Type</th><th>Amount</th><th>Balance After</th><th>Description</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($transactions as $txn)
            <tr>
                <td>{{ ucwords(str_replace('_', ' ', $txn->type)) }}</td>
                <td class="fw-semibold" style="color: {{ $txn->direction === 'credit' ? '#2e7d32' : '#c62828' }};">
                    {{ $txn->direction === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                </td>
                <td>${{ number_format($txn->balance_after, 2) }}</td>
                <td>{{ $txn->description ?? '—' }}</td>
                <td>{{ $txn->created_at->format('M d, Y g:i A') }}</td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="5">No transactions</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
