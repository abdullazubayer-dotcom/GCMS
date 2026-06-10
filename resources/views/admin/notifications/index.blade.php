<x-layouts.app title="Notifications - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Notifications</h1>
            <p class="text-muted mb-0">Email/SMS attempts are logged as pending, sent, or failed.</p>
        </div>
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary align-self-md-start">Send Notification</a>
    </div>

    <form method="GET" action="{{ route('admin.notifications.index') }}" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="channel">Channel</label>
                    <select class="form-select" id="channel" name="channel">
                        <option value="">All channels</option>
                        @foreach (['email', 'sms'] as $channel)
                            <option value="{{ $channel }}" @selected(($filters['channel'] ?? '') === $channel)>{{ strtoupper($channel) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All statuses</option>
                        @foreach (['pending', 'sent', 'failed'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
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
                            <th>Channel</th>
                            <th>Recipient</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Sent At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notification)
                            <tr>
                                <td>{{ strtoupper($notification->channel) }}</td>
                                <td>
                                    {{ $notification->recipient ?? 'N/A' }}
                                    @if ($notification->user)
                                        <div class="small text-muted">{{ $notification->user->name }}</div>
                                    @endif
                                </td>
                                <td>{{ $notification->subject ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $notification->status === 'sent' ? 'success' : ($notification->status === 'failed' ? 'danger' : 'secondary') }}">
                                        {{ ucfirst($notification->status) }}
                                    </span>
                                </td>
                                <td>{{ $notification->sent_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.notifications.show', $notification) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No notification logs found.</td>
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
