<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class CorporateAgent extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'unique_id',
        'role_id',
        'phone_verified_at',
        'otp',
        'otp_expiry',
        'otp_resend_count',
        'last_otp_resend',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        'otp_expiry' => 'datetime',
        'last_otp_resend' => 'datetime',
    ];


    public function get_corporate_agent_unique_id()
    {
        $id = $this->id;
        $postfix = ''; // Initialize $postfix here

        if ($id >= 1 && $id <= 99999) {
            $prefix = 'A';
            $postfix = 'A';
        } elseif ($id >= 100000 && $id <= 1099999) {
            $prefix = 'A';
            if ($id <= 199999) {
                $postfix = 'B';
                $id -= 100000;
            } elseif ($id <= 299999) {
                $postfix = 'C';
                $id -= 200000;
            } elseif ($id <= 399999) {
                $postfix = 'D';
                $id -= 300000;
            } elseif ($id <= 499999) {
                $postfix = 'E';
                $id -= 400000;
            } elseif ($id <= 599999) {
                $postfix = 'F';
                $id -= 500000;
            } elseif ($id <= 699999) {
                $postfix = 'G';
                $id -= 600000;
            } elseif ($id <= 799999) {
                $postfix = 'H';
                $id -= 700000;
            } elseif ($id <= 899999) {
                $postfix = 'I';
                $id -= 800000;
            } elseif ($id <= 999999) {
                $postfix = 'J';
                $id -= 900000;
            } elseif ($id <= 1099999) {
                $postfix = 'K';
                $id -= 1000000;
            }
        }

        $num = sprintf("%05d", $id);

        $this->unique_id = $prefix . $num . $postfix;
        $this->save();
        return true;
    }

    public function get_corporate_partner_unique_id()
    {
        return $this->get_corporate_agent_unique_id();
    }

    public function personalInfo()
    {
        return $this->hasOne(AgentPersonalInfo::class, 'agent_id', 'id');
    }
    public function contactInfo()
    {
        return $this->hasOne(AgentContactInfo::class, 'agent_id', 'id');
    }

}
