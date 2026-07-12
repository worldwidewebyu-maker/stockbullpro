@extends('layouts.dashboard')

@section('title', 'Make Payment')
@section('breadcrumb', 'Deposit')

@section('content')

  <h1 class="page-title">Make payment</h1>

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <div style="background:#fff; border-radius:.75rem; padding:2rem; box-shadow:0 1px 6px rgba(0,0,0,.06); border:1px solid #f0f0f0;">

        <!-- Payment method header -->
        <div class="payment-method-header">
          <div>
            <div class="method-label">Your Payment Method</div>
            <div class="method-name">{{ $method->name }}</div>
          </div>
        </div>

        <p class="mb-4" style="font-size:.9rem; font-weight:600;">
          You are to make payment of
          <strong style="color:#cb0c9f;">${{ number_format($amount, 2) }}</strong>
          using your selected payment method.
        </p>

        <form method="POST" action="{{ route('dashboard.deposit.confirm', $method) }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="amount" value="{{ $amount }}">

          <!-- Wallet address -->
          <div class="dash-form-group mb-3">
            <label style="font-weight:700;">{{ $method->name }} Address:</label>
            <div class="address-box">
              <span class="address-text" id="walletAddress">
                {{ $method->wallet_address ?: 'Contact support for wallet address' }}
              </span>
              @if($method->wallet_address)
                <button type="button" class="btn-copy" id="copyBtn" onclick="copyAddress()">Copy</button>
              @endif
            </div>
          </div>

          <!-- Network type -->
          @if($method->network_type)
            <p class="mb-4" style="font-size:.875rem;">
              <strong>Network Type:</strong>
              <span style="color:#7b809a;">{{ $method->network_type }}</span>
            </p>
          @endif

          <!-- QR Code -->
          @if($method->qr_code_url)
            <div class="mb-4 text-center">
              <p style="font-size:.875rem; font-weight:600; margin-bottom:.75rem;">Scan QR Code to pay:</p>
              <img
                src="{{ $method->qr_code_url }}"
                alt="{{ $method->name }} QR Code"
                style="max-width:200px; border:1px solid #e9ecef; border-radius:.5rem; padding:8px;"
              >
            </div>
          @endif

          <!-- Charge info -->
          @if($method->charge_amount > 0)
            <div style="background:#f8f9fa; border-radius:.5rem; padding:1rem 1.2rem; margin-bottom:1.5rem; font-size:.875rem;">
              <div class="d-flex justify-content-between">
                <span style="color:#7b809a;">
                  Charge ({{ $method->charge_type === 'percentage' ? $method->charge_amount.'%' : '$'.number_format($method->charge_amount,2) }})
                </span>
                <span style="font-weight:600;">${{ number_format($method->calculateCharge($amount), 2) }}</span>
              </div>
            </div>
          @endif

          <!-- Upload proof -->
          <div class="dash-form-group mb-4">
            <label>Upload Payment proof after payment.</label>
            <input
              type="file"
              name="proof"
              class="form-control @error('proof') is-invalid @enderror"
              accept="image/jpeg,image/png,image/webp,.pdf"
              required
            >
            @error('proof') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn-dash-primary">MARK AS COMPLETED</button>
          <a href="{{ route('dashboard.deposit') }}" class="btn-dash-outline ms-2">CANCEL</a>

        </form>

      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  function copyAddress() {
    const addr = document.getElementById('walletAddress').textContent.trim();
    navigator.clipboard.writeText(addr).then(() => {
      const btn = document.getElementById('copyBtn');
      btn.textContent = 'Copied!';
      setTimeout(() => btn.textContent = 'Copy', 2000);
    });
  }
</script>
@endpush
