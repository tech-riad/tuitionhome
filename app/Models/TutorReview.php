<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TutorReview extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function tutor()
    {
        return $this->belongsTo(Tutor::class,'tutor_id');
    }
    public function parent()
    {
        return $this->belongsTo(Parents::class,'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'emp_id');
    }
    public function action()
    {
        return $this->belongsTo(User::class,'action_by');
    }
}
