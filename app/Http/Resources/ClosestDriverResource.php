<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClosestDriverResource extends JsonResource
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
            'approval_status' => $this->approval_status,
            'available' => $this->available,
            'driver_licence' => [
                'number' => $this->driver_licence['number'],
                'expiry_date' => $this->driver_licence['expiry_date'],
                'country' => $this->driver_licence['country'],
                'front' => $this->driver_licence['front'] ? config('app.url') . '/' . $this->driver_licence['front'] : null,
                'back' => $this->driver_licence['back'] ? config('app.url') . '/' . $this->driver_licence['back'] : null,
            ],
            'car_reg_details' => [
                'image' => $this->car_reg_details['image'] ? config('app.url') . '/' . $this->car_reg_details['image'] : null,
                'model' => $this->car_reg_details['model'],
                'model_type' => $this->car_reg_details['model_type'],
                'year' => $this->car_reg_details['year'],
                'color' => $this->car_reg_details['color'],
                'registration_number' => $this->car_reg_details['registration_number'],
                'date_of_registration' => $this->car_reg_details['date_of_registration'],
                'front' => $this->car_reg_details['front'] ? config('app.url') . '/' . $this->car_reg_details['front'] : null,
                'back' => $this->car_reg_details['back'] ? config('app.url') . '/' . $this->car_reg_details['back'] : null,
            ],
            'acceptance_rating' => $this->acceptance_rating,
            'bank_details' => $this->bank_details,
            'hourly_delivery_rate' => $this->hourly_delivery_rate,
            'current_location' => $this->current_location,
            'distance' => $this->distance ? round($this->distance, 2) : null,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
