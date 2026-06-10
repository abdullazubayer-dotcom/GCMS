<x-layouts.app title="Notification Log - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Notification Log</h1>
            <p class="text-muted mb-0">{{ strtoupper($notification->channel) }} attempt #{{ $notification->id }}</p>
        </div>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary align-self-md-start">Back</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Channel:</strong><br>{{ strtoupper($notification->channel) }}</div>
                <div class="col-md-4"><strong>Status:</strong><br>{{ ucfirst($notification->status) }}</div>
                <div class="col-md-4"><strong>Sent At:</strong><br>{{ $notification->sent_at?->format('M d, Y h:i A') ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>User:</strong><br>{{ $notification->user?->name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Recipient:</strong><br>{{ $notification->recipient ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Subject:</strong><br>{{ $notification->subject ?? 'N/A' }}</div>
                <div class="col-12"><strong>Message:</strong><br>{{ $notification->message ?? 'N/A' }}</div>
                <div class="col-12"><strong>Error:</strong><br>{{ $notification->error_message ?? 'N/A' }}</div>
                <div class="col-12">
                    <strong>Meta:</strong>
                    <pre class="bg-light border rounded p-3 mt-2 mb-0">{{ json_encode($notification->meta, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
