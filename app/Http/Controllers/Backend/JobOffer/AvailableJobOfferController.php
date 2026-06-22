<?php

namespace App\Http\Controllers\Backend\JobOffer;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\SmsLimit;
use App\Models\User;
use Illuminate\Http\Request;

class AvailableJobOfferController extends Controller
{
    public function index(Request $request)
    {
        $paginationLimit = $request->input('pagination_limit', 50);

        $employees = User::where('role_id', 2)->orderBy('id', 'desc')->get();
        $smsLimit = SmsLimit::first();

        $all_jobs = JobOffer::where('is_active', 1)
                            ->orderBy('id', 'DESC')
                            ->with(['parent', 'reference', 'applications','additionalChild'])
                            ->paginate($paginationLimit);

        return view('backend.job_offers.available_offer', compact('all_jobs', 'employees', 'smsLimit', 'paginationLimit'));
    }



}
