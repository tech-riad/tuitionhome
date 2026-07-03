<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnverifiedCorporatePartner extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'otp',
        'otp_expiry',
        'gender',
        'role_id',
        'password'
    ];
}
