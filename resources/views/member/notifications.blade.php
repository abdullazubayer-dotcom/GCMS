<x-layouts.app title="My Notifications - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">My Notifications</h1>
        <p class="text-muted mb-0">Only notifications sent to your account are shown here.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Channel</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                            <tr>
                                <td>{{ ucfirst($notification->channel) }}</td>
                                <td>{{ $notification->subject ?? 'N/A' }}</td>
                                <td>{{ $notification->message ?? 'N/A' }}</td>
                                <td>{{ ucfirst($notification->status) }}</td>
                                <td>{{ $notification->sent_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No notifications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
