<?php

namespace App\Models;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



/**
 * Class Subject
 * @package App\Models
 * @version February 23, 2023, 4:41 am UTC
 *
 * @property string $title
 */
class Subject extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'subjects';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required'
    ];

    public function courses(){
        return $this->belongsTo(CourseSubject::class, 'course_subjects');
    }

    public function subjects()
{
    return $this->hasOne(CourseSubject::class, 'course_id');
}

    // public function subject_one(){
    //    return $this->belongsTo(CourseSubject::class,'subject_id','id');
    // }

}
