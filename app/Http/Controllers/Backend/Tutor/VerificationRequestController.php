<?php

namespace App\Http\Controllers\Backend\Tutor;

use App\Http\Controllers\Controller;
use App\Models\ApplicationPayment;
use App\Models\Tutor;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationRequestController extends Controller
{
    public function verifyRequestAdd(Request $request)
    {
        $request->validate([
            'phone'      => 'required|regex:/(01)[0-9]{9}/',


        ]);
        $tutor = Tutor::where('phone',$request->phone)->first();
        if (!$tutor) {
            return response()->json(['status' => 'error', 'message' => 'Tutor not found'], 404);
        }

        $verification = new VerificationRequest();
        $verification->tutor_id = $tutor->id;
        $verification->name = $tutor->name;
        $verification->action_by = Auth::user()->id;
        $verification->action_at = now();
        $verification->channel_name = 'Admin';
        $verification->request_status = 'pending';
        $verification->save();

        return redirect()->back()->withMessage('Request Added Succesfully!');


    }
    public function index(Request $request)
    {
        $paginationLimit = $request->input('pagination_limit', 50);

        $requests = VerificationRequest::orderBy('id', 'desc')->paginate($paginationLimit);
        $employees = User::where('role_id',4)->get();


        return view('backend.verifyrequest.index', compact('requests','employees','paginationLimit'));


    }
    public function verifyRequestSearch(Request $request)
    {
        $search = $request->input('search');
        $paginationLimit = $request->input('pagination_limit', 50);

        $requests = VerificationRequest::where(function($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('taka', 'like', '%' . $search . '%')
                ->orWhere('tutor_id', 'like', '%' . $search . '%')
                ->orWhere('transction_id', 'like', '%' . $search . '%')
                ->orWhere('payment_status', 'like', '%' . $search . '%')
                ->orWhere('action_by', 'like', '%' . $search . '%')
                ->orWhere('request_status', 'like', '%' . $search . '%')
                ->orWhere('decline_note', 'like', '%' . $search . '%');
        })->paginate($paginationLimit);
        $employees = User::where('role_id',4)->get();
        return view('backend.verifyrequest.index', compact('requests','employees','paginationLimit'));


    }

    public function grantApplication(Request $request)
    {
        // dd($request->all());
        $verify = VerificationRequest::where('id',$request->grant_id)->first();
        $tutor = Tutor::where('id',$verify->tutor_id)->first();
        $tutor->is_verified = 1;
        $tutor->verify_date = now();
        $tutor->verified_by = Auth::user()->id;
        $tutor->update();

        if($verify->payment_status == 'paid')
        {
            $verify->channel_name = 'Website';
        }else{
            $verify->channel_name = 'Admin';
        }
        $verify->action_by        = auth::user()->id;
        $verify->payment_status   = 'paid';
        $verify->request_status   = 'accepted';
        $verify->action_at        = now();
        $verify->update();


        if($request->online_payment == 0)
        {

            $transction = new ApplicationPayment();
            $transction->tutor_id            = $tutor->id ;
            $transction->received_amount     = $request->taka;
            $transction->trx_id              = $request->transction_id;
            $transction->ownership_by        = Auth::user()->id;
            $transction->render_by           = Auth::user()->id;
            $transction->service_category    = "verification payment";
            $transction->save();

        }




        return redirect()->back()->withMessage('Successfully Granted Application!');


    }
    public function declineApplication(Request $request)
    {
        $verify = VerificationRequest::where('id',$request->decline_id)->first();

        $verify->action_by        = auth::user()->id;
        $verify->decline_note     = $request->decline_note;
        $verify->request_status   = 'rejected';
        $verify->action_at        = now();
        $verify->update();
        return redirect()->back()->withMessage('Declined Application!');

    }
    public function waitingVerifyApplication(Request $request)
    {
        $memberships = VerificationRequest::where('id',$request->waiting_id)->first();

        $memberships->action_by        = auth::user()->id;
        $memberships->waiting_note     = $request->waiting_note;
        $memberships->expected_waiting_date     = $request->expected_waiting_date;
        $memberships->request_status   = 'waiting';
        $memberships->waiting_note_update_date  = now();
        $memberships->action_at        = now();
        $memberships->update();
        return redirect()->back()->withMessage('waiting Application!');

    }

    public function verifyRequestNote(Request $request)
    {
        $memberships = VerificationRequest::where('id', $request->application_id)->first();
        $memberships->action_by = auth()->user()->id;
        $memberships->note = $request->note;
        $memberships->action_at = now();
        $memberships->update();

        return redirect()->back()->with('success', 'Note Update!');
    }

    public function filterVerifyApplication(Request $request)
    {

        $query = VerificationRequest::query();

        if ($request->filled('datef')) {
            $query->whereDate('created_at', '>=', $request->input('datef'));
        }

        if ($request->filled('datet')) {
            $query->whereDate('created_at', '<=', $request->input('datet'));
        }

        if ($request->filled('user_id')) {
            $query->where('action_by', $request->input('user_id'));
        }
        if ($request->filled('status')) {
            $query->where('request_status', $request->input('status'));
        }
        if ($request->filled('channel_name')) {
            $query->where('channel_name', $request->input('channel_name'));
        }

        $paginationLimit = $request->input('pagination_limit', 50);
        $requests = $query->paginate($paginationLimit);
        $employees = User::where('role_id',4)->get();

        return view('backend.verifyrequest.index', compact('requests', 'paginationLimit', 'employees'));
    }



}
