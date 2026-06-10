<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole(['super_admin', 'admin']) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'event_id' => ['nullable', 'exists:events,id'],
            'payment_type' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', Rule::in(['cash', 'bank', 'mobile_banking', 'card', 'other'])],
            'transaction_reference' => ['nullable', 'string', 'max:150'],
            'payment_status' => ['required', Rule::in(['due', 'partial', 'paid', 'waived', 'cancelled'])],
            'remarks' => ['nullable', 'string'],
            'received_by' => ['required', 'exists:users,id'],
        ];
    }
}
