<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'country_id',
        'city_id',
        'location_id',
        'address',
        'additional_phone',
        'whatsapp',
        'facebook',
        'personal_opinion',
    ];

    public function agent()
    {
        return $this->belongsTo(CorporateAgent::class, 'agent_id', 'id');
    }
}
