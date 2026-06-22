<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationPayment extends Model
{
    use HasFactory;

    public function application(){
        return $this->belongsTo(JobApplication::class, 'application_id');
    }
    public function tutor(){
        return $this->belongsTo(Tutor::class);
    }
    public function render(){
        return $this->belongsTo(User::class,'render_by');
    }
    public function verifyBy(){
        return $this->belongsTo(User::class,'verified_by');
    }
    public function owner(){
        return $this->belongsTo(User::class,'ownership_by');
    }

}
