<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnverifiedCorporateAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'phone_verified_at',
        'otp',
        'otp_expiry',
        'otp_resend_count',
        'last_otp_resend',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'otp_expiry' => 'datetime',
        'last_otp_resend' => 'datetime',
    ];
}
