<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Sms;
use Illuminate\Support\Facades\Session;
use App\Models\Course;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tutor extends Authenticatable
{
    use Notifiable,HasApiTokens;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function getIdAttribute()
    {
        return $this->attributes['id'];
    }
    public function tutor_delete_note()
    {
        return $this->hasMany(TutorDeleteNote::class);
    }
    public function tutor_log()
    {
        return $this->hasMany(TutorLog::class);
    }


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
        'lat',
        'long',
    ];
    protected $guard = 'tutor';
    private static $tutor;
    private static $generate_otp;

    public function job_applications(){
        return $this->hasMany(JobApplication::class,'tutor_id');
    }
    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class, 'job_offer_id', 'job_offer_id');
    }
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    public function premire()
    {
        return $this->belongsTo(User::class, 'premium_by');
    }
    public function feature()
    {
        return $this->belongsTo(User::class, 'featured_by');
    }



    public static function sendOtpSms($number,$otp){

        $response= Sms::otpApiRequest("88".$number,$otp." is your OTP.\n Tuition Terminal");
        return $response; //response data type is json
    }

    public function tutor_educations()
    {
        return $this->hasMany(TutorEducation::class, 'tutor_id', 'id');
    }
    public function tutor_education()
    {
        return $this->hasMany(TutorEducation::class, 'tutor_id', 'id');
    }

    public function tutor_personal_info()
    {
        return $this->hasOne(TutorPersonalInfo::class, 'tutor_id', 'id');
    }



//    public function tutor_prefered_location()
//    {
//        return $this->hasOne(TutorPreferedLocation::class,'tutor_id');
//    }

