<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marketting extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'campain_status', 'send_now', 'send_latter','updated_audience'];
    protected $dates = ['deleted_at'];
}
