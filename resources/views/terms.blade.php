@extends('layouts.app')

@section('title', 'Terms of Service - Bull Pro')
@section('description', 'Read the Bull Pro Terms of Service, Privacy Policy, and Risk Disclaimer.')

@section('content')

  <!-- Page Hero -->
  <section class="hero section dark-background" style="background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('{{ asset('bizland/img/hero-bg.jpg') }}') center/cover no-repeat; min-height: 280px;">
    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 280px;">
      <div class="text-center" data-aos="fade-up">
        <h1 class="text-white fw-bold mb-3">Terms of Service</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item">
              <a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item active text-white" aria-current="page">Terms of Service</li>
          </ol>
        </nav>
      </div>
    </div>
  </section>

  <!-- Terms Content -->
  <section class="section py-5">
    <div class="container" data-aos="fade-up">
      <div class="row justify-content-center">
        <div class="col-lg-10" style="color: rgb(51,51,51); font-family: 'Open Sans', sans-serif;">

          <h3 style="font-size:24px; font-weight:500;">1. CONFIDENTIALITY</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            All information provided by clients to Bull Pro is treated with the utmost confidentiality. We will not disclose any personal information to third parties without your explicit consent, except where required by law or regulatory authorities. Our staff are bound by strict confidentiality obligations and any breach of these obligations is treated as a serious disciplinary matter.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">2. PRIVACY STATEMENT</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro is committed to protecting your privacy. We collect and use personal information solely for the purpose of providing our services. Your data is stored securely and processed in accordance with applicable data protection laws. We do not sell, trade, or transfer your personally identifiable information to outside parties. Your information will not be sold, exchanged, transferred, or given to any other company without your consent.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">3. INVESTMENT POLICY</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro provides investment and trading services across multiple asset classes. All investments carry risk, and the value of investments may go up or down. We do not guarantee returns on any investment. Clients should only invest funds they can afford to lose and are encouraged to seek independent financial advice if necessary. Past performance of any investment or trading strategy is not necessarily indicative of future results.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">4. DISCLAIMER</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            The information provided on this website is for general informational purposes only. Bull Pro makes no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability, or availability of the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">5. WEBSITE AVAILABILITY AND PROTECTION AGAINST DDOS ATTACKS</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro strives to maintain continuous website availability and a seamless trading experience. However, we cannot guarantee uninterrupted, secure, or error-free service at all times. We implement industry-standard measures to protect our platform against DDoS attacks and other cyber threats. In the event of planned maintenance or emergency downtime, we will notify users in advance where possible. Bull Pro shall not be liable for any losses arising from interruptions in service availability.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">6. TERMINATION OF AGREEMENTS AND REFUND POLICY</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Either party may terminate the service agreement at any time by providing written notice. Upon termination, any remaining uninvested balance in your account will be processed for refund in accordance with our standard withdrawal policy. Bull Pro reserves the right to terminate accounts that violate our terms of service, engage in fraudulent activity, or pose a risk to other users or the platform. Refunds are processed within 5–10 business days from the date of request, subject to verification.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">7. MAINTENANCE</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro performs regular system maintenance to ensure optimal platform performance and security. Scheduled maintenance windows will be announced in advance via email and on-site notifications where possible. During maintenance periods, some or all services may be temporarily unavailable. We are not liable for any losses or missed trading opportunities incurred during scheduled or emergency maintenance periods.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">8. LOG FILES</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Like many online platforms, Bull Pro uses log files. The information inside the log files includes internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and number of clicks. This information is used to analyze trends, administer the site, track user movements, and gather aggregate demographic information. IP addresses and similar data are not linked to personally identifiable information.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">9. COOKIES</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro uses cookies to enhance your browsing experience, analyze site traffic, and personalize content. By using our website, you consent to our use of cookies in accordance with this policy. Cookies are small files that a site or its service provider transfers to your computer's hard drive through your Web browser. You can choose to disable cookies through your browser settings, but this may affect the functionality of certain areas of our website.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">10. LINKS TO THIS WEBSITE AND THE AFFILIATE PROGRAM</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro operates an affiliate program that allows qualified partners to earn commissions by referring new clients to our platform. Affiliates must comply with our affiliate program terms and conditions, including truthful representation of our services. We reserve the right to approve or reject affiliate applications and to terminate affiliate agreements for violations of our policies or any misrepresentation.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">11. LINKS OF THIS WEBSITE</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Our website may contain links to external third-party websites. These links are provided for your convenience and informational purposes only. Bull Pro has no control over the content, privacy practices, or policies of those external sites and accepts no responsibility for them or for any loss or damage that may arise from your use of them. The inclusion of any links does not necessarily imply a recommendation or endorsement of the views expressed therein.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">12. COPYRIGHT NOTICE</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            All content on this website, including but not limited to text, graphics, logos, images, audio clips, digital downloads, data compilations, and software, is the property of Bull Pro and is protected by applicable copyright laws. Unauthorized use, reproduction, modification, distribution, or display of any content from this website, in whole or in part, without the prior written permission of Bull Pro is strictly prohibited.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">13. COMMUNICATION</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            By registering with Bull Pro, you agree to receive communications from us via email and other electronic means. These communications may include account notifications, transaction confirmations, promotional offers, and important platform updates. You may opt out of marketing communications at any time by clicking the unsubscribe link in any promotional email or by contacting our support team directly.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">14. INVESTMENT RISKS WARNING</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Trading and investing in financial instruments involves substantial risk of loss. The value of investments can fall as well as rise, and you may receive back less than you originally invested. Past performance is not a reliable indicator of future results. Leveraged products such as CFDs can magnify both gains and losses. You should carefully consider your investment objectives, level of experience, and risk appetite before making any investment decisions. Only invest money you can afford to lose entirely.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">15. FORCE MAJEURE</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro shall not be held liable for any delays or failures in performance resulting from circumstances beyond our reasonable control, including but not limited to acts of God, natural disasters, war, terrorism, government actions, changes in laws or regulations, power outages, or internet or telecommunications service disruptions. We will make reasonable efforts to minimize the impact of such events on our service.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">16. WAIVER</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            The failure of Bull Pro to enforce any provision of these Terms of Service at any time shall not be construed as a waiver of that provision or of any other provision or right. Any waiver of specific terms must be made in writing and signed by an authorized representative of Bull Pro to be legally effective. No course of dealing or trade practice shall be deemed to modify these terms.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">17. GENERAL</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            These Terms of Service constitute the entire agreement between you and Bull Pro regarding your use of our services and supersede all prior agreements and understandings. If any provision of these terms is found to be invalid, illegal, or unenforceable by a court of competent jurisdiction, the remaining provisions shall remain in full force and effect. These terms are governed by and construed in accordance with applicable laws, and any disputes shall be subject to the exclusive jurisdiction of the relevant courts.
          </p>

          <h3 style="font-size:24px; font-weight:500; margin-top:30px;">18. NOTIFICATION OF CHANGES</h3>
          <p style="font-size:15px; line-height:23px; text-align:justify;">
            Bull Pro reserves the right to modify these Terms of Service at any time without prior notice. We will notify registered users of significant changes via email and by posting a notice on our website. Your continued use of our services following the notification or posting of changes to these terms constitutes your acceptance of those changes. We encourage you to review these terms periodically to stay informed of any updates. The date of the most recent revision will be indicated at the top of the terms page.
          </p>

        </div>
      </div>
    </div>
  </section>

@endsection
