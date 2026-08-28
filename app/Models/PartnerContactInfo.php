<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'country_id',
        'city_id',
        'location_id',
        'address',
        'additional_phone',
        'whatsapp',
        'facebook',
        'personal_opinion',
    ];

    public function partner()
    {
        return $this->belongsTo(CorporatePartner::class, 'partner_id', 'id');
    }
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
}
