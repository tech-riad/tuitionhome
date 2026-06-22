<?php
namespace App\Services;

use App\Interfaces\JobOfferServiceInterface;
use App\Models\JobOffer;

class JobOfferService implements JobOfferServiceInterface
{
    public function all()
    {
        $all_job_offers = JobOffer::with(['category','course','job_offer_student_subjects','teachingMethod','country','city','location','tutorCurriculam'])->where('is_active','1')->orderBy('id','desc');

        return $all_job_offers;

    }

    public function single($id)
    {
        $all_job_offers = JobOffer::with(['category','course','job_offer_student_subjects','teachingMethod','country','city','location','tutorCurriculam'])->where('id',$id);
        return $all_job_offers;
    }




}
