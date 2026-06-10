<x-layouts.app title="Members - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">Members</h1>
            <p class="text-muted mb-0">Search, filter, view, and manage club members.</p>
        </div>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary align-self-md-start">Create Member</a>
    </div>

    <form method="GET" action="{{ route('admin.members.index') }}" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Member ID, name, email, phone">
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All statuses</option>
                        @foreach (['active', 'inactive', 'suspended', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="membership_type" class="form-label">Membership Type</label>
                    <select class="form-select" id="membership_type" name="membership_type">
                        <option value="">All types</option>
                        @foreach (['general', 'lifetime', 'associate', 'honorary'] as $type)
                            <option value="{{ $type }}" @selected(($filters['membership_type'] ?? '') === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-flex align-items-end">
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
                            <th>Member ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
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
                                <td>
                                    <span class="badge text-bg-{{ $member->membership_status === 'active' ? 'success' : ($member->membership_status === 'suspended' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($member->membership_status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
