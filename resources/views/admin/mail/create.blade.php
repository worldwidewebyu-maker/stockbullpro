@extends('layouts.admin')
@section('title', 'Send Email')
@section('breadcrumb', 'Send Email')

@section('content')
<div class="mb-4">
    <h4 class="dash-page-title">Send Email</h4>
    <p class="text-muted mb-0" style="font-size:.875rem">Send a general message to all users or selected users.</p>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.mail.send') }}" id="mailForm">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="profile-field">
                        <label>Subject <span style="color:var(--dash-pink);">*</span></label>
                        <input type="text" name="subject"
                            class="profile-input @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}" required>
                        @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="profile-field">
                        <label>Message <span style="color:var(--dash-pink);">*</span></label>
                        <textarea name="message" rows="8"
                            class="profile-input @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="profile-field">
                        <label class="d-block mb-2">Recipients <span style="color:var(--dash-pink);">*</span></label>
                        <div class="d-flex flex-wrap gap-3">
                            <label class="profile-radio">
                                <input type="radio" name="recipient_type" value="all"
                                    {{ old('recipient_type', 'all') === 'all' ? 'checked' : '' }}>
                                <span>All users ({{ $users->count() }})</span>
                            </label>
                            <label class="profile-radio">
                                <input type="radio" name="recipient_type" value="selected"
                                    {{ old('recipient_type') === 'selected' ? 'checked' : '' }}>
                                <span>Selected users</span>
                            </label>
                        </div>
                        @error('recipient_type')<div class="text-danger" style="font-size:.8rem;">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="col-12" id="userPicker" style="display:none;">
                    <div class="profile-field">
                        <label>Select users</label>
                        <input type="text" id="userSearch" class="profile-input mb-2" placeholder="Search by name, username, or email…">
                        <div style="max-height:280px; overflow-y:auto; border:1px solid #e9ecef; border-radius:.5rem; padding:.75rem;">
                            @foreach($users as $user)
                            <label class="d-flex align-items-center gap-2 py-1 user-row" style="font-size:.85rem; cursor:pointer;"
                                data-search="{{ strtolower($user->username . ' ' . $user->full_name . ' ' . $user->email) }}">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                    {{ in_array($user->id, old('user_ids', [])) ? 'checked' : '' }}>
                                <span>
                                    <strong>{{ $user->username }}</strong>
                                    <span class="text-muted">— {{ $user->full_name }} ({{ $user->email }})</span>
                                </span>
                            </label>
                            @endforeach
                        </div>
                        @error('user_ids')<div class="text-danger" style="font-size:.8rem;">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="profile-actions mt-4">
                <button type="submit" class="btn-dash-primary"
                    onclick="return confirm('Send this email to the selected recipients?');">
                    <i class="bi bi-send me-1"></i> Send Email
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const radios = document.querySelectorAll('input[name="recipient_type"]');
    const picker = document.getElementById('userPicker');
    const search = document.getElementById('userSearch');

    function togglePicker() {
        const selected = document.querySelector('input[name="recipient_type"]:checked')?.value;
        picker.style.display = selected === 'selected' ? 'block' : 'none';
    }

    radios.forEach(r => r.addEventListener('change', togglePicker));
    togglePicker();

    search?.addEventListener('input', () => {
        const q = search.value.toLowerCase().trim();
        document.querySelectorAll('.user-row').forEach(row => {
            row.style.display = !q || row.dataset.search.includes(q) ? 'flex' : 'none';
        });
    });
</script>
@endpush
