<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_id',
        'transaction_id',
        'amount',
        'currency',
        'payment_method',
        'status',
        'eps_transaction_id',
        'request_data',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];
}
