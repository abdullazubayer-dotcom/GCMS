<x-layouts.app title="Member Report - GCMS">
    @include('admin.reports.partials.print-style')

    <div class="d-flex justify-content-between align-items-start mb-4 no-print">
        <div>
            <h1 class="h3 mb-1">Member Report</h1>
            <p class="text-muted mb-0">Filter members by status, type, and joining date.</p>
        </div>
        <button type="button" class="btn btn-outline-primary" onclick="window.print()">Print</button>
    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4 no-print">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All</option>
                        @foreach (['active', 'inactive', 'suspended', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="membership_type">Membership Type</label>
                    <select class="form-select" id="membership_type" name="membership_type">
                        <option value="">All</option>
                        @foreach (['general', 'lifetime', 'associate', 'honorary'] as $type)
                            <option value="{{ $type }}" @selected(($filters['membership_type'] ?? '') === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="from_date">Joining From</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" value="{{ $filters['from_date'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="to_date">Joining To</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" value="{{ $filters['to_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.reports.members') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm print-area">
        <div class="card-body">
            <h2 class="h5 mb-3">Member Report</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Joining Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td>{{ $member->member_code }}</td>
                                <td>{{ $member->user?->name ?? 'N/A' }}</td>
                                <td>{{ $member->user?->email ?? 'N/A' }}</td>
                                <td>{{ $member->user?->phone ?? 'N/A' }}</td>
                                <td>{{ ucfirst($member->membership_type) }}</td>
                                <td>{{ ucfirst($member->membership_status) }}</td>
                                <td>{{ $member->joining_date?->format('M d, Y') ?? 'N/A' }}</td>
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
