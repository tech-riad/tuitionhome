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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    

    public function createInvoice(Request $request)
    {

            $tutor = Tutor::where('id',Auth::user()->id)->first();

            $package =  PackageAmount::where('id', $request->package_id)->first();

            $cupon = $request->cupon_code;
            $cuponCode = null;
            // dd($cupon);


            $existingInvoices = Invoice::where('tutor_id', Auth::user()->id)
                ->where('package_name', $package->package_name)
                ->where('status', 'pending');

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

            $invoice = DB::transaction(function () use ($existingInvoices, $package, $tutor, $invoice_amount, $cuponCode) {
                $existingInvoices->delete();

                $invoicePrefixes = [
                    'premium' => 'PR',
                    'boost' => 'BS',
                    'sms' => 'SMS',
                    'profile_verify' => 'VR',
                ];
                $invoicePrefix = $invoicePrefixes[$package->type] ?? 'INV';

                do {
                    $invoiceNumber = $invoicePrefix . '-' . Str::upper(Str::random(6));
                } while (Invoice::where('invoice_number', $invoiceNumber)->exists());

                $invoice = new Invoice();
                $invoice->tutor_id = $tutor->id;
                $invoice->invoice_number = $invoiceNumber;
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

                return $invoice;
            });

            return response()->json(['message' => 'Request Sent.','invoice_id' => $invoice->id ]);

    }

}
