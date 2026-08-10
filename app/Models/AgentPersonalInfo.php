<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'date_of_birth',
        'profession',
        'known_from',
        'institute',
        'institute_category',
        'institute_designation',
        'work_experience',
    ];

    public function agent()
    {
        return $this->belongsTo(CorporateAgent::class, 'agent_id', 'id');
    }
}
