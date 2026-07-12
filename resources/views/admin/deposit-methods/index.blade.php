@extends('layouts.admin')
@section('title', 'Deposit Methods')
@section('breadcrumb', 'Deposit Methods')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
    <div>
        <h4 class="dash-page-title">Deposit Methods</h4>
        <p class="text-muted mb-0" style="font-size:.875rem">Manage the crypto currencies users can deposit with.</p>
    </div>
    <a href="{{ route('admin.deposit-methods.create') }}" class="btn-dash-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Method
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Method</th>
                        <th>Network</th>
                        <th>Wallet Address</th>
                        <th>Limits</th>
                        <th>Charge</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($methods as $method)
                    <tr>
                        <td>{{ $method->sort_order }}</td>
                        <td class="fw-semibold">
                            <div class="d-flex align-items-center gap-2">
                                @if($method->qr_code_url)
                                    <img src="{{ $method->qr_code_url }}" alt="QR" style="width:28px;height:28px;object-fit:cover;border-radius:.25rem;">
                                @endif
                                {{ $method->name }}
                            </div>
                        </td>
                        <td>{{ $method->network_type ?: '—' }}</td>
                        <td style="max-width:200px;">
                            <span style="word-break:break-all; font-size:.8rem;">{{ $method->wallet_address ?: '—' }}</span>
                        </td>
                        <td style="font-size:.8rem;">${{ number_format($method->min_amount, 0) }} – ${{ number_format($method->max_amount, 0) }}</td>
                        <td>{{ $method->charge_type === 'percentage' ? $method->charge_amount.'%' : '$'.number_format($method->charge_amount, 2) }}</td>
                        <td>
                            @if($method->is_active)
                                <span class="badge-txn-success">Active</span>
                            @else
                                <span class="badge-txn-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.deposit-methods.edit', $method) }}"
                                   class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem;">Edit</a>

                                <form method="POST" action="{{ route('admin.deposit-methods.toggle', $method) }}">
                                    @csrf
                                    <button type="submit" class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem;">
                                        {{ $method->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.deposit-methods.destroy', $method) }}"
                                      onsubmit="return confirm('Delete {{ $method->name }}? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem; border-color:#dc3545; color:#dc3545;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No deposit methods yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
