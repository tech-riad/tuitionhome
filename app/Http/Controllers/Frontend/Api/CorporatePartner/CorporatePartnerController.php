<?php

namespace App\Http\Controllers\Frontend\Api\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\AgentContactInfo;
use App\Models\PartnerContactInfo;
use App\Models\PartnerPersonalInfo;
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
    public function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();

        PartnerPersonalInfo::updateOrCreate(
            [
                'partner_id' => $user->id, // Search condition
            ],
            [
                'date_of_birth'          => $request->date_of_birth,
                'profession'             => $request->profession,
                'known_from'             => $request->known_from,
                'institute'              => $request->institute,
                'institute_category'     => $request->institute_category,
                'institute_designation'  => $request->institute_designation,
                'work_experience'        => $request->work_experience,
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Personal information saved successfully.',
            'data' => new CorporatePartnerResource($user->fresh())
        ]);
    }
    public function updateContactInfo(Request $request)
    {
        $user = auth()->user();
        PartnerContactInfo::updateOrCreate(
            [
                'partner_id' => $user->id,
            ],
            [
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'location_id' => $request->location_id,
                'address' => $request->address,
                'additional_phone' => $request->additional_phone,
                'whatsapp' => $request->whatsapp,
                'facebook' => $request->facebook,
                'personal_opinion' => $request->personal_opinion,
            ]
        );
        return response()->json([
            'status' => true,
            'message' => 'Contact information saved successfully.',
            'data' => new CorporatePartnerResource($user->fresh())
        ]);

    }


}
