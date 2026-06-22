<?php

namespace App\TutorModule;

use App\Models\TutorCategory;
use App\Models\TutorCourse;
use App\Models\TutorDay;
use App\Models\TutorPersonalInfo;
use App\Models\TutorPreferedLocation;
use App\Models\TutorSubject;
use App\Models\TutorTeachingMethod;
use Illuminate\Http\Request;

class Tutoring_Info
{

    protected $guarded = ['id'];
    public function tutor_information($request,$tutor_id)
    {
        // dd($request->all());
        $tutor_personal_info = TutorPersonalInfo::where('tutor_id',$tutor_id)->first();
        $tutor_personal_info->country_id = $request->country_id;
        $tutor_personal_info->city_id = $request->city_id;
        $tutor_personal_info->location_id = $request->location_id;
        $tutor_personal_info->tutoring_experience = $request->tutoring_experience;
        
        if($tutor_personal_info->available_to != null && $request->available_to==null){
            $tutor_personal_info->available_to = $tutor_personal_info->available_to;

        }
        if($tutor_personal_info->available_from != null && $request->available_from==null){
            $tutor_personal_info->available_from = $tutor_personal_info->available_from;

        }else{
            $tutor_personal_info->available_from = $request->available_from;
            $tutor_personal_info->available_to = $request->available_to;

        }
        if($tutor_personal_info->expected_salary != null && $request->expected_salary==null){
            $tutor_personal_info->expected_salary = $tutor_personal_info->expected_salary;


        }else{
            $tutor_personal_info->expected_salary = $request->expected_salary;


        }
        $tutor_personal_info->available_day = $request->available_day;

        $tutor_personal_info->save();
    }
    public function availableDay($tutor_id,$available_day)
    {
        $tutor_available_day = new TutorDay();
        $tutor_available_day->tutor_id = $tutor_id;
        $tutor_available_day->day_id = $available_day;
        $tutor_available_day->save();
    }

    public function favouriteSubject($tutor_id,$subject)
    {
        $tutoring_subject = new TutorSubject();
        $tutoring_subject->tutor_id = $tutor_id;
        $tutoring_subject->subject_id = $subject;
        $tutoring_subject->save();
    }

    public function preferredLocation($tutor_id,$preferred_location)
    {

            $tutor_preferred_location = new TutorPreferedLocation();
            $tutor_preferred_location->tutor_id =  $tutor_id;
            $tutor_preferred_location->location_id =  $preferred_location;
            $tutor_preferred_location->save();

    }

    public function tutorTeaching($tutor_id,$teaching_method)
        {
            $tutor_teaching_method = new TutorTeachingMethod();
            $tutor_teaching_method->tutor_id = $tutor_id;
            $tutor_teaching_method->title =$teaching_method;
            $tutor_teaching_method->save();
        }

        public function tutorcategory($tutor_id,$category)
        {
            $tutoring_category = new TutorCategory();
            $tutoring_category->tutor_id = $tutor_id;
            $tutoring_category->category_id = $category;
            $tutoring_category->save();
        }
        public function tutorcourse($tutor_id,$course)
        {
            $tutoring_course = new TutorCourse();
            $tutoring_course->tutor_id = $tutor_id;
            $tutoring_course->course_id = $course;
            $tutoring_course->save();
        }

}