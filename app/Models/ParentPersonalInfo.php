<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentPersonalInfo extends Model
{
    use HasFactory;
    public $table = 'parent_personal_infos';
    protected $fillable = [
        'parents_id','country_id', 'city_id', 'location_id', 'additional_phone',
        'whats_up_phone', 'facebook_profile', 'address_details', 'personal_opinion','gender', 'date_of_birth', 'profession', 'about_us'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class,'location_id');
    }
    public function category()
    {
        return $this->belongsTo(Location::class,'category_id');
    }
    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

}
