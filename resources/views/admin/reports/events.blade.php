<x-layouts.app title="Event Report - GCMS">
    @include('admin.reports.partials.print-style')

    <div class="d-flex justify-content-between align-items-start mb-4 no-print">
        <div>
            <h1 class="h3 mb-1">Event Report</h1>
            <p class="text-muted mb-0">Filter events by status and event date.</p>
        </div>
        <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4 no-print">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All</option>
                        @foreach (['draft', 'published', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="from_date">From</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $filters['from_date'] ?? '' }}">
                </div>
                <div class="col-md-3">
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
            <h2 class="h5 mb-3">Event Report</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Venue</th>
                            <th>Fee</th>
                            <th>Capacity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->event_date->format('M d, Y') }}</td>
                                <td>
                                    {{ $event->start_time ? \Illuminate\Support\Carbon::parse($event->start_time)->format('h:i A') : 'N/A' }}
                                    @if ($event->end_time)
                                        - {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('h:i A') }}
                                    @endif
                                </td>
                                <td>{{ $event->venue ?? 'N/A' }}</td>
                                <td>BDT {{ number_format($event->event_fee, 2) }}</td>
                                <td>{{ $event->capacity ?? 'N/A' }}</td>
                                <td>{{ ucfirst($event->status) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted">No records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
