<?php

namespace App\Http\Resources;

use App\Http\Resources\TrackingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RejectedDeliveryResource extends JsonResource
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
            'sales_id' => $this->sales_id,
            'driver_id' => $this->driver_id,
            'delivery_fee' => $this->delivery_fee,
            'status' => "rejected",
            'picked_at' => $this->created_at,
            'delivered_at' => $this->created_at,
            'driver' => new DriverResource($this->driver),
        ];
    }
}
