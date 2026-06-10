<x-layouts.app title="My Payments - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">My Payment History</h1>
        <p class="text-muted mb-0">Only your own payment records are shown here.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Payment No</th>
                            <th>Payment Type</th>
                            <th>Event</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_no }}</td>
                                <td>{{ $payment->payment_type }}</td>
                                <td>{{ $payment->event?->title ?? 'N/A' }}</td>
                                <td>BDT {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td>{{ ucfirst($payment->payment_status) }}</td>
                                <td>{{ $payment->payment_date?->format('M d, Y') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No payment records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
