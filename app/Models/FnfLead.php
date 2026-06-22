<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FnfLead extends Model
{
    use HasFactory;

    protected $fillable =['name' ,'id'];

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
        return $this->belongsToMany(Subject::class);
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
}
