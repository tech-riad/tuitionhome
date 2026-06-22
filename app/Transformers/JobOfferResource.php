<?php

namespace App\Transformers;

use App\Imports\CategoryImport;
use App\Models\Subject;
use Illuminate\Http\Resources\Json\JsonResource;

class JobOfferResource extends JsonResource
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


    $additionalChildren = $this->additionalChild->map(function ($child) {
        return [
            'course_id' => $child->course_id,
            'category_id' => $child->category_id,
            'name' => $child->course->name,
        ];
    });

        return [

            'id' => $this->id,
            'parent_id' =>$this->parent_id,
            'student_name' => $this->student_name,
            'institute_name' =>$this->institute_name,
            'student_gender' =>$this->student_gender,
            'student_subject' =>CourseSubjectResource::collection($this->job_offer_student_subjects),
            'days_in_week' =>$this->days_in_week .' days',
            'category_id' =>new CategoryResource($this->category),
            'course_id' =>new CourseResource($this->course),
            'tutoring_time' =>$this->tutoring_time,
            'tutoring_duration' =>$this->tutoring_duration,
            'teaching_method_id' =>new TeachingMethodResource($this->teachingMethod),
            'salary' =>$this->salary,
            'number_of_students' =>$this->number_of_students,
            'country_id' =>new CountryResource($this->country),
            'city_id' =>new CityResource($this->city),
            'location_id' =>new LocationResource($this->location),
            'full_address' =>$this->full_address,
            'lat_long' =>$this->lat .', ' . $this->long,

            'requirement' =>$this->tutor_requirement,
            'special_note' =>$this->special_note,
            'hiring_from' =>$this->date,
            'relegion' =>$this->tutor_religion,
            'tutor_gender' =>$this->tutor_gender,
            'tutor_school' =>$this->tutor_school_id,
            'tutor_college' =>$this->tutor_school_id,
            'tutor_board' =>$this->tutor_board,
            'tutor_group' =>$this->tutor_group,
            'year' =>$this->year,
            'tutor_university_type' =>$this->tutor_university_type,
            'tutor_university' => $this->job_offer_tutor_universities->map(function ($universities) {
                return [
                    'name' => $universities->title ?? '',
                ];
            }),

            'tutor_study_types' => $this->job_offer_tutor_study_types->map(function ($studyTypes) {
                return [
                    'name' => $studyTypes->title ?? '',
                ];
            }),
            'tutor_department' => $this->job_offer_tutor_departments->map(function ($department) {
                return [
                    'name' => $department->title ?? '',
                ];
            }),
            'tutor_courses' => $this->job_offer_tutor_courses->map(function ($course) {
                return [
                    'name' => $course->name,
                ];
            }),
            'tutor_categories' => $this->job_offer_tutor_categories->map(function ($category) {
                return [
                    'name' => $category->name,
                ];
            }),
            'tutor_subject' => $this->job_offer_tutor_subjects->map(function ($subject) {
                return [
                    'subject_name' => Subject::find($subject->subject_id)->title ?? '',
                ];
            }),


            'tutor_curriculam' =>new TutorCariculamResource($this->tutorCurriculam),
            'total_view' => $this->job_views,
            'total_application'=> $this->total_application,
            'created_at'=> $this->created_at,
            'additionalChild' => $additionalChildren,


        ];
    }
}