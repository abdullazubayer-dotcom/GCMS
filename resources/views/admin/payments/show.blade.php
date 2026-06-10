<x-layouts.app title="Payment Details - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $payment->payment_no }}</h1>
            <p class="text-muted mb-0">{{ $payment->member?->member_code }} - {{ $payment->member?->user?->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-primary">Edit</a>
            <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('Delete this payment?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Member ID:</strong><br>{{ $payment->member?->member_code ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Member Name:</strong><br>{{ $payment->member?->user?->name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Event:</strong><br>{{ $payment->event?->title ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Payment Type:</strong><br>{{ $payment->payment_type }}</div>
                <div class="col-md-4"><strong>Amount:</strong><br>BDT {{ number_format($payment->amount, 2) }}</div>
                <div class="col-md-4"><strong>Payment Date:</strong><br>{{ $payment->payment_date->format('M d, Y') }}</div>
                <div class="col-md-4"><strong>Method:</strong><br>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                <div class="col-md-4"><strong>Status:</strong><br>{{ ucfirst($payment->payment_status) }}</div>
                <div class="col-md-4"><strong>Reference:</strong><br>{{ $payment->transaction_reference ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Received By:</strong><br>{{ $payment->receiver?->name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Updated By:</strong><br>{{ $payment->updater?->name ?? 'N/A' }}</div>
                <div class="col-12"><strong>Remarks:</strong><br>{{ $payment->remarks ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</x-layouts.app>
