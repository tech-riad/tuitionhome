<?php

namespace App\Http\Controllers\Backend\Parent;

use App\Http\Controllers\Controller;
use App\Models\Backend\Config\TutorRequirementTemplate;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Curriculam;
use App\Models\Department;
use App\Models\FnfLead;
use App\Models\HiringRequest;
use App\Models\Institute;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\Lead;
use App\Models\Location;
use App\Models\ParentLog;
use App\Models\Parents;
use App\Models\Study;
use App\Models\Subject;
use App\Models\TeachingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BackendParentJobController extends Controller
{
    public function parentJobStatus($id)
    {
        $requestedJobs = Lead::where('parents_id',$id)->orderBy('id','desc')->get();
        $requestedJobsCount = Lead::where('parents_id',$id)->count();

        $approvedJobs = JobOffer::where('parent_id',$id)->orderBy('id','desc')->get();
        $approvedJobCount = JobOffer::where('parent_id',$id)->count();

        // Appointed Job
        $approveJobOfferIds = JobOffer::where('parent_id', $id)
                                ->pluck('id');

        $appointedApplicationId = JobApplication::whereIn('job_offer_id', $approveJobOfferIds)
                                    ->whereNotNull('taken_at')
                                    ->pluck('job_offer_id');


        $appointedJobs = JobOffer::whereIn('id',$appointedApplicationId)->orderBy('id','desc')->get();
        $appointedJobsCount = JobOffer::whereIn('id',$appointedApplicationId)->count();


        // Confirm Job
        $confirmApplicationId = JobApplication::whereIn('job_offer_id', $approveJobOfferIds)
                                    ->where('current_stage','confirm')
                                    ->pluck('job_offer_id');


        $confirmJobs = JobOffer::whereIn('id',$confirmApplicationId)->orderBy('id','desc')->get();
        $confirmJobsCount = JobOffer::whereIn('id',$confirmApplicationId)->count();

        // Cancel Job
        $closedApplications = JobApplication::whereIn('job_offer_id', $approveJobOfferIds)
                                            ->select('job_offer_id', 'current_stage')
                                            ->get()
                                            ->groupBy('job_offer_id');

        $closedJobOfferIds = [];

        foreach ($closedApplications as $jobOfferId => $applications) {
            if ($applications->every(function ($app) {
                return $app->current_stage === 'closed';
            })) {
                $closedJobOfferIds[] = $jobOfferId;
            }
        }


        $cancelJobs = JobOffer::whereIn('id',$closedJobOfferIds)->orderBy('id','desc')->get();
        $cancelJobsCount = JobOffer::whereIn('id',$closedJobOfferIds)->count();

        $count = [
            'approvedJobCount' => $approvedJobCount,
            'requestedJobsCount' => $requestedJobsCount,
            'appointedJobsCount' => $appointedJobsCount,
            'confirmJobsCount' => $confirmJobsCount,
            'cancelJobsCount' => $cancelJobsCount,
        ];


        return view('backend.parents.job_status',compact('count','cancelJobs','id','requestedJobs','approvedJobs','appointedJobs','confirmJobs'));
    }
    public function parentFnfLead()
    {
        $leads = FnfLead::orderBy('id','desc')->paginate(20);

        return view('backend.parents.lead.parent_fnf_lead',compact('leads'));

    }


    public function parentFnfLeadAdminNote(Request $request, $lead_id)
    {
        $request->validate([
            'admin_note' => 'required|max:200',
        ]);

        try {
            $lead = FnfLead::findOrFail($lead_id);
            $lead->admin_note = $request->admin_note;
            $lead->added_by = Auth::user()->id;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Admin note successfully add.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel the job. Please try again later.'
            ], 500);
        }
    }

    public function getPostedJob($id)
    {
        $parent = Parents::findOrfail($id);
        $liveOnJobsCount = JobOffer::where('parent_id',$id)->where('is_active',1)->count();
        $liveOnJobs = JobOffer::where('parent_id',$id)->where('is_active',1)->orderBy('id','desc')->get();
        $liveOffJobs = JobOffer::where('parent_id',$id)->where('is_active',0)->orderBy('id','desc')->get();
        $liveOffJobsCount = JobOffer::where('parent_id',$id)->where('is_active',0)->count();
        return view('backend.parents.posted_job',compact('parent','liveOnJobs','liveOffJobs','liveOffJobsCount','liveOnJobsCount'));
    }
    public function basicLog($id)
    {
        $logs = ParentLog::where('parents_id', $id)
                ->where(function ($query) {
                    $query->whereNotNull('name')
                        ->orWhereNotNull('phone')
                        ->orWhereNotNull('email');
                })
                ->orderBy('id','desc')
                ->paginate(10);


        return view('backend.parents.basic_log',compact('id','logs'));
    }
    public function advanceLog($id)
    {
        $logs = ParentLog::where('parents_id', $id)
                ->orderBy('id','desc')
                ->paginate(10);



        return view('backend.parents.advance_log',compact('id','logs'));
    }
    public function parentLead(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 20);
        $leads = Lead::orderBy('id','desc')->paginate($paginationLimit);
        $totalLead = Lead::count();
        $totalfnfLead = FnfLead::count();
        $parentLeadPending = Lead::where('status','Pending')->count();
        $parentLeadAccepted = Lead::where('status','Accepted')->count();



        return view('backend.parents.lead.parent_lead',compact('paginationLimit','currentRoute','leads','totalLead','totalfnfLead','parentLeadPending','parentLeadAccepted'));
    }
    public function parentLeadView(Request $request, $id)
    {
        $lead = Lead::where('id',$id)->first();
        return view('backend.parents.lead.lead_view',compact('lead'));
    }

    public function parentLeadSearch(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);

        $parent = Parents::where('phone',$request->search)->first();
        $leads = Lead::where('parents_id',$parent->id)->orderBy('id','desc')->paginate($paginationLimit);
        $totalLead = Lead::count();
        $totalfnfLead = FnfLead::count();
        $parentLeadPending = Lead::where('status','Pending')->count();
        $parentLeadAccepted = Lead::where('status','Accepted')->count();



        return view('backend.parents.lead.parent_lead',compact('paginationLimit','currentRoute','leads','totalLead','totalfnfLead','parentLeadPending','parentLeadAccepted'));

    }
    public function parentLeadJobPost($lead_id)
    {

        $lead = Lead::with('parentsNote')->where('id',$lead_id)->first();

        // dd($lead);
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
        return view('backend.job_offers.add_offer',compact('locations','lead','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates','cities'));

    }
    public function parentFnfLeadJobPost($lead_id)
    {


        $fnflead = FnfLead::where('id',$lead_id)->first();

        $parent = Parents::where('phone',$fnflead->phone)->first();

        if($parent)
        {
            $fnfleadparent = $parent;
        }else{
            $fnfparent = new Parents();
            $fnfparent->name = 'Demo Parent';
            $fnfparent->phone = $fnflead->phone;
            $fnfparent->phone_verified_at = now();
            $fnfparent->password = Hash::make('123456');
            $fnfparent->otp = rand(1234, 9999);
            $fnfparent->save();
            $fnfparent->get_parent_unique_id();

            $fnfleadparent = $parent;
        }

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

        // dd($fnfleadparent);
        return view('backend.job_offers.add_offer',compact('fnfleadparent','locations','fnflead','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates','cities'));
    }
    public function parentFnfLeadJobReject(Request $request, $lead_id)
    {
        $request->validate([
            'cancel_note' => 'required|max:200',
        ]);

        try {
            $lead = FnfLead::findOrFail($lead_id);
            $lead->status = 'Cancel';
            $lead->cancel_note = $request->cancel_note;
            $lead->added_by = Auth::user()->id;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Job canceled successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel the job. Please try again later.'
            ], 500);
        }
    }
    public function parentLeadJobReject(Request $request, $lead_id)
    {
        $request->validate([
            'cancel_note' => 'required|max:200',
        ]);

        try {
            $lead = Lead::findOrFail($lead_id);
            $lead->status = 'Cancel';
            $lead->cancel_note = $request->cancel_note;
            $lead->added_by = Auth::user()->id;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Job canceled successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel the job. Please try again later.'
            ], 500);
        }
    }
    public function parentLeadNote(Request $request, $lead_id)
    {
        $request->validate([
            'note' => 'required|max:200',
        ]);

        try {
            $lead = Lead::findOrFail($lead_id);
            $lead->note = $request->note;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Note added successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel the job. Please try again later.'
            ], 500);
        }
    }

    public function tutorCategoryRequest($id)
    {
        $tutorHireRequests = HiringRequest::where('parent_id',$id)->paginate(10);

        return view('backend.parents.tc_request',compact('id','tutorHireRequests'));




    }

    public function tutorCategoryRequestFilter(Request $request , $id)
    {
        $searchCriteria = $request->input('tc_filter');


        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);

        try {
            $tutorHireRequests = HiringRequest::whereRaw($searchCriteria)
                ->where('parent_id', $id)
                ->orderBy('id', 'desc')
                ->paginate(20);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return view('backend.parents.tc_request',compact('id','tutorHireRequests'));



    }
    public function parentCategoryLeadJobPost(Request $request ,$lead_id)
    {
        $hiringlead = HiringRequest::with('parentsNote')->where('id',$lead_id)->first();

        $postedJobStatus = JobOffer::where('parent_id',$hiringlead->parent_id)->count();

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
        return view('backend.job_offers.add_offer',compact('postedJobStatus','locations','hiringlead','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates','cities'));

    }
    public function parentTutorLeadJobPost(Request $request ,$lead_id)
    {
        $hiringleadTutor = HiringRequest::with('parentsNote')->where('id',$lead_id)->first();

        $postedJobStatus = JobOffer::where('parent_id',$hiringleadTutor->parent_id)->count();

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
        return view('backend.job_offers.add_offer',compact('postedJobStatus','locations','hiringleadTutor','countries','departments','categories',
        'departments','courses','institutes','teaching_methods','subjects','studies','curriculams','templates','cities'));

    }



}
