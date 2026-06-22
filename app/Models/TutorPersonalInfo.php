<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorPersonalInfo extends Model
{
    use HasFactory;
    public $table = 'tutor_personal_infos';

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
    public function t_user()
    {
        return $this->belongsTo(Tutor::class,'tutor_id','id');
    }

    protected $fillable = [
        'tutor_id',
        'country_id',
        'city_id',
        'location_id',
        'additional_phone',
        'full_address',
        'permanent_full_address',
        'nid_number',
        'nationality',
        'facebook_profile',
        'blood_group',
        'date_of_birth',
        'fathers_name',
        'mothers_name',
        'fathers_phone',
        'mothers_phone',
        'emergency_name',
        'emergency_phone',
        'reason_hired',
    ];




}