<?php

namespace App\Http\Controllers\Backend\JobOffer;

use App\Http\Controllers\Controller;
use App\Models\Counting;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\JobStatus;
use App\Models\Tutor;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationJobOfferController extends Controller
{
    public function index()
    {


        $unique_tutors_applied = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT tutor_id) AS unique_tutors_applied'))
        ->first();



        $jobApplications = JobApplication::with(['job', 'tutors'])
        ->orderBy('id', 'desc')
        ->paginate(50)
        ->groupBy('job_offer_id');
        $uniqueJobsTakenToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_taken_today'))
        ->whereDate('taken_at', now())
        ->first();
        $uniqueJobsShortlistedToday = DB::table('job_applications')
        ->select(DB::raw('COUNT(DISTINCT job_offer_id) AS unique_jobs_shortlisted_today'))
        ->whereDate('shortlisted_date', now())
        ->first();


        // $s = JobOffer::where('taken_by_2', 2)->get();
        // dd($s);
        // $takenByFirstUser = User::where('id',JobOffer::where('id',3));
        // dd($takenByFirstUser);

        return view('backend.job_offers.application_offer', compact('jobApplications','unique_tutors_applied'));
    }

    public function applicantList($id)
    {
        $total_applicants = JobApplication::where('job_offer_id', $id)->update([
            'is_seen' => 1
        ]);
        $job_offer = JobOffer::with('course','category','job_offer_student_subjects','country','city','location','parent')->where('id',$id)->get()->first();

        // dd($job_offer->toarray());

        $total_applicants = JobApplication::with('job_offer','tutor')->where('job_offer_id', $id)->orderBy('id' ,'DESC')->get();
        return view('backend.job_offers.applicant_list',compact('total_applicants','job_offer'));
    }
    public function applicantListRestore($id)
    {
        $application = JobApplication::where('id',$id)->first();
        // $jobOffer = JobOffer::where('id',$application->job_offer_id)->first();
        $application->taken_by_id   = null;
        $application->taken_at      = null;
        $application->current_stage = null;
        $application->is_taken      = 0;
        $application->update();


        return redirect()->back()->withMessage('Restore Successful');
    }

    public function jobTaken(Request $request)
    {

        try{
            $id = $request->id;
            $taken1 = JobOffer::Where('id',$request->job_id)->pluck('taken_by_1')->first();
            $taken2 = JobOffer::Where('id',$request->job_id)->pluck('taken_by_2')->first();
            $taken_offer = JobApplication::find($id);


            if($taken_offer->is_shortlisted == 1){

                $jobStatusLog =new JobStatus();
                if($taken1 == null && $taken_offer->taken_by_id == null){

                    $job = JobOffer::Where('id',$request->job_id)->first();
                    $job->taken_by_1 = Auth::id();
                    $job->taken_by_1_date = now();
                    if ($job->taken_by_2 !=null) {
                        $job->is_active = 0;

                        $jobStatusLog->job_id = $request->job_id;
                        $jobStatusLog->status = 0;
                        $job->live_off_date = now();
                        $jobStatusLog->emp_id = Auth::user()->id;
                        $jobStatusLog->save();

                    }
                    $job->update();



                $taken_offer->taken_by_id = Auth::id();
                $taken_offer->taken_at =  now();
                $taken_offer->is_taken = 1;
                $taken_offer->current_stage = 'assign';
                $taken_offer->save();

                $counting = Counting::where('tutor_id', $taken_offer->tutor_id)->first();

                $counting->appointed_job = $counting->appointed_job + 1;
                $counting->save();
                return response()->json(['status'=>'success', 'count'=>$taken1,'$id'=>$request->all()]);


                }elseif($taken2 == null && $taken_offer->taken_by_id == null){
                    $job = JobOffer::Where('id',$request->job_id)->first();
                    $job->taken_by_2 = Auth::id();
                    $job->taken_by_2_date = now();
                    $job->is_active = 0;
                    $job->live_off_date = now();

                        $jobStatusLog->job_id = $request->job_id;
                        $jobStatusLog->status = 0;
                        $jobStatusLog->emp_id = Auth::user()->id;
                        $jobStatusLog->save();

                    $job->update();

                $taken_offer = JobApplication::find($id);
                $taken_offer->taken_by_id = Auth::id();
                $taken_offer->taken_at =  now();
                $taken_offer->is_taken = 1;
                $taken_offer->current_stage = 'assign';
                $taken_offer->save();

                $counting = Counting::where('tutor_id', $taken_offer->tutor_id)->first();

                $counting->appointed_job = $counting->appointed_job + 1;
                $counting->save();



                return response()->json(['status'=>'success', 'count'=>$taken1,'$id'=>$request->all()]);

                }
                else{
                return response()->json(['status'=>'false','error'=>'Already Taken By Two Person']);

                }


            }

            else{


                return response()->json(['status'=>'false','error'=>'Please Shortlist the applicant First']);

            }




        }catch(Exception $e)
        {
            return response()->json(['status'=>'error','error'=>$e->getMessage()]);
        }

    }



    public function jobShortlist(Request $request)
    {

        try{
            $id = $request->id;

            $taken_offer = JobApplication::find($id);


            if($taken_offer->is_shortlisted == 0){
                $taken_offer->is_shortlisted = 1;
                $taken_offer->shortlisted_date = Carbon::now();
                $taken_offer->shortlisted_by = Auth::id();

                $counting = Counting::where('tutor_id', $taken_offer->tutor_id)->first();

                $counting->shortlisted_job = $counting->shortlisted_job + 1;
                $counting->save();

                $taken_offer->update();
                return response()->json(['status'=>'success', 'message'=>'shortlisted successfully']);


            }


            else{
            return response()->json(['status'=>'false','error'=>'Already shortlisted']);

            }

        }catch(Exception $e)
        {
            return response()->json(['status'=>'error','error'=>$e->getMessage()]);
        }

    }



    public function AppliedTutorDelete(Request $request)
    {
        $remove_application = JobApplication::find($request->id);
        $job_id = $remove_application->job_offer_id;

        $job = JobOffer::Where('id',$job_id)->first();
        $job->taken_by_2 = null;
        $job->update();
        $remove_application->delete();
        return response()->json(['status'=>'success','message'=>'delete successfully!']);
    }

    public function newAssignTutor(Request $request)
    {
        try {
            $tutorIdOrPhone = $request->tutor_id;

            $tutor = Tutor::where('phone', $tutorIdOrPhone)
                ->orWhere('unique_id', $tutorIdOrPhone)
                ->firstOrFail();

                if (!$tutor) {
                    return response()->json(['status' => 'tutor', 'message' => 'Tutor not found']);
                }

            $checkTutor = JobApplication::where('tutor_id', $tutor->id)
                ->where('job_offer_id', $request->id)
                ->first();

            if (!$checkTutor) {
                $assign_tutor = new JobApplication();
                $assign_tutor->job_offer_id = $request->id;
                $assign_tutor->tutor_id = $tutor->id;
                $assign_tutor->tutor_added_additional_by = Auth::id();
                $assign_tutor->save();

                $counting = Counting::where('tutor_id', $tutor->id)->first();

                $counting->applied_job = $counting->applied_job + 1;
                $counting->save();


                return response()->json(['status' => 'success', 'message' => 'Tutor assigned successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Already assigned']);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'tutor', 'message' => 'Tutor not found']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Oops! Tutor not found or registration error']);
        }
    }


    public function jobApply(Request $request)
    {
        try {
            $tutorIdOrPhone = $request->tutor_id;
            $jobId = $request->job_id;

            $tutor = Tutor::where('phone', $tutorIdOrPhone)
            ->orWhere('unique_id', $tutorIdOrPhone)
            ->first();

            if (!$tutor) {
                return response()->json(['status' => 'tutor', 'message' => 'Tutor not found']);
            }

            $jobOffer = JobOffer::where('id', $jobId)->first();

            if (!$jobOffer) {
                return response()->json(['status' => 'job', 'message' => 'Job Offer not found']);
            }

            $previousApplication = JobApplication::where('tutor_id', $tutor->id)
                ->where('job_offer_id', $jobOffer->id)
                ->first();

            if ($previousApplication) {
                return response()->json(['status' => 'alreadyApplied', 'message' => 'Already applied to the job offer']);
            }

            $jobApplication = new JobApplication();
            $jobApplication->tutor_id = $tutor->id;
            $jobApplication->job_offer_id = $jobOffer->id;
            $jobApplication->save();


            $counting = Counting::where('tutor_id', $tutor->id)->first();

            $counting->applied_job = $counting->applied_job + 1;
            $counting->save();

            return response()->json(['status' => 'success', 'message' => 'Your job application was successful.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
