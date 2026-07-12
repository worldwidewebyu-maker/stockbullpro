@extends('layouts.admin')
@section('title', 'Edit FAQ')
@section('breadcrumb', 'Edit FAQ')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Edit FAQ</h4>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @method('PUT')
            @include('admin.faqs._form', ['submitLabel' => 'Update FAQ'])
        </form>
    </div>
</div>
@endsection
