<x-layouts.app title="Member Dashboard - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Member Dashboard</h1>
            <p class="text-muted mb-0">Welcome, {{ $user->name }}.</p>
        </div>
        <a href="{{ route('password.change') }}" class="btn btn-outline-primary align-self-md-start">Change Password</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('member.events') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body">
                <div class="card-body">
                    <p class="text-muted mb-1">Published Upcoming Events</p>
                    <h2 class="h3 mb-0">{{ number_format($upcomingEventsCount) }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('member.payments') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body">
                <div class="card-body">
                    <p class="text-muted mb-1">Payment Records</p>
                    <h2 class="h3 mb-0">{{ number_format($paymentsCount) }}</h2>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('member.notifications') }}" class="card border-0 shadow-sm h-100 text-decoration-none text-body">
                <div class="card-body">
                    <p class="text-muted mb-1">Notifications</p>
                    <h2 class="h3 mb-0">{{ number_format($notificationsCount) }}</h2>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h2 class="h5 mb-0">My Profile</h2>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Login ID:</strong> {{ $user->login_id }}</p>
                    <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="mb-2"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                    <a href="{{ route('member.profile') }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h2 class="h5 mb-0">Recent Payments</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Payment No</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_no }}</td>
                                        <td>{{ $payment->payment_type }}</td>
                                        <td>BDT {{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst($payment->payment_status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
