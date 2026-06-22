<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class InactiveTutor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    protected $fillable = [
        'id',
        'unique_id',
        'name',
        'image',
        'email',
        'phone',
        'password',
        'role_id',
        'gender',
        'ip_address',
        'login_at',
        'phone_varified_at',
        'email_varified_at',
        'otp',
        'otp_expiry',
        'phone_change_count',
        'email_otp',
        'status',
        'is_verified',
        'is_featured',
        'is_active',
        'is_sms',
        'available_form',
        'available_to',
        'premium_by',
        'verified_by',
        'featured_by',
        'condition_note',
        'deleted_at',
        'is_premium',
        'deleted_by',
        'otp_resend_count',
        'last_otp_resend',
        'user_agent',
        'deactivate_by_admin',
        'deactivate_by_tutor',
        'delete_note',
        'profile_views',
        'premium_date',
        'featured_date',
        'verify_date',
        'is_alerted',
        'alerted_date',
        'alerted_by',
    ];
    protected $guard = 'inactive_tutor';

    public function tutor_personal_info()
    {
        return $this->hasOne(TutorPersonalInfo::class, 'tutor_id', 'id');
    }
    public function tutor_education()
    {
        return $this->hasMany(TutorEducation::class, 'tutor_id', 'id');
    }
    public function tutor_prefered_locations()
    {
        return $this->belongsToMany(Location::class,'tutor_prefered_locations','tutor_id','location_id');
    }

    public function tutor_course()
    {
        return $this->belongsToMany(Course::class, 'tutor_courses',
            'tutor_id', 'course_id');
    }

    public function tutor_subject()
    {
        return $this->belongsToMany(CourseSubject::class,'tutor_subjects','tutor_id','subject_id');
    }

    public function tutor_categories()
    {
        return $this->belongsToMany(Category::class, 'tutor_categories', 'tutor_id', 'category_id');
    }

    public function tutor_days()
    {
        return $this->belongsToMany(Day::class,'tutor_days','tutor_id','day_id');
    }
    public function teaching_method()
    {
        return $this->belongsToMany(TeachingMethod::class,'tutor_teaching_methods','tutor_id','method_id');
    }
    public function course_subjects(){
        return $this->belongsToMany(CourseSubject::class, 'tutor_subjects', 'tutor_id', 'subject_id');
    }

    public function getProfileComplete()
    {
        $count=5;
        $info= $this->tutor_personal_info;
        $education = $this->tutor_education;
        $certificate = TutorCertificate::where('tutor_id',$this->id)->first();
        if($info!=null){
            if($info->blood_group!=null){
                $count++;
            }
            if($info->full_address!=null){
                $count++;
            }
            if($info->permanent_full_address!=null){
                $count++;
            }
            if($info->date_of_birth!=null){
                $count++;
            }
            if($info->nid_number!=null){
                $count++;
            }
            if($info->fathers_name!=null){
                $count+=5;
            }
            if($info->fathers_phone!=null){
                $count+=5;
            }
            if($info->mothers_name!=null){
                $count+=5;
            }
            if($info->mothers_phone!=null){
                $count+=5;
            }
            if($info->facebook_link!=null){
                $count+=5;
            }

            if($info->about_yourself!=null){
                $count+=4;
            }
            if($info->reason_hired!=null){
                $count+=2;
            }
            if($info->personal_opinion!=null){
                $count+=2;
            }
            if($info->tutoring_experience!=null){
                $count+=2;
            }

            if($info->pic == 1){
                $count+=10;
            }

        }
        if ($education != null) {
            $sscRecord = TutorEducation::where('tutor_id', $this->id)->where('degree_name', 'ssc')->first();
            $hscRecord = TutorEducation::where('tutor_id', $this->id)->where('degree_name', 'hsc')->first();

            if ($sscRecord != null) {
                $count += 10;
            }

            if ($hscRecord != null) {
                $count += 10;
            }
        }
        if ($certificate !=null) {
            if($certificate->ssc_c != null)
            {
                $count += 2;
            }
            if($certificate->ssc_m != null)
            {
                $count += 2;
            }
            if($certificate->hsc_c != null)
            {
                $count += 2;
            }
            if($certificate->hsc_m != null)
            {
                $count += 2;
            }
            if($certificate->university_c != null)
            {
                $count += 2;
            }
        }


        if(count($this->tutor_categories)>0){
            $count+=2;
        }
        if(count($this->tutor_course)>0){
            $count+=2;
        }
        if(count($this->course_subjects)>0){
            $count+=1;
        }
        $pre=10;
        $count= ($count / 100) * 100;
        $total= $pre+$count;
        return $total;
    }

}