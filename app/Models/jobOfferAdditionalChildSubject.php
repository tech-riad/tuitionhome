<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobOfferAdditionalChildSubject extends Model
{
    use HasFactory;


    public function job_offer_additional_child_subjects(){
        return $this->belongsToMany(CourseSubject::class, 'job_offer_additional_child_subjects', 'parent_id', 'id')
                    ;
    }


}
