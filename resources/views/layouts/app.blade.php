<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'Bull Pro') - Advanced Trading Platform</title>
  <meta name="description" content="@yield('description', 'Trade stocks, ETFs, and cryptocurrencies with Bull Pro advanced trading platform.')">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @include('partials.favicons')

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('bizland/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bizland/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('bizland/css/main.css') }}" rel="stylesheet">

  <style>
    /* Login / Register pill buttons in navbar */
    .navmenu ul li.nav-btn a {
      background-color: #cb0c9f;
      color: #fff !important;
      border-radius: 1.25rem;
      padding: 0.43rem 1.3rem;
      font-size: 0.875rem;
      font-weight: 600;
      line-height: 1.5;
      transition: opacity 0.2s ease;
      margin-left: 4px;
    }
    .navmenu ul li.nav-btn a:hover,
    .navmenu ul li.nav-btn a.active {
      background-color: #a8008a !important;
      opacity: 1;
    }
    /* Prevent the bottom active underline on these button items */
    .navmenu ul li.nav-btn a::before {
      display: none !important;
    }
    /* Mobile: give them a bit of margin */
    @media (max-width: 1199px) {
      .navmenu ul li.nav-btn a {
        display: inline-block;
        margin: 4px 0;
      }
    }
    /* Google Translate compact styling */
    #google_translate_element .goog-te-gadget-simple {
      border: 1px solid #dee2e6;
      border-radius: 4px;
      padding: 2px 6px;
      font-size: 0.8rem;
    }
    #google_translate_element .goog-te-gadget-simple a {
      color: #444 !important;
      text-decoration: none !important;
    }
  </style>

  @stack('styles')
</head>

<body class="index-page">

  @php $base = Route::is('home') ? '' : route('home') @endphp

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center">
            <a href="mailto:info@finxstockbull.com">info@finxstockbull.com</a>
          </i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">

        <!-- Logo + Google Translate stacked on the left -->
        <div class="d-flex flex-column justify-content-center">
          <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <i class="bi bi-graph-up-arrow me-2" style="font-size:1.6rem; color: var(--accent-color);"></i>
            <h1 class="sitename">BullPro</h1>
          </a>
          <div id="google_translate_element" class="mt-1"></div>
        </div>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="{{ $base }}#hero" @if(Route::is('home')) class="active" @endif>Home</a></li>
            <li><a href="{{ $base }}#about">About</a></li>
            <li><a href="{{ $base }}#services">Why Us</a></li>
            <li class="dropdown">
              <a href="#"><span>More</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="{{ $base }}#team">Supported Platforms</a></li>
                <li><a href="{{ $base }}#testimonials">Testimonials</a></li>
                <li><a href="{{ $base }}#faq">FAQ</a></li>
                <li><a href="{{ route('terms') }}" @if(Route::is('terms')) class="active" @endif>Terms Of Use</a></li>
              </ul>
            </li>
            <li><a href="{{ $base }}#contact">Contact</a></li>
            <li class="nav-btn"><a href="{{ route('login') }}">Login</a></li>
            <li class="nav-btn"><a href="{{ route('register') }}">Signup</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

      </div>
    </div>

  </header>

  <!-- TradingView Ticker Tape Widget -->
  <div class="tradingview-widget-container">
    <div class="tradingview-widget-container__widget"></div>
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
    {
      "symbols": [
        { "proName": "FOREXCOM:SPXUSD", "title": "S&P 500" },
        { "proName": "NASDAQ:NDX",       "title": "Nasdaq 100" },
        { "proName": "FX_IDC:EURUSD",    "title": "EUR/USD" },
        { "proName": "BITSTAMP:BTCUSD",  "title": "BTC/USD" },
        { "proName": "BITSTAMP:ETHUSD",  "title": "ETH/USD" },
        { "proName": "FOREXCOM:NSXUSD",  "title": "US 100" },
        { "proName": "FX_IDC:GBPUSD",    "title": "GBP/USD" },
        { "proName": "BITSTAMP:XRPUSD",  "title": "XRP/USD" }
      ],
      "showSymbolLogo": true,
      "isTransparent": false,
      "displayMode": "adaptive",
      "colorTheme": "light",
      "locale": "en"
    }
    </script>
  </div>

  <main class="main">
    @yield('content')
  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">

        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('home') }}" class="d-flex align-items-center">
            <i class="bi bi-graph-up-arrow me-2" style="font-size:1.4rem; color: var(--accent-color);"></i>
            <span class="sitename">BullPro</span>
          </a>
          <div class="footer-contact pt-3">
            <p><strong>Email:</strong> <span>info@finxstockbull.com</span></p>
          </div>
          <div class="social-links d-flex mt-3">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}#about">About Us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}#faq">FAQ</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('terms') }}">Terms Of Use</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('terms') }}">Privacy Policy</a></li>
          </ul>
        </div>

        <div class="col-lg-6 col-md-12">
          <h4>Risk Disclaimer</h4>
          <p class="small" style="line-height: 1.7;">
            Trading in financial instruments involves significant risk of loss and is not suitable for all investors. Past performance is not indicative of future results. The value of investments can fall as well as rise. Please ensure that you fully understand the risks involved before trading and seek independent financial advice if necessary. Only invest funds you can afford to lose.
          </p>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">BullPro</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <a href="{{ $telegramLink }}" class="telegram-float d-flex align-items-center justify-content-center" target="_blank" rel="noopener noreferrer" aria-label="Chat on Telegram">
    <i class="bi bi-telegram"></i>
  </a>

  <a href="{{ $whatsappLink }}" class="whatsapp-float d-flex align-items-center justify-content-center" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
    <i class="bi bi-whatsapp"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>

  <!-- Vendor JS -->
  <script src="{{ asset('bizland/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('bizland/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('bizland/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('bizland/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('bizland/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('bizland/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('bizland/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('bizland/js/main.js') }}"></script>

  @stack('scripts')

  <!-- Google Translate -->
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false
      }, 'google_translate_element');
    }
  </script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>
