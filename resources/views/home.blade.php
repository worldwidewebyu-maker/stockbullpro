@extends('layouts.app')

@section('title', 'Bull Pro - Advanced Trading Platform')
@section('description', 'Trade and invest in top stocks, ETFs, and cryptocurrencies with Bull Pro. Join over 15 million traders worldwide.')

@section('content')

  <!-- Hero Section -->
  <section id="hero" class="hero section light-background">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
          <h1>Welcome to <span>Bull Pro</span></h1>
          <p>Trade and invest in top stocks and ETFs, cryptocurrencies, forex, and more with our advanced trading platform. Start growing your wealth today.</p>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('login') }}" class="btn-get-started">Login</a>
            <a href="{{ route('register') }}" class="btn-watch-video d-flex align-items-center">
              <i class="bi bi-person-plus-fill"></i><span>Sign Up</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Hero Section -->

  <!-- Featured Services Section -->
  <section id="featured-services" class="featured-services section">
    <div class="container">
      <div class="row gy-4">

        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-person-check-fill icon"></i></div>
            <h4><a href="{{ route('register') }}" class="stretched-link">Open An Account</a></h4>
            <p>Create your free trading account in minutes with a quick and simple verification process.</p>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-wallet2 icon"></i></div>
            <h4><a href="{{ route('register') }}" class="stretched-link">Fund Your Account</a></h4>
            <p>Deposit funds using multiple payment methods including crypto, bank transfer, and cards.</p>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-graph-up-arrow icon"></i></div>
            <h4><a href="{{ route('register') }}" class="stretched-link">Trade</a></h4>
            <p>Access global markets and trade stocks, ETFs, forex, crypto and more from one platform.</p>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-cash-coin icon"></i></div>
            <h4><a href="{{ route('register') }}" class="stretched-link">Withdraw Profit</a></h4>
            <p>Withdraw your profits quickly and securely to your preferred payment method anytime.</p>
          </div>
        </div>

      </div>
    </div>
  </section><!-- /Featured Services Section -->

  <!-- About Section -->
  <section id="about" class="about section light-background">

    <div class="container section-title" data-aos="fade-up">
      <h2>About</h2>
      <p><span>Find Out More</span> <span class="description-title">About Us</span></p>
    </div>

    <div class="container">
      <div class="row gy-3">

        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <img src="{{ asset('bizland/img/about.jpg') }}" alt="About Bull Pro" class="img-fluid">
        </div>

        <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <div class="about-content ps-0 ps-lg-3">
            <h3>A trusted trading platform built for both beginners and experienced traders worldwide.</h3>
            <p class="fst-italic">
              Bull Pro was founded with a single mission: to democratize access to financial markets and empower investors worldwide to achieve their financial goals.
            </p>
            <ul>
              <li>
                <i class="bi bi-shield-check"></i>
                <div>
                  <h4>Regulated &amp; Transparent Operations</h4>
                  <p>We operate under strict financial regulations to ensure the safety of your funds and the integrity of every transaction.</p>
                </div>
              </li>
              <li>
                <i class="bi bi-globe2"></i>
                <div>
                  <h4>Global Market Access</h4>
                  <p>Trade across 176 countries with access to stocks, ETFs, forex, cryptocurrencies and more from a single account.</p>
                </div>
              </li>
            </ul>
            <p>
              Our platform is designed to provide you with all the tools and resources you need to make informed trading decisions. Whether you're a seasoned investor or just starting out, Bull Pro offers a seamless, secure, and rewarding trading experience.
            </p>
          </div>
        </div>

      </div>
    </div>

  </section><!-- /About Section -->

  <!-- Stats / Counts Section -->
  <section id="stats" class="stats section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-people"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="15203932" data-purecounter-duration="1" class="purecounter"></span>
            <p>Traders on the Platform</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-arrow-left-right"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="41927182" data-purecounter-duration="1" class="purecounter"></span>
            <p>Deals Completed Per Month</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-graph-up"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="101372" data-purecounter-duration="1" class="purecounter"></span>
            <p>Active Traders</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-globe"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="176" data-purecounter-duration="1" class="purecounter"></span>
            <p>Countries Supported</p>
          </div>
        </div>

      </div>
    </div>
  </section><!-- /Stats Section -->

  <!-- Payment Methods Section -->
  <section id="clients" class="clients section light-background">

    <div class="container section-title" data-aos="fade-up">
      <h2>Payments</h2>
      <p><span>We Accept</span> <span class="description-title">Multiple Payment Methods</span></p>
    </div>

    <div class="container">
      <div class="swiper init-swiper">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": { "delay": 3000 },
            "slidesPerView": "auto",
            "breakpoints": {
              "320": { "slidesPerView": 2, "spaceBetween": 40 },
              "480": { "slidesPerView": 3, "spaceBetween": 60 },
              "640": { "slidesPerView": 4, "spaceBetween": 80 },
              "992": { "slidesPerView": 6, "spaceBetween": 120 }
            }
          }
        </script>
        <div class="swiper-wrapper align-items-center">
          <div class="swiper-slide text-center py-3">
            <i class="bi bi-currency-bitcoin" style="font-size: 2.5rem; color: #F7931A;"></i>
            <p class="mt-1 mb-0 small fw-semibold">Bitcoin</p>
          </div>
          <div class="swiper-slide text-center py-3">
            <i class="bi bi-wallet2" style="font-size: 2.5rem; color: #862165;"></i>
            <p class="mt-1 mb-0 small fw-semibold">Skrill</p>
          </div>
          <div class="swiper-slide text-center py-3">
            <i class="bi bi-paypal" style="font-size: 2.5rem; color: #003087;"></i>
            <p class="mt-1 mb-0 small fw-semibold">PayPal</p>
          </div>
          <div class="swiper-slide text-center py-3">
            <i class="bi bi-bank" style="font-size: 2.5rem; color: #2ecc71;"></i>
            <p class="mt-1 mb-0 small fw-semibold">Bank Transfer</p>
          </div>
          <div class="swiper-slide text-center py-3">
            <i class="bi bi-credit-card" style="font-size: 2.5rem; color: #eb001b;"></i>
            <p class="mt-1 mb-0 small fw-semibold">Mastercard</p>
          </div>
          <div class="swiper-slide text-center py-3">
            <i class="bi bi-credit-card-2-front" style="font-size: 2.5rem; color: #1a1f71;"></i>
            <p class="mt-1 mb-0 small fw-semibold">Visa</p>
          </div>
        </div>
      </div>
    </div>

  </section><!-- /Payment Methods Section -->

  <!-- Why Us / Services Section -->
  <section id="services" class="services section">

    <div class="container section-title" data-aos="fade-up">
      <h2>Why Us</h2>
      <p><span>Reasons to</span> <span class="description-title">Choose Bull Pro</span></p>
    </div>

    <div class="container">
      <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-shield-check"></i></div>
            <a href="#" class="stretched-link"><h3>Regulation</h3></a>
            <p>Bull Pro operates under strict regulatory compliance, ensuring your investments are protected and our practices meet international financial standards.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-lock-fill"></i></div>
            <a href="#" class="stretched-link"><h3>High Level Security</h3></a>
            <p>Your funds and personal data are protected with bank-grade encryption, two-factor authentication, and advanced security protocols at all times.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-globe2"></i></div>
            <a href="#" class="stretched-link"><h3>We Are Global</h3></a>
            <p>Available in 176 countries, Bull Pro provides access to global financial markets, connecting traders from every corner of the world.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-bar-chart-line-fill"></i></div>
            <a href="#" class="stretched-link"><h3>Multi Asset</h3></a>
            <p>Trade across multiple asset classes including stocks, ETFs, forex, cryptocurrencies, commodities, and indices all from a single account.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-eye-slash-fill"></i></div>
            <a href="#" class="stretched-link"><h3>Privacy</h3></a>
            <p>We take your privacy seriously. Your personal information is never shared with third parties without your explicit consent, ever.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
          <div class="service-item position-relative">
            <div class="icon"><i class="bi bi-headset"></i></div>
            <a href="#" class="stretched-link"><h3>Support</h3></a>
            <p>Our dedicated customer support team is available 24/7 to assist you with any questions, issues, or guidance you may need.</p>
          </div>
        </div>

      </div>
    </div>

  </section><!-- /Why Us Section -->

  <!-- Supported Platforms Section -->
  <section id="team" class="team section light-background">

    <div class="container section-title" data-aos="fade-up">
      <h2>Platforms</h2>
      <p><span>Our</span> <span class="description-title">Supported Platforms</span></p>
    </div>

    <div class="container">
      <div class="row gy-4 justify-content-center">

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="team-member w-100">
            <div class="member-img d-flex align-items-center justify-content-center" style="background: #eef2ff; height: 200px; border-radius: 8px 8px 0 0;">
              <i class="bi bi-phone-fill" style="font-size: 5rem; color: var(--accent-color, #0d6efd);"></i>
            </div>
            <div class="member-info text-center">
              <h4>Mobile Web App</h4>
              <span>Trade anywhere, anytime directly from your mobile browser — no download required.</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="team-member w-100">
            <div class="member-img d-flex align-items-center justify-content-center" style="background: #eef2ff; height: 200px; border-radius: 8px 8px 0 0;">
              <i class="bi bi-laptop-fill" style="font-size: 5rem; color: var(--accent-color, #0d6efd);"></i>
            </div>
            <div class="member-info text-center">
              <h4>Web Trader Platform</h4>
              <span>Full-featured professional trading platform accessible from any desktop browser.</span>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          <div class="team-member w-100">
            <div class="member-img d-flex align-items-center justify-content-center" style="background: #eef2ff; height: 200px; border-radius: 8px 8px 0 0;">
              <i class="bi bi-display-fill" style="font-size: 5rem; color: var(--accent-color, #0d6efd);"></i>
            </div>
            <div class="member-info text-center">
              <h4>MT4 Platform</h4>
              <span>Industry-standard MetaTrader 4 platform for advanced traders with powerful tools.</span>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section><!-- /Supported Platforms Section -->

  <!-- Testimonials Section -->
  <section id="testimonials" class="testimonials section dark-background">

    <img src="{{ asset('bizland/img/testimonials-bg.jpg') }}" class="testimonials-bg" alt="">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper init-swiper">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": { "delay": 5000 },
            "slidesPerView": "auto",
            "pagination": {
              "el": ".swiper-pagination",
              "type": "bullets",
              "clickable": true
            }
          }
        </script>
        <div class="swiper-wrapper">

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="{{ asset('bizland/img/testimonials/testimonials-1.jpg') }}" class="testimonial-img" alt="">
              <h3>Michael Thompson</h3>
              <h4>Investor</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>I've been trading for years and Bull Pro is by far the most reliable platform I've used. The interface is intuitive, withdrawals are fast, and the support team is always available whenever I need help.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="{{ asset('bizland/img/testimonials/testimonials-2.jpg') }}" class="testimonial-img" alt="">
              <h3>Sarah Collins</h3>
              <h4>Day Trader</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Bull Pro has completely transformed my trading experience. The platform is fast, secure, and offers a wide range of assets. I've been consistently profitable since joining and couldn't be happier.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="{{ asset('bizland/img/testimonials/testimonials-3.jpg') }}" class="testimonial-img" alt="">
              <h3>David Martinez</h3>
              <h4>Beginner Investor</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>As someone new to investing, I was nervous about getting started. Bull Pro made it incredibly easy. The educational resources and responsive support helped me understand trading quickly and confidently.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="{{ asset('bizland/img/testimonials/testimonials-4.jpg') }}" class="testimonial-img" alt="">
              <h3>Emma Johnson</h3>
              <h4>Entrepreneur</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>I was skeptical at first, but Bull Pro exceeded all my expectations. The security features are top-notch, and I've never had any issues with deposits or withdrawals. Truly a platform you can trust.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="{{ asset('bizland/img/testimonials/testimonials-5.jpg') }}" class="testimonial-img" alt="">
              <h3>James Williams</h3>
              <h4>Forex Trader</h4>
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p>
                <i class="bi bi-quote quote-icon-left"></i>
                <span>Bull Pro's customer support is outstanding. Any time I've had a question or issue, the team has responded quickly and professionally. I highly recommend this platform to any serious trader.</span>
                <i class="bi bi-quote quote-icon-right"></i>
              </p>
            </div>
          </div>

        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

  </section><!-- /Testimonials Section -->

  <!-- FAQ Section -->
  <section id="faq" class="faq section light-background">

    <div class="container section-title" data-aos="fade-up">
      <h2>F.A.Q</h2>
      <p><span>Frequently Asked</span> <span class="description-title">Questions</span></p>
    </div>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
          <div class="faq-container">

            @forelse($faqs as $faq)
            <div class="faq-item{{ $loop->first ? ' faq-active' : '' }}">
              <h3>{{ $faq->question }}</h3>
              <div class="faq-content">
                <p>{{ $faq->answer }}</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div>
            @empty
            <p class="text-center text-muted">No FAQs available at the moment.</p>
            @endforelse

          </div>
        </div>
      </div>
    </div>

  </section><!-- /FAQ Section -->

  <!-- Contact Section -->
  <section id="contact" class="contact section">

    <div class="container section-title" data-aos="fade-up">
      <h2>Contact</h2>
      <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4 justify-content-center">

        <div class="col-lg-5">
          <div class="info-wrap">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>info@finxstockbull.com</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-headset flex-shrink-0"></i>
              <div>
                <h3>Live Support</h3>
                <p>24/7 customer support available via live chat and email</p>
              </div>
            </div>
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-clock flex-shrink-0"></i>
              <div>
                <h3>Support Hours</h3>
                <p>Monday – Sunday: 24 hours a day, 7 days a week</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-7">
          <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            @csrf
            <div class="row gy-4">
              <div class="col-md-6">
                <label for="name-field" class="pb-2">Your Name</label>
                <input type="text" name="name" id="name-field" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="email-field" class="pb-2">Your Email</label>
                <input type="email" name="email" id="email-field" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label for="subject-field" class="pb-2">Subject</label>
                <input type="text" name="subject" id="subject-field" class="form-control" required>
              </div>
              <div class="col-md-12">
                <label for="message-field" class="pb-2">Message</label>
                <textarea class="form-control" name="message" rows="8" id="message-field" required></textarea>
              </div>
              <div class="col-md-12 text-center">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
                <button type="submit">Send Message</button>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>

  </section><!-- /Contact Section -->

@endsection
