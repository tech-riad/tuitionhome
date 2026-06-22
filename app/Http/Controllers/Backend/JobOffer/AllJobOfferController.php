<?php

namespace App\Http\Controllers\Backend\JobOffer;

use App\Models\Sms;
use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use App\Models\Admin\AdditionalChild;
use App\Models\AppliedTutorNote;
use Illuminate\Http\Request;
use App\Models\Parents;
use App\Models\Category;
use App\Models\SmsBalance;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Curriculam;
use App\Models\Department;
use App\Models\FnfLead;
use App\Models\Institute;
use App\Models\JobApplication;
use App\Models\JobEditLog;
use App\Models\JobOffer;
use App\Models\jobOfferLog;
use App\Models\JobSms;
use App\Models\JobStatus;
use App\Models\LeadSource;
use App\Models\TutorTeachingMethod;
use App\Models\Location;
use App\Models\SmsLimit;
use App\Models\Study;
use App\Models\TeachingMethod;
use App\Models\Subject;
use App\Models\Tutor;
use App\Models\User;
use App\Models\VSmsTemplate;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToArray;
use Psy\CodeCleaner\FunctionContextPass;
use Illuminate\Support\Facades\Validator;
use DateTime;
use DateTimeZone;


class AllJobOfferController extends Controller
{


    public function matchRate(Request $request){


        $job_id = $request->job_id;
        //  return  $job_id;
        $tutor_id = $request->tutor_id;
        // return $tutor_id;
        $job = JobOffer::with([
            'job_offer_student_subjects',
        ])->where('id', $job_id)->first();



    //  return  $job;

        $tutor = Tutor::with([
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'teaching_method',
        ])->where('id',$tutor_id)->first();
    //   return  $tutor;


         $t_profile_c = $tutor->getProfileComplete();
        //  return $t_profile_c;
        $count = 20;

           if($t_profile_c > 80){

            $count += 20;
           }


            foreach ($tutor->tutor_categories as $cat) {
            if ($cat->id == $job->category_id) {
                $count += 10;
            }
            }
            foreach ($tutor->tutor_course as $co) {
                if ($co->id == $job->course_id) {
                    $count += 20;
                }
                }


                foreach ($tutor->teaching_method as $tm) {
                if ($tm->id == $job->teaching_method_id) {
                    $count += 10;
                }
                }

                $matchCount = 0;

            foreach ($job->job_offer_student_subjects as $job_subject) {
                foreach ($tutor->tutor_subject as $tutor_subject) {
                    if ($job_subject->subject_id == $tutor_subject->subject_id) {
                         $count += 10;
                        $matchCount++;
                   if ($matchCount == 2) {

                    break 2;
            }
                    }
                }
            }

            return response()->json([
                'status'=>true,
                'count' =>$count,
                'tt_c' =>$t_profile_c,
            ]);

    }

    public function temChange(Request $request)
    {

        $template = VSmsTemplate::where('id', $request->id)->first();


        $job = JobOffer::with([
            'job_offer_student_subjects',
        ])->where('id', $request->job_id)->first();



        // $subject = $job->job_offer_student_subjects;

        foreach($job->job_offer_student_subjects as $course){

            $subject[] = $course->subject->title;


        }


       $subject= implode(',',$subject);

        // return  $subject;


        $job_with_value['id'] = $job->id;
        $job_with_value['class'] = $job->course->name;
        $job_with_value['subject'] = $subject;
        $job_with_value['location'] = $job->location->name;
        $job_with_value['days'] = $job->days_in_week;
        $job_with_value['full_address'] = $job->location->name;
        $job_with_value['salary'] = $job->salary;
        $job_with_value['duration'] = $job->tutoring_duration;

        $date = $job->tutoring_time;
        date('h:i A', strtotime($date));

        // $tutoring_time = new DateTime($job->tutoring_time, new DateTimeZone('UTC'));
        // $tutoring_time->setTimezone(new DateTimeZone('Asia/Dhaka'));
        // $job_with_value['time'] = $tutoring_time->format('h:i A');
        $job_with_value['time'] = date('h:i A', strtotime($date));



        // return $job_with_value;



        return response()->json([
            'status'=>true,
            'template'=>$template,
            'job' =>$job_with_value,
        ]);


    }


    public function tutorSms(Request $request)
    {
        // dd($request->all());


        $job_id = $request->sms_job_id;
        $all_sms_number = Sms::where('job_id',$job_id)->count();


        $ids = $request->all_t_ids;
        $myArray = explode(',', $ids);
        $tutors= Tutor::whereIn('id',$myArray)->get();


        // dd($tutors->toarray());
        foreach($tutors as $tutor){
            $phonenumbers[] = $tutor->phone;
        }
           $numbers = implode(',', $phonenumbers);


        $templates = VSmsTemplate::orderBy('id', 'desc')->get();


        // dd($numbers);
        return view('backend.job_offers.sms_editor', compact('templates','job_id','tutors','ids','numbers','all_sms_number'));

    }

    public function resendSms(Request $request)
    {
        // Validate the request
        // dd($request->toArray());
        $request->validate([
            'sms_job_ids'  => 'required|numeric',
            'tutor_ids'    => 'required|numeric',
            'tutor_phones' => 'required|string',
            'sms_bodies'   => 'required|string',
        ]);

        $smsJobId = $request->input('sms_job_ids');
        // dd($smsJobId);
        $tutorIds =  $request->input('tutor_ids');
        $body = $request->input('sms_bodies');
        $tutorNumbers = explode(',', $request->input('tutor_phones'));

        $smsTitles = $request->input('sms_titles');
        $smsMethods = $request->input('sms_methods');

        foreach ($tutorNumbers as $key => $phoneNumber) {
            $message = $body;
            $url = 'https://easybulksmsbd.com/sms/api?action=send-sms&api_key=VHVpdGlvbkhvbWU6MTIzNDU2Nzg5&to=88' . $phoneNumber . '&from=SenderID&sms=' . urlencode($message);

            $response = Http::get($url);

            // Check for errors
            if ($response->failed()) {
                return 'Failed to send SMS to ' . $phoneNumber . '. HTTP Error: ' . $response->status();
            }
        }

        JobSms::create([
            'job_id' => $smsJobId,
            'sender_name' => Auth::user()->name,
            'sender_id' => Auth::user()->id,
            'sms_title' => $smsTitles,
            'sms_body' => $body,
            'tutor_id' => is_array($tutorIds) ? $tutorIds[0] : $tutorIds,
            'tutor_phone' => is_array($tutorNumbers) ? $tutorNumbers[0] : $tutorNumbers,
            'sms_method' => $smsMethods
        ]);

        return redirect()->back()->with('success', 'SMS resent successfully.');
    }

