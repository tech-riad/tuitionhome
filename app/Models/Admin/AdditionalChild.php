<?php

namespace App\Models\Admin;

use App\Models\Category;
use App\Models\Course;
use App\Models\Subject;
use App\Models\CourseSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalChild extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function job_offer_additional_child_subjects(){
        return $this->belongsToMany(CourseSubject::class, 'job_offer_additional_child_subjects', 'parent_id', 'subject_id')
                    ;
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }



    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
