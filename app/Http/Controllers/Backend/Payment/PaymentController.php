<?php

namespace App\Http\Controllers\Backend\Payment;

use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\DuePayments;
use App\Models\JobApplication;
use App\Models\PaymentNote;
use App\Models\SmsBalance;
use App\Models\SmsRecharge;
use App\Models\Tutor;
use App\Models\WebSetting;
use App\Models\User;
use App\Models\JobSms;
use App\Models\PremiumMembership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function paymentAdd(Request $request)
    {
        $addRevenue = new ApplicationPayment();
        $addRevenue->tutor_id = $request->tutor_id;
        $addRevenue->trx_id = $request->trx_id;
        $addRevenue->job_offer_id = $request->job_offer_id;
        $addRevenue->application_id = $request->application_id;
        $addRevenue->received_amount = $request->received_amount;
        $addRevenue->ownership_by = $request->ownership_by;
        $addRevenue->render_by = Auth::user()->id;
        $addRevenue->save();

        $application = JobApplication::where('id',$request->application_id)->first();
        $application->received_amount = $application->received_amount + $request->received_amount;
        $application->update();

        return redirect()->back()->withMessage('Added Successful');


    }
    public function smsRechargeDueFilter(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit',30);
        $searchCriteria = $request->input('sms_due_filter');


        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);

        $query = "SELECT tutor_id FROM sms_recharges WHERE $searchCriteria";

        try {
            $paumentIds = DB::select($query);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $paymentIds = array_column($paumentIds, 'tutor_id');


        $smsrecharges = SmsBalance::whereIn('tutor_id', $paymentIds)
                        ->where('available_sms', '!=', 0)
                        ->orderBy('id','desc')->paginate($paginationLimit);


        $amount = SmsRecharge::whereIn('tutor_id', $paymentIds)->sum('amount');
        $count = SmsRecharge::whereIn('tutor_id', $paymentIds)->count();

        $smsrecharges->appends(['sms_due_filter' => $searchCriteria]);


        $datefrom = null;
        // $smsrecharges = SmsBalance::where('available_sms', '!=', 0)->orderBy('id','desc')->paginate(10);

        $dueTakaPending = SmsBalance::sum('available_sms');

        $todaySmsDelevered = JobSms::whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->count();


        $todayUniqueTutSmsReceived = JobSms::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
                                   ->distinct('tutor_id')
                                   ->count('tutor_id');

        return view('backend.payment.due.smsdue',compact('paginationLimit','currentRoute','count','amount','datefrom','smsrecharges','dueTakaPending','todaySmsDelevered','todayUniqueTutSmsReceived'));

    }
    public function smsRechargeDueSetPoint(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit',30);
        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();

        $smsrecharges = SmsBalance::where('available_sms', '!=', 0)

                        ->orderBy('id','desc')->paginate($paginationLimit);

        $dueTakaPending = SmsRecharge::whereBetween('created_at', [$datefrom, $dateto])
                            ->sum('amount');

        $todaySmsDelevered = JobSms::whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->count();


        $todayUniqueTutSmsReceived = JobSms::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
                                                       ->distinct('tutor_id')
                                                       ->count('tutor_id');


        return view('backend.payment.due.smsdue',compact('paginationLimit','currentRoute','datefrom','smsrecharges','dueTakaPending','todaySmsDelevered','todayUniqueTutSmsReceived'));
    }

    public function smsRechargeDue(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit',30);
        $datefrom = null;
        $smsrecharges = SmsBalance::where('available_sms', '!=', 0)->orderBy('id','desc')->paginate($paginationLimit);

        $dueTakaPending = SmsBalance::sum('available_sms');

        $todaySmsDelevered = JobSms::whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()])->count();


        $todayUniqueTutSmsReceived = JobSms::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
                                   ->distinct('tutor_id')
                                   ->count('tutor_id');
        return view('backend.payment.due.smsdue',compact('paginationLimit','currentRoute','datefrom','smsrecharges','dueTakaPending','todaySmsDelevered','todayUniqueTutSmsReceived'));
    }
    public function duePaymentPaid(Request $request)
    {
        // dd($request->all());
        $application = JobApplication::findOrFail($request->application_id);
        // dd($application->toarray());
        $duePayments = DuePayments::where('application_id',$request->application_id)->first();

        $tutor = Tutor::where('id',$application->tutor_id)->first();

        if($duePayments->refund_coin != $request->refund_coin  ){
            if($tutor->balances != 0)
            {
                $tutor->balances -= $request->refund_coin - $duePayments->refund_coin;
                $tutor->update();
            }

        }
        if($duePayments->payment_amount != $request->payment_amount ){
            if($tutor->balances != 0)
            {
                $tutor->balances -= $request->payment_amount - $duePayments->payment_amount;
                $tutor->update();
            }

        }


        // if($application->refund_coin != $request->refund_coin){
        //     $application->refund_complete_amount +=   $request->refund_coin;
        //     $application->refund_coin =$request->refund_coin;
        // }


        // if($application->refund_payment != $request->payment_amount){
        //     $application->refund_complete_amount += $request->payment_amount;
        //     $application->refund_payment          = $request->payment_amount;

        // }else{

        // }

        $application->refund_payment                  = $request->payment_amount;
        $application->refund_coin                     = $request->refund_coin;
        $application->refund_complete_amount          = $application->refund_coin + $application->refund_payment  ;


        $application->refund_complete_note = $request->refund_complete_note;
        $application->payment_method = $request->payment_method;
        $application->refund_status = 1;
        $application->refund_by = Auth::user()->id;
        $application->refund_complete_date = now()->toDateString();
        $application->update();



        $duePayments = DuePayments::where('application_id',$request->application_id)->first();
        $duePayments->trx_id         = $request->trx_id;
        $duePayments->payment_amount = $request->payment_amount;
        $duePayments->refund_coin    = $request->refund_coin;
        $duePayments->sending_method = $request->payment_method;
        $duePayments->paid_date      = now();
        $duePayments->payment_status = 1;
        $duePayments->refund_complete_note = $request->refund_complete_note;
        $duePayments->update();





        return redirect()->back()->withMessage('Success! Refund Complete.');

    }

    public function todayPayDue(Request $request)
    {
        // dd($request->all());
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);

        $date = now()->toDateString();
        $refundDue = DuePayments::sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;


       $jobIds = JobApplication::whereDate('refund_date', '<=', now())
            ->where('refund_status', '!=', '1')
            ->pluck('job_offer_id');




        // dd($jobIds);


  $duePayments = DuePayments::whereIn('job_id', $jobIds)
                            ->orderBy('id','asc')
                            ->paginate($paginationLimit);


        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();



        return view('backend.payment.due.index',compact('currentRoute','paginationLimit','duePayments','refundDue','smsPaymentDue','employees','admin'));

    }
    public function filterDue(Request $request)
    {


        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        // dd($request->due_filter);
        $searchCriteria = $request->input('due_filter');


        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);


        $query = "SELECT id FROM due_payments WHERE $searchCriteria";

        try {
            $paumentIds = DB::select($query);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $paymentIds = array_column($paumentIds, 'id');




        $duePayments = DuePayments::whereIn('id', $paymentIds)
                        ->orderBy('id','DESC')
                        ->paginate($paginationLimit);

        $filtersum = DuePayments::whereIn('id', $paymentIds)->sum('amount');
        $filtersumcount = DuePayments::whereIn('id', $paymentIds)->count();

        $duePayments->appends(['due_filter' => $searchCriteria]);

        $refundDue = DuePayments::sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();


        return view('backend.payment.due.index',compact('currentRoute','paginationLimit','filtersumcount','filtersum','employees','admin','duePayments','refundDue','smsPaymentDue'));

    }
    public function filterDuePendingDate(Request $request)
    {


        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        $searchCriteria = $request->input('due_filter_pending_date');


        if (!$searchCriteria) {
            $searchCriteria = "1";
        }


        $searchCriteria = str_replace('==', '=', $searchCriteria);


        $query = "SELECT job_offer_id FROM job_applications WHERE $searchCriteria AND refund_status = 0";

        // dd($query);
        try {
            $paumentIds = DB::select($query);

        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $paymentIds = array_column($paumentIds, 'job_offer_id');




        // dd($paymentIds);
        $duePayments = DuePayments::whereIn('job_id', $paymentIds)
                        ->where('payment_status',0)
                        ->orderBy('id','DESC')
                        ->paginate($paginationLimit);


        $filtersum = DuePayments::whereIn('job_id', $paymentIds)->sum('amount');
        $filtersumcount = DuePayments::whereIn('job_id', $paymentIds)->count();

        $duePayments->appends(['due_filter_pending_date' => $searchCriteria]);

        $refundDue = DuePayments::sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();


        return view('backend.payment.due.index',compact('currentRoute','paginationLimit','filtersumcount','filtersum','employees','admin','duePayments','refundDue','smsPaymentDue'));

    }
    public function monthlyDue(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $servicePaymentSumMonthly  = ApplicationPayment::whereYear('created_at', $currentYear)
                                    ->whereMonth('created_at', $currentMonth)
                                    ->sum('received_amount');
        $servicePaymentSumMonthlyCount  = ApplicationPayment::whereYear('created_at', $currentYear)
                                        ->whereMonth('created_at', $currentMonth)
                                        ->count();
        $refundDue = DuePayments::sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;


        $refundDueMonthly = DuePayments::whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $currentMonth)->sum('amount');
        $refundDueMonthlyCount = DuePayments::whereYear('created_at', $currentYear)
                            ->whereMonth('created_at', $currentMonth)->count();

        $duePayments = DuePayments::whereYear('created_at', $currentYear)
                        ->whereMonth('created_at', $currentMonth)
                        ->orderBy('id','DESC')
                        ->paginate(10);

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        return view('backend.payment.due.monthlydue',compact('employees','admin','refundDueMonthlyCount','duePayments','refundDue','smsPaymentDue','refundDueMonthly'));




    }

    public function setPointDue(Request $request)
    {

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();
        $currentRoute = \Route::currentRouteName();

        $paginationLimit = $request->get('pagination_limit', 10);


        $duePayments = DuePayments::whereBetween('created_at', [$datefrom, $dateto])
                        ->orderBy('id','DESC')->paginate($paginationLimit);

        $refundDue = DuePayments::whereBetween('created_at', [$datefrom, $dateto])->where('payment_status',0)->sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();


        return view('backend.payment.due.index',compact('currentRoute','paginationLimit','admin','employees','duePayments','refundDue','smsPaymentDue'));

    }
    public function dueNotedetails($itemId)
    {
        $notes = PaymentNote::where('note_type','due')->where('payment_id', $itemId)->orderBy('id','DESC')->get();

        $html = '';

        foreach ($notes as $note) {
            $html .= '<div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">';
            $html .= '<div class="d-flex justify-content-between align-items-center">';
            $html .= '<div>';
            $html .= '<p class="mb-0 text-dark fs-5">' . $note->user->name . '</p>';
            $html .= '<p class="text-info" style="font-size: 12px">ID-' . $note->user->id . '</p>';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '<p>' . date('M d, Y', strtotime($note->created_at)) . '</p>'; // Format date as per your requirement
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '<p class="" style="font-size: 16px; color: #3b3c3d">Title: ' . $note->note_title . '</p>';
            $html .= '<p>Description: ' . $note->note_details . '</p>';
            $html .= '</div>';
            $html .= '<div class="d-flex justify-content-between align-items-center">';
            $html .= '<div>';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        // Return JSON response with the constructed HTML
        return response()->json([
            'html' => $html
        ]);
    }
    public function dueNote(Request $request)
    {
        $validated = $request->validate([
            'note_title' => 'required|string|max:255',
            'note_details' => 'required|string',
        ]);

        $payment = DuePayments::where('id', $request->item_id)->first();

        if (!$payment) {
            return response()->json(['status' => false, 'message' => 'Payment not found']);
        }

        $note = new PaymentNote();
        $note->payment_id = $request->item_id;
        $note->job_id = $payment->job_id;
        $note->tutor_id = $payment->tutor_id;
        $note->created_by = auth()->user()->id;
        $note->note_title = $request->note_title;
        $note->note_details = $request->note_details;
        $note->note_type = "due";
        $note->save();

        // Log the payment details

        return response()->json(['status' => true, 'message' => 'Note created successfully', 'payment' => $payment]);
    }

    public function verifyPaymentDue(Request $request)
    {
        $itemId = $request->input('id');
        $item = DuePayments::find($itemId);

        if ($item) {
            $item->is_verified = 1;
            $item->verified_by = Auth::user()->id;
            $item->verify_date = now();
            $item->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function setPointSmsRecharge(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit',30);
        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();

        $smsrecharges = SmsRecharge::whereBetween('created_at', [$datefrom, $dateto])->orderBy('id','desc')->paginate($paginationLimit);
        $totalTutorRecharge = SmsRecharge::whereBetween('created_at', [$datefrom, $dateto])->distinct('tutor_id')->count('tutor_id');

        $smsRechargeSum     = SmsRecharge::whereBetween('created_at', [$datefrom, $dateto])->sum('amount');
        $todaySmsRechargeSum     = SmsRecharge::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('amount');

        $totalCount = SmsRecharge::whereBetween('created_at', [$datefrom, $dateto])->count();
        $todayCount = SmsRecharge::all()->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count();

        return view('backend.payment.revenue.smssetpoint',compact('paginationLimit','currentRoute','todayCount','totalCount','todaySmsRechargeSum','smsrecharges','totalTutorRecharge','smsRechargeSum'));

    }
    public function allRevenue(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);

        $payments = ApplicationPayment::orderBy('id','DESC')->paginate($paginationLimit);

        $servicePaymentSum  = ApplicationPayment::where('service_category','service charge')->sum('received_amount');
        $serviceMemberSum  = ApplicationPayment::where('service_category','membership payment')->sum('received_amount');
        $serviceverifySum  = ApplicationPayment::where('service_category','verification payment')->sum('received_amount');
        $serviceboostSum  = ApplicationPayment::where('service_category','profile boost')->sum('received_amount');


        $smsRechargeSum     = SmsRecharge::sum('amount');

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();


        return view('backend.payment.revenue.allrevenue',compact('serviceboostSum','serviceverifySum','serviceMemberSum','paginationLimit','currentRoute','datefrom','payments','servicePaymentSum','smsRechargeSum','employees','admin'));



    }

    public function searchRevenue(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit');

        $tutorUniqueId = $request->search;

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();



        $tutorId = Tutor::where('phone', $tutorUniqueId)->value('id');

        $payments = ApplicationPayment::where('tutor_id', $tutorId)
                                      ->orderBy('id', 'DESC')
                                      ->paginate(10);
        $servicePaymentSumTop  = ApplicationPayment::where('tutor_id', $tutorId)->sum('received_amount');
        $smsRechargeSumCount     = SmsRecharge::where('tutor_id', $tutorId)->sum('amount');

        $smsRechargeSum     = SmsRecharge::sum('amount');
        $servicePaymentSum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','service charge')->sum('received_amount');
        $serviceMemberSum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','membership payment')->sum('received_amount');
        $serviceverifySum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','verification payment')->sum('received_amount');
        $serviceboostSum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','profile boost')->sum('received_amount');


        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        return view('backend.payment.revenue.index',compact('serviceboostSum','serviceverifySum','serviceMemberSum','paginationLimit','currentRoute','smsRechargeSumCount','servicePaymentSumTop','datefrom','payments','servicePaymentSum','smsRechargeSum','employees','admin'));

    }


    public function filterRevenue(Request $request)
    {
        // dd($request->revenue_filter);
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);
        $searchCriteria = $request->input('revenue_filter', '1');


        $searchCriteria = str_replace('==', '=', $searchCriteria);
        // dd($searchCriteria);
        try {

            $paymentIds = DB::table('application_payments')
            ->whereRaw($searchCriteria)
            // ->when($searchCriteria === "render_by='null'", function ($query) {
            //     $query->whereNull('render_by');
            // })
            ->pluck('id');


        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Invalid filter criteria: ' . $e->getMessage()]);
        }

        // Fetch payments
        $payments = ApplicationPayment::whereIn('id', $paymentIds)
            ->orderBy('id', 'DESC')
            ->paginate($paginationLimit);

        // Summarize data
        $filtersum = ApplicationPayment::whereIn('id', $paymentIds)->sum('received_amount');
        $filtersumcount = ApplicationPayment::whereIn('id', $paymentIds)->count();
        $payments->appends(['revenue_filter' => $searchCriteria]);

        // Additional data
        $servicePaymentSum  = ApplicationPayment::where('service_category','service charge')->sum('received_amount');
        $serviceMemberSum  = ApplicationPayment::where('service_category','membership payment')->sum('received_amount');
        $serviceverifySum  = ApplicationPayment::where('service_category','verification payment')->sum('received_amount');
        $serviceboostSum  = ApplicationPayment::where('service_category','profile boost')->sum('received_amount');
        $smsRechargeSum = SmsRecharge::sum('amount');

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date ?? now();
        $dateto = Carbon::now();

        // Employee and admin lists
        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::where('role_id', 1)->orderBy('id', 'desc')->get();

        return view('backend.payment.revenue.index', compact(
            'serviceboostSum',
            'serviceverifySum',
            'serviceMemberSum',
            'currentRoute',
            'paginationLimit',
            'datefrom',
            'filtersumcount',
            'filtersum',
            'payments',
            'servicePaymentSum',
            'smsRechargeSum',
            'employees',
            'admin'
        ));
    }

    public function paymentNote(Request $request)
    {
        $validated = $request->validate([
            'note_title' => 'required|string|max:255',
            'note_details' => 'required|string',
        ]);

        $payment = ApplicationPayment::where('id',$request->item_id)->first();

        $note = new PaymentNote();
        $note->payment_id = $request->item_id;
        $note->job_id = $payment->job_offer_id;
        $note->tutor_id = $payment->tutor_id;
        $note->created_by = auth()->user()->id;
        $note->note_title = $request->note_title;
        $note->note_details = $request->note_details;
        $note->note_type = 'revenue';
        $note->save();

        return response()->json(['status' => true, 'message' => 'Note created successfully']);
    }
    public function getNoteDetails($itemId)
    {
        $notes = PaymentNote::where('note_type','revenue')->where('payment_id', $itemId)->orderBy('id','DESC')->get();

        $html = '';

        foreach ($notes as $note) {
            $html .= '<div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">';
            $html .= '<div class="d-flex justify-content-between align-items-center">';
            $html .= '<div>';
            $html .= '<p class="mb-0 text-dark fs-5">' . $note->user->name . '</p>';
            $html .= '<p class="text-info" style="font-size: 12px">ID-' . $note->user->id . '</p>';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '<p>' . date('M d, Y', strtotime($note->created_at)) . '</p>'; // Format date as per your requirement
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '<p class="" style="font-size: 16px; color: #3b3c3d">Title: ' . $note->note_title . '</p>';
            $html .= '<p>Description: ' . $note->note_details . '</p>';
            $html .= '</div>';
            $html .= '<div class="d-flex justify-content-between align-items-center">';
            $html .= '<div>';
            $html .= '</div>';
            $html .= '<div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        // Return JSON response with the constructed HTML
        return response()->json([
            'html' => $html
        ]);
    }
    public function index(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 10);

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();


        $servicePaymentSum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','service charge')->sum('received_amount');
        $serviceMemberSum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','membership payment')->sum('received_amount');
        $serviceverifySum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','verification payment')->sum('received_amount');
        $serviceboostSum  = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->where('service_category','profile boost')->sum('received_amount');


        $smsRechargeSum     = SmsRecharge::whereBetween('created_at', [$datefrom, $dateto])->sum('amount');


        $payments = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->orderBy('id', 'desc')->paginate($paginationLimit);
        return view('backend.payment.revenue.index',compact('serviceboostSum','serviceverifySum','serviceMemberSum','currentRoute','paginationLimit','datefrom','payments','servicePaymentSum','smsRechargeSum','employees','admin'));

    }
    public function smsRecharge(Request $request)
    {
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit',30);

        $smsrecharges = SmsRecharge::orderBy('id','desc')->paginate($paginationLimit);

        $totalTutorRecharge = SmsRecharge::distinct('tutor_id')->count('tutor_id');

        $smsRechargeSum     = SmsRecharge::sum('amount');
        $todaySmsRechargeSum     = SmsRecharge::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('amount');

        $totalCount = SmsRecharge::all()->count();
        $todayCount = SmsRecharge::all()->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count();

        return view('backend.payment.revenue.smsrecharge',compact('currentRoute','paginationLimit','todayCount','totalCount','todaySmsRechargeSum','smsrecharges','totalTutorRecharge','smsRechargeSum'));

    }
    public function smsRechargeSearch(Request $request)
    {

        $tutorUniqueId = $request->search;
        $tutorId = Tutor::where('phone', $tutorUniqueId)->value('id');
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit',30);
        $smsrecharges = SmsRecharge::where('tutor_id',$tutorId)->orderBy('id','desc')->paginate($paginationLimit);

        $totalTutorRecharge = SmsRecharge::distinct('tutor_id')->count('tutor_id');

        $smsRechargeSum     = SmsRecharge::sum('amount');
        $todaySmsRechargeSum     = SmsRecharge::whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->sum('amount');

        $totalCount = SmsRecharge::all()->count();
        $todayCount = SmsRecharge::all()->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->count();

        return view('backend.payment.revenue.smsrecharge',compact('paginationLimit','currentRoute','todayCount','totalCount','todaySmsRechargeSum','smsrecharges','totalTutorRecharge','smsRechargeSum'));

    }

    public function duePayment(Request $request)
    {
        $currentRoute = \Route::currentRouteName();


        $paginationLimit = $request->get('pagination_limit', 10);


        $refundDue = DuePayments::where('payment_status',0)->sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;


        $duePayments = DuePayments::orderBy('id','DESC')
                            ->paginate($paginationLimit);

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();



        return view('backend.payment.due.index',compact('paginationLimit','currentRoute','duePayments','refundDue','smsPaymentDue','employees','admin'));
    }

    public function searchDue(Request $request)
    {
        $tutorUniqueId = $request->search;
        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 30);





        $tutorId = Tutor::where('phone', $tutorUniqueId)->value('id');
        $refundDue = DuePayments::sum('amount');
        $smsPayment = SmsBalance::where('available_sms', '>', 0)->sum('available_sms');
        $smsPaymentDue = $smsPayment * 0.25;


        $duePayments = DuePayments::where('tutor_id', $tutorId)
                                      ->orderBy('id', 'DESC')
                                      ->paginate($paginationLimit);


        $refundPaymentDues = DuePayments::where('tutor_id', $tutorId)->sum('amount');
        $refundPaymentDuescount = DuePayments::where('tutor_id', $tutorId)->count();

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        return view('backend.payment.due.index',compact('currentRoute','paginationLimit','refundPaymentDuescount','refundPaymentDues','admin','employees','duePayments','refundDue','smsPayment','smsPaymentDue'));

    }
    public function verifyPaymentServiceCharge(Request $request)
    {
        $itemId = $request->input('id');
        $item = ApplicationPayment::find($itemId);

        if ($item) {
            $item->is_verified = 1;
            $item->verified_by = Auth::user()->id;
            $item->verify_date = now();
            $item->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    public function monthlyRevenue()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $servicePaymentSumMonthly  = ApplicationPayment::whereYear('created_at', $currentYear)
                                                ->whereMonth('created_at', $currentMonth)
                                                ->sum('received_amount');
        $servicePaymentSumMonthlyCount  = ApplicationPayment::whereYear('created_at', $currentYear)
                                                ->whereMonth('created_at', $currentMonth)
                                                ->count();

        $monthlyRevenue = ApplicationPayment::whereYear('created_at', $currentYear)
                                            ->whereMonth('created_at', $currentMonth)
                                            ->orderBy('id','DESC')
                                            ->paginate(10);
        $servicePaymentSum  = ApplicationPayment::sum('received_amount');
        $smsRechargeSum     = SmsRecharge::sum('amount');


        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();


        return view('backend.payment.revenue.monthly', compact('datefrom','employees','admin','servicePaymentSumMonthlyCount','monthlyRevenue','smsRechargeSum','servicePaymentSum','servicePaymentSumMonthly'));
    }

    public function employee(Request $request)
    {
        $searchCriteria = $request->input('emp_payment');

        // dd($searchCriteria);

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 30);

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();
        // Summing up the amounts
        $serviceCharge = ApplicationPayment::where('service_category','service charge')->whereBetween('created_at', [$datefrom, $dateto])->sum('received_amount');
        $premiumCharge = ApplicationPayment::where('service_category','membership payment')
                                            ->where('render_by','!=','Payment Gateway')
                                            ->whereBetween('created_at', [$datefrom, $dateto])->sum('received_amount');
        $verifyCharge = ApplicationPayment::whereIn('service_category', ['verification payment'])
                                            ->where('render_by','!=','Payment Gateway')
                                            ->whereBetween('created_at', [$datefrom, $dateto])
                                            ->sum('received_amount');
        $revenue = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])
                                        ->whereNotIn('service_category', ['membership payment', 'verification payment'])
                                        ->orWhere(function ($query) {
                                            $query->where('render_by', 'Payment Gateway');
                                        })
                                        ->whereBetween('created_at', [$datefrom, $dateto])
                                        ->sum('received_amount');

        $refund = DuePayments::whereBetween('created_at', [$datefrom, $dateto])
                                        ->sum('amount');

        // Fetching the data
        $revenueApplications = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])
                                ->with('tutor')->orderBy('created_at', 'desc')->get();
        $refundApplications = DuePayments::whereBetween('created_at', [$datefrom, $dateto])
                                ->orderBy('created_at', 'desc')->get();

        // Merging both collections
        $allApplications = $revenueApplications->map(function ($item) {
            $item->type = 'received';
            $item->amount = $item->received_amount + $item->refund_coin;
            $item->received_amount = $item->received_amount;
            $item->refund_coin = $item->refund_coin;
            $item->name = $item->tutor->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        })->merge($refundApplications->map(function ($item) {
            $item->type = 'refund';
            $item->amount = $item->amount;
            $item->name = $item->tutor->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        }))->sortByDesc('created_at');

        // Pagination
        $perPage = $paginationLimit;
        $page = $request->input('page', 1);
        $total = $allApplications->count();
        $paginatedApplications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allApplications->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();





        return view('backend.payment.employee.index', compact('verifyCharge','serviceCharge','premiumCharge','paginationLimit','currentRoute','searchCriteria','datefrom','admin','employees','revenue', 'refund', 'paginatedApplications'));

    }
    public function employeeSearch(Request $request)
    {
        $tutorUniqueId = $request->search;
        $searchCriteria = $request->input('emp_payment');

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 30);

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();
        // Summing up the amounts

        $tutorId = Tutor::where('phone', $tutorUniqueId)->value('id');

        $serviceCharge = ApplicationPayment::where('service_category','service charge')->whereBetween('created_at', [$datefrom, $dateto])->sum('received_amount');
        $premiumCharge = ApplicationPayment::where('service_category','membership payment')
                                            ->where('render_by','!=','Payment Gateway')
                                            ->whereBetween('created_at', [$datefrom, $dateto])->sum('received_amount');
        $verifyCharge = ApplicationPayment::whereIn('service_category', ['verification payment'])
                                            ->where('render_by','!=','Payment Gateway')
                                            ->whereBetween('created_at', [$datefrom, $dateto])
                                            ->sum('received_amount');
        $revenue = ApplicationPayment::whereBetween('created_at', [$datefrom, $dateto])->sum('received_amount');
        $refund = DuePayments::whereBetween('created_at', [$datefrom, $dateto])->sum('amount');

        // Fetching the data
        $revenueApplications = ApplicationPayment::where('tutor_id',$tutorId)->get();
        $refundApplications = DuePayments::where('tutor_id',$tutorId)->get();

        // Merging both collections
        $allApplications = $revenueApplications->map(function ($item) {
            $item->type = 'received';
            $item->amount = $item->received_amount + $item->refund_coin;
            $item->received_amount = $item->received_amount;
            $item->refund_coin = $item->refund_coin;
            $item->name = $item->tutor->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        })->merge($refundApplications->map(function ($item) {
            $item->type = 'refund';
            $item->amount = $item->amount;
            $item->name = $item->tutor->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        }))->sortByDesc('created_at');

        // Pagination
        $perPage = $paginationLimit;
        $page = $request->input('page', 1);
        $total = $allApplications->count();
        $paginatedApplications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allApplications->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();





        return view('backend.payment.employee.index', compact('verifyCharge','premiumCharge','serviceCharge','paginationLimit','currentRoute','searchCriteria','datefrom','admin','employees','revenue', 'refund', 'paginatedApplications'));

    }

    public function selectedEmployee(Request $request)
    {

        // dd($request->all());

        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 30);
        $revenueApplicationsquery = ApplicationPayment::with('tutor')->orderBy('created_at', 'desc');

        $serviceChargehistory = ApplicationPayment::where('service_category', 'service charge')
            ->whereBetween('created_at', [$datefrom, $dateto])
            ->where('ownership_by', $request->owner_by_name)
            ->selectRaw('SUM(received_amount) as total_received, SUM(refund_coin) as total_refund')
            ->first();

        $totalReceived = $serviceChargehistory->total_received ?? 0;
        $totalRefund = $serviceChargehistory->total_refund ?? 0;

        $serviceCharge = $totalReceived + $totalRefund;


        $premiumCharge = ApplicationPayment::where('service_category','membership payment')
                                            ->where('render_by','!=','Payment Gateway')
                                            ->where('ownership_by',$request->owner_by_name)
                                            ->whereBetween('created_at', [$datefrom, $dateto])->sum('received_amount');
        $verifyCharge = ApplicationPayment::whereIn('service_category', ['verification payment'])
                                            ->where('render_by','!=','Payment Gateway')
                                            ->where('ownership_by',$request->owner_by_name)
                                            ->whereBetween('created_at', [$datefrom, $dateto])
                                            ->sum('received_amount');

        if ($request->has('set_point')) {
            $revenueApplicationsquery->whereBetween('created_at', [$datefrom, $dateto]);
        }

        if ($request->owner_by_name !== null) {
            $revenueApplicationsquery->where('ownership_by', $request->owner_by_name);
        }
        if ($request->owner_by_id !== null) {
            $revenueApplicationsquery->where('ownership_by', $request->owner_by_id);
        }

        $revenueApplications = $revenueApplicationsquery->get();

        // dd($revenueApplications);

        $refundApplicationquery = DuePayments::orderBy('created_at', 'desc');

        if ($request->has('set_point')) {
            $refundApplicationquery->whereBetween('created_at', [$datefrom, $dateto]);
        }

        if ($request->owner_by_name !== null) {
            $refundApplicationquery->where('ownership_by', $request->owner_by_name);
        }
        if ($request->owner_by_id !== null) {
            $refundApplicationquery->where('ownership_by', $request->owner_by_id);
        }

        $refundApplications = $refundApplicationquery->get();

        $revenue = $revenueApplications->sum(function ($application) {
            return $application->received_amount + $application->refund_coin;
        });
        $refund = $refundApplications->sum('amount');

        $allApplications = $revenueApplications->map(function ($item) {
            $item->type = 'received';
            $item->amount = $item->received_amount + $item->refund_coin;
            $item->received_amount = $item->received_amount;
            $item->refund_coin = $item->refund_coin;
            $item->name = $item->tutor->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        })->merge($refundApplications->map(function ($item) {
            $item->type = 'refund';
            $item->amount = $item->amount;
            $item->name = $item->tutor->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        }))->sortByDesc('created_at');

        $perPage = $paginationLimit;
        $page = $request->input('page', 1);
        $total = $allApplications->count();
        $paginatedApplications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allApplications->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        $ownerName = $request->owner_by_name;

        $owner = User::where('id',$ownerName)->pluck('name');

        return view('backend.payment.employee.index', compact('verifyCharge','premiumCharge','currentRoute','paginationLimit','owner','datefrom', 'admin', 'employees', 'revenue', 'refund', 'paginatedApplications','serviceCharge'));
    }


    public function filterEmpPayment(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 30);
        $setpoint = WebSetting::first();
        $datefrom = $setpoint->set_point_date;
        $dateto = Carbon::now();

        // dd($request->all());

        $searchCriteria = $request->input('emp_payment', '1');
        $searchCriteria = str_replace('==', '=', $searchCriteria);

        $revenueApplications = ApplicationPayment::with('tutor')
            ->whereRaw($searchCriteria)
            ->orderBy('created_at', 'desc')
            ->get();

        $refundApplications = DuePayments::whereRaw($searchCriteria)
            ->orderBy('created_at', 'desc')
            ->get();

            $allApplications = $revenueApplications->map(function ($item) {
                $item->type = 'received';
                $item->amount = $item->received_amount + $item->refund_coin;
                $item->received_amount = $item->received_amount;
                $item->refund_coin = $item->refund_coin;
                $item->name = $item->tutor->name ?? '';
                $item->user_type = 'Tutor';
                return $item;
            })->merge($refundApplications->map(function ($item) {
            $item->type = 'refund';
            $item->amount = $item->amount;
            $item->name = $item->name ?? '';
            $item->user_type = 'Tutor';
            return $item;
        }))->sortByDesc('created_at');

        $perPage = $paginationLimit;
        $page = $request->input('page', 1);
        $total = $allApplications->count();
        $paginatedApplications = new \Illuminate\Pagination\LengthAwarePaginator(
            $allApplications->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Summing up amounts
        $revenue = ApplicationPayment::whereRaw($searchCriteria)
                    ->selectRaw('SUM(received_amount + refund_coin) as total_revenue')
                    ->value('total_revenue');
        $refund = DuePayments::whereRaw($searchCriteria)->sum('amount');
        $revenueCount = ApplicationPayment::whereRaw($searchCriteria)->count();
        $refundCount = DuePayments::whereRaw($searchCriteria)->count();

        $allCount = $revenueCount + $refundCount;
        $allAmount = $revenue - $refund;

        $employees = User::orderBy('id', 'desc')->get();
        $admin = User::whereIn('role_id', [1])->orderBy('id', 'desc')->get();

        // Pass data to view
        return view('backend.payment.employee.employeefilter', compact('allAmount','allCount','currentRoute','paginationLimit','searchCriteria', 'datefrom', 'admin', 'employees', 'revenue', 'refund', 'paginatedApplications'));
    }

    public function tutorInvoice($id)
        {
            $invoices = ApplicationPayment::where('tutor_id', $id)
                            ->where('service_category', 'service charge')
                            ->where('in_out', 'received')
                            ->get();

            $invoiceData = [];

            foreach ($invoices as $invoice) {
                $invoiceData[] = [
                    'invoiceNo'       => 'TM0' . $invoice->id,
                    'tutorName'       => $invoice->tutor->name,
                    'tutorEmail'       => $invoice->tutor->email,
                    'serviceCategory' => $invoice->service_category,
                    'jobId'           => $invoice->job_offer_id,
                    'tutorId'         => $invoice->tutor->unique_id,
                    'createdDate'     => optional($invoice->created_at)->toDateString() ?? 'N/A',
                    'amount'          => $invoice->received_amount,
                ];
            }

            return response()->json($invoiceData);
        }
        public function refundStatus($id)
        {
            $refunds = DuePayments::where('tutor_id', $id)
                            ->where('service_category', 'Refund')
                            ->where('in_out', 'out')
                            ->get();

            $refundData = [];

            foreach ($refunds as $refund) {
                $refundData[] = [
                    'invoiceNo'       => 'TM0' . $refund->id,
                    'serviceCategory' => 'Service Charge',
                    'jobId'           => $refund->job_id ?? 'N/A',
                    'tutorId'         => optional($refund->tutor)->unique_id ?? 'N/A',
                    'createdDate'     => optional($refund->created_at)->toDateString() ?? 'N/A',
                    'amount'          => $refund->amount ?? 0,
                    'refundStatus'    => $refund->payment_status ?? 'N/A',
                    'pendingDate'     => optional($refund->job)->refund_date ?? 'N/A',
                    'paidDate'        => optional($refund->paid_date)->toDateString() ?? 'N/A',
                ];
            }
            return response()->json($refundData);
        }

        public function paymentTrx($id)
        {
            $transctions = ApplicationPayment::where('tutor_id', $id)
                            ->where('service_category', 'service charge')
                            ->where('in_out', 'received')
                            ->get();

            $transctionData = [];

            foreach ($transctions as $transction) {
                $transctionData[] = [
                    'jobId'           => $transction->job_offer_id,
                    'paymentMethod'   => $transction->payment_method,
                    'amount'          => $transction->received_amount,
                    'senderNumber'    => $transction->received_number,
                    'trxId'         => $transction->trx_id,
                    'createdDate'     => $transction->created_at->toDateString(),
                ];
            }
            return response()->json($transctionData);

        }
        public function membershipTrx($id)
        {
            $transctions = PremiumMembership::where('tutor_id', $id)
                            ->where('payment_status',  'paid')
                            ->where('request_status',  'accepted')
                            ->get();

            $transctionData = [];

            foreach ($transctions as $transction) {
                $transctionData[] = [
                    'packageName'           => $transction->package_name,
                    'paymentMethod'   => $transction->payment_method,
                    'amount'          => $transction->taka,
                    'senderNumber'    => $transction->received_from,
                    'trxId'         => $transction->transction_id,
                    'createdDate'     => $transction->created_at->toDateString(),
                    'validityDate'     => $transction->tutor->premium_expire,
                ];
            }
            return response()->json($transctionData);

        }
        public function refundTrx($id)
        {
            $refunds = DuePayments::where('tutor_id',$id)
                            ->where('service_category', 'Refund')
                            ->where('in_out', 'out')
                            ->where(DB::raw('payment_amount + refund_coin'), DB::raw('amount'))
                            ->get();

            $refundData = [];

            foreach ($refunds as $refund) {
                $refundData[] = [
                    'jobId'           => $refund->job_id ?? 'N/A',
                    'refundMethod'    => $refund->sending_method,
                    'refundAmount'    => $refund->payment_amount + $refund->refund_coin,
                    'trxId'           => $refund->trx_id ?? '',
                    'paidDate'        => optional($refund->paid_date)->toDateString() ?? 'N/A',
                ];
            }
            return response()->json($refundData);

        }


    public function smsRechargeAdd(Request $request)
    {
        $tutor = Tutor::where('phone', $request->tutor_phone)->first();

        if (!$tutor) {
            return redirect()->back()->with('error', 'Tutor not found.');
        }

        $tutor_id = $tutor->id;

        $tutorSmsRecharge = new SmsRecharge();
        $tutorSmsRecharge->tutor_id = $tutor_id;
        $tutorSmsRecharge->payment_method = "Admin";
        $tutorSmsRecharge->amount = $request->amount;
        $tutorSmsRecharge->recharge_title = 'Sms Recharge';
        $tutorSmsRecharge->render_by = Auth::user()->id;

        $smsQuantity = 0;
        try {
            $costPerSMS = 0.99;
            $smsQuantity = ($request->amount - $request->amount * 1.5 / 100) / $costPerSMS;
            $roundedSmsQuantity = round($smsQuantity);
            if ($smsQuantity - $roundedSmsQuantity < 0.5) {
                $smsQuantity = floor($smsQuantity);
            } else {
                $smsQuantity = ceil($smsQuantity);
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while calculating SMS quantity.');
        }

        $tutorSmsRecharge->sms_quantity = $smsQuantity;
        $tutorSmsRecharge->costing = 0;
        $tutorSmsRecharge->save();

        $smsBalance = SmsBalance::where('tutor_id', $tutor_id)->first();

        if (!$smsBalance) {
            return redirect()->back()->with('error', 'SMS balance record not found.');
        }

        $smsBalance->available_sms += $smsQuantity;
        $smsBalance->update();

        return redirect()->back()->with('success', "SMS Recharge successful! Added {$smsQuantity} SMS.");
    }


}
