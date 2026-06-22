<?php

namespace App\Http\Controllers\Backend\JobOffer;

use App\Http\Controllers\Controller;
use App\Jobs\SendSmsJob;
use App\Models\Admin\AdditionalChild;
use App\Models\AppliedTutorNote;
use Illuminate\Http\Request;
use App\Models\Parents;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Curriculam;
use App\Models\Department;
use App\Models\FnfLead;
use App\Models\Institute;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\jobOfferLog;
use App\Models\JobSms;
use App\Models\TutorTeachingMethod;
use App\Models\Location;
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


class AllJobOfferController extends Controller
{


    public function matchRate(Request $request){

        return $request;




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
        $job_with_value['full_address'] = $job->full_address;
        $job_with_value['salary'] = $job->salary;
        $job_with_value['duration'] = $job->tutoring_duration;
        $job_with_value['time'] = $job->tutoring_time;



        // return $job_with_value;



        return response()->json([
            'status'=>true,
            'template'=>$template,
            'job' =>$job_with_value,
        ]);


    }


    public function tutorSms(Request $request)
    {


        $job_id = $request->sms_job_id;

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
        return view('backend.job_offers.sms_editor', compact('templates','job_id','tutors','ids','numbers'));

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
            $url = 'https://easybulksmsbd.com/sms/api?action=send-sms&api_key=VHVpdGlvbiBUZXJtaW5hbDoxMjM0NTY3&to=88' . $phoneNumber . '&from=SenderID&sms=' . urlencode($message);

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
        $tutorId = $request->tutors_id;
        
        $tutorNumbers = is_array($request->tutor_numbers) ? $request->tutor_numbers : [$request->tutor_numbers];
        
        $smsBody = $request->sms_body;
        $jobId = $request->job_id;
        $titleId = $request->title_id;

        $result = Artisan::call('tutor:sms-send', [
            'tutors_id' => $tutorId,
            'tutor_numbers' => implode(',', $tutorNumbers),
            'sms_body' => $smsBody,
            'job_id' => $jobId,
            'title_id' => $titleId,
        ]);

        if ($result === 0) {
            return redirect()->route('admin.job-offer.all-offers')->withMessage('Success! SMS sending job dispatched to the queue.');
        } else {
            return redirect()->route('admin.job-offer.all-offers')->with('error', 'Failed to dispatch SMS sending job.');
        }
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
}
    public function index()
    {

        $employees  = User::where('role_id', 2)->orderBy('id', 'desc')->get();

        $all_jobs   = JobOffer::with(['parent', 'reference','applications'])->orderBy('id', 'desc')->paginate(50);


        return view('backend.job_offers.all_offer', compact('all_jobs',
         'employees' ));
    }

