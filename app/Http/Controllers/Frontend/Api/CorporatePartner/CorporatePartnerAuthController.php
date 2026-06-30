<?php

namespace App\Http\Controllers\Frontend\Api\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\CorporatePartner;
use App\Services\AdnSmsService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function VerifyPhone(Request $request)
    {

        try{

            $validator = Validator()->make($request->all(),[
                'otp' => 'required|numeric',
            ]);
            if ($validator->fails())
            {
                return response()->json(['status'=>false,'error'=>$validator->errors()]);
            }
            $check_Otp = CorporatePartner::where('phone',$request->phone)->first();
            if ($check_Otp->phone_verified_at)
            {
                return response()->json(['status'=>false,'error'=>'your Phone Number Already Verified! ']);
            }
             if($check_Otp->otp && Carbon::now()->lt($check_Otp->otp_expiry))
                {
                if ($check_Otp->otp == $request->otp)
                {
                    $check_Otp->phone_verified_at =now();
                    $check_Otp->save();

                    // $token = $this->createCustomToken($check_Otp, 'affiliates');


                    return response()->json(['status'=>true,'message'=>'Phone verified successfully!','id'=>$check_Otp->id]);
                }else
                {
                    return response()->json(['status'=>false,'error'=>'your otp is invalid!']);
                }
            }else
            {
                return $this->resposeError('Your Otp is expired! resend again','');
            }



        }catch(Exception $e)
        {
            return $this->resposeError('',$e->getMessage());
        }

    }
    public function login(Request $request)
    {
        try {
            $validator = Validator()->make($request->all(), [
                'phone'    => 'required',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }

            $credentials = [
                'password' => $request->password,
            ];

            if (is_numeric($request->get('phone'))) {
                $credentials['phone'] = $request->phone;
            } elseif (filter_var($request->get('phone'), FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $request->phone;
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid phone number or email format']);
            }

            if (Auth::guard('corporate_partner')->attempt($credentials)) {
                $corporate_partner = Auth::guard('corporate_partner')->user();

                if($corporate_partner->phone_verified_at != null)
                {
                    $token = $this->createCustomToken($corporate_partner, 'corporate_partners');
                    return response()->json(['status' => true, 'message' => 'Login Successfully!', 'token' => $token, 'user' => $corporate_partner]);
                }else
                {
                 return response()->json(['status'=>false,'message'=>'Please verified your phone']);
                }

            } else {
                return response()->json(['status' => false, 'message' => 'Username or password invalid']);
            }
        } catch (Exception $e) {
            return $this->resposeError('', $e->getMessage());
        }

    }

}
