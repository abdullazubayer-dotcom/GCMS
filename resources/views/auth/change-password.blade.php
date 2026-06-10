<x-layouts.auth title="Change Password - GCMS">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h1 class="h4 mb-1">Change Password</h1>
            <p class="text-muted mb-4">You must change your temporary password before continuing.</p>

            <form method="POST" action="{{ route('password.change.update') }}">
                @csrf

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input
                        type="password"
                        class="form-control @error('current_password') is-invalid @enderror"
                        id="current_password"
                        name="current_password"
                        autocomplete="current-password"
                        required
                    >
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100">Change Password</button>
            </form>
        </div>
    </div>
</x-layouts.auth>
