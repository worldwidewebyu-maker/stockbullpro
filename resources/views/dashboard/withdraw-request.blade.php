@extends('layouts.dashboard')

@section('title', 'Complete Withdrawal Request')
@section('breadcrumb', 'Withdraw')

@section('content')

  <h1 class="page-title">Complete withdrawal request</h1>

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div style="background:#fff; border-radius:.75rem; padding:2rem; box-shadow:0 1px 6px rgba(0,0,0,.06); border:1px solid #f0f0f0;">

        <h4 style="font-size:1.4rem; font-weight:700; color:var(--dash-text); margin-bottom:1.5rem;">
          {{ $method->name }}
        </h4>

        <form method="POST" action="{{ route('dashboard.withdraw.submit', $method) }}">
          @csrf

          <div class="dash-form-group mb-4">
            <label for="wallet_address">Your {{ $method->name }} wallet address</label>
            <input
              type="text"
              id="wallet_address"
              name="wallet_address"
              class="form-control @error('wallet_address') is-invalid @enderror"
              placeholder="Enter your {{ $method->name }} wallet address"
              value="{{ old('wallet_address') }}"
              required
            >
            @error('wallet_address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="dash-form-group mb-4">
            <label for="amount">Enter Amount to withdraw($)</label>
            <input
              type="number"
              id="amount"
              name="amount"
              class="form-control @error('amount') is-invalid @enderror"
              placeholder="Enter Amount"
              min="{{ $method->min_amount }}"
              max="{{ $method->max_amount }}"
              step="any"
              value="{{ old('amount') }}"
              oninput="calcCharge()"
              required
            >
            @error('amount')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small style="color:var(--dash-text-muted);">
              Min: ${{ number_format($method->min_amount, 2) }} &nbsp;|&nbsp;
              Max: ${{ number_format($method->max_amount, 2) }}
            </small>
          </div>

          <!-- Charge preview -->
          <div style="background:#f8f9fa; border-radius:.5rem; padding:1rem 1.2rem; margin-bottom:1.5rem; font-size:.875rem;">
            <div class="d-flex justify-content-between mb-1">
              <span style="color:var(--dash-text-muted);">Charge ({{ $method->charge_type === 'percentage' ? $method->charge_amount.'%' : '$'.number_format($method->charge_amount,2) }})</span>
              <span id="chargeDisplay" style="font-weight:600;">$0.00</span>
            </div>
            <div class="d-flex justify-content-between">
              <span style="color:var(--dash-text-muted);">You will receive</span>
              <span id="receiveDisplay" style="font-weight:700; color:var(--dash-pink);">$0.00</span>
            </div>
          </div>

          <button type="submit" class="btn-dash-primary">COMPLETE REQUEST</button>
          <a href="{{ route('dashboard.withdraw') }}" class="btn-dash-outline ms-2">CANCEL</a>

        </form>

      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  const chargeType   = '{{ $method->charge_type }}';
  const chargeAmount = {{ $method->charge_amount }};

  function calcCharge() {
    const amount = parseFloat(document.getElementById('amount').value) || 0;
    let charge = 0;

    if (chargeType === 'percentage') {
      charge = amount * (chargeAmount / 100);
    } else {
      charge = chargeAmount;
    }

    const receive = Math.max(0, amount - charge);
    document.getElementById('chargeDisplay').textContent  = '$' + charge.toFixed(2);
    document.getElementById('receiveDisplay').textContent = '$' + receive.toFixed(2);
  }
</script>
@endpush
