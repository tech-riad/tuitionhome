<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorDeleteNote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function deleteuser()
    {
        return $this->belongsTo(User::class,'delete_by');
    }
    public function restoreuser()
    {
        return $this->belongsTo(User::class,'restore_by');
    }
}
