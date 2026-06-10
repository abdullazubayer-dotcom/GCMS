<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
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
            'member_id' => [
                'required',
                'string',
                'max:50',
                'unique:users,login_id',
                'unique:members,member_code',
            ],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'profession' => ['nullable', 'string', 'max:150'],
            'organization' => ['nullable', 'string', 'max:150'],
            'membership_type' => ['required', Rule::in(['general', 'lifetime', 'associate', 'honorary'])],
            'joining_date' => ['required', 'date'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'emergency_contact_name' => ['nullable', 'string', 'max:150'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended', 'cancelled'])],
            'temporary_password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'member_id' => 'Member ID',
            'date_of_birth' => 'DOB',
            'temporary_password' => 'temporary password',
        ];
    }
}
