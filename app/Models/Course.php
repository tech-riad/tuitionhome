<?php

namespace App\Models;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 * @package App\Models
 * @version February 22, 2023, 11:44 am UTC
 *
 * @property integer $category_id
 * @property string $name
 */
class Course extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'courses';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'category_id',
        'name',
        'course_image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category_id' => 'integer',
        'name' => 'string',
        'course_image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required',
        'name' => 'required',
        'course_image' => 'nullable',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'course_subjects');
    }

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class, 'tutors_courses', 'course_id', 'tutor_id');
    }
}
