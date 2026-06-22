<?php

namespace App\Transformers;

use App\Imports\CategoryImport;
use Illuminate\Http\Resources\Json\JsonResource;

class Tutor_prefered_locationsResource extends JsonResource
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
            'name' =>$this->name,

        ];
    }
}
