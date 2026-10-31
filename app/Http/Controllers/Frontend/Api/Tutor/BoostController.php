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
use Illuminate\Support\Facades\DB;

class BoostController extends Controller
{


    public function createBoostInvoice(Request $request)
    {
        $tutor = Tutor::where('id', Auth::user()->id)->firstOrFail();

        $invoice = DB::transaction(function () use ($request, $tutor) {
            Invoice::where('tutor_id', $tutor->id)
                ->where('status', 'pending')
                ->where('invoice_type', 'boost payment')
                ->delete();

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

            return $invoice;
        });

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
