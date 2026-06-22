<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_type',
        'popupnotification_id',
        'send_now',
        'send_later_time',
        'placement_url',
        'navigate_link',
        'image',
        'status',
        'title',
    ];
}
