<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CorporatePartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'unique_id' => $this->unique_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'image' => $this->image ? url('storage/corporate-partner-images/' . $this->image) : null,
            'is_verified' => $this->phone_verified_at ? true : false,
            'phone_verified_at' => $this->phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
            'is_active' => $this->is_active,
            'is_sms' => $this->is_sms,
            'balances' => $this->balances,
            'login_at' => $this->login_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
