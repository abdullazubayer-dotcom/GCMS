<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'channel' => $this->channel,
            'recipient' => $this->recipient,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => $this->status,
            'sent_at' => $this->sent_at?->toISOString(),
            'error_message' => $this->error_message,
            'meta' => $this->meta,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
