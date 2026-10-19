<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageAmount extends Model
{
    use HasFactory;

    protected $fillable = [
    'package_name',
    'amount',
    'currency',
    'duration',
    'type',
    'cupon',
    'discount'
];
}
