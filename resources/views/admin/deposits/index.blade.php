@extends('layouts.admin')
@section('title', 'Deposit Logs')
@section('breadcrumb', 'Deposit Logs')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Deposit Logs</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Review, approve or reject user deposits.</p>
</div>

<!-- Filter tabs -->
<div class="txn-tabs mb-3" style="margin:0 0 1rem;">
    <a href="{{ route('admin.deposits.index') }}" class="txn-tab {{ !$status ? 'active' : '' }}" style="text-decoration:none;">All</a>
    <a href="{{ route('admin.deposits.index', ['status' => 'pending']) }}" class="txn-tab {{ $status === 'pending' ? 'active' : '' }}" style="text-decoration:none;">Pending ({{ $counts['pending'] }})</a>
    <a href="{{ route('admin.deposits.index', ['status' => 'approved']) }}" class="txn-tab {{ $status === 'approved' ? 'active' : '' }}" style="text-decoration:none;">Approved ({{ $counts['approved'] }})</a>
    <a href="{{ route('admin.deposits.index', ['status' => 'rejected']) }}" class="txn-tab {{ $status === 'rejected' ? 'active' : '' }}" style="text-decoration:none;">Rejected ({{ $counts['rejected'] }})</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Proof</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $dep)
                    <tr>
                        <td>
                            @if($dep->user)
                                <a href="{{ route('admin.users.show', $dep->user) }}" style="color:var(--dash-pink); text-decoration:none;">{{ $dep->user->username }}</a>
                            @else — @endif
                        </td>
                        <td class="fw-semibold">${{ number_format($dep->amount, 2) }}</td>
                        <td>{{ $dep->method?->name ?? 'Admin Credit' }}</td>
                        <td>
                            @if($dep->proof_url)
                                <a href="{{ $dep->proof_url }}" target="_blank" style="color:var(--dash-pink);">View</a>
                            @else — @endif
                        </td>
                        <td>{!! txn_badge($dep->status) !!}</td>
                        <td style="font-size:.8rem;">{{ $dep->created_at->format('M d, Y g:i A') }}</td>
                        <td class="text-end">
                            @if($dep->status === 'pending')
                                <div class="d-flex justify-content-end gap-1">
                                    <form method="POST" action="{{ route('admin.deposits.approve', $dep) }}"
                                          onsubmit="return confirm('Approve this deposit and credit the user?');">
                                        @csrf
                                        <button type="submit" class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem; border-color:#2e7d32; color:#2e7d32;">Approve</button>
                                    </form>
                                    <button type="button" class="btn-dash-outline"
                                        style="padding:.3rem .7rem; font-size:.7rem; border-color:#dc3545; color:#dc3545;"
                                        onclick="openReject('{{ route('admin.deposits.reject', $dep) }}', '{{ $dep->user?->username }}', '{{ number_format($dep->amount, 2) }}')">Reject</button>
                                </div>
                            @else
                                <span class="text-muted" style="font-size:.75rem;">
                                    {{ $dep->approved_at ? $dep->approved_at->format('M d, Y') : ($dep->admin_note ?: '—') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No deposits found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">{{ $deposits->links() }}</div>

<!-- Reject modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="rejectForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Reject Deposit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted small mb-3">Rejecting deposit of <strong id="rejectInfo"></strong>.</p>
          <div class="profile-field">
            <label>Reason (optional, sent to user)</label>
            <input type="text" name="admin_note" maxlength="255" class="profile-input" placeholder="e.g. Payment not received">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-dash-outline" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-dash-primary" style="background:#dc3545; box-shadow:none;">Reject Deposit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
  function openReject(action, username, amount) {
    document.getElementById('rejectForm').action = action;
    document.getElementById('rejectInfo').textContent = '$' + amount + (username ? ' from ' + username : '');
    rejectModal.show();
  }
</script>
@endpush
