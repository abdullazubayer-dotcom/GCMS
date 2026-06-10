<x-layouts.app title="Member-wise Payment Report - GCMS">
    @include('admin.reports.partials.print-style')

    <div class="d-flex justify-content-between align-items-start mb-4 no-print">
        <div>
            <h1 class="h3 mb-1">Member-wise Payment Report</h1>
            <p class="text-muted mb-0">Payments grouped by member.</p>
        </div>
        <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4 no-print">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="member_id">Member</label>
                    <select class="form-select" id="member_id" name="member_id">
                        <option value="">All</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" @selected(($filters['member_id'] ?? '') == $member->id)>{{ $member->member_code }} - {{ $member->user?->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="event_id">Event</label>
                    <select class="form-select" id="event_id" name="event_id">
                        <option value="">All</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" @selected(($filters['event_id'] ?? '') == $event->id)>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="payment_status">Status</label>
                    <select class="form-select" id="payment_status" name="payment_status">
                        <option value="">All</option>
                        @foreach (['due', 'partial', 'paid', 'waived', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['payment_status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="from_date">From</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $filters['from_date'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="to_date">To</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" value="{{ $filters['to_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.reports.member-wise-payments') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm print-area">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="h5 mb-0">Member-wise Payment Report</h2>
                <strong>Total: BDT {{ number_format($totalAmount, 2) }}</strong>
            </div>

            @forelse ($paymentGroups as $payments)
                @php
                    $member = $payments->first()->member;
                @endphp
                <div class="mb-4">
                    <h3 class="h6 mb-2">
                        {{ $member?->member_code ?? 'N/A' }} - {{ $member?->user?->name ?? 'N/A' }}
                        <span class="text-muted">| Total: BDT {{ number_format($payments->sum('amount'), 2) }}</span>
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Payment No</th>
                                    <th>Event</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_no }}</td>
                                        <td>{{ $payment->event?->title ?? 'N/A' }}</td>
                                        <td>{{ $payment->payment_type }}</td>
                                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                        <td>{{ ucfirst($payment->payment_status) }}</td>
                                        <td class="text-end">BDT {{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted mb-0">No records found.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
