@extends('layouts.admin')
@section('title', 'Add FAQ')
@section('breadcrumb', 'Add FAQ')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Add FAQ</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @include('admin.faqs._form', ['submitLabel' => 'Add FAQ'])
        </form>
    </div>
</div>
@endsection
