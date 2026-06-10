<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificationRequest extends FormRequest
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
            'channel' => ['required', Rule::in(['email', 'sms'])],
            'user_id' => ['nullable', 'exists:users,id'],
            'recipient' => ['nullable', 'string', 'max:150', 'required_without:user_id'],
            'subject' => ['nullable', 'string', 'max:255', 'required_if:channel,email'],
            'message' => ['required', 'string'],
        ];
    }
}
