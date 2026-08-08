<?php

namespace App\Http\Controllers\Frontend\Api\CorporateAgent;

use App\Http\Controllers\Controller;
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
}
