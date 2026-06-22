<?php
namespace App\Services;

use App\Interfaces\TutorServiceInterface;
use App\Models\Tutor;

class TutorService implements TutorServiceInterface
{
    public function showTutor($id)
    {

        $get_tutor = Tutor::with([
             'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
        ])->where('id',$id);



        return $get_tutor;


    }





}
