@extends('layouts.auth')

@section('title', 'Sign Up - Bull Pro')

@section('content')
<div class="d-flex min-vh-100">

  <!-- Form Column -->
  <div class="col-12 col-lg-7 d-flex align-items-center py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-11 col-md-10 col-lg-11 col-xl-10">

          <!-- Logo -->
          <div class="mb-4">
            <a href="{{ route('home') }}" class="auth-logo-text text-decoration-none d-inline-flex align-items-center gap-2">
              <i class="bi bi-graph-up-arrow"></i>
              <span>BullPro</span>
            </a>
          </div>

          <h3 class="fw-bold mb-1">Free Sign Up</h3>
          <p class="text-muted mb-4 small">Don't have an account? Create your account, it takes less than a minute.</p>

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="row">

              <!-- Username -->
              <div class="col-lg-6 mb-3">
                <label for="username" class="form-label fw-semibold small">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required>
                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <!-- Full Name -->
              <div class="col-lg-6 mb-3">
                <label for="full_name" class="form-label fw-semibold small">Full Name</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <!-- Email -->
              <div class="col-lg-6 mb-3">
                <label for="email" class="form-label fw-semibold small">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <!-- Phone -->
              <div class="col-lg-6 mb-3">
                <label for="phone" class="form-label fw-semibold small">Phone Number</label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <!-- Country -->
              <div class="col-lg-6 mb-3">
                <label for="country" class="form-label fw-semibold small">Country</label>
                <select class="form-select @error('country') is-invalid @enderror" id="country" name="country" required>
                  <option value="">Select Country</option>
                  <option value="AF" {{ old('country')=='AF'?'selected':'' }}>Afghanistan</option>
                  <option value="AL" {{ old('country')=='AL'?'selected':'' }}>Albania</option>
                  <option value="DZ" {{ old('country')=='DZ'?'selected':'' }}>Algeria</option>
                  <option value="AD" {{ old('country')=='AD'?'selected':'' }}>Andorra</option>
                  <option value="AO" {{ old('country')=='AO'?'selected':'' }}>Angola</option>
                  <option value="AG" {{ old('country')=='AG'?'selected':'' }}>Antigua and Barbuda</option>
                  <option value="AR" {{ old('country')=='AR'?'selected':'' }}>Argentina</option>
                  <option value="AM" {{ old('country')=='AM'?'selected':'' }}>Armenia</option>
                  <option value="AU" {{ old('country')=='AU'?'selected':'' }}>Australia</option>
                  <option value="AT" {{ old('country')=='AT'?'selected':'' }}>Austria</option>
                  <option value="AZ" {{ old('country')=='AZ'?'selected':'' }}>Azerbaijan</option>
                  <option value="BS" {{ old('country')=='BS'?'selected':'' }}>Bahamas</option>
                  <option value="BH" {{ old('country')=='BH'?'selected':'' }}>Bahrain</option>
                  <option value="BD" {{ old('country')=='BD'?'selected':'' }}>Bangladesh</option>
                  <option value="BB" {{ old('country')=='BB'?'selected':'' }}>Barbados</option>
                  <option value="BY" {{ old('country')=='BY'?'selected':'' }}>Belarus</option>
                  <option value="BE" {{ old('country')=='BE'?'selected':'' }}>Belgium</option>
                  <option value="BZ" {{ old('country')=='BZ'?'selected':'' }}>Belize</option>
                  <option value="BJ" {{ old('country')=='BJ'?'selected':'' }}>Benin</option>
                  <option value="BT" {{ old('country')=='BT'?'selected':'' }}>Bhutan</option>
                  <option value="BO" {{ old('country')=='BO'?'selected':'' }}>Bolivia</option>
                  <option value="BA" {{ old('country')=='BA'?'selected':'' }}>Bosnia and Herzegovina</option>
                  <option value="BW" {{ old('country')=='BW'?'selected':'' }}>Botswana</option>
                  <option value="BR" {{ old('country')=='BR'?'selected':'' }}>Brazil</option>
                  <option value="BN" {{ old('country')=='BN'?'selected':'' }}>Brunei</option>
                  <option value="BG" {{ old('country')=='BG'?'selected':'' }}>Bulgaria</option>
                  <option value="BF" {{ old('country')=='BF'?'selected':'' }}>Burkina Faso</option>
                  <option value="BI" {{ old('country')=='BI'?'selected':'' }}>Burundi</option>
                  <option value="CV" {{ old('country')=='CV'?'selected':'' }}>Cabo Verde</option>
                  <option value="KH" {{ old('country')=='KH'?'selected':'' }}>Cambodia</option>
                  <option value="CM" {{ old('country')=='CM'?'selected':'' }}>Cameroon</option>
                  <option value="CA" {{ old('country')=='CA'?'selected':'' }}>Canada</option>
                  <option value="CF" {{ old('country')=='CF'?'selected':'' }}>Central African Republic</option>
                  <option value="TD" {{ old('country')=='TD'?'selected':'' }}>Chad</option>
                  <option value="CL" {{ old('country')=='CL'?'selected':'' }}>Chile</option>
                  <option value="CN" {{ old('country')=='CN'?'selected':'' }}>China</option>
                  <option value="CO" {{ old('country')=='CO'?'selected':'' }}>Colombia</option>
                  <option value="KM" {{ old('country')=='KM'?'selected':'' }}>Comoros</option>
                  <option value="CG" {{ old('country')=='CG'?'selected':'' }}>Congo</option>
                  <option value="CR" {{ old('country')=='CR'?'selected':'' }}>Costa Rica</option>
                  <option value="HR" {{ old('country')=='HR'?'selected':'' }}>Croatia</option>
                  <option value="CU" {{ old('country')=='CU'?'selected':'' }}>Cuba</option>
                  <option value="CY" {{ old('country')=='CY'?'selected':'' }}>Cyprus</option>
                  <option value="CZ" {{ old('country')=='CZ'?'selected':'' }}>Czech Republic</option>
                  <option value="DK" {{ old('country')=='DK'?'selected':'' }}>Denmark</option>
                  <option value="DJ" {{ old('country')=='DJ'?'selected':'' }}>Djibouti</option>
                  <option value="DM" {{ old('country')=='DM'?'selected':'' }}>Dominica</option>
                  <option value="DO" {{ old('country')=='DO'?'selected':'' }}>Dominican Republic</option>
                  <option value="EC" {{ old('country')=='EC'?'selected':'' }}>Ecuador</option>
                  <option value="EG" {{ old('country')=='EG'?'selected':'' }}>Egypt</option>
                  <option value="SV" {{ old('country')=='SV'?'selected':'' }}>El Salvador</option>
                  <option value="GQ" {{ old('country')=='GQ'?'selected':'' }}>Equatorial Guinea</option>
                  <option value="ER" {{ old('country')=='ER'?'selected':'' }}>Eritrea</option>
                  <option value="EE" {{ old('country')=='EE'?'selected':'' }}>Estonia</option>
                  <option value="SZ" {{ old('country')=='SZ'?'selected':'' }}>Eswatini</option>
                  <option value="ET" {{ old('country')=='ET'?'selected':'' }}>Ethiopia</option>
                  <option value="FJ" {{ old('country')=='FJ'?'selected':'' }}>Fiji</option>
                  <option value="FI" {{ old('country')=='FI'?'selected':'' }}>Finland</option>
                  <option value="FR" {{ old('country')=='FR'?'selected':'' }}>France</option>
                  <option value="GA" {{ old('country')=='GA'?'selected':'' }}>Gabon</option>
                  <option value="GM" {{ old('country')=='GM'?'selected':'' }}>Gambia</option>
                  <option value="GE" {{ old('country')=='GE'?'selected':'' }}>Georgia</option>
                  <option value="DE" {{ old('country')=='DE'?'selected':'' }}>Germany</option>
                  <option value="GH" {{ old('country')=='GH'?'selected':'' }}>Ghana</option>
                  <option value="GR" {{ old('country')=='GR'?'selected':'' }}>Greece</option>
                  <option value="GD" {{ old('country')=='GD'?'selected':'' }}>Grenada</option>
                  <option value="GT" {{ old('country')=='GT'?'selected':'' }}>Guatemala</option>
                  <option value="GN" {{ old('country')=='GN'?'selected':'' }}>Guinea</option>
                  <option value="GW" {{ old('country')=='GW'?'selected':'' }}>Guinea-Bissau</option>
                  <option value="GY" {{ old('country')=='GY'?'selected':'' }}>Guyana</option>
                  <option value="HT" {{ old('country')=='HT'?'selected':'' }}>Haiti</option>
                  <option value="HN" {{ old('country')=='HN'?'selected':'' }}>Honduras</option>
                  <option value="HU" {{ old('country')=='HU'?'selected':'' }}>Hungary</option>
                  <option value="IS" {{ old('country')=='IS'?'selected':'' }}>Iceland</option>
                  <option value="IN" {{ old('country')=='IN'?'selected':'' }}>India</option>
                  <option value="ID" {{ old('country')=='ID'?'selected':'' }}>Indonesia</option>
                  <option value="IR" {{ old('country')=='IR'?'selected':'' }}>Iran</option>
                  <option value="IQ" {{ old('country')=='IQ'?'selected':'' }}>Iraq</option>
                  <option value="IE" {{ old('country')=='IE'?'selected':'' }}>Ireland</option>
                  <option value="IL" {{ old('country')=='IL'?'selected':'' }}>Israel</option>
                  <option value="IT" {{ old('country')=='IT'?'selected':'' }}>Italy</option>
                  <option value="JM" {{ old('country')=='JM'?'selected':'' }}>Jamaica</option>
                  <option value="JP" {{ old('country')=='JP'?'selected':'' }}>Japan</option>
                  <option value="JO" {{ old('country')=='JO'?'selected':'' }}>Jordan</option>
                  <option value="KZ" {{ old('country')=='KZ'?'selected':'' }}>Kazakhstan</option>
                  <option value="KE" {{ old('country')=='KE'?'selected':'' }}>Kenya</option>
                  <option value="KI" {{ old('country')=='KI'?'selected':'' }}>Kiribati</option>
                  <option value="KW" {{ old('country')=='KW'?'selected':'' }}>Kuwait</option>
                  <option value="KG" {{ old('country')=='KG'?'selected':'' }}>Kyrgyzstan</option>
                  <option value="LA" {{ old('country')=='LA'?'selected':'' }}>Laos</option>
                  <option value="LV" {{ old('country')=='LV'?'selected':'' }}>Latvia</option>
                  <option value="LB" {{ old('country')=='LB'?'selected':'' }}>Lebanon</option>
                  <option value="LS" {{ old('country')=='LS'?'selected':'' }}>Lesotho</option>
                  <option value="LR" {{ old('country')=='LR'?'selected':'' }}>Liberia</option>
                  <option value="LY" {{ old('country')=='LY'?'selected':'' }}>Libya</option>
                  <option value="LI" {{ old('country')=='LI'?'selected':'' }}>Liechtenstein</option>
                  <option value="LT" {{ old('country')=='LT'?'selected':'' }}>Lithuania</option>
                  <option value="LU" {{ old('country')=='LU'?'selected':'' }}>Luxembourg</option>
                  <option value="MG" {{ old('country')=='MG'?'selected':'' }}>Madagascar</option>
                  <option value="MW" {{ old('country')=='MW'?'selected':'' }}>Malawi</option>
                  <option value="MY" {{ old('country')=='MY'?'selected':'' }}>Malaysia</option>
                  <option value="MV" {{ old('country')=='MV'?'selected':'' }}>Maldives</option>
                  <option value="ML" {{ old('country')=='ML'?'selected':'' }}>Mali</option>
                  <option value="MT" {{ old('country')=='MT'?'selected':'' }}>Malta</option>
                  <option value="MH" {{ old('country')=='MH'?'selected':'' }}>Marshall Islands</option>
                  <option value="MR" {{ old('country')=='MR'?'selected':'' }}>Mauritania</option>
                  <option value="MU" {{ old('country')=='MU'?'selected':'' }}>Mauritius</option>
                  <option value="MX" {{ old('country')=='MX'?'selected':'' }}>Mexico</option>
                  <option value="FM" {{ old('country')=='FM'?'selected':'' }}>Micronesia</option>
                  <option value="MD" {{ old('country')=='MD'?'selected':'' }}>Moldova</option>
                  <option value="MC" {{ old('country')=='MC'?'selected':'' }}>Monaco</option>
                  <option value="MN" {{ old('country')=='MN'?'selected':'' }}>Mongolia</option>
                  <option value="ME" {{ old('country')=='ME'?'selected':'' }}>Montenegro</option>
                  <option value="MA" {{ old('country')=='MA'?'selected':'' }}>Morocco</option>
                  <option value="MZ" {{ old('country')=='MZ'?'selected':'' }}>Mozambique</option>
                  <option value="MM" {{ old('country')=='MM'?'selected':'' }}>Myanmar</option>
                  <option value="NA" {{ old('country')=='NA'?'selected':'' }}>Namibia</option>
                  <option value="NR" {{ old('country')=='NR'?'selected':'' }}>Nauru</option>
                  <option value="NP" {{ old('country')=='NP'?'selected':'' }}>Nepal</option>
                  <option value="NL" {{ old('country')=='NL'?'selected':'' }}>Netherlands</option>
                  <option value="NZ" {{ old('country')=='NZ'?'selected':'' }}>New Zealand</option>
                  <option value="NI" {{ old('country')=='NI'?'selected':'' }}>Nicaragua</option>
                  <option value="NE" {{ old('country')=='NE'?'selected':'' }}>Niger</option>
                  <option value="NG" {{ old('country')=='NG'?'selected':'' }}>Nigeria</option>
                  <option value="NO" {{ old('country')=='NO'?'selected':'' }}>Norway</option>
                  <option value="OM" {{ old('country')=='OM'?'selected':'' }}>Oman</option>
                  <option value="PK" {{ old('country')=='PK'?'selected':'' }}>Pakistan</option>
                  <option value="PW" {{ old('country')=='PW'?'selected':'' }}>Palau</option>
                  <option value="PA" {{ old('country')=='PA'?'selected':'' }}>Panama</option>
                  <option value="PG" {{ old('country')=='PG'?'selected':'' }}>Papua New Guinea</option>
                  <option value="PY" {{ old('country')=='PY'?'selected':'' }}>Paraguay</option>
                  <option value="PE" {{ old('country')=='PE'?'selected':'' }}>Peru</option>
                  <option value="PH" {{ old('country')=='PH'?'selected':'' }}>Philippines</option>
                  <option value="PL" {{ old('country')=='PL'?'selected':'' }}>Poland</option>
                  <option value="PT" {{ old('country')=='PT'?'selected':'' }}>Portugal</option>
                  <option value="QA" {{ old('country')=='QA'?'selected':'' }}>Qatar</option>
                  <option value="RO" {{ old('country')=='RO'?'selected':'' }}>Romania</option>
                  <option value="RU" {{ old('country')=='RU'?'selected':'' }}>Russia</option>
                  <option value="RW" {{ old('country')=='RW'?'selected':'' }}>Rwanda</option>
                  <option value="KN" {{ old('country')=='KN'?'selected':'' }}>Saint Kitts and Nevis</option>
                  <option value="LC" {{ old('country')=='LC'?'selected':'' }}>Saint Lucia</option>
                  <option value="VC" {{ old('country')=='VC'?'selected':'' }}>Saint Vincent and the Grenadines</option>
                  <option value="WS" {{ old('country')=='WS'?'selected':'' }}>Samoa</option>
                  <option value="SM" {{ old('country')=='SM'?'selected':'' }}>San Marino</option>
                  <option value="ST" {{ old('country')=='ST'?'selected':'' }}>Sao Tome and Principe</option>
                  <option value="SA" {{ old('country')=='SA'?'selected':'' }}>Saudi Arabia</option>
                  <option value="SN" {{ old('country')=='SN'?'selected':'' }}>Senegal</option>
                  <option value="RS" {{ old('country')=='RS'?'selected':'' }}>Serbia</option>
                  <option value="SC" {{ old('country')=='SC'?'selected':'' }}>Seychelles</option>
                  <option value="SL" {{ old('country')=='SL'?'selected':'' }}>Sierra Leone</option>
                  <option value="SG" {{ old('country')=='SG'?'selected':'' }}>Singapore</option>
                  <option value="SK" {{ old('country')=='SK'?'selected':'' }}>Slovakia</option>
                  <option value="SI" {{ old('country')=='SI'?'selected':'' }}>Slovenia</option>
                  <option value="SB" {{ old('country')=='SB'?'selected':'' }}>Solomon Islands</option>
                  <option value="SO" {{ old('country')=='SO'?'selected':'' }}>Somalia</option>
                  <option value="ZA" {{ old('country')=='ZA'?'selected':'' }}>South Africa</option>
                  <option value="SS" {{ old('country')=='SS'?'selected':'' }}>South Sudan</option>
                  <option value="ES" {{ old('country')=='ES'?'selected':'' }}>Spain</option>
                  <option value="LK" {{ old('country')=='LK'?'selected':'' }}>Sri Lanka</option>
                  <option value="SD" {{ old('country')=='SD'?'selected':'' }}>Sudan</option>
                  <option value="SR" {{ old('country')=='SR'?'selected':'' }}>Suriname</option>
                  <option value="SE" {{ old('country')=='SE'?'selected':'' }}>Sweden</option>
                  <option value="CH" {{ old('country')=='CH'?'selected':'' }}>Switzerland</option>
                  <option value="SY" {{ old('country')=='SY'?'selected':'' }}>Syria</option>
                  <option value="TW" {{ old('country')=='TW'?'selected':'' }}>Taiwan</option>
                  <option value="TJ" {{ old('country')=='TJ'?'selected':'' }}>Tajikistan</option>
                  <option value="TZ" {{ old('country')=='TZ'?'selected':'' }}>Tanzania</option>
                  <option value="TH" {{ old('country')=='TH'?'selected':'' }}>Thailand</option>
                  <option value="TL" {{ old('country')=='TL'?'selected':'' }}>Timor-Leste</option>
                  <option value="TG" {{ old('country')=='TG'?'selected':'' }}>Togo</option>
                  <option value="TO" {{ old('country')=='TO'?'selected':'' }}>Tonga</option>
                  <option value="TT" {{ old('country')=='TT'?'selected':'' }}>Trinidad and Tobago</option>
                  <option value="TN" {{ old('country')=='TN'?'selected':'' }}>Tunisia</option>
                  <option value="TR" {{ old('country')=='TR'?'selected':'' }}>Turkey</option>
                  <option value="TM" {{ old('country')=='TM'?'selected':'' }}>Turkmenistan</option>
                  <option value="TV" {{ old('country')=='TV'?'selected':'' }}>Tuvalu</option>
                  <option value="UG" {{ old('country')=='UG'?'selected':'' }}>Uganda</option>
                  <option value="UA" {{ old('country')=='UA'?'selected':'' }}>Ukraine</option>
                  <option value="AE" {{ old('country')=='AE'?'selected':'' }}>United Arab Emirates</option>
                  <option value="GB" {{ old('country')=='GB'?'selected':'' }}>United Kingdom</option>
                  <option value="US" {{ old('country')=='US'?'selected':'' }}>United States</option>
                  <option value="UY" {{ old('country')=='UY'?'selected':'' }}>Uruguay</option>
                  <option value="UZ" {{ old('country')=='UZ'?'selected':'' }}>Uzbekistan</option>
                  <option value="VU" {{ old('country')=='VU'?'selected':'' }}>Vanuatu</option>
                  <option value="VE" {{ old('country')=='VE'?'selected':'' }}>Venezuela</option>
                  <option value="VN" {{ old('country')=='VN'?'selected':'' }}>Vietnam</option>
                  <option value="YE" {{ old('country')=='YE'?'selected':'' }}>Yemen</option>
                  <option value="ZM" {{ old('country')=='ZM'?'selected':'' }}>Zambia</option>
                  <option value="ZW" {{ old('country')=='ZW'?'selected':'' }}>Zimbabwe</option>
                </select>
                @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <!-- Referral ID -->
              <div class="col-lg-6 mb-3">
                <label for="referral" class="form-label fw-semibold small">Referral ID <span class="text-muted fw-normal">(Optional)</span></label>
                <input type="text" class="form-control" id="referral" name="referral" value="{{ old('referral', request('ref')) }}">
              </div>

              <!-- Password -->
              <div class="col-lg-6 mb-3">
                <label for="password" class="form-label fw-semibold small">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                  <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                    <i class="bi bi-eye" id="togglePwdIcon"></i>
                  </button>
                  @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="col-lg-6 mb-3">
                <label for="password_confirmation" class="form-label fw-semibold small">Confirm Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                  <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" tabindex="-1">
                    <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                  </button>
                </div>
              </div>

            </div><!-- /.row -->

            <button type="submit" class="btn btn-auth w-100 mt-2">Get Started</button>

          </form>

          <p class="text-center mt-4 mb-0 text-muted small">
            Already registered?
            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: var(--accent-color);">Login</a>
          </p>

        </div>
      </div>
    </div>
  </div>

  <!-- Cover Image Column (desktop only) -->
  <div class="col-lg-5 d-none d-lg-block p-0 cover-col">
    <img src="{{ asset('bizland/img/hero-bg.jpg') }}" alt="Bull Pro Trading Platform">
  </div>

</div>
@endsection

@push('scripts')
<script>
  function setupToggle(btnId, inputId, iconId) {
    document.getElementById(btnId).addEventListener('click', function () {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
      }
    });
  }
  setupToggle('togglePassword', 'password', 'togglePwdIcon');
  setupToggle('toggleConfirmPassword', 'password_confirmation', 'toggleConfirmIcon');
</script>
@endpush
