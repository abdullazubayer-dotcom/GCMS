<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'payment_no' => $this->payment_no,
            'member' => new MemberResource($this->whenLoaded('member')),
            'event' => new EventResource($this->whenLoaded('event')),
            'payment_type' => $this->payment_type,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date?->toDateString(),
            'payment_method' => $this->payment_method,
            'transaction_reference' => $this->transaction_reference,
            'payment_status' => $this->payment_status,
            'remarks' => $this->remarks,
            'received_by' => new UserResource($this->whenLoaded('receiver')),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
