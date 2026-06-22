<?php

namespace App\Http\Controllers\Frontend\Api\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\CorporatePartner;
use App\Services\AdnSmsService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash as FacadesHash;
use phpseclib3\Crypt\Hash;

class CorporatePartnerAuthController extends Controller
{
    use ApiResponse;
    private $adnSmsService;
    public function __construct( AdnSmsService $adnSmsService)
    {
        $this->adnSmsService = $adnSmsService;
    }
    private function createCustomToken($user, $scope)
    {
        $token = $user->createToken($user->name, [$scope]);

        // Customize the token as needed
        $token->token->expires_at = now()->addDays(7);
        $token->token->save();

        return $token->accessToken;
    }
    public function register(Request $request)
    {
        $validator = Validator()->make($request->all(),[
            'name' => 'required',
            'email' => 'nullable',
            'phone'=> 'required|regex:/(01)[0-9]{9}/|unique:corporate_partners',
            'password' => 'required|min:8',
            'confirm_password' =>'same:password'
        ]);
        if ($validator->fails())
        {
            return response()->json(['status'=>false,'error'=>$validator->errors()]);
        }

        $expiry = Carbon::now()->addMinutes(10);
        $dateTime = new DateTime($expiry);
        $minutes = $dateTime->format('h:i');


        $corporatePartner = new CorporatePartner();
        $corporatePartner->name = $request->name;
        $corporatePartner->phone = $request->phone;
        $corporatePartner->email = $request->email;
        $corporatePartner->gender = $request->gender;
        $corporatePartner->password = FacadesHash::make($request->password);
        $corporatePartner->otp = rand(1234,9999);
        $corporatePartner->otp_expiry=$expiry;
        $corporatePartner->save();

        $corporatePartner->get_corporate_partner_unique_id();


        $data = [

            "id" => $corporatePartner->id,
            "name" => $corporatePartner->name,
            "phone" => $corporatePartner->phone,
            "otp" => $corporatePartner->otp,

        ];

        return response()->json(['status'=>true,'message'=>'Registration Successfully!','data' =>$data]);

    }

}
