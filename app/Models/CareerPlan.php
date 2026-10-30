<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'title',
        'status',
        'form_data',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];
}
