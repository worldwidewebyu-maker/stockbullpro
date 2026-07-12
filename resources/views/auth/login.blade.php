@extends('layouts.auth')

@section('title', 'Sign In - Bull Pro')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">

        <div class="auth-card card p-4 p-md-5">

          <!-- Logo -->
          <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="auth-logo-text text-decoration-none d-inline-flex align-items-center gap-2">
              <i class="bi bi-graph-up-arrow"></i>
              <span>BullPro</span>
            </a>
          </div>

          <h4 class="text-center fw-bold mb-1">Sign In</h4>
          <p class="text-center text-muted mb-4 small">Enter your email address and password to access your account.</p>

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <form method="POST" action="{{ route('login.post') }}" novalidate>
            @csrf

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold small">Email Address</label>
              <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Your email address"
                required
                autofocus
              >
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label fw-semibold small mb-0">Password</label>
                <a href="#" class="small text-decoration-none" style="color: var(--accent-color);">Forgot password?</a>
              </div>
              <div class="input-group">
                <input
                  type="password"
                  class="form-control @error('password') is-invalid @enderror"
                  id="password"
                  name="password"
                  placeholder="Your password"
                  required
                >
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                  <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-muted small" for="remember">Remember me</label>
              </div>
            </div>

            <button type="submit" class="btn btn-auth w-100">Sign in</button>
          </form>

          <hr class="my-4">

          <p class="text-center mb-0 text-muted small">
            Don't have an account?
            <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color: var(--accent-color);">Sign up</a>
          </p>

        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
      pwd.type = 'password';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
  });
</script>
@endpush
