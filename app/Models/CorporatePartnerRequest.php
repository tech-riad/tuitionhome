<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tutor;
use App\Models\TutorPersonalInfo;


class CorporatePartnerRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'tutor_id',
        'status',
        'action_by',
    ];

    protected $guarded = [];


    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'id');
    }

    public function tutor_personal_info()
    {
        return $this->belongsTo(TutorPersonalInfo::class, 'tutor_id', 'tutor_id');
    }
}
