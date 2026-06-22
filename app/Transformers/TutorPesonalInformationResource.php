<?php

namespace App\Transformers;

use App\Imports\CategoryImport;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorPesonalInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //  return parent::toArray($request);

    //    $subject =  SubjectResource::collection($this->job_offer_student_subjects,function($subject){
    //            foreach($subject as $sub)
    //            {
    //             return $sub->title;

    //            }
    //     });


        return [

            'id' => $this->id,
            'tutor_id' =>$this->tutor_id,
            'country' => $this->country ? ['id' =>$this->country->id,'name'=>$this->country->name] : null,
            'city' =>$this->city ? ['id' =>$this->city->id,'name'=>$this->city->name] : null,
            'location' =>$this->location ? ['id' =>$this->location->id,'name'=>$this->location->name]  : null,
            'additional_phone' =>$this->additional_phone,
            'full_address' =>$this->full_address,
            'permanent_full_address' =>$this->permanent_full_address,
            'nid_number' =>$this->nid_number,
            'nationality' =>$this->nationality,
            'blood_group' =>$this->blood_group,
            'date_of_birth' =>$this->date_of_birth,
            'fathers_name' =>$this->fathers_name,
            'fathers_phone' =>$this->fathers_phone,
            'mothers_name' =>$this->mothers_name,
            'mothers_phone' =>$this->mothers_phone,
            'emergency_name' =>$this->emergency_name,
            'emergency_phone' =>$this->emergency_phone,
            'short_description' =>$this->short_description,
            'religion' =>$this->religion,
            'expected_salary' =>$this->expected_salary,
            'tutoring_experience_details' =>$this->tutoring_experience_details,
            'tutoring_experience' =>$this->tutoring_experience,
            'available_day' =>$this->available_day,
            'available_from' =>$this->available_from,
            'available_to' =>$this->available_to,
            'facebook_link' =>$this->facebook_link,
            'linekdin_link' =>$this->linekdin_link,
            'twitter_link' =>$this->twitter_link,
            'instagram_link' =>$this->instagram_link,
            'about_yourself' =>$this->about_yourself,
            'personal_opinion' =>$this->personal_opinion,
            'reason_hired' =>$this->reason_hired,
            // 'tutoring_experience_details' =>$this->tutoring_experience_details,
        ];
    }
}
