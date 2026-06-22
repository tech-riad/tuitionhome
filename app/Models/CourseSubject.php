<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\Course;

class CourseSubject extends Model
{
    use HasFactory;
    protected $fillable = [

        'subject_id',
        'course_id',
    ];



    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
    // public function job_offer_student_subjects(){

    //     return $this->hasManyThrough(Subject::class, CourseSubject::class);

    // }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
