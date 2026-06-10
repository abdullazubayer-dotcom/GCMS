@php
    $authArtType = request()->routeIs('password.*') ? 'password' : 'login';
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GCMS Login' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background:
                linear-gradient(90deg, rgba(15, 23, 42, .9), rgba(15, 118, 110, .62)),
                url("{{ asset('images/futuristic-club-art.png') }}") center / cover no-repeat;
        }

        .auth-panel {
            background: rgba(255, 255, 255, .94);
            border-radius: 8px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .28);
        }

        .auth-art-note {
            color: rgba(255, 255, 255, .82);
        }

        .auth-art-card {
            max-width: 420px;
            margin-top: 28px;
        }

        .page-art-svg {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <main class="min-vh-100 d-flex align-items-center py-5">
        <div class="container">
            <div class="row align-items-center justify-content-center g-4">
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="auth-art-note">
                        <span class="badge text-bg-light mb-3">Secure club portal</span>
                        <h1 class="display-5 fw-bold">Modern access for official members.</h1>
                        <p class="lead mb-0">Login with Member ID, manage club work, and keep every activity connected.</p>
                        <div class="auth-art-card">
                            <x-page-art :type="$authArtType" />
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-10 col-md-7 col-lg-5">
                    <div class="auth-panel">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
