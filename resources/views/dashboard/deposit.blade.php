@extends('layouts.dashboard')

@section('title', 'Deposit')
@section('breadcrumb', 'Deposit')

@section('content')

  <h1 class="page-title">Deposit into your account</h1>

  <div class="row g-4">

    <!-- Deposit form -->
    <div class="col-lg-8">

      @if($methods->isEmpty())
        <div class="empty-state">
          <p>No deposit methods are currently available. Please check back later.</p>
        </div>
      @else
        <form method="POST" action="" id="depositForm">
          @csrf

          <div class="dash-form-group mb-4">
            <label for="amount">Enter Amount</label>
            <input
              type="number"
              id="amount"
              name="amount"
              class="form-control @error('amount') is-invalid @enderror"
              placeholder="Enter Amount"
              min="1"
              step="any"
              value="{{ old('amount') }}"
              oninput="updateSummary()"
            >
            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="dash-form-group mb-4">
            <label for="method_id">Choose Payment Method from the list below</label>
            <select
              id="method_id"
              name="method_id"
              class="form-select @error('method_id') is-invalid @enderror"
              onchange="updateSummary()"
            >
              <option value="">Select Currency</option>
              @foreach($methods as $m)
                <option
                  value="{{ $m->id }}"
                  data-name="{{ $m->name }}"
                  data-min="{{ $m->min_amount }}"
                  data-charge-type="{{ $m->charge_type }}"
                  data-charge="{{ $m->charge_amount }}"
                  {{ old('method_id') == $m->id ? 'selected' : '' }}
                >{{ $m->name }}</option>
              @endforeach
            </select>
            @error('method_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn-dash-primary" id="proceedBtn">PROCEED TO PAYMENT</button>

        </form>
      @endif

    </div>

    <!-- Summary card -->
    <div class="col-lg-4">
      <div class="deposit-summary">
        <div class="summary-row">
          <span class="summary-title">Total Deposit</span>
          <div class="text-end">
            <div class="summary-value" id="summaryAmount">$0.00</div>
            <div class="summary-sub" id="summaryCurrency">-</div>
            <div class="summary-sub mt-1">Amount</div>
          </div>
        </div>
        <a href="{{ route('dashboard.transactions') }}" class="summary-link">View deposit history</a>
      </div>
    </div>

  </div>

@endsection

@push('scripts')
<script>
  // Build route map: method_id -> payment URL
  const routes = {
    @foreach($methods as $m)
      {{ $m->id }}: '{{ route('dashboard.deposit.payment', $m) }}',
    @endforeach
  };

  const form      = document.getElementById('depositForm');
  const selectEl  = document.getElementById('method_id');
  const amountEl  = document.getElementById('amount');

  // Point the form action to the selected method's route
  function updateSummary() {
    const methodId = selectEl.value;
    const amount   = parseFloat(amountEl.value) || 0;
    const selected = selectEl.options[selectEl.selectedIndex];
    const name     = methodId ? selected.dataset.name : '-';

    document.getElementById('summaryAmount').textContent   = '$' + amount.toFixed(2);
    document.getElementById('summaryCurrency').textContent = name;

    if (methodId && routes[methodId]) {
      form.action = routes[methodId];
    }
  }

  // Ensure action is set before submit
  form.addEventListener('submit', function(e) {
    const methodId = selectEl.value;
    if (!methodId) {
      e.preventDefault();
      selectEl.classList.add('is-invalid');
      return;
    }
    form.action = routes[methodId];
  });
</script>
@endpush
