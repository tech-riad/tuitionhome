<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorLog extends Model
{
    use HasFactory;

    public function editor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id', 'id');
    }
}
