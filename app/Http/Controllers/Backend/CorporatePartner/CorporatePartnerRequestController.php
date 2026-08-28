<?php

namespace App\Http\Controllers\Backend\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\CorporatePartner;
use Illuminate\Http\Request;
use App\Models\CorporatePartnerRequest;
use App\Models\Tutor;
use Illuminate\Support\Facades\Hash;

class CorporatePartnerRequestController extends Controller
{
   public function index(Request $request)
    {
        $paginationLimit = (int) $request->get('pagination_limit', 30);

        $allowedLimits = [30, 50, 100, 200, 400, 500];

        if (!in_array($paginationLimit, $allowedLimits)) {
            $paginationLimit = 30;
        }

        $requests = CorporatePartnerRequest::with('tutor', 'tutor_personal_info')
            ->latest()
            ->paginate($paginationLimit)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('backend.corporatepartner.partials.table', compact('requests'))->render(),
                'pagination' => $requests->links()->render(),
            ]);
        }

        return view('backend.corporatepartner.index', compact(
            'requests',
            'paginationLimit'
        ));
    }
    public function apply($id)
    {
        try {
            $request = CorporatePartnerRequest::findOrFail($id);
            $tutor = Tutor::findOrFail($request->tutor_id);

            // Already Corporate Partner check
            if (
                CorporatePartner::where('phone', $tutor->phone)->exists() ||
                CorporatePartner::where('email', $tutor->email)->exists()
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'This tutor is already a corporate partner.'
                ], 422);
            }

            $corporatePartner = new CorporatePartner();
            $corporatePartner->name              = $tutor->name;
            $corporatePartner->phone             = $tutor->phone;
            $corporatePartner->email             = $tutor->email;
            $corporatePartner->otp               = $tutor->otp;
            $corporatePartner->otp_expiry        = $tutor->otp_expiry;
            $corporatePartner->role_id           = $tutor->role_id;
            $corporatePartner->password          = Hash::make('12345678');
            $corporatePartner->phone_verified_at = now();
            $corporatePartner->channel_name      = 'Tutor Request';
            $corporatePartner->save();

            $corporatePartner->get_corporate_partner_unique_id();

            $request->update([
                'status' => 'approved',
                'approved_by' => auth()->user()->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Request approved successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.'
                // 'error' => $e->getMessage(), // development এ চাইলে uncomment করতে পারো
            ], 500);
        }
    }
    public function cancel($id)
    {
        try {

            $request = CorporatePartnerRequest::findOrFail($id);

            if ($request->status == 'rejected') {
                return response()->json([
                    'status' => false,
                    'message' => 'This request is already cancelled.'
                ], 422);
            }

            $request->update([
                'status' => 'rejected',
                'rejected_by' => auth()->user()->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Request cancelled successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
