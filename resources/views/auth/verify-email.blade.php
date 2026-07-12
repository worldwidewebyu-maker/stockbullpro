@extends('layouts.auth')

@section('title', 'Verify Your Email - Bull Pro')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">

        <div class="auth-card card p-4 p-md-5 text-center">

          <!-- Logo -->
          <div class="mb-4">
            <a href="{{ route('home') }}" class="auth-logo-text text-decoration-none d-inline-flex align-items-center gap-2">
              <i class="bi bi-graph-up-arrow"></i>
              <span>BullPro</span>
            </a>
          </div>

          <div class="mb-3">
            <i class="bi bi-envelope-check" style="font-size: 3rem; color: var(--accent-color, #0d6efd);"></i>
          </div>

          <h4 class="fw-bold mb-2">Verify Your Email</h4>
          <p class="text-muted small mb-4">
            Thanks for registering! Before you get started, please verify your email address by clicking the link we just sent to <strong>{{ auth()->user()->email }}</strong>.
          </p>

          @if(session('status') === 'verification-link-sent')
            <div class="alert alert-success small">
              A new verification link has been sent to your email address.
            </div>
          @endif

          <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-auth w-100">Resend Verification Email</button>
          </form>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted small text-decoration-none w-100">
              Log Out
            </button>
          </form>

        </div>

      </div>
    </div>
  </div>
</div>
@endsection
