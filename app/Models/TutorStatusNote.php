<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorStatusNote extends Model
{
    use HasFactory;
    protected $fillable = [
        'tutor_id',
        'changed_by',
        'status',
        'changed_note',
    ];
}
