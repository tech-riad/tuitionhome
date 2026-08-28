<?php

namespace App\Http\Controllers\Backend\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CorporatePartner;
use Illuminate\Http\Request;
use App\Models\CorporatePartnerRequest;
use App\Models\Country;
use App\Models\Location;
use App\Models\PartnerContactInfo;
use Illuminate\Support\Facades\Hash;

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

            $locations   = Location::orderBy('id', 'ASC')->get();
            $cities      = City::orderBy('id', 'ASC')->get();
            $countries   = Country::orderBy('id', 'ASC')->get();


            return view('backend.corporatepartner.profile.index', compact(
                'partners',
                'paginationLimit',
                'totalProfile',
                'activeProfile',
                'inactiveProfile',
                'tutorProfile',
                'maleProfile',
                'femaleProfile',
                'locations',
                'cities',
                'countries'
            ));
        
    }
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'phone' => 'required|string|max:20|unique:corporate_partners,phone',

            'email' => 'nullable|email|max:255',

            'gender' => 'required|in:Male,Female',

            'country_id' => 'required|exists:countries,id',

            'city_id' => 'required|exists:cities,id',

            'location_id' => 'required|exists:locations,id',
            

        ]);


        if (
                CorporatePartner::where('phone', $request->phone)->exists() ||
                CorporatePartner::where('email', $request->email)->exists()
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'This tutor is already a corporate partner.'
                ], 422);
            }

            $corporatePartner = new CorporatePartner();
            $corporatePartner->name              = $request->name;
            $corporatePartner->phone             = $request->phone;
            $corporatePartner->gender             = $request->gender;
            $corporatePartner->email             = $request->email;
            $corporatePartner->otp               = $request->otp;
            $corporatePartner->otp_expiry        = $request->otp_expiry;
            $corporatePartner->role_id           = 3;
            $corporatePartner->password          = Hash::make($request->password);
            $corporatePartner->phone_verified_at = now();
            $corporatePartner->channel_name      = auth()->user()->name ?? 'Admin';
            $corporatePartner->save();

            $corporatePartner->get_corporate_partner_unique_id();

            // $user = auth()->user();
            PartnerContactInfo::updateOrCreate(
                [
                    'partner_id' => $corporatePartner->id, // Search condition
                ],
                [
                    'country_id' => $request->country_id ?? null,
                    'city_id' => $request->city_id ?? null,
                    'location_id' => $request->location_id ?? null,
                ]
            );






        return response()->json([

            'status' => true,

            'message' => 'CP Profile created successfully.',

            'data' => $corporatePartner

        ]);
    }
}
