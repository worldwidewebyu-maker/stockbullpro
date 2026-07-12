@extends('layouts.dashboard')
@section('title', 'My Investment Plans')
@section('breadcrumb', 'My Investment Plans')

@section('content')
<div class="dash-page-header mb-4">
    <h4 class="dash-page-title">My Investment Plans (All)</h4>
</div>

@if($investments->isEmpty())
    <div class="card shadow-sm">
        <div class="card-body text-center py-5">
            <p class="text-muted mb-4">You do not have an investment plan at the moment or no value match your query.</p>
            <a href="{{ route('dashboard.invest') }}" class="btn-dash-primary px-4">BUY A PLAN</a>
        </div>
    </div>
@else
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>ROI</th>
                        <th>Accrued Profit</th>
                        <th>Start Date</th>
                        <th>Maturity Date</th>
                        <th>Progress</th>
                        <th>Days Left</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($investments as $i => $inv)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <span class="fw-semibold">{{ $inv->plan_name }}</span>
                        </td>
                        <td>${{ number_format($inv->amount, 2) }}</td>
                        <td>{{ number_format($inv->roi_percentage, 0) }}% {{ $inv->roi_period }}</td>
                        <td>
                            @if($inv->status === 'active')
                                <span class="text-success fw-semibold">${{ number_format($inv->accrued_profit, 2) }}</span>
                            @elseif($inv->status === 'matured')
                                <span class="text-muted">Paid out</span>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $inv->start_date->format('M d, Y') }}</td>
                        <td>{{ $inv->end_date->format('M d, Y') }}</td>
                        <td style="min-width:130px">
                            <div class="invest-progress-wrap">
                                <div class="invest-progress-bar" style="width: {{ $inv->progress_percent }}%"></div>
                            </div>
                            <small class="text-muted">{{ $inv->progress_percent }}%</small>
                        </td>
                        <td>
                            @if($inv->status === 'active')
                                <span class="fw-semibold">{{ $inv->days_remaining }} day{{ $inv->days_remaining != 1 ? 's' : '' }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($inv->status === 'active')
                                <span class="badge-invest-active">Active</span>
                            @elseif($inv->status === 'matured')
                                <span class="badge-invest-matured">Matured</span>
                            @else
                                <span class="badge-invest-cancelled">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-end">
    <a href="{{ route('dashboard.invest') }}" class="btn-dash-primary px-4">BUY A PLAN</a>
</div>
@endif
@endsection
