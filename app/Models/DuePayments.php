<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuePayments extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tutor(){
        return $this->belongsTo(Tutor::class);
    }
    public function job(){
        return $this->belongsTo(JobApplication::class,'application_id');
    }
    public function render(){
        return $this->belongsTo(User::class,'render_by');
    }
    public function verifyBy(){
        return $this->belongsTo(User::class,'verified_by');
    }
    public function ownerBy(){
        return $this->belongsTo(User::class,'ownership_by');
    }
    public function jobApplication(){
        return $this->belongsTo(JobApplication::class,'application_id');
    }
    public function accountName(){
        return $this->belongsTo(TutorAccount::class);
    }
}
