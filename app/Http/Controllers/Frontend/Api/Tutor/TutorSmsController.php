<?php

namespace App\Http\Controllers\frontend\api\tutor;

use App\Http\Controllers\Controller;
use App\Models\AdvanceSearchSms;
use App\Models\JobSms;
use App\Models\Sms;
use App\Models\SmsBalance;
use App\Models\SmsRecharge;
use App\Models\Tutor;
use App\Services\BkashTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorSmsController extends Controller
{


    protected $bkashTokenService;

    public function __construct(BkashTokenService $bkashTokenService)
    {
        $this->bkashTokenService = $bkashTokenService;

        $appKey = config('bkash.app_key');
        $appSecret = config('bkash.app_secret');
        $baseUrl = config('bkash.base_url');
        $username = config('bkash.username');
        $password = config('bkash.password');
    }

    public function smsAlert(Request $request)
    {
        $tutor = Tutor::where('id',Auth::user()->id)->first();


        if ($request->is_sms == 0)
        {
            $tutor->is_sms = 0;
            $tutor->update();
            return response()->json(['status' => true, 'message' => 'Sms alert deactive successfull!']);
        }elseif($request->is_sms == 1)
        {
            $tutor->is_sms = 1;
            $tutor->update();
            return response()->json(['status' => true, 'message' => 'Sms alert active successfull!']);

        }




    }
    public function smsLog()
    {
        $phone = Auth::user()->phone;

        $sms = Sms::where('phone', $phone)->get();
        $advanceSearchSms = AdvanceSearchSms::where('phone', $phone)->get();
        $paidsms = JobSms::where('tutor_phone', $phone)->get();

        // Format sms
        $formattedSms = $sms->map(function ($item) {
            return [
                'id' => $item->id,
                'send_by' => $item->user->name, // Assuming send_by is a foreign key referencing the name of the sender
                'job_id' => $item->job_id,
                'user_id' => $item->user_id,
                'phone' => $item->phone,
                'body' => $item->body,
                'sent' => $item->sent,
                'status' => 'unpaid',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        // Format advance search sms
        $formattedAdvanceSearchSms = $advanceSearchSms->map(function ($item) {
            return [
                'id' => $item->id,
                'send_by' => $item->user->name, // Assuming send_by is a foreign key referencing the name of the sender
                'is_send' => $item->is_send,
                'body' => $item->body,
                'phone' => $item->phone,
                'status' => 'unpaid',
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        // Format paidsms
        $formattedPaidSms = $paidsms->map(function ($item) {
            return [
                'id' => $item->id,
                'job_id' => $item->job_id,
                'sender_name' => $item->sender_name,
                'sender_id' => $item->sender_id,
                'sms_title' => $item->sms_title,
                'sms_body' => $item->sms_body,
                'tutor_id' => $item->tutor_id,
                'tutor_phone' => $item->tutor_phone,
                'sms_method' => $item->sms_method,
                'is_sent' => $item->is_sent,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json([
            'sms' => $formattedSms,
            'adsms' => $formattedAdvanceSearchSms,
            'paidsms' => $formattedPaidSms,
        ]);
    }


    public function smsLogFilter(Request $request)
    {
        $phone = Auth::user()->phone;
        $searchQuery = $request->input('search');

        $losSms = Sms::selectRaw('CAST(`sms`.`id` AS CHAR CHARACTER SET utf8) AS id,
                                    CAST(`sms`.`send_by` AS CHAR CHARACTER SET utf8) AS send_by,
                                    CAST(`sms`.`phone` AS CHAR CHARACTER SET utf8) AS phone,
                                    CAST(`sms`.`body` AS CHAR CHARACTER SET utf8) AS body,
                                    `users`.`name` AS send_by_name')
                ->join('users', 'sms.send_by', '=', 'users.id')
                ->where('sms.phone', $phone)
                ->when($searchQuery, function ($query) use ($searchQuery) {
                    $query->where('sms.body', 'like', '%'.$searchQuery.'%');
                });

        $logSms = AdvanceSearchSms::selectRaw('CAST(`advance_search_sms`.`id` AS CHAR CHARACTER SET utf8) AS id,
                                            CAST(`advance_search_sms`.`send_by` AS CHAR CHARACTER SET utf8) AS send_by,
                                            CAST(`advance_search_sms`.`phone` AS CHAR CHARACTER SET utf8) AS phone,
                                            CAST(`advance_search_sms`.`body` AS CHAR CHARACTER SET utf8) AS body,
                                            `users`.`name` AS send_by_name')
                            ->join('users', 'advance_search_sms.send_by', '=', 'users.id')
                            ->where('advance_search_sms.phone', $phone)
                            ->when($searchQuery, function ($query) use ($searchQuery) {
                                $query->where('advance_search_sms.body', 'like', '%'.$searchQuery.'%');
                            });

        $combinedSms = $losSms->union($logSms)->paginate(5);

        return $combinedSms;
    }



    public function index()
    {
        $id = Auth::user()->id;
        $tutorSmsbalance = SmsBalance::where('tutor_id',$id)->first();

        if($tutorSmsbalance == null)
        {
            $tutorSmsbalance = new SmsBalance();
            $tutorSmsbalance->tutor_id           = Auth::user()->id;
            $tutorSmsbalance->unpaid_sms         = $tutorSmsbalance->unpaid_sms ?? 0;
            $tutorSmsbalance->paid_sms           = $tutorSmsbalance->paid_sms ?? 0;
            $tutorSmsbalance->total_sms_received = $tutorSmsbalance->unpaid_sms + $tutorSmsbalance->paid_sms;
            $tutorSmsbalance->available_sms      = $tutorSmsbalance->available_sms ?? 0;
            $tutorSmsbalance->save();

        }
        $smsBalance = [
            'available_sms'       =>$tutorSmsbalance->available_sms,
            'paid_sms'            =>$tutorSmsbalance->paid_sms,
            'unpaid_sms'          =>$tutorSmsbalance->unpaid_sms,
            'total_sms_received'  =>$tutorSmsbalance->unpaid_sms + $tutorSmsbalance->paid_sms,

        ];
        return response()->json([
            'smsBalance'       => $smsBalance,

        ]);


    }

    public function smsRecharge(Request $request)
    {
        $response = $this->executePayment($request);

        return response()->json([
            'response' => $response,
            'user_id' => Auth::user()->id,
        ]);

    }

    public function grantToken()
    {

        $token = $this->bkashTokenService->getToken();
        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Failed to retrieve token'], 500);
        }

    }

    public function createPayment(Request $request)
    {
        $appKey = config('bkash.app_key');
        $baseUrl = config('bkash.base_url');
        $callBackUrl = config('bkash.callbackURL');
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

        // dd($responseData['callbackURL']);

        return response()->json($responseData);
        // return redirect()->to($responseData['callbackURL']);

    }


    public function executePayment(Request $request)
    {
        $appKey          = config('bkash.app_key');
        $baseUrl         = config('bkash.base_url');
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
            Log::error('Error decoding JSON response: ' . json_last_error_msg());
            return response()->json(['error' => 'Error decoding JSON response'], 500);
        }

        // dd($response);

        if (isset($response['statusCode']) && $response['statusCode'] == "0000" && isset($response['transactionStatus']) && $response['transactionStatus'] == "Completed") {
                $tutorSmsRecharge = new SmsRecharge();
                $tutorSmsRecharge->tutor_id = $request->tutor_id;
                $tutorSmsRecharge->payment_method = 'bkash';
                $tutorSmsRecharge->amount = $response['amount'];
                $tutorSmsRecharge->invoice_no  = $response['trxID'];
                $tutorSmsRecharge->recharge_title = 'Sms Recharge';
                $smsQuantity = 0;
                try {
                    $costPerSMS = 0.99;
                    $smsQuantity = ($response['amount'] - $response['amount'] * 1.5 / 100) / $costPerSMS;
                    $roundedSmsQuantity = round($smsQuantity);
                    if ($smsQuantity - $roundedSmsQuantity < 0.5) {
                        $smsQuantity = floor($smsQuantity);
                    } else {
                        $smsQuantity = ceil($smsQuantity);
                    }
                } catch (Exception $e) {
                    // Log::error('Error calculating SMS quantity: ' . $e->getMessage());
                }

                $tutorSmsRecharge->sms_quantity = $smsQuantity;
                $tutorSmsRecharge->costing = 0;
                $tutorSmsRecharge->save();

                 $smsBalance = SmsBalance::where('tutor_id',$request->tutor_id)->first();
                $smsBalance->available_sms = $smsBalance->available_sms + $smsQuantity;
                $smsBalance->update();

        }

        return response()->json($response);
    }


    public function callBack(Request $request) {
            $response = $this->executePayment($request);

            return $response;
        }

        public function transctionHistory(Request $request)
        {

            $transactionHistory = SmsRecharge::where('tutor_id',Auth::user()->id)
                                    ->paginate();

                                 return response()->json([
                                        'transactionHistory'       => $transactionHistory,
                                    ]);
        }



}
