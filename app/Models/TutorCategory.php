<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorCategory extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function tutor_courses()
    {
        return $this->belongsToMany(Category::class,
            'tutor_courses', 'tutor_id', 'course_id');
    }

}
