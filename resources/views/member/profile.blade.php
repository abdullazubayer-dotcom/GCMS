<x-layouts.app title="My Profile - GCMS">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">My Profile</h1>
            <p class="text-muted mb-0">Your own club membership information.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>Member ID:</strong><br>{{ $user->login_id }}</div>
                <div class="col-md-4"><strong>Name:</strong><br>{{ $user->name }}</div>
                <div class="col-md-4"><strong>Email:</strong><br>{{ $user->email }}</div>
                <div class="col-md-4"><strong>Phone:</strong><br>{{ $user->phone ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Status:</strong><br>{{ ucfirst($user->member?->membership_status ?? $user->status) }}</div>
                <div class="col-md-4"><strong>Membership Type:</strong><br>{{ ucfirst($user->member?->membership_type ?? 'N/A') }}</div>
                <div class="col-md-4"><strong>Joining Date:</strong><br>{{ $user->member?->joining_date?->format('M d, Y') ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>DOB:</strong><br>{{ $user->member?->date_of_birth?->format('M d, Y') ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Gender:</strong><br>{{ $user->member?->gender ? ucfirst($user->member->gender) : 'N/A' }}</div>
                <div class="col-md-4"><strong>Profession:</strong><br>{{ $user->member?->occupation ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Organization:</strong><br>{{ $user->member?->organization ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Blood Group:</strong><br>{{ $user->member?->blood_group ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Emergency Contact:</strong><br>{{ $user->member?->emergency_contact_name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Emergency Phone:</strong><br>{{ $user->member?->emergency_contact_phone ?? 'N/A' }}</div>
                <div class="col-12"><strong>Address:</strong><br>{{ $user->member?->address ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</x-layouts.app>
