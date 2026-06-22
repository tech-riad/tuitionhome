<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsBalance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tutor(){
        return $this->belongsTo(Tutor::class,'tutor_id');
    }


}