    public function additionalChildUpdate(Request $request)
    {

        // dd($request->toArray());
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
            $parent_id = $request->parent_id;
            $updateChild = AdditionalChild::where('id', $parent_id)->first();

            // dd($updateChild);

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

                return response()->json(['status' => true, 'message' => 'job updated Successfully!', 'data' => $updateChild]);
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

                return response()->json(['status' => true, 'message' => 'job updated Successfully!', 'data' => $updateChild]);
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
            // 'lat_long',
        ])->where('id', $job_id)->firstOrFail();
        // dd($job);

        if ($job->additional_child_info != null) {
            $xx = $job->additional_child_info->job_offer_additional_child_subjects;

        } else {
            $xx = 'null';
        }
        // dd($xx);
        // dd($job->additional_child_info->course_id);

        // return $xx;
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
            'xx'
        ));

        // dd($job);


    }
    public function update(Request $request)
    {


        //   dd($request->toArray());

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
            'lat_long'              => 'nullable',
            'tutor_requirement'     => 'required',
            'staff_note'            => 'required',
            'tutor_gender'          => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        try {

            $jobdata = $request->all();
            // dd($tutordata);
            $id = $jobdata['job_id'];
            $job = JobOffer::where('id', $id)->firstOrFail();

            // $job = new JobOffer();
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
            $job->lat_long = $request->lat_long;
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




            // $jobLog= jobOfferLog::where('id', $id)->firstOrFail();
            // $jobLog->job_id = $job->id;
            // $jobLog->parent_id = $request->parent_id;
            // $jobLog->student_name = $request->student_name;
            // $jobLog->student_gender = $request->student_gender;
            // $jobLog->institute_name = $request->institute_name;
            // $jobLog->category_id = $request->category_id;
            // $jobLog->course_id = $request->course_id;
            // $jobLog->subject_id = implode(',',$request->subject_id);
            // $jobLog->days_in_week = $request->days_in_week;
            // $jobLog->tutoring_time = $request->tutoring_time;
            // $jobLog->tutoring_duration = $request->tutoring_duration;
            // $jobLog->teaching_method_id = $request->teaching_method_id;
            // $jobLog->salary = $request->salary;
            // $jobLog->number_of_students = $request->number_of_students;
            // $jobLog->country_id = $request->country_id;
            // $jobLog->city_id = $request->city_id;
            // $jobLog->location_id = $request->location_id;
            // $jobLog->full_address = $request->full_address;
            // $jobLog->tutor_requirement = $request->tutor_requirement;
            // $jobLog->special_note = $request->special_note;
            // $jobLog->staff_note = $request->staff_note;
            // $jobLog->tutoring_category_id = implode(',',$request->tutoring_category_id);
            // $jobLog->tutor_subject_id = implode(',',$request->tutor_subject_id);
            // $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);
            // $jobLog->tutor_religion = $request->tutor_religion;
            // $jobLog->tutor_gender = $request->tutor_gender;
            // $jobLog->tutor_university_type = $request->tutor_university_type;
            // $jobLog->tutor_university_id = implode(',',$request->tutor_university_id);
            // $jobLog->tutor_study_type_id = implode(',',$request->tutor_study_type_id);
            // $jobLog->tutor_department_id = implode(',', $request->tutor_department_id);
            // $jobLog->year = $request->year;
            // $jobLog->tutor_school_id = $request->tutor_school_id;
            // $jobLog->tutor_college_id = $request->tutor_college_id;
            // $jobLog->tutor_board = $request->board;
            // $jobLog->tutor_group = $request->group;
            // $jobLog->tutor_curriculam_id = $request->tutor_curriculam_id;
            // $jobLog->date = $request->date;
            // $job->is_sms_send = $request->is_sms;
            // $jobLog->created_by = auth()->user()->id;
            // // $jobLog->save();
            // $jobLog->update();




            return response()->json(['status' => true, 'message' => 'job updated Successfully!', 'data' => $job]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function jobDetails($job)
    {


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
        ])->where('id', $job)->firstOrFail();

        // dd($job->toArray());


        // $job->country
        //  dd($job->toArray());

        // return $job;

        if ($job->additional_child_info != null) {
            $xx = $job->additional_child_info->job_offer_additional_child_subjects;
        } else {
            $xx = 'null';
        }

        // $xx = $job->additional_child_info->job_offer_additional_child_subjects->toArray();

        return view('backend.job_offers.job_details', compact('job', 'xx'));
    }

    public function seeCondition($id=null)
    {
        $job_applications = JobApplication::with(['tutor','user'])->where('job_offer_id',$id)->get();
        $job_application_note = AppliedTutorNote::where('job_application_id',$id)->get();
        return view('backend.job_offers.see_condition',compact('job_applications','job_application_note'));
    }

    public function smsLog($job)
    {

        $job_sms = JobSms::where('job_id', $job)->orderby('id' , 'desc')->paginate(15);

        // dd($job_sms->toArray());
        return view('backend.job_offers.sms_log', compact('job_sms'));
    }

    public function statusLog()
    {
        return view('backend.job_offers.status_log');
    }

    public function searchTutor(Request $request)
    {

            $id = $request->job_id;
         $job_offer = JobOffer::with(['job_offer_tutor_universities', 'job_offer_tutor_departments','job_offer_tutor_study_types'])->where('id', $id)->first();
         
         return $job_offer;

        if (count($job_offer->job_offer_tutor_universities) != 0) {
            $tutor_university = [];

            foreach ($job_offer->job_offer_tutor_universities as $uni) {
                $tutor_university[] = $uni->id;
            }
            $tutor_university = implode(',', $tutor_university);
        } else {
            $tutor_university = '';
        }

        if (count($job_offer->job_offer_tutor_departments) != 0) {
            $tutor_department = [];

            foreach ($job_offer->job_offer_tutor_departments as $dep) {
                $tutor_department[] = $dep->id;
            }
            $tutor_department = implode(',', $tutor_department);
        } else {
            $tutor_department = '';
        }

        if (count($job_offer->job_offer_tutor_study_types) != 0) {
            $tutor_study = [];

            foreach ($job_offer->job_offer_tutor_study_types as $stu) {
                $tutor_study[] = $stu->id;
            }
            $tutor_study = implode(',', $tutor_study);
        } else {
            $tutor_study = '';
        }

        $tutor_gender = $job_offer->tutor_gender;
        $teaching_method = $job_offer->teaching_method_id;
        $university_type = $job_offer->tutor_university_type;
        $curriculam = $job_offer->tutor_curriculam_id;
        $group = $job_offer->tutor_group;


        $tutors_ids = DB::table('basic_search')
            ->select('tutor_id')
            ->where('country_id', $job_offer->country_id)
            ->where('city_id', $job_offer->city_id)
            ->where('pre_location_id', $job_offer->location_id)
            ->when($tutor_gender != 'any', function ($query) use ($tutor_gender) {
                return $query->where('gender', $tutor_gender);
            })
            ->when($university_type != '', function ($query) use ($university_type) {
                return $query->where('university_type', $university_type);
            })
            ->when($curriculam != '', function ($query) use ($curriculam) {
                return $query->where('curriculum_id', $curriculam);
            })
            ->when(!empty($tutor_department), function ($query) use  ($tutor_department) {
                $departments = explode(',', $tutor_department);
                return $query->whereIn('department_id', $departments);
            })
            ->when(!empty($tutor_university), function ($query) use ($tutor_university) {
                $universities = explode(',', $tutor_university);
                return $query->whereIn('institute_id', $universities);
            })
            ->when(!empty($tutor_study), function ($query) use ($tutor_study) {
                $tutor_studies = explode(',', $tutor_study);
                return $query->whereIn('study_type_id', $tutor_studies);
            })
            ->when($group != '', function ($query) use ($group) {
                return $query->where('group_or_major', $group);
            })
            ->get();




        //     $tutors_ids = DB::table('tutorfilter')
        //     ->select('tutor_id')
        //    ->where('country_id', "$job_offer->country_id")
        //      ->Where('city_id', "$job_offer->city_id")
        //    ->Where('pre_location_id', "$job_offer->location_id")
        //    if($tutor_gender != 'any'){
        //     ->Where('gender', "$job_offer->tutor_gender")
        //    }
        //     ->get();


        if (count($tutors_ids) == 0) {
           return response()->json(['status'=>false,
             'message'=> 'tutor not found',
                      ]);
        }

          foreach($tutors_ids as $key =>$tutor_id){

             $t_id[$key] =  $tutor_id->tutor_id;
         }

         if($request->types == 'Premium_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('is_premium', 1)
            ->take(50)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }
            else{

                $tutorsWithEducation = $tutors->map(function ($tutor) {

                    $educationTitle = '';
                if ($tutor->tutor_education->isNotEmpty()){
                $lastEducation = $tutor->tutor_education->last();
                if ($lastEducation->institutes) {
                    $educationTitle = $lastEducation->institutes->title;
                }
            }
                    return [
                        'tutor_name' => $tutor->name,
                        'tutor_id' => $tutor->id,
                        'tutor_education' => $educationTitle,
                        'tutor_personal_info' => $tutor->tutor_personal_info,
                    ];
                });
                return response()->json([
                    'status' => true,
                    'tutors' => $tutorsWithEducation,
                ]);


            }
         }
         if($request->types == 'Latest_created_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('created_at', '>', '2022-01-01 00:00:00')
            ->take(50)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }

            else{

            $tutorsWithEducation = $tutors->map(function ($tutor) {

                $educationTitle = '';
            if ($tutor->tutor_education->isNotEmpty()) {
            $lastEducation = $tutor->tutor_education->last();
            if ($lastEducation->institutes) {
                $educationTitle = $lastEducation->institutes->title;
            }
        }
                return [
                    'tutor_name' => $tutor->name,
                    'tutor_id' => $tutor->id,
                    'tutor_education' => $educationTitle,
                    'tutor_personal_info' => $tutor->tutor_personal_info,
                ];
            });


            return response()->json([
                'status' => true,
                'tutors' => $tutorsWithEducation,
            ]);


        }

         }

         if($request->types == '2nd_latest_created_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('created_at', '>', '2020-01-01 00:00:00')
            ->take(50)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }


            $tutorsWithEducation = $tutors->map(function ($tutor) {

                $educationTitle = '';
            if ($tutor->tutor_education->isNotEmpty()) {
            $lastEducation = $tutor->tutor_education->last();
            if ($lastEducation->institutes) {
                $educationTitle = $lastEducation->institutes->title;
            }
        }
                return [
                    'tutor_name' => $tutor->name,
                    'tutor_id' => $tutor->id,
                    'tutor_education' => $educationTitle,
                    'tutor_personal_info' => $tutor->tutor_personal_info,
                ];
            });


            return response()->json([
                'status' => true,
                'tutors' => $tutorsWithEducation,
            ]);



         }


         if($request->types == 'Bottom_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('created_at', '<', '2020-01-01 00:00:00')
            ->take(50)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }
            else{

                $tutorsWithEducation = $tutors->map(function ($tutor) {

                    $educationTitle = '';
                if ($tutor->tutor_education->isNotEmpty()) {
                $lastEducation = $tutor->tutor_education->last();
                if ($lastEducation->institutes) {
                    $educationTitle = $lastEducation->institutes->title;
                }
            }
                    return [
                        'tutor_name' => $tutor->name,
                        'tutor_id' => $tutor->id,
                        'tutor_education' => $educationTitle,
                        'tutor_personal_info' => $tutor->tutor_personal_info,
                    ];
                });


                return response()->json([
                    'status' => true,
                    'tutors' => $tutorsWithEducation,
                ]);


            }
         }

         if($request->types == '2nd_bottom_tutor'){
            $tutors = Tutor::with([
                'tutor_education',
                'tutor_personal_info',
            ])->whereIn('id', $t_id)
            ->where('created_at', '<', '2022-01-01 00:00:00')
            ->take(50)
            ->get();

            if (count($tutors) == 0) {
                return response()->json(['status'=>false,
                'message'=> 'tutor not found',
                         ]);

            }
            else{


                $tutorsWithEducation = $tutors->map(function ($tutor) {

                    $educationTitle = '';
                if ($tutor->tutor_education->isNotEmpty()) {
                $lastEducation = $tutor->tutor_education->last();
                if ($lastEducation->institutes) {
                    $educationTitle = $lastEducation->institutes->title;
                }
            }
                    return [
                        'tutor_name' => $tutor->name,
                        'tutor_id' => $tutor->id,
                        'tutor_education' => $educationTitle,
                        'tutor_personal_info' => $tutor->tutor_personal_info,
                    ];
                });


                return response()->json([
                    'status' => true,
                    'tutors' => $tutorsWithEducation,
                ]);


            }
         }

         $tutors = Tutor::with([
            'tutor_education',
            'tutor_personal_info',
        ])->whereIn('id', $t_id)
        ->take(50)
        ->get();



        //  $tAduTotalElements = count($tutors->tutor_education);

        //  $tutors['university'] = $tutors->tutor_education[$tAduTotalElements - 1]->institutes->title;


        $tutorsWithEducation = $tutors->map(function ($tutor) {

            $educationTitle = '';
        if ($tutor->tutor_education->isNotEmpty()) {
        $lastEducation = $tutor->tutor_education->last();
        if ($lastEducation->institutes) {
            $educationTitle = $lastEducation->institutes->title;
        }
    }
            return [
                'tutor_name'           => $tutor->name,
                'tutor_id'             => $tutor->id,
                'tutor_education'      => $educationTitle,
                'tutor_personal_info'  => $tutor->tutor_personal_info,
            ];
        });


        return response()->json([
            'status' => true,
            'tutors' => $tutorsWithEducation,
        ]);



    }
    public function smsView($id)
    {

        $sms_content = JobSms::where('id',$id)->first();

        // dd($sms_content);

        // dd($sms_content);

        return view('backend.job_offers.sms_view',compact('sms_content'));
    }
    public function editHistoryDetails()
    {

        return view('backend.job_offers.job_edit_history');
    }


    public function changeStatus(Request $request)
    {

        $job_offer            = JobOffer::find($request->id);
        $job_offer->is_active = $job_offer->is_active === 1 ? 0 : 1;
        $job_offer->save();
        return response()->json(['status'=>'success','message'=> 'Job Offer Status Change']);
    }


    public function jobSearch(Request $request)
    {

        $input= $request->job_search;

        if($request->job_search ==null){
            $input = "country_id='1'";
        }

        $query   = 'select id from job_offers where '.$input;
        $job_id  = DB::select($query);

        $j_id = [];

         foreach($job_id as $key =>$job){

            $j_id[$key] = $job->id;
        }

        $employees = User::where('role_id', 2)->orderBy('id', 'desc')->get();

        $all_jobs  = JobOffer::with(['parent', 'reference','applications'])->whereIn('id' ,$j_id)->orderBy('id', 'desc')->paginate(10);
        return view('backend.job_offers.all_offer', compact('all_jobs',
         'employees' ));
    }

    public function jobSearchSingle(Request $request)
    {
        $searchTerm = $request->search;

        $isPhoneNumber = preg_match('/^\d{10}$/', $searchTerm);

        $employees = User::where('role_id', 2)->orderBy('id', 'desc')->get();

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

        return view('backend.job_offers.all_offer', compact('all_jobs', 'employees'));
    }




}