@extends('layouts.admin')
@section('title', 'Add Withdrawal Method')
@section('breadcrumb', 'Withdrawal Methods')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Add Withdrawal Method</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.withdrawal-methods.store') }}">
            @include('admin.withdrawal-methods._form', ['submitLabel' => 'Create Method'])
        </form>
    </div>
</div>
@endsection
