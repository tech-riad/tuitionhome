<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorAlertNote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    // Relationship for the 'changed_by' column
    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Relationship for the 'undo_by' column
    public function undoByUser()
    {
        return $this->belongsTo(User::class, 'undo_by');
    }
}
