<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'username' => $this->username,
            'approval_status' => $this->approval_status,
            'driver_licence' => $this->driver_licence,
            'car_reg_details' => $this->car_reg_details,
            'acceptance_rating' => $this->acceptance_rating,
            'bank_details' => $this->bank_details,
            'hourly_delivery_rate' => $this->hourly_delivery_rate,
            'current_location' => $this->current_location,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
