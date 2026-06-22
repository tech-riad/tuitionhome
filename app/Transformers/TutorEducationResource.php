<?php

namespace App\Transformers;

use App\Imports\CategoryImport;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorEducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
    //      return parent::toArray($request);

    //    $subject =  SubjectResource::collection($this->job_offer_student_subjects,function($subject){
    //            foreach($subject as $sub)
    //            {
    //             return $sub->title;

    //            }
    //     });


    return [

        'id' => $this->id,
        'tutor_id' =>$this->tutor_id,
        'institute' => $this->institutes ? ['id' =>$this->institutes->id,'title'=>$this->institutes->title] : null,
        'curriculum' => $this->curriculam ? ['id' =>$this->curriculam->id,'title'=>$this->curriculam->title] : null ,
        'degree_name' =>$this->degree_name,
        'gpa' =>$this->gpa,
        'education_board' =>$this->education_board,
        'group_or_major' =>$this->group_or_major,
        'passing_year' =>$this->passing_year,
        'currently_studying' =>$this->currently_studying,
        'degree_title' =>$this->degree_title,
        'study_type' =>$this->studyType ? ['id' =>$this->studyType->id,'title'=>$this->studyType->title] : null,
        'department' =>$this->departments ? ['id' =>$this->departments->id,'title'=>$this->departments->title] : null,
        'university_type' =>$this->university_type,
        'year_or_semester' =>$this->year_or_semester,


    ];

    }
}
