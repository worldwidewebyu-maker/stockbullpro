@extends('layouts.auth')

@section('title', 'Admin Sign In - Bull Pro')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">

        <div class="auth-card card p-4 p-md-5">

          <div class="text-center mb-4">
            <span class="auth-logo-text d-inline-flex align-items-center gap-2">
              <i class="bi bi-shield-lock-fill"></i>
              <span>BullPro Admin</span>
            </span>
          </div>

          <h4 class="text-center fw-bold mb-1">Admin Sign In</h4>
          <p class="text-center text-muted mb-4 small">Restricted area. Authorized administrators only.</p>

          <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
            @csrf

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

            <div class="mb-3">
              <label for="password" class="form-label fw-semibold small mb-1">Password</label>
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

            <div class="mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-muted small" for="remember">Remember me</label>
              </div>
            </div>

            <button type="submit" class="btn btn-auth w-100">Sign in</button>
          </form>

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
