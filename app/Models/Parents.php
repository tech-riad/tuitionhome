<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Parents extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'phone',
        'password',
        'otp',
        'email',
        'unique_id',
        'phone_verified_at',
    ];

    protected $hidden = ['otp', 'email_otp'];
    public function parentsNote()
    {
        return $this->hasmany(ParentNote::class,'parents_id','id');
    }
    public function activeDeactiveParentNote()
    {
        return $this->hasmany(ParentDeactivateNote::class,'parent_id','id');
    }

    public function parents_personalInfo()
    {
        return $this->hasOne(ParentPersonalInfo::class,'parents_id','id');
    }
    public function parent_notices()
    {
        return $this->hasMany(AllNotice::class,'parent_id');
    }
    public function jobOffer()
    {
        return $this->hasmany(JobOffer::class,'parent_id','id');
    }

    public function get_parent_unique_id()
    {
        $id = $this->id;
        $prefix = '';
        $postfix = '';

        if ($id >= 1 && $id <= 99999) {
            $prefix = 'G';
            $postfix = 'A';
        } elseif ($id >= 100000 && $id <= 199999) {
            $prefix = 'G';
            $postfix = 'B';
            $id -= 100000;
        } elseif ($id >= 200000 && $id <= 299999) {
            $prefix = 'G';
            $postfix = 'C';
            $id -= 200000;
        }
         elseif ($id >= 300000 && $id <= 399999) {
            $prefix = 'G';
            $postfix = 'D';
            $id -= 300000;
        } elseif ($id >= 400000 && $id <= 499999) {
            $prefix = 'G';
            $postfix = 'E';
            $id -= 400000;
        } elseif ($id >= 500000 && $id <= 599999) {
            $prefix = 'G';
            $postfix = 'F';
            $id -= 500000;
        }
         elseif ($id >= 600000 && $id <= 699999) {
            $prefix = 'G';
            $postfix = 'G';
            $id -= 600000;
        } elseif ($id >= 700000 && $id <= 799999) {
            $prefix = 'G';
            $postfix = 'H';
            $id -= 700000;
        }
         elseif ($id >= 800000 && $id <= 899999) {
            $prefix = 'G';
            $postfix = 'I';
            $id -= 800000;
        } elseif ($id >= 900000 && $id <= 999999) {
            $prefix = 'G';
            $postfix = 'J';
            $id -= 900000;
        }
         elseif ($id >= 1000000 && $id <= 1099999) {
            $prefix = 'G';
            $postfix = 'K';
            $id -= 1000000;
        }

        $num = sprintf("%05d", $id);

        $this->unique_id = $prefix . $num . $postfix;
        $this->save();
        return true;
    }


    public function superer()
    {
        return $this->belongsTo(User::class, 'super_by');
    }
    public function unpleaser()
    {
        return $this->belongsTo(User::class, 'unplesant_by');
    }
    public function verify()
    {
        return $this->belongsTo(User::class, 'verify_by');
    }
    public function deactivate()
    {
        return $this->belongsTo(User::class, 'deactive_by');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
