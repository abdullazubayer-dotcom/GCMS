<x-layouts.app title="Edit Payment - GCMS">
    <div class="mb-4">
        <h1 class="h3 mb-1">Edit Payment</h1>
        <p class="text-muted mb-0">{{ $payment->payment_no }}</p>
    </div>

    <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="card border-0 shadow-sm">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Payment No</label>
                    <input type="text" class="form-control" value="{{ $payment->payment_no }}" disabled>
                </div>

                <div class="col-md-6">
                    <label for="member_id" class="form-label">Member ID</label>
                    <select class="form-select @error('member_id') is-invalid @enderror" id="member_id" name="member_id" required>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" @selected(old('member_id', $payment->member_id) == $member->id)>
                                {{ $member->member_code }} - {{ $member->user?->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="event_id" class="form-label">Event</label>
                    <select class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id">
                        <option value="">No event</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" @selected(old('event_id', $payment->event_id) == $event->id)>
                                {{ $event->title }} - {{ $event->event_date->format('M d, Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label for="payment_type" class="form-label">Payment Type</label>
                    <input type="text" class="form-control @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type" value="{{ old('payment_type', $payment->payment_type) }}" required>
                    @error('payment_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d')) }}" required>
                    @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="received_by" class="form-label">Received By</label>
                    <select class="form-select @error('received_by') is-invalid @enderror" id="received_by" name="received_by" required>
                        @foreach ($receivers as $receiver)
                            <option value="{{ $receiver->id }}" @selected(old('received_by', $payment->received_by) == $receiver->id)>{{ $receiver->name }}</option>
                        @endforeach
                    </select>
                    @error('received_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                        @foreach (['cash', 'bank', 'mobile_banking', 'card', 'other'] as $method)
                            <option value="{{ $method }}" @selected(old('payment_method', $payment->payment_method) === $method)>{{ ucfirst(str_replace('_', ' ', $method)) }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                        @foreach (['due', 'partial', 'paid', 'waived', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('payment_status', $payment->payment_status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('payment_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label for="transaction_reference" class="form-label">Transaction Reference</label>
                    <input type="text" class="form-control @error('transaction_reference') is-invalid @enderror" id="transaction_reference" name="transaction_reference" value="{{ old('transaction_reference', $payment->transaction_reference) }}">
                    @error('transaction_reference')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="3">{{ old('remarks', $payment->remarks) }}</textarea>
                    @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Payment</button>
        </div>
    </form>
</x-layouts.app>
