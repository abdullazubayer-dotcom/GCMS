<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'member_code' => $this->member_code,
            'user' => new UserResource($this->whenLoaded('user')),
            'joining_date' => $this->joining_date?->toDateString(),
            'membership_type' => $this->membership_type,
            'membership_status' => $this->membership_status,
            'date_of_birth' => $this->date_of_birth?->toDateString(),
            'gender' => $this->gender,
            'blood_group' => $this->blood_group,
            'occupation' => $this->occupation,
            'organization' => $this->organization,
            'address' => $this->address,
            'permanent_address' => $this->permanent_address,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'photo_path' => $this->photo_path,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
