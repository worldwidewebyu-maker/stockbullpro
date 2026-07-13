@extends('layouts.admin')
@section('title', 'Settings')
@section('breadcrumb', 'Settings')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">General Settings</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Configure platform behaviour, support links, and referral limits.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-12">
                    <h6 class="fw-bold text-uppercase text-muted" style="font-size:.75rem; letter-spacing:.05em;">Authentication</h6>
                </div>

                <div class="col-md-6">
                    <div class="profile-field">
                        <label class="profile-radio d-flex align-items-start gap-2">
                            <input type="checkbox" name="email_verification_enabled" value="1"
                                {{ old('email_verification_enabled', $settings['email_verification_enabled']) ? 'checked' : '' }}>
                            <span>
                                <strong>Require email verification</strong><br>
                                <small class="text-muted">When off, new users are logged in immediately after registration.</small>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                    <h6 class="fw-bold text-uppercase text-muted" style="font-size:.75rem; letter-spacing:.05em;">Support</h6>
                </div>

                <div class="col-md-6">
                    <div class="profile-field">
                        <label>WhatsApp Support Number</label>
                        <input type="text" name="whatsapp_number"
                            class="profile-input @error('whatsapp_number') is-invalid @enderror"
                            value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"
                            placeholder="+1 (332) 283-0661">
                        <small class="text-muted">Used in the dashboard support widget and the floating WhatsApp button on the homepage.</small>
                        @error('whatsapp_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="profile-field">
                        <label>Telegram Support Username</label>
                        <input type="text" name="telegram_username"
                            class="profile-input @error('telegram_username') is-invalid @enderror"
                            value="{{ old('telegram_username', $settings['telegram_username']) }}"
                            placeholder="@finstockbullcomsupport">
                        <small class="text-muted">Used in the dashboard support widget and the floating Telegram button on the homepage.</small>
                        @error('telegram_username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="profile-field">
                        <label>Support Email <span style="color:var(--dash-pink);">*</span></label>
                        <input type="email" name="support_email"
                            class="profile-input @error('support_email') is-invalid @enderror"
                            value="{{ old('support_email', $settings['support_email']) }}" required>
                        @error('support_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-12">
                    <hr>
                    <h6 class="fw-bold text-uppercase text-muted" style="font-size:.75rem; letter-spacing:.05em;">Referrals</h6>
                </div>

                <div class="col-md-6">
                    <div class="profile-field">
                        <label>Max referral bonuses per referred user <span style="color:var(--dash-pink);">*</span></label>
                        <input type="number" name="referral_max_deposits" min="0" max="100"
                            class="profile-input @error('referral_max_deposits') is-invalid @enderror"
                            value="{{ old('referral_max_deposits', $settings['referral_max_deposits']) }}" required>
                        <small class="text-muted">How many approved deposits from one referred user can earn the referrer a bonus. Set 0 for unlimited.</small>
                        @error('referral_max_deposits')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="profile-actions mt-4">
                <button type="submit" class="btn-dash-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
