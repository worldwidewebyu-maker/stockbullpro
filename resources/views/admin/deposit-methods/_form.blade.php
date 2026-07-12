@csrf

<div class="row g-4">
    <div class="col-md-6">
        <div class="profile-field">
            <label>Name <span style="color:var(--dash-pink);">*</span></label>
            <input type="text" name="name"
                class="profile-input @error('name') is-invalid @enderror"
                value="{{ old('name', $method->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="profile-field">
            <label>Network Type</label>
            <input type="text" name="network_type"
                class="profile-input @error('network_type') is-invalid @enderror"
                value="{{ old('network_type', $method->network_type) }}" placeholder="e.g. TRC20, ERC20">
            @error('network_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-12">
        <div class="profile-field">
            <label>Wallet Address</label>
            <input type="text" name="wallet_address"
                class="profile-input @error('wallet_address') is-invalid @enderror"
                value="{{ old('wallet_address', $method->wallet_address) }}" placeholder="Deposit wallet address">
            @error('wallet_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Min Amount ($) <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="min_amount" step="any" min="0"
                class="profile-input @error('min_amount') is-invalid @enderror"
                value="{{ old('min_amount', $method->min_amount) }}" required>
            @error('min_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Max Amount ($) <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="max_amount" step="any" min="0"
                class="profile-input @error('max_amount') is-invalid @enderror"
                value="{{ old('max_amount', $method->max_amount) }}" required>
            @error('max_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Sort Order <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="sort_order" min="0"
                class="profile-input @error('sort_order') is-invalid @enderror"
                value="{{ old('sort_order', $method->sort_order) }}" required>
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Charge Type <span style="color:var(--dash-pink);">*</span></label>
            <select name="charge_type" class="profile-input @error('charge_type') is-invalid @enderror">
                <option value="percentage" {{ old('charge_type', $method->charge_type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                <option value="fixed" {{ old('charge_type', $method->charge_type) === 'fixed' ? 'selected' : '' }}>Fixed ($)</option>
            </select>
            @error('charge_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Charge Amount <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="charge_amount" step="any" min="0"
                class="profile-input @error('charge_amount') is-invalid @enderror"
                value="{{ old('charge_amount', $method->charge_amount) }}" required>
            @error('charge_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label class="d-block mb-2">Status</label>
            <label class="profile-radio">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $method->is_active) ? 'checked' : '' }}>
                <span>Active</span>
            </label>
        </div>
    </div>

    <div class="col-12">
        <div class="profile-field">
            <label>QR Code Image</label>
            @if($method->qr_code_url)
                <div class="mb-2 d-flex align-items-center gap-3">
                    <img src="{{ $method->qr_code_url }}" alt="QR" style="width:80px;height:80px;object-fit:cover;border:1px solid #e9ecef;border-radius:.5rem;padding:4px;">
                    <label class="profile-radio">
                        <input type="checkbox" name="remove_qr" value="1">
                        <span>Remove current QR code</span>
                    </label>
                </div>
            @endif
            <input type="file" name="qr_code" accept="image/jpeg,image/png,image/webp"
                class="profile-input @error('qr_code') is-invalid @enderror">
            <small class="text-muted">JPG, PNG or WEBP. Max 2MB.</small>
            @error('qr_code')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
    </div>
</div>

<div class="profile-actions">
    <button type="submit" class="btn-dash-primary">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.deposit-methods.index') }}" class="btn-dash-outline ms-2">Cancel</a>
</div>
