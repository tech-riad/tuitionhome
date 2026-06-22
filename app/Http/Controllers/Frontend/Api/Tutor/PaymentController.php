<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\DuePayments;
use App\Models\JobApplication;
use App\Models\PremiumMembership;
use App\Models\Tutor;
use App\Models\TutorAccount;
use App\Services\BkashTokenService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    protected $bkashTokenService;

    public function __construct(BkashTokenService $bkashTokenService)
    {
        $this->bkashTokenService = $bkashTokenService;

        $appKey = config('applicationpayment.app_key');
        $appSecret = config('applicationpayment.app_secret');
        $baseUrl = config('applicationpayment.base_url');
        $username = config('applicationpayment.username');
        $password = config('applicationpayment.password');
    }

    public function refundApply(Request $request)
    {
        $tutorId = Auth::user()->id;

        $refundApplications = JobApplication::where('tutor_id', $tutorId)
                            ->where('payment_status', 'refund')
                            ->where(function ($query) {
                                $query->where('refund_status', 0)
                                    ->orWhere(function ($query) {
                                        $query->where('refund_status', 1)
                                                ->whereColumn('refund_amount', '>', 'refund_complete_amount');
                                    });
                            })
                            ->get();

        $jobApplication = JobApplication::where('id', $request->application_id)->first();

        if (!$jobApplication) {
            return response()->json(['error' => 'Job application not found'], 404);
        }

        $adjustment = 0;
        $adjustmentAmount = 0;

        foreach ($refundApplications as $refundApplication) {
            if ($refundApplication->refund_status == 0) {
                if ($jobApplication->charge == $refundApplication->refund_amount) {
                    $adjustment = $refundApplication->id;
                    $adjustmentAmount = 0;
                    break;
                } elseif ($jobApplication->charge <  $refundApplication->refund_amount) {
                    $adjustment        = $refundApplication->id;
                    $adjustmentAmount  = $refundApplication->refund_amount;

                    break;
                }
            }
        }

        if($adjustment != 0 && $adjustmentAmount == 0)
        {
            // JobApplication payment complete
            $jobApplication->payment_method     = 'Refund Adjustment';
            $jobApplication->received_amount    += $refundApplication->refund_amount;
            $jobApplication->payment_status     = 'paid';
            $jobApplication->paid_date          = Carbon::now();
            $jobApplication->update();

            // Application Refund Complete
            $refundCompleteJob = JobApplication::where('id',$refundApplication->id)->first();
            $refundCompleteJob->refund_complete_amount += $refundApplication->refund_amount;
            $refundCompleteJob->refund_complete_note = 'Adjustment From Job ID: ' . $refundApplication->job_offer_id;
            $refundCompleteJob->refund_status = 1;
            $refundCompleteJob->refund_by = Auth::user()->id;
            $refundCompleteJob->refund_complete_date = now()->toDateString();
            $refundCompleteJob->update();

            // Revenue Create complete
            $payment = new ApplicationPayment();
            $payment->tutor_id = $jobApplication->tutor_id;
            $payment->job_offer_id  = $jobApplication->job_offer_id ;
            $payment->application_id   = $jobApplication->id ;
            $payment->refund_coin   = $refundApplication->refund_amount ;
            $payment->payment_method   = 'Refund Adjustment' ;
            $payment->trx_id   = $refundApplication->job_offer_id;
            $payment->render_by   = Auth::user()->id ;
            $payment->ownership_by   = $jobApplication->taken_by_id;
            $payment->save();

            // Due Application Complete
            $dueCompleteJob = DuePayments::where('application_id',$refundApplication->id)->first();
            $dueCompleteJob->trx_id      = $refundApplication->job_offer_id;
            $dueCompleteJob->refund_coin += $refundApplication->refund_amount;
            $dueCompleteJob->paid_date   = now();
            $dueCompleteJob->payment_status = 1;
            $dueCompleteJob->update();

            $tutor = Tutor::where('id',$dueCompleteJob->tutor_id)->first();

            if($tutor->balances != 0)
            {
                $tutor->balances -= $refundApplication->refund_amount;
                $tutor->update();
            }

            return response()->json(['message' => 'Refund Done']);
        }elseif($adjustment != 0 && $adjustmentAmount != 0){
            // JobApplication payment complete
            $jobApplication->payment_method     = 'Refund Adjustment';
            $jobApplication->received_amount    = $jobApplication->charge;
            $jobApplication->payment_status     = 'paid';
            $jobApplication->paid_date          = Carbon::now();
            $jobApplication->update();

            // Application Refund Complete
            $refundCompleteJob = JobApplication::where('id',$refundApplication->id)->first();
            $refundCompleteJob->refund_complete_amount += $jobApplication->charge;
            $refundCompleteJob->refund_complete_note = 'Adjustment For Job ID: ' . $jobApplication->job_offer_id;
            $refundCompleteJob->refund_status = 1;
            $refundCompleteJob->refund_by = Auth::user()->id;
            $refundCompleteJob->refund_complete_date = now()->toDateString();
            $refundCompleteJob->update();

            // Revenue Create complete
            $payment = new ApplicationPayment();
            $payment->tutor_id         = $jobApplication->tutor_id;
            $payment->job_offer_id     = $jobApplication->job_offer_id ;
            $payment->application_id   = $jobApplication->id ;
            $payment->refund_coin      = $jobApplication->received_amount ;
            $payment->payment_method   = 'Refund Adjustment' ;
            $payment->trx_id           = 'Adjustment For Job ID: ' . $refundCompleteJob->job_offer_id;
            $payment->render_by        = Auth::user()->id ;
            $payment->ownership_by     = $jobApplication->taken_by_id;
            $payment->save();

            // Due Application Complete
            $dueCompleteJob = DuePayments::where('application_id',$refundApplication->id)->first();
            $dueCompleteJob->trx_id      = 'Adjustment For Job ID: ' . $refundCompleteJob->job_offer_id;
            $dueCompleteJob->refund_coin += $jobApplication->received_amount;
            $dueCompleteJob->paid_date   = now();
            $dueCompleteJob->payment_status = 1;
            $dueCompleteJob->update();

            $tutor = Tutor::where('id',$dueCompleteJob->tutor_id)->first();

            if($tutor->balances != 0)
            {
                $tutor->balances -= $jobApplication->received_amount;
                $tutor->update();
            }



            return response()->json(['message' => 'Done']);

        }else{
            return response()->json(['message' => 'Contact With Admin']);

        }


    }

    public function paymentPending()
    {
        $tutorId = Auth::user()->id;
        $isconfirm = true;
        $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->when($isconfirm, function ($query) {
                    return $query->whereNotNull('confirm_date');
                })
                ->where('payment_status', null)
                ->with('jobOffer')
                ->get();

            $confirmed_data = [];

            foreach ($tutorApplications as $application) {
                $jobOffer = $application->jobOffer;
                $payment_date_confirm = $application->payment_date;

                $confirmed_data[] = [
                    'apply_date'   => (new DateTime($application->created_at))->format('Y-m-d H:i:s'),
                    'charge'         => $application->charge,
                    'payment_date'   => $payment_date_confirm,
                    'application_id' => $application->id,
                    'job_offer'      => [
                        'job_id'       => $jobOffer->id,
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                    ],
                ];
            }




            return response()->json([
                'paymentPending'  => $confirmed_data,
            ]);
    }

    public function paymentDue()
    {
        $tutorId = Auth::user()->id;
        $paidStatus = true;

            $tutorApplications = JobApplication::where('tutor_id', $tutorId)
                ->when($paidStatus, function ($query) {
                    return $query->where('payment_status', 'due');
                })
                ->with('jobOffer')
                ->get();

            $dueData = [];

            foreach ($tutorApplications as $application) {
                $jobOffer        = $application->jobOffer;
                $dueData[] = [
                    'apply_date'        => (new DateTime($application->created_at))->format('Y-m-d H:i:s'),
                    'due_payment_date'    => (new DateTime($application->due_payment_date))->format('Y-m-d H:i:s'),
                    'due_amount'          => $application->due_amount,
                    'application_id' => $application->id,


                    'job_offer'      => [
                        'job_id'       => $jobOffer->id,
                        'category'     => $jobOffer->category->name,
                        'course'       => $jobOffer->course->name,
                        'location'     => $jobOffer->location->name,
                    ],
                ];
            }


            return response()->json([
                'dueData' => $dueData,
            ]);


    }

    public function tutorBalance()
    {
        $tutor_id = Auth::user()->id;
        $balance = Tutor::where('id',$tutor_id)->first();
        $balanceTable = DuePayments::where('tutor_id', $tutor_id)
                        ->where(DB::raw('payment_amount + refund_coin'), '!=', DB::raw('amount'))
                        ->get();

        $refundAmountTable = [];
        foreach ($balanceTable as $item) {

            $refundAmountTable[] = [
                'jobId' => $item->job_id,
                'refundDate' => $item->jobApplication->refund_date,
                'amount' => $item->amount - ($item->payment_amount + $item->refund_coin),

            ];
        }
        return response()->json([
            'myBalance'       => $balance->balances,
            'refundTable'       => $refundAmountTable,

        ]);

    }



    public function grantToken()
    {

        $token = $this->bkashTokenService->getPaymentToken();
        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Failed to retrieve token'], 500);
        }

    }

    public function createPayment(Request $request)
    {

        $appKey = config('applicationpayment.app_key');
        $baseUrl = config('applicationpayment.base_url');
        $callBackUrl = config('applicationpayment.callbackURL');
        $invoiceAmount = $request->amount;
        $invoiceNumber = $request->invoice_no;
        $payerReference = $request->payerReference ?? '1';
        $mode = '0011';
        $token = $request->token;
        $requestData = [
            'amount' => $invoiceAmount,
            'intent' => 'sale',
            'currency' => 'BDT',
            'merchantInvoiceNumber' => $invoiceNumber,
            'mode' => $mode,
            'payerReference' => $payerReference,
            'callbackURL' => url($callBackUrl)
        ];
        $url = "$baseUrl/v1.2.0-beta/tokenized/checkout/create";
        $requestDataJson = json_encode($requestData);
        $header = [
            'Content-Type: application/json',
            "Authorization: $token",
            "x-app-key: $appKey"
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $requestDataJson);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultData = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $responseData = json_decode($resultData, true);
        if ($httpStatus === 401) {
            return response()->json(['error' => 'Unauthorized'], $httpStatus);
        }


        return response()->json($responseData);

    }


    public function executePayment(Request $request)
    {
        $appKey          = config('applicationpayment.app_key');
        $baseUrl         = config('applicationpayment.base_url');
        $token           = $request->token;
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $paymentID       = $request->paymentID;


        $url             = curl_init("$baseUrl/v1.2.0-beta/tokenized/checkout/execute");
        $header          = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$appKey"
        );
        $request_data_json = json_encode(['paymentID' => $paymentID]);

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);

        $resultdata = curl_exec($url);
        $httpStatus = curl_getinfo($url, CURLINFO_HTTP_CODE);
        curl_close($url);

        if ($httpStatus === 401) {
            return response()->json(['error' => 'Unauthorized'], $httpStatus);
        }

        $response = json_decode($resultdata, true);


        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Error decoding JSON response: ' . json_last_error_msg());
            return response()->json(['error' => 'Error decoding JSON response'], 500);
        }

        if($request->adjustment != null && $request->adjustmentAmount !=null){
            if (isset($response['statusCode']) && $response['statusCode'] == "0000" && isset($response['transactionStatus']) && $response['transactionStatus'] == "Completed") {

                $application= JobApplication::where('id', $request->application_id)->first();
                $application->payment_method     = $request->payment_method ?? "Bkash";
                $application->received_amount    = $response['amount'] + $request->adjustmentAmount;
                $application->received_number    = $request->received_number ?? 5;
                $application->payment_status     = 'paid';
                $application->paid_date = Carbon::now();
                $application->update();

                $adjustment = JobApplication::where('id', $request->adjustment)->first();
                $adjustment->refund_complete_amount += $request->adjustmentAmount;
                $adjustment->refund_complete_note = 'Adjustment From Job ID: ' . $application->job_offer_id;
                $adjustment->refund_status = 1;
                $adjustment->refund_by = $application->tutor_id;
                $adjustment->refund_complete_date = now()->toDateString();
                $adjustment->update();

                $transction = new ApplicationPayment();
                $transction->tutor_id           = $application->tutor_id ?? '1';
                $transction->job_offer_id       = $application->job_offer_id ?? '1';
                $transction->application_id     = $application->application_id ?? '1';
                $transction->received_amount    = $response['amount'];
                $transction->refund_coin        = $request->adjustmentAmount ?? '1';
                $transction->trx_id             = $response['trxID'] . ',' . $adjustment->job_offer_id;
                $transction->payment_phone      = $response['customerMsisdn'];
                $transction->received_number    = $request->received_number ?? 5;
                $transction->payment_method     = $request->payment_method ?? "Bkash";
                $transction->save();


                $dueApplication = DuePayments::where('application_id',$request->adjustment)->first();
                $dueApplication->trx_id = 'Adjustment From Job ID: ' . $application->job_offer_id;
                $dueApplication->refund_coin += $request->adjustmentAmount ;
                $dueApplication->paid_date = now();
                $dueApplication->payment_status = 1;
                $dueApplication->update();

                $tutor = Tutor::where('id',$dueApplication->tutor_id)->first();

                if($tutor->balances != 0)
                {
                    $tutor->balances -= $request->adjustmentAmount;
                    $tutor->update();
                }

            }

        }else{

            if (isset($response['statusCode']) && $response['statusCode'] == "0000" && isset($response['transactionStatus']) && $response['transactionStatus'] == "Completed") {

                $tutor = Tutor::where('id',$request->tutor_id)->first();


                $application= JobApplication::where('id', $request->application_id)->first();
                $application->payment_method     = $request->payment_method ?? "Bkash";
                $application->received_amount    = $response['amount'];
                $application->received_number    = $request->received_number ?? 5;
                $application->payment_status = 'paid';
                $application->paid_date = Carbon::now();
                $application->update();


                $transction = new ApplicationPayment();
                $transction->tutor_id           = $request->tutor_id ?? 1;
                $transction->job_offer_id       = $application->job_offer_id ?? 1;
                $transction->application_id     = $request->application_id ?? 1;
                $transction->received_amount    = $response['amount'];
                $transction->trx_id             = $response['trxID'];
                $transction->payment_phone      = $response['customerMsisdn'];
                $transction->received_number    = $request->received_number ?? 5;
                $transction->payment_method     = $request->payment_method ?? "Bkash";
                $transction->ownership_by       = $application->taken_by_id ?? '';
                $transction->save();
            }


        }



        return response()->json($response);
    }

    public function payment(Request $request)
    {
        $response = $this->executePayment($request);



        return response()->json([
            'response' => $response,
            'user_id' => Auth::user()->id,
        ]);
    }

    public function callBack(Request $request) {
            $response = $this->executePayment($request);

            return $response;
        }

        public function tutorInvoice()
        {
            $invoices = ApplicationPayment::where('tutor_id', Auth::user()->id)
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
        public function refundStatus()
        {
            $refunds = DuePayments::where('tutor_id', Auth::user()->id)
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
                    'paidDate'        => $refund->paid_date,
                ];
            }
            return response()->json($refundData);
        }

        public function paymentTrx()
        {
            $transctions = ApplicationPayment::where('tutor_id', Auth::user()->id)
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
        public function membershipTrx()
        {
            $transctions = ApplicationPayment::where('tutor_id', Auth::user()->id)
                            ->where('service_category', '!=', 'service charge')
                            ->orderBy('id','desc')
                            ->get();
            // $transctions = PremiumMembership::where('tutor_id', Auth::user()->id)
            //                 ->where('payment_status',  'paid')
            //                 ->where('request_status',  'accepted')
            //                 ->get();

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
        public function refundTrx()
        {
            $refunds = DuePayments::where('tutor_id', Auth::user()->id)
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


        public function tutorAccount(Request $request)
        {


            $existingRecord = TutorAccount::where('tutor_id', Auth::user()->id)->first();

            if ($request->provider == 'mobile_banking') {
                if ($existingRecord) {
                    $existingRecord->update([
                        'number' => $request->number,
                        'account_type' => $request->account_type,
                        'account_name' => $request->account_name,
                    ]);
                } else {
                    TutorAccount::create([
                        'tutor_id' => Auth::user()->id,
                        'number' => $request->number,
                        'account_type' => $request->account_type,
                        'account_name' => $request->account_name,
                    ]);
                }
                return response()->json(['message' => 'Successfull.']);

            } elseif ($request->provider == 'bank') {
                if ($existingRecord) {
                    $existingRecord->update([
                        'b_account_number' => $request->b_account_number,
                        'b_account_type' => $request->b_account_type,
                        'b_branch_name' => $request->b_branch_name,
                        'b_account_name' => $request->b_account_name,
                    ]);
                } else {
                    TutorAccount::create([
                        'tutor_id' => Auth::user()->id,
                        'b_account_number' => $request->b_account_number,
                        'b_account_type' => $request->b_account_type,
                        'b_branch_name' => $request->b_branch_name,
                        'b_account_name' => $request->b_account_name,
                    ]);
                }
                return response()->json(['message' => 'Successfull.']);

            }


        }
        public function tutorAccountInfo()
        {
            $tutorAccount = TutorAccount::where('tutor_id', Auth::user()->id)->first();

            return response()->json([
                'accountinfo' => $tutorAccount,
            ]);




        }



}
