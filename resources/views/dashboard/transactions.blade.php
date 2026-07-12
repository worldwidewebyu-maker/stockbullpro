@extends('layouts.dashboard')
@section('title', 'Transaction History')
@section('breadcrumb', 'Transaction History')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Account transactions history</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">All your transaction history in one place.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">

        {{-- Tabs --}}
        <div class="txn-tabs">
            <button class="txn-tab active" data-tab="deposits">Deposit</button>
            <button class="txn-tab" data-tab="withdrawals">Withdrawal</button>
            <button class="txn-tab" data-tab="transfers">Transfer</button>
            <button class="txn-tab" data-tab="others">Others</button>
        </div>

        {{-- Deposit Table --}}
        <div class="txn-panel" id="tab-deposits">
            <div class="table-responsive">
                <table class="table dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $dep)
                        <tr>
                            <td class="fw-semibold">${{ number_format($dep->amount, 2) }}</td>
                            <td>{{ $dep->method?->name ?? '—' }}</td>
                            <td>{!! txn_badge($dep->status) !!}</td>
                            <td>{{ $dep->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No deposit records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Withdrawal Table --}}
        <div class="txn-panel d-none" id="tab-withdrawals">
            <div class="table-responsive">
                <table class="table dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Amount Requested</th>
                            <th>Amount + Charges</th>
                            <th>Receiving Mode</th>
                            <th>Status</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $wd)
                        <tr>
                            <td class="fw-semibold">${{ number_format($wd->amount, 2) }}</td>
                            <td>${{ number_format($wd->final_amount, 2) }}
                                @if($wd->charge > 0)
                                    <small class="text-muted">(+${{ number_format($wd->charge, 2) }} fee)</small>
                                @endif
                            </td>
                            <td>{{ $wd->method?->name ?? '—' }}</td>
                            <td>{!! txn_badge($wd->status) !!}</td>
                            <td>{{ $wd->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No withdrawal records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Transfer Table --}}
        <div class="txn-panel d-none" id="tab-transfers">
            <div class="table-responsive">
                <table class="table dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Direction</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Charge</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $tr)
                        @php $isSent = $tr->sender_id === auth()->id(); @endphp
                        <tr>
                            <td>
                                @if($isSent)
                                    <span class="badge-txn-danger">Sent</span>
                                @else
                                    <span class="badge-txn-success">Received</span>
                                @endif
                            </td>
                            <td>{{ $isSent ? ($tr->recipient?->username ?? '—') : ($tr->sender?->username ?? '—') }}</td>
                            <td class="fw-semibold" style="color: {{ $isSent ? '#c62828' : '#2e7d32' }};">
                                {{ $isSent ? '-' : '+' }}${{ number_format($tr->amount, 2) }}
                            </td>
                            <td>{{ $isSent ? '$'.number_format($tr->charge, 2) : '—' }}</td>
                            <td>{{ $tr->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No transfer records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Others Table (investments) --}}
        <div class="txn-panel d-none" id="tab-others">
            <div class="table-responsive">
                <table class="table dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Plan / Narration</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($others as $inv)
                        <tr>
                            <td class="fw-semibold">${{ number_format($inv->amount, 2) }}</td>
                            <td>Investment</td>
                            <td>{{ $inv->plan_name }}
                                <small class="text-muted d-block">{{ number_format($inv->roi_percentage, 0) }}% {{ $inv->roi_period }} · {{ $inv->duration_days }} days</small>
                            </td>
                            <td>{{ $inv->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No other transaction records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.txn-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.txn-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.txn-panel').forEach(p => p.classList.add('d-none'));
        this.classList.add('active');
        document.getElementById('tab-' + this.dataset.tab).classList.remove('d-none');
    });
});
</script>
@endpush
@endsection
