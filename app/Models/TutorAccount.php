<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorAccount extends Model
{
    use HasFactory;
    protected $fillable = ['tutor_id', 'number', 'account_type', 'account_name','b_account_name','b_branch_name','b_account_type','b_account_number'];

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
}
