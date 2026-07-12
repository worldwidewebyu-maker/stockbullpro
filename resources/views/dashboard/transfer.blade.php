@extends('layouts.dashboard')
@section('title', 'Fund Transfer')
@section('breadcrumb', 'Transfer')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Fund Transfer</h4>
</div>

@if(session('success'))
<div class="dash-alert-success mb-3"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-4 p-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- Balance card -->
                <div class="d-flex justify-content-center mb-4">
                    <div class="stat-card" style="min-width:280px;">
                        <div class="stat-icon" style="background:#f0f2f5; color:var(--dash-text-muted); box-shadow:none;">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="stat-info text-end ms-3">
                            <div class="stat-value">${{ number_format(auth()->user()->balance, 2) }}</div>
                            <div class="stat-label">Your Account Balance</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('dashboard.transfer.submit') }}">
                    @csrf

                    <div class="profile-field mb-3">
                        <label>Recipient Email or username <span style="color:var(--dash-pink);">*</span></label>
                        <input type="text" name="recipient"
                            class="profile-input @error('recipient') is-invalid @enderror"
                            value="{{ old('recipient') }}" required>
                        @error('recipient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="profile-field mb-3">
                        <label>Amount($) <span style="color:var(--dash-pink);">*</span></label>
                        <input type="number" name="amount" id="amount" step="any" min="0.01"
                            class="profile-input @error('amount') is-invalid @enderror"
                            placeholder="Enter amount you want to transfer to recipient"
                            value="{{ old('amount') }}" oninput="calcTransfer()" required>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <p class="mb-1" style="font-weight:700; color:var(--dash-text);">
                        Transfer Charges: <span style="color:var(--dash-pink);">{{ rtrim(rtrim(number_format($chargePercentage, 2), '0'), '.') }}%</span>
                    </p>
                    @if($chargePercentage > 0)
                    <p class="mb-3" style="font-size:.85rem; color:var(--dash-text-muted);">
                        Charge: <span id="chargeDisplay">$0.00</span> &nbsp;|&nbsp;
                        Total debited: <span id="totalDisplay">$0.00</span>
                    </p>
                    @endif

                    <button type="submit" class="btn-dash-primary mt-2">PROCEED</button>
                </form>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const transferCharge = {{ $chargePercentage }};
    function calcTransfer() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const charge = amount * (transferCharge / 100);
        const chargeEl = document.getElementById('chargeDisplay');
        const totalEl  = document.getElementById('totalDisplay');
        if (chargeEl) chargeEl.textContent = '$' + charge.toFixed(2);
        if (totalEl)  totalEl.textContent  = '$' + (amount + charge).toFixed(2);
    }
</script>
@endpush
@endsection
