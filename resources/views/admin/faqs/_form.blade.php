@csrf

<div class="row g-4">
    <div class="col-12">
        <div class="profile-field">
            <label>Question <span style="color:var(--dash-pink);">*</span></label>
            <input type="text" name="question"
                class="profile-input @error('question') is-invalid @enderror"
                value="{{ old('question', $faq->question) }}" required>
            @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-12">
        <div class="profile-field">
            <label>Answer <span style="color:var(--dash-pink);">*</span></label>
            <textarea name="answer" rows="5"
                class="profile-input @error('answer') is-invalid @enderror" required>{{ old('answer', $faq->answer) }}</textarea>
            @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label>Sort Order <span style="color:var(--dash-pink);">*</span></label>
            <input type="number" name="sort_order" min="0"
                class="profile-input @error('sort_order') is-invalid @enderror"
                value="{{ old('sort_order', $faq->sort_order) }}" required>
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="profile-field">
            <label class="d-block mb-2">Status</label>
            <label class="profile-radio">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                <span>Visible on home page</span>
            </label>
        </div>
    </div>
</div>

<div class="profile-actions">
    <button type="submit" class="btn-dash-primary">{{ $submitLabel ?? 'Save' }}</button>
    <a href="{{ route('admin.faqs.index') }}" class="btn-dash-outline ms-2">Cancel</a>
</div>
