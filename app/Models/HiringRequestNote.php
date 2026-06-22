<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringRequestNote extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class,'added_by');
    }
    // public function hiringRequest()
    // {
    //     return $this->belongsTo(HiringRequest::class, 'lead_id', 'id');
    // }
}
