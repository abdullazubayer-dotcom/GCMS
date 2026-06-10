<x-layouts.app title="Edit Member - GCMS">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Member</h1>
            <p class="text-muted mb-0">{{ $member->member_code }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.members.update', $member) }}" class="card border-0 shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="member_id" class="form-label">Member ID</label>
                    <input type="text" class="form-control @error('member_id') is-invalid @enderror" id="member_id" name="member_id" value="{{ old('member_id', $member->member_code) }}" required>
                    @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $member->user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $member->user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $member->user->phone) }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="date_of_birth" class="form-label">DOB</label>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $member->date_of_birth?->format('Y-m-d')) }}">
                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="">Select gender</option>
                        @foreach (['male', 'female', 'other'] as $gender)
                            <option value="{{ $gender }}" @selected(old('gender', $member->gender) === $gender)>{{ ucfirst($gender) }}</option>
                        @endforeach
                    </select>
                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="profession" class="form-label">Profession</label>
                    <input type="text" class="form-control @error('profession') is-invalid @enderror" id="profession" name="profession" value="{{ old('profession', $member->occupation) }}">
                    @error('profession')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="organization" class="form-label">Organization</label>
                    <input type="text" class="form-control @error('organization') is-invalid @enderror" id="organization" name="organization" value="{{ old('organization', $member->organization) }}">
                    @error('organization')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="blood_group" class="form-label">Blood Group</label>
                    <input type="text" class="form-control @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group" value="{{ old('blood_group', $member->blood_group) }}">
                    @error('blood_group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="membership_type" class="form-label">Membership Type</label>
                    <select class="form-select @error('membership_type') is-invalid @enderror" id="membership_type" name="membership_type" required>
                        @foreach (['general', 'lifetime', 'associate', 'honorary'] as $type)
                            <option value="{{ $type }}" @selected(old('membership_type', $member->membership_type) === $type)>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                    @error('membership_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="joining_date" class="form-label">Joining Date</label>
                    <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="{{ old('joining_date', $member->joining_date?->format('Y-m-d')) }}" required>
                    @error('joining_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        @foreach (['active', 'inactive', 'suspended', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $member->membership_status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                    <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $member->emergency_contact_name) }}">
                    @error('emergency_contact_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                    <input type="text" class="form-control @error('emergency_contact_phone') is-invalid @enderror" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $member->emergency_contact_phone) }}">
                    @error('emergency_contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $member->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="{{ route('admin.members.show', $member) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Member</button>
        </div>
    </form>
</x-layouts.app>
