<?php

namespace App\Transformers;

use App\Imports\CategoryImport;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public function toArray($request)
    // {


    //     return [

    //         'id' => $this->id,
    //         'unique_id' =>$this->unique_id,
    //         'name' => $this->name,
    //         'email' =>$this->email,
    //         'phone' =>$this->phone,
    //         'gender' =>$this->gender,
    //         'is_verified' =>$this->is_verified,
    //         'email_varified_at' =>$this->email_varified_at,
    //         'is_featured' =>$this->is_featured,
    //         'is_premium'  =>$this->is_premium,
    //         'is_premium_pro'  =>$this->is_premium_pro,
    //         'is_premium_advance'  =>$this->is_premium_advance,
    //         'is_active'  =>$this->is_active,
    //         'is_boost'  =>$this->is_boost,
    //         'is_sms'  =>$this->is_sms,
    //         'is_alerted'  =>$this->is_alerted,
    //         'deactive_by_admin'  =>$this->deactivate_by_admin,
    //         'created_at'  =>$this->created_at,
    //         'tutor_personal_info' => new TutorPesonalInformationResource($this->tutor_personal_info),
    //         'tutor_education' =>TutorEducationResource::collection($this->tutor_education),
    //         'tutor_prefered_locations' =>Tutor_prefered_locationsResource::collection($this->tutor_prefered_locations),
    //         'tutor_course' =>CourseResource::collection($this->tutor_course),
    //         'tutor_subject' =>SubjectResource::collection($this->tutor_subject),
    //         'tutor_categories' =>CategoryResource::collection($this->tutor_categories),
    //         'tutor_days' =>TutorDaysResource::collection($this->tutor_days),
    //         'teaching_method' =>TeachingMethodResource::collection($this->teaching_method),


    //         $tutor_reviews = $tutor->tutor_reviews()
    //         ->orderBy('id', 'desc')
    //         ->get()
    //         ->map(function ($review) {
    //             return [
    //                 'parent_name' => $review->parent->name ?? null,
    //                 'parent_image' => 'https://hellott.xyz/storage/parent-images/' . ($review->parent->image ?? null),
    //                 'parent_id' => $review->parent->unique_id ?? null,
    //                 'emp_id' => $review->emp_id ?? null,
    //                 'rating' => $review->rating,
    //                 'description' => $review->description,
    //                 'date' => $review->created_at,
    //             ];
    //         });


    //     ];
    // }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'unique_id' => $this->unique_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'is_verified' => $this->is_verified,
            'email_varified_at' =>$this->email_varified_at, // Fixed typo
            'is_featured' => $this->is_featured,
            'is_premium' => $this->is_premium,
            'is_premium_pro' => $this->is_premium_pro,
            'is_premium_advance' => $this->is_premium_advance,
            'is_active' => $this->is_active,
            'is_boost' => $this->is_boost,
            'is_sms' => $this->is_sms,
            'is_alerted' => $this->is_alerted,
            'deactive_by_admin'  =>$this->deactivate_by_admin, // Fixed key
            'created_at' => $this->created_at,
            'tutor_personal_info' => new TutorPesonalInformationResource($this->tutor_personal_info),
            'tutor_education' => TutorEducationResource::collection($this->tutor_education),
            'tutor_prefered_locations' => Tutor_prefered_locationsResource::collection($this->tutor_prefered_locations),
            'tutor_course' => CourseResource::collection($this->tutor_course),
            'tutor_subject' => SubjectResource::collection($this->tutor_subject),
            'tutor_categories' => CategoryResource::collection($this->tutor_categories),
            'tutor_days' => TutorDaysResource::collection($this->tutor_days),
            'teaching_method' => TeachingMethodResource::collection($this->teaching_method),


            'tutor_reviews' => $this->tutor_reviews()
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'reviewer_type' => $review->parent ? 'parent' : 'employee',
                    'parent_name' => $review->parent->name ?? ($review->emp->name ?? null),
                    'parent_image' => $review->parent && $review->parent->image
                        ? url('storage/parent-images/' . $review->parent->image)
                        : ($review->emp && $review->emp->image ? url('storage/emp-images/' . $review->emp->image) : null),
                    'parent_id' => $review->parent->unique_id ?? ($review->emp->unique_id ?? null),
                    'emp_id' => $review->emp_id ? 'E2' . $review->emp_id .'2A' : null,
                    'rating' => $review->rating,
                    'description' => $review->description,
                    'date' => $review->created_at,
                ];
            }),
            'tutor_notice' => $this->tutor_notice()
            ->where('status',1)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($notices) {
                return [
                    'description' => $notices->description ,
                    'created_at' => $notices->created_at->format('d M Y'),

                ];
            }),


        ];
    }

}