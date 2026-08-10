<?php

namespace App\Http\Controllers\Frontend\Api\CorporateAgent;

use App\Http\Controllers\Controller;
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
}
