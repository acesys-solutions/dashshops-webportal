<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'business_name' => $this->business_name,
            'business_address' => $this->business_address,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'photo' => $this->photo,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'user_type' => $this->user_type,
            'user_status' => $this->user_status,
            'email_verified_at' => $this->email_verified_at,
            'remember_token' => $this->remember_token,
            'admin' => $this->admin,
            'is_vip' => $this->is_vip,
            'approved_at' => $this->approved_at,
            'retailer_id' => $this->retailer_id,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
