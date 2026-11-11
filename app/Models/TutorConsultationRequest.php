<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorConsultationRequest extends Model
{
    public const STATUSES = [
        'pending',
        'accepted',
        'scheduled',
        'canceled',
    ];

    protected $fillable = [
        'tutor_id',
        'parent_id',
        'topic',
        'message',
        'status',
        'scheduled_at',
        'invoice_id',
        'payment_status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function notes()
    {
        return $this->hasMany(TutorConsultationRequestNote::class, 'consultation_request_id')
            ->with('user')
            ->latest();
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
