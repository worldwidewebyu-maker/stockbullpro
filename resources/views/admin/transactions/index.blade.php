@extends('layouts.admin')
@section('title', 'Transactions')
@section('breadcrumb', 'Transactions')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Transaction History</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Complete ledger of every balance movement across the platform.</p>
</div>

<!-- Totals -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Transactions</div>
                <div class="stat-value">{{ number_format($totals['count']) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-list-ul"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Credits</div>
                <div class="stat-value" style="color:#2e7d32;">+${{ number_format($totals['credits'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-arrow-down-left-circle"></i></div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-info">
                <div class="stat-label">Total Debits</div>
                <div class="stat-value" style="color:#c62828;">-${{ number_format($totals['debits'], 2) }}</div>
            </div>
            <div class="stat-icon"><i class="bi bi-arrow-up-right-circle"></i></div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="stat-label d-block mb-1">Search user</label>
                <input type="text" name="q" value="{{ $search }}" class="profile-input" placeholder="Username, email or name">
            </div>
            <div class="col-md-3">
                <label class="stat-label d-block mb-1">Type</label>
                <select name="type" class="profile-input">
                    <option value="">All types</option>
                    @foreach($types as $t)
                        <option value="{{ $t }}" {{ $type === $t ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $t)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="stat-label d-block mb-1">Direction</label>
                <select name="direction" class="profile-input">
                    <option value="">All</option>
                    <option value="credit" {{ $direction === 'credit' ? 'selected' : '' }}>Credit</option>
                    <option value="debit" {{ $direction === 'debit' ? 'selected' : '' }}>Debit</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn-dash-primary">Filter</button>
                @if($search || $type || $direction)
                    <a href="{{ route('admin.transactions.index') }}" class="btn-dash-outline">Clear</a>
                @endif
            </div>
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
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance After</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                    <tr>
                        <td>
                            @if($txn->user)
                                <a href="{{ route('admin.users.show', $txn->user) }}" style="color:var(--dash-pink); text-decoration:none;">{{ $txn->user->username }}</a>
                            @else — @endif
                        </td>
                        <td>{{ ucwords(str_replace('_', ' ', $txn->type)) }}</td>
                        <td class="fw-semibold" style="color: {{ $txn->direction === 'credit' ? '#2e7d32' : '#c62828' }};">
                            {{ $txn->direction === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                        </td>
                        <td>${{ number_format($txn->balance_after, 2) }}</td>
                        <td style="font-size:.8rem;">{{ $txn->description ?? '—' }}</td>
                        <td style="font-size:.8rem;">{{ $txn->created_at->format('M d, Y g:i A') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No transactions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
