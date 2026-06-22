<?php

namespace App\Http\Controllers\Backend\JobOffer;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdditionalChild as ModelsAdditionalChild;
use App\Models\Admin\AdditionalChild;
use App\Models\Backend\Config\TutorRequirementTemplate;
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
use App\Models\HiringRequest;
use App\Models\Institute;
use App\Models\JobOffer;
use App\Models\jobOfferAdditionalChildSubject;
use App\Models\jobOfferLog;
use App\Models\JobSms;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\TutorTeachingMethod;
use App\Models\Location;
use App\Models\ParentPersonalInfo;
use App\Models\SmsBalance;
use App\Models\Study;
use App\Models\TeachingMethod;
use App\Models\Subject;
use App\Models\Tutor;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;

class AddOfferController extends Controller
{
    public function index(){


        $countries   = Country::orderBy('id', 'ASC')->get();
        // $tutors= Tutor::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $categories        = Category::orderBy('id', 'ASC')->get();
        $departments       = Department::orderBy('id', 'ASC')->get();
        $courses           = Course::orderBy('id', 'ASC')->get();
        $institutes        = Institute::orderBy('id', 'ASC')->get();
        $teaching_methods  = TeachingMethod::all();
        $subjects          = Subject::orderBy('id', 'ASC')->get();
        $studies           = Study::orderBy('id', 'ASC')->get();
        $curriculams       = Curriculam::orderBy('id', 'ASC')->get();
        $templates         = TutorRequirementTemplate::orderBy('id', 'ASC')->get();
        $cities            = City::orderBy('id', 'ASC')->get();
        $locations             = Location::orderBy('id', 'ASC')->get();
        // dd($templates);



        return view('backend.job_offers.add_offer', compact('locations','cities','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates'));

    }

