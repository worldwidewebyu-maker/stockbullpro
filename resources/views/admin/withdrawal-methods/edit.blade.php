@extends('layouts.admin')
@section('title', 'Edit Withdrawal Method')
@section('breadcrumb', 'Withdrawal Methods')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Edit Withdrawal Method</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">{{ $method->name }}</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.withdrawal-methods.update', $method) }}">
            @method('PUT')
            @include('admin.withdrawal-methods._form', ['submitLabel' => 'Update Method'])
        </form>
    </div>
</div>
@endsection
