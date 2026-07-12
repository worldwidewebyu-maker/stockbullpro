@extends('layouts.dashboard')
@section('title', 'Account Settings')
@section('breadcrumb', 'Profile')

@php
$activeTab = session('success_tab', session('active_tab', 'personal'));
@endphp

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Account Settings</h4>
</div>

@if(session('success'))
<div class="dash-alert-success mb-3"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">

        {{-- Tabs --}}
        <div class="profile-tabs">
            <button class="profile-tab {{ $activeTab === 'personal' ? 'active' : '' }}" data-tab="personal">Personal Settings</button>
            <button class="profile-tab {{ $activeTab === 'wallets' ? 'active' : '' }}" data-tab="wallets">Withdrawal Settings</button>
            <button class="profile-tab {{ $activeTab === 'password' ? 'active' : '' }}" data-tab="password">Password/Security</button>
            <button class="profile-tab {{ $activeTab === 'settings' ? 'active' : '' }}" data-tab="settings">Other Settings</button>
        </div>

        {{-- Personal Settings --}}
        <div class="profile-panel {{ $activeTab === 'personal' ? '' : 'd-none' }}" id="tab-personal">
            <div class="p-4">
                <h5 class="profile-section-title">Basic information</h5>
                <form method="POST" action="{{ route('dashboard.profile.personal') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="profile-field">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="profile-input @error('full_name') is-invalid @enderror"
                                    value="{{ old('full_name', $user->full_name) }}">
                                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="profile-field">
                                <label>Phone</label>
                                <input type="text" name="phone" class="profile-input @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="profile-field">
                                <label>Email address</label>
                                <input type="email" class="profile-input" value="{{ $user->email }}" disabled>
                                <small class="text-muted">Email address cannot be changed.</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="profile-field">
                                <label>Country</label>
                                @php $selectedCountry = old('country', $user->country); @endphp
                                <select name="country" class="profile-input @error('country') is-invalid @enderror">
                                    <option value="">Select Country</option>
                                    <option value="AF" {{ $selectedCountry=='AF'?'selected':'' }}>Afghanistan</option>
                                    <option value="AL" {{ $selectedCountry=='AL'?'selected':'' }}>Albania</option>
                                    <option value="DZ" {{ $selectedCountry=='DZ'?'selected':'' }}>Algeria</option>
                                    <option value="AD" {{ $selectedCountry=='AD'?'selected':'' }}>Andorra</option>
                                    <option value="AO" {{ $selectedCountry=='AO'?'selected':'' }}>Angola</option>
                                    <option value="AG" {{ $selectedCountry=='AG'?'selected':'' }}>Antigua and Barbuda</option>
                                    <option value="AR" {{ $selectedCountry=='AR'?'selected':'' }}>Argentina</option>
                                    <option value="AM" {{ $selectedCountry=='AM'?'selected':'' }}>Armenia</option>
                                    <option value="AU" {{ $selectedCountry=='AU'?'selected':'' }}>Australia</option>
                                    <option value="AT" {{ $selectedCountry=='AT'?'selected':'' }}>Austria</option>
                                    <option value="AZ" {{ $selectedCountry=='AZ'?'selected':'' }}>Azerbaijan</option>
                                    <option value="BS" {{ $selectedCountry=='BS'?'selected':'' }}>Bahamas</option>
                                    <option value="BH" {{ $selectedCountry=='BH'?'selected':'' }}>Bahrain</option>
                                    <option value="BD" {{ $selectedCountry=='BD'?'selected':'' }}>Bangladesh</option>
                                    <option value="BB" {{ $selectedCountry=='BB'?'selected':'' }}>Barbados</option>
                                    <option value="BY" {{ $selectedCountry=='BY'?'selected':'' }}>Belarus</option>
                                    <option value="BE" {{ $selectedCountry=='BE'?'selected':'' }}>Belgium</option>
                                    <option value="BZ" {{ $selectedCountry=='BZ'?'selected':'' }}>Belize</option>
                                    <option value="BJ" {{ $selectedCountry=='BJ'?'selected':'' }}>Benin</option>
                                    <option value="BT" {{ $selectedCountry=='BT'?'selected':'' }}>Bhutan</option>
                                    <option value="BO" {{ $selectedCountry=='BO'?'selected':'' }}>Bolivia</option>
                                    <option value="BA" {{ $selectedCountry=='BA'?'selected':'' }}>Bosnia and Herzegovina</option>
                                    <option value="BW" {{ $selectedCountry=='BW'?'selected':'' }}>Botswana</option>
                                    <option value="BR" {{ $selectedCountry=='BR'?'selected':'' }}>Brazil</option>
                                    <option value="BN" {{ $selectedCountry=='BN'?'selected':'' }}>Brunei</option>
                                    <option value="BG" {{ $selectedCountry=='BG'?'selected':'' }}>Bulgaria</option>
                                    <option value="BF" {{ $selectedCountry=='BF'?'selected':'' }}>Burkina Faso</option>
                                    <option value="BI" {{ $selectedCountry=='BI'?'selected':'' }}>Burundi</option>
                                    <option value="CV" {{ $selectedCountry=='CV'?'selected':'' }}>Cabo Verde</option>
                                    <option value="KH" {{ $selectedCountry=='KH'?'selected':'' }}>Cambodia</option>
                                    <option value="CM" {{ $selectedCountry=='CM'?'selected':'' }}>Cameroon</option>
                                    <option value="CA" {{ $selectedCountry=='CA'?'selected':'' }}>Canada</option>
                                    <option value="CF" {{ $selectedCountry=='CF'?'selected':'' }}>Central African Republic</option>
                                    <option value="TD" {{ $selectedCountry=='TD'?'selected':'' }}>Chad</option>
                                    <option value="CL" {{ $selectedCountry=='CL'?'selected':'' }}>Chile</option>
                                    <option value="CN" {{ $selectedCountry=='CN'?'selected':'' }}>China</option>
                                    <option value="CO" {{ $selectedCountry=='CO'?'selected':'' }}>Colombia</option>
                                    <option value="KM" {{ $selectedCountry=='KM'?'selected':'' }}>Comoros</option>
                                    <option value="CG" {{ $selectedCountry=='CG'?'selected':'' }}>Congo</option>
                                    <option value="CR" {{ $selectedCountry=='CR'?'selected':'' }}>Costa Rica</option>
                                    <option value="HR" {{ $selectedCountry=='HR'?'selected':'' }}>Croatia</option>
                                    <option value="CU" {{ $selectedCountry=='CU'?'selected':'' }}>Cuba</option>
                                    <option value="CY" {{ $selectedCountry=='CY'?'selected':'' }}>Cyprus</option>
                                    <option value="CZ" {{ $selectedCountry=='CZ'?'selected':'' }}>Czech Republic</option>
                                    <option value="DK" {{ $selectedCountry=='DK'?'selected':'' }}>Denmark</option>
                                    <option value="DJ" {{ $selectedCountry=='DJ'?'selected':'' }}>Djibouti</option>
                                    <option value="DM" {{ $selectedCountry=='DM'?'selected':'' }}>Dominica</option>
                                    <option value="DO" {{ $selectedCountry=='DO'?'selected':'' }}>Dominican Republic</option>
                                    <option value="EC" {{ $selectedCountry=='EC'?'selected':'' }}>Ecuador</option>
                                    <option value="EG" {{ $selectedCountry=='EG'?'selected':'' }}>Egypt</option>
                                    <option value="SV" {{ $selectedCountry=='SV'?'selected':'' }}>El Salvador</option>
                                    <option value="GQ" {{ $selectedCountry=='GQ'?'selected':'' }}>Equatorial Guinea</option>
                                    <option value="ER" {{ $selectedCountry=='ER'?'selected':'' }}>Eritrea</option>
                                    <option value="EE" {{ $selectedCountry=='EE'?'selected':'' }}>Estonia</option>
                                    <option value="SZ" {{ $selectedCountry=='SZ'?'selected':'' }}>Eswatini</option>
                                    <option value="ET" {{ $selectedCountry=='ET'?'selected':'' }}>Ethiopia</option>
                                    <option value="FJ" {{ $selectedCountry=='FJ'?'selected':'' }}>Fiji</option>
                                    <option value="FI" {{ $selectedCountry=='FI'?'selected':'' }}>Finland</option>
                                    <option value="FR" {{ $selectedCountry=='FR'?'selected':'' }}>France</option>
                                    <option value="GA" {{ $selectedCountry=='GA'?'selected':'' }}>Gabon</option>
                                    <option value="GM" {{ $selectedCountry=='GM'?'selected':'' }}>Gambia</option>
                                    <option value="GE" {{ $selectedCountry=='GE'?'selected':'' }}>Georgia</option>
                                    <option value="DE" {{ $selectedCountry=='DE'?'selected':'' }}>Germany</option>
                                    <option value="GH" {{ $selectedCountry=='GH'?'selected':'' }}>Ghana</option>
                                    <option value="GR" {{ $selectedCountry=='GR'?'selected':'' }}>Greece</option>
                                    <option value="GD" {{ $selectedCountry=='GD'?'selected':'' }}>Grenada</option>
                                    <option value="GT" {{ $selectedCountry=='GT'?'selected':'' }}>Guatemala</option>
                                    <option value="GN" {{ $selectedCountry=='GN'?'selected':'' }}>Guinea</option>
                                    <option value="GW" {{ $selectedCountry=='GW'?'selected':'' }}>Guinea-Bissau</option>
                                    <option value="GY" {{ $selectedCountry=='GY'?'selected':'' }}>Guyana</option>
                                    <option value="HT" {{ $selectedCountry=='HT'?'selected':'' }}>Haiti</option>
                                    <option value="HN" {{ $selectedCountry=='HN'?'selected':'' }}>Honduras</option>
                                    <option value="HU" {{ $selectedCountry=='HU'?'selected':'' }}>Hungary</option>
                                    <option value="IS" {{ $selectedCountry=='IS'?'selected':'' }}>Iceland</option>
                                    <option value="IN" {{ $selectedCountry=='IN'?'selected':'' }}>India</option>
                                    <option value="ID" {{ $selectedCountry=='ID'?'selected':'' }}>Indonesia</option>
                                    <option value="IR" {{ $selectedCountry=='IR'?'selected':'' }}>Iran</option>
                                    <option value="IQ" {{ $selectedCountry=='IQ'?'selected':'' }}>Iraq</option>
                                    <option value="IE" {{ $selectedCountry=='IE'?'selected':'' }}>Ireland</option>
                                    <option value="IL" {{ $selectedCountry=='IL'?'selected':'' }}>Israel</option>
                                    <option value="IT" {{ $selectedCountry=='IT'?'selected':'' }}>Italy</option>
                                    <option value="JM" {{ $selectedCountry=='JM'?'selected':'' }}>Jamaica</option>
                                    <option value="JP" {{ $selectedCountry=='JP'?'selected':'' }}>Japan</option>
                                    <option value="JO" {{ $selectedCountry=='JO'?'selected':'' }}>Jordan</option>
                                    <option value="KZ" {{ $selectedCountry=='KZ'?'selected':'' }}>Kazakhstan</option>
                                    <option value="KE" {{ $selectedCountry=='KE'?'selected':'' }}>Kenya</option>
                                    <option value="KI" {{ $selectedCountry=='KI'?'selected':'' }}>Kiribati</option>
                                    <option value="KW" {{ $selectedCountry=='KW'?'selected':'' }}>Kuwait</option>
                                    <option value="KG" {{ $selectedCountry=='KG'?'selected':'' }}>Kyrgyzstan</option>
                                    <option value="LA" {{ $selectedCountry=='LA'?'selected':'' }}>Laos</option>
                                    <option value="LV" {{ $selectedCountry=='LV'?'selected':'' }}>Latvia</option>
                                    <option value="LB" {{ $selectedCountry=='LB'?'selected':'' }}>Lebanon</option>
                                    <option value="LS" {{ $selectedCountry=='LS'?'selected':'' }}>Lesotho</option>
                                    <option value="LR" {{ $selectedCountry=='LR'?'selected':'' }}>Liberia</option>
                                    <option value="LY" {{ $selectedCountry=='LY'?'selected':'' }}>Libya</option>
                                    <option value="LI" {{ $selectedCountry=='LI'?'selected':'' }}>Liechtenstein</option>
                                    <option value="LT" {{ $selectedCountry=='LT'?'selected':'' }}>Lithuania</option>
                                    <option value="LU" {{ $selectedCountry=='LU'?'selected':'' }}>Luxembourg</option>
                                    <option value="MG" {{ $selectedCountry=='MG'?'selected':'' }}>Madagascar</option>
                                    <option value="MW" {{ $selectedCountry=='MW'?'selected':'' }}>Malawi</option>
                                    <option value="MY" {{ $selectedCountry=='MY'?'selected':'' }}>Malaysia</option>
                                    <option value="MV" {{ $selectedCountry=='MV'?'selected':'' }}>Maldives</option>
                                    <option value="ML" {{ $selectedCountry=='ML'?'selected':'' }}>Mali</option>
                                    <option value="MT" {{ $selectedCountry=='MT'?'selected':'' }}>Malta</option>
                                    <option value="MH" {{ $selectedCountry=='MH'?'selected':'' }}>Marshall Islands</option>
                                    <option value="MR" {{ $selectedCountry=='MR'?'selected':'' }}>Mauritania</option>
                                    <option value="MU" {{ $selectedCountry=='MU'?'selected':'' }}>Mauritius</option>
                                    <option value="MX" {{ $selectedCountry=='MX'?'selected':'' }}>Mexico</option>
                                    <option value="FM" {{ $selectedCountry=='FM'?'selected':'' }}>Micronesia</option>
                                    <option value="MD" {{ $selectedCountry=='MD'?'selected':'' }}>Moldova</option>
                                    <option value="MC" {{ $selectedCountry=='MC'?'selected':'' }}>Monaco</option>
                                    <option value="MN" {{ $selectedCountry=='MN'?'selected':'' }}>Mongolia</option>
                                    <option value="ME" {{ $selectedCountry=='ME'?'selected':'' }}>Montenegro</option>
                                    <option value="MA" {{ $selectedCountry=='MA'?'selected':'' }}>Morocco</option>
                                    <option value="MZ" {{ $selectedCountry=='MZ'?'selected':'' }}>Mozambique</option>
                                    <option value="MM" {{ $selectedCountry=='MM'?'selected':'' }}>Myanmar</option>
                                    <option value="NA" {{ $selectedCountry=='NA'?'selected':'' }}>Namibia</option>
                                    <option value="NR" {{ $selectedCountry=='NR'?'selected':'' }}>Nauru</option>
                                    <option value="NP" {{ $selectedCountry=='NP'?'selected':'' }}>Nepal</option>
                                    <option value="NL" {{ $selectedCountry=='NL'?'selected':'' }}>Netherlands</option>
                                    <option value="NZ" {{ $selectedCountry=='NZ'?'selected':'' }}>New Zealand</option>
                                    <option value="NI" {{ $selectedCountry=='NI'?'selected':'' }}>Nicaragua</option>
                                    <option value="NE" {{ $selectedCountry=='NE'?'selected':'' }}>Niger</option>
                                    <option value="NG" {{ $selectedCountry=='NG'?'selected':'' }}>Nigeria</option>
                                    <option value="NO" {{ $selectedCountry=='NO'?'selected':'' }}>Norway</option>
                                    <option value="OM" {{ $selectedCountry=='OM'?'selected':'' }}>Oman</option>
                                    <option value="PK" {{ $selectedCountry=='PK'?'selected':'' }}>Pakistan</option>
                                    <option value="PW" {{ $selectedCountry=='PW'?'selected':'' }}>Palau</option>
                                    <option value="PA" {{ $selectedCountry=='PA'?'selected':'' }}>Panama</option>
                                    <option value="PG" {{ $selectedCountry=='PG'?'selected':'' }}>Papua New Guinea</option>
                                    <option value="PY" {{ $selectedCountry=='PY'?'selected':'' }}>Paraguay</option>
                                    <option value="PE" {{ $selectedCountry=='PE'?'selected':'' }}>Peru</option>
                                    <option value="PH" {{ $selectedCountry=='PH'?'selected':'' }}>Philippines</option>
                                    <option value="PL" {{ $selectedCountry=='PL'?'selected':'' }}>Poland</option>
                                    <option value="PT" {{ $selectedCountry=='PT'?'selected':'' }}>Portugal</option>
                                    <option value="QA" {{ $selectedCountry=='QA'?'selected':'' }}>Qatar</option>
                                    <option value="RO" {{ $selectedCountry=='RO'?'selected':'' }}>Romania</option>
                                    <option value="RU" {{ $selectedCountry=='RU'?'selected':'' }}>Russia</option>
                                    <option value="RW" {{ $selectedCountry=='RW'?'selected':'' }}>Rwanda</option>
                                    <option value="KN" {{ $selectedCountry=='KN'?'selected':'' }}>Saint Kitts and Nevis</option>
                                    <option value="LC" {{ $selectedCountry=='LC'?'selected':'' }}>Saint Lucia</option>
                                    <option value="VC" {{ $selectedCountry=='VC'?'selected':'' }}>Saint Vincent and the Grenadines</option>
                                    <option value="WS" {{ $selectedCountry=='WS'?'selected':'' }}>Samoa</option>
                                    <option value="SM" {{ $selectedCountry=='SM'?'selected':'' }}>San Marino</option>
                                    <option value="ST" {{ $selectedCountry=='ST'?'selected':'' }}>Sao Tome and Principe</option>
                                    <option value="SA" {{ $selectedCountry=='SA'?'selected':'' }}>Saudi Arabia</option>
                                    <option value="SN" {{ $selectedCountry=='SN'?'selected':'' }}>Senegal</option>
                                    <option value="RS" {{ $selectedCountry=='RS'?'selected':'' }}>Serbia</option>
                                    <option value="SC" {{ $selectedCountry=='SC'?'selected':'' }}>Seychelles</option>
                                    <option value="SL" {{ $selectedCountry=='SL'?'selected':'' }}>Sierra Leone</option>
                                    <option value="SG" {{ $selectedCountry=='SG'?'selected':'' }}>Singapore</option>
                                    <option value="SK" {{ $selectedCountry=='SK'?'selected':'' }}>Slovakia</option>
                                    <option value="SI" {{ $selectedCountry=='SI'?'selected':'' }}>Slovenia</option>
                                    <option value="SB" {{ $selectedCountry=='SB'?'selected':'' }}>Solomon Islands</option>
                                    <option value="SO" {{ $selectedCountry=='SO'?'selected':'' }}>Somalia</option>
                                    <option value="ZA" {{ $selectedCountry=='ZA'?'selected':'' }}>South Africa</option>
                                    <option value="SS" {{ $selectedCountry=='SS'?'selected':'' }}>South Sudan</option>
                                    <option value="ES" {{ $selectedCountry=='ES'?'selected':'' }}>Spain</option>
                                    <option value="LK" {{ $selectedCountry=='LK'?'selected':'' }}>Sri Lanka</option>
                                    <option value="SD" {{ $selectedCountry=='SD'?'selected':'' }}>Sudan</option>
                                    <option value="SR" {{ $selectedCountry=='SR'?'selected':'' }}>Suriname</option>
                                    <option value="SE" {{ $selectedCountry=='SE'?'selected':'' }}>Sweden</option>
                                    <option value="CH" {{ $selectedCountry=='CH'?'selected':'' }}>Switzerland</option>
                                    <option value="SY" {{ $selectedCountry=='SY'?'selected':'' }}>Syria</option>
                                    <option value="TW" {{ $selectedCountry=='TW'?'selected':'' }}>Taiwan</option>
                                    <option value="TJ" {{ $selectedCountry=='TJ'?'selected':'' }}>Tajikistan</option>
                                    <option value="TZ" {{ $selectedCountry=='TZ'?'selected':'' }}>Tanzania</option>
                                    <option value="TH" {{ $selectedCountry=='TH'?'selected':'' }}>Thailand</option>
                                    <option value="TL" {{ $selectedCountry=='TL'?'selected':'' }}>Timor-Leste</option>
                                    <option value="TG" {{ $selectedCountry=='TG'?'selected':'' }}>Togo</option>
                                    <option value="TO" {{ $selectedCountry=='TO'?'selected':'' }}>Tonga</option>
                                    <option value="TT" {{ $selectedCountry=='TT'?'selected':'' }}>Trinidad and Tobago</option>
                                    <option value="TN" {{ $selectedCountry=='TN'?'selected':'' }}>Tunisia</option>
                                    <option value="TR" {{ $selectedCountry=='TR'?'selected':'' }}>Turkey</option>
                                    <option value="TM" {{ $selectedCountry=='TM'?'selected':'' }}>Turkmenistan</option>
                                    <option value="TV" {{ $selectedCountry=='TV'?'selected':'' }}>Tuvalu</option>
                                    <option value="UG" {{ $selectedCountry=='UG'?'selected':'' }}>Uganda</option>
                                    <option value="UA" {{ $selectedCountry=='UA'?'selected':'' }}>Ukraine</option>
                                    <option value="AE" {{ $selectedCountry=='AE'?'selected':'' }}>United Arab Emirates</option>
                                    <option value="GB" {{ $selectedCountry=='GB'?'selected':'' }}>United Kingdom</option>
                                    <option value="US" {{ $selectedCountry=='US'?'selected':'' }}>United States</option>
                                    <option value="UY" {{ $selectedCountry=='UY'?'selected':'' }}>Uruguay</option>
                                    <option value="UZ" {{ $selectedCountry=='UZ'?'selected':'' }}>Uzbekistan</option>
                                    <option value="VU" {{ $selectedCountry=='VU'?'selected':'' }}>Vanuatu</option>
                                    <option value="VE" {{ $selectedCountry=='VE'?'selected':'' }}>Venezuela</option>
                                    <option value="VN" {{ $selectedCountry=='VN'?'selected':'' }}>Vietnam</option>
                                    <option value="YE" {{ $selectedCountry=='YE'?'selected':'' }}>Yemen</option>
                                    <option value="ZM" {{ $selectedCountry=='ZM'?'selected':'' }}>Zambia</option>
                                    <option value="ZW" {{ $selectedCountry=='ZW'?'selected':'' }}>Zimbabwe</option>
                                </select>
                                @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="profile-field">
                                <label>Username</label>
                                <input type="text" name="username" class="profile-input @error('username') is-invalid @enderror"
                                    value="{{ old('username', $user->username) }}">
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" class="btn-dash-primary">
                            <i class="bi bi-arrow-repeat me-1"></i> SAVE CHANGES
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Withdrawal Settings --}}
        <div class="profile-panel {{ $activeTab === 'wallets' ? '' : 'd-none' }}" id="tab-wallets">
            <div class="p-4">
                <form method="POST" action="{{ route('dashboard.profile.wallets') }}">
                    @csrf
                    <div class="row g-4">
                        @foreach($methods as $method)
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label>{{ $method->name }}</label>
                                <input type="text"
                                    name="wallet_{{ $method->id }}"
                                    class="profile-input"
                                    placeholder="Enter {{ $method->name }} Address"
                                    value="{{ old('wallet_' . $method->id, $wallets[$method->id] ?? '') }}">
                                <small class="text-muted">Enter your {{ $method->name }} Address that will be used to withdraw your funds</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="profile-actions">
                        <button type="submit" class="btn-dash-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Password / Security --}}
        <div class="profile-panel {{ $activeTab === 'password' ? '' : 'd-none' }}" id="tab-password">
            <div class="p-4">
                <form method="POST" action="{{ route('dashboard.profile.password') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label>Old Password</label>
                                <input type="password" name="current_password"
                                    class="profile-input @error('current_password') is-invalid @enderror">
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label>New Password</label>
                                <input type="password" name="password"
                                    class="profile-input @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label>Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="profile-input">
                            </div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" class="btn-dash-primary">UPDATE PASSWORD</button>
                    </div>
                </form>

                <div class="password-requirements">
                    <strong>Password requirements:</strong>
                    <ul>
                        <li>Minimum 8 characters long - the more, the better</li>
                        <li>At least one lowercase character</li>
                        <li>At least one uppercase character</li>
                        <li>At least one number, symbol.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Other Settings --}}
        <div class="profile-panel {{ $activeTab === 'settings' ? '' : 'd-none' }}" id="tab-settings">
            <div class="p-4">
                <form method="POST" action="{{ route('dashboard.profile.settings') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label class="d-block mb-2">Send confirmation OTP to my email when withdrawing my funds.</label>
                                <div class="profile-radio-group">
                                    <label class="profile-radio">
                                        <input type="radio" name="notify_withdrawal_otp" value="1"
                                            {{ old('notify_withdrawal_otp', $user->notify_withdrawal_otp) ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>
                                    <label class="profile-radio">
                                        <input type="radio" name="notify_withdrawal_otp" value="0"
                                            {{ !old('notify_withdrawal_otp', $user->notify_withdrawal_otp) ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label class="d-block mb-2">Send me email when i get profit.</label>
                                <div class="profile-radio-group">
                                    <label class="profile-radio">
                                        <input type="radio" name="notify_profit_email" value="1"
                                            {{ old('notify_profit_email', $user->notify_profit_email) ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>
                                    <label class="profile-radio">
                                        <input type="radio" name="notify_profit_email" value="0"
                                            {{ !old('notify_profit_email', $user->notify_profit_email) ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-field">
                                <label class="d-block mb-2">Send me email when my investment plan expires.</label>
                                <div class="profile-radio-group">
                                    <label class="profile-radio">
                                        <input type="radio" name="notify_plan_expiry_email" value="1"
                                            {{ old('notify_plan_expiry_email', $user->notify_plan_expiry_email) ? 'checked' : '' }}>
                                        <span>Yes</span>
                                    </label>
                                    <label class="profile-radio">
                                        <input type="radio" name="notify_plan_expiry_email" value="0"
                                            {{ !old('notify_plan_expiry_email', $user->notify_plan_expiry_email) ? 'checked' : '' }}>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" class="btn-dash-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.profile-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.profile-panel').forEach(p => p.classList.add('d-none'));
        this.classList.add('active');
        document.getElementById('tab-' + this.dataset.tab).classList.remove('d-none');
    });
});
</script>
@endpush
@endsection
