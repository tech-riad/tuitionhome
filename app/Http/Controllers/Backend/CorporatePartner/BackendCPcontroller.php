<?php

namespace App\Http\Controllers\Backend\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\CorporatePartner;
use Illuminate\Http\Request;
use App\Models\CorporatePartnerRequest;

class BackendCPcontroller extends Controller
{
    public function index(Request $request)
    {
       
            $paginationLimit = (int) $request->get('pagination_limit', 30);

            $allowedLimits = [30, 50, 100, 200, 400, 500];

            if (!in_array($paginationLimit, $allowedLimits)) {
                $paginationLimit = 30;
            }

        

            // Pagination
            $partners = CorporatePartner::with('tutor','contactInfo')
                ->latest()
                ->paginate($paginationLimit)
                ->withQueryString();
                // dd($requests);

            if ($request->ajax()) {
                return response()->json([
                    'html' => view(
                        'backend.corporatepartner.partials.partner_table',
                        compact('partners')
                    )->render(),

                    'pagination' => $partners->links()->render(),
                ]);
            }



            $totalProfile = CorporatePartner::count();

            $activeProfile = CorporatePartner::where('is_active', 1)->count();

            $inactiveProfile = CorporatePartner::where('is_active', 0)->count();

            $tutorProfile = CorporatePartner::count();

            $maleProfile = CorporatePartner::where('gender', 'Male')->count();

            $femaleProfile = CorporatePartner::where('gender', 'Female')->count();

            return view('backend.corporatepartner.profile.index', compact(
                'partners',
                'paginationLimit',
                'totalProfile',
                'activeProfile',
                'inactiveProfile',
                'tutorProfile',
                'maleProfile',
                'femaleProfile'
            ));
        
    }
}
