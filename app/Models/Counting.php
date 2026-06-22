<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'applied_job',
        'shortlisted_job',
        'appointed_job',
        'confirmed_job',
        'cancel_job',
        'payment_job',
        'repost_job',
        'due_job',
        'refund_job',
        'waiting_job',
        'meeting_job',
        'trial_job',
        'problem_job'
    ];
}
