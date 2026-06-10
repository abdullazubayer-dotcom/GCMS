<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
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
        /** @var Event $event */
        $event = $this->route('event');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($event->id)],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after_or_equal:start_time'],
            'venue' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_fee' => ['required', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['draft', 'published', 'completed', 'cancelled'])],
        ];
    }
}
