<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorCourse extends Model
{
    use HasFactory;

    public function subjects()
    {
        return $this->hasMany(TutorSubject::class,'course_id');
    }
}
