<?php

namespace App\Http\Controllers\Frontend\Api\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Transformers\CorporatePartnerResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorporatePartnerController extends Controller
{
    public function getCorporatePartner(Request $request)
    {
        $corporatePartner = Auth::user();

        $corporatePartner =new CorporatePartnerResource($corporatePartner);

        return response()->json([
            'status' => true,
            'message' => 'Corporate Partner retrieved successfully',
            'data' => $corporatePartner
        ]);
    }


}
