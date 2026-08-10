<?php

namespace App\Http\Controllers\Frontend\Api\CorporateAgent;

use App\Http\Controllers\Controller;
use App\Models\AgentContactInfo;
use App\Models\AgentPersonalInfo;
use App\Transformers\CorporateAgentResource;
use Illuminate\Http\Request;

class CorporateAgentCOntroller extends Controller
{
    //
    public function getCorporateAgent(Request $request)
    {

        $corporateAgent =new CorporateAgentResource(auth()->user());


        return response()->json([
            'status' => true,
            'message' => 'Corporate Agent retrieved successfully',
            'data' => $corporateAgent
        ]);
    }
    public function updatePersonalInfo(Request $request)
    {
        $user = auth()->user();

        AgentPersonalInfo::updateOrCreate(
            [
                'agent_id' => $user->id, // Search condition
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
            'data' => new CorporateAgentResource($user->fresh())
        ]);
    }
    public function updateContactInfo(Request $request)
    {
        $user = auth()->user();

        AgentContactInfo::updateOrCreate(
            [
                'agent_id' => $user->id,
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
            'message' => 'Contact information updated successfully.',
            'data' => new CorporateAgentResource($user->fresh())
        ]);
    }
}
