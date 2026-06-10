<x-layouts.app title="Member Details - GCMS">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $member->user->name }}</h1>
            <p class="text-muted mb-0">{{ $member->member_code }}</p>
        </div>
        <div>
            <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary">Back</a>
            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Email:</strong><br>{{ $member->user->email }}</div>
                <div class="col-md-4"><strong>Phone:</strong><br>{{ $member->user->phone ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Status:</strong><br>{{ ucfirst($member->membership_status) }}</div>
                <div class="col-md-4"><strong>Membership Type:</strong><br>{{ ucfirst($member->membership_type) }}</div>
                <div class="col-md-4"><strong>Joining Date:</strong><br>{{ $member->joining_date?->format('M d, Y') ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>DOB:</strong><br>{{ $member->date_of_birth?->format('M d, Y') ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Gender:</strong><br>{{ $member->gender ? ucfirst($member->gender) : 'N/A' }}</div>
                <div class="col-md-4"><strong>Profession:</strong><br>{{ $member->occupation ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Organization:</strong><br>{{ $member->organization ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Blood Group:</strong><br>{{ $member->blood_group ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Emergency Contact:</strong><br>{{ $member->emergency_contact_name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Emergency Phone:</strong><br>{{ $member->emergency_contact_phone ?? 'N/A' }}</div>
                <div class="col-12"><strong>Address:</strong><br>{{ $member->address ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</x-layouts.app>
