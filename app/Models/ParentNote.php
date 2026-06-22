<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentNote extends Model
{
    use HasFactory;

    public function noteBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
