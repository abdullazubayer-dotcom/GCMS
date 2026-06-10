<x-layouts.app title="Payments - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Payments</h1>
            <p class="text-muted mb-0">Record and manage member payments.</p>
        </div>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary align-self-md-start">Record Payment</a>
    </div>

    <form method="GET" action="{{ route('admin.payments.index') }}" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-7">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Payment no, member ID, name, email, phone, type">
                </div>
                <div class="col-md-3">
                    <label for="payment_status" class="form-label">Status</label>
                    <select class="form-select" id="payment_status" name="payment_status">
                        <option value="">All statuses</option>
                        @foreach (['due', 'partial', 'paid', 'waived', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['payment_status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Payment No</th>
                            <th>Member</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_no }}</td>
                                <td>
                                    {{ $payment->member?->member_code ?? 'N/A' }}
                                    <div class="small text-muted">{{ $payment->member?->user?->name ?? 'N/A' }}</div>
                                </td>
                                <td>{{ $payment->payment_type }}</td>
                                <td>BDT {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $payment->payment_status === 'paid' ? 'success' : ($payment->payment_status === 'due' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No payments found.</td>
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
