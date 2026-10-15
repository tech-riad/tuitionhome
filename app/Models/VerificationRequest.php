<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'tutor_id',
        'request_status',
        'name',
        'taka',
        'transction_id',
        'payment_status',
        'action_by',
        'received_from',
        'payment_method',
        'decline_note',
        'waiting_note',
        'waiting_note_update_date',
        'expected_waiting_date',
        'action_at',
        'channel_name',
        'note',
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
