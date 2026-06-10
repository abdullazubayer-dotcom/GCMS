<x-layouts.app title="Create Member - GCMS">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Create Member</h1>
            <p class="text-muted mb-0">Create the member login account and profile manually.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.members.store') }}" class="card border-0 shadow-sm">
        @csrf

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="member_id" class="form-label">Member ID</label>
                    <input type="text" class="form-control @error('member_id') is-invalid @enderror" id="member_id" name="member_id" value="{{ old('member_id') }}" required>
                    @error('member_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="date_of_birth" class="form-label">DOB</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="">Select gender</option>
                        <option value="male" @selected(old('gender') === 'male')>Male</option>
                        <option value="female" @selected(old('gender') === 'female')>Female</option>
                        <option value="other" @selected(old('gender') === 'other')>Other</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="profession" class="form-label">Profession</label>
                    <input type="text" class="form-control @error('profession') is-invalid @enderror" id="profession" name="profession" value="{{ old('profession') }}">
                    @error('profession')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="organization" class="form-label">Organization</label>
                    <input type="text" class="form-control @error('organization') is-invalid @enderror" id="organization" name="organization" value="{{ old('organization') }}">
                    @error('organization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="blood_group" class="form-label">Blood Group</label>
                    <input type="text" class="form-control @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" value="{{ old('blood_group') }}">
                    @error('blood_group')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="membership_type" class="form-label">Membership Type</label>
                    <select class="form-select @error('membership_type') is-invalid @enderror" id="membership_type" name="membership_type" required>
                        <option value="general" @selected(old('membership_type', 'general') === 'general')>General</option>
                        <option value="lifetime" @selected(old('membership_type') === 'lifetime')>Lifetime</option>
                        <option value="associate" @selected(old('membership_type') === 'associate')>Associate</option>
                        <option value="honorary" @selected(old('membership_type') === 'honorary')>Honorary</option>
                    </select>
                    @error('membership_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="joining_date" class="form-label">Joining Date</label>
                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="{{ old('joining_date', now()->toDateString()) }}" required>
                    @error('joining_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        <option value="suspended" @selected(old('status') === 'suspended')>Suspended</option>
                        <option value="cancelled" @selected(old('status') === 'cancelled')>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                    <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}">
                    @error('emergency_contact_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                    <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}">
                    @error('emergency_contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="temporary_password" class="form-label">Temporary Password</label>
                    <input type="password" class="form-control @error('temporary_password') is-invalid @enderror" id="temporary_password" name="temporary_password" required>
                    @error('temporary_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create Member</button>
        </div>
    </form>
</x-layouts.app>
