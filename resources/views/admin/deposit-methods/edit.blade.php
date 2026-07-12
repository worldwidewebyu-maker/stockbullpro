@extends('layouts.admin')
@section('title', 'Edit Deposit Method')
@section('breadcrumb', 'Deposit Methods')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Edit Deposit Method</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">{{ $method->name }}</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.deposit-methods.update', $method) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.deposit-methods._form', ['submitLabel' => 'Update Method'])
        </form>
    </div>
</div>
@endsection
