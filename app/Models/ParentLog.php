<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentLog extends Model
{
    use HasFactory;

    protected $fillable =['category_id','tag_id','title','short_description','long_description','image','created_by'];

    public function location()
    {
        return $this->belongsTo(Location::class,'location_id');
    }
}
