<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\Invoice;
use App\Models\PremiumMembership;
use App\Models\Tutor;
use App\Services\BkashTokenService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoostController extends Controller
{
    use ApiResponse;

    protected $bkashTokenService;

    public function __construct(BkashTokenService $bkashTokenService)
    {
        $this->bkashTokenService = $bkashTokenService;

        $appKey = config('boost.app_key');
        $appSecret = config('boost.app_secret');
        $baseUrl = config('boost.base_url');
        $username = config('boost.username');
        $password = config('boost.password');
    }

    public function grantToken()
    {

        $token = $this->bkashTokenService->getBoostToken();
        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Failed to retrieve token'], 500);
        }

    }

    public function createPayment(Request $request)
    {

        $appKey = config('boost.app_key');
        $baseUrl = config('boost.base_url');
        $callBackUrl = config('boost.callbackURL');
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
        $appKey          = config('boost.app_key');
        $baseUrl         = config('boost.base_url');
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

        if (isset($response['statusCode']) && $response['statusCode'] == "0000" && isset($response['transactionStatus']) && $response['transactionStatus'] == "Completed") {

            $tutor = Tutor::where('id',$request->tutor_id)->first();

            if($request->package_duration == '1')
            {
                $tutor->is_boost    = 1;
                $tutor->boost_date  = today();
                $tutor->boost_package  = $request->package_duration;
                $tutor->boost_expire = now()->addMonths(1);
                $tutor->update();



                return response()->json(['message' => 'Request Sent.']);
            }elseif($request->package_duration == '3'){
                $tutor->is_boost    = 1;
                $tutor->boost_date  = today();
                $tutor->boost_package  = $request->package_duration;
                $tutor->boost_expire = now()->addMonths(3);
                $tutor->update();


            }elseif($request->package_duration == '6'){
                $tutor->is_boost    = 1;
                $tutor->boost_date  = today();
                $tutor->boost_package  = $request->package_duration;
                $tutor->boost_expire = now()->addMonths(6);
                $tutor->update();


            }elseif($request->package_duration == '12'){
                $tutor->is_boost    = 1;
                $tutor->boost_date  = today();
                $tutor->boost_package  = $request->package_duration;
                $tutor->boost_expire = now()->addMonths(12);
                $tutor->update();


            }






        }


        return response()->json($response);
    }


    public function createBoostInvoice(Request $request)
    {
        $tutor = Tutor::where('id',Auth::user()->id)->first();

        $unpaidInvoice = Invoice::where('tutor_id', $tutor->id)
            ->where('status', 'pending')
            ->where('invoice_type', 'boost payment')
            ->first();
        if ($unpaidInvoice) {
            return response()->json(['error' => 'You have an unpaid invoice. Please pay it before creating a new one.'], 400);
        }




        if($tutor){
            $invoice = new Invoice();
            $invoice->tutor_id = $tutor->id;
            $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
            $invoice->amount = $request->amount;
            $invoice->currency = 'BDT';
            $invoice->status = 'pending';
            $invoice->issued_at = now();
            $invoice->tutor_name = $tutor->name;
            $invoice->tutor_phone = $tutor->phone;
            $invoice->unique_id = $tutor->unique_id;
            $invoice->payment_date = now()->addDays(7);
            $invoice->invoice_type = "boost payment";
            $invoice->package_duration = $request->package_duration;
            $invoice->save();
        }

        return response()->json(['message' => 'Invoice Created.','invoice_id' => $invoice->id ]);
    }

    public function getBoostStatus()
    {
        $tutor = Tutor::where('id',Auth::user()->id)->first();

        if($tutor){
            $status = $tutor->is_boost;
            $package_name = $tutor->boost_package;
        }

        return response()->json([
            'status'                     => $status,
            'package_name'               => $package_name,

        ]);

    }


}