    public function tutorSmsSend(Request $request)
        {
            try {
                $tutorNumbers = explode(',', $request->tutor_numbers);
                $body = $request->sms_body;

                foreach ($tutorNumbers as $phoneNumber) {
                    $sms = new Sms();
                    $sms->job_id = $request->jod_id;
                    $sms->send_by = Auth::user()->id;
                    $sms->user_id = Auth::user()->id;
                    $sms->body = $body;
                    $sms->phone = $phoneNumber;
                    $sms->sent = 0;
                    $sms->save();

                    $tutorId = Tutor::where('phone', $phoneNumber)->pluck('id')->first();
                    if ($tutorId) {
                        $updateSmsBalance = SmsBalance::where('tutor_id', $tutorId)->first();
                        if ($updateSmsBalance) {
                            $updateSmsBalance->increment('unpaid_sms');
                        } else {
                            $newSmsBalance = new SmsBalance();
                            $newSmsBalance->tutor_id = $tutorId;
                            $newSmsBalance->unpaid_sms = 1;
                            $newSmsBalance->save();
                        }
                    }

                    // $sms = new JobSms();
                    // $sms->job_id             = $request->jod_id;
                    // $sms->sender_name        = Auth::user()->name;
                    // $sms->sender_id          = Auth::user()->id;
                    // $sms->sms_title          = $request->title_id;
                    // $sms->sms_body           = $request->sms_body;
                    // $sms->tutor_id           = $tutor_id[$key];
                    // $sms->tutor_phone        = $tutor_numbers[$key];
                    // $sms->sms_method		  ="pushup";

                    // $sms->save();
                }

                return redirect()->route('admin.job-offer.all-offers')->withMessage('Success! SMS sent successfully');
            } catch (\Exception $e) {
                return 'Error: ' . $e->getMessage();
            }
        }
    public function index(Request $request)
    {



        

        $paginationLimit = $request->input('pagination_limit', 50);

        $employees = User::whereIn('role_id', [3, 4])->orderBy('id', 'desc')->get();

        $all_jobs = JobOffer::where(function ($query) {
                                $query->whereNull('hire_date')
                                    ->orWhere('hire_date', '<=', now());
                            })
                            ->with(['parent', 'reference', 'applications', 'job_offer_tutor_categories', 'additionalChild'])
                            ->orderBy('id', 'desc')
                            ->paginate($paginationLimit);

        // dd($all_jobs->additionalChild);
        $smsLimit = SmsLimit::first();
        // dd($all_jobs);
        return view('backend.job_offers.all_offer', compact('all_jobs',
         'employees','smsLimit' , 'paginationLimit'));
    }
    public function scheduleOffer(Request $request)
    {





        $paginationLimit = $request->input('pagination_limit', 50);

        $employees = User::whereIn('role_id', [3, 4])->orderBy('id', 'desc')->get();

        $all_jobs = JobOffer::whereNotNull('hire_date')
                            ->where('hire_date', '>', now())
                            ->with(['parent', 'reference', 'applications', 'job_offer_tutor_categories', 'additionalChild'])
                            ->orderBy('id', 'desc')
                            ->paginate($paginationLimit);

        $smsLimit = SmsLimit::first();
        // dd($all_jobs);
        return view('backend.job_offers.schedule_offer', compact('all_jobs',
         'employees','smsLimit' , 'paginationLimit'));
    }

