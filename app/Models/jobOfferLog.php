<?php

namespace App\Models;

use App\Models\Admin\AdditionalChild;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobOfferLog extends Model
{
    use HasFactory;

    protected $table = "job_offer_logs";
    protected $guarded = [];
    use HasFactory;

    public function applicationNote()
    {
        return $this->hasMany(ApplicationNote::class,'job_application_id');
    }


    public function applications()
    {
         return $this->hasMany(JobApplication::class,'job_offer_id');
    }
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(){
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function reference(){
        return $this->belongsTo(FnfLead::class, 'reference_id');
    }
    public function tutorSchool(){
        return $this->belongsTo(Institute::class, 'tutor_school_id');
    }

    public function tutorCollege(){
        return $this->belongsTo(Institute::class, 'tutor_college_id');
    }

    public function tutorCurriculam(){
        return $this->belongsTo(Curriculam::class, 'tutor_curriculam_id');
    }


    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function teachingMethod(){
        return $this->belongsTo(TeachingMethod::class, 'teaching_method_id');
    }
    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }
    public function tutorUniversity(){
        return $this->hasMany(Institute::class,'id', 'tutor_university_id');
    }
    // public function subject(){
    //     return $this->belongsTo(location::class, 'location_id');
    // }

    public function tutorUniversityType(){
        return $this->belongsTo(Study::class, 'tutor_university_type_id');
    }

    public function job_offer_subject(){
        return $this->belongsToMany(Subject::class,'job_offer_student_subjects','job_id','subject_id');
    }

    public function job_offer_tutor_categories(){
        return $this->belongsToMany(Category::class,'job_offer_tutor_categories','job_id','category_id');
    }

    public function job_offer_tutor_courses(){
        return $this->belongsToMany(Course::class,'job_offer_tutor_courses','job_id','course_id');
    }

    public function job_offer_tutor_subjects(){
        return $this->belongsToMany(CourseSubject::class,'job_offer_tutor_subjects','job_id','subject_id');
    }

    public function job_offer_tutor_universities(){
        return $this->belongsToMany(Institute::class,'job_offer_tutor_universities','job_id','univirsity_id');
    }

    public function job_offer_tutor_study_types(){
        return $this->belongsToMany(Study::class,'job_offer_tutor_study_types','job_id','study_type_id');
    }
    public function job_offer_tutor_departments(){
        return $this->belongsToMany(Department::class,'job_offer_tutor_departments','job_id','department_id');
    }
    public function job_offer_student_subjects(){
        return $this->belongsToMany(CourseSubject::class,'job_offer_student_subjects','job_id','subject_id');

    }
    public function additional_child_info(){
        return $this->belongsTo(AdditionalChild::class,'parent_id');
    }
    public function job_offer_additional_child_subjects(){
        return $this->belongsToMany(CourseSubject::class,'job_offer_additional_child_subjects','parent_id','subject_id');
    }





}
