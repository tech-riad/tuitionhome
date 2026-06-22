<?php

namespace App\Http\Controllers;

use App\Models\FnfLead;
use App\Models\Lead;
use App\Models\WebLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebleadController extends Controller
{
    public function webLead(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 20);
        $leads = WebLead::orderBy('id','desc')->paginate($paginationLimit);
        $totalLead = WebLead::count();
        $totalfnfLead = FnfLead::count();
        $parentLeadPending = WebLead::where('status','Pending')->count();
        $parentLeadAccepted = WebLead::where('status','Accepted')->count();
        $parentLeadCancel = WebLead::where('status','Cancel')->count();
        return view('backend.weblead.index',compact('paginationLimit','currentRoute','leads','totalLead','totalfnfLead','parentLeadPending','parentLeadAccepted','parentLeadCancel'));
    }
    public function webLeadSearch(Request $request)
    {

        $currentRoute = \Route::currentRouteName();
        $paginationLimit = $request->get('pagination_limit', 20);

        $leads = WebLead::where('phone',$request->search)->orderBy('id','desc')->paginate($paginationLimit);
        $totalLead = WebLead::count();
        $totalfnfLead = FnfLead::count();
        $parentLeadPending = WebLead::where('status','Pending')->count();
        $parentLeadAccepted = WebLead::where('status','Accepted')->count();
        $parentLeadCancel = WebLead::where('status','Cancel')->count();
        return view('backend.weblead.index',compact('paginationLimit','currentRoute','leads','totalLead','totalfnfLead','parentLeadPending','parentLeadAccepted','parentLeadCancel'));
    }

    public function webLeadJobReject(Request $request, $lead_id)
    {
        $request->validate([
            'cancel_note' => 'required|max:200',
        ]);

        try {
            $lead = WebLead::findOrFail($lead_id);
            $lead->status = 'Cancel';
            $lead->cancel_note = $request->cancel_note;
            $lead->action_by = Auth::user()->id;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Job canceled successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel the job. Please try again later.'
            ], 500);
        }
    }
    public function webLeadJobApprove(Request $request, $lead_id)
    {
        $request->validate([
            'cancel_note' => 'required|max:200',
        ]);

        try {
            $lead = WebLead::findOrFail($lead_id);
            $lead->status = 'Accepted';
            $lead->cancel_note = $request->cancel_note;
            $lead->action_by = Auth::user()->id;
            $lead->save();

            return response()->json([
                'status' => true,
                'message' => 'Job approved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel the job. Please try again later.'
            ], 500);
        }
    }
}
