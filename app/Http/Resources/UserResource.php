<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'login_id' => $this->login_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'role' => $this->whenLoaded('role', fn () => $this->role?->name),
            'must_change_password' => (bool) $this->must_change_password,
            'last_login_at' => $this->last_login_at?->toISOString(),
        ];
    }
}
