<x-layouts.app title="Date-wise Collection Report - GCMS">
    @include('admin.reports.partials.print-style')

    <div class="d-flex justify-content-between align-items-start mb-4 no-print">
        <div>
            <h1 class="h3 mb-1">Date-wise Collection Report</h1>
            <p class="text-muted mb-0">Shows paid payment collection grouped by payment date.</p>
        </div>
        <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4 no-print">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label" for="from_date">From</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $filters['from_date'] ?? '' }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="to_date">To</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" value="{{ $filters['to_date'] ?? '' }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm print-area">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="h5 mb-0">Date-wise Collection Report</h2>
                <strong>Total: BDT {{ number_format($totalAmount, 2) }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Payment Date</th>
                            <th class="text-end">Total Payments</th>
                            <th class="text-end">Total Collection</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($collections as $collection)
                            <tr>
                                <td>{{ \Illuminate\Support\Carbon::parse($collection->payment_date)->format('M d, Y') }}</td>
                                <td class="text-end">{{ number_format($collection->total_payments) }}</td>
                                <td class="text-end">BDT {{ number_format($collection->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
