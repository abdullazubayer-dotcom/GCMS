@php
    $routeName = request()->route()?->getName();
    $pageArtType = match (true) {
        $routeName === 'admin.dashboard' => 'dashboard',
        $routeName === 'admin.members.index' => 'members',
        $routeName === 'admin.members.create' => 'member-form',
        $routeName === 'admin.members.show' => 'member-detail',
        $routeName === 'admin.members.edit' => 'member-form',
        str_starts_with((string) $routeName, 'admin.events.create'),
        str_starts_with((string) $routeName, 'admin.events.edit') => 'event-form',
        str_starts_with((string) $routeName, 'admin.events') => 'events',
        str_starts_with((string) $routeName, 'admin.payments.create'),
        str_starts_with((string) $routeName, 'admin.payments.edit') => 'payment-form',
        str_starts_with((string) $routeName, 'admin.payments') => 'payments',
        str_starts_with((string) $routeName, 'admin.notifications') => 'notifications',
        str_starts_with((string) $routeName, 'admin.reports') => 'reports',
        $routeName === 'member.dashboard' => 'member-dashboard',
        $routeName === 'member.profile' => 'profile',
        $routeName === 'member.events' => 'member-events',
        $routeName === 'member.payments' => 'member-payments',
        $routeName === 'member.notifications' => 'member-notifications',
        default => 'dashboard',
    };
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GCMS' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --gcms-ink: #172033;
            --gcms-teal: #0f766e;
            --gcms-gold: #b7791f;
        }

        body {
            color: var(--gcms-ink);
            background:
                linear-gradient(180deg, rgba(15, 118, 110, .08), transparent 280px),
                #f6f8fb;
        }

        .navbar {
            backdrop-filter: blur(10px);
        }

        .nav-art {
            min-height: 160px;
            background: linear-gradient(90deg, #111827, #0f766e);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .nav-art .container {
            min-height: 160px;
            position: relative;
            z-index: 1;
        }

        .nav-art h1 {
            letter-spacing: 0;
        }

        .card {
            border-radius: 8px;
        }

        .art-chip {
            background: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .28);
            color: #fff;
        }

        .page-art-wrap {
            position: absolute;
            right: clamp(16px, 6vw, 92px);
            top: 18px;
            width: min(34vw, 360px);
            opacity: .96;
        }

        .page-art-svg {
            width: 100%;
            height: auto;
        }

        @media (max-width: 991.98px) {
            .navbar .container {
                align-items: flex-start;
                gap: 12px;
            }

            .navbar .d-flex.gap-3 {
                flex-wrap: wrap;
                margin-left: 0 !important;
            }

            .page-art-wrap {
                opacity: .32;
                right: -64px;
                width: 320px;
            }
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="#">GCMS</a>
            @auth
                @if (auth()->user()->hasRole(['super_admin', 'admin']))
                    <div class="d-flex gap-3 ms-4 me-auto">
                        <a class="text-decoration-none" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a class="text-decoration-none" href="{{ route('admin.members.index') }}">Members</a>
                        <a class="text-decoration-none" href="{{ route('admin.members.create') }}">Create Member</a>
                        <a class="text-decoration-none" href="{{ route('admin.events.index') }}">Events</a>
                        <a class="text-decoration-none" href="{{ route('admin.payments.index') }}">Payments</a>
                        <a class="text-decoration-none" href="{{ route('admin.notifications.index') }}">Notifications</a>
                        <a class="text-decoration-none" href="{{ route('admin.reports.index') }}">Reports</a>
                    </div>
                @elseif (auth()->user()->hasRole('member'))
                    <div class="d-flex gap-3 ms-4 me-auto">
                        <a class="text-decoration-none" href="{{ route('member.dashboard') }}">Dashboard</a>
                        <a class="text-decoration-none" href="{{ route('member.profile') }}">Profile</a>
                        <a class="text-decoration-none" href="{{ route('member.events') }}">Events</a>
                        <a class="text-decoration-none" href="{{ route('member.payments') }}">Payments</a>
                        <a class="text-decoration-none" href="{{ route('member.notifications') }}">Notifications</a>
                    </div>
                @endif
            @endauth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <section class="nav-art">
        <div class="page-art-wrap" aria-hidden="true">
            <x-page-art :type="$pageArtType" />
        </div>
        <div class="container d-flex align-items-center">
            <div>
                <span class="badge art-chip mb-2">Futuristic club operations</span>
                <h1 class="h2 fw-bold mb-2">{{ $title ?? 'General Club Management System' }}</h1>
                <p class="mb-0 opacity-75">Members, events, payments, notifications, and reports in one organized portal.</p>
            </div>
        </div>
    </section>

    <main class="container py-4">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
