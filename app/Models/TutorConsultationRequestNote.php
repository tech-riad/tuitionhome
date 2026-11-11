<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorConsultationRequestNote extends Model
{
    protected $fillable = [
        'consultation_request_id',
        'user_id',
        'note',
    ];

    public function consultationRequest()
    {
        return $this->belongsTo(TutorConsultationRequest::class, 'consultation_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
