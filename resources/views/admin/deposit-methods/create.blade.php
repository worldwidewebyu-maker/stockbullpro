@extends('layouts.admin')
@section('title', 'Add Deposit Method')
@section('breadcrumb', 'Deposit Methods')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Add Deposit Method</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.deposit-methods.store') }}" enctype="multipart/form-data">
            @include('admin.deposit-methods._form', ['submitLabel' => 'Create Method'])
        </form>
    </div>
</div>
@endsection
