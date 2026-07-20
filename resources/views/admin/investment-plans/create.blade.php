@extends('layouts.admin')
@section('title', 'Add Investment Plan')
@section('breadcrumb', 'Investment Plans')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Add Investment Plan</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.investment-plans.store') }}">
            @include('admin.investment-plans._form', ['submitLabel' => 'Create Plan'])
        </form>
    </div>
</div>
@endsection
