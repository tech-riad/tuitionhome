<?php

namespace App\Models;

use App\TutorModule\Tutor_Education_info;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    public function applicationPayment(){
        return $this->belongsTo(ApplicationPayment::class, 'application_id');
    }

    public function applications()
    {
         return $this->hasMany(JobApplication::class,'job_offer_id');
    }

    public function job()
    {
        return $this->belongsTo(JobApplication::class, 'job_offer_id', 'job_offer_id');
    }

    public function tutors()
    {
        return $this->hasMany(JobApplication::class, 'job_offer_id', 'job_offer_id');
    }

    public function job_offer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'taken_by_id');
    }
    public function seenBy()
    {
        return $this->belongsTo(User::class,'seen_by');
    }

    public function stortlistedByUser()
    {
        return $this->belongsTo(User::class,'shortlisted_by');
    }



    public function tutor()
    {
        return $this->belongsTo(Tutor::class,'tutor_id');
    }


    public function tutorEdu()
    {
        return $this->hasMany(TutorEducation::class,'id','tutor_id');
    }

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class,'job_offer_id');
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class,'job_offer_id->parent_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'taken_by_id');
    }

    // public function tutorEdu()
    // {
    //     return $this->hasMany(TutorEducation::class,'id','tutor_id');
    // }

    public function applicationNote()
    {
        return $this->hasMany(ApplicationNote::class,'job_application_id');
    }

    // $jobApplication = job_offer::find($job_id)

// if ($jobApplication) {
//     $parent = $jobApplication->jobOffer->parent; // Access the "parent" relationship in the "JobOffer" model
//     // Now, $parent contains the parent information associated with the job application
// }


    // public function matched_rate(){


    //     if($this->tutor){
    //         $parcent=0;
    //         $tutor=$this->tutor;

    //         $personal=$tutor->tutor_personal_information;
    //         // $u_degrees=$tutor->tutor_degrees()->whereIn('degree_id',[3,4])->get();
    //         $offer=$this->job_offer;
    //         $offer_cat=$offer->category;
    //         $cat_matched=false;
    //         $gender_matched=false;
    //         $university_matched=false;
    //         $city_matched=false;
    //         $department_matched=false;
    //         $study_type_matched=false;
    //         $university_type_matched=false;
    //         foreach($tutor->categories as $category){
    //             if($offer_cat->id==$category->id){
    //                 $cat_matched=true;
    //                 break;
    //             }
    //         }
    //     }


    //     if($this->tutor){
    //         if($tutor->tutor_personal_information){
    //             if($personal && $offer){
    //                 if($personal->gender == $offer->tutor_gender){
    //                     $gender_matched=true;
    //                 }
    //             }
    //         }



            // foreach($u_degrees as $degree){
            //     if($degree->institute_id==$offer->tutor_university_id){
            //         $university_matched=true;
            //         break;
            //     }
            // }

            // if($tutor->city_id==$offer->city_id){
            //     $city_matched=true;
            // }
            // foreach($u_degrees as $degree){
            //     if($degree->department==$offer->tutor_department){
            //         $department_matched=true;
            //     }
            // }
            // if($offer->tutor_department==null){
            //     $department_matched=true;
            // }
            // foreach($u_degrees as $degree){
            //     if($degree->study_type_id==$offer->tutor_study_type_id){
            //         $study_type_matched=true;
            //     }
            // }
            // if($offer->tutor_study_type_id==null){
            //     $study_type_matched=true;
            // }
            // foreach($u_degrees as $degree){
            //     if($degree->university_type==$offer->university_type){
            //         $university_type_matched=true;
            //     }
            // }
    //         if($offer->university_type==null){
    //             $university_type_matched=true;
    //         }
    //         if($cat_matched && $gender_matched && $university_matched && $city_matched && $department_matched && $study_type_matched && $university_type_matched){
    //             $parcent+=50;
    //         }
    //         if($offer->location_id==$tutor->location_id){
    //             $parcent+=20;
    //         }
    //         foreach($tutor->prefered_locations as $pref_loc){
    //             if($offer->location_id==$pref_loc->id){
    //                 $parcent+=15;
    //                 break;
    //             }
    //         }
    //         foreach($tutor->courses as $cs){
    //             if($cs->id==$offer->course_id){
    //                 $parcent+=5;
    //             }
    //         }
    //         $ocs=$offer->course_subjects;
    //         $ocs_count=$ocs->count();
    //         $ocs_match_found=0;
    //         $tcs= $tutor->course_subjects;
    //         foreach($ocs as $oc){
    //             foreach($tcs as $tc){
    //                 if($oc->pivot->course_subject_id==$tc->pivot->course_subject_id){
    //                     $ocs_match_found+=1;
    //                     break;
    //                 }
    //             }
    //         }

    //         $ocs_percent=($ocs_match_found / $ocs_count) * 100;


    //         $parcent+= (5/100) * $ocs_percent;
    //         if($personal->gender==$offer->student_gender){
    //             $parcent+=5;
    //         }
    //     return $parcent;
    //     }
    // }

    // public function matched_rate() {
    //     if (!$this->tutor) {
    //         return 0;  // No tutor, no match
    //     }

    //     $parcent = 0;
    //     $tutor = $this->tutor;

    //     $personal = $tutor->tutor_personal_information;
    //     // $u_degrees = $tutor->tutor_degrees()->whereIn('degree_id', [3, 4])->get();
    //     $offer = $this->job_offer;
    //     $offer_cat = $offer->category;

    //     $cat_matched = $tutor->categories->contains('id', $offer_cat->id);

    //     if ($tutor->tutor_personal_information && $personal && $offer) {
    //         $gender_matched = ($personal->gender == $offer->tutor_gender);
    //     }

    //     // $university_matched = $u_degrees->contains('institute_id', $offer->tutor_university_id);
    //     $city_matched = ($tutor->city_id == $offer->city_id);

    //     // $department_matched = $u_degrees->contains('department', $offer->tutor_department) || $offer->tutor_department === null;

    //     // $study_type_matched = $u_degrees->contains('study_type_id', $offer->tutor_study_type_id) || $offer->tutor_study_type_id === null;

    //     // $university_type_matched = $u_degrees->contains('university_type', $offer->university_type) || $offer->university_type === null;

    //     if ($cat_matched && $gender_matched && $city_matched ) {
    //         $parcent += 50;
    //     }

    //     if ($offer->location_id == $tutor->location_id) {
    //         $parcent += 20;
    //     }

    //     if ($tutor->prefered_locations->contains('id', $offer->location_id)) {
    //         $parcent += 15;
    //     }

    //     foreach ($tutor->courses as $cs) {
    //         if ($cs->id == $offer->course_id) {
    //             $parcent += 5;
    //         }
    //     }

    //     $ocs = $offer->course_subjects;
    //     $ocs_count = $ocs->count();
    //     $ocs_match_found = $tutor->course_subjects->intersect($ocs)->count();

    //     $ocs_percent = ($ocs_match_found / $ocs_count) * 100;

    //     $parcent += (5 / 100) * $ocs_percent;

    //     if ($personal->gender == $offer->student_gender) {
    //         $parcent += 5;
    //     }

    //     return $parcent;
    // }
}
