<x-layouts.app title="Admin Dashboard - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Admin Dashboard</h1>
            <p class="mb-0 text-muted">Welcome, {{ auth()->user()->name }}.</p>
        </div>
        <div class="text-muted small">
            {{ now()->format('F d, Y') }}
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Members</p>
                    <h2 class="h3 mb-0">{{ number_format($totalMembers) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Active Members</p>
                    <h2 class="h3 mb-0 text-success">{{ number_format($activeMembers) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Inactive Members</p>
                    <h2 class="h3 mb-0 text-secondary">{{ number_format($inactiveMembers) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Events</p>
                    <h2 class="h3 mb-0">{{ number_format($totalEvents) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Upcoming Events</p>
                    <h2 class="h3 mb-0 text-primary">{{ number_format($upcomingEvents) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Collection</p>
                    <h2 class="h3 mb-0">BDT {{ number_format($totalPaymentCollection, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Due Payments</p>
                    <h2 class="h3 mb-0 text-danger">BDT {{ number_format($duePayments, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h2 class="h5 mb-0">Recent Members</h2>
                </div>
                <div class="card-body pt-2">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Member Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentMembers as $member)
                                    <tr>
                                        <td>{{ $member->member_code }}</td>
                                        <td>{{ $member->user?->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $member->membership_status === 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($member->membership_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $member->joining_date?->format('M d, Y') ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No members found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-3">
                    <h2 class="h5 mb-0">Recent Payments</h2>
                </div>
                <div class="card-body pt-2">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Payment No</th>
                                    <th>Member</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_no }}</td>
                                        <td>{{ $payment->member?->user?->name ?? 'N/A' }}</td>
                                        <td>BDT {{ number_format($payment->amount, 2) }}</td>
                                        <td>
                                            @php
                                                $paymentBadge = match ($payment->payment_status) {
                                                    'paid' => 'success',
                                                    'partial' => 'warning',
                                                    'due' => 'danger',
                                                    'waived' => 'info',
                                                    default => 'secondary',
                                                };
                                            @endphp
                                            <span class="badge text-bg-{{ $paymentBadge }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
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
