<x-layouts.app title="Edit Event - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">Edit Event</h1>
        <p class="text-muted mb-0">{{ $event->title }}</p>
    </div>

    <form method="POST" action="{{ route('admin.events.update', $event) }}" class="card border-0 shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $event->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $event->slug) }}">
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" required>
                    @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time ? substr($event->start_time, 0, 5) : '') }}">
                    @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time ? substr($event->end_time, 0, 5) : '') }}">
                    @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="venue" class="form-label">Venue</label>
                    <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue" name="venue" value="{{ old('venue', $event->venue) }}">
                    @error('venue')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label for="event_fee" class="form-label">Event Fee</label>
                    <input type="number" step="0.01" min="0" class="form-control @error('event_fee') is-invalid @enderror" id="event_fee" name="event_fee" value="{{ old('event_fee', $event->event_fee) }}" required>
                    @error('event_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" min="1" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}">
                    @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        @foreach (['draft', 'published', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $event->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </div>
    </form>
</x-layouts.app>
