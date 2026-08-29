<?php

namespace App\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CorporateAgentResource extends JsonResource
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
            'image' => $this->image ? Storage::disk('r2')->url('corporate-agent-images/' . $this->image) : null,
            'is_verified' => $this->phone_verified_at ? true : false,
            'phone_verified_at' => $this->phone_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'personal_info' => $this->personalInfo ? [
                'date_of_birth' => $this->personalInfo->date_of_birth,
                'profession' => $this->personalInfo->profession,
                'known_from' => $this->personalInfo->known_from,
                'institute' => $this->personalInfo->institute,
                'institute_category' => $this->personalInfo->institute_category,
                'institute_designation' => $this->personalInfo->institute_designation,
                'work_experience' => $this->personalInfo->work_experience,
            ] : null,
            'contact_info' => $this->contactInfo ? [
                'country_id' => $this->contactInfo->country_id,
                'city_id' => $this->contactInfo->city_id,
                'location_id' => $this->contactInfo->location_id,
                'address' => $this->contactInfo->address,
                'additional_phone' => $this->contactInfo->additional_phone,
                'whatsapp' => $this->contactInfo->whatsapp,
                'facebook' => $this->contactInfo->facebook,
                'personal_opinion' => $this->contactInfo->personal_opinion,
            ] : null,
        ];
    }
}
