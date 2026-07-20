@extends('layouts.admin')
@section('title', 'Edit Investment Plan')
@section('breadcrumb', 'Investment Plans')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Edit Investment Plan</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">{{ $plan->name }}</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.investment-plans.update', $plan) }}">
            @method('PUT')
            @include('admin.investment-plans._form', ['submitLabel' => 'Update Plan'])
        </form>
    </div>
</div>
@endsection
