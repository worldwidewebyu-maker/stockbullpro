@extends('layouts.admin')
@section('title', 'FAQs')
@section('breadcrumb', 'FAQs')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-2">
    <div>
        <h4 class="dash-page-title">FAQs</h4>
        <p class="text-muted mb-0" style="font-size:.875rem">Manage frequently asked questions shown on the home page.</p>
    </div>
    <a href="{{ route('admin.faqs.create') }}" class="btn-dash-primary">
        <i class="bi bi-plus-lg me-1"></i> Add FAQ
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td>{{ $faq->sort_order }}</td>
                        <td>
                            <div class="fw-semibold">{{ $faq->question }}</div>
                            <div class="text-muted" style="font-size:.8rem; max-width:500px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ Str::limit($faq->answer, 120) }}
                            </div>
                        </td>
                        <td>
                            @if($faq->is_active)
                                <span class="badge-txn-success">Active</span>
                            @else
                                <span class="badge-txn-danger">Hidden</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.faqs.edit', $faq) }}"
                                   class="btn-dash-outline" style="padding:.3rem .7rem; font-size:.7rem;">Edit</a>
                                <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}"
                                      onsubmit="return confirm('Delete this FAQ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-dash-outline"
                                        style="padding:.3rem .7rem; font-size:.7rem; color:#dc3545; border-color:#dc3545;">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No FAQs yet. Add the first one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
