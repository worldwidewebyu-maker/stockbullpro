@extends('layouts.dashboard')
@section('title', 'Invest Now')
@section('breadcrumb', 'Invest Now')

@section('content')
<div class="dash-page-header mb-4">
    <h4 class="dash-page-title">Buy Plans</h4>
</div>

@if($plans->isEmpty())
    <div class="card shadow-sm text-center py-5">
        <div class="card-body">
            <p class="text-muted">No investment plans are available at the moment. Please check back later.</p>
        </div>
    </div>
@else
<div class="row g-4">
    @foreach($plans as $plan)
    <div class="col-lg-4 col-md-6">
        <div class="invest-plan-card">
            <div class="invest-plan-header">
                <div class="invest-roi">{{ number_format($plan->roi_percentage, 0) }} % ROI</div>
                <div class="invest-name">{{ $plan->name }}</div>
            </div>

            <div class="invest-features">
                <div class="invest-feature">
                    <span class="invest-check"><i class="bi bi-check2"></i></span>
                    <span>Minimum amount: ${{ number_format($plan->min_amount, 0) }}</span>
                </div>
                <div class="invest-feature">
                    <span class="invest-check"><i class="bi bi-check2"></i></span>
                    <span>Maximum amount: ${{ number_format($plan->max_amount, 0) }}</span>
                </div>
                <div class="invest-feature">
                    <span class="invest-check"><i class="bi bi-check2"></i></span>
                    <span>{{ number_format($plan->roi_percentage, 0) }}% {{ $plan->roi_period }} for {{ $plan->duration_days }} {{ $plan->duration_days == 1 ? 'Day' : 'Days' }}</span>
                </div>
                <div class="invest-feature">
                    <span class="invest-check"><i class="bi bi-check2"></i></span>
                    <span>Charges Amount:
                        @if($plan->charge_amount > 0)
                            {{ $plan->charge_type === 'percentage' ? number_format($plan->charge_amount, 2).'%' : '$'.number_format($plan->charge_amount, 2) }}
                        @endif
                    </span>
                </div>
                <div class="invest-feature">
                    <span class="invest-check"><i class="bi bi-check2"></i></span>
                    <span>Duration: {{ $plan->duration_days }} {{ $plan->duration_days == 1 ? 'Day' : 'Days' }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.invest.join', $plan) }}">
                @csrf
                <div class="invest-input-wrap">
                    <input
                        type="number"
                        name="amount"
                        class="invest-amount-input @error('amount') is-invalid @enderror"
                        placeholder="$ {{ number_format($plan->min_amount, 0) }} - $ {{ number_format($plan->max_amount, 0) }}"
                        min="{{ $plan->min_amount }}"
                        max="{{ $plan->max_amount }}"
                        step="0.01"
                    >
                    @error('amount')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-invest-join">JOIN PLAN</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
