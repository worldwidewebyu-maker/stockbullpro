@csrf

<div class="row g-4">
    <div class="col-md-6">
        <div class="profile-field">
            <label>Plan Name <span style="color:var(--dash-pink);">*</span></label>
            <input type="text" name="name"
                class="profile-input @error('name') is-invalid @enderror"
                value="{{ old('name', $plan->name) }}" placeholder="e.g. Starter Plan" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="profile-field">
            <label>ROI (%) <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="roi_percentage" step="any" min="0"
                class="profile-input @error('roi_percentage') is-invalid @enderror"
                value="{{ old('roi_percentage', $plan->roi_percentage) }}" required>
            @error('roi_percentage')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="profile-field">
            <label>ROI Period <span style="color:var(--dash-pink);">*</span></label>
            <select name="roi_period" class="profile-input @error('roi_period') is-invalid @enderror">
                @foreach(['Daily', 'Weekly', 'Monthly'] as $period)
                    <option value="{{ $period }}" {{ old('roi_period', $plan->roi_period) === $period ? 'selected' : '' }}>{{ $period }}</option>
                @endforeach
            </select>
            @error('roi_period')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Duration (Days) <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="duration_days" min="1"
                class="profile-input @error('duration_days') is-invalid @enderror"
                value="{{ old('duration_days', $plan->duration_days) }}" required>
            @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Min Amount ($) <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="min_amount" step="any" min="0"
                class="profile-input @error('min_amount') is-invalid @enderror"
                value="{{ old('min_amount', $plan->min_amount) }}" required>
            @error('min_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Max Amount ($) <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="max_amount" step="any" min="0"
                class="profile-input @error('max_amount') is-invalid @enderror"
                value="{{ old('max_amount', $plan->max_amount) }}" required>
            @error('max_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Charge Type <span style="color:var(--dash-pink);">*</span></label>
            <select name="charge_type" class="profile-input @error('charge_type') is-invalid @enderror">
                <option value="percentage" {{ old('charge_type', $plan->charge_type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                <option value="fixed" {{ old('charge_type', $plan->charge_type) === 'fixed' ? 'selected' : '' }}>Fixed ($)</option>
            </select>
            @error('charge_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Charge Amount <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="charge_amount" step="any" min="0"
                class="profile-input @error('charge_amount') is-invalid @enderror"
                value="{{ old('charge_amount', $plan->charge_amount) }}" required>
            @error('charge_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Sort Order <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="sort_order" min="0"
                class="profile-input @error('sort_order') is-invalid @enderror"
                value="{{ old('sort_order', $plan->sort_order) }}" required>
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label class="d-block mb-2">Status</label>
            <label class="profile-radio">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                <span>Active</span>
            </label>
        </div>
    </div>
</div>

<div class="profile-actions">
    <button type="submit" class="btn-dash-primary">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.investment-plans.index') }}" class="btn-dash-outline ms-2">Cancel</a>
</div>
