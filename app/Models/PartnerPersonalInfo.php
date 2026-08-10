<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerPersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'date_of_birth',
        'profession',
        'known_from',
        'institute',
        'institute_category',
        'institute_designation',
        'work_experience',
    ];

    public function partner()
    {
        return $this->belongsTo(CorporatePartner::class, 'partner_id', 'id');
    }

}
