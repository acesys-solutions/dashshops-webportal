<?php

namespace App\Http\Resources;

use App\Http\Resources\TrackingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleOrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'user_id' => $this->user_id,
            'is_store_pickup' => $this->is_store_pickup,
            'driver_id' => $this->driver_id,
            'status' => $this->status,
            'service_charge' => $this->service_charge,
            'total_discount' => $this->total_discount,
            'total_cost' => $this->total_cost,
            'delivery_fee' => $this->delivery_fee,
            'proposed_route' => $this->proposed_route ?? null
        ];
    }
}
