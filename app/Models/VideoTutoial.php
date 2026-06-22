<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTutoial extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
    'tutorial_type',
    'video_title',
    'video_link',
    'deleted_by',
    'deleted_at',
];
}