    public function additionalChildUpdate(Request $request)
    {

        $validator = Validator()->make($request->all(), [
            'gender'          => 'required',
            'institute_name'  => 'required',
            'category'        => 'required',
            'course'          => 'required',
            'subject'         => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $parent_id = $request->id;
            $updateChild = AdditionalChild::where('id', $parent_id)->first();

            // dd($request->all());

            if ($updateChild) {

                $updateChild->parent_id       = $request->parent_id;
                $updateChild->student_name    = $request->student_name;
                $updateChild->student_gender  = $request->gender;
                $updateChild->institute_name  = $request->institute_name;
                $updateChild->category_id     = $request->category;
                $updateChild->course_id       = $request->course;
                $updateChild->created_by      = auth()->user()->id;
                $updateChild->update();
                $updateChild->job_offer_additional_child_subjects()->sync($request->subject);

                return response()->json(['status' => true, 'message' => 'Job updated Successfully!', 'data' => $updateChild]);
            } else {
                $addChild = new AdditionalChild();
                $addChild->parent_id       = $request->parent_id;
                $addChild->student_name    = $request->name;
                $addChild->student_gender  = $request->gender;
                $addChild->institute_name  = $request->name;
                $addChild->category_id     = $request->category;
                $addChild->course_id       = $request->course;
                $addChild->created_by      = auth()->user()->id;
                $addChild->save();
                $addChild->job_offer_additional_child_subjects()->sync($request->subject);

                return response()->json(['status' => true, 'message' => 'Job updated Successfully!', 'data' => $updateChild]);
            }
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {


        $countries          = Country::orderBy('id', 'desc')->get();
        $cities             = City::orderBy('id', 'desc')->get();
        $locations          = Location::orderBy('id', 'desc')->get();
        $departments        = Department::orderBy('id', 'desc')->get();
        $categories         = Category::orderBy('id', 'desc')->get();
        $courses            = Course::orderBy('id', 'desc')->get();
        $courseSubjects     = CourseSubject::orderBy('id', 'desc')->get();
        $institutes         = Institute::orderBy('id', 'desc')->get();
        $teaching_methods   = TeachingMethod::orderBy('id', 'desc')->get();
        $subjects           = Subject::orderBy('id', 'desc')->get();
        $studies            = Study::orderBy('id', 'desc')->get();
        $curriculams        = Curriculam::orderBy('id', 'desc')->get();

        $job_id = $id;
        // $job_long_lat = JobOffer::

        $job = JobOffer::with([
            'tutorUniversity',
            'parent',
            'reference',
            'job_offer_tutor_categories',
            'job_offer_student_subjects',
            'job_offer_tutor_courses',
            'job_offer_tutor_departments',
            'job_offer_tutor_study_types',
            'job_offer_tutor_subjects',
            'job_offer_tutor_universities',
            'additional_child_info',

        ])->where('id', $job_id)->firstOrFail();


        if ($job->additional_child_info != null) {
            $xx = $job->additional_child_info->job_offer_additional_child_subjects;

        } else {
            $xx = 'null';
        }
        // dd($xx);
        // dd($job->additional_child_info->course_id);

        // return $xx;

        $additionChild = AdditionalChild::where('job_id',$job->id)->get();
        return view('backend.job_offers.job_edit', compact(
            'job',
            'countries',
            'departments',
            'categories',
            'departments',
            'courses',
            'institutes',
            'teaching_methods',
            'subjects',
            'studies',
            'curriculams',
            'cities',
            'locations',
            'courseSubjects',
            'xx',
            'additionChild'
        ));

        // dd($job);


    }
    // public function update(Request $request)
    // {


    //     $validator = Validator()->make($request->all(), [
    //         'student_gender'        => 'required',
    //         'category_id'           => 'required',
    //         'course_id'             => 'required',
    //         'subject_id'            => 'required',
    //         'days_in_week'          => 'required',
    //         'tutoring_time'         => 'required',
    //         'tutoring_duration'     => 'required',
    //         'teaching_method_id'    => 'required',
    //         'salary'                => 'required',
    //         'number_of_students'    => 'required',
    //         'country_id'            => 'required',
    //         'city_id'               => 'required',
    //         'location_id'           => 'required',
    //         'full_address'          => 'required',
    //         'lat_long'              => 'nullable',
    //         'tutor_requirement'     => 'required',
    //         'staff_note'            => 'required',
    //         'tutor_gender'          => 'required',

    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['status' => false, 'error' => $validator->errors()]);
    //     }
    //     try {

    //         $jobdata = $request->all();
    //         $id = $jobdata['job_id'];
    //         $job = JobOffer::where('id', $id)->firstOrFail();
    //         $job->parent_id = $request->parent_id;
    //         $job->student_name = $request->student_name;
    //         $job->student_gender = $request->student_gender;
    //         $job->institute_name = $request->institute_name;
    //         $job->category_id = $request->category_id;
    //         $job->course_id = $request->course_id;
    //         $job->days_in_week = $request->days_in_week;
    //         $job->tutoring_time = $request->tutoring_time;
    //         $job->tutoring_duration = $request->tutoring_duration;
    //         $job->teaching_method_id = $request->teaching_method_id;
    //         $job->salary = $request->salary;
    //         $job->number_of_students = $request->number_of_students;
    //         $job->country_id = $request->country_id;
    //         $job->city_id = $request->city_id;
    //         $job->location_id = $request->location_id;
    //         $job->full_address = $request->full_address;
    //         $job->lat_long = $request->lat_long;
    //         $job->tutor_requirement = $request->tutor_requirement;
    //         $job->special_note = $request->special_note;
    //         $job->staff_note = $request->staff_note;
    //         $job->tutor_religion = $request->tutor_religion;
    //         $job->tutor_gender = $request->tutor_gender;
    //         $job->tutor_university_type = $request->tutor_university_type;
    //         $job->year = $request->year;
    //         $job->tutor_school_id = $request->tutor_school_id;
    //         $job->tutor_college_id = $request->tutor_college_id;
    //         $job->tutor_board = $request->tutor_board;
    //         $job->tutor_group = $request->tutor_group;
    //         $job->tutor_curriculam_id = $request->tutor_curriculam_id;
    //         $job->date = $request->date;
    //         if($request->is_sms == ''){
    //             $job->is_sms_send = 0;
    //         }
    //         else{
    //             $job->is_sms_send = $request->is_sms;
    //         }
    //         $job->created_by = $job->created_by;
    //         $job->update();
    //         $job->job_offer_subject()->sync($request->subject_id);
    //         $job->job_offer_tutor_categories()->sync($request->tutoring_category_id);
    //         $job->job_offer_tutor_courses()->sync($request->tutor_course_id);
    //         $job->job_offer_tutor_subjects()->sync($request->tutor_subject_id);
    //         $job->job_offer_tutor_universities()->sync($request->tutor_university_id);
    //         $job->job_offer_tutor_study_types()->sync($request->tutor_study_type_id);
    //         $job->job_offer_tutor_departments()->sync($request->tutor_department_id);



    //         $jobLog = new JobEditLog();
    //         $jobLog->job_id = $job->id;
    //         $jobLog->parent_id          = $request->parent_id;
    //         $jobLog->student_name       = $request->student_name;
    //         $jobLog->student_gender     = $request->student_gender;
    //         $jobLog->institute_name     = $request->institute_name;
    //         $jobLog->category_id        = $request->category_id;
    //         $jobLog->course_id          = $request->course_id;
    //         $jobLog->days_in_week       = $request->days_in_week;
    //         $jobLog->tutoring_time      = $request->tutoring_time;
    //         $jobLog->tutoring_duration  = $request->tutoring_duration;
    //         $jobLog->teaching_method_id = $request->teaching_method_id;
    //         $jobLog->salary             = $request->salary;
    //         $jobLog->number_of_students = $request->number_of_students;
    //         $jobLog->country_id         = $request->country_id;
    //         $jobLog->city_id            = $request->city_id;
    //         $jobLog->location_id        = $request->location_id;
    //         $jobLog->full_address       = $request->full_address;
    //         $jobLog->lat_long           = $request->lat_long;
    //         $jobLog->tutor_requirement  = $request->tutor_requirement;
    //         $jobLog->special_note       = $request->special_note;
    //         $jobLog->staff_note         = $request->staff_note;
    //         $jobLog->tutor_religion     = $request->tutor_religion;
    //         $jobLog->tutor_gender       = $request->tutor_gender;
    //         $jobLog->tutor_university_type = $request->tutor_university_type;
    //         $jobLog->year               = $request->year;
    //         $jobLog->tutor_school_id    = $request->tutor_school_id;
    //         $jobLog->tutor_college_id   = $request->tutor_college_id;
    //         $jobLog->tutor_board = $request->board;
    //         $jobLog->tutor_group = $request->group;
    //         $jobLog->tutor_curriculam_id = $request->tutor_curriculam_id;
    //         $jobLog->date = $request->date;
    //         $job->is_sms_send = $request->is_sms;
    //         // $jobLog->created_by = auth()->user()->id;





    //         if($request->subject_id == ''){
    //             $jobLog->subject_id =$request->subject_id;
    //         }
    //         else{
    //             $jobLog->subject_id = implode(',',$request->subject_id);

    //         }

    //         if($request->tutoring_category_id == ''){
    //             $jobLog->tutoring_category_id =$request->tutoring_category_id;
    //         }
    //         else{
    //             $jobLog->tutoring_category_id = implode(',',$request->tutoring_category_id);

    //         }

    //         if($request->tutor_subject_id == ''){
    //             $jobLog->tutor_subject_id =$request->tutor_subject_id;
    //         }
    //         else{
    //             $jobLog->tutor_subject_id = implode(',',$request->tutor_subject_id);

    //         }

    //         if($request->tutor_course_id == ''){
    //             $jobLog->tutor_course_id =$request->tutor_course_id;
    //         }
    //         else{
    //             $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);

    //         }



    //         if($request->tutor_course_id == ''){
    //             $jobLog->tutor_course_id =$request->tutor_course_id;
    //         }
    //         else{
    //             $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);

    //         }

    //         if($request->tutor_course_id == ''){
    //             $jobLog->tutor_course_id =$request->tutor_course_id;
    //         }
    //         else{
    //             $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);

    //         }

    //         if($request->tutor_university_id == ''){
    //             $jobLog->tutor_university_id =$request->tutor_university_id;
    //         }
    //         else{
    //             $jobLog->tutor_university_id = implode(',',$request->tutor_university_id);

    //         }


    //         if($request->tutor_study_type_id == ''){
    //             $jobLog->tutor_study_type_id =$request->tutor_study_type_id;
    //         }
    //         else{
    //             $jobLog->tutor_study_type_id = implode(',',$request->tutor_study_type_id);

    //         }

    //         if($request->tutor_department_id == ''){
    //             $jobLog->tutor_department_id =$request->tutor_department_id ;
    //         }
    //         else{
    //             $jobLog->tutor_department_id = implode(',', $request->tutor_department_id);

    //         }

    //         $jobLog->save();




    //         return response()->json(['status' => true, 'message' => 'job updated Successfully!', 'data' => $job]);
    //     } catch (QueryException $e) {
    //         return redirect()->back()->withInput()->withErrors($e->getMessage());
    //     }
    // }

    public function update(Request $request)
    {

        $validator = Validator()->make($request->all(), [
            'student_gender'        => 'required',
            'category_id'           => 'required',
            'course_id'             => 'required',
            'subject_id'            => 'required',
            'days_in_week'          => 'required',
            'tutoring_time'         => 'required',
            'tutoring_duration'     => 'required',
            'teaching_method_id'    => 'required',
            'salary'                => 'required',
            'number_of_students'    => 'required',
            'country_id'            => 'required',
            'city_id'               => 'required',
            'location_id'           => 'required',
            'full_address'          => 'required',
            'lat'              => 'nullable',
            'long'              => 'nullable',
            'tutor_requirement'     => 'required',
            'staff_note'            => 'required',
            'tutor_gender'          => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $job = JobOffer::findOrFail($request->job_id);

            $oldValues = $job->toArray();
            $job->hire_date = $request->hire_date;
            $job->parent_id = $request->parent_id;
            $job->student_name = $request->student_name;
            $job->student_gender = $request->student_gender;
            $job->institute_name = $request->institute_name;
            $job->category_id = $request->category_id;
            $job->course_id = $request->course_id;
            $job->days_in_week = $request->days_in_week;
            $job->tutoring_time = $request->tutoring_time;
            $job->tutoring_duration = $request->tutoring_duration;
            $job->teaching_method_id = $request->teaching_method_id;
            $job->salary = $request->salary;
            $job->number_of_students = $request->number_of_students;
            $job->country_id = $request->country_id;
            $job->city_id = $request->city_id;
            $job->location_id = $request->location_id;
            $job->full_address = $request->full_address;
            $job->lat = $request->lat;
            $job->long = $request->long;
            $job->tutor_requirement = $request->tutor_requirement;
            $job->special_note = $request->special_note;
            $job->staff_note = $request->staff_note;
            $job->tutor_religion = $request->tutor_religion;
            $job->tutor_gender = $request->tutor_gender;
            $job->tutor_university_type = $request->tutor_university_type;
            $job->year = $request->year;
            $job->tutor_school_id = $request->tutor_school_id;
            $job->tutor_college_id = $request->tutor_college_id;
            $job->tutor_board = $request->tutor_board;
            $job->tutor_group = $request->tutor_group;
            $job->tutor_curriculam_id = $request->tutor_curriculam_id;
            $job->date = $request->date;
            if($request->is_sms == ''){
                $job->is_sms_send = 0;
            }
            else{
                $job->is_sms_send = $request->is_sms;
            }
            $job->created_by = $job->created_by;
            $job->update();
            $job->job_offer_subject()->sync($request->subject_id);
            $job->job_offer_tutor_categories()->sync($request->tutoring_category_id);
            $job->job_offer_tutor_courses()->sync($request->tutor_course_id);
            $job->job_offer_tutor_subjects()->sync($request->tutor_subject_id);
            $job->job_offer_tutor_universities()->sync($request->tutor_university_id);
            $job->job_offer_tutor_study_types()->sync($request->tutor_study_type_id);
            $job->job_offer_tutor_departments()->sync($request->tutor_department_id);

            $updatedValues = $job->toArray();

            $changedValues = array_diff_assoc($updatedValues, $oldValues);

            $jobLog = new JobEditLog();
            $jobLog->job_id = $job->id;
            $jobLog->updated_by = Auth::user()->id;

            if (!empty($subjectChanges['subject_removed'])) {
                $jobLog->subject_removed = implode(',', $subjectChanges['subject_removed']);
            }

            if (!empty($subjectChanges['subject_added'])) {
                $jobLog->subject_added = implode(',', $subjectChanges['subject_added']);
            }

            foreach ($changedValues as $field => $value) {
                $jobLog->$field = $value;
            }

            $jobLog->save();


            return response()->json(['status' => true, 'message' => 'Job updated successfully!', 'data' => $job]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }



    public function jobDetails($job)
    {





        $job_edit_log = JobEditLog::where('job_id', $job)
            ->orderBy('id', 'desc')
            ->get();
        $job_created_log = JobOfferLog::where('job_id', $job)->firstOrFail();


        $job = JobOffer::with([
            'tutorUniversity',
            'parent',
            'reference',
            'job_offer_tutor_categories',
            'job_offer_student_subjects',
            'job_offer_tutor_courses',
            'job_offer_tutor_departments',
            'job_offer_tutor_study_types',
            'job_offer_tutor_universities',
            'job_offer_tutor_subjects',
            'additional_child_info',
            'job_offer_additional_child_subjects'
        ])->where('id', $job)->firstOrFail();



        if ($job->additional_child_info != null) {
            $xx = $job->additional_child_info->job_offer_additional_child_subjects;
        } else {
            $xx = 'null';
        }

        $additionChild = AdditionalChild::where('job_id',$job->id)->get();
        // dd($additionChild->job_offer_student_subjects);

        $source = LeadSource::where('job_id',$job->id)->first();



        return view('backend.job_offers.job_details', compact('source','job', 'xx','job_edit_log','job_created_log','additionChild'));
    }

    public function seeCondition($id=null)
    {
        $job_applications = JobApplication::with(['tutor', 'user','parent'])
        ->where('job_offer_id', $id)
        ->whereNotNull('current_stage')
        ->orderBy('id', 'desc')
        ->paginate(50);

        $job_application_note = AppliedTutorNote::where('job_application_id',$id)->get();
        return view('backend.job_offers.see_condition',compact('job_applications','job_application_note'));
    }
    public function restoreCondition($id)
    {
        $job_application = JobApplication::where('id', $id)->first();

        $takenId = $job_application->taken_by_id;

        $jobOffer = JobOffer::where('id',$job_application->job_offer_id)->first();

        if($jobOffer->taken_by_1 == $takenId)
        {
            $jobOffer->taken_by_1      = null;
            $jobOffer->taken_by_1_date = null;
            $jobOffer->update();

        }elseif($jobOffer->taken_by_2 == $takenId)
        {
            $jobOffer->taken_by_2      = null;
            $jobOffer->taken_by_2_date = null;
            $jobOffer->update();

        }


        return redirect()->back()->withMessage('Restore Successful');


    }

    public function smsLog($job)
    {

        $job_sms = JobSms::where('job_id', $job)->orderby('id' , 'desc')->paginate(15);

        // dd($job_sms->toArray());
        return view('backend.job_offers.sms_log', compact('job_sms'));
    }

    public function statusLog($id)
    {
        $status = JobStatus::where('job_id',$id)->get();

        return view('backend.job_offers.status_log',compact('status'));
    }

    public function searchTutor(Request $request)
    {

         $id = $request->job_id;

        $job_offer = JobOffer::with([
            'job_offer_tutor_universities',
            'job_offer_tutor_departments',
            'job_offer_tutor_study_types'
        ])->findOrFail($id);



        $tutorSms1 = Sms::where('job_id', $id)->pluck('phone');
        $tutorSms2 = JobSms::where('job_id', $id)->pluck('tutor_phone');

        $tutorSmsU = $tutorSms1->merge($tutorSms2);

        $tutor_sms = $tutorSmsU->unique();



        $smsLimit = SmsLimit::first();
        $all_sms_number = Sms::where('job_id', $id)->count();

        $tutor_university = $job_offer->job_offer_tutor_universities->pluck('id')->implode(',');
        $tutor_department = $job_offer->job_offer_tutor_departments->pluck('id')->implode(',');
        $tutor_study = $job_offer->job_offer_tutor_study_types->pluck('id')->implode(',');
        $tutor_gender = $job_offer->tutor_gender;


        // return  $tutor_study;
        // Retrieve tutors based on specified criteria
        $tutors_ids = Tutor::with(['tutor_personal_info', 'tutor_education', 'tutor_prefered_locations'])
            ->when($job_offer->tutor_gender !== 'any', function ($query) use ($job_offer) {
                $query->where('gender', $job_offer->tutor_gender);
            })
            ->whereHas('tutor_personal_info', function ($query) use ($job_offer) {
                $query->where('country_id', $job_offer->country_id)
                    ->when(!empty($job_offer->city_id), function ($query) use ($job_offer) {
                        $query->where('city_id', $job_offer->city_id);
                    })

                     ->when(!empty($job_offer->tutor_religion), function ($query) use ($job_offer) {
                        $query->where('religion', $job_offer->tutor_religion);
                    });
            })
            ->when(!empty($job_offer->location_id), function ($query) use ($job_offer) {
                $query->whereHas('tutor_prefered_locations', function ($subQuery) use ($job_offer) {
                    $subQuery->where('location_id', $job_offer->location_id);
                });
            })
            ->when(!empty($job_offer->tutor_group), function ($query) use ($job_offer) {
                $query->whereHas('tutor_education', function ($subQuery) use ($job_offer) {
                    $subQuery->where(function ($subSubQuery) use ($job_offer) {
                        $subSubQuery->where('group_or_major', $job_offer->tutor_group)
                            ->where('degree_name', 'ssc');
                    })->orWhere(function ($subSubQuery) use ($job_offer) {
                        $subSubQuery->where('group_or_major', $job_offer->tutor_group)
                            ->where('degree_name', 'hsc');
                    });
                });
            })
            ->when(!empty($tutor_university), function ($query) use ($tutor_university) {
                $query->whereHas('tutor_education', function ($subQuery) use ($tutor_university) {
                    $subQuery->whereIn('institute_id', explode(',', $tutor_university))
                        ->where('degree_name', 'honours');
                });
            })
            ->when(!empty($job_offer->tutor_university_type), function ($query) use ($job_offer) {
                $query->whereHas('tutor_education', function ($subQuery) use ($job_offer) {
                    $subQuery->whereIn('university_type', explode(',', $job_offer->tutor_university_type))
                        ->where('degree_name', 'honours');
                });
            })
            ->when(!empty($tutor_department), function ($query) use ($tutor_department) {
                $query->whereHas('tutor_education', function ($subQuery) use ($tutor_department) {
                    $subQuery->whereIn('department_id', explode(',', $tutor_department))
                        ->where('degree_name', 'honours');
                });
            })
            ->when(!empty($tutor_study), function ($query) use ($tutor_study) {
                $query->whereHas('tutor_education', function ($subQuery) use ($tutor_study) {
                    $subQuery->whereIn('study_type_id', explode(',', $tutor_study))
                        ->where('degree_name', 'honours');
                });
            })
            ->when(!empty($job_offer->tutor_curriculam_id), function ($query) use ($job_offer) {
                $query->whereHas('tutor_education', function ($subQuery) use ($job_offer) {
                    $subQuery->where('curriculum_id', $job_offer->tutor_curriculam_id);
                });
            })

            ->pluck('id');


            // return $tutors_ids;



            if (count($tutors_ids) == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tutor not found',
                ]);
            }

            // $t_id = [];
            // foreach ($tutors_ids as $key => $tutor_id) {
            //     $t_id[$key] = $tutor_id->id;
            // }
             $t_id = $tutors_ids;




         if($request->types == 'Premium_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('is_premium', 1)
            ->where('is_active',1)
            ->take($smsLimit->premium)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }
            else{

                $tutorsWithEducation = $tutors->map(function ($tutor) {

                  $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
            }
                   return [
                'tutor_name'           => $tutor->name  ?? null,
                'tutor_id'             => $tutor->id ?? null,
                'is_premium' => $tutor->is_premium ?? null,
                'is_verified' => $tutor->is_verified ?? null,
                'tutor_phone'          => $tutor->phone ?? null,
                'tutor_education'      => $educationTitle ?? null,
                'tutor_dept' =>        $educationDept ?? null,
                'tutor_personal_info'  => $tutor->tutor_personal_info ?? null,
                'tutor_location'      => $tutor->tutor_personal_info->location->name ?? null,
                'tutor_city'      => $tutor->tutor_personal_info->city->name ?? null,


            ];
                });



                 return response()->json([
                'status' => true,
                'tutors' => $tutorsWithEducation,
                'tutor_sms' =>$tutor_sms,
                'job_id' =>$id,
                'all_tutors' =>$tutors,
                'requestType' => $request->types,


            ]);



            }
         }
         if($request->types == 'Latest_created_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->orderBy('created_at', 'desc')
            ->where('is_active',1)
            ->take($smsLimit->latest_created_input)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }

            else{

            $tutorsWithEducation = $tutors->map(function ($tutor) {

               $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
        }
                return [
                    'tutor_name' => $tutor->name,
                    'tutor_id' => $tutor->id,
                     'is_premium' => $tutor->is_premium,
                     'is_verified' => $tutor->is_verified,
                    'tutor_phone' => $tutor->phone,
                    'tutor_education' => $educationTitle,
                    'tutor_dept' => $educationDept,

                    'tutor_personal_info' => $tutor->tutor_personal_info,
                    'tutor_location'      => $tutor->tutor_personal_info->location->name,
                    'tutor_city'      => $tutor->tutor_personal_info->city->name,

                ];
            });


            return response()->json([
                'status' => true,
                'tutors' => $tutorsWithEducation,
                'tutor_sms' =>$tutor_sms,
                'job_id' =>$id,
                'all_tutors' =>$tutors,
                'requestType' => $request->types,


            ]);


        }

         }
         if($request->types == 'Random_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
              ->where('created_at', '>', '2023-01-01 00:00:00')
              ->where('is_active', 1)
              ->where('is_sms', 1)
              ->inRandomOrder() // Add this line to get random order
              ->take($smsLimit->random)
              ->get();

            if (count($tutors) == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tutor not found',
                ]);
            } else {
                $tutorsWithEducation = $tutors->map(function ($tutor) {
                   $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
                    }
                    return [
                        'tutor_name' => $tutor->name,
                        'is_premium' => $tutor->is_premium,
                         'is_verified' => $tutor->is_verified,
                        'tutor_id' => $tutor->id,
                        'tutor_phone' => $tutor->phone,
                        'tutor_education' => $educationTitle,
                        'tutor_dept' => $educationDept,

                        'tutor_personal_info' => $tutor->tutor_personal_info,
                        'tutor_location'      => $tutor->tutor_personal_info->location->name,
                        'tutor_city'      => $tutor->tutor_personal_info->city->name,

                    ];
                });

                return response()->json([
                    'status' => true,
                    'tutors' => $tutorsWithEducation,
                    'tutor_sms' => $tutor_sms,
                    'job_id' =>$id,
                    'requestType' => $request->types,

                ]);
            }
        }


         if($request->types == '2nd_latest_created_tutor'){




           $latest_tutors = Tutor::orderBy('created_at', 'desc')
                ->take(30)
                ->pluck('id');

            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])
            ->whereIn('id', $t_id)
            ->where('is_active', 1)
            ->where('is_sms', 1)
            ->whereNotIn('id', $latest_tutors)
            ->orderBy('created_at', 'desc')
            ->take($smsLimit->second_latest_created)
            ->get();



            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }


            $tutorsWithEducation = $tutors->map(function ($tutor) {

                $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
        }
                return [
                    'tutor_name' => $tutor->name,
                     'is_premium' => $tutor->is_premium,
                     'is_verified' => $tutor->is_verified,
                    'tutor_id' => $tutor->id,
                    'tutor_phone'          => $tutor->phone,
                    'tutor_education' => $educationTitle,
                    'tutor_dept' => $educationDept,

                    'tutor_personal_info' => $tutor->tutor_personal_info,
                    'tutor_location'      => $tutor->tutor_personal_info->location->name,
                    'tutor_city'      => $tutor->tutor_personal_info->city->name,

                ];
            });


            return response()->json([
                'status' => true,
                'tutors' => $tutorsWithEducation,
                'tutor_sms' =>$tutor_sms,
                'job_id' =>$id,
                'requestType' => $request->types,

            ]);



         }


         if($request->types == 'Bottom_tutor'){
             $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('is_active',1)
             ->orderBy('created_at', 'asc')

            ->take($smsLimit->second_bottom)

            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }
            else{

                $tutorsWithEducation = $tutors->map(function ($tutor) {
             $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
            }
                    return [
                        'tutor_name' => $tutor->name,
                        'tutor_id' => $tutor->id,
                         'is_premium' => $tutor->is_premium,
                        'is_verified' => $tutor->is_verified,
                        'tutor_education' => $educationTitle,
                        'tutor_dept' => $educationDept,
                        'tutor_phone'          => $tutor->phone,
                        'tutor_personal_info' => $tutor->tutor_personal_info,
                       'tutor_location'      => $tutor->tutor_personal_info->location->name,
                       'tutor_city'      => $tutor->tutor_personal_info->city->name,

                    ];
                });


                return response()->json([
                    'status' => true,
                    'tutors' => $tutorsWithEducation,
                    'tutor_sms' =>$tutor_sms,
                    'job_id' =>$id,
                    'requestType' => $request->types,

                ]);


            }
         }

         if($request->types == '2nd_bottom_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('created_at', '<', '2022-01-01 00:00:00')
            ->where('is_active',1)
            ->take($smsLimit->second_bottom)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }
            else{


                $tutorsWithEducation = $tutors->map(function ($tutor) {

                $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
            }
                    return [
                        'tutor_name' => $tutor->name,
                        'tutor_id' => $tutor->id,
                         'is_premium' => $tutor->is_premium,
                        'is_verified' => $tutor->is_verified,
                        'tutor_education' => $educationTitle,
                        'tutor_dept' => $educationDept,
                        'tutor_phone'          => $tutor->phone,
                        'tutor_personal_info' => $tutor->tutor_personal_info,
                         'tutor_location'      => $tutor->tutor_personal_info->location->name,
                         'tutor_city'      => $tutor->tutor_personal_info->city->name,

                    ];
                });


                return response()->json([
                    'status' => true,
                    'tutors' => $tutorsWithEducation,
                    'tutor_sms' =>$tutor_sms,
                    'job_id' =>$id,
                    'requestType' => $request->types,

                ]);


            }
         }

         $tutors = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
        ])->whereIn('id', $t_id)
        ->where('is_active',1)
        ->take(200)
        ->get();

         $countTutor = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
        ])->whereIn('id', $t_id)
        ->where('is_active',1)
        ->count();



        //  $tAduTotalElements = count($tutors->tutor_education);

        //  $tutors['university'] = $tutors->tutor_education[$tAduTotalElements - 1]->institutes->title;


        $tutorsWithEducation = $tutors->map(function ($tutor) {

            $educationTitle = '';
            $educationDept = '';

        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
         if ($lastEducation->departments) {
            $educationDept = $lastEducation->departments->title;
        }
    }
           return [
                'tutor_name'           => $tutor->name  ?? null,
                'tutor_id'             => $tutor->id ?? null,
                'is_premium' => $tutor->is_premium ?? null,
                'is_verified' => $tutor->is_verified ?? null,
                'tutor_phone'          => $tutor->phone ?? null,
                'tutor_education'      => $educationTitle ?? null,
                'tutor_dept' =>        $educationDept ?? null,
                'tutor_personal_info'  => $tutor->tutor_personal_info ?? null,
                'tutor_location'      => $tutor->tutor_personal_info->location->name ?? null,
                'tutor_city'      => $tutor->tutor_personal_info->city->name ?? null,


            ];
        });


        return response()->json([
            'status' => true,
            'tutors' => $tutorsWithEducation,
            'tutor_sms' =>$tutor_sms,
            'count' => $countTutor,
            'all_sms_number'=>$all_sms_number,
            'job_id' =>$id,
            'requestType' => $request->types,


        ]);



    }
    public function smsView($id)
    {

        $sms_content = JobSms::where('id',$id)->first();

        // dd($sms_content);

        // dd($sms_content);

        return view('backend.job_offers.sms_view',compact('sms_content'));
    }
    public function editHistoryDetails(Request $request, $id)
    {

        $jobId = $request->query('job_id');
        $job = JobOffer::with([
            'tutorUniversity',
            'parent',
            'reference',
            'job_offer_tutor_categories',
            'job_offer_student_subjects',
            'job_offer_tutor_courses',
            'job_offer_tutor_departments',
            'job_offer_tutor_study_types',
            'job_offer_tutor_universities',
            'job_offer_tutor_subjects',
            'additional_child_info',
            'job_offer_additional_child_subjects'
        ])->where('id',$jobId)->firstOrFail();

        $job_edit_log = JobEditLog::where('id',$id)->firstOrFail();


        if ($job->additional_child_info != null) {
            $xx = $job->additional_child_info->job_offer_additional_child_subjects;
        } else {
            $xx = 'null';
        }

        return view('backend.job_offers.job_edit_history',compact('job','xx','job_edit_log'));
    }

    public function jobLogDetails(Request $request, $id)
    {

        $job = JobOfferLog::with([
            'tutorUniversity',
            'parent',
            'reference',
            'job_offer_tutor_categories',
            'job_offer_student_subjects',
            'job_offer_tutor_courses',
            'job_offer_tutor_departments',
            'job_offer_tutor_study_types',
            'job_offer_tutor_universities',
            'job_offer_tutor_subjects',
            'additional_child_info',
            'job_offer_additional_child_subjects'
        ])->where('job_id',$id)->firstOrFail();

        // $job_edit_log = JobEditLog::where('id',$id)->firstOrFail();


        if ($job->additional_child_info != null) {
            $xx = $job->additional_child_info->job_offer_additional_child_subjects;
        } else {
            $xx = 'null';
        }

        return view('backend.job_offers.job_log',compact('job','xx'));
    }


    public function changeStatus(Request $request)
    {


        $job_offer            = JobOffer::find($request->id);
        $job_offer->is_active = $job_offer->is_active === 1 ? 0 : 1;


        if($job_offer->hire_date == Null || $job_offer->schedule_posted !== null)
        {
            if($job_offer->is_active == 0)
            {
                $job_offer->live_off_date = now();

            }

            $job_offer->save();

            $status = new JobStatus();
            $status->job_id     = $job_offer->id;
            $status->status     = $job_offer->is_active;
            $status->updated_by = Auth::user()->name;
            $status->save();


            return response()->json(['status'=>'success','message'=> 'Job Offer Status Change']);

        }elseif($job_offer->hire_date > now() && $job_offer->schedule_posted == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot change the status now.'
            ]);
        }


    }


    public function jobSearch(Request $request)
    {
        $searchCriteria = $request->input('job_search');
        $paginationLimit = $request->input('pagination_limit', 50);

        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);

        $query = "SELECT id FROM job_offers WHERE $searchCriteria";

        try {
            $jobIds = DB::select($query);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $jobIds = array_column($jobIds, 'id');

        $employees = User::whereIn('role_id', [3, 4])->orderBy('id', 'desc')->get();


        $all_jobs = JobOffer::with(['parent', 'reference', 'applications','additionalChild'])
            ->whereIn('id', $jobIds)
            ->orderBy('id', 'asc')
            ->paginate($paginationLimit);

        $all_jobs->appends(['job_search' => $searchCriteria]);

        $uniqueJobsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueJobsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();


        return view('backend.job_offers.all_offer', compact('all_jobs', 'employees', 'paginationLimit','uniqueJobsShortlistedToday','uniqueJobsTakenToday'));
    }

    public function jobSearchSingleAvailable(Request $request)
    {

        $paginationLimit = $request->input('pagination_limit', 50);

        $searchTerm = $request->search;

        $isPhoneNumber = preg_match('/^\d{10}$/', $searchTerm);

        $employees = User::whereIn('role_id', [3, 4])->orderBy('id', 'desc')->get();


        $smsLimit = SmsLimit::first();
        $all_jobs = JobOffer::with(['parent', 'reference', 'applications'])
            ->when($isPhoneNumber, function ($query) use ($searchTerm) {
                return $query->whereHas('parent', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('phone', $searchTerm);
                });
            }, function ($query) use ($searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('id', $searchTerm)
                            ->orWhereHas('parent', function ($innerSubQuery) use ($searchTerm) {
                                $innerSubQuery->where('phone', $searchTerm);
                            });
                });
            })
            ->orderBy('id', 'desc')
            ->where('is_active',1)
            ->paginate(10);

            $uniqueJobsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueJobsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();

        return view('backend.job_offers.all_offer', compact('all_jobs', 'employees','smsLimit' ,'paginationLimit','uniqueJobsShortlistedToday','uniqueJobsTakenToday'));
    }
    public function jobSearchSingleAll(Request $request)
    {


        $paginationLimit = $request->input('pagination_limit', 50);

        $searchTerm = $request->search;

        $isPhoneNumber = preg_match('/^\d{10}$/', $searchTerm);

        $employees = User::whereIn('role_id', [3, 4])->orderBy('id', 'desc')->get();

        $smsLimit = SmsLimit::first();

        $all_jobs = JobOffer::with(['parent', 'reference', 'applications'])
            ->when($isPhoneNumber, function ($query) use ($searchTerm) {
                return $query->whereHas('parent', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('phone', $searchTerm);
                });
            }, function ($query) use ($searchTerm) {
                $query->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('id', $searchTerm)
                            ->orWhereHas('parent', function ($innerSubQuery) use ($searchTerm) {
                                $innerSubQuery->where('phone', $searchTerm);
                            });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
            $uniqueJobsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueJobsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();

        return view('backend.job_offers.all_offer', compact('all_jobs', 'employees','smsLimit', 'paginationLimit','uniqueJobsShortlistedToday','uniqueJobsTakenToday'));
    }


    public function smsLimit(Request $request)
    {
        try {


            $validatedData = $request->validate([
                'latest_created_input' => 'required|numeric',
                'second_latest_created' => 'required|numeric',
                'random' => 'required|numeric',
                'bottom' => 'required|numeric',
                'second_bottom' => 'required|numeric',
                'premium' => 'required|numeric',
                'send_sms_range' => 'required|numeric',
            ]);

            $smsLimit = SmsLimit::first();

            if (!$smsLimit) {
                $smsLimit = new SmsLimit();
            }

            $smsLimit->latest_created_input = $validatedData['latest_created_input'];
            $smsLimit->second_latest_created = $validatedData['second_latest_created'];
            $smsLimit->random = $validatedData['random'];
            $smsLimit->bottom = $validatedData['bottom'];
            $smsLimit->second_bottom = $validatedData['second_bottom'];
            $smsLimit->premium = $validatedData['premium'];
            $smsLimit->send_sms_range = $validatedData['send_sms_range'];

            $smsLimit->save();

            return redirect()->back()->withMessage('Limit Saved Successful');
        } catch (\Exception $e) {
            \Log::error($e);

            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }


    public function jobSmsDelete(Request $request)
    {
        try {
            $jobId = $request->job_id;

            $smsDelete = Sms::where('job_id', $jobId)->delete();

            return redirect()->back()->withMessage('Sms Record Delete Successful');
        } catch (\Exception $e) {
            \Log::error($e);

            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }

    public function smsEditor(Request $request)
    {
        // dd($request->all());
        $ids     = $request['all_id'];
        $myArray = explode(',', $ids);
        $tutors = Parents::whereIn('id', $myArray)
                ->where('is_sms', 1)
                ->get();


        $errorTutorId = null;

        $phonenumbers = [];

        foreach ($tutors as $utor) {
            if ($utor->is_sms == 1) {
                $phonenumbers[] = $utor->phone;
            } else {
                $errorTutorId = $utor->id;
            }
        }

        if ($errorTutorId !== null) {
            return response()->json(['send-sms-status' => false, 'error' => 'Please Activate Sms Status for Tutor ID: ' . $errorTutorId]);
        }

        $numbers = implode(',', $phonenumbers);

        return view('backend.tutor.smsEditor', compact('numbers', 'tutors'));
    }



    public function jobCounting()
    {

        $uniqueJobsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueJobsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();


        return view('backend.job_offers.job_counting',compact('uniqueJobsShortlistedToday','uniqueJobsTakenToday'));
    }



}