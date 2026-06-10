<x-layouts.app title="Send Notification - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">Send Notification</h1>
        <p class="text-muted mb-0">Choose email or SMS. SMS is currently a placeholder and is written to the log.</p>
    </div>

    <form method="POST" action="{{ route('admin.notifications.store') }}" class="card border-0 shadow-sm">
        @csrf

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="channel">Channel</label>
                    <select class="form-select @error('channel') is-invalid @enderror" id="channel" name="channel" required>
                        <option value="email" @selected(old('channel', 'email') === 'email')>Email</option>
                        <option value="sms" @selected(old('channel') === 'sms')>SMS placeholder</option>
                    </select>
                    @error('channel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label" for="user_id">User</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                        <option value="">No user, use custom recipient</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                {{ $user->login_id }} - {{ $user->name }} ({{ $user->email ?? 'no email' }} / {{ $user->phone ?? 'no phone' }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="recipient">Custom Recipient</label>
                    <input type="text" class="form-control @error('recipient') is-invalid @enderror" id="recipient" name="recipient" value="{{ old('recipient') }}" placeholder="Email address or phone number">
                    @error('recipient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="subject">Subject</label>
                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}">
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label" for="message">Message</label>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Send and Log</button>
        </div>
    </form>
</x-layouts.app>
