<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplicationNote extends Model
{
    protected $fillable = [
        'career_application_id',
        'user_id',
        'note',
    ];

    public function application()
    {
        return $this->belongsTo(CareerApplication::class, 'career_application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
