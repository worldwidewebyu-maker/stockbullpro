<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Bull Pro')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('bizland/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <!-- BizLand main CSS (for color variables) -->
  <link href="{{ asset('bizland/css/main.css') }}" rel="stylesheet">

  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f5f7fa;
      min-height: 100vh;
    }
    .auth-card {
      border: none;
      border-radius: 14px;
      box-shadow: 0 4px 40px rgba(0, 0, 0, 0.08);
      background: #fff;
    }
    .auth-logo-text {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--heading-color, #2c3e50);
      letter-spacing: -0.5px;
    }
    .auth-logo-text i {
      color: #cb0c9f;
    }
    .btn-auth {
      background-color: #cb0c9f;
      border-color: #cb0c9f;
      color: #fff;
      padding: 0.53125rem 1.5625rem;
      font-size: 0.875rem;
      font-weight: 600;
      border-radius: 1.25rem;
      line-height: 1.5;
      transition: background-color 0.2s ease;
    }
    .btn-auth:hover {
      background-color: #a8008a;
      border-color: #a8008a;
      color: #fff;
    }
    .form-control, .form-select {
      border-radius: 8px;
      padding: 0.6rem 0.85rem;
      border: 1px solid #dee2e6;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--accent-color, #0d6efd);
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    .input-group .btn-outline-secondary {
      border-radius: 0 8px 8px 0;
      border-color: #dee2e6;
      color: #6c757d;
    }
    .input-group .btn-outline-secondary:hover {
      background-color: #f8f9fa;
      color: #495057;
    }
    .cover-col {
      min-height: 100vh;
    }
    .cover-col img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>

  @stack('styles')
</head>

<body>
  @yield('content')

  <script src="{{ asset('bizland/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @stack('scripts')
</body>

</html>
