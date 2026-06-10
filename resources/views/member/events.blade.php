<x-layouts.app title="Published Events - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">Published Events</h1>
        <p class="text-muted mb-0">Club events available to members.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Venue</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>
                                    <strong>{{ $event->title }}</strong>
                                    @if ($event->description)
                                        <div class="small text-muted">{{ $event->description }}</div>
                                    @endif
                                </td>
                                <td>{{ $event->venue ?? 'N/A' }}</td>
                                <td>{{ $event->event_date->format('M d, Y') }}</td>
                                <td>
                                    {{ $event->start_time ? \Illuminate\Support\Carbon::parse($event->start_time)->format('h:i A') : 'N/A' }}
                                    @if ($event->end_time)
                                        - {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('h:i A') }}
                                    @endif
                                </td>
                                <td>৳{{ number_format($event->event_fee, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No published events found.</td>
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
