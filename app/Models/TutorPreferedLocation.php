<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorPreferedLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'tutor_id',
        'location_id',

    ];
    public $table = 'tutor_prefered_locations';

    public function preferred_location()
    {
        return $this->belongsTo(Location::class,'location_id','id');
    }
}
