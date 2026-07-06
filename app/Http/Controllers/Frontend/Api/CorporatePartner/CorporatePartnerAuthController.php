<?php

namespace App\Http\Controllers\Frontend\Api\CorporatePartner;

use App\Http\Controllers\Controller;
use App\Models\CorporatePartner;
use App\Models\UnverifiedCorporatePartner;
use App\Services\AdnSmsService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
    public function VerifyPhone(Request $request)
    {

        try{

            $validator = Validator()->make($request->all(),[
                'otp' => 'required|numeric',
                'phone' => 'required|numeric',
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

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'             => 'required',
                'phone'            => 'required|regex:/(01)[0-9]{9}/|unique:unverified_corporate_partners,phone|unique:unverified_corporate_partners,phone',
                'email'            => 'required|email|unique:unverified_corporate_partners,email|unique:unverified_corporate_partners,email',
                'gender'           => 'required',
                'password'         => 'required|min:6',
                'confirm_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $registeredCorporatePartner = CorporatePartner::where('phone', $request->phone)->first();

            if ($registeredCorporatePartner) {
                return response()->json(['status' => true, 'message' => 'You Are Already Registered Please Login!']);
            }

            $existingUnverifiedCorporatePartner = UnverifiedCorporatePartner::where('phone', $request->phone)->first();

            if ($existingUnverifiedCorporatePartner) {
                return response()->json(['status' => true, 'message' => 'Corporate Partner Already Exists Please Verify Your Phone!']);
            }

            $unverifiedCorporatePartner = new UnverifiedCorporatePartner();
            $expiry = Carbon::now()->addMinutes(10);

            $unverifiedCorporatePartner->otp          = rand(1234, 9999);
            $unverifiedCorporatePartner->otp_expiry   = $expiry;
            $unverifiedCorporatePartner->name         = $request->name;
            $unverifiedCorporatePartner->phone        = $request->phone;
            $unverifiedCorporatePartner->email        = $request->email;
            $unverifiedCorporatePartner->gender       = $request->gender;
            $unverifiedCorporatePartner->role_id      = 3;
            $unverifiedCorporatePartner->password     = Hash::make($request->password);
            $unverifiedCorporatePartner->save();

                $data = [

                    "id" => $unverifiedCorporatePartner->id,
                    "name" => $unverifiedCorporatePartner->name,
                    "phone" => $unverifiedCorporatePartner->phone,
                    "otp" => $unverifiedCorporatePartner->otp,

                ];

            return response()->json(['status' => true, 'message' => 'Corporate Partner Registration Successful!', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
    public function verifyOtpAndSave(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|exists:unverified_corporate_partners,phone',
                'otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $unverifiedCorporatePartner = UnverifiedCorporatePartner::where('phone', $request->phone)->first();

            if (!$unverifiedCorporatePartner || $unverifiedCorporatePartner->otp !== $request->otp || $unverifiedCorporatePartner->otp_expiry < now()) {
                return response()->json(['status' => false, 'error' => 'Invalid OTP']);
            }

            $corporatePartner = new CorporatePartner();
            $corporatePartner->name               = $unverifiedCorporatePartner->name;
            $corporatePartner->phone              = $unverifiedCorporatePartner->phone;
            $corporatePartner->email              = $unverifiedCorporatePartner->email;
            $corporatePartner->gender             = $unverifiedCorporatePartner->gender;
            $corporatePartner->otp                = $unverifiedCorporatePartner->otp;
            $corporatePartner->otp_expiry         = $unverifiedCorporatePartner->otp_expiry;
            $corporatePartner->role_id            = $unverifiedCorporatePartner->role_id;
            $corporatePartner->password           = $unverifiedCorporatePartner->password;
            $corporatePartner->login_at           = now();
            $corporatePartner->phone_verified_at  = now();
            $corporatePartner->save();
            $corporatePartner->get_corporate_partner_unique_id();



            $token = $this->createCustomToken($corporatePartner, 'corporate_partners');

            $data = [
                "id" => $corporatePartner->id,
                "token" => $token,
            ];

            $unverifiedCorporatePartner->delete();

            return response()->json(['status' => true, 'message' => 'Your corporate partner profile registration has been verified successfully.', 'data' => $data]);


        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }
    }
    public function resendRegisterOtp(Request $request)
    {
        try {
            $phone = $request->phone;
            $unverifiedCorporatePartner = UnverifiedCorporatePartner::where('phone',$phone)->first();

            if ($unverifiedCorporatePartner) {
                $otpRequestLimit = 1;
                $otpRequestTimeFrame = 120;

                $cacheKey = 'otp_request_count_' . $unverifiedCorporatePartner->phone;
                $otpRequestCount = Cache::get($cacheKey, 0);

                if ($otpRequestCount >= $otpRequestLimit) {
                    return $this->resposeError('You can only request one OTP every 2 minutes. Please try again later.', '');
                }


                Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));


                $otpResendLimit = 3;
                $otpResendTimeFrame = 24 * 60;

                if ($unverifiedCorporatePartner->otp_resend_count >= $otpResendLimit && Carbon::now()->diffInMinutes($unverifiedCorporatePartner->last_otp_resend) < $otpResendTimeFrame) {
                    return $this->resposeError('You have reached the maximum OTP resend limit for today. Please try again after 24 hours.Or Contact with Tuition Home Admin Over The Phone', '');
                }


                $unverifiedCorporatePartner->increment('otp_resend_count');
                $unverifiedCorporatePartner->last_otp_resend = now();
                $unverifiedCorporatePartner->save();

                $expiry = Carbon::now()->addMinutes(10);
                $dateTime = new DateTime($expiry);
                $minutes = $dateTime->format('h:i');

                $unverifiedCorporatePartner->otp = rand(1234, 9999);
                $unverifiedCorporatePartner->otp_expiry = $expiry;
                $unverifiedCorporatePartner->save();

                $resend_otp_information = [
                    'corporate_partner_phone' => $unverifiedCorporatePartner->phone,
                    'otp' => $unverifiedCorporatePartner->otp,
                ];

                return $this->resposeSuccess('Otp Resend Successfully', $resend_otp_information);
            } else {
                return $this->resposeError('User Not Found!', '');
            }
        } catch (Exception $e) {
            return $this->resposeError('An error occurred while resending OTP.', '');
        }

    }


    public function checkPhone(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|regex:/(01)[0-9]{9}/',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $phone = $request->phone;

            $corporatePartnerPasswordReset = CorporatePartner::where('phone', $phone)->first();

            if ($corporatePartnerPasswordReset === null) {
                return response()->json(['status' => false, 'message' => 'User Not Found!']);
            } elseif ($corporatePartnerPasswordReset->phone !== $phone) {
                return response()->json(['status' => false, 'message' => 'Invalid phone number for the user!']);
            } else {
                $otpRequestLimit = 1;
                $otpRequestTimeFrame = 120;

                $cacheKey = 'otp_request_count_' . $corporatePartnerPasswordReset->phone;
                $otpRequestCount = Cache::get($cacheKey, 0);

                if ($otpRequestCount >= $otpRequestLimit) {
                    return response()->json(['status' => false, 'message' => 'You can only request one OTP every 2 minutes. Please try again later.']);
                }

                Cache::put($cacheKey, $otpRequestCount + 1, now()->addSeconds($otpRequestTimeFrame));

                $otpResendLimit = 3;
                $otpResendTimeFrame = 24 * 60;

                if ($corporatePartnerPasswordReset->otp_resend_count >= $otpResendLimit && Carbon::now()->diffInMinutes($corporatePartnerPasswordReset->last_otp_resend) < $otpResendTimeFrame) {
                    return $this->resposeError('You have reached the maximum OTP resend limit for today. Please try again after 24 hours. Or contact TuitionHome Admin over the phone', '');
                }

                $phone_otp = rand(1234, 9999);
                $otpExpiry = now()->addMinutes(10);
                $corporatePartnerPasswordReset->otp = $phone_otp;
                $corporatePartnerPasswordReset->otp_expiry = $otpExpiry;

                // $this->sendOtpToUser($request->phone, 'Your password recovery OTP for "TuitionHome" is: ' . $phone_otp, $corporatePartnerPasswordReset->id);

                // Update OTP resend count and timestamp
                $corporatePartnerPasswordReset->otp_resend_count += 1;
                $corporatePartnerPasswordReset->last_otp_resend = now();
                $corporatePartnerPasswordReset->save();

                return response()->json(['status' => true, 'message' => 'OTP sent successfully!', 'phone' => $corporatePartnerPasswordReset->phone,'otp' => $corporatePartnerPasswordReset->otp]);
            }
        } catch (ValidationException $e) {
            return response()->json(['status' => false, 'error' => $e->errors()]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()]);
        }
    }

     public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'corporate_partner_id' => 'required',
                'new_password'         => 'required|min:6',
                'confirm_password'     => 'required|same:new_password',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $current_user = CorporatePartner::find($request->corporate_partner_id);

            if ($current_user) {
                if ($current_user->otp_expiry > $current_user->phone_varified_at ){
                    $current_user->password = Hash::make($request->new_password);
                    $current_user->save();

                    return response()->json(['status' => true, 'message' => 'Password changed successfully!']);

            }
            else{
                return response()->json(['status' => false, 'message' => 'verified phone first!']);
            }
        }

        } catch (Exception $e) {

        }
    }

    public function verifyOtpAndSavePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|exists:corporate_partners,phone',
                'phone_otp'   => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'error' => $validator->errors()]);
            }

            $corporate_partner = CorporatePartner::where('phone',$request->phone)->first();
            if ($corporate_partner) {
                if ($corporate_partner->otp && Carbon::now()->lt($corporate_partner->otp_expiry)) {
                    if ($corporate_partner->otp == $request->phone_otp) {
                        $corporate_partner->phone_verified_at = now();
                        $corporate_partner->save();

                        $data = [
                            'corporate_partner_id' => $corporate_partner->id,
                            'corporate_partner_phone' => $corporate_partner->phone,
                            'otp' => $corporate_partner->otp,
                        ];
                        return response()->json(['status' => true, 'message' => 'Phone verified successfully!', 'data' => $data]);
                    } else {
                        return $this->resposeError('Your OTP is invalid!', '');
                    }
                } else {
                    return $this->resposeError('Your OTP is expired! Resend OTP and try again.', '');
                }
            } else {
                return $this->resposeError('User not found!', '');
            }
            // $corporate_partner_info = [
            //     'corporate_partner_id' => $corporate_partner->id,
            //     'corporate_partner_phone' => $corporate_partner->phone,
            // ];
            // return $this->resposeSuccess('Update your password now', $corporate_partner_info);


        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['status' => false, 'error' => 'Internal Server Error'], 500);
        }

    }



}
