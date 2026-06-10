<x-layouts.app title="Payment Report - GCMS">
    @include('admin.reports.partials.print-style')

    <div class="d-flex justify-content-between align-items-start mb-4 no-print">
        <div>
            <h1 class="h3 mb-1">Payment Report</h1>
            <p class="text-muted mb-0">Filter payments by member, event, status, method, and date.</p>
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
                    <label class="form-label" for="payment_method">Method</label>
                    <select class="form-select" id="payment_method" name="payment_method">
                        <option value="">All</option>
                        @foreach (['cash', 'bank', 'mobile_banking', 'card', 'other'] as $method)
                            <option value="{{ $method }}" @selected(($filters['payment_method'] ?? '') === $method)>{{ ucfirst(str_replace('_', ' ', $method)) }}</option>
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
                    <a href="{{ route('admin.reports.payments') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    @include('admin.reports.partials.payment-table', ['title' => 'Payment Report', 'payments' => $payments, 'totalAmount' => $totalAmount])
</x-layouts.app>
