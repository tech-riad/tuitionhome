<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reffer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function reffer()
    {
        return $this->belongsTo(Tutor::class, 'reffer_for','phone');
    }
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
