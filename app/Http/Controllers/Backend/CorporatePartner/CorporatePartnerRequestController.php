<?php

namespace App\Http\Controllers\Backend\CorporatePartner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CorporatePartnerRequest;

class CorporatePartnerRequestController extends Controller
{
    public function index()
    {
        $requests = CorporatePartnerRequest::with('tutor','tutor_personal_info')->get();
        // dd($requests);
        return view('backend.corporatepartner.index', compact('requests'));
    }
}
