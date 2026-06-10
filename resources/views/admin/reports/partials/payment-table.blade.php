<div class="card border-0 shadow-sm print-area">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="h5 mb-0">{{ $title }}</h2>
            <strong>Total: BDT {{ number_format($totalAmount, 2) }}</strong>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead>
                    <tr>
                        <th>Payment No</th>
                        <th>Member</th>
                        <th>Event</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_no }}</td>
                            <td>{{ $payment->member?->member_code }} - {{ $payment->member?->user?->name }}</td>
                            <td>{{ $payment->event?->title ?? 'N/A' }}</td>
                            <td>{{ $payment->payment_type }}</td>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ ucfirst($payment->payment_status) }}</td>
                            <td class="text-end">BDT {{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
