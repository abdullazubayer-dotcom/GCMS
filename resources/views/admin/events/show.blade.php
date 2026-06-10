<x-layouts.app title="Event Details - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $event->title }}</h1>
            <p class="text-muted mb-0">{{ $event->slug }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">Edit</a>
            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Date:</strong><br>{{ $event->event_date->format('M d, Y') }}</div>
                <div class="col-md-4">
                    <strong>Time:</strong><br>
                    {{ $event->start_time ? \Illuminate\Support\Carbon::parse($event->start_time)->format('h:i A') : 'N/A' }}
                    @if ($event->end_time)
                        - {{ \Illuminate\Support\Carbon::parse($event->end_time)->format('h:i A') }}
                    @endif
                </div>
                <div class="col-md-4"><strong>Status:</strong><br>{{ ucfirst($event->status) }}</div>
                <div class="col-md-4"><strong>Venue:</strong><br>{{ $event->venue ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Event Fee:</strong><br>৳{{ number_format($event->event_fee, 2) }}</div>
                <div class="col-md-4"><strong>Capacity:</strong><br>{{ $event->capacity ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Created By:</strong><br>{{ $event->creator?->name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Updated By:</strong><br>{{ $event->updater?->name ?? 'N/A' }}</div>
                <div class="col-12"><strong>Description:</strong><br>{{ $event->description ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</x-layouts.app>
