<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SmsTamplate extends Model
{
    use HasFactory;

    // public function userName()
    // {
    //     return $this->hasOne(user::class,'id','id');
    // }

    public function user(){
        return $this->belongsTo(user::class,'user_id','id');
    }

}
