@extends('layouts.dashboard')

@section('title', 'Withdraw')
@section('breadcrumb', 'Withdraw')

@section('content')

  <h1 class="page-title mb-1">Withdraw from your account.</h1>
  <p class="mb-4" style="color:var(--dash-text-muted); font-size:.9rem;">
    Place a withdrawal request using any of the payment method below.
  </p>

  @if($methods->isEmpty())
    <div class="empty-state">
      <p>No withdrawal methods are currently available. Please check back later.</p>
    </div>
  @else
    <div class="row g-4">
      @foreach($methods as $method)
        <div class="col-xl-4 col-md-6">
          <div style="background:#fff; border-radius:.75rem; padding:2rem 1.75rem; box-shadow:0 1px 6px rgba(0,0,0,.06); border:1px solid #f0f0f0; display:flex; flex-direction:column; height:100%;">

            <div style="font-size:1rem; font-weight:600; text-transform:uppercase; letter-spacing:.1em; color:var(--dash-text-muted); text-align:center; margin-bottom:1rem;">
              {{ $method->name }}
            </div>

            <div style="text-align:center; margin-bottom:1.5rem;">
              <span style="font-size:1.8rem; font-weight:800; color:var(--dash-text);">
                ${{ number_format($method->max_amount) }}
              </span>
              <span style="font-size:1.2rem; color:var(--dash-text-muted); font-weight:500;"> Max</span>
            </div>

            <ul style="list-style:none; padding:0; margin:0 0 2rem; flex:1;">
              <li style="display:flex; align-items:center; gap:10px; padding:.45rem 0; font-size:.9rem; color:var(--dash-text-muted);">
                <i class="bi bi-check2" style="color:#cb0c9f; font-size:1rem;"></i>
                Minimum amount: ${{ number_format($method->min_amount, 0) }}
              </li>
              <li style="display:flex; align-items:center; gap:10px; padding:.45rem 0; font-size:.9rem; color:var(--dash-text-muted);">
                <i class="bi bi-check2" style="color:#cb0c9f; font-size:1rem;"></i>
                Charge Type: {{ $method->charge_type }}
              </li>
              <li style="display:flex; align-items:center; gap:10px; padding:.45rem 0; font-size:.9rem; color:var(--dash-text-muted);">
                <i class="bi bi-check2" style="color:#cb0c9f; font-size:1rem;"></i>
                Charges Amount: {{ $method->charge_type === 'percentage' ? $method->charge_amount.'%' : '$'.number_format($method->charge_amount,2) }}
              </li>
              <li style="display:flex; align-items:center; gap:10px; padding:.45rem 0; font-size:.9rem; color:var(--dash-text-muted);">
                <i class="bi bi-check2" style="color:#cb0c9f; font-size:1rem;"></i>
                Duration: {{ $method->duration }}
              </li>
            </ul>

            <a href="{{ route('dashboard.withdraw.request', $method) }}" class="btn-dash-primary text-center d-block">
              SELECT THIS METHOD
            </a>

          </div>
        </div>
      @endforeach
    </div>
  @endif

@endsection
