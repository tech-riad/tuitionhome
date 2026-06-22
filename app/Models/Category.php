<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Course;
/**
 * Class Category
 * @package App\Models
 * @version February 22, 2023, 11:41 am UTC
 *
 * @property string $name
 */
class Category extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'categories';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];
    public function courses(){
        return $this->hasMany(Course::class, 'category_id');
    }

    // public function category() {
    //     return $this->belongsTo(JobOffer::class,'category_id');
    // }

}
