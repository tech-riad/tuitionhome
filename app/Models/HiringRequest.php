<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiringRequest extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function tutor(){
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
    public function parent(){
        return $this->belongsTo(Parents::class, 'parent_id');
    }
    public function parentsNote()
    {
        return $this->hasMany(ParentNote::class, 'parents_id', 'parent_id');
    }

    public function hiringRequestNotes()
    {
        return $this->hasMany(HiringRequestNote::class,'lead_id');
    }
}
