<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorEducation extends Model
{
    use HasFactory;
    public $table = 'tutor_educations';

    public function institutes()
    {
        return $this->belongsTo(Institute::class,'institute_id','id');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function studyType()
    {
        return $this->belongsTo(Study::class,'study_type_id','id');
    }
    public function curriculam()
    {
        return $this->belongsTo(Curriculam::class,'curriculum_id','id');
    }

}
