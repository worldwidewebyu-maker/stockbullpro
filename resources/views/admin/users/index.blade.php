@extends('layouts.admin')
@section('title', 'Users')
@section('breadcrumb', 'Users')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">User Management</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">{{ $users->total() }} registered user(s).</p>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
            <input type="text" name="q" value="{{ $search }}" class="profile-input"
                placeholder="Search by username, email or full name" style="max-width:360px;">
            <button type="submit" class="btn-dash-primary">Search</button>
            @if($search)
                <a href="{{ route('admin.users.index') }}" class="btn-dash-outline">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table dash-table mb-0">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Balance</th>
                        <th>Joined</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td class="fw-semibold">{{ $u->username }}</td>
                        <td>{{ $u->full_name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>${{ number_format($u->balance, 2) }}</td>
                        <td>{{ $u->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.show', $u) }}" class="btn-dash-outline" style="padding:.35rem .8rem; font-size:.7rem;">Manage</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>
@endsection
