<?php

namespace App\Http\Controllers\Frontend\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\Invoice;
use App\Models\PackageAmount;
use App\Models\PremiumMembership;
use App\Models\Tutor;
use App\Models\VerificationRequest;
use App\Services\BkashTokenService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    use ApiResponse;

    protected $bkashTokenService;

    public function __construct(BkashTokenService $bkashTokenService)
    {
        $this->bkashTokenService = $bkashTokenService;

        $appKey = config('premium.app_key');
        $appSecret = config('premium.app_secret');
        $baseUrl = config('premium.base_url');
        $username = config('premium.username');
        $password = config('premium.password');
    }

    public function grantToken()
    {

        $token = $this->bkashTokenService->getPremiumToken();
        if ($token) {
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Failed to retrieve token'], 500);
        }

    }

    public function getMembership(Request $request)
    {
        $tutor = Tutor::where('id',Auth::user()->id)->first();
        // dd($tutor);

        $memberships = PremiumMembership::where('tutor_id', $tutor->id)
                 ->where('payment_status', 'paid')
                 ->latest()
                 ->first();

        if(!$memberships){
                return response()->json([
                    $status = [],
                ]);

        }elseif($memberships){
            $status = [];
            $package_name=[];

            if ($memberships->request_status == 'pending') {
                $status = 'pending';
                $package_name = $memberships->package_name;
            }elseif($memberships->request_status == 'accepted'){
                $status = 'accepted';
                $package_name = $memberships->package_name;
            }

            return response()->json([
                'status'                     => $status,
                'package_name'               => $package_name,

            ]);


        }





    }

    public function createPayment(Request $request)
    {

        $appKey = config('premium.app_key');
        $baseUrl = config('premium.base_url');
        $callBackUrl = config('premium.callbackURL');
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

    public function createInvoice(Request $request)
    {

            $tutor = Tutor::where('id',Auth::user()->id)->first();

            $package =  PackageAmount::where('id', $request->package_id)->first();

            $cupon = $request->cupon_code;
            // dd($cupon);


            $existingInvoice = Invoice::where('tutor_id', Auth::user()->id)
                ->where('package_name', $package->package_name)
                ->where('status', 'pending')
                ->first();

            if ($existingInvoice) {
                return response()->json([
                    'message' => 'You already have an unpaid invoice for this type.',
                    'invoice_id' => $existingInvoice->id
                ], 422);
            }

            if ($cupon !== null ) {

                if ($package->cupon != $cupon) {
                    return response()->json([
                        'message' => 'Invalid coupon code.'
                    ], 422);
                }

                $invoice_amount = $package->amount - $package->discount ;
                $cuponCode = $package->cupon;
            } else {
                $invoice_amount = $package->amount;
            }

            if($package->type == 'premium'){
                 $sendMembershipRequest = new PremiumMembership ();

                $sendMembershipRequest->tutor_id        = $tutor->id;
                $sendMembershipRequest->name            = $tutor->name;
                $sendMembershipRequest->request_status  = 'pending';
                $sendMembershipRequest->payment_status  = 'unpaid';
                $sendMembershipRequest->taka            = $invoice_amount;
                $sendMembershipRequest->package_name    = $package->package_name;
                $sendMembershipRequest->channel_name    = 'Website';

                $sendMembershipRequest->save();

            }



            // dd($sendMembershipRequest->id);

            $invoice = new Invoice();
            $invoice->tutor_id = $tutor->id;
            $invoice->invoice_number = 'INV-' . strtoupper(uniqid());
            $invoice->amount = $invoice_amount;
            $invoice->currency = 'BDT';
            $invoice->status = 'pending';
            $invoice->issued_at = Carbon::now();
            $invoice->tutor_name = $tutor->name;
            $invoice->tutor_phone = $tutor->phone;
            $invoice->unique_id = $tutor->unique_id;
            $invoice->payment_date = now()->addDays(7);
            $invoice->cupon = $cuponCode ?? null;
            $invoice->package_id = $package->id;

            $invoice->invoice_type = $package->type;
            $invoice->package_name = $package->package_name;
            $invoice->membership_id = $sendMembershipRequest->id ?? null;
            $invoice->save();
            return response()->json(['message' => 'Request Sent.','invoice_id' => $invoice->id ]);

    }

}
