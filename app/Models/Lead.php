<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable =['name','id'];

    public function user()
    {
        return $this->belongsTo(User::class,'added_by');
    }
    public function parent()
    {
        return $this->belongsTo(Parents::class,'parents_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class,'location_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subjects()
    {

        $subjectIds = explode(',', $this->subject_id);
        return Subject::whereIn('id', $subjectIds)->get();
    }
    public function parentsNote()
    {
        return $this->hasMany(ParentNote::class, 'parents_id', 'parents_id');
    }

}
