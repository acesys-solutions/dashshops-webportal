<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'approval_status' => $this->approval_status,
            'available' => $this->available,
            'driver_licence' => $this->driver_licence ? [
                'number' => $this->driver_licence['number'] ?? null,
                'expiry_date' => $this->driver_licence['expiry_date'] ?? null,
                'country' => $this->driver_licence['country'] ?? null,
                'front' => $this->driver_licence['front'] ? config('app.url') . '/' . $this->driver_licence['front'] : null,
                'back' => $this->driver_licence['back'] ? config('app.url') . '/' . $this->driver_licence['back'] : null,
            ] : null,
            'car_reg_details' => $this->car_reg_details ? [
                'image' => $this->car_reg_details['image'] ? config('app.url') . '/' . $this->car_reg_details['image'] : null,
                'model' => $this->car_reg_details['model'] ?? null,
                'model_type' => $this->car_reg_details['model_type'] ?? null,
                'year' => $this->car_reg_details['year'] ?? null,
                'color' => $this->car_reg_details['color'] ?? null,
                'registration_number' => $this->car_reg_details['registration_number'] ?? null,
                'date_of_registration' => $this->car_reg_details['date_of_registration'] ?? null,
                'front' => $this->car_reg_details['front'] ? config('app.url') . '/' . $this->car_reg_details['front'] : null,
                'back' => $this->car_reg_details['back'] ? config('app.url') . '/' . $this->car_reg_details['back'] : null,
            ] : null,
            'acceptance_rating' => $this->acceptance_rating ?? null,
            'bank_details' => $this->bank_details ?? null,
            'hourly_delivery_rate' => $this->hourly_delivery_rate ?? null,
            'start_time' => $this->start_time ? date('H:i', strtotime($this->start_time)) : null,
            'end_time' => $this->end_time ? date('H:i', strtotime($this->end_time)) : null,
            'current_location' => $this->current_location ?? null,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