//    public function tutor_course()
//    {
//        return $this->hasMany(TutorCourse::class,'tutor_id','id');
//    }


        public function courses()
            {
                return $this->belongsToMany(Course::class, 'tutor_courses', 'tutor_id', 'course_id');
            }

            public function tt_cat()
            {
                return $this->belongsToMany(Category::class, 'tutor_categories', 'tutor_id', 'category_id');

            }


            public function tutor_geTcategories()
            {
                return $this->belongsToMany(Category::class, 'tutor_categories', 'tutor_id', 'category_id');
            }
            public function institutes()
            {
                return $this->belongsTo(Institute::class,'institute_id','id');
            }
            public function departments()
            {
                return $this->belongsTo(Department::class,'department_id','id');
            }

            public function tutor_geTcourses()
            {
                return $this->belongsToMany(Course::class, 'tutor_courses', 'tutor_id', 'course_id');
            }

            public function tutor_geTsubjects()
            {
                return $this->belongsToMany(CourseSubject::class, 'tutor_subjects', 'tutor_id', 'subject_id');
            }

    public function tutor_course()
    {
        return $this->belongsToMany(Course::class, 'tutor_courses',
            'tutor_id', 'course_id');
    }
    public function tutor_certificate()
    {
        return $this->belongsToMany(TutorCertificate::class, 'tutor_id',
            'id');
    }

    public function tutor_course_subjects(){
        return $this->belongsToMany(tutor_course_subject::class ,'tutor_course_subject','tutor_id','course_subject_id');
    }

    public function course_subjects(){
        return $this->belongsToMany(CourseSubject::class, 'tutor_subjects', 'tutor_id', 'subject_id');
    }
    public function tutor_subject()
    {
        return $this->belongsToMany(CourseSubject::class,'tutor_subjects','tutor_id','subject_id');
    }

    public function scopeCourseSubjects($query,$course_id){
        if($course_id) {
            return $this->belongsToMany(CourseSubject::class,
                'tutor_subjects', 'tutor_id', 'subject_id')
                ->where('course_subjects.course_id', $course_id)
            ;
        }else{
            return $query;
        }
    }


    public function job_offer_tutor_categories(){
        return $this->belongsToMany(Category::class,'job_offer_tutor_categories','job_id','category_id');
    }

    public function tutor_categories()
    {
        return $this->belongsToMany(Category::class, 'tutor_categories', 'tutor_id', 'category_id');
    }

    public function tutor_courses() // Adjusted the method name to match the eager loading
    {
        return $this->belongsToMany(Course::class, 'tutor_courses', 'tutor_id', 'course_id');
    }
    // public function tutor_categories()
    // {
    //     return $this->belongsToMany(Category::class,
    //         'tutor_categories', 'tutor_id', 'category_id');
    // }
    public function scopeTutorCourse($query, $cat_id){
        if($cat_id) {
            return $this->belongsToMany(Course::class, 'tutor_courses',
                'tutor_id', 'course_id')
                ->where('category_id', $cat_id);
        }else{
            return $query;
        }
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class,'location_id');
    }
    public function tutor_prefered_locations()
    {
        return $this->belongsToMany(Location::class,'tutor_prefered_locations','tutor_id','location_id');
    }
    // For Suggession as tutor view
    public function tutor_prefered_location()
    {
        return $this->hasMany(TutorPreferedLocation::class, 'tutor_id');
    }
    public function tutor_days()
    {
        return $this->belongsToMany(Day::class,'tutor_days','tutor_id','day_id');
    }
    public function teaching_method()
    {
        return $this->belongsToMany(TeachingMethod::class,'tutor_teaching_methods','tutor_id','method_id');
    }

    public function TutorCertificate()
    {
        return $this->hasOne(TutorCertificate::class,'tutor_id','id');
    }


    public function smsBalances()
    {
        return $this->hasOne(SmsBalance::class,'tutor_id', 'id');
    }

    public function tutorPersonalInfo()
    {
        return $this->hasOne(TutorPersonalInfo::class);
    }

    public function tutor_reviews()
    {
        return $this->hasMany(TutorReview::class);
    }
    public function tutor_notice()
    {
        return $this->hasMany(AllNotice::class);
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


    public function isActive(){
        if($this->is_active == 1){
            return true;
        }else{
            return false;
        }
    }




    // public function get_tutor_unique_id()
    // {
    //     $id= $this->id;
    //     $mod = $id % 10000;

    //     $div_res= (int) ($id / 10000);
    //     $prefix="AA";
    //     $postfix="A";
    //     switch($div_res){
    //         case 0:
    //             $prefix='A';
    //         break;
    //         case 1:
    //             $prefix='B';
    //         break;
    //         case 2:
    //             $prefix='C';
    //         break;
    //         case 3:
    //             $prefix='D';
    //         break;
    //         case 4:
    //             $prefix='E';
    //         break;
    //         case 5:
    //             $prefix='F';
    //         break;
    //         case 6:
    //             $prefix='G';
    //         break;
    //         case 7:
    //             $prefix='H';
    //         break;
    //         case 8:
    //             $prefix='I';
    //         break;
    //         case 9:
    //             $prefix='J';
    //         break;
    //         case 10:
    //             $prefix='A';
    //         break;
    //         case 11:
    //             $prefix='A';
    //         break;
    //         case 12:
    //             $prefix='A';
    //         break;
    //         case 13:
    //             $prefix='A';
    //         break;
    //         case 14:
    //             $prefix='A';
    //         break;
    //         case 15:
    //             $prefix='A';
    //         break;
    //         case 16:
    //             $prefix='A';
    //         break;
    //         case 17:
    //             $prefix='A';
    //         break;
    //         case 18:
    //             $prefix='A';
    //         break;
    //         case 19:
    //             $prefix='A';
    //         break;
    //         case 20:
    //             $prefix='A';
    //         break;
    //         case 21:
    //             $prefix='A';
    //         break;
    //         case 22:
    //             $prefix='A';
    //         break;
    //         case 23:
    //             $prefix='A';
    //         break;
    //         case 24:
    //             $prefix='A';
    //         break;
    //         case 25:
    //             $prefix='A';
    //         break;
    //     }
    //     $num= sprintf("%05d", $mod);
    //     $this->unique_id= $prefix.$num.$postfix;
    //     $this->save();
    //     return true;
    // }

    public function get_tutor_unique_id()
{
    $id = $this->id;
    $prefix = '';
    $postfix = ''; // <-- define default

    if ($id >= 1 && $id <= 99999) {
        $prefix = 'A';
    } elseif ($id >= 100000 && $id <= 199999) {
        $prefix = 'A';
        $postfix = 'A';
        $id -= 100000;
    } elseif ($id >= 200000 && $id <= 299999) {
        $prefix = 'A';
        $postfix = 'B';
        $id -= 200000;
    } elseif ($id >= 300000 && $id <= 399999) {
        $prefix = 'A';
        $postfix = 'C';
        $id -= 300000;
    } elseif ($id >= 400000 && $id <= 499999) {
        $prefix = 'A';
        $postfix = 'D';
        $id -= 400000;
    } elseif ($id >= 500000 && $id <= 599999) {
        $prefix = 'A';
        $postfix = 'E';
        $id -= 500000;
    } elseif ($id >= 600000 && $id <= 699999) {
        $prefix = 'A';
        $postfix = 'F';
        $id -= 600000;
    } elseif ($id >= 700000 && $id <= 799999) {
        $prefix = 'A';
        $postfix = 'G';
        $id -= 700000;
    } elseif ($id >= 800000 && $id <= 899999) {
        $prefix = 'A';
        $postfix = 'H';
        $id -= 800000;
    } elseif ($id >= 900000 && $id <= 999999) {
        $prefix = 'A';
        $postfix = 'I';
        $id -= 900000;
    } elseif ($id >= 1000000 && $id <= 1099999) {
        $prefix = 'A';
        $postfix = 'J';
        $id -= 1000000;
    }

    $num = sprintf("%05d", $id);
    $this->unique_id = $prefix . $num . $postfix;
    $this->save();

    return true;
}

}