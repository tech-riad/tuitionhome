<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    public const STATUSES = [
        'pending',
        'reviewing',
        'shortlisted',
        'interview',
        'hired',
        'rejected',
    ];

    protected $fillable = [
        'career_plan_id',
        'tutor_id',
        'status',
    ];

    public function careerPlan()
    {
        return $this->belongsTo(CareerPlan::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function notes()
    {
        return $this->hasMany(CareerApplicationNote::class, 'career_application_id')
            ->with('user')
            ->latest();
    }
}
