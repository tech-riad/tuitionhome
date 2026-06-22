<?php

namespace App\Http\Controllers\Backend\TakenOffer;

use App\Http\Controllers\Controller;
use App\Models\ApplicationNote;
use App\Models\ApplicationPayment;
use App\Models\ApplicationStage;
use App\Models\Counting;
use App\Models\DuePayments;
use App\Models\JobApplication;
use App\Models\JobOffer;
use App\Models\JobSms;
use App\Models\Sms;
use App\Models\SmsBalance;
use App\Models\SmsRecharge;
use App\Models\Tutor;
use App\Models\TutorAccount;
use App\Models\TutorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TakenOfferController extends Controller
{

    public function refundPaymentComplete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'refund_complete_amount' => 'required|numeric',
            'refund_note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        $application = JobApplication::findOrFail($request->refund_id);

        $application->refund_complete_amount = $request->refund_complete_amount;
        $application->refund_coin            = $request->refund_coin;
        $application->refund_complete_note   = $request->refund_complete_note;
        $application->refund_status = 1;
        $application->refund_by = Auth::user()->id;
        $application->refund_complete_date = now()->toDateString();

        $application->update();

        $tutor = Tutor::where('id',$application->tutor_id)->first();

        if($tutor->balances !=0)
        {
            $tutor->balances -= $application->refund_amount;
            $tutor->update();

        }


        $duePaymentsUpdate = Duepayments::where('application_id',$request->refund_id)->first();
        if($duePaymentsUpdate != null){
            $duePaymentsUpdate->trx_id = $request->trx_id;
            $duePaymentsUpdate->paid_date = now();
            $duePaymentsUpdate->payment_status = 1;
            $duePaymentsUpdate->payment_amount = $request->refund_complete_amount;
            $duePaymentsUpdate->refund_coin = $request->refund_coin;
            $duePaymentsUpdate->update();
        }


        return response()->json(['status' => true, 'message' => 'Refund completed successfully']);
    }

    public function refundPayment(Request $request)
    {

        try {
            $validator = Validator::make($request->all(),[
                'refund_app_id' => 'required',
                'refund_amount' => 'required|numeric',
                'refund_reason' => 'required|string',
                'refund_date' => 'required|date',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            $application = JobApplication::where('id', $request->refund_app_id)->first();


            $application->refund_amount   = $request->refund_amount;
            $application->refund_reason   = $request->refund_reason;
            $application->refund_date     = $request->refund_date;
            $application->refund_status   = 0;
            $application->payment_status  = 'refund';
            $application->update();

            $tutor = Tutor::where('id',$application->tutor_id)->first();
            $tutor->balances += $application->refund_amount;
            $tutor->update();

            $duePayment = new DuePayments();
            $duePayment->application_id         = $application->id;
            $duePayment->tutor_id               = $application->tutor_id ?? '';
            $duePayment->job_id                 = $application->job_offer_id ;
            $duePayment->user_type              = 'Tutor' ;
            $duePayment->name                   = $application->tutor->name ?? '' ;
            $duePayment->service_category       = 'Refund' ;
            $duePayment->amount                 = $request->refund_amount ;
            $duePayment->payment_status         = 0 ;
            $duePayment->render_by              = Auth::user()->id ;
            $duePayment->ownership_by           = $application->taken_by_id ;
            $duePayment->save();

            $existingRecord = TutorAccount::where('tutor_id', $application->tutor_id)->first();

            if($existingRecord){
                $tutorac = new TutorAccount();
                $tutorac->tutor_id = $application->tutor_id;
                $tutorac->number = $request->number;
                $tutorac->account_type = $request->account_type;
                $tutorac->account_name = $request->account_name;
                $tutorac->update();

            }else{
                $tutorac = new TutorAccount();
                $tutorac->tutor_id = $application->tutor_id;
                $tutorac->number = $request->number;
                $tutorac->account_type = $request->account_type;
                $tutorac->account_name = $request->account_name;
                $tutorac->save();
            }



            // $tutorAccount = TutorAccount::UpdateOrCreate(
            //     ['tutor_id' => $application->tutor_id],
            //     [
            //         'number' => $request->number,
            //         'account_type' => $request->account_type,
            //         'account_name' => $request->account_name
            //     ]
            // );


            $counting = Counting::where('tutor_id', $application->tutor_id)->first();

            $counting->trial_job = $counting->trial_job + 1;
            $counting->save();







            return redirect()->route('admin.taken_offer.index')->withMessage('Added For Refund !');


          } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

    public function due_payment(Request $request)
    {


        if($request->turn_off_payment == 1)
        {
            $application= JobApplication::where('id', $request->due_app_id)->first();
            $application->is_payment_turned_off = 1;
            $application->payment_status = "paid";
            $application->due_amount = 0;
            $application->due_payment_date = null;
            $application->update();



        }else{

            if($request->due_due_amount != 0){
                $validator = Validator::make($request->all(),[
                    'p_method' => 'required',
                    'received_amount' => 'required',
                    'received_number' => 'required',
                    'due_due_payment_date' => 'required',


                ]);

             }else{

                $validator = Validator::make($request->all(),[
                    'p_method' => 'required',
                    'received_amount' => 'required',
                    'received_number' => 'required',

                ]);

             }


            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }

            $application= JobApplication::where('id', $request->due_app_id)->first();
            $application->payment_method = $request->p_method;
            $application->received_amount = $application->received_amount + $request->received_amount;
            $application->received_number = $request->recevied_number;



            $application->due_amount =  $application->due_amount - $request->received_amount;


            $application->due_payment_date = $request->due_due_payment_date;

            if($application->due_amount == 0){
                $application->payment_status = 'paid';
                $application->paid_date = Carbon::now();
                $application->due_complete = 1;

            }
            else{
                $application->payment_status = 'due';
            }


            $application->update();

            if($request->online_payment == 0)
            {
                $payment = new ApplicationPayment();

                $payment->tutor_id = $application->tutor_id;
                $payment->job_offer_id  = $application->job_offer_id ;
                $payment->application_id   = $application->id ;
                $payment->received_amount   = $request->received_amount ;
                $payment->payment_method   = $application->payment_method ;
                $payment->trx_id   = $request->trx_id ;
                $payment->render_by   = Auth::user()->id ;
                $payment->ownership_by   = $application->taken_by_id;
                $payment->save();
            }

            return response()->json(['application'=>$application]);

        }




    }

    public function payment(Request $request)
    {
        // Validation
        $rules = [
            'p_method' => 'required',
            'received_amount' => 'required',
            'received_number' => 'required',
        ];

        if ($request->due_amount != 0) {
            $rules['due_payment_date'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        // Fetch application
        $application = JobApplication::find($request->p_app_id);
        if (!$application) {
            return response()->json([
                'status' => false,
                'error'  => 'Application not found.'
            ]);
        }

        $applicationPayment = ApplicationPayment::where('application_id', $application->id)->first();

        if ($applicationPayment && $applicationPayment->created_at >= now()->subMinutes(30)) {
            return response()->json([
                'status' => false,
                'error'  => 'Try again after 30 minutes.'
            ]);
        }

        $application->payment_method = $request->p_method;
        $application->received_amount = $request->received_amount;
        $application->received_number = $request->recevied_number; // Typo fixed: 'recevied_number' => 'received_number'
        $application->due_amount = $request->due_amount;
        $application->due_payment_date = $request->due_payment_date;

        if ($request->due_amount == 0) {
            $application->payment_status = 'paid';
            $application->paid_date = now();
        } else {
            $application->payment_status = 'due';
        }

        $application->save();

        $tutor = Tutor::find($application->tutor_id);

        if ($request->online_payment == 0) {


            // Optional: Check if existing application payment is too new


            // Create new payment
            $payment = new ApplicationPayment();
            $payment->tutor_id = $application->tutor_id;
            $payment->job_offer_id = $application->job_offer_id;
            $payment->application_id = $application->id;
            $payment->received_amount = $request->received_amount;
            $payment->payment_method = $application->payment_method;
            $payment->trx_id = $request->trx_id;
            $payment->render_by = Auth::id();
            $payment->ownership_by = $application->taken_by_id;

            if ($request->refund_coin !== null) {
                $payment->refund_coin = $request->refund_coin;

                if ($tutor) {
                    $tutor->balances -= $request->refund_coin;
                    $tutor->save();
                }
            }

            $payment->save();
        }



        $counting = Counting::where('tutor_id', $application->tutor_id)->first();

        $counting->payment_job = $counting->payment_job + 1;
        $counting->save();

        return response()->json([
            'status' => true,
            'application' => $application
        ]);
    }



    public function seenApplication(Request $request)
    {
        $application= JobApplication::where('id', $request->app_id)->first();
        $application->is_tutor_seen = 1;
        if($application->seen_by == null)
        {
            $application->seen_by = Auth::user()->id;
        }

        $application->update();

        $tutor = Tutor::with([
            'tutor_personal_info',
            'tutor_education',
            'tutor_prefered_locations',
            'tutor_course',
            'tutor_subject',
            'tutor_categories',
            'tutor_days',
            'teaching_method',
            'course_subjects',
            'TutorCertificate',
        ])->where('id',$request->tutor_id)->first();


        $tutor_logs = TutorLog::where('tutor_id',$request->tutor_id)->get();

        $paidSms = JobSms::where('tutor_id',$request->tutor_id)->orderBy('id','DESC')->get();
        $unPaidSms = Sms::where('phone', $tutor->phone)->orderBy('id','DESC')->get();


        $smsTrxHistory = SmsRecharge::where('tutor_id',$request->tutor_id)->orderBy('created_at','DESC')->get();


        $smsBalance = SmsBalance::where('tutor_id',$request->tutor_id)->first();

        return view('backend.tutor.tutor_info',compact('smsBalance','smsTrxHistory','unPaidSms','paidSms','tutor','tutor_logs'));


    }


    public function closedStageChange(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'closed_about' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $stage= JobApplication::where('id', $request->closed_application_id)->firstOrFail();
        $stage->current_stage = $request->stage;
        $stage->closed_about = $request->closed_about;
        $stage->closed_date = Carbon::now();


        $stage->update();

        $stage_update = JobOffer::where('id',$stage->job_offer_id)->first();
        $stage_update->is_active = 0;
        $stage_update->live_off_date = now();
        $stage_update->update();


        $counting = Counting::where('tutor_id', $stage->tutor_id)->first();

        $counting->cancel_job = $counting->cancel_job + 1;
        $counting->save();


      return response()->json(['status'=>true]);
    }


    public function confirmStageChange(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'confirm_about' => 'nullable',
            'tutoring_start_date' => 'nullable',
            'payment_date' => 'nullable',
            // 'confirm_follow_up' => 'required',
            'percentage' => 'required',
            'charge' => 'required',
            'tution_salary' => 'required'

        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        // dd($request->toArray());
        $stage= JobApplication::where('id', $request->confirm_application_id)->firstOrFail();
        $stage->current_stage = $request->stage;
        $stage->confirm_about = $request->confirm_about;
        $stage->job_duration = $request->job_duration;
        $stage->tutoring_start_date = $request->tutoring_start_date;
        $stage->payment_date = $request->payment_date;
        $stage->tuition_salary = $request->tution_salary;
        $stage->percentage = $request->percentage;
        $stage->charge = $request->charge;
        $stage->confirm_follow_up = $request->confirm_follow_up;
        $stage->confirm_date = Carbon::now();

        $stage->update();
        // dd($stage);
        // dd($request->toArray());

        $stage_update = JobOffer::where('id',$stage->job_offer_id)->first();
        $stage_update->is_active = 0;
        $stage_update->live_off_date = now();
        $stage_update->update();


        $counting = Counting::where('tutor_id', $stage->tutor_id)->first();
        $counting->confirm_job = $counting->confirm_job + 1;
        $counting->save();

      return response()->json(['status'=>true]);


    }

    public function repostStageChange(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'repost_about' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $stage= JobApplication::where('id', $request->repost_application_id)->firstOrFail();
        $stage->current_stage = $request->stage;
        $stage->repost_about = $request->repost_about;
        $stage->repost_date = Carbon::now();

        $job = JobOffer::where('id', $stage->job_offer_id)->first();
        if ($job->taken_by_1 == Auth::user()->id) {
            $job->taken_by_1 = null;
            $job->taken_by_1_date = null;
        }
        elseif ($job->taken_by_2 == Auth::user()->id) {
            $job->taken_by_2 = null;
            $job->taken_by_2_date = null;
        }
        $job->is_active = 1;
        $job->update();
        $stage->update();


        $counting = Counting::where('tutor_id', $stage->tutor_id)->first();

        $counting->repost_job = $counting->repost_job + 1;
        $counting->save();



      return response()->json(['status'=>true]);

    }

    public function problemStageChange(Request $request)
    {


        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'panding_to' => 'required',
            'about_problem' => 'required',


        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $stage= JobApplication::where('id', $request->problem_application_id)->firstOrFail();
        $stage->current_stage = $request->stage;
        $stage->panding_to = $request->panding_to;
        $stage->problem_about = $request->problem_about;
        $stage->condition = $request->condition;
        $stage->tag = $request->tag;
        $stage->problem_follow_up = $request->problem_follow_up;
        $stage->problem_date = Carbon::now();

        $stage->update();
        $statusChange = JObOffer::where('id',$stage->job_offer_id)->first();
        $statusChange->is_active = 0;
        $statusChange->live_off_date = now();
        $statusChange->update();


        $counting = Counting::where('tutor_id', $stage->tutor_id)->first();

        $counting->problem_job = $counting->problem_job + 1;
        $counting->save();




      return response()->json(['status'=>true]);

    }

    public function waitingSearch(Request $request)
    {
        $taken_jobs = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('is_taken', 1)
        ->orderBy('id', 'desc')->paginate(20);

        $waiting_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'waiting')
        ->where('job_offer_id', $request->waitingSearch)
        ->orderBy('id', 'desc')->paginate(20);

        $problem_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'problem')
        ->orderBy('id', 'desc')->paginate(20);

        $meeting_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'meet')
        ->orderBy('id', 'desc')->paginate(20);

        $repost_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'repost')
        ->orderBy('id', 'desc')->paginate(20);

        $closed_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'closed')
        ->orderBy('id', 'desc')->paginate(20);

        $confirm_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'confirm')
        ->where('payment_status', null)
        ->orderBy('id', 'desc')->paginate(20);



        $trial_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('current_stage', 'trial')
        ->orderBy('id', 'desc')->paginate(20);



        $due_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('payment_status', 'due')
        ->orwhere('payment_status' , 'Partial_paid')
        ->orderBy('id', 'desc')->paginate(30);

        $payment_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('payment_status', 'paid')
        ->orwhere('payment_status' , 'Partial_paid')
        ->orwhere('payment_status' , 'due')

        ->orderBy('id', 'desc')->paginate(30);

        $refund_applications = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
        ])->where('payment_status','refund')
        ->orderBy('id', 'desc')->paginate(30);



        return view('backend.taken_offer.index',compact('taken_jobs','waiting_applications','payment_applications','due_applications',
        'meeting_applications','trial_applications','problem_applications','repost_applications','closed_applications','confirm_applications','refund_applications '));


    }

    public function assignSearch(Request $request)
    {
        $user_id = Auth::user()->role_id;



        if($user_id == 2)
         {

            $taken_job_search = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('is_taken', 1)
            ->where('job_offer_id', $request->assignSearch)
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);


            return view('backend.taken_offer.index',compact('taken_job_search'));
         }

         elseif(in_array(Auth::user()->role_id, [1, 6]))
         {
            $todayTrial = JobApplication::where('taken_by_id',Auth::user()->id)
            ->whereBetween('trial_date', [Carbon::today(), Carbon::tomorrow()])->count();
            $todayConfirm = JobApplication::where('taken_by_id',Auth::user()->id)
                        ->whereBetween('confirm_date', [Carbon::today(), Carbon::tomorrow()])->count();

            $taken_job_search = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('is_taken', 1)
            ->where('job_offer_id', $request->assignSearch)
            ->orderBy('id', 'desc')->paginate(10);
            return view('backend.taken_offer.index',compact('taken_job_search','todayTrial','todayConfirm'));
         }

    }

    public function manageApplication($id)
    {


        $application = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
            'applicationNote',
            'applicationNote',
        ])->where('id', $id)->first();
        // dd($application->job_offer_id);


        $other_application = JobApplication::with([
            'tutor',
            'tutorEdu',
            'jobOffer',
            'parent' ,
            'applicationNote',
            'applicationNote',
        ])
        ->where('job_offer_id',$application->job_offer_id)
        ->whereNotNull('taken_by_id')
        ->get();





        // dd($other_application->toarray());


        //  dd($application->toArray());

        // $tAduTotalElements = count($application->tutor->tutor_education);

        // return $application->tutor->tutor_education[$tAduTotalElements-1]->institutes->title;

        //  return $application->tutor->tutor_days;

        //  dd($application->jobOffer->toarray());



        return view('backend.taken_offer.manage',compact('application','other_application'));




    }


    public function meetingStageChange(Request $request)
    {
        //  dd($request->toArray());


        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'meeting_date' => 'nullable',
            'meeting_time' => 'nullable',
            // 'waiting_about' => 'required',
            // 'meeting_follow_up_date' => 'required',
            // 'condition' => 'required',
            // 'tag' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        // dd($request->toArray());
        $stage= JobApplication::where('id', $request->application_id)->firstOrFail();
        $stage->current_stage = $request->stage;
        $stage->meeting_date = $request->meeting_date;
        $stage->meeting_time = $request->meeting_time;
        $stage->meeting_about = $request->meeting_about;
        $stage->condition = $request->condition;
        $stage->tag = $request->tag;
        $stage->waiting_follow_up_date = $request->meeting_follow_up_date;

        $stage->update();


        $counting = Counting::where('tutor_id', $stage->tutor_id)->first();

        $counting->meeting_job = $counting->meeting_job + 1;
        $counting->save();



        // dd($stage);
      return response()->json(['status'=>true]);


    }


    public function trialStageChange(Request $request)
    {
        //  dd($request->toArray());


        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'trial_date_1st' => 'nullable',
            // 'trial_date_2nd' => 'nullable',
            'trial_time_1st' => 'nullable',
            // 'trial_time_2nd' => 'required',
            // 'trial_about' => 'required',
            // 'trial_follow_up' => 'required',
            // 'condition' => 'required',
            // 'tag' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        // dd($request->toArray());
        $application= JobApplication::where('id', $request->application_id)->firstOrFail();
        $application->current_stage = $request->stage;
        $application->trial_date_1st = $request->trial_date_1st;
        $application->trial_time_1st = $request->trial_time_1st;
        $application->trial_date_2nd = $request->trial_date_2nd;
        $application->trial_time_2nd = $request->trial_time_2nd;
        $application->trial_about = $request->trial_about;
        $application->condition = $request->condition;
        $application->tag = $request->tag;
        $application->trail_follow_up = $request->trial_follow_up;

        if ($request->trial_date_1st != null) {
            $application->trial_date = Carbon::now();
        }

        $application->update();


        $counting = Counting::where('tutor_id', $application->tutor_id)->first();

        $counting->trial_job = $counting->trial_job + 1;
        $counting->save();



        //  dd($application);



      return response()->json(['status'=>true]);


    }

    public function waitingStageChange(Request $request)
    {

        // dd($request->toArray());

        $validator = Validator::make($request->all(),[
            'stage' => 'required',
            'waiting_date' => 'nullable',
            'waiting_time' => 'nullable',
            // 'waiting_about' => 'required',
            // 'follow_up_date' => 'required',
            // 'condition' => 'required',
            // 'tag' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        // dd($request->toArray());
        $stage= JobApplication::where('id', $request->application_id)->firstOrFail();
        $stage->current_stage = $request->stage;
        $stage->waiting_date = $request->waiting_date;
        $stage->waiting_time = $request->waiting_time;
        $stage->waiting_about = $request->waiting_about;
        $stage->condition = $request->condition;
        $stage->tag = $request->tag;
        $stage->waiting_follow_up_date = $request->waiting_follow_up_date;
        $stage->update();


        //  dd($stage->toarray());


        $counting = Counting::where('tutor_id', $stage->tutor_id)->first();
        $counting->waiting_job = $counting->waiting_job + 1;
        $counting->save();




      return response()->json(['status'=>true]);




    }

    public function getNote(Request $request)
    {


        // return 'tamim';
        $id = $request->id;
        $notes = ApplicationNote::where('job_application_id', $id)->orderBy('id', 'desc')->get();



        return response()->json([
            'status'=>true,
            'message'=>'note added Successfully!',
            'data' =>$notes]);
    }

    public function setNote(Request $request)
    {


        $validator = Validator()->make($request->all(),[
            'application_note' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $note = new ApplicationNote();
        $note->job_application_id = $request->note_application_id;

        $note->body = $request->application_note;
        $note->created_by = Auth::user()->name;
        $note->save();

        return response()->json([
            'status'=>true,
            'message'=>'note added Successfully!',
            'data' =>$note]);


        // dd($request->toArray());




    }

    public function index()
    {
        $user_id = Auth::user()->role_id;

         if($user_id == 2)
         {


            $taken_jobs = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'assign')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);

            $waiting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'waiting')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);

            $problem_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'problem')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);

            $repost_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'repost')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);

            $closed_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'closed')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);

            $confirm_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'confirm')
            ->where('payment_status', null)

            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);


            $meeting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'meet')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);



            $trial_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'trial')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);


            $payment_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('taken_by_id', Auth::id())
            ->where(function($query) {
                $query->where('payment_status', 'paid')
                      ->orWhere('payment_status', 'Partial_paid')
                      ->orWhere('payment_status', 'due');
            })
            ->orderBy('id', 'desc')
            ->paginate(30);

            $due_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where(function($query) {
                $query->where('payment_status', 'due')
                      ->orWhere('payment_status', 'Partial_paid');
            })
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(30);

            $refund_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status','refund')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);


            $todayTrial = JobApplication::where('taken_by_id',Auth::user()->id)
                        ->whereBetween('trial_date', [Carbon::today(), Carbon::tomorrow()])->count();
            $todayConfirm = JobApplication::where('taken_by_id',Auth::user()->id)
                        ->whereBetween('confirm_date', [Carbon::today(), Carbon::tomorrow()])->count();



            return view('backend.taken_offer.index',compact('todayConfirm','todayTrial','taken_jobs','waiting_applications','payment_applications','due_applications',
            'meeting_applications','trial_applications','problem_applications','repost_applications','closed_applications','confirm_applications','refund_applications'));
         }

         elseif(in_array(Auth::user()->role_id, [1, 6]))
         {

            $taken_jobs = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'assign')
            ->orderBy('id', 'desc')->paginate(30);

            $waiting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'waiting')
            ->orderBy('id', 'desc')->paginate(30);

            $problem_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'problem')
            ->orderBy('id', 'desc')->paginate(30);

            $repost_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'repost')
            ->orderBy('id', 'desc')->paginate(30);

            $closed_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'closed')
            ->orderBy('id', 'desc')->paginate(30);

            $confirm_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'confirm')
            ->where('payment_status', null)
            ->orderBy('id', 'desc')->paginate(30);


            $meeting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'meet')
            ->orderBy('id', 'desc')->paginate(30);



            $trial_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'trial')
            ->orderBy('id', 'desc')->paginate(30);

            $due_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status', 'due')
            ->orwhere('payment_status' , 'Partial_paid')
            ->orderBy('id', 'desc')->paginate(30);

            $payment_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status', 'paid')
            ->orwhere('payment_status' , 'Partial_paid')
            ->orwhere('payment_status' , 'due')
            // ->orwhere('payment_status' , 'refund')


            ->orderBy('id', 'desc')->paginate(30);

            $refund_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status','refund')
            ->orderBy('id', 'desc')->paginate(30);


            $todayTrial = JobApplication::whereBetween('trial_date', [Carbon::today(), Carbon::tomorrow()])->count();
            $todayConfirm = JobApplication::whereBetween('confirm_date', [Carbon::today(), Carbon::tomorrow()])->count();





            return view('backend.taken_offer.index',compact('todayConfirm','todayTrial','taken_jobs','waiting_applications','payment_applications','due_applications',
            'meeting_applications','trial_applications','problem_applications','repost_applications','closed_applications','confirm_applications','refund_applications'));
         }

    }




    // Taken Management

    public function assignOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $taken_jobs = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'assign')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.assign_offer',compact('taken_jobs'));
        }else{

            $taken_jobs = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'assign')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.assign_offer',compact('taken_jobs'));


        }



    }
    public function waitingOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $waiting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'waiting')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.waiting_offer',compact('waiting_applications'));
        }else{

            $waiting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'waiting')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.waiting_offer',compact('waiting_applications'));


        }



    }
    public function confirmOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $confirm_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'confirm')
            ->where('payment_status', null)
            ->orderBy('id', 'desc')->paginate(30);

            return view('backend.taken_offer.confirm_offer',compact('confirm_applications'));
        }else{

            $confirm_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'confirm')
            ->where('payment_status', null)

            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(30);

            return view('backend.taken_offer.confirm_offer',compact('confirm_applications'));


        }



    }
    public function mettingOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $meeting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'meet')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.meeting_offer',compact('meeting_applications'));
        }else{

            $meeting_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'meet')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.meeting_offer',compact('meeting_applications'));


        }



    }
    public function trialOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $trial_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'trial')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.trial_offer',compact('trial_applications'));
        }else{

            $trial_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'trial')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.trial_offer',compact('trial_applications'));


        }



    }
    public function repostOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $repost_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'repost')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.repost_offer',compact('repost_applications'));
        }else{

            $repost_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'repost')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.repost_offer',compact('repost_applications'));


        }



    }
    public function paymentOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $payment_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status', 'paid')
            ->orwhere('payment_status' , 'Partial_paid')
            ->orwhere('payment_status' , 'due')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.payment_offer',compact('payment_applications'));
        }else{

            $payment_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('taken_by_id', Auth::id())
            ->where(function($query) {
                $query->where('payment_status', 'paid')
                      ->orWhere('payment_status', 'Partial_paid')
                      ->orWhere('payment_status', 'due');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);


            return view('backend.taken_offer.payment_offer',compact('payment_applications'));


        }



    }
    public function closedOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $closed_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'closed')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.closed_offer',compact('closed_applications'));
        }else{

            $closed_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'closed')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);


            return view('backend.taken_offer.closed_offer',compact('closed_applications'));


        }



    }
    public function dueOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $due_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status', 'due')
            ->orwhere('payment_status' , 'Partial_paid')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.due_offer',compact('due_applications'));
        }else{

            $due_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where(function($query) {
                $query->where('payment_status', 'due')
                      ->orWhere('payment_status', 'Partial_paid');
            })
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);


            return view('backend.taken_offer.due_offer',compact('due_applications'));


        }



    }
    public function refundOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $refund_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status','refund')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.refund_offer',compact('refund_applications'));
        }else{

            $refund_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('payment_status','refund')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);


            return view('backend.taken_offer.refund_offer',compact('refund_applications'));


        }



    }
    public function problemOffer(Request $request)
    {
        $role_id = Auth::user()->role_id;

        if(in_array(Auth::user()->role_id, [1, 6]))
        {
            $problem_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'problem')
            ->orderBy('id', 'desc')->paginate(10);

            return view('backend.taken_offer.problem_offer',compact('problem_applications'));
        }else{

            $problem_applications = JobApplication::with([
                'tutor',
                'tutorEdu',
                'jobOffer',
                'parent' ,
            ])->where('current_stage', 'problem')
            ->where('taken_by_id', Auth::id())
            ->orderBy('id', 'desc')->paginate(10);


            return view('backend.taken_offer.problem_offer',compact('problem_applications'));


        }



    }
}
