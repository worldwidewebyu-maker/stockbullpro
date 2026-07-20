@extends('layouts.admin')
@section('title', 'Investment Plans')
@section('breadcrumb', 'Investment Plans')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
    <div>
        <h4 class="dash-page-title">Investment Plans</h4>
        <p class="text-muted mb-0" style="font-size:.875rem">Create and manage the plans users can invest in.</p>
    </div>
    <a href="{{ route('admin.investment-plans.create') }}" class="btn-dash-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Plan
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Plan</th>
                        <th>ROI</th>
                        <th>Duration</th>
                        <th>Limits</th>
                        <th>Charge</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr>
                        <td>{{ $plan->sort_order }}</td>
                        <td class="fw-semibold">{{ $plan->name }}</td>
                        <td>{{ number_format($plan->roi_percentage, 2) }}% {{ $plan->roi_period }}</td>
                        <td>{{ $plan->duration_days }} {{ $plan->duration_days == 1 ? 'Day' : 'Days' }}</td>
                        <td style="font-size:.8rem;">${{ number_format($plan->min_amount, 0) }} – ${{ number_format($plan->max_amount, 0) }}</td>
                        <td>
                            @if($plan->charge_amount > 0)
                                {{ $plan->charge_type === 'percentage' ? $plan->charge_amount.'%' : '$'.number_format($plan->charge_amount, 2) }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($plan->is_active)
                                <span class="badge-txn-success">Active</span>
                            @else
                                <span class="badge-txn-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.investment-plans.edit', $plan) }}"
                                   class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem;">Edit</a>

                                <form method="POST" action="{{ route('admin.investment-plans.toggle', $plan) }}">
                                    @csrf
                                    <button type="submit" class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem;">
                                        {{ $plan->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.investment-plans.destroy', $plan) }}"
                                      onsubmit="return confirm('Delete {{ $plan->name }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem; border-color:#dc3545; color:#dc3545;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No investment plans yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
