<?php

namespace App\Http\Controllers\Backend\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\CorporatePartner;
use Illuminate\Http\Request;

class BackendCPPartnerProfileController extends Controller
{
    public function index($id)
    {
        $partner = CorporatePartner::with('tutor','contactInfo')->findOrFail($id);
        return view('backend.corporatepartner.profile.show', compact('partner'));
    }
}
