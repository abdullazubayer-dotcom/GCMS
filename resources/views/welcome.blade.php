<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>General Club Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --gcms-ink: #18212f;
            --gcms-green: #0f766e;
            --gcms-red: #b42318;
            --gcms-gold: #b7791f;
        }

        body {
            color: var(--gcms-ink);
            background: #f7f8fb;
        }

        .site-nav {
            background: rgba(255, 255, 255, .94);
            backdrop-filter: blur(10px);
        }

        .hero {
            min-height: calc(100vh - 96px);
            background:
                linear-gradient(90deg, rgba(10, 18, 32, .86) 0%, rgba(10, 18, 32, .62) 42%, rgba(10, 18, 32, .12) 100%),
                url("{{ asset('images/club-activities-hero.png') }}") center / cover no-repeat;
            display: flex;
            align-items: center;
        }

        .hero-copy {
            max-width: 720px;
            color: #fff;
            padding-block: 72px;
        }

        .hero-copy h1 {
            font-size: clamp(2.25rem, 5vw, 4.8rem);
            line-height: 1.02;
            letter-spacing: 0;
        }

        .section-title {
            max-width: 720px;
        }

        .feature-card,
        .activity-card,
        .info-panel,
        .future-panel {
            border: 0;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(24, 33, 47, .08);
        }

        .activity-card img {
            height: 230px;
            object-fit: cover;
        }

        .activity-card:nth-child(2) img {
            object-position: 65% center;
        }

        .activity-card:nth-child(3) img {
            object-position: right center;
        }

        .badge-soft {
            background: rgba(15, 118, 110, .1);
            color: var(--gcms-green);
        }

        .map-frame {
            width: 100%;
            min-height: 330px;
            border: 0;
            border-radius: 8px;
        }

        .future-panel {
            overflow: hidden;
            background: #fff;
        }

        .future-panel img {
            width: 100%;
            height: 100%;
            min-height: 360px;
            object-fit: cover;
        }

        @media (max-width: 767.98px) {
            .hero {
                min-height: 680px;
                background:
                    linear-gradient(180deg, rgba(10, 18, 32, .88) 0%, rgba(10, 18, 32, .58) 68%, rgba(10, 18, 32, .2) 100%),
                    url("{{ asset('images/club-activities-hero.png') }}") center / cover no-repeat;
            }

            .hero-copy {
                padding-block: 56px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg site-nav sticky-top border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">GCMS Club</a>
            <div class="d-flex gap-2">
                @auth
                    @if (auth()->user()->must_change_password)
                        <a href="{{ route('password.change') }}" class="btn btn-outline-primary">Change Password</a>
                    @elseif (auth()->user()->hasRole(['super_admin', 'admin']))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                    @elseif (auth()->user()->hasRole('member'))
                        <a href="{{ route('member.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Member Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <div class="hero-copy">
                <span class="badge rounded-pill text-bg-light mb-3">Community, events, membership, service</span>
                <h1 class="fw-bold mb-4">General Club Management System</h1>
                <p class="lead mb-4">
                    A friendly digital home for club members, events, payments, notices, and daily club activities.
                    Members are created by club authority and can log in with their official Member ID.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">Login to Portal</a>
                    <a href="#location" class="btn btn-light btn-lg px-4">Find Our Club</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="py-5 bg-white">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="section-title mb-4">
                            <span class="badge badge-soft mb-2">About the club</span>
                            <h2 class="h1 fw-bold">A place for members to connect, organize, and grow together.</h2>
                            <p class="text-muted mb-0">
                                Our club supports social programs, member meetings, events, sports, cultural activities,
                                and community initiatives through organized club authority and active member participation.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="future-panel">
                            <img src="{{ asset('images/futuristic-club-art.png') }}" alt="Futuristic club management artwork">
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <h3 class="h5">Member Services</h3>
                                <p class="text-muted mb-0">Manage member profiles, contact details, status, and official Member ID access.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <h3 class="h5">Events & Activities</h3>
                                <p class="text-muted mb-0">Publish events, share schedules, and keep members informed about club programs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card feature-card h-100">
                            <div class="card-body">
                                <h3 class="h5">Payments & Reports</h3>
                                <p class="text-muted mb-0">Track payment records, dues, collections, and printable administrative reports.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                    <div>
                        <span class="badge badge-soft mb-2">Activities</span>
                        <h2 class="h1 fw-bold mb-0">Club life in action</h2>
                    </div>
                    <p class="text-muted mb-0 section-title">
                        Meetings, programs, volunteer work, and member gatherings are part of everyday club life.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card activity-card overflow-hidden h-100">
                            <img src="{{ asset('images/club-activities-hero.png') }}" class="card-img-top" alt="Club members at a meeting">
                            <div class="card-body">
                                <h3 class="h5">Member Meetings</h3>
                                <p class="text-muted mb-0">Regular discussions and planning sessions for club development.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card overflow-hidden h-100">
                            <img src="{{ asset('images/club-activities-hero.png') }}" class="card-img-top" alt="Club event activities">
                            <div class="card-body">
                                <h3 class="h5">Events</h3>
                                <p class="text-muted mb-0">Published events help members stay connected with upcoming programs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card activity-card overflow-hidden h-100">
                            <img src="{{ asset('images/club-activities-hero.png') }}" class="card-img-top" alt="Community activity at the club">
                            <div class="card-body">
                                <h3 class="h5">Community Work</h3>
                                <p class="text-muted mb-0">Members can support social, cultural, and service activities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="location" class="py-5 bg-white">
            <div class="container">
                <div class="row g-4 align-items-stretch">
                    <div class="col-lg-5">
                        <div class="card info-panel h-100">
                            <div class="card-body p-4">
                                <span class="badge badge-soft mb-2">Visit us</span>
                                <h2 class="h1 fw-bold mb-3">Club Address</h2>
                                <p class="mb-2"><strong>General Club Office</strong></p>
                                <p class="text-muted mb-4">
                                    Club House, Main Road<br>
                                    Dhaka, Bangladesh
                                </p>
                                <p class="text-muted">
                                    Office hours, phone number, and exact address can be updated later with your real club information.
                                </p>
                                <a href="https://www.google.com/maps/search/?api=1&query=Club%20House%2C%20Dhaka%2C%20Bangladesh" target="_blank" class="btn btn-outline-primary">
                                    Open in Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <iframe
                            class="map-frame shadow-sm"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=Club%20House%2C%20Dhaka%2C%20Bangladesh&output=embed">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2 text-muted">
            <span>&copy; {{ date('Y') }} General Club Management System</span>
            <span>No public signup. Members are created by club authority.</span>
        </div>
    </footer>
</body>
</html>