    public function AddAdditionalChild(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'gender' => 'required',
            'category' => 'required',
            'course' => 'required',
            'subject' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
        try{

            $addChild = new AdditionalChild();
            $addChild->parent_id    = $request->parent_id;
            $addChild->student_name = $request->name;
            $addChild->student_gender = $request->gender;
            $addChild->institute_name = $request->name;
            $addChild->category_id =$request->category;
            $addChild->course_id = $request->course;
            $addChild->created_by =auth()->user()->id;
            $addChild->save();
            $addChild->job_offer_additional_child_subjects()->sync($request->subject);


            return response()->json(['status'=>true,'message'=>'job created Successfully!','data' =>$addChild]);

        }

        catch (QueryException $e)

        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());

        }

    }


    public function AddNewReference(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'name' => 'required',
            'email' => 'unique:fnf_leads,email',
            'phone'=> 'required|regex:/(01)[0-9]{9}/|unique:fnf_leads',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'error'=>$validator->errors()]);
        }

        $fnf_lead = new FnfLead();
        $fnf_lead->parents_id = $request->parents_id;
        $fnf_lead->name = $request->name;
        $fnf_lead->email = $request->email;
        $fnf_lead->phone = $request->phone;
        $fnf_lead->additional_phone = $request->additional_phone;
        $fnf_lead->save();

        return response()->json([
            'status'=>true,
            'message'=>'Registration Successfully!',
            'data' =>$fnf_lead]);

    }


    public function searchReference(Request $request)
    {


        $search = $request->input;
        $fnf_lead = FnfLead::where('phone', $search)
            ->get();

        return response()->json([
                'data'=>$fnf_lead,
            ]);



    }

    public function searchParent(Request $request)
    {
        $search = $request->input;
        $parent = Parents::with('parents_personalInfo', 'parentsNote', 'jobOffer')->where('phone', $search)->get();

        $parent = $parent->map(function ($item) {
            $item->job_offer_count = $item->jobOffer->count();
            return $item;
        });

        return response()->json([
            'parent' => $parent->toArray(),
        ]);
    }



    public function addNewParent(Request $request)
    {
        $validatorRules = [
            'phone' => 'required|regex:/^01[0-9]{9}$/|unique:parents',
            'email' => 'nullable|email|unique:parents',
        ];

        $validator = Validator()->make($request->all(), $validatorRules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error'  => $validator->errors(),
            ]);
        }

        $parent = new Parents();
        $parent->name = $request->name ?? 'Anonymous Parent';
        $parent->email = $request->email;
        $parent->phone = $request->phone;
        $parent->phone_verified_at = now();
        $parent->additional_phone = $request->additional_phone;
        $parent->password = Hash::make('123456');
        $parent->otp = rand(1234, 9999);
        $parent->save();
        $parent->get_parent_unique_id();

        return response()->json([
            'status' => true,
            'message' => 'Registration Successfully!',
            'data' => $parent,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'student_gender' => 'required',
            'institute_name' => 'nullable',
            'category_id' => 'required',
            'course_id' => 'required',
            'subject_id' => 'required',
            'days_in_week' => 'required',
            'tutoring_time' => 'required',
            'tutoring_duration' => 'required',
            'teaching_method_id' => 'required',
            'salary' => 'required',
            'number_of_students' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'location_id' => 'required',
            'full_address' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'tutor_requirement' => 'required',
            'staff_note' => 'required',
            'tutor_religion' => 'nullable',
            'tutor_gender' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }
        try{

            $job = new JobOffer();

            if($request->hire_date)
            {

                $job->hire_date = $request->hire_date;
                $job->date = $request->hire_date;
                $job->is_active = 0;

            }else{
                $job->date = $request->date;
            }


            $job->parent_id = $request->parent_id;
            $job->job_views = 0;
            $job->total_application = 0;
            $job->student_name = $request->student_name;
            $job->student_gender = $request->student_gender;
            $job->institute_name = $request->institute_name;
            $job->category_id = $request->category_id;
            $job->course_id = $request->course_id;
            // $job->subject_id = implode(',',$request->subject_id);
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
            // $job->tutoring_category_id = implode(',',$request->tutoring_category_id);
            // $job->tutor_subject_id = implode(',',$request->tutor_subject_id);
            // $job->tutor_course_id = implode(',',$request->tutor_course_id);
            $job->tutor_religion = $request->tutor_religion;
            $job->tutor_gender = $request->tutor_gender;
            $job->tutor_university_type = $request->tutor_university_type;
            // $job->tutor_university_id = implode(',',$request->tutor_university_id);
            // $job->tutor_study_type_id = implode(',',$request->tutor_study_type_id);
            // $job->tutor_department_id = implode(',', $request->tutor_department_id);
            $job->year = $request->year;
            $job->tutor_school_id = $request->tutor_school_id;
            $job->tutor_college_id = $request->tutor_college_id;
            $job->tutor_board = $request->tutor_board;
            $job->tutor_group = $request->tutor_group;
            $job->tutor_curriculam_id = $request->tutor_curriculam_id;

            $job->is_sms_send = $request->is_sms;
            $job->created_by = auth()->user()->id;
            $job->save();
            $job->job_offer_subject()->sync($request->subject_id);
            $job->job_offer_tutor_categories()->sync($request->tutoring_category_id);
            $job->job_offer_tutor_courses()->sync($request->tutor_course_id);
            $job->job_offer_tutor_subjects()->sync($request->tutor_subject_id);
            $job->job_offer_tutor_universities()->sync($request->tutor_university_id);
            $job->job_offer_tutor_study_types()->sync($request->tutor_study_type_id);
            $job->job_offer_tutor_departments()->sync($request->tutor_department_id);





            $currentTime = Carbon::now();
            $startTime = $currentTime->copy()->subMinutes(30);

            $additionalChildren = AdditionalChild::where('parent_id', $request->parent_id)
                                    ->where('created_at', '>=', $startTime)
                                    ->where('job_id', '=', null)
                                    ->get();

                                    if($additionalChildren){
                                        foreach ($additionalChildren as $additionalChild) {
                                            $additionalChild->job_id = $job->id;
                                            $additionalChild->save();
                                        }

                                    }






            $jobLog = new jobOfferLog();
            if($request->hire_date)
            {

                $jobLog->hire_date = $request->hire_date;
                $jobLog->date = $request->hire_date;

            }else{
                $jobLog->date = $request->date;

            }
            $jobLog->job_id = $job->id;
            $jobLog->parent_id = $request->parent_id;
            $jobLog->student_name = $request->student_name;
            $jobLog->student_gender = $request->student_gender;
            $jobLog->institute_name = $request->institute_name;
            $jobLog->category_id = $request->category_id;
            $jobLog->course_id = $request->course_id;
            // $jobLog->subject_id = implode(',',$request->subject_id);
            $jobLog->days_in_week = $request->days_in_week;
            $jobLog->tutoring_time = $request->tutoring_time;
            $jobLog->tutoring_duration = $request->tutoring_duration;
            $jobLog->teaching_method_id = $request->teaching_method_id;
            $jobLog->salary = $request->salary;
            $jobLog->number_of_students = $request->number_of_students;
            $jobLog->country_id = $request->country_id;
            $jobLog->city_id = $request->city_id;
            $jobLog->location_id = $request->location_id;
            $jobLog->full_address = $request->full_address;
            $jobLog->lat = $request->lat;
            $jobLog->long = $request->long;
            $jobLog->tutor_requirement = $request->tutor_requirement;
            $jobLog->special_note = $request->special_note;
            $jobLog->staff_note = $request->staff_note;
            // $jobLog->tutoring_category_id = implode(',',$request->tutoring_category_id);
            // $jobLog->tutor_subject_id = implode(',',$request->tutor_subject_id);
            // $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);
            $jobLog->tutor_religion = $request->tutor_religion;
            $jobLog->tutor_gender = $request->tutor_gender;
            $jobLog->tutor_university_type = $request->tutor_university_type;
            // $jobLog->tutor_university_id = implode(',',$request->tutor_university_id);
            // $jobLog->tutor_study_type_id = implode(',',$request->tutor_study_type_id);
            // $jobLog->tutor_department_id = implode(',', $request->tutor_department_id);
            $jobLog->year = $request->year;
            $jobLog->tutor_school_id = $request->tutor_school_id;
            $jobLog->tutor_college_id = $request->tutor_college_id;
            $jobLog->tutor_board = $request->board;
            $jobLog->tutor_group = $request->group;
            $jobLog->tutor_curriculam_id = $request->tutor_curriculam_id;

            $job->is_sms_send = $request->is_sms;
            $jobLog->created_by = auth()->user()->id;





            if($request->subject_id == ''){
                $jobLog->subject_id =$request->subject_id;
            }
            else{
                $jobLog->subject_id = implode(',',$request->subject_id);

            }

            if($request->tutoring_category_id == ''){
                $jobLog->tutoring_category_id =$request->tutoring_category_id;
            }
            else{
                $jobLog->tutoring_category_id = implode(',',$request->tutoring_category_id);

            }

            if($request->tutor_subject_id == ''){
                $jobLog->tutor_subject_id =$request->tutor_subject_id;
            }
            else{
                $jobLog->tutor_subject_id = implode(',',$request->tutor_subject_id);

            }

            if($request->tutor_course_id == ''){
                $jobLog->tutor_course_id =$request->tutor_course_id;
            }
            else{
                $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);

            }



            if($request->tutor_course_id == ''){
                $jobLog->tutor_course_id =$request->tutor_course_id;
            }
            else{
                $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);

            }

            if($request->tutor_course_id == ''){
                $jobLog->tutor_course_id =$request->tutor_course_id;
            }
            else{
                $jobLog->tutor_course_id = implode(',',$request->tutor_course_id);

            }

            if($request->tutor_university_id == ''){
                $jobLog->tutor_university_id =$request->tutor_university_id;
            }
            else{
                $jobLog->tutor_university_id = implode(',',$request->tutor_university_id);

            }


            if($request->tutor_study_type_id == ''){
                $jobLog->tutor_study_type_id =$request->tutor_study_type_id;
            }
            else{
                $jobLog->tutor_study_type_id = implode(',',$request->tutor_study_type_id);

            }

            if($request->tutor_department_id == ''){
                $jobLog->tutor_department_id =$request->tutor_department_id ;
            }
            else{
                $jobLog->tutor_department_id = implode(',', $request->tutor_department_id);

            }

            $jobLog->save();

            if ($request->parent_lead_id) {
                $leadUpdate = Lead::where('id',$request->parent_lead_id)->first();
                $leadUpdate->status = 'Accepted';
                $leadUpdate->added_by = Auth::user()->id;
                $leadUpdate->update();

                $leadSource = new LeadSource();
                $leadSource->channel            = 'Website';
                $leadSource->source_name        = 'Parent Lead';
                $leadSource->source_code        = 'PL-'.$request->parent_lead_id;
                $leadSource->job_id             = $job->id;
                $leadSource->save();
            }

            if ($request->parent_fnf_lead_id) {
                $leadUpdate = FnfLead::where('id',$request->parent_fnf_lead_id)->first();
                $leadUpdate->status = 'Accepted';
                $leadUpdate->added_by = Auth::user()->id;
                $leadUpdate->update();

                $leadSource = new LeadSource();
                $leadSource->channel            = 'Website';
                $leadSource->source_name        = 'Parent Fnf Lead';
                $leadSource->source_code        = 'PFL-'.$request->parent_fnf_lead_id;
                $leadSource->job_id             = $job->id;
                $leadSource->save();
            }
            if ($request->hiring_lead_id) {
                $leadUpdate = HiringRequest::where('id',$request->hiring_lead_id)->first();
                $leadUpdate->status = 'accepted';
                $leadUpdate->added_by = Auth::user()->id;
                $leadUpdate->update();

                $leadSource = new LeadSource();
                $leadSource->channel            = 'Website';
                $leadSource->source_name        = 'Parent Category Request';
                $leadSource->source_code        = 'TR-'.$request->hiring_lead_id;
                $leadSource->job_id             = $job->id;
                $leadSource->save();
            }
            if ($request->hiring_lead_tutor_id) {
                $leadUpdate = HiringRequest::where('id',$request->hiring_lead_tutor_id)->first();
                $leadUpdate->status = 'accepted';
                $leadUpdate->added_by = Auth::user()->id;
                $leadUpdate->update();

                $leadSource = new LeadSource();
                $leadSource->channel            = 'Website';
                $leadSource->source_name        = 'Parent Category Request';
                $leadSource->source_code        = 'TR-'.$request->hiring_lead_tutor_id;
                $leadSource->job_id             = $job->id;
                $leadSource->save();
            }






            // dd($job->id);

            $job_offer = JobOffer::findOrFail($job->id);
            $tutor_university = $job_offer->job_offer_tutor_universities->pluck('id')->implode(',');
            $tutor_department = $job_offer->job_offer_tutor_departments->pluck('id')->implode(',');
            $tutor_study = $job_offer->job_offer_tutor_study_types->pluck('id')->implode(',');
            $tutor_gender = $job_offer->tutor_gender;

            $tutors_ids = Tutor::with(['tutor_personal_info', 'tutor_education', 'tutor_prefered_locations', 'smsBalances'])
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
            ->where('is_active',1)
            ->where('is_sms',1)
            ->whereHas('smsBalances', function ($query) {
                $query->where('available_sms', '>', 0);
            })
            ->pluck('id');
            if($tutors_ids != null)
            {
                $tutors = Tutor::whereIn('id', $tutors_ids)->get();

                $subjects = [];
                $jobOfferSubject = $job_offer->job_offer_student_subjects;
                foreach ($jobOfferSubject as $key => $item) {
                    $subjects[] = $item->subject->title;
                }

                $job_id = $job_offer->id;
                $location = $job_offer->location->name;
                $course = $job_offer->course->name;
                $jobSubject = implode(', ', $subjects);
                $tutoring_time = Carbon::createFromFormat('H:i:s', $job_offer->tutoring_time)->format('h A');
                $tutoring_duration = $job_offer->tutoring_duration;
                $salary = $job_offer->salary;
                $apply_link = "https://tuitionhome.xyz/job-board/job-details/$job_offer->id";
                $contact_number = "09678444477";
                $day = $job_offer->days_in_week;

                $sms_body = "JOB ID: $job_id\n$course,$location,$tutoring_time,$tutoring_duration H,$day D,$salary tk\n\nApply: $apply_link\nCall: $contact_number";

                foreach ($tutors as $tutor) {
                    $sms = new JobSms();
                    $sms->job_id = $job_offer->id;
                    $sms->sender_name = "Auto Profile Match";
                    $sms->sms_body = $sms_body;
                    $sms->tutor_phone = $tutor->phone;
                    $sms->sms_method = 'paid';
                    $sms->is_sent = 0;
                    $sms->tutor_id = $tutor->id;
                    $sms->save();

                        $updateSmsBalance = SmsBalance::where('tutor_id', $tutor->id)->first();
                        if ($updateSmsBalance) {
                            $updateSmsBalance->increment('paid_sms');
                            $updateSmsBalance->decrement('available_sms');
                        }
                }

            }

            $parent = ParentPersonalInfo::updateOrCreate(
                ['parents_id' => $request->parent_id],
                [
                    'country_id'  => $request->country_id,
                    'parents_id'  => $request->parent_id,
                    'city_id'     => $request->city_id,
                    'location_id' => $request->location_id
                ]
            );








            return response()->json(['status'=>true,'message'=>'job created Successfully!','data' =>$job]);


        }

        catch (QueryException $e)

        {
            return redirect()->back()->withInput()->withErrors($e->getMessage());


        }

    }




}