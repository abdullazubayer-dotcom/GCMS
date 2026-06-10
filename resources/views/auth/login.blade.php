<x-layouts.auth title="Login - GCMS">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h1 class="h4 mb-1">General Club Management System</h1>
            <p class="text-muted mb-4">Login with your official Login ID.</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="login_id" class="form-label">Login ID</label>
                    <input
                        type="text"
                        class="form-control @error('login_id') is-invalid @enderror"
                        id="login_id"
                        name="login_id"
                        value="{{ old('login_id') }}"
                        autocomplete="username"
                        autofocus
                        required
                    >
                    @error('login_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</x-layouts.auth>
