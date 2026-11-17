<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationRequestCheckout extends Model
{
    protected $fillable = [
        'invoice_id',
        'tutor_id',
        'parent_id',
        'message',
        'mode',
        'preferred_date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }
}
