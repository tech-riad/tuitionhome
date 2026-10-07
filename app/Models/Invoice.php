<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tutor;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'tutor_id',
        'invoice_number',
        'amount',
        'currency',
        'status',
        'issued_at',
        'paid_at',
        'tutor_email',
        'tutor_name',
        'tutor_phone',
        'unique_id',
        'job_id',
        'trx_id',
        'payment_date',
        'owned_by',
        'issued_by',
        'verified_by',
        'due_amount',
        'due_payment_date',
        'merchanttrx_id',
        'payment_method',
    ];
    protected $casts = [
    'issued_at' => 'datetime',
    'paid_at' => 'datetime',
    'payment_date' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owned_by');
    }
    public function render()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    public function verifyBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
