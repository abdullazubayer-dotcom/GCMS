<x-layouts.app title="Events - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Events</h1>
            <p class="text-muted mb-0">Create and manage club events.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary align-self-md-start">Create Event</a>
    </div>

    <form method="GET" action="{{ route('admin.events.index') }}" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Title, slug, venue">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All statuses</option>
                        @foreach (['draft', 'published', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
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
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Venue</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>
                                    <strong>{{ $event->title }}</strong>
                                    <div class="small text-muted">{{ $event->slug }}</div>
                                </td>
                                <td>{{ $event->event_date->format('M d, Y') }}</td>
                                <td>
                                    {{ $event->start_time ? \Illuminate\Support\Carbon::parse($event->start_time)->format('h:i A') : 'N/A' }}
                                    @if ($event->end_time)
                                        - {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('h:i A') }}
                                    @endif
                                </td>
                                <td>{{ $event->venue ?? 'N/A' }}</td>
                                <td>৳{{ number_format($event->event_fee, 2) }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No events found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
