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
            <label>Processing Duration <span style="color:var(--dash-pink);">*</span></label>
            <input type="text" name="duration"
                class="profile-input @error('duration') is-invalid @enderror"
                value="{{ old('duration', $method->duration) }}" placeholder="e.g. Instant Payment, 1-3 hours" required>
            @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
</div>

<div class="profile-actions">
    <button type="submit" class="btn-dash-primary">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.withdrawal-methods.index') }}" class="btn-dash-outline ms-2">Cancel</a>
</div>
