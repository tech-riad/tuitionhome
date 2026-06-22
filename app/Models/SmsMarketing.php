<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsMarketing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = ['title', 'sms_body', 'status', 'campain_status', 'send_now', 'send_latter','updated_audience'];

}